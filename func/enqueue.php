<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/13/2019
 * Time: 9:23 AM
 */

wp_enqueue_style('google-font-poppins', 'https://fonts.googleapis.com/css?family=Poppins:300,400,700&display=swap', array(), '1.0.0');

//style
wp_enqueue_style('font-awesome', 	CC_TRAVEL_DIR_URL . '/assets/plugins/font-awesome/font-awesome.css');
wp_enqueue_style('jquery-ranger', 	CC_TRAVEL_DIR_URL . '/assets/plugins/ranger/jquery.range.css');
wp_enqueue_style('cc-date-picker', 	CC_TRAVEL_DIR_URL . '/assets/css/date-picker.css');
wp_enqueue_style('slick', 			CC_TRAVEL_DIR_URL . '/assets/plugins/slick/slick.css', array());
wp_enqueue_style('slick-theme', 	CC_TRAVEL_DIR_URL . '/assets/plugins/slick/slick-theme.css', array());
wp_enqueue_style('jquery-fancybox', CC_TRAVEL_DIR_URL . '/assets/plugins/fancybox/jquery.fancybox.min.css', array(), '3.5.2');
wp_enqueue_style('cc-travel-style', 	CC_TRAVEL_DIR_URL . '/assets/css/style.css');

//javascript
wp_enqueue_script('imagesloaded');
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_script('jquery-fancybox', CC_TRAVEL_DIR_URL . 'assets/plugins/fancybox/jquery.fancybox.min.js', array('jquery'), '3.5.2', true);
wp_enqueue_script('slick', CC_TRAVEL_DIR_URL . 'assets/plugins/slick/slick.js', array(), false, true);
wp_enqueue_script('isotope', CC_TRAVEL_DIR_URL . 'assets/plugins/isotope/isotope.pkgd.min.js', array('jquery'), '3.0.3', true);
wp_enqueue_script('jquery-validate', 	CC_TRAVEL_DIR_URL . 'assets/plugins/validate/jquery.validate.min.js', array('jquery'), '1.19.1', true);
wp_enqueue_script('jquery-ranger', 	CC_TRAVEL_DIR_URL . 'assets/plugins/ranger/jquery.range-min.js', array('jquery'), '1.0.0', true);
wp_enqueue_script('tabs', 	CC_TRAVEL_DIR_URL . 'assets/plugins/tabs/tab.js', array('jquery'), '3.3.6', true);
wp_enqueue_script('cc-travel-script', 	CC_TRAVEL_DIR_URL . 'assets/js/script.js', array('jquery'), '1.0.0', true);
wp_localize_script('cc-travel-script', 'cc_travel_script', array(
	'ajax_url' 				=> admin_url('admin-ajax.php'),
	'site_url'				=> esc_url(home_url('/')),
	'duration_label'		=> esc_html__('days', 'cc-travel'),
	'price_label'			=> cc_travel_get_option('_currency_symbol', '$'),
	'min_price'				=> (int) cc_travel_get_min_value_custom_fields('price'),
	'max_price'				=> (int) cc_travel_get_max_value_custom_fields('price'),
	'min_duration'			=> cc_travel_get_min_value_custom_fields('duration'),
	'max_duration'			=> cc_travel_get_max_value_custom_fields('duration'),
));