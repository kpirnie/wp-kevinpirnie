<?php
/** 
 * navigation/breadcrumbs.php
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>
<nav class="mb-6 text-right">
    <?php
        yoast_breadcrumb( );
    ?>
</nav>