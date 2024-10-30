<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/13/2019
 * Time: 9:17 AM
 */

/*
 * Get Tour Details
 */
if (! function_exists('cc_travel_get_tour_details')) {
	function cc_travel_get_tour_details($tour_id) {
		$details = get_post_meta($tour_id, '_tour_details', true);

		return $details;
	}
}

/*
 * Price with currency
 */
if (!function_exists('cc_travel_render_price_with_currency')) {
	function cc_travel_render_price_with_currency($price) {
		$_currency_symbol	= cc_travel_get_option('_currency_symbol', '$');
		$_currency_position	= cc_travel_get_option('_currency_position', 'left');

		if ($_currency_position == 'left') {
			$result = $_currency_symbol . $price;
		} else {
			$result = $price . $_currency_symbol;
		}

		return $result;
	}
}

/*
 * Custom tour query
 */
if (! function_exists('cc_travel_custom_query_tour')) {
	function cc_travel_custom_query_tour($params) {
		$arpg			= array();

		//basic params
		$post_type		= isset($params['post_type'])		? $params['post_type']		: 'cc_tour';
		$post_orderby	= isset($params['orderby']) 		? $params['orderby'] 		: '';
		$post_order		= isset($params['order']) 			? $params['order'] 			: '';
		$posts_per_page	= isset($params['posts_per_page'])	? $params['posts_per_page']	: '';
		$paged			= isset($params['paged'])			? $params['paged']			: '';

		//movie params
		$sortby			= isset($params['sortby'])			? $params['sortby']			: '';

		//custom fields params
		$custom_fields	= isset($params['custom_fields'])	? $params['custom_fields']	: array();

		/*
		 * Begin
		 */

		//basic
		$arpg['post_type']		= $post_type;
		$arpg['order'] 			= $post_order;
		$arpg['posts_per_page'] = $posts_per_page;
		$arpg['paged']			= $paged;
		$arpg['orderby']		= $sortby;

		//custom fields params
		if (!empty($custom_fields)) {
			foreach ($custom_fields as $field) {
				$arpg['tax_query'][] = array(
					'taxonomy' => $field['id'],
					'field' => 'term_id',
					'terms' => explode(',', $field['value'])
				);
			}
		}

		return $arpg;
	}
}

/*
 * Get max value from db
 */
if (!function_exists('cc_travel_get_max_value_from_db')) {
	function cc_travel_get_max_value_from_db($meta) {
		global $wpdb;

		$query = $wpdb->prepare("SELECT max(cast(meta_value as UNSIGNED)) FROM {$wpdb->postmeta} WHERE meta_key='%s'", $meta);

    	return $wpdb->get_var($query);
	}
}

/*
 * Get min value from db
 */
if (!function_exists('cc_travel_get_min_value_from_db')) {
	function cc_travel_get_min_value_from_db($meta) {
		global $wpdb;

		$query = $wpdb->prepare("SELECT min(cast(meta_value as UNSIGNED)) FROM {$wpdb->postmeta} WHERE meta_key='%s'", $meta);

    	return $wpdb->get_var($query);
	}
}

/*
 * Get min value in all tour
 */
if (!function_exists('cc_travel_get_min_value_custom_fields')) {
	function cc_travel_get_min_value_custom_fields($type) {
		if ($type == 'price') {
			$arr = array(
				cc_travel_get_min_value_from_db('regular_price'),
				cc_travel_get_min_value_from_db('sale_price'),
			);

			if (!empty($arr)) {
				$arr = array_unique($arr);
				$arr = array_diff($arr, [0]);

				return min($arr);
			} else {
				return false;
			}
		} else if ($type = 'duration') {
			return cc_travel_get_min_value_from_db('_duration_days');
		}
	}
}

/*
 * Get max value in all tour
 */
if (!function_exists('cc_travel_get_max_value_custom_fields')) {
	function cc_travel_get_max_value_custom_fields($type) {
		if ($type == 'price') {
			$arr = array(
				cc_travel_get_max_value_from_db('regular_price'),
				cc_travel_get_max_value_from_db('sale_price'),
			);
			if (!empty($arr)) {
				$arr = array_unique($arr);
				$arr = array_diff($arr, [0]);

				return max($arr);
			} else {
				return false;
			}
		} else if ($type = 'duration') {
			return cc_travel_get_max_value_from_db('_duration_days');
		}
	}
}

/*
 * Query filter by pre get posts
 */
if (!function_exists('cc_travel_custom_query_by_filter_pre_get_posts')) {
	function cc_travel_custom_query_by_filter_pre_get_posts($query) {
		if (!is_admin() && $query->is_main_query() && (cc_travel_is_taxonomy_tour() || cc_travel_is_archive_tour())) {
			//post per page
			$query->set('posts_per_page', cc_travel_get_option('_taxonomy_post_per_page'));

			$meta_query = $query->get('meta_query');
			$meta_query = ($meta_query == '') ? array() : $meta_query;

			if (isset($_GET['min_price'])) {
				$meta_query[] = array(
					'relation'	=> 'OR',
					array(
						'key'		=> 'regular_price',
						'value'		=> wp_unslash($_GET['min_price']),
						'compare'	=> '>='
					),
					array(
						'key'		=> 'sale_price',
						'value'		=> wp_unslash($_GET['min_price']),
						'compare'	=> '>='
					),
				);
			}

			if (isset($_GET['max_price'])) {
				$meta_query[] = array(
					'relation'	=> 'OR',
					array(
						'key'		=> 'regular_price',
						'value'		=> wp_unslash($_GET['max_price']),
						'compare'	=> '<='
					),
					array(
						'key'		=> 'sale_price',
						'value'		=> wp_unslash($_GET['max_price']),
						'compare'	=> '<='
					),
				);
			}

			if (isset($_GET['duration'])) {
				$arr = explode(',', wp_unslash($_GET['duration']));

				$meta_query[] = array(
					'relation'	=> 'AND',
					array(
						'key'		=> '_duration_days',
						'value'		=> $arr[0],
						'compare'	=> '>='
					),
					array(
						'key'		=> '_duration_days',
						'value'		=> $arr[1],
						'compare'	=> '<='
					),
				);
			}

			if (isset($_GET['start_date'])) {
				$meta_query[] = array(
					array(
						'key'	=> '_date_start',
						'value'	=> wp_unslash($_GET['start_date']),
						'compare'	=> '>='
					)
				);
			}

			if (isset($_GET['end_date'])) {
				$meta_query[] = array(
					array(
						'key'	=> '_date_end',
						'value'	=> wp_unslash($_GET['end_date']),
						'compare'	=> '<='
					)
				);
			}

			$query->set('meta_query', $meta_query);
		}
	}

	add_action('pre_get_posts', 'cc_travel_custom_query_by_filter_pre_get_posts');
}

function cc_travel_get_current_page_archive_url() {
	if (is_post_type_archive('cc_tour')) {
		$link = get_permalink(cc_travel_archive_tour_page_id());
	} else {
		$queried_object = get_queried_object();
		$link           = get_term_link($queried_object->slug, $queried_object->taxonomy);
	}

	if (isset($_GET['min_price'])) {
		$link = add_query_arg('min_price', wp_unslash($_GET['min_price']), $link);
	}

	if (isset($_GET['max_price'])) {
		$link = add_query_arg('max_price', wp_unslash($_GET['max_price']), $link);
	}

	if (isset($_GET['duration'])) {
		$link = add_query_arg('duration', wp_unslash($_GET['duration']), $link);
	}

	if (isset($_GET['start_date'])) {
		$link = add_query_arg('start_date', wp_unslash($_GET['start_date']), $link);
	}

	if (isset($_GET['end_date'])) {
		$link = add_query_arg('end_date', wp_unslash($_GET['end_date']), $link);
	}

	/**
	 * Search Arg.
	 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
	 */
	if (get_search_query()) {
		$link = add_query_arg('s', rawurlencode(htmlspecialchars_decode(get_search_query())), $link);
	}

	// All current filters.
	$tax_arr = array(
		'cc_destination'	=> esc_html__('Destination', 'cc-travel'),
		'cc_travel_style'	=> esc_html__('Travel Style', 'cc-travel'),
	);

	$custom_fields = cc_travel_get_option('_custom_taxonomy');

	if (!empty($custom_fields)) {
		foreach ($custom_fields as $field) {
			$title = (isset($field['title']) && $field['title'] != '') ? $field['title'] : '';
			$name = (isset($field['name']) && $field['name'] != '') ? sanitize_title($field['name']) : sanitize_title($title);

			$tax_arr[$name]	= $title;
		}
	}

	if ($tax_arr) {
		foreach ($tax_arr as $name => $data) {
			if (! empty($_GET[$name])) {
				$link = add_query_arg($name, $_GET[$name], $link);
			}
		}
	}

	return $link;
}

if (!function_exists('cc_travel_is_archive_tour')) {
	function cc_travel_is_archive_tour() {
		if (is_post_type_archive('cc_tour')) {
			return true;
		} else {
			return false;
		}
	}
}

if (!function_exists('cc_travel_is_taxonomy_tour')) {
	function cc_travel_is_taxonomy_tour() {
		$tax_arr = array(
			'cc_travel_style'	=> esc_html__('Travel Style', 'cc-travel'),
		);

		$custom_fields 	= cc_travel_get_option('_custom_taxonomy');
		$check			= true;

		if (!empty($custom_fields)) {
			foreach ($custom_fields as $field) {
				$title	= (isset($field['title']) && $field['title'] != '') ? $field['title'] : '';
				$name	= (isset($field['name']) && $field['name'] != '') ? sanitize_title($field['name']) : sanitize_title($title);

				$tax_arr[$name]	= $title;
			}
		}

		foreach ($tax_arr as $slug => $name) {
			if (is_tax($slug)) {
				return true;
			} else {
				$check = false;
			}
		}

		return $check;
	}
}