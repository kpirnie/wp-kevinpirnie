<?php
/** 
 * Theme CPT's
 * 
 * This class controls the themes custom post types
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// make sure this class doesnt already exist
if( ! class_exists( 'KPT_CPTs' ) ) {

    /** 
     * Class KPT_CPTs
     * 
     * Controls the theme custom post types
     * 
     * @since 8.4
     * @access public
     * @author Kevin Pirnie <me@kpirnie.com>
     * @package Kevin Pirnie's Theme
     * 
    */
    class KPT_CPTs {

        /** 
         * add_cpts
         * 
         * Add in the theme's custom post types
         * 
         * @since 8.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        public function add_cpts( ) : void {

            // hook into the init
            add_action( 'init', function( ) {

                // create the CTA CPT
                $this -> create_cta( );

                // and the heroes
                $this -> create_hero( );

            } );

        }

        /** 
         * create_cta
         * 
         * Register the CTA post type
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function create_cta( ) : void {

            // register the call to action CPT
            register_post_type( 'kpt_cta', array(
                'labels' => array(
                    'name'               => 'Call To Actions',
                    'singular_name'      => 'Call To Action',
                    'add_new'            => 'Add New',
                    'add_new_item'       => 'Add New CTA',
                    'edit_item'          => 'Edit CTA',
                    'new_item'           => 'New CTA',
                    'all_items'          => 'All CTAs',
                    'menu_name'          => 'CTAs',
                ),
                'public'              => false,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'menu_icon'           => 'dashicons-megaphone',
                'supports'            => array( 'title', 'thumbnail' ),
                'has_archive'         => false,
                'rewrite'             => false,
                'publicly_queryable'  => false,
                'exclude_from_search' => true,
                'show_in_nav_menus'   => false,
            ) );

        }

        /** 
         * create_hero
         * 
         * Register the Page Hero post type
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function create_hero( ) : void {

            // register the call to action CPT
            register_post_type( 'kpt_hero', array(
                'labels' => array(
                    'name'               => 'Page Heros',
                    'singular_name'      => 'Hero',
                    'add_new'            => 'Add New',
                    'add_new_item'       => 'Add New Hero',
                    'edit_item'          => 'Edit Hero',
                    'new_item'           => 'New Hero',
                    'all_items'          => 'All Heros',
                    'menu_name'          => 'Page Heros',
                ),
                'public'              => false,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'menu_icon'           => 'dashicons-slides',
                'supports'            => array( 'title', 'thumbnail', 'editor', 'editor-style' ),
                'has_archive'         => false,
                'rewrite'             => false,
                'publicly_queryable'  => false,
                'exclude_from_search' => true,
                'show_in_nav_menus'   => false,
                'show_in_rest'        => true,
            ) );
            
        }

    }

}
