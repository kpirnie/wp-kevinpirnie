<?php get_header(); ?>

<div class="container mx-auto px-4 py-8">
    <?php kp_breadcrumbs(); ?>
    
    <div class="mb-8">
        <h1 class="text-4xl font-bold mb-2 text-transparent bg-clip-text bg-gradient-to-r bg-kp-gradient dark:from-blue-400 dark:to-teal-400">
            <?php
            if (is_home() && !is_front_page()) {
                echo 'Blog';
            } elseif (is_archive()) {
                the_archive_title();
            } elseif (is_search()) {
                echo 'Search Results for: ' . get_search_query();
            } else {
                bloginfo('name');
            }
            ?>
        </h1>
        <?php if (is_archive() && get_the_archive_description()): ?>
            <div class="text-gray-600 dark:text-gray-400"><?php the_archive_description(); ?></div>
        <?php endif; ?>
    </div>
    
    <?php if (have_posts()): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while (have_posts()): the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300'); ?>>
                    <?php if (has_post_thumbnail()): ?>
                        <a href="<?php the_permalink(); ?>" class="block">
                            <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-48 object-cover')); ?>
                        </a>
                    <?php else: ?>
                        <a href="<?php the_permalink(); ?>" class="block bg-gradient-to-br bg-kp-gradient h-48 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <div class="flex flex-wrap gap-2 mb-3">
                            <?php
                            $categories = get_the_category();
                            if ($categories) {
                                foreach ($categories as $category) {
                                    echo '<a href="' . get_category_link($category->term_id) . '" class="text-xs px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors">' . esc_html($category->name) . '</a>';
                                }
                            }
                            ?>
                        </div>
                        
                        <h2 class="text-xl font-bold mb-2">
                            <a href="<?php the_permalink(); ?>" class="text-gray-900 dark:text-gray-100 hover:text-[#599bb8] dark:hover:text-blue-400 transition-colors">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-3 flex items-center gap-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                <?php echo get_the_date(); ?>
                            </span>
                        </div>
                        
                        <div class="text-gray-600 dark:text-gray-300 mb-4">
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-[#599bb8] dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                            Read More
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        
        <div class="mt-12">
            <?php
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>',
                'next_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>',
            ));
            ?>
        </div>
    <?php else: ?>
        <div class="text-center py-12">
            <p class="text-xl text-gray-600 dark:text-gray-400">No posts found.</p>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>