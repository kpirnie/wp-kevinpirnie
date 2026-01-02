<?php
/** 
 * single.php
 * 
 * This is the single article template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// pull in the header
get_header( ); 
?>

<section <?php post_class( 'w-full pt-6 px-4 sm:px-8 md:px-16' ); ?>>

    <?php echo KPT_BreadCrumbs::get_base_breadcrumbs(); ?>
    
    <?php while (have_posts()): the_post(); ?>
        <div class="w-full flex flex-col lg:flex-row gap-8">
            
            <!-- Main Content - 2/3 width -->
            <article id="post-<?php the_ID(); ?>" <?php post_class('w-full lg:w-2/3'); ?>>
                <header class="mb-8">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 kp-gradient-text">
                        <?php the_title(); ?>
                    </h1>
                    
                    <div class="flex flex-wrap items-center justify-end gap-4 text-sm text-gray-400">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <?php echo get_the_date(); ?>
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            <?php the_author(); ?>
                        </span>
                    </div>
                </header>
                
                <?php if (has_post_thumbnail()): ?>
                    <div class="mb-8 rounded-lg overflow-hidden h-auto lg:h-96">
                        <?php the_post_thumbnail('full', array('class' => 'w-full h-full object-cover')); ?>
                    </div>
                <?php endif; ?>
                
                <div class="article-content prose prose-lg mb-8">
                    <?php the_content(); ?>
                </div>
                
                <?php
                $categories = get_the_category();
                if ($categories):
                ?>
                <div class="border-t border-gray-700 pt-6 mb-8">
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-sm font-semibold text-gray-300">Categories:</span>
                        <?php
                        foreach ($categories as $category) {
                            echo '<a href="' . get_category_link($category->term_id) . '" class="text-xs px-3 py-1 bg-gray-700 text-gray-300 rounded-full hover:bg-gray-600 transition-colors">' . esc_html($category->name) . '</a>';
                        }
                        ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if (has_tag()): ?>
                    <div class="border-t border-gray-700 pt-6 mb-8">
                        <div class="flex flex-wrap gap-2 items-center">
                            <span class="text-sm font-semibold text-gray-300">Tags:</span>
                            <?php
                            $tags = get_the_tags();
                            if ($tags) {
                                foreach ($tags as $tag) {
                                    echo '<a href="' . get_tag_link($tag->term_id) . '" class="text-xs px-3 py-1 bg-orange-900 text-orange-200 rounded-full hover:bg-orange-800 transition-colors">#' . esc_html($tag->name) . '</a>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="border-t border-b border-gray-700 py-6 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <?php
                            $prev_post = get_previous_post();
                            if ($prev_post): ?>
                                <a href="<?php echo get_permalink($prev_post); ?>" class="flex items-start text-[#599bb8] hover:text-blue-700 transition-colors">
                                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    <span class="text-sm"><?php echo esc_html( $prev_post->post_title ); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="md:text-right">
                            <?php
                            $next_post = get_next_post();
                            if ($next_post): ?>
                                <a href="<?php echo get_permalink($next_post); ?>" class="flex items-start md:justify-end text-[#599bb8] hover:text-blue-700 transition-colors">
                                    <span class="text-sm md:order-1"><?php echo esc_html( $next_post->post_title ); ?></span>
                                    <svg class="w-5 h-5 ml-2 flex-shrink-0 mt-0.5 md:order-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </article>
            
            <!-- Sidebar - 1/3 width -->
            <aside class="w-full lg:w-1/3">
                <div class="lg:sticky lg:top-24">
                    
                    <!-- Search Widget -->
                    <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-100">Search</h3>
                        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <div class="flex gap-2">
                                <input type="search" 
                                    name="s" 
                                    placeholder="Search..." 
                                    class="flex-1 px-3 py-2 rounded-lg border border-gray-700 bg-gray-900 text-gray-100 focus:outline-none focus:ring-2 focus:ring-[#599bb8]"
                                    value="<?php echo get_search_query(); ?>">
                                <button type="submit" 
                                        class="px-4 py-2 bg-gradient-to-r from-[#599bb8] to-[#2d7696] text-white rounded-lg transition-all hover:from-[#43819c] hover:to-[#2d7696]">
                                    <span class="fa-solid fa-magnifying-glass"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Archives Widget -->
                    <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-100">Archives</h3>
                        <ul class="space-y-2 list-disc list-inside">
                            <?php
                            wp_get_archives(array(
                                'type' => 'monthly',
                                'limit' => 12,
                                'format' => 'custom',
                                'before' => '<li>',
                                'after' => '</li>',
                                'show_post_count' => true,
                                'echo' => true
                            ));
                            ?>
                        </ul>
                    </div>
                    
                    <!-- Categories Widget -->
                    <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-100">Categories</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php
                            $categories = get_categories(array(
                                'orderby' => 'name',
                                'order' => 'ASC'
                            ));
                            foreach($categories as $category) {
                                echo '<a href="' . get_category_link($category->term_id) . '" class="text-xs px-3 py-1 bg-gray-700 text-gray-300 rounded-full hover:bg-blue-900 hover:text-white transition-colors">' . $category->name . '</a>';
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- Tags Cloud Widget -->
                    <?php
                    $tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 10000));
                    if ($tags):
                    ?>
                    <div class="bg-gray-800 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-100">Tag Cloud</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php
                            foreach($tags as $tag) {
                                echo '<a href="' . get_tag_link($tag->term_id) . '" class="text-xs px-3 py-1 bg-gray-700 text-gray-300 rounded-full hover:bg-blue-900 hover:text-white transition-colors">' . $tag->name . '</a>';
                            }
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                </div>
            </aside>

        </div>
    <?php endwhile; ?>

</section>

<?php 

// pull in the footer
get_footer(); 
