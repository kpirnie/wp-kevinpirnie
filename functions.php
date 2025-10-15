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

function kp_widgets_init() {
    register_sidebar(array(
        'name' => __('Footer Column 1', 'kpt'),
        'id' => 'footer-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Column 2', 'kpt'),
        'id' => 'footer-2',
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Column 3', 'kpt'),
        'id' => 'footer-3',
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'kp_widgets_init');
