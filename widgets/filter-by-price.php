<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/11/2019
 * Time: 10:31 PM
 */

class CC_Travel_Widget_Filter_By_Price extends CCFramework_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'cc-travel-widget cc-travel-widget-filter-by-price',
			'description' => esc_html__('Show Filter by Price into Widget.', 'cc-travel'),
		);

		$control_ops = array(
			'width'  => 400,
			'height' => 350,
		);

		parent::__construct('cc_travel_widget_filter_by_price', esc_html__('+ CC Travel - Filter By Price', 'cc-travel'), $widget_ops, $control_ops);
	}

	function get_options() {
		return array(
			array(
				'id'    => 'title',
				'type'  => 'text',
				'title' => esc_html__('Title', 'cc-travel'),
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

		$title	= empty($instance['title']) ? '' : $instance['title'];
		$class	= empty($instance['class']) ? '' : $instance['class'];

		if (!cc_travel_is_taxonomy_tour() && !cc_travel_is_archive_tour()) {
			return;
		}

		echo $before_widget;

		$html = array();

		$html[] = '<div class="cct-filer-by-price ' . esc_attr($class) . '">';

		$html[] = $title ? '<h3 class="cctw-title">' . esc_attr($title) . '</h3>' : '';

		$html[] = '<div class="cctw-content">';

		$min_price 	= isset($_GET['min_price']) ? sanitize_text_field($_GET['min_price']) : (int) cc_travel_get_min_value_custom_fields('price');
		$max_price	= isset($_GET['max_price']) ? sanitize_text_field($_GET['max_price']) : (int) cc_travel_get_max_value_custom_fields('price');

		$html[] = '<input type="hidden" class="cct-ranger-slide cctw-price" value="'. $min_price . ',' . $max_price . '" name="price[]"/>';
		$html[] = '</div>';

		$html[] = '</div>';

		echo implode('', $html);

		echo $after_widget;
	}
}

register_widget('CC_Travel_Widget_Filter_By_Price');
