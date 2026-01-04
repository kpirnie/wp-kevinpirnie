<?php
/** 
 * partials/cpts/portfolio.php
 * 
 * Portfolio slideshow template with Ken Burns and parallax effects
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// Get portfolio items in random order
$args = array(
    'post_type'      => 'kpt_portfolio',
    'posts_per_page' => 5,
    'post_status'    => 'publish',
    'orderby'        => 'rand',
);

$portfolio_items = get_posts( $args );

if ( empty( $portfolio_items ) ) {
    return;
}
?>

<div class="kpt-portfolio-slideshow relative w-full h-[350px] md:h-[400px] lg:h-[450px] overflow-hidden">
    
    <?php foreach ( $portfolio_items as $index => $item ) : 
        $item_id = $item->ID;
        $title = $item->post_title;
        $excerpt = $item->post_excerpt;
        $content = $item->post_content;
        $image_size = get_query_var( 'portfolio_image_size', 'portfolio' );
        $image = get_the_post_thumbnail_url( $item_id, $image_size );
        
        // Get portfolio settings
        $settings = get_post_meta( $item_id, 'kpt_portfolio_settings', true );
        $link_data = isset( $settings['portfolio_url'] ) ? $settings['portfolio_url'] : array();
        $url = isset( $link_data['url'] ) ? $link_data['url'] : '';
        $link_text = isset( $link_data['text'] ) ? $link_data['text'] : 'View Project';
        $link_target = isset( $link_data['target'] ) && ! empty( $link_data['target'] ) ? $link_data['target'] : '_blank';
        
        // Randomize Ken Burns direction
        $kb_effects = array( 'kb-zoom-in', 'kb-zoom-out', 'kb-pan-left', 'kb-pan-right' );
        $kb_effect = $kb_effects[ array_rand( $kb_effects ) ];
    ?>
        <div class="kpt-portfolio-slide <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>">
            
            <!-- Parallax Background -->
            <div class="kpt-portfolio-bg <?php echo esc_attr( $kb_effect ); ?>" 
                 style="background-image: url('<?php echo esc_url( $image ); ?>');">
            </div>
            
            <!-- Overlay -->
            <div class="kpt-portfolio-overlay h-[75%]"></div>
            
            <!-- Content -->
            <div class="kpt-portfolio-content h-[75%]">
                <div class="kpt-portfolio-content-inner">
                    <?php if ( $title ) : ?>
                        <h2 class="kpt-portfolio-title"><?php echo esc_html( $title ); ?></h2>
                    <?php endif; ?>
                    
                    <?php if ( $excerpt ) : ?>
                        <p class="kpt-portfolio-excerpt"><?php echo esc_html( $excerpt ); ?></p>
                    <?php elseif ( $content ) : ?>
                        <div class="kpt-portfolio-excerpt"><?php echo wp_trim_words( wp_strip_all_tags( $content ), 30 ); ?></div>
                    <?php endif; ?>
                    
                    <?php if ( $url ) : ?>
                        <a href="<?php echo esc_url( $url ); ?>" 
                           target="<?php echo esc_attr( $link_target ); ?>" 
                           class="kpt-portfolio-link group">
                            <span><?php echo esc_html( $link_text ); ?></span>
                            <span class="fa-solid fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
    <?php endforeach; ?>
    
    <?php if ( count( $portfolio_items ) > 1 ) : ?>
        <!-- Navigation Dots -->
        <div class="kpt-portfolio-dots">
            <?php foreach ( $portfolio_items as $index => $item ) : ?>
                <button class="kpt-portfolio-dot <?php echo $index === 0 ? 'active' : ''; ?>" 
                        data-index="<?php echo $index; ?>"
                        aria-label="Go to slide <?php echo $index + 1; ?>">
                </button>
            <?php endforeach; ?>
        </div>
        
        <!-- Navigation Arrows -->
        <button class="kpt-portfolio-prev" aria-label="Previous slide">
            <span class="fa-solid fa-chevron-left"></span>
        </button>
        <button class="kpt-portfolio-next" aria-label="Next slide">
            <span class="fa-solid fa-chevron-right"></span>
        </button>
    <?php endif; ?>
    
    <!-- Progress Bar -->
    <div class="kpt-portfolio-progress">
        <div class="kpt-portfolio-progress-bar"></div>
    </div>
    
</div>