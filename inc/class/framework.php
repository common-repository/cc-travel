<?php
/**
 * Created by vagrant.
 * User: vagrant
 */

if (!defined('ABSPATH')) {
	return;
}

class CC_Travel_Framework extends CCFramework {
	public $unique				= '_cc_travel_options';
	public $settings			= array();
	public $sections			= array();
	public $get_option			= array();
	public $options				= array();
	private static $instance	= null;

	public function __construct($settings, $options) {
		$this->settings = apply_filters('cc_travel_settings', $settings);
		$this->options = apply_filters('cc_travel_options', $options);

		if (!empty($this->options)) {
			$this->sections		= $this->get_sections();
			$this->get_option	= get_option('_cc_travel_options');

			$this->addAction('admin_init', 'settings_api');
			$this->addAction('admin_menu', 'admin_menu');
		}

	}

  	//instance
	public static function instance($settings = array(), $options = array()) {
		if (is_null(self::$instance)) {
			self::$instance = new self($settings, $options);
		}

		return self::$instance;
	}

}