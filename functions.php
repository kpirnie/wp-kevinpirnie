<?php

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// setup our path
defined( 'KPT_PATH' ) || define( 'KPT_PATH', dirname( __FILE__ ) . '/' );

// At our earliest point, fire this up
add_action( 'after_setup_theme', function( ) {

	// include our autoloader
    include_once KPT_PATH . '/vendor/autoload.php';

    // we can fire up the rest of the theme's functionality now
    $_kpt = new KPT( );

    // initialize the theme
    $_kpt -> init( );

    // clean up
    unset( $_kpt );
    
    // Extended Setup Class for the framework
    if ( ! class_exists( 'KPT_FW' ) ) {
    class KPT_FW extends KPT_FW_Setup{}
    }

}, 999 );
