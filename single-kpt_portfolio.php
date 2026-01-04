<?php
/** 
 * single-kpt_portfolio.php
 * 
 * Single portfolio item template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

get_header( ); 

the_post( );

$settings = get_post_meta( get_the_ID(), 'kpt_portfolio_settings', true );
$link_data = isset( $settings['portfolio_url'] ) ? $settings['portfolio_url'] : array();
$external_url = isset( $link_data['url'] ) ? $link_data['url'] : '';
$link_text = isset( $link_data['text'] ) ? $link_data['text'] : 'View Project';
$link_target = isset( $link_data['target'] ) && ! empty( $link_data['target'] ) ? $link_data['target'] : '_blank';

?>

<section <?php post_class( 'w-full pt-6 px-4 sm:px-8 md:px-16' ); ?>>

    <?php get_template_part( 'partials/navigation/breadcrumbs' ); ?>
    
    <div class="w-full flex flex-col lg:flex-row gap-8">
        
        <!-- Main Content - 2/3 width -->
        <article class="w-full lg:w-2/3">
            
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="relative mb-8 rounded-lg overflow-hidden h-96 md:h-[500px]">
                    <?php the_post_thumbnail( 'full', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                    
                    <div class="absolute inset-0 kpt-portfolio-item-overlay"></div>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8">
                        <h1 class="text-3xl md:text-5xl font-bold mb-4 kp-gradient-text">
                            <?php the_title(); ?>
                        </h1>
                        
                        <?php if ( has_excerpt() ) : ?>
                            <div class="text-lg md:text-xl text-gray-200">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else : ?>
                <header class="mb-8">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 kp-gradient-text">
                        <?php the_title(); ?>
                    </h1>
                    
                    <?php if ( has_excerpt() ) : ?>
                        <div class="text-xl text-gray-400 mb-6">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>
                </header>
            <?php endif; ?>
            
            <div class="article-content prose prose-lg mb-8">
                <?php the_content(); ?>
            </div>
            
            <?php if ( $external_url ) : ?>
                <div class="mt-8">
                    <a href="<?php echo esc_url( $external_url ); ?>" 
                       target="<?php echo esc_attr( $link_target ); ?>"
                       class="btn-primary inline-flex items-center gap-2">
                        <span><?php echo esc_html( $link_text ); ?></span>
                        <span class="fa-solid fa-arrow-up-right-from-square"></span>
                    </a>
                </div>
            <?php endif; ?>
            
        </article>
        
        <!-- Sidebar - 1/3 width -->
        <aside class="w-full lg:w-1/3">
            <?php get_template_part( 'partials/sidebar', 'portfolio' ); ?>
        </aside>

    </div>

</section>

<?php 

get_footer( );