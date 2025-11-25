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
        'footer_stay' => __('Footer - Stay Menu', 'nirup-island'),
        'footer_experiences' => __('Footer - Experiences Menu', 'nirup-island'),
        'footer_dining' => __('Footer - Dining Menu', 'nirup-island'),
        'footer_information' => __('Footer - Information Menu', 'nirup-island'),
    ));
    
    // Set content width
    if (!isset($content_width)) {
        $content_width = 1200;
    }
}
add_action('after_setup_theme', 'nirup_theme_setup');

/**
 * UPDATED Enqueue Scripts and Styles Function
 */

function nirup_get_secret($const_name, $theme_mod_key, $default = '') {
  if (defined($const_name) && constant($const_name)) {
    return constant($const_name);
  }
  $val = get_theme_mod($theme_mod_key, $default);
  return $val !== '' ? $val : $default;
}

function nirup_enqueue_assets() {

    // Use child-safe paths and automatic cache-busting
    $dir_uri  = get_stylesheet_directory_uri();
    $dir_path = get_stylesheet_directory();

    // === CSS FILES ===
    // style.css
    wp_enqueue_style(
        'nirup-style',
        get_stylesheet_uri(),
        [],
        file_exists($dir_path . '/style.css') ? filemtime($dir_path . '/style.css') : null
    );

    // helper list: [handle, relative path from theme root, dependencies]
    $css_files = [
        ['nirup-main',                  '/assets/css/main.css',                  []],
        ['nirup-header',                '/assets/css/header.css',                ['nirup-main']],
        ['nirup-hero',                  '/assets/css/hero.css',                  ['nirup-main']],
        ['nirup-video',                 '/assets/css/video.css',                 ['nirup-main']],
        ['nirup-about-island',          '/assets/css/about-island.css',          ['nirup-main']],
        ['nirup-accommodations',        '/assets/css/accommodations.css',        ['nirup-main']],
        ['nirup-experiences-carousel',  '/assets/css/experiences-carousel.css',  ['nirup-main']],
        ['nirup-experiences-archive',   '/assets/css/archive-experiences.css',   ['nirup-main']],
        ['nirup-breadcrumbs',           '/assets/css/breadcrumbs.css',           []],
        ['nirup-map-section',           '/assets/css/map-section.css',           ['nirup-main']],
        ['nirup-wellness-retreat',      '/assets/css/wellness-retreat.css',      ['nirup-main']],
        ['nirup-services',              '/assets/css/services.css',              ['nirup-main']],
        ['nirup-events-offers-carousel','/assets/css/events-offers-carousel.css',['nirup-main']],
        ['nirup-events-offers-archive', '/assets/css/events-offers-archive.css', ['nirup-main']],
        ['nirup-single-event-offer',    '/assets/css/single-event-offer.css',    ['nirup-main']],
        ['nirup-footer',                '/assets/css/footer.css',                ['nirup-main']],
        ['nirup-dining',                '/assets/css/dining.css',                ['nirup-main']],
        ['nirup-single-restaurant',     '/assets/css/single-restaurant.css',     ['nirup-main']],
        ['nirup-legal-pages',           '/assets/css/legal-pages.css',           ['nirup-main']],
        ['nirup-contact',               '/assets/css/contact.css',               []],
        ['nirup-marina',                '/assets/css/marina.css',                ['nirup-main']],
        ['nirup-media-coverage',        '/assets/css/media-coverage.css',        ['nirup-main']],
        ['nirup-press-kit',         '/assets/css/press-kit.css',         ['nirup-main']],
        ['nirup-villa-booking',         '/assets/css/villa-booking.css',         ['nirup-main']],
        // ['nirup-woocommerce-booking',         '/assets/css/woocommerce-booking.css',         ['nirup-main']],
    ];

    foreach ($css_files as [$handle, $rel, $deps]) {
        $path = $dir_path . $rel;
        wp_enqueue_style(
            $handle,
            $dir_uri . $rel,
            $deps,
            file_exists($path) ? filemtime($path) : null
        );
    }

    if (is_404()) {
    $path_404 = $dir_path . '/assets/css/404.css';
    wp_enqueue_style(
        'nirup-404',
        $dir_uri . '/assets/css/404.css',
        ['nirup-main'],
        file_exists($path_404) ? filemtime($path_404) : null
    );
}

    // === GOOGLE FONTS === (leave version null so Google controls cache)
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Albert+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap',
        [],
        null
    );

    // === JAVASCRIPT FILES WITH EXPLICIT JQUERY DEPENDENCY ===
    $js_files = [
        // handle, rel path, deps
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


    // === LOCALIZATION ===
    wp_localize_script('nirup-main', 'nirup_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('nirup_nonce')
    ));

    wp_localize_script('nirup-utils', 'nirup_theme', array(
        'template_url' => $dir_uri, // child-safe template URL
        'home_url' => home_url('/'),
        'is_mobile' => wp_is_mobile(),
        'debug' => defined('WP_DEBUG') && WP_DEBUG
    ));

    // NEW: Localize carousel script
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

// Make sure the hook is properly registered
remove_action('wp_enqueue_scripts', 'nirup_enqueue_assets'); // Remove any existing
add_action('wp_enqueue_scripts', 'nirup_enqueue_assets', 20); // Run a bit later so it wins over plugins


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
 * NEW: Register Custom Post Type: Experiences
 */
function register_experiences_post_type() {
    $labels = array(
        'name'                  => _x('Experiences', 'Post type general name', 'nirup-island'),
        'singular_name'         => _x('Experience', 'Post type singular name', 'nirup-island'),
        'menu_name'             => _x('Experiences', 'Admin Menu text', 'nirup-island'),
        'name_admin_bar'        => _x('Experience', 'Add New on Toolbar', 'nirup-island'),
        'add_new'               => __('Add New', 'nirup-island'),
        'add_new_item'          => __('Add New Experience', 'nirup-island'),
        'new_item'              => __('New Experience', 'nirup-island'),
        'edit_item'             => __('Edit Experience', 'nirup-island'),
        'view_item'             => __('View Experience', 'nirup-island'),
        'all_items'             => __('All Experiences', 'nirup-island'),
        'search_items'          => __('Search Experiences', 'nirup-island'),
        'parent_item_colon'     => __('Parent Experiences:', 'nirup-island'),
        'not_found'             => __('No experiences found.', 'nirup-island'),
        'not_found_in_trash'    => __('No experiences found in Trash.', 'nirup-island'),
        'featured_image'        => _x('Experience Featured Image', 'Overrides the "Featured Image" phrase', 'nirup-island'),
        'set_featured_image'    => _x('Set featured image', 'Overrides the "Set featured image" phrase', 'nirup-island'),
        'remove_featured_image' => _x('Remove featured image', 'Overrides the "Remove featured image" phrase', 'nirup-island'),
        'use_featured_image'    => _x('Use as featured image', 'Overrides the "Use as featured image" phrase', 'nirup-island'),
        'archives'              => _x('Experience archives', 'The post type archive label', 'nirup-island'),
        'insert_into_item'      => _x('Insert into experience', 'Overrides the "Insert into post" phrase', 'nirup-island'),
        'uploaded_to_this_item' => _x('Uploaded to this experience', 'Overrides the "Uploaded to this post" phrase', 'nirup-island'),
        'filter_items_list'     => _x('Filter experiences list', 'Screen reader text for the filter links', 'nirup-island'),
        'items_list_navigation' => _x('Experiences list navigation', 'Screen reader text for the pagination', 'nirup-island'),
        'items_list'            => _x('Experiences list', 'Screen reader text for the items list', 'nirup-island'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'experiences'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => true, // Enable parent-child relationships
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-palmtree',
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'page-attributes'),
        'show_in_rest'       => true,
    );

    register_post_type('experience', $args);
}
add_action('init', 'register_experiences_post_type');

/**
 * NEW: Add custom fields for experiences
 */
function add_experience_meta_boxes() {
    add_meta_box(
        'experience_details',
        'Experience Details',
        'experience_details_callback',
        'experience',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_experience_meta_boxes');

function experience_details_callback($post) {
    wp_nonce_field('save_experience_details', 'experience_details_nonce');
    
    $short_description = get_post_meta($post->ID, '_experience_short_description', true);
    $experience_type = get_post_meta($post->ID, '_experience_type', true);
    $category_template = get_post_meta($post->ID, '_category_template', true);
    $hero_gallery = get_post_meta($post->ID, '_hero_banner_gallery', true);
    $featured_in_carousel = get_post_meta($post->ID, '_featured_in_carousel', true);
    $featured_in_archive = get_post_meta($post->ID, '_featured_in_archive', true);
    
    // New detailed template fields
    $detailed_subtitle = get_post_meta($post->ID, '_detailed_subtitle', true);
    $quote_title = get_post_meta($post->ID, '_quote_title', true);
    $quote_text = get_post_meta($post->ID, '_quote_text', true);
    $show_nature_section = get_post_meta($post->ID, '_show_nature_section', true);
    $nature_section_text = get_post_meta($post->ID, '_nature_section_text', true);
    $show_region_section = get_post_meta($post->ID, '_show_region_section', true);
    $region_section_text = get_post_meta($post->ID, '_region_section_text', true);
    
    // Additional content section fields
    $show_additional_section = get_post_meta($post->ID, '_show_additional_section', true);
    $additional_images = get_post_meta($post->ID, '_additional_section_images', true);
    $additional_quote_title = get_post_meta($post->ID, '_additional_quote_title', true);
    $additional_quote_text = get_post_meta($post->ID, '_additional_quote_text', true);
    $additional_content = get_post_meta($post->ID, '_additional_content', true);

    $cta_title = get_post_meta($post->ID, '_cta_title', true);
    $cta_subtitle = get_post_meta($post->ID, '_cta_subtitle', true);
    $cta_primary_button = get_post_meta($post->ID, '_cta_primary_button', true);
    $cta_secondary_button = get_post_meta($post->ID, '_cta_secondary_button', true);
    $cta_pdf_file = get_post_meta($post->ID, '_cta_pdf_file', true);
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th>Display Options</th>';
    echo '<td>';
    echo '<label><input type="checkbox" name="featured_in_carousel" value="1"' . checked($featured_in_carousel, 1, false) . ' /> Display in Homepage Carousel</label><br>';
    echo '<label><input type="checkbox" name="featured_in_archive" value="1"' . checked($featured_in_archive, 1, false) . ' /> Display in Experiences Archive Page</label><br>';
    echo '<label><input type="checkbox" name="display_in_dining" value="1"' . checked(get_post_meta($post->ID, '_display_in_dining', true), 1, false) . ' /> Display in Dining Page</label>';
    echo '<p class="description">Choose where this experience should appear.</p>';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="experience_short_description">Short Description</label></th>';
    echo '<td><input type="text" id="experience_short_description" name="experience_short_description" value="' . esc_attr($short_description) . '" class="widefat" placeholder="e.g., Banana boat, flying donut, kayak, paddle boat" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="experience_type">Experience Type</label></th>';
    echo '<td>';
    echo '<select id="experience_type" name="experience_type" onchange="toggleCategoryFields()">';
    echo '<option value="single"' . selected($experience_type, 'single', false) . '>Single Experience</option>';
    echo '<option value="category"' . selected($experience_type, 'category', false) . '>Category (has sub-experiences)</option>';
    echo '</select>';
    echo '<p class="description">Choose "Category" if this experience contains multiple sub-experiences.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Category Template Selection Row
    echo '<tr id="category_template_row" style="' . ($experience_type !== 'category' ? 'display: none;' : '') . '">';
    echo '<th><label for="category_template">Category Template</label></th>';
    echo '<td>';
    echo '<select id="category_template" name="category_template" onchange="toggleDetailedFields()">';
    echo '<option value="listing"' . selected($category_template, 'listing', false) . '>Listing (Simple Grid)</option>';
    echo '<option value="detailed"' . selected($category_template, 'detailed', false) . '>Detailed (Magazine Style)</option>';
    echo '</select>';
    echo '<p class="description">Choose the layout style for category pages.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Hero Gallery Row - Show for both single experiences and detailed categories
    $show_detailed_fields = ($experience_type === 'single') || ($experience_type === 'category' && $category_template === 'detailed');
    echo '<tr id="hero_gallery_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Hero Banner Gallery</label></th>';
    echo '<td>';
    echo '<div class="hero-gallery-images">';
    
    if ($hero_gallery && is_array($hero_gallery)) {
        foreach ($hero_gallery as $index => $image_id) {
            $image_url = wp_get_attachment_image_src($image_id, 'thumbnail');
            if ($image_url) {
                echo '<div class="hero-gallery-item" data-id="' . $image_id . '">';
                echo '<img src="' . $image_url[0] . '" style="max-width: 100px; margin: 5px;">';
                echo '<button type="button" class="remove-hero-gallery-image button">Remove</button>';
                echo '<input type="hidden" name="hero_banner_gallery[' . $index . ']" value="' . $image_id . '">';
                echo '</div>';
            }
        }
    }
    
    echo '</div>';
    echo '<button type="button" id="add_hero_gallery_image" class="button">Add Gallery Images</button>';
    echo '<button type="button" id="clear_hero_gallery" class="button">Clear All</button>';
    echo '<p class="description">Upload 4 images for the hero banner gallery. Images will be arranged in a grid layout.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Detailed Subtitle
    echo '<tr id="detailed_subtitle_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label for="detailed_subtitle">Subtitle</label></th>';
    echo '<td><input type="text" id="detailed_subtitle" name="detailed_subtitle" value="' . esc_attr($detailed_subtitle) . '" class="widefat" placeholder="Subtitle text displayed below the main title" /></td>';
    echo '</tr>';
    
    // Quote Section
    echo '<tr id="quote_section_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Quote Section</label></th>';
    echo '<td>';
    echo '<input type="text" name="quote_title" value="' . esc_attr($quote_title) . '" placeholder="Quote Title" class="widefat" style="margin-bottom: 10px;" />';
    echo '<textarea name="quote_text" placeholder="Quote Text" class="widefat" rows="3">' . esc_textarea($quote_text) . '</textarea>';
    echo '<p class="description">Optional quote section displayed after the gallery.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Nature Section
    echo '<tr id="nature_section_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Nature Section</label></th>';
    echo '<td>';
    echo '<label><input type="checkbox" name="show_nature_section" value="1"' . checked($show_nature_section, 1, false) . ' /> Show Nature Section</label><br><br>';
    wp_editor($nature_section_text, 'nature_section_text', array(
        'textarea_name' => 'nature_section_text',
        'textarea_rows' => 5,
        'teeny' => true,
        'media_buttons' => false,
    ));
    echo '<p class="description">Content for the nature section. Check the box above to display this section.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Region Section
    echo '<tr id="region_section_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Region Section</label></th>';
    echo '<td>';
    echo '<label><input type="checkbox" name="show_region_section" value="1"' . checked($show_region_section, 1, false) . ' /> Show Region Section</label><br><br>';
    wp_editor($region_section_text, 'region_section_text', array(
        'textarea_name' => 'region_section_text',
        'textarea_rows' => 5,
        'teeny' => true,
        'media_buttons' => false,
    ));
    echo '<p class="description">Content for the region section. Check the box above to display this section.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Additional Section Toggle
    echo '<tr id="additional_section_toggle_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Additional Content Section</label></th>';
    echo '<td>';
    echo '<label><input type="checkbox" name="show_additional_section" value="1"' . checked($show_additional_section, 1, false) . ' onchange="toggleAdditionalSectionFields()" /> Show Additional Content Section</label>';
    echo '<p class="description">Check this to enable the additional content section with images and text.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Additional Section Images
    echo '<tr id="additional_images_row" style="' . (!$show_detailed_fields || !$show_additional_section ? 'display: none;' : '') . '">';
    echo '<th><label>Additional Section Images</label></th>';
    echo '<td>';
    echo '<div class="additional-images">';
    
    if ($additional_images && is_array($additional_images)) {
        foreach ($additional_images as $index => $image_id) {
            $image_url = wp_get_attachment_image_src($image_id, 'thumbnail');
            if ($image_url) {
                echo '<div class="additional-image-item" data-id="' . $image_id . '">';
                echo '<img src="' . $image_url[0] . '" style="max-width: 100px; margin: 5px;">';
                echo '<button type="button" class="remove-additional-image button">Remove</button>';
                echo '<input type="hidden" name="additional_section_images[' . $index . ']" value="' . $image_id . '">';
                echo '</div>';
            }
        }
    }
    
    echo '</div>';
    echo '<button type="button" id="add_additional_images" class="button">Add Images</button>';
    echo '<button type="button" id="clear_additional_images" class="button">Clear All</button>';
    echo '<p class="description">Add images for the additional content section.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Additional Section Quote
    echo '<tr id="additional_quote_row" style="' . (!$show_detailed_fields || !$show_additional_section ? 'display: none;' : '') . '">';
    echo '<th><label>Additional Section Quote</label></th>';
    echo '<td>';
    echo '<input type="text" name="additional_quote_title" value="' . esc_attr($additional_quote_title) . '" placeholder="Quote Title" class="widefat" style="margin-bottom: 10px;" />';
    echo '<textarea name="additional_quote_text" placeholder="Quote Text" class="widefat" rows="3">' . esc_textarea($additional_quote_text) . '</textarea>';
    echo '<p class="description">Optional quote for the additional section.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Additional Content
    echo '<tr id="additional_content_row" style="' . (!$show_detailed_fields || !$show_additional_section ? 'display: none;' : '') . '">';
    echo '<th><label for="additional_content">Additional Content</label></th>';
    echo '<td>';
    wp_editor($additional_content, 'additional_content', array(
        'textarea_name' => 'additional_content',
        'textarea_rows' => 8,
        'teeny' => false,
        'media_buttons' => true,
    ));
    echo '<p class="description">Content for the additional section. If left empty, no content will be displayed in this section.</p>';
    echo '</td>';
    echo '</tr>';

 // CTA Section Fields - Show ONLY for single experiences
    $show_cta_fields = ($experience_type === 'single');
    echo '<tr id="cta_section_row" style="' . (!$show_cta_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Call to Action Section</label></th>';
    echo '<td>';
    echo '<input type="text" name="cta_title" value="' . esc_attr($cta_title) . '" placeholder="e.g., Book your experience" class="widefat" style="margin-bottom: 10px;" />';
    echo '<p class="description" style="margin-bottom: 10px;">CTA Title (if empty, will use: Book your [experience title])</p>';
    echo '<input type="text" name="cta_subtitle" value="' . esc_attr($cta_subtitle) . '" placeholder="e.g., Make your journey unforgettable — reserve your experience in advance" class="widefat" style="margin-bottom: 10px;" />';
    echo '<p class="description" style="margin-bottom: 10px;">CTA Subtitle</p>';
    echo '<input type="text" name="cta_secondary_button" value="' . esc_attr($cta_secondary_button) . '" placeholder="e.g., Download Our Map" class="widefat" style="margin-bottom: 10px;" />';
    echo '<p class="description" style="margin-bottom: 10px;">Secondary Button Text (transparent with gold border)</p>';
    
    // PDF Upload Field
    echo '<div id="cta_pdf_upload_container" style="margin-bottom: 15px;">';
    echo '<label style="display: block; margin-bottom: 5px; font-weight: bold;">PDF File for Download Button:</label>';
    
    if ($cta_pdf_file) {
        $pdf_url = wp_get_attachment_url($cta_pdf_file);
        $pdf_filename = basename(get_attached_file($cta_pdf_file));
        echo '<div id="current_pdf_display" style="background: #f1f1f1; padding: 10px; border-radius: 3px; margin-bottom: 10px;">';
        echo '<strong>Current PDF:</strong> <a href="' . esc_url($pdf_url) . '" target="_blank">' . esc_html($pdf_filename) . '</a>';
        echo ' <button type="button" id="remove_pdf_btn" class="button" style="margin-left: 10px;">Remove PDF</button>';
        echo '</div>';
    }
    
    echo '<button type="button" id="upload_pdf_btn" class="button">' . ($cta_pdf_file ? 'Change PDF' : 'Upload PDF') . '</button>';
    echo '<input type="hidden" id="cta_pdf_file" name="cta_pdf_file" value="' . esc_attr($cta_pdf_file) . '" />';
    echo '<p class="description">Upload a PDF file that will be downloaded when users click the secondary button.</p>';
    echo '</div>';
    
    echo '<input type="text" name="cta_primary_button" value="' . esc_attr($cta_primary_button) . '" placeholder="e.g., Book Now" class="widefat" style="margin-bottom: 10px;" />';
    echo '<p class="description">Primary Button Text (gold background)</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '</table>';
    
    // Add JavaScript for gallery management and field toggling
       ?>
    <script>
    jQuery(document).ready(function($) {
        
        // ===== HERO GALLERY UPLOADER =====
        var heroGalleryUploader;
        
        $('#add_hero_gallery_image').on('click', function(e) {
            e.preventDefault();
            
            if (heroGalleryUploader) {
                heroGalleryUploader.open();
                return;
            }
            
            heroGalleryUploader = wp.media({
                title: 'Select Images for Hero Gallery',
                button: {
                    text: 'Add to Gallery'
                },
                multiple: true,
                library: {
                    type: 'image'
                }
            });
            
            heroGalleryUploader.on('select', function() {
                var attachments = heroGalleryUploader.state().get('selection').toJSON();
                var currentCount = $('.hero-gallery-item').length;
                var maxImages = 4;
                var availableSlots = maxImages - currentCount;
                
                if (availableSlots <= 0) {
                    alert('Maximum of 4 images allowed for hero banner gallery. Please remove some images first.');
                    return;
                }
                
                // Add selected images (up to available slots)
                attachments.slice(0, availableSlots).forEach(function(attachment, index) {
                    var imageIndex = currentCount + index;
                    var imageHtml = '<div class="hero-gallery-item" data-id="' + attachment.id + '" style="position: relative; display: inline-block; margin: 5px;">';
                    imageHtml += '<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" style="max-width: 100px; height: 80px; object-fit: cover; border: 2px solid #ddd;" />';
                    imageHtml += '<button type="button" class="remove-hero-gallery-image button" style="position: absolute; top: -5px; right: -5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1; padding: 0;">×</button>';
                    imageHtml += '<input type="hidden" name="hero_banner_gallery[' + imageIndex + ']" value="' + attachment.id + '">';
                    imageHtml += '</div>';
                    
                    $('.hero-gallery-images').append(imageHtml);
                });
                
                if (attachments.length > availableSlots) {
                    alert('Only ' + availableSlots + ' images were added. Maximum of 4 images total allowed for hero gallery.');
                }
            });
            
            heroGalleryUploader.open();
        });
        
        // Remove hero gallery image
        $(document).on('click', '.remove-hero-gallery-image', function(e) {
            e.preventDefault();
            $(this).closest('.hero-gallery-item').remove();
            
            // Reindex the remaining images
            $('.hero-gallery-item').each(function(index) {
                $(this).find('input[type="hidden"]').attr('name', 'hero_banner_gallery[' + index + ']');
            });
        });
        
        // Clear all hero gallery images
        $('#clear_hero_gallery').on('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to clear all gallery images?')) {
                $('.hero-gallery-images').empty();
            }
        });
        
        // ===== ADDITIONAL SECTION IMAGES UPLOADER =====
        var additionalMediaUploader;
        
        $('#add_additional_images').on('click', function(e) {
            e.preventDefault();
            
            if (additionalMediaUploader) {
                additionalMediaUploader.open();
                return;
            }
            
            additionalMediaUploader = wp.media({
                title: 'Select Images for Additional Section',
                button: {
                    text: 'Use Selected Images'
                },
                multiple: true,
                library: {
                    type: 'image'
                }
            });
            
            additionalMediaUploader.on('select', function() {
                var attachments = additionalMediaUploader.state().get('selection').toJSON();
                var currentCount = $('.additional-image-item').length;
                var maxImages = 2;
                var availableSlots = maxImages - currentCount;
                
                if (availableSlots <= 0) {
                    alert('Maximum of 2 images allowed for additional section. Please remove some images first.');
                    return;
                }
                
                // Add selected images (up to available slots)
                attachments.slice(0, availableSlots).forEach(function(attachment, index) {
                    var imageIndex = currentCount + index;
                    var imageHtml = '<div class="additional-image-item" data-id="' + attachment.id + '" style="position: relative; display: inline-block; margin: 5px;">';
                    imageHtml += '<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" style="max-width: 100px; height: 80px; object-fit: cover; border: 2px solid #ddd;" />';
                    imageHtml += '<button type="button" class="remove-additional-image button" style="position: absolute; top: -5px; right: -5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1; padding: 0;">×</button>';
                    imageHtml += '<input type="hidden" name="additional_section_images[' + imageIndex + ']" value="' + attachment.id + '">';
                    imageHtml += '</div>';
                    
                    $('.additional-images').append(imageHtml);
                });
                
                if (attachments.length > availableSlots) {
                    alert('Only ' + availableSlots + ' images were added. Maximum of 2 images total allowed for additional section.');
                }
            });
            
            additionalMediaUploader.open();
        });
        
        // Remove additional image
        $(document).on('click', '.remove-additional-image', function(e) {
            e.preventDefault();
            $(this).closest('.additional-image-item').remove();
            
            // Reindex the remaining images
            $('.additional-image-item').each(function(index) {
                $(this).find('input[type="hidden"]').attr('name', 'additional_section_images[' + index + ']');
            });
        });
        
        // Clear all additional images
        $('#clear_additional_images').on('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to clear all additional images?')) {
                $('.additional-images').empty();
            }
        });
        
        // ===== PDF UPLOAD FUNCTIONALITY =====
        var ctaPdfUploader;
        
        $('#upload_pdf_btn').on('click', function(e) {
            e.preventDefault();
            
            if (ctaPdfUploader) {
                ctaPdfUploader.open();
                return;
            }
            
            ctaPdfUploader = wp.media({
                title: 'Select PDF File',
                library: {
                    type: 'application/pdf'
                },
                button: {
                    text: 'Use this PDF'
                },
                multiple: false
            });
            
            ctaPdfUploader.on('select', function() {
                var attachment = ctaPdfUploader.state().get('selection').first().toJSON();
                
                if (attachment.mime !== 'application/pdf') {
                    alert('Please select a PDF file.');
                    return;
                }
                
                $('#cta_pdf_file').val(attachment.id);
                
                var displayHtml = '<div id="current_pdf_display" style="background: #f1f1f1; padding: 10px; border-radius: 3px; margin-bottom: 10px;">';
                displayHtml += '<strong>Current PDF:</strong> <a href="' + attachment.url + '" target="_blank">' + attachment.filename + '</a>';
                displayHtml += ' <button type="button" id="remove_pdf_btn" class="button" style="margin-left: 10px;">Remove PDF</button>';
                displayHtml += '</div>';
                
                $('#current_pdf_display').remove();
                $('#upload_pdf_btn').before(displayHtml);
                $('#upload_pdf_btn').text('Change PDF');
            });
            
            ctaPdfUploader.open();
        });
        
        // Remove PDF functionality
        $(document).on('click', '#remove_pdf_btn', function(e) {
            e.preventDefault();
            $('#cta_pdf_file').val('');
            $('#current_pdf_display').remove();
            $('#upload_pdf_btn').text('Upload PDF');
        });
        
        // ===== FORM FIELD TOGGLES =====
        function toggleCategoryFields() {
            var experienceType = document.getElementById("experience_type").value;
            var categoryTemplateRow = document.getElementById("category_template_row");
            
            if (experienceType === "category") {
                categoryTemplateRow.style.display = "table-row";
                toggleDetailedFields(); // Check if detailed fields should be shown
            } else {
                categoryTemplateRow.style.display = "none";
                // For single experiences, always show detailed fields
                showDetailedFields();
            }
            
            // Always update CTA visibility based on experience type
            toggleCTAFields();
        }
        
        function toggleDetailedFields() {
            var experienceType = document.getElementById("experience_type").value;
            var categoryTemplate = document.getElementById("category_template").value;
            var showFields = (experienceType === "single") || (experienceType === "category" && categoryTemplate === "detailed");
            
            if (showFields) {
                showDetailedFields();
            } else {
                hideDetailedFields();
            }
            
            // Always update CTA visibility based on experience type
            toggleCTAFields();
        }
        
        function showDetailedFields() {
            // These fields show for both single experiences AND detailed category templates
            var detailedRows = [
                "detailed_subtitle_row",
                "quote_section_row", 
                "nature_section_row",
                "region_section_row",
                "hero_gallery_row",
                "additional_section_toggle_row"
                // Note: CTA section is handled separately
            ];
            
            detailedRows.forEach(function(rowId) {
                var row = document.getElementById(rowId);
                if (row) {
                    row.style.display = "table-row";
                }
            });
            
            // Also check if additional section should be shown
            toggleAdditionalSectionFields();
        }
        
        function hideDetailedFields() {
            var detailedRows = [
                "detailed_subtitle_row",
                "quote_section_row", 
                "nature_section_row",
                "region_section_row",
                "hero_gallery_row",
                "additional_section_toggle_row",
                "additional_images_row",
                "additional_quote_row",
                "additional_content_row"
                // Note: CTA section is handled separately
            ];
            
            detailedRows.forEach(function(rowId) {
                var row = document.getElementById(rowId);
                if (row) {
                    row.style.display = "none";
                }
            });
        }

        function toggleCTAFields() {
            var experienceType = document.getElementById("experience_type").value;
            var ctaRow = document.getElementById("cta_section_row");
            
            if (ctaRow) {
                // CTA section only shows for single experiences
                if (experienceType === "single") {
                    ctaRow.style.display = "table-row";
                } else {
                    ctaRow.style.display = "none";
                }
            }
        }
        
        function toggleAdditionalSectionFields() {
            var showAdditional = document.querySelector('input[name="show_additional_section"]');
            if (!showAdditional) return;
            
            var isChecked = showAdditional.checked;
            var additionalRows = [
                "additional_images_row",
                "additional_quote_row",
                "additional_content_row"
            ];
            
            additionalRows.forEach(function(rowId) {
                var row = document.getElementById(rowId);
                if (row) {
                    row.style.display = isChecked ? "table-row" : "none";
                }
            });
        }
        
        // Make functions global so they can be called from inline handlers
        window.toggleCategoryFields = toggleCategoryFields;
        window.toggleDetailedFields = toggleDetailedFields;
        window.toggleAdditionalSectionFields = toggleAdditionalSectionFields;
        
        // Initialize on page load
        toggleCategoryFields();
        
        // Make galleries sortable
        if ($('.hero-gallery-images').length) {
            $('.hero-gallery-images').sortable({
                items: '.hero-gallery-item',
                cursor: 'move',
                update: function() {
                    // Reindex after sorting
                    $('.hero-gallery-item').each(function(index) {
                        $(this).find('input[type="hidden"]').attr('name', 'hero_banner_gallery[' + index + ']');
                    });
                }
            });
        }
        
        if ($('.additional-images').length) {
            $('.additional-images').sortable({
                items: '.additional-image-item',
                cursor: 'move',
                update: function() {
                    // Reindex after sorting
                    $('.additional-image-item').each(function(index) {
                        $(this).find('input[type="hidden"]').attr('name', 'additional_section_images[' + index + ']');
                    });
                }
            });
        }
    });
    </script>
    <?php
}

function save_experience_details($post_id) {
    if (!isset($_POST['experience_details_nonce']) || !wp_verify_nonce($_POST['experience_details_nonce'], 'save_experience_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['experience_short_description'])) {
        update_post_meta($post_id, '_experience_short_description', sanitize_text_field($_POST['experience_short_description']));
    }

    if (isset($_POST['experience_type'])) {
        update_post_meta($post_id, '_experience_type', sanitize_text_field($_POST['experience_type']));
    }
    
    // Save category template selection
    if (isset($_POST['category_template'])) {
        update_post_meta($post_id, '_category_template', sanitize_text_field($_POST['category_template']));
    }
    
    // Save detailed template fields
    if (isset($_POST['detailed_subtitle'])) {
        update_post_meta($post_id, '_detailed_subtitle', sanitize_text_field($_POST['detailed_subtitle']));
    }
    
    if (isset($_POST['quote_title'])) {
        update_post_meta($post_id, '_quote_title', sanitize_text_field($_POST['quote_title']));
    }
    
    if (isset($_POST['quote_text'])) {
        update_post_meta($post_id, '_quote_text', sanitize_textarea_field($_POST['quote_text']));
    }
    
    // Save section toggles and text
    $show_nature_section = isset($_POST['show_nature_section']) ? 1 : 0;
    update_post_meta($post_id, '_show_nature_section', $show_nature_section);
    
    if (isset($_POST['nature_section_text'])) {
        update_post_meta($post_id, '_nature_section_text', sanitize_text_field($_POST['nature_section_text']));
    }
    
    $show_region_section = isset($_POST['show_region_section']) ? 1 : 0;
    update_post_meta($post_id, '_show_region_section', $show_region_section);
    
    if (isset($_POST['region_section_text'])) {
        update_post_meta($post_id, '_region_section_text', sanitize_text_field($_POST['region_section_text']));
    }
    
    // Save additional content section
    $show_additional_section = isset($_POST['show_additional_section']) ? 1 : 0;
    update_post_meta($post_id, '_show_additional_section', $show_additional_section);
    
    if (isset($_POST['additional_quote_title'])) {
        update_post_meta($post_id, '_additional_quote_title', sanitize_text_field($_POST['additional_quote_title']));
    }
    
    if (isset($_POST['additional_quote_text'])) {
        update_post_meta($post_id, '_additional_quote_text', sanitize_textarea_field($_POST['additional_quote_text']));
    }
    
    if (isset($_POST['additional_content'])) {
        update_post_meta($post_id, '_additional_content', wp_kses_post($_POST['additional_content']));
    }
    
    // Save additional section images
    if (isset($_POST['additional_section_images']) && is_array($_POST['additional_section_images'])) {
        $additional_image_ids = array_map('intval', $_POST['additional_section_images']);
        $additional_image_ids = array_filter($additional_image_ids); // Remove empty values
        $additional_image_ids = array_slice($additional_image_ids, 0, 2); // Limit to 2 images
        update_post_meta($post_id, '_additional_section_images', $additional_image_ids);
    } else {
        delete_post_meta($post_id, '_additional_section_images');
    }
    
    // Save hero banner gallery
    if (isset($_POST['hero_banner_gallery']) && is_array($_POST['hero_banner_gallery'])) {
        $gallery_ids = array_map('intval', $_POST['hero_banner_gallery']);
        $gallery_ids = array_filter($gallery_ids); // Remove empty values
        $gallery_ids = array_slice($gallery_ids, 0, 4); // Limit to 4 images
        update_post_meta($post_id, '_hero_banner_gallery', $gallery_ids);
    } else {
        delete_post_meta($post_id, '_hero_banner_gallery');
    }
   // Save CTA section fields
    if (isset($_POST['cta_title'])) {
        update_post_meta($post_id, '_cta_title', sanitize_text_field($_POST['cta_title']));
    }
    
    if (isset($_POST['cta_subtitle'])) {
        update_post_meta($post_id, '_cta_subtitle', sanitize_textarea_field($_POST['cta_subtitle']));
    }
    
    if (isset($_POST['cta_primary_button'])) {
        update_post_meta($post_id, '_cta_primary_button', sanitize_text_field($_POST['cta_primary_button']));
    }
    
    if (isset($_POST['cta_secondary_button'])) {
        update_post_meta($post_id, '_cta_secondary_button', sanitize_text_field($_POST['cta_secondary_button']));
    }
    
    if (isset($_POST['cta_pdf_file'])) {
        update_post_meta($post_id, '_cta_pdf_file', intval($_POST['cta_pdf_file']));
    }

    $featured_carousel = isset($_POST['featured_in_carousel']) ? 1 : 0;
    update_post_meta($post_id, '_featured_in_carousel', $featured_carousel);
    
    $featured_archive = isset($_POST['featured_in_archive']) ? 1 : 0;
    update_post_meta($post_id, '_featured_in_archive', $featured_archive);

    $display_in_dining = isset($_POST['display_in_dining']) ? 1 : 0;
    update_post_meta($post_id, '_display_in_dining', $display_in_dining);
}
add_action('save_post', 'save_experience_details');

function get_dining_experiences($limit = 3) {
    $args = array(
        'post_type' => 'experience',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_display_in_dining',
                'value' => '1',
                'compare' => '='
            )
        ),
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    
    return new WP_Query($args);
}

function add_dining_column_to_experiences($columns) {
    // Insert the new column after the 'featured' column
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'featured') {
            $new_columns['dining_page'] = __('Dining Page', 'nirup-island');
        }
    }
    return $new_columns;
}
add_filter('manage_experience_posts_columns', 'add_dining_column_to_experiences');

function display_dining_column_content($column, $post_id) {
    if ($column === 'dining_page') {
        $display_in_dining = get_post_meta($post_id, '_display_in_dining', true);
        echo $display_in_dining ? '<span style="color: green; font-weight: bold;">✓ Yes</span>' : '<span style="color: #888;">No</span>';
    }
}
add_action('manage_experience_posts_custom_column', 'display_dining_column_content', 10, 2);

function nirup_enqueue_detailed_category_css() {
    if (is_singular('experience')) {
        global $post;
        $experience_type = get_post_meta($post->ID, '_experience_type', true);
        $category_template = get_post_meta($post->ID, '_category_template', true);
        
        if ($experience_type === 'category' && $category_template === 'detailed') {
            wp_enqueue_style(
                'nirup-detailed-category', 
                get_template_directory_uri() . '/assets/css/experience-category-detailed.css', 
                array('nirup-main'), 
                '1.0.0'
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_detailed_category_css');

function nirup_enqueue_detailed_recommendations_js() {
    if (is_singular('experience')) {
        global $post;
        $experience_type = get_post_meta($post->ID, '_experience_type', true);
        $category_template = get_post_meta($post->ID, '_category_template', true);
        
        if ($experience_type === 'category' && $category_template === 'detailed') {
            wp_enqueue_script(
                'nirup-detailed-recommendations-carousel',
                get_template_directory_uri() . '/assets/js/detailed-recommendations-carousel.js',
                array(),
                '1.0.0',
                true
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_detailed_recommendations_js');

function nirup_admin_enqueue_scripts($hook) {
    global $post_type;
    
    // Only load on post edit/new pages for experiences and event_offers
    if ($hook == 'post-new.php' || $hook == 'post.php') {
        if ($post_type == 'experience' || $post_type == 'event_offer') {
            // Enqueue WordPress media library
            wp_enqueue_media();
            
            // Enqueue required scripts
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-sortable');
            
            // Enqueue WordPress media scripts
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
            wp_enqueue_style('thickbox');
        }
    }
}
add_action('admin_enqueue_scripts', 'nirup_admin_enqueue_scripts');

/**
 * NEW: Get featured experiences for carousel
 */
function get_featured_experiences($limit = -1) {
    $args = array(
        'post_type' => 'experience',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_featured_in_carousel',
                'value' => '1',
                'compare' => '='
            )
        ),
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    
    return new WP_Query($args);
}

/**
 * NEW: Get all experiences (for archive page)
 */
function get_all_experiences($parent_id = 0) {
    $args = array(
        'post_type' => 'experience',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'post_parent' => $parent_id,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    
    return new WP_Query($args);
}

/**
 * NEW: Get child experiences for category-type experiences
 */
function get_child_experiences($parent_id) {
    $args = array(
        'post_type' => 'experience',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'post_parent' => $parent_id,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    
    return new WP_Query($args);
}

/**
 * NEW: Add custom columns to experiences admin list
 */
function set_custom_experience_columns($columns) {
    $columns['featured'] = __('Featured in Carousel', 'nirup-island');
    $columns['type'] = __('Type', 'nirup-island');
    $columns['template'] = __('Template', 'nirup-island');
    $columns['gallery'] = __('Hero Gallery', 'nirup-island');
    $columns['additional'] = __('Additional Section', 'nirup-island');
    $columns['short_desc'] = __('Short Description', 'nirup-island');
    $columns['parent'] = __('Parent', 'nirup-island');
    return $columns;
}
add_filter('manage_experience_posts_columns', 'set_custom_experience_columns');

function custom_experience_column($column, $post_id) {
    switch ($column) {
        case 'featured':
            $featured = get_post_meta($post_id, '_featured_in_carousel', true);
            echo $featured ? '<span style="color: green; font-weight: bold;">✓ Yes</span>' : '<span style="color: #888;">No</span>';
            break;
        case 'type':
            $type = get_post_meta($post_id, '_experience_type', true);
            echo $type ? '<span style="background: #0073aa; color: white; padding: 2px 6px; border-radius: 3px; font-size: 11px;">' . ucfirst($type) . '</span>' : '<span style="background: #ddd; color: #555; padding: 2px 6px; border-radius: 3px; font-size: 11px;">Single</span>';
            break;
        case 'template':
            $type = get_post_meta($post_id, '_experience_type', true);
            if ($type === 'category') {
                $template = get_post_meta($post_id, '_category_template', true);
                $template = $template ? $template : 'listing'; // Default to listing
                $color = $template === 'detailed' ? '#8b5e1d' : '#666';
                echo '<span style="background: ' . $color . '; color: white; padding: 2px 6px; border-radius: 3px; font-size: 11px;">' . ucfirst($template) . '</span>';
            } else {
                echo '<span style="color: #ccc;">—</span>';
            }
            break;
        case 'gallery':
            $type = get_post_meta($post_id, '_experience_type', true);
            $template = get_post_meta($post_id, '_category_template', true);
            if ($type === 'category' && $template === 'detailed') {
                $gallery = get_post_meta($post_id, '_hero_banner_gallery', true);
                $count = is_array($gallery) ? count($gallery) : 0;
                if ($count > 0) {
                    echo '<span style="color: green; font-weight: bold;">' . $count . '/4 images</span>';
                } else {
                    echo '<span style="color: #dc3232;">No images</span>';
                }
            } else {
                echo '<span style="color: #ccc;">—</span>';
            }
            break;
        case 'additional':
            $type = get_post_meta($post_id, '_experience_type', true);
            $template = get_post_meta($post_id, '_category_template', true);
            if ($type === 'category' && $template === 'detailed') {
                $show_additional = get_post_meta($post_id, '_show_additional_section', true);
                if ($show_additional) {
                    $additional_images = get_post_meta($post_id, '_additional_section_images', true);
                    $img_count = is_array($additional_images) ? count($additional_images) : 0;
                    echo '<span style="color: green; font-weight: bold;">✓ Enabled (' . $img_count . '/2)</span>';
                } else {
                    echo '<span style="color: #888;">Disabled</span>';
                }
            } else {
                echo '<span style="color: #ccc;">—</span>';
            }
            break;
        case 'short_desc':
            $desc = get_post_meta($post_id, '_experience_short_description', true);
            echo $desc ? '<em>' . esc_html(wp_trim_words($desc, 8)) . '</em>' : '<span style="color: #888;">No description</span>';
            break;
        case 'parent':
            $parent_id = wp_get_post_parent_id($post_id);
            if ($parent_id) {
                $parent_title = get_the_title($parent_id);
                $parent_link = get_edit_post_link($parent_id);
                echo '<a href="' . esc_url($parent_link) . '">' . esc_html($parent_title) . '</a>';
            } else {
                echo '<span style="color: #888;">—</span>';
            }
            break;
    }
}
add_action('manage_experience_posts_custom_column', 'custom_experience_column', 10, 2);

/**
 * NEW: Create sample experiences on theme activation
 */
function create_sample_experiences() {
    // Check if sample experiences already exist
    $existing = get_posts(array(
        'post_type' => 'experience',
        'posts_per_page' => 1,
        'post_status' => 'any'
    ));
    
    if (!empty($existing)) {
        return; // Sample experiences already exist
    }
    
    // Sample experiences data
    $sample_experiences = array(
        array(
            'title' => 'Water Sports',
            'short_desc' => 'Banana boat, flying donut, kayak, paddle boat',
            'content' => 'Dive into excitement with our comprehensive water sports activities. From thrilling banana boat rides to peaceful kayaking sessions, there\'s something for every adventure level.',
            'type' => 'single',
            'featured' => true
        ),
        array(
            'title' => 'Wellness',
            'short_desc' => 'Heavenly Spa, fitness studio, outdoor pool',
            'content' => 'Rejuvenate your mind, body, and soul with our world-class wellness facilities. Experience the ultimate relaxation at our Heavenly Spa by Westin™.',
            'type' => 'single',
            'featured' => true
        ),
        array(
            'title' => 'Kids Club',
            'short_desc' => 'Indoor & outdoor activities for ages 4–12',
            'content' => 'Keep your little ones entertained with our supervised kids club featuring age-appropriate activities, games, and adventures.',
            'type' => 'single',
            'featured' => true
        ),
        array(
            'title' => 'Excursions',
            'short_desc' => 'Cultural trips to the Riau Islands',
            'content' => 'Explore the rich culture and natural beauty of the Riau Islands with our guided excursion packages.',
            'type' => 'category',
            'featured' => true
        )
    );
    
    foreach ($sample_experiences as $experience) {
        $post_id = wp_insert_post(array(
            'post_title' => $experience['title'],
            'post_content' => $experience['content'],
            'post_status' => 'publish',
            'post_type' => 'experience'
        ));
        
        if ($post_id && !is_wp_error($post_id)) {
            update_post_meta($post_id, '_experience_short_description', $experience['short_desc']);
            update_post_meta($post_id, '_experience_type', $experience['type']);
            update_post_meta($post_id, '_featured_in_carousel', $experience['featured'] ? 1 : 0);
        }
    }
}
add_action('after_switch_theme', 'create_sample_experiences');

/**
 * NEW: Add custom image sizes for experiences
 */
function nirup_custom_image_sizes() {
    add_image_size('experience-carousel', 380, 420, true);
    add_image_size('experience-featured', 800, 600, true);
}
add_action('after_setup_theme', 'nirup_custom_image_sizes');

/**
 * NEW: Flush rewrite rules on theme activation
 */
function nirup_rewrite_flush() {
    register_experiences_post_type();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'nirup_rewrite_flush');

/**
 * Plugin Support and Compatibility
 */

// Yoast SEO Breadcrumbs support
function nirup_yoast_breadcrumbs() {
    if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<div class="breadcrumbs">', '</div>');
    }
}

// TranslatePress compatibility and customization
function nirup_translatepress_support() {
    if (function_exists('trp_custom_language_switcher')) {
        // Hide the default TranslatePress language switcher
        add_action('wp_head', function() {
            echo '<style>
                .trp-language-switcher-container,
                .trp-floater,
                #trp-floater-ls {
                    display: none !important;
                }
            </style>';
        });
        
        // Remove TranslatePress default language switcher from footer/bottom
        remove_action('wp_footer', 'trp_add_language_switcher_shortcode');
    }
}
add_action('init', 'nirup_translatepress_support');

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

// Brevo (Sendinblue) compatibility and initialization
function nirup_brevo_support() {
    if (function_exists('sib_forms_shortcode')) {
        // Brevo forms are available
    }
}

// Initialize Brevo settings on theme activation
function nirup_initialize_brevo_settings() {
    // Only set if not already configured
    if (empty(get_theme_mod('nirup_brevo_api_key'))) {
        // Check if constant is defined in wp-config.php
        if (defined('NIRUP_BREVO_API_KEY')) {
            set_theme_mod('nirup_brevo_api_key', NIRUP_BREVO_API_KEY);
        }
    }

    if (empty(get_theme_mod('nirup_brevo_list_id'))) {
        // Check if constant is defined in wp-config.php
        if (defined('NIRUP_BREVO_LIST_ID')) {
            set_theme_mod('nirup_brevo_list_id', NIRUP_BREVO_LIST_ID);
        }
    }
}
add_action('after_setup_theme', 'nirup_initialize_brevo_settings');

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
        'priority' => 20,
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

    // Hero Section
    $wp_customize->add_section('nirup_hero_section', array(
        'title' => __('Hero Section', 'nirup-island'),
        'priority' => 25,
    ));

    // Hero Main Title
    $wp_customize->add_setting('nirup_hero_title', array(
        'default' => __('Your Island Escape', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_hero_title', array(
        'label' => __('Hero Title', 'nirup-island'),
        'section' => 'nirup_hero_section',
        'type' => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('nirup_hero_subtitle', array(
        'default' => __('Just 50 minutes from Singapore', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'nirup-island'),
        'section' => 'nirup_hero_section',
        'type' => 'text',
    ));

    // Hero Logo/Brand Image
    $wp_customize->add_setting('nirup_hero_logo', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_hero_logo', array(
        'label' => __('Hero Logo/Brand Image', 'nirup-island'),
        'section' => 'nirup_hero_section',
        'mime_type' => 'image',
    )));

    // Hero Logo Link
    $wp_customize->add_setting('nirup_hero_logo_link', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_hero_logo_link', array(
        'label' => __('Hero Logo Link URL', 'nirup-island'),
        'section' => 'nirup_hero_section',
        'type' => 'url',
        'description' => __('Enter the URL where the logo should link to (e.g., homepage or Westin website)', 'nirup-island'),
    ));

    // Hero CTA Button Text
    $wp_customize->add_setting('nirup_hero_cta_text', array(
        'default' => __('Book Your Stay', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_hero_cta_text', array(
        'label' => __('Hero Button Text', 'nirup-island'),
        'section' => 'nirup_hero_section',
        'type' => 'text',
    ));

    // Hero CTA Button Link
    $wp_customize->add_setting('nirup_hero_cta_link', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    // Video Section
$wp_customize->add_section('nirup_video_section', array(
    'title' => __('Video Section', 'nirup-island'),
    'priority' => 26,
));

// Show/Hide Video Section
$wp_customize->add_setting('nirup_video_show', array(
    'default' => true,
    'sanitize_callback' => 'wp_validate_boolean',
));

$wp_customize->add_control('nirup_video_show', array(
    'label' => __('Show Video Section', 'nirup-island'),
    'section' => 'nirup_video_section',
    'type' => 'checkbox',
));

// Video Source Type (YouTube or Upload)
$wp_customize->add_setting('nirup_video_source_type', array(
    'default' => 'youtube',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_control('nirup_video_source_type', array(
    'label' => __('Video Source', 'nirup-island'),
    'section' => 'nirup_video_section',
    'type' => 'radio',
    'choices' => array(
        'youtube' => __('YouTube Video', 'nirup-island'),
        'upload' => __('Upload Video', 'nirup-island'),
    ),
));

// YouTube Video URL
$wp_customize->add_setting('nirup_video_url', array(
    'default' => '',
    'sanitize_callback' => 'nirup_sanitize_youtube_url',
));

$wp_customize->add_control('nirup_video_url', array(
    'label' => __('YouTube Video URL', 'nirup-island'),
    'description' => __('Enter the full YouTube URL (e.g., https://www.youtube.com/watch?v=VIDEO_ID)', 'nirup-island'),
    'section' => 'nirup_video_section',
    'type' => 'url',
));

// Uploaded Video File
$wp_customize->add_setting('nirup_video_upload', array(
    'default' => '',
    'sanitize_callback' => 'absint',
));

$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_video_upload', array(
    'label' => __('Upload Video File', 'nirup-island'),
    'description' => __('Upload an MP4 video file. Recommended size: Max 50MB for better performance.', 'nirup-island'),
    'section' => 'nirup_video_section',
    'mime_type' => 'video',
)));

// Video Title (for accessibility)
$wp_customize->add_setting('nirup_video_title', array(
    'default' => __('Nirup Island Video', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_control('nirup_video_title', array(
    'label' => __('Video Title', 'nirup-island'),
    'description' => __('Title for accessibility (screen readers)', 'nirup-island'),
    'section' => 'nirup_video_section',
    'type' => 'text',
));

// Autoplay Toggle
$wp_customize->add_setting('nirup_video_autoplay', array(
    'default' => false,
    'sanitize_callback' => 'wp_validate_boolean',
));

$wp_customize->add_control('nirup_video_autoplay', array(
    'label' => __('Autoplay Video', 'nirup-island'),
    'description' => __('Video will autoplay muted when page loads. Best for ambient/background videos.', 'nirup-island'),
    'section' => 'nirup_video_section',
    'type' => 'checkbox',
));

// Loop Toggle
$wp_customize->add_setting('nirup_video_loop', array(
    'default' => false,
    'sanitize_callback' => 'wp_validate_boolean',
));

$wp_customize->add_control('nirup_video_loop', array(
    'label' => __('Loop Video', 'nirup-island'),
    'description' => __('Video will restart automatically when it ends.', 'nirup-island'),
    'section' => 'nirup_video_section',
    'type' => 'checkbox',
));

    // Navigation Settings Section
    $wp_customize->add_section('nirup_navigation', array(
        'title' => __('Navigation Settings', 'nirup-island'),
        'priority' => 21,
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


    // Wellness Retreat Section
$wp_customize->add_section('nirup_wellness_retreat', array(
    'title' => __('Promo Banner Section', 'nirup-island'),
    'priority' => 36,
));

// Small Title
$wp_customize->add_setting('nirup_wellness_small_title', array(
    'default' => __('Wellness Retreat Package', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_control('nirup_wellness_small_title', array(
    'label' => __('Small Title', 'nirup-island'),
    'section' => 'nirup_wellness_retreat',
    'type' => 'text',
));

// Main Title
$wp_customize->add_setting('nirup_wellness_main_title', array(
    'default' => __('WELLNESS RETREAT BY WESTIN', 'nirup-island'),
    'sanitize_callback' => 'sanitize_textarea_field',
));

$wp_customize->add_control('nirup_wellness_main_title', array(
    'label' => __('Main Title', 'nirup-island'),
    'section' => 'nirup_wellness_retreat',
    'type' => 'textarea',
));

// Date Range
$wp_customize->add_setting('nirup_wellness_date_range', array(
    'default' => __('June 03, 2025 – September 02, 2025', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_control('nirup_wellness_date_range', array(
    'label' => __('Date Range', 'nirup-island'),
    'section' => 'nirup_wellness_retreat',
    'type' => 'text',
));

// Description
$wp_customize->add_setting('nirup_wellness_description', array(
    'default' => __('The Nirup Wellness Retreat at The Westin Nirup Island Resort & Spa offers guests a holistic escape, featuring daily wellness and family activities, access to the WestinWORKOUT® Fitness Studio, and a curated program of rejuvenating experiences.', 'nirup-island'),
    'sanitize_callback' => 'sanitize_textarea_field',
));

$wp_customize->add_control('nirup_wellness_description', array(
    'label' => __('Description', 'nirup-island'),
    'section' => 'nirup_wellness_retreat',
    'type' => 'textarea',
));

// Button Text
$wp_customize->add_setting('nirup_wellness_button_text', array(
    'default' => __('Book Your Stay', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_control('nirup_wellness_button_text', array(
    'label' => __('Button Text', 'nirup-island'),
    'section' => 'nirup_wellness_retreat',
    'type' => 'text',
));

// Button Link
$wp_customize->add_setting('nirup_wellness_button_link', array(
    'default' => '#',
    'sanitize_callback' => 'esc_url_raw',
));

$wp_customize->add_control('nirup_wellness_button_link', array(
    'label' => __('Button Link', 'nirup-island'),
    'section' => 'nirup_wellness_retreat',
    'type' => 'url',
));

// Wellness Image
$wp_customize->add_setting('nirup_wellness_image', array(
    'default' => '',
    'sanitize_callback' => 'absint',
));

$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_wellness_image', array(
    'label' => __('Wellness Image', 'nirup-island'),
    'section' => 'nirup_wellness_retreat',
    'mime_type' => 'image',
)));
}
add_action('customize_register', 'nirup_customize_register');

/**
 * Add About Island Customizer Options
 */
function nirup_about_island_customizer($wp_customize) {
    // About Island Section
    $wp_customize->add_section('nirup_about_island', array(
        'title' => __('About Island Section', 'nirup-island'),
        'priority' => 32,
        'description' => __('Customize the About Island section content', 'nirup-island'),
    ));

    // Section Title
    $wp_customize->add_setting('nirup_about_section_title', array(
        'default' => __('ABOUT THE ISLAND', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_about_section_title', array(
        'label' => __('Section Title', 'nirup-island'),
        'section' => 'nirup_about_island',
        'type' => 'text',
    ));

    // Main Title
    $wp_customize->add_setting('nirup_about_main_title', array(
        'default' => __('Where Luxury Meets Nature', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_about_main_title', array(
        'label' => __('Main Title', 'nirup-island'),
        'section' => 'nirup_about_island',
        'type' => 'text',
    ));

    // Description
    $wp_customize->add_setting('nirup_about_description', array(
        'default' => __('Just 8 nautical miles from Singapore and Batam, Nirup Island offers a luxurious and convenient paradise. The island features The Westin Nirup Island Resort & Spa, ONE°15 Marina yacht facilities, beach club dining and wellness experiences amid pristine beaches. Sustainability and seamless arrival experiences ensure guests unwind fully.', 'nirup-island'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('nirup_about_description', array(
        'label' => __('Description', 'nirup-island'),
        'section' => 'nirup_about_island',
        'type' => 'textarea',
        'description' => __('Main description text for the about section', 'nirup-island'),
    ));

    // Feature 1
    $wp_customize->add_setting('nirup_feature_1_title', array(
        'default' => __('Private Yacht Charter', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_feature_1_title', array(
        'label' => __('Feature 1 - Title', 'nirup-island'),
        'section' => 'nirup_about_island',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_feature_1_desc', array(
        'default' => __('Book a private yacht from ONE°15 Marina for day‑trip or overnight stays.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_feature_1_desc', array(
        'label' => __('Feature 1 - Description', 'nirup-island'),
        'section' => 'nirup_about_island',
        'type' => 'textarea',
    ));

    // Feature 2
    $wp_customize->add_setting('nirup_feature_2_title', array(
        'default' => __('Heavenly Spa by Westin™', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_feature_2_title', array(
        'label' => __('Feature 2 - Title', 'nirup-island'),
        'section' => 'nirup_about_island',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_feature_2_desc', array(
        'default' => __('Rejuvenate with spa treatments surrounded by tranquil nature.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_feature_2_desc', array(
        'label' => __('Feature 2 - Description', 'nirup-island'),
        'section' => 'nirup_about_island',
        'type' => 'textarea',
    ));

    // Feature 3
    $wp_customize->add_setting('nirup_feature_3_title', array(
        'default' => __('Curated Island Dining', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_feature_3_title', array(
        'label' => __('Feature 3 - Title', 'nirup-island'),
        'section' => 'nirup_about_island',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_feature_3_desc', array(
        'default' => __('Enjoy elevated dining experiences at the beach club and fine restaurants.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_feature_3_desc', array(
        'label' => __('Feature 3 - Description', 'nirup-island'),
        'section' => 'nirup_about_island',
        'type' => 'textarea',
    ));

    // Feature 4
    $wp_customize->add_setting('nirup_feature_4_title', array(
        'default' => __('Kids Club & Family Fun', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_feature_4_title', array(
        'label' => __('Feature 4 - Title', 'nirup-island'),
        'section' => 'nirup_about_island',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_feature_4_desc', array(
        'default' => __('Dedicated programming and play spaces for children aged 4–12.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_feature_4_desc', array(
        'label' => __('Feature 4 - Description', 'nirup-island'),
        'section' => 'nirup_about_island',
        'type' => 'textarea',
    ));

    // Feature 5
    $wp_customize->add_setting('nirup_feature_5_title', array(
        'default' => __('Luxury Resort & Villas', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_feature_5_title', array(
        'label' => __('Feature 5 - Title', 'nirup-island'),
        'section' => 'nirup_about_island',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_feature_5_desc', array(
        'default' => __('Stay at The Westin Resort or Riahi Residences, steps from the sea.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_feature_5_desc', array(
        'label' => __('Feature 5 - Description', 'nirup-island'),
        'section' => 'nirup_about_island',
        'type' => 'textarea',
    ));

    // Feature 6
    $wp_customize->add_setting('nirup_feature_6_title', array(
        'default' => __('Eco‑Conscious Design', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_feature_6_title', array(
        'label' => __('Feature 6 - Title', 'nirup-island'),
        'section' => 'nirup_about_island',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_feature_6_desc', array(
        'default' => __('Built with sustainability in mind: solar, rainwater harvesting, local staff.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_feature_6_desc', array(
        'label' => __('Feature 6 - Description', 'nirup-island'),
        'section' => 'nirup_about_island',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'nirup_about_island_customizer');

/**
 * Add Accommodations Customizer Options
 */
function nirup_accommodations_customizer($wp_customize) {
    // Accommodations Section
    $wp_customize->add_section('nirup_accommodations', array(
        'title' => __('Accommodations Section', 'nirup-island'),
        'priority' => 33,
        'description' => __('Customize the accommodations comparison section', 'nirup-island'),
    ));

    // === RESORT SETTINGS ===
    
    // Resort Category
    $wp_customize->add_setting('nirup_resort_category', array(
        'default' => __('Resort Hotel', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_resort_category', array(
        'label' => __('Resort Category', 'nirup-island'),
        'section' => 'nirup_accommodations',
        'type' => 'text',
    ));

    // Resort Title
    $wp_customize->add_setting('nirup_resort_title', array(
        'default' => __('The Westin Nirup Island Resort & Spa', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_resort_title', array(
        'label' => __('Resort Title', 'nirup-island'),
        'section' => 'nirup_accommodations',
        'type' => 'text',
    ));

    // Resort Description
    $wp_customize->add_setting('nirup_resort_description', array(
        'default' => __('Luxurious rooms and overwater villas with private pools and sweeping sea views. Guests enjoy Heavenly Spa by Westin™, the WestinWORKOUT® Fitness Studio, and access to the Kids Club — all in a tranquil island setting.', 'nirup-island'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('nirup_resort_description', array(
        'label' => __('Resort Description', 'nirup-island'),
        'section' => 'nirup_accommodations',
        'type' => 'textarea',
    ));

    // Resort Image
    $wp_customize->add_setting('nirup_resort_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_resort_image', array(
        'label' => __('Resort Background Image', 'nirup-island'),
        'section' => 'nirup_accommodations',
        'mime_type' => 'image',
    )));

    // Resort CTA Button
    $wp_customize->add_setting('nirup_resort_cta_text', array(
        'default' => __('Explore Resort', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_resort_cta_text', array(
        'label' => __('Resort Button Text', 'nirup-island'),
        'section' => 'nirup_accommodations',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_resort_cta_link', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_resort_cta_link', array(
        'label' => __('Resort Button Link', 'nirup-island'),
        'section' => 'nirup_accommodations',
        'type' => 'url',
    ));

    // === VILLAS SETTINGS ===
    
    // Villas Category
    $wp_customize->add_setting('nirup_villas_category', array(
        'default' => __('Private Villas', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_villas_category', array(
        'label' => __('Villas Category', 'nirup-island'),
        'section' => 'nirup_accommodations',
        'type' => 'text',
    ));

    // Villas Title
    $wp_customize->add_setting('nirup_villas_title', array(
        'default' => __('Riahi Residences', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_villas_title', array(
        'label' => __('Villas Title', 'nirup-island'),
        'section' => 'nirup_accommodations',
        'type' => 'text',
    ));

    // Villas Description
    $wp_customize->add_setting('nirup_villas_description', array(
        'default' => __('1 to 4-Bedroom Private Villas. Spacious villas with full kitchens, private pools, and sea views. Designed for privacy and long stays, with access to Westin\'s facilities and optional in-villa dining.', 'nirup-island'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('nirup_villas_description', array(
        'label' => __('Villas Description', 'nirup-island'),
        'section' => 'nirup_accommodations',
        'type' => 'textarea',
    ));

    // Villas Image
    $wp_customize->add_setting('nirup_villas_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_villas_image', array(
        'label' => __('Villas Background Image', 'nirup-island'),
        'section' => 'nirup_accommodations',
        'mime_type' => 'image',
    )));

    // Villas CTA Button
    $wp_customize->add_setting('nirup_villas_cta_text', array(
        'default' => __('Explore Villas', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_villas_cta_text', array(
        'label' => __('Villas Button Text', 'nirup-island'),
        'section' => 'nirup_accommodations',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_villas_cta_link', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_villas_cta_link', array(
        'label' => __('Villas Button Link', 'nirup-island'),
        'section' => 'nirup_accommodations',
        'type' => 'url',
    ));
}
add_action('customize_register', 'nirup_accommodations_customizer');

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
 * Display Language Dropdown - FIXED TO MATCH JAVASCRIPT
 */
function nirup_language_dropdown() {
    // Check if TranslatePress is active
    if (function_exists('trp_custom_language_switcher')) {
        
        // Get TranslatePress instance and settings
        $trp = TRP_Translate_Press::get_trp_instance();
        if (!$trp) {
            nirup_language_fallback();
            return;
        }
        
        $trp_settings = $trp->get_component('settings');
        $settings = $trp_settings->get_settings();
        $trp_languages = $trp->get_component('languages');
        $trp_url_converter = $trp->get_component('url_converter');
        
        // Get all published languages
        $published_languages = $settings['publish-languages'];
        $all_languages = $trp_languages->get_language_names($published_languages);
        
        // Get current language
        $current_language = get_locale();
        if (isset($_GET['trp-edit-translation']) && $_GET['trp-edit-translation'] == 'preview') {
            $current_language = sanitize_text_field($_GET['trp-edit-translation']);
        }
        
        // Find current language in published languages
        $current_lang_code = '';
        foreach ($published_languages as $code) {
            if ($code === $current_language || $code === substr($current_language, 0, 2)) {
                $current_lang_code = $code;
                break;
            }
        }
        
        // If no current language found, use default
        if (empty($current_lang_code)) {
            $current_lang_code = $settings['default-language'];
        }
        
        // Map language codes to display names
        $lang_display_names = array(
            'en_US' => 'ENG',
            'es_ES' => 'ESP', 
            'fr_FR' => 'FRA',
            'de_DE' => 'GER',
            'it_IT' => 'ITA',
            'pt_PT' => 'POR',
            'nl_NL' => 'NLD',
            'ru_RU' => 'RUS',
            'zh_CN' => 'CHN',
            'ja' => 'JPN',
            'ko' => 'KOR',
            'en' => 'ENG',
            'es' => 'ESP',
            'fr' => 'FRA', 
            'de' => 'GER',
            'it' => 'ITA',
            'pt' => 'POR',
            'nl' => 'NLD',
            'ru' => 'RUS',
            'zh' => 'CHN',
        );
        
        // Get display name for current language
        $current_display = isset($lang_display_names[$current_lang_code]) ? 
                          $lang_display_names[$current_lang_code] : 
                          strtoupper(substr($current_lang_code, 0, 3));
        
        // FIXED HTML STRUCTURE TO MATCH JAVASCRIPT
        echo '<div class="language-switcher-container">';
        echo '<button class="language-current" type="button">';
        echo esc_html($current_display);
        echo '<svg class="lang-dropdown-arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6" fill="none">';
        echo '<path d="M9 1L5 5L1 1" stroke="black" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>';
        echo '</svg>';
        echo '</button>';
        
        echo '<ul class="language-dropdown-menu">';
        
        // Loop through all published languages
        foreach ($published_languages as $language_code) {
            if (isset($all_languages[$language_code])) {
                
                // Get display name
                $display_name = isset($lang_display_names[$language_code]) ? 
                               $lang_display_names[$language_code] : 
                               strtoupper(substr($language_code, 0, 3));
                
                // Get URL for this language
                $language_url = $trp_url_converter->get_url_for_language($language_code);
                
                // Check if this is the current language
                $is_current = ($language_code === $current_lang_code) ? ' current-language' : '';
                
                echo '<li class="language-option' . $is_current . '">';
                echo '<a href="' . esc_url($language_url) . '" data-lang="' . esc_attr($language_code) . '">';
                echo esc_html($display_name);
                echo '</a>';
                echo '</li>';
            }
        }
        
        echo '</ul>';
        echo '</div>';
        
    } else {
        // Fallback if TranslatePress is not active
        nirup_language_fallback();
    }
}
    
/**
 * Debug function to help troubleshoot language issues
 * Add ?debug_lang=1 to your URL to see language information
 */
function nirup_debug_language_info() {
    if (isset($_GET['debug_lang']) && $_GET['debug_lang'] == '1' && current_user_can('manage_options')) {
        if (function_exists('trp_custom_language_switcher')) {
            $trp = TRP_Translate_Press::get_trp_instance();
            if ($trp) {
                $trp_settings = $trp->get_component('settings');
                $settings = $trp_settings->get_settings();
                
                echo '<div style="position: fixed; top: 100px; right: 20px; background: white; padding: 20px; border: 2px solid red; z-index: 9999; font-size: 12px; max-width: 300px;">';
                echo '<h4>TranslatePress Debug Info:</h4>';
                echo '<strong>Current Locale:</strong> ' . get_locale() . '<br>';
                echo '<strong>Default Language:</strong> ' . $settings['default-language'] . '<br>';
                echo '<strong>Published Languages:</strong> ' . implode(', ', $settings['publish-languages']) . '<br>';
                echo '<strong>Current URL:</strong> ' . esc_url($_SERVER['REQUEST_URI']) . '<br>';
                echo '<button onclick="this.parentElement.style.display=\'none\'">Close</button>';
                echo '</div>';
            }
        } else {
            echo '<div style="position: fixed; top: 100px; right: 20px; background: white; padding: 20px; border: 2px solid red; z-index: 9999;">TranslatePress not active!</div>';
        }
    }
}
add_action('wp_footer', 'nirup_debug_language_info');

function nirup_language_fallback() {
    echo '<div class="language-switcher-container">';
    echo '<button class="language-current" type="button">ENG';
    echo '<svg class="lang-dropdown-arrow" width="8" height="4" viewBox="0 0 8 4" fill="none">';
    echo '<path d="M0 0L4 4L8 0" fill="currentColor"/>';
    echo '</svg>';
    echo '</button>';
    echo '<ul class="language-dropdown-menu">';
    echo '<li class="language-option current-language"><a href="#">ENG</a></li>';
    echo '</ul>';
    echo '</div>';
}

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

/**
 * Convert YouTube URL to embed format
 */
/**
 * Convert YouTube URL to embed format with autoplay and loop support
 */
function nirup_get_youtube_embed_url($url, $autoplay = false, $loop = false) {
    if (empty($url)) {
        return false;
    }

    // Extract video ID from various YouTube URL formats
    $video_id = '';
    
    // Standard watch URL: https://www.youtube.com/watch?v=VIDEO_ID
    if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
        $video_id = $matches[1];
    }
    // Short URL: https://youtu.be/VIDEO_ID
    elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
        $video_id = $matches[1];
    }
    // Embed URL: https://www.youtube.com/embed/VIDEO_ID
    elseif (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
        $video_id = $matches[1];
    }
    
    if (empty($video_id)) {
        return false;
    }
    
    // Build embed URL with privacy-enhanced mode
    $embed_url = 'https://www.youtube-nocookie.com/embed/' . $video_id;
    
    // Add parameters
    $params = array(
        'rel' => '0',           // Don't show related videos from other channels
        'modestbranding' => '1', // Minimal YouTube branding
        'iv_load_policy' => '3', // Don't show annotations
        'enablejsapi' => '1',    // Enable JavaScript API for tracking
    );
    
    // Add autoplay parameter if enabled (YouTube will mute automatically)
    if ($autoplay) {
        $params['autoplay'] = '1';
        $params['mute'] = '1'; // Required for autoplay to work
    }
    
    // Add loop parameter if enabled
    if ($loop) {
        $params['loop'] = '1';
        $params['playlist'] = $video_id; // Required for loop to work
    }
    
    $embed_url .= '?' . http_build_query($params);
    
    return $embed_url;
}

/**
 * Validate YouTube URL (for customizer)
 */
function nirup_sanitize_youtube_url($url) {
    if (empty($url)) {
        return '';
    }
    
    // Check if it's a valid YouTube URL
    if (nirup_get_youtube_embed_url($url)) {
        return esc_url_raw($url);
    }
    
    return '';
}

// Register Experiences Post Type
function nirup_register_experiences() {
    $args = array(
        'label'               => 'Experiences',
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 25,
        'menu_icon'           => 'dashicons-palmtree',
        'supports'            => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'has_archive'         => true,
        'hierarchical'        => true,
        'rewrite'             => array('slug' => 'experiences'),
        'capability_type'     => 'post',
        'publicly_queryable'  => true,
        'show_in_rest'        => true,
    );
    
    register_post_type('experience', $args);
}
add_action('init', 'nirup_register_experiences');

function nirup_get_breadcrumbs() {
    $breadcrumbs = array();
    
    $breadcrumbs[] = array(
        'title' => 'Home',
        'url' => home_url('/')
    );
    
    if (is_page_template('page-sustainability.php')) {
        $breadcrumbs[] = array(
            'title' => 'Sustainability',
            'url' => ''
        );
    }
    
    if (is_post_type_archive('experience')) {
        $breadcrumbs[] = array(
            'title' => 'Experiences',
            'url' => ''
        );
    } elseif (is_singular('experience')) {
        $experience_type = get_post_meta(get_the_ID(), '_experience_type', true);
        
        $breadcrumbs[] = array(
            'title' => 'Experiences',
            'url' => get_post_type_archive_link('experience')
        );
        
        $parent_id = wp_get_post_parent_id(get_the_ID());
        if ($parent_id) {
            $breadcrumbs[] = array(
                'title' => get_the_title($parent_id),
                'url' => get_permalink($parent_id)
            );
        }
        
        $breadcrumbs[] = array(
            'title' => get_the_title(),
            'url' => ''
        );
    }

    if (is_post_type_archive('event_offer')) {
        $breadcrumbs[] = array(
            'title' => 'Events & Offers',
            'url' => ''
        );
    } elseif (is_singular('event_offer')) {
        $breadcrumbs[] = array(
            'title' => 'Events & Offers',
            'url' => get_post_type_archive_link('event_offer')
        );
        
        $breadcrumbs[] = array(
            'title' => get_the_title(),
            'url' => ''
        );
    }

    if (is_post_type_archive('restaurant')) {
        $breadcrumbs[] = array(
            'title' => 'Dining',
            'url' => ''
        );
    } elseif (is_singular('restaurant')) {
        $breadcrumbs[] = array(
            'title' => 'Dining',
            'url' => get_post_type_archive_link('restaurant')
        );
        
        $breadcrumbs[] = array(
            'title' => get_the_title(),
            'url' => ''
        );
    }

    if (is_page_template('page-terms-conditions.php') || is_page('terms-conditions')) {
    $breadcrumbs[] = array(
        'title' => 'Terms & Conditions',
        'url' => ''
    );
    } elseif (is_page_template('page-privacy-policy.php') || is_page('privacy-policy')) {
        $breadcrumbs[] = array(
            'title' => 'Privacy Policy', 
            'url' => ''
        );
    } elseif (is_page_template('page-cookies-policy.php') || is_page('cookies-policy')) {
        $breadcrumbs[] = array(
            'title' => 'Cookies Policy',
            'url' => ''
        );
    }

    if (is_page_template('page-contact.php')) {
        $breadcrumbs[] = array(
            'title' => 'Contact',
            'url' => ''
        );
    }

    if (is_page_template('page-marina.php')) {
        $breadcrumbs[] = array(
            'title' => 'Marina',
            'url' => ''
        );
    }

    if (is_page_template('page-villa-selling.php')) {
        $breadcrumbs[] = array(
            'title' => 'Own Your Private Island Retreat',
            'url' => ''
        );
    }

    if (is_page_template('page-getting-here.php') || is_page('getting-here')) {
        $breadcrumbs[] = array(
            'title' => 'Getting Here',
            'url' => ''
        );
    }

        // Visa-On-Arrival Countries Page
    if (is_page_template('page-visa-on-arrival-countries.php')) {
        // Add Getting Here as parent
        $breadcrumbs[] = array(
            'title' => 'Getting Here',
            'url' => get_permalink(get_page_by_path('getting-here'))
        );
        
        $breadcrumbs[] = array(
            'title' => 'Visa-On-Arrival Countries',
            'url' => ''
        );
    }

    if (is_page_template('page-private-events.php')) {
        $breadcrumbs[] = array(
            'title' => 'Private Events',
            'url' => ''
        );
    }

    if (is_page_template('media-coverage.php')) {
        $breadcrumbs[] = array(
            'title' => 'Media Coverage',
            'url' => ''
        );
    }

    if (is_page_template('page-press-kit.php')) {
        $breadcrumbs[] = array(
            'title' => 'Media Kit',
            'url' => ''
        );
    }

    if (is_page_template('page-visa-free-countries.php')) {
        // Add Getting Here as parent
        $breadcrumbs[] = array(
            'title' => 'Getting Here',
            'url' => get_permalink(get_page_by_path('getting-here'))
        );
        
        $breadcrumbs[] = array(
            'title' => 'Visa Free Countries',
            'url' => ''
        );
    }

    if (is_page_template('page-accommodations.php') || is_page('page-accommodations')) {
        $breadcrumbs[] = array(
            'title' => 'Accommodations',
            'url' => ''
        );
    }

    // Riahi Residences Page
    if (is_page_template('page-riahi-residences.php')) {
        // Add Accommodations as parent
        $accommodations_page = get_page_by_path('accommodations');
        if ($accommodations_page) {
            $breadcrumbs[] = array(
                'title' => 'Accommodations',
                'url' => get_permalink($accommodations_page)
            );
        }
        
        $breadcrumbs[] = array(
            'title' => 'Riahi Residences',
            'url' => ''
        );
    }

    if (is_singular('villa')) {
    // Get the villa category to determine parent page
    $villa_category = get_post_meta(get_the_ID(), '_villa_category', true);
    
    // Add Accommodations
    $breadcrumbs[] = array(
        'title' => 'Accommodations',
        'url' => home_url('/accommodations') // Update this URL as needed
    );
    
    // Add Riahi Residences if this villa belongs to that category
    if (stripos($villa_category, 'riahi') !== false) {
        $breadcrumbs[] = array(
            'title' => 'Riahi Residences',
            'url' => home_url('/riahi-residences') // Update this URL as needed
        );
    }
    
    // Add current villa
    $breadcrumbs[] = array(
        'title' => get_the_title(),
        'url' => ''
    );
}


    
    return $breadcrumbs;
}

/**
 * Add Experiences Archive Customizer Options
 */
function nirup_experiences_archive_customizer($wp_customize) {
    // Experiences Archive Section
    $wp_customize->add_section('nirup_experiences_archive', array(
        'title' => __('Experiences Archive Page', 'nirup-island'),
        'priority' => 41,
        'description' => __('Customize the experiences archive page content', 'nirup-island'),
    ));

    // Archive Title
    $wp_customize->add_setting('nirup_experiences_archive_title', array(
        'default' => __('Island Experiences', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_experiences_archive_title', array(
        'label' => __('Archive Page Title', 'nirup-island'),
        'section' => 'nirup_experiences_archive',
        'type' => 'text',
    ));

    // Archive Subtitle
    $wp_customize->add_setting('nirup_experiences_archive_subtitle', array(
        'default' => __('Discover curated experiences that make every moment unforgettable — from family fun to wellness escapes', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_experiences_archive_subtitle', array(
        'label' => __('Archive Page Subtitle', 'nirup-island'),
        'section' => 'nirup_experiences_archive',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'nirup_experiences_archive_customizer');

/**
 * Use custom template for category-type experiences
 */
function nirup_experience_template($template) {
    if (is_singular('experience')) {
        global $post;
        $experience_type = get_post_meta($post->ID, '_experience_type', true);
        
        if ($experience_type === 'category') {
            // Use the existing category template
            $category_template = locate_template('single-experience-category.php');
            if ($category_template) {
                return $category_template;
            }
        } elseif ($experience_type === 'single') {
            // Use the new single experience template
            $single_template = locate_template('single-experience.php');
            if ($single_template) {
                return $single_template;
            }
        }
    }
    return $template;
}
add_filter('single_template', 'nirup_experience_template');

/**
 * Map Section Customizer Options
 */
function nirup_map_section_customizer($wp_customize) {
    
    // Add Map Section Panel
    $wp_customize->add_section('nirup_map_section', array(
        'title'    => __('Map Section', 'nirup-island'),
        'priority' => 35,
        'description' => __('Customize the island map section settings', 'nirup-island'),
    ));

    // Map Section Display Toggle
    $wp_customize->add_setting('nirup_map_display', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('nirup_map_display', array(
        'label'    => __('Display Map Section', 'nirup-island'),
        'section'  => 'nirup_map_section',
        'type'     => 'checkbox',
        'priority' => 5,
    ));

    // Map Section Title
    $wp_customize->add_setting('nirup_map_title', array(
        'default'           => __('Explore Our Island', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_map_title', array(
        'label'    => __('Map Section Title', 'nirup-island'),
        'section'  => 'nirup_map_section',
        'type'     => 'text',
        'priority' => 10,
    ));

    // Map Section Subtitle
    $wp_customize->add_setting('nirup_map_subtitle', array(
        'default'           => __('Discover amazing locations and experiences across Nirup Island', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('nirup_map_subtitle', array(
        'label'    => __('Map Section Subtitle', 'nirup-island'),
        'section'  => 'nirup_map_section',
        'type'     => 'textarea',
        'priority' => 20,
    ));

    // Map Image
    $wp_customize->add_setting('nirup_map_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_map_image', array(
        'label'     => __('Map Image', 'nirup-island'),
        'section'   => 'nirup_map_section',
        'mime_type' => 'image',
        'priority'  => 30,
        'description' => __('Upload the main map image for your island. Recommended size: 1200x600px or larger.', 'nirup-island'),
    )));
}
add_action('customize_register', 'nirup_map_section_customizer');

function nirup_add_map_pins_menu() {
    // Main menu item
    add_menu_page(
        __('Map Pins', 'nirup-island'),           // Page title
        __('Map Pins', 'nirup-island'),           // Menu title
        'manage_options',                          // Capability
        'nirup-map-pins',                          // Menu slug
        'nirup_map_pins_admin_page',              // Callback function
        'dashicons-location-alt',                  // Icon
        27                                         // Position (after Villas at 26)
    );
    
    // Submenu: Manage Pins (same as main page)
    add_submenu_page(
        'nirup-map-pins',                          // Parent slug
        __('Manage Pins', 'nirup-island'),        // Page title
        __('Manage Pins', 'nirup-island'),        // Menu title
        'manage_options',                          // Capability
        'nirup-map-pins',                          // Menu slug (same as parent)
        'nirup_map_pins_admin_page'               // Callback
    );
    
    // Submenu: Icon Library
    add_submenu_page(
        'nirup-map-pins',                          // Parent slug
        __('Icon Library', 'nirup-island'),       // Page title
        __('Icon Library', 'nirup-island'),       // Menu title
        'manage_options',                          // Capability
        'nirup-map-icons',                         // Menu slug
        'nirup_map_icons_admin_page'              // Callback function
    );
}
add_action('admin_menu', 'nirup_add_map_pins_menu');

function nirup_map_icons_admin_page() {
    // Handle icon upload
    if (isset($_FILES['custom_icon']) && check_admin_referer('nirup_icon_upload', 'icon_upload_nonce')) {
        $uploaded = nirup_handle_custom_icon_upload();
        if ($uploaded) {
            add_settings_error('nirup_icons', 'icon_uploaded', __('Icon uploaded successfully!', 'nirup-island'), 'updated');
        }
    }
    
    // Handle icon deletion
    if (isset($_POST['delete_icon']) && check_admin_referer('nirup_delete_icon', 'icon_delete_nonce')) {
        $filename = sanitize_file_name($_POST['icon_filename']);
        if (nirup_delete_custom_icon($filename)) {
            add_settings_error('nirup_icons', 'icon_deleted', __('Icon deleted successfully!', 'nirup-island'), 'updated');
        }
    }
    
    $custom_icons = nirup_get_custom_icons();
    ?>
    <div class="wrap">
        <h1><?php _e('Icon Library', 'nirup-island'); ?></h1>
        
        <?php settings_errors('nirup_icons'); ?>
        
        <!-- Upload Form -->
        <div class="card" style="max-width: 600px;">
            <h2><?php _e('Upload New Icon', 'nirup-island'); ?></h2>
            <form method="post" enctype="multipart/form-data">
                <?php wp_nonce_field('nirup_icon_upload', 'icon_upload_nonce'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('SVG Icon File', 'nirup-island'); ?></th>
                        <td>
                            <input type="file" name="custom_icon" accept=".svg" required>
                            <p class="description"><?php _e('Upload an SVG file. Max 100KB. Icon will be automatically standardized to 28x28px.', 'nirup-island'); ?></p>
                        </td>
                    </tr>
                </table>
                <p class="submit">
                    <button type="submit" class="button button-primary">
                        <?php _e('Upload Icon', 'nirup-island'); ?>
                    </button>
                </p>
            </form>
        </div>
        
        <!-- Icon Library -->
        <div class="card">
            <h2><?php _e('Your Icon Library', 'nirup-island'); ?></h2>
            
            <?php if (empty($custom_icons)): ?>
                <p><?php _e('No custom icons uploaded yet. Upload your first icon above!', 'nirup-island'); ?></p>
            <?php else: ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px; padding: 20px 0;">
                    <?php foreach ($custom_icons as $icon): ?>
                        <div style="border: 1px solid #ddd; padding: 15px; text-align: center; border-radius: 4px;">
                            <div style="width: 60px; height: 60px; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; background: #f5f5f5; border-radius: 4px;">
                                <?php echo $icon['svg']; ?>
                            </div>
                            <div style="font-size: 12px; margin-bottom: 10px;">
                                <strong><?php echo esc_html($icon['name']); ?></strong><br>
                                <span style="color: #666;"><?php echo esc_html($icon['size']); ?></span>
                            </div>
                            <form method="post" style="margin: 0;" onsubmit="return confirm('<?php _e('Are you sure you want to delete this icon?', 'nirup-island'); ?>');">
                                <?php wp_nonce_field('nirup_delete_icon', 'icon_delete_nonce'); ?>
                                <input type="hidden" name="delete_icon" value="1">
                                <input type="hidden" name="icon_filename" value="<?php echo esc_attr($icon['filename']); ?>">
                                <button type="submit" class="button button-small" style="color: #b32d2e;">
                                    <?php _e('Delete', 'nirup-island'); ?>
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

function nirup_map_pins_admin_page() {
    wp_enqueue_media();

    // Handle form submissions
    if (isset($_POST['action']) && wp_verify_nonce($_POST['nirup_pins_nonce'], 'nirup_pins_action')) {
        if ($_POST['action'] === 'add_pin') {
            nirup_add_map_pin($_POST);
        } elseif ($_POST['action'] === 'update_pin') {
            nirup_update_map_pin($_POST);
        } elseif ($_POST['action'] === 'delete_pin') {
            nirup_delete_map_pin($_POST['pin_id']);
        }
    }
    
    $pins = nirup_get_map_pins();
    $map_image_url = nirup_get_map_image_url();
    ?>
    
    <div class="wrap nirup-map-admin">
        <h1><?php _e('Map Pin Management', 'nirup-island'); ?></h1>
        
        <?php if (!$map_image_url): ?>
            <div class="notice notice-warning">
                <p>
                    <?php _e('Please upload a map image first:', 'nirup-island'); ?>
                    <a href="<?php echo admin_url('customize.php?autofocus[section]=nirup_map_section'); ?>" class="button button-small">
                        <?php _e('Upload Map Image', 'nirup-island'); ?>
                    </a>
                </p>
            </div>
        <?php else: ?>

            <!-- Instructions -->
            <div class="card" style="max-width: 1430px; margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2><?php _e('How to Add Pins', 'nirup-island'); ?></h2>
                        <ol style="margin-bottom: 0;">
                            <li><strong><?php _e('Click anywhere on the map below', 'nirup-island'); ?></strong> <?php _e('to add a new pin at that exact location', 'nirup-island'); ?></li>
                            <li><strong><?php _e('Drag existing pins', 'nirup-island'); ?></strong> <?php _e('to reposition them precisely', 'nirup-island'); ?></li>
                            <li><strong><?php _e('Click on a pin', 'nirup-island'); ?></strong> <?php _e('to edit its details', 'nirup-island'); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
            
            <!-- Interactive Map -->
            <div class="card">
                <h2><?php _e('Interactive Map - Click to Add Pins', 'nirup-island'); ?></h2>
                <div class="map-editor-container">
                    <img src="<?php echo esc_url($map_image_url); ?>" alt="Map" class="map-editor-image" id="map-editor">


                    <div class="map-pins-overlay" id="map-pins-overlay">
                        <?php foreach ($pins as $pin): 
                            $icon_key = isset($pin['icon']) ? $pin['icon'] : '';
                            ?>
                            <div class="admin-pin admin-pin-<?php echo esc_attr($pin['pin_type']); ?>"
                                 data-pin-id="<?php echo esc_attr($pin['id']); ?>"
                                 data-pin-type="<?php echo esc_attr($pin['pin_type']); ?>"
                                 data-title="<?php echo esc_attr($pin['title']); ?>"
                                 data-description="<?php echo esc_attr($pin['description']); ?>"
                                 data-link="<?php echo esc_attr($pin['link']); ?>"
                                 data-icon="<?php echo esc_attr($icon_key); ?>"
                                 data-image-1="<?php echo esc_attr($pin['image_1'] ?? '0'); ?>"
                                 data-image-2="<?php echo esc_attr($pin['image_2'] ?? '0'); ?>"
                                 data-hours="<?php echo esc_attr($pin['hours'] ?? ''); ?>"
                                 style="left: <?php echo esc_attr($pin['x']); ?>%; top: <?php echo esc_attr($pin['y']); ?>%;">
                                <div class="pin-icon">
                                    <?php echo nirup_get_pin_icon_svg($pin['pin_type'], $icon_key); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Pin Type Selector -->
                <div class="pin-controls">
                    <label><?php _e('Pin Type for New Pins:', 'nirup-island'); ?></label>
                    <label class="pin-type-option">
                        <input type="radio" name="new_pin_type" value="public" checked>
                        <span class="pin-preview pin-preview-public"></span>
                        <?php _e('Public Areas', 'nirup-island'); ?>
                    </label>
                    <label class="pin-type-option">
                        <input type="radio" name="new_pin_type" value="accommodation">
                        <span class="pin-preview pin-preview-accommodation"></span>
                        <?php _e('Accommodations', 'nirup-island'); ?>
                    </label>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Pin List -->
        <div class="card">
            <h2><?php _e('Pin List', 'nirup-island'); ?></h2>
            
            <?php if (empty($pins)): ?>
                <p><?php _e('No pins created yet. Click on the map above to add your first pin!', 'nirup-island'); ?></p>
            <?php else: ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th style="width: 50px;"><?php _e('Type', 'nirup-island'); ?></th>
                            <th><?php _e('Title', 'nirup-island'); ?></th>
                            <th><?php _e('Description', 'nirup-island'); ?></th>
                            <th style="width: 100px;"><?php _e('Actions', 'nirup-island'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pins as $pin): ?>
                            <tr data-pin-id="<?php echo esc_attr($pin['id']); ?>">
                                <td>
                                    <div class="pin-type-indicator pin-type-<?php echo esc_attr($pin['pin_type']); ?>"></div>
                                </td>
                                <td>
                                    <strong><?php echo esc_html($pin['title']); ?></strong>
                                    <?php if (!empty($pin['icon'])): ?>
                                        <span class="has-icon-indicator">📌</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo esc_html($pin['description']); ?>
                                    <?php if (!empty($pin['link'])): ?>
                                        <br><a href="<?php echo esc_url($pin['link']); ?>" target="_blank">
                                            <?php echo esc_url($pin['link']); ?> <span class="dashicons dashicons-external"></span>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button type="button" class="button button-small edit-pin-btn" data-pin-id="<?php echo esc_attr($pin['id']); ?>">
                                        <?php _e('Edit', 'nirup-island'); ?>
                                    </button>
                                    <button type="button" class="button button-small delete-pin-btn" data-pin-id="<?php echo esc_attr($pin['id']); ?>">
                                        <?php _e('Delete', 'nirup-island'); ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- Pin Modal -->
        <div id="pin-modal" class="pin-modal" style="display: none;">
            <div class="pin-modal-overlay"></div>
            <div class="pin-modal-content">
                <div class="pin-modal-header">
                    <h2><?php _e('Add New Pin', 'nirup-island'); ?></h2>
                    <button type="button" class="pin-modal-close">&times;</button>
                </div>
                <div class="pin-modal-body">
                    <div class="pin-modal-form">
                        <div class="form-field">
                            <label for="modal-pin-title"><?php _e('Title', 'nirup-island'); ?> <span class="required">*</span></label>
                            <input type="text" id="modal-pin-title" class="widefat" required>
                        </div>

                        <div class="form-field">
                            <label for="modal-pin-description"><?php _e('Description', 'nirup-island'); ?></label>
                            <textarea id="modal-pin-description" rows="3" class="widefat"></textarea>
                        </div>

                        <!-- Image 1 -->
                        <div class="form-field">
                            <label for="modal-pin-image-1"><?php _e('Image 1', 'nirup-island'); ?></label>
                            <div class="image-upload-wrapper">
                                <input type="hidden" id="modal-pin-image-1" value="">
                                <button type="button" class="button upload-image-btn" data-target="modal-pin-image-1">
                                    <?php _e('Select Image', 'nirup-island'); ?>
                                </button>
                                <button type="button" class="button remove-image-btn" data-target="modal-pin-image-1" style="display:none;">
                                    <?php _e('Remove', 'nirup-island'); ?>
                                </button>
                                <div class="image-preview" data-for="modal-pin-image-1" style="display:none; margin-top:10px;">
                                    <img src="" alt="" style="max-width: 150px; height: 100px; object-fit: cover; border-radius: 4px;">
                                </div>
                            </div>
                            <p class="description"><?php _e('First image to display in tooltip', 'nirup-island'); ?></p>
                        </div>

                        <!-- Image 2 -->
                        <div class="form-field">
                            <label for="modal-pin-image-2"><?php _e('Image 2', 'nirup-island'); ?></label>
                            <div class="image-upload-wrapper">
                                <input type="hidden" id="modal-pin-image-2" value="">
                                <button type="button" class="button upload-image-btn" data-target="modal-pin-image-2">
                                    <?php _e('Select Image', 'nirup-island'); ?>
                                </button>
                                <button type="button" class="button remove-image-btn" data-target="modal-pin-image-2" style="display:none;">
                                    <?php _e('Remove', 'nirup-island'); ?>
                                </button>
                                <div class="image-preview" data-for="modal-pin-image-2" style="display:none; margin-top:10px;">
                                    <img src="" alt="" style="max-width: 150px; height: 100px; object-fit: cover; border-radius: 4px;">
                                </div>
                            </div>
                            <p class="description"><?php _e('Second image to display in tooltip', 'nirup-island'); ?></p>
                        </div>

                        <!-- Hours Field -->
                        <div class="form-field">
                            <label for="modal-pin-hours"><?php _e('Hours', 'nirup-island'); ?></label>
                            <input type="text" id="modal-pin-hours" class="widefat" placeholder="10:00 AM – 12:00 AM">
                            <p class="description"><?php _e('Operating hours (optional), e.g., "10:00 AM – 12:00 AM"', 'nirup-island'); ?></p>
                        </div>

                        <div class="form-field">
                            <label for="modal-pin-link"><?php _e('Link (Optional)', 'nirup-island'); ?></label>
                            <input type="url" id="modal-pin-link" class="widefat" placeholder="https://">
                        </div>

                        <div class="form-field">
                            <label><?php _e('Select Icon (Optional)', 'nirup-island'); ?></label>
                            <div class="modal-icon-selection">
                                <?php
                                $custom_icons = nirup_get_custom_icons();
                                if (!empty($custom_icons)): ?>
                                    <div class="modal-icon-grid">
                                        <div class="modal-icon-option active" data-icon="">
                                            <div class="icon-box">
                                                <span style="font-size: 10px; color: black;"><?php _e('None', 'nirup-island'); ?></span>
                                            </div>
                                        </div>
                                        <?php foreach ($custom_icons as $filename => $icon): ?>
                                            <div class="modal-icon-option" data-icon="custom:<?php echo esc_attr($filename); ?>">
                                                <div class="icon-box">
                                                    <?php echo $icon['svg']; ?>
                                                </div>
                                                <span class="icon-label"><?php echo esc_html($icon['name']); ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p style="color: #666; font-style: italic;">
                                        <?php _e('No icons available.', 'nirup-island'); ?>
                                        <a href="<?php echo admin_url('themes.php?page=nirup-icon-library'); ?>" target="_blank">
                                            <?php _e('Upload icons', 'nirup-island'); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-field">
                            <label><?php _e('Preview', 'nirup-island'); ?></label>
                            <div id="modal-pin-preview" class="modal-pin-preview">
                                <!-- Pin preview will be rendered here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pin-modal-footer">
                    <button type="button" class="button" id="modal-cancel-btn"><?php _e('Cancel', 'nirup-island'); ?></button>
                    <button type="button" class="button button-primary" id="modal-save-pin-btn"><?php _e('Add Pin', 'nirup-island'); ?></button>
                </div>
            </div>
        </div>
        <div id="edit-pin-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 999999; align-items: center; justify-content: center;">
            <div style="background: white; padding: 30px; border-radius: 8px; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; position: relative;">
                <button type="button" onclick="jQuery('#edit-pin-modal').fadeOut(200)" style="position: absolute; top: 15px; right: 15px; background: none; border: none; font-size: 24px; cursor: pointer; color: #666; line-height: 1;">&times;</button>
                
                <h2 style="margin-top: 0;"><?php _e('Edit Pin', 'nirup-island'); ?></h2>
                
                <form method="post" id="edit-pin-form">
                    <?php wp_nonce_field('nirup_pins_action', 'nirup_pins_nonce'); ?>
                    <input type="hidden" name="action" value="update_pin">
                    <input type="hidden" name="pin_id" id="edit-pin-id">
                    
                    <table class="form-table">
                        <tr>
                            <th><label for="edit-pin-title"><?php _e('Pin Title', 'nirup-island'); ?> *</label></th>
                            <td><input type="text" name="title" id="edit-pin-title" class="regular-text" required></td>
                        </tr>
                        <tr>
                            <th><label for="edit-pin-description"><?php _e('Description', 'nirup-island'); ?></label></th>
                            <td><textarea name="description" id="edit-pin-description" rows="4" class="large-text"></textarea></td>
                        </tr>
                        <tr>
                            <th><label for="edit-pin-link"><?php _e('Link URL', 'nirup-island'); ?></label></th>
                            <td><input type="url" name="link" id="edit-pin-link" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><label><?php _e('Pin Type', 'nirup-island'); ?></label></th>
                            <td>
                                <label style="margin-right: 20px;">
                                    <input type="radio" name="pin_type" value="public"> <?php _e('Public Areas (Blue)', 'nirup-island'); ?>
                                </label>
                                <label>
                                    <input type="radio" name="pin_type" value="accommodation"> <?php _e('Accommodations (Gold)', 'nirup-island'); ?>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="edit-pin-icon"><?php _e('Custom Icon', 'nirup-island'); ?></label></th>
                            <td>
                                <select name="icon" id="edit-pin-icon" class="regular-text">
                                    <option value=""><?php _e('No custom icon', 'nirup-island'); ?></option>
                                    <?php
                                    $custom_icons = nirup_get_custom_icons();
                                    foreach ($custom_icons as $icon):
                                    ?>
                                        <option value="custom:<?php echo esc_attr($icon['filename']); ?>"><?php echo esc_html($icon['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="edit-pin-image-1"><?php _e('Image 1', 'nirup-island'); ?></label></th>
                            <td>
                                <input type="hidden" name="image_1" id="edit-pin-image-1">
                                <button type="button" class="button upload-image-button" data-target="edit-pin-image-1"><?php _e('Select Image', 'nirup-island'); ?></button>
                                <button type="button" class="button remove-image-button" data-target="edit-pin-image-1" style="display: none;"><?php _e('Remove', 'nirup-island'); ?></button>
                                <div class="image-preview" data-target="edit-pin-image-1" style="margin-top: 10px;"></div>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="edit-pin-image-2"><?php _e('Image 2', 'nirup-island'); ?></label></th>
                            <td>
                                <input type="hidden" name="image_2" id="edit-pin-image-2">
                                <button type="button" class="button upload-image-button" data-target="edit-pin-image-2"><?php _e('Select Image', 'nirup-island'); ?></button>
                                <button type="button" class="button remove-image-button" data-target="edit-pin-image-2" style="display: none;"><?php _e('Remove', 'nirup-island'); ?></button>
                                <div class="image-preview" data-target="edit-pin-image-2" style="margin-top: 10px;"></div>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="edit-pin-hours"><?php _e('Hours', 'nirup-island'); ?></label></th>
                            <td><input type="text" name="hours" id="edit-pin-hours" class="regular-text" placeholder="e.g., 9:00 AM - 5:00 PM"></td>
                        </tr>
                    </table>
                    
                    <p class="submit">
                        <button type="submit" class="button button-primary button-large"><?php _e('Update Pin', 'nirup-island'); ?></button>
                        <button type="button" class="button button-large" onclick="jQuery('#edit-pin-modal').fadeOut(200)" style="margin-left: 10px;"><?php _e('Cancel', 'nirup-island'); ?></button>
                    </p>
                </form>
            </div>
        </div>

    </div>
    <script>
        jQuery(document).ready(function($) {
            // Image upload in edit modal
            $('#edit-pin-modal').on('click', '.upload-image-button', function(e) {
                e.preventDefault();
                var targetId = $(this).data('target');
                var frame = wp.media({ title: 'Select Image', button: { text: 'Use this image' }, multiple: false });
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#' + targetId).val(attachment.id);
                    $('.image-preview[data-target="' + targetId + '"]').html('<img src="' + attachment.url + '" style="max-width: 200px;">');
                    $('.remove-image-button[data-target="' + targetId + '"]').show();
                });
                frame.open();
            });
            
            // Image removal in edit modal
            $('#edit-pin-modal').on('click', '.remove-image-button', function(e) {
                e.preventDefault();
                var targetId = $(this).data('target');
                $('#' + targetId).val('');
                $('.image-preview[data-target="' + targetId + '"]').empty();
                $(this).hide();
            });
        });
    </script>

    <style>
        .nirup-map-admin .card {
            max-width: 1430px;
            margin-bottom: 20px;
        }
        
        .map-editor-container {
            position: relative;
            display: inline-block;
            border: 2px solid #ddd;
            overflow: hidden;
            cursor: crosshair;
            background: #f9f9f9;
        }
        
        .map-editor-image {
            display: block;
            max-width: 100%;
            width: 1430px; /* Bigger map size */
            height: auto;
        }
        
        .map-pins-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        
        .admin-pin {
            position: absolute;
            transform: translate(-50%, -100%);
            cursor: move;
            pointer-events: all;
            z-index: 10;
        }
        
        .admin-pin:hover {
            z-index: 20;
        }
        
        .admin-pin .pin-icon {
            width: 47px;
            height: 56px;
        }
        
        .pin-controls {
            margin-top: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
        }
        
        .pin-type-option {
            display: inline-flex;
            align-items: center;
            margin-right: 20px;
            cursor: pointer;
            font-weight: 500;
        }
        
        .pin-type-option input[type="radio"] {
            margin-right: 8px;
        }
        
        .pin-preview {
            width: 16px;
            height: 16px;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            border: 2px solid #fff;
            margin: 0 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        
        .pin-preview-public {
            background: #1E3673;
        }
        
        .pin-preview-accommodation {
            background: #C49A5D;
        }
        
        .pin-type-indicator {
            width: 20px;
            height: 20px;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            border: 2px solid #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        
        .pin-type-indicator.pin-type-public {
            background: #1E3673;
        }
        
        .pin-type-indicator.pin-type-accommodation {
            background: #C49A5D;
        }
        
        .has-icon-indicator {
            color: #0073aa;
            font-size: 12px;
            margin-left: 5px;
        }
        
        /* Icon Library Picker Styles */
        .icon-picker-library {
            max-width: 600px;
        }

        .icon-selection-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 10px;
            margin-bottom: 15px;
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 6px;
            background: #fafafa;
        }

        .icon-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            border: 2px solid transparent;
            border-radius: 6px;
            cursor: pointer;
            background: white;
            transition: all 0.2s ease;
        }

        .icon-option:hover {
            border-color: #0073aa;
            background: #f0f8ff;
        }

        .icon-option.active {
            border-color: #0073aa;
            background: #e3f2fd;
            box-shadow: 0 2px 4px rgba(0,115,170,0.2);
        }

        .icon-preview-box {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 5px;
            border-radius: 4px;
            background: #f9f9f9;
        }

        .icon-preview-box svg {
            max-width: 30px;
            max-height: 30px;
        }

        .no-icon-option .icon-preview-box {
            background: #e0e0e0;
        }

        .no-icon-text {
            font-size: 10px;
            color: #666;
            text-align: center;
            font-weight: 500;
        }

        .icon-name {
            font-size: 11px;
            text-align: center;
            font-weight: 500;
            color: black;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .selected-icon-preview {
            padding: 15px;
            background: #f9f9f9;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .pin-with-icon-preview {
            display: inline-block;
            margin-left: 10px;
        }

        .pin-with-icon-preview svg {
            width: 47px;
            height: 56px;
        }

        .no-icons-message {
            text-align: center;
            padding: 30px;
            background: #f9f9f9;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .no-icons-message p {
            margin: 0 0 15px 0;
            color: #666;
        }

        /* Crosshair cursor */
        #map-crosshair {
            position: absolute;
            pointer-events: none;
            z-index: 9999;
            display: none;
        }

        .crosshair-h,
        .crosshair-v {
            position: absolute;
            background: rgba(0, 115, 170, 0.6);
        }

        .crosshair-h {
            width: 40px;
            height: 2px;
            left: -20px;
            top: -1px;
        }

        .crosshair-v {
            width: 2px;
            height: 40px;
            left: -1px;
            top: -20px;
        }

        /* Coordinate display */
        #coordinate-display {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-family: monospace;
            font-weight: 500;
            z-index: 9998;
            pointer-events: none;
            display: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        /* Click feedback animation */
        .click-feedback {
            position: absolute;
            width: 20px;
            height: 20px;
            border: 3px solid #0073aa;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 9997;
            opacity: 1;
        }

        .click-feedback.animate {
            animation: clickPulse 0.6s ease-out forwards;
        }

        @keyframes clickPulse {
            0% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 1;
            }
            100% {
                transform: translate(-50%, -50%) scale(3);
                opacity: 0;
            }
        }

        /* Pin dragging state */
        .admin-pin.dragging {
            opacity: 0.8;
            transform: translate(-50%, -100%) scale(1.1);
            z-index: 100 !important;
            filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.4));
        }

        /* Improved map editor cursor */
        .map-editor-container {
            cursor: crosshair !important;
        }

        .map-editor-container:hover {
            border-color: #0073aa;
        }

        /* Better pin hover state */
        .admin-pin {
            transition: all 0.2s ease;
        }

        .admin-pin:hover {
            transform: translate(-50%, -100%) scale(1.15);
            filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.35));
        }

        /* Grid overlay */
        .map-grid-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 5;
            background-image:
                repeating-linear-gradient(0deg, rgba(0, 115, 170, 0.1) 0px, rgba(0, 115, 170, 0.1) 1px, transparent 1px, transparent 10%),
                repeating-linear-gradient(90deg, rgba(0, 115, 170, 0.1) 0px, rgba(0, 115, 170, 0.1) 1px, transparent 1px, transparent 10%);
        }

        /* Improved card styling */
        .nirup-map-admin .card {
            border-left: 4px solid #0073aa;
        }

        .nirup-map-admin .card h2 {
            color: #23282d;
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 15px 0;
        }

        /* Instructions styling */
        .nirup-map-admin ol {
            padding-left: 20px;
        }

        .nirup-map-admin ol li {
            margin-bottom: 8px;
            line-height: 1.6;
        }

        /* Pin controls styling */
        .pin-controls {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 1px solid #dee2e6;
        }

        .pin-controls label {
            font-size: 14px;
            color: #495057;
        }

        /* Modal Styles */
        .pin-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 100000;
        }

        .pin-modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(2px);
        }

        .pin-modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .pin-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid #ddd;
        }

        .pin-modal-header h2 {
            margin: 0;
            font-size: 20px;
            color: #23282d;
        }

        .pin-modal-close {
            background: none;
            border: none;
            font-size: 32px;
            line-height: 1;
            color: #666;
            cursor: pointer;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .pin-modal-close:hover {
            background: #f0f0f0;
            color: #000;
        }

        .pin-modal-body {
            padding: 24px;
            overflow-y: auto;
            flex: 1;
        }

        .pin-modal-form .form-field {
            margin-bottom: 20px;
        }

        .pin-modal-form label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #23282d;
        }

        .pin-modal-form .required {
            color: #d63638;
        }

        .pin-modal-form input[type="text"],
        .pin-modal-form input[type="url"],
        .pin-modal-form textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .pin-modal-form textarea {
            resize: vertical;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .modal-icon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
            gap: 10px;
            max-height: 200px;
            overflow-y: auto;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .modal-icon-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px;
            border: 2px solid transparent;
            border-radius: 6px;
            cursor: pointer;
            background: #979797ff;
            transition: all 0.2s;
        }

        .modal-icon-option:hover {
            border-color: #0073aa;
            background: #97979767;
        }

        .modal-icon-option.active {
            border-color: #0073aa;
            background: #97979767;
            box-shadow: 0 2px 4px rgba(0,115,170,0.2);
        }

        .modal-icon-option .icon-box {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 4px;
        }

        .modal-icon-option .icon-box svg {
            max-width: 24px;
            max-height: 24px;
        }

        .modal-icon-option .icon-label {
            font-size: 10px;
            text-align: center;
            color: black;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .modal-pin-preview {
            padding: 20px;
            background: #f9f9f9;
            border-radius: 6px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .modal-pin-preview .pin-icon {
            display: inline-block;
        }

        .pin-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 24px;
            border-top: 1px solid #ddd;
            background: #f9f9f9;
        }
    </style>
    
    <script>
        jQuery(document).ready(function($) {
            // ===================================
            // GLOBAL VARIABLES - MUST BE FIRST
            // ===================================
            var pendingPinData = null;
            var selectedModalIcon = '';
            
            // ===================================
            // IMAGE UPLOAD FUNCTIONALITY
            // ===================================
            var imageUploader;
            var currentImageTarget = null;

            // Handle upload button click
            $(document).on('click', '.upload-image-btn', function(e) {
                e.preventDefault();
                currentImageTarget = $(this).data('target');

                // Lower z-index of pin modal so media library appears on top
                $('#pin-modal').css('z-index', '99999');

                if (imageUploader) {
                    imageUploader.open();
                    return;
                }

                imageUploader = wp.media({
                    title: 'Select Image',
                    button: { text: 'Use this image' },
                    multiple: false,
                    library: { type: 'image' }
                });

                imageUploader.on('select', function() {
                    var attachment = imageUploader.state().get('selection').first().toJSON();
                    $('#' + currentImageTarget).val(attachment.id);
                    var $preview = $('.image-preview[data-for="' + currentImageTarget + '"]');
                    $preview.find('img').attr('src', attachment.url);
                    $preview.show();
                    $('.remove-image-btn[data-target="' + currentImageTarget + '"]').show();
                    // Restore pin modal z-index after selection
                    $('#pin-modal').css('z-index', '100000');
                });

                imageUploader.on('close', function() {
                    // Restore pin modal z-index when media library is closed
                    $('#pin-modal').css('z-index', '100000');
                });

                imageUploader.open();
            });

            // Handle remove button click
            $(document).on('click', '.remove-image-btn', function(e) {
                e.preventDefault();
                var target = $(this).data('target');
                $('#' + target).val('');
                $('.image-preview[data-for="' + target + '"]').hide().find('img').attr('src', '');
                $(this).hide();

            });
            


            var currentEditPinId = null;
            
            // ===================================
            // ICON SELECTION FUNCTIONALITY
            // ===================================
            $('.icon-option').on('click', function() {
                $('.icon-option').removeClass('active');
                $(this).addClass('active');
                
                var iconValue = $(this).data('icon');
                $('#pin_icon').val(iconValue);
                
                // Update preview
                updateIconPreview(iconValue);
            });
            
            // Update preview when pin type changes
            $('input[name="pin_type"]').on('change', function() {
                var currentIcon = $('#pin_icon').val();
                updateIconPreview(currentIcon);
            });
            
            function updateIconPreview(iconValue) {
                var $preview = $('#selected-icon-preview');
                var $previewPin = $('#pin-with-icon-preview');
                
                if (iconValue) {
                    var pinType = $('input[name="pin_type"]:checked').val();
                    var baseColor = pinType === 'accommodation' ? '#C49A5D' : '#1E3673';
                    var selectedIconHtml = $('.icon-option.active .icon-preview-box').html();
                    
                    // Create simplified preview
                    $previewPin.html(`
                        <div style="position: relative; width: 47px; height: 56px;">
                            <div style="width: 47px; height: 56px; background: ${baseColor}; clip-path: polygon(50% 100%, 0 0, 100% 0); position: relative; display: flex; align-items: center; justify-content: center;">
                                <div style="position: absolute; top: 15px; left: 50%; transform: translateX(-50%); width: 20px; height: 20px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <div style="width: 16px; height: 16px; color: ${baseColor}; transform: scale(0.6);">
                                        ${selectedIconHtml}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                    $preview.show();
                } else {
                    $preview.hide();
                }
            }
            
            // ===================================
            // DRAGGABLE PINS
            // ===================================
            function makePinsDraggable() {
                $('.admin-pin').draggable({
                    containment: '.map-editor-container',
                    start: function(event, ui) {
                        $(this).addClass('dragging');
                    },
                    drag: function(event, ui) {
                        // Update coordinates display during drag
                        var container = $('.map-editor-image');
                        var containerWidth = container.width();
                        var containerHeight = container.height();

                        // Calculate percentage position
                        var x = ((ui.position.left + ($(this).width() / 2)) / containerWidth) * 100;
                        var y = ((ui.position.top + $(this).height()) / containerHeight) * 100;

                        updateCoordinatesDisplay(x, y);
                    },
                    stop: function(event, ui) {
                        $(this).removeClass('dragging');

                        var pinId = $(this).data('pin-id');
                        var container = $('.map-editor-image');
                        var containerWidth = container.width();
                        var containerHeight = container.height();
                        var pinWidth = $(this).width();
                        var pinHeight = $(this).height();

                        // Calculate the actual anchor point (bottom-center of pin)
                        var x = ((ui.position.left + (pinWidth / 2)) / containerWidth) * 100;
                        var y = ((ui.position.top + pinHeight) / containerHeight) * 100;

                        savePinPosition(pinId, x, y);
                        hideCoordinatesDisplay();
                    }
                });
            }

            // ===================================
            // MAP INTERACTION - CROSSHAIR & CLICK
            // ===================================
            $('.map-editor-container').on('mousemove', function(e) {
                var container = $(this);
                var rect = this.getBoundingClientRect();
                var x = e.clientX - rect.left;
                var y = e.clientY - rect.top;

                updateCrosshair(x, y);

                // Calculate and display percentage coordinates
                var xPercent = (x / rect.width) * 100;
                var yPercent = (y / rect.height) * 100;
                updateCoordinatesDisplay(xPercent, yPercent);
            }).on('mouseleave', function() {
                hideCrosshair();
                hideCoordinatesDisplay();
            });

            // Click on map to add new pin
            $('#map-editor').on('click', function(e) {


                var rect = this.getBoundingClientRect();
                var clickX = e.clientX - rect.left;
                var clickY = e.clientY - rect.top;

                // Convert to percentage
                var x = (clickX / rect.width) * 100;
                var y = (clickY / rect.height) * 100;

                var pinType = $('input[name="new_pin_type"]:checked').val();



                // Visual feedback
                showClickFeedback(clickX, clickY);

                addNewPin(x, y, pinType);
            });

            // Crosshair and coordinates helper functions
            function updateCrosshair(x, y) {
                var $crosshair = $('#map-crosshair');
                if (!$crosshair.length) {
                    $crosshair = $('<div id="map-crosshair"><div class="crosshair-h"></div><div class="crosshair-v"></div></div>');
                    $('.map-editor-container').append($crosshair);
                }
                $crosshair.css({
                    left: x + 'px',
                    top: y + 'px',
                    display: 'block'
                });
            }

            function hideCrosshair() {
                $('#map-crosshair').hide();
            }

            function updateCoordinatesDisplay(x, y) {
                var $coords = $('#coordinate-display');
                if (!$coords.length) {
                    $coords = $('<div id="coordinate-display"></div>');
                    $('.map-editor-container').append($coords);
                }
                $coords.text(`X: ${x.toFixed(1)}%, Y: ${y.toFixed(1)}%`).show();
            }

            function hideCoordinatesDisplay() {
                $('#coordinate-display').hide();
            }

            function showClickFeedback(x, y) {
                var $feedback = $('<div class="click-feedback"></div>');
                $feedback.css({
                    left: x + 'px',
                    top: y + 'px'
                });
                $('.map-editor-container').append($feedback);

                setTimeout(() => {
                    $feedback.addClass('animate');
                }, 10);

                setTimeout(() => {
                    $feedback.remove();
                }, 600);
            }
            
            // ===================================
            // PIN EDIT/DELETE
            // ===================================
            $(document).on('click', '.admin-pin', function(e) {
                e.stopPropagation();
                var pinId = $(this).data('pin-id');
                editPin(pinId);
            });
            
            $('.edit-pin-btn').on('click', function() {
                var pinId = $(this).data('pin-id');
                editPin(pinId);
            });
            
            $('.delete-pin-btn').on('click', function() {
                var pinId = $(this).data('pin-id');
                if (confirm('<?php _e('Are you sure you want to delete this pin?', 'nirup-island'); ?>')) {
                    deletePin(pinId);
                }
            });

            // ===================================
            // ADD NEW PIN FUNCTION
            // ===================================
            function addNewPin(x, y, pinType) {


                // Store the pin data - CRITICAL FOR SAVE TO WORK
                pendingPinData = { x: x, y: y, pinType: pinType };
                selectedModalIcon = '';
                editingPinId = null; // Not editing



                // Reset all modal fields
                $('#modal-pin-title').val('');
                $('#modal-pin-description').val('');
                $('#modal-pin-link').val('');
                $('#modal-pin-image-1').val('');
                $('#modal-pin-image-2').val('');
                $('#modal-pin-hours').val('');
                $('.image-preview').hide().find('img').attr('src', '');
                $('.remove-image-btn').hide();
                $('.modal-icon-option').removeClass('active');
                $('.modal-icon-option[data-icon=""]').addClass('active');
                $('.pin-modal-header h2').text('<?php _e('Add New Pin', 'nirup-island'); ?>');
                $('#modal-save-pin-btn').text('<?php _e('Add Pin', 'nirup-island'); ?>');
                updateModalPreview();


                $('#pin-modal').fadeIn(200);
                setTimeout(function() {
                    $('#modal-pin-title').focus();
                }, 300);
            }

            // ===================================
            // MODAL ICON SELECTION
            // ===================================
            $(document).on('click', '.modal-icon-option', function() {
                $('.modal-icon-option').removeClass('active');
                $(this).addClass('active');
                selectedModalIcon = $(this).data('icon') || '';
                updateModalPreview();
            });

            // Update modal preview with selected icon
            function updateModalPreview() {
                if (!pendingPinData) return;

                var $preview = $('#modal-pin-preview');

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'nirup_get_pin_preview',
                        pin_type: pendingPinData.pinType,
                        icon: selectedModalIcon,
                        nonce: '<?php echo wp_create_nonce('nirup_map_nonce'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            $preview.html('<div class="pin-icon">' + response.data + '</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Preview error:', error);
                    }
                });
            }

            // ===================================
            // SAVE PIN BUTTON - SENDS ALL DATA
            // ===================================
            $('#modal-save-pin-btn').on('click', function() {

                
                var title = $('#modal-pin-title').val().trim();
                if (!title) {
                    alert('<?php _e('Please enter a pin title', 'nirup-island'); ?>');
                    return;
                }

                if (!pendingPinData) {
                    console.error('ERROR: pendingPinData is null!');
                    alert('Error: No pin location set. Try clicking the map again.');
                    return;
                }

                var description = $('#modal-pin-description').val().trim();
                var link = $('#modal-pin-link').val().trim();
                var image1 = $('#modal-pin-image-1').val() || 0;
                var image2 = $('#modal-pin-image-2').val() || 0;
                var hours = ($('#modal-pin-hours').val() || '').trim();


                // Check if we're editing or adding
                var ajaxData = {
                    title: title,
                    description: description,
                    link: link,
                    icon: selectedModalIcon,
                    image_1: image1,
                    image_2: image2,
                    hours: hours,
                    x: pendingPinData.x,
                    y: pendingPinData.y,
                    pin_type: pendingPinData.pinType,
                    nonce: '<?php echo wp_create_nonce('nirup_map_nonce'); ?>'
                };

                if (editingPinId) {
                    // Updating existing pin
                    ajaxData.action = 'nirup_update_pin_ajax';
                    ajaxData.pin_id = editingPinId;
                } else {
                    // Adding new pin
                    ajaxData.action = 'nirup_add_pin_ajax';
                }

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: ajaxData,
                    success: function(response) {
                        console.log('Save response:', response);
                        if (response.success) {
                            console.log('Pin saved successfully!');
                            $('#pin-modal').fadeOut(200);
                            location.reload();
                        } else {
                            console.error('Save failed:', response.data);
                            alert('Error: ' + response.data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', error);
                        console.error('Response:', xhr.responseText);
                        alert('<?php _e('An error occurred. Please try again.', 'nirup-island'); ?>');
                    }
                });
            });

            // ===================================
            // CLOSE MODAL
            // ===================================
            function closeModal() {
                $('#pin-modal').fadeOut(200);
                pendingPinData = null;
                selectedModalIcon = '';
                editingPinId = null;
            }

            $('.pin-modal-close, #modal-cancel-btn').on('click', closeModal);
            $('.pin-modal-overlay').on('click', closeModal);

            // ESC key to close modal
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && $('#pin-modal').is(':visible')) {
                    closeModal();
                }
            });
            
            // ===================================
            // PIN MANAGEMENT FUNCTIONS
            // ===================================
            function savePinPosition(pinId, x, y) {
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'nirup_update_pin_position',
                        pin_id: pinId,
                        x: x,
                        y: y,
                        nonce: '<?php echo wp_create_nonce('nirup_map_nonce'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            showMessage('Pin position updated!', 'success');
                        }
                    }
                });
            }
            
            function editPin(pinId) {
                var $pin = $(`.admin-pin[data-pin-id="${pinId}"]`);

                // Get current pin position
                var pinLeft = parseFloat($pin.css('left'));
                var pinTop = parseFloat($pin.css('top'));
                var containerWidth = $('.map-editor-container').width();
                var containerHeight = $('.map-editor-container').height();
                var xPercent = (pinLeft / containerWidth) * 100;
                var yPercent = (pinTop / containerHeight) * 100;

                // Store the pin data
                pendingPinData = {
                    x: xPercent,
                    y: yPercent,
                    pinType: $pin.data('pin-type')
                };
                editingPinId = pinId;

                // Pre-populate modal with existing data
                $('#modal-pin-title').val($pin.data('title') || '');
                $('#modal-pin-description').val($pin.data('description') || '');
                $('#modal-pin-link').val($pin.data('link') || '');
                $('#modal-pin-hours').val($pin.data('hours') || '');

                // Pre-select the icon if one exists
                var currentIcon = $pin.data('icon') || '';
                selectedModalIcon = currentIcon;
                $('.modal-icon-option').removeClass('active');
                if (currentIcon) {
                    $(`.modal-icon-option[data-icon="${currentIcon}"]`).addClass('active');
                } else {
                    $('.modal-icon-option[data-icon=""]').addClass('active');
                }

                // Handle Image 1
                var image1 = $pin.data('image-1');
                if (image1 && image1 != '0' && image1 != 0) {
                    $('#modal-pin-image-1').val(image1);
                    $.post(ajaxurl, { action: 'get_attachment_url', attachment_id: image1 }, function(response) {
                        if (response.success) {
                            var $preview = $('.image-preview[data-for="modal-pin-image-1"]');
                            $preview.find('img').attr('src', response.data.url);
                            $preview.show();
                            $('.remove-image-btn[data-target="modal-pin-image-1"]').show();
                        }
                    });
                } else {
                    $('#modal-pin-image-1').val('');
                    $('.image-preview[data-for="modal-pin-image-1"]').hide().find('img').attr('src', '');
                    $('.remove-image-btn[data-target="modal-pin-image-1"]').hide();
                }

                // Handle Image 2
                var image2 = $pin.data('image-2');
                if (image2 && image2 != '0' && image2 != 0) {
                    $('#modal-pin-image-2').val(image2);
                    $.post(ajaxurl, { action: 'get_attachment_url', attachment_id: image2 }, function(response) {
                        if (response.success) {
                            var $preview = $('.image-preview[data-for="modal-pin-image-2"]');
                            $preview.find('img').attr('src', response.data.url);
                            $preview.show();
                            $('.remove-image-btn[data-target="modal-pin-image-2"]').show();
                        }
                    });
                } else {
                    $('#modal-pin-image-2').val('');
                    $('.image-preview[data-for="modal-pin-image-2"]').hide().find('img').attr('src', '');
                    $('.remove-image-btn[data-target="modal-pin-image-2"]').hide();
                }

                // Update modal title and button
                $('.pin-modal-header h2').text('<?php _e('Edit Pin', 'nirup-island'); ?>');
                $('#modal-save-pin-btn').text('<?php _e('Update Pin', 'nirup-island'); ?>');

                updateModalPreview();

                // Show modal
                $('#pin-modal').fadeIn(200);
                setTimeout(function() {
                    $('#modal-pin-title').focus();
                }, 300);
            }
            
            function deletePin(pinId) {
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'nirup_delete_pin_ajax',
                        pin_id: pinId,
                        nonce: '<?php echo wp_create_nonce('nirup_map_nonce'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Error: ' + response.data);
                        }
                    }
                });
            }
            
            function showMessage(message, type) {
                var $message = $(`<div class="${type}-message">${message}</div>`);
                $('.wrap h1').after($message);
                setTimeout(() => $message.fadeOut(), 3000);
            }
        
            makePinsDraggable();
            $('.no-icon-option').trigger('click');
            
        });
    </script>
    
    <?php
}

function nirup_get_map_pins() {
    return get_option('nirup_map_pins', array());
}

function nirup_get_attachment_url_ajax() {
    $attachment_id = intval($_POST['attachment_id']);
    $url = wp_get_attachment_image_url($attachment_id, 'medium');
    
    if ($url) {
        wp_send_json_success(array('url' => $url));
    } else {
        wp_send_json_error(array('message' => 'Image not found'));
    }
}
add_action('wp_ajax_get_attachment_url', 'nirup_get_attachment_url_ajax');

function nirup_add_map_pin($data) {
    $pins = nirup_get_map_pins();

    $new_pin = array(
        'id' => uniqid('pin_'),
        'title' => sanitize_text_field($data['pin_title'] ?? $data['title'] ?? ''),
        'description' => sanitize_textarea_field($data['pin_description'] ?? $data['description'] ?? ''),
        'x' => floatval($data['pin_x'] ?? $data['x'] ?? 0),
        'y' => floatval($data['pin_y'] ?? $data['y'] ?? 0),
        'link' => esc_url_raw($data['pin_link'] ?? $data['link'] ?? ''),
        'pin_type' => sanitize_text_field($data['pin_type'] ?? 'public'),
        'icon' => sanitize_text_field($data['pin_icon'] ?? $data['icon'] ?? ''),
        // IMAGE FIELDS - CRITICAL
        'image_1' => isset($data['pin_image_1']) ? absint($data['pin_image_1']) : (isset($data['image_1']) ? absint($data['image_1']) : 0),
        'image_2' => isset($data['pin_image_2']) ? absint($data['pin_image_2']) : (isset($data['image_2']) ? absint($data['image_2']) : 0),
        'hours' => isset($data['pin_hours']) ? sanitize_text_field($data['pin_hours']) : (isset($data['hours']) ? sanitize_text_field($data['hours']) : ''),
        'created' => current_time('mysql')
    );

    $pins[] = $new_pin;
    update_option('nirup_map_pins', $pins);

    add_settings_error('nirup_pins', 'pin_added', __('Pin added successfully!', 'nirup-island'), 'updated');
}

function nirup_update_map_pin($data) {
    $pins = nirup_get_map_pins();
    $pin_id = sanitize_text_field($data['pin_id']);

    foreach ($pins as &$pin) {
        if ($pin['id'] === $pin_id) {
            $pin['title'] = sanitize_text_field($data['pin_title'] ?? $data['title'] ?? $pin['title']);
            $pin['description'] = sanitize_textarea_field($data['pin_description'] ?? $data['description'] ?? $pin['description']);
            $pin['x'] = floatval($data['pin_x'] ?? $data['x'] ?? $pin['x']);
            $pin['y'] = floatval($data['pin_y'] ?? $data['y'] ?? $pin['y']);
            $pin['link'] = esc_url_raw($data['pin_link'] ?? $data['link'] ?? $pin['link']);
            $pin['pin_type'] = sanitize_text_field($data['pin_type'] ?? $pin['pin_type']);
            $pin['icon'] = sanitize_text_field($data['pin_icon'] ?? $data['icon'] ?? $pin['icon'] ?? '');
            // IMAGE FIELDS - CRITICAL
            $pin['image_1'] = isset($data['pin_image_1']) ? absint($data['pin_image_1']) : (isset($data['image_1']) ? absint($data['image_1']) : ($pin['image_1'] ?? 0));
            $pin['image_2'] = isset($data['pin_image_2']) ? absint($data['pin_image_2']) : (isset($data['image_2']) ? absint($data['image_2']) : ($pin['image_2'] ?? 0));
            $pin['hours'] = isset($data['pin_hours']) ? sanitize_text_field($data['pin_hours']) : (isset($data['hours']) ? sanitize_text_field($data['hours']) : ($pin['hours'] ?? ''));
            $pin['updated'] = current_time('mysql');
            break;
        }
    }

    update_option('nirup_map_pins', $pins);
    add_settings_error('nirup_pins', 'pin_updated', __('Pin updated successfully!', 'nirup-island'), 'updated');
}

// AJAX handler to get image URL
function nirup_get_image_url() {
    $image_id = intval($_POST['image_id']);
    $size = isset($_POST['size']) ? sanitize_text_field($_POST['size']) : 'medium';
    
    if (!$image_id) {
        wp_send_json_error('No image ID provided');
        return;
    }
    
    $image_url = wp_get_attachment_image_url($image_id, $size);
    
    if ($image_url) {
        wp_send_json_success($image_url);
    } else {
        wp_send_json_error('Image not found');
    }
}
add_action('wp_ajax_nirup_get_image_url', 'nirup_get_image_url');
add_action('wp_ajax_nopriv_nirup_get_image_url', 'nirup_get_image_url');


function nirup_delete_map_pin($pin_id) {
    $pins = nirup_get_map_pins();
    $pin_id = sanitize_text_field($pin_id);
    
    $pins = array_filter($pins, function($pin) use ($pin_id) {
        return $pin['id'] !== $pin_id;
    });
    
    update_option('nirup_map_pins', array_values($pins));
    add_settings_error('nirup_pins', 'pin_deleted', __('Pin deleted successfully!', 'nirup-island'), 'updated');
}

function nirup_get_map_image_url() {
    $image_id = get_theme_mod('nirup_map_image');
    return $image_id ? wp_get_attachment_image_url($image_id, 'full') : false;
}

/**
 * Helper function to check if map section should be displayed
 */
function nirup_should_display_map_section() {
    return get_theme_mod('nirup_map_display', true);
}

function nirup_get_all_pins_debug() {
    $pins = get_option('nirup_map_pins', array());
    wp_send_json_success($pins);
}
add_action('wp_ajax_nirup_get_all_pins_debug', 'nirup_get_all_pins_debug');

// AJAX: Add new pin
function nirup_add_pin_ajax() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'nirup_map_nonce')) {
        wp_send_json_error('Security check failed');
        return;
    }

    // Check permissions
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Insufficient permissions');
        return;
    }

    $pins = nirup_get_map_pins();

    $new_pin = array(
        'id' => uniqid('pin_'),
        'title' => sanitize_text_field($_POST['title']),
        'description' => isset($_POST['description']) ? sanitize_textarea_field($_POST['description']) : '',
        'x' => floatval($_POST['x']),
        'y' => floatval($_POST['y']),
        'link' => isset($_POST['link']) ? esc_url_raw($_POST['link']) : '',
        'pin_type' => sanitize_text_field($_POST['pin_type']),
        'icon' => isset($_POST['icon']) ? sanitize_text_field($_POST['icon']) : '',
        // IMAGE FIELDS - CRITICAL FOR SAVING
        'image-1' => isset($_POST['image_1']) ? absint($_POST['image_1']) : 0,
        'image-2' => isset($_POST['image_2']) ? absint($_POST['image_2']) : 0,
        'hours' => isset($_POST['hours']) ? sanitize_text_field($_POST['hours']) : '',
        'created' => current_time('mysql')
    );

    $pins[] = $new_pin;
    update_option('nirup_map_pins', $pins);

    wp_send_json_success($new_pin);
}
add_action('wp_ajax_nirup_add_pin_ajax', 'nirup_add_pin_ajax');

// AJAX handler for pin preview
function nirup_get_pin_preview_ajax() {
    if (!wp_verify_nonce($_POST['nonce'], 'nirup_map_nonce')) {
        wp_die('Security check failed');
    }

    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }

    $pin_type = sanitize_text_field($_POST['pin_type']);
    $icon = isset($_POST['icon']) ? sanitize_text_field($_POST['icon']) : '';

    $svg = nirup_get_pin_icon_svg($pin_type, $icon);

    wp_send_json_success($svg);
}
add_action('wp_ajax_nirup_get_pin_preview', 'nirup_get_pin_preview_ajax');

// AJAX: Update pin position
function nirup_update_pin_position() {
    if (!wp_verify_nonce($_POST['nonce'], 'nirup_map_nonce')) {
        wp_die('Security check failed');
    }
    
    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }
    
    $pins = nirup_get_map_pins();
    $pin_id = sanitize_text_field($_POST['pin_id']);
    $x = floatval($_POST['x']);
    $y = floatval($_POST['y']);
    
    foreach ($pins as &$pin) {
        if ($pin['id'] === $pin_id) {
            $pin['x'] = $x;
            $pin['y'] = $y;
            $pin['updated'] = current_time('mysql');
            break;
        }
    }
    
    update_option('nirup_map_pins', $pins);
    wp_send_json_success('Position updated');
}
add_action('wp_ajax_nirup_update_pin_position', 'nirup_update_pin_position');


// AJAX: Update pin details
function nirup_update_pin_ajax() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'nirup_map_nonce')) {
        wp_die('Security check failed');
    }

    // Check permissions
    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }

    $pins = nirup_get_map_pins();
    $pin_id = sanitize_text_field($_POST['pin_id']);

    foreach ($pins as &$pin) {
        if ($pin['id'] === $pin_id) {
            $pin['title'] = sanitize_text_field($_POST['title']);
            $pin['description'] = sanitize_textarea_field($_POST['description']);
            $pin['link'] = esc_url_raw($_POST['link']);
            $pin['pin_type'] = sanitize_text_field($_POST['pin_type']);
            $pin['icon'] = sanitize_text_field($_POST['icon'] ?? '');
            // IMAGE FIELDS - Save image data
            $pin['image_1'] = isset($_POST['image_1']) ? absint($_POST['image_1']) : ($pin['image_1'] ?? 0);
            $pin['image_2'] = isset($_POST['image_2']) ? absint($_POST['image_2']) : ($pin['image_2'] ?? 0);
            $pin['hours'] = isset($_POST['hours']) ? sanitize_text_field($_POST['hours']) : ($pin['hours'] ?? '');
            // Only update coordinates if provided (to preserve position when editing details only)
            if (isset($_POST['x']) && isset($_POST['y'])) {
                $pin['x'] = floatval($_POST['x']);
                $pin['y'] = floatval($_POST['y']);
            }
            $pin['updated'] = current_time('mysql');
            break;
        }
    }

    update_option('nirup_map_pins', $pins);
    wp_send_json_success('Pin updated');
}
add_action('wp_ajax_nirup_update_pin_ajax', 'nirup_update_pin_ajax');

// AJAX: Delete pin
function nirup_delete_pin_ajax() {
    if (!wp_verify_nonce($_POST['nonce'], 'nirup_map_nonce')) {
        wp_die('Security check failed');
    }
    
    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }
    
    $pins = nirup_get_map_pins();
    $pin_id = sanitize_text_field($_POST['pin_id']);
    
    $pins = array_filter($pins, function($pin) use ($pin_id) {
        return $pin['id'] !== $pin_id;
    });
    
    update_option('nirup_map_pins', array_values($pins));
    wp_send_json_success('Pin deleted');
}
add_action('wp_ajax_nirup_delete_pin_ajax', 'nirup_delete_pin_ajax');

function nirup_enqueue_admin_assets() {
    $screen = get_current_screen();
    if ($screen && in_array($screen->id, ['toplevel_page_nirup-map-pins', 'map-pins_page_nirup-map-icons'])) {
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'nirup_enqueue_admin_assets');

// Remove predefined icons - only use uploaded ones
function nirup_get_predefined_icons() {
    return array(); // Empty - no predefined icons
}

// Enhanced custom icon management
function nirup_get_custom_icons() {
    $upload_dir = wp_upload_dir();
    $icon_dir = $upload_dir['basedir'] . '/pin-icons/';
    $icon_url = $upload_dir['baseurl'] . '/pin-icons/';
    
    $custom_icons = array();
    
    if (is_dir($icon_dir)) {
        $files = glob($icon_dir . '*.svg');
        foreach ($files as $file) {
            $filename = basename($file);
            $name = pathinfo($filename, PATHINFO_FILENAME);
            $file_size = filesize($file);
            $file_modified = filemtime($file);
            
            $custom_icons[$filename] = array(
                'name' => ucfirst(str_replace(array('-', '_'), ' ', $name)),
                'filename' => $filename,
                'url' => $icon_url . $filename,
                'svg' => file_get_contents($file),
                'size' => size_format($file_size),
                'modified' => date('Y-m-d H:i:s', $file_modified)
            );
        }
    }
    
    return $custom_icons;
}

// Enhanced icon upload with better validation
function nirup_handle_custom_icon_upload() {
    if (!isset($_FILES['custom_icon']) || $_FILES['custom_icon']['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $uploaded_file = $_FILES['custom_icon'];
    
    // Validate file type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $uploaded_file['tmp_name']);
    finfo_close($finfo);
    
    if ($mime_type !== 'image/svg+xml') {
        add_settings_error('nirup_pins', 'invalid_file', __('Please upload only SVG files.', 'nirup-island'), 'error');
        return false;
    }
    
    // Validate file size (max 100KB)
    if ($uploaded_file['size'] > 102400) {
        add_settings_error('nirup_pins', 'file_too_large', __('Icon file must be smaller than 100KB.', 'nirup-island'), 'error');
        return false;
    }
    
    // Create icon directory if it doesn't exist
    $upload_dir = wp_upload_dir();
    $icon_dir = $upload_dir['basedir'] . '/pin-icons/';
    
    if (!file_exists($icon_dir)) {
        wp_mkdir_p($icon_dir);
    }
    
    // Generate unique filename to avoid conflicts
    $filename = sanitize_file_name($uploaded_file['name']);
    $name = pathinfo($filename, PATHINFO_FILENAME);
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    
    $counter = 1;
    $final_filename = $filename;
    while (file_exists($icon_dir . $final_filename)) {
        $final_filename = $name . '-' . $counter . '.' . $ext;
        $counter++;
    }
    
    $filepath = $icon_dir . $final_filename;
    
    if (move_uploaded_file($uploaded_file['tmp_name'], $filepath)) {
        add_settings_error('nirup_pins', 'icon_uploaded', __('Icon uploaded successfully!', 'nirup-island'), 'updated');
        return $final_filename;
    }
    
    add_settings_error('nirup_pins', 'upload_failed', __('Failed to upload icon.', 'nirup-island'), 'error');
    return false;
}

// Delete custom icon
function nirup_delete_custom_icon($filename) {
    $upload_dir = wp_upload_dir();
    $icon_dir = $upload_dir['basedir'] . '/pin-icons/';
    $filepath = $icon_dir . sanitize_file_name($filename);
    
    if (file_exists($filepath)) {
        unlink($filepath);
        
        // Also remove this icon from any pins using it
        $pins = nirup_get_map_pins();
        $updated = false;
        foreach ($pins as &$pin) {
            if (isset($pin['icon']) && $pin['icon'] === 'custom:' . $filename) {
                $pin['icon'] = '';
                $updated = true;
            }
        }
        
        if ($updated) {
            update_option('nirup_map_pins', $pins);
        }
        
        return true;
    }
    
    return false;
}


function nirup_extract_svg_viewbox($svg_string) {
    // Try to find viewBox attribute
    if (preg_match('/viewBox=["\']([^"\']+)["\']/', $svg_string, $matches)) {
        return $matches[1];
    }
    
    // If no viewBox, try to construct one from width/height
    $width = 28;  
    $height = 28; 
    
    if (preg_match('/width=["\'](\d+(?:\.\d+)?)[^"\']*["\']/', $svg_string, $w_matches)) {
        $width = floatval($w_matches[1]);
    }
    if (preg_match('/height=["\'](\d+(?:\.\d+)?)[^"\']*["\']/', $svg_string, $h_matches)) {
        $height = floatval($h_matches[1]);
    }
    
    return "0 0 $width $height";
}

function nirup_extract_svg_content($svg_string) {
    $svg_string = preg_replace('/<svg[^>]*>/', '', $svg_string);
    $svg_string = preg_replace('/<\/svg>/', '', $svg_string);
    return trim($svg_string);
}


function nirup_get_pin_icon_svg($pin_type, $custom_icon = '') {
    if ($pin_type === 'accommodation') {
        $base_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="94" height="124" viewBox="0 0 94 124" fill="none">
        <g filter="url(#filter0_d_481_1351)">
                    <path d="M47 15C32.0966 15.0197 20.0197 27.0965 20 41.9999C20 61.3835 45.155 85.6609 46.2237 86.6847C46.6555 87.1051 47.3445 87.1051 47.7763 86.6847C48.845 85.6609 74 61.3835 74 41.9999C73.9803 27.0965 61.9034 15.0197 47 15Z" fill="#C49A5D"/>
                    <path d="M47 15.75C61.263 15.7694 72.8627 27.147 73.2402 41.3232L73.25 42.001C73.2498 46.6932 71.7246 51.7302 69.375 56.6943C67.0282 61.6527 63.8806 66.4934 60.6875 70.7793C54.3027 79.3491 47.7822 85.6403 47.2578 86.1426L47.2529 86.1475C47.1124 86.2842 46.8876 86.2842 46.7471 86.1475L46.7422 86.1426C46.2178 85.6403 39.6973 79.3491 33.3125 70.7793C30.1194 66.4934 26.9718 61.6527 24.625 56.6943C22.2754 51.7302 20.7502 46.6932 20.75 42.001C20.7691 27.5114 32.5105 15.7697 47 15.75Z" stroke="url(#paint0_linear_481_1351)" stroke-width="1.5"/>
                    </g>
                    <g filter="url(#filter1_d_481_1351)">
                    <circle cx="47" cy="95.0005" r="4" fill="white"/>
                    </g>';
        $defs = '<defs>
<filter id="filter0_d_481_1351" x="0" y="0" width="94" height="112" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
<feFlood flood-opacity="0" result="BackgroundImageFix"/>
<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
<feOffset dy="5"/>
<feGaussianBlur stdDeviation="10"/>
<feComposite in2="hardAlpha" operator="out"/>
<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.18 0"/>
<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_481_1351"/>
<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_481_1351" result="shape"/>
</filter>
<filter id="filter1_d_481_1351" x="39" y="89.0005" width="16" height="16" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
<feFlood flood-opacity="0" result="BackgroundImageFix"/>
<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
<feOffset dy="2"/>
<feGaussianBlur stdDeviation="2"/>
<feComposite in2="hardAlpha" operator="out"/>
<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_481_1351"/>
<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_481_1351" result="shape"/>
</filter>
<linearGradient id="paint0_linear_481_1351" x1="47" y1="15" x2="47" y2="87" gradientUnits="userSpaceOnUse">
<stop stop-color="#E6C896"/>
<stop offset="1" stop-color="#A07543"/>
</linearGradient>
</defs>';
    } else {
        // Public pin type
        $base_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="94" height="124" viewBox="0 0 94 124" fill="none">
        <g filter="url(#filter0_d_481_1382)">
                    <path d="M47 15C32.0966 15.0197 20.0197 27.0965 20 41.9999C20 61.3835 45.155 85.6609 46.2237 86.6847C46.6555 87.1051 47.3445 87.1051 47.7763 86.6847C48.845 85.6609 74 61.3835 74 41.9999C73.9803 27.0965 61.9034 15.0197 47 15Z" fill="#153C88"/>
                    <path d="M47 15.75C61.263 15.7694 72.8627 27.147 73.2402 41.3232L73.25 42.001C73.2498 46.6932 71.7246 51.7302 69.375 56.6943C67.0282 61.6527 63.8806 66.4934 60.6875 70.7793C54.3027 79.3491 47.7822 85.6403 47.2578 86.1426L47.2529 86.1475C47.1124 86.2842 46.8876 86.2842 46.7471 86.1475L46.7422 86.1426C46.2178 85.6403 39.6973 79.3491 33.3125 70.7793C30.1194 66.4934 26.9718 61.6527 24.625 56.6943C22.2754 51.7302 20.7502 46.6932 20.75 42.001C20.7691 27.5114 32.5105 15.7697 47 15.75Z" stroke="url(#paint0_linear_481_1382)" stroke-width="1.5"/>
                    </g>
                    <g filter="url(#filter1_d_481_1382)">
                    <circle cx="47" cy="95.0005" r="4" fill="white"/>
                    </g>';
        $defs = '<defs>
<filter id="filter0_d_481_1382" x="0" y="0" width="94" height="112" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
<feFlood flood-opacity="0" result="BackgroundImageFix"/>
<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
<feOffset dy="5"/>
<feGaussianBlur stdDeviation="10"/>
<feComposite in2="hardAlpha" operator="out"/>
<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.18 0"/>
<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_481_1382"/>
<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_481_1382" result="shape"/>
</filter>
<filter id="filter1_d_481_1382" x="39" y="89.0005" width="16" height="16" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
<feFlood flood-opacity="0" result="BackgroundImageFix"/>
<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
<feOffset dy="2"/>
<feGaussianBlur stdDeviation="2"/>
<feComposite in2="hardAlpha" operator="out"/>
<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_481_1382"/>
<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_481_1382" result="shape"/>
</filter>
<linearGradient id="paint0_linear_481_1382" x1="47" y1="15" x2="47" y2="87" gradientUnits="userSpaceOnUse">
<stop stop-color="#6E9CE0"/>
<stop offset="1" stop-color="#1E3673"/>
</linearGradient>
</defs>';
    }
    
    // Add custom icon overlay - NO BACKGROUND CIRCLE
    $icon_overlay = '';
    if (!empty($custom_icon) && strpos($custom_icon, 'custom:') === 0) {
        $filename = str_replace('custom:', '', $custom_icon);
        $custom_icons = nirup_get_custom_icons();
        if (isset($custom_icons[$filename])) {
            $icon_svg = $custom_icons[$filename]['svg'];
            
            // Extract the viewBox and content from the uploaded SVG
            $viewBox = nirup_extract_svg_viewbox($icon_svg);
            $icon_content = nirup_extract_svg_content($icon_svg);
            
            // STANDARDIZED 28x28 ICON CONTAINER - NO BACKGROUND
            $icon_overlay = '
            <g transform="translate(33, 28)">
                <svg x="0" y="0" width="28" height="28" viewBox="' . esc_attr($viewBox) . '" preserveAspectRatio="xMidYMid meet">
                    ' . $icon_content . '
                </svg>
            </g>';
        }
    }
    
    return '<svg width="94" height="112" viewBox="0 0 94 112" fill="none" xmlns="http://www.w3.org/2000/svg">
        ' . $base_svg . '
        ' . $icon_overlay . '
        ' . $defs . '
        </svg>';
}

// AJAX handler for icon management
function nirup_manage_icon_ajax() {
    if (!wp_verify_nonce($_POST['nonce'], 'nirup_map_nonce')) {
        wp_die('Security check failed');
    }
    
    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }
    
    $action_type = sanitize_text_field($_POST['action_type']);
    
    if ($action_type === 'delete_icon') {
        $filename = sanitize_text_field($_POST['filename']);
        if (nirup_delete_custom_icon($filename)) {
            wp_send_json_success('Icon deleted successfully');
        } else {
            wp_send_json_error('Failed to delete icon');
        }
    }
}
add_action('wp_ajax_nirup_manage_icon_ajax', 'nirup_manage_icon_ajax');


function nirup_icon_library_admin_page() {
    // Handle icon upload
    if (isset($_POST['action']) && $_POST['action'] === 'upload_icon' && wp_verify_nonce($_POST['nirup_icon_nonce'], 'nirup_icon_action')) {
        nirup_handle_custom_icon_upload();
    }
    
    // Handle icon deletion
    if (isset($_POST['action']) && $_POST['action'] === 'delete_icon' && wp_verify_nonce($_POST['nirup_icon_nonce'], 'nirup_icon_action')) {
        $filename = sanitize_text_field($_POST['icon_filename']);
        if (nirup_delete_custom_icon($filename)) {
            add_settings_error('nirup_icons', 'icon_deleted', __('Icon deleted successfully!', 'nirup-island'), 'updated');
        } else {
            add_settings_error('nirup_icons', 'delete_failed', __('Failed to delete icon.', 'nirup-island'), 'error');
        }
    }
    
    $custom_icons = nirup_get_custom_icons();
    
    ?>
    <div class="wrap">
        <h1><?php _e('Icon Library Management', 'nirup-island'); ?></h1>
        
        <?php settings_errors('nirup_icons'); ?>
        
        <!-- Upload New Icon -->
        <div class="card">
            <h2><?php _e('Upload New Icon', 'nirup-island'); ?></h2>
            <form method="post" enctype="multipart/form-data">
                <?php wp_nonce_field('nirup_icon_action', 'nirup_icon_nonce'); ?>
                <input type="hidden" name="action" value="upload_icon">
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="custom_icon"><?php _e('Select SVG Icon', 'nirup-island'); ?></label>
                        </th>
                        <td>
                            <input type="file" name="custom_icon" id="custom_icon" accept=".svg,image/svg+xml" required>
                            <p class="description">
                                <?php _e('Upload SVG files only. Maximum size: 100KB. Icons work best when they are simple and clear at small sizes.', 'nirup-island'); ?>
                            </p>
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" name="submit" class="button button-primary" value="<?php _e('Upload Icon', 'nirup-island'); ?>">
                </p>
            </form>
        </div>
        
        <!-- Icon Library -->
        <div class="card">
            <h2><?php _e('Your Icon Library', 'nirup-island'); ?></h2>
            
            <?php if (empty($custom_icons)): ?>
                <p><?php _e('No icons uploaded yet. Upload your first icon above!', 'nirup-island'); ?></p>
            <?php else: ?>
                <div class="icon-library-grid">
                    <?php foreach ($custom_icons as $filename => $icon): ?>
                        <div class="icon-item" data-filename="<?php echo esc_attr($filename); ?>">
                            <div class="icon-preview">
                                <div class="icon-display"><?php echo $icon['svg']; ?></div>
                            </div>
                            <div class="icon-info">
                                <strong><?php echo esc_html($icon['name']); ?></strong>
                                <small><?php echo esc_html($icon['size']); ?></small>
                                <small><?php echo esc_html($icon['modified']); ?></small>
                            </div>
                            <div class="icon-actions">
                                <form method="post" style="display: inline;" onsubmit="return confirm('<?php _e('Are you sure you want to delete this icon?', 'nirup-island'); ?>');">
                                    <?php wp_nonce_field('nirup_icon_action', 'nirup_icon_nonce'); ?>
                                    <input type="hidden" name="action" value="delete_icon">
                                    <input type="hidden" name="icon_filename" value="<?php echo esc_attr($filename); ?>">
                                    <button type="submit" class="button button-small button-link-delete"><?php _e('Delete', 'nirup-island'); ?></button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <style>
        .icon-library-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .icon-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background: #fff;
            text-align: center;
        }
        
        .icon-preview {
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            background: #f9f9f9;
            border-radius: 4px;
        }
        
        .icon-display {
            max-width: 40px;
            max-height: 40px;
        }
        
        .icon-display svg {
            width: 100%;
            height: 100%;
            max-width: 40px;
            max-height: 40px;
        }
        
        .icon-info {
            margin-bottom: 10px;
        }
        
        .icon-info strong {
            display: block;
            margin-bottom: 5px;
        }
        
        .icon-info small {
            display: block;
            color: #666;
            font-size: 11px;
        }
        
        .icon-actions {
            margin-top: 10px;
        }
    </style>
    <?php
}

function nirup_getting_here_customizer($wp_customize) {
    // Getting Here Section
    $wp_customize->add_section('nirup_getting_here', array(
        'title' => __('Getting Here Section', 'nirup-island'),
        'priority' => 37,
        'description' => __('Customize the Getting Here section with interactive Google Maps', 'nirup-island'),
    ));

    // Section Content Settings
    $wp_customize->add_setting('nirup_getting_here_title', array(
        'default' => __('GETTING HERE', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_getting_here_title', array(
        'label' => __('Section Title', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_getting_here_description', array(
        'default' => __('Nirup Island is just a 20-minute ferry ride from Harbour Bay Ferry Terminal in Batam and 50 minutes from HarbourFront Centre in Singapore.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('nirup_getting_here_description', array(
        'label' => __('Description', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'textarea',
    ));

    // Google Maps API Settings
    $wp_customize->add_setting('nirup_google_maps_api_key', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_google_maps_api_key', array(
        'label' => __('Google Maps API Key', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
        'description' => __('Enter your Google Maps JavaScript API key. Get one at: https://developers.google.com/maps/documentation/javascript/get-api-key', 'nirup-island'),
    ));

    // Map Settings
    $wp_customize->add_setting('nirup_map_center_lat', array(
        'default' => '1.1304753',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_map_center_lat', array(
        'label' => __('Map Center Latitude (Nirup Island)', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
        'description' => __('Latitude coordinate for Nirup Island', 'nirup-island'),
    ));

    $wp_customize->add_setting('nirup_map_center_lng', array(
        'default' => '104.0266055',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_map_center_lng', array(
        'label' => __('Map Center Longitude (Nirup Island)', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
        'description' => __('Longitude coordinate for Nirup Island', 'nirup-island'),
    ));

    $wp_customize->add_setting('nirup_map_zoom', array(
        'default' => '10',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('nirup_map_zoom', array(
        'label' => __('Map Zoom Level', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
        ),
        'description' => __('Map zoom level (1-20, recommended: 10-12)', 'nirup-island'),
    ));

    $wp_customize->add_setting('nirup_map_style', array(
        'default' => 'terrain',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_map_style', array(
        'label' => __('Map Style', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'select',
        'choices' => array(
            'roadmap' => __('Roadmap', 'nirup-island'),
            'satellite' => __('Satellite', 'nirup-island'),
            'hybrid' => __('Hybrid', 'nirup-island'),
            'terrain' => __('Terrain', 'nirup-island'),
        ),
    ));

    // Singapore Ferry Terminal Settings
    $wp_customize->add_setting('nirup_singapore_lat', array(
        'default' => '1.2650543',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_singapore_lat', array(
        'label' => __('Singapore Terminal Latitude', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
        'description' => __('HarbourFront Centre coordinates', 'nirup-island'),
    ));

    $wp_customize->add_setting('nirup_singapore_lng', array(
        'default' => '103.8232508',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_singapore_lng', array(
        'label' => __('Singapore Terminal Longitude', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_singapore_departure', array(
        'default' => __('HarbourFront Centre', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_singapore_departure', array(
        'label' => __('Singapore Departure Point', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_singapore_time', array(
        'default' => __('50 minutes', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_singapore_time', array(
        'label' => __('Singapore Travel Time', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_singapore_ferry_info', array(
        'default' => __('50 minutes from HarbourFront Centre', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_singapore_ferry_info', array(
        'label' => __('Singapore Ferry Info (Map Tooltip)', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    // Batam Ferry Terminal Settings
    $wp_customize->add_setting('nirup_batam_lat', array(
        'default' => '1.1210997',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_batam_lat', array(
        'label' => __('Batam Terminal Latitude', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
        'description' => __('Harbour Bay Ferry Terminal coordinates', 'nirup-island'),
    ));

    $wp_customize->add_setting('nirup_batam_lng', array(
        'default' => '104.0538234',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_batam_lng', array(
        'label' => __('Batam Terminal Longitude', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_batam_departure', array(
        'default' => __('Harbour Bay Ferry Terminal', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_batam_departure', array(
        'label' => __('Batam Departure Point', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_batam_time', array(
        'default' => __('20 minutes', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_batam_time', array(
        'label' => __('Batam Travel Time', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_batam_ferry_info', array(
        'default' => __('20 minutes from Harbour Bay Terminal', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_batam_ferry_info', array(
        'label' => __('Batam Ferry Info (Map Tooltip)', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    // Show/Hide Section
    $wp_customize->add_setting('nirup_getting_here_show', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('nirup_getting_here_show', array(
        'label' => __('Show Getting Here Section', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'checkbox',
    ));

        // See More Button Settings
    $wp_customize->add_setting('nirup_getting_here_show_button', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('nirup_getting_here_show_button', array(
        'label' => __('Show "See More" Button', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'checkbox',
        'description' => __('Display the "See More" button in the header', 'nirup-island'),
    ));

    $wp_customize->add_setting('nirup_getting_here_button_text', array(
        'default' => __('See More', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_getting_here_button_text', array(
        'label' => __('Button Text', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_getting_here_button_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

}
add_action('customize_register', 'nirup_getting_here_customizer');

/**
 * Helper function to check if Getting Here section should be displayed
 */
function nirup_should_display_getting_here_section() {
    return get_theme_mod('nirup_getting_here_show', true);
}

/**
 * Enqueue Getting Here Section specific styles and scripts (FIXED)
 */
function nirup_getting_here_assets() {
    if (is_page_template('page-getting-here.php')) {
        // Enqueue CSS first
        wp_enqueue_style(
            'nirup-getting-here-css',
            get_template_directory_uri() . '/assets/css/page-getting-here.css',
            array('nirup-main'),
            '1.0.3'
        );

        $google_maps_api_key = get_theme_mod('nirup_google_maps_api_key', '');
        
        if (!empty($google_maps_api_key)) {
            // Load our JavaScript FIRST (in footer, BEFORE Google Maps)
            wp_enqueue_script(
                'nirup-getting-here-js',
                get_template_directory_uri() . '/assets/js/getting-here.js',
                array('jquery'),
                '1.0.3',
                true // Load in footer
            );
            
            // Then load Google Maps API (depends on our script)
            wp_enqueue_script(
                'google-maps-api',
                'https://maps.googleapis.com/maps/api/js?key=' . esc_attr($google_maps_api_key) . '&libraries=geometry&callback=initNirupMap',
                array('nirup-getting-here-js'), // Depends on our script
                null,
                true // Load in footer AFTER our script
            );
        } else {
            wp_enqueue_script(
                'nirup-getting-here-js',
                get_template_directory_uri() . '/assets/js/getting-here.js',
                array('jquery'),
                '1.0.3',
                true
            );
        }

        // Localize script with map data
        wp_localize_script('nirup-getting-here-js', 'nirupGettingHere', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('nirup_getting_here_nonce'),
            'hasApiKey' => !empty($google_maps_api_key),
            'strings' => array(
                'loadingMap' => __('Loading interactive map...', 'nirup-island'),
                'nirupIsland' => __('Nirup Island', 'nirup-island'),
                'singapore' => __('Singapore Terminal', 'nirup-island'),
                'batam' => __('Batam Terminal', 'nirup-island'),
                'ferryRoute' => __('Ferry Route', 'nirup-island'),
            ),
        ));
    }
}
add_action('wp_enqueue_scripts', 'nirup_getting_here_assets');
/**
 * Add admin notice if Google Maps API key is missing
 */
function nirup_google_maps_admin_notice() {
    $screen = get_current_screen();
    if ($screen && ($screen->id === 'customize' || $screen->id === 'appearance_page_customize')) {
        $api_key = get_theme_mod('nirup_google_maps_api_key', '');
        if (empty($api_key)) {
            echo '<div class="notice notice-warning"><p>';
            echo '<strong>' . __('Nirup Island Theme:', 'nirup-island') . '</strong> ';
            echo __('To enable interactive maps in the Getting Here section, please add your Google Maps API key in the Customizer.', 'nirup-island');
            echo ' <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">' . __('Get API Key', 'nirup-island') . '</a>';
            echo '</p></div>';
        }
    }
}
add_action('admin_notices', 'nirup_google_maps_admin_notice');

function nirup_services_customize_register($wp_customize) {
    
    // ===========================
    // SERVICES SECTION PANEL
    // ===========================
    
    $wp_customize->add_section('nirup_services_section', array(
        'title'       => __('Services Section', 'nirup-island'),
        'description' => __('Configure the services section with Private Events, Marina, and Sustainability cards.', 'nirup-island'),
        'priority'    => 37,
    ));
    
    // Services Section Show/Hide
    $wp_customize->add_setting('nirup_services_show', array(
        'default'           => true,
        'sanitize_callback' => 'nirup_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_services_show', array(
        'label'       => __('Show Services Section', 'nirup-island'),
        'description' => __('Toggle to show/hide the entire services section.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'checkbox',
        'priority'    => 10,
    ));
    
    // ===========================
    // PRIVATE EVENTS CARD
    // ===========================
    
    // Private Events Title
    $wp_customize->add_setting('nirup_service_events_title', array(
        'default'           => __('Private Events', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_service_events_title', array(
        'label'       => __('Private Events Title', 'nirup-island'),
        'description' => __('Title for the Private Events card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'text',
        'priority'    => 20,
    ));
    
    // Private Events Description
    $wp_customize->add_setting('nirup_service_events_desc', array(
        'default'           => __('Nirup Island provides an exclusive and well-appointed setting for private team-building events, destination weddings, and other special occasions.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_service_events_desc', array(
        'label'       => __('Private Events Description', 'nirup-island'),
        'description' => __('Description text for the Private Events card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'textarea',
        'priority'    => 30,
    ));
    
    // Private Events Image
    $wp_customize->add_setting('nirup_service_events_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_service_events_image', array(
        'label'       => __('Private Events Image', 'nirup-island'),
        'description' => __('Upload an image for the Private Events card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'mime_type'   => 'image',
        'priority'    => 40,
    )));
    
    // Private Events Link
    $wp_customize->add_setting('nirup_service_events_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_service_events_link', array(
        'label'       => __('Private Events Link', 'nirup-island'),
        'description' => __('URL where the Private Events card should link to.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'url',
        'priority'    => 45,
    ));
    
    // ===========================
    // MARINA CARD
    // ===========================
    
    // Marina Title
    $wp_customize->add_setting('nirup_service_marina_title', array(
        'default'           => __('Marina', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_service_marina_title', array(
        'label'       => __('Marina Title', 'nirup-island'),
        'description' => __('Title for the Marina card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'text',
        'priority'    => 50,
    ));
    
    // Marina Description
    $wp_customize->add_setting('nirup_service_marina_desc', array(
        'default'           => __('ONE°15 Marina at Nirup Island offers berthing facilities for up to 70 private yachts, along with private charters for scenic journeys or special events.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_service_marina_desc', array(
        'label'       => __('Marina Description', 'nirup-island'),
        'description' => __('Description text for the Marina card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'textarea',
        'priority'    => 60,
    ));
    
    // Marina Image
    $wp_customize->add_setting('nirup_service_marina_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_service_marina_image', array(
        'label'       => __('Marina Image', 'nirup-island'),
        'description' => __('Upload an image for the Marina card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'mime_type'   => 'image',
        'priority'    => 70,
    )));
    
    // Marina Link
    $wp_customize->add_setting('nirup_service_marina_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_service_marina_link', array(
        'label'       => __('Marina Link', 'nirup-island'),
        'description' => __('URL where the Marina card should link to.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'url',
        'priority'    => 75,
    ));
    
    // ===========================
    // SUSTAINABILITY CARD
    // ===========================
    
    // Sustainability Title
    $wp_customize->add_setting('nirup_service_sustainability_title', array(
        'default'           => __('Sustainability', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_service_sustainability_title', array(
        'label'       => __('Sustainability Title', 'nirup-island'),
        'description' => __('Title for the Sustainability card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'text',
        'priority'    => 80,
    ));
    
    // Sustainability Description
    $wp_customize->add_setting('nirup_service_sustainability_desc', array(
        'default'           => __('From solar panels to rainwater harvesting and local sourcing, sustainability is central to Nirup Island\'s operations. Guests are encouraged to engage in eco-friendly habits and support local communities.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_service_sustainability_desc', array(
        'label'       => __('Sustainability Description', 'nirup-island'),
        'description' => __('Description text for the Sustainability card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'textarea',
        'priority'    => 90,
    ));
    
    // Sustainability Image
    $wp_customize->add_setting('nirup_service_sustainability_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_service_sustainability_image', array(
        'label'       => __('Sustainability Image', 'nirup-island'),
        'description' => __('Upload an image for the Sustainability card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'mime_type'   => 'image',
        'priority'    => 100,
    )));
    
    // Sustainability Link
    $wp_customize->add_setting('nirup_service_sustainability_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_service_sustainability_link', array(
        'label'       => __('Sustainability Link', 'nirup-island'),
        'description' => __('URL where the Sustainability card should link to.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'url',
        'priority'    => 105,
    ));
}
add_action('customize_register', 'nirup_services_customize_register');

/**
 * Customizer Live Preview for Services Section
 */
function nirup_services_customize_preview_js() {
    wp_enqueue_script(
        'nirup-services-customize-preview',
        get_template_directory_uri() . '/assets/js/customize-preview-services.js',
        array('customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'nirup_services_customize_preview_js');

/**
 * Sanitize checkbox function (if not already exists)
 */
if (!function_exists('nirup_sanitize_checkbox')) {
    function nirup_sanitize_checkbox($checked) {
        return ((isset($checked) && true == $checked) ? true : false);
    }
}


function register_events_offers_post_type() {
    $labels = array(
        'name'                  => _x('Events & Offers', 'Post Type General Name', 'nirup-island'),
        'singular_name'         => _x('Event/Offer', 'Post Type Singular Name', 'nirup-island'),
        'menu_name'             => __('Events & Offers', 'nirup-island'),
        'name_admin_bar'        => __('Event/Offer', 'nirup-island'),
        'archives'              => __('Events & Offers Archives', 'nirup-island'),
        'attributes'            => __('Event/Offer Attributes', 'nirup-island'),
        'parent_item_colon'     => __('Parent Event/Offer:', 'nirup-island'),
        'all_items'             => __('All Events & Offers', 'nirup-island'),
        'add_new_item'          => __('Add New Event/Offer', 'nirup-island'),
        'add_new'               => __('Add New', 'nirup-island'),
        'new_item'              => __('New Event/Offer', 'nirup-island'),
        'edit_item'             => __('Edit Event/Offer', 'nirup-island'),
        'update_item'           => __('Update Event/Offer', 'nirup-island'),
        'view_item'             => __('View Event/Offer', 'nirup-island'),
        'view_items'            => __('View Events & Offers', 'nirup-island'),
        'search_items'          => __('Search Events & Offers', 'nirup-island'),
        'not_found'             => __('Not found', 'nirup-island'),
        'not_found_in_trash'    => __('Not found in Trash.', 'nirup-island'),
        'featured_image'        => _x('Event/Offer Featured Image', 'Overrides the "Featured Image" phrase', 'nirup-island'),
        'set_featured_image'    => _x('Set featured image', 'Overrides the "Set featured image" phrase', 'nirup-island'),
        'remove_featured_image' => _x('Remove featured image', 'Overrides the "Remove featured image" phrase', 'nirup-island'),
        'use_featured_image'    => _x('Use as featured image', 'Overrides the "Use as featured image" phrase', 'nirup-island'),
        'insert_into_item'      => _x('Insert into event/offer', 'Overrides the "Insert into post" phrase', 'nirup-island'),
        'uploaded_to_this_item' => _x('Uploaded to this event/offer', 'Overrides the "Uploaded to this post" phrase', 'nirup-island'),
        'items_list'            => _x('Events & Offers list', 'Screen reader text for the items list', 'nirup-island'),
        'items_list_navigation' => _x('Events & Offers list navigation', 'Screen reader text for the pagination', 'nirup-island'),
        'filter_items_list'     => _x('Filter events & offers list', 'Screen reader text for the filter links', 'nirup-island'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'events-offers'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false, // Unlike experiences, events/offers don't have parent-child relationships
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'page-attributes'),
        'show_in_rest'       => true,
    );

    register_post_type('event_offer', $args);
}
add_action('init', 'register_events_offers_post_type');

/**
 * Add custom fields for events and offers
 */
function add_event_offer_meta_boxes() {
    add_meta_box(
        'event_offer_details',
        'Event/Offer Details',
        'event_offer_details_callback',
        'event_offer',
        'normal',
        'high'
    );
    
    // Add gallery meta box
    add_meta_box(
        'event_offer_gallery',
        'Event/Offer Gallery',
        'event_offer_gallery_callback',
        'event_offer',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_event_offer_meta_boxes');

function event_offer_details_callback($post) {
    wp_nonce_field('save_event_offer_details', 'event_offer_details_nonce');
    
    $short_description = get_post_meta($post->ID, '_event_offer_short_description', true);
    $featured_in_carousel = get_post_meta($post->ID, '_event_offer_featured_in_carousel', true);
    $featured_in_archive = get_post_meta($post->ID, '_event_offer_featured_in_archive', true);
    $event_date = get_post_meta($post->ID, '_event_offer_date', true);
    $event_end_date = get_post_meta($post->ID, '_event_offer_end_date', true);
    $event_type = get_post_meta($post->ID, '_event_offer_type', true);
    $event_location = get_post_meta($post->ID, '_event_offer_location', true);
    $event_location_description = get_post_meta($post->ID, '_event_offer_location_description', true);
    $additional_info = get_post_meta($post->ID, '_event_offer_additional_info', true);
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<td colspan="2" style="padding: 15px 0; border-bottom: 1px solid #ddd;">';
    echo '<p style="margin: 0; font-style: italic; color: #666;"><strong>Note:</strong> Make sure to add content in the main editor above to display the event description on the page.</p>';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="event_offer_short_description">Subtitle</label></th>';
    echo '<td><input type="text" id="event_offer_short_description" name="event_offer_short_description" value="' . esc_attr($short_description) . '" class="widefat" placeholder="e.g., An Evening of Music & Magic" />';
    echo '<p class="description">This will appear as the large subtitle under the hero section.</p></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="event_offer_type">Type</label></th>';
    echo '<td>';
    echo '<select id="event_offer_type" name="event_offer_type">';
    echo '<option value="event"' . selected($event_type, 'event', false) . '>Event</option>';
    echo '<option value="offer"' . selected($event_type, 'offer', false) . '>Special Offer</option>';
    echo '</select>';
    echo '<p class="description">Specify whether this is an event or a special offer.</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="event_offer_date">Start Date</label></th>';
    echo '<td><input type="datetime-local" id="event_offer_date" name="event_offer_date" value="' . esc_attr($event_date) . '" /></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="event_offer_end_date">End Date/Time (Optional)</label></th>';
    echo '<td><input type="datetime-local" id="event_offer_end_date" name="event_offer_end_date" value="' . esc_attr($event_end_date) . '" />';
    echo '<p class="description">Leave empty for single-day events or ongoing offers.</p></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="event_offer_location">Location</label></th>';
    echo '<td><input type="text" id="event_offer_location" name="event_offer_location" value="' . esc_attr($event_location) . '" class="widefat" placeholder="e.g., Constellate Rooftop Bar & Lounge" /></td>';
    // echo '<p class="description"></p>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="event_offer_location_description">Location Description</label></th>';
    echo '<td><textarea id="event_offer_location_description" name="event_offer_location_description" class="widefat" rows="2" placeholder="e.g., Located on the rooftop of The Westin Nirup Island">' . esc_textarea($event_location_description) . '</textarea>';
    echo '<p class="description">Additional description for the location. Leave empty to hide.</p></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="event_offer_additional_info">Additional Information</label></th>';
    echo '<td><textarea id="event_offer_additional_info" name="event_offer_additional_info" class="widefat" rows="3" placeholder="Additional details about the event/offer...">' . esc_textarea($additional_info) . '</textarea>';
    echo '<p class="description">This text will appear below the main content description, after the divider line and before the "How to Book" button.</p></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="event_offer_booking_link">Booking Link (External)</label></th>';
    echo '<td>';
    $booking_link = get_post_meta($post->ID, '_event_offer_booking_link', true);
    echo '<input type="url" id="event_offer_booking_link" name="event_offer_booking_link" value="' . esc_attr($booking_link) . '" class="widefat" placeholder="https://example.com/booking" />';
    echo '<p class="description">Enter an external URL for booking. The "Book Now" button will only appear if this field is filled. Link will open in a new tab.</p>';
    echo '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<th>Display Options</th>';
    echo '<td>';
    echo '<label><input type="checkbox" name="event_offer_featured_in_carousel" value="1"' . checked($featured_in_carousel, 1, false) . ' /> Display in Homepage Carousel</label><br>';
    echo '<label><input type="checkbox" name="event_offer_featured_in_archive" value="1"' . checked($featured_in_archive, 1, false) . ' /> Display in Events & Offers Archive Page</label>';
    echo '<p class="description">Choose where this event/offer should appear.</p>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

function event_offer_gallery_callback($post) {
    wp_nonce_field('save_event_offer_gallery', 'event_offer_gallery_nonce');
    
    $gallery_images = get_post_meta($post->ID, '_event_offer_gallery', true);
    $gallery_images = is_array($gallery_images) ? $gallery_images : array();
    
    echo '<div class="event-offer-gallery-container">';
    echo '<p class="description">Upload images for the event/offer gallery. These will be displayed in a carousel at the bottom of the single event/offer page.</p>';
    
    echo '<div class="gallery-images-wrapper">';
    echo '<div id="gallery-images-container" class="gallery-images-grid">';
    
    // Display existing images
    foreach ($gallery_images as $image_id) {
        $image_url = wp_get_attachment_thumb_url($image_id);
        if ($image_url) {
            echo '<div class="gallery-image-item" data-attachment-id="' . esc_attr($image_id) . '">';
            echo '<img src="' . esc_url($image_url) . '" alt="" style="max-width: 150px; height: 100px; object-fit: cover;">';
            echo '<button type="button" class="remove-gallery-image" style="position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer;">×</button>';
            echo '<input type="hidden" name="event_offer_gallery[]" value="' . esc_attr($image_id) . '">';
            echo '</div>';
        }
    }
    
    echo '</div>';
    echo '<button type="button" id="add-gallery-images" class="button button-secondary" style="margin-top: 10px;">Add Images to Gallery</button>';
    echo '</div>';
    
    echo '</div>';
    
    // Add the media upload script
    ?>
    <style>
    .gallery-images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
        margin-bottom: 10px;
    }
    .gallery-image-item {
        position: relative;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }
    .gallery-image-item img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        display: block;
    }
    .remove-gallery-image {
        position: absolute !important;
        top: 5px !important;
        right: 5px !important;
        background: #dc3232 !important;
        color: white !important;
        border: none !important;
        border-radius: 50% !important;
        width: 20px !important;
        height: 20px !important;
        cursor: pointer !important;
        font-size: 12px !important;
        line-height: 1 !important;
        padding: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    .remove-gallery-image:hover {
        background: #a00 !important;
    }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        var galleryFrame;
        
        // Add images to gallery
        $('#add-gallery-images').on('click', function(e) {
            e.preventDefault();
            
            if (galleryFrame) {
                galleryFrame.open();
                return;
            }
            
            galleryFrame = wp.media({
                title: 'Select Gallery Images',
                button: {
                    text: 'Add to Gallery'
                },
                multiple: true,
                library: {
                    type: 'image'
                }
            });
            
            galleryFrame.on('select', function() {
                var selection = galleryFrame.state().get('selection');
                var container = $('#gallery-images-container');
                
                selection.map(function(attachment) {
                    attachment = attachment.toJSON();
                    var imageHtml = '<div class="gallery-image-item" data-attachment-id="' + attachment.id + '">' +
                        '<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" alt="" style="max-width: 150px; height: 100px; object-fit: cover;">' +
                        '<button type="button" class="remove-gallery-image" style="position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer;">×</button>' +
                        '<input type="hidden" name="event_offer_gallery[]" value="' + attachment.id + '">' +
                        '</div>';
                    container.append(imageHtml);
                });
            });
            
            galleryFrame.open();
        });
        
        // Remove image from gallery
        $(document).on('click', '.remove-gallery-image', function(e) {
            e.preventDefault();
            $(this).closest('.gallery-image-item').remove();
        });
    });
    </script>
    <?php
}

function save_event_offer_details($post_id) {
    if (!isset($_POST['event_offer_details_nonce']) || !wp_verify_nonce($_POST['event_offer_details_nonce'], 'save_event_offer_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['event_offer_short_description'])) {
        update_post_meta($post_id, '_event_offer_short_description', sanitize_text_field($_POST['event_offer_short_description']));
    }

    if (isset($_POST['event_offer_type'])) {
        update_post_meta($post_id, '_event_offer_type', sanitize_text_field($_POST['event_offer_type']));
    }

    if (isset($_POST['event_offer_date'])) {
        update_post_meta($post_id, '_event_offer_date', sanitize_text_field($_POST['event_offer_date']));
    }

    if (isset($_POST['event_offer_end_date'])) {
        update_post_meta($post_id, '_event_offer_end_date', sanitize_text_field($_POST['event_offer_end_date']));
    }

    if (isset($_POST['event_offer_location'])) {
        update_post_meta($post_id, '_event_offer_location', sanitize_text_field($_POST['event_offer_location']));
    }

    if (isset($_POST['event_offer_location_description'])) {
        update_post_meta($post_id, '_event_offer_location_description', sanitize_textarea_field($_POST['event_offer_location_description']));
    }

    if (isset($_POST['event_offer_additional_info'])) {
        update_post_meta($post_id, '_event_offer_additional_info', wp_kses_post($_POST['event_offer_additional_info']));
    }

    if (isset($_POST['event_offer_booking_link'])) {
        update_post_meta($post_id, '_event_offer_booking_link', esc_url_raw($_POST['event_offer_booking_link']));
    }

    $featured_carousel = isset($_POST['event_offer_featured_in_carousel']) ? 1 : 0;
    update_post_meta($post_id, '_event_offer_featured_in_carousel', $featured_carousel);

    $featured_archive = isset($_POST['event_offer_featured_in_archive']) ? 1 : 0;
    update_post_meta($post_id, '_event_offer_featured_in_archive', $featured_archive);
}
add_action('save_post', 'save_event_offer_details');

function save_event_offer_gallery($post_id) {
    if (!isset($_POST['event_offer_gallery_nonce']) || !wp_verify_nonce($_POST['event_offer_gallery_nonce'], 'save_event_offer_gallery')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save gallery images
    if (isset($_POST['event_offer_gallery']) && is_array($_POST['event_offer_gallery'])) {
        $gallery_images = array_map('intval', $_POST['event_offer_gallery']);
        update_post_meta($post_id, '_event_offer_gallery', $gallery_images);
    } else {
        delete_post_meta($post_id, '_event_offer_gallery');
    }
}
add_action('save_post', 'save_event_offer_gallery');

function enqueue_single_event_offer_gallery_script() {
    if (is_singular('event_offer')) {
        wp_enqueue_script(
            'single-event-offer-gallery',
            get_template_directory_uri() . '/assets/js/single-event-offer-gallery.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_single_event_offer_gallery_script');

function load_media_scripts_for_event_offers($hook) {
    global $post_type;
    
    if ($hook == 'post.php' || $hook == 'post-new.php') {
        if ($post_type == 'event_offer') {
            wp_enqueue_media();
            wp_enqueue_script('jquery');
        }
    }
}
add_action('admin_enqueue_scripts', 'load_media_scripts_for_event_offers');

function get_featured_events_offers($limit = -1) {
    $args = array(
        'post_type' => 'event_offer',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_event_offer_featured_in_carousel',
                'value' => '1',
                'compare' => '='
            )
        ),
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    
    return new WP_Query($args);
}

/**
 * Get all events and offers (for archive page)
 */
function get_all_events_offers() {
    $args = array(
        'post_type' => 'event_offer',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_event_offer_featured_in_archive',
                'value' => '1',
                'compare' => '='
            )
        ),
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    
    return new WP_Query($args);
}

/**
 * Add custom columns to events and offers admin list
 */
function set_custom_event_offer_columns($columns) {
    $columns['featured_carousel'] = __('Featured in Carousel', 'nirup-island');
    $columns['featured_archive'] = __('Featured in Archive', 'nirup-island');
    $columns['type'] = __('Type', 'nirup-island');
    $columns['event_date'] = __('Date', 'nirup-island');
    $columns['short_desc'] = __('Short Description', 'nirup-island');
    return $columns;
}
add_filter('manage_event_offer_posts_columns', 'set_custom_event_offer_columns');

function custom_event_offer_column($column, $post_id) {
    switch ($column) {
        case 'featured_carousel':
            $featured = get_post_meta($post_id, '_event_offer_featured_in_carousel', true);
            echo $featured ? '<span style="color: green; font-weight: bold;">✓ Yes</span>' : '<span style="color: #888;">No</span>';
            break;
        case 'featured_archive':
            $featured = get_post_meta($post_id, '_event_offer_featured_in_archive', true);
            echo $featured ? '<span style="color: green; font-weight: bold;">✓ Yes</span>' : '<span style="color: #888;">No</span>';
            break;
        case 'type':
            $type = get_post_meta($post_id, '_event_offer_type', true);
            $color = $type === 'event' ? '#0073aa' : '#d63638';
            echo $type ? '<span style="background: ' . $color . '; color: white; padding: 2px 6px; border-radius: 3px; font-size: 11px;">' . ucfirst($type) . '</span>' : '<span style="background: #ddd; color: #555; padding: 2px 6px; border-radius: 3px; font-size: 11px;">Event</span>';
            break;
        case 'event_date':
            $start_date = get_post_meta($post_id, '_event_offer_date', true);
            $end_date = get_post_meta($post_id, '_event_offer_end_date', true);
            if ($start_date) {
                $formatted_start = date('M j, Y', strtotime($start_date));
                if ($end_date) {
                    $formatted_end = date('M j, Y', strtotime($end_date));
                    echo $formatted_start . ' - ' . $formatted_end;
                } else {
                    echo $formatted_start;
                }
            } else {
                echo '-';
            }
            break;
        case 'short_desc':
            $desc = get_post_meta($post_id, '_event_offer_short_description', true);
            echo $desc ? '<em>' . esc_html(wp_trim_words($desc, 8)) . '</em>' : '<span style="color: #888;">No description</span>';
            break;
    }
}
add_action('manage_event_offer_posts_custom_column', 'custom_event_offer_column', 10, 2);

/**
 * Events and Offers Archive Customizer Options
 */
function nirup_events_offers_archive_customizer($wp_customize) {
    // Events & Offers Archive Section
    $wp_customize->add_section('nirup_events_offers_archive', array(
        'title' => __('Events & Offers Archive Page', 'nirup-island'),
        'priority' => 42,
        'description' => __('Customize the events and offers archive page content', 'nirup-island'),
    ));

    // Archive Title
    $wp_customize->add_setting('nirup_events_offers_archive_title', array(
        'default' => __('Events & Offers', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_events_offers_archive_title', array(
        'label' => __('Archive Page Title', 'nirup-island'),
        'section' => 'nirup_events_offers_archive',
        'type' => 'text',
    ));

    // Archive Subtitle
    $wp_customize->add_setting('nirup_events_offers_archive_subtitle', array(
        'default' => __('Discover special events and exclusive offers that make your island experience even more memorable', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_events_offers_archive_subtitle', array(
        'label' => __('Archive Page Subtitle', 'nirup-island'),
        'section' => 'nirup_events_offers_archive',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'nirup_events_offers_archive_customizer');

function nirup_flush_rewrite_rules_on_activation() {
    register_events_offers_post_type();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'nirup_flush_rewrite_rules_on_activation');

function nirup_events_offers_carousel_customizer($wp_customize) {
    // Events & Offers Carousel Section
    $wp_customize->add_section('nirup_events_offers_carousel', array(
        'title' => __('Events & Offers Carousel', 'nirup-island'),
        'priority' => 40,
        'description' => __('Customize the events and offers carousel section on the homepage', 'nirup-island'),
    ));

    // Carousel Subtitle
    $wp_customize->add_setting('nirup_events_offers_subtitle', array(
        'default' => __('Events & Offers', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_events_offers_subtitle', array(
        'label' => __('Carousel Subtitle', 'nirup-island'),
        'section' => 'nirup_events_offers_carousel',
        'type' => 'text',
        'description' => __('Leave empty to hide the subtitle completely.', 'nirup-island'),
    ));

    // Carousel Title
    $wp_customize->add_setting('nirup_events_offers_title', array(
        'default' => __('Discover Special Moments', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_events_offers_title', array(
        'label' => __('Carousel Title', 'nirup-island'),
        'section' => 'nirup_events_offers_carousel',
        'type' => 'text',
        'description' => __('Leave empty to hide the title completely.', 'nirup-island'),
    ));
}
add_action('customize_register', 'nirup_events_offers_carousel_customizer');

/**
 * Experiences Carousel Customizer Options
 */
function nirup_experiences_carousel_customizer($wp_customize) {
    // Experiences Carousel Section
    $wp_customize->add_section('nirup_experiences_carousel', array(
        'title' => __('Experiences Carousel', 'nirup-island'),
        'priority' => 34,
        'description' => __('Customize the experiences carousel section on the homepage', 'nirup-island'),
    ));

    // Carousel Subtitle
    $wp_customize->add_setting('nirup_experiences_subtitle', array(
        'default' => __('Experiences', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_experiences_subtitle', array(
        'label' => __('Carousel Subtitle', 'nirup-island'),
        'section' => 'nirup_experiences_carousel',
        'type' => 'text',
        'description' => __('Leave empty to hide the subtitle completely.', 'nirup-island'),
    ));

    // Carousel Title
    $wp_customize->add_setting('nirup_experiences_title', array(
        'default' => __('Live the Island Lifestyle', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_experiences_title', array(
        'label' => __('Carousel Title', 'nirup-island'),
        'section' => 'nirup_experiences_carousel',
        'type' => 'text',
        'description' => __('Leave empty to hide the title completely.', 'nirup-island'),
    ));
}
add_action('customize_register', 'nirup_experiences_carousel_customizer');

function nirup_footer_customizer($wp_customize) {
    // Footer Section
    $wp_customize->add_section('nirup_footer_settings', array(
        'title' => __('Footer Settings', 'nirup-island'),
        'priority' => 50,
        'description' => __('Customize footer content, social media links, and contact information', 'nirup-island'),
    ));

    // === SOCIAL MEDIA SETTINGS ===
    
    // YouTube URL
    $wp_customize->add_setting('nirup_social_youtube', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_social_youtube', array(
        'label' => __('YouTube URL', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'url',
        'description' => __('Enter your YouTube channel URL. Leave empty to hide the icon.', 'nirup-island'),
    ));

    // Instagram URL
    $wp_customize->add_setting('nirup_social_instagram', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_social_instagram', array(
        'label' => __('Instagram URL', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'url',
        'description' => __('Enter your Instagram profile URL. Leave empty to hide the icon.', 'nirup-island'),
    ));

    // TikTok URL
    $wp_customize->add_setting('nirup_social_tiktok', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_social_tiktok', array(
        'label' => __('TikTok URL', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'url',
        'description' => __('Enter your TikTok profile URL. Leave empty to hide the icon.', 'nirup-island'),
    ));

    // Facebook URL
    $wp_customize->add_setting('nirup_social_facebook', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_social_facebook', array(
        'label' => __('Facebook URL', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'url',
        'description' => __('Enter your Facebook profile URL. Leave empty to hide the icon.', 'nirup-island'),
    ));

    // TripAdvisor URL
    $wp_customize->add_setting('nirup_social_tripadvisor', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_social_tripadvisor', array(
        'label' => __('TripAdvisor URL', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'url',
        'description' => __('Enter your TripAdvisor listing URL. Leave empty to hide the icon.', 'nirup-island'),
    ));

    // === CONTACT INFORMATION SETTINGS ===

    // Contact Email
    $wp_customize->add_setting('nirup_contact_email', array(
        'default' => 'info@nirupisland.com',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('nirup_contact_email', array(
        'label' => __('Contact Email', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'email',
        'description' => __('Main contact email address displayed in the footer', 'nirup-island'),
    ));

    // Primary Phone Number
    $wp_customize->add_setting('nirup_contact_phone_primary', array(
        'default' => '+62 811 6220 999',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_contact_phone_primary', array(
        'label' => __('Primary Phone Number', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'text',
        'description' => __('Main phone number for contact', 'nirup-island'),
    ));

    // Hotel Direct Phone Number
    $wp_customize->add_setting('nirup_contact_phone_direct', array(
        'default' => '+62 778 210 8899',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_contact_phone_direct', array(
        'label' => __('Hotel Direct Phone Number', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'text',
        'description' => __('Direct hotel phone number', 'nirup-island'),
    ));

    // Contact Address
    $wp_customize->add_setting('nirup_contact_address', array(
        'default' => 'Nirup Island, Sekanak Raya, Belakang Padang, Batam, Riau Islands, Indonesia, 29416',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('nirup_contact_address', array(
        'label' => __('Contact Address', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'textarea',
        'description' => __('Full address displayed in the footer', 'nirup-island'),
    ));

    // === BREVO NEWSLETTER SETTINGS ===

        // === reCAPTCHA v3 SETTINGS ===

    // Site Key
    $wp_customize->add_setting('nirup_recaptcha_site_key', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'capability'        => 'manage_options',
    ));
    $wp_customize->add_control('nirup_recaptcha_site_key', array(
        'label'       => __('reCAPTCHA v3 Site Key', 'nirup-island'),
        'section'     => 'nirup_footer_settings',
        'type'        => 'text',
        'description' => __('From Google reCAPTCHA Admin Console. Add all domains (localhost, staging, production).', 'nirup-island'),
    ));

    // Secret Key
    $wp_customize->add_setting('nirup_recaptcha_secret', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'capability'        => 'manage_options',
    ));
    $wp_customize->add_control('nirup_recaptcha_secret', array(
        'label'       => __('reCAPTCHA v3 Secret Key', 'nirup-island'),
        'section'     => 'nirup_footer_settings',
        'type'        => 'text', // change to 'password' if you prefer hidden input
        'description' => __('Server-side secret used to verify tokens. For best security, you can define RECAPTCHA_SECRET in wp-config.php.', 'nirup-island'),
    ));

    // (Optional) tighten Brevo List ID sanitization to integer
    $wp_customize->add_setting('nirup_brevo_list_id', array(
        'default'           => '6',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('nirup_brevo_list_id', array(
        'label'       => __('Brevo List ID', 'nirup-island'),
        'section'     => 'nirup_footer_settings',
        'type'        => 'number',
        'input_attrs' => array('min' => 1, 'step' => 1),
        'description' => __('Numeric List ID (e.g., 6).', 'nirup-island'),
    ));


    // Brevo API Key
    $wp_customize->add_setting('nirup_brevo_api_key', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_brevo_api_key', array(
        'label' => __('Brevo API Key', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'text',
        'description' => __('Enter your Brevo (Sendinblue) API key for newsletter integration', 'nirup-island'),
    ));

}
add_action('customize_register', 'nirup_footer_customizer');

function nirup_handle_newsletter_subscription() {
    // Check nonce for security
    if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'newsletter_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed'), 403);
    }

    $email = sanitize_email($_POST['email'] ?? '');
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'), 400);
    }


    $brevo_api_key     = nirup_get_secret('BREVO_API_KEY',     'nirup_brevo_api_key',     '');
    $brevo_list_id     = (int) nirup_get_secret('BREVO_LIST_ID','nirup_brevo_list_id',     6);


    $recaptcha_secret = nirup_get_secret('RECAPTCHA_SECRET', 'nirup_recaptcha_secret', '');
    $recaptcha_token  = sanitize_text_field($_POST['recaptcha_token'] ?? '');

    // If no secret is configured, skip (keeps current behavior intact)
    if (!empty($recaptcha_secret)) {
    $verify = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
        'body' => [
        'secret'   => $recaptcha_secret,
        'response' => $recaptcha_token,
        'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
        ],
        'timeout' => 10,
    ]);

    if (is_wp_error($verify)) {
        wp_send_json_error(['message' => 'Captcha verification failed. Please try again.'], 400);
    }

    $vbody = json_decode(wp_remote_retrieve_body($verify), true);
    $score = isset($vbody['score']) ? (float) $vbody['score'] : 0;
    $ok    = !empty($vbody['success']) && $score >= 0.5;

    if (!$ok) {
        // OPTIONAL: lower threshold slightly if needed (e.g., 0.3)
        // if (!empty($vbody['success']) && $score >= 0.3) { $ok = true; }

        // Fail fast on captcha only (do not touch Brevo/local logic)
        wp_send_json_error(['message' => 'Captcha failed. Please try again.'], 400);
    }
    } else {
    // No secret present → keep current working flow
    error_log('reCAPTCHA secret not set; skipping verification.');
    }


    // ---- Brevo upsert (uses $brevo_api_key and $brevo_list_id) ----
    error_log('Newsletter subscription attempt for: ' . $email);
    error_log('Brevo API Key configured: ' . (!empty($brevo_api_key) ? 'Yes' : 'No'));
    error_log('Brevo List ID configured: ' . (!empty($brevo_list_id) ? $brevo_list_id : 'No'));

    $brevo_success = false;
    $brevo_error_message = '';

    if (!empty($brevo_api_key) && !empty($brevo_list_id)) {
        $data = array(
            'email'         => $email,
            'listIds'       => array($brevo_list_id),
            'updateEnabled' => true,
        );

        error_log('Sending to Brevo API with list ID: ' . intval($brevo_list_id));

        $response = wp_remote_post('https://api.brevo.com/v3/contacts', array(
            'headers' => array(
                'api-key'      => $brevo_api_key,
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ),
            'body'    => wp_json_encode($data),
            'timeout' => 15,
        ));

        if (is_wp_error($response)) {
            $brevo_error_message = $response->get_error_message();
            error_log('Brevo API WP_Error: ' . $brevo_error_message);
        } else {
            $response_code     = wp_remote_retrieve_response_code($response);
            $response_body_raw = wp_remote_retrieve_body($response);
            $response_body     = json_decode($response_body_raw, true);

            error_log('Brevo API Response Code: ' . $response_code);
            error_log('Brevo API Response Body: ' . $response_body_raw);

            if ($response_code === 201 || $response_code === 204) {
                $brevo_success = true;
                error_log('Brevo subscription successful for: ' . $email);
            } else {
                $brevo_error_message = $response_body['message'] ?? 'Unknown error';
                error_log('Brevo API Error (Code ' . $response_code . '): ' . $brevo_error_message);
                if (isset($response_body['code'])) {
                    error_log('Brevo Error Code: ' . $response_body['code']);
                }
            }
        }
    } else {
        error_log('Brevo integration skipped - credentials not configured');
    }

    // Local backup store (unchanged)
    $subscribers = get_option('nirup_newsletter_subscribers', array());
    $already_subscribed = in_array($email, $subscribers, true);
    if (!$already_subscribed) {
        $subscribers[] = $email;
        update_option('nirup_newsletter_subscribers', $subscribers);
        error_log('Email saved to local database: ' . $email);
    } else {
        error_log('Email already in local database: ' . $email);
    }

    // Response
    if ($brevo_success) {
        wp_send_json_success(array('message' => 'Thank you for subscribing to our newsletter!'));
    } elseif (!empty($brevo_api_key) && !empty($brevo_list_id)) {
        wp_send_json_error(array('message' => 'There was an issue subscribing you. Please try again later.'));
    } elseif ($already_subscribed) {
        wp_send_json_error(array('message' => 'You are already subscribed.'));
    } else {
        wp_send_json_success(array('message' => 'Thank you for subscribing!'));
    }
}
// AJAX: logged-out users
add_action('wp_ajax_nopriv_nirup_newsletter_subscribe', 'nirup_handle_newsletter_subscription');
// AJAX: logged-in users
add_action('wp_ajax_nirup_newsletter_subscribe',        'nirup_handle_newsletter_subscription');



function nirup_sustainability_customizer($wp_customize) {
    
    // Add Sustainability Page Section
    $wp_customize->add_section('nirup_sustainability_page', array(
        'title'    => __('Sustainability Page', 'nirup-island'),
        'priority' => 40,
        'description' => __('Customize the sustainability page content and images', 'nirup-island'),
    ));

    // Hero Section Settings
    // Hero Subtitle
    $wp_customize->add_setting('nirup_sustainability_hero_subtitle', array(
        'default'           => __('Balancing comfort with care for the planet', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('nirup_sustainability_hero_subtitle', array(
        'label'    => __('Hero Subtitle', 'nirup-island'),
        'section'  => 'nirup_sustainability_page',
        'type'     => 'text',
        'priority' => 10,
    ));

    // Hero Title
    $wp_customize->add_setting('nirup_sustainability_hero_title', array(
        'default'           => __('Sustainability', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('nirup_sustainability_hero_title', array(
        'label'    => __('Hero Title', 'nirup-island'),
        'section'  => 'nirup_sustainability_page',
        'type'     => 'text',
        'priority' => 20,
    ));

    // Description Text
    $wp_customize->add_setting('nirup_sustainability_description', array(
        'default'           => __('Nirup Island has been designed with sustainability at its core. Every aspect of the resort — from building design to energy, water, and community engagement — is crafted to harmonize with nature while offering a refined guest experience.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('nirup_sustainability_description', array(
        'label'       => __('Description Text', 'nirup-island'),
        'description' => __('Paragraph text below the hero title', 'nirup-island'),
        'section'     => 'nirup_sustainability_page',
        'type'        => 'textarea',
        'priority'    => 30,
    ));

    // Gallery Images
    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("nirup_sustainability_gallery_image_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'absint',
            'transport'         => 'refresh',
        ));

        $description = '';
        if ($i === 1) {
            $description = __('Large gallery image (left side)', 'nirup-island');
        } elseif ($i === 2) {
            $description = __('Top right gallery image', 'nirup-island');
        } elseif ($i === 3) {
            $description = __('Bottom left small gallery image', 'nirup-island');
        } else {
            $description = __('Bottom right small gallery image', 'nirup-island');
        }

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "nirup_sustainability_gallery_image_{$i}", array(
            'label'       => sprintf(__('Gallery Image %d', 'nirup-island'), $i),
            'description' => $description,
            'section'     => 'nirup_sustainability_page',
            'mime_type'   => 'image',
            'priority'    => 30 + $i,
        )));
    }

    // Practices Section Title
    $wp_customize->add_setting('nirup_sustainability_practices_title', array(
        'default'           => __('Key Sustainability Practices', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('nirup_sustainability_practices_title', array(
        'label'    => __('Practices Section Title', 'nirup-island'),
        'section'  => 'nirup_sustainability_page',
        'type'     => 'text',
        'priority' => 50,
    ));

    // Practice Items (8 practices with exact content)
    $default_practices = array(
        1 => array(
            'title' => 'Building Design',
            'desc1' => 'Passive cooling & natural airflow',
            'desc2' => 'Energy-efficient architecture'
        ),
        2 => array(
            'title' => 'Renewable Energy',
            'desc1' => '1 MW solar panels',
            'desc2' => 'Reducing fossil fuel reliance'
        ),
        3 => array(
            'title' => 'Water Conservation',
            'desc1' => '20,000 m³ rainwater reservoir',
            'desc2' => 'Recycling & efficient fixtures'
        ),
        4 => array(
            'title' => 'Waste Management',
            'desc1' => 'Recycling & composting',
            'desc2' => 'Food scraps into fertilizer'
        ),
        5 => array(
            'title' => 'Green Landscaping',
            'desc1' => 'Native, drought-resistant plants',
            'desc2' => 'Low-maintenance greenery'
        ),
        6 => array(
            'title' => 'Sustainable Transportation',
            'desc1' => 'Electric buggies on island',
            'desc2' => 'Bicycles for eco-exploration'
        ),
        7 => array(
            'title' => 'Environmental Education',
            'desc1' => 'Water refill stations',
            'desc2' => 'Guest eco-awareness programs'
        ),
        8 => array(
            'title' => 'Local Sourcing & Community',
            'desc1' => 'Local ingredients & materials',
            'desc2' => 'Jobs for nearby communities'
        ),
    );

    for ($i = 1; $i <= 8; $i++) {
        // Practice Title
        $wp_customize->add_setting("nirup_sustainability_practice_{$i}_title", array(
            'default'           => isset($default_practices[$i]) ? $default_practices[$i]['title'] : '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ));

        $wp_customize->add_control("nirup_sustainability_practice_{$i}_title", array(
            'label'    => sprintf(__('Practice %d Title', 'nirup-island'), $i),
            'section'  => 'nirup_sustainability_page',
            'type'     => 'text',
            'priority' => 50 + ($i * 3) - 2,
        ));

        // Practice Description 1
        $wp_customize->add_setting("nirup_sustainability_practice_{$i}_desc1", array(
            'default'           => isset($default_practices[$i]) ? $default_practices[$i]['desc1'] : '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ));

        $wp_customize->add_control("nirup_sustainability_practice_{$i}_desc1", array(
            'label'    => sprintf(__('Practice %d Description 1', 'nirup-island'), $i),
            'section'  => 'nirup_sustainability_page',
            'type'     => 'text',
            'priority' => 50 + ($i * 3) - 1,
        ));

        // Practice Description 2
        $wp_customize->add_setting("nirup_sustainability_practice_{$i}_desc2", array(
            'default'           => isset($default_practices[$i]) ? $default_practices[$i]['desc2'] : '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ));

        $wp_customize->add_control("nirup_sustainability_practice_{$i}_desc2", array(
            'label'    => sprintf(__('Practice %d Description 2', 'nirup-island'), $i),
            'section'  => 'nirup_sustainability_page',
            'type'     => 'text',
            'priority' => 50 + ($i * 3),
        ));
    }
}
add_action('customize_register', 'nirup_sustainability_customizer');

function nirup_sustainability_styles() {
    if (is_page_template('page-sustainability.php')) {
        wp_enqueue_style(
            'nirup-sustainability-styles',
            get_template_directory_uri() . '/assets/css/sustainability.css',
            array(),
            '1.0.0'
        );
        
        // Ensure breadcrumbs CSS is loaded
        wp_enqueue_style(
            'nirup-breadcrumbs',
            get_template_directory_uri() . '/assets/css/breadcrumbs.css',
            array(),
            '1.0.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'nirup_sustainability_styles');

/**
 * Customizer Live Preview for Sustainability Page
 */
function nirup_sustainability_customize_preview_js() {
    wp_enqueue_script(
        'nirup-sustainability-customize-preview',
        get_template_directory_uri() . '/assets/js/customize-preview-sustainability.js',
        array('customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'nirup_sustainability_customize_preview_js');

function nirup_enqueue_single_experience_css() {
    if (is_singular('experience')) {
        global $post;
        $experience_type = get_post_meta($post->ID, '_experience_type', true);
        
        if ($experience_type === 'single') {
            wp_enqueue_style(
                'nirup-single-experience', 
                get_template_directory_uri() . '/assets/css/experience-single.css', 
                array('nirup-main'), 
                '1.0.0'
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_single_experience_css');

// Register Restaurant Custom Post Type
function nirup_register_restaurant_post_type() {
    $labels = array(
        'name'                  => _x('Restaurants', 'Post type general name', 'nirup-island'),
        'singular_name'         => _x('Restaurant', 'Post type singular name', 'nirup-island'),
        'menu_name'             => _x('Restaurants', 'Admin Menu text', 'nirup-island'),
        'name_admin_bar'        => _x('Restaurant', 'Add New on Toolbar', 'nirup-island'),
        'add_new'               => __('Add New', 'nirup-island'),
        'add_new_item'          => __('Add New Restaurant', 'nirup-island'),
        'new_item'              => __('New Restaurant', 'nirup-island'),
        'edit_item'             => __('Edit Restaurant', 'nirup-island'),
        'view_item'             => __('View Restaurant', 'nirup-island'),
        'all_items'             => __('All Restaurants', 'nirup-island'),
        'search_items'          => __('Search Restaurants', 'nirup-island'),
        'parent_item_colon'     => __('Parent Restaurants:', 'nirup-island'),
        'not_found'             => __('No restaurants found.', 'nirup-island'),
        'not_found_in_trash'    => __('No restaurants found in Trash.', 'nirup-island'),
        'featured_image'        => _x('Restaurant Main Image', 'Overrides the "Featured Image" phrase', 'nirup-island'),
        'set_featured_image'    => _x('Set restaurant main image', 'Overrides the "Set featured image" phrase', 'nirup-island'),
        'remove_featured_image' => _x('Remove restaurant main image', 'Overrides the "Remove featured image" phrase', 'nirup-island'),
        'use_featured_image'    => _x('Use as restaurant main image', 'Overrides the "Use as featured image" phrase', 'nirup-island'),
        'archives'              => _x('Restaurant archives', 'The post type archive label', 'nirup-island'),
        'insert_into_item'      => _x('Insert into restaurant', 'Overrides the "Insert into post" phrase', 'nirup-island'),
        'uploaded_to_this_item' => _x('Uploaded to this restaurant', 'Overrides the "Uploaded to this post" phrase', 'nirup-island'),
        'filter_items_list'     => _x('Filter restaurants list', 'Screen reader text for the filter links', 'nirup-island'),
        'items_list_navigation' => _x('Restaurants list navigation', 'Screen reader text for the pagination', 'nirup-island'),
        'items_list'            => _x('Restaurants list', 'Screen reader text for the items list', 'nirup-island'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'restaurant'),
        'capability_type'    => 'post',
        'has_archive'        => 'dining',
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-food',
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        'show_in_rest'       => true,
    );

    register_post_type('restaurant', $args);
}
add_action('init', 'nirup_register_restaurant_post_type');

// Restaurant Meta Boxes
function nirup_add_restaurant_meta_boxes() {
    add_meta_box(
        'restaurant-archive-card-info',
        __('📋 Archive Card Information', 'nirup-island'),
        'nirup_restaurant_archive_card_callback',
        'restaurant',
        'normal',
        'high'
    );
    
    add_meta_box(
        'restaurant-single-page-info',
        __('📄 Single Page Information', 'nirup-island'),
        'nirup_restaurant_single_page_callback',
        'restaurant',
        'normal',
        'high'
    );
    
    add_meta_box(
        'restaurant-gallery',
        __('🖼️ Restaurant Gallery', 'nirup-island'),
        'nirup_restaurant_gallery_callback',
        'restaurant',
        'normal',
        'default'
    );
    
    add_meta_box(
        'restaurant-archive-settings',
        __('⚙️ Archive Display Settings', 'nirup-island'),
        'nirup_restaurant_archive_settings_callback',
        'restaurant',
        'side'
    );
}
add_action('add_meta_boxes', 'nirup_add_restaurant_meta_boxes');


// Restaurant Details Meta Box Callback
function nirup_restaurant_details_callback($post) {
    wp_nonce_field('nirup_restaurant_details', 'nirup_restaurant_details_nonce');
    
    $restaurant_category = get_post_meta($post->ID, '_restaurant_category', true);
    $short_description = get_post_meta($post->ID, '_restaurant_short_description', true);
    $operating_hours = get_post_meta($post->ID, '_restaurant_operating_hours', true);
    $additional_info = get_post_meta($post->ID, '_restaurant_additional_info', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="restaurant_category"><?php _e('Category', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="restaurant_category" name="restaurant_category" value="<?php echo esc_attr($restaurant_category); ?>" class="regular-text" />
                <p class="description"><?php _e('e.g., "All-day Dining / Multiple Cuisines"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_short_description"><?php _e('Short Description', 'nirup-island'); ?></label></th>
            <td>
                <textarea id="restaurant_short_description" name="restaurant_short_description" rows="3" class="large-text"><?php echo esc_textarea($short_description); ?></textarea>
                <p class="description"><?php _e('Brief description shown on archive cards.', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_operating_hours"><?php _e('Operating Hours', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="restaurant_operating_hours" name="restaurant_operating_hours" value="<?php echo esc_attr($operating_hours); ?>" class="regular-text" />
                <p class="description"><?php _e('e.g., "Open daily: 6:00 AM – 10:30 PM"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_additional_info"><?php _e('Additional Information', 'nirup-island'); ?></label></th>
            <td>
                <textarea id="restaurant_additional_info" name="restaurant_additional_info" rows="3" class="large-text"><?php echo esc_textarea($additional_info); ?></textarea>
                <p class="description"><?php _e('Any additional details about the restaurant.', 'nirup-island'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

function nirup_restaurant_archive_card_callback($post) {
    wp_nonce_field('nirup_restaurant_card_info', 'nirup_restaurant_card_info_nonce');
    
    $card_category = get_post_meta($post->ID, '_restaurant_card_category', true);
    $card_short_description = get_post_meta($post->ID, '_restaurant_card_short_description', true);
    $card_operating_hours = get_post_meta($post->ID, '_restaurant_card_operating_hours', true);
    ?>
    <p><strong>⚠️ These fields are used ONLY for the restaurant cards on the dining archive page.</strong></p>
    <table class="form-table">
        <tr>
            <th><label for="restaurant_card_category"><?php _e('Category (for card)', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="restaurant_card_category" name="restaurant_card_category" value="<?php echo esc_attr($card_category); ?>" class="regular-text" />
                <p class="description"><?php _e('e.g., "Seafood Specialty Restaurant" - shown on archive cards only', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_card_short_description"><?php _e('Short Description (for card)', 'nirup-island'); ?></label></th>
            <td>
                <textarea id="restaurant_card_short_description" name="restaurant_card_short_description" rows="3" class="large-text"><?php echo esc_textarea($card_short_description); ?></textarea>
                <p class="description"><?php _e('Brief description shown on archive cards only.', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_card_operating_hours"><?php _e('Operating Hours (for card)', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="restaurant_card_operating_hours" name="restaurant_card_operating_hours" value="<?php echo esc_attr($card_operating_hours); ?>" class="large-text" />
                <p class="description"><?php _e('e.g., "Open daily: 6:00 AM – 10:30 PM" - shown on archive cards only', 'nirup-island'); ?></p>
            </td>
        </tr>
    </table>
    <p><em>Note: The featured image is also used for the archive cards.</em></p>
    <?php
}

function nirup_restaurant_single_page_callback($post) {
    wp_nonce_field('nirup_restaurant_page_info', 'nirup_restaurant_page_info_nonce');
    
    $page_subtitle = get_post_meta($post->ID, '_restaurant_page_subtitle', true);
    $page_category_title = get_post_meta($post->ID, '_restaurant_page_category_title', true);
    $page_cuisine_type = get_post_meta($post->ID, '_restaurant_page_cuisine_type', true);
    $page_operating_hours = get_post_meta($post->ID, '_restaurant_page_operating_hours', true);
    $page_menu_pdf = get_post_meta($post->ID, '_restaurant_menu_pdf', true);
    ?>
    <p><strong>ℹ️ These fields are used ONLY for the individual restaurant page.</strong></p>
    <table class="form-table">
        <tr>
            <th><label for="restaurant_page_subtitle"><?php _e('Page Subtitle', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="restaurant_page_subtitle" name="restaurant_page_subtitle" value="<?php echo esc_attr($page_subtitle); ?>" class="large-text" />
                <p class="description"><?php _e('e.g., "Fresh from the Ocean, Served with Elegance" - shown under main title on single page', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_page_category_title"><?php _e('Category Title (for single page)', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="restaurant_page_category_title" name="restaurant_page_category_title" value="<?php echo esc_attr($page_category_title); ?>" class="regular-text" />
                <p class="description"><?php _e('e.g., "Seafood Specialty Restaurant" - shown as section title on single page', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_page_cuisine_type"><?php _e('Cuisine Type (sidebar)', 'nirup-island'); ?></label></th>
            <td>
                <textarea id="restaurant_page_cuisine_type" name="restaurant_page_cuisine_type" rows="2" class="regular-text"><?php echo esc_textarea($page_cuisine_type); ?></textarea>
                <p class="description"><?php _e('e.g., "Seafood Specialty, Farm-to-Table Concept" - shown in sidebar', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_page_operating_hours"><?php _e('Operating Hours (sidebar)', 'nirup-island'); ?></label></th>
            <td>
                <textarea id="restaurant_page_operating_hours" name="restaurant_page_operating_hours" rows="3" class="regular-text"><?php echo esc_textarea($page_operating_hours); ?></textarea>
                <p class="description"><?php _e('e.g., "Friday – Sunday: 11:00 AM – 10:00 PM<br>Closed: Monday – Thursday" - shown in sidebar', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_menu_pdf"><?php _e('Menu PDF', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="restaurant_menu_pdf" name="restaurant_menu_pdf" value="<?php echo esc_attr($page_menu_pdf); ?>" class="regular-text" />
                <button type="button" class="button" id="upload_menu_pdf_button"><?php _e('Upload/Select PDF', 'nirup-island'); ?></button>
                <button type="button" class="button" id="remove_menu_pdf_button" <?php echo empty($page_menu_pdf) ? 'style="display:none;"' : ''; ?>><?php _e('Remove PDF', 'nirup-island'); ?></button>
                <p class="description"><?php _e('Upload a PDF file for the "Discover Menu" button. Visitors will download this file.', 'nirup-island'); ?></p>
                <?php if (!empty($page_menu_pdf)) : ?>
                    <p><a href="<?php echo esc_url($page_menu_pdf); ?>" target="_blank">View current PDF</a></p>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <p><em>Note: The main content editor above is used as the restaurant description paragraph on the single page.</em></p>
    
    <script>
    jQuery(document).ready(function($) {
        var frame;
        
        $('#upload_menu_pdf_button').on('click', function(e) {
            e.preventDefault();
            
            if (frame) {
                frame.open();
                return;
            }
            
            frame = wp.media({
                title: 'Select Menu PDF',
                multiple: false,
                library: {
                    type: 'application/pdf'
                }
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#restaurant_menu_pdf').val(attachment.url);
                $('#remove_menu_pdf_button').show();
            });
            
            frame.open();
        });
        
        $('#remove_menu_pdf_button').on('click', function(e) {
            e.preventDefault();
            $('#restaurant_menu_pdf').val('');
            $(this).hide();
        });
    });
    </script>
    <?php
}

function nirup_restaurant_gallery_callback($post) {
    wp_nonce_field('nirup_restaurant_gallery', 'nirup_restaurant_gallery_nonce');
    
    $gallery_images = get_post_meta($post->ID, '_restaurant_gallery', true);
    $gallery_images = $gallery_images ? $gallery_images : array();
    ?>
    <p><strong>🖼️ Restaurant Gallery - Upload images for the restaurant gallery (displays 5 photos with "see more" option if more are uploaded)</strong></p>
    
    <div class="restaurant-gallery-container">
        <div id="restaurant-gallery-images" class="gallery-images-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; margin-bottom: 20px;">
            <?php foreach ($gallery_images as $image_id) : ?>
                <?php $image_url = wp_get_attachment_thumb_url($image_id); ?>
                <?php if ($image_url) : ?>
                    <div class="gallery-image-item" data-attachment-id="<?php echo esc_attr($image_id); ?>" style="position: relative;">
                        <img src="<?php echo esc_url($image_url); ?>" alt="" style="width: 100%; height: 100px; object-fit: cover; border: 2px solid #ddd;">
                        <button type="button" class="remove-gallery-image" style="position: absolute; top: 5px; right: 5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px;">×</button>
                        <input type="hidden" name="restaurant_gallery[]" value="<?php echo esc_attr($image_id); ?>">
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        
        <button type="button" class="button button-primary" id="add-gallery-images"><?php _e('Add Gallery Images', 'nirup-island'); ?></button>
        <p class="description"><?php _e('The first 5 images will be displayed in the gallery layout. If more than 5 images are uploaded, a "See All Photos" button will appear.', 'nirup-island'); ?></p>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var frame;
        
        // Add images
        $('#add-gallery-images').on('click', function(e) {
            e.preventDefault();
            
            if (frame) {
                frame.open();
                return;
            }
            
            frame = wp.media({
                title: 'Select Gallery Images',
                multiple: true,
                library: {
                    type: 'image'
                }
            });
            
            frame.on('select', function() {
                var attachments = frame.state().get('selection').toJSON();
                
                attachments.forEach(function(attachment) {
                    var html = '<div class="gallery-image-item" data-attachment-id="' + attachment.id + '" style="position: relative;">' +
                               '<img src="' + attachment.sizes.thumbnail.url + '" alt="" style="width: 100%; height: 100px; object-fit: cover; border: 2px solid #ddd;">' +
                               '<button type="button" class="remove-gallery-image" style="position: absolute; top: 5px; right: 5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px;">×</button>' +
                               '<input type="hidden" name="restaurant_gallery[]" value="' + attachment.id + '">' +
                               '</div>';
                    
                    $('#restaurant-gallery-images').append(html);
                });
            });
            
            frame.open();
        });
        
        // Remove images
        $(document).on('click', '.remove-gallery-image', function(e) {
            e.preventDefault();
            $(this).closest('.gallery-image-item').remove();
        });
    });
    </script>
    <?php
}

function nirup_restaurant_archive_settings_callback($post) {
    wp_nonce_field('nirup_restaurant_archive_settings', 'nirup_restaurant_archive_settings_nonce');
    
    $featured_in_archive = get_post_meta($post->ID, '_featured_in_archive', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="featured_in_archive"><?php _e('Show in Archive', 'nirup-island'); ?></label></th>
            <td>
                <input type="checkbox" id="featured_in_archive" name="featured_in_archive" value="1" <?php checked($featured_in_archive, 1); ?> />
                <label for="featured_in_archive"><?php _e('Display this restaurant on the dining archive page', 'nirup-island'); ?></label>
            </td>
        </tr>
    </table>
    <?php
}

// Save Restaurant Meta
function nirup_save_restaurant_meta($post_id) {
    // Verify nonces
    $nonces_valid = 
        (isset($_POST['nirup_restaurant_card_info_nonce']) && wp_verify_nonce($_POST['nirup_restaurant_card_info_nonce'], 'nirup_restaurant_card_info')) ||
        (isset($_POST['nirup_restaurant_page_info_nonce']) && wp_verify_nonce($_POST['nirup_restaurant_page_info_nonce'], 'nirup_restaurant_page_info')) ||
        (isset($_POST['nirup_restaurant_gallery_nonce']) && wp_verify_nonce($_POST['nirup_restaurant_gallery_nonce'], 'nirup_restaurant_gallery')) ||
        (isset($_POST['nirup_restaurant_archive_settings_nonce']) && wp_verify_nonce($_POST['nirup_restaurant_archive_settings_nonce'], 'nirup_restaurant_archive_settings'));
    
    if (!$nonces_valid) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save archive card info
    if (isset($_POST['restaurant_card_category'])) {
        update_post_meta($post_id, '_restaurant_card_category', sanitize_text_field($_POST['restaurant_card_category']));
    }

    if (isset($_POST['restaurant_card_short_description'])) {
        update_post_meta($post_id, '_restaurant_card_short_description', sanitize_textarea_field($_POST['restaurant_card_short_description']));
    }

    if (isset($_POST['restaurant_card_operating_hours'])) {
        update_post_meta($post_id, '_restaurant_card_operating_hours', sanitize_text_field($_POST['restaurant_card_operating_hours']));
    }

    // Save single page info
    if (isset($_POST['restaurant_page_subtitle'])) {
        update_post_meta($post_id, '_restaurant_page_subtitle', sanitize_text_field($_POST['restaurant_page_subtitle']));
    }

    if (isset($_POST['restaurant_page_category_title'])) {
        update_post_meta($post_id, '_restaurant_page_category_title', sanitize_text_field($_POST['restaurant_page_category_title']));
    }

    if (isset($_POST['restaurant_page_cuisine_type'])) {
        update_post_meta($post_id, '_restaurant_page_cuisine_type', sanitize_textarea_field($_POST['restaurant_page_cuisine_type']));
    }

    if (isset($_POST['restaurant_page_operating_hours'])) {
        update_post_meta($post_id, '_restaurant_page_operating_hours', sanitize_textarea_field($_POST['restaurant_page_operating_hours']));
    }

    if (isset($_POST['restaurant_menu_pdf'])) {
        update_post_meta($post_id, '_restaurant_menu_pdf', esc_url_raw($_POST['restaurant_menu_pdf']));
    }

    // Save gallery
    if (isset($_POST['restaurant_gallery'])) {
        $gallery_images = array_map('intval', $_POST['restaurant_gallery']);
        update_post_meta($post_id, '_restaurant_gallery', $gallery_images);
    } else {
        delete_post_meta($post_id, '_restaurant_gallery');
    }

    // Save archive settings
    if (isset($_POST['nirup_restaurant_archive_settings_nonce']) && wp_verify_nonce($_POST['nirup_restaurant_archive_settings_nonce'], 'nirup_restaurant_archive_settings')) {
        $featured_in_archive = isset($_POST['featured_in_archive']) ? 1 : 0;
        update_post_meta($post_id, '_featured_in_archive', $featured_in_archive);
    }
}
add_action('save_post', 'nirup_save_restaurant_meta');

// Add Dining Archive Customizer Options
function nirup_dining_archive_customizer($wp_customize) {
    // Dining Archive Section
    $wp_customize->add_section('nirup_dining_archive', array(
        'title' => __('Dining Archive Page', 'nirup-island'),
        'priority' => 42,
        'description' => __('Customize the dining archive page content', 'nirup-island'),
    ));

    // Hero Section Settings
    $wp_customize->add_setting('dining_hero_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'dining_hero_image', array(
        'label' => __('Hero Background Image', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'settings' => 'dining_hero_image',
    )));

    $wp_customize->add_setting('dining_hero_alt', array(
        'default' => __('Dining Experience', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_hero_alt', array(
        'label' => __('Hero Image Alt Text', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_hero_subtitle', array(
        'default' => __('Welcome to our restaurants', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_hero_title', array(
        'default' => __('Savor Royal Flavors', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_hero_title', array(
        'label' => __('Hero Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    // About Section Settings
    $wp_customize->add_setting('dining_about_category', array(
        'default' => __('About the dining', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_about_category', array(
        'label' => __('About Section Category', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_about_title', array(
        'default' => __('Celebrate The Art of Dining', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_about_title', array(
        'label' => __('About Section Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_about_description', array(
        'default' => __('Step into a world where fine cuisine and refined ambiance come together. Our restaurants feature signature dishes crafted by world-class chefs, complemented by curated wine collections and exceptional service. From intimate dinners to grand celebrations, every detail is designed to create an unforgettable dining journey.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('dining_about_description', array(
        'label' => __('About Section Description', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'textarea',
    ));

    // Feature Icons Section
    // Icon 1 - Fresh Products
    $wp_customize->add_setting('dining_icon1_title', array(
        'default' => __('Fresh Products', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_icon1_title', array(
        'label' => __('Icon 1 - Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_icon1_description', array(
        'default' => __('Carefully selected ingredients from trusted suppliers.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('dining_icon1_description', array(
        'label' => __('Icon 1 - Description', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'textarea',
    ));

    // Icon 2 - Skilled Chefs
    $wp_customize->add_setting('dining_icon2_title', array(
        'default' => __('Skilled Chefs', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_icon2_title', array(
        'label' => __('Icon 2 - Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_icon2_description', array(
        'default' => __('Masters of their craft, creating culinary perfection.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('dining_icon2_description', array(
        'label' => __('Icon 2 - Description', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'textarea',
    ));

    // Icon 3 - Unique Recipes
    $wp_customize->add_setting('dining_icon3_title', array(
        'default' => __('Unique Recipes', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_icon3_title', array(
        'label' => __('Icon 3 - Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_icon3_description', array(
        'default' => __('Signature dishes you won\'t find anywhere else.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('dining_icon3_description', array(
        'label' => __('Icon 3 - Description', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'textarea',
    ));

    // Icon 4 - Premium Service
    $wp_customize->add_setting('dining_icon4_title', array(
        'default' => __('Premium Service', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_icon4_title', array(
        'label' => __('Icon 4 - Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_icon4_description', array(
        'default' => __('Attentive staff making every detail matter.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('dining_icon4_description', array(
        'label' => __('Icon 4 - Description', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'textarea',
    ));

    // Signature Experiences Section
    $wp_customize->add_setting('signature_experiences_category', array(
        'default' => __('For Connoisseurs', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('signature_experiences_category', array(
        'label' => __('Signature Experiences Category', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('signature_experiences_title', array(
        'default' => __('Signature Experience', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('signature_experiences_title', array(
        'label' => __('Signature Experiences Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

      // Toggle to show/hide signature experiences section
    $wp_customize->add_setting('show_signature_experiences', array(
        'default' => true, // Show by default
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('show_signature_experiences', array(
        'label' => __('Show Signature Experiences Section', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'checkbox',
        'description' => __('Check to display the signature experiences section on the dining page.', 'nirup-island'),
    ));

    // Existing signature experiences category setting
    $wp_customize->add_setting('signature_experiences_category', array(
        'default' => __('For Connoisseurs', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('signature_experiences_category', array(
        'label' => __('Signature Experiences Category', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    // Existing signature experiences title setting  
    $wp_customize->add_setting('signature_experiences_title', array(
        'default' => __('Signature Experience', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('signature_experiences_title', array(
        'label' => __('Signature Experiences Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));
}
add_action('customize_register', 'nirup_dining_archive_customizer');

function nirup_restaurant_admin_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key == 'title') {
            $new_columns['restaurant_card_category'] = __('Card Category', 'nirup-island');
            $new_columns['featured_archive'] = __('In Archive', 'nirup-island');
            $new_columns['gallery_count'] = __('Gallery Images', 'nirup-island');
        }
    }
    return $new_columns;
}
add_filter('manage_restaurant_posts_columns', 'nirup_restaurant_admin_columns');

function nirup_restaurant_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'restaurant_card_category':
            $category = get_post_meta($post_id, '_restaurant_card_category', true);
            echo $category ? esc_html($category) : '—';
            break;
        case 'featured_archive':
            $featured = get_post_meta($post_id, '_featured_in_archive', true);
            echo $featured ? '✓' : '—';
            break;
        case 'gallery_count':
            $gallery = get_post_meta($post_id, '_restaurant_gallery', true);
            $count = is_array($gallery) ? count($gallery) : 0;
            echo $count . ' ' . ($count === 1 ? 'image' : 'images');
            break;
    }
}
add_action('manage_restaurant_posts_custom_column', 'nirup_restaurant_admin_column_content', 10, 2);

// Register Ferry Schedule Custom Post Type
function nirup_register_ferry_schedule_post_type() {
    $labels = array(
        'name'                  => _x('Ferry Schedules', 'Post type general name', 'nirup-island'),
        'singular_name'         => _x('Ferry Schedule', 'Post type singular name', 'nirup-island'),
        'menu_name'             => _x('Ferry Schedules', 'Admin Menu text', 'nirup-island'),
        'name_admin_bar'        => _x('Ferry Schedule', 'Add New on Toolbar', 'nirup-island'),
        'add_new'               => __('Add New', 'nirup-island'),
        'add_new_item'          => __('Add New Ferry Schedule', 'nirup-island'),
        'new_item'              => __('New Ferry Schedule', 'nirup-island'),
        'edit_item'             => __('Edit Ferry Schedule', 'nirup-island'),
        'view_item'             => __('View Ferry Schedule', 'nirup-island'),
        'all_items'             => __('All Ferry Schedules', 'nirup-island'),
        'search_items'          => __('Search Ferry Schedules', 'nirup-island'),
        'not_found'             => __('No ferry schedules found.', 'nirup-island'),
        'not_found_in_trash'    => __('No ferry schedules found in Trash.', 'nirup-island'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 22,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => array('title'),
        'show_in_rest'       => true,
    );

    register_post_type('ferry_schedule', $args);
}
add_action('init', 'nirup_register_ferry_schedule_post_type');

// Ferry Schedule Meta Boxes
function nirup_add_ferry_schedule_meta_boxes() {
    add_meta_box(
        'ferry-schedule-details',
        __('⛴️ Ferry Schedule Details', 'nirup-island'),
        'nirup_ferry_schedule_details_callback',
        'ferry_schedule',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_ferry_schedule_meta_boxes');

// Ferry Schedule Details Meta Box Callback
function nirup_ferry_schedule_details_callback($post) {
    wp_nonce_field('nirup_ferry_schedule_details', 'nirup_ferry_schedule_details_nonce');

    $route_type = get_post_meta($post->ID, '_ferry_route_type', true);
    $route_from = get_post_meta($post->ID, '_ferry_route_from', true);
    $route_to = get_post_meta($post->ID, '_ferry_route_to', true);
    $etd = get_post_meta($post->ID, '_ferry_etd', true);
    $eta = get_post_meta($post->ID, '_ferry_eta', true);
    $operator = get_post_meta($post->ID, '_ferry_operator', true);
    $duration = get_post_meta($post->ID, '_ferry_duration', true);
    $price = get_post_meta($post->ID, '_ferry_price', true);
    $frequency = get_post_meta($post->ID, '_ferry_frequency', true);
    $checkin_location = get_post_meta($post->ID, '_ferry_checkin_location', true);
    $menu_order = get_post_meta($post->ID, '_ferry_menu_order', true);
    ?>
    <style>
        .ferry-schedule-table { width: 100%; border-collapse: collapse; }
        .ferry-schedule-table th { text-align: left; padding: 12px; background: #f5f5f5; width: 200px; }
        .ferry-schedule-table td { padding: 12px; }
        .ferry-schedule-table tr { border-bottom: 1px solid #ddd; }
        .ferry-schedule-table input[type="text"],
        .ferry-schedule-table select { width: 100%; max-width: 500px; }
        .ferry-schedule-table textarea { width: 100%; max-width: 500px; rows: 3; }
        .ferry-schedule-table .description { color: #666; font-size: 13px; margin-top: 5px; }
    </style>
    <table class="ferry-schedule-table">
        <tr>
            <th><label for="ferry_route_type"><?php _e('Route Type', 'nirup-island'); ?></label></th>
            <td>
                <select id="ferry_route_type" name="ferry_route_type">
                    <option value="singapore" <?php selected($route_type, 'singapore'); ?>>Singapore</option>
                    <option value="batam" <?php selected($route_type, 'batam'); ?>>Batam</option>
                </select>
                <p class="description"><?php _e('Select which route this schedule belongs to (Singapore or Batam)', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_route_from"><?php _e('Route From', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_route_from" name="ferry_route_from" value="<?php echo esc_attr($route_from); ?>" />
                <p class="description"><?php _e('e.g., "Singapore", "Nirup", "Batam"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_route_to"><?php _e('Route To', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_route_to" name="ferry_route_to" value="<?php echo esc_attr($route_to); ?>" />
                <p class="description"><?php _e('e.g., "Singapore", "Nirup", "Batam"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_etd"><?php _e('ETD (Departure Time)', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_etd" name="ferry_etd" value="<?php echo esc_attr($etd); ?>" />
                <p class="description"><?php _e('e.g., "10:30 (SGT)" or "09:45 (IDT)"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_eta"><?php _e('ETA (Arrival Time)', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_eta" name="ferry_eta" value="<?php echo esc_attr($eta); ?>" />
                <p class="description"><?php _e('e.g., "11:10 (SGT)" or "10:05 (IDT)"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_operator"><?php _e('Operator', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_operator" name="ferry_operator" value="<?php echo esc_attr($operator); ?>" />
                <p class="description"><?php _e('e.g., "Horizon Fast Ferry", "Rans Fadhila"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_duration"><?php _e('Duration', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_duration" name="ferry_duration" value="<?php echo esc_attr($duration); ?>" />
                <p class="description"><?php _e('e.g., "50 minutes", "20 minutes"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_price"><?php _e('Price', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_price" name="ferry_price" value="<?php echo esc_attr($price); ?>" />
                <p class="description"><?php _e('e.g., "SGD 76 /per way", "Rp150,000 /per way"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_frequency"><?php _e('Frequency / Days', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_frequency" name="ferry_frequency" value="<?php echo esc_attr($frequency); ?>" />
                <p class="description"><?php _e('e.g., "Daily", "Fri–Sun only"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_checkin_location"><?php _e('Check-in Location', 'nirup-island'); ?></label></th>
            <td>
                <textarea id="ferry_checkin_location" name="ferry_checkin_location" rows="2"><?php echo esc_textarea($checkin_location); ?></textarea>
                <p class="description"><?php _e('e.g., "Tanah Merah Ferry Terminal"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_menu_order"><?php _e('Display Order', 'nirup-island'); ?></label></th>
            <td>
                <input type="number" id="ferry_menu_order" name="ferry_menu_order" value="<?php echo esc_attr($menu_order ? $menu_order : 0); ?>" min="0" />
                <p class="description"><?php _e('Lower numbers appear first. Leave at 0 for default ordering.', 'nirup-island'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

// Save Ferry Schedule Meta
function nirup_save_ferry_schedule_meta($post_id) {
    // Check nonce
    if (!isset($_POST['nirup_ferry_schedule_details_nonce']) || !wp_verify_nonce($_POST['nirup_ferry_schedule_details_nonce'], 'nirup_ferry_schedule_details')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save all fields
    $fields = array(
        'ferry_route_type' => 'sanitize_text_field',
        'ferry_route_from' => 'sanitize_text_field',
        'ferry_route_to' => 'sanitize_text_field',
        'ferry_etd' => 'sanitize_text_field',
        'ferry_eta' => 'sanitize_text_field',
        'ferry_operator' => 'sanitize_text_field',
        'ferry_duration' => 'sanitize_text_field',
        'ferry_price' => 'sanitize_text_field',
        'ferry_frequency' => 'sanitize_text_field',
        'ferry_checkin_location' => 'sanitize_textarea_field',
        'ferry_menu_order' => 'absint',
    );

    foreach ($fields as $field => $sanitize_callback) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, $sanitize_callback($_POST[$field]));
        }
    }
}
add_action('save_post', 'nirup_save_ferry_schedule_meta');

// Add admin columns for ferry schedules
function nirup_ferry_schedule_admin_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['route_type'] = __('Route Type', 'nirup-island');
    $new_columns['route'] = __('Route', 'nirup-island');
    $new_columns['etd'] = __('ETD', 'nirup-island');
    $new_columns['eta'] = __('ETA', 'nirup-island');
    $new_columns['operator'] = __('Operator', 'nirup-island');
    $new_columns['order'] = __('Order', 'nirup-island');
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_ferry_schedule_posts_columns', 'nirup_ferry_schedule_admin_columns');

function nirup_ferry_schedule_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'route_type':
            $route_type = get_post_meta($post_id, '_ferry_route_type', true);
            echo $route_type ? ucfirst(esc_html($route_type)) : '—';
            break;
        case 'route':
            $from = get_post_meta($post_id, '_ferry_route_from', true);
            $to = get_post_meta($post_id, '_ferry_route_to', true);
            echo ($from && $to) ? esc_html($from . ' → ' . $to) : '—';
            break;
        case 'etd':
            $etd = get_post_meta($post_id, '_ferry_etd', true);
            echo $etd ? esc_html($etd) : '—';
            break;
        case 'eta':
            $eta = get_post_meta($post_id, '_ferry_eta', true);
            echo $eta ? esc_html($eta) : '—';
            break;
        case 'operator':
            $operator = get_post_meta($post_id, '_ferry_operator', true);
            echo $operator ? esc_html($operator) : '—';
            break;
        case 'order':
            $order = get_post_meta($post_id, '_ferry_menu_order', true);
            echo $order ? esc_html($order) : '0';
            break;
    }
}
add_action('manage_ferry_schedule_posts_custom_column', 'nirup_ferry_schedule_admin_column_content', 10, 2);

function nirup_booking_modal_customizer($wp_customize) {
    // Booking Modal Section
    $wp_customize->add_section('nirup_booking_modal', array(
        'title' => __('Booking Modal', 'nirup-island'),
        'priority' => 22,
        'description' => __('Customize the booking modal content and images', 'nirup-island'),
    ));

    // Modal Title
    $wp_customize->add_setting('nirup_booking_modal_title', array(
        'default' => __('BOOK YOUR STAY', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_modal_title', array(
        'label' => __('Modal Title', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'text',
    ));

    // --- RESORT HOTEL SECTION ---
    
    // Resort Label
    $wp_customize->add_setting('nirup_booking_resort_label', array(
        'default' => __('RESORT HOTEL', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_resort_label', array(
        'label' => __('Resort Label', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'text',
        'description' => __('Small label above resort name', 'nirup-island'),
    ));

    // Resort Name
    $wp_customize->add_setting('nirup_booking_resort_name', array(
        'default' => __('The Westin Nirup Island Resort & Spa', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_resort_name', array(
        'label' => __('Resort Name', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'text',
    ));

    // Resort Description
    $wp_customize->add_setting('nirup_booking_resort_description', array(
        'default' => __('Unwind in elegant guest rooms and overwater villas with panoramic sea views. Enjoy Heavenly Spa by Westin™, the WestinWORKOUT® Fitness Studio, and family-friendly Kids Club.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_resort_description', array(
        'label' => __('Resort Description', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'textarea',
        'input_attrs' => array(
            'rows' => 4,
        ),
    ));

    // Resort Button Text
    $wp_customize->add_setting('nirup_booking_resort_button_text', array(
        'default' => __('Book on Westin Website', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_resort_button_text', array(
        'label' => __('Resort Button Text', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'text',
    ));

    // Resort Button Link
    $wp_customize->add_setting('nirup_booking_resort_button_link', array(
        'default' => 'https://www.marriott.com/',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_booking_resort_button_link', array(
        'label' => __('Resort Button Link', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'url',
    ));

    // Resort Image
    $wp_customize->add_setting('nirup_booking_resort_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_booking_resort_image', array(
        'label' => __('Resort Image', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'mime_type' => 'image',
        'description' => __('Recommended size: 896x504px', 'nirup-island'),
    )));

    // --- PRIVATE VILLAS SECTION ---
    
    // Villas Label
    $wp_customize->add_setting('nirup_booking_villas_label', array(
        'default' => __('PRIVATE VILLAS', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_villas_label', array(
        'label' => __('Villas Label', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'text',
        'description' => __('Small label above villas name', 'nirup-island'),
    ));

    // Villas Name
    $wp_customize->add_setting('nirup_booking_villas_name', array(
        'default' => __('Riahi Residences', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_villas_name', array(
        'label' => __('Villas Name', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'text',
    ));

    // Villas Description
    $wp_customize->add_setting('nirup_booking_villas_description', array(
        'default' => __('Spacious 1–4 bedroom villas with private pools and full kitchens. Designed for privacy and comfort, with access to Westin resort amenities and in-villa dining options.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_villas_description', array(
        'label' => __('Villas Description', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'textarea',
        'input_attrs' => array(
            'rows' => 4,
        ),
    ));

    // Villas Button Text
    $wp_customize->add_setting('nirup_booking_villas_button_text', array(
        'default' => __('Book Now', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_villas_button_text', array(
        'label' => __('Villas Button Text', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'text',
    ));

    // Villas Button Link
    $wp_customize->add_setting('nirup_booking_villas_button_link', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_booking_villas_button_link', array(
        'label' => __('Villas Button Link', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'url',
    ));

    // Villas Image
    $wp_customize->add_setting('nirup_booking_villas_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_booking_villas_image', array(
        'label' => __('Villas Image', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'mime_type' => 'image',
        'description' => __('Recommended size: 896x489px', 'nirup-island'),
    )));
}
add_action('customize_register', 'nirup_booking_modal_customizer');

function nirup_enqueue_booking_modal_assets() {
    // Enqueue booking modal CSS
    wp_enqueue_style(
        'nirup-booking-modal',
        get_template_directory_uri() . '/assets/css/booking-modal.css',
        array(),
        '1.0.0'
    );
    
    // Enqueue booking modal JavaScript
    wp_enqueue_script(
        'nirup-booking-modal',
        get_template_directory_uri() . '/assets/js/booking-modal.js',
        array('jquery'),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_booking_modal_assets');

function nirup_contact_form_submit() {
    // Check nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'contact_form_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed.'));
        return;
    }
    
    // Get and sanitize form data
    $form_data = isset($_POST['form_data']) ? $_POST['form_data'] : array();
    
    $name         = sanitize_text_field($form_data['name'] ?? '');
    $email        = sanitize_email($form_data['email'] ?? '');
    $phone        = sanitize_text_field($form_data['phone'] ?? '');
    $inquiry_type = sanitize_text_field($form_data['inquiry_type'] ?? '');
    $message      = sanitize_textarea_field($form_data['message'] ?? '');
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($inquiry_type) || empty($message)) {
        wp_send_json_error(array('message' => 'Please fill in all required fields.'));
        return;
    }
    
    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'));
        return;
    }

    // ---- reCAPTCHA v3 verification (added) ----
    $recaptcha_secret = nirup_get_secret('RECAPTCHA_SECRET', 'nirup_recaptcha_secret', '');
    $recaptcha_token  = sanitize_text_field($_POST['recaptcha_token'] ?? '');
    $captcha_enabled  = !defined('NIRUP_DISABLE_CAPTCHA') && !empty($recaptcha_secret);

    if ($captcha_enabled) {
        $verify = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
            'body' => array(
                'secret'   => $recaptcha_secret,
                'response' => $recaptcha_token,
                'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
            ),
            'timeout' => 10,
        ));

        if (is_wp_error($verify)) {
            wp_send_json_error(array('message' => 'Captcha verification failed. Please try again.'), 400);
        }

        $vbody = json_decode(wp_remote_retrieve_body($verify), true);
        $score = isset($vbody['score']) ? (float) $vbody['score'] : 0;

        // Threshold 0.5 (loosen to 0.3 if needed on dev)
        if (empty($vbody['success']) || $score < 0.5) {
            wp_send_json_error(array('message' => 'Captcha failed. Please try again.'), 400);
        }
    } else {
        error_log('Contact form: reCAPTCHA disabled or not configured; skipping verification.');
    }
    // ---- end captcha ----
    
    // Store submission in database FIRST
    nirup_store_contact_submission($name, $email, $phone, $inquiry_type, $message);
    error_log('Contact Form - Submission saved to database');
    
    // Get email settings from customizer
    $admin_email = get_theme_mod('nirup_contact_form_email', 'explore@nirupisland.com');
    $from_email  = get_theme_mod('nirup_contact_form_from_email', 'explore@nirupisland.com');
    $from_name   = get_bloginfo('name');
    
    error_log('Contact Form - Admin email: ' . $admin_email);
    error_log('Contact Form - From email: ' . $from_email);
    error_log('Contact Form - User email: ' . $email);
    
    // EMAIL 1: ADMIN NOTIFICATION
    $admin_subject = '[' . get_bloginfo('name') . '] New Contact Form Submission from ' . $name;
    
    $admin_body  = "New contact form submission:\n\n";
    $admin_body .= "Name: " . $name . "\n";
    $admin_body .= "Email: " . $email . "\n";
    $admin_body .= "Phone: " . (!empty($phone) ? $phone : 'Not provided') . "\n";
    $admin_body .= "Type of Inquiry: " . $inquiry_type . "\n\n";
    $admin_body .= "Message:\n" . $message . "\n\n";
    $admin_body .= "---\n";
    $admin_body .= "This email was sent from the contact form on " . get_bloginfo('url') . "\n";
    $admin_body .= "Submitted on: " . current_time('F j, Y g:i A');
    
    $admin_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );
    
    // EMAIL 2: USER CONFIRMATION
    $user_subject_template = get_theme_mod('nirup_contact_confirmation_subject', 'Thank you for contacting {site_name}');
    $user_body_template    = get_theme_mod('nirup_contact_confirmation_body', "Dear {user_name},\n\nThank you for reaching out to us. We have received your message and our team will review it shortly.\n\nHere's a summary of what you submitted:\n\nType of Inquiry: {inquiry_type}\n\nWe aim to respond within 1-2 business days. If your matter is urgent, please don't hesitate to call us at {phone_number}.\n\nBest regards,\nThe {site_name} Team");
    $user_footer_template  = get_theme_mod('nirup_contact_confirmation_footer', "---\nThis is an automated confirmation email. Please do not reply to this message.");
    
    $replacements = array(
        '{site_name}'    => get_bloginfo('name'),
        '{user_name}'    => $name,
        '{user_email}'   => $email,
        '{user_phone}'   => !empty($phone) ? $phone : 'Not provided',
        '{inquiry_type}' => $inquiry_type,
        '{phone_number}' => get_theme_mod('nirup_contact_phone_primary', '+62 811 6220 999')
    );
    
    $user_subject = str_replace(array_keys($replacements), array_values($replacements), $user_subject_template);
    $user_body    = str_replace(array_keys($replacements), array_values($replacements), $user_body_template);
    $user_footer  = str_replace(array_keys($replacements), array_values($replacements), $user_footer_template);
    $user_body    = $user_body . "\n\n" . $user_footer;
    
    $user_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>'
    );
    
    // SEND BOTH EMAILS
    error_log('Contact Form - Attempting to send admin email to: ' . $admin_email);
    $admin_mail_sent = wp_mail($admin_email, $admin_subject, $admin_body, $admin_headers);
    error_log('Contact Form - Admin email result: ' . ($admin_mail_sent ? 'SUCCESS' : 'FAILED'));
    
    error_log('Contact Form - Attempting to send user email to: ' . $email);
    $user_mail_sent = wp_mail($email, $user_subject, $user_body, $user_headers);
    error_log('Contact Form - User email result: ' . ($user_mail_sent ? 'SUCCESS' : 'FAILED'));
    
    if (!$admin_mail_sent || !$user_mail_sent) {
        global $phpmailer;
        if (isset($phpmailer) && !empty($phpmailer->ErrorInfo)) {
            error_log('Contact Form - PHPMailer Error: ' . $phpmailer->ErrorInfo);
        }
    }
    
    // RETURN RESPONSE
    if ($admin_mail_sent || $user_mail_sent) {
        wp_send_json_success(array(
            'message'    => 'Your message has been received! We will respond within 1-2 business days.',
            'admin_sent' => $admin_mail_sent,
            'user_sent'  => $user_mail_sent
        ));
    } else {
        // Both failed but data is saved
        wp_send_json_success(array(
            'message'    => 'Your message has been saved! We will respond within 1-2 business days.',
            'admin_sent' => false,
            'user_sent'  => false
        ));
    }
}
add_action('wp_ajax_nirup_contact_form_submit', 'nirup_contact_form_submit');
add_action('wp_ajax_nopriv_nirup_contact_form_submit', 'nirup_contact_form_submit');



/**
 * Store Contact Form Submission in Database (Optional)
 * This creates a backup of all submissions in the database
 */
function nirup_store_contact_submission($name, $email, $phone, $inquiry_type, $message) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    
    // Create table if it doesn't exist
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        nirup_create_contact_submissions_table();
    }
    
    // Insert submission
    $result = $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'inquiry_type' => $inquiry_type,
            'message' => $message,
            'submission_date' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s')
    );
    
    if ($result === false) {
        error_log('Contact Form - Database storage failed: ' . $wpdb->last_error);
    } else {
        error_log('Contact Form - Submission saved to database successfully');
    }
}

/**
 * Create Contact Submissions Table
 */
function nirup_create_contact_submissions_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(100) DEFAULT '',
        inquiry_type varchar(255) NOT NULL,
        message text NOT NULL,
        submission_date datetime NOT NULL,
        status varchar(20) DEFAULT 'new',
        PRIMARY KEY (id),
        KEY email (email),
        KEY submission_date (submission_date),
        KEY status (status)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}


/**
 * Add Contact Form Settings to Customizer
 * Separate section for clarity
 */
function nirup_contact_form_customizer($wp_customize) {
    
    // Add Contact Form Section (separate from content)
    $wp_customize->add_section('nirup_contact_form_settings', array(
        'title' => __('Contact Form Settings', 'nirup-island'),
        'priority' => 46,
        'description' => __('Configure email addresses and email content for contact form', 'nirup-island'),
    ));
    
    // ===== EMAIL ADDRESSES =====
    
    // Send FROM Email Setting (noreply address)
    $wp_customize->add_setting('nirup_contact_form_from_email', array(
        'default' => 'explore@nirupisland.com',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_contact_form_from_email', array(
        'label' => __('Send From Email', 'nirup-island'),
        'section' => 'nirup_contact_form_settings',
        'type' => 'email',
        'description' => __('Email address that will appear as the sender (e.g., noreply@yourdomain.com)', 'nirup-island'),
        'priority' => 10,
    ));
    
    // Send TO Email Setting (admin notification)
    $wp_customize->add_setting('nirup_contact_form_email', array(
        'default' => 'explore@nirupisland.com',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_contact_form_email', array(
        'label' => __('Send To Email', 'nirup-island'),
        'section' => 'nirup_contact_form_settings',
        'type' => 'email',
        'description' => __('Email address where contact form submissions will be sent', 'nirup-island'),
        'priority' => 20,
    ));
    
    // ===== USER CONFIRMATION EMAIL CONTENT =====
    
    // Email Subject
    $wp_customize->add_setting('nirup_contact_confirmation_subject', array(
        'default' => __('Thank you for contacting {site_name}', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_contact_confirmation_subject', array(
        'label' => __('Confirmation Email Subject', 'nirup-island'),
        'section' => 'nirup_contact_form_settings',
        'type' => 'text',
        'description' => __('Available tags: {site_name}, {user_name}', 'nirup-island'),
        'priority' => 30,
    ));
    
    // Email Body
    $wp_customize->add_setting('nirup_contact_confirmation_body', array(
        'default' => __("Dear {user_name},\n\nThank you for reaching out to us. We have received your message and our team will review it shortly.\n\nHere's a summary of what you submitted:\n\nType of Inquiry: {inquiry_type}\n\nWe aim to respond within 1-2 business days. If your matter is urgent, please don't hesitate to call us at {phone_number}.\n\nBest regards,\nThe {site_name} Team", 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_contact_confirmation_body', array(
        'label' => __('Confirmation Email Body', 'nirup-island'),
        'section' => 'nirup_contact_form_settings',
        'type' => 'textarea',
        'description' => __('Available tags: {site_name}, {user_name}, {inquiry_type}, {phone_number}, {user_email}, {user_phone}', 'nirup-island'),
        'input_attrs' => array(
            'rows' => 12,
        ),
        'priority' => 40,
    ));
    
    // Email Footer
    $wp_customize->add_setting('nirup_contact_confirmation_footer', array(
        'default' => __("---\nThis is an automated confirmation email. Please do not reply to this message.", 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_contact_confirmation_footer', array(
        'label' => __('Confirmation Email Footer', 'nirup-island'),
        'section' => 'nirup_contact_form_settings',
        'type' => 'textarea',
        'description' => __('Text that appears at the bottom of the confirmation email', 'nirup-island'),
        'input_attrs' => array(
            'rows' => 3,
        ),
        'priority' => 50,
    ));
}
add_action('customize_register', 'nirup_contact_form_customizer');

function nirup_contact_submissions_menu() {
    add_menu_page(
        'Contact Submissions',
        'Contact Forms',
        'manage_options',
        'contact-submissions',
        'nirup_contact_submissions_page',
        'dashicons-email-alt',
        25
    );
}
add_action('admin_menu', 'nirup_contact_submissions_menu');

/**
 * Display Contact Submissions Admin Page
 */
function nirup_contact_submissions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    
    // Handle status updates
    if (isset($_POST['update_status']) && wp_verify_nonce($_POST['contact_nonce'], 'contact_action')) {
        $id = intval($_POST['submission_id']);
        $status = sanitize_text_field($_POST['status']);
        $wpdb->update($table_name, array('status' => $status), array('id' => $id));
        echo '<div class="notice notice-success is-dismissible"><p>Status updated successfully!</p></div>';
    }
    
    // Handle deletion
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id']) && wp_verify_nonce($_GET['_wpnonce'], 'delete_submission_' . $_GET['id'])) {
        $id = intval($_GET['id']);
        $wpdb->delete($table_name, array('id' => $id), array('%d'));
        echo '<div class="notice notice-success is-dismissible"><p>Submission deleted successfully!</p></div>';
    }
    
    // Get filter
    $status_filter = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : 'all';
    
    // Get submissions
    if ($status_filter === 'all') {
        $submissions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submission_date DESC");
    } else {
        $submissions = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE status = %s ORDER BY submission_date DESC", $status_filter));
    }
    
    // Count by status
    $count_new = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'new'");
    $count_replied = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'replied'");
    $count_archived = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'archived'");
    $count_all = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    
    ?>
    <div class="wrap nirup-contact-admin">
        <h1 class="wp-heading-inline">Contact Form Submissions</h1>
        
        <!-- Status Filter Tabs -->
        <ul class="subsubsub">
            <li><a href="?page=contact-submissions&status=all" class="<?php echo $status_filter === 'all' ? 'current' : ''; ?>">All <span class="count">(<?php echo $count_all; ?>)</span></a> |</li>
            <li><a href="?page=contact-submissions&status=new" class="<?php echo $status_filter === 'new' ? 'current' : ''; ?>">New <span class="count">(<?php echo $count_new; ?>)</span></a> |</li>
            <li><a href="?page=contact-submissions&status=replied" class="<?php echo $status_filter === 'replied' ? 'current' : ''; ?>">Replied <span class="count">(<?php echo $count_replied; ?>)</span></a> |</li>
            <li><a href="?page=contact-submissions&status=archived" class="<?php echo $status_filter === 'archived' ? 'current' : ''; ?>">Archived <span class="count">(<?php echo $count_archived; ?>)</span></a></li>
        </ul>
        
        <div class="clear"></div>
        
        <?php if (empty($submissions)): ?>
            <p>No submissions found.</p>
        <?php else: ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th style="width: 80px;">Status</th>
                        <th style="width: 80px;">Date</th>
                        <th style="width: 160px;">Name</th>
                        <th style="width: 230px;">Email</th>
                        <th style="width: 160px;">Phone</th>
                        <th style="width: 160px;">Inquiry Type</th>
                        <th>Message Preview</th>
                        <th style="width: 300px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $submission): ?>
                        <tr class="submission-row" data-status="<?php echo esc_attr($submission->status); ?>">
                            <td>
                                <?php
                                $status_class = 'status-' . $submission->status;
                                $status_label = ucfirst($submission->status);
                                ?>
                                <span class="status-badge <?php echo $status_class; ?>">
                                    <?php echo $status_label; ?>
                                </span>
                            </td>
                            <td><?php echo esc_html(date('M j, Y', strtotime($submission->submission_date))); ?><br>
                                <small><?php echo esc_html(date('g:i A', strtotime($submission->submission_date))); ?></small>
                            </td>
                            <td><strong><?php echo esc_html($submission->name); ?></strong></td>
                            <td><?php echo esc_html($submission->email); ?></td>
                            <td><?php echo esc_html($submission->phone ?: 'N/A'); ?></td>
                            <td><?php echo esc_html($submission->inquiry_type); ?></td>
                            <td><?php echo esc_html(wp_trim_words($submission->message, 12)); ?></td>
                            <td>
                                <button class="button button-small view-submission" data-id="<?php echo $submission->id; ?>">
                                    <span class="dashicons dashicons-visibility"></span> View
                                </button>
                                <button class="button button-small reply-submission" data-email="<?php echo esc_attr($submission->email); ?>" data-name="<?php echo esc_attr($submission->name); ?>">
                                    <span class="dashicons dashicons-email"></span> Reply
                                </button>
                                <a href="<?php echo wp_nonce_url('?page=contact-submissions&action=delete&id=' . $submission->id, 'delete_submission_' . $submission->id); ?>" 
                                   class="button button-small button-link-delete"
                                   onclick="return confirm('Are you sure you want to delete this submission?');">
                                    <span class="dashicons dashicons-trash"></span> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
    <!-- View Modal -->
    <div id="submission-modal" class="submission-modal" style="display: none;">
        <div class="modal-backdrop"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h2>Submission Details</h2>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="submission-details">
                    <!-- Content loaded via AJAX -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="button button-large button-close">Close</button>
            </div>
        </div>
    </div>
    
    <?php
}

function nirup_get_submission_details() {
    check_ajax_referer('nirup_contact_admin_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Insufficient permissions');
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    $id = intval($_POST['id']);
    
    $submission = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));
    
    if (!$submission) {
        wp_send_json_error('Submission not found');
    }
    
    ob_start();
    ?>
    <div class="submission-detail-grid">
        <div class="detail-row">
            <div class="detail-label">From:</div>
            <div class="detail-value"><strong><?php echo esc_html($submission->name); ?></strong></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Email:</div>
            <div class="detail-value">
                <a href="mailto:<?php echo esc_attr($submission->email); ?>"><?php echo esc_html($submission->email); ?></a>
            </div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Phone:</div>
            <div class="detail-value"><?php echo esc_html($submission->phone ?: 'Not provided'); ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Inquiry Type:</div>
            <div class="detail-value"><span class="inquiry-badge"><?php echo esc_html($submission->inquiry_type); ?></span></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Date:</div>
            <div class="detail-value"><?php echo esc_html(date('F j, Y g:i A', strtotime($submission->submission_date))); ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Status:</div>
            <div class="detail-value">
                <form method="post" class="status-update-form">
                    <input type="hidden" name="contact_nonce" value="<?php echo wp_create_nonce('contact_action'); ?>">
                    <input type="hidden" name="submission_id" value="<?php echo $submission->id; ?>">
                    <select name="status" class="status-select">
                        <option value="new" <?php selected($submission->status, 'new'); ?>>New</option>
                        <option value="replied" <?php selected($submission->status, 'replied'); ?>>Replied</option>
                        <option value="archived" <?php selected($submission->status, 'archived'); ?>>Archived</option>
                    </select>
                    <button type="submit" name="update_status" class="button button-small">Update</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="message-container">
        <h3>Message:</h3>
        <div class="message-content">
            <?php echo nl2br(esc_html($submission->message)); ?>
        </div>
    </div>
    
    <div class="action-buttons">
        <a href="mailto:<?php echo esc_attr($submission->email); ?>?subject=Re: Your inquiry to <?php echo esc_attr(get_bloginfo('name')); ?>&body=Hi <?php echo esc_attr($submission->name); ?>,%0D%0A%0D%0AThank you for contacting us.%0D%0A%0D%0A" 
           class="button button-primary button-large">
            <span class="dashicons dashicons-email"></span> Reply via Email
        </a>
    </div>
    <?php
    $html = ob_get_clean();
    
    wp_send_json_success(array('html' => $html));
}
add_action('wp_ajax_nirup_get_submission_details', 'nirup_get_submission_details');

function nirup_contact_activation() {
    nirup_create_contact_submissions_table();
}
register_activation_hook(__FILE__, 'nirup_contact_activation');

add_action('after_switch_theme', 'nirup_create_contact_submissions_table');

function nirup_contact_page_customizer($wp_customize) {
    
    $wp_customize->add_section('nirup_contact_page_settings', array(
        'title' => __('Contact Page Content', 'nirup-island'),
        'priority' => 45,
        'description' => __('Customize all text content on the contact page', 'nirup-island'),
    ));
    
    $wp_customize->add_setting('nirup_contact_title', array(
        'default' => __('CONTACT US', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_title', array(
        'label' => __('Page Title', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 10,
    ));
    

    $wp_customize->add_setting('nirup_contact_intro_text', array(
        'default' => __('We welcome your enquiries and are here to assist with every detail of your visit, stay, or event. For urgent matters, please call us at:', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_intro_text', array(
        'label' => __('Introduction Text', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'textarea',
        'priority' => 20,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_phone_label', array(
        'default' => __('General Enquiries:', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_phone_label', array(
        'label' => __('Phone Number Label', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 30,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_closing_text', array(
        'default' => __('For all other requests, please complete the enquiry form below. Our team will review your message and respond within 1-2 business days.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_closing_text', array(
        'label' => __('Closing Text', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'textarea',
        'priority' => 40,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_label_name', array(
        'default' => __('Name*', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_label_name', array(
        'label' => __('Name Field Label', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 50,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_placeholder_name', array(
        'default' => __('Your Name', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_placeholder_name', array(
        'label' => __('Name Field Placeholder', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 60,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_label_email', array(
        'default' => __('E-mail*', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_label_email', array(
        'label' => __('Email Field Label', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 70,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_placeholder_email', array(
        'default' => __('Your E-mail', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_placeholder_email', array(
        'label' => __('Email Field Placeholder', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 80,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_label_phone', array(
        'default' => __('Phone', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_label_phone', array(
        'label' => __('Phone Field Label', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 90,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_placeholder_phone', array(
        'default' => __('Your Phone Number', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_placeholder_phone', array(
        'label' => __('Phone Field Placeholder', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 100,
    ));
    
   
    $wp_customize->add_setting('nirup_contact_label_inquiry', array(
        'default' => __('Type of Enquiry*', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_label_inquiry', array(
        'label' => __('Inquiry Type Label', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 110,
    ));
    

    $wp_customize->add_setting('nirup_contact_placeholder_inquiry', array(
        'default' => __('Choose event type', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_placeholder_inquiry', array(
        'label' => __('Inquiry Type Placeholder', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 120,
    ));
    

    $wp_customize->add_setting('nirup_contact_label_message', array(
        'default' => __('Message*', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_label_message', array(
        'label' => __('Message Field Label', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 130,
    ));
    
    $wp_customize->add_setting('nirup_contact_placeholder_message', array(
        'default' => __('Text your message here', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_placeholder_message', array(
        'label' => __('Message Field Placeholder', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 140,
    ));
    
    $wp_customize->add_setting('nirup_contact_submit_text', array(
        'default' => __('Submit Inquiry', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_submit_text', array(
        'label' => __('Submit Button Text', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 150,
    ));
    

    $wp_customize->add_setting('nirup_contact_modal_title', array(
        'default' => __('THANK YOU!', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_modal_title', array(
        'label' => __('Thank You Modal Title', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 160,
    ));
    
    // Modal Message Line 1
    $wp_customize->add_setting('nirup_contact_modal_message_1', array(
        'default' => __('Your request has been received.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_modal_message_1', array(
        'label' => __('Modal Message Line 1', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 170,
    ));
    
    // Modal Message Line 2
    $wp_customize->add_setting('nirup_contact_modal_message_2', array(
        'default' => __('Our team is at your service', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_modal_message_2', array(
        'label' => __('Modal Message Line 2', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 180,
    ));
    
    // Modal Phone Text
    $wp_customize->add_setting('nirup_contact_modal_phone_text', array(
        'default' => __('For urgent matters, call', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_modal_phone_text', array(
        'label' => __('Modal Phone Text', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 190,
    ));
}
add_action('customize_register', 'nirup_contact_page_customizer');

function nirup_contact_admin_assets($hook) {
    if ($hook !== 'toplevel_page_contact-submissions') {
        return;
    }
    
    wp_enqueue_style('nirup-contact-admin', get_template_directory_uri() . '/assets/css/contact-admin.css', array(), '1.0.0');
    wp_enqueue_script('nirup-contact-admin', get_template_directory_uri() . '/assets/js/contact-admin.js', array('jquery'), '1.0.0', true);
    
    wp_localize_script('nirup-contact-admin', 'nirupContactAdmin', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('nirup_contact_admin_nonce')
    ));
}
add_action('admin_enqueue_scripts', 'nirup_contact_admin_assets');

function nirup_update_contact_table_add_status() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    
    // Check if status column exists
    $column_exists = $wpdb->get_results($wpdb->prepare(
        "SHOW COLUMNS FROM $table_name LIKE %s",
        'status'
    ));
    
    // If status column doesn't exist, add it
    if (empty($column_exists)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN status varchar(20) DEFAULT 'new' AFTER submission_date");
        $wpdb->query("ALTER TABLE $table_name ADD KEY status (status)");
        
        echo '<div class="notice notice-success"><p>Status column added successfully!</p></div>';
    } else {
        echo '<div class="notice notice-info"><p>Status column already exists.</p></div>';
    }
}

add_action('admin_init', 'nirup_run_contact_table_update_once');
function nirup_run_contact_table_update_once() {
    // Check if update has been run
    if (get_option('nirup_contact_table_updated') !== 'yes') {
        nirup_update_contact_table_add_status();
        update_option('nirup_contact_table_updated', 'yes');
    }
}

function nirup_add_marina_meta_boxes() {
    add_meta_box(
        'marina_details',
        '🏖️ Marina Page Settings',
        'nirup_marina_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_marina_meta_boxes');

function nirup_marina_meta_box_callback($post) {
    // Only show for Marina page template
    $template = get_post_meta($post->ID, '_wp_page_template', true);
    if ($template !== 'page-marina.php') {
        echo '<p>This meta box is only available when using the Marina Page template.</p>';
        return;
    }

    wp_nonce_field('nirup_marina_meta_box', 'nirup_marina_meta_box_nonce');

    // Get saved values (existing fields)
    $subtitle = get_post_meta($post->ID, '_marina_subtitle', true);
    $title = get_post_meta($post->ID, '_marina_title', true);
    $berthing_desc_1 = get_post_meta($post->ID, '_marina_berthing_description_1', true);
    $berthing_desc_2 = get_post_meta($post->ID, '_marina_berthing_description_2', true);
    $gallery_images = get_post_meta($post->ID, '_marina_gallery', true);
    $gallery_images = is_array($gallery_images) ? $gallery_images : array();

    // NEW: Get PDF file IDs
    $berthing_rates_pdf = get_post_meta($post->ID, '_berthing_rates_pdf', true);
    $arrival_procedure_pdf = get_post_meta($post->ID, '_arrival_procedure_pdf', true);
    $marina_rules_en_pdf = get_post_meta($post->ID, '_marina_rules_en_pdf', true);
    $marina_rules_id_pdf = get_post_meta($post->ID, '_marina_rules_id_pdf', true);

    ?>
    <style>
        .marina-meta-section { margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #ddd; }
        .marina-meta-section:last-child { border-bottom: none; }
        .marina-meta-field { margin-bottom: 15px; }
        .marina-meta-field label { display: block; font-weight: bold; margin-bottom: 5px; }
        .marina-meta-field input[type="text"],
        .marina-meta-field textarea { width: 100%; }
        .pdf-upload-container { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-top: 10px; }
        .current-pdf { background: #f1f1f1; padding: 10px; border-radius: 3px; margin-bottom: 10px; }
        .pdf-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px; }
    </style>

    <!-- Existing Hero Section Fields -->
    <div class="marina-meta-section">
        <h3>🏝️ Hero Section</h3>
        
        <div class="marina-meta-field">
            <label for="marina_subtitle">Subtitle</label>
            <input type="text" id="marina_subtitle" name="marina_subtitle" 
                   value="<?php echo esc_attr($subtitle); ?>" 
                   placeholder="e.g., Welcome to ONE°15 Marina Nirup Island" />
        </div>

        <div class="marina-meta-field">
            <label for="marina_title">Main Title</label>
            <input type="text" id="marina_title" name="marina_title" 
                   value="<?php echo esc_attr($title); ?>" 
                   placeholder="e.g., Arrive in Style" />
        </div>
    </div>

    <!-- Existing Berthing Description -->
    <div class="marina-meta-section">
        <h3>⚓ Berthing Descriptions</h3>
        
        <div class="marina-meta-field">
            <label for="marina_berthing_description_1">Description 1</label>
            <textarea id="marina_berthing_description_1" name="marina_berthing_description_1" 
                      rows="3"><?php echo esc_textarea($berthing_desc_1); ?></textarea>
        </div>

        <div class="marina-meta-field">
            <label for="marina_berthing_description_2">Description 2</label>
            <textarea id="marina_berthing_description_2" name="marina_berthing_description_2" 
                      rows="3"><?php echo esc_textarea($berthing_desc_2); ?></textarea>
        </div>
    </div>

    <!-- Marina Gallery Section -->
    <div class="marina-meta-section">
        <h3>📸 Marina Gallery</h3>
        <p style="color: #666; margin-bottom: 15px;">Upload images for the marina gallery. The first image will be used as the main image, and the next 4 will appear in the grid.</p>

        <div class="marina-gallery-images" style="margin-bottom: 15px; min-height: 50px; border: 2px dashed #ddd; padding: 10px; background: #fafafa;">
            <?php
            if ($gallery_images && is_array($gallery_images)) {
                foreach ($gallery_images as $index => $image_id) {
                    $image_url = wp_get_attachment_image_src($image_id, 'thumbnail');
                    if ($image_url) {
                        echo '<div class="marina-gallery-item" data-id="' . $image_id . '" style="position: relative; display: inline-block; margin: 5px; cursor: move;">';
                        echo '<img src="' . $image_url[0] . '" style="max-width: 100px; height: 80px; object-fit: cover; border: 2px solid #ddd;" />';
                        echo '<button type="button" class="remove-marina-gallery-image button" style="position: absolute; top: -5px; right: -5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1; padding: 0;">×</button>';
                        echo '<input type="hidden" name="marina_gallery[' . $index . ']" value="' . $image_id . '">';
                        echo '</div>';
                    }
                }
            }
            ?>
        </div>

        <button type="button" id="add_marina_gallery_image" class="button button-primary">Add Images to Gallery</button>
        <button type="button" id="clear_marina_gallery" class="button" style="margin-left: 10px;">Clear All Images</button>
        <p class="description" style="margin-top: 10px;">You can drag and drop images to reorder them. The first image is the main gallery image.</p>
    </div>

    <!-- NEW: PDF Downloads Section -->
    <div class="marina-meta-section">
        <h3>📄 Downloadable PDFs</h3>
        <p style="color: #666; margin-bottom: 15px;">Upload PDF files that users can download from the marina page.</p>
        
        <div class="pdf-grid">
            <!-- Berthing Rates PDF -->
            <div class="marina-meta-field">
                <label>Berthing Rates PDF</label>
                <div class="pdf-upload-container">
                    <?php if ($berthing_rates_pdf): 
                        $pdf_url = wp_get_attachment_url($berthing_rates_pdf);
                        $pdf_filename = basename(get_attached_file($berthing_rates_pdf));
                    ?>
                        <div class="current-pdf" id="berthing_rates_display">
                            <strong>Current PDF:</strong> 
                            <a href="<?php echo esc_url($pdf_url); ?>" target="_blank"><?php echo esc_html($pdf_filename); ?></a>
                            <button type="button" class="button remove-pdf-btn" data-field="berthing_rates" style="margin-left: 10px;">Remove</button>
                        </div>
                    <?php endif; ?>
                    <button type="button" class="button upload-pdf-btn" data-field="berthing_rates">
                        <?php echo $berthing_rates_pdf ? 'Change PDF' : 'Upload PDF'; ?>
                    </button>
                    <input type="hidden" id="berthing_rates_pdf" name="berthing_rates_pdf" value="<?php echo esc_attr($berthing_rates_pdf); ?>" />
                </div>
            </div>

            <!-- Arrival Procedure PDF -->
            <div class="marina-meta-field">
                <label>Arrival Procedure PDF</label>
                <div class="pdf-upload-container">
                    <?php if ($arrival_procedure_pdf): 
                        $pdf_url = wp_get_attachment_url($arrival_procedure_pdf);
                        $pdf_filename = basename(get_attached_file($arrival_procedure_pdf));
                    ?>
                        <div class="current-pdf" id="arrival_procedure_display">
                            <strong>Current PDF:</strong> 
                            <a href="<?php echo esc_url($pdf_url); ?>" target="_blank"><?php echo esc_html($pdf_filename); ?></a>
                            <button type="button" class="button remove-pdf-btn" data-field="arrival_procedure" style="margin-left: 10px;">Remove</button>
                        </div>
                    <?php endif; ?>
                    <button type="button" class="button upload-pdf-btn" data-field="arrival_procedure">
                        <?php echo $arrival_procedure_pdf ? 'Change PDF' : 'Upload PDF'; ?>
                    </button>
                    <input type="hidden" id="arrival_procedure_pdf" name="arrival_procedure_pdf" value="<?php echo esc_attr($arrival_procedure_pdf); ?>" />
                </div>
            </div>

            <!-- Marina Rules (EN) PDF -->
            <div class="marina-meta-field">
                <label>Marina Rules & Regulations (EN) PDF</label>
                <div class="pdf-upload-container">
                    <?php if ($marina_rules_en_pdf): 
                        $pdf_url = wp_get_attachment_url($marina_rules_en_pdf);
                        $pdf_filename = basename(get_attached_file($marina_rules_en_pdf));
                    ?>
                        <div class="current-pdf" id="marina_rules_en_display">
                            <strong>Current PDF:</strong> 
                            <a href="<?php echo esc_url($pdf_url); ?>" target="_blank"><?php echo esc_html($pdf_filename); ?></a>
                            <button type="button" class="button remove-pdf-btn" data-field="marina_rules_en" style="margin-left: 10px;">Remove</button>
                        </div>
                    <?php endif; ?>
                    <button type="button" class="button upload-pdf-btn" data-field="marina_rules_en">
                        <?php echo $marina_rules_en_pdf ? 'Change PDF' : 'Upload PDF'; ?>
                    </button>
                    <input type="hidden" id="marina_rules_en_pdf" name="marina_rules_en_pdf" value="<?php echo esc_attr($marina_rules_en_pdf); ?>" />
                </div>
            </div>

            <!-- Marina Rules (ID) PDF -->
            <div class="marina-meta-field">
                <label>Marina Rules & Regulations (ID) PDF</label>
                <div class="pdf-upload-container">
                    <?php if ($marina_rules_id_pdf): 
                        $pdf_url = wp_get_attachment_url($marina_rules_id_pdf);
                        $pdf_filename = basename(get_attached_file($marina_rules_id_pdf));
                    ?>
                        <div class="current-pdf" id="marina_rules_id_display">
                            <strong>Current PDF:</strong> 
                            <a href="<?php echo esc_url($pdf_url); ?>" target="_blank"><?php echo esc_html($pdf_filename); ?></a>
                            <button type="button" class="button remove-pdf-btn" data-field="marina_rules_id" style="margin-left: 10px;">Remove</button>
                        </div>
                    <?php endif; ?>
                    <button type="button" class="button upload-pdf-btn" data-field="marina_rules_id">
                        <?php echo $marina_rules_id_pdf ? 'Change PDF' : 'Upload PDF'; ?>
                    </button>
                    <input type="hidden" id="marina_rules_id_pdf" name="marina_rules_id_pdf" value="<?php echo esc_attr($marina_rules_id_pdf); ?>" />
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for PDF Upload -->
    <script>
    jQuery(document).ready(function($) {
        var pdfUploaders = {};
        
        // Upload PDF
        $('.upload-pdf-btn').on('click', function(e) {
            e.preventDefault();
            var fieldName = $(this).data('field');
            var button = $(this);
            
            if (pdfUploaders[fieldName]) {
                pdfUploaders[fieldName].open();
                return;
            }
            
            pdfUploaders[fieldName] = wp.media({
                title: 'Select PDF File',
                library: { type: 'application/pdf' },
                button: { text: 'Use this PDF' },
                multiple: false
            });
            
            pdfUploaders[fieldName].on('select', function() {
                var attachment = pdfUploaders[fieldName].state().get('selection').first().toJSON();
                
                if (attachment.mime !== 'application/pdf') {
                    alert('Please select a PDF file.');
                    return;
                }
                
                $('#' + fieldName + '_pdf').val(attachment.id);
                
                var displayHtml = '<div class="current-pdf" id="' + fieldName + '_display">';
                displayHtml += '<strong>Current PDF:</strong> <a href="' + attachment.url + '" target="_blank">' + attachment.filename + '</a>';
                displayHtml += ' <button type="button" class="button remove-pdf-btn" data-field="' + fieldName + '" style="margin-left: 10px;">Remove</button>';
                displayHtml += '</div>';
                
                $('#' + fieldName + '_display').remove();
                button.before(displayHtml);
                button.text('Change PDF');
            });
            
            pdfUploaders[fieldName].open();
        });
        
        // Remove PDF
        $(document).on('click', '.remove-pdf-btn', function(e) {
            e.preventDefault();
            var fieldName = $(this).data('field');
            $('#' + fieldName + '_pdf').val('');
            $('#' + fieldName + '_display').remove();
            $('.upload-pdf-btn[data-field="' + fieldName + '"]').text('Upload PDF');
        });

        // ===== MARINA GALLERY UPLOADER =====
        var marinaGalleryUploader;

        $('#add_marina_gallery_image').on('click', function(e) {
            e.preventDefault();

            if (marinaGalleryUploader) {
                marinaGalleryUploader.open();
                return;
            }

            marinaGalleryUploader = wp.media({
                title: 'Select Images for Marina Gallery',
                button: {
                    text: 'Add to Gallery'
                },
                multiple: true,
                library: {
                    type: 'image'
                }
            });

            marinaGalleryUploader.on('select', function() {
                var attachments = marinaGalleryUploader.state().get('selection').toJSON();
                var currentCount = $('.marina-gallery-item').length;

                // Add selected images
                attachments.forEach(function(attachment, index) {
                    var imageIndex = currentCount + index;
                    var imageHtml = '<div class="marina-gallery-item" data-id="' + attachment.id + '" style="position: relative; display: inline-block; margin: 5px; cursor: move;">';
                    imageHtml += '<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" style="max-width: 100px; height: 80px; object-fit: cover; border: 2px solid #ddd;" />';
                    imageHtml += '<button type="button" class="remove-marina-gallery-image button" style="position: absolute; top: -5px; right: -5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1; padding: 0;">×</button>';
                    imageHtml += '<input type="hidden" name="marina_gallery[' + imageIndex + ']" value="' + attachment.id + '">';
                    imageHtml += '</div>';

                    $('.marina-gallery-images').append(imageHtml);
                });
            });

            marinaGalleryUploader.open();
        });

        // Remove marina gallery image
        $(document).on('click', '.remove-marina-gallery-image', function(e) {
            e.preventDefault();
            $(this).closest('.marina-gallery-item').remove();

            // Reindex the remaining images
            $('.marina-gallery-item').each(function(index) {
                $(this).find('input[type="hidden"]').attr('name', 'marina_gallery[' + index + ']');
            });
        });

        // Clear all marina gallery images
        $('#clear_marina_gallery').on('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to clear all gallery images?')) {
                $('.marina-gallery-images').empty();
            }
        });

        // Make marina gallery sortable
        if ($('.marina-gallery-images').length) {
            $('.marina-gallery-images').sortable({
                items: '.marina-gallery-item',
                cursor: 'move',
                update: function() {
                    // Reindex after sorting
                    $('.marina-gallery-item').each(function(index) {
                        $(this).find('input[type="hidden"]').attr('name', 'marina_gallery[' + index + ']');
                    });
                }
            });
        }
    });
    </script>
    <?php
}

/**
 * Save Marina Meta Data
 */
function nirup_save_marina_meta($post_id) {
    // Security checks
    if (!isset($_POST['nirup_marina_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['nirup_marina_meta_box_nonce'], 'nirup_marina_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save Hero Section
    if (isset($_POST['marina_subtitle'])) {
        update_post_meta($post_id, '_marina_subtitle', sanitize_text_field($_POST['marina_subtitle']));
    }

    if (isset($_POST['marina_title'])) {
        update_post_meta($post_id, '_marina_title', sanitize_text_field($_POST['marina_title']));
    }

    // Save Gallery
    if (isset($_POST['marina_gallery'])) {
        $gallery_images = array_map('intval', $_POST['marina_gallery']);
        update_post_meta($post_id, '_marina_gallery', $gallery_images);
    } else {
        delete_post_meta($post_id, '_marina_gallery');
    }

    // Save Berthing Descriptions
    if (isset($_POST['marina_berthing_description_1'])) {
        update_post_meta($post_id, '_marina_berthing_description_1', wp_kses_post($_POST['marina_berthing_description_1']));
    }

    if (isset($_POST['marina_berthing_description_2'])) {
        update_post_meta($post_id, '_marina_berthing_description_2', wp_kses_post($_POST['marina_berthing_description_2']));
    }

    // ============================================
    // NEW: Save PDF files - ADD THIS SECTION
    // ============================================
    if (isset($_POST['berthing_rates_pdf'])) {
        update_post_meta($post_id, '_berthing_rates_pdf', intval($_POST['berthing_rates_pdf']));
    }
    
    if (isset($_POST['arrival_procedure_pdf'])) {
        update_post_meta($post_id, '_arrival_procedure_pdf', intval($_POST['arrival_procedure_pdf']));
    }
    
    if (isset($_POST['marina_rules_en_pdf'])) {
        update_post_meta($post_id, '_marina_rules_en_pdf', intval($_POST['marina_rules_en_pdf']));
    }
    
    if (isset($_POST['marina_rules_id_pdf'])) {
        update_post_meta($post_id, '_marina_rules_id_pdf', intval($_POST['marina_rules_id_pdf']));
    }
    // ============================================

    // Save Private Charters
    if (isset($_POST['marina_charters']) && is_array($_POST['marina_charters'])) {
        $charters = array();
        foreach ($_POST['marina_charters'] as $charter) {
            $charters[] = array(
                'image' => intval($charter['image'] ?? 0),
                'name' => sanitize_text_field($charter['name'] ?? ''),
                'description' => wp_kses_post($charter['description'] ?? ''),
                'bedrooms' => sanitize_text_field($charter['bedrooms'] ?? ''),
                'bathrooms' => sanitize_text_field($charter['bathrooms'] ?? ''),
                'kitchen' => sanitize_text_field($charter['kitchen'] ?? ''),
                'meal_addon' => sanitize_text_field($charter['meal_addon'] ?? ''),
                'length' => sanitize_text_field($charter['length'] ?? ''),
                'capacity' => sanitize_text_field($charter['capacity'] ?? ''),
                'top_speed' => sanitize_text_field($charter['top_speed'] ?? ''),
                'travel_time' => sanitize_text_field($charter['travel_time'] ?? ''),
                'pricing' => wp_kses_post($charter['pricing'] ?? ''),
            );
        }
        update_post_meta($post_id, '_marina_private_charters', $charters);
    } else {
        delete_post_meta($post_id, '_marina_private_charters');
    }
}
add_action('save_post', 'nirup_save_marina_meta');

function nirup_register_private_charters() {
    $labels = array(
        'name'                  => 'Private Charters',
        'singular_name'         => 'Private Charter',
        'menu_name'             => 'Private Charters',
        'add_new'               => 'Add New Charter',
        'add_new_item'          => 'Add New Private Charter',
        'edit_item'             => 'Edit Private Charter',
        'new_item'              => 'New Private Charter',
        'view_item'             => 'View Private Charter',
        'search_items'          => 'Search Private Charters',
        'not_found'             => 'No private charters found',
        'not_found_in_trash'    => 'No private charters found in trash',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => false,
        'publicly_queryable'    => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 26,
        'menu_icon'             => 'dashicons-admin-multisite',
        'supports'              => array('title', 'thumbnail'),
        'hierarchical'          => false,
        'rewrite'               => false,
        'show_in_rest'          => false,
    );

    register_post_type('private_charter', $args);
}
add_action('init', 'nirup_register_private_charters');

function nirup_add_charter_meta_boxes() {
    add_meta_box(
        'charter_details',
        '⛵ Private Charter Details',
        'nirup_charter_details_callback',
        'private_charter',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_charter_meta_boxes');

function nirup_charter_details_callback($post) {
    wp_nonce_field('nirup_charter_meta_box', 'nirup_charter_meta_box_nonce');

    $description = get_post_meta($post->ID, '_charter_description', true);
    $specifications = get_post_meta($post->ID, '_charter_specifications', true);
    $specifications = is_array($specifications) ? $specifications : array();
    $pricing = get_post_meta($post->ID, '_charter_pricing', true);
    
    // NEW: Get booking calendar fields
    $calendar_id = get_post_meta($post->ID, '_charter_booking_calendar_id', true);
    $form_id = get_post_meta($post->ID, '_charter_booking_form_id', true);
    ?>

    <style>
        .charter-meta-box .form-group { margin-bottom: 20px; }
        .charter-meta-box label { display: block; font-weight: 600; margin-bottom: 8px; }
        .charter-meta-box input[type="text"],
        .charter-meta-box textarea { width: 100%; padding: 8px; }
        .charter-meta-box textarea { min-height: 100px; }
        .charter-meta-box .description { color: #666; font-style: italic; margin-top: 5px; }
        .spec-item { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9; position: relative; }
        .spec-item h4 { margin: 0 0 10px 0; padding-right: 100px; }
        .remove-spec { position: absolute; top: 15px; right: 15px; }
        .booking-calendar-section { 
            background: #f0f6fc; 
            border: 1px solid #0073aa; 
            padding: 20px; 
            margin: 20px 0; 
            border-radius: 4px; 
        }
        .booking-calendar-section h3 { margin-top: 0; color: #0073aa; }
    </style>

    <div class="charter-meta-box">
        <p><strong>Note:</strong> The charter name is the post title. The featured image is the main charter image.</p>

        <div class="form-group">
            <label for="charter_description">Description</label>
            <textarea id="charter_description" name="charter_description" rows="4"><?php echo esc_textarea($description); ?></textarea>
            <p class="description">Brief description of the charter</p>
        </div>

        <h3>📋 Specifications</h3>
        <p><em>Add specifications below. They will automatically split into two columns on the page.</em></p>
        
        <div id="charter-specifications-container">
            <?php if (!empty($specifications)) : ?>
                <?php foreach ($specifications as $index => $spec) : ?>
                    <div class="spec-item" data-spec-index="<?php echo $index; ?>">
                        <h4>Specification #<?php echo $index + 1; ?></h4>
                        <button type="button" class="button button-secondary remove-spec">Remove</button>
                        
                        <div class="form-group">
                            <label>Specification Text</label>
                            <input type="text" name="charter_specifications[<?php echo $index; ?>][text]" value="<?php echo esc_attr($spec['text'] ?? ''); ?>" placeholder="e.g., 3 bedrooms, Length: 21.58 m, Capacity: 15 Max">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <button type="button" class="button button-primary" id="add-specification">Add Specification</button>

        <h3>💵 Pricing</h3>

        <div class="form-group">
            <label for="charter_pricing">Pricing Information</label>
            <textarea id="charter_pricing" name="charter_pricing" rows="5"><?php echo esc_textarea($pricing); ?></textarea>
            <p class="description">Add pricing details. Use line breaks for multiple routes.</p>
        </div>

        <!-- NEW: Booking Calendar Section -->
        <div class="booking-calendar-section">
            <h3>📅 WP Booking System Calendar</h3>
            
            <div class="form-group">
                <label for="charter_booking_calendar_id">WP Booking Calendar ID</label>
                <input type="text" 
                       id="charter_booking_calendar_id" 
                       name="charter_booking_calendar_id" 
                       value="<?php echo esc_attr($calendar_id); ?>" 
                       placeholder="e.g., 1">
                <p class="description">
                    Enter the WP Booking System calendar ID for this charter.<br>
                    Find it in: <strong>WP Booking System > Calendars</strong>
                </p>
            </div>

            <div class="form-group">
                <label for="charter_booking_form_id">WP Booking Form ID</label>
                <input type="text" 
                       id="charter_booking_form_id" 
                       name="charter_booking_form_id" 
                       value="<?php echo esc_attr($form_id); ?>" 
                       placeholder="e.g., 1">
                <p class="description">
                    Enter the WP Booking System form ID to attach to the calendar.<br>
                    Find it in: <strong>WP Booking System > Forms</strong>
                </p>
            </div>

            <?php if (class_exists('WP_Booking_System')) : ?>
                <p style="padding: 10px; background: #d4edda; border-left: 3px solid #28a745; margin-top: 10px;">
                    ✓ WP Booking System is active
                </p>
            <?php else : ?>
                <p style="padding: 10px; background: #f8d7da; border-left: 3px solid #dc3545; margin-top: 10px;">
                    ⚠ WP Booking System plugin not detected. Please install and activate it.
                </p>
            <?php endif; ?>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        let specIndex = <?php echo count($specifications); ?>;

        // Add Specification
        $('#add-specification').on('click', function() {
            const html = `
                <div class="spec-item" data-spec-index="${specIndex}">
                    <h4>Specification #${specIndex + 1}</h4>
                    <button type="button" class="button button-secondary remove-spec">Remove</button>
                    
                    <div class="form-group">
                        <label>Specification Text</label>
                        <input type="text" name="charter_specifications[${specIndex}][text]" placeholder="e.g., 3 bedrooms, Length: 21.58 m, Capacity: 15 Max">
                    </div>
                </div>
            `;
            $('#charter-specifications-container').append(html);
            specIndex++;
        });

        // Remove Specification
        $(document).on('click', '.remove-spec', function() {
            if (confirm('Are you sure you want to remove this specification?')) {
                $(this).closest('.spec-item').remove();
            }
        });
    });
    </script>
    <?php
}

function nirup_save_charter_meta($post_id) {
    if (!isset($_POST['nirup_charter_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['nirup_charter_meta_box_nonce'], 'nirup_charter_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save Description
    if (isset($_POST['charter_description'])) {
        update_post_meta($post_id, '_charter_description', wp_kses_post($_POST['charter_description']));
    }

    // Save Specifications
    if (isset($_POST['charter_specifications']) && is_array($_POST['charter_specifications'])) {
        $specifications = array();
        foreach ($_POST['charter_specifications'] as $spec) {
            if (!empty($spec['text'])) {
                $specifications[] = array(
                    'text' => sanitize_text_field($spec['text'])
                );
            }
        }
        update_post_meta($post_id, '_charter_specifications', $specifications);
    } else {
        delete_post_meta($post_id, '_charter_specifications');
    }

    // Save Pricing
    if (isset($_POST['charter_pricing'])) {
        update_post_meta($post_id, '_charter_pricing', wp_kses_post($_POST['charter_pricing']));
    }

    // NEW: Save Booking Calendar ID
    if (isset($_POST['charter_booking_calendar_id'])) {
        update_post_meta(
            $post_id, 
            '_charter_booking_calendar_id', 
            sanitize_text_field($_POST['charter_booking_calendar_id'])
        );
    }

    // NEW: Save Booking Form ID
    if (isset($_POST['charter_booking_form_id'])) {
        update_post_meta(
            $post_id, 
            '_charter_booking_form_id', 
            sanitize_text_field($_POST['charter_booking_form_id'])
        );
    }
}
add_action('save_post_private_charter', 'nirup_save_charter_meta');

function nirup_getting_here_page_assets() {
    // Load on Getting Here page OR front page (homepage)
    if (is_page_template('page-getting-here.php') || is_front_page()) {
        // Enqueue CSS
        wp_enqueue_style(
            'nirup-getting-here-css',
            get_template_directory_uri() . '/assets/css/page-getting-here.css',
            array(),
            '1.0.0'
        );
    
        // Get Google Maps API key
        $google_maps_api_key = get_theme_mod('nirup_google_maps_api_key', '');
        
        if ($google_maps_api_key) {
            // First load our custom script with the callback function
            wp_enqueue_script(
                'nirup-getting-here-js',
                get_template_directory_uri() . '/assets/js/getting-here.js',
                array('jquery'),
                '1.0.3',
                true // Load in footer
            );
            
            // Then load Google Maps API (depends on our script)
            wp_enqueue_script(
                'google-maps-api',
                'https://maps.googleapis.com/maps/api/js?key=' . esc_attr($google_maps_api_key) . '&libraries=geometry&callback=initNirupMap',
                array('nirup-getting-here-js'), // Depends on our script
                null,
                true // Load in footer AFTER our script
            );
        } else {
            wp_enqueue_script(
                'nirup-getting-here-js',
                get_template_directory_uri() . '/assets/js/getting-here.js',
                array('jquery'),
                '1.0.3',
                true
            );
        }

        // Localize script with map data
        wp_localize_script('nirup-getting-here-js', 'nirupGettingHere', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('nirup_getting_here_nonce'),
            'hasApiKey' => !empty($google_maps_api_key),
            'strings' => array(
                'loadingMap' => __('Loading interactive map...', 'nirup-island'),
                'nirupIsland' => __('Nirup Island', 'nirup-island'),
                'singapore' => __('Singapore Terminal', 'nirup-island'),
                'batam' => __('Batam Terminal', 'nirup-island'),
                'ferryRoute' => __('Ferry Route', 'nirup-island'),
            ),
        ));
    }
}
add_action('wp_enqueue_scripts', 'nirup_getting_here_page_assets');

function nirup_getting_here_page_customizer($wp_customize) {
    
    // Add Getting Here Page Section
    $wp_customize->add_section('nirup_getting_here_page', array(
        'title' => __('Getting Here Page', 'nirup-island'),
        'priority' => 35,
    ));
    
    // ===== HERO SECTION =====
    $wp_customize->add_setting('nirup_getting_here_hero_title', array(
        'default' => __('Getting Here', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_getting_here_hero_title', array(
        'label' => __('Hero Title', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_getting_here_hero_subtitle', array(
        'default' => __('Find the easiest way to reach Nirup Island', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_getting_here_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // ===== FERRY DEPARTURES SECTION =====
    $wp_customize->add_setting('nirup_getting_here_ferry_title', array(
        'default' => __('Ferry Departures', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_getting_here_ferry_title', array(
        'label' => __('Ferry Departures Title', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_getting_here_ferry_subtitle', array(
        'default' => __('Nirup Island is served by direct ferry links from both Singapore & Batam with 12 weekly trips from Singapore and daily trips from Batam.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('nirup_getting_here_ferry_subtitle', array(
        'label' => __('Ferry Departures Subtitle', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'textarea',
    ));
    
    // ===== TAB LABELS =====
    $wp_customize->add_setting('nirup_singapore_to_nirup_tab', array(
        'default' => __('Singapore → Nirup', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_singapore_to_nirup_tab', array(
        'label' => __('Singapore to Nirup Tab', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_nirup_to_singapore_tab', array(
        'default' => __('Nirup → Singapore', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_nirup_to_singapore_tab', array(
        'label' => __('Nirup to Singapore Tab', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_batam_to_nirup_tab', array(
        'default' => __('Batam → Nirup', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_batam_to_nirup_tab', array(
        'label' => __('Batam to Nirup Tab', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_nirup_to_batam_tab', array(
        'default' => __('Nirup → Batam', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_nirup_to_batam_tab', array(
        'label' => __('Nirup to Batam Tab', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_book_ticket_singapore_url', array(
    'default' => '#',
    'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('nirup_book_ticket_singapore_url', array(
        'label' => __('Singapore Ferry - Book Ticket Button URL', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'url',
        'description' => __('URL for the Singapore route booking button', 'nirup-island'),
    ));

    // Batam Ferry Ticket Button URL
    $wp_customize->add_setting('nirup_book_ticket_batam_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('nirup_book_ticket_batam_url', array(
        'label' => __('Batam Ferry - Book Ticket Button URL', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'url',
        'description' => __('URL for the Batam route booking button', 'nirup-island'),
    ));
    
    // ===== DEPARTURE POINTS =====
    $wp_customize->add_setting('nirup_singapore_departure_point', array(
        'default' => __('HarbourFront Centre', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_singapore_departure_point', array(
        'label' => __('Singapore Departure Point', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_batam_departure_point', array(
        'default' => __('HarbourBay Ferry Terminal', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_batam_departure_point', array(
        'label' => __('Batam Departure Point', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_nirup_departure_point', array(
        'default' => __('Nirup Island Ferry Terminal', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_nirup_departure_point', array(
        'label' => __('Nirup Island Departure Point', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // ===== TABLE HEADERS =====
    $wp_customize->add_setting('nirup_ferry_table_route', array(
        'default' => __('Route', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_ferry_table_route', array(
        'label' => __('Table Header: Route', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_ferry_table_etd', array(
        'default' => __('ETD', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_ferry_table_etd', array(
        'label' => __('Table Header: ETD', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_ferry_table_eta', array(
        'default' => __('ETA', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_ferry_table_eta', array(
        'label' => __('Table Header: ETA', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_ferry_table_days', array(
        'default' => __('Days', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_ferry_table_days', array(
        'label' => __('Table Header: Days', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // ===== SIDEBAR LABELS =====
    $wp_customize->add_setting('nirup_sidebar_operator_label', array(
        'default' => __('Operator', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_sidebar_operator_label', array(
        'label' => __('Sidebar Label: Operator', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_sidebar_duration_label', array(
        'default' => __('Duration', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_sidebar_duration_label', array(
        'label' => __('Sidebar Label: Duration', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));

    // Work Days Label
    $wp_customize->add_setting('nirup_sidebar_workdays_label', array(
        'default' => __('Work Days', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_sidebar_workdays_label', array(
        'label' => __('Sidebar: "Work Days" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for work days in the sidebar', 'nirup-island'),
    ));
    
    // Price Label
    $wp_customize->add_setting('nirup_sidebar_price_label', array(
        'default' => __('Price', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_sidebar_price_label', array(
        'label' => __('Sidebar: "Price" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for price in the sidebar', 'nirup-island'),
    ));
    
    // ===== SINGAPORE SIDEBAR VALUES =====
    
    // Singapore Work Days
    $wp_customize->add_setting('nirup_singapore_workdays', array(
        'default' => __('Friday – Sunday', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_singapore_workdays', array(
        'label' => __('Singapore: Work Days', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Operating days for Singapore route', 'nirup-island'),
    ));
    
    // Singapore Price
    $wp_customize->add_setting('nirup_singapore_price', array(
        'default' => __('SGD 76 /per way', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_singapore_price', array(
        'label' => __('Singapore: Price', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Price for Singapore route', 'nirup-island'),
    ));
    
    // ===== BATAM SIDEBAR VALUES =====
    
    // Batam Work Days
    $wp_customize->add_setting('nirup_batam_workdays', array(
        'default' => __('Daily / Friday – Sunday', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_batam_workdays', array(
        'label' => __('Batam: Work Days', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Operating days for Batam route', 'nirup-island'),
    ));
    
    // Batam Price
    $wp_customize->add_setting('nirup_batam_price', array(
        'default' => __('Rp150,000 /per way', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_batam_price', array(
        'label' => __('Batam: Price', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Price for Batam route', 'nirup-island'),
    ));
    
    // ===== CHECK-IN VALUES FOR ROUTES =====
    
    // Singapore to Nirup Check-in
    $wp_customize->add_setting('nirup_singapore_to_nirup_checkin', array(
        'default' => __('Horizon Fast Ferry Counter (Harbour Front Centre, #03-47)', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_singapore_to_nirup_checkin', array(
        'label' => __('Singapore to Nirup: Check-in Location', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Check-in location for Singapore to Nirup route', 'nirup-island'),
    ));
    
    
    // Batam to Nirup Check-in
    $wp_customize->add_setting('nirup_batam_to_nirup_checkin', array(
        'default' => __('Horizon Fast Ferry counter (Bayfront Mall, 2nd floor)', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_batam_to_nirup_checkin', array(
        'label' => __('Batam to Nirup: Check-in Location', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Check-in location for Batam to Nirup route', 'nirup-island'),
    ));
    
    
    $wp_customize->add_setting('nirup_sidebar_checkin_label', array(
        'default' => __('Check In', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_sidebar_checkin_label', array(
        'label' => __('Sidebar Label: Check In', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // ===== SIDEBAR VALUES - SINGAPORE =====
    $wp_customize->add_setting('nirup_singapore_operator', array(
        'default' => __('Sindo Ferry', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_singapore_operator', array(
        'label' => __('Singapore Operator', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_singapore_duration', array(
        'default' => __('1 hr', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_singapore_duration', array(
        'label' => __('Singapore Duration', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // ===== SIDEBAR VALUES - BATAM =====
    $wp_customize->add_setting('nirup_batam_operator', array(
        'default' => __('Sindo Ferry', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_batam_operator', array(
        'label' => __('Batam Operator', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_batam_duration', array(
        'default' => __('20 min', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_batam_duration', array(
        'label' => __('Batam Duration', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    
    // ===== BOOK TICKET BUTTON =====
    $wp_customize->add_setting('nirup_book_ticket_text', array(
        'default' => __('Book Your Ticket', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_book_ticket_text', array(
        'label' => __('Book Ticket Button Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // ===== LUGGAGE SECTION =====
    $wp_customize->add_setting('nirup_getting_here_luggage_title', array(
        'default' => __('Luggage Information', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_getting_here_luggage_title', array(
        'label' => __('Luggage Section Title', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_luggage_singapore_title', array(
        'default' => __('Singapore Departure', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_title', array(
        'label' => __('Luggage: Singapore Title', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));

    // Singapore Free Label
    $wp_customize->add_setting('nirup_luggage_singapore_free_label', array(
        'default' => __('Free', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_free_label', array(
        'label' => __('Singapore: "Free" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for free luggage allowance', 'nirup-island'),
    ));
    
    // Singapore Check-in Label
    $wp_customize->add_setting('nirup_luggage_singapore_checkin_label', array(
        'default' => __('Check-in', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_checkin_label', array(
        'label' => __('Singapore: "Check-in" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for check-in time', 'nirup-island'),
    ));
    
    // Singapore Excess Label
    $wp_customize->add_setting('nirup_luggage_singapore_excess_label', array(
        'default' => __('Excess', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_excess_label', array(
        'label' => __('Singapore: "Excess" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for excess luggage fees', 'nirup-island'),
    ));
    
    // Singapore Counters Label
    $wp_customize->add_setting('nirup_luggage_singapore_counters_label', array(
        'default' => __('Counters', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_counters_label', array(
        'label' => __('Singapore: "Counters" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for counter location', 'nirup-island'),
    ));
    
    
    // Singapore Free Luggage Text
    $wp_customize->add_setting('nirup_luggage_singapore_free', array(
        'default' => __('20 kg / boarding pass', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_free', array(
        'label' => __('Singapore: Free Luggage Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Free luggage allowance for Singapore departure', 'nirup-island'),
    ));
    
    // Singapore Check-in Text
    $wp_customize->add_setting('nirup_luggage_singapore_checkin', array(
        'default' => __('60–20 min before departure', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_checkin', array(
        'label' => __('Singapore: Check-in Time Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Check-in time for Singapore departure', 'nirup-island'),
    ));
    
    // Singapore Excess Luggage Text
    $wp_customize->add_setting('nirup_luggage_singapore_excess', array(
        'default' => __('$1 per kg (max 40 kg)', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_excess', array(
        'label' => __('Singapore: Excess Luggage Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Excess luggage fees for Singapore departure', 'nirup-island'),
    ));
    
    // Singapore Counters Text
    $wp_customize->add_setting('nirup_luggage_singapore_counters', array(
        'default' => __('Next to immigration gate', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_counters', array(
        'label' => __('Singapore: Counter Location Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Counter location for Singapore departure', 'nirup-island'),
    ));
    
    $wp_customize->add_setting('nirup_luggage_batam_title', array(
        'default' => __('Batam Departure', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_title', array(
        'label' => __('Luggage: Batam Title', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // Batam Free Label
    $wp_customize->add_setting('nirup_luggage_batam_free_label', array(
        'default' => __('Free', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_free_label', array(
        'label' => __('Batam: "Free" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for free luggage allowance', 'nirup-island'),
    ));
    
    // Batam Check-in Label
    $wp_customize->add_setting('nirup_luggage_batam_checkin_label', array(
        'default' => __('Check-in', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_checkin_label', array(
        'label' => __('Batam: "Check-in" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for check-in time', 'nirup-island'),
    ));
    
    // Batam Excess Label
    $wp_customize->add_setting('nirup_luggage_batam_excess_label', array(
        'default' => __('Excess', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_excess_label', array(
        'label' => __('Batam: "Excess" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for excess luggage fees', 'nirup-island'),
    ));
    
    // Batam Counters Label
    $wp_customize->add_setting('nirup_luggage_batam_counters_label', array(
        'default' => __('Counters', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_counters_label', array(
        'label' => __('Batam: "Counters" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for counter location', 'nirup-island'),
    ));
    
    // ===== BATAM LUGGAGE VALUES =====
    
    // Batam Free Luggage Text
    $wp_customize->add_setting('nirup_luggage_batam_free', array(
        'default' => __('20 kg / boarding pass', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_free', array(
        'label' => __('Batam: Free Luggage Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Free luggage allowance for Batam departure', 'nirup-island'),
    ));
    
    // Batam Check-in Text
    $wp_customize->add_setting('nirup_luggage_batam_checkin', array(
        'default' => __('60–20 min before departure', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_checkin', array(
        'label' => __('Batam: Check-in Time Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Check-in time for Batam departure', 'nirup-island'),
    ));
    
    // Batam Excess Luggage Text
    $wp_customize->add_setting('nirup_luggage_batam_excess', array(
        'default' => __('$1 per kg (max 40 kg)', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_excess', array(
        'label' => __('Batam: Excess Luggage Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Excess luggage fees for Batam departure', 'nirup-island'),
    ));
    
    // Batam Counters Text
    $wp_customize->add_setting('nirup_luggage_batam_counters', array(
        'default' => __('Next to immigration gate', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_counters', array(
        'label' => __('Batam: Counter Location Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Counter location for Batam departure', 'nirup-island'),
    ));
    
    // ===== VISA SECTION =====
    $wp_customize->add_setting('nirup_getting_here_visa_title', array(
        'default' => __('Visa Requirements', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_getting_here_visa_title', array(
        'label' => __('Visa Section Title', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_getting_here_visa_subtitle', array(
        'default' => __('Entering Nirup Island follows the same process as any Indonesian island.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_getting_here_visa_subtitle', array(
        'label' => __('Visa Section Subtitle', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // $wp_customize->add_setting('nirup_visa_free_text', array(
    //     'default' => __('Visa Free Countries', 'nirup-island'),
    //     'sanitize_callback' => 'sanitize_text_field',
    // ));
    // $wp_customize->add_control('nirup_visa_free_text', array(
    //     'label' => __('Visa Free Button Text', 'nirup-island'),
    //     'section' => 'nirup_getting_here_page',
    //     'type' => 'text',
    // ));
    
    // $wp_customize->add_setting('nirup_visa_free_url', array(
    //     'default' => '#',
    //     'sanitize_callback' => 'esc_url_raw',
    // ));
    // $wp_customize->add_control('nirup_visa_free_url', array(
    //     'label' => __('Visa Free Button URL', 'nirup-island'),
    //     'section' => 'nirup_getting_here_page',
    //     'type' => 'url',
    // ));
    
    $wp_customize->add_setting('nirup_visa_on_arrival_text', array(
        'default' => __('Visa-On-Arrival Countries', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_visa_on_arrival_text', array(
        'label' => __('Visa On Arrival Button Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_visa_on_arrival_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('nirup_visa_on_arrival_url', array(
        'label' => __('Visa On Arrival Button URL', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'url',
    ));
}
add_action('customize_register', 'nirup_getting_here_page_customizer');

// Include Ferry Map Customizer Settings
require_once get_template_directory() . '/inc/customizer-map.php';

// Include Experiences Customizer Settings
require_once get_template_directory() . '/inc/customizer-experiences.php';

function nirup_enqueue_ferry_map_styles() {
    // Only load on pages that use the map
    if (is_front_page() || is_page_template('page-templates/page-getting-here.php')) {
        wp_enqueue_style(
            'nirup-ferry-map',
            get_template_directory_uri() . '/assets/css/ferry-map.css',
            array(),
            '1.0.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_ferry_map_styles');

function nirup_enqueue_private_events_assets() {
    if (is_page_template('page-private-events.php')) {
        // CSS
        wp_enqueue_style(
            'nirup-private-events',
            get_template_directory_uri() . '/assets/css/private-events.css',
            array(),
            '1.0.0'
        );
        
        // JS
        wp_enqueue_script(
            'nirup-private-events',
            get_template_directory_uri() . '/assets/js/private-events.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_private_events_assets');

/**
 * Handle Private Events Form Submission
 */
function nirup_private_events_form_submit() {
    // Check nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'private_events_form_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed.'));
        return;
    }
    
    // Get and sanitize form data
    $form_data = isset($_POST['form_data']) ? $_POST['form_data'] : array();
    
    $name = sanitize_text_field($form_data['name']);
    $email = sanitize_email($form_data['email']);
    $phone = sanitize_text_field($form_data['phone']);
    $event_type = sanitize_text_field($form_data['event_type']);
    $event_date = sanitize_text_field($form_data['event_date']);
    $guest_count = sanitize_text_field($form_data['guest_count']);
    $message = sanitize_textarea_field($form_data['message']);
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($event_type) || empty($message)) {
        wp_send_json_error(array('message' => 'Please fill in all required fields.'));
        return;
    }
    
    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'));
        return;
    }
    
    // Store submission in database FIRST
    nirup_store_private_event_submission($name, $email, $phone, $event_type, $event_date, $guest_count, $message);
    error_log('Private Events Form - Submission saved to database');
    
    // Get email settings from customizer
    $admin_email = get_theme_mod('nirup_private_events_form_email', 'explore@nirupisland.com');
    $from_email = get_theme_mod('nirup_private_events_form_from_email', 'explore@nirupisland.com');
    $from_name = get_bloginfo('name');
    
    error_log('Private Events Form - Admin email: ' . $admin_email);
    error_log('Private Events Form - From email: ' . $from_email);
    error_log('Private Events Form - User email: ' . $email);
    
    // ==========================================
    // EMAIL 1: ADMIN NOTIFICATION (Internal)
    // ==========================================
    $admin_subject = '[' . get_bloginfo('name') . '] New Private Event Request from ' . $name;
    
    $admin_body = "New private event request:\n\n";
    $admin_body .= "Name: " . $name . "\n";
    $admin_body .= "Email: " . $email . "\n";
    $admin_body .= "Phone: " . (!empty($phone) ? $phone : 'Not provided') . "\n";
    $admin_body .= "Event Type: " . $event_type . "\n";
    $admin_body .= "Preferred Date: " . (!empty($event_date) ? date('F j, Y', strtotime($event_date)) : 'Not specified') . "\n";
    $admin_body .= "Number of Guests: " . (!empty($guest_count) ? $guest_count : 'Not specified') . "\n\n";
    $admin_body .= "Additional Details:\n" . $message . "\n\n";
    $admin_body .= "---\n";
    $admin_body .= "This email was sent from the private events form on " . get_bloginfo('url') . "\n";
    $admin_body .= "Submitted on: " . current_time('F j, Y g:i A');
    
    $admin_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );
    
    // ==========================================
    // EMAIL 2: USER CONFIRMATION (Customer)
    // ==========================================
    
    // Get customizable email content
    $user_subject_template = get_theme_mod('nirup_private_events_confirmation_subject', 'Thank you for your event inquiry - {site_name}');
    $user_body_template = get_theme_mod('nirup_private_events_confirmation_body', "Dear {user_name},\n\nThank you for your interest in hosting your event at {site_name}. We have received your request and our events team is reviewing the details.\n\nEvent Request Summary:\nEvent Type: {event_type}\nPreferred Date: {event_date}\nExpected Guests: {guest_count}\n\nOur events coordinator will contact you within 1-2 business days with a customized proposal tailored to your needs.\n\nIf you have any immediate questions, please don't hesitate to call us at {phone_number}.\n\nWe look forward to making your event extraordinary!\n\nWarm regards,\nThe {site_name} Events Team");
    $user_footer_template = get_theme_mod('nirup_private_events_confirmation_footer', "---\nThis is an automated confirmation email. Please do not reply to this message.");
    
    // Replace placeholders with actual values
    $replacements = array(
        '{site_name}' => get_bloginfo('name'),
        '{user_name}' => $name,
        '{user_email}' => $email,
        '{user_phone}' => !empty($phone) ? $phone : 'Not provided',
        '{event_type}' => $event_type,
        '{event_date}' => !empty($event_date) ? date('F j, Y', strtotime($event_date)) : 'Not specified',
        '{guest_count}' => !empty($guest_count) ? $guest_count : 'Not specified',
        '{phone_number}' => get_theme_mod('nirup_contact_phone_primary', '+62 811 6220 999')
    );
    
    // Apply replacements
    $user_subject = str_replace(array_keys($replacements), array_values($replacements), $user_subject_template);
    $user_body = str_replace(array_keys($replacements), array_values($replacements), $user_body_template);
    $user_footer = str_replace(array_keys($replacements), array_values($replacements), $user_footer_template);
    
    // Combine body and footer
    $user_body = $user_body . "\n\n" . $user_footer;
    
    $user_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>'
    );
    
    // ==========================================
    // SEND BOTH EMAILS
    // ==========================================
    
    // Send admin notification
    error_log('Private Events Form - Attempting to send admin email to: ' . $admin_email);
    $admin_mail_sent = wp_mail($admin_email, $admin_subject, $admin_body, $admin_headers);
    error_log('Private Events Form - Admin email result: ' . ($admin_mail_sent ? 'SUCCESS' : 'FAILED'));
    
    // Send user confirmation
    error_log('Private Events Form - Attempting to send user email to: ' . $email);
    $user_mail_sent = wp_mail($email, $user_subject, $user_body, $user_headers);
    error_log('Private Events Form - User email result: ' . ($user_mail_sent ? 'SUCCESS' : 'FAILED'));
    
    // Check for PHPMailer errors
    if (!$admin_mail_sent || !$user_mail_sent) {
        global $phpmailer;
        if (isset($phpmailer) && !empty($phpmailer->ErrorInfo)) {
            error_log('Private Events Form - PHPMailer Error: ' . $phpmailer->ErrorInfo);
        }
    }
    
    // ==========================================
    // RETURN RESPONSE
    // ==========================================
    
    // Return success if at least one email sent
    if ($admin_mail_sent || $user_mail_sent) {
        wp_send_json_success(array(
            'message' => 'Your event request has been received! We will respond within 1-2 business days.',
            'admin_sent' => $admin_mail_sent,
            'user_sent' => $user_mail_sent
        ));
    } else {
        // Both failed but data is saved
        wp_send_json_success(array(
            'message' => 'Your event request has been saved! We will respond within 1-2 business days.',
            'admin_sent' => false,
            'user_sent' => false
        ));
    }
}
add_action('wp_ajax_nirup_private_events_form_submit', 'nirup_private_events_form_submit');
add_action('wp_ajax_nopriv_nirup_private_events_form_submit', 'nirup_private_events_form_submit');

/**
 * Store Private Event Submission in Database
 */
function nirup_store_private_event_submission($name, $email, $phone, $event_type, $event_date, $guest_count, $message) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'private_event_submissions';
    
    // Create table if it doesn't exist
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        nirup_create_private_event_submissions_table();
    }
    
    // Insert submission
    $result = $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'event_type' => $event_type,
            'event_date' => $event_date,
            'guest_count' => $guest_count,
            'message' => $message,
            'submission_date' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );
    
    if ($result === false) {
        error_log('Private Events Form - Database storage failed: ' . $wpdb->last_error);
    } else {
        error_log('Private Events Form - Submission saved to database successfully');
    }
}

/**
 * Create Private Event Submissions Table
 */
function nirup_create_private_event_submissions_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'private_event_submissions';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(100) DEFAULT '',
        event_type varchar(255) NOT NULL,
        event_date date DEFAULT NULL,
        guest_count varchar(50) DEFAULT '',
        message text NOT NULL,
        submission_date datetime NOT NULL,
        status varchar(20) DEFAULT 'new',
        PRIMARY KEY (id),
        KEY email (email),
        KEY submission_date (submission_date),
        KEY status (status)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function nirup_private_events_customizer($wp_customize) {
    
    // ===========================
    // PRIVATE EVENTS PAGE CONTENT
    // ===========================
    
    $wp_customize->add_section('nirup_private_events_content', array(
        'title' => __('Private Events Page Content', 'nirup-island'),
        'priority' => 47,
        'description' => __('Customize all text and images on the private events page', 'nirup-island'),
    ));
    
    // Page Title
    $wp_customize->add_setting('nirup_private_events_title', array(
        'default' => __('PRIVATE EVENTS', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_private_events_title', array(
        'label' => __('Page Title', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 10,
    ));
    
    // Hero Image
    $wp_customize->add_setting('nirup_private_events_hero_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_private_events_hero_image', array(
        'label' => __('Hero Background Image', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'mime_type' => 'image',
        'priority' => 15,
    )));
    
    // Hero Subtitle
    $wp_customize->add_setting('nirup_private_events_hero_subtitle', array(
        'default' => __('Versatile venues where elegance meets island beauty — ideal for meetings, weddings, and celebrations', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_private_events_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'textarea',
        'priority' => 20,
    ));
    
    // Section Title
    $wp_customize->add_setting('nirup_private_events_section_title', array(
        'default' => __('EVENTS', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_private_events_section_title', array(
        'label' => __('Section Title', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 25,
    ));
    
    // Section Description
    $wp_customize->add_setting('nirup_private_events_section_description', array(
        'default' => __('Versatile venues for weddings, meetings, and private celebrations on Nirup Island, offering elegant spaces, breathtaking views, and tailored experiences to make every event truly unforgettable.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_private_events_section_description', array(
        'label' => __('Section Description', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'textarea',
        'priority' => 26,
    ));
    
    // ===========================
    // CARD 1: BALLROOM
    // ===========================
    
    $wp_customize->add_setting('nirup_event_ballroom_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_event_ballroom_image', array(
        'label' => __('Ballroom - Image', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'mime_type' => 'image',
        'priority' => 30,
    )));
    
    $wp_customize->add_setting('nirup_event_ballroom_location', array(
        'default' => __('Westin Nirup Island Resort & Spa', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_ballroom_location', array(
        'label' => __('Ballroom - Venue Name', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 31,
    ));
    
    $wp_customize->add_setting('nirup_event_ballroom_title', array(
        'default' => __('BALLROOM', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_ballroom_title', array(
        'label' => __('Ballroom - Title', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 32,
    ));
    
    $wp_customize->add_setting('nirup_event_ballroom_description', array(
        'default' => __('Celebrate life\'s most important moments at Nirup Island\'s elegant ballroom. Perfect for weddings, anniversaries, and milestone events, the ballroom offers a pillarless 450 sqm space that can be transformed to match your vision. With breathtaking views and access to the island\'s unique venues, your celebration becomes truly unforgettable.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_ballroom_description', array(
        'label' => __('Ballroom - Description', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'textarea',
        'priority' => 33,
    ));
    
    // ===========================
    // CARD 2: MEETING ROOMS
    // ===========================
    
    $wp_customize->add_setting('nirup_event_meeting_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_event_meeting_image', array(
        'label' => __('Meeting Rooms - Image', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'mime_type' => 'image',
        'priority' => 40,
    )));
    
    $wp_customize->add_setting('nirup_event_meeting_location', array(
        'default' => __('Westin Nirup Island Resort & Spa', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_meeting_location', array(
        'label' => __('Meeting Rooms - Venue Name', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 41,
    ));
    
    $wp_customize->add_setting('nirup_event_meeting_title', array(
        'default' => __('MEETING ROOMS', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_meeting_title', array(
        'label' => __('Meeting Rooms - Title', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 42,
    ));
    
    $wp_customize->add_setting('nirup_event_meeting_description', array(
        'default' => __('Designed for productivity and collaboration, our meeting rooms combine a professional setting with the island\'s calming atmosphere. Ideal for board meetings, team workshops, or small conferences, each space offers flexible layouts, modern amenities, and the option to be combined for larger gatherings.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_meeting_description', array(
        'label' => __('Meeting Rooms - Description', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'textarea',
        'priority' => 43,
    ));
    
    // ===========================
    // CARD 3: WEDDINGS
    // ===========================
    
    $wp_customize->add_setting('nirup_event_wedding_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_event_wedding_image', array(
        'label' => __('Weddings - Image', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'mime_type' => 'image',
        'priority' => 50,
    )));
    
    $wp_customize->add_setting('nirup_event_wedding_location', array(
        'default' => __('Nirup Island', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_wedding_location', array(
        'label' => __('Weddings - Venue Name', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 51,
    ));
    
    $wp_customize->add_setting('nirup_event_wedding_title', array(
        'default' => __('WEDDINGS', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_wedding_title', array(
        'label' => __('Weddings - Title', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 52,
    ));
    
    $wp_customize->add_setting('nirup_event_wedding_description', array(
        'default' => __('Exchange vows against the backdrop of shimmering waters and lush landscapes. Nirup Island offers an enchanting setting for weddings of every scale — from intimate ceremonies to grand celebrations. Our team perfects every detail—from custom décor to curated dining—creating memories that last a lifetime.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_wedding_description', array(
        'label' => __('Weddings - Description', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'textarea',
        'priority' => 53,
    ));
    
    // ===========================
    // FORM SECTION
    // ===========================
    
    $wp_customize->add_section('nirup_private_events_form_settings', array(
        'title' => __('Private Events Form Settings', 'nirup-island'),
        'priority' => 48,
    ));
    
    // Form Title
    $wp_customize->add_setting('nirup_private_events_form_title', array(
        'default' => __('INQUIRE ABOUT AN EVENT', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_private_events_form_title', array(
        'label' => __('Form Section Title', 'nirup-island'),
        'section' => 'nirup_private_events_form_settings',
        'type' => 'text',
        'priority' => 10,
    ));
    
    // Form Description
    $wp_customize->add_setting('nirup_private_events_form_description', array(
        'default' => __('Ready to create an unforgettable experience? Get in touch with our team today to start planning your event.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_private_events_form_description', array(
        'label' => __('Form Section Description', 'nirup-island'),
        'section' => 'nirup_private_events_form_settings',
        'type' => 'textarea',
        'priority' => 15,
    ));
    
    // Admin Recipient Email
    $wp_customize->add_setting('nirup_private_events_form_email', array(
        'default' => 'explore@nirupisland.com',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_private_events_form_email', array(
        'label' => __('Admin Recipient Email', 'nirup-island'),
        'description' => __('Where event inquiries will be sent', 'nirup-island'),
        'section' => 'nirup_private_events_form_settings',
        'type' => 'email',
        'priority' => 20,
    ));
    
    // From Email Address
    $wp_customize->add_setting('nirup_private_events_form_from_email', array(
        'default' => 'explore@nirupisland.com',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_private_events_form_from_email', array(
        'label' => __('From Email Address', 'nirup-island'),
        'description' => __('Email address that will appear in the "From" field', 'nirup-island'),
        'section' => 'nirup_private_events_form_settings',
        'type' => 'email',
        'priority' => 25,
    ));
    
    // Confirmation Email Subject
    $wp_customize->add_setting('nirup_private_events_confirmation_subject', array(
        'default' => __('Thank you for your event inquiry - {site_name}', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_private_events_confirmation_subject', array(
        'label' => __('Confirmation Email Subject', 'nirup-island'),
        'section' => 'nirup_private_events_form_settings',
        'type' => 'text',
        'description' => __('Available tag: {site_name}', 'nirup-island'),
        'priority' => 30,
    ));
    
    // Confirmation Email Body
    $wp_customize->add_setting('nirup_private_events_confirmation_body', array(
        'default' => __("Dear {user_name},\n\nThank you for your interest in hosting your event at {site_name}. We have received your request and our events team is reviewing the details.\n\nEvent Request Summary:\nEvent Type: {event_type}\nPreferred Date: {event_date}\nExpected Guests: {guest_count}\n\nOur events coordinator will contact you within 1-2 business days with a customized proposal tailored to your needs.\n\nIf you have any immediate questions, please don't hesitate to call us at {phone_number}.\n\nWe look forward to making your event extraordinary!\n\nWarm regards,\nThe {site_name} Events Team", 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_private_events_confirmation_body', array(
        'label' => __('Confirmation Email Body', 'nirup-island'),
        'section' => 'nirup_private_events_form_settings',
        'type' => 'textarea',
        'description' => __('Available tags: {site_name}, {user_name}, {event_type}, {event_date}, {guest_count}, {phone_number}', 'nirup-island'),
        'input_attrs' => array(
            'rows' => 12,
        ),
        'priority' => 40,
    ));
    
    // Confirmation Email Footer
    $wp_customize->add_setting('nirup_private_events_confirmation_footer', array(
        'default' => __("---\nThis is an automated confirmation email. Please do not reply to this message.", 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_private_events_confirmation_footer', array(
        'label' => __('Confirmation Email Footer', 'nirup-island'),
        'section' => 'nirup_private_events_form_settings',
        'type' => 'textarea',
        'input_attrs' => array(
            'rows' => 3,
        ),
        'priority' => 50,
    ));

    // ===========================
// MODAL SETTINGS
// ===========================

$wp_customize->add_section('nirup_private_events_modal_settings', array(
    'title' => __('Private Events Thank You Modal', 'nirup-island'),
    'priority' => 49,
    'description' => __('Customize the thank you modal that appears after form submission', 'nirup-island'),
));

// Preview Modal Toggle (hidden setting, just for preview)
$wp_customize->add_setting('nirup_private_events_modal_preview', array(
    'default' => false,
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_validate_boolean',
));

$wp_customize->add_control('nirup_private_events_modal_preview', array(
    'label' => __('👁️ Show Modal Preview', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'checkbox',
    'priority' => 5,
    'description' => __('Check this box to preview the modal while editing', 'nirup-island'),
));

// Modal Title
$wp_customize->add_setting('nirup_private_events_modal_title', array(
    'default' => __('THANK YOU FOR REACHING OUT', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage',
));

$wp_customize->add_control('nirup_private_events_modal_title', array(
    'label' => __('Modal Title', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'text',
    'priority' => 10,
));

// Modal Intro Text
$wp_customize->add_setting('nirup_private_events_modal_intro', array(
    'default' => __('Your event request has been received. Our team will be in touch within 1-2 business days to discuss your plans in detail and guide you through the possibilities.', 'nirup-island'),
    'sanitize_callback' => 'sanitize_textarea_field',
    'transport' => 'postMessage',
));

$wp_customize->add_control('nirup_private_events_modal_intro', array(
    'label' => __('Modal Intro Text', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'textarea',
    'priority' => 20,
));

// Link 1 - URL
$wp_customize->add_setting('nirup_private_events_modal_link1_url', array(
    'default' => '/dining/',
    'sanitize_callback' => 'esc_url_raw',
    'transport' => 'refresh',
));

$wp_customize->add_control('nirup_private_events_modal_link1_url', array(
    'label' => __('Link 1 - URL', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'url',
    'priority' => 30,
));

// Link 1 - Text
$wp_customize->add_setting('nirup_private_events_modal_link1_text', array(
    'default' => __('Explore our dining experiences', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage',
));

$wp_customize->add_control('nirup_private_events_modal_link1_text', array(
    'label' => __('Link 1 - Text', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'text',
    'priority' => 40,
));

// Link 2 - URL
$wp_customize->add_setting('nirup_private_events_modal_link2_url', array(
    'default' => '/accommodations/',
    'sanitize_callback' => 'esc_url_raw',
    'transport' => 'refresh',
));

$wp_customize->add_control('nirup_private_events_modal_link2_url', array(
    'label' => __('Link 2 - URL', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'url',
    'priority' => 50,
));

// Link 2 - Text
$wp_customize->add_setting('nirup_private_events_modal_link2_text', array(
    'default' => __('Discover accommodation for your guests', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage',
));

$wp_customize->add_control('nirup_private_events_modal_link2_text', array(
    'label' => __('Link 2 - Text', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'text',
    'priority' => 60,
));

// Phone Text
$wp_customize->add_setting('nirup_private_events_modal_phone_text', array(
    'default' => __('Contact us directly for time-sensitive enquiries at +62 811-6220-999', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage',
));

$wp_customize->add_control('nirup_private_events_modal_phone_text', array(
    'label' => __('Phone Link - Text', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'text',
    'priority' => 70,
));

// Phone Number
$wp_customize->add_setting('nirup_private_events_modal_phone_number', array(
    'default' => '+62 811-6220-999',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'refresh',
));

$wp_customize->add_control('nirup_private_events_modal_phone_number', array(
    'label' => __('Phone Number', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'text',
    'description' => __('The actual phone number that will be dialed when clicked', 'nirup-island'),
    'priority' => 80,
));

// Modal Closing Text
$wp_customize->add_setting('nirup_private_events_modal_closing', array(
    'default' => __('We look forward to helping you create an event that is both seamless and memorable.', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage',
));

$wp_customize->add_control('nirup_private_events_modal_closing', array(
    'label' => __('Modal Closing Text', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'text',
    'priority' => 90,
));
}
add_action('customize_register', 'nirup_private_events_customizer');
/**
 * Admin Menu for Private Event Submissions
 */
// function nirup_private_events_admin_menu() {
//     add_menu_page(
//         'Private Event Requests',
//         'Event Requests',
//         'manage_options',
//         'private-event-submissions',
//         'nirup_private_events_admin_page',
//         'dashicons-calendar-alt',
//         26
//     );
// }
// add_action('admin_menu', 'nirup_private_events_admin_menu');

/**
 * Display Private Event Submissions Admin Page
 */
function nirup_private_events_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'private_event_submissions';
    
    // Get all submissions
    $submissions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submission_date DESC");
    
    ?>
    <div class="wrap">
        <h1>Private Event Requests</h1>
        
        <?php if (empty($submissions)): ?>
            <p>No event requests yet.</p>
        <?php else: ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Event Type</th>
                        <th>Event Date</th>
                        <th>Guests</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $submission): ?>
                        <tr>
                            <td><?php echo date('M j, Y', strtotime($submission->submission_date)); ?></td>
                            <td><strong><?php echo esc_html($submission->name); ?></strong></td>
                            <td><a href="mailto:<?php echo esc_attr($submission->email); ?>"><?php echo esc_html($submission->email); ?></a></td>
                            <td><?php echo esc_html($submission->event_type); ?></td>
                            <td><?php echo $submission->event_date ? date('M j, Y', strtotime($submission->event_date)) : 'Not specified'; ?></td>
                            <td><?php echo $submission->guest_count ? esc_html($submission->guest_count) : 'Not specified'; ?></td>
                            <td><?php echo esc_html($submission->status); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Create Private Event Submissions Table on Theme Activation
 */
function nirup_private_events_activation() {
    nirup_create_private_event_submissions_table();
}
register_activation_hook(__FILE__, 'nirup_private_events_activation');

add_action('after_switch_theme', 'nirup_create_private_event_submissions_table');

function nirup_private_events_customizer_preview() {
    wp_enqueue_script(
        'nirup-private-events-customizer-preview',
        get_template_directory_uri() . '/assets/js/private-events-customizer-preview.js',
        array('jquery', 'customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'nirup_private_events_customizer_preview');

function nirup_enqueue_accommodations_page_assets() {
    // Only on accommodations page template
    if (is_page_template('page-accommodations.php')) {
        // Enqueue CSS - NEW FILE
        wp_enqueue_style(
            'nirup-accommodations-page',
            get_template_directory_uri() . '/assets/css/accommodations-page.css',
            array(),
            '1.0.0'
        );
        
        // Enqueue JavaScript
        wp_enqueue_script(
            'nirup-accommodations-page-carousel',
            get_template_directory_uri() . '/assets/js/accommodations-carousel.js',
            array(),
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_accommodations_page_assets');

/**
 * Accommodations PAGE Customizer Options
 * RENAMED to avoid conflicts with homepage accommodations section customizer
 */
function nirup_accommodations_page_customizer($wp_customize) {
    // Accommodations PAGE Section
    $wp_customize->add_section('nirup_accommodations_page', array(
        'title' => __('Accommodations Page', 'nirup-island'),
        'priority' => 36,
        'description' => __('Customize the full accommodations page (not the homepage section)', 'nirup-island'),
    ));

    // === HERO SECTION ===
    
    // Hero Image
    $wp_customize->add_setting('nirup_accommodations_hero_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_accommodations_hero_image', array(
        'label' => __('Hero Background Image', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'mime_type' => 'image',
        'description' => __('Recommended size: 1400x780px', 'nirup-island'),
    )));

    // Hero Title
    $wp_customize->add_setting('nirup_accommodations_hero_title', array(
        'default' => __('ACCOMMODATION', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_accommodations_hero_title', array(
        'label' => __('Hero Title', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('nirup_accommodations_hero_subtitle', array(
        'default' => __('Find your perfect retreat on Nirup Island — from luxurious resort stays to private residences', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('nirup_accommodations_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'textarea',
    ));

    // === RIAHI RESIDENCES SECTION ===
    
    // Riahi Section Title
    $wp_customize->add_setting('nirup_riahi_section_title', array(
        'default' => __('RIAHI RESIDENCES', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_riahi_section_title', array(
        'label' => __('Riahi Section Title', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'text',
    ));

    // Riahi Section Description
    $wp_customize->add_setting('nirup_riahi_section_description', array(
        'default' => __('Riahi Residences offers a tranquil and spacious retreat, with elegantly designed villas featuring fully equipped kitchens and private pools in select units—providing an exclusive sanctuary where guests can enjoy both comfort and privacy. While offering seclusion, the residences remain just a short walk from the island\'s restaurants and the amenities of The Westin Nirup Island Resort & Spa, accessible with day passes.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('nirup_riahi_section_description', array(
        'label' => __('Riahi Section Description', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'textarea',
        'input_attrs' => array(
            'rows' => 6,
        ),
    ));

    // Riahi CTA Text
    $wp_customize->add_setting('nirup_riahi_cta_text', array(
        'default' => __('SEE ALL VILLAS', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_riahi_cta_text', array(
        'label' => __('Riahi CTA Button Text', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'text',
    ));

    // Riahi CTA Link
    $wp_customize->add_setting('nirup_riahi_booking_link', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_riahi_booking_link', array(
        'label' => __('Riahi Booking Link', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'url',
        'description' => __('Link for the Riahi Residences booking button', 'nirup-island'),
    ));

    // === WESTIN SECTION ===
    
    // Westin Section Title
    $wp_customize->add_setting('nirup_westin_section_title', array(
        'default' => __('THE WESTIN NIRUP ISLAND RESORT & SPA', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_westin_section_title', array(
        'label' => __('Westin Section Title', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'text',
    ));

    // Westin Section Description
    $wp_customize->add_setting('nirup_westin_section_description', array(
        'default' => __('Set atop the island\'s hill, each room features beautiful sea views of the Riau Islands. Relax with a soothing spa treatment, enjoy a session in the wellness center, or simply take in the serene surroundings. Families will appreciate the Kids Club, where children can enjoy engaging activities in a safe and fun environment, allowing parents to relax nearby. For those seeking more privacy, the island offers 1 to 3-bedroom villas over the water, each with a private pool, providing direct access to the sea and a closer connection to the island.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('nirup_westin_section_description', array(
        'label' => __('Westin Section Description', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'textarea',
        'input_attrs' => array(
            'rows' => 6,
        ),
    ));

    // Westin CTA Text
    $wp_customize->add_setting('nirup_westin_cta_text', array(
        'default' => __('BOOK AT THE WESTIN', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_westin_cta_text', array(
        'label' => __('Westin CTA Button Text', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'text',
    ));

    // Westin CTA Link
    $wp_customize->add_setting('nirup_westin_booking_link', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_westin_booking_link', array(
        'label' => __('Westin Booking Link', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'url',
        'description' => __('External link to Westin booking website', 'nirup-island'),
    ));
}
add_action('customize_register', 'nirup_accommodations_page_customizer');

function nirup_register_villa_cpt() {
    $labels = array(
        'name'                  => _x('Villas', 'Post Type General Name', 'nirup-island'),
        'singular_name'         => _x('Villa', 'Post Type Singular Name', 'nirup-island'),
        'menu_name'             => __('Villas', 'nirup-island'),
        'name_admin_bar'        => __('Villa', 'nirup-island'),
        'archives'              => __('Villa Archives', 'nirup-island'),
        'attributes'            => __('Villa Attributes', 'nirup-island'),
        'parent_item_colon'     => __('Parent Villa:', 'nirup-island'),
        'all_items'             => __('All Villas', 'nirup-island'),
        'add_new_item'          => __('Add New Villa', 'nirup-island'),
        'add_new'               => __('Add New', 'nirup-island'),
        'new_item'              => __('New Villa', 'nirup-island'),
        'edit_item'             => __('Edit Villa', 'nirup-island'),
        'update_item'           => __('Update Villa', 'nirup-island'),
        'view_item'             => __('View Villa', 'nirup-island'),
        'view_items'            => __('View Villas', 'nirup-island'),
        'search_items'          => __('Search Villa', 'nirup-island'),
        'not_found'             => __('Not found', 'nirup-island'),
        'not_found_in_trash'    => __('Not found in Trash', 'nirup-island'),
        'featured_image'        => __('Villa Featured Image', 'nirup-island'),
        'set_featured_image'    => __('Set villa featured image', 'nirup-island'),
        'remove_featured_image' => __('Remove villa featured image', 'nirup-island'),
        'use_featured_image'    => __('Use as villa featured image', 'nirup-island'),
        'insert_into_item'      => __('Insert into villa', 'nirup-island'),
        'uploaded_to_this_item' => __('Uploaded to this villa', 'nirup-island'),
        'items_list'            => __('Villas list', 'nirup-island'),
        'items_list_navigation' => __('Villas list navigation', 'nirup-island'),
        'filter_items_list'     => __('Filter villas list', 'nirup-island'),
    );

    $args = array(
        'label'                 => __('Villa', 'nirup-island'),
        'description'           => __('Riahi Residences Villas', 'nirup-island'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'page-attributes'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 26,
        'menu_icon'             => 'dashicons-admin-home',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array('slug' => 'villa'),
    );

    register_post_type('villa', $args);
}
add_action('init', 'nirup_register_villa_cpt');

/**
 * Register Westin Room Custom Post Type
 * Simple display-only cards (no single page)
 */
function nirup_register_westin_room_cpt() {
    $labels = array(
        'name'                  => _x('Westin Rooms', 'Post Type General Name', 'nirup-island'),
        'singular_name'         => _x('Westin Room', 'Post Type Singular Name', 'nirup-island'),
        'menu_name'             => __('Westin Rooms', 'nirup-island'),
        'name_admin_bar'        => __('Westin Room', 'nirup-island'),
        'archives'              => __('Room Archives', 'nirup-island'),
        'attributes'            => __('Room Attributes', 'nirup-island'),
        'parent_item_colon'     => __('Parent Room:', 'nirup-island'),
        'all_items'             => __('All Rooms', 'nirup-island'),
        'add_new_item'          => __('Add New Room', 'nirup-island'),
        'add_new'               => __('Add New', 'nirup-island'),
        'new_item'              => __('New Room', 'nirup-island'),
        'edit_item'             => __('Edit Room', 'nirup-island'),
        'update_item'           => __('Update Room', 'nirup-island'),
        'view_item'             => __('View Room', 'nirup-island'),
        'view_items'            => __('View Rooms', 'nirup-island'),
        'search_items'          => __('Search Room', 'nirup-island'),
        'not_found'             => __('Not found', 'nirup-island'),
        'not_found_in_trash'    => __('Not found in Trash', 'nirup-island'),
        'featured_image'        => __('Room Image', 'nirup-island'),
        'set_featured_image'    => __('Set room image', 'nirup-island'),
        'remove_featured_image' => __('Remove room image', 'nirup-island'),
        'use_featured_image'    => __('Use as room image', 'nirup-island'),
        'insert_into_item'      => __('Insert into room', 'nirup-island'),
        'uploaded_to_this_item' => __('Uploaded to this room', 'nirup-island'),
        'items_list'            => __('Rooms list', 'nirup-island'),
        'items_list_navigation' => __('Rooms list navigation', 'nirup-island'),
        'filter_items_list'     => __('Filter rooms list', 'nirup-island'),
    );

    $args = array(
        'label'                 => __('Westin Room', 'nirup-island'),
        'description'           => __('Westin Hotel Room Types', 'nirup-island'),
        'labels'                => $labels,
        'supports'              => array('title', 'thumbnail', 'page-attributes'),
        'hierarchical'          => false,
        'public'                => false, // Not publicly accessible
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 27,
        'menu_icon'             => 'dashicons-building',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false, // No single page
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type('westin_room', $args);
}
add_action('init', 'nirup_register_westin_room_cpt');

/**
 * Add Villa Meta Box
 * For now just villa category field
 */
function nirup_add_villa_meta_boxes() {
    add_meta_box(
        'villa_details',
        __('Villa Details', 'nirup-island'),
        'nirup_villa_meta_box_callback',
        'villa',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_villa_meta_boxes');

/**
 * Villa Meta Box Callback
 */
function nirup_villa_meta_box_callback($post) {
    // Add nonce for security
    wp_nonce_field('nirup_save_villa_meta', 'nirup_villa_meta_nonce');
    
    // Get current values
    $villa_category = get_post_meta($post->ID, '_villa_category', true);
    ?>
    
    <div style="margin-bottom: 20px;">
        <label for="villa_category" style="display: block; margin-bottom: 5px; font-weight: 600;">
            <?php _e('Villa Category', 'nirup-island'); ?>
        </label>
        <input 
            type="text" 
            id="villa_category" 
            name="villa_category" 
            value="<?php echo esc_attr($villa_category); ?>" 
            style="width: 100%; max-width: 500px;"
            placeholder="e.g., Riahi Residence, Villa 201"
        />
        <p class="description">
            <?php _e('This appears above the villa type name on the card (e.g., "Riahi Residence, Villa 201").', 'nirup-island'); ?>
        </p>
    </div>
    
    <p style="padding: 15px; background: #f0f0f1; border-left: 4px solid #2271b1;">
        <strong><?php _e('Note:', 'nirup-island'); ?></strong> 
        <?php _e('More villa details (bedrooms, amenities, pricing, etc.) will be added in the next phase when we create the single villa page.', 'nirup-island'); ?>
    </p>
    
    <?php
}

/**
 * Save Villa Meta
 */
function nirup_save_villa_meta($post_id) {
    // Check nonce
    if (!isset($_POST['nirup_villa_meta_nonce']) || 
        !wp_verify_nonce($_POST['nirup_villa_meta_nonce'], 'nirup_save_villa_meta')) {
        return;
    }
    
    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save villa category
    if (isset($_POST['villa_category'])) {
        update_post_meta(
            $post_id,
            '_villa_category',
            sanitize_text_field($_POST['villa_category'])
        );
    }
}
add_action('save_post_villa', 'nirup_save_villa_meta');

/**
 * Add custom columns to Villa admin list
 */
function nirup_villa_admin_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['featured_image'] = __('Image', 'nirup-island');
    $new_columns['title'] = $columns['title'];
    $new_columns['villa_category'] = __('Category', 'nirup-island');
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_villa_posts_columns', 'nirup_villa_admin_columns');

/**
 * Display custom column content for Villas
 */
function nirup_villa_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'featured_image':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(60, 60));
            } else {
                echo '—';
            }
            break;
        case 'villa_category':
            $category = get_post_meta($post_id, '_villa_category', true);
            echo $category ? esc_html($category) : '—';
            break;
    }
}
add_action('manage_villa_posts_custom_column', 'nirup_villa_admin_column_content', 10, 2);

/**
 * Add custom columns to Westin Room admin list
 */
function nirup_westin_room_admin_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['featured_image'] = __('Image', 'nirup-island');
    $new_columns['title'] = $columns['title'];
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_westin_room_posts_columns', 'nirup_westin_room_admin_columns');

/**
 * Display custom column content for Westin Rooms
 */
function nirup_westin_room_admin_column_content($column, $post_id) {
    if ($column === 'featured_image') {
        if (has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail($post_id, array(60, 60));
        } else {
            echo '—';
        }
    }
}
add_action('manage_westin_room_posts_custom_column', 'nirup_westin_room_admin_column_content', 10, 2);

/**
 * Flush rewrite rules on theme activation
 * Important for custom post types to work properly
 */
function nirup_flush_rewrites_on_activation() {
    nirup_register_villa_cpt();
    nirup_register_westin_room_cpt();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'nirup_flush_rewrites_on_activation');

function nirup_customizer_preview_scripts() {
    wp_enqueue_script(
        'nirup-video-customizer-preview',
        get_template_directory_uri() . '/assets/js/video-customizer-preview.js',
        array('jquery', 'customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'nirup_customizer_preview_scripts');

/**
 * Add Villa Features Meta Box
 * Add this to functions.php
 */
function nirup_add_villa_features_meta_box() {
    add_meta_box(
        'villa_features',
        __('Villa Features', 'nirup-island'),
        'nirup_villa_features_meta_box_callback',
        'villa',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_villa_features_meta_box');

/**
 * Villa Features Meta Box Callback
 */
function nirup_villa_features_meta_box_callback($post) {
    wp_nonce_field('nirup_save_villa_features', 'nirup_villa_features_nonce');
    
    $features = get_post_meta($post->ID, '_villa_features', true);
    if (!is_array($features)) {
        $features = array();
    }
    ?>
    
    <div id="villa-features-wrapper">
        <div id="villa-features-list">
            <?php
            if (!empty($features)) {
                foreach ($features as $index => $feature) {
                    ?>
                    <div class="villa-feature-item" style="margin-bottom: 15px; padding: 15px; background: #f9f9f9; border: 1px solid #ddd;">
                        <input 
                            type="text" 
                            name="villa_features[]" 
                            value="<?php echo esc_attr($feature); ?>" 
                            placeholder="e.g., 2 Bedrooms, Swimming Pool, Full Kitchen"
                            style="width: 80%; margin-right: 10px;"
                        />
                        <button type="button" class="button remove-feature">Remove</button>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <button type="button" id="add-feature" class="button button-secondary" style="margin-top: 10px;">
            + Add Feature
        </button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Add feature
        $('#add-feature').on('click', function() {
            var featureHtml = '<div class="villa-feature-item" style="margin-bottom: 15px; padding: 15px; background: #f9f9f9; border: 1px solid #ddd;">' +
                '<input type="text" name="villa_features[]" value="" placeholder="e.g., 2 Bedrooms, Swimming Pool, Full Kitchen" style="width: 80%; margin-right: 10px;" />' +
                '<button type="button" class="button remove-feature">Remove</button>' +
                '</div>';
            $('#villa-features-list').append(featureHtml);
        });
        
        // Remove feature
        $(document).on('click', '.remove-feature', function() {
            $(this).closest('.villa-feature-item').remove();
        });
    });
    </script>
    
    <style>
        .villa-feature-item {
            display: flex;
            align-items: center;
        }
    </style>
    
    <?php
}

/**
 * Save Villa Features
 */
function nirup_save_villa_features($post_id) {
    // Check nonce
    if (!isset($_POST['nirup_villa_features_nonce']) || 
        !wp_verify_nonce($_POST['nirup_villa_features_nonce'], 'nirup_save_villa_features')) {
        return;
    }
    
    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save features
    $features = array();
    if (isset($_POST['villa_features']) && is_array($_POST['villa_features'])) {
        foreach ($_POST['villa_features'] as $feature) {
            $feature = sanitize_text_field($feature);
            if (!empty($feature)) {
                $features[] = $feature;
            }
        }
    }
    
    update_post_meta($post_id, '_villa_features', $features);
}
add_action('save_post_villa', 'nirup_save_villa_features');

/**
 * Riahi Residences Page Customizer Options
 * Add this to functions.php
 */
function nirup_riahi_residences_customizer($wp_customize) {
    // Riahi Residences Section
    $wp_customize->add_section('nirup_riahi_residences', array(
        'title' => __('Riahi Residences Page', 'nirup-island'),
        'priority' => 37,
        'description' => __('Customize the Riahi Residences page', 'nirup-island'),
    ));

    // === HERO SECTION ===
    
    // Hero Image
    $wp_customize->add_setting('nirup_riahi_hero_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_riahi_hero_image', array(
        'label' => __('Hero Background Image', 'nirup-island'),
        'section' => 'nirup_riahi_residences',
        'mime_type' => 'image',
        'description' => __('Recommended size: 1400x780px', 'nirup-island'),
    )));

    // Hero Subtitle
    $wp_customize->add_setting('nirup_riahi_hero_subtitle', array(
        'default' => __('Your Private Island Sanctuary', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_riahi_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'nirup-island'),
        'section' => 'nirup_riahi_residences',
        'type' => 'text',
    ));

    // Hero Title
    $wp_customize->add_setting('nirup_riahi_hero_title', array(
        'default' => __('Riahi Residences', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_riahi_hero_title', array(
        'label' => __('Hero Title', 'nirup-island'),
        'section' => 'nirup_riahi_residences',
        'type' => 'text',
    ));

    // === OVERVIEW SECTION ===
    
    // Overview Heading
    $wp_customize->add_setting('nirup_riahi_overview_heading', array(
        'default' => __('Overview', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_riahi_overview_heading', array(
        'label' => __('Overview Section Heading', 'nirup-island'),
        'section' => 'nirup_riahi_residences',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_riahi_overview_description', array(
        'default' => __('Riahi Residences offers a tranquil and spacious retreat, with 2 to 4-bedroom villas designed for comfort and privacy. Each unit features a fully equipped kitchen, and some include a private plunge or swimming pool. While offering seclusion, the residences remain just a short distance from the island\'s dining venues and the amenities of The Westin Nirup Island Resort & Spa, accessible with day passes. Guests have the flexibility to dine at various restaurants across the island or prepare their own meals in the comfort of their villa.', 'nirup-island'),
        'sanitize_callback' => 'wp_kses_post',  // Changed from sanitize_textarea_field
    ));

    $wp_customize->add_control('nirup_riahi_overview_description', array(
        'label' => __('Overview Description', 'nirup-island'),
        'section' => 'nirup_riahi_residences',
        'type' => 'textarea',
        'input_attrs' => array(
            'rows' => 6,
        ),
    ));
}
add_action('customize_register', 'nirup_riahi_residences_customizer');

function nirup_enqueue_riahi_residences_assets() {
    // Only on Riahi Residences page template
    if (is_page_template('page-riahi-residences.php')) {
        // Enqueue CSS
        wp_enqueue_style(
            'nirup-riahi-residences',
            get_template_directory_uri() . '/assets/css/riahi-residences.css',
            array(),
            '1.0.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_riahi_residences_assets');

function nirup_villa_icons_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=villa',
        'Feature Icons Library',
        'Feature Icons',
        'manage_options',
        'villa-feature-icons',
        'nirup_villa_icons_admin_page'
    );
}
add_action('admin_menu', 'nirup_villa_icons_admin_menu');

/**
 * Get villa feature icons directory paths
 */
function nirup_get_villa_icon_paths() {
    $upload_dir = wp_upload_dir();
    return array(
        'dir' => $upload_dir['basedir'] . '/villa-feature-icons/',
        'url' => $upload_dir['baseurl'] . '/villa-feature-icons/'
    );
}

/**
 * Get all available villa feature icons
 */
function nirup_get_villa_feature_icons() {
    $paths = nirup_get_villa_icon_paths();
    $icons = array();
    
    if (is_dir($paths['dir'])) {
        $files = glob($paths['dir'] . '*.svg');
        foreach ($files as $file) {
            $filename = basename($file);
            $name = pathinfo($filename, PATHINFO_FILENAME);
            
            $icons[$filename] = array(
                'name' => ucfirst(str_replace(array('-', '_'), ' ', $name)),
                'filename' => $filename,
                'url' => $paths['url'] . $filename,
                'path' => $file
            );
        }
    }
    
    return $icons;
}

/**
 * Admin page for icon library
 */
function nirup_villa_icons_admin_page() {
    $paths = nirup_get_villa_icon_paths();
    
    // Create directory if it doesn't exist
    if (!file_exists($paths['dir'])) {
        wp_mkdir_p($paths['dir']);
    }
    
    // Handle file upload
    if (isset($_POST['upload_villa_icon']) && check_admin_referer('upload_villa_icon_nonce')) {
        if (!empty($_FILES['villa_icon_file']['name'])) {
            $file = $_FILES['villa_icon_file'];
            
            // Check if it's an SVG
            if ($file['type'] === 'image/svg+xml') {
                $filename = sanitize_file_name($file['name']);
                $destination = $paths['dir'] . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    echo '<div class="notice notice-success"><p>Icon uploaded successfully!</p></div>';
                } else {
                    echo '<div class="notice notice-error"><p>Failed to upload icon.</p></div>';
                }
            } else {
                echo '<div class="notice notice-error"><p>Only SVG files are allowed.</p></div>';
            }
        }
    }
    
    // Handle icon deletion
    if (isset($_GET['delete_icon']) && check_admin_referer('delete_villa_icon_' . $_GET['delete_icon'])) {
        $icon_to_delete = sanitize_file_name($_GET['delete_icon']);
        $file_path = $paths['dir'] . $icon_to_delete;
        
        if (file_exists($file_path)) {
            unlink($file_path);
            echo '<div class="notice notice-success"><p>Icon deleted successfully!</p></div>';
        }
    }
    
    $icons = nirup_get_villa_feature_icons();
    ?>
    
    <div class="wrap">
        <h1>Villa Feature Icons Library</h1>
        
        <div style="background: white; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
            <h2>Upload New Icon</h2>
            <form method="post" enctype="multipart/form-data">
                <?php wp_nonce_field('upload_villa_icon_nonce'); ?>
                <p>
                    <input type="file" name="villa_icon_file" accept=".svg" required>
                    <input type="submit" name="upload_villa_icon" class="button button-primary" value="Upload SVG Icon">
                </p>
                <p class="description">Only SVG files are accepted. Icon names should be descriptive (e.g., bedroom.svg, pool.svg, kitchen.svg)</p>
            </form>
        </div>
        
        <div style="background: white; padding: 20px; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
            <h2>Icon Library (<?php echo count($icons); ?> icons)</h2>
            
            <?php if (empty($icons)) : ?>
                <p>No icons uploaded yet. Upload your first icon above!</p>
            <?php else : ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px; margin-top: 20px;">
                    <?php foreach ($icons as $icon) : ?>
                        <div style="border: 1px solid #ddd; padding: 15px; text-align: center; border-radius: 4px;">
                            <div style="width: 60px; height: 60px; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center;">
                                <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['name']); ?>" style="max-width: 100%; max-height: 100%;">
                            </div>
                            <p style="margin: 0 0 8px 0; font-size: 12px; word-break: break-word;">
                                <strong><?php echo esc_html($icon['name']); ?></strong>
                            </p>
                            <p style="margin: 0; font-size: 11px; color: #666;">
                                <?php echo esc_html($icon['filename']); ?>
                            </p>
                            <a href="?post_type=villa&page=villa-feature-icons&delete_icon=<?php echo urlencode($icon['filename']); ?>&_wpnonce=<?php echo wp_create_nonce('delete_villa_icon_' . $icon['filename']); ?>" 
                               class="button button-small" 
                               style="margin-top: 8px; color: #b32d2e;"
                               onclick="return confirm('Are you sure you want to delete this icon?');">
                                Delete
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div style="background: #f0f6fc; border-left: 4px solid #2271b1; padding: 12px; margin-top: 20px;">
            <p style="margin: 0;"><strong>💡 Tip:</strong> Name your icon files descriptively (e.g., "bedroom.svg", "swimming-pool.svg", "kitchen.svg") for easier selection when adding villa features.</p>
        </div>
    </div>
    
    <?php
}

// ========== 2. ENHANCED VILLA FEATURES META BOX WITH ICON PICKER ==========

/**
 * Replace the old villa features meta box
 */
function nirup_villa_features_with_icons_meta_box() {
    wp_nonce_field('nirup_save_villa_features', 'nirup_villa_features_nonce');
    
    global $post;
    $features = get_post_meta($post->ID, '_villa_features', true);
    if (!is_array($features)) {
        $features = array();
    }
    
    $available_icons = nirup_get_villa_feature_icons();
    ?>
    
    <div id="villa-features-wrapper">
        <div id="villa-features-list">
            <?php
            if (!empty($features)) {
                foreach ($features as $index => $feature) {
                    $feature_text = isset($feature['text']) ? $feature['text'] : (is_string($feature) ? $feature : '');
                    $feature_icon = isset($feature['icon']) ? $feature['icon'] : '';
                    
                    nirup_render_feature_row($feature_text, $feature_icon, $available_icons);
                }
            }
            ?>
        </div>
        
        <button type="button" id="add-feature" class="button button-secondary" style="margin-top: 10px;">
            + Add Feature
        </button>
        
        <?php if (empty($available_icons)) : ?>
            <p style="margin-top: 15px; padding: 12px; background: #fff3cd; border-left: 4px solid #ffc107;">
                <strong>No icons available.</strong> 
                <a href="<?php echo admin_url('edit.php?post_type=villa&page=villa-feature-icons'); ?>">Upload icons to the library</a> first.
            </p>
        <?php endif; ?>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Add feature
        $('#add-feature').on('click', function() {
            var featureHtml = <?php echo json_encode(nirup_get_feature_row_html($available_icons)); ?>;
            $('#villa-features-list').append(featureHtml);
        });
        
        // Remove feature
        $(document).on('click', '.remove-feature', function() {
            $(this).closest('.villa-feature-item').remove();
        });
        
        // Icon preview on change
        $(document).on('change', '.feature-icon-select', function() {
            var iconUrl = $(this).find(':selected').data('icon-url');
            var preview = $(this).siblings('.icon-preview');
            
            if (iconUrl) {
                preview.html('<img src="' + iconUrl + '" style="width: 28px; height: 28px;">');
            } else {
                preview.html('<span style="font-size: 20px; color: #a48456;">•</span>');
            }
        });
    });
    </script>
    
    <style>
        .villa-feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            padding: 15px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .icon-preview {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .feature-icon-select {
            width: 200px;
        }
        .feature-text-input {
            flex: 1;
        }
    </style>
    
    <?php
}

/**
 * Render a single feature row
 */
function nirup_render_feature_row($text = '', $icon = '', $available_icons = array()) {
    ?>
    <div class="villa-feature-item">
        <div class="icon-preview">
            <?php if ($icon && isset($available_icons[$icon])) : ?>
                <img src="<?php echo esc_url($available_icons[$icon]['url']); ?>" style="width: 28px; height: 28px;">
            <?php else : ?>
                <span style="font-size: 20px; color: #a48456;">•</span>
            <?php endif; ?>
        </div>
        
        <select name="villa_features_icon[]" class="feature-icon-select">
            <option value="">No icon (bullet point)</option>
            <?php foreach ($available_icons as $available_icon) : ?>
                <option value="<?php echo esc_attr($available_icon['filename']); ?>" 
                        data-icon-url="<?php echo esc_url($available_icon['url']); ?>"
                        <?php selected($icon, $available_icon['filename']); ?>>
                    <?php echo esc_html($available_icon['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <input 
            type="text" 
            name="villa_features_text[]" 
            value="<?php echo esc_attr($text); ?>" 
            placeholder="e.g., 2 Bedrooms, Swimming Pool, Full Kitchen"
            class="feature-text-input"
        />
        
        <button type="button" class="button remove-feature">Remove</button>
    </div>
    <?php
}

/**
 * Get HTML for new feature row
 */
function nirup_get_feature_row_html($available_icons) {
    ob_start();
    nirup_render_feature_row('', '', $available_icons);
    return ob_get_clean();
}

/**
 * Update the save function to handle icons
 */
function nirup_save_villa_features_with_icons($post_id) {
    if (!isset($_POST['nirup_villa_features_nonce']) || 
        !wp_verify_nonce($_POST['nirup_villa_features_nonce'], 'nirup_save_villa_features')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $features = array();
    
    if (isset($_POST['villa_features_text']) && is_array($_POST['villa_features_text'])) {
        $feature_texts = $_POST['villa_features_text'];
        $feature_icons = isset($_POST['villa_features_icon']) ? $_POST['villa_features_icon'] : array();
        
        foreach ($feature_texts as $index => $text) {
            $text = sanitize_text_field($text);
            if (!empty($text)) {
                $features[] = array(
                    'text' => $text,
                    'icon' => isset($feature_icons[$index]) ? sanitize_file_name($feature_icons[$index]) : ''
                );
            }
        }
    }
    
    update_post_meta($post_id, '_villa_features', $features);
}

// Update hooks
remove_action('add_meta_boxes', 'nirup_add_villa_features_meta_box');
remove_action('save_post_villa', 'nirup_save_villa_features');

function nirup_add_villa_features_with_icons_meta_box() {
    add_meta_box(
        'villa_features',
        __('Villa Features', 'nirup-island'),
        'nirup_villa_features_with_icons_meta_box',
        'villa',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_villa_features_with_icons_meta_box');
add_action('save_post_villa', 'nirup_save_villa_features_with_icons');

function nirup_add_single_villa_meta_boxes() {
    add_meta_box(
        'villa_single_page_content',
        '🏝️ Single Villa Page Content',
        'nirup_villa_single_page_meta_box_callback',
        'villa',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_single_villa_meta_boxes');

/**
 * Single Villa Page Meta Box Callback
 */
function nirup_villa_single_page_meta_box_callback($post) {
    wp_nonce_field('nirup_save_villa_single_page', 'nirup_villa_single_page_nonce');
    
    // Get saved values
    $subtitle = get_post_meta($post->ID, '_villa_subtitle', true);
    $category_title = get_post_meta($post->ID, '_villa_category_title', true);
    $description = get_post_meta($post->ID, '_villa_description', true);
    $features_list = get_post_meta($post->ID, '_villa_features_list', true);
    $booking_url = get_post_meta($post->ID, '_villa_booking_url', true);
    $gallery_images = get_post_meta($post->ID, '_villa_gallery', true);
    $gallery_images = is_array($gallery_images) ? $gallery_images : array();
    ?>
    
    <style>
        .villa-meta-section {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #ddd;
        }
        .villa-meta-section:last-child {
            border-bottom: none;
        }
        .villa-meta-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1d2327;
        }
        .villa-meta-input {
            width: 100%;
            max-width: 100%;
            padding: 8px 12px;
            font-size: 14px;
        }
        .villa-meta-textarea {
            width: 100%;
            min-height: 120px;
            padding: 8px 12px;
            font-size: 14px;
        }
        .villa-meta-description {
            margin-top: 5px;
            color: #646970;
            font-size: 13px;
        }
        .villa-section-title {
            font-size: 14px;
            font-weight: 600;
            color: #1d2327;
            margin: 20px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #2271b1;
        }
        .villa-gallery-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .villa-gallery-item {
            position: relative;
            width: 120px;
            height: 120px;
            border: 2px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }
        .villa-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .villa-gallery-remove {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #dc3232;
            color: white;
            border: none;
            border-radius: 3px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
        }
        .villa-gallery-add {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 120px;
            height: 120px;
            border: 2px dashed #8c8f94;
            border-radius: 4px;
            background: #f6f7f7;
            color: #50575e;
            cursor: pointer;
            transition: all 0.2s;
        }
        .villa-gallery-add:hover {
            border-color: #2271b1;
            background: #f0f0f1;
            color: #2271b1;
        }
    </style>

    <!-- Hero Section -->
    <div class="villa-meta-section">
        <h3 class="villa-section-title">📍 Hero Section</h3>
        
        <div style="margin-bottom: 20px;">
            <label class="villa-meta-label" for="villa_subtitle">
                Subtitle (appears above title)
            </label>
            <input 
                type="text" 
                id="villa_subtitle" 
                name="villa_subtitle" 
                value="<?php echo esc_attr($subtitle); ?>" 
                class="villa-meta-input"
                placeholder="e.g., 2 Bedroom with Pool"
            />
            <p class="villa-meta-description">This text appears above the main villa title</p>
        </div>
    </div>

    <!-- Gallery Section -->
    <div class="villa-meta-section">
        <h3 class="villa-section-title">📸 Gallery Section</h3>
        
        <div>
            <label class="villa-meta-label">Gallery Images</label>
            <p class="villa-meta-description" style="margin-bottom: 15px;">
                The first image will be the main large image, images 2-5 will appear in the grid. 
                Click and drag to reorder.
            </p>
            
            <div id="villa-gallery-container" class="villa-gallery-container">
                <?php foreach ($gallery_images as $image_id) : 
                    $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                    if ($image_url) :
                ?>
                    <div class="villa-gallery-item" data-id="<?php echo esc_attr($image_id); ?>">
                        <img src="<?php echo esc_url($image_url); ?>" alt="">
                        <button type="button" class="villa-gallery-remove" onclick="removeVillaGalleryImage(this)">×</button>
                        <input type="hidden" name="villa_gallery[]" value="<?php echo esc_attr($image_id); ?>">
                    </div>
                <?php 
                    endif;
                endforeach; 
                ?>
                <div class="villa-gallery-add" onclick="openVillaMediaUploader()">
                    <span style="font-size: 40px; line-height: 1;">+</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="villa-meta-section">
        <h3 class="villa-section-title">📝 Main Content Section</h3>
        
        <div style="margin-bottom: 20px;">
            <label class="villa-meta-label" for="villa_category_title">
                Category Title
            </label>
            <input 
                type="text" 
                id="villa_category_title" 
                name="villa_category_title" 
                value="<?php echo esc_attr($category_title); ?>" 
                class="villa-meta-input"
                placeholder="e.g., Your Private Island Retreat"
            />
            <p class="villa-meta-description">Large heading that appears above the description</p>
        </div>

        <div style="margin-bottom: 20px;">
            <label class="villa-meta-label" for="villa_description">
                Main Description
            </label>
            <textarea 
                id="villa_description" 
                name="villa_description" 
                class="villa-meta-textarea"
                placeholder="Enter the main descriptive paragraph about this villa..."
            ><?php echo esc_textarea($description); ?></textarea>
            <p class="villa-meta-description">The main description paragraph (supports HTML)</p>
        </div>

        <div style="margin-bottom: 20px;">
            <label class="villa-meta-label" for="villa_features_list">
                Features List (Bullet Points)
            </label>
            <textarea 
                id="villa_features_list" 
                name="villa_features_list" 
                class="villa-meta-textarea"
                placeholder="Enter features as a bulleted list..."
            ><?php echo esc_textarea($features_list); ?></textarea>
            <p class="villa-meta-description">
                Use HTML list format: &lt;ul&gt;&lt;li&gt;Feature 1&lt;/li&gt;&lt;li&gt;Feature 2&lt;/li&gt;&lt;/ul&gt;
            </p>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        // Make gallery sortable
        $('#villa-gallery-container').sortable({
            items: '.villa-gallery-item',
            cursor: 'move',
            placeholder: 'villa-gallery-placeholder',
            update: function() {
                // Update order in hidden inputs
            }
        });
    });

    let villaMediaUploader;

    function openVillaMediaUploader() {
        if (villaMediaUploader) {
            villaMediaUploader.open();
            return;
        }

        villaMediaUploader = wp.media({
            title: 'Select Villa Gallery Images',
            button: {
                text: 'Add to Gallery'
            },
            multiple: true
        });

        villaMediaUploader.on('select', function() {
            const attachments = villaMediaUploader.state().get('selection').toJSON();
            const container = document.getElementById('villa-gallery-container');
            const addButton = container.querySelector('.villa-gallery-add');

            attachments.forEach(function(attachment) {
                const item = document.createElement('div');
                item.className = 'villa-gallery-item';
                item.setAttribute('data-id', attachment.id);
                item.innerHTML = `
                    <img src="${attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url}" alt="">
                    <button type="button" class="villa-gallery-remove" onclick="removeVillaGalleryImage(this)">×</button>
                    <input type="hidden" name="villa_gallery[]" value="${attachment.id}">
                `;
                container.insertBefore(item, addButton);
            });
        });

        villaMediaUploader.open();
    }

    function removeVillaGalleryImage(button) {
        if (confirm('Remove this image from the gallery?')) {
            button.closest('.villa-gallery-item').remove();
        }
    }
    </script>
    
    <?php
}

/**
 * Save Single Villa Page Meta
 */
function nirup_save_villa_single_page_meta($post_id) {
    // Check nonce
    if (!isset($_POST['nirup_villa_single_page_nonce']) || 
        !wp_verify_nonce($_POST['nirup_villa_single_page_nonce'], 'nirup_save_villa_single_page')) {
        return;
    }
    
    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save all fields
    $fields = array(
        '_villa_subtitle' => 'sanitize_text_field',
        '_villa_category_title' => 'sanitize_text_field',
        '_villa_description' => 'wp_kses_post',
        '_villa_features_list' => 'wp_kses_post',
        '_villa_booking_url' => 'esc_url_raw'
    );
    
    foreach ($fields as $meta_key => $sanitize_callback) {
        $post_key = str_replace('_villa_', 'villa_', $meta_key);
        if (isset($_POST[$post_key])) {
            update_post_meta($post_id, $meta_key, $sanitize_callback($_POST[$post_key]));
        }
    }
    
    // Save gallery
    if (isset($_POST['villa_gallery']) && is_array($_POST['villa_gallery'])) {
        $gallery_images = array_map('intval', $_POST['villa_gallery']);
        update_post_meta($post_id, '_villa_gallery', $gallery_images);
    } else {
        delete_post_meta($post_id, '_villa_gallery');
    }
}
add_action('save_post_villa', 'nirup_save_villa_single_page_meta');

/**
 * Enqueue Single Villa Page Assets
 */
function nirup_enqueue_single_villa_assets() {
    if (is_singular('villa')) {
        wp_enqueue_style(
            'nirup-single-villa',
            get_template_directory_uri() . '/assets/css/single-villa.css',
            array(),
            '1.0.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_single_villa_assets');

function nirup_add_villa_booking_calendar_field() {
    add_meta_box(
        'villa_booking_calendar',
        '📅 WP Booking System Calendar',
        'nirup_villa_booking_calendar_callback',
        'villa',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_villa_booking_calendar_field');

/**
 * Villa Booking Calendar Meta Box Callback
 */
function nirup_villa_booking_calendar_callback($post) {
    wp_nonce_field('nirup_save_villa_booking_calendar', 'nirup_villa_booking_calendar_nonce');
    
    $calendar_id = get_post_meta($post->ID, '_villa_booking_calendar_id', true);
    $form_id = get_post_meta($post->ID, '_villa_booking_form_id', true);
    ?>
    
    <style>
        .villa-booking-field {
            margin-bottom: 15px;
        }
        .villa-booking-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .villa-booking-input {
            width: 100%;
            padding: 6px 8px;
        }
        .villa-booking-help {
            margin-top: 5px;
            color: #666;
            font-size: 12px;
        }
    </style>

    <div class="villa-booking-field">
        <label class="villa-booking-label" for="villa_booking_calendar_id">
            WP Booking Calendar ID
        </label>
        <input 
            type="text" 
            id="villa_booking_calendar_id" 
            name="villa_booking_calendar_id" 
            value="<?php echo esc_attr($calendar_id); ?>" 
            class="villa-booking-input"
            placeholder="e.g., 1"
        />
        <p class="villa-booking-help">
            Enter the WP Booking System calendar ID for this villa. 
            <br>Find it in: <strong>WP Booking System > Calendars</strong>
        </p>
    </div>

    <div class="villa-booking-field">
        <label class="villa-booking-label" for="villa_booking_form_id">
            WP Booking Form ID
        </label>
        <input 
            type="text" 
            id="villa_booking_form_id" 
            name="villa_booking_form_id" 
            value="<?php echo esc_attr($form_id); ?>" 
            class="villa-booking-input"
            placeholder="e.g., 1"
        />
        <p class="villa-booking-help">
            Enter the WP Booking System form ID to attach to the calendar. 
            <br>Find it in: <strong>WP Booking System > Forms</strong>
        </p>
    </div>

    <?php if (class_exists('WP_Booking_System')) : ?>
        <p style="padding: 10px; background: #d4edda; border-left: 3px solid #28a745; margin-top: 10px;">
            ✓ WP Booking System is active
        </p>
    <?php else : ?>
        <p style="padding: 10px; background: #f8d7da; border-left: 3px solid #dc3545; margin-top: 10px;">
            ⚠ WP Booking System plugin not detected. Please install and activate it.
        </p>
    <?php endif; ?>
    <?php
}

/**
 * Save Villa Booking Calendar Meta
 */
function nirup_save_villa_booking_calendar($post_id) {
    // Check nonce
    if (!isset($_POST['nirup_villa_booking_calendar_nonce']) || 
        !wp_verify_nonce($_POST['nirup_villa_booking_calendar_nonce'], 'nirup_save_villa_booking_calendar')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save Calendar ID
    if (isset($_POST['villa_booking_calendar_id'])) {
        update_post_meta(
            $post_id, 
            '_villa_booking_calendar_id', 
            sanitize_text_field($_POST['villa_booking_calendar_id'])
        );
    }

    // Save Form ID
    if (isset($_POST['villa_booking_form_id'])) {
        update_post_meta(
            $post_id, 
            '_villa_booking_form_id', 
            sanitize_text_field($_POST['villa_booking_form_id'])
        );
    }
}
add_action('save_post_villa', 'nirup_save_villa_booking_calendar');

/**
 * Enqueue Villa Booking Assets
 */
// function nirup_enqueue_villa_booking_assets() {
//         // Just enqueue the CSS, no custom JS needed
//         wp_enqueue_style(
//             'nirup-villa-booking',
//             get_template_directory_uri() . '/assets/css/villa-booking.css',
//             array(),
//             '1.0.6'
//         );

// }
// add_action('wp_enqueue_scripts', 'nirup_enqueue_villa_booking_assets');

// Enqueue JS
function nirup_enqueue_villa_booking_calendar_assets() {
    // Only load on Riahi Residences page or single villa pages
    if (is_page_template('page-riahi-residences.php') || is_singular('villa')) {
        wp_enqueue_script(
            'nirup-villa-booking-calendar',
            get_template_directory_uri() . '/assets/js/villa-booking-calendar.js',
            array('jquery'),
            '1.0.1',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_villa_booking_calendar_assets');

/**
 * AJAX Handler for Villa Booking Shortcode Processing
 */
function nirup_process_villa_booking_shortcode() {
    // Verify nonce for security
    check_ajax_referer('villa_booking_nonce', 'nonce');
    
    // Get villa ID from AJAX request
    $villa_id = isset($_POST['villa_id']) ? intval($_POST['villa_id']) : 0;
    
    if (!$villa_id) {
        wp_send_json_error('No villa ID provided');
        return;
    }
    
    // Get calendar ID and form ID from villa meta
    $calendar_id = get_post_meta($villa_id, '_villa_booking_calendar_id', true);
    $form_id = get_post_meta($villa_id, '_villa_booking_form_id', true);
    
    // Check if calendar ID exists
    if (!$calendar_id) {
        wp_send_json_error('No calendar ID configured for this villa');
        return;
    }
    
    // Check if WP Booking System is active
    if (!class_exists('WP_Booking_System')) {
        wp_send_json_error('WP Booking System is not active. Please install and activate the plugin.');
        return;
    }

    // Enqueue WPBS styles and scripts
    if (function_exists('wpbs_enqueue_front_end_scripts_and_styles')) {
        wpbs_enqueue_front_end_scripts_and_styles();
    }
    
    // Capture any enqueued styles
    ob_start();
    wp_print_styles();
    $styles = ob_get_clean();

    // Build shortcode with all necessary attributes for villas
    $shortcode_attrs = array(
        'id' => esc_attr($calendar_id),
        'history' => '1', // Show past dates as unavailable
        'selection_type' => 'multiple', // Date range for villa stays
        'selection_style' => 'split' // Split days for check-in/check-out
    );
    
    // Add form_id if available
    if ($form_id) {
        $shortcode_attrs['form_id'] = esc_attr($form_id);
    }
    
    // Build the shortcode string
    $shortcode_parts = array();
    foreach ($shortcode_attrs as $key => $value) {
        $shortcode_parts[] = $key . '="' . $value . '"';
    }
    
    $shortcode = '[wpbs ' . implode(' ', $shortcode_parts) . ']';
    
    // Process the shortcode
    $output = do_shortcode($shortcode);
    
    // Check if output is valid
    if (empty(trim($output)) || $output === $shortcode) {
        wp_send_json_error('Calendar ID ' . esc_html($calendar_id) . ' not found. Please verify the calendar exists in WP Booking System > Calendars.');
        return;
    }
    
    // Combine styles and output
    $full_output = $styles . $output;
    
    // Return success with calendar HTML and metadata
    wp_send_json_success(array(
        'html' => $full_output,
        'calendar_id' => $calendar_id,
        'form_id' => $form_id
    ));
}
add_action('wp_ajax_process_villa_booking_shortcode', 'nirup_process_villa_booking_shortcode');
add_action('wp_ajax_nopriv_process_villa_booking_shortcode', 'nirup_process_villa_booking_shortcode');

function nirup_enqueue_charter_booking_assets() {
    // Only load on the marina page
    if (is_page_template('page-marina.php')) {
        wp_enqueue_script(
            'nirup-charter-booking',
            get_template_directory_uri() . '/assets/js/charter-booking.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_charter_booking_assets');


// Booking calendar meta box removed - now using external booking link in Event/Offer Details

// Event offer booking assets removed - now using external booking links instead of modal

function nirup_add_experience_booking_calendar_meta_box() {
    add_meta_box(
        'experience_booking_calendar',
        '📅 WP Booking System Calendar',
        'nirup_experience_booking_calendar_callback',
        'experience',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_experience_booking_calendar_meta_box');

/**
 * Experience Booking Calendar Meta Box Callback
 */
function nirup_experience_booking_calendar_callback($post) {
    wp_nonce_field('nirup_save_experience_booking_calendar', 'nirup_experience_booking_calendar_nonce');
    
    $calendar_id = get_post_meta($post->ID, '_experience_booking_calendar_id', true);
    $form_id = get_post_meta($post->ID, '_experience_booking_form_id', true);
    ?>
    
    <style>
        .experience-booking-field {
            margin-bottom: 15px;
        }
        .experience-booking-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .experience-booking-input {
            width: 100%;
            padding: 6px 8px;
        }
        .experience-booking-help {
            margin-top: 5px;
            color: #666;
            font-size: 12px;
        }
    </style>

    <div class="experience-booking-field">
        <label class="experience-booking-label" for="experience_booking_calendar_id">
            WP Booking Calendar ID
        </label>
        <input 
            type="text" 
            id="experience_booking_calendar_id" 
            name="experience_booking_calendar_id" 
            value="<?php echo esc_attr($calendar_id); ?>" 
            class="experience-booking-input"
            placeholder="e.g., 1"
        />
        <p class="experience-booking-help">
            Enter the WP Booking System calendar ID for this experience. 
            <br>Find it in: <strong>WP Booking System > Calendars</strong>
        </p>
    </div>

    <div class="experience-booking-field">
        <label class="experience-booking-label" for="experience_booking_form_id">
            WP Booking Form ID
        </label>
        <input 
            type="text" 
            id="experience_booking_form_id" 
            name="experience_booking_form_id" 
            value="<?php echo esc_attr($form_id); ?>" 
            class="experience-booking-input"
            placeholder="e.g., 1"
        />
        <p class="experience-booking-help">
            Enter the WP Booking System form ID to attach to the calendar. 
            <br>Find it in: <strong>WP Booking System > Forms</strong>
        </p>
    </div>

    <?php if (class_exists('WP_Booking_System')) : ?>
        <p style="padding: 10px; background: #d4edda; border-left: 3px solid #28a745; margin-top: 10px;">
            ✓ WP Booking System is active
        </p>
    <?php else : ?>
        <p style="padding: 10px; background: #f8d7da; border-left: 3px solid #dc3545; margin-top: 10px;">
            ⚠ WP Booking System plugin not detected. Please install and activate it.
        </p>
    <?php endif; ?>
    <?php
}

/**
 * Save Experience Booking Calendar Data
 */
function nirup_save_experience_booking_calendar($post_id) {
    // Security checks
    if (!isset($_POST['nirup_experience_booking_calendar_nonce']) || 
        !wp_verify_nonce($_POST['nirup_experience_booking_calendar_nonce'], 'nirup_save_experience_booking_calendar')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save Calendar ID
    if (isset($_POST['experience_booking_calendar_id'])) {
        update_post_meta(
            $post_id, 
            '_experience_booking_calendar_id', 
            sanitize_text_field($_POST['experience_booking_calendar_id'])
        );
    }

    // Save Form ID
    if (isset($_POST['experience_booking_form_id'])) {
        update_post_meta(
            $post_id, 
            '_experience_booking_form_id', 
            sanitize_text_field($_POST['experience_booking_form_id'])
        );
    }
}
add_action('save_post_experience', 'nirup_save_experience_booking_calendar');

/**
 * Enqueue Experience Booking Assets
 */
function nirup_enqueue_experience_booking_assets() {
    // Only load on single experience pages
    if (is_singular('experience')) {
        wp_enqueue_script(
            'nirup-experience-booking',
            get_template_directory_uri() . '/assets/js/experience-booking.js',
            array('jquery'),
            '1.0.0',
            true
        );
        
        // Enqueue villa booking styles (reuse the same modal styles)
        // wp_enqueue_style(
        //     'nirup-villa-booking',
        //     get_template_directory_uri() . '/assets/css/villa-booking.css',
        //     array(),
        //     '1.0.6'
        // );
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_experience_booking_assets');

function wpbs_add_custom_currency($currencies)
{
    $currencies['IDR'] = 'Indonesian rupiah';
    return $currencies;
}
add_filter('wpbs_currencies', 'wpbs_add_custom_currency', 10, 1);

function wpbs_add_custom_currency_symbol($currencies)
{
    $currencies['IDR'] = 'Rp';
    return $currencies;
}
add_filter('wpbs_currency_symbol', 'wpbs_add_custom_currency_symbol', 10, 1);

/**
 * Register Media Coverage Custom Post Type
 */
function nirup_register_media_coverage() {
    $labels = array(
        'name'                  => 'Media Coverage',
        'singular_name'         => 'Media Article',
        'menu_name'             => 'Media Coverage',
        'add_new'               => 'Add New Article',
        'add_new_item'          => 'Add New Media Article',
        'edit_item'             => 'Edit Media Article',
        'new_item'              => 'New Media Article',
        'view_item'             => 'View Media Article',
        'search_items'          => 'Search Media Articles',
        'not_found'             => 'No media articles found',
        'not_found_in_trash'    => 'No media articles found in trash',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => false,
        'publicly_queryable'    => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 27,
        'menu_icon'             => 'dashicons-media-document',
        'supports'              => array('title'),
        'hierarchical'          => false,
        'rewrite'               => false,
        'show_in_rest'          => false,
    );

    register_post_type('media_coverage', $args);
}
add_action('init', 'nirup_register_media_coverage');

/**
 * Add Media Coverage Meta Boxes
 */
function nirup_add_media_coverage_meta_boxes() {
    add_meta_box(
        'media_article_details',
        '📰 Media Article Details',
        'nirup_media_article_details_callback',
        'media_coverage',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_media_coverage_meta_boxes');

/**
 * Media Coverage Meta Box Callback
 */
function nirup_media_article_details_callback($post) {
    wp_nonce_field('nirup_media_article_meta_box', 'nirup_media_article_meta_box_nonce');

    $source = get_post_meta($post->ID, '_media_article_source', true);
    $date = get_post_meta($post->ID, '_media_article_date', true);
    $quote = get_post_meta($post->ID, '_media_article_quote', true);
    $link = get_post_meta($post->ID, '_media_article_link', true);
    ?>

    <style>
        .media-article-meta-box .form-group { margin-bottom: 20px; }
        .media-article-meta-box label { display: block; font-weight: 600; margin-bottom: 8px; }
        .media-article-meta-box input[type="text"],
        .media-article-meta-box input[type="url"],
        .media-article-meta-box textarea { width: 100%; padding: 8px; }
        .media-article-meta-box textarea { min-height: 100px; }
        .media-article-meta-box .description { color: #666; font-style: italic; margin-top: 5px; font-size: 13px; }
        .media-article-meta-box .note-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px;
            margin-bottom: 20px;
        }
    </style>

    <div class="media-article-meta-box">
        <div class="note-box">
            <strong>📌 Note:</strong> The article title is the post title above. Enter additional details below.
        </div>

        <div class="form-group">
            <label for="media_article_source">Publication / Author</label>
            <input type="text" 
                   id="media_article_source" 
                   name="media_article_source" 
                   value="<?php echo esc_attr($source); ?>" 
                   placeholder="e.g., Condé Nast Traveller - July 2025">
            <p class="description">Enter the publication name and date (this will be displayed on the page)</p>
        </div>

        <div class="form-group">
            <label for="media_article_date">Date (for sorting)</label>
            <input type="text" 
                   id="media_article_date" 
                   name="media_article_date" 
                   value="<?php echo esc_attr($date); ?>" 
                   placeholder="e.g., 2025-07">
            <p class="description">Format: YYYY-MM (used for sorting articles chronologically)</p>
        </div>

        <div class="form-group">
            <label for="media_article_quote">Article Quote</label>
            <textarea id="media_article_quote" 
                      name="media_article_quote" 
                      rows="4"><?php echo esc_textarea($quote); ?></textarea>
            <p class="description">A memorable quote or excerpt from the article</p>
        </div>

        <div class="form-group">
            <label for="media_article_link">Article URL</label>
            <input type="url" 
                   id="media_article_link" 
                   name="media_article_link" 
                   value="<?php echo esc_url($link); ?>" 
                   placeholder="https://example.com/article">
            <p class="description">The full URL to the article on the external website</p>
        </div>
    </div>

    <?php
}

/**
 * Save Media Coverage Meta Data
 */
function nirup_save_media_coverage_meta($post_id) {
    // Check if our nonce is set and verify it
    if (!isset($_POST['nirup_media_article_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['nirup_media_article_meta_box_nonce'], 'nirup_media_article_meta_box')) {
        return;
    }

    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save the data
    if (isset($_POST['media_article_source'])) {
        update_post_meta($post_id, '_media_article_source', sanitize_text_field($_POST['media_article_source']));
    }

    if (isset($_POST['media_article_date'])) {
        update_post_meta($post_id, '_media_article_date', sanitize_text_field($_POST['media_article_date']));
    }

    if (isset($_POST['media_article_quote'])) {
        update_post_meta($post_id, '_media_article_quote', sanitize_textarea_field($_POST['media_article_quote']));
    }

    if (isset($_POST['media_article_link'])) {
        update_post_meta($post_id, '_media_article_link', esc_url_raw($_POST['media_article_link']));
    }
}
add_action('save_post', 'nirup_save_media_coverage_meta');

/**
 * Add Admin Columns for Media Coverage
 */
function nirup_media_coverage_admin_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['source'] = __('Publication', 'nirup-island');
    $new_columns['article_date'] = __('Date', 'nirup-island');
    $new_columns['link'] = __('Article Link', 'nirup-island');
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_media_coverage_posts_columns', 'nirup_media_coverage_admin_columns');

/**
 * Populate Admin Columns for Media Coverage
 */
function nirup_media_coverage_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'source':
            $source = get_post_meta($post_id, '_media_article_source', true);
            echo $source ? esc_html($source) : '—';
            break;
        case 'article_date':
            $date = get_post_meta($post_id, '_media_article_date', true);
            echo $date ? esc_html($date) : '—';
            break;
        case 'link':
            $link = get_post_meta($post_id, '_media_article_link', true);
            if ($link) {
                echo '<a href="' . esc_url($link) . '" target="_blank" rel="noopener">View Article ↗</a>';
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_media_coverage_posts_custom_column', 'nirup_media_coverage_admin_column_content', 10, 2);
/**
 * AJAX Handler for Load More Media Articles
 */
function nirup_load_more_media_articles() {
    // Verify nonce
    check_ajax_referer('media_coverage_nonce', 'nonce');
    
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    
    // Query for articles
    $articles_query = new WP_Query(array(
        'post_type' => 'media_coverage',
        'posts_per_page' => 5,
        'orderby' => 'meta_value',
        'meta_key' => '_media_article_date',
        'order' => 'DESC',
        'post_status' => 'publish',
        'paged' => $page
    ));
    
    if ($articles_query->have_posts()) {
        ob_start();
        
        while ($articles_query->have_posts()) {
            $articles_query->the_post();
            $article_id = get_the_ID();
            $source = get_post_meta($article_id, '_media_article_source', true);
            $quote = get_post_meta($article_id, '_media_article_quote', true);
            $link = get_post_meta($article_id, '_media_article_link', true);
            ?>
            
            <div class="media-article-item" data-page="<?php echo esc_attr($page); ?>">
                <div class="article-header">
                    <h2 class="article-title"><?php echo esc_html(get_the_title()); ?></h2>
                    
                    <?php if ($source) : ?>
                        <p class="article-source"><?php echo esc_html($source); ?></p>
                    <?php endif; ?>
                    
                    <div class="article-divider"></div>
                </div>
                
                <div class="article-content">
                    <?php if ($quote) : ?>
                        <blockquote class="article-quote"><?php echo esc_html($quote); ?></blockquote>
                    <?php endif; ?>
                    
                    <?php if ($link) : ?>
                        <a href="<?php echo esc_url($link); ?>" 
                           class="article-link-btn" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            Read Full Article
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php
        }
        
        $html = ob_get_clean();
        wp_reset_postdata();
        
        wp_send_json_success(array(
            'html' => $html,
            'page' => $page
        ));
    } else {
        wp_send_json_error(array(
            'message' => 'No more articles found'
        ));
    }
    
    wp_die();
}
add_action('wp_ajax_load_more_media_articles', 'nirup_load_more_media_articles');
add_action('wp_ajax_nopriv_load_more_media_articles', 'nirup_load_more_media_articles');

/**
 * Add Media Coverage Page Customizer Options
 * Add this code to your functions.php file
 */
function nirup_media_coverage_customizer($wp_customize) {
    // Media Coverage Section
    $wp_customize->add_section('nirup_media_coverage_page', array(
        'title' => __('Media Coverage Page', 'nirup-island'),
        'priority' => 45,
        'description' => __('Customize the Media Coverage page hero section', 'nirup-island'),
    ));

    // Page Title
    $wp_customize->add_setting('nirup_media_coverage_title', array(
        'default' => __('Media Coverage', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('nirup_media_coverage_title', array(
        'label' => __('Page Title', 'nirup-island'),
        'section' => 'nirup_media_coverage_page',
        'type' => 'text',
        'description' => __('Main heading for the Media Coverage page', 'nirup-island'),
    ));

    // Page Subtitle
    $wp_customize->add_setting('nirup_media_coverage_subtitle', array(
        'default' => __('Stay up to date with how Nirup Island is being recognized', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('nirup_media_coverage_subtitle', array(
        'label' => __('Subtitle Line', 'nirup-island'),
        'section' => 'nirup_media_coverage_page',
        'type' => 'text',
        'description' => __('Subtitle', 'nirup-island'),
    ));


    // Show/Hide Subtitle
    $wp_customize->add_setting('nirup_media_coverage_show_subtitle', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('nirup_media_coverage_show_subtitle', array(
        'label' => __('Show Subtitle', 'nirup-island'),
        'section' => 'nirup_media_coverage_page',
        'type' => 'checkbox',
        'description' => __('Toggle to show/hide the subtitle text', 'nirup-island'),
    ));
}
add_action('customize_register', 'nirup_media_coverage_customizer');

// =======================
// Press Kit Page Customizer Settings
// =======================
// Add this to your functions.php file

function nirup_press_kit_customizer($wp_customize) {
    
    // Add Press Kit Section
    $wp_customize->add_section('nirup_press_kit', array(
        'title' => __('Press Kit Page', 'nirup-island'),
        'priority' => 90,
    ));

    // Hero Section Settings
    // Subtitle
    $wp_customize->add_setting('press_kit_subtitle', array(
        'default' => 'FOR YOUR MEDIA COVERAGE',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('press_kit_subtitle', array(
        'label' => __('Hero Subtitle', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'text',
    ));

    // Title
    $wp_customize->add_setting('press_kit_title', array(
        'default' => 'Press kit',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('press_kit_title', array(
        'label' => __('Hero Title', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'text',
    ));

    // Description
    $wp_customize->add_setting('press_kit_description', array(
        'default' => 'Welcome to the Nirup Island Press Kit. Here you\'ll find everything you need to cover our story — from official logos and brand assets to high-resolution photos and videos. These materials are free to use for editorial purposes when featuring Nirup Island.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('press_kit_description', array(
        'label' => __('Description Text', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'textarea',
    ));

    // Card 1 - Logos
    // Card 1 Image
    $wp_customize->add_setting('press_kit_card1_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'press_kit_card1_image', array(
        'label' => __('Card 1 - Image', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'settings' => 'press_kit_card1_image',
    )));

    // Card 1 Title
    $wp_customize->add_setting('press_kit_card1_title', array(
        'default' => 'Logos',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('press_kit_card1_title', array(
        'label' => __('Card 1 - Title', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'text',
    ));

    // Card 1 File
    $wp_customize->add_setting('press_kit_card1_file', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'press_kit_card1_file', array(
        'label' => __('Card 1 - Download File (ZIP)', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'settings' => 'press_kit_card1_file',
    )));

    // Card 2 - Photos
    // Card 2 Image
    $wp_customize->add_setting('press_kit_card2_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'press_kit_card2_image', array(
        'label' => __('Card 2 - Image', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'settings' => 'press_kit_card2_image',
    )));

    // Card 2 Title
    $wp_customize->add_setting('press_kit_card2_title', array(
        'default' => 'Photos',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('press_kit_card2_title', array(
        'label' => __('Card 2 - Title', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'text',
    ));

    // Card 2 File
    $wp_customize->add_setting('press_kit_card2_file', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'press_kit_card2_file', array(
        'label' => __('Card 2 - Download File (ZIP)', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'settings' => 'press_kit_card2_file',
    )));

    // Card 3 - Videos
    // Card 3 Image
    $wp_customize->add_setting('press_kit_card3_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'press_kit_card3_image', array(
        'label' => __('Card 3 - Image', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'settings' => 'press_kit_card3_image',
    )));

    // Card 3 Title
    $wp_customize->add_setting('press_kit_card3_title', array(
        'default' => 'Videos',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('press_kit_card3_title', array(
        'label' => __('Card 3 - Title', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'text',
    ));

    // Card 3 File
    $wp_customize->add_setting('press_kit_card3_file', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'press_kit_card3_file', array(
        'label' => __('Card 3 - Download File (ZIP)', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'settings' => 'press_kit_card3_file',
    )));

    // Press Contacts Section
    // Title
    $wp_customize->add_setting('press_kit_contacts_title', array(
        'default' => 'Press Contacts',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('press_kit_contacts_title', array(
        'label' => __('Press Contacts - Title', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'text',
    ));

    // Label
    $wp_customize->add_setting('press_kit_contacts_label', array(
        'default' => 'For media inquiries:',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('press_kit_contacts_label', array(
        'label' => __('Press Contacts - Label', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'text',
    ));

    // Email
    $wp_customize->add_setting('press_kit_contacts_email', array(
        'default' => 'Marcomm@citrabuanaprakarsa.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('press_kit_contacts_email', array(
        'label' => __('Press Contacts - Email', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'email',
    ));
}
add_action('customize_register', 'nirup_press_kit_customizer');

function nirup_register_selling_unit_post_type() {
    $labels = array(
        'name'                  => _x('Selling Units', 'Post type general name', 'nirup-island'),
        'singular_name'         => _x('Selling Unit', 'Post type singular name', 'nirup-island'),
        'menu_name'             => _x('Selling Units', 'Admin Menu text', 'nirup-island'),
        'add_new'               => __('Add New', 'nirup-island'),
        'add_new_item'          => __('Add New Unit', 'nirup-island'),
        'new_item'              => __('New Unit', 'nirup-island'),
        'edit_item'             => __('Edit Unit', 'nirup-island'),
        'view_item'             => __('View Unit', 'nirup-island'),
        'all_items'             => __('All Units', 'nirup-island'),
        'search_items'          => __('Search Units', 'nirup-island'),
        'not_found'             => __('No units found.', 'nirup-island'),
        'not_found_in_trash'    => __('No units found in Trash.', 'nirup-island'),
        'featured_image'        => __('Unit Featured Image', 'nirup-island'),
        'set_featured_image'    => __('Set unit featured image', 'nirup-island'),
        'remove_featured_image' => __('Remove unit featured image', 'nirup-island'),
        'use_featured_image'    => __('Use as unit featured image', 'nirup-island'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'menu_icon'          => 'dashicons-admin-multisite',
        'supports'           => array('title', 'thumbnail'),
    );

    register_post_type('selling_unit', $args);
}
add_action('init', 'nirup_register_selling_unit_post_type');

// ========== 2. ADD META BOXES FOR SELLING UNIT DETAILS ==========

function nirup_add_selling_unit_meta_boxes() {
    add_meta_box(
        'selling_unit_details',
        __('Unit Details', 'nirup-island'),
        'nirup_render_selling_unit_details_meta_box',
        'selling_unit',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_selling_unit_meta_boxes');

function nirup_render_selling_unit_details_meta_box($post) {
    wp_nonce_field('nirup_save_selling_unit_details', 'nirup_selling_unit_nonce');
    
    $subtitle = get_post_meta($post->ID, '_unit_subtitle', true);
    $bedrooms = get_post_meta($post->ID, '_unit_bedrooms', true);
    $size = get_post_meta($post->ID, '_unit_size', true);
    $status = get_post_meta($post->ID, '_unit_status', true);
    $price = get_post_meta($post->ID, '_unit_price', true);
    ?>
    
    <table class="form-table">
        <tr>
            <th><label for="unit_subtitle"><?php _e('Subtitle', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="unit_subtitle" name="unit_subtitle" 
                       value="<?php echo esc_attr($subtitle); ?>" class="regular-text"
                       placeholder="e.g., Ocean view villa with private pool">
                <p class="description"><?php _e('Descriptive subtitle shown above the unit title', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="unit_bedrooms"><?php _e('Bedrooms', 'nirup-island'); ?></label></th>
            <td>
                <input type="number" id="unit_bedrooms" name="unit_bedrooms" 
                       value="<?php echo esc_attr($bedrooms); ?>" class="small-text" min="1" max="10">
                <p class="description"><?php _e('Number of bedrooms', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="unit_size"><?php _e('Size (sqm)', 'nirup-island'); ?></label></th>
            <td>
                <input type="number" id="unit_size" name="unit_size" 
                       value="<?php echo esc_attr($size); ?>" class="small-text" min="1">
                <p class="description"><?php _e('Size in square meters', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="unit_status"><?php _e('Status', 'nirup-island'); ?></label></th>
            <td>
                <select id="unit_status" name="unit_status">
                    <option value="Available" <?php selected($status, 'Available'); ?>><?php _e('Available', 'nirup-island'); ?></option>
                    <option value="Reserved" <?php selected($status, 'Reserved'); ?>><?php _e('Reserved', 'nirup-island'); ?></option>
                    <option value="Sold" <?php selected($status, 'Sold'); ?>><?php _e('Sold', 'nirup-island'); ?></option>
                </select>
                <p class="description"><?php _e('Current availability status', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="unit_price"><?php _e('Price', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="unit_price" name="unit_price" 
                       value="<?php echo esc_attr($price); ?>" class="regular-text"
                       placeholder="e.g., $289,000 USD">
                <p class="description"><?php _e('Display price with currency (e.g., $289,000 USD)', 'nirup-island'); ?></p>
            </td>
        </tr>
    </table>
    
    <?php
}

function nirup_save_selling_unit_details($post_id) {
    if (!isset($_POST['nirup_selling_unit_nonce']) || 
        !wp_verify_nonce($_POST['nirup_selling_unit_nonce'], 'nirup_save_selling_unit_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['unit_subtitle'])) {
        update_post_meta($post_id, '_unit_subtitle', sanitize_text_field($_POST['unit_subtitle']));
    }
    
    if (isset($_POST['unit_bedrooms'])) {
        update_post_meta($post_id, '_unit_bedrooms', absint($_POST['unit_bedrooms']));
    }
    
    if (isset($_POST['unit_size'])) {
        update_post_meta($post_id, '_unit_size', absint($_POST['unit_size']));
    }
    
    if (isset($_POST['unit_status'])) {
        update_post_meta($post_id, '_unit_status', sanitize_text_field($_POST['unit_status']));
    }
    
    if (isset($_POST['unit_price'])) {
        update_post_meta($post_id, '_unit_price', sanitize_text_field($_POST['unit_price']));
    }
}
add_action('save_post_selling_unit', 'nirup_save_selling_unit_details');

// ========== 3. ADMIN COLUMNS FOR SELLING UNITS ==========

function nirup_selling_unit_admin_columns($columns) {
    $new_columns = array(
        'cb' => $columns['cb'],
        'thumbnail' => __('Image', 'nirup-island'),
        'title' => $columns['title'],
        'bedrooms' => __('Bedrooms', 'nirup-island'),
        'size' => __('Size', 'nirup-island'),
        'status' => __('Status', 'nirup-island'),
        'price' => __('Price', 'nirup-island'),
        'date' => $columns['date']
    );
    return $new_columns;
}
add_filter('manage_selling_unit_posts_columns', 'nirup_selling_unit_admin_columns');

function nirup_selling_unit_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'thumbnail':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(60, 60));
            } else {
                echo '—';
            }
            break;
        case 'bedrooms':
            $bedrooms = get_post_meta($post_id, '_unit_bedrooms', true);
            echo $bedrooms ? esc_html($bedrooms) : '—';
            break;
        case 'size':
            $size = get_post_meta($post_id, '_unit_size', true);
            echo $size ? esc_html($size) . ' sqm' : '—';
            break;
        case 'status':
            $status = get_post_meta($post_id, '_unit_status', true);
            if ($status) {
                $color = ($status === 'Available') ? '#28a745' : (($status === 'Reserved') ? '#ffc107' : '#dc3545');
                echo '<span style="color: ' . $color . '; font-weight: 600;">' . esc_html($status) . '</span>';
            } else {
                echo '—';
            }
            break;
        case 'price':
            $price = get_post_meta($post_id, '_unit_price', true);
            echo $price ? esc_html($price) : '—';
            break;
    }
}
add_action('manage_selling_unit_posts_custom_column', 'nirup_selling_unit_admin_column_content', 10, 2);

// ========== 4. ENQUEUE ASSETS FOR VILLA SELLING PAGE ==========

function nirup_enqueue_villa_selling_assets() {
    if (is_page_template('page-villa-selling.php')) {
        // Enqueue CSS
        wp_enqueue_style(
            'nirup-villa-selling',
            get_template_directory_uri() . '/assets/css/villa-selling.css',
            array(),
            '1.0.0'
        );
        
        // Enqueue JavaScript
        wp_enqueue_script(
            'nirup-villa-selling',
            get_template_directory_uri() . '/assets/js/villa-selling.js',
            array('jquery'),
            '1.0.0',
            true
        );
        
        // Localize script
        wp_localize_script('nirup-villa-selling', 'nirup_villa_selling_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('nirup_villa_selling_form_nonce')
        ));
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_villa_selling_assets');

// ========== 5. FORM SUBMISSION HANDLER ==========

function nirup_villa_selling_form_submit() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'nirup_villa_selling_form_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed.'));
    }

    // Get form data
    $form_data = $_POST['form_data'];
    
    $name = sanitize_text_field($form_data['name']);
    $email = sanitize_email($form_data['email']);
    $phone = sanitize_text_field($form_data['phone']);
    $language = sanitize_text_field($form_data['language']);
    $villa_unit = sanitize_text_field($form_data['villa_unit']);
    $message = sanitize_textarea_field($form_data['message']);
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($phone)) {
        wp_send_json_error(array('message' => 'Please fill in all required fields.'));
    }
    
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'));
    }

    // Store in database
    nirup_store_villa_selling_submission($name, $email, $phone, $language, $villa_unit, $message);
    
    // Prepare email to admin
    $admin_email = get_option('admin_email');
    $admin_subject = sprintf('[Villa Selling Enquiry] New enquiry from %s', $name);
    
    $admin_body = sprintf(
        "New Villa Selling Enquiry\n\n" .
        "Name: %s\n" .
        "Email: %s\n" .
        "Phone: %s\n" .
        "Preferred Language: %s\n" .
        "Villa Interest: %s\n\n" .
        "Message:\n%s\n\n" .
        "---\n" .
        "This enquiry was submitted from the Villa Selling Options page at %s",
        $name,
        $email,
        $phone,
        $language ? $language : 'Not specified',
        $villa_unit ? $villa_unit : 'Not specified',
        $message,
        get_site_url()
    );
    
    $admin_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );
    
    // Prepare confirmation email to user
    $user_subject = 'Thank you for your enquiry - Nirup Island';
    $user_body = sprintf(
        "Dear %s,\n\n" .
        "Thank you for your interest in owning a villa at Nirup Island.\n\n" .
        "We have received your enquiry and our sales team will contact you within 24 hours to discuss your requirements.\n\n" .
        "Your Enquiry Details:\n" .
        "- Preferred Language: %s\n" .
        "- Villa Interest: %s\n" .
        "- Message: %s\n\n" .
        "We look forward to helping you find your perfect island retreat.\n\n" .
        "Best regards,\n" .
        "Nirup Island Sales Team\n\n" .
        "---\n" .
        "If you have any questions, please contact us at %s",
        $name,
        $language ? $language : 'Not specified',
        $villa_unit ? $villa_unit : 'Not specified',
        $message ? $message : 'No additional message',
        $admin_email
    );
    
    $user_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: Nirup Island <' . get_option('admin_email') . '>'
    );
    
    // Send emails
    $admin_mail_sent = wp_mail($admin_email, $admin_subject, $admin_body, $admin_headers);
    $user_mail_sent = wp_mail($email, $user_subject, $user_body, $user_headers);
    
    // Log results
    error_log('Villa Selling Form - Admin email result: ' . ($admin_mail_sent ? 'SUCCESS' : 'FAILED'));
    error_log('Villa Selling Form - User email result: ' . ($user_mail_sent ? 'SUCCESS' : 'FAILED'));
    
    // Return success response
    wp_send_json_success(array(
        'message' => 'Your enquiry has been received! Our sales team will contact you within 24 hours.',
        'admin_sent' => $admin_mail_sent,
        'user_sent' => $user_mail_sent
    ));
}
add_action('wp_ajax_nirup_villa_selling_form_submit', 'nirup_villa_selling_form_submit');
add_action('wp_ajax_nopriv_nirup_villa_selling_form_submit', 'nirup_villa_selling_form_submit');

// ========== 6. STORE SUBMISSION IN DATABASE ==========

function nirup_store_villa_selling_submission($name, $email, $phone, $language, $villa_unit, $message) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'villa_selling_submissions';
    
    // Create table if it doesn't exist
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        nirup_create_villa_selling_submissions_table();
    }
    
    // Insert submission
    $result = $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'language' => $language,
            'villa_unit' => $villa_unit,
            'message' => $message,
            'submission_date' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );
    
    if ($result === false) {
        error_log('Villa Selling Form - Database storage failed: ' . $wpdb->last_error);
    } else {
        error_log('Villa Selling Form - Submission saved to database successfully');
    }
}

function nirup_create_villa_selling_submissions_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'villa_selling_submissions';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(50) NOT NULL,
        language varchar(50) DEFAULT NULL,
        villa_unit varchar(255) DEFAULT NULL,
        message text DEFAULT NULL,
        submission_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        status varchar(50) DEFAULT 'pending' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Create table on theme activation
add_action('after_switch_theme', 'nirup_create_villa_selling_submissions_table');

// ========== 7. ADMIN PAGE FOR SUBMISSIONS ==========

function nirup_villa_selling_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=selling_unit',
        'Enquiries',
        'Enquiries',
        'manage_options',
        'villa-selling-enquiries',
        'nirup_villa_selling_enquiries_page'
    );
}
add_action('admin_menu', 'nirup_villa_selling_admin_menu');

function nirup_villa_selling_enquiries_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'villa_selling_submissions';
    
    $submissions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submission_date DESC");
    ?>
    <div class="wrap">
        <h1>Villa Selling Enquiries</h1>
        
        <?php if (empty($submissions)): ?>
            <p>No enquiries yet.</p>
        <?php else: ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Villa Interest</th>
                        <th>Language</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $submission): ?>
                        <tr>
                            <td><?php echo date('M j, Y', strtotime($submission->submission_date)); ?></td>
                            <td><strong><?php echo esc_html($submission->name); ?></strong></td>
                            <td><a href="mailto:<?php echo esc_attr($submission->email); ?>"><?php echo esc_html($submission->email); ?></a></td>
                            <td><?php echo esc_html($submission->phone); ?></td>
                            <td><?php echo $submission->villa_unit ? esc_html($submission->villa_unit) : '—'; ?></td>
                            <td><?php echo $submission->language ? esc_html($submission->language) : '—'; ?></td>
                            <td><?php echo esc_html($submission->status); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php
}

// ========== 8. CUSTOMIZER SETTINGS ==========

function nirup_villa_selling_customizer($wp_customize) {
    // Add Villa Selling Section
    $wp_customize->add_section('nirup_villa_selling', array(
        'title'    => __('Villa Selling Options Page', 'nirup-island'),
        'priority' => 160,
    ));

    // Hero Image
    $wp_customize->add_setting('nirup_villa_selling_hero_image', array(
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_villa_selling_hero_image', array(
        'label'    => __('Hero Background Image', 'nirup-island'),
        'section'  => 'nirup_villa_selling',
        'mime_type' => 'image',
    )));

    // Hero Title
    $wp_customize->add_setting('nirup_villa_selling_hero_title', array(
        'default' => __('Own Your Private Island Retreat', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('nirup_villa_selling_hero_title', array(
        'label'   => __('Hero Title', 'nirup-island'),
        'section' => 'nirup_villa_selling',
        'type'    => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('nirup_villa_selling_hero_subtitle', array(
        'default' => __('Wake up to the sound of the sea and make Nirup Island your home.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('nirup_villa_selling_hero_subtitle', array(
        'label'   => __('Hero Subtitle', 'nirup-island'),
        'section' => 'nirup_villa_selling',
        'type'    => 'textarea',
    ));

    // Overview Column 1 Heading
    $wp_customize->add_setting('nirup_villa_selling_overview_col1_heading', array(
        'default' => __('Own a luxury villa on a private island', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('nirup_villa_selling_overview_col1_heading', array(
        'label'   => __('Overview Column 1 - Heading', 'nirup-island'),
        'section' => 'nirup_villa_selling',
        'type'    => 'text',
    ));

    // Overview Column 2 Text
    $wp_customize->add_setting('nirup_villa_selling_overview_col2_text', array(
        'default' => __('Riahi Residences offers an exclusive opportunity to own a home on Nirup Island, where refined comfort meets the serenity of the sea.', 'nirup-island'),
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('nirup_villa_selling_overview_col2_text', array(
        'label'   => __('Overview Column 2 - Text', 'nirup-island'),
        'section' => 'nirup_villa_selling',
        'type'    => 'textarea',
    ));

    // Overview Column 3 Text
    $wp_customize->add_setting('nirup_villa_selling_overview_col3_text', array(
        'default' => __('Each residence is professionally maintained through a monthly management fee, with optional services provided by The Westin Nirup Island Resort & Spa.', 'nirup-island'),
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('nirup_villa_selling_overview_col3_text', array(
        'label'   => __('Overview Column 3 - Text', 'nirup-island'),
        'section' => 'nirup_villa_selling',
        'type'    => 'textarea',
    ));

    // Form Heading
    $wp_customize->add_setting('nirup_villa_selling_form_heading', array(
        'default' => __('Enquire About Villa Ownership', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('nirup_villa_selling_form_heading', array(
        'label'   => __('Form Section - Heading', 'nirup-island'),
        'section' => 'nirup_villa_selling',
        'type'    => 'text',
    ));

    // Form Description
    $wp_customize->add_setting('nirup_villa_selling_form_description', array(
        'default' => __('Experience the freedom of owning a home by the sea. Please fill out the form below and our sales team will contact you within 24 hours.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('nirup_villa_selling_form_description', array(
        'label'   => __('Form Section - Description', 'nirup-island'),
        'section' => 'nirup_villa_selling',
        'type'    => 'textarea',
    ));
}
add_action('customize_register', 'nirup_villa_selling_customizer');

function nirup_add_selling_unit_features_meta_box() {
    add_meta_box(
        'selling_unit_features',
        __('Unit Features', 'nirup-island'),
        'nirup_selling_unit_features_meta_box_callback',
        'selling_unit',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_selling_unit_features_meta_box');

/**
 * Selling Unit Features Meta Box Callback
 */
function nirup_selling_unit_features_meta_box_callback($post) {
    wp_nonce_field('nirup_save_selling_unit_features', 'nirup_selling_unit_features_nonce');
    
    $features = get_post_meta($post->ID, '_unit_features', true);
    if (!is_array($features)) {
        $features = array();
    }
    
    $available_icons = nirup_get_villa_feature_icons(); // Use the same icon library
    ?>
    
    <div id="selling-unit-features-wrapper">
        <div id="selling-unit-features-list">
            <?php
            if (!empty($features)) {
                foreach ($features as $index => $feature) {
                    $feature_text = isset($feature['text']) ? $feature['text'] : (is_string($feature) ? $feature : '');
                    $feature_icon = isset($feature['icon']) ? $feature['icon'] : '';
                    
                    nirup_render_selling_unit_feature_row($feature_text, $feature_icon, $available_icons);
                }
            }
            ?>
        </div>
        
        <button type="button" id="add-unit-feature" class="button button-secondary" style="margin-top: 10px;">
            + Add Feature
        </button>
        
        <?php if (empty($available_icons)) : ?>
            <p style="margin-top: 15px; padding: 12px; background: #fff3cd; border-left: 4px solid #ffc107;">
                <strong>No icons available.</strong> 
                <a href="<?php echo admin_url('edit.php?post_type=villa&page=villa-feature-icons'); ?>">Upload icons to the library</a> first.
            </p>
        <?php endif; ?>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Add feature
        $('#add-unit-feature').on('click', function() {
            var featureHtml = <?php echo json_encode(nirup_get_selling_unit_feature_row_html($available_icons)); ?>;
            $('#selling-unit-features-list').append(featureHtml);
        });
        
        // Remove feature
        $(document).on('click', '.remove-unit-feature', function() {
            $(this).closest('.selling-unit-feature-item').remove();
        });
        
        // Icon preview on change
        $(document).on('change', '.unit-feature-icon-select', function() {
            var iconUrl = $(this).find(':selected').data('icon-url');
            var preview = $(this).siblings('.unit-icon-preview');
            
            if (iconUrl) {
                preview.html('<img src="' + iconUrl + '" style="width: 28px; height: 28px;">');
            } else {
                preview.html('<span style="font-size: 20px; color: #a48456;">•</span>');
            }
        });
    });
    </script>
    
    <style>
        .selling-unit-feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            padding: 15px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .unit-icon-preview {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .unit-feature-icon-select {
            width: 200px;
        }
        .unit-feature-text-input {
            flex: 1;
        }
    </style>
    
    <?php
}

/**
 * Render a single selling unit feature row
 */
function nirup_render_selling_unit_feature_row($text = '', $icon = '', $available_icons = array()) {
    ?>
    <div class="selling-unit-feature-item">
        <div class="unit-icon-preview">
            <?php if ($icon && isset($available_icons[$icon])) : ?>
                <img src="<?php echo esc_url($available_icons[$icon]['url']); ?>" style="width: 28px; height: 28px;">
            <?php else : ?>
                <span style="font-size: 20px; color: #a48456;">•</span>
            <?php endif; ?>
        </div>
        
        <select name="unit_features_icon[]" class="unit-feature-icon-select">
            <option value="">No icon (bullet point)</option>
            <?php foreach ($available_icons as $available_icon) : ?>
                <option value="<?php echo esc_attr($available_icon['filename']); ?>" 
                        data-icon-url="<?php echo esc_url($available_icon['url']); ?>"
                        <?php selected($icon, $available_icon['filename']); ?>>
                    <?php echo esc_html($available_icon['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <input 
            type="text" 
            name="unit_features_text[]" 
            value="<?php echo esc_attr($text); ?>" 
            placeholder="e.g., Private Pool, Ocean View, Modern Kitchen"
            class="unit-feature-text-input"
        />
        
        <button type="button" class="button remove-unit-feature">Remove</button>
    </div>
    <?php
}

/**
 * Get HTML for new selling unit feature row
 */
function nirup_get_selling_unit_feature_row_html($available_icons) {
    ob_start();
    nirup_render_selling_unit_feature_row('', '', $available_icons);
    return ob_get_clean();
}

/**
 * Save Selling Unit Features
 */
function nirup_save_selling_unit_features($post_id) {
    if (!isset($_POST['nirup_selling_unit_features_nonce']) || 
        !wp_verify_nonce($_POST['nirup_selling_unit_features_nonce'], 'nirup_save_selling_unit_features')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $features = array();
    
    if (isset($_POST['unit_features_text']) && is_array($_POST['unit_features_text'])) {
        $feature_texts = $_POST['unit_features_text'];
        $feature_icons = isset($_POST['unit_features_icon']) ? $_POST['unit_features_icon'] : array();
        
        foreach ($feature_texts as $index => $text) {
            $text = sanitize_text_field($text);
            if (!empty($text)) {
                $features[] = array(
                    'text' => $text,
                    'icon' => isset($feature_icons[$index]) ? sanitize_file_name($feature_icons[$index]) : ''
                );
            }
        }
    }
    
    update_post_meta($post_id, '_unit_features', $features);
}
add_action('save_post_selling_unit', 'nirup_save_selling_unit_features');

function nirup_redirect_cart_to_checkout() {

    // Never run this in admin or AJAX.
    if ( is_admin() ) {
        return;
    }

    // Only act on the real Cart page.
    if ( ! function_exists( 'is_cart' ) || ! is_cart() ) {
        return;
    }

    // Ensure WooCommerce cart exists.
    if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
        return;
    }

    // IMPORTANT: If cart is empty, do NOT redirect.
    // WooCommerce (or WP Booking System) may legitimately land on Cart
    // with an empty cart, and redirecting would cause a loop.
    if ( WC()->cart->is_empty() ) {
        return;
    }

    // Extra safety: if for some reason this runs on checkout, bail.
    if ( function_exists( 'is_checkout' ) && is_checkout() ) {
        return;
    }

    if ( function_exists( 'wc_get_checkout_url' ) ) {
        $checkout_url = wc_get_checkout_url();

        if ( ! empty( $checkout_url ) ) {
            wp_safe_redirect( $checkout_url );
            exit;
        }
    }
}
add_action( 'template_redirect', 'nirup_redirect_cart_to_checkout' );

?>