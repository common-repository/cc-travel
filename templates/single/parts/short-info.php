<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 9/17/2019
 * Time: 2:51 PM
 */

global $post;

$details			= cc_travel_get_tour_details($post->ID);
$durations			= cc_travel_get_value_in_array($details, '_duration');
$days				= cc_travel_get_value_in_array($durations, '_duration_days');
$night				= cc_travel_get_value_in_array($durations, '_duration_night');

$age				= cc_travel_get_value_in_array($details, '_age');
$age_from			= cc_travel_get_value_in_array($age, '_age_from');
$age_to				= cc_travel_get_value_in_array($age, '_age_to');
?>

<div class="tour-short-info">
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

	<?php if ($age_from || $age_to) : ?>
		<div class="age">
			<i class="fa fa-group"></i>
			<?php if ($age_from) : ?>
				<span>
					<?php echo esc_attr($age_from); ?>
				</span>
			<?php endif; ?>

			<?php if ($age_to) : ?>
				<span class="space">-</span>
				<span>
					<?php echo esc_attr($age_to); ?>
				</span>
				<span><?php echo esc_html__('Age', 'cc-travel'); ?></span>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>
