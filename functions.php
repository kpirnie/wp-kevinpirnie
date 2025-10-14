<?php
if (!defined('ABSPATH')) exit;

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

// Custom Walker for Desktop Hierarchical Menu (Click-based)
class KP_Hierarchical_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"submenu absolute left-0 top-full mt-2 bg-gray-800 rounded-lg shadow-lg py-2 min-w-[200px] hidden z-50\">\n";
    }
    
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        
        // Add class to parent items
        $has_children = in_array('menu-item-has-children', $classes);
        if ($has_children && $depth == 0) {
            $class_names .= ' has-dropdown relative';
        }
        
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $output .= $indent . '<li' . $class_names . '>';
        
        // For parent items, create a clickable toggle
        if ($has_children && $depth == 0) {
            $output .= '<button class="dropdown-toggle hover:text-[#599bb8] transition-colors flex items-center gap-1" aria-expanded="false" aria-label="Toggle ' . esc_attr($item->title) . ' menu">';
            $output .= '<span>' . esc_html($item->title) . '</span>';
            $output .= '<svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>';
            $output .= '</button>';
        } else {
            // Regular link for items without children
            $atts = array();
            $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = !empty($item->target) ? $item->target : '';
            $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
            $atts['href'] = !empty($item->url) ? $item->url : '';
            
            if ($depth == 0) {
                $atts['class'] = 'hover:text-[#599bb8] transition-colors flex items-center gap-1';
            } else {
                $atts['class'] = 'block px-4 py-2 hover:bg-gray-700 transition-colors text-sm whitespace-nowrap';
            }
            
            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
            
            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }
            
            $title = apply_filters('the_title', $item->title, $item->ID);
            $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
            
            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
            
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }
}

// Custom Walker for Mobile Hierarchical Menu
class KP_Mobile_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"submenu-mobile ml-4 mt-2 space-y-2 hidden\">\n";
    }
    
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        
        $has_children = in_array('menu-item-has-children', $classes);
        if ($has_children) {
            $class_names .= ' has-submenu';
        }
        
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $output .= $indent . '<li' . $class_names . '>';
        
        // Create container for parent items with children
        if ($has_children && $depth == 0) {
            $output .= '<div class="flex items-center justify-between w-full">';
        }
        
        // Always create a link (whether it has children or not)
        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';
        
        if ($has_children && $depth == 0) {
            $atts['class'] = 'flex-1 block py-2 hover:text-[#599bb8] transition-colors';
        } else {
            $atts['class'] = 'block py-2 hover:text-[#599bb8] transition-colors w-full';
        }
        
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        
        // Add toggle button for parent items
        if ($has_children && $depth == 0) {
            $output .= '<button class="submenu-toggle p-2 hover:text-[#599bb8] transition-colors flex-shrink-0" aria-label="Toggle submenu for ' . esc_attr($title) . '" type="button">';
            $output .= '<svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>';
            $output .= '</button>';
            $output .= '</div>';
        }
    }
}
