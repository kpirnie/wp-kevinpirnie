<?php

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// setup our path
defined( 'KPT_PATH' ) || define( 'KPT_PATH', dirname( __FILE__ ) . '/' );

// At our earliest point, fire this up
add_action( 'after_setup_theme', function( ) {

	// include our autoloader
    include_once KPT_PATH . '/vendor/autoload.php';

    // we can fire up the rest of the theme's functionality now
    $_kpt = new KPT( );

    // initialize the theme
    $_kpt -> init( );

    // clean up
    unset( $_kpt );
    
}, 0 );

function kp_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo');
    add_theme_support('responsive-embeds');
    
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'kp-portfolio'),
        'top' => __('Top Header Menu', 'kp-portfolio')
    ));
}
add_action('after_setup_theme', 'kp_theme_setup');

function kp_theme_scripts() {
    wp_enqueue_style('kp-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_script('kp-theme-js', get_template_directory_uri() . '/assets/js/theme.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'kp_theme_scripts');

function kp_widgets_init() {
    register_sidebar(array(
        'name' => __('Footer Column 1', 'kp-portfolio'),
        'id' => 'footer-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Column 2', 'kp-portfolio'),
        'id' => 'footer-2',
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Column 3', 'kp-portfolio'),
        'id' => 'footer-3',
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'kp_widgets_init');

function kp_breadcrumbs() {
    // Don't show on home page
    if (is_front_page()) {
        return;
    }
    
    $separator = ' <span class="text-gray-400 dark:text-gray-600">/</span> ';
    $home_title = 'Home';
    
    echo '<nav class="breadcrumbs text-sm py-4 text-gray-600 dark:text-gray-400 text-right" aria-label="Breadcrumb"><div class="w-full">';
    
    echo '<a href="' . get_home_url() . '" class="text-blue-600 dark:text-blue-400 hover:underline">' . $home_title . '</a>';
    echo $separator;
    
    if (is_category() || is_single()) {
        $category = get_the_category();
        if ($category) {
            echo '<a href="' . get_category_link($category[0]->term_id) . '" class="text-blue-600 dark:text-blue-400 hover:underline">' . $category[0]->name . '</a>';
            if (is_single()) {
                echo $separator;
                echo '<span class="text-gray-700 dark:text-gray-300">' . get_the_title() . '</span>';
            }
        }
    } elseif (is_page()) {
        echo '<span class="text-gray-700 dark:text-gray-300">' . get_the_title() . '</span>';
    } elseif (is_tag()) {
        echo '<span class="text-gray-700 dark:text-gray-300">Tag: ' . single_tag_title('', false) . '</span>';
    } elseif (is_archive()) {
        echo '<span class="text-gray-700 dark:text-gray-300">' . post_type_archive_title('', false) . '</span>';
    } elseif (is_search()) {
        echo '<span class="text-gray-700 dark:text-gray-300">Search Results</span>';
    }
    
    echo '</div></nav>';
}

function kp_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'kp_excerpt_length');

function kp_remove_wp_block_library_css() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
}
add_action('wp_enqueue_scripts', 'kp_remove_wp_block_library_css', 100);

function kp_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
}
add_action('init', 'kp_disable_emojis');

