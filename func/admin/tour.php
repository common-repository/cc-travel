<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/13/2019
 * Time: 9:21 AM
 */

/*
 * Custom Tour States
 */
if (!function_exists('cc_travel_custom_page_states')) {
	function cc_travel_custom_page_states($states, $post) {
		if (cc_travel_archive_tour_page_id() == $post->ID) {
			$states['cc_travel_page_for_tours'] = esc_html__('Tours Page', 'cc-travel');
		}

		if (cc_travel_booking_page_id() == $post->ID) {
			$states['cc_travel_booking_page'] = esc_html__('Booking Page', 'cc-travel');
		}

		return $states;
	}

	add_filter('display_post_states', 'cc_travel_custom_page_states', 10, 2);
}

if (!function_exists('cc_travel_disable_booking_title')) {
	function cc_travel_disable_booking_title() {
		?>
		<script type="text/javascript">
			if(jQuery('#post_type').val() === 'cc_booking'){
				jQuery('#title').prop('disabled', true);
				jQuery('#cc-tab-_info input').prop('disabled', true);
			}
		</script>
		<?php
	}

	add_action( 'admin_footer-post.php', 'cc_travel_disable_booking_title' );
	//add_action('admin_footer-post.php'. 'cc_travel_disable_booking_title');
}

