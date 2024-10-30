<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/13/2019
 * Time: 9:16 AM
 */

/*
 * Default atts
 */
if (!function_exists('cc_travel_shortcode_default_atts')) {
	function cc_travel_shortcode_default_atts() {
		$custom_fields			= cc_travel_get_option('movie_custom_fields');
		$shortcodes_atts 		= array();

		$shortcodes_atts['cc_destination'] 	= '';
		$shortcodes_atts['cc_travel_style'] = '';

		if (!empty($custom_fields)) {
			foreach ($custom_fields as $field) {
				$title 		= (isset($field['title']) && $field['title'] != '') ? $field['title'] : '';
				$name 		= (isset($field['name']) && $field['name'] != '') ? sanitize_title($field['name']) : sanitize_title($title);

				$shortcodes_atts[$name]	= '';
			}
		}

		$shortcodes_atts['orderby']			= 'date';
		$shortcodes_atts['order']			= 'DESC';
		$shortcodes_atts['posts_per_page']	= '-1';

		$shortcodes_atts['class']			= '';

		return $shortcodes_atts;
	}
}