<?php
/**
 * Template Helper Functions
 *
 * All template helpers, query functions, admin customizations,
 * third-party integrations, and utility functions for the Nirup Island theme.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}


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

/**
 * Add About Island Customizer Options
 */

/**
 * Add Accommodations Customizer Options
 */

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





// AJAX handler to get image URL



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


// AJAX: Add new pin

// AJAX handler for pin preview

// AJAX: Update pin position


// AJAX: Update pin details

// AJAX: Delete pin

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


/**
 * Customizer Live Preview for Services Section
 */

/**
 * Sanitize checkbox function (if not already exists)
 */

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

function nirup_flush_rewrite_rules_on_activation() {
    register_events_offers_post_type();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'nirup_flush_rewrite_rules_on_activation');


/**
 * Experiences Carousel Customizer Options
 */







/**
 * Customizer Live Preview for Sustainability Page
 */


// Add Dining Archive Customizer Options

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


function nirup_enqueue_booking_modal_assets() {
    
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

/**
 * Add Contact Form Settings to Customizer
 * Separate section for clarity
 */

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


function nirup_contact_activation() {
    nirup_create_contact_submissions_table();
}
register_activation_hook(__FILE__, 'nirup_contact_activation');

add_action('after_switch_theme', 'nirup_create_contact_submissions_table');


function nirup_contact_admin_assets($hook) {
    if ($hook !== 'toplevel_page_contact-submissions') {
        return;
    }

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



function nirup_getting_here_page_assets() {
    // Load on Getting Here page OR front page (homepage)
    if (is_page_template('page-getting-here.php') || is_front_page()) {
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


// Include Ferry Map Customizer Settings
require_once get_template_directory() . '/inc/customizer-map.php';

// Include Experiences Customizer Settings
require_once get_template_directory() . '/inc/customizer-experiences.php';

require_once get_template_directory() . '/inc/wpbs-search-helpers.php';


function nirup_enqueue_private_events_assets() {
    if (is_page_template('page-private-events.php')) {
        $dir_uri  = get_stylesheet_directory_uri();
        $dir_path = get_stylesheet_directory();

        // JS with automatic cache-busting
        $js_path = $dir_path . '/assets/js/private-events.js';
        wp_enqueue_script(
            'nirup-private-events',
            $dir_uri . '/assets/js/private-events.js',
            array('jquery'),
            file_exists($js_path) ? filemtime($js_path) : '1.0.0',
            true
        );

        // Get reCAPTCHA site key (same as contact/newsletter)
        $site_key = nirup_get_secret('RECAPTCHA_SITE_KEY', 'nirup_recaptcha_site_key', '');

        wp_localize_script('nirup-private-events', 'nirup_private_events_ajax', array(
            'ajax_url'  => admin_url('admin-ajax.php'),
            'nonce'     => wp_create_nonce('private_events_form_nonce'),
            'recaptcha' => array(
                'site_key' => $site_key,
                'action'   => 'private_event_submit',
            ),
        ));
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_private_events_assets');

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




function nirup_enqueue_accommodations_page_assets() {
    // Only on accommodations page template
    if (is_page_template('page-accommodations.php')) {
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


/**
 * Add Villa Features Meta Box

/**
 * Riahi Residences Page Customizer Options
 * Add this to functions.php
 */


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

/**
 * Add Media Coverage Page Customizer Options
 * Add this code to your functions.php file
 */

// =======================
// Press Kit Page Customizer Settings
// =======================
// Add this to your functions.php file



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

// Hide WooCommerce's default "Have a coupon?" block at the top of the checkout
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );


/**
 * Enqueue Event Offer Booking Assets (conditionally)
 */
function nirup_enqueue_event_offer_booking_assets() {
    if (is_singular('event_offer')) {
        $post_id = get_the_ID();
        $booking_link = get_post_meta($post_id, '_event_offer_booking_link', true);
        $calendar_id = get_post_meta($post_id, '_event_offer_booking_calendar_id', true);
        $form_id = get_post_meta($post_id, '_event_offer_booking_form_id', true);
        
        // Only load booking modal assets if no booking link but has calendar/form
        if (empty($booking_link) && !empty($calendar_id) && !empty($form_id)) {
            // Event offer booking JS
            wp_enqueue_script(
                'nirup-event-offer-booking',
                get_template_directory_uri() . '/assets/js/event-offer-booking.js',
                array('jquery'),
                filemtime(get_template_directory() . '/assets/js/event-offer-booking.js'),
                true
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_event_offer_booking_assets');
// ========== 1. ENQUEUE ASSETS (BERTHING) ==========

function nirup_enqueue_berthing_assets() {
    $dir_uri  = get_stylesheet_directory_uri();
    $dir_path = get_stylesheet_directory();

    // JS with automatic cache-busting
    $js_path = $dir_path . '/assets/js/berthing.js';
    if (file_exists($js_path)) {
        wp_enqueue_script(
            'nirup-berthing',
            $dir_uri . '/assets/js/berthing.js',
            array('jquery'),
            filemtime($js_path),
            true
        );

        // Get reCAPTCHA site key
        $site_key = nirup_get_secret('RECAPTCHA_SITE_KEY', 'nirup_recaptcha_site_key', '');

        wp_localize_script('nirup-berthing', 'nirup_berthing_ajax', array(
            'ajax_url'  => admin_url('admin-ajax.php'),
            'nonce'     => wp_create_nonce('berthing_form_nonce'),
            'recaptcha' => array(
                'site_key' => $site_key,
                'action'   => 'berthing_submit',
            ),
        ));

        // Ensure reCAPTCHA v3 script is loaded if configured
        if (!empty($site_key) && !defined('NIRUP_DISABLE_CAPTCHA')) {
            wp_enqueue_script(
                'recaptcha-v3-berthing',
                'https://www.google.com/recaptcha/api.js?render=' . rawurlencode($site_key),
                array(),
                null,
                true
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_berthing_assets');

// ========== CUSTOMIZER SETTINGS ==========



// ========== 6. ADMIN MENU (for viewing submissions) ==========

function nirup_berthing_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=page',
        'Berthing Submissions',
        'Berthing Submissions',
        'manage_options',
        'berthing-submissions',
        'nirup_berthing_submissions_page'
    );
}
add_action('admin_menu', 'nirup_berthing_admin_menu');

function nirup_berthing_submissions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'berthing_submissions';
    
    // Handle status updates
    if (isset($_POST['update_status']) && isset($_POST['submission_id'])) {
        $submission_id = intval($_POST['submission_id']);
        $new_status    = sanitize_text_field($_POST['status']);
        
        $wpdb->update(
            $table_name,
            array('status' => $new_status),
            array('id' => $submission_id),
            array('%s'),
            array('%d')
        );
        
        echo '<div class="notice notice-success"><p>Status updated successfully!</p></div>';
    }
    
    $submissions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submission_date DESC LIMIT 50");
    
    ?>
    <div class="wrap">
        <h1>Berthing Form Submissions</h1>
        
        <?php if (empty($submissions)): ?>
            <p>No submissions yet.</p>
        <?php else: ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Vessel Name</th>
                        <th>Owner</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Arrival Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $submission): ?>
                        <tr>
                            <td><?php echo esc_html($submission->id); ?></td>
                            <td><?php echo esc_html(date('Y-m-d H:i', strtotime($submission->submission_date))); ?></td>
                            <td><strong><?php echo esc_html($submission->vessel_name); ?></strong></td>
                            <td><?php echo esc_html($submission->yacht_owner_name); ?></td>
                            <td><?php echo esc_html($submission->contact_name); ?></td>
                            <td><?php echo esc_html($submission->email); ?></td>
                            <td><?php echo esc_html($submission->arrival_date); ?></td>
                            <td>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="submission_id" value="<?php echo esc_attr($submission->id); ?>">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="new" <?php selected($submission->status, 'new'); ?>>New</option>
                                        <option value="reviewed" <?php selected($submission->status, 'reviewed'); ?>>Reviewed</option>
                                        <option value="confirmed" <?php selected($submission->status, 'confirmed'); ?>>Confirmed</option>
                                        <option value="completed" <?php selected($submission->status, 'completed'); ?>>Completed</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                            <td>
                                <button type="button" class="button" onclick="viewDetails(<?php echo esc_js($submission->id); ?>)">View Details</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
    <style>
        .wrap table { margin-top: 20px; }
        .wrap td, .wrap th { padding: 12px; }
    </style>
    
    <script>
    function viewDetails(id) {
        alert('View details for submission #' + id + '\\n\\nYou can implement a detailed view here.');
    }
    </script>
    <?php
}
function nirup_enqueue_shared_gallery_modal() {
    if (is_singular('restaurant') || is_page_template('page-marina.php')) {
        wp_enqueue_script(
            'nirup-shared-gallery-modal',
            get_template_directory_uri() . '/assets/js/shared-gallery-modal.js',
            array(),
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'nirup_enqueue_shared_gallery_modal');
?>