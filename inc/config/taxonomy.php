<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 7/13/2019
 * Time: 9:33 PM
 */

$options      	= array();

// Destination
$options[] = array(
	'id'        => '_destination_options',
	'taxonomy'	=> 'cc_destination',
	'fields'    => array(
		array(
			'id'			=> 'type',
			'class'			=> 'chosen',
			'type'			=> 'select',
			'title'			=> esc_html__('Destination Type', 'cc-travel'),
			'options'		=> array(
				'country'	=> esc_html__('Country', 'cc-travel'),
				'city'		=> esc_html__('City', 'cc-travel'),
				'place'		=> esc_html__('Place', 'cc-travel'),
			)
		),

		array(
			'id'    => 'featured_image',
			'type'  => 'image',
			'title' => esc_html__('Featured Image', 'cc-travel'),
		),

		array(
			'id'    => 'banner',
			'type'  => 'image',
			'title' => esc_html__('Banner', 'cc-travel'),
		),

		array(
			'id'    => 'gallery',
			'type'  => 'gallery',
			'title' => esc_html__('Gallery', 'cc-travel'),
		),

		array(
			'id'	=> 'infomation',
			'type'	=> 'group',
			'title'	=> esc_html__('Infomation', 'cc-travel'),
			'button_title'    => esc_html__('Add New', 'cc-travel'),
			'accordion_title' => esc_html__('Add New Infomation', 'cc-travel'),
			'fields'          => array(
				array(
					'id'	=> 'title',
					'type'	=> 'text',
					'title'	=> esc_html__('Title', 'cc-travel'),
				),

				array(
					'id'	=> 'content',
					'type'	=> 'textarea',
					'title'	=> esc_html__('Description', 'cc-travel'),
				),
			),
		),

		/*
		array(
			'id'	=> 'highlights',
			'type'	=> 'group',
			'title'	=> esc_html__('Highlights', 'cc-travel'),
			'button_title'    => esc_html__('Add New', 'cc-travel'),
			'accordion_title' => esc_html__('Add New Highlights', 'cc-travel'),
			'fields'          => array(
				array(
					'id'	=> 'title',
					'type'	=> 'text',
					'title'	=> esc_html__('Title', 'cc-travel'),
				),

				array(
					'id'    => 'image',
					'type'  => 'image',
					'title' => esc_html__('Image', 'cc-travel'),
				),

				array(
					'id'	=> 'content',
					'type'	=> 'textarea',
					'title'	=> esc_html__('Title', 'cc-travel'),
				),
			),
		),
		*/
	)
);

CC_Travel_Taxonomy::instance($options);