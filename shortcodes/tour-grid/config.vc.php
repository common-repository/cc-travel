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

//Columns
$params[] = array(
	'type'			=> 'dropdown',
	'heading'		=> esc_html__('Columns', 'cc-travel'),
	'param_name'	=> 'columns',
	'value'			=> array(
		esc_html__('2', 'cc-travel')	=> '2',
		esc_html__('3', 'cc-travel')	=> '3',
		esc_html__('4', 'cc-travel')	=> '4',
		esc_html__('6', 'cc-travel')	=> '6',
	),
	'std'			=> '3',
	'group'			=> esc_html__('Layout Option', 'cc-travel'),
	'dependency'	=> array('element' => 'layout', 'value' => array('grid-1')),
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
	'name' 				=> esc_html__('Tour Grid', 'cc-travel'),
	'base' 				=> 'tour_grid',
	'icon'				=> 'fa fa-grid',
	'is_container'   	=> true,
	'category' 			=> esc_html__('CC Travel', 'cc-travel'),
	'params' 			=> $params
));