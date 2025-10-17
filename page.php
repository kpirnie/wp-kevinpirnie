<?php
/** 
 * page.php
 * 
 * This is the page template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// get the header
get_header(); 

// setup post data
the_post();

// Get assigned heroes
$heroes = get_post_meta( get_the_ID(), 'kpt_hero', false );

?>

<?php if ( ! empty( $heroes ) ) : ?>
    
    <?php if ( count( $heroes ) > 1 ) : ?>

        <!-- Multiple Heroes - Slideshow -->
        <div class="kpt-hero-slideshow w-full relative h-[150px] md:h-[350px]">
            <?php foreach ( $heroes as $index => $hero_id ) : 
                $hero_post = get_post( $hero_id );
                $hero_title = get_post_meta( $hero_id, 'kpt_hero_title', true );
                $hero_content = get_post_meta( $hero_id, 'kpt_hero_content', true );
                $hero_image = get_the_post_thumbnail_url( $hero_id, 'full' );
            ?>
                <div class="kpt-hero-slide <?php echo $index === 0 ? 'active' : ''; ?> w-full h-full bg-cover bg-center" style="background-image: url('<?php echo esc_url( $hero_image ); ?>');">
                    <div class="kpt-hero-content">
                        <?php if ( $hero_title ) : ?>
                            <h2 class="kpt-hero-title"><?php echo esc_html( $hero_title ); ?></h2>
                        <?php endif; ?>
                        <?php if ( $hero_content ) : ?>
                            <div class="kpt-hero-text"><?php echo wp_kses_post( $hero_content ); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <!-- Slideshow Controls -->
            <button class="kpt-hero-prev" aria-label="Previous slide">&lsaquo;</button>
            <button class="kpt-hero-next" aria-label="Next slide">&rsaquo;</button>
            <div class="kpt-hero-dots"></div>
        </div>
        
    <?php else : ?>
        <!-- Single Hero -->
        <?php 
            $hero_id = $heroes[0];
            $hero_post = get_post( $hero_id );
            $hero_title = get_post_meta( $hero_id, 'kpt_hero_title', true );
            $hero_content = get_post_meta( $hero_id, 'kpt_hero_content', true );
            $hero_image = get_the_post_thumbnail_url( $hero_id, 'full' );
        ?>
        <div class="kpt-hero-single w-full relative h-[150px] md:h-[350px] bg-cover bg-center" style="background-image: url('<?php echo esc_url( $hero_image ); ?>');">
            <div class="kpt-hero-content">
                <?php if ( $hero_title ) : ?>
                    <h2 class="kpt-hero-title"><?php echo esc_html( $hero_title ); ?></h2>
                <?php endif; ?>
                <?php if ( $hero_content ) : ?>
                    <div class="kpt-hero-text"><?php echo wp_kses_post( $hero_content ); ?></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    
<?php elseif ( has_post_thumbnail() ) : ?>
    <!-- Fallback to Featured Image as Hero -->
    <div class="kpt-hero-single w-full relative h-[150px] md:h-[350px] bg-cover bg-center" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID( ), 'full' ) ); ?>');"></div>
<?php endif; ?>

<!-- Breadcrumbs -->
<?php echo KPT_BreadCrumbs::get_base_breadcrumbs(); ?>

<!-- Page Content -->
<section id="post-<?php the_ID( ); ?>" <?php post_class( 'w-full pt-6 px-4 sm:px-8 md:px-16' ); ?>>

    <header class="mb-8">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 kp-gradient-text">
            <?php the_title( ); ?>
        </h1>
    </header>
    
    <div class="article-content prose prose-lg mb-8">
        <?php the_content (); ?>
    </div>
</section>

<?php 

get_footer( );