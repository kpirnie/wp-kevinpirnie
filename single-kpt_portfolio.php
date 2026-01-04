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

    <?php echo KPT_BreadCrumbs::get_base_breadcrumbs( ); ?>
    
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
                
                <!-- Recent Portfolio Items -->
                <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-100">Recent Projects</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php
                        $recent_portfolio = get_posts(array(
                            'post_type' => 'kpt_portfolio',
                            'posts_per_page' => -1,
                            'orderby' => 'title',
                            'order' => 'ASC',
                            'post__not_in' => array(get_the_ID())
                        ));
                        foreach($recent_portfolio as $portfolio_item) {
                            echo '<a href="' . get_permalink($portfolio_item->ID) . '" class="inline-block px-3 py-1 bg-gray-700 text-gray-300 rounded-full hover:bg-gradient-to-r hover:from-[#599bb8] hover:to-[#2d7696] hover:text-white transition-all text-sm">' . esc_html($portfolio_item->post_title) . '</a>';
                        }
                        ?>
                    </div>
                </div>
                
            </div>
        </aside>

    </div>

</section>

<?php 

get_footer( );