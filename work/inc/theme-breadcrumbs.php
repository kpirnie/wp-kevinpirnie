<?php
/** 
 * Theme Breadcrumb Nav
 * 
 * This class controls the breadcrumb navigation
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

if( ! class_exists( 'KPT_BreadCrumbs' ) ) {

    /** 
     * Class KPT_BreadCrumbs
     * 
     * The breadcrumb navigation class
     * 
     * @since 8.4
     * @access public
     * @author Kevin Pirnie <me@kpirnie.com>
     * @package Kevin Pirnie's Theme
     * 
    */
    class KPT_BreadCrumbs {

        /** 
         * get_base_breadcrumbs
         * 
         * Public method to return a html string of breadcrumb navigation
         * checks for a couple plugins, then attempts to build one manually
         * 
         * @since 7.4
         * @access public
         * @static
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package The Base
         * 
         * @return string This method returns an html string representing our breadcrumb navigation
         * 
        */
        public static function get_base_breadcrumbs( ) : string {

            // if we're on the home page we don't need this
            if ( ! in_array( true, array( is_home(), is_archive(), is_single(), is_search() ) ) ) {

                // just return
                return '';
            }

            // hold the returnable html string
            $_ret = '';

            // see if we have the yoast breadcrumbs
            if ( function_exists( 'yoast_breadcrumb' ) ) {

                // toss the breadcrumbs into our return
                $_ret = yoast_breadcrumb( );

            // see if we have All-In-One SEO breadcrumbs
            } elseif( function_exists( 'aioseo_breadcrumbs' ) ) {

                // toss the breadcrumbs into our return
                $_ret = aioseo_breadcrumbs( );

            // see if Breadcrumb NavXT is installed
            } elseif( function_exists( 'bcn_display' ) ) {

                // toss the breadcrumbs into our return
                $_ret = bcn_display( );

            // otherwise, try our built-in breadcrumber...
            } else {

                // few definitions
                global $post;

                // If you have custom taxonomy place it here
                $_custom_tax = '';

                // if we are not on the front page, we really don't need them...
                if( ! is_front_page( ) ) {

                    // show the HOME link
                    $_ret .= '<a href="' . esc_url( get_home_url( ) ) . '" rel="nofollow" title="' . esc_attr( get_bloginfo( 'name' ) ) . '">Home</a>';

                    // if it's single
                    if ( is_single( ) ) {

                        // get the current post type
                        $_pt = get_post_type( );

                        // it's it's NOT a post
                        if( $_pt != 'post' ) {

                            // get the poost type object 
                            $_pto = get_post_type_object( $_pt );

                            // now get the link to it
                            $_ptl = get_post_type_archive_link( $_pt );

                            // the link for it
                            $_ret .= '<a href="' . esc_url( $_ptl ) . '" title="' . esc_attr( $_ptl -> labels -> name ) . '">' . $_ptl -> labels -> name . '</a>';

                        }

                        // Get the categories
                        $_cat = get_the_category( $post -> ID );

                        // if it's not empty
                        if( ! empty( $_cat ) ) {

                            // Arrange category parent to the child
                            $_cat_vals = array_values( $_cat );
                            $_cat_last = end( $_cat_vals );
                            $_cat_parent = rtrim( get_category_parents( $_cat_last -> term_id, true, ',' ), ',' );
                            $_cat_parent = explode( ',', $_cat_parent );

                            // hold a string for these
                            $_cat_str = '';

                            // loop them
                            foreach( $_cat_parent as $_p ) {

                                $_cat_str .= '<span>' . $_p . '</span>';

                            }

                        }

                        // If it's a custom post type within a custom taxonomy
                        $_tax_exists = taxonomy_exists( $_custom_tax );

                        // make sure they exist
                        if( empty( $_cat_last ) && ! empty( $_custom_tax ) && $_tax_exists ) {

                            // setup the taxonomy data
                            $_tax_terms = get_the_terms( $post -> ID, $_custom_tax );
                            $_cat_id = $_tax_terms[0] -> term_id;
                            $_cat_link = get_term_link( $_tax_terms[0] -> term_id, $_custom_tax );
                            $_cat_name = $_tax_terms[0] -> name;

                        }

                        // make sure we're not empty
                        if( ! empty( $_cat_last ) ) {

                            // add the category string from above
                            $_ret .= $_cat_str;

                            // now add the title of the current post
                            $_ret .= '<span>' . get_the_title( ) . '</span>';

                        // otherwise see if the category id is not empty
                        } elseif( ! empty( $_cat_id ) ) {

                            // add the category's link
                            $ret .= '<a href="' . esc_url( $_cat_link ) . '" title="' . esc_attr( $_cat_name ) . '">' . esc_attr( $_cat_name ) . '</a>';

                            // now add the title of the current post
                            $_ret .= '<span>' . get_the_title( ) . '</span>';

                        // otherwise
                        } else {

                            // now add the title of the current post
                            $_ret .= '<span>' . get_the_title( ) . '</span>';

                        }

                    // if it's a page
                    } else if( is_page( ) ) {

                        // is there a parent?
                        if( $post -> post_parent ) {

                            // If child page, get parents
                            $_parents = get_post_ancestors( $post -> ID );

                            // Get parents in the right order
                            $_parents = array_reverse( $_parents );

                            // loop them
                            foreach( $_parents as $_parent ) {

                                // add the link
                                $_ret .= '<a href="' . esc_url( get_the_permalink( $_parent ) ) . '" title="' . esc_attr( get_the_title( $_parent ) ) . '">' . get_the_title( $_parent ) . '</a>';

                            }

                            // append the page title
                            $_ret .= '<span>' . $post -> post_title . '</span>';

                        // there aren't any
                        } else {

                            // append the page title
                            $_ret .= '<span>' . $post -> post_title . '</span>';

                        }

                    // if it's an archive
                    } else if( is_archive( ) ) {

                        // is it a category?
                        if( is_category( ) ) {

                            // get the parent category
                            $_parent = get_queried_object( ) -> category_parent;

                            // if it actually exists
                            if( $_parent !== 0 ) {

                                // get the actual category
                                $_pcat = get_category( $_parent );

                                // get the link for it
                                $_pcat_link = get_category_link( $_parent );

                                $_ret .= '<a href="' . esc_url( $_pcat_link ) . '" title="' . esc_attr( $_pcat -> name ) . '">' . $_pcat -> name . '</a>';

                            }

                            $_ret .= '<span>' . single_cat_title( '', false ) . '</span>';

                        // if it's a tag
                        } else if( is_tag( ) ) {

                            // Get tag information
                            $_term_id = get_query_var( 'tag_id' );
                            $_terms = get_terms( 'post_tag', array( 'include' => $_term_id ) );
                            $_term_name = $_terms[0] -> name;

                            // append it
                            $_ret .= '<span>' . $_term_name . '</span>';

                        // if it's a taxonomy
                        } else if( is_tax( ) ) {

                            // get the post type
                            $_pt = get_post_type( );

                            // if it's not a post
                            if( $_pt != 'post' ) {

                                // get the poost type object 
                                $_pto = get_post_type_object( $_pt );

                                // now get the link to it
                                $_ptl = get_post_type_archive_link( $_pt );

                                // the link for it
                                $_ret .= '<a href="' . esc_url( $_ptl ) . '" title="' . esc_attr( $_ptl -> labels -> name ) . '">' . $_ptl -> labels -> name . '</a>';

                            }

                            // get the name of the queried object
                            $_ret .= '<span>' . get_queried_object( ) -> name . '</span>';

                        // if it's the day
                        } else if( is_day( ) ) {

                            // append the year link
                            $_ret .= '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '" title="' . esc_attr( get_the_time( 'Y' ) ) . ' Archives">' . get_the_time( 'Y' ) . ' Archives</a>';

                            // append the month link
                            $_ret .= '<a href="' . esc_url( get_month_link( get_the_time( 'M' ) ) ) . '" title="' . esc_attr( get_the_time( 'M' ) ) . ' Archives">' . get_the_time( 'M' ) . ' Archives</a>';

                            // append the day
                            $_ret .= '<span>' . get_the_time( 'jS' ) . ' Archives</span>';

                        // or the month
                        } else if( is_month( ) ) {

                            // append the year link
                            $_ret .= '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '" title="' . esc_attr( get_the_time( 'Y' ) ) . ' Archives">' . get_the_time( 'Y' ) . ' Archives</a>';

                            // append the month
                            $_ret .= '<span>' . get_the_time( 'M' ) . ' Archives</span>';
                            
                        // or the year
                        } else if( is_year( ) ) {

                            // append the year
                            $_ret .= '<span>' . get_the_time( 'Y' ) . ' Archives</span>';

                        // or the author
                        } else if( is_author( ) ) {

                            // Get the author information
                            global $_author;
                            $_userdata = get_userdata( $_author );

                            // append the author
                            $_ret .= '<span>Author: ' . $_userdata -> display_name . '</span>';

                        // nope, just a plain ol' archive
                        } else {

                            // append the archive title
                            $_ret .= '<span>' . post_type_archive_title( ) . '</span>';

                        }

                    // if it's the search
                    } else if( is_search( ) ) {

                        // append
                        $_ret .= '<span>Search results for: '. get_search_query( ) .'</span>';

                    // if it's the 404
                    } else if( is_404( ) ) {

                        // append
                        $_ret .= '<span>Error: 404 Not Found</span>';

                    }

                }

            }

            // return it
            return $_ret;

        }
        
    }

}
