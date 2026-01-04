<?php
/** 
 * partials/cpts/portfolio.php
 * 
 * Portfolio masonry grid with random corner overlays
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

$args = array(
    'post_type'      => 'kpt_portfolio',
    'posts_per_page' => 9,
    'post_status'    => 'publish',
    'orderby'        => 'rand',
);

$portfolio_items = get_posts( $args );

if ( empty( $portfolio_items ) ) {
    return;
}

$positions = array( 'bottom-right' );
$heights = array( 'h-64', 'h-80', 'h-96', 'h-72' );
?>

<div class="kpt-portfolio-masonry w-full my-8">
    
    <?php foreach ( $portfolio_items as $index => $item ) : 
        $item_id = $item->ID;
        $title = $item->post_title;
        $excerpt = $item->post_excerpt;
        $content = $item->post_content;
        $image_size = get_query_var( 'portfolio_image_size', 'portfolio-masonry' );
        $image = get_the_post_thumbnail_url( $item_id, $image_size );
        
        $settings = get_post_meta( $item_id, 'kpt_portfolio_settings', true );
        $link_data = isset( $settings['portfolio_url'] ) ? $settings['portfolio_url'] : array();
        $url = get_permalink( $item_id );
        
        $position = $positions[ array_rand( $positions ) ];
        $height = $heights[ array_rand( $heights ) ];
        
        $position_classes = array(
            'top-left' => 'top-0 left-0',
            'top-right' => 'top-0 right-0',
            'bottom-left' => 'bottom-0 left-0',
            'bottom-right' => 'bottom-0 right-0'
        );
    ?>
        <div class="kpt-portfolio-item relative overflow-hidden rounded-md group mb-4 <?php echo esc_attr( $height ); ?>">
            
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 ease-out group-hover:scale-110" 
                 style="background-image: url('<?php echo esc_url( $image ); ?>');">
            </div>
            
            <div class="absolute inset-0 bg-gradient-to-br from-black/60 to-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-700 ease-out"></div>
            
            <div class="kpt-portfolio-overlay absolute <?php echo esc_attr( $position_classes[$position] ); ?> w-full p-4 bg-black/85 backdrop-blur-sm transition-all duration-700 ease-out group-hover:bg-black/95">
                
                <?php if ( $title ) : ?>
                    <h4 class="text-white font-bold text-lg mb-2 line-clamp-2"><?php echo esc_html( $title ); ?></h4>
                <?php endif; ?>
                
                <?php if ( $excerpt ) : ?>
                    <p class="text-gray-300 text-sm mb-3 line-clamp-2"><?php echo esc_html( $excerpt ); ?></p>
                <?php elseif ( $content ) : ?>
                    <p class="text-gray-300 text-sm mb-3 line-clamp-2"><?php echo wp_trim_words( wp_strip_all_tags( $content ), 15 ); ?></p>
                <?php endif; ?>
                
                <a href="<?php echo esc_url( $url ); ?>" 
                   class="inline-flex items-center text-[#599bb8] hover:text-[#43819c] text-sm font-medium transition-colors duration-300 group/link">
                    <span>View Project</span>
                    <span class="fa-solid fa-arrow-right ml-2 transition-transform duration-300 group-hover/link:translate-x-1"></span>
                </a>
                
            </div>
            
        </div>
    <?php endforeach; ?>
    
</div>