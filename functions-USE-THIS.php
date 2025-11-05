<?php
/**
 * Nirup Island Theme Functions - Modular Version
 *
 * This file uses the optimized modular structure.
 * TO USE: Rename your current functions.php to functions-OLD.php
 *         Then rename this file to functions.php
 *
 * @package Nirup_Island
 * @version 2.0.0-modular
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ============================================================================
 * LOAD OPTIMIZED MODULAR COMPONENTS
 * ============================================================================
 */

// Core theme setup and hooks (extracted from original)
require_once get_template_directory() . '/inc/theme-setup.php';

// Custom post type registrations (extracted from original)
require_once get_template_directory() . '/inc/post-types.php';

// Helper and utility functions (extracted from original)
require_once get_template_directory() . '/inc/helper-functions.php';

// Asset loading - scripts and styles (extracted from original, debug code removed)
require_once get_template_directory() . '/inc/enqueue-scripts.php';

// Existing modular customizer files
require_once get_template_directory() . '/inc/customizer-map.php';
require_once get_template_directory() . '/inc/customizer-experiences.php';

/**
 * ============================================================================
 * REMAINING FUNCTIONS FROM ORIGINAL functions.php
 * ============================================================================
 *
 * Below are all the functions that haven't been extracted to modules yet.
 * These will be modularized in future optimization phases.
 */

// NOTE: You need to copy the remaining functions from your original functions.php here
// EXCLUDING the functions that are now in the modular files above:
//
// DO NOT COPY these (already in modular files):
// - nirup_theme_setup()
// - nirup_register_sidebars()
// - nirup_enqueue_assets()
// - register_experiences_post_type()
// - register_events_offers_post_type()
// - nirup_register_restaurant_post_type()
// - nirup_register_ferry_schedule_post_type()
// - nirup_register_private_charters()
// - nirup_register_villa_cpt()
// - nirup_register_westin_room_cpt()
// - nirup_custom_image_sizes()
// - nirup_rewrite_flush()
// - nirup_translatepress_support()
// - nirup_booking_system_hooks()
// - nirup_google_site_kit_support()
// - nirup_microsoft_clarity()
// - nirup_brevo_support()
// - wpbs_add_custom_currency()
// - wpbs_add_custom_currency_symbol()
// - get_dining_experiences()
// - get_featured_experiences()
// - get_all_experiences()
// - get_child_experiences()
// - get_featured_events_offers()
// - get_all_events_offers()
// - nirup_get_youtube_embed_url()
// - nirup_sanitize_youtube_url()
// - nirup_get_template_part()
//
// COPY EVERYTHING ELSE from your original functions.php starting from line 356

/* ========== PASTE REMAINING FUNCTIONS BELOW THIS LINE ========== */

// Experience Meta Boxes
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

// ... (Continue pasting the rest of the functions from your original file)
// ... (Lines 356 onwards from original functions.php)
// ... (EXCLUDING the functions listed above that are now in modular files)

/* ========== END OF REMAINING FUNCTIONS ========== */
