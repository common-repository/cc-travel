<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access pages directly.
/**
 *
 * Add framework element
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('cc_add_element')) {
	function cc_add_element($field = array(), $value = '', $unique = '') {

		$output = '';
		$depend = '';
		$sub = (isset($field['sub'])) ? 'sub-' : '';
		$unique = (isset($unique)) ? $unique : '';
		$languages = cc_language_defaults();
		$class = 'CCFramework_Option_' . $field['type'];
		$wrap_class = (isset($field['wrap_class'])) ? ' ' . $field['wrap_class'] : '';
		$el_class = (isset($field['title'])) ? sanitize_title($field['title']) : 'no-title';
		$hidden = (isset($field['show_only_language']) && ($field['show_only_language'] != $languages['current'])) ? ' hidden' : '';
		$is_pseudo = (isset($field['pseudo'])) ? ' cc-pseudo-field' : '';

		if (isset($field['dependency'])) {
			$hidden = ' hidden';
			$depend .= ' data-' . $sub . 'controller="' . $field['dependency'][0] . '"';
			$depend .= ' data-' . $sub . 'condition="' . $field['dependency'][1] . '"';
			$depend .= ' data-' . $sub . 'value="' . $field['dependency'][2] . '"';
		}

		$output .= '<div class="cc-element cc-element-' . $el_class . ' cc-field-' . $field['type'] . $is_pseudo . $wrap_class . $hidden . '"' . $depend . '>';

		if (isset($field['title'])) {
			$field_desc = (isset($field['desc'])) ? '<p class="cc-text-desc">' . $field['desc'] . '</p>' : '';
			$output .= '<div class="cc-title"><h4>' . $field['title'] . '</h4>' . $field_desc . '</div>';
		}

		$output .= (isset($field['title'])) ? '<div class="cc-fieldset">' : '';

		$value = (!isset($value) && isset($field['default'])) ? $field['default'] : $value;
		$value = (isset($field['value'])) ? $field['value'] : $value;

		if (class_exists($class)) {
			ob_start();
			$element = new $class($field, $value, $unique);
			$element->output();
			$output .= ob_get_clean();
		} else {
			$output .= '<p>' . __('This field class is not available!', 'cc-framework') . '</p>';
		}

		$output .= (isset($field['title'])) ? '</div>' : '';
		$output .= '<div class="clear"></div>';
		$output .= '</div>';

		return $output;

	}
}

/**
 *
 * Encode string for backup options
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('cc_encode_string')) {
	function cc_encode_string($string) {
		return rtrim(strtr(call_user_func('base' . '64' . '_encode', addslashes(gzcompress(serialize($string), 9))), '+/', '-_'), '=');
	}
}

/**
 *
 * Decode string for backup options
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('cc_decode_string')) {
	function cc_decode_string($string) {
		return unserialize(gzuncompress(stripslashes(call_user_func('base' . '64' . '_decode', rtrim(strtr($string, '-_', '+/'), '=')))));
	}
}

/**
 *
 * Get google font from json file
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('cc_get_google_fonts')) {
	function cc_get_google_fonts() {

		global $cc_google_fonts;

		if (!empty($cc_google_fonts)) {

			return $cc_google_fonts;

		} else {

			ob_start();
			cc_locate_template('fields/typography/google-fonts.json');
			$json = ob_get_clean();

			$cc_google_fonts = json_decode($json);

			return $cc_google_fonts;
		}

	}
}

/**
 *
 * Get icon fonts from json file
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('cc_get_icon_fonts')) {
	function cc_get_icon_fonts($file) {

		ob_start();
		cc_locate_template($file);
		$json = ob_get_clean();

		return json_decode($json);

	}
}

/**
 *
 * Array search key & value
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('cc_array_search')) {
	function cc_array_search($array, $key, $value) {

		$results = array();

		if (is_array($array)) {
			if (isset($array[$key]) && $array[$key] == $value) {
				$results[] = $array;
			}

			foreach ($array as $sub_array) {
				$results = array_merge($results, cc_array_search($sub_array, $key, $value));
			}

		}

		return $results;

	}
}

/**
 *
 * Getting POST Var
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('cc_get_var')) {
	function cc_get_var($var, $default = '') {

		if (isset($_POST[$var])) {
			return wp_unslash($_POST[$var]);
		}

		if (isset($_GET[$var])) {
			return wp_unslash($_GET[$var]);
		}

		return $default;

	}
}

/**
 *
 * Getting POST Vars
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('cc_get_vars')) {
	function cc_get_vars($var, $depth, $default = '') {

		if (isset($_POST[$var][$depth])) {
			return wp_unslash($_POST[$var][$depth]);
		}

		if (isset($_GET[$var][$depth])) {
			return wp_unslash($_GET[$var][$depth]);
		}

		return $default;

	}
}

/**
 *
 * Load options fields
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('cc_load_option_fields')) {
	function cc_load_option_fields() {

		$located_fields = array();

		foreach (glob(CC_DIR . '/fields/*/*.php') as $cc_field) {
			$located_fields[] = basename($cc_field);
			cc_locate_template(str_replace(CC_DIR, '', $cc_field));
		}

		$override_name = apply_filters('cc_framework_override', 'cc-framework-override');
		$override_dir = get_template_directory() . '/' . $override_name . '/fields';

		if (is_dir($override_dir)) {

			foreach (glob($override_dir . '/*/*.php') as $override_field) {

				if (!in_array(basename($override_field), $located_fields)) {

					cc_locate_template(str_replace($override_dir, '/fields', $override_field));

				}

			}

		}

		do_action('cc_load_option_fields');

	}
}
