<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/19/2019
 * Time: 4:01 PM
 */

get_header();

?>
<div class="cct-booking">
	<div class="container">
	<?php

	if (isset($_GET['tour'])) :
		$tour_id 	= esc_attr($_GET['tour']);
		$details	= cc_travel_get_tour_details($tour_id);
		$durations	= cc_travel_get_value_in_array($details, '_duration');
		$days		= cc_travel_get_value_in_array($durations, '_duration_days');
		$night		= cc_travel_get_value_in_array($durations, '_duration_night');

		$age		= cc_travel_get_value_in_array($details, '_age');
		$age_from	= cc_travel_get_value_in_array($age, '_age_from');
		$age_to		= cc_travel_get_value_in_array($age, '_age_to');

		$regular_price 	= cc_travel_get_value_in_array($details, 'regular_price');
		$sale_price		= cc_travel_get_value_in_array($details, 'sale_price');
		$price			= ($sale_price) ? $sale_price : $regular_price;
	?>
		<div class="row">
			<div class="col-md-6">
				<div class="tour-info">
					<h3 class="booking-title">
						<?php echo esc_html__('Tour Info', 'cc-travel'); ?>
					</h3>
					<div class="tour-info-content">
						<div class="tour-image">
							<?php echo get_the_post_thumbnail($tour_id); ?>
						</div>
						<h4>
							<a href="<?php echo get_permalink($tour_id); ?>">
								<?php echo get_the_title($tour_id); ?>
							</a>
						</h4>
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
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="booking-info">
					<h3 class="booking-title">
						<?php echo esc_html__('Booking Info', 'cc-travel'); ?>
					</h3>
					<form method="post" class="cct-booking-form">
						<div class="input-group">
							<label>
								<?php echo esc_html__('Name:', 'cc-travel'); ?>
							</label>
							<input type="text" name="name" />
						</div>

						<div class="input-group">
							<label>
								<?php echo esc_html__('Email:', 'cc-travel'); ?>
							</label>
							<input type="text" name="email" />
						</div>

						<div class="input-group">
							<label>
								<?php echo esc_html__('Phone:', 'cc-travel'); ?>
							</label>
							<input type="text" name="phone" />
						</div>

						<div class="input-group">
							<label>
								<?php echo esc_html__('Message:', 'cc-travel'); ?>
							</label>
							<textarea name="message"></textarea>
						</div>

						<div class="input-group">
							<label>
								<?php echo esc_html__('Chosen Start Date', 'cc-travel'); ?>
							</label>
							<?php
							$_tour_dd	= get_post_meta($tour_id, '_tour_departure_date', true);
							$_date_type	= cc_travel_get_value_in_array($_tour_dd, '_departure_date_type');
							$list_date	= cc_travel_get_value_in_array($_tour_dd, '_list_departure_date');

							if ($_date_type == 'full-day') : ?>
								<input type="text" name="start_date" class="cc-datepicker"/>
							<?php elseif ($_date_type == 'chosen-day') : ?>
								<?php if (!empty($list_date)) : ?>
									<select name="start_date" class="required">
										<option value=""><?php echo esc_html__('Please chosen date', 'cc-travel'); ?></option>
										<?php foreach ($list_date as $date) : ?>
											<option value="<?php echo esc_attr($date['_date_start']); ?>">
												<?php echo esc_attr($date['_date_start']); ?>
											</option>
										<?php endforeach; ?>
									</select>
								<?php endif; ?>
							<?php endif; ?>
						</div>

						<div class="input-group">
							<label>
								<?php echo esc_html__('Number Person', 'cc-travel'); ?>
							</label>
							<select name="person" class="required change-person" data-n-price="<?php echo esc_attr($regular_price); ?>" data-s-price="<?php echo esc_attr($sale_price); ?>">
								<?php for ($i = 1; $i < 10; $i++) : ?>
									<option value="<?php echo esc_attr($i); ?>">
										<?php echo esc_attr($i); ?>
									</option>
								<?php endfor; ?>
							</select>
						</div>
						<div class="input-group price">
							<label>
								<?php echo esc_html__('Price/person:', 'cc-travel'); ?>
							</label>
							<span>
								<?php echo cc_travel_tour_price_html($tour_id); ?>
							</span>
						</div>
						<div class="input-group total price">
							<label>
								<?php echo esc_html__('Total:', 'cc-travel'); ?>
							</label>
							<span>
								<?php echo cc_travel_tour_price_html($tour_id); ?>
							</span>
						</div>

						<div class="input-group">
							<button type="button" class="cct-booking-submit">
								<?php echo esc_html__('Submit', 'cc-travel'); ?>
							</button>
						</div>
						<input type="hidden" name="tour_id" value="<?php echo esc_attr($tour_id); ?>" />
					</form>
				</div>
			</div>
		</div>
	<?php
	else :
		?>
			<p>
				<?php echo esc_html__('Booking is not available because tour is empty', 'cc-travel'); ?>
			</p>
		<?php
	endif;

	?>
	</div>
</div>

<?php
get_footer();