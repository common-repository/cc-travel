<?php
if (!defined('ABSPATH')) {
	die;
}

require_once plugin_dir_path(__FILE__) . '/ccfw-path.php';

if (!function_exists('cc_framework_init') && !class_exists('CCFramework')) {
	function cc_framework_init() {

		// active modules
		defined('CC_ACTIVE_LIGHT_THEME') or define('CC_ACTIVE_LIGHT_THEME', false);

		// helpers
		cc_locate_template('functions/helpers.php');
		cc_locate_template('functions/actions.php');
		cc_locate_template('functions/enqueue.php');
		cc_locate_template('functions/sanitize.php');
		cc_locate_template('functions/validate.php');

		// classes
		cc_locate_template('classes/abstract.class.php');
		cc_locate_template('classes/options.class.php');
		cc_locate_template('classes/framework.class.php');
		cc_locate_template('classes/metabox.class.php');
		cc_locate_template('classes/taxonomy.class.php');
		cc_locate_template('classes/customize.class.php');

		if (class_exists('Vc_Manager')) {
			cc_locate_template('plugins/js-composer/includes/init.php');
		}
	}

	add_action('init', 'cc_framework_init', 10);

	function cc_framework_widgets_init() {
		cc_locate_template('classes/widget.class.php');
	}

	add_action('widgets_init', 'cc_framework_widgets_init');
}
