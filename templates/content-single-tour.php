<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 9/17/2019
 * Time: 2:28 PM
 */

global $post;

$tmpl = new CC_Travel_Template();

?>

<div id="tour-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="tour-header">
		<div class="tour-header-bg">
			<?php $tmpl->get_template_part('single/parts/banner', null, true); ?>
		</div>
		<div class="tour-header-opacity"></div>
		<div class="tour-header-content">
			<div class="tour-header-inner">
				<div class="container">
					<?php $tmpl->get_template_part('single/parts/price', null, true); ?>
					<?php $tmpl->get_template_part('single/parts/title', null, true); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="tour-content">
		<div class="tour-content-inner">
			<div class="container">
				<div class="cct-tabs">
					<div class="cct-tab-nav bs-tab-nav">
						<ul>
							<li class="active">
								<a href="#single-tour-info">
									<?php echo esc_html__('Infomation', 'cc-travel'); ?>
								</a>
							</li>
							<li>
								<a href="#single-tour-plan">
									<?php echo esc_html__('Tour Plan', 'cc-travel'); ?>
								</a>
							</li>
							<li>
								<a href="#single-tour-location">
									<?php echo esc_html__('Location', 'cc-travel'); ?>
								</a>
							</li>
							<li>
								<a href="#single-tour-gallery">
									<?php echo esc_html__('Gallery', 'cc-travel'); ?>
								</a>
							</li>
						</ul>
					</div>
					<div class="cct-tab-contents">
						<div class="cct-tab-content active" id="single-tour-info">
							<?php $tmpl->get_template_part('single/parts/content', null, true); ?>
							<?php $tmpl->get_template_part('single/parts/short-info', null, true); ?>
							<?php $tmpl->get_template_part('single/parts/full-info', null, true); ?>
							<?php $tmpl->get_template_part('single/parts/highlight', null, true); ?>
						</div>
						<div class="cct-tab-content" id="single-tour-plan">
							<?php $tmpl->get_template_part('single/parts/plan', null, true); ?>
						</div>
						<div class="cct-tab-content" id="single-tour-location">
							<?php $tmpl->get_template_part('single/parts/location', null, true); ?>
						</div>
						<div class="cct-tab-content" id="single-tour-gallery">
							<?php $tmpl->get_template_part('single/parts/gallery', null, true); ?>
						</div>
					</div>
				</div>
				<div class="book-now book-now-bottom">
					<a href="<?php echo esc_url(get_permalink(cc_travel_booking_page_id())); ?>?tour=<?php echo esc_attr($post->ID); ?>">
						<span>
							<?php echo esc_html__('Book Now', 'cc-travel'); ?>
						</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
