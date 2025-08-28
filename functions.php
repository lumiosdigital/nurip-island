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
        'primary' => __('Primary Menu', 'nirup-island'),
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
    // Enqueue main stylesheet
    wp_enqueue_style('nirup-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue main JavaScript (to be created later)
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
 * Theme Customizer (basic setup)
 */
function nirup_customize_register($wp_customize) {
    // Add customizer sections as needed
    $wp_customize->add_section('nirup_general', array(
        'title' => __('Nirup Island Settings', 'nirup-island'),
        'priority' => 30,
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