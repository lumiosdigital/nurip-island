<?php
/**
 * Enqueue Scripts and Styles
 *
 * Handles all CSS and JavaScript file loading for the theme
 * with conditional loading based on page context for optimal performance.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Helper function to get secrets from constants or theme mods
 */
function nirup_get_secret($const_name, $theme_mod_key, $default = '') {
    if (defined($const_name) && constant($const_name)) {
        return constant($const_name);
    }
    $val = get_theme_mod($theme_mod_key, $default);
    return $val !== '' ? $val : $default;
}

/**
 * Main assets enqueue function
 */
function nirup_enqueue_assets() {

    // Use child-safe paths and automatic cache-busting
    $dir_uri  = get_stylesheet_directory_uri();
    $dir_path = get_stylesheet_directory();

    // ========================================
    // CSS FILES
    // ========================================

    // Main stylesheet
    wp_enqueue_style(
        'nirup-style',
        get_stylesheet_uri(),
        [],
        file_exists($dir_path . '/style.css') ? filemtime($dir_path . '/style.css') : null
    );

    // Core styles - loaded on all pages
    $core_css_files = [
        ['nirup-main',                  '/assets/css/main.css',                  []],
        ['nirup-header',                '/assets/css/header.css',                ['nirup-main']],
        ['nirup-footer',                '/assets/css/footer.css',                ['nirup-main']],
        ['nirup-breadcrumbs',           '/assets/css/breadcrumbs.css',           []],
        ['nirup-villa-booking',         '/assets/css/villa-booking.css',         ['nirup-main']],
        ['nirup-availability-modal',    '/assets/css/check-availability-modal.css', ['nirup-main']],
        ['nirup-availability-results',  '/assets/css/availability-results.css',  ['nirup-main']],
        ['nirup-booking-modal',         '/assets/css/booking-modal.css',         ['nirup-main']],
    ];

    foreach ($core_css_files as [$handle, $rel, $deps]) {
        $path = $dir_path . $rel;
        wp_enqueue_style(
            $handle,
            $dir_uri . $rel,
            $deps,
            file_exists($path) ? filemtime($path) : null
        );
    }

    // Conditional styles based on context
    $conditional_css = [];

    // Homepage styles
    if (is_front_page()) {
        $conditional_css = array_merge($conditional_css, [
            ['nirup-hero',                  '/assets/css/hero.css',                  ['nirup-main']],
            ['nirup-video',                 '/assets/css/video.css',                 ['nirup-main']],
            ['nirup-about-island',          '/assets/css/about-island.css',          ['nirup-main']],
            ['nirup-accommodations',        '/assets/css/accommodations.css',        ['nirup-main']],
            ['nirup-experiences-carousel',  '/assets/css/experiences-carousel.css',  ['nirup-main']],
            ['nirup-events-offers-carousel','/assets/css/events-offers-carousel.css',['nirup-main']],
            ['nirup-map-section',           '/assets/css/map-section.css',           ['nirup-main']],
            ['nirup-wellness-retreat',      '/assets/css/wellness-retreat.css',      ['nirup-main']],
            ['nirup-services',              '/assets/css/services.css',              ['nirup-main']],
            ['nirup-getting-here-css',      '/assets/css/page-getting-here.css',     ['nirup-main']],
            ['nirup-ferry-map',             '/assets/css/ferry-map.css',             []],
        ]);
    }

    // 404 page
    if (is_404()) {
        $conditional_css[] = ['nirup-404', '/assets/css/404.css', ['nirup-main']];
    }

    // Experience archive
    if (is_post_type_archive('experience')) {
        $conditional_css[] = ['nirup-experiences-archive', '/assets/css/archive-experiences.css', ['nirup-main']];
    }

    // Single experience
    if (is_singular('experience')) {
        global $post;
        $experience_type = get_post_meta($post->ID, '_experience_type', true);
        $category_template = get_post_meta($post->ID, '_category_template', true);

        if ($experience_type === 'category' && $category_template === 'detailed') {
            // Detailed category template
            $conditional_css[] = ['nirup-detailed-category', '/assets/css/experience-category-detailed.css', ['nirup-main']];
        } elseif ($experience_type === 'category') {
            // Category listing template (uses archive styles)
            $conditional_css[] = ['nirup-experiences-archive', '/assets/css/archive-experiences.css', ['nirup-main']];
        } else {
            // Single experience
            $conditional_css[] = ['nirup-single-experience', '/assets/css/experience-single.css', ['nirup-main']];
        }
    }

    // Events/Offers archive
    if (is_post_type_archive('event_offer')) {
        $conditional_css[] = ['nirup-events-offers-archive', '/assets/css/events-offers-archive.css', ['nirup-main']];
    }

    // Single event/offer
    if (is_singular('event_offer')) {
        $conditional_css[] = ['nirup-single-event-offer', '/assets/css/single-event-offer.css', ['nirup-main']];
        $conditional_css[] = ['nirup-events-offers-carousel', '/assets/css/events-offers-carousel.css', ['nirup-main']];
    }

    // Restaurant archive
    if (is_post_type_archive('restaurant')) {
        $conditional_css[] = ['nirup-dining', '/assets/css/dining.css', ['nirup-main']];
    }

    // Single restaurant
    if (is_singular('restaurant')) {
        $conditional_css[] = ['nirup-single-restaurant', '/assets/css/single-restaurant.css', ['nirup-main']];
        $conditional_css[] = ['nirup-dining', '/assets/css/dining.css', ['nirup-main']];
    }

    // Single villa
    if (is_singular('villa')) {
        $conditional_css[] = ['nirup-single-villa', '/assets/css/single-villa.css', []];
    }

    // Contact page
    if (is_page_template('page-contact.php')) {
        $conditional_css[] = ['nirup-contact', '/assets/css/contact.css', []];
    }

    // Getting Here page
    if (is_page_template('page-getting-here.php')) {
        $conditional_css[] = ['nirup-getting-here-css', '/assets/css/page-getting-here.css', ['nirup-main']];
        $conditional_css[] = ['nirup-ferry-map', '/assets/css/ferry-map.css', []];
    }

    // Sustainability page
    if (is_page_template('page-sustainability.php')) {
        $conditional_css[] = ['nirup-sustainability-styles', '/assets/css/sustainability.css', []];
    }

    // Accommodations page
    if (is_page_template('page-accommodations.php')) {
        $conditional_css[] = ['nirup-accommodations-page', '/assets/css/accommodations-page.css', []];
    }

    // Riahi Residences page
    if (is_page_template('page-riahi-residences.php')) {
        $conditional_css[] = ['nirup-riahi-residences', '/assets/css/riahi-residences.css', []];
    }

    // Private Events page
    if (is_page_template('page-private-events.php')) {
        $conditional_css[] = ['nirup-private-events', '/assets/css/private-events.css', []];
    }

    // Villa Selling page
    if (is_page_template('page-villa-selling.php')) {
        $conditional_css[] = ['nirup-villa-selling', '/assets/css/villa-selling.css', []];
    }

    // Legal pages
    if (is_page_template('page-privacy-policy.php') ||
        is_page_template('page-terms-conditions.php') ||
        is_page_template('page-cookies-policy.php')) {
        $conditional_css[] = ['nirup-legal-pages', '/assets/css/legal-pages.css', ['nirup-main']];
    }

    // Marina page
    if (is_page_template('page-marina.php')) {
        $conditional_css[] = ['nirup-marina', '/assets/css/marina.css', ['nirup-main']];
        $conditional_css[] = ['nirup-berthing', '/assets/css/berthing.css', ['nirup-main']];
    }

    // Berthing page
    if (is_page_template('page-berthing.php')) {
        $conditional_css[] = ['nirup-berthing', '/assets/css/berthing.css', ['nirup-main']];
    }

    // Media Coverage page
    if (is_page_template('media-coverage.php')) {
        $conditional_css[] = ['nirup-media-coverage', '/assets/css/media-coverage.css', ['nirup-main']];
    }

    // Press Kit page
    if (is_page_template('page-press-kit.php')) {
        $conditional_css[] = ['nirup-press-kit', '/assets/css/press-kit.css', ['nirup-main']];
    }

    // WooCommerce pages
    if (class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page())) {
        $conditional_css[] = ['nirup-woocommerce', '/assets/css/woocommerce.css', ['nirup-main']];
    }

    // Enqueue all conditional CSS
    foreach ($conditional_css as [$handle, $rel, $deps]) {
        $path = $dir_path . $rel;
        wp_enqueue_style(
            $handle,
            $dir_uri . $rel,
            $deps,
            file_exists($path) ? filemtime($path) : null
        );
    }

    // Google Fonts (leave version null so Google controls cache)
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Albert+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap',
        [],
        null
    );

    // ========================================
    // JAVASCRIPT FILES
    // ========================================

    $js_files = [
        ['nirup-utils',                 '/assets/js/utils.js',                    ['jquery']],
        ['nirup-navigation',            '/assets/js/navigation.js',              ['jquery','nirup-utils']],
        ['nirup-mobile-menu',           '/assets/js/mobile-menu.js',             ['jquery','nirup-utils']],
        ['nirup-search',                '/assets/js/search.js',                  ['jquery','nirup-utils']],
        ['nirup-language',              '/assets/js/language-switcher.js',       ['jquery','nirup-utils']],
        ['nirup-analytics',             '/assets/js/analytics.js',               ['jquery','nirup-utils']],
        ['nirup-plugins',               '/assets/js/plugins.js',                 ['jquery','nirup-utils']],
        ['nirup-carousel',              '/assets/js/carousel.js',                ['jquery']],
        ['nirup-main',                  '/assets/js/main.js',                    ['jquery','nirup-utils','nirup-navigation','nirup-mobile-menu','nirup-search','nirup-language','nirup-analytics','nirup-plugins','nirup-carousel']],
        ['nirup-map-section',           '/assets/js/map-section.js',             ['jquery']],
        ['nirup-events-offers-carousel','/assets/js/events-offers-carousel.js',  ['jquery','nirup-utils']],
        ['nirup-footer',                '/assets/js/footer.js',                  ['jquery']],
        ['single-event-offer-gallery',  '/assets/js/single-event-offer-gallery.js',['jquery']],
        ['nirup-contact',               '/assets/js/contact.js',                 ['jquery']],
        ['nirup-media-coverage',        '/assets/js/media-coverage.js',          ['jquery','nirup-main']],
        ['nirup-berthing',              '/assets/js/berthing.js',                ['jquery']],
        ['nirup-availability-modal',    '/assets/js/check-availability.js',      ['jquery']],
    ];

    foreach ($js_files as [$handle, $rel, $deps]) {
        $path = $dir_path . $rel;
        wp_enqueue_script(
            $handle,
            $dir_uri . $rel,
            $deps,
            file_exists($path) ? filemtime($path) : null,
            true
        );
    }

    // ========================================
    // LOCALIZATION
    // ========================================

    wp_localize_script('nirup-main', 'nirup_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('nirup_nonce')
    ));

    wp_localize_script('nirup-utils', 'nirup_theme', array(
        'template_url' => $dir_uri,
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

    $site_key = nirup_get_secret('RECAPTCHA_SITE_KEY', 'nirup_recaptcha_site_key', '');
    $brevo_list_id = nirup_get_secret('BREVO_LIST_ID', 'nirup_brevo_list_id', 6);

    wp_localize_script('nirup-footer', 'nirup_footer_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('newsletter_nonce'),
        'messages' => array(
            'subscribing' => __('Subscribing...', 'nirup-island'),
            'error'       => __('Something went wrong. Please try again.', 'nirup-island'),
        ),
        'recaptcha' => array(
            'site_key' => $site_key,
            'action'   => 'newsletter_subscribe'
        ),
        'brevo' => array(
            'list_id'  => (int) $brevo_list_id,
        ),
    ));

    wp_localize_script('nirup-contact', 'nirup_contact_ajax', [
        'ajax_url'  => admin_url('admin-ajax.php'),
        'nonce'     => wp_create_nonce('contact_form_nonce'),
        'recaptcha' => [
            'site_key' => nirup_get_secret('RECAPTCHA_SITE_KEY', 'nirup_recaptcha_site_key', ''),
            'action'   => 'contact_submit'
        ],
    ]);

    wp_localize_script('nirup-berthing', 'nirup_berthing_ajax', [
        'ajax_url'  => admin_url('admin-ajax.php'),
        'nonce'     => wp_create_nonce('berthing_form_nonce'),
        'recaptcha' => [
            'site_key' => nirup_get_secret('RECAPTCHA_SITE_KEY', 'nirup_recaptcha_site_key', ''),
            'action'   => 'berthing_submit',
        ],
    ]);

    // Google reCAPTCHA v3
    if (!empty($site_key) && !defined('NIRUP_DISABLE_CAPTCHA')) {
        wp_enqueue_script(
            'recaptcha-v3',
            'https://www.google.com/recaptcha/api.js?render=' . rawurlencode($site_key),
            [],
            null,
            true
        );
    }
}

// Register the enqueue function
add_action('wp_enqueue_scripts', 'nirup_enqueue_assets', 20);

/**
 * Preload hero background image on front page to prevent white flash
 */
function nirup_preload_hero_image() {
    // Only on front page
    if (!is_front_page()) {
        return;
    }

    $hero_bg_image_id = get_theme_mod('nirup_hero_bg_image');
    if ($hero_bg_image_id) {
        $hero_bg_url = wp_get_attachment_image_url($hero_bg_image_id, 'full');
        if ($hero_bg_url) {
            echo '<link rel="preload" as="image" href="' . esc_url($hero_bg_url) . '" fetchpriority="high">' . "\n";
        }
    }
}
add_action('wp_head', 'nirup_preload_hero_image', 1);
