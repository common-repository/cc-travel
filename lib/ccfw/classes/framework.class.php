<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access pages directly.

/**
 *
 * Framework Class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CCFramework extends CCFramework_Abstract {

	/**
	 *
	 * option database/data name
	 * @access public
	 * @var string
	 *
	 */
	public $unique = CC_OPTION;

	/**
	 *
	 * settings
	 * @access public
	 * @var array
	 *
	 */
	public $settings = array();

	/**
	 *
	 * options tab
	 * @access public
	 * @var array
	 *
	 */
	public $options = array();

	/**
	 *
	 * options section
	 * @access public
	 * @var array
	 *
	 */
	public $sections = array();

	/**
	 *
	 * options store
	 * @access public
	 * @var array
	 *
	 */
	public $get_option = array();

	/**
	 *
	 * instance
	 * @access private
	 * @var class
	 *
	 */
	private static $instance = null;

	// run framework construct
	public function __construct($settings, $options) {

		$this->settings = apply_filters('cc_framework_settings', $settings);
		$this->options = apply_filters('cc_framework_options', $options);

		if (!empty($this->options)) {

			$this->sections = $this->get_sections();
			$this->get_option = get_option(CC_OPTION);
			$this->addAction('admin_init', 'settings_api');
			$this->addAction('admin_menu', 'admin_menu');

		}

	}

	// instance
	public static function instance($settings = array(), $options = array()) {
		if (is_null(self::$instance)) {
			self::$instance = new self($settings, $options);
		}
		return self::$instance;
	}

	// get sections
	public function get_sections() {

		$sections = array();

		foreach ($this->options as $key => $value) {

			if (isset($value['sections'])) {

				foreach ($value['sections'] as $section) {

					if (isset($section['fields'])) {
						$sections[] = $section;
					}

				}

			} else {

				if (isset($value['fields'])) {
					$sections[] = $value;
				}

			}

		}

		return $sections;

	}

	// wp settings api
	public function settings_api() {

		$defaults = array();

		foreach ($this->sections as $section) {

			register_setting($this->unique . '_group', $this->unique, array(&$this, 'validate_save'));

			if (isset($section['fields'])) {

				add_settings_section($section['name'] . '_section', $section['title'], '', $section['name'] . '_section_group');

				foreach ($section['fields'] as $field_key => $field) {

					add_settings_field($field_key . '_field', '', array(&$this, 'field_callback'), $section['name'] . '_section_group', $section['name'] . '_section', $field);

					// set default option if isset
					if (isset($field['default'])) {
						$defaults[$field['id']] = $field['default'];
						if (!empty($this->get_option) && !isset($this->get_option[$field['id']])) {
							$this->get_option[$field['id']] = $field['default'];
						}
					}

				}
			}

		}

		// set default variable if empty options and not empty defaults
		if (empty($this->get_option) && !empty($defaults)) {
			update_option($this->unique, $defaults);
			$this->get_option = $defaults;
		}

	}

	// section fields validate in save
	public function validate_save($request) {

		$add_errors = array();
		$section_id = cc_get_var('cc_section_id');

		// ignore nonce requests
		if (isset($request['_nonce'])) {
			unset($request['_nonce']);
		}

		// import
		if (isset($request['import']) && !empty($request['import'])) {
			$decode_string = cc_decode_string($request['import']);
			if (is_array($decode_string)) {
				return $decode_string;
			}
			$add_errors[] = $this->add_settings_error(__('Success. Imported backup options.', 'cc-framework'), 'updated');
		}

		// reset all options
		if (isset($request['resetall'])) {
			$add_errors[] = $this->add_settings_error(__('Default options restored.', 'cc-framework'), 'updated');
			return;
		}

		// reset only section
		if (isset($request['reset']) && !empty($section_id)) {
			foreach ($this->sections as $value) {
				if ($value['name'] == $section_id) {
					foreach ($value['fields'] as $field) {
						if (isset($field['id'])) {
							if (isset($field['default'])) {
								$request[$field['id']] = $field['default'];
							} else {
								unset($request[$field['id']]);
							}
						}
					}
				}
			}
			$add_errors[] = $this->add_settings_error(__('Default options restored for only this section.', 'cc-framework'), 'updated');
		}

		// option sanitize and validate
		foreach ($this->sections as $section) {
			if (isset($section['fields'])) {
				foreach ($section['fields'] as $field) {

					// ignore santize and validate if element multilangual
					if (isset($field['type']) && !isset($field['multilang']) && isset($field['id'])) {

						// sanitize options
						$request_value = isset($request[$field['id']]) ? $request[$field['id']] : '';
						$sanitize_type = $field['type'];

						if (isset($field['sanitize'])) {
							$sanitize_type = ($field['sanitize'] !== false) ? $field['sanitize'] : false;
						}

						if ($sanitize_type !== false && has_filter('cc_sanitize_' . $sanitize_type)) {
							$request[$field['id']] = apply_filters('cc_sanitize_' . $sanitize_type, $request_value, $field, $section['fields']);
						}

						// validate options
						if (isset($field['validate']) && has_filter('cc_validate_' . $field['validate'])) {

							$validate = apply_filters('cc_validate_' . $field['validate'], $request_value, $field, $section['fields']);

							if (!empty($validate)) {
								$add_errors[] = $this->add_settings_error($validate, 'error', $field['id']);
								$request[$field['id']] = (isset($this->get_option[$field['id']])) ? $this->get_option[$field['id']] : '';
							}

						}

					}

					if (!isset($field['id']) || empty($request[$field['id']])) {
						continue;
					}

				}
			}
		}

		$request = apply_filters('cc_validate_save', $request);

		do_action('cc_validate_save_after', $request);

		// set transient
		$transient_time = (cc_language_defaults() !== false) ? 30 : 10;
		set_transient('cc-framework-transient', array('errors' => $add_errors, 'section_id' => $section_id), $transient_time);

		return $request;
	}

	// field callback classes
	public function field_callback($field) {
		$value = (isset($field['id']) && isset($this->get_option[$field['id']])) ? $this->get_option[$field['id']] : '';
		echo cc_add_element($field, $value, $this->unique);
	}

	// settings sections
	public function do_settings_sections($page) {

		global $wp_settings_sections, $wp_settings_fields;

		if (!isset($wp_settings_sections[$page])) {
			return;
		}

		foreach ($wp_settings_sections[$page] as $section) {

			if ($section['callback']) {
				call_user_func($section['callback'], $section);
			}

			if (!isset($wp_settings_fields) || !isset($wp_settings_fields[$page]) || !isset($wp_settings_fields[$page][$section['id']])) {
				continue;
			}

			$this->do_settings_fields($page, $section['id']);

		}

	}

	// settings fields
	public function do_settings_fields($page, $section) {

		global $wp_settings_fields;

		if (!isset($wp_settings_fields[$page][$section])) {
			return;
		}

		foreach ($wp_settings_fields[$page][$section] as $field) {
			call_user_func($field['callback'], $field['args']);
		}

	}

	public function add_settings_error($message, $type = 'error', $id = 'global') {
		return array('setting' => 'cc-errors', 'code' => $id, 'message' => $message, 'type' => $type);
	}

	// adding option page
	public function admin_menu() {

		$defaults_menu_args = array(
			'menu_parent' => '',
			'menu_title' => '',
			'menu_type' => '',
			'menu_slug' => '',
			'menu_icon' => '',
			'menu_capability' => 'manage_options',
			'menu_position' => null,
		);

		$args = wp_parse_args($this->settings, $defaults_menu_args);

		if ($args['menu_type'] == 'submenu') {
			call_user_func('add_' . $args['menu_type'] . '_page', $args['menu_parent'], $args['menu_title'], $args['menu_title'], $args['menu_capability'], $args['menu_slug'], array(&$this, 'admin_page'));
		} else {
			call_user_func('add_' . $args['menu_type'] . '_page', $args['menu_title'], $args['menu_title'], $args['menu_capability'], $args['menu_slug'], array(&$this, 'admin_page'), $args['menu_icon'], $args['menu_position']);
		}

	}

	// option page html output
	public function admin_page() {
		$allow_html = wp_kses_allowed_html();

		$transient = get_transient('cc-framework-transient');
		$has_nav = (count($this->options) <= 1) ? ' cc-show-all' : '';
		$section_id = (!empty($transient['section_id'])) ? $transient['section_id'] : $this->sections[0]['name'];
		$section_id = cc_get_var('cc-section', $section_id);

		echo '<div class="cc-framework cc-option-framework">';

		echo '<form method="post" action="options.php" enctype="multipart/form-data" id="csframework_form">';
		echo '<input type="hidden" class="cc-reset" name="cc_section_id" value="' . esc_attr($section_id) . '" />';

		if ($this->settings['ajax_save'] !== true && !empty($transient['errors'])) {

			global $cc_errors;

			$cc_errors = $transient['errors'];

			if (!empty($cc_errors)) {
				foreach ($cc_errors as $error) {
					if (in_array($error['setting'], array('general', 'cc-errors'))) {
						echo '<div class="cc-settings-error ' . esc_attr($error['type']) . '">';
						echo '<p><strong>' . esc_attr($error['message']) . '</strong></p>';
						echo '</div>';
					}
				}
			}

		}

		settings_fields($this->unique . '_group');

		echo '<header class="cc-header">';
		echo '<h1>' . esc_attr($this->settings['framework_title']) . '</h1>';
		echo '<fieldset>';

		echo ($this->settings['ajax_save']) ? '<span id="cc-save-ajax">' . esc_html__('Settings saved.', 'cc-framework') . '</span>' : '';

		submit_button(esc_html__('Save', 'cc-framework'), 'primary cc-save', 'save', false, array('data-save' => esc_html__('Saving...', 'cc-framework')));
		submit_button(esc_html__('Restore', 'cc-framework'), 'secondary cc-restore cc-reset-confirm', $this->unique . '[reset]', false);

		if ($this->settings['show_reset_all']) {
			submit_button(esc_html__('Reset All Options', 'cc-framework'), 'secondary cc-restore cc-warning-primary cc-reset-confirm', $this->unique . '[resetall]', false);
		}

		echo '</fieldset>';
		echo (empty($has_nav)) ? '<a href="#" class="cc-expand-all"><i class="fa fa-eye-slash"></i> ' . esc_html__('show all options', 'cc-framework') . '</a>' : '';
		echo '<div class="clear"></div>';
		echo '</header>'; // end .cc-header

		echo '<div class="cc-body' . esc_attr($has_nav) . '">';

		echo '<div class="cc-nav">';

		echo '<ul>';

		foreach ($this->options as $key => $tab) {

			if ((isset($tab['sections']))) {

				$tab_active = cc_array_search($tab['sections'], 'name', $section_id);
				$active_style = (!empty($tab_active)) ? ' style="display: block;"' : '';
				$active_list = (!empty($tab_active)) ? ' cc-tab-active' : '';
				$tab_icon = (!empty($tab['icon'])) ? '<i class="cc-icon ' . $tab['icon'] . '"></i>' : '';

				echo '<li class="cc-sub' . esc_attr($active_list) . '">';

				echo '<a href="#" class="cc-arrow">' . $tab_icon . esc_attr($tab['title']) . '</a>';

				echo '<ul' . wp_kses($active_style, $allow_html) . '>';
				foreach ($tab['sections'] as $tab_section) {

					$active_tab = ($section_id == $tab_section['name']) ? ' class="cc-section-active"' : '';
					$icon = (!empty($tab_section['icon'])) ? '<i class="cc-icon ' . esc_attr($tab_section['icon']) . '"></i>' : '';

					echo '<li><a href="#"' . esc_attr($active_tab) . ' data-section="' . esc_attr($tab_section['name']) . '">' . wp_kses($icon, $allow_html) . esc_attr($tab_section['title']) . '</a></li>';

				}
				echo '</ul>';

				echo '</li>';

			} else {

				$icon = (!empty($tab['icon'])) ? '<i class="cc-icon ' . $tab['icon'] . '"></i>' : '';

				if (isset($tab['fields'])) {

					$active_list = ($section_id == $tab['name']) ? ' class="cc-section-active"' : '';
					echo '<li><a href="#"' . esc_attr($active_list) . ' data-section="' . esc_attr($tab['name']) . '">' . wp_kses($icon, $allow_html) . esc_attr($tab['title']) . '</a></li>';

				} else {

					echo '<li><div class="cc-seperator">' . wp_kses($icon, $allow_html) . esc_attr($tab['title']) . '</div></li>';

				}

			}

		}
		echo '</ul>';

		echo '</div>'; // end .cc-nav

		echo '<div class="cc-content">';

		echo '<div class="cc-sections">';

		foreach ($this->sections as $section) {

			if (isset($section['fields'])) {

				$active_content = ($section_id == $section['name']) ? ' style="display: block;"' : '';
				echo '<div id="cc-tab-' . $section['name'] . '" class="cc-section"' . wp_kses($active_content, $allow_html) . '>';
				echo (isset($section['title']) && empty($has_nav)) ? '<div class="cc-section-title"><h3>' . esc_attr($section['title']) . '</h3></div>' : '';
				$this->do_settings_sections($section['name'] . '_section_group');
				echo '</div>';

			}

		}

		echo '</div>'; // end .cc-sections

		echo '<div class="clear"></div>';

		echo '</div>'; // end .cc-content

		echo '<div class="cc-nav-background"></div>';

		echo '</div>'; // end .cc-body

		echo '<footer class="cc-footer">';
		echo '<div class="cc-block-left">Powered by CC Framework.</div>';
		echo '<div class="cc-block-right">Version ' . CC_VERSION . '</div>';
		echo '<div class="clear"></div>';
		echo '</footer>'; // end .cc-footer

		echo '</form>'; // end form

		echo '<div class="clear"></div>';

		echo '</div>'; // end .cc-framework

	}

}
