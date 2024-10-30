<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 9/17/2019
 * Time: 9:48 PM
 */

$details	= cc_travel_get_tour_details($post->ID);
$highlights	= cc_travel_get_value_in_array($details, 'highlights');

$data_slick = array(
	'"adaptiveHeight": false',
	'"slidesToShow": 4',
	'"slidesToScroll": 1',
	'"infinite": true',
	'"autoplay": false',
	'"arrows": false',
	'"dots": true',
	'"lazyLoad": "progressive"',
	'"responsive": [{ "breakpoint": 992, "settings": {"slidesToShow": 4} },{ "breakpoint": 768, "settings": {"slidesToShow": 3} },{ "breakpoint": 576, "settings": {"slidesToShow": 2} } ]',
);

$slick_att = array("data-slick='{" . implode(', ', $data_slick) . "}'");
?>

<div class="tour-highlights">
	<?php if (!empty($highlights)) : ?>
		<div class="highlights-title">
			<?php echo esc_html__('Highlights', 'cc-travel'); ?>
		</div>
		<div class="cct-slick" <?php echo implode(' ', $slick_att); ?>>
			<?php foreach ($highlights as $highlight) : ?>
				<?php
					$image 	= cc_travel_get_value_in_array($highlight, 'image');
					$title	= cc_travel_get_value_in_array($highlight, 'title');
					$desc 	= cc_travel_get_value_in_array($highlight, 'desc');
				?>
				<div class="item-highlight">
					<div class="item-image">
						<a href="<?php echo wp_get_attachment_image_url($image, 'full'); ?>" class="cct-fancybox">
							<img src="<?php echo wp_get_attachment_image_url($image, 'cc-travel-470-290-archive-tour'); ?>" />
						</a>
					</div>
					<div class="item-content">
						<div class="item-title">
							<span><?php echo esc_attr($title); ?></span>
						</div>
						<div class="item-desc">
							<span><?php echo esc_attr($desc); ?></span>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>
</div>
