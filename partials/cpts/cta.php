<?php
/** 
 * partials/cpts/cta.php
 * 
 * This is the CTA display template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// Get CTA ID - can be passed as variable or from current post
$cta_id = isset( $cta_id ) ? $cta_id : get_the_ID();

// Get CTA data
$cta_title = get_the_title( $cta_id );
$cta_content = get_post_field( 'post_content', $cta_id );
$cta_featured_image = get_the_post_thumbnail_url( $cta_id, 'full' );

// get the buttons for the cta
$cta_buttons = get_post_meta( $cta_id, 'cta_buttons', true );var_dump($cta_buttons);

// Determine if we have a background image
$has_bg_image = ! empty( $cta_featured_image );
?>

<div class="kpt-cta-container w-full my-8">
    <div class="kpt-cta relative overflow-hidden rounded-lg shadow-lg transition-shadow duration-300 hover:shadow-xl <?php echo $has_bg_image ? 'min-h-[300px]' : 'bg-gradient-to-br from-gray-800 to-gray-900'; ?>">
        
        <?php if ( $has_bg_image ) : ?>
            <!-- Background Image with Overlay -->
            <div class="kpt-cta-bg absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo esc_url( $cta_featured_image ); ?>');">
                <div class="absolute inset-0 bg-gray-900 opacity-85"></div>
            </div>
        <?php endif; ?>
        
        <!-- Content Container -->
        <div class="kpt-cta-content relative z-10 px-6 py-12 md:px-16">
            <div class="max-w-4xl mx-auto text-center">
                
                <?php if ( ! empty( $cta_title ) ) : ?>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">
                        <?php echo esc_html( $cta_title ); ?>
                    </h2>
                <?php endif; ?>
                
                <?php if ( ! empty( $cta_content ) ) : ?>
                    <div class="text-lg text-gray-200 mb-8 leading-relaxed">
                        <?php echo wp_kses_post( $cta_content ); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Buttons -->
                <?php if ( ! empty( $primary_button_text ) || ! empty( $secondary_button_text ) ) : ?>
                    <div class="flex flex-wrap gap-4 justify-center items-center">
                        
                        <?php if ( ! empty( $primary_button_text ) && ! empty( $primary_button_url ) ) : ?>
                            <a href="<?php echo esc_url( $primary_button_url ); ?>" 
                               class="btn-primary inline-flex items-center gap-2 group">
                                <span><?php echo esc_html( $primary_button_text ); ?></span>
                                <span class="fa-solid fa-arrow-right text-sm transition-transform group-hover:translate-x-1"></span>
                            </a>
                        <?php endif; ?>
                        
                        <?php if ( ! empty( $secondary_button_text ) && ! empty( $secondary_button_url ) ) : ?>
                            <a href="<?php echo esc_url( $secondary_button_url ); ?>" 
                               class="btn-secondary inline-flex items-center gap-2 group">
                                <span><?php echo esc_html( $secondary_button_text ); ?></span>
                                <span class="fa-solid fa-arrow-right text-sm transition-transform group-hover:translate-x-1"></span>
                            </a>
                        <?php endif; ?>
                        
                    </div>
                <?php endif; ?>
                
            </div>
        </div>
        
    </div>
</div>