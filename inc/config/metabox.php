<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 7/18/2019
 * Time: 9:33 PM
 */
$options	= array();

// Details
$tour_arr = array();

$tour_arr[] = array(
	'name'		=> '_details',
	'title'		=> esc_html__('Details', 'cc-travel'),
	'fields'	=> array(
		array(
			'title'		=> esc_html__('Short Description', 'cc-travel'),
			'id'		=> '_short_desc',
			'type'      => 'textarea',
		),

		array(
			'title'		=> esc_html__('Duration', 'cc-travel'),
			'id'		=> '_duration',
			'type'      => 'fieldset',
			'inline'	=> true,
			'fields'	=> array(
				array(
					'title'		=> esc_html__('Days', 'cc-travel'),
					'id'		=> '_duration_days',
					'type'      => 'number',
				),

				array(
					'title'		=> esc_html__('Night', 'cc-travel'),
					'id'		=> '_duration_night',
					'type'      => 'number',
				),
			)
		),

		array(
			'title'		=> esc_html__('Age', 'cc-travel'),
			'id'		=> '_age',
			'type'      => 'fieldset',
			'inline'	=> true,
			'fields'	=> array(
				array(
					'title'		=> esc_html__('From', 'cc-travel'),
					'id'		=> '_age_from',
					'type'      => 'number',
				),

				array(
					'title'		=> esc_html__('To', 'cc-travel'),
					'id'		=> '_age_to',
					'type'      => 'number',
				),
			)
		),

		array(
			'title'		=> esc_html__('Location Map', 'cc-travel'),
			'id'		=> '_map',
			'type'      => 'textarea',
		),
	)
);

$tour_arr[] = array(
	'name'		=> '_highlight',
	'title'		=> esc_html__('Highlight', 'cc-travel'),
	'fields'	=> array(
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
					'id'	=> 'desc',
					'type'	=> 'textarea',
					'title'	=> esc_html__('Description', 'cc-travel'),
				),
			),
		),
	)
);

$tour_arr[] = array(
	'name'		=> '_price',
	'title'		=> esc_html__('Price', 'cc-travel'),
	'fields'	=> array(
		/*
		array(
			'id'			=> '_price_type',
			'class'			=> 'chosen',
			'default'		=> 'simple',
			'type'			=> 'select',
			'title'			=> esc_html__('Price Type', 'cc-travel'),
			'options'		=> array(
				'simple'	=> esc_html__('Simple Price', 'cc-travel'),
				'variable'	=> esc_html__('Variable Price', 'cc-travel'),
			)
		),
		*/
		array(
			'id'			=> 'regular_price',
			'type'			=> 'text',
			'title'			=> esc_html__('Regular Price', 'cc-travel'),
			//'dependency'	=> array('_price_type', '==', 'simple')
		),

		array(
			'id'			=> 'sale_price',
			'type'			=> 'text',
			'title'			=> esc_html__('Sale Price', 'cc-travel'),
			//'dependency'	=> array('_price_type', '==', 'simple')
		),

		/*
		array(
			'title'		=> esc_html__('Adults', 'cc-travel'),
			'id'		=> '_adults',
			'type'      => 'fieldset',
			'dependency'	=> array('_price_type', '==', 'variable'),
			'fields'	=> array(
				array(
					'id'			=> '_adults_regular_price',
					'type'			=> 'text',
					'title'			=> esc_html__('Regular Price', 'cc-travel'),
				),

				array(
					'id'			=> '_adults_sale_price',
					'type'			=> 'text',
					'title'			=> esc_html__('Sale Price', 'cc-travel'),
				),
			)
		),

		array(
			'title'		=> esc_html__('Child', 'cc-travel'),
			'id'		=> '_child',
			'type'      => 'fieldset',
			'dependency'	=> array('_price_type', '==', 'variable'),
			'fields'	=> array(
				array(
					'id'			=> '_child_regular_price',
					'type'			=> 'text',
					'title'			=> esc_html__('Regular Price', 'cc-travel'),
				),

				array(
					'id'			=> '_child_sale_price',
					'type'			=> 'text',
					'title'			=> esc_html__('Sale Price', 'cc-travel'),
				),
			)
		),
		*/
	)
);

$custom_fields = cc_travel_get_option('_custom_fields');

if (!empty($custom_fields)) {
	$custom_fields_opt = array();

	foreach ($custom_fields as $field) {
		if ($field['type'] == 'text') {
			$type		= $field['type'];
			$title 		= (isset($field['title']) && $field['title'] != '') ? $field['title'] : '';
			$name 		= (isset($field['name']) && $field['name'] != '') ? sanitize_title($field['name']) : sanitize_title($title);

			$custom_fields_opt[] = array(
				'title'	=> $title,
				'type'	=> $type,
				'id'	=> $name
			);
		}
	}

	$tour_arr[] = array(
		'name'		=> '_custom_fields',
		'title'		=> esc_html__('Custom Fields', 'cc-travel'),
		'fields'	=> $custom_fields_opt
	);
}

$options[] = array(
	'id'		=> '_tour_details',
	'title'		=> esc_html__('Tour Details', 'cc-travel'),
	'post_type'	=> array('cc_tour'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'	=> $tour_arr
);

$destination_list 	= get_terms(array('taxonomy' => 'cc_destination'));
$destination_opt	= array();

if (!empty($destination_list)) {
	foreach ($destination_list as $destination) {
		$destination_opt[$destination->term_id] = $destination->name;
	}
}

$options[] = array(
	'id'		=> '_tour_itinerary',
	'title'		=> esc_html__('Tour Itinerary', 'cc-travel'),
	'post_type'	=> array('cc_tour'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'	=> array(
		array(
			'name' => '_list_itinerary',
			'fields' => array(
				array(
					'id' => '_itinerary',
					'type' => 'group',
					'button_title' => esc_html__('Add Itinerary', 'cc-travel'),
					'accordion_title' => esc_html__('New Itinerary', 'cc-travel'),
					'fields' => array(
						array(
							'id' => 'title',
							'type' => 'text',
							'title' => esc_html__('Title', 'cc-travel'),
						),

						array(
							'id' => 'desc',
							'type' => 'textarea',
							'title' => esc_html__('Itinerary Detail', 'cc-travel'),
						),

						array(
							'id'			=> 'meals',
							'class'			=> 'chosen',
							'type'			=> 'select',
							'title'			=> esc_html__('Meals', 'cc-travel'),
							'options'		=> array(
								'breakfast'	=> esc_html__('Breakfast', 'cc-travel'),
								'lunch'		=> esc_html__('Lunch', 'cc-travel'),
								'dinner'	=> esc_html__('Dinner', 'cc-travel'),
								'no-meal'	=> esc_html__('No meal', 'cc-travel')
							)
						),

						array(
							'id'			=> 'visited',
							'class'			=> 'chosen',
							'type'			=> 'select',
							'title'			=> esc_html__('Visited', 'cc-travel'),
							'options'		=> $destination_opt,
							'attributes'	=> array(
								'multiple'			=> 'multiple',
							),
						),

						/*
						array(
							'id'    => 'gallery',
							'type'  => 'gallery',
							'title' => esc_html__('Gallery', 'cc-travel'),
						),
						*/
					)
				)
			)
		)
	)
);

$options[] = array(
	'id'		=> '_tour_departure_date',
	'title'		=> esc_html__('Departure Date', 'cc-travel'),
	'post_type'	=> array('cc_tour'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'	=> array(
		array(
			'name' => '_departure_date',
			'fields' => array(
				array(
					'id'			=> '_departure_date_type',
					'class'			=> 'chosen',
					'type'			=> 'select',
					'title'			=> esc_html__('Type', 'cc-travel'),
					'options'		=> array(
						'full-day'		=> esc_html__('All Days', 'cc-travel'),
						'chosen-day'	=> esc_html__('Chosen Day', 'cc-travel'),
					)
				),

				array(
					'id' => '_list_departure_date',
					'type' => 'group',
					'button_title' => esc_html__('Add Date', 'cc-travel'),
					'accordion_title' => esc_html__('New Date', 'cc-travel'),
					'dependency'	=> array('_departure_date_type', '==', 'chosen-day'),
					'fields' => array(
						array(
							'title'		=> esc_html__('Start Date', 'cc-travel'),
							'id'		=> '_date_start',
							'type'      => 'datepicker',
						),

						array(
							'title'		=> esc_html__('End Date', 'cc-travel'),
							'id'		=> '_date_end',
							'type'      => 'datepicker',
						),
					)
				)
			)
		)
	)
);

// Media
$options[]  = array(
	'id'        => '_tour_media',
	'title'     => esc_html__('Media', 'cc-travel'),
	'post_type' => array('cc_tour'),
	'context'   => 'side',
	'priority'  => 'low',
	'sections'  => array(
		array(
			'name'			=> '_media',
			'fields'      	=> array(
				array(
					'title'		=> esc_html__('Banner', 'cc-travel'),
					'id'		=> '_banner',
					'type'      => 'image',
				),

				array(
					'title'		=> esc_html__('Gallery', 'cc-travel'),
					'id'		=> '_gallery',
					'type'      => 'gallery',
				),
			),
		),

	),
);

//Booking Info
$options[]  = array(
	'id'        => '_booking_info',
	'title'     => esc_html__('Booking Info', 'cc-travel'),
	'post_type' => array('cc_booking'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'  => array(
		array(
			'name'			=> '_info',
			'fields'      	=> array(
				array(
					'title'		=> esc_html__('Tour', 'cc-travel'),
					'id'		=> '_tour_id',
					'type'      => 'text',
				),

				array(
					'title'		=> esc_html__('Name', 'cc-travel'),
					'id'		=> '_name',
					'type'      => 'text',
				),

				array(
					'title'		=> esc_html__('Email', 'cc-travel'),
					'id'		=> '_email',
					'type'      => 'text',
				),

				array(
					'title'		=> esc_html__('Phone', 'cc-travel'),
					'id'		=> '_phone',
					'type'      => 'text',
				),

				array(
					'title'		=> esc_html__('Start Date', 'cc-travel'),
					'id'		=> '_start_date',
					'type'      => 'text',
				),

				array(
					'title'		=> esc_html__('Person', 'cc-travel'),
					'id'		=> '_person',
					'type'      => 'text',
				),

				array(
					'title'		=> esc_html__('Message', 'cc-travel'),
					'id'		=> '_message',
					'type'      => 'text',
				),

				array(
					'title'		=> esc_html__('Status', 'cc-travel'),
					'id'		=> '_status',
					'type'      => 'select',
					'class'		=> 'chosen',
					'options'	=> array(
						'pending'	=> esc_html__('Pending', 'cc-travel'),
						'finish'	=> esc_html__('Finish', 'cc-travel')
					)
				),
			),
		),

	),
);

$options[]  = array(
	'id'        => '_booking_admin_mes',
	'title'     => esc_html__('Admin Message', 'cc-travel'),
	'post_type' => array('cc_booking'),
	'context'   => 'side',
	'priority'  => 'default',
	'sections'  => array(
		array(
			'name'			=> '_info',
			'fields'      	=> array(
				array(
					'title'		=> esc_html__('Note', 'cc-travel'),
					'id'		=> '_note',
					'type'      => 'textarea',
				),
			),
		),

	),
);

CC_Travel_MetaBox::instance($options);