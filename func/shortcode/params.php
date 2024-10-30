<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/13/2019
 * Time: 9:15 AM
 */

/*
 * Default visual composer shortcode params
 */
if (!function_exists('cc_travel_vc_shortcode_movie_default_params')) {
	function cc_travel_vc_shortcode_movie_default_params() {
		$params = array();

		$custom_fields = cc_travel_get_option('_custom_taxonomy');

		$custom_fields[] = array(
			'title'	=> esc_html__('Destination', 'cc-travel'),
			'name'	=> 'cc_destination',
		);

		$custom_fields[] = array(
			'title'	=> esc_html__('Travel Style', 'cc-travel'),
			'name'	=> 'cc_travel_style',
		);

		if (!empty($custom_fields)) {
			foreach ($custom_fields as $field) {
				$title 		= (isset($field['title']) && $field['title'] != '') ? $field['title'] : '';
				$name 		= (isset($field['name']) && $field['name'] != '') ? sanitize_title($field['name']) : sanitize_title($title);

				$terms 		= get_terms(array('taxonomy' => $name));
				$options 	= array();

				if (!empty($terms)) {
					foreach ($terms as $term) {
						$options[$term->name]	= $term->term_id;
					}
				}

				$params[] = array(
					'type'				=> 'vc_cc_chosen',
					'heading'			=> $title,
					'param_name'		=> $name,
					'value'				=> $options,
					'std'				=> '',
					'group'				=> esc_html__('Query Option', 'cc-travel')
				);
			}
		}

		//order by
		$params[] = array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__('Order By', 'cc-travel'),
			'param_name'	=> 'orderby',
			'value'		=> array(
				esc_html__('Post ID', 'cc-travel')			=> 'ID',
				esc_html__('Title', 'cc-travel')			=> 'title',
				esc_html__('Date', 'cc-travel')				=> 'date',
				esc_html__('Random Order', 'cc-travel')		=> 'rand',
			),
			'std'	=> 'date',
			'group'	=> esc_html__('Query Option', 'cc-travel')
		);

		//order
		$params[] = array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__('Sort order', 'cc-travel'),
			'param_name'	=> 'order',
			'value'			=> array(
				esc_html__('Descending', 'cc-travel')	=> 'DESC',
				esc_html__('Ascending', 'cc-travel')	=> 'ASC',
			),
			'std'			=> 'DESC',
			'group'			=> esc_html__('Query Option', 'cc-travel')
		);

		return $params;
	}
}

