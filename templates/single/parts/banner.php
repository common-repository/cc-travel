<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 9/17/2019
 * Time: 2:25 PM
 */

global $post;

$_tour_media		= get_post_meta($post->ID, '_tour_media', true);
$_banner			= cc_travel_get_value_in_array($_tour_media, '_banner');

if ($_banner) {
	echo wp_get_attachment_image($_banner, 'full');
} else {
	echo '<div class="no-banner"></div>';
}
