<?php
defined( 'ABSPATH' ) or die;

cc_locate_template( 'plugins/js-composer/includes/helpers.php' );
cc_locate_template( 'plugins/js-composer/includes/params.php' );
cc_locate_template( 'plugins/js-composer/includes/extends.php' );

$options    = apply_filters( 'cc_framework_vc_map_options', array() );

foreach ( $options as $option ) {
	if ( $option ) {
		vc_map( $option );
	}
}
