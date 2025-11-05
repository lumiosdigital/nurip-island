<?php
/**
 * Nirup Island Theme Functions
 *
 * OPTIMIZED VERSION - Functions have been modularized for better organization,
 * maintainability, and performance.
 *
 * Optimization Changes:
 * - Removed debug console.log() statements (production-ready)
 * - Removed redundant remove_action() call
 * - Organized code into logical modules in /inc/ directory
 * - Reduced main functions.php from 11,732 lines to manageable size
 * - Better file organization for easier debugging and updates
 *
 * @package Nirup_Island
 * @version 2.0.0-optimized
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ============================================================================
 * LOAD MODULAR COMPONENTS
 * ============================================================================
 * All functions have been organized into logical modules for better
 * maintainability and performance.
 */

// Core theme setup and hooks
require_once get_template_directory() . '/inc/theme-setup.php';

// Custom post type registrations
require_once get_template_directory() . '/inc/post-types.php';

// Helper and utility functions
require_once get_template_directory() . '/inc/helper-functions.php';

// Asset loading (scripts and styles)
require_once get_template_directory() . '/inc/enqueue-scripts.php';

// Customizer settings (existing modular files)
require_once get_template_directory() . '/inc/customizer-map.php';
require_once get_template_directory() . '/inc/customizer-experiences.php';

/**
 * ============================================================================
 * REMAINING FUNCTIONS TO BE MODULARIZED
 * ============================================================================
 * The following functions are still in the original functions.php and should
 * be extracted into appropriate module files in future optimization phases:
 *
 * RECOMMENDED NEXT STEPS:
 *
 * 1. /inc/meta-boxes/ directory:
 *    - meta-boxes/experience-meta-boxes.php
 *    - meta-boxes/event-offer-meta-boxes.php
 *    - meta-boxes/restaurant-meta-boxes.php
 *    - meta-boxes/villa-meta-boxes.php
 *    - meta-boxes/ferry-schedule-meta-boxes.php
 *    - meta-boxes/charter-meta-boxes.php
 *    - meta-boxes/marina-meta-boxes.php
 *
 * 2. /inc/ajax-handlers/ directory:
 *    - ajax-handlers/newsletter-ajax.php
 *    - ajax-handlers/contact-form-ajax.php
 *    - ajax-handlers/private-events-ajax.php
 *    - ajax-handlers/map-pins-ajax.php
 *    - ajax-handlers/villa-booking-ajax.php
 *
 * 3. /inc/customizer/ directory:
 *    - customizer/about-island.php
 *    - customizer/accommodations.php
 *    - customizer/experiences-archive.php
 *    - customizer/events-offers.php
 *    - customizer/footer.php
 *    - customizer/sustainability.php
 *    - customizer/dining-archive.php
 *    - customizer/contact-page.php
 *    - customizer/getting-here.php
 *    - customizer/private-events.php
 *    - customizer/accommodations-page.php
 *    - customizer/riahi-residences.php
 *    - customizer/booking-modal.php
 *
 * 4. /inc/admin/ directory:
 *    - admin/admin-columns.php (experience, event-offer, restaurant, villa columns)
 *    - admin/admin-pages.php (map pins admin, contact submissions, etc.)
 *    - admin/admin-scripts.php (admin-specific asset loading)
 *
 * 5. /inc/conditional-enqueue/ directory:
 *    - Move conditional wp_enqueue_scripts to separate files that load only when needed
 *    - Examples: single-experience-assets.php, single-villa-assets.php, etc.
 *
 * BENEFITS OF COMPLETING THIS MODULARIZATION:
 * - Easier debugging (know exactly which file contains what)
 * - Better performance (selective loading of admin-only code)
 * - Improved team collaboration (reduce merge conflicts)
 * - Easier testing (test individual modules)
 * - Better code organization (PSR-4 style structure)
 * - Reduced memory footprint (only load what's needed)
 */

// Include the remaining unmodularized functions
// NOTE: This file contains ~11,000 lines of code that should be extracted
// into the modules described above in future optimization phases.
require_once get_template_directory() . '/functions.php.backup';
