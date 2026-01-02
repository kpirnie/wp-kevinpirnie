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

                // and the portfolio items
                $this -> create_portfolio( );

            } );

            // hook into admin init
            add_action( 'admin_init', function( ) {

                // add the columns
                $this -> add_admin_columns( );
                $this -> admin_column_css( );

            } );

        }


        private function create_portfolio( ) : void {
         
            // register the call to action CPT
            register_post_type( 'kpt_portfolio', array(
                'labels' => array(
                    'name'               => 'Portfolio',
                    'singular_name'      => 'Portfolio Item',
                    'add_new'            => 'Add New',
                    'add_new_item'       => 'Add New Item',
                    'edit_item'          => 'Edit Item',
                    'new_item'           => 'New Portfolio Item',
                    'all_items'          => 'All Items',
                    'menu_name'          => 'Portfolio',
                ),
                'public'              => true,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'menu_icon'           => 'dashicons-images-alt2',
                'supports'            => array( 'title', 'thumbnail', 'editor', 'editor-style', 'excerpt' ),
                'has_archive'         => false,
                'exclude_from_search' => true,
                'show_in_nav_menus'   => false,
                'show_in_rest'        => true,
                'rewrite' => ['slug' => "portfolio/client", 'with_front' => false],
            ) );
            
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
                'supports'            => array( 'title', 'thumbnail', 'editor', 'editor-style' ),
                'has_archive'         => false,
                'rewrite'             => false,
                'publicly_queryable'  => false,
                'exclude_from_search' => true,
                'show_in_nav_menus'   => false,
                'show_in_rest'        => true,
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
                    'name'               => 'Page Heroes',
                    'singular_name'      => 'Hero',
                    'add_new'            => 'Add New',
                    'add_new_item'       => 'Add New Hero',
                    'edit_item'          => 'Edit Hero',
                    'new_item'           => 'New Hero',
                    'all_items'          => 'All Heroes',
                    'menu_name'          => 'Page Heroes',
                ),
                'public'              => false,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'menu_icon'           => 'dashicons-images-alt',
                'supports'            => array( 'title', 'thumbnail', 'editor', 'editor-style' ),
                'has_archive'         => false,
                'rewrite'             => false,
                'publicly_queryable'  => false,
                'exclude_from_search' => true,
                'show_in_nav_menus'   => false,
                'show_in_rest'        => true,
            ) );
            
        }

        /** 
         * add_admin_columns
         * 
         * Add thumbnail columns to admin list pages
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function add_admin_columns( ) : void {

            // Add the secondary title
            add_filter( 'manage_page_posts_columns', function( $columns ) {
                $new = array();
                foreach ( $columns as $key => $value ) {
                    $new[$key] = $value;
                    if ( $key === 'cb' ) {
                        $new['sec_title'] = __( 'Title', 'kpt' );
                    }
                }
                return $new;
            } );

            // Display the thumbnail
            add_action( 'manage_page_posts_custom_column', function( $column, $post_id ) {
                if ( $column === 'sec_title' ) {
                    $hero_settings = get_post_meta( $post_id, 'kpt_hero_settings', true );
                    echo ($hero_settings['page_secondary_title']) ?? '';
                }
            }, 10, 2 );

            // Heroes
            add_filter( 'manage_kpt_hero_posts_columns', function( $columns ) {
                $new = array();
                foreach ( $columns as $key => $value ) {
                    $new[$key] = $value;
                    if ( $key === 'cb' ) {
                        $new['thumbnail'] = __( 'Image', 'kpt' );
                    }
                }
                return $new;
            } );

            add_action( 'manage_kpt_hero_posts_custom_column', function( $column, $post_id ) {
                if ( $column === 'thumbnail' ) {
                    echo get_the_post_thumbnail( $post_id, array( 125, 125 ) );
                }
            }, 10, 2 );

            // Heroes
            add_filter( 'manage_kpt_portfolio_posts_columns', function( $columns ) {
                $new = array();
                foreach ( $columns as $key => $value ) {
                    $new[$key] = $value;
                    if ( $key === 'cb' ) {
                        $new['thumbnail'] = __( 'Image', 'kpt' );
                    }
                }
                return $new;
            } );

            add_action( 'manage_kpt_portfolio_posts_custom_column', function( $column, $post_id ) {
                if ( $column === 'thumbnail' ) {
                    echo get_the_post_thumbnail( $post_id, array( 125, 125 ) );
                }
            }, 10, 2 );

            // CTAs
            add_filter( 'manage_kpt_cta_posts_columns', function( $columns ) {
                $new = array();
                foreach ( $columns as $key => $value ) {
                    $new[$key] = $value;
                    if ( $key === 'cb' ) {
                        $new['thumbnail'] = __( 'Image', 'kpt' );
                    }
                }
                return $new;
            } );

            add_action( 'manage_kpt_cta_posts_custom_column', function( $column, $post_id ) {
                if ( $column === 'thumbnail' ) {
                    echo get_the_post_thumbnail( $post_id, array( 125, 125 ) );
                }
            }, 10, 2 );

        }

        /** 
         * admin_column_css
         * 
         * Add CSS to style the thumbnail column width
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function admin_column_css( ) : void {

            add_action( 'admin_head', function( ) {
                echo '<style>
                    .column-thumbnail, .column-sec_title {
                        width: 125px;
                    }
                    .column-thumbnail img {
                        max-width: 125px;
                        height: auto;
                    }
                </style>';
            } );

        }

    }

}
