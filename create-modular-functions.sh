#!/bin/bash
#
# Automatic Functions.php Modularization Script
# This script creates a new functions.php that uses the modular files
#

echo "=========================================="
echo "Functions.php Modularization Script"
echo "=========================================="
echo ""

# Backup current functions.php
if [ -f "functions.php" ]; then
    BACKUP="functions-backup-$(date +%Y%m%d-%H%M%S).php"
    echo "✓ Backing up current functions.php to $BACKUP"
    cp functions.php "$BACKUP"
else
    echo "✗ Error: functions.php not found"
    exit 1
fi

# Create new functions.php with modular structure
cat > functions-modular-NEW.php << 'EOFMAIN'
<?php
/**
 * Nirup Island Theme Functions - Modular Version
 *
 * Optimized modular structure for better maintainability
 *
 * @package Nirup_Island
 * @version 2.0.0-modular
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load Optimized Modular Components
 */
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/helper-functions.php';
require_once get_template_directory() . '/inc/enqueue-scripts.php';
require_once get_template_directory() . '/inc/customizer-map.php';
require_once get_template_directory() . '/inc/customizer-experiences.php';

/**
 * Remaining Functions (to be modularized in future phases)
 */

EOFMAIN

# Extract only the functions that are NOT in modular files
# This is a simplified version - we're excluding the line ranges we know contain extracted functions

echo "✓ Creating new modular functions.php structure..."
echo "✓ Extracting remaining functions (excluding already modularized code)..."

# Add all functions EXCEPT the ones we've extracted
# Lines 356-11732 minus the specific functions we've extracted
awk '
  NR >= 356 && NR < 11733 {
    # Skip extracted post type registrations and their hooks
    if (NR >= 304 && NR <= 351) next;     # register_experiences_post_type
    if (NR >= 4645 && NR <= 4695) next;   # register_events_offers_post_type
    if (NR >= 5629 && NR <= 5676) next;   # nirup_register_restaurant_post_type
    if (NR >= 6327 && NR <= 6362) next;   # nirup_register_ferry_schedule_post_type
    if (NR >= 7959 && NR <= 7991) next;   # nirup_register_private_charters
    if (NR >= 9974 && NR <= 10029) next;  # nirup_register_villa_cpt
    if (NR >= 10035 && NR <= 10089) next; # nirup_register_westin_room_cpt

    # Skip extracted helper functions
    if (NR >= 1079 && NR <= 1096) next;   # get_dining_experiences
    if (NR >= 1181 && NR <= 1230) next;   # get_featured_experiences, get_all_experiences, get_child_experiences
    if (NR >= 2363 && NR <= 2430) next;   # nirup_get_youtube_embed_url, nirup_sanitize_youtube_url
    if (NR >= 5021 && NR <= 5060) next;   # get_featured_events_offers, get_all_events_offers
    if (NR >= 1466 && NR <= 1474) next;   # nirup_get_template_part

    # Skip extracted theme setup functions
    if (NR >= 1384 && NR <= 1397) next;   # nirup_custom_image_sizes, nirup_rewrite_flush
    if (NR >= 1404 && NR <= 1457) next;   # Plugin compatibility functions
    if (NR >= 11720 && NR <= 11732) next; # WP Booking System currency functions

    print
  }
' functions.php >> functions-modular-NEW.php

echo "✓ New modular functions.php created as: functions-modular-NEW.php"
echo ""
echo "=========================================="
echo "Next Steps:"
echo "=========================================="
echo ""
echo "1. Review the new file: functions-modular-NEW.php"
echo "2. Test it by renaming:"
echo "   mv functions.php functions-OLD.php"
echo "   mv functions-modular-NEW.php functions.php"
echo ""
echo "3. If something breaks, restore:"
echo "   mv functions.php functions-modular-NEW.php"
echo "   mv functions-OLD.php functions.php"
echo ""
echo "Backup saved to: $BACKUP"
echo "=========================================="
