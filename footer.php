    </div>
</main>

<footer class="bg-gray-100 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-12">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="footer-column">
                <?php if (is_active_sidebar('footer-1')): ?>
                    <?php dynamic_sidebar('footer-1'); ?>
                <?php else: ?>
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">About</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">DevOps Support Lead & Web Developer specializing in WordPress, PHP, and cloud infrastructure.</p>
                <?php endif; ?>
            </div>
            
            <div class="footer-column">
                <?php if (is_active_sidebar('footer-2')): ?>
                    <?php dynamic_sidebar('footer-2'); ?>
                <?php else: ?>
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?php echo home_url('/'); ?>" class="text-gray-600 dark:text-gray-400 hover:text-[#599bb8] dark:hover:text-blue-400 transition-colors">Home</a></li>
                        <li><a href="<?php echo home_url('/blog'); ?>" class="text-gray-600 dark:text-gray-400 hover:text-[#599bb8] dark:hover:text-blue-400 transition-colors">Blog</a></li>
                    </ul>
                <?php endif; ?>
            </div>
            
            <div class="footer-column">
                <?php if (is_active_sidebar('footer-3')): ?>
                    <?php dynamic_sidebar('footer-3'); ?>
                <?php else: ?>
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Contact</h3>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Feeding Hills, MA 01030</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            <a href="mailto:me@kpirnie.com" class="hover:text-[#599bb8] dark:hover:text-blue-400 transition-colors">me@kpirnie.com</a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <a href="tel:4138880068" class="hover:text-[#599bb8] dark:hover:text-blue-400 transition-colors">413.888.0068</a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="bg-gray-200 dark:bg-gray-900 border-t border-gray-300 dark:border-gray-700">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-600 dark:text-gray-400">
                <div class="mb-2 md:mb-0">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
                </div>
                <div class="flex space-x-4">
                    <a href="<?php echo home_url('/privacy-policy'); ?>" class="hover:text-[#599bb8] dark:hover:text-blue-400 transition-colors">Privacy Policy</a>
                    <span class="text-gray-400 dark:text-gray-600">|</span>
                    <a href="<?php echo home_url('/terms'); ?>" class="hover:text-[#599bb8] dark:hover:text-blue-400 transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>