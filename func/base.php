<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/13/2019
 * Time: 9:09 AM
 */

/*
 *	Get value in array
 */
if (!function_exists('cc_travel_get_value_in_array')) {
	function cc_travel_get_value_in_array($arr, $key) {
		$arr = (array) $arr;

		if (!empty($arr) && isset($arr[$key])) {
			return $arr[$key];
		} else {
			return false;
		}
	}
}

/**
 * Get registered sidebars
 */
if (! function_exists('cc_travel_wp_registered_sidebars')) {
	function cc_travel_wp_registered_sidebars() {
		global $wp_registered_sidebars;

		$widgets	= array();

		if (! empty($wp_registered_sidebars)) {
			foreach ($wp_registered_sidebars as $key => $value) {
				$widgets[$key]	= $value['name'];
			}
		}

		return array_reverse($widgets);
	}
}

/*
 * Default Image Size
 */
if (! function_exists('cc_travel_default_image_size')) {
	function cc_travel_default_image_size() {
		$img_size = array();

		$img_size[0]['img_size_name'] 	= 'cc-travel-470-290-archive-tour';
		$img_size[0]['img_size_width'] 	= '470';
		$img_size[0]['img_size_height']	= '290';
		$img_size[0]['img_crop'] 		= '1';

		$img_size[1]['img_size_name'] 	= 'cc-travel-350-350-medium';
		$img_size[1]['img_size_width'] 	= '350';
		$img_size[1]['img_size_height']	= '350';
		$img_size[1]['img_crop'] 		= '1';

		$img_size = apply_filters('cc_travel_default_image_size', $img_size);

		return $img_size;
	}
}

/*
 * Get option from plugin options
 */
if (!function_exists('cc_travel_get_option')) {
	function cc_travel_get_option($option_name = '', $default = '') {

		$options = apply_filters('cc_travel_get_option', get_option('_cc_travel_options'), $option_name, $default);

		if (!empty($option_name) && !empty($options[$option_name])) {
			return $options[$option_name];
		} else {
			return (!empty($default)) ? $default : null;
		}

	}
}

/*
 * Page Sidebar
 */
if (!function_exists( 'cc_travel_page_sidebar')) {
	function cc_travel_page_sidebar($page, $sidebar) {
		if ($page != 'full' && is_active_sidebar($sidebar)) {
			echo '<div class="cct-sidebar col-md-3">';
			dynamic_sidebar($sidebar);
			echo '</div>';
		}
	}
}