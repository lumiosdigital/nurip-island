<?php
/**
 * Nirup Island Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function nirup_theme_setup() {
    // Add theme support for various features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    
    // Add support for custom menus
    register_nav_menus(array(
        'primary' => __('Primary Menu (Left Side)', 'nirup-island'),
        'secondary' => __('Secondary Menu (Right Side)', 'nirup-island'),
        'footer' => __('Footer Menu', 'nirup-island'),
    ));
    
    // Set content width
    if (!isset($content_width)) {
        $content_width = 1200;
    }
}
add_action('after_setup_theme', 'nirup_theme_setup');

/**
 * Enqueue Scripts and Styles
 */
function nirup_enqueue_assets() {
    // Enqueue main stylesheet (WordPress theme header only)
    wp_enqueue_style('nirup-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue main CSS file
    wp_enqueue_style('nirup-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    
    // Enqueue header CSS file
    wp_enqueue_style('nirup-header', get_template_directory_uri() . '/assets/css/header.css', array('nirup-main'), '1.0.0');
    
    // Enqueue main JavaScript
    wp_enqueue_script('nirup-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('nirup-main', 'nirup_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('nirup_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_assets');

/**
 * Widget Areas
 */
function nirup_register_sidebars() {
    register_sidebar(array(
        'name' => __('Footer Widgets', 'nirup-island'),
        'id' => 'footer-widgets',
        'description' => __('Widgets for the footer area', 'nirup-island'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'nirup_register_sidebars');

/**
 * Plugin Support and Compatibility
 */

// Yoast SEO Breadcrumbs support
function nirup_yoast_breadcrumbs() {
    if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<div class="breadcrumbs">', '</div>');
    }
}

// TranslatePress compatibility
function nirup_translatepress_support() {
    if (function_exists('trp_custom_language_switcher')) {
        // Language switcher will be added in templates as needed
    }
}

// WP Booking System hooks
function nirup_booking_system_hooks() {
    if (class_exists('WP_Booking_System')) {
        // Add any custom hooks for booking system here
    }
}
add_action('init', 'nirup_booking_system_hooks');

// Google Site Kit support
function nirup_google_site_kit_support() {
    if (function_exists('googlesitekit_get_option')) {
        // Site Kit is active, add any custom functionality here
    }
}
add_action('wp', 'nirup_google_site_kit_support');

// Microsoft Clarity support (if needed for custom implementation)
function nirup_microsoft_clarity() {
    // This will be handled by the plugin, but custom code can be added here if needed
}
add_action('wp_head', 'nirup_microsoft_clarity');

// Brevo (Sendinblue) compatibility
function nirup_brevo_support() {
    if (function_exists('sib_forms_shortcode')) {
        // Brevo forms are available
    }
}

/**
 * Custom Post Types and Fields (to be added as needed)
 */

/**
 * Utility Functions
 */
function nirup_get_template_part($slug, $name = null, $args = array()) {
    if (!empty($args)) {
        set_query_var('template_args', $args);
    }
    get_template_part($slug, $name);
}

/**
 * Theme Customizer
 */
function nirup_customize_register($wp_customize) {
    // Announcement Bar Section
    $wp_customize->add_section('nirup_announcement_bar', array(
        'title' => __('Announcement Bar', 'nirup-island'),
        'priority' => 30,
    ));

    // Show/Hide Announcement Bar
    $wp_customize->add_setting('nirup_announcement_show', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('nirup_announcement_show', array(
        'label' => __('Show Announcement Bar', 'nirup-island'),
        'section' => 'nirup_announcement_bar',
        'type' => 'checkbox',
    ));

    // Announcement Text
    $wp_customize->add_setting('nirup_announcement_text', array(
        'default' => __('Wellness Retreat now available – June to September 2025', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_announcement_text', array(
        'label' => __('Announcement Text', 'nirup-island'),
        'section' => 'nirup_announcement_bar',
        'type' => 'text',
    ));

    // Announcement Link
    $wp_customize->add_setting('nirup_announcement_link', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_announcement_link', array(
        'label' => __('Announcement Link URL', 'nirup-island'),
        'section' => 'nirup_announcement_bar',
        'type' => 'url',
    ));

    // Navigation Settings Section
    $wp_customize->add_section('nirup_navigation', array(
        'title' => __('Navigation Settings', 'nirup-island'),
        'priority' => 31,
    ));

    // Book Your Stay Button Text
    $wp_customize->add_setting('nirup_booking_button_text', array(
        'default' => __('Book Your Stay', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_booking_button_text', array(
        'label' => __('Booking Button Text', 'nirup-island'),
        'section' => 'nirup_navigation',
        'type' => 'text',
    ));

    // Book Your Stay Button Link
    $wp_customize->add_setting('nirup_booking_button_link', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_booking_button_link', array(
        'label' => __('Booking Button Link URL', 'nirup-island'),
        'section' => 'nirup_navigation',
        'type' => 'url',
    ));
}
add_action('customize_register', 'nirup_customize_register');

/**
 * Security and Performance
 */
// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');

// Clean up wp_head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

/**
 * AJAX Handlers (to be added as needed)
 */

/**
 * Default Menu Fallbacks
 */
function nirup_default_left_menu() {
    echo '<ul class="primary-menu-left">';
    echo '<li><a href="' . esc_url(home_url('/getting-here/')) . '">' . __('Getting Here', 'nirup-island') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/accommodations/')) . '">' . __('Accommodations', 'nirup-island') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/experiences/')) . '">' . __('Experiences', 'nirup-island') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/dining/')) . '">' . __('Dining', 'nirup-island') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/marina/')) . '">' . __('Marina', 'nirup-island') . '</a></li>';
    echo '</ul>';
}

function nirup_default_right_menu() {
    echo '<ul class="secondary-menu">';
    echo '<li><a href="' . esc_url(home_url('/private-events/')) . '">' . __('Private Events', 'nirup-island') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/events-offers/')) . '">' . __('Events & Offers', 'nirup-island') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact/')) . '">' . __('Contact', 'nirup-island') . '</a></li>';
    echo '</ul>';
}

function nirup_mobile_default_menu() {
    echo '<ul class="mobile-primary-menu">';
    echo '<li><a href="' . esc_url(home_url('/getting-here/')) . '">' . __('Getting Here', 'nirup-island') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/accommodations/')) . '">' . __('Accommodations', 'nirup-island') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/experiences/')) . '">' . __('Experiences', 'nirup-island') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/dining/')) . '">' . __('Dining', 'nirup-island') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/marina/')) . '">' . __('Marina', 'nirup-island') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/private-events/')) . '">' . __('Private Events', 'nirup-island') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/events-offers/')) . '">' . __('Events & Offers', 'nirup-island') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact/')) . '">' . __('Contact', 'nirup-island') . '</a></li>';
    echo '</ul>';
}