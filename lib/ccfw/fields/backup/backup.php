<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Backup
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CCFramework_Option_backup extends CCFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    echo $this->element_before();

    echo '<textarea name="'. $this->unique .'[import]"'. $this->element_class() . $this->element_attributes() .'></textarea>';
    submit_button( __( 'Import a Backup', 'cc-framework' ), 'primary cc-import-backup', 'backup', false );
    echo '<small>( '. __( 'copy-paste your backup string here', 'cc-framework' ).' )</small>';

    echo '<hr />';

    echo '<textarea name="_nonce"'. $this->element_class() . $this->element_attributes() .' disabled="disabled">'. cc_encode_string( get_option( $this->unique ) ) .'</textarea>';
    echo '<a href="'. admin_url( 'admin-ajax.php?action=cc-export-options' ) .'" class="button button-primary" target="_blank">'. __( 'Export and Download Backup', 'cc-framework' ) .'</a>';
    echo '<small>-( '. __( 'or', 'cc-framework' ) .' )-</small>';
    submit_button( __( 'Reset All Options', 'cc-framework' ), 'cc-warning-primary cc-reset-confirm', $this->unique . '[resetall]', false );
    echo '<small class="cc-text-warning">'. __( 'Please be sure for reset all of framework options.', 'cc-framework' ) .'</small>';

    echo $this->element_after();

  }

}
