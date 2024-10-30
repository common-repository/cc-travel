<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 9/17/2019
 * Time: 2:36 PM
 */

global $post;

?>

<div class="price">
	<?php echo cc_travel_tour_price_html($post->ID); ?>
	<span class="text"><?php echo esc_html__('/ per person', 'cc-travel'); ?></span>
</div>
