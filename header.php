<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth dark">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-gray-900 text-gray-100 font-mono'); ?>>
<?php wp_body_open(); ?>

<div id="top-header" class="text-white transition-transform duration-300">
    <div class="w-full px-4 sm:px-8 md:px-16">
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
            </div>
        </div>
    </div>
</div>

<header id="main-header" class="sticky top-0 z-50 bg-gray-900/95 backdrop-blur-sm shadow-md shadow-gray-950 transition-all duration-300">
    <div class="w-full px-4 sm:px-8 md:px-16">
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
                    'walker' => new KPT_Main_Nav_Walker(),
                ));
                ?>
                <button id="search-toggle" class="p-2 rounded-lg hover:bg-gray-800 transition-colors" aria-label="Toggle search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </nav>
            
            <div class="flex items-center space-x-4 lg:hidden">
                <button id="search-toggle-mobile" class="p-2 rounded-lg hover:bg-gray-800 transition-colors" aria-label="Toggle search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
                
                <button id="mobile-menu-toggle" class="p-2 rounded-lg hover:bg-gray-800 transition-colors" aria-label="Toggle menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <div id="search-form" class="hidden border-t border-gray-700">
        <div class="w-full px-4 sm:px-8 md:px-16 py-4">
            <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="flex gap-2">
                <input type="search" name="s" placeholder="Search..." class="flex-1 px-3 md:px-4 py-2 rounded-lg border border-gray-700 bg-gray-800 focus:outline-none focus:ring-2 focus:ring-[#599bb8] text-sm md:text-base" value="<?php echo get_search_query(); ?>">
                <button type="submit" class="p-2 md:p-3 text-white rounded-lg transition-all kp-gradient-bg" aria-label="Search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    
    <nav id="mobile-menu" class="hidden lg:hidden border-t border-gray-700">
        <div class="w-full px-4 sm:px-8 md:px-16 py-4">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'mobile-menu-list',
                'fallback_cb' => false,
                'walker' => new KPT_Mobile_Nav_Walker(),
            ));
            ?>
        </div>
    </nav>
</header>

<main id="content" class="min-h-screen">
    <div class="w-full px-4 sm:px-8 md:px-16">