<?php
/**
 * Created by vagrant.
 * User: vagrant
 */


if (!defined('ABSPATH')) {
	return;
}

if (!function_exists('cc_travel_create_post_type_tour')) {
	function cc_travel_create_post_type_tour() {
		$args		= array(
			'labels'			=> array(
				'name' 			=> esc_html__('Tour', 'cc-travel'),
				'singular_name' => esc_html__('Tours', 'cc-travel'),
				'add_new_item'	=> esc_html__('Add Tour', 'cc-travel'),
				'add_new'		=> esc_html__('Add Tour', 'cc-travel'),
			),
			'public' 				=> true,
			'has_archive' 			=> get_post_field('post_name', cc_travel_archive_tour_page_id()),
			'publicly_queryable'  	=> true,
			'exclude_from_search'	=> false,
			'menu_icon'				=> 'dashicons-admin-site',
			'supports'				=> array('title', 'editor', 'comments', 'thumbnail'),
			'rewrite'				=> array(
				'slug' 			=> 'tour',
				'with_front'    => true,
				'feeds'         => true,
				'pages'			=> true,
			),
		);

		register_post_type('cc_tour', $args);
	}

	add_action('init', 'cc_travel_create_post_type_tour');
}

if (!function_exists('cc_travel_create_post_type_booking')) {
	function cc_travel_create_post_type_booking() {
		$args		= array(
			'labels'			=> array(
				'name' 			=> esc_html__('Booking', 'cc-travel'),
				'singular_name' => esc_html__('Booking', 'cc-travel'),
				'add_new_item'	=> esc_html__('Add Booking', 'cc-travel'),
				'add_new'		=> esc_html__('Add Booking', 'cc-travel'),
			),
			'public' 				=> true,
			'has_archive' 			=> false,
			'publicly_queryable'  	=> false,
			'exclude_from_search'	=> false,
			'menu_icon'				=> 'dashicons-admin-site',
			'supports'				=> array('title'),
			'rewrite'				=> false,
		);

		register_post_type('cc_booking', $args);
	}

	add_action('init', 'cc_travel_create_post_type_booking');
}

// Destination
if (!function_exists('cc_travel_create_taxonomy_destination')) {
	function cc_travel_create_taxonomy_destination() {
		register_taxonomy('cc_destination',array('cc_tour'), array(
			'hierarchical' 		=> true,
			'labels' 			=> array(
				'name' 				=> esc_html__('Destination', 'cc-travel'),
				'singular_name' 	=> esc_html__('Destination', 'cc-travel'),
				'search_items' 		=> esc_html__('Search Destination', 'cc-travel'),
				'all_items' 		=> esc_html__('All Destination', 'cc-travel'),
				'parent_item' 		=> esc_html__('Parent Destination', 'cc-travel'),
				'parent_item_colon' => esc_html__('Parent Destination:', 'cc-travel'),
				'edit_item' 		=> esc_html__('Edit Destination', 'cc-travel'),
				'update_item' 		=> esc_html__('Update Destination', 'cc-travel'),
				'add_new_item' 		=> esc_html__('Add New Destination', 'cc-travel'),
				'new_item_name' 	=> esc_html__('New Destination Name', 'cc-travel'),
				'menu_name' 		=> esc_html__('Destination'),
			),
			'show_ui' 			=> true,
			'show_admin_column' => true,
			'query_var' 		=> true,
			'rewrite' 			=> array(
				'slug'                  => 'destination',
				'with_front'            => true,
				'hierarchical'          => true,
			),
		));
	}

	add_action('init', 'cc_travel_create_taxonomy_destination');
}

// Travel Style
if (!function_exists('cc_travel_create_taxonomy_travel_style')) {
	function cc_travel_create_taxonomy_travel_style() {
		register_taxonomy('cc_travel_style',array('cc_tour'), array(
			'hierarchical' 		=> true,
			'labels' 			=> array(
				'name' 				=> esc_html__('Travel Style', 'cc-travel'),
				'singular_name' 	=> esc_html__('Travel Style', 'cc-travel'),
				'search_items' 		=> esc_html__('Search Travel Style', 'cc-travel'),
				'all_items' 		=> esc_html__('All Travel Style', 'cc-travel'),
				'parent_item' 		=> esc_html__('Parent Travel Style', 'cc-travel'),
				'parent_item_colon' => esc_html__('Parent Travel Style:', 'cc-travel'),
				'edit_item' 		=> esc_html__('Edit Travel Style', 'cc-travel'),
				'update_item' 		=> esc_html__('Update Travel Style', 'cc-travel'),
				'add_new_item' 		=> esc_html__('Add New Travel Style', 'cc-travel'),
				'new_item_name' 	=> esc_html__('New Travel Style Name', 'cc-travel'),
				'menu_name' 		=> esc_html__('Travel Style'),
			),
			'show_ui' 			=> true,
			'show_admin_column' => true,
			'query_var' 		=> true,
			'rewrite' 			=> array(
				'slug'                  => 'travel-style',
				'with_front'            => true,
				'hierarchical'          => true,
			),
		));
	}

	add_action('init', 'cc_travel_create_taxonomy_travel_style');
}

// Custom taxonomy
if (!function_exists('cc_travel_create_custom_taxonomy')) {
	function cc_travel_create_custom_taxonomy() {
		$custom_fields = cc_travel_get_option('_custom_taxonomy');

		if (!empty($custom_fields)) {
			foreach ($custom_fields as $field) {
				$title 		= (isset($field['title']) && $field['title'] != '') ? $field['title'] : '';
				$name 		= (isset($field['name']) && $field['name'] != '') ? sanitize_title($field['name']) : sanitize_title($title);
				$slug		= (isset($field['slug']) && $field['slug'] != '') ? sanitize_title($field['slug']) : $name;
				$type		= $field['type'];

				if ($type == 'category') {
					$hierarchical = true;
				} else {
					$hierarchical = false;
				}

				register_taxonomy($name, array('cc_tour'), array(
					'hierarchical' 		=> $hierarchical,
					'labels' 			=> array(
						'name' 			=> $title,
					),
					'show_ui' 			=> true,
					'show_admin_column' => true,
					'query_var' 		=> true,
					'rewrite' 			=> array(
						'slug'                  => $slug,
						'with_front'            => true,
						'hierarchical'          => true,
					),
				));
			}
		}
	}

	add_action('init', 'cc_travel_create_custom_taxonomy');
}