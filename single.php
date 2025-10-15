<?php get_header(); ?>

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
                    <div class="flex justify-between">
                        <div>
                            <?php
                            $prev_post = get_previous_post();
                            if ($prev_post): ?>
                                <a href="<?php echo get_permalink($prev_post); ?>" class="flex items-center text-[#599bb8] hover:text-blue-700 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    <span class="text-sm">Previous Post</span>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php
                            $next_post = get_next_post();
                            if ($next_post): ?>
                                <a href="<?php echo get_permalink($next_post); ?>" class="flex items-center text-[#599bb8] hover:text-blue-700 transition-colors">
                                    <span class="text-sm">Next Post</span>
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <?php
                if (comments_open() || get_comments_number()) {
                    comments_template();
                }
                ?>
            </article>
            
            <!-- Sidebar - 1/3 width -->
            <aside class="w-full lg:w-1/3">
                <div class="lg:sticky lg:top-24">
                    <!-- Recent Posts Widget -->
                    <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-100">Recent Posts</h3>
                        <ul class="space-y-3 list-disc list-inside">
                            <?php
                            $recent_posts = wp_get_recent_posts(array(
                                'numberposts' => 5,
                                'post_status' => 'publish'
                            ));
                            foreach($recent_posts as $recent) {
                                echo '<li><a href="' . get_permalink($recent['ID']) . '" class="text-sm text-gray-400 hover:text-[#599bb8] transition-colors">' . $recent['post_title'] . '</a></li>';
                            }
                            wp_reset_query();
                            ?>
                        </ul>
                    </div>
                    
                    <!-- Categories Widget -->
                    <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-100">Categories</h3>
                        <ul class="space-y-2 list-disc list-inside">
                            <?php
                            $categories = get_categories(array(
                                'orderby' => 'count',
                                'order' => 'DESC',
                                'number' => 10
                            ));
                            foreach($categories as $category) {
                                echo '<li><a href="' . get_category_link($category->term_id) . '" class="text-sm text-gray-400 hover:text-white transition-colors"><span>' . $category->name . '</span><span class="text-gray-600"> (' . $category->count . ')</span></a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    
                    <!-- Tags Cloud Widget -->
                    <?php
                    $tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 20));
                    if ($tags):
                    ?>
                    <div class="bg-gray-800 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-100">Popular Tags</h3>
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

<?php get_footer(); ?>