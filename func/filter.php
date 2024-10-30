<?php
/**
 * Created by vagrant.
 * User: vagrant
 */


if (!defined('ABSPATH')) {
	return;
}

if (!function_exists('cc_travel_custom_template')) {
	function cc_travel_custom_template($template) {
		global $post;

		$tmpl 		= new CC_Travel_Template();

		if (cc_travel_is_taxonomy_tour() || cc_travel_is_archive_tour()) {
			$template = $tmpl->get_template_part('archive-tour', null, false);
		}

		if (is_tax('cc_destination')) {
			$template = $tmpl->get_template_part('destination', null, false);
		}

		if (is_singular('cc_tour')) {
			$template = $tmpl->get_template_part('single-tour', null, false);
		}

		if ($post->ID == cc_travel_booking_page_id()) {
			$template = $tmpl->get_template_part('booking', null, false);
		}

		return $template;
	}

	add_filter('template_include', 'cc_travel_custom_template');
}
