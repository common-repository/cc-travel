<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access pages directly.
/**
 *
 * Framework admin enqueue style and scripts
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('cc_admin_enqueue_scripts')) {
	function cc_admin_enqueue_scripts() {

		// admin utilities
		wp_enqueue_media();

		// wp core styles
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_style('wp-jquery-ui-dialog');

		// framework core styles
		wp_enqueue_style('datetimepicker', CC_URI . '/assets/css/jquery.datetimepicker.css', array(), '1.0.0', 'all');
		wp_enqueue_style('cc-framework', CC_URI . '/assets/css/cc-framework.css', array(), '1.0.0', 'all');
		wp_enqueue_style('font-awesome', CC_URI . '/assets/css/font-awesome.css', array(), '4.2.0', 'all');

		if (CC_ACTIVE_LIGHT_THEME) {
			wp_enqueue_style('cc-light-theme', CC_URI . '/assets/css/cc-theme-light.css', array(), "1.0.0", 'all');
		}

		if (is_rtl()) {
			wp_enqueue_style('cc-framework-rtl', CC_URI . '/assets/css/cc-framework-rtl.css', array(), '1.0.0', 'all');
		}

		// wp core scripts
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-accordion');
		wp_enqueue_script('jquery-ui-datepicker');

		// framework core scripts
		wp_enqueue_script('datetimepicker', CC_URI . '/assets/js/vendor/jquery.datetimepicker.js', array(), '1.0.0', true);
		wp_enqueue_script('cc-plugins', CC_URI . '/assets/js/cc-plugins.js', array(), '1.0.0', true);
		wp_enqueue_script('cc-framework', CC_URI . '/assets/js/cc-framework.js', array('cc-plugins'), '1.0.0', true);

	}

	add_action('admin_enqueue_scripts', 'cc_admin_enqueue_scripts');
}
