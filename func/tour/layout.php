<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/6/2019
 * Time: 10:04 PM
 */

/*
 * Template taxonomy
 */
if (! function_exists('cc_travel_template_terms_list')) {
	function cc_travel_template_terms_list($tour_id, $taxonomy) {
		$terms		= wp_get_post_terms($tour_id, $taxonomy);

		$html 		= '';
		$numItems 	= count($terms);
		$i 			= 0;

		if (!empty($terms)) {
			foreach ($terms as $term) {
				if (++$i === $numItems) {
					$space = '';
				} else {
					$space = ', ';
				}

				$html .= '<a href="' . get_term_link($term->slug, $taxonomy) . '">';
				$html .= $term->name;
				$html .= '</a>';
				$html .= $space;
			}
		}

		return $html;
	}
}

/*
 * Price Tour Html
 */
if (!function_exists('cc_travel_tour_price_html')) {
	function cc_travel_tour_price_html($tour_id) {
		$details 	= cc_travel_get_tour_details($tour_id);
		//$price_type	= cc_travel_get_value_in_array($details, '_price_type');

		$html = array();

		//if ($price_type == 'simple') {
			$regular_price 	= cc_travel_get_value_in_array($details, 'regular_price');
			$sale_price		= cc_travel_get_value_in_array($details, 'sale_price');

			$no_sale_class	= ($sale_price) ? '' : 'no-sale';

			$html[] = $regular_price ? '<span class="regular-price cct-amount ' . $no_sale_class . '">' . cc_travel_render_price_with_currency($regular_price) . '</span>' : '';
			$html[] = $sale_price ? '<span class="sale-price cct-amount">' . cc_travel_render_price_with_currency($sale_price) . '</span>' : '';
		//}

		return implode('', $html);
	}
}