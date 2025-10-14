<?php get_header(); ?>

<div class="container mx-auto px-4 py-8">
    <?php kp_breadcrumbs(); ?>
    
    <div class="mb-8">
        <h1 class="text-4xl font-bold mb-2 text-transparent bg-clip-text bg-gradient-to-r bg-kp-gradient dark:from-blue-400 dark:to-teal-400">
            <?php the_archive_title(); ?>
        </h1>
        <?php if (get_the_archive_description()): ?>
            <div class="text-gray-600 dark:text-gray-400 mt-2">
                <?php the_archive_description(); ?>
            </div>
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
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-2">
                            <a href="<?php the_permalink(); ?>" class="text-gray-900 dark:text-gray-100 hover:text-[#599bb8] dark:hover:text-blue-400 transition-colors">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                            <?php echo get_the_date(); ?>
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