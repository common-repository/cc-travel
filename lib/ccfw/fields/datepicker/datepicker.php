<?php
/**
 * Created by vagrant.
 * User: vagrant
 */

if (!defined('ABSPATH')) {
	return;
}

/**
 *
 * Field: DatePicker
 *
 * @since 1.0.0
 * @version 1.0.0
 */
class CCFramework_Option_datepicker extends CCFramework_Options {

	public function __construct($field, $value = '', $unique = '') {
		parent::__construct($field, $value, $unique);
	}

	public function output() {
		echo $this->element_before();

		?>
		<div class="cc-datepicker-wrapper">
			<?php echo '<input type="text" name="' . $this->element_name() . '" value="' . $this->element_value() . '"' . $this->element_class('cc-datepicker') . $this->element_attributes() . '/>'; ?>
		</div>
		<?php

		echo $this->element_after();
	}
}
