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

            // setup an array to hold them
            $_css = [
                'debug' => [
                    'kpt_font' => [ '//fonts.googleapis.com/css2?family=Source+Code+Pro:wght@300;400;500;600;700&display=swap&_=' . time( ), '' ],
                    'kpt_theme' => [ get_stylesheet_directory_uri( ) . '/assets/css/theme.css?_=' . time( ), 'kpt_font' ],
                    'custom' => [ get_stylesheet_directory_uri( ) . '/style.css?_=' . time( ), 'kpt_theme' ],
                ],
                'production' => [
                    'kpt_font' => [ '//fonts.googleapis.com/css2?family=Source+Code+Pro:wght@300;400;500;600;700&display=swap', '' ],
                    'kpt_theme' => [ get_stylesheet_directory_uri( ) . '/assets/css/theme.min.css', 'kpt_font' ],
                    'custom' => [ get_stylesheet_directory_uri( ) . '/style.css', 'kpt_theme' ],
                ],
            ];

            // if we're in debug mode
            if( defined( 'WP_DEBUG' ) && WP_DEBUG ) {   

                // loop over the debug css
                foreach( $_css['debug' ] as $_key => $_val ) {

                    // register the style, then enqueue it
                    wp_register_style( $_key, $_val[0], [ $_val[1] ], null );
                    wp_enqueue_style( $_key );

                }

            // nope, we're on production
            } else {

                // loop over the debug css
                foreach( $_css['production' ] as $_key => $_val ) {
                    var_dump($_key);
                    var_dump($_val);
                    echo '<hr />';

                    // register the style, then enqueue it
                    wp_register_style( $_key, $_val[0], [ $_val[1] ], null );
                    wp_enqueue_style( $_key );

                }

            }

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



        }

        /** 
         * remove_frontend_jquery
         * 
         * Properly remove jquery from teh front-end of the site
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

                            // dequeueu it first
                            wp_dequeue_script( $_hndl );

                            // now unregister it
                            wp_deregister_script( $_hndl );   
                            
                        }

                        // do the same for unecessary CSS
                        $_remove = array( 'wp-block-library' );

                        // loop over this array and properly remove them
                        foreach( $_remove as $_hndl ) {

                            // dequeueu it first
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
