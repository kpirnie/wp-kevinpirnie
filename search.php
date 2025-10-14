<?php get_header(); ?>

    <?php kp_breadcrumbs(); ?>
    
    <div class="mb-8">
        <h1 class="text-4xl font-bold mb-2 kp-gradient-text">
            Search Results for: <?php echo get_search_query(); ?>
        </h1>
        <p class="text-gray-600 dark:text-gray-400">
            <?php global $wp_query; echo $wp_query->found_posts; ?> results found
        </p>
    </div>
    
    <?php if (have_posts()): ?>
        <div class="space-y-6">
            <?php while (have_posts()): the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow duration-300'); ?>>
                    <div class="flex gap-6">
                        <?php if (has_post_thumbnail()): ?>
                            <a href="<?php the_permalink(); ?>" class="flex-shrink-0 hidden md:block">
                                <?php the_post_thumbnail('thumbnail', array('class' => 'w-32 h-32 object-cover rounded-lg')); ?>
                            </a>
                        <?php endif; ?>
                        
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold mb-2">
                                <a href="<?php the_permalink(); ?>" class="text-gray-900 dark:text-gray-100 hover:text-[#599bb8] dark:hover:text-blue-400 transition-colors">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                                <?php echo get_the_date(); ?> | <?php the_category(', '); ?>
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
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-6">No results found for your search.</p>
            <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="max-w-md mx-auto">
                <div class="flex gap-2">
                    <input type="search" name="s" placeholder="Try another search..." class="flex-1 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r bg-kp-gradient hover:from-blue-700 hover:to-teal-700 text-white rounded-lg transition-all">
                        Search
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>

<?php get_footer(); ?>