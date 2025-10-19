<?php
/** 
 * page.php
 * 
 * This is the page template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// get the header
get_header( ); 

// setup post data
the_post( );

// pull in the heroes partial
get_template_part( 'partials/cpts/heroes' );

// pull in the breadcrumbs if needed
echo KPT_BreadCrumbs::get_base_breadcrumbs( ); 
?>

<!-- Page Content -->
<section id="page-<?php the_ID( ); ?>" <?php post_class( 'w-full pt-6 px-4 sm:px-8 md:px-16' ); ?>>

    <div class="article-content prose prose-lg mb-8">
        <?php the_content( ); ?>
    </div>

</section>

<?php 

// pull in the footer
get_footer( );
