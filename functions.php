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
    
    // Add accommodations CSS
    wp_enqueue_style('nirup-accommodations', get_template_directory_uri() . '/assets/css/accommodations.css', array('nirup-main'), '1.0.2');
    
    // NEW: Add experiences carousel CSS
    wp_enqueue_style('nirup-experiences-carousel', get_template_directory_uri() . '/assets/css/experiences-carousel.css', array('nirup-main'), '1.0.2');

    // NEW: Add experiences archive CSS
    wp_enqueue_style('nirup-experiences-archive', get_template_directory_uri() . '/assets/css/archive-experiences.css', array('nirup-main'), '1.0.2');
    
    wp_enqueue_style('nirup-breadcrumbs', get_template_directory_uri() . '/assets/css/breadcrumbs.css', array(), '1.0.2');
    
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
    $featured_in_carousel = get_post_meta($post->ID, '_featured_in_carousel', true);
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th><label for="experience_short_description">Short Description (for carousel)</label></th>';
    echo '<td><input type="text" id="experience_short_description" name="experience_short_description" value="' . esc_attr($short_description) . '" class="widefat" placeholder="e.g., Banana boat, flying donut, kayak, paddle boat" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="experience_type">Experience Type</label></th>';
    echo '<td>';
    echo '<select id="experience_type" name="experience_type">';
    echo '<option value="single"' . selected($experience_type, 'single', false) . '>Single Experience</option>';
    echo '<option value="category"' . selected($experience_type, 'category', false) . '>Category (has sub-experiences)</option>';
    echo '</select>';
    echo '<p class="description">Choose "Category" if this experience contains multiple sub-experiences (like Excursions).</p>';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="featured_in_carousel">Featured in Homepage Carousel</label></th>';
    echo '<td>';
    echo '<input type="checkbox" id="featured_in_carousel" name="featured_in_carousel" value="1"' . checked($featured_in_carousel, 1, false) . ' />';
    echo '<label for="featured_in_carousel"> Display this experience in the homepage carousel</label>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
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

    $featured = isset($_POST['featured_in_carousel']) ? 1 : 0;
    update_post_meta($post_id, '_featured_in_carousel', $featured);
}
add_action('save_post', 'save_experience_details');

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
        case 'short_desc':
            $desc = get_post_meta($post_id, '_experience_short_description', true);
            echo $desc ? '<em>' . esc_html(wp_trim_words($desc, 8)) . '</em>' : '<span style="color: #888;">—</span>';
            break;
        case 'parent':
            $parent_id = wp_get_post_parent_id($post_id);
            if ($parent_id) {
                echo '<a href="' . get_edit_post_link($parent_id) . '">' . get_the_title($parent_id) . '</a>';
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
 * Add About Island Customizer Options
 */
function nirup_about_island_customizer($wp_customize) {
    // About Island Section
    $wp_customize->add_section('nirup_about_island', array(
        'title' => __('About Island Section', 'nirup-island'),
        'priority' => 35,
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
        'priority' => 36,
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
    register_post_type('experience', array(
        'public' => true,
        'label' => 'Experiences',
        'has_archive' => true,
        'menu_icon' => 'dashicons-palmtree',
        'supports' => array('title', 'editor', 'thumbnail')
    ));
}
add_action('init', 'nirup_register_experiences');

/**
 * Generate breadcrumbs for current page
 */
function nirup_get_breadcrumbs() {
    $breadcrumbs = array();
    
    // Always start with Home
    $breadcrumbs[] = array(
        'title' => 'Home',
        'url' => home_url('/')
    );
    
    if (is_post_type_archive('experience')) {
        // Experiences archive page
        $breadcrumbs[] = array(
            'title' => 'Experiences',
            'url' => ''
        );
    } elseif (is_singular('experience')) {
        // Single experience page
        $breadcrumbs[] = array(
            'title' => 'Experiences',
            'url' => get_post_type_archive_link('experience')
        );
        $breadcrumbs[] = array(
            'title' => get_the_title(),
            'url' => ''
        );
    } elseif (is_page()) {
        // Regular pages
        $breadcrumbs[] = array(
            'title' => get_the_title(),
            'url' => ''
        );
    } elseif (is_single()) {
        // Blog posts
        $breadcrumbs[] = array(
            'title' => 'Blog',
            'url' => get_permalink(get_option('page_for_posts'))
        );
        $breadcrumbs[] = array(
            'title' => get_the_title(),
            'url' => ''
        );
    }
    
    return $breadcrumbs;
}
?>

