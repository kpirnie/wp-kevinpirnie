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

            // pull in our assets
            // $this -> kpt_assets( );

                
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

        }

    }

}
