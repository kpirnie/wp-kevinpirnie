<?php
/** 
 * footer.php
 * 
 * This is the footer template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// check if we actually have ANY widgets for the footer
$have_widgets = in_array( true, array( is_active_sidebar('footer-1'), is_active_sidebar('footer-2'), is_active_sidebar('footer-3') ) );

?>
            </div>
        </main>

        <!-- Scroll to Top Button -->
        <button id="scroll-to-top" class="fixed bottom-8 right-8 bg-gradient-to-r from-[#599bb8] to-[#2d7696] text-white p-3 rounded-full shadow-lg opacity-0 invisible transition-all duration-300 hover:from-[#43819c] hover:to-[#2d7696] z-40" aria-label="Scroll to top">
            <span class="fa-solid fa-arrow-up-from-bracket inline-block w-6 h-6"></span>
        </button>

        <footer class="bg-gray-800 border-t border-gray-700 mt-8">

            <?php 
            // we only need to show this is the widgets actually have anything in them
            if ($have_widgets): ?>
            <div class="w-full px-4 sm:px-8 md:px-16 py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="footer-column">
                        <?php if (is_active_sidebar('footer-1')): ?>
                            <?php dynamic_sidebar('footer-1'); ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="footer-column">
                        <?php if (is_active_sidebar('footer-2')): ?>
                            <?php dynamic_sidebar('footer-2'); ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="footer-column">
                        <?php if (is_active_sidebar('footer-3')): ?>
                            <?php dynamic_sidebar('footer-3'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

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

        <!-- Cookie Notice Overlay -->
        <div id="kp-cookie-overlay" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50"></div>
        
        <!-- Cookie Notice -->
        <div id="kp-cookie-notice" class="hidden fixed bottom-0 left-0 right-0 bg-gray-900 text-white p-6 shadow-lg z-50 border-t-4 border-[#599bb8]">
            <div class="max-w-6xl mx-auto">
                <div class="flex flex-col gap-4">
                    <div>
                        <h3 class="text-2xl font-bold mb-3">Cookie Consent</h3>
                        <p class="text-base text-gray-300 mb-4">
                            This website uses cookies to enhance your browsing experience, analyze site traffic, and personalize content. 
                            Cookies are small text files stored on your device that help us remember your preferences and understand how you interact with our site.
                        </p>
                        <p class="text-base text-gray-300 mb-4">
                            By clicking "Accept", you consent to our use of cookies as described in our Cookie Policy. 
                            If you click "Decline", we will not use cookies for tracking purposes, but some features of the site may not function optimally.
                        </p>
                        <p class="text-sm text-gray-400">
                            <a href="#" id="kp-cookie-learn-more" class="text-[#599bb8] hover:text-[#43819c] underline">Learn more about our Cookie Policy</a>
                        </p>
                    </div>
                    <div class="flex gap-3 justify-end">
                        <button id="kp-cookie-decline" class="px-8 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors font-semibold">
                            Decline
                        </button>
                        <button id="kp-cookie-accept" class="px-8 py-3 bg-gradient-to-r from-[#599bb8] to-[#2d7696] hover:from-[#43819c] hover:to-[#2d7696] rounded-lg transition-colors font-semibold">
                            Accept
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cookie Policy Modal -->
        <div id="kp-cookie-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
            <div id="kp-modal-overlay" class="absolute inset-0 bg-black bg-opacity-75"></div>
            <div class="relative bg-gray-800 rounded-lg max-w-4xl w-full max-h-[85vh] overflow-hidden flex flex-col">
                <div class="flex items-center justify-between p-6 border-b border-gray-700">
                    <h2 class="text-2xl font-bold">Cookie Policy</h2>
                    <button id="kp-modal-close" class="text-gray-400 hover:text-white text-3xl leading-none">
                        &times;
                    </button>
                </div>
                <div id="kp-modal-content" class="flex-1 overflow-y-auto p-6 text-gray-300">
                    <div class="flex items-center justify-center py-12">
                        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-[#599bb8]"></div>
                    </div>
                </div>
            </div>
        </div>

        <?php wp_footer( ); ?>
    </body>
</html>