<?php
/** 
 * Theme Settings
 * 
 * This class controls the themes settings
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// make sure this class doesnt already exist
if( ! class_exists( 'KPT_Settings' ) ) {

    /** 
     * Class KPT_Settings
     * 
     * Controls the theme settings
     * 
     * @since 8.4
     * @access public
     * @author Kevin Pirnie <me@kpirnie.com>
     * @package Kevin Pirnie's Theme
     * 
    */
    class KPT_Settings {

        /** 
         * add_settings
         * 
         * Add in the theme's settings
         * 
         * @since 8.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        public function add_settings( ) : void {

            // call the admin settings
            $this -> create_theme_settings( );

        }

        /** 
         * create_theme_settings
         * 
         * Create the theme's settings
         * 
         * @since 8.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function create_theme_settings( ) : void {

            // make sure our field framework actually exists
            if( ! class_exists( 'KPT_FW' ) ) {
                return;
            }
            
            // our settings id
            $settings_id = 'kptheme_settings';

            // create the main options page
            KPT_FW::createOptions( $settings_id, array(
                'menu_title' => __( 'Theme Settings', 'kpt' ),
                'menu_slug'  => $settings_id,
                'menu_capability' => 'list_users',
                'menu_icon' => 'dashicons-admin-settings',
                'menu_position' => 2,
                'show_in_network' => false,
                'show_reset_all' => false,
                'show_reset_section' => false,   
                'sticky_header' => false,  
                'ajax_save' => false,           
                'footer_text' => __( '<a href="https://kevinpirnie.com" target="_blank"><img src="https://cdn.kevp.cc/kp/kevinpirnie-logo-color.svg" alt="Kevin Pirnie: https://kevinpirnie.com" style="width:250px !important;" /></a>', 'kpt' ),
                'framework_title' => __( 'Kevin\'s Theme Settings <small>by <a href="https://kevinpirnie.com/" target="_blank">Kevin C. Pirnie</a></small>', 'kpt' ),
                'footer_credit' => __( 'Thanks for customizing!', 'kpt' ),
            ) );

            // after the save occurs, clear WP option cache
            add_filter( 'kpt_fw_{$settings_id}_saved', function( ) : void {

                // get the current site id
                $_site_id = get_current_blog_id( );

                // first clear wordpress's builtin cache
                wp_cache_flush( );

                // now try to delete the wp object cache
                if( function_exists( 'wp_cache_delete' ) ) {

                    // clear the plugin object cache
                    wp_cache_delete( 'uninstall_plugins', 'options' );

                    // clear the options object cache
                    wp_cache_delete( 'alloptions', 'options' );

                    // clear the rest of the object cache
                    wp_cache_delete( 'notoptions', 'options' );

                    // clear the rest of the object cache for the parent site in a multisite install
                    wp_cache_delete( $_site_id . '-notoptions', 'site-options' );

                    // clear the plugin object cache for the parent site in a multisite install
                    wp_cache_delete( $_site_id . '-active_sitewide_plugins', 'site-options' );
                }

                // probably overkill, but let's fire off the rest of the builtin cache flushing mechanisms
                global $wp_object_cache;

                // try to flush the object cache
                $wp_object_cache -> flush( 0 );

                // attempt to clear the opcache
                opcache_reset( );

            } );

            // add in the heroes settings
            $this -> heroes_settings( );


        }

        /** 
         * heroes_settings
         * 
         * Add the theme's hero settings settings
         * 
         * @since 8.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function heroes_settings( ) : void {

            // page settings key
            $_settings_key = 'kpt_hero_settings';

            // create the metabox
            KPT_FW::createMetabox( $_settings_key, array(
                'title'        => 'Hero Options',
                'post_type'    => 'page',
                'show_restore' => true,
                'context'      => 'advanced',
            ) );

            KPT_FW::createSection( $_settings_key, array(
                'fields' => array( 
                    // page selection to assign the hero to.
                    array(
                        'id'          => 'page_assignment',
                        'type'        => 'checkbox',
                        'title'       => 'Select Heroes',
                        'subdesc'     => 'Select the heroes you want to assign here',
                        'options'     => $this -> get_heroes( ),
                    ),

                ) ) );

        }


        private function get_heroes( ) : array {

            // the return
            $ret = [];

            // setup the args for the hero CPT
            $args = array(
                'post_type'      => 'kpt_hero', 
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'fields'         => 'ids',
            );

            // now get the heroes
            $heroes = get_posts( $args );

            // if there aren't ay heroes
            if( ! $heroes ) {
                return $ret;
            }

            // loop over them
            foreach( $heroes as $hero ) {

                $ret[$hero] = get_the_title( $hero );

            }

            // return it
            return $ret;

        }

    }

}
