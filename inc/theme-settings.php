<?php
if (!defined('ABSPATH')) exit;

// Add admin menu
function kp_theme_settings_menu() {
    add_theme_page(
        'Theme Settings',
        'Theme Settings',
        'manage_options',
        'kp-theme-settings',
        'kp_theme_settings_page'
    );
}
add_action('admin_menu', 'kp_theme_settings_menu');

// Register settings
function kp_theme_settings_init() {
    register_setting('kp_theme_settings', 'kp_cookie_notice_title');
    register_setting('kp_theme_settings', 'kp_cookie_notice_content');
    register_setting('kp_theme_settings', 'kp_cookie_accept_text');
    register_setting('kp_theme_settings', 'kp_cookie_decline_text');
    register_setting('kp_theme_settings', 'kp_cookie_accept_classes');
    register_setting('kp_theme_settings', 'kp_cookie_decline_classes');
    register_setting('kp_theme_settings', 'kp_cookie_modal_page');
    register_setting('kp_theme_settings', 'kp_cookie_modal_position');
    register_setting('kp_theme_settings', 'kp_cookie_modal_overlay');
    register_setting('kp_theme_settings', 'kp_short_address');
    register_setting('kp_theme_settings', 'kp_long_address');
    register_setting('kp_theme_settings', 'kp_phone_number');
    register_setting('kp_theme_settings', 'kp_email_address');
}
add_action('admin_init', 'kp_theme_settings_init');

// Settings page HTML
function kp_theme_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    if (isset($_GET['settings-updated'])) {
        add_settings_error('kp_theme_messages', 'kp_theme_message', 'Settings Saved', 'updated');
    }
    
    settings_errors('kp_theme_messages');
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('kp_theme_settings');
            ?>
            
            <h2>Cookie Notice Settings</h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="kp_cookie_notice_title">Cookie Notice Title</label>
                    </th>
                    <td>
                        <input type="text" id="kp_cookie_notice_title" name="kp_cookie_notice_title" 
                               value="<?php echo esc_attr(get_option('kp_cookie_notice_title', 'Cookie Notice')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="kp_cookie_notice_content">Cookie Notice Content</label>
                    </th>
                    <td>
                        <?php
                        wp_editor(
                            get_option('kp_cookie_notice_content', ''),
                            'kp_cookie_notice_content',
                            array(
                                'textarea_name' => 'kp_cookie_notice_content',
                                'textarea_rows' => 10,
                                'media_buttons' => false,
                            )
                        );
                        ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="kp_cookie_accept_text">Accept Button Text</label>
                    </th>
                    <td>
                        <input type="text" id="kp_cookie_accept_text" name="kp_cookie_accept_text" 
                               value="<?php echo esc_attr(get_option('kp_cookie_accept_text', 'Accept')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="kp_cookie_accept_classes">Accept Button Classes</label>
                    </th>
                    <td>
                        <input type="text" id="kp_cookie_accept_classes" name="kp_cookie_accept_classes" 
                               value="<?php echo esc_attr(get_option('kp_cookie_accept_classes', 'btn-primary')); ?>" 
                               class="regular-text">
                        <p class="description">CSS classes for the accept button (space-separated)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="kp_cookie_decline_text">Decline Button Text</label>
                    </th>
                    <td>
                        <input type="text" id="kp_cookie_decline_text" name="kp_cookie_decline_text" 
                               value="<?php echo esc_attr(get_option('kp_cookie_decline_text', 'Decline')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="kp_cookie_decline_classes">Decline Button Classes</label>
                    </th>
                    <td>
                        <input type="text" id="kp_cookie_decline_classes" name="kp_cookie_decline_classes" 
                               value="<?php echo esc_attr(get_option('kp_cookie_decline_classes', 'btn-secondary')); ?>" 
                               class="regular-text">
                        <p class="description">CSS classes for the decline button (space-separated)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="kp_cookie_modal_page">Privacy Policy Page</label>
                    </th>
                    <td>
                        <?php
                        wp_dropdown_pages(array(
                            'name' => 'kp_cookie_modal_page',
                            'id' => 'kp_cookie_modal_page',
                            'selected' => get_option('kp_cookie_modal_page', ''),
                            'show_option_none' => 'Select a page',
                        ));
                        ?>
                        <p class="description">Page to display in modal when "Learn More" is clicked</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="kp_cookie_modal_position">Modal Position</label>
                    </th>
                    <td>
                        <select id="kp_cookie_modal_position" name="kp_cookie_modal_position">
                            <option value="left" <?php selected(get_option('kp_cookie_modal_position', 'right'), 'left'); ?>>50% Left</option>
                            <option value="right" <?php selected(get_option('kp_cookie_modal_position', 'right'), 'right'); ?>>50% Right</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="kp_cookie_modal_overlay">Full Page Overlay</label>
                    </th>
                    <td>
                        <input type="checkbox" id="kp_cookie_modal_overlay" name="kp_cookie_modal_overlay" 
                               value="1" <?php checked(get_option('kp_cookie_modal_overlay', '1'), '1'); ?>>
                        <label for="kp_cookie_modal_overlay">Enable full page overlay</label>
                    </td>
                </tr>
            </table>
            
            <h2>Contact Information</h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="kp_short_address">Short Address</label>
                    </th>
                    <td>
                        <input type="text" id="kp_short_address" name="kp_short_address" 
                               value="<?php echo esc_attr(get_option('kp_short_address', '')); ?>" 
                               class="regular-text">
                        <p class="description">e.g., "Feeding Hills, MA" - Shortcode: [kp_short_address]</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="kp_long_address">Full Address</label>
                    </th>
                    <td>
                        <textarea id="kp_long_address" name="kp_long_address" rows="4" class="large-text"><?php echo esc_textarea(get_option('kp_long_address', '')); ?></textarea>
                        <p class="description">Full mailing address - Shortcode: [kp_long_address]</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="kp_phone_number">Phone Number</label>
                    </th>
                    <td>
                        <input type="text" id="kp_phone_number" name="kp_phone_number" 
                               value="<?php echo esc_attr(get_option('kp_phone_number', '')); ?>" 
                               class="regular-text">
                        <p class="description">e.g., "(413) 888-0068" - Shortcode: [kp_phone]</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="kp_email_address">Email Address</label>
                    </th>
                    <td>
                        <input type="email" id="kp_email_address" name="kp_email_address" 
                               value="<?php echo esc_attr(get_option('kp_email_address', '')); ?>" 
                               class="regular-text">
                        <p class="description">Shortcode: [kp_email]</p>
                    </td>
                </tr>
            </table>
            
            <?php submit_button('Save Settings'); ?>
        </form>
    </div>
    <?php
}

// Obfuscation helper
function kp_obfuscate_string($string) {
    $obfuscated = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $obfuscated .= '&#' . ord($string[$i]) . ';';
    }
    return $obfuscated;
}

// Shortcodes
function kp_short_address_shortcode() {
    return esc_html(get_option('kp_short_address', ''));
}
add_shortcode('kp_short_address', 'kp_short_address_shortcode');

function kp_long_address_shortcode() {
    return nl2br(esc_html(get_option('kp_long_address', '')));
}
add_shortcode('kp_long_address', 'kp_long_address_shortcode');

function kp_phone_shortcode() {
    $phone = get_option('kp_phone_number', '');
    if (empty($phone)) {
        return '';
    }
    
    $clean_phone = preg_replace('/[^0-9]/', '', $phone);
    $obfuscated = kp_obfuscate_string($phone);
    
    return '<a href="tel:' . esc_attr($clean_phone) . '">' . $obfuscated . '</a>';
}
add_shortcode('kp_phone', 'kp_phone_shortcode');

function kp_email_shortcode() {
    $email = get_option('kp_email_address', '');
    if (empty($email)) {
        return '';
    }
    
    $obfuscated_email = kp_obfuscate_string($email);
    $obfuscated_mailto = kp_obfuscate_string('mailto:' . $email);
    
    return '<a href="' . $obfuscated_mailto . '">' . $obfuscated_email . '</a>';
}
add_shortcode('kp_email', 'kp_email_shortcode');

// Cookie notice display
function kp_display_cookie_notice() {
    $title = get_option('kp_cookie_notice_title', 'Cookie Notice');
    $content = get_option('kp_cookie_notice_content', '');
    $accept_text = get_option('kp_cookie_accept_text', 'Accept');
    $decline_text = get_option('kp_cookie_decline_text', 'Decline');
    $accept_classes = get_option('kp_cookie_accept_classes', 'btn-primary');
    $decline_classes = get_option('kp_cookie_decline_classes', 'btn-secondary');
    $modal_page = get_option('kp_cookie_modal_page', '');
    $modal_position = get_option('kp_cookie_modal_position', 'right');
    $modal_overlay = get_option('kp_cookie_modal_overlay', '1');
    
    if (empty($content)) {
        return;
    }
    ?>
    <!-- Cookie Notice Overlay -->
    <div id="kp-cookie-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden" style="display: none; z-index: 9998;"></div>
    
    <!-- Cookie Notice -->
    <div id="kp-cookie-notice" class="fixed bottom-0 left-0 right-0 bg-gray-800 text-white p-6 shadow-lg hidden" style="display: none; z-index: 9999;">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex-1">
                    <h3 class="text-lg font-bold mb-2"><?php echo esc_html($title); ?></h3>
                    <div class="text-sm text-gray-300">
                        <?php echo wp_kses_post($content); ?>
                        <?php if ($modal_page): ?>
                            <a href="#" id="kp-cookie-learn-more" class="text-blue-400 hover:text-blue-300 underline ml-2">Learn More</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button id="kp-cookie-decline" class="<?php echo esc_attr($decline_classes); ?>">
                        <?php echo esc_html($decline_text); ?>
                    </button>
                    <button id="kp-cookie-accept" class="<?php echo esc_attr($accept_classes); ?>">
                        <?php echo esc_html($accept_text); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <?php if ($modal_page): ?>
    <div id="kp-cookie-modal" class="fixed inset-0 hidden" style="z-index: 10000;">
        <?php if ($modal_overlay == '1'): ?>
        <div class="absolute inset-0 bg-black bg-opacity-50" id="kp-modal-overlay"></div>
        <?php endif; ?>
        
        <div class="absolute top-0 bottom-0 <?php echo $modal_position === 'left' ? 'left-0' : 'right-0'; ?> w-full md:w-1/2 bg-white dark:bg-gray-900 overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-gray-800 p-4 flex justify-between items-center z-10">
                <h3 class="text-lg font-bold text-white">Privacy Policy</h3>
                <button id="kp-modal-close" class="text-white hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-6" id="kp-modal-content">
                <?php
                $page = get_post($modal_page);
                if ($page) {
                    echo '<h1 class="text-3xl font-bold mb-4 kp-gradient-text">' . esc_html($page->post_title) . '</h1>';
                    echo '<div class="prose prose-lg">' . apply_filters('the_content', $page->post_content) . '</div>';
                }
                ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php
}
add_action('wp_footer', 'kp_display_cookie_notice');
