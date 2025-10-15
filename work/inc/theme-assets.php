<?php
/** 
 * Assets class
 * 
 * This class is responsible for properly pulling in our theme assets
 * 
 * @since 8.4
 * @access public
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// make sure this isn't already loaded in
if( ! class_exists( 'KPT_Assets' ) ) {

    /** 
     * KPT_Assets
     * 
     * This class is responsible for properly pulling in our theme assets
     * 
     * @since 8.4
     * @access public
     * @author Kevin Pirnie <me@kpirnie.com>
     * @package Kevin Pirnie's Theme
     * 
    */
    class KPT_Assets {

        /** 
         * enqueue
         * 
         * Setup the css and javascript enqueuers
         * 
         * @since 8.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        public function enqueue( ) {

            // only run on the frontend, not in wp-admin
            if ( is_admin() ) {
                return;
            }

            // remove jquery from front-end
            $this -> remove_frontend_jquery( );

            // enqueue our styles
            $this -> pull_css( );

            // enqueue our scripts
            $this -> pull_js( );

        }

        /** 
         * pull_css
         * 
         * Properly enqueue the css for our theme
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function pull_css( ) : void {

            $is_debug = defined('KPT_DEBUG') && KPT_DEBUG;

            // Google Fonts
            wp_enqueue_style(
                'kpt_font',
                'https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@300;400;500;600;700&display=swap',
                array(),
                null
            );

            // Theme CSS
            wp_enqueue_style(
                'kpt_theme',
                get_stylesheet_directory_uri() . '/assets/css/theme.' . ($is_debug ? 'debug' : 'min') . '.css',
                array('kpt_font'),
                $is_debug ? time() : null
            );

            // Custom CSS - style.css
            wp_enqueue_style(
                'kpt_custom',
                get_stylesheet_uri(),
                array('kpt_theme'),
                $is_debug ? time() : null
            );

        }

        /** 
         * pull_js
         * 
         * Properly enqueue the javascript for our theme
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function pull_js( ) : void {

            $is_debug = defined('KPT_DEBUG') && KPT_DEBUG;

            wp_enqueue_script(
                'kpt_theme',
                get_stylesheet_directory_uri() . '/assets/js/theme.' . ($is_debug ? 'debug' : 'min') . '.js',
                array(),
                $is_debug ? time() : null,
                true
            );

            wp_enqueue_script(
                'kpt_custom',
                get_stylesheet_directory_uri() . '/script.js',
                array('kpt_theme'),
                $is_debug ? time() : null,
                true
            );

        }

        /** 
         * remove_frontend_jquery
         * 
         * Properly remove jquery from the front-end of the site
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function remove_frontend_jquery( ) : void {

            // make sure we only do this in the front-end, and only on pages that are not our form
            if( ! is_admin( ) ) {

                // remove it
                add_action( 'wp_enqueue_scripts', function( ) {

                    // check for the contact me page
                    if( ! is_page( 83 ) ) {

                        // setup an array of items to be removed
                        $_remove = array( 'jquery', 'wp-embed' );

                        // loop over this array and properly remove them
                        foreach( $_remove as $_hndl ) {

                            // dequeue it first
                            wp_dequeue_script( $_hndl );

                            // now unregister it
                            wp_deregister_script( $_hndl );   
                            
                        }

                        // do the same for unnecessary CSS
                        $_remove = array( 'wp-block-library', 'classic-themes-styles', 'global-styles' );

                        // loop over this array and properly remove them
                        foreach( $_remove as $_hndl ) {

                            // dequeue it first
                            wp_dequeue_style( $_hndl );

                            // now unregister it
                            wp_deregister_style( $_hndl );   
                            
                        }

                    }

                }, PHP_INT_MAX - 1 );

            }

        }

    }

}