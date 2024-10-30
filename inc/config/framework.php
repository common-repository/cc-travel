<?php
/**
 * Created by PhpStorm.
 * User: TRUNG
 * Date: 10/27/2017
 * Time: 9:53 PM
 */

if (!defined('ABSPATH')) {
	return;
}

$settings	= array(
	'menu_title'		=> esc_html__('CC Travel', 'cc-travel'),
	'menu_type'			=> 'menu',
	'menu_slug'			=> 'cc-travel',
	'framework_title'	=> esc_html__('CC Travel Setting', 'cc-travel'),
	'ajax_save'			=> false,
	'show_reset_all'	=> false,
);

$options	= array();

$pages			= get_pages();
$page_options	= array();

if (!empty($pages)) {
	foreach ($pages as $page) {
		$page_options[$page->ID] = $page->post_title;
	}
}

$default_page_archive_tour		= get_page_by_path('tours');
$default_page_archive_tour_id	= ($default_page_archive_tour) ? $default_page_archive_tour->ID : '';

$options[]	= array(
	'name'		=> '_cc_travel_general',
	'title'		=> esc_html__('General', 'cc-travel'),
	'fields'	=> array(
		array(
			'id'			=> '_page_archive_tour',
			'title'			=> esc_html__('Page Archive Tours', 'cc-travel'),
			'type'			=> 'select',
			'class'			=> 'chosen',
			'options'		=> $page_options,
			'default'		=> cc_travel_archive_tour_page_id()
		),

		array(
			'id'			=> '_page_booking',
			'title'			=> esc_html__('Page Booking', 'cc-travel'),
			'type'			=> 'select',
			'class'			=> 'chosen',
			'options'		=> $page_options,
			'default'		=> cc_travel_booking_page_id()
		),

		array(
			'id' 			=> '_currency_symbol',
			'type' 			=> 'text',
			'title' 		=> esc_html__('Currency', 'cc-travel'),
			'default'		=> '$'
		),

		array(
			'id'		=> '_currency_position',
			'type'		=> 'select',
			'class'		=> 'chosen',
			'title'		=> esc_html__('Currency position ', 'cc-travel'),
			'options'	=> array(
				'left'		=> esc_html__('Left', 'cc-travel'),
				'right'		=> esc_html__('Right', 'cc-travel'),
			),
			'default'	=> 'left',
		),

		array(
			'id'				=> '_custom_taxonomy',
			'type'				=> 'group',
			'title'				=> esc_html__('Custom Taxonomy', 'cc-travel'),
			'button_title'		=> esc_html__('Add New Taxonomy', 'cc-travel'),
			'accordion'			=> true,
			'accordion_title'	=> esc_html__('New Taxonomy', 'cc-travel'),
			'fields'			=> array(
				array(
					'id'			=> 'title',
					'type'			=> 'text',
					'title'			=> esc_html__('Title', 'cc-travel'),
				),

				array(
					'id'			=> 'name',
					'type'			=> 'text',
					'title'			=> esc_html__('Singular Name', 'cc-travel'),
					'desc'			=> esc_html__('Best if used english, no space', 'cc-travel'),
				),

				array(
					'id'			=> 'slug',
					'type'			=> 'text',
					'title'			=> esc_html__('Slug', 'cc-travel'),
				),

				array(
					'id'			=> 'type',
					'class'			=> 'chosen',
					'type'			=> 'select',
					'title'			=> esc_html__('Type', 'cc-travel'),
					'options'		=> array(
						'category'	=> esc_html__('Category', 'cc-travel'),
						'tag'		=> esc_html__('Tag', 'cc-travel'),
					)
				),
			),
		),

		array(
			'id'				=> '_custom_fields',
			'type'				=> 'group',
			'title'				=> esc_html__('Custom Fields', 'cc-travel'),
			'button_title'		=> esc_html__('Add New Field', 'cc-travel'),
			'accordion'			=> true,
			'accordion_title'	=> esc_html__('New Field', 'cc-travel'),
			'fields'			=> array(
				array(
					'id'			=> 'title',
					'type'			=> 'text',
					'title'			=> esc_html__('Title', 'cc-travel'),
				),

				array(
					'id'			=> 'type',
					'class'			=> 'chosen',
					'type'			=> 'select',
					'title'			=> esc_html__('Type', 'cc-travel'),
					'options'		=> array(
						'text'			=> esc_html__('Text', 'cc-travel'),
						'textarea'		=> esc_html__('Textarea', 'cc-travel'),
						'color_picker'	=> esc_html__('Color Picker', 'cc-travel'),
						'image'			=> esc_html__('Image', 'cc-travel'),
						'icon'			=> esc_html__('Icon', 'cc-travel'),
						'gallery'		=> esc_html__('Gallery', 'cc-travel'),
					)
				),

				array(
					'id'			=> 'name',
					'type'			=> 'text',
					'title'			=> esc_html__('Singular Name', 'cc-travel'),
					'desc'			=> esc_html__('Best if used english, no space', 'cc-travel'),
				),
			),
		),
	)
);

$options[]	= array(
	'name'		=> '_cc_travel_taxonomy',
	'title'		=> esc_html__('Archive & Taxonomy', 'cc-travel'),
	'fields'	=> array(
		array(
			'id'				=> '_taxonomy_sidebar',
			'type'				=> 'select',
			'class'				=> 'chosen',
			'title'				=> esc_html__('Select Sidebar', 'cc-travel'),
			'options'			=> array(
				'right'				=> esc_html__('Right Sidebar', 'cc-travel'),
				'left'				=> esc_html__('Left Sidebar', 'cc-travel'),
				'full'				=> esc_html__('No Sidebar', 'cc-travel'),
			),
			'default'			=> 'full',
		),

		array(
			'id'				=> '_taxonomy_widget',
			'type'				=> 'select',
			'class'				=> 'chosen',
			'title'				=> esc_html__('Sidebar Widget', 'cc-travel'),
			'options'			=> cc_travel_wp_registered_sidebars(),
			'default_option'	=> esc_html__('Select a sidebar', 'cc-travel'),
			'dependency'		=> array('_taxonomy_sidebar', 'any', 'right,left'),
		),

		array(
			'id'		=> '_taxonomy_layout',
			'type'		=> 'select',
			'class'		=> 'chosen',
			'title'		=> esc_html__('Select Layout', 'cc-travel'),
			'options'	=> array(
				'grid'		=> esc_html__('Grid', 'cc-travel'),
				'list'		=> esc_html__('List', 'cc-travel'),
			),
			'default'	=> 'grid',
		),

		array(
			'type'			=> 'select',
			'title'			=> esc_html__('Select Columns', 'cc-travel'),
			'id'			=> '_taxonomy_column',
			'class'			=> 'chosen',
			'options'		=> array(
				'2'	=> esc_html__('2 column', 'cc-travel'),
				'3'	=> esc_html__('3 column', 'cc-travel'),
				'4'	=> esc_html__('4 column', 'cc-travel'),
				'6' => esc_html__('6 column', 'cc-travel'),
			),
			'default'			=> '3',
			'dependency'	=> array('_taxonomy_layout', '==', 'grid'),
		),

		array(
			'id' 			=> '_taxonomy_post_per_page',
			'type' 			=> 'text',
			'title' 		=> esc_html__('Post Per Page', 'cc-travel'),
			'default'		=> ''
		),
	)
);


CC_Travel_Framework::instance($settings, $options);