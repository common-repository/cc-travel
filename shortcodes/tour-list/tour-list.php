<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/7/2019
 * Time: 11:05 AM
 */

if (!function_exists('tour_list')) {
	function tour_list($atts, $content = '', $key = '') {
		$default_atts = cc_travel_shortcode_default_atts();

		$shortcodes_atts = array_merge($default_atts, array(
			'pagination'	=> false,
		));

		extract(shortcode_atts($shortcodes_atts, $atts));

		//query now
		$params 	= array();
		$paged 		= (get_query_var('paged')) ? intval(get_query_var('paged')) : intval(get_query_var('page'));

		$params['post_type']		= 'cc_tour';
		$params['orderby']			= $orderby;
		$params['order']			= $order;
		$params['posts_per_page']	= $posts_per_page;
		$params['paged']			= $paged;
		$params['custom_fields']	= array();

		if (!empty($custom_fields)) {
			foreach ($custom_fields as $field) {
				$title 		= (isset($field['title']) && $field['title'] != '') ? $field['title'] : '';
				$name 		= (isset($field['name']) && $field['name'] != '') ? sanitize_title($field['name']) : sanitize_title($title);

				if ($$name != '') {
					$params['custom_fields'][] = array(
						'id'	=> $name,
						'value'	=> $$name
					);
				}
			}
		}

		if ($cc_destination != '') {
			$params['custom_fields'][] = array(
				'id'		=> 'cc_destination',
				'value'		=> $cc_destination
			);
		}

		if ($cc_travel_style != '') {
			$params['custom_fields'][] = array(
				'id'		=> 'cc_travel_style',
				'value'		=> $cc_travel_style
			);
		}

		$html 				= array();
		$tmpl 				= new CC_Travel_Template();
		$arpg 				= cc_travel_custom_query_tour($params);
		$tour_list_query 	= new WP_Query($arpg);

		$wrapper_class = array(
			'ccts-tour-list',
			'cct-list',
		);

		$html[] = '<div class="' . implode(' ', $wrapper_class) . '">';
		$html[] = '<div class="row">';

		if ($tour_list_query->have_posts()) :
			while ($tour_list_query->have_posts()) :
				$tour_list_query->the_post();

				global $post;

				ob_start();

				$tmpl->get_template_part('shortcodes/list', null, true);

				$html[] = ob_get_clean();
			endwhile;
		endif;

		$html[] = '</div>';
		$html[] = '</div>';

		$max = intval($movie_v2_grid_query->max_num_pages);

		if ($pagination == true && $max >= 2) {
			$html[] = '<div class="cct-pagination">';


			$html[] = '</div>';
		}

		wp_reset_postdata();

		return implode("\n", $html);
	}

	add_shortcode('tour_list', 'tour_list');
}