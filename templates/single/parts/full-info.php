<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 9/17/2019
 * Time: 2:51 PM
 */

global $post;

$details			= cc_travel_get_tour_details($post->ID);

$_tour_dd	= get_post_meta($post->ID, '_tour_departure_date', true);
$_date_type	= cc_travel_get_value_in_array($_tour_dd, '_departure_date_type');
$list_date	= cc_travel_get_value_in_array($_tour_dd, '_list_departure_date');

$custom_taxonomy	= cc_travel_get_option('_custom_taxonomy');
$custom_fields		= cc_travel_get_option('_custom_fields');
?>

<div class="tour-full-info">
	<ul>
		<li>
			<label><?php echo esc_html__('Destination', 'cc-travel'); ?></label>
			<?php echo cc_travel_template_terms_list($post->ID, 'cc_destination'); ?>
		</li>
		<li>
			<label><?php echo esc_html__('Travel Style', 'cc-travel'); ?></label>
			<?php echo cc_travel_template_terms_list($post->ID, 'cc_travel_style'); ?>
		</li>
		<li>
			<label><?php echo esc_html__('Departure Date', 'cc-travel'); ?></label>
			<?php if ($_date_type == 'full-day') : ?>
				<span><?php echo esc_html__('All Day', 'cc-travel'); ?></span>
			<?php elseif ($_date_type == 'chosen-day') : ?>
				<?php if (!empty($list_date)) : ?>
					<div class="start_date">
						<?php foreach ($list_date as $date) : ?>
							<span>
								<?php echo esc_attr($date['_date_start']); ?>,
							</span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</li>

		<?php if (!empty($custom_taxonomy)) : ?>
			<?php foreach ($custom_taxonomy as $field) : ?>
				<?php
					$title 		= (isset($field['title']) && $field['title'] != '') ? $field['title'] : '';
					$name 		= (isset($field['name']) && $field['name'] != '') ? sanitize_title($field['name']) : sanitize_title($title);
					$slug		= (isset($field['slug']) && $field['slug'] != '') ? sanitize_title($field['slug']) : $name;
				?>
				<li>
					<label><?php echo esc_attr($title); ?></label>
					<span><?php echo cc_travel_template_terms_list($post->ID, $slug); ?></span>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php if (!empty($custom_fields)) : ?>
			<?php foreach ($custom_fields as $field) : ?>
				<?php
					$title 		= (isset($field['title']) && $field['title'] != '') ? $field['title'] : '';
					$name 		= (isset($field['name']) && $field['name'] != '') ? sanitize_title($field['name']) : sanitize_title($title);
				?>

				<?php if ($field['type'] == 'text') : ?>
				<li>
					<label><?php echo esc_attr($title); ?></label>
					<span><?php echo esc_attr(cc_travel_get_value_in_array($details, $name)); ?></span>
				</li>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
</div>