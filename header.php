<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-mono transition-colors duration-200'); ?>>
<?php wp_body_open(); ?>

<div id="top-header" class="text-white transition-transform duration-300">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-2 text-xs md:text-sm">
            <div class="flex items-center space-x-4">
                <a href="mailto:me@kpirnie.com" class="hover:text-[#fd6a4f] transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                    <span class="hidden sm:inline">me@kpirnie.com</span>
                </a>
                <a href="tel:4138880068" class="hover:text-[#fd6a4f] transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                    </svg>
                    <span class="hidden sm:inline">413.888.0068</span>
                </a>
                <span class="hidden md:flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    Feeding Hills, MA
                </span>
            </div>
            <div class="flex items-center space-x-4">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'top',
                    'container' => false,
                    'menu_class' => 'flex space-x-4',
                    'fallback_cb' => false,
                    'depth' => 1,
                ));
                ?>
                <button id="dark-mode-toggle" class="hover:text-[#fd6a4f] transition-colors" aria-label="Toggle dark mode">
                    <svg id="sun-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                    </svg>
                    <svg id="moon-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<header id="main-header" class="sticky top-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm shadow-md transition-all duration-300">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center">
                <a href="<?php echo home_url('/'); ?>" class="flex items-center space-x-3">
                    <?php if (has_custom_logo()): ?>
                        <?php the_custom_logo(); ?>
                    <?php else: ?>
                        <span class="text-2xl font-bold kp-gradient-text">
                            <?php bloginfo('name'); ?>
                        </span>
                    <?php endif; ?>
                </a>
            </div>
            
            <nav class="hidden lg:flex items-center space-x-6">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'flex space-x-6 items-center',
                    'fallback_cb' => false,
                ));
                ?>
            </nav>
            
            <div class="flex items-center space-x-4">
                <button id="search-toggle" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" aria-label="Toggle search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
                
                <button id="mobile-menu-toggle" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" aria-label="Toggle menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <div id="search-form" class="hidden border-t border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 py-4">
            <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="flex gap-2">
                <input type="search" name="s" placeholder="Search..." class="flex-1 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-[#599bb8]" value="<?php echo get_search_query(); ?>">
                <button type="submit" class="px-6 py-2 text-white rounded-lg transition-all kp-gradient-bg">Search</button>
            </form>
        </div>
    </div>
    
    <nav id="mobile-menu" class="hidden lg:hidden border-t border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 py-4">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'space-y-2',
                'fallback_cb' => false,
            ));
            ?>
        </div>
    </nav>
</header>

<main id="content" class="min-h-screen">