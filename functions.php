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
        'mobile' => __('Mobile Menu', 'nirup-island'),
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
 * Enqueue Scripts and Styles
 * Moved to inc/enqueue-assets.php for better organization
 */
require_once get_template_directory() . '/inc/enqueue-assets.php';

/**
 * AJAX Handlers
 * Moved to inc/ajax-handlers.php for better organization
 */
require_once get_template_directory() . '/inc/ajax-handlers.php';

/**
 * Custom Post Types
 * Moved to inc/post-types.php for better organization
 */
require_once get_template_directory() . '/inc/post-types.php';

/**
 * Theme Customizer Settings
 * Moved to inc/customizer.php for better organization
 */
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Meta Boxes
 * Moved to inc/meta-boxes.php for better organization
 */
require_once get_template_directory() . '/inc/meta-boxes.php';

/**
 * Template Functions & Helpers
 * Moved to inc/template-functions.php for better organization
 */
require_once get_template_directory() . '/inc/template-functions.php';
