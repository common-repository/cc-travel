<?php
/**
 * Created by vagrant.
 * User: vagrant
 */

/*
Plugin Name: 		CC Travel
Plugin URI: 		http://chuyencode.com/cc-travel
Description: 		Plugin for travel
Version: 			1.0.0
Author: 			chuyencode
Author URI: 		http://chuyencode.com
*/

if (!defined('ABSPATH')) {
	return;
}

if (!class_exists('CC_Travel')) {
	class CC_Travel {
		public function __construct() {
			$this->define_constant();
			$this->load_library();
			$this->load_helper();

			add_action('init', array(__CLASS__, 'load_config'), 12);
			add_action('wp_loaded', array(__CLASS__, 'shortcodes'));
			add_action('widgets_init', array(__CLASS__, 'widget'));

			if (!is_admin()) {
				add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue_scripts'), 20);
			}

			if (is_admin()) {
				add_action('admin_print_scripts-post.php', array(__CLASS__, 'admin_enqueue_scripts'), 99);
				add_action('admin_print_scripts-post-new.php', array(__CLASS__, 'admin_enqueue_scripts'), 99);
				add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_enqueue_scripts'), 99);
			}

			$this->create_image_size();
		}

		// define constant.
		public function define_constant() {
			define('CC_TRAVEL_DIR_PATH', plugin_dir_path(__FILE__));
			define('CC_TRAVEL_DIR_URL', plugin_dir_url(__FILE__));
		}

		// load library.
		public function load_library() {
			if (!class_exists('CCFramework') && !function_exists('cc_framework_init')) {
				require_once CC_TRAVEL_DIR_PATH . '/lib/ccfw/ccfw.php';
			}

			if (!class_exists('Gamajo_Template_Loader')) {
				require_once CC_TRAVEL_DIR_PATH . '/lib/template/class-gamajo-template-loader.php';
				require_once CC_TRAVEL_DIR_PATH . '/lib/template/template.php';
			}
		}

		// load config.
		public static function load_config() {
			//lib extends.
			require_once CC_TRAVEL_DIR_PATH . '/inc/class/framework.php';
			require_once CC_TRAVEL_DIR_PATH . '/inc/class/taxonomy.php';
			require_once CC_TRAVEL_DIR_PATH . '/inc/class/metabox.php';

			// load config.
			require_once CC_TRAVEL_DIR_PATH . '/inc/config/framework.php';
			require_once CC_TRAVEL_DIR_PATH . '/inc/config/taxonomy.php';
			require_once CC_TRAVEL_DIR_PATH . '/inc/config/metabox.php';
		}

		// load helper.
		public function load_helper() {
			// register post type.
			require_once CC_TRAVEL_DIR_PATH . '/func/post-type.php';

			// load function base.
			require_once CC_TRAVEL_DIR_PATH . '/func/base.php';
			require_once CC_TRAVEL_DIR_PATH . '/func/filter.php';
			require_once CC_TRAVEL_DIR_PATH . '/func/hook.php';

			// load function tour
			require_once CC_TRAVEL_DIR_PATH . '/func/tour/tour.php';
			require_once CC_TRAVEL_DIR_PATH . '/func/tour/layout.php';

			//load function shortcode
			require_once CC_TRAVEL_DIR_PATH . '/func/shortcode/params.php';
			require_once CC_TRAVEL_DIR_PATH . '/func/shortcode/actions.php';

			// load style class
			require_once CC_TRAVEL_DIR_PATH . '/func/style-builder.php';

			// load admin function
			if (is_admin()) {
				require_once CC_TRAVEL_DIR_PATH . '/func/admin/tour.php';
			}
		}

		// load image size
		public function create_image_size() {
			//add image size
			$defaults_image_size = cc_travel_default_image_size();

			if (! empty($defaults_image_size)) {
				foreach ($defaults_image_size as $size) {
					if ($size['img_crop']) {
						$crop	= array('left', 'top');
					} else {
						$crop	= '';
					}

					add_image_size(sanitize_title($size['img_size_name']), $size['img_size_width'], $size['img_size_height'], $crop);
				}
			}
		}

		// call shortcodes
		public static function shortcodes() {
			$vc_active 		= class_exists('Vc_Manager');
			$path			= CC_TRAVEL_DIR_PATH . '/shortcodes/';

			$shortcodes		= array(
				'tour-grid',
				'tour-list'
			);

			foreach ($shortcodes as $shortcode) {
				if (is_admin() && $vc_active && file_exists($path . $shortcode . '/config.vc.php')) {
					require_once $path . $shortcode . '/config.vc.php';
				}

				if (!is_admin() && file_exists($path . $shortcode . '/' . $shortcode . '.php')) {
					require_once $path . $shortcode . '/' . $shortcode . '.php';
				}
			}
		}

		// load widget
		public static function widget() {
			require_once CC_TRAVEL_DIR_PATH . '/widgets/filter-by-price.php';
			require_once CC_TRAVEL_DIR_PATH . '/widgets/filter-by-duration.php';
			require_once CC_TRAVEL_DIR_PATH . '/widgets/filter-by-departure-date.php';
			require_once CC_TRAVEL_DIR_PATH . '/widgets/filter-by-taxonomy.php';
		}

		// enqueue_scripts.
		public static function enqueue_scripts() {
			require_once CC_TRAVEL_DIR_PATH . '/func/enqueue.php';
			require_once CC_TRAVEL_DIR_PATH . '/func/style-custom.php';

			$style_builder	= CC_Travel_Style_Builder::getInstance();
			$custom_style	= $style_builder->render();

			if ($custom_style) {
				wp_add_inline_style('cc-travel-style', $custom_style);
			}
		}

		// admin enqueue_scripts.
		public static function admin_enqueue_scripts() {
			require_once CC_TRAVEL_DIR_PATH . '/func/admin/enqueue.php';
		}
	}

	new CC_Travel();
}