<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access pages directly.

/**
 *
 * Field: Heading
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CCFramework_Option_heading extends CCFramework_Options {

	public function __construct($field, $value = '', $unique = '') {
		parent::__construct($field, $value, $unique);
	}

	public function output() {

		echo $this->element_before();
		echo wp_kses($this->field['content'], wp_kses_allowed_html());
		echo $this->element_after();

	}

}
