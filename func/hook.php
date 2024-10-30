<?php
/**
 * Created by vagrant.
 * User: vagrant
 */


if (!defined('ABSPATH')) {
	return;
}

/*
 * Create Page Archive Tour
 */
if (!function_exists('cc_travel_archive_tour_page_id')) {
	function cc_travel_archive_tour_page_id() {
		$current_id = cc_travel_get_option('_page_archive_tour');
		$title		= 'Tours';

		if ($current_id || get_page_by_title($title)) {
			return $current_id;
		}

		if (get_page_by_title($title)) {
			return get_page_by_title($title)->ID;
		}

		$page_id = wp_insert_post(array(
			'post_title'		=> $title,
			'post_type'			=> 'page',
			'post_name'			=> 'tours',
			'comment_status'	=> 'closed',
			'ping_status'		=> 'closed',
			'post_content'		=> '',
			'post_status'		=> 'publish',
			'post_author'		=> 1,
			'menu_order'		=> 0
		));

		return $page_id;
	}

	add_action('init', 'cc_travel_archive_tour_page_id');
}

/*
 * Create Page Archive Tour
 */
if (!function_exists('cc_travel_booking_page_id')) {
	function cc_travel_booking_page_id() {
		$current_id = cc_travel_get_option('_page_booking');
		$title		= 'Booking';

		if ($current_id || get_page_by_title($title)) {
			return $current_id;
		}

		if (get_page_by_title($title)) {
			return get_page_by_title($title)->ID;
		}

		$page_id = wp_insert_post(array(
			'post_title'		=> $title,
			'post_type'			=> 'page',
			'post_name'			=> 'booking',
			'comment_status'	=> 'closed',
			'ping_status'		=> 'closed',
			'post_content'		=> '',
			'post_status'		=> 'publish',
			'post_author'		=> 1,
			'menu_order'		=> 0
		));

		return $page_id;
	}

	add_action('init', 'cc_travel_booking_page_id');
}

if (!function_exists('cc_travel_ajax_booking')) {
	function cc_travel_ajax_booking() {
		$name		= sanitize_text_field($_GET['name']);
		$email		= sanitize_email($_GET['email']);
		$phone		= sanitize_text_field($_GET['phone']);
		$start_date	= sanitize_text_field($_GET['start_date']);
		$tour_id	= sanitize_key($_GET['tour_id']);
		$message	= sanitize_text_field($_GET['message']);
		$person		= sanitize_key($_GET['person']);

		$new_booking = array(
			'post_title'	=> '#' . rand(10,10000) . ' ' . $name,
			'post_status'	=> 'publish',
			'post_type'		=> 'cc_booking',
			'guid'			=> 'amy_uid_0_' . uniqid(),
		);

		$booking_id = wp_insert_post($new_booking);

		$booking_details = array(
			'_name'			=> $name,
			'_email'		=> $email,
			'_phone'		=> $phone,
			'_start_date'	=> $start_date,
			'_tour_id'		=> $tour_id,
			'_message'		=> $message,
			'_person'		=> $person,
			'_status'		=> 'pending'
		);

		add_post_meta($booking_id, '_booking_info', $booking_details);

		$html = '<p class="thankyou">' . esc_html__('Thank you for booking. We will contact us as soon as possible', 'cc-travel') . '</p>';

		echo json_encode($html);
		exit;
	}

	add_action('wp_ajax_cc_travel_ajax_booking', 'cc_travel_ajax_booking', 99);
	add_action('wp_ajax_nopriv_cc_travel_ajax_booking', 'cc_travel_ajax_booking', 99);
}

if (!function_exists('cc_travel_ajax_general_price')) {
	function cc_travel_ajax_general_price() {
		$person 	= sanitize_key($_POST['person']);
		$n_price 	= sanitize_text_field($_POST['n_price']);
		$s_price 	= sanitize_text_field($_POST['s_price']);

		$html = array();

		$no_sale_class	= ($s_price) ? '' : 'no-sale';

		$html[] = $n_price ? '<span class="regular-price cct-amount ' . $no_sale_class . '">' . cc_travel_render_price_with_currency($n_price * $person) . '</span>' : '';
		$html[] = $s_price ? '<span class="sale-price cct-amount">' . cc_travel_render_price_with_currency($s_price * $person) . '</span>' : '';


		echo json_encode(implode('', $html));
		exit;
	}

	add_action('wp_ajax_cc_travel_ajax_general_price', 'cc_travel_ajax_general_price', 99);
	add_action('wp_ajax_nopriv_cc_travel_ajax_general_price', 'cc_travel_ajax_general_price', 99);
}