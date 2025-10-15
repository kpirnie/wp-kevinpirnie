<?php get_header(); ?>

    <?php echo KPT_BreadCrumbs::get_base_breadcrumbs(); ?>
    
    <?php while (have_posts()): the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('w-full'); ?>>
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
            
            <div class="article-content prose prose-lg mb-8">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>

<?php get_footer(); ?>