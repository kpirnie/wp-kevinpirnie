<?php
/** 
 * Performance class
 * 
 * This class is responsible for managing the performance of the theme
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
if( ! class_exists( 'KPT_Performance' ) ) {

    /** 
     * KPT_Performance
     * 
     * This class is responsible for managing some 
     * performance options and settings of the site
     * they will only be applied when KPT_DEBUG either does not exist, or is false
     * 
     * @since 8.4
     * @access public
     * @author Kevin Pirnie <me@kpirnie.com>
     * @package Kevin Pirnie's Theme
     * 
    */
    class KPT_Performance {

        // hold the debug flag
        private bool $is_debug;

        // fire up the class
        public function __construct( ) {

            // set the debug flag
            $this -> is_debug = ( defined( 'KPT_DEBUG' ) && KPT_DEBUG ) ? true : false;

        }

        /** 
         * manage_performance
         * 
         * Publicy manage the performance of the site's theme
         * 
         * @since 8.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        public function manage_performance( ) : void {

            // if we are not in debug mode
            if ( ! $this -> is_debug ) {

                // manage the scripts
                $this -> manage_scripts( );

                // now... hook into the wp_head action
                add_action( 'wp_head', function( ) {

                    // fire up the pre* functions
                    echo $this -> setup_prefetcher( );
                    echo $this -> setup_preloader( );
                    echo $this -> setup_prerenderer( );

                }, PHP_INT_MAX );

            }

            // fire up the cleanup crew no matter what
            $this -> cleanup_crew( );

        }

        /** 
         * cleanup_crew
         * 
         * Cleans up unnecessary items
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function cleanup_crew( ) : void {

            // remove the emoji styles and scripts actions
            remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
            remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
            remove_action( 'wp_print_styles', 'print_emoji_styles' );
            remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
            remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
            remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
            remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

            // remove them from the tinymce plugins
            add_filter( 'tiny_mce_plugins', function( $_plugs ) : array {

                // make sure the plugins is an array
                if( is_array( $_plugs ) ) {

                    // remove the wpemoji plugins from it and return
                    return array_diff( $_plugs, array( 'wpemoji' ) );

                // otherwise
                } else {

                    // return an empty array
                    return array( );
                }

            } );

            // check the resource hints for the emoji prefetch
            add_filter( 'wp_resource_hints', function( $_urls, $_rel_type ) : array {

                // if the relationship type is prefetch
                if( 'dns-prefetch' == $_rel_type ) {

                    // This filter is documented in wp-includes/formatting.php
                    $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

                    // remove it from the urls array
                    $_urls = array_diff( $_urls, array( $emoji_svg_url ) );
                }
                
                // return the urls array
                return $_urls;

            }, 10, 2 );
            
        }

        /** 
         * manage_scripts
         * 
         * Manage the script locations and querystrings
         * 
         * @since 8.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function manage_scripts( ) : void {

            // remove these from the head
            remove_action( 'wp_head', 'wp_print_scripts' ); 
            remove_action( 'wp_head', 'wp_print_head_scripts', 9 ); 
            remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
            
            // add them to the footer
            add_action( 'wp_footer', 'wp_print_scripts', 5 );
            add_action( 'wp_footer', 'wp_enqueue_scripts', 5 );
            add_action( 'wp_footer', 'wp_print_head_scripts', 5 ); 

            // Since gravityforms seems to be very popular, let's make sure the scripts for it are loaded properly as well
            if( has_filter( 'gform_init_scripts_footer' ) ) {

                // force gravity forms javascripts to the footer
                add_filter( 'gform_init_scripts_footer', '__return_true' );
            }

            // hook into our script and style loaders
            add_filter( 'style_loader_src', 'kp_remove_ver', 1, PHP_INT_MAX );
            add_filter( 'script_loader_src', 'kp_remove_ver', 1, PHP_INT_MAX );

            // make sure the function does not currently exist
            if( ! function_exists( 'kp_remove_ver' ) ) {
                function kp_remove_ver( $_src ) : string {
                    
                    // remove the assigned versioning querystrings from the source
                    $_src = remove_query_arg( array( 'ver', 'version', 'v' ), $_src );
                
                    // return the source		
                    return $_src;
                }
            }

            // Enqueue instant.page to load absolutely dead last
            add_action( 'wp_print_footer_scripts', function() {
                ?>
                <script src="//instant.page/5.2.0" type="module"></script>
                <?php
            }, PHP_INT_MAX );


        }

        /** 
         * get_all_scripts_and_styles
         * 
         * get the sites full list of 
         * scripts and stylesheets
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * @return array Array containing domains, scripts, and styles
         * 
        */
        private function get_all_scripts_and_styles( ) : array {

            // get our scripts global
            global $wp_scripts;

            // get out styles global
            global $wp_styles;

            // setup the returnable array with initial structure
            $_ret = array(
                'domains' => array(),
                'scripts' => array(),
                'styles'  => array()
            );

            // loop over the enqueued scripts
            foreach( $wp_scripts -> queue as $_hndl ) {

                // get the source
                $_src = $wp_scripts -> registered[$_hndl] -> src;

                // add to scripts array
                $_ret['scripts'][] = $_src;

                // extract and add domain if exists
                $_domain = parse_url( $_src, PHP_URL_HOST );
                if( ! empty( $_domain ) ) {
                    $_ret['domains'][] = $_domain;
                }

            }

            // loop over the enqueued styles
            foreach( $wp_styles -> queue as $_hndl ) {

                // get the source
                $_src = $wp_styles -> registered[$_hndl] -> src;

                // add to styles array
                $_ret['styles'][] = $_src;

                // extract and add domain if exists
                $_domain = parse_url( $_src, PHP_URL_HOST );
                if( ! empty( $_domain ) ) {
                    $_ret['domains'][] = $_domain;
                }

            }

            // remove duplicate domains
            $_ret['domains'] = array_unique( $_ret['domains'] );

            // return the returnable array
            return $_ret;    

        }

        /** 
         * setup_prefetcher
         * 
         * setup the prefetcher meta tag html strings
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * @return string HTML string of prefetch link tags
         * 
        */
        private function setup_prefetcher( ) : string {

            // get our array of scripts, styles, and domains
            $_arr = $this -> get_all_scripts_and_styles( );

            // build array of HTML strings instead of concatenating
            $_html_parts = array();

            // loop for script dns-prefetch
            foreach( $_arr['domains'] as $_domain ) {

                // add dns-prefetch for each unique domain
                $_html_parts[] = '<link rel="dns-prefetch" href="//' . esc_attr( $_domain ) . '" />';

            }

            // loop over the scripts and inject prefetch
            foreach( $_arr['scripts'] as $_script ) {

                // add prefetch tag for each script
                $_html_parts[] = '<link rel="prefetch" href="' . esc_url( $_script ) . '" as="script" />';

            }

            // loop over the styles and inject prefetch
            foreach( $_arr['styles'] as $_style ) {

                // add prefetch tag for each stylesheet
                $_html_parts[] = '<link rel="prefetch" href="' . esc_url( $_style ) . '" as="style" />';

            }

            // join all HTML parts with newlines (more efficient than repeated concatenation)
            return implode( PHP_EOL, $_html_parts ) . PHP_EOL;

        }

        /** 
         * setup_preloader
         * 
         * setup the preloader meta tag html strings
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * @return string HTML string of preload link tags
         * 
        */
        private function setup_preloader( ) : string {

            // get our array of scripts and styles
            $_arr = $this -> get_all_scripts_and_styles( );

            // build array of HTML strings instead of concatenating
            $_html_parts = array();

            // loop over the scripts and inject preload
            foreach( $_arr['scripts'] as $_script ) {

                // add preload tag for each script
                $_html_parts[] = '<link rel="preload" href="' . esc_url( $_script ) . '" as="script" />';

            }

            // loop over the styles and inject preload
            foreach( $_arr['styles'] as $_style ) {

                // add preload tag for each stylesheet
                $_html_parts[] = '<link rel="preload" href="' . esc_url( $_style ) . '" as="style" />';

            }

            // join all HTML parts with newlines (more efficient than repeated concatenation)
            return implode( PHP_EOL, $_html_parts ) . PHP_EOL;

        }

        /** 
         * setup_prerenderer
         * 
         * setup the prerenderer meta tag html strings
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * @return string HTML string of prerender link tags
         * 
        */
        private function setup_prerenderer( ) : string {

            // setup the post query arguments for maximum efficiency
            $args = array(
                'post_type'              => 'any',
                'post_status'            => 'publish',
                'posts_per_page'         => -1,
                'fields'                 => 'ids',
                'no_found_rows'          => true,
                'update_post_meta_cache' => false,
                'update_post_term_cache' => false,
                'suppress_filters'       => true,
            );
            
            // get all post ids
            $post_ids = get_posts( $args );

            // early return if no posts found
            if( empty( $post_ids ) ) {
                return '';
            }

            // build array of HTML strings instead of concatenating
            $_html_parts = array();

            // loop over post IDs and build prerender tags
            foreach ( $post_ids as $post_id ) {

                // get the permalink
                $_link = get_the_permalink( $post_id );

                // add prerender tag for each post
                $_html_parts[] = '<link rel="prerender" href="' . esc_url( $_link ) . '" />';

            }

            // join all HTML parts with newlines (more efficient than repeated concatenation)
            return implode( PHP_EOL, $_html_parts ) . PHP_EOL;

        }

    }

}
