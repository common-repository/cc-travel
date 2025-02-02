<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access pages directly.
/**
 *
 * Get icons from admin ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('cc_get_icons')) {
	function cc_get_icons() {

		do_action('cc_add_icons_before');

		$jsons = apply_filters('cc_add_icons_json', glob(CC_DIR . '/fields/icon/*.json'));

		if (!empty($jsons)) {

			foreach ($jsons as $path) {

				$object = cc_get_icon_fonts('fields/icon/' . basename($path));

				if (is_object($object)) {

					echo (count($jsons) >= 2) ? '<h4 class="cc-icon-title">' . $object->name . '</h4>' : '';

					foreach ($object->icons as $icon) {
						echo '<a class="cc-icon-tooltip" data-cc-icon="' . esc_attr($icon) . '" data-title="' . esc_attr($icon) . '"><span class="cc-icon cc-selector"><i class="' . esc_attr($icon) . '"></i></span></a>';
					}

				} else {
					echo '<h4 class="cc-icon-title">' . esc_html__('Error! Can not load json file.', 'cc-framework') . '</h4>';
				}

			}

		}

		do_action('cc_add_icons');
		do_action('cc_add_icons_after');

		die();
	}

	add_action('wp_ajax_cc-get-icons', 'cc_get_icons');
}

/**
 *
 * Export options
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('cc_export_options')) {
	function cc_export_options() {

		header('Content-Type: plain/text');
		header('Content-disposition: attachment; filename=backup-options-' . gmdate('d-m-Y') . '.txt');
		header('Content-Transfer-Encoding: binary');
		header('Pragma: no-cache');
		header('Expires: 0');

		echo cc_encode_string(get_option(CC_OPTION));

		die();
	}

	add_action('wp_ajax_cc-export-options', 'cc_export_options');
}

/**
 *
 * Set icons for wp dialog
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('cc_set_icons')) {
	function cc_set_icons() {

		echo '<div id="cc-icon-dialog" class="cc-dialog" title="' . esc_html__('Add Icon', 'cc-framework') . '">';
		echo '<div class="cc-dialog-header cc-text-center"><input type="text" placeholder="' . esc_html__('Search a Icon...', 'cc-framework') . '" class="cc-icon-search" /></div>';
		echo '<div class="cc-dialog-load"><div class="cc-icon-loading">' . esc_html__('Loading...', 'cc-framework') . '</div></div>';
		echo '</div>';

	}

	add_action('admin_footer', 'cc_set_icons');
	add_action('customize_controls_print_footer_scripts', 'cc_set_icons');
}
