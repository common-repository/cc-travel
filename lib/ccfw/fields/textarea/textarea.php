<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Textarea
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CCFramework_Option_textarea extends CCFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    echo $this->element_before();
    echo $this->shortcode_generator();
    echo '<textarea name="'. $this->element_name() .'"'. $this->element_class() . $this->element_attributes() .'>'. $this->element_value() .'</textarea>';
    echo $this->element_after();

  }

  public function shortcode_generator() {
    if( isset( $this->field['shortcode'] ) && CC_ACTIVE_SHORTCODE ) {
      echo '<a href="#" class="button button-primary cc-shortcode cc-shortcode-textarea">'. __( 'Add Shortcode', 'cc-framework' ) .'</a>';
    }
  }
}
