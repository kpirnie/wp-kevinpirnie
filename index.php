<?php
/** 
 * index.php
 * 
 * This is the main index template
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
?>

<section <?php post_class( 'w-full pt-6 px-4 sm:px-8 md:px-16' ); ?>>

    <?php echo KPT_BreadCrumbs::get_base_breadcrumbs(); ?>
    
    <div class="mb-8">
        <h1 class="text-4xl font-bold mb-2 kp-gradient-text">
            <?php
            if ( is_archive( ) ) {
                the_archive_title( );
            } elseif ( is_search( ) ) {
                echo 'Search Results for: ' . get_search_query( );
            }
            ?>
        </h1>
        <?php if ( is_archive( ) && get_the_archive_description( ) ): ?>
            <div class="text-gray-600 dark:text-gray-400"><?php the_archive_description( ); ?></div>
        <?php endif; ?>
    </div>
    
    <?php if ( have_posts( ) ): ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while ( have_posts( ) ): the_post( ); ?>
                <?php get_template_part( 'partials/content/posts' ); ?>
            <?php endwhile; ?>
        </div>
        
        <div class="mt-12">
            <?php
            echo get_the_posts_pagination( array(
                'mid_size' => 2,
                'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>',
                'next_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>',
            ) );
            ?>
        </div>

    <?php else: ?>

        <div class="text-center py-12">
            <p class="text-xl text-gray-600 dark:text-gray-400">No posts found.</p>
        </div>
        
    <?php endif; ?>

</section>

<?php 

// get the footer
get_footer( );
