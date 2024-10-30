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
$_taxonomy_layout			= isset($_GET['layout']) ? sanitize_text_field($_GET['layout']) : $_taxonomy_layout;

$_taxonomy_post_per_page	= cc_travel_get_option('_taxonomy_post_per_page');

$_taxonomy_sidebar			= cc_travel_get_option('_taxonomy_sidebar', 'full');
$_taxonomy_sidebar			= isset($_GET['sidebar']) ? sanitize_text_field($_GET['sidebar']) : $_taxonomy_sidebar;

$_taxonomy_widget			= cc_travel_get_option('_taxonomy_widget');

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

<div class="cct-archive-tour">
	<div class="container">
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

<?php
wp_reset_postdata();
get_footer();