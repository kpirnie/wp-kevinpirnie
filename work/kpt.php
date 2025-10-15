<?php
/** 
 * Theme Class
 * 
 * This is the primary theme class file. It will be responsible for pulling together everything for us to use
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

if( ! class_exists( 'KPT' ) ) {

    /** 
     * Class KPT
     * 
     * The primary theme class
     * 
     * @since 8.4
     * @access public
     * @author Kevin Pirnie <me@kpirnie.com>
     * @package Kevin Pirnie's Theme
     * 
    */
    class KPT {

        // fire us up
        public function __construct( ) {

            // hook into the style/script enqueuer as soon as possible
            add_action( 'wp_enqueue_scripts', function( ) {

                // fire up the assets class
                $_assets = new KPT_Assets( );

                // DO IT!
                $_assets -> enqueue( );

                // clean up
                unset( $_assets );

            } );

        }

        /** 
         * init
         * 
         * Initilize the theme
         * 
         * @since 8.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        public function init( ) : void {

            // hold our classes and the public method we'll be using
            $theme_classes = array(
                array( 'class' => 'KPT_Assets', 'method' => 'enqueue' ),
                array( 'class' => 'KPT_Supports', 'method' => 'the_theme_supports' ),
                array( 'class' => 'KPT_Performance', 'method' => 'manage_performance' ),
                //[ 'class' => '', 'method' => ''],
            );

            // loop over each item
            foreach ( $theme_classes as $item ) {

                // make sure the class actually exists
                if ( class_exists( $item['class'] ) ) {
                    
                    // fire it up
                    $instance = new $item['class']( );
                    
                    // make sure the method exists
                    if ( method_exists( $instance, $item['method'] ) ) {
                        
                        // fire it up
                        $instance -> {$item['method']}( );
                    }
                    
                    // now clean up the instance
                    unset( $instance );

                }

            }

            // now we can clean up the class array
            unset( $theme_classes );
            
            // toss in menus we want
            register_nav_menus(array(
                'primary' => __( 'Primary Menu', 'kpt' ),
                'top' => __( 'Top Header Menu', 'kpt' ),
                'bottom' => __( 'Footer Bottem Menu', 'kpt' ),
            ));

            // modify our excerpt length
            add_filter( 'excerpt_length', function( $length ) : int {
                return 20;
            } );

        }


    }

}
