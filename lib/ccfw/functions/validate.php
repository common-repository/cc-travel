<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Email validate
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cc_validate_email' ) ) {
  function cc_validate_email( $value, $field ) {

    if ( ! sanitize_email( $value ) ) {
      return __( 'Please write a valid email address!', 'cc-framework' );
    }

  }
  add_filter( 'cc_validate_email', 'cc_validate_email', 10, 2 );
}

/**
 *
 * Numeric validate
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cc_validate_numeric' ) ) {
  function cc_validate_numeric( $value, $field ) {

    if ( ! is_numeric( $value ) ) {
      return __( 'Please write a numeric data!', 'cc-framework' );
    }

  }
  add_filter( 'cc_validate_numeric', 'cc_validate_numeric', 10, 2 );
}

/**
 *
 * Required validate
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cc_validate_required' ) ) {
  function cc_validate_required( $value ) {
    if ( empty( $value ) ) {
      return __( 'Fatal Error! This field is required!', 'cc-framework' );
    }
  }
  add_filter( 'cc_validate_required', 'cc_validate_required' );
}
