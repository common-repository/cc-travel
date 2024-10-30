<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access pages directly.

/**
 *
 * Metabox Class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CCFramework_Metabox extends CCFramework_Abstract {

	/**
	 *
	 * metabox options
	 * @access public
	 * @var array
	 *
	 */
	public $options = array();

	/**
	 *
	 * instance
	 * @access private
	 * @var class
	 *
	 */
	private static $instance = null;

	// run metabox construct
	public function __construct($options) {

		$this->options = apply_filters('cc_metabox_options', $options);

		if (!empty($this->options)) {
			$this->addAction('add_meta_boxes', 'add_meta_box');
			$this->addAction('save_post', 'save_post', 10, 2);
		}

	}

	// instance
	public static function instance($options = array()) {
		if (is_null(self::$instance)) {
			self::$instance = new self($options);
		}
		return self::$instance;
	}

	// add metabox
	public function add_meta_box($post_type) {

		foreach ($this->options as $value) {
			add_meta_box($value['id'], $value['title'], array(&$this, 'render_meta_box_content'), $value['post_type'], $value['context'], $value['priority'], $value);
		}

	}

	// metabox render content
	public function render_meta_box_content($post, $callback) {

		global $post, $cc_errors, $typenow;

		wp_nonce_field('cc-framework-metabox', 'cc-framework-metabox-nonce');

		$unique = $callback['args']['id'];
		$sections = $callback['args']['sections'];
		$meta_value = get_post_meta($post->ID, $unique, true);
		$transient = get_transient('cc-metabox-transient');
		$cc_errors = $transient['errors'];
		$has_nav = (count($sections) >= 2 && $callback['args']['context'] != 'side') ? true : false;
		$show_all = (!$has_nav) ? ' cc-show-all' : '';
		$section_id = (!empty($transient['ids'][$unique])) ? $transient['ids'][$unique] : '';
		$section_id = cc_get_var('cc-section', $section_id);

		echo '<div class="cc-framework cc-metabox-framework">';

		echo '<input type="hidden" name="cc_section_id[' . esc_attr($unique) . ']" class="cc-reset" value="' . esc_attr($section_id) . '">';

		echo '<div class="cc-body' . esc_attr($show_all) . '">';

		if ($has_nav) {

			echo '<div class="cc-nav">';

			echo '<ul>';
			$num = 0;
			foreach ($sections as $value) {

				if (!empty($value['typenow']) && $value['typenow'] !== $typenow) {
					continue;
				}

				if (isset($value['fields'])) {
					$active_section = ((empty($section_id) && $num === 0) || $section_id == $value['name']) ? ' class="cc-section-active"' : '';
					echo '<li><a href="#"' . esc_attr($active_section) . ' data-section="' . esc_attr($value['name']) . '">';
					echo (!empty($value['icon'])) ? '<i class="cc-icon ' . esc_attr($value['icon']) . '"></i>' : '';
					echo esc_attr($value['title']);
					echo '</a></li>';
				} else {
					echo '<li><div class="cc-seperator">';
					echo (!empty($value['icon'])) ? '<i class="cc-icon ' . esc_attr($value['icon']) . '"></i>' : '';
					echo esc_attr($value['title']);
					echo '</div></li>';
				}

				$num++;
			}
			echo '</ul>';

			echo '</div>';

		}

		echo '<div class="cc-content">';

		echo '<div class="cc-sections">';
		$num = 0;
		foreach ($sections as $v) {

			if (!empty($v['typenow']) && $v['typenow'] !== $typenow) {
				continue;
			}

			if (isset($v['fields'])) {

				$active_content = ((empty($section_id) && $num === 0) || $section_id == $v['name']) ? ' style="display: block;"' : '';

				echo '<div id="cc-tab-' . esc_attr($v['name']) . '" class="cc-section"' . esc_attr($active_content) . '>';
				echo (isset($v['title'])) ? '<div class="cc-section-title"><h3>' . esc_attr($v['title']) . '</h3></div>' : '';

				foreach ($v['fields'] as $field_key => $field) {

					$default = (isset($field['default'])) ? $field['default'] : '';
					$elem_id = (isset($field['id'])) ? $field['id'] : '';
					$elem_value = (is_array($meta_value) && isset($meta_value[$elem_id])) ? $meta_value[$elem_id] : $default;
					echo cc_add_element($field, $elem_value, $unique);

				}
				echo '</div>';

			}

			$num++;
		}
		echo '</div>';

		echo '<div class="clear"></div>';

		echo '</div>';

		echo ($has_nav) ? '<div class="cc-nav-background"></div>' : '';

		echo '<div class="clear"></div>';

		echo '</div>';

		echo '</div>';

	}

	// save metabox options
	public function save_post($post_id, $post) {

		if (wp_verify_nonce(cc_get_var('cc-framework-metabox-nonce'), 'cc-framework-metabox')) {

			$errors = array();
			$post_type = cc_get_var('post_type');

			foreach ($this->options as $request_value) {

				if (in_array($post_type, (array)$request_value['post_type'])) {

					$request_key = $request_value['id'];
					$request = cc_get_var($request_key, array());

					// ignore _nonce
					if (isset($request['_nonce'])) {
						unset($request['_nonce']);
					}

					foreach ($request_value['sections'] as $key => $section) {

						if (isset($section['fields'])) {

							foreach ($section['fields'] as $field) {

								if (isset($field['type']) && isset($field['id'])) {

									$field_value = cc_get_vars($request_key, $field['id']);

									// sanitize options
									if (isset($field['sanitize']) && $field['sanitize'] !== false) {
										$sanitize_type = $field['sanitize'];
									} else if (!isset($field['sanitize'])) {
										$sanitize_type = $field['type'];
									}

									if (has_filter('cc_sanitize_' . $sanitize_type)) {
										$request[$field['id']] = apply_filters('cc_sanitize_' . $sanitize_type, $field_value, $field, $section['fields']);
									}

									if (empty($request)) {
										delete_post_meta($post_id, $field['id']);
									} else {
										update_post_meta($post_id, $field['id'], $field_value);
									}

									if (is_array($field_value) && !empty($field_value)) {
										foreach ($field_value as $item_name => $item_value) {
											if (!is_numeric($item_name)) {
												if (empty($request)) {
													delete_post_meta($post_id, $item_name);
												} else {
													update_post_meta($post_id, $item_name, $item_value);
												}
											}
										}
									}

									// validate options
									if (isset($field['validate']) && has_filter('cc_validate_' . $field['validate'])) {

										$validate = apply_filters('cc_validate_' . $field['validate'], $field_value, $field, $section['fields']);

										if (!empty($validate)) {

											$meta_value = get_post_meta($post_id, $request_key, true);

											$errors[$field['id']] = array('code' => $field['id'], 'message' => $validate, 'type' => 'error');
											$default_value = isset($field['default']) ? $field['default'] : '';
											$request[$field['id']] = (isset($meta_value[$field['id']])) ? $meta_value[$field['id']] : $default_value;
										}

									}
								}

							}

						}

					}

					$request = apply_filters('cc_save_post', $request, $request_key, $post);

					if (empty($request)) {

						delete_post_meta($post_id, $request_key);

					} else {

						update_post_meta($post_id, $request_key, $request);

					}

					$transient['ids'][$request_key] = cc_get_vars('cc_section_id', $request_key);
					$transient['errors'] = $errors;

				}

			}

			set_transient('cc-metabox-transient', $transient, 10);

		}

	}

}
