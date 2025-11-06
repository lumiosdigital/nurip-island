#!/bin/bash
#
# Complete Functions.php Modularization - All Phases
# This script extracts ALL remaining functions into organized modules
#

set -e

echo "=============================================="
echo "Complete Functions.php Modularization"
echo "All Phases: 2, 3, 4, 5, 6"
echo "=============================================="
echo ""

# Create backup
BACKUP="functions-original-$(date +%Y%m%d-%H%M%S).php"
cp functions.php "$BACKUP"
echo "✓ Backed up to: $BACKUP"

# Create directory structure
mkdir -p inc/meta-boxes inc/ajax-handlers inc/customizer inc/admin inc/conditional-enqueue

echo "✓ Created module directories"
echo ""

# Extract line ranges for each meta box module
echo "Phase 2: Extracting Meta Boxes..."

# Experience Meta Boxes
sed -n '356,1077p' functions.php > inc/meta-boxes/experience-meta-boxes.php
sed -i '1i<?php\n/**\n * Experience Meta Boxes\n */\nif (!defined("ABSPATH")) exit;\n' inc/meta-boxes/experience-meta-boxes.php
echo "  ✓ inc/meta-boxes/experience-meta-boxes.php"

# Event/Offer Meta Boxes
sed -n '4700,4995p' functions.php > inc/meta-boxes/event-offer-meta-boxes.php
sed -i '1i<?php\n/**\n * Event/Offer Meta Boxes\n */\nif (!defined("ABSPATH")) exit;\n' inc/meta-boxes/event-offer-meta-boxes.php
echo "  ✓ inc/meta-boxes/event-offer-meta-boxes.php"

# Restaurant Meta Boxes
sed -n '5679,6048p' functions.php > inc/meta-boxes/restaurant-meta-boxes.php
sed -i '1i<?php\n/**\n * Restaurant Meta Boxes\n */\nif (!defined("ABSPATH")) exit;\n' inc/meta-boxes/restaurant-meta-boxes.php
echo "  ✓ inc/meta-boxes/restaurant-meta-boxes.php"

# Ferry Schedule Meta Boxes
sed -n '6365,6526p' functions.php > inc/meta-boxes/ferry-schedule-meta-boxes.php
sed -i '1i<?php\n/**\n * Ferry Schedule Meta Boxes\n */\nif (!defined("ABSPATH")) exit;\n' inc/meta-boxes/ferry-schedule-meta-boxes.php
echo "  ✓ inc/meta-boxes/ferry-schedule-meta-boxes.php"

# Marina Meta Boxes
sed -n '7633,7957p' functions.php > inc/meta-boxes/marina-meta-boxes.php
sed -i '1i<?php\n/**\n * Marina Meta Boxes\n */\nif (!defined("ABSPATH")) exit;\n' inc/meta-boxes/marina-meta-boxes.php
echo "  ✓ inc/meta-boxes/marina-meta-boxes.php"

# Charter Meta Boxes
sed -n '7993,8207p' functions.php > inc/meta-boxes/charter-meta-boxes.php
sed -i '1i<?php\n/**\n * Charter Meta Boxes\n */\nif (!defined("ABSPATH")) exit;\n' inc/meta-boxes/charter-meta-boxes.php
echo "  ✓ inc/meta-boxes/charter-meta-boxes.php"

# Villa Meta Boxes (complex - multiple)
sed -n '10095,11140p' functions.php > inc/meta-boxes/villa-meta-boxes.php
sed -i '1i<?php\n/**\n * Villa Meta Boxes\n */\nif (!defined("ABSPATH")) exit;\n' inc/meta-boxes/villa-meta-boxes.php
echo "  ✓ inc/meta-boxes/villa-meta-boxes.php"

# Booking Calendar Meta Boxes
cat > inc/meta-boxes/booking-calendar-meta-boxes.php << 'EOFBOOKING'
<?php
/**
 * Booking Calendar Meta Boxes
 * WP Booking System integration for villas, experiences, and events
 */
if (!defined('ABSPATH')) exit;

EOFBOOKING
sed -n '11157,11703p' functions.php >> inc/meta-boxes/booking-calendar-meta-boxes.php
echo "  ✓ inc/meta-boxes/booking-calendar-meta-boxes.php"

echo ""
echo "Phase 3: Extracting AJAX Handlers..."

# Newsletter AJAX
cat > inc/ajax-handlers/newsletter-ajax.php << 'EOFNEWSLETTER'
<?php
/**
 * Newsletter Subscription AJAX Handler
 */
if (!defined('ABSPATH')) exit;

EOFNEWSLETTER
sed -n '5362,5390p' functions.php >> inc/ajax-handlers/newsletter-ajax.php
echo "  ✓ inc/ajax-handlers/newsletter-ajax.php"

# Contact Form AJAX
cat > inc/ajax-handlers/contact-form-ajax.php << 'EOFCONTACT'
<?php
/**
 * Contact Form AJAX Handlers
 */
if (!defined('ABSPATH')) exit;

EOFCONTACT
sed -n '6784,7313p' functions.php >> inc/ajax-handlers/contact-form-ajax.php
echo "  ✓ inc/ajax-handlers/contact-form-ajax.php"

# Private Events AJAX
cat > inc/ajax-handlers/private-events-ajax.php << 'EOFPRIVATE'
<?php
/**
 * Private Events Form AJAX Handlers
 */
if (!defined('ABSPATH')) exit;

EOFPRIVATE
sed -n '8976,9777p' functions.php >> inc/ajax-handlers/private-events-ajax.php
echo "  ✓ inc/ajax-handlers/private-events-ajax.php"

# Map Pins AJAX
cat > inc/ajax-handlers/map-pins-ajax.php << 'EOFMAP'
<?php
/**
 * Map Pins AJAX Handlers
 */
if (!defined('ABSPATH')) exit;

EOFMAP
sed -n '3554,3898p' functions.php >> inc/ajax-handlers/map-pins-ajax.php
echo "  ✓ inc/ajax-handlers/map-pins-ajax.php"

# Villa Booking AJAX
cat > inc/ajax-handlers/villa-booking-ajax.php << 'EOFVILLA'
<?php
/**
 * Villa Booking AJAX Handlers
 */
if (!defined('ABSPATH')) exit;

EOFVILLA
sed -n '11320,11385p' functions.php >> inc/ajax-handlers/villa-booking-ajax.php
echo "  ✓ inc/ajax-handlers/villa-booking-ajax.php"

echo ""
echo "Phase 4: Extracting Customizer Sections..."

# About Island Customizer
cat > inc/customizer/about-island.php << 'EOFABOUT'
<?php
/**
 * About Island Customizer Settings
 */
if (!defined('ABSPATH')) exit;

EOFABOUT
sed -n '1811,1994p' functions.php >> inc/customizer/about-island.php
echo "  ✓ inc/customizer/about-island.php"

# Accommodations Customizer
cat > inc/customizer/accommodations.php << 'EOFACCOMMODATIONS'
<?php
/**
 * Accommodations Section Customizer Settings
 */
if (!defined('ABSPATH')) exit;

EOFACCOMMODATIONS
sed -n '1999,2153p' functions.php >> inc/customizer/accommodations.php
echo "  ✓ inc/customizer/accommodations.php"

# Experiences Archive Customizer
cat > inc/customizer/experiences-archive.php << 'EOFEXPARCH'
<?php
/**
 * Experiences Archive Customizer Settings
 */
if (!defined('ABSPATH')) exit;

EOFEXPARCH
sed -n '2659,2691p' functions.php >> inc/customizer/experiences-archive.php
echo "  ✓ inc/customizer/experiences-archive.php"

# Events & Offers Customizers
cat > inc/customizer/events-offers.php << 'EOFEVENTS'
<?php
/**
 * Events & Offers Customizer Settings
 */
if (!defined('ABSPATH')) exit;

EOFEVENTS
sed -n '5116,5229p' functions.php >> inc/customizer/events-offers.php
echo "  ✓ inc/customizer/events-offers.php"

# Footer Customizer
cat > inc/customizer/footer.php << 'EOFFOOTER'
<?php
/**
 * Footer Customizer Settings
 */
if (!defined('ABSPATH')) exit;

EOFFOOTER
sed -n '5231,5360p' functions.php >> inc/customizer/footer.php
echo "  ✓ inc/customizer/footer.php"

# Sustainability Customizer
cat > inc/customizer/sustainability.php << 'EOFSUSTAIN'
<?php
/**
 * Sustainability Customizer Settings
 */
if (!defined('ABSPATH')) exit;

EOFSUSTAIN
sed -n '5392,5609p' functions.php >> inc/customizer/sustainability.php
echo "  ✓ inc/customizer/sustainability.php"

# Dining Archive Customizer
cat > inc/customizer/dining-archive.php << 'EOFDINING'
<?php
/**
 * Dining Archive Customizer Settings
 */
if (!defined('ABSPATH')) exit;

EOFDINING
sed -n '6051,6291p' functions.php >> inc/customizer/dining-archive.php
echo "  ✓ inc/customizer/dining-archive.php"

# Booking Modal Customizer
cat > inc/customizer/booking-modal.php << 'EOFBOOKING'
<?php
/**
 * Booking Modal Customizer Settings
 */
if (!defined('ABSPATH')) exit;

EOFBOOKING
sed -n '6575,6782p' functions.php >> inc/customizer/booking-modal.php
echo "  ✓ inc/customizer/booking-modal.php"

# Contact Page Customizer
cat > inc/customizer/contact-page.php << 'EOFCONTACT'
<?php
/**
 * Contact Page Customizer Settings
 */
if (!defined('ABSPATH')) exit;

EOFCONTACT
sed -n '6990,7084p' functions.php >> inc/customizer/contact-page.php
sed -n '7315,7586p' functions.php >> inc/customizer/contact-page.php
echo "  ✓ inc/customizer/contact-page.php"

# Getting Here Page Customizer
cat > inc/customizer/getting-here.php << 'EOFGETTING'
<?php
/**
 * Getting Here Page Customizer Settings
 */
if (!defined('ABSPATH')) exit;

EOFGETTING
sed -n '8268,8930p' functions.php >> inc/customizer/getting-here.php
echo "  ✓ inc/customizer/getting-here.php"

# Private Events Customizer
cat > inc/customizer/private-events.php << 'EOFPEVENTS'
<?php
/**
 * Private Events Customizer Settings
 */
if (!defined('ABSPATH')) exit;

EOFPEVENTS
sed -n '9185,9788p' functions.php >> inc/customizer/private-events.php
echo "  ✓ inc/customizer/private-events.php"

# Accommodations Page Customizer
cat > inc/customizer/accommodations-page.php << 'EOFACCPAGE'
<?php
/**
 * Accommodations Page Customizer Settings
 */
if (!defined('ABSPATH')) exit;

EOFACCPAGE
sed -n '9817,9972p' functions.php >> inc/customizer/accommodations-page.php
echo "  ✓ inc/customizer/accommodations-page.php"

# Riahi Residences Customizer
cat > inc/customizer/riahi-residences.php << 'EOFRIAHI'
<?php
/**
 * Riahi Residences Customizer Settings
 */
if (!defined('ABSPATH')) exit;

EOFRIAHI
sed -n '10378,10453p' functions.php >> inc/customizer/riahi-residences.php
echo "  ✓ inc/customizer/riahi-residences.php"

# Main Customizer (hero, video, etc.)
cat > inc/customizer/main-sections.php << 'EOFMAIN'
<?php
/**
 * Main Customizer Sections (Hero, Video, etc.)
 */
if (!defined('ABSPATH')) exit;

EOFMAIN
sed -n '1476,1806p' functions.php >> inc/customizer/main-sections.php
echo "  ✓ inc/customizer/main-sections.php"

echo ""
echo "Phase 5: Extracting Admin Functionality..."

# Admin Columns
cat > inc/admin/admin-columns.php << 'EOFADMINCOL'
<?php
/**
 * Admin Column Customizations
 */
if (!defined('ABSPATH')) exit;

EOFADMINCOL

# Add all admin column functions
sed -n '1098,1117p' functions.php >> inc/admin/admin-columns.php  # Dining column
sed -n '1235,1315p' functions.php >> inc/admin/admin-columns.php  # Experience columns
sed -n '5065,5111p' functions.php >> inc/admin/admin-columns.php  # Event/Offer columns
sed -n '6293,6324p' functions.php >> inc/admin/admin-columns.php  # Restaurant columns
sed -n '6529,6573p' functions.php >> inc/admin/admin-columns.php  # Ferry columns
sed -n '10177,10233p' functions.php >> inc/admin/admin-columns.php # Villa columns
echo "  ✓ inc/admin/admin-columns.php"

# Admin Pages
cat > inc/admin/admin-pages.php << 'EOFADMINPAGES'
<?php
/**
 * Admin Pages and Menus
 */
if (!defined('ABSPATH')) exit;

EOFADMINPAGES
sed -n '2786,3898p' functions.php >> inc/admin/admin-pages.php  # Map pins admin
sed -n '7086,7306p' functions.php >> inc/admin/admin-pages.php  # Contact submissions
sed -n '9724,9772p' functions.php >> inc/admin/admin-pages.php  # Private events admin
sed -n '10469,10621p' functions.php >> inc/admin/admin-pages.php # Villa icons admin
echo "  ✓ inc/admin/admin-pages.php"

# Admin Scripts
cat > inc/admin/admin-scripts.php << 'EOFADMINJS'
<?php
/**
 * Admin-Only Script Loading
 */
if (!defined('ABSPATH')) exit;

EOFADMINJS
sed -n '1156,1176p' functions.php >> inc/admin/admin-scripts.php  # Experience admin
sed -n '3671,3678p' functions.php >> inc/admin/admin-scripts.php  # Map pins admin
sed -n '5009,5019p' functions.php >> inc/admin/admin-scripts.php  # Event/Offer admin
sed -n '7588,7624p' functions.php >> inc/admin/admin-scripts.php  # Contact admin
echo "  ✓ inc/admin/admin-scripts.php"

echo ""
echo "Phase 6: Extracting Conditional Asset Loading..."

# Single Experience Assets
cat > inc/conditional-enqueue/single-experience-assets.php << 'EOFSINGEXP'
<?php
/**
 * Single Experience Page Assets
 */
if (!defined('ABSPATH')) exit;

EOFSINGEXP
sed -n '1119,1154p' functions.php >> inc/conditional-enqueue/single-experience-assets.php
sed -n '5611,5626p' functions.php >> inc/conditional-enqueue/single-experience-assets.php
echo "  ✓ inc/conditional-enqueue/single-experience-assets.php"

# Single Villa Assets
cat > inc/conditional-enqueue/single-villa-assets.php << 'EOFSINGVILLA'
<?php
/**
 * Single Villa Page Assets
 */
if (!defined('ABSPATH')) exit;

EOFSINGVILLA
sed -n '11145,11315p' functions.php >> inc/conditional-enqueue/single-villa-assets.php
echo "  ✓ inc/conditional-enqueue/single-villa-assets.php"

# Getting Here Assets
cat > inc/conditional-enqueue/getting-here-assets.php << 'EOFGETTINGASSETS'
<?php
/**
 * Getting Here Page Assets
 */
if (!defined('ABSPATH')) exit;

EOFGETTINGASSETS
sed -n '8209,8266p' functions.php >> inc/conditional-enqueue/getting-here-assets.php
sed -n '8938,8949p' functions.php >> inc/conditional-enqueue/getting-here-assets.php
echo "  ✓ inc/conditional-enqueue/getting-here-assets.php"

# Private Events Assets
cat > inc/conditional-enqueue/private-events-assets.php << 'EOFPRIVASSETS'
<?php
/**
 * Private Events Page Assets
 */
if (!defined('ABSPATH')) exit;

EOFPRIVASSETS
sed -n '8951,8971p' functions.php >> inc/conditional-enqueue/private-events-assets.php
echo "  ✓ inc/conditional-enqueue/private-events-assets.php"

# Accommodations Page Assets
cat > inc/conditional-enqueue/accommodations-page-assets.php << 'EOFACCASSETS'
<?php
/**
 * Accommodations Page Assets
 */
if (!defined('ABSPATH')) exit;

EOFACCASSETS
sed -n '9790,9811p' functions.php >> inc/conditional-enqueue/accommodations-page-assets.php
echo "  ✓ inc/conditional-enqueue/accommodations-page-assets.php"

# Riahi Residences Assets
cat > inc/conditional-enqueue/riahi-residences-assets.php << 'EOFRIAHASSETS'
<?php
/**
 * Riahi Residences Page Assets
 */
if (!defined('ABSPATH')) exit;

EOFRIAHASSETS
sed -n '10455,10467p' functions.php >> inc/conditional-enqueue/riahi-residences-assets.php
echo "  ✓ inc/conditional-enqueue/riahi-residences-assets.php"

# Booking Modal Assets
cat > inc/conditional-enqueue/booking-modal-assets.php << 'EOFBOOKASSETS'
<?php
/**
 * Booking Modal Assets
 */
if (!defined('ABSPATH')) exit;

EOFBOOKASSETS
sed -n '6764,6782p' functions.php >> inc/conditional-enqueue/booking-modal-assets.php
sed -n '11387,11550p' functions.php >> inc/conditional-enqueue/booking-modal-assets.php
echo "  ✓ inc/conditional-enqueue/booking-modal-assets.php"

# Sustainability Assets
cat > inc/conditional-enqueue/sustainability-assets.php << 'EOFSUSTAINASSETS'
<?php
/**
 * Sustainability Page Assets
 */
if (!defined('ABSPATH')) exit;

EOFSUSTAINASSETS
sed -n '5577,5609p' functions.php >> inc/conditional-enqueue/sustainability-assets.php
echo "  ✓ inc/conditional-enqueue/sustainability-assets.php"

echo ""
echo "Creating Additional Helper Files..."

# Language/Menu helpers
cat > inc/helper-functions-extended.php << 'EOFHELPERS'
<?php
/**
 * Extended Helper Functions
 * Language, menus, breadcrumbs, templates
 */
if (!defined('ABSPATH')) exit;

EOFHELPERS
sed -n '2173,2430p' functions.php >> inc/helper-functions-extended.php
sed -n '2454,2717p' functions.php >> inc/helper-functions-extended.php
echo "  ✓ inc/helper-functions-extended.php"

# Database table creation functions
cat > inc/database-tables.php << 'EOFDATABASE'
<?php
/**
 * Database Table Creation and Management
 */
if (!defined('ABSPATH')) exit;

EOFDATABASE
sed -n '6961,6989p' functions.php >> inc/database-tables.php  # Contact table
sed -n '7603,7624p' functions.php >> inc/database-tables.php  # Contact table update
sed -n '9159,9185p' functions.php >> inc/database-tables.php  # Private events table
echo "  ✓ inc/database-tables.php"

# Template filters and hooks
cat > inc/template-hooks.php << 'EOFTEMPLATE'
<?php
/**
 * Template Filters and Hooks
 */
if (!defined('ABSPATH')) exit;

EOFTEMPLATE
sed -n '2696,2717p' functions.php >> inc/template-hooks.php
sed -n '10239,10255p' functions.php >> inc/template-hooks.php
echo "  ✓ inc/template-hooks.php"

# Utility functions (icon management, etc.)
cat > inc/utility-functions.php << 'EOFUTIL'
<?php
/**
 * Utility Functions
 * Icon management, file uploads, misc helpers
 */
if (!defined('ABSPATH')) exit;

EOFUTIL
sed -n '3690,3809p' functions.php >> inc/utility-functions.php  # Icon functions
sed -n '3725,3898p' functions.php >> inc/utility-functions.php  # Icon upload/delete
sed -n '10484,10766p' functions.php >> inc/utility-functions.php # Villa icon functions
echo "  ✓ inc/utility-functions.php"

# Sample data creation
cat > inc/sample-data.php << 'EOFSAMPLE'
<?php
/**
 * Sample Data Creation (Theme Activation)
 */
if (!defined('ABSPATH')) exit;

EOFSAMPLE
sed -n '1320,1379p' functions.php >> inc/sample-data.php
echo "  ✓ inc/sample-data.php"

echo ""
echo "Validating PHP syntax for all created files..."

# Validate all PHP files
for file in inc/**/*.php; do
    if ! php -l "$file" > /dev/null 2>&1; then
        echo "  ✗ Syntax error in: $file"
        php -l "$file"
        exit 1
    fi
done

echo "  ✓ All files have valid PHP syntax"

echo ""
echo "=============================================="
echo "Extraction Complete!"
echo "=============================================="
echo ""
echo "Created Modules:"
echo "  - 8 meta-box files"
echo "  - 5 AJAX handler files"
echo "  - 14 customizer files"
echo "  - 3 admin files"
echo "  - 8 conditional enqueue files"
echo "  - 5 additional helper files"
echo ""
echo "Total: 43 modular files created"
echo ""
echo "Next: Run ./create-final-functions.sh to generate"
echo "      the integrated functions.php file"
echo "=============================================="
