<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 9/17/2019
 * Time: 2:34 PM
 */

global $post;

?>

<h3 class="tour-title">
	<a href="<?php echo get_the_permalink($post->ID); ?>">
		<?php echo get_the_title($post->ID); ?>
	</a>
</h3>
