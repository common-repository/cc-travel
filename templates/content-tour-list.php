<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/4/2019
 * Time: 10:20 PM
 */

if (!defined('ABSPATH')) {
	return;
}

global $post;

$image_size			= 'cc-travel-470-290-archive-tour';
$details			= cc_travel_get_tour_details($post->ID);
$durations			= cc_travel_get_value_in_array($details, '_duration');
$days				= cc_travel_get_value_in_array($durations, '_duration_days');
$night				= cc_travel_get_value_in_array($durations, '_duration_night');

$post_class = array(
	'item-tour',
	'col-md-12'
);

?>

<div class="<?php echo implode(' ', $post_class); ?>">
	<div class="item-tour-wrapper">
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="item-thumbnail">
					<a href="<?php echo esc_url(get_the_permalink()); ?>" class="cct-image">
						<?php echo get_the_post_thumbnail($post, $image_size); ?>
					</a>
					<div class="travel-style">
						<?php
							$travel_style_list	= wp_get_post_terms($post->ID, 'cc_travel_style');
							$first_travel_style	= !empty($travel_style_list) ? reset($travel_style_list) : '';

							if ($first_travel_style) {
								echo '<a href="' . get_term_link($first_travel_style->slug, 'cc_travel_style') . '">' . $first_travel_style->name . '</a>';
							}
						?>
					</div>
				</div>
			</div>

			<div class="col-md-8 col-sm-8 col-xs-12">
				<div class="item-data">
					<h2 class="item-title">
						<a href="<?php echo esc_url(get_the_permalink()); ?>">
							<?php echo get_the_title(); ?>
						</a>
					</h2>
					<div class="item-destination">
						<i class="fa fa-location-arrow"></i>
						<?php echo cc_travel_template_terms_list($post->ID, 'cc_destination'); ?>
					</div>

					<?php if ($days || $night) : ?>
						<div class="ddn">
							<i class="fa fa-calendar-plus-o"></i>
							<?php if ($days) : ?>
								<span>
									<?php echo esc_attr($days) . esc_html__(' Days', 'cc-travel'); ?>
								</span>
							<?php endif; ?>

							<?php if ($night) : ?>
								<span class="space">-</span>
								<span>
									<?php echo esc_attr($night) . esc_html__(' Nights', 'cc-travel'); ?>
								</span>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<div class="item-desc">
						<?php echo cc_travel_get_value_in_array($details, '_short_desc'); ?>
					</div>
					<div class="price">
						<?php echo cc_travel_tour_price_html($post->ID); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
