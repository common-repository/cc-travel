<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/7/2019
 * Time: 11:05 AM
 */

$params = array();
$params = cc_travel_vc_shortcode_movie_default_params();

//post per page
$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Number Of Tour', 'cc-travel'),
	'param_name'	=> 'posts_per_page',
	'group'			=> esc_html__('Layout Option', 'cc-travel'),
);

$params[] = array(
	'type'			=> 'vc_cc_on_off',
	'heading'		=> esc_html__('Pagination', 'cc-travel'),
	'param_name'	=> 'pagination',
	'std'			=> true,
	'group'			=> esc_html__('Layout Option', 'cc-travel')
);

$params[] = array(
	'type'			=> 'textfield',
	'heading'		=> esc_html__('Extra Class', 'cc-travel'),
	'param_name'	=> 'class',
	'group'			=> esc_html__('Layout Option', 'cc-travel')
);

vc_map(array(
	'name' 				=> esc_html__('Tour List', 'cc-travel'),
	'base' 				=> 'tour_list',
	'icon'				=> 'fa fa-grid',
	'is_container'   	=> true,
	'category' 			=> esc_html__('CC Travel', 'cc-travel'),
	'params' 			=> $params
));