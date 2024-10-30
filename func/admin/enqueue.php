<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 8/13/2019
 * Time: 9:23 AM
 */

//style
wp_enqueue_style('cc-travel-style', 	CC_TRAVEL_DIR_URL . 'assets/css/admin.css');

//script
wp_enqueue_script('cc-travel-script', 	CC_TRAVEL_DIR_URL . 'assets/js/admin.js', array('jquery'), '1.0.0', true);
