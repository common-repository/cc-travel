<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/19/2019
 * Time: 3:56 PM
 */

get_header();

?>

<div class="cct-single-tour">
	<div class="single-tour-wrapper">
		<?php
			while (have_posts()) {
				the_post();

				$tmpl = new CC_Travel_Template();
				$tmpl->get_template_part('content-single-tour', null, true);
			}
		?>
	</div>
</div>
<?php
get_footer();