<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 7/13/2019
 * Time: 9:28 PM
 */

class CC_Travel_Taxonomy extends CCFramework_Taxonomy {
	public $options = array();
	private static $instance = null;

	public function __construct( $options ) {

		$this->options = apply_filters( 'cc_travel_options', $options );

		if( ! empty( $this->options ) ) {
			$this->addAction( 'admin_init', 'add_taxonomy_fields' );
		}

	}

	// instance
	public static function instance( $options = array() ) {
		if ( is_null( self::$instance )) {
			self::$instance = new self( $options );
		}

		return self::$instance;
	}
}