<?php
/**
 * Enqueue Scripts and Styles
 *
 * All asset loading for the theme
 * Extracted from functions.php for better organization
 * Debug code removed for production
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue frontend scripts and styles
 */
function nirup_enqueue_assets() {
    // === EXPLICITLY ENQUEUE JQUERY FIRST ===
    wp_enqueue_script('jquery');

    // === CSS FILES ===
    wp_enqueue_style('nirup-style', get_stylesheet_uri(), array(), '1.0.2');
    wp_enqueue_style('nirup-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.2');
    wp_enqueue_style('nirup-header', get_template_directory_uri() . '/assets/css/header.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-hero', get_template_directory_uri() . '/assets/css/hero.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-video', get_template_directory_uri() . '/assets/css/video.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-about-island', get_template_directory_uri() . '/assets/css/about-island.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-accommodations', get_template_directory_uri() . '/assets/css/accommodations.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-experiences-carousel', get_template_directory_uri() . '/assets/css/experiences-carousel.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-experiences-archive', get_template_directory_uri() . '/assets/css/archive-experiences.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-breadcrumbs', get_template_directory_uri() . '/assets/css/breadcrumbs.css', array(), '1.0.2');
    wp_enqueue_style('nirup-map-section', get_template_directory_uri() . '/assets/css/map-section.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-wellness-retreat', get_template_directory_uri() . '/assets/css/wellness-retreat.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-services', get_template_directory_uri() . '/assets/css/services.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-events-offers-carousel', get_template_directory_uri() . '/assets/css/events-offers-carousel.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-events-offers-archive', get_template_directory_uri() . '/assets/css/events-offers-archive.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-single-event-offer', get_template_directory_uri() . '/assets/css/single-event-offer.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-footer', get_template_directory_uri() . '/assets/css/footer.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-dining', get_template_directory_uri() . '/assets/css/dining.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-single-restaurant', get_template_directory_uri() . '/assets/css/single-restaurant.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-legal-pages', get_template_directory_uri() . '/assets/css/legal-pages.css', array('nirup-main'), '1.0.2');
    wp_enqueue_style('nirup-contact', get_template_directory_uri() . '/assets/css/contact.css', array(), '1.0.2');
    wp_enqueue_style('nirup-marina', get_template_directory_uri() . '/assets/css/marina.css', array('nirup-main'), '1.0.0');

    // === GOOGLE FONTS ===
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Albert+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', array(), null);

    // === JAVASCRIPT FILES WITH EXPLICIT JQUERY DEPENDENCY ===

    // 1. Core utilities
    wp_enqueue_script(
        'nirup-utils',
        get_template_directory_uri() . '/assets/js/utils.js',
        array('jquery'),
        '1.0.2',
        true
    );

    // 2. Navigation and header behavior
    wp_enqueue_script(
        'nirup-navigation',
        get_template_directory_uri() . '/assets/js/navigation.js',
        array('jquery', 'nirup-utils'),
        '1.0.2',
        true
    );

    // 3. Mobile menu functionality
    wp_enqueue_script(
        'nirup-mobile-menu',
        get_template_directory_uri() . '/assets/js/mobile-menu.js',
        array('jquery', 'nirup-utils'),
        '1.0.2',
        true
    );

    // 4. Search functionality
    wp_enqueue_script(
        'nirup-search',
        get_template_directory_uri() . '/assets/js/search.js',
        array('jquery', 'nirup-utils'),
        '1.0.2',
        true
    );

    // 5. Language switcher
    wp_enqueue_script(
        'nirup-language',
        get_template_directory_uri() . '/assets/js/language-switcher.js',
        array('jquery', 'nirup-utils'),
        '1.0.2',
        true
    );

    // 6. Analytics and tracking
    wp_enqueue_script(
        'nirup-analytics',
        get_template_directory_uri() . '/assets/js/analytics.js',
        array('jquery', 'nirup-utils'),
        '1.0.2',
        true
    );

    // 7. Plugin integrations
    wp_enqueue_script(
        'nirup-plugins',
        get_template_directory_uri() . '/assets/js/plugins.js',
        array('jquery', 'nirup-utils'),
        '1.0.2',
        true
    );

    // 8. Experiences carousel
    wp_enqueue_script(
        'nirup-carousel',
        get_template_directory_uri() . '/assets/js/carousel.js',
        array('jquery'),
        '1.0.2',
        true
    );

    // 9. Main initialization (loads last)
    wp_enqueue_script(
        'nirup-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(
            'jquery',
            'nirup-utils',
            'nirup-navigation',
            'nirup-mobile-menu',
            'nirup-search',
            'nirup-language',
            'nirup-analytics',
            'nirup-plugins',
            'nirup-carousel'
        ),
        '1.0.2',
        true
    );

    wp_enqueue_script(
        'nirup-map-section',
        get_template_directory_uri() . '/assets/js/map-section.js',
        array('jquery'),
        '1.0.2',
        true
    );

    wp_enqueue_script(
        'nirup-events-offers-carousel',
        get_template_directory_uri() . '/assets/js/events-offers-carousel.js',
        array('jquery', 'nirup-utils'),
        '1.0.2',
        true
    );

    wp_enqueue_script(
        'nirup-footer',
        get_template_directory_uri() . '/assets/js/footer.js',
        array('jquery'),
        '1.0.2',
        true
    );

    wp_enqueue_script(
        'single-event-offer-gallery',
        get_template_directory_uri() . '/assets/js/single-event-offer-gallery.js',
        array('jquery'),
        '1.0.2',
        true
    );

    wp_enqueue_script(
        'nirup-contact',
        get_template_directory_uri() . '/assets/js/contact.js',
        array('jquery'),
        '1.0.3',
        true
    );

    // === LOCALIZATION ===
    wp_localize_script('nirup-main', 'nirup_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('nirup_nonce')
    ));

    wp_localize_script('nirup-utils', 'nirup_theme', array(
        'template_url' => get_template_directory_uri(),
        'home_url' => home_url('/'),
        'is_mobile' => wp_is_mobile(),
        'debug' => defined('WP_DEBUG') && WP_DEBUG
    ));

    wp_localize_script('nirup-carousel', 'nirup_carousel', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('nirup_carousel_nonce')
    ));

    wp_localize_script('nirup-map-section', 'nirup_map', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('nirup_map_nonce'),
        'pins_enabled' => true
    ));

    wp_localize_script('nirup-footer', 'nirup_footer_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('newsletter_nonce'),
        'messages' => array(
            'subscribing' => __('Subscribing...', 'nirup-island'),
            'error' => __('Something went wrong. Please try again.', 'nirup-island'),
        )
    ));

    wp_localize_script('nirup-contact', 'nirup_contact_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('contact_form_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_assets');
