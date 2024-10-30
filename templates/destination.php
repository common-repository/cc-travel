<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/4/2019
 * Time: 10:14 PM
 */
if (!defined('ABSPATH')) {
	return;
}

get_header();

$_taxonomy_layout			= cc_travel_get_option('_taxonomy_layout', 'grid');
$_taxonomy_post_per_page	= cc_travel_get_option('_taxonomy_post_per_page');

$_taxonomy_sidebar			= cc_travel_get_option('_taxonomy_sidebar', 'full');
$_taxonomy_widget			= cc_travel_get_option('_taxonomy_widget');

$queried_object = get_queried_object();
$term_id 		= $queried_object->term_id;
$term 			= get_term($term_id);
$term_data 		= get_term_meta($term_id, '_destination_options', true);

$feature_img	= cc_travel_get_value_in_array($term_data, 'featured_image');
$gallery		= cc_travel_get_value_in_array($term_data, 'gallery');
$gallery		= explode(',', $gallery);
$infomation		= cc_travel_get_value_in_array($term_data, 'infomation');
$banner			= cc_travel_get_value_in_array($term_data, 'banner');

$wrapper_class = array(
	'cct-wrapper-tour',
	'cct-' . $_taxonomy_layout
);

if ($_taxonomy_sidebar != 'full' && is_active_sidebar($_taxonomy_widget)) {
	$check_sidebar	= 'has-sidebar row ' . $_taxonomy_sidebar;
	$inner_content	= 'cct-inner-content col-md-9';
} else {
	$check_sidebar 	= 'no-sidebar row';
	$inner_content	= 'cct-inner-content col-md-12';
}

?>

<div class="cct-destination">
	<div class="destination-header">
		<div class="destination-header-bg">
			<?php echo wp_get_attachment_image($banner, 'full'); ?>
		</div>
		<div class="destination-header-opacity"></div>
		<div class="destination-header-content">
			<div class="destination-header-inner">
				<div class="container">
					<h3 class="destination-name">
						<?php echo esc_attr($term->name); ?>
					</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="destination-overview">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="description-content">
						<h4 class="destination-title">
							<?php echo esc_html__('Over View', 'cc-travel'); ?>
						</h4>
						<p><?php echo term_description(); ?></p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="description-feature-image">
						<div class="cct-image">
							<?php echo wp_get_attachment_image($feature_img, 'full'); ?>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="destination-info">
		<div class="container">
			<h4 class="destination-title">
				<?php echo esc_html__('Infomation', 'cc-travel'); ?>
			</h4>
			<div class="row">
				<div class="destination-info-list col-md-6">
					<div class="info-list cct-accordion">
						<?php if (!empty($infomation)) : ?>
							<?php $i = 1; ?>
							<?php foreach ($infomation as $info) : ?>
								<?php
									$title		= cc_travel_get_value_in_array($info, 'title');
									$desc		= cc_travel_get_value_in_array($info, 'content');
								?>
								<div class="cct-item">
									<h3 class="item-title <?php echo ($i == 1) ? 'on' : ''; ?>">
										<i class="fa fa-angle-down"></i>
										<?php echo esc_attr($title); ?>
									</h3>
									<div class="item-desc <?php echo ($i == 1) ? 'show' : ''; ?>">
										<p>
											<?php echo esc_attr($desc); ?>
										</p>
									</div>
								</div>
								<?php $i++; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="destination-gallery col-md-6">
					<div class="destination-gallery-masonry cct-masonry" data-column="3">
						<?php if (!empty($gallery)) : ?>
							<div class="row">
								<?php foreach ($gallery as $image) : ?>
									<?php $src = wp_get_attachment_image_url($image, 'full'); ?>
									<div class="item-image cct-column col-md-4">
										<a href="<?php echo esc_url($src); ?>" class="cct-fancybox" data-fancybox="images">
											<img src="<?php echo esc_url($src); ?>" />
										</a>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="destination-tours">
		<div class="container">
			<h4 class="destination-title">
				<?php echo esc_html__('Tours', 'cc-travel'); ?>
			</h4>
			<div class="<?php echo implode(' ', $wrapper_class); ?>">
				<div class="<?php echo esc_attr($check_sidebar); ?>">
					<div class="<?php echo esc_attr($inner_content); ?>">
						<div class="row">
							<?php
							if (have_posts()) {
								while (have_posts()) {
									the_post();

									$tmpl = new CC_Travel_Template();
									$tmpl->get_template_part('content-tour-' . $_taxonomy_layout, null, true);
								}
							} else {

							}
							?>
						</div>
						<nav class="cct-pagination">
							<?php // Set Blog Reading Settings to XX for optimum view!!
							global $wp_query;

							$big = 999999999; // need an unlikely integer

							echo paginate_links(
								array(
									'base'		=> str_replace($big, '%#%', get_pagenum_link($big)),
									'format'	=> '?paged=%#%',
									'current'	=> max(1, get_query_var('paged')),
									'total'		=> $wp_query->max_num_pages,
									'end_size'	=> 1,
									'mid_size'	=> 2,
								)
							);
							?>
						</nav>
					</div>
					<?php cc_travel_page_sidebar($_taxonomy_sidebar, $_taxonomy_widget); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
wp_reset_postdata();
get_footer();