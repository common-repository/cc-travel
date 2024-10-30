<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 9/17/2019
 * Time: 3:16 PM
 */

global $post;

$_itinerary = get_post_meta($post->ID, '_tour_itinerary', true);
$plans		= cc_travel_get_value_in_array($_itinerary, '_itinerary');

if (empty($plans)) {
	return;
}

$i = 1;
?>
<div class="tour-plans">
	<?php foreach ($plans as $plan) : ?>
		<?php
			$title		= cc_travel_get_value_in_array($plan, 'title');
			$desc		= cc_travel_get_value_in_array($plan, 'desc');
			$meals		= cc_travel_get_value_in_array($plan, 'meals');
			$visited	= cc_travel_get_value_in_array($plan, 'visited');
			//$gallery	= cc_travel_get_value_in_array($plan, 'gallery');

			$visited_html = array();

			if (!empty($visited)) {
				foreach ($visited as $visit) {
					$term = get_term_by('id', $visit, 'cc_destination');

					$visited_html[] = '<a href="' . get_term_link($term->term_id, 'cc_destination') . '">' . $term->name . '</a>';
				}
			}
		?>

		<div class="tour-plan">
			<div class="tour-plan-route">
				<?php echo esc_attr($i); ?>
			</div>
			<div class="tour-plan-content">
				<h4 class="plan-title">
					<?php echo esc_attr($title); ?>
				</h4>
				<div class="plan-desc">
					<?php echo esc_attr($desc); ?>
				</div>
				<ul class="plan-info">
					<li>
						<label>
							<?php echo esc_html__('Meals', 'cc-travel'); ?>
						</label>
						<span>
							<?php echo esc_attr($meals); ?>
						</span>
					</li>
					<li>
						<label>
							<?php echo esc_html__('Visited', 'cc-travel'); ?>
						</label>
						<span>
							<?php echo implode('', $visited_html); ?>
						</span>
					</li>
				</ul>
			</div>
		</div>

		<?php $i++; ?>
	<?php endforeach; ?>
</div>
