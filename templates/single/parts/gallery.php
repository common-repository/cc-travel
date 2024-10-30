<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 9/17/2019
 * Time: 3:33 PM
 */

global $post;

$_tour_media	= get_post_meta($post->ID, '_tour_media', true);
$gallery		= cc_travel_get_value_in_array($_tour_media, '_gallery');
$gallery		= explode(',', $gallery);

?>

<div class="tour-gallery">
	<div class="tour-gallery-masonry cct-masonry" data-column="3">
		<?php if (!empty($gallery)) : ?>
			<?php foreach ($gallery as $image) : ?>
				<?php $src = wp_get_attachment_image_url($image, 'full'); ?>
				<div class="item-image cct-column col-md-4">
					<a href="<?php echo esc_url($src); ?>" class="cct-fancybox" data-fancybox="images">
						<img src="<?php echo esc_url($src); ?>" />
					</a>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>
