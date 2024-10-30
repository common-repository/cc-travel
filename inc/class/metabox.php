<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 7/18/2019
 * Time: 9:33 PM
 */

class CC_Travel_MetaBox extends CCFramework_Metabox {
	public $options = array();
	private static $instance = null;

	// run metabox construct
	public function __construct( $options ){
		$this->options = apply_filters( 'cc_travel_metabox_options', $options );

		if( ! empty( $this->options ) ) {
			$this->addAction( 'add_meta_boxes', 'add_meta_box' );
			$this->addAction( 'save_post', 'save_post', 10, 2 );
		}
	}

	// instance
	public static function instance( $options = array() ){
		if ( is_null( self::$instance )) {
			self::$instance = new self( $options );
		}

		return self::$instance;
	}
}