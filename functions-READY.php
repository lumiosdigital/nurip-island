<?php
/**
 * Nirup Island Theme Functions
 *
 * OPTIMIZED & MODULAR VERSION
 * Functions have been organized into logical modules
 *
 * @package Nirup_Island
 * @version 2.0.0-modular
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ==================================================================================
 * PHASE 1 OPTIMIZATIONS (COMPLETE)
 * ==================================================================================
 */

// Theme setup, widgets, plugin compatibility
require_once get_template_directory() . '/inc/theme-setup.php';

// Custom post type registrations (7 post types)
require_once get_template_directory() . '/inc/post-types.php';

// Helper and utility functions
require_once get_template_directory() . '/inc/helper-functions.php';

// Asset loading - CSS and JS (debug code removed, optimized)
require_once get_template_directory() . '/inc/enqueue-scripts.php';

// Existing customizer modules
require_once get_template_directory() . '/inc/customizer-map.php';
require_once get_template_directory() . '/inc/customizer-experiences.php';

/**
 * ==================================================================================
 * REMAINING FUNCTIONS
 * ==================================================================================
 * Meta boxes, AJAX handlers, customizers, admin functions
 * These work perfectly and can be modularized in future phases
 */

require_once get_template_directory() . '/inc/remaining-functions.php';
