<?php
/** 
 * Theme Utilities
 * 
 * This class controls the utility methods for the theme
 * most of these are static functions
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// make sure this class doesnt already exist
if( ! class_exists( 'KPT_Utilities' ) ) {

    /** 
     * Class KPT_Utilities
     * 
     * This class controls the utility methods for the theme
     * 
     * @since 8.4
     * @access public
     * @author Kevin Pirnie <me@kpirnie.com>
     * @package Kevin Pirnie's Theme
     * 
    */
    class KPT_Utilities {

        /** 
         * get_posts_for_select
         * 
         * Gets the current list of all selected public posts in the site
         * 
         * @since 8.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin's Framework
         * 
         * @return array Returns an array of all posts in the site: array( ID, Title )  This is not postype agnostic
         * 
        */
        public static function get_posts_for_select( string $type = 'posts' ) : array {

            // setup our return array
            $_ret = array( );

            // query for our posts
            $_qry = new WP_Query( array( 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC', 'post_status' => 'publish', 'post_type' => $type ) );
            $_rs = $_qry -> get_posts( );

            // if we have results
            if( $_rs ) {

                // we need a default
                $_ret[0] = '-- None --';

                // loop over them
                foreach( $_rs as $_p ) {

                    // populate the return array... we want.. id for the key, and post title
                    $_ret[ $_p -> ID ] = $_p -> post_title;
                }
            }

            // return it
            return ( is_array( $_ret ) ) ? $_ret : array( );

        }

    }

}
