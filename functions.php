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
function nirup_enqueue_assets() {
    // Debug output
    if (current_user_can('manage_options')) {
        echo '<script>console.log("🔧 FIXED nirup_enqueue_assets function running!");</script>';
    }
    
    // === EXPLICITLY ENQUEUE JQUERY FIRST ===
    wp_enqueue_script('jquery');
    
    if (current_user_can('manage_options')) {
        echo '<script>console.log("✅ jQuery explicitly enqueued");</script>';
    }
    
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



    // === GOOGLE FONTS ===
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Albert+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', array(), null);
    
    // === JAVASCRIPT FILES WITH EXPLICIT JQUERY DEPENDENCY ===
    
    // 1. Core utilities - explicitly depend on 'jquery' handle
    wp_enqueue_script(
        'nirup-utils', 
        get_template_directory_uri() . '/assets/js/utils.js', 
        array('jquery'), 
        '1.0.2', 
        true
    );
    
    if (current_user_can('manage_options')) {
        echo '<script>console.log("📝 nirup-utils enqueued");</script>';
    }
    
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
    
    // NEW: 8. Experiences carousel
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

    
    if (current_user_can('manage_options')) {
        echo '<script>console.log("✅ All JavaScript files enqueued!");</script>';
    }
    
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

    wp_localize_script('nirup-footer', 'nirup_footer_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('newsletter_nonce'),
        'messages' => array(
            'subscribing' => __('Subscribing...', 'nirup-island'),
            'error' => __('Something went wrong. Please try again.', 'nirup-island'),
        )
    ));

    
    
    if (current_user_can('manage_options')) {
        echo '<script>console.log("✅ Script localization complete!");</script>';
    }

    
}

// Make sure the hook is properly registered
remove_action('wp_enqueue_scripts', 'nirup_enqueue_assets'); // Remove any existing
add_action('wp_enqueue_scripts', 'nirup_enqueue_assets'); // Add fresh

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
    
    echo '<table class="form-table">';
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
    echo '<p class="description">Choose the template style for displaying this category page.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Detailed Template Fields
    $show_detailed_fields = ($experience_type === 'category' && $category_template === 'detailed');
    
    // Subtitle Field
    echo '<tr id="detailed_subtitle_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label for="detailed_subtitle">Subtitle</label></th>';
    echo '<td><input type="text" id="detailed_subtitle" name="detailed_subtitle" value="' . esc_attr($detailed_subtitle) . '" class="widefat" placeholder="e.g., Adventure, relaxation, and discovery await" />';
    echo '<p class="description">Subtitle that appears under the main title (for detailed template).</p></td>';
    echo '</tr>';
    
    // Quote Section
    echo '<tr id="quote_section_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Quote Section</label></th>';
    echo '<td>';
    echo '<input type="text" id="quote_title" name="quote_title" value="' . esc_attr($quote_title) . '" class="widefat" placeholder="e.g., ISLAND WISDOM" style="margin-bottom: 10px;" />';
    echo '<label for="quote_title" style="display: block; margin-bottom: 10px; font-size: 12px; color: #666;">Quote Title</label>';
    echo '<textarea id="quote_text" name="quote_text" class="widefat" rows="3" placeholder="e.g., The sea whispers secrets only travelers can hear.">' . esc_textarea($quote_text) . '</textarea>';
    echo '<label for="quote_text" style="display: block; margin-top: 5px; font-size: 12px; color: #666;">Quote Text</label>';
    echo '<p class="description">Quote section that appears in the content area (for detailed template).</p>';
    echo '</td>';
    echo '</tr>';
    
    // Nature Section
    echo '<tr id="nature_section_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Nature Section</label></th>';
    echo '<td>';
    echo '<label><input type="checkbox" name="show_nature_section" value="1"' . checked($show_nature_section, 1, false) . ' /> Show Nature Section</label><br>';
    echo '<input type="text" id="nature_section_text" name="nature_section_text" value="' . esc_attr($nature_section_text) . '" class="widefat" placeholder="e.g., NATURE" style="margin-top: 10px;" />';
    echo '<p class="description">Text for the nature section divider. Leave empty for default "NATURE".</p>';
    echo '</td>';
    echo '</tr>';
    
    // Region Section
    echo '<tr id="region_section_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Region Section</label></th>';
    echo '<td>';
    echo '<label><input type="checkbox" name="show_region_section" value="1"' . checked($show_region_section, 1, false) . ' /> Show Region Section</label><br>';
    echo '<input type="text" id="region_section_text" name="region_section_text" value="' . esc_attr($region_section_text) . '" class="widefat" placeholder="e.g., REGION" style="margin-top: 10px;" />';
    echo '<p class="description">Text for the region section divider. Leave empty for default "REGION".</p>';
    echo '</td>';
    echo '</tr>';
    
    // Hero Banner Gallery Row (only for detailed template)
    echo '<tr id="hero_gallery_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label for="hero_banner_gallery">Hero Banner Gallery</label></th>';
    echo '<td>';
    echo '<div id="hero_gallery_container">';
    
    // Display current gallery images
    if ($hero_gallery && is_array($hero_gallery)) {
        echo '<div class="hero-gallery-images" style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">';
        foreach ($hero_gallery as $index => $image_id) {
            $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
            if ($image_url) {
                echo '<div class="hero-gallery-item" style="position: relative; width: 100px; height: 100px;">';
                echo '<img src="' . esc_url($image_url) . '" style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #ddd;" />';
                echo '<button type="button" class="remove-gallery-image" data-index="' . $index . '" style="position: absolute; top: -5px; right: -5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1;">×</button>';
                echo '<input type="hidden" name="hero_banner_gallery[]" value="' . esc_attr($image_id) . '">';
                echo '</div>';
            }
        }
        echo '</div>';
    } else {
        echo '<div class="hero-gallery-images" style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;"></div>';
    }
    
    echo '<button type="button" id="add_gallery_images" class="button button-primary">Select All Gallery Images (Up to 4)</button>';
    echo '<button type="button" id="clear_gallery_images" class="button" style="margin-left: 10px;">Clear All Images</button>';
    echo '<p class="description">Select up to 4 images for the hero banner gallery. You can select multiple images at once and they will replace the current gallery. Images are for the detailed template only.</p>';
    echo '</div>';
    echo '</td>';
    echo '</tr>';
    
    // Additional Content Section
    echo '<tr id="additional_section_toggle_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Additional Content Section</label></th>';
    echo '<td>';
    echo '<label><input type="checkbox" id="show_additional_section" name="show_additional_section" value="1"' . checked($show_additional_section, 1, false) . ' onchange="toggleAdditionalSection()" /> Enable Additional Content Section</label>';
    echo '<p class="description">Add an additional content section below the region divider with 2 images, quote, and content.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Additional Section Images
    echo '<tr id="additional_images_row" style="' . (!$show_detailed_fields || !$show_additional_section ? 'display: none;' : '') . '">';
    echo '<th><label for="additional_section_images">Additional Section Images</label></th>';
    echo '<td>';
    echo '<div id="additional_images_container">';
    
    // Display current additional images
    if ($additional_images && is_array($additional_images)) {
        echo '<div class="additional-images" style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">';
        foreach ($additional_images as $index => $image_id) {
            $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
            if ($image_url) {
                echo '<div class="additional-image-item" style="position: relative; width: 100px; height: 100px;">';
                echo '<img src="' . esc_url($image_url) . '" style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #ddd;" />';
                echo '<button type="button" class="remove-additional-image" style="position: absolute; top: -5px; right: -5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1;">×</button>';
                echo '<input type="hidden" name="additional_section_images[]" value="' . esc_attr($image_id) . '">';
                echo '</div>';
            }
        }
        echo '</div>';
    } else {
        echo '<div class="additional-images" style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;"></div>';
    }
    
    echo '<button type="button" id="add_additional_images" class="button button-primary">Select 2 Images for Additional Section</button>';
    echo '<button type="button" id="clear_additional_images" class="button" style="margin-left: 10px;">Clear Images</button>';
    echo '<p class="description">Select exactly 2 images for the additional content section.</p>';
    echo '</div>';
    echo '</td>';
    echo '</tr>';
    
    // Additional Quote Section
    echo '<tr id="additional_quote_row" style="' . (!$show_detailed_fields || !$show_additional_section ? 'display: none;' : '') . '">';
    echo '<th><label>Additional Quote Section</label></th>';
    echo '<td>';
    echo '<input type="text" id="additional_quote_title" name="additional_quote_title" value="' . esc_attr($additional_quote_title) . '" class="widefat" placeholder="e.g., TIDES & TIME" style="margin-bottom: 10px;" />';
    echo '<label for="additional_quote_title" style="display: block; margin-bottom: 10px; font-size: 12px; color: #666;">Additional Quote Title</label>';
    echo '<textarea id="additional_quote_text" name="additional_quote_text" class="widefat" rows="3" placeholder="e.g., Islands remind us that stillness can be the greatest adventure.">' . esc_textarea($additional_quote_text) . '</textarea>';
    echo '<label for="additional_quote_text" style="display: block; margin-top: 5px; font-size: 12px; color: #666;">Additional Quote Text</label>';
    echo '<p class="description">Quote for the additional content section.</p>';
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
    echo '<p class="description">Content for the additional section. If left empty, will continue from main content.</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th>Display Options</th>';
    echo '<td>';
    echo '<label><input type="checkbox" name="featured_in_carousel" value="1"' . checked($featured_in_carousel, 1, false) . ' /> Display in Homepage Carousel</label><br>';
    echo '<label><input type="checkbox" name="featured_in_archive" value="1"' . checked($featured_in_archive, 1, false) . ' /> Display in Experiences Archive Page</label>';
    echo '<p class="description">Choose where this experience should appear.</p>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    
    // Add JavaScript for gallery management
    ?>
    <script>
    function toggleCategoryFields() {
        var experienceType = document.getElementById("experience_type").value;
        var categoryTemplateRow = document.getElementById("category_template_row");
        
        if (experienceType === "category") {
            categoryTemplateRow.style.display = "table-row";
            toggleDetailedFields(); // Check if detailed fields should be shown
        } else {
            categoryTemplateRow.style.display = "none";
            hideDetailedFields();
        }
    }
    
    function toggleDetailedFields() {
        var experienceType = document.getElementById("experience_type").value;
        var categoryTemplate = document.getElementById("category_template").value;
        var showFields = (experienceType === "category" && categoryTemplate === "detailed");
        
        var detailedRows = [
            "detailed_subtitle_row",
            "quote_section_row", 
            "nature_section_row",
            "region_section_row",
            "hero_gallery_row",
            "additional_section_toggle_row"
        ];
        
        detailedRows.forEach(function(rowId) {
            var row = document.getElementById(rowId);
            if (row) {
                row.style.display = showFields ? "table-row" : "none";
            }
        });
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
        ];
        
        detailedRows.forEach(function(rowId) {
            var row = document.getElementById(rowId);
            if (row) {
                row.style.display = "none";
            }
        });
    }
    
    function toggleAdditionalSection() {
        var showAdditional = document.getElementById("show_additional_section").checked;
        var additionalRows = [
            "additional_images_row",
            "additional_quote_row",
            "additional_content_row"
        ];
        
        additionalRows.forEach(function(rowId) {
            var row = document.getElementById(rowId);
            if (row) {
                row.style.display = showAdditional ? "table-row" : "none";
            }
        });
    }
    
    jQuery(document).ready(function($) {
        var mediaUploader;
        
        $('#add_gallery_images').on('click', function(e) {
            e.preventDefault();
            
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            mediaUploader = wp.media({
                title: 'Select Hero Banner Images (Up to 4)',
                button: {
                    text: 'Use Selected Images'
                },
                multiple: true,
                library: {
                    type: 'image'
                }
            });
            
            mediaUploader.on('select', function() {
                var attachments = mediaUploader.state().get('selection').toJSON();
                var maxImages = 4;
                
                // Clear existing images
                $('.hero-gallery-images').empty();
                
                // Add selected images (up to 4)
                attachments.slice(0, maxImages).forEach(function(attachment, index) {
                    var imageHtml = '<div class="hero-gallery-item" style="position: relative; width: 100px; height: 100px;">';
                    imageHtml += '<img src="' + attachment.sizes.thumbnail.url + '" style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #ddd;" />';
                    imageHtml += '<button type="button" class="remove-gallery-image" style="position: absolute; top: -5px; right: -5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1;">×</button>';
                    imageHtml += '<input type="hidden" name="hero_banner_gallery[]" value="' + attachment.id + '">';
                    imageHtml += '</div>';
                    
                    $('.hero-gallery-images').append(imageHtml);
                });
                
                if (attachments.length > maxImages) {
                    alert('Only the first 4 images were added. Maximum of 4 images allowed for hero banner gallery.');
                }
            });
            
            mediaUploader.open();
        });
        
        // Clear all gallery images
        $('#clear_gallery_images').on('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to clear all gallery images?')) {
                $('.hero-gallery-images').empty();
            }
        });
        
        // Remove image functionality
        $(document).on('click', '.remove-gallery-image', function() {
            $(this).closest('.hero-gallery-item').remove();
        });
        
        // Additional images uploader
        var additionalMediaUploader;
        
        $('#add_additional_images').on('click', function(e) {
            e.preventDefault();
            
            if (additionalMediaUploader) {
                additionalMediaUploader.open();
                return;
            }
            
            additionalMediaUploader = wp.media({
                title: 'Select 2 Images for Additional Section',
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
                var maxImages = 2;
                
                // Clear existing images
                $('.additional-images').empty();
                
                // Add selected images (up to 2)
                attachments.slice(0, maxImages).forEach(function(attachment, index) {
                    var imageHtml = '<div class="additional-image-item" style="position: relative; width: 100px; height: 100px;">';
                    imageHtml += '<img src="' + attachment.sizes.thumbnail.url + '" style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #ddd;" />';
                    imageHtml += '<button type="button" class="remove-additional-image" style="position: absolute; top: -5px; right: -5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1;">×</button>';
                    imageHtml += '<input type="hidden" name="additional_section_images[]" value="' + attachment.id + '">';
                    imageHtml += '</div>';
                    
                    $('.additional-images').append(imageHtml);
                });
                
                if (attachments.length > maxImages) {
                    alert('Only the first 2 images were added. Maximum of 2 images allowed for additional section.');
                }
            });
            
            additionalMediaUploader.open();
        });
        
        // Clear additional images
        $('#clear_additional_images').on('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to clear all additional images?')) {
                $('.additional-images').empty();
            }
        });
        
        // Remove additional image functionality
        $(document).on('click', '.remove-additional-image', function() {
            $(this).closest('.additional-image-item').remove();
        });
        
        // Make additional images sortable
        $('.additional-images').sortable({
            items: '.additional-image-item',
            cursor: 'move',
            update: function() {
                // Update order in hidden inputs
                $(this).find('.additional-image-item').each(function(index) {
                    $(this).find('input[type="hidden"]').attr('name', 'additional_section_images[' + index + ']');
                });
            }
        });
        
        // Make gallery sortable
        $('.hero-gallery-images').sortable({
            items: '.hero-gallery-item',
            cursor: 'move',
            update: function() {
                // Update order in hidden inputs
                $(this).find('.hero-gallery-item').each(function(index) {
                    $(this).find('input[type="hidden"]').attr('name', 'hero_banner_gallery[' + index + ']');
                });
            }
        });
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

    $featured_carousel = isset($_POST['featured_in_carousel']) ? 1 : 0;
    update_post_meta($post_id, '_featured_in_carousel', $featured_carousel);
    
    $featured_archive = isset($_POST['featured_in_archive']) ? 1 : 0;
    update_post_meta($post_id, '_featured_in_archive', $featured_archive);
}
add_action('save_post', 'save_experience_details');

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
    
    if ($hook == 'post-new.php' || $hook == 'post.php') {
        if ($post_type == 'experience') {
            wp_enqueue_media();
            wp_enqueue_script('jquery-ui-sortable');
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

    $wp_customize->add_control('nirup_hero_cta_link', array(
        'label' => __('Hero Button Link', 'nirup-island'),
        'section' => 'nirup_hero_section',
        'type' => 'url',
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

    // Video URL (YouTube)
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

    $wp_customize->add_control('nirup_booking_button_link', array(
        'label' => __('Booking Button Link URL', 'nirup-island'),
        'section' => 'nirup_navigation',
        'type' => 'url',
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
function nirup_get_youtube_embed_url($url) {
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
    
    // Build embed URL with privacy-enhanced mode and parameters
    $embed_url = 'https://www.youtube-nocookie.com/embed/' . $video_id;
    
    // Add parameters for better experience
    $params = array(
        'rel' => '0',           // Don't show related videos from other channels
        'modestbranding' => '1', // Minimal YouTube branding
        'iv_load_policy' => '3', // Don't show annotations
        'enablejsapi' => '1',    // Enable JavaScript API for tracking
    );
    
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
        
        // If this is a child experience, add the parent
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
            $category_template = get_template_directory() . '/single-experience-category.php';
            if (file_exists($category_template)) {
                return $category_template;
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
    add_theme_page(
        __('Map Pins', 'nirup-island'),
        __('Map Pins', 'nirup-island'),
        'manage_options',
        'nirup-map-pins',
        'nirup_map_pins_admin_page'
    );
}
add_action('admin_menu', 'nirup_add_map_pins_menu');

/**
 * REPLACE the nirup_map_pins_admin_page function in functions.php with this
 */
/**
 * UPDATED Map Pins Admin Page with Icon Library Integration
 * REPLACE the entire nirup_map_pins_admin_page() function in your functions.php with this
 */
function nirup_map_pins_admin_page() {
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
            
            <!-- NEW: Add Pin Form with Icon Library -->
            <div class="card">
                <h2><?php _e('Add New Pin', 'nirup-island'); ?></h2>
                <form method="post" action="">
                    <?php wp_nonce_field('nirup_pins_action', 'nirup_pins_nonce'); ?>
                    <input type="hidden" name="action" value="add_pin">
                    <input type="hidden" name="pin_x" id="pin_x" value="">
                    <input type="hidden" name="pin_y" id="pin_y" value="">
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="pin_title"><?php _e('Pin Title', 'nirup-island'); ?></label>
                            </th>
                            <td>
                                <input type="text" id="pin_title" name="pin_title" class="regular-text" required>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="pin_description"><?php _e('Description', 'nirup-island'); ?></label>
                            </th>
                            <td>
                                <textarea id="pin_description" name="pin_description" rows="3" class="large-text"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="pin_link"><?php _e('Link (Optional)', 'nirup-island'); ?></label>
                            </th>
                            <td>
                                <input type="url" id="pin_link" name="pin_link" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label><?php _e('Pin Type', 'nirup-island'); ?></label>
                            </th>
                            <td>
                                <label>
                                    <input type="radio" name="pin_type" value="public" checked>
                                    <?php _e('Public Area', 'nirup-island'); ?>
                                </label><br>
                                <label>
                                    <input type="radio" name="pin_type" value="accommodation">
                                    <?php _e('Accommodation', 'nirup-island'); ?>
                                </label>
                            </td>
                        </tr>
                        
                        <!-- NEW: Icon Selection with Visual Library -->
                        <tr>
                            <th scope="row">
                                <label for="pin_icon"><?php _e('Pin Icon (Optional)', 'nirup-island'); ?></label>
                            </th>
                            <td>
                                <div class="icon-picker-library">
                                    <?php 
                                    $custom_icons = nirup_get_custom_icons();
                                    if (!empty($custom_icons)): ?>
                                        <div class="icon-selection-grid">
                                            <div class="icon-option no-icon-option active" data-icon="">
                                                <div class="icon-preview-box">
                                                    <span class="no-icon-text"><?php _e('No Icon', 'nirup-island'); ?></span>
                                                </div>
                                                <span class="icon-name"><?php _e('None', 'nirup-island'); ?></span>
                                            </div>
                                            
                                            <?php foreach ($custom_icons as $filename => $icon): ?>
                                                <div class="icon-option" data-icon="custom:<?php echo esc_attr($filename); ?>">
                                                    <div class="icon-preview-box">
                                                        <?php echo $icon['svg']; ?>
                                                    </div>
                                                    <span class="icon-name"><?php echo esc_html($icon['name']); ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        
                                        <input type="hidden" id="pin_icon" name="pin_icon" value="">
                                        
                                        <!-- Icon Preview with Pin -->
                                        <div class="selected-icon-preview" id="selected-icon-preview" style="margin-top: 15px; display: none;">
                                            <label><?php _e('Preview:', 'nirup-island'); ?></label>
                                            <div class="pin-with-icon-preview" id="pin-with-icon-preview"></div>
                                        </div>
                                        
                                    <?php else: ?>
                                        <div class="no-icons-message">
                                            <p><?php _e('No icons available yet.', 'nirup-island'); ?></p>
                                            <a href="<?php echo admin_url('themes.php?page=nirup-icon-library'); ?>" class="button">
                                                <?php _e('Upload Icons', 'nirup-island'); ?>
                                            </a>
                                        </div>
                                        <input type="hidden" id="pin_icon" name="pin_icon" value="">
                                    <?php endif; ?>
                                    
                                    <p class="description" style="margin-top: 10px;">
                                        <a href="<?php echo admin_url('themes.php?page=nirup-icon-library'); ?>" target="_blank">
                                            <?php _e('Manage your icon library', 'nirup-island'); ?> →
                                        </a>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    
                    <p class="submit">
                        <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Add Pin', 'nirup-island'); ?>" disabled>
                    </p>
                </form>
            </div>
            
            <!-- Instructions -->
            <div class="card" style="max-width: 1430px; margin-bottom: 20px;">
                <h2><?php _e('How to Add Pins', 'nirup-island'); ?></h2>
                <ol>
                    <li><strong><?php _e('Click anywhere on the map below', 'nirup-island'); ?></strong> <?php _e('to add a new pin', 'nirup-island'); ?></li>
                    <li><strong><?php _e('Drag existing pins', 'nirup-island'); ?></strong> <?php _e('to reposition them', 'nirup-island'); ?></li>
                    <li><strong><?php _e('Click on a pin', 'nirup-island'); ?></strong> <?php _e('to edit its details', 'nirup-island'); ?></li>
                </ol>
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
    </div>
    
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
            width: 35px;  
            height: 42px;
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
            color: #333;
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
    </style>
    
    <script>
        jQuery(document).ready(function($) {
            let currentEditPinId = null;
            
            // Icon selection functionality
            $('.icon-option').on('click', function() {
                $('.icon-option').removeClass('active');
                $(this).addClass('active');
                
                const iconValue = $(this).data('icon');
                $('#pin_icon').val(iconValue);
                
                // Update preview
                updateIconPreview(iconValue);
            });
            
            // Update preview when pin type changes
            $('input[name="pin_type"]').on('change', function() {
                const currentIcon = $('#pin_icon').val();
                updateIconPreview(currentIcon);
            });
            
            function updateIconPreview(iconValue) {
                const $preview = $('#selected-icon-preview');
                const $previewPin = $('#pin-with-icon-preview');
                
                if (iconValue) {
                    const pinType = $('input[name="pin_type"]:checked').val();
                    const baseColor = pinType === 'accommodation' ? '#C49A5D' : '#1E3673';
                    const selectedIconHtml = $('.icon-option.active .icon-preview-box').html();
                    
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
            
            // Make existing pins draggable
            function makePinsDraggable() {
                $('.admin-pin').draggable({
                    containment: '.map-pins-overlay',
                    stop: function(event, ui) {
                        const pinId = $(this).data('pin-id');
                        const container = $('.map-editor-image');
                        const containerWidth = container.width();
                        const containerHeight = container.height();
                        
                        const x = (ui.position.left / containerWidth) * 100;
                        const y = (ui.position.top / containerHeight) * 100;
                        
                        savePinPosition(pinId, x, y);
                    }
                });
            }
            
            // Click on map to add new pin
            $('#map-editor').on('click', function(e) {
                const rect = this.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                const pinType = $('input[name="new_pin_type"]:checked').val();
                
                addNewPin(x, y, pinType);
            });
            
            // Click on existing pin to edit
            $(document).on('click', '.admin-pin', function(e) {
                e.stopPropagation();
                const pinId = $(this).data('pin-id');
                editPin(pinId);
            });
            
            // Edit pin from table
            $('.edit-pin-btn').on('click', function() {
                const pinId = $(this).data('pin-id');
                editPin(pinId);
            });
            
            // Delete pin
            $('.delete-pin-btn').on('click', function() {
                const pinId = $(this).data('pin-id');
                if (confirm('<?php _e('Are you sure you want to delete this pin?', 'nirup-island'); ?>')) {
                    deletePin(pinId);
                }
            });
            
            // Functions
            function addNewPin(x, y, pinType) {
                const title = prompt('<?php _e('Enter pin title:', 'nirup-island'); ?>');
                if (!title) return;
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'nirup_add_pin_ajax',
                        title: title,
                        x: x,
                        y: y,
                        pin_type: pinType,
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
                const $pin = $(`.admin-pin[data-pin-id="${pinId}"]`);
                const newTitle = prompt('Edit pin title:', $pin.data('title'));
                if (newTitle && newTitle !== $pin.data('title')) {
                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'nirup_update_pin_ajax',
                            pin_id: pinId,
                            title: newTitle,
                            description: $pin.data('description'),
                            link: $pin.data('link'),
                            pin_type: $pin.data('pin-type'),
                            nonce: '<?php echo wp_create_nonce('nirup_map_nonce'); ?>'
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            }
                        }
                    });
                }
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
                const $message = $(`<div class="${type}-message">${message}</div>`);
                $('.wrap h1').after($message);
                setTimeout(() => $message.fadeOut(), 3000);
            }
            
            // Initialize
            makePinsDraggable();
            
            // Initialize with "No Icon" selected
            $('.no-icon-option').trigger('click');
        });
    </script>
    
    <?php
}

function nirup_get_map_pins() {
    return get_option('nirup_map_pins', array());
}

function nirup_add_map_pin($data) {
    $pins = nirup_get_map_pins();
    
    $new_pin = array(
        'id' => uniqid('pin_'),
        'title' => sanitize_text_field($data['pin_title']),
        'description' => sanitize_textarea_field($data['pin_description']),
        'x' => floatval($data['pin_x']),
        'y' => floatval($data['pin_y']),
        'link' => esc_url_raw($data['pin_link']),
        'pin_type' => sanitize_text_field($data['pin_type']), // Changed from 'icon_type'
        'icon' => sanitize_text_field($data['pin_icon'] ?? ''), // NEW: Icon field
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
            $pin['title'] = sanitize_text_field($data['pin_title']);
            $pin['description'] = sanitize_textarea_field($data['pin_description']);
            $pin['x'] = floatval($data['pin_x']);
            $pin['y'] = floatval($data['pin_y']);
            $pin['link'] = esc_url_raw($data['pin_link']);
            $pin['pin_type'] = sanitize_text_field($data['pin_type']); // Changed from 'icon_type'
            $pin['icon'] = sanitize_text_field($data['pin_icon'] ?? '');
            $pin['updated'] = current_time('mysql');
            break;
        }
    }
    
    update_option('nirup_map_pins', $pins);
    add_settings_error('nirup_pins', 'pin_updated', __('Pin updated successfully!', 'nirup-island'), 'updated');
}

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


/**
 * ADD THESE NEW FUNCTIONS to your functions.php (in addition to the previous ones)
 * These handle the AJAX for drag & drop functionality
 */

// ===========================
// AJAX HANDLERS FOR DRAG & DROP
// ===========================

// AJAX: Add new pin
function nirup_add_pin_ajax() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'nirup_map_nonce')) {
        wp_die('Security check failed');
    }
    
    // Check permissions
    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }
    
    $pins = nirup_get_map_pins();
    
    $new_pin = array(
        'id' => uniqid('pin_'),
        'title' => sanitize_text_field($_POST['title']),
        'description' => '', // Will be added in edit
        'x' => floatval($_POST['x']),
        'y' => floatval($_POST['y']),
        'link' => '',
        'pin_type' => sanitize_text_field($_POST['pin_type']), // 'public' or 'accommodation'
        'created' => current_time('mysql')
    );
    
    $pins[] = $new_pin;
    update_option('nirup_map_pins', $pins);
    
    wp_send_json_success($new_pin);
}
add_action('wp_ajax_nirup_add_pin_ajax', 'nirup_add_pin_ajax');

// AJAX: Update pin position
function nirup_update_pin_position() {
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
    
    $pins = array_filter($pins, function($pin) use ($pin_id) {
        return $pin['id'] !== $pin_id;
    });
    
    update_option('nirup_map_pins', array_values($pins));
    wp_send_json_success('Pin deleted');
}
add_action('wp_ajax_nirup_delete_pin_ajax', 'nirup_delete_pin_ajax');

function nirup_enqueue_admin_assets() {
    // Only on our admin page
    $screen = get_current_screen();
    if ($screen && $screen->id === 'appearance_page_nirup-map-pins') {
        wp_enqueue_script('jquery-ui-draggable');
    }
}
add_action('admin_enqueue_scripts', 'nirup_enqueue_admin_assets');

/**
 * CUSTOM ICON LIBRARY SYSTEM
 * Replace the icon-related functions in your functions.php with these
 */

// ===========================
// UPDATED ICON SYSTEM - UPLOAD-ONLY LIBRARY
// ===========================

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

// Updated pin icon function - only handles custom icons
function nirup_get_pin_icon_svg($pin_type, $custom_icon = '') {
    if ($pin_type === 'accommodation') {
        $base_svg = '<g filter="url(#filter0_d_433_1358)">
                <path d="M47 15C32.0966 15.0197 20.0197 27.0965 20 41.9999C20 61.3835 45.155 85.6609 46.2237 86.6846C46.6555 87.1051 47.3445 87.1051 47.7763 86.6846C48.845 85.6609 74 61.3835 74 41.9999C73.9803 27.0965 61.9034 15.0197 47 15Z" fill="#C49A5D"/>
                <path d="M47 15.75C61.263 15.7694 72.8627 27.147 73.2402 41.3232L73.25 42.001C73.2498 46.6932 71.7246 51.7302 69.375 56.6943C67.0282 61.6527 63.8806 66.4934 60.6875 70.7793C54.3027 79.3491 47.7822 85.6403 47.2578 86.1426L47.2529 86.1475C47.1124 86.2842 46.8876 86.2842 46.7471 86.1475L46.7422 86.1426C46.2178 85.6403 39.6973 79.3491 33:3125 70.7793C30.1194 66.4934 26.9718 61.6527 24.625 56.6943C22.2754 51.7302 20.7502 46.6932 20.75 42.001C20.7691 27.5114 32.5105 15.7697 47 15.75Z" stroke="url(#paint0_linear_433_1358)" stroke-width="1.5"/>
            </g>';
        $defs = '<defs>
                <filter id="filter0_d_433_1358" x="0" y="0" width="94" height="112" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="5"/>
                    <feGaussianBlur stdDeviation="10"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.18 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_433_1358"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_433_1358" result="shape"/>
                </filter>
                <linearGradient id="paint0_linear_433_1358" x1="47" y1="15" x2="47" y2="87" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#D8AE72"/>
                    <stop offset="1" stop-color="#A48456"/>
                </linearGradient>
            </defs>';
    } else {
        $base_svg = '<g filter="url(#filter0_d_433_1373)">
                <path d="M47 15C32.0966 15.0197 20.0197 27.0965 20 41.9999C20 61.3835 45.155 85.6609 46.2237 86.6847C46.6555 87.1051 47.3445 87.1051 47.7763 86.6847C48.845 85.6609 74 61.3835 74 41.9999C73.9803 27.0965 61.9034 15.0197 47 15Z" fill="#1E3673"/>
                <path d="M47 15.75C61.263 15.7694 72.8627 27.147 73.2402 41.3232L73.25 42.001C73.2498 46.6932 71.7246 51.7302 69.375 56.6943C67.0282 61.6527 63.8806 66.4934 60.6875 70.7793C54.3027 79:3491 47.7822 85.6403 47.2578 86.1426L47.2529 86.1475C47.1124 86.2842 46.8876 86.2842 46.7471 86.1475L46.7422 86.1426C46.2178 85.6403 39.6973 79:3491 33:3125 70.7793C30.1194 66.4934 26.9718 61.6527 24.625 56.6943C22.2754 51.7302 20.7502 46.6932 20.75 42.001C20.7691 27.5114 32.5105 15.7697 47 15.75Z" stroke="url(#paint0_linear_433_1373)" stroke-width="1.5"/>
            </g>';
        $defs = '<defs>
                <filter id="filter0_d_433_1373" x="0" y="0" width="94" height="112" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="5"/>
                    <feGaussianBlur stdDeviation="10"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.18 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_433_1373"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_anta_1373" result="shape"/>
                </filter>
                <linearGradient id="paint0_linear_433_1373" x1="47" y1="15" x2="47" y2="87" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#6E9CE0"/>
                    <stop offset="1" stop-color="#1E3673"/>
                </linearGradient>
            </defs>';
    }
    
    // Add custom icon overlay if provided
    $icon_overlay = '';
    if (!empty($custom_icon) && strpos($custom_icon, 'custom:') === 0) {
        $filename = str_replace('custom:', '', $custom_icon);
        $custom_icons = nirup_get_custom_icons();
        if (isset($custom_icons[$filename])) {
            $icon_svg = $custom_icons[$filename]['svg'];
            $icon_overlay = '<g transform="translate(47, 35)">
                <circle cx="0" cy="0" r="12" fill="white" opacity="0.9"/>
                <g transform="translate(-8, -8) scale(0.7)" fill="' . ($pin_type === 'accommodation' ? '#C49A5D' : '#1E3673') . '">
                    ' . $icon_svg . '
                </g>
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

// Add icon library management to admin page
function nirup_add_icon_library_menu() {
    add_theme_page(
        __('Icon Library', 'nirup-island'),
        __('Icon Library', 'nirup-island'),
        'manage_options',
        'nirup-icon-library',
        'nirup_icon_library_admin_page'
    );
}
add_action('admin_menu', 'nirup_add_icon_library_menu');

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

    $wp_customize->add_control('nirup_getting_here_button_url', array(
        'label' => __('Button Link URL', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'url',
        'description' => __('Enter the full URL where the button should link (e.g., https://yoursite.com/getting-here)', 'nirup-island'),
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
    // Only load on pages where the section is displayed
    if (nirup_should_display_getting_here_section()) {
        
        $google_maps_api_key = get_theme_mod('nirup_google_maps_api_key', '');
        
        if ($google_maps_api_key) {
            // First enqueue our script that defines the callback
            wp_enqueue_script(
                'nirup-getting-here-js',
                get_template_directory_uri() . '/assets/js/getting-here.js',
                array('jquery'),
                '1.0.1', // Updated version
                false // Load in head to ensure callback is available
            );
            
            // Then enqueue Google Maps API with callback
            wp_enqueue_script(
                'google-maps-api',
                'https://maps.googleapis.com/maps/api/js?key=' . esc_attr($google_maps_api_key) . '&libraries=geometry&callback=initNirupMap&loading=async',
                array('nirup-getting-here-js'), // Depend on our script
                null,
                false // Load in head
            );
        } else {
            // Load our script even without API key for fallback functionality
            wp_enqueue_script(
                'nirup-getting-here-js',
                get_template_directory_uri() . '/assets/js/getting-here.js',
                array('jquery'),
                '1.0.1',
                true
            );
        }

        // Localize script for any dynamic content
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

    // LinkedIn URL
    $wp_customize->add_setting('nirup_social_linkedin', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_social_linkedin', array(
        'label' => __('LinkedIn URL', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'url',
        'description' => __('Enter your LinkedIn profile URL. Leave empty to hide the icon.', 'nirup-island'),
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
}
add_action('customize_register', 'nirup_footer_customizer');

function nirup_handle_newsletter_subscription() {
    // Check nonce for security
    if (!wp_verify_nonce($_POST['nonce'], 'newsletter_nonce')) {
        wp_die('Security check failed');
    }

    $email = sanitize_email($_POST['email']);
    
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'));
        return;
    }

    // For now, just store in WordPress options or add to a custom table
    // Later this can be connected to your newsletter service (Mailchimp, etc.)
    
    // Placeholder - save to options table for now
    $subscribers = get_option('nirup_newsletter_subscribers', array());
    
    if (!in_array($email, $subscribers)) {
        $subscribers[] = $email;
        update_option('nirup_newsletter_subscribers', $subscribers);
        wp_send_json_success(array('message' => 'Thank you for subscribing!'));
    } else {
        wp_send_json_error(array('message' => 'You are already subscribed.'));
    }
}
add_action('wp_ajax_nirup_newsletter_subscribe', 'nirup_handle_newsletter_subscription');
add_action('wp_ajax_nopriv_nirup_newsletter_subscribe', 'nirup_handle_newsletter_subscription');

?>