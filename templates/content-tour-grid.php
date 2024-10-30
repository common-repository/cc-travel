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

$_taxonomy_column	= cc_travel_get_option('_taxonomy_column', 3);
$_taxonomy_column	= isset($_GET['column']) ? esc_attr($_GET['column']) : $_taxonomy_column;

$durations			= cc_travel_get_value_in_array($details, '_duration');
$days				= cc_travel_get_value_in_array($durations, '_duration_days');
$night				= cc_travel_get_value_in_array($durations, '_duration_night');

$post_class = array(
	'col-md-' . 12/$_taxonomy_column,
	'item-tour'
);

?>

<div class="<?php echo implode(' ', $post_class); ?>">
	<div class="item-tour-wrapper">
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
		<div class="item-data">
			<div class="item-destination">
				<i class="fa fa-location-arrow"></i>
				<?php echo cc_travel_template_terms_list($post->ID, 'cc_destination'); ?>
			</div>
			<h2 class="item-title">
				<a href="<?php echo esc_url(get_the_permalink()); ?>">
					<?php echo get_the_title(); ?>
				</a>
			</h2>
			<div class="item-actions">
				<?php if ($days || $night) : ?>
					<div class="ddn">
						<i class="fa fa-calendar-plus-o"></i>
						<?php if ($days) : ?>
							<span>
								<?php echo esc_attr($days) . esc_html__(' D', 'cc-travel'); ?>
							</span>
						<?php endif; ?>

						<?php if ($night) : ?>
							<span class="space">-</span>
							<span>
								<?php echo esc_attr($night) . esc_html__(' N', 'cc-travel'); ?>
							</span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<div class="price">
					<?php echo cc_travel_tour_price_html($post->ID); ?>
				</div>
			</div>
		</div>
	</div>
</div>
