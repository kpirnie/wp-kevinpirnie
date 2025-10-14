<?php get_header(); ?>

    <?php kp_breadcrumbs(); ?>
    
    <?php while (have_posts()): the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('max-w-4xl mx-auto'); ?>>
            <header class="mb-8">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 kp-gradient-text">
                    <?php the_title(); ?>
                </h1>
            </header>
            
            <?php if (has_post_thumbnail()): ?>
                <div class="mb-8 rounded-lg overflow-hidden">
                    <?php the_post_thumbnail('full', array('class' => 'w-full h-auto')); ?>
                </div>
            <?php endif; ?>
            
            <div class="prose prose-lg dark:prose-invert max-w-none">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>

<?php get_footer(); ?>