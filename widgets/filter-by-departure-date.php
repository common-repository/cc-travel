<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/11/2019
 * Time: 10:31 PM
 */

class CC_Travel_Widget_Filter_By_Departure_Date extends CCFramework_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'cc-travel-widget cc-travel-widget-filter-by-departure-date',
			'description' => esc_html__('Show Filter by Departure Date into Widget.', 'cc-travel'),
		);

		$control_ops = array(
			'width'  => 400,
			'height' => 350,
		);

		parent::__construct('cc_travel_widget_filter_by_departure_date', esc_html__('+ CC Travel - Filter By Departure Date', 'cc-travel'), $widget_ops, $control_ops);
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

		$html[] = '<div class="cct-filer-by-departure-date ' . esc_attr($class) . '">';

		$html[] = $title ? '<h3 class="cctw-title">' . esc_attr($title) . '</h3>' : '';

		$html[] = '<div class="cctw-content">';

		$start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
		$end_date	= isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';

		$html[] = '<input type="text" class="cct-datepicker cct-start-date" value="' . $start_date . '" data-name="start_date" placeholder="' . esc_html__('Start Date', 'cc-travel') . '" />';
		$html[] = '<input type="text" class="cct-datepicker cct-end-date" value="' . $end_date . '" data-name="end_date" placeholder="' . esc_html__('End Date', 'cc-travel') . '" />';
		$html[] = '</div>';

		$html[] = '</div>';

		echo implode('', $html);

		echo $after_widget;
	}
}

register_widget('CC_Travel_Widget_Filter_By_Departure_Date');
