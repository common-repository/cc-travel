<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/11/2019
 * Time: 10:31 PM
 */

class CC_Travel_Widget_Filter_By_Taxonomy extends CCFramework_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'cc-travel-widget cc-travel-widget-filter-by-taxonomy',
			'description' => esc_html__('Show Filter by Taxonomy into Widget.', 'cc-travel'),
		);

		$control_ops = array(
			'width'  => 400,
			'height' => 350,
		);

		parent::__construct('cc_travel_widget_filter_by_taxonomy', esc_html__('+ CC Travel - Filter By Taxonomy', 'cc-travel'), $widget_ops, $control_ops);
	}

	function get_options() {
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

		return array(
			array(
				'id'    => 'title',
				'type'  => 'text',
				'title' => esc_html__('Title', 'cc-travel'),
			),

			array(
				'id'		=> 'taxonomy',
				'type'		=> 'select',
				'class'		=> 'chosen',
				'title'		=> esc_html__('Select Taxonomy', 'cc-travel'),
				'options'	=> $tax_arr
			),

			array(
				'id'    => 'class',
				'type'  => 'text',
				'title' => esc_html__('Extra Class', 'cc-travel'),
			),
		);
	}

	function widget($args, $instance) {
		extract($args);

		$title		= empty($instance['title']) ? '' : $instance['title'];
		$class		= empty($instance['class']) ? '' : $instance['class'];
		$taxonomy	= empty($instance['taxonomy']) ? '' : $instance['taxonomy'];

		if (!cc_travel_is_archive_tour()) {
			return;
		}

		echo $before_widget;

		$html = array();

		$terms		= get_terms($taxonomy);
		$base_link	= cc_travel_get_current_page_archive_url();

		$html[] = '<div class="cct-filer-by-taxonomy ' . esc_attr($class) . '">';

		$html[] = $title ? '<h3 class="cctw-title">' . esc_attr($title) . '</h3>' : '';

		$html[] = '<div class="cctw-content">';

		if (!empty($terms)) {
			$html[] = '<ul class="terms-wrapper">';

			foreach ($terms as $term) {
				$link		= $base_link;

				if (isset($_GET['min_price'])) {
					$link = add_query_arg('min_price', sanitize_text_field($_GET['min_price']), $link);
				}

				if (isset($_GET['max_price'])) {
					$link = add_query_arg('max_price', sanitize_text_field($_GET['max_price']), $link);
				}

				if (isset($_GET['duration'])) {
					$link = add_query_arg('duration', sanitize_text_field($_GET['duration']), $link);
				}

				if (isset($_GET['start_date'])) {
					$link = add_query_arg('start_date', sanitize_text_field($_GET['start_date']), $link);
				}

				if (isset($_GET['end_date'])) {
					$link = add_query_arg('end_date', sanitize_text_field($_GET['end_date']), $link);
				}

				$current_filter = isset($_GET[$taxonomy]) ? explode(',', wp_unslash($_GET[$taxonomy])) : array();
				$current_filter = array_map('sanitize_title', $current_filter);

				if (!in_array($term->slug, $current_filter)) {
					$current_filter[] = $term->slug;
				}

				// Add current filters to URL.
				foreach ($current_filter as $key => $value) {
					// Exclude query arg for current term archive term.
					if ($value === $this->get_current_term_slug()) {
						unset($current_filter[$key]);
					}

					// Exclude self so filter can be unset on click.
					if (isset($_GET[$taxonomy]) && in_array($term->slug, explode(',', $_GET[$taxonomy])) && $value === $term->slug) {
						unset($current_filter[ $key ]);
					}
				}

				if (! empty($current_filter)) {
					asort($current_filter);
					$link = add_query_arg($taxonomy, implode(',', $current_filter), $link);
					$link = str_replace('%2C', ',', $link);
				}

				if (isset($_GET[ $taxonomy ]) && strpos($_GET[ $taxonomy ], $term->slug) !== false) {
					$chosen = 'chosen';
				} else {
					$chosen = '';
				}

				$html[] = '<li class="term-item">';
				$html[] = '<a href="' . $link . '" rel="nofollow" class="filter-item ' . $chosen . '">';
				$html[] = '<span class="attr-checkbox"></span>';
				$html[] = '<span class="term-label">' . $term->name . '</span>';
				$html[] = '</a>';
				$html[] = '</li>';
			}

			$html[] = '</ul>';
		}

		$html[] = '</div>';

		$html[] = '</div>';

		echo implode('', $html);

		echo $after_widget;
	}

	protected function get_current_term_slug() {
		return absint(is_tax() ? get_queried_object()->slug : 0);
	}
}

register_widget('CC_Travel_Widget_Filter_By_Taxonomy');
