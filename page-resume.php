<?php
/**
 * 
 * page-resume.php
 * 
 * This is the resume page's template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
 * Template Name: Kevin's Resume
 * Template Post Type: page
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// get the page's ID
$id = get_the_ID( );

// get the custom fields
$resume_summary = get_post_meta( $id, 'resume_summary', true);
$resume_contact_left = get_post_meta( $id, 'resume_contact_left', true);
$resume_contact_right = get_post_meta( $id, 'resume_contact_right', true);

?>
<!DOCTYPE html>
<html <?php language_attributes( ); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Kevin C. Pirnie" />
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php wp_head( ); ?>
        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="/wp-content/uploads/2025/10/kevinpirnie-favicon-initials.svg">
        <link rel="alternate icon" type="image/webp" href="/wp-content/uploads/2025/10/kevinpirnie-favicon-initials_512.webp">
        <link rel="apple-touch-icon" href="/wp-content/uploads/2025/10/kevinpirnie-favicon-initials_512.webp">
        <style type="text/css">
            
            .show-print{

            }

            @media print {
                body{background:#fff !important;color:#000 !important;}
                .print-link{display:none !important;}
                .hide-print{display:none !important;}
                .no-top{margin-top:0 !important;}
                .show-print{display:block !important;}
            }

        </style>
    </head>
    <body <?php body_class( 'bg-gray-900 text-gray-100 font-mono' ); ?>>
        <?php wp_body_open( ); ?>
        
        <header id="main-header" class="bg-gray-900/95 ">

            <div class="w-full p-4 sm:px-8 md:px-16">

                <div class="hide-print">
                    <a href="<?php echo home_url( '/' ); ?>" class="header-logo">
                        <?php
                            // get the SVG content for my logo
                            echo file_get_contents( ABSPATH . '/wp-content/uploads/2025/10/kevinpirnie-logo-color.svg' );
                        ?>
                    </a>
                </div>

                <div class="show-print">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Kevin C. Pirnie</h1>
                </div>
                
                <h1 class="text-4xl md:text-5xl font-bold mb-4 kp-gradient-text">
                    <?php
                        _e( get_the_title( ), 'kpt' );
                    ?>
                </h1>
                
                <p>
                    <?php
                        _e( $resume_summary, 'kpt' );
                    ?>                
                </p>
            </div>

        </header>

        <div id="top-header" class="resume-bottom-header sticky text-white backdrop-blur-sm shadow-md shadow-gray-950 hide-print">

            <div class="w-full px-4 sm:px-8 md:px-16">

                <div class="flex justify-between items-center py-2 text-xs md:text-sm">

                    <div class="flex items-center">
                        <?php
                            _e( $resume_contact_left, 'kpt' );
                        ?>                
                    </div>
                    <div class="flex items-center">
                        <?php
                            _e( $resume_contact_right, 'kpt' );
                        ?>                
                    </div>

                </div>
            </div>

        </div>

        <main id="content" class="min-h-screen">
            <div class="w-full">
                <section id="page-<?php the_ID( ); ?>" <?php post_class( 'w-full pt-6 px-4 sm:px-8 md:px-16' ); ?>>
                    <div class="article-content prose prose-lg mb-8">
                        <p class="text-right hide-print">
                            <a href="#" class="print-link" onclick="window.print( );"><span class="fa-solid fa-print"></span> Print My Resume</a> | 
                            <a href="https://dev.kpirnie.com/wp-content/uploads/2025/10/KevinPirnie-Resume.pdf" target="_blank"><span class="fa-solid fa-file-pdf"></span> Download PDF</a>
                        </p>
                        <?php
                            
                            // just write out the content
                            _e( apply_filters( 'the_content', get_the_content( ), 1 ), 'kpt' );

                        ?>
                    </div>
                </section>
            </div>
        </main>

        <!-- Scroll to Top Button -->
        <button id="scroll-to-top" class="hide-print fixed bottom-8 right-8 bg-gradient-to-r from-[#599bb8] to-[#2d7696] text-white p-3 rounded-full shadow-lg opacity-0 invisible transition-all duration-300 hover:from-[#43819c] hover:to-[#2d7696] z-40" aria-label="Scroll to top">
            <span class="fa-solid fa-arrow-up-from-bracket inline-block w-6 h-6"></span>
        </button>
        <footer class="hide-print bg-gray-800 border-t border-gray-700 mt-8">
            <div class="bg-gray-900 border-t border-gray-700">
                <div class="w-full px-4 sm:px-8 md:px-16 py-4">
                    <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                        <div class="mb-2 md:mb-0">
                            <p>Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
                        </div>
                        <div class="flex space-x-4">
                            <?php
                            wp_nav_menu( array(
                                'theme_location' => 'bottom',
                                'container' => 'nav',
                                'container_class' => 'flex items-center',
                                'menu_class' => 'flex items-center space-x-2',
                                'fallback_cb' => false,
                                'depth' => 1,
                                'walker' => new KPT_Top_Header_Nav_Walker( ),
                            ) );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <?php
            
            // make wordpress process our footer
            wp_footer( ); 
        ?>

    </body>
</html>
