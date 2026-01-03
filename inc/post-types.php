<?php
/**
 * Custom Post Types Registration
 *
 * All custom post type registrations for the Nirup Island theme.
 * This file contains registration functions for:
 * - Experiences
 * - Events & Offers
 * - Restaurants
 * - Ferry Schedules
 * - Private Charters
 * - Villas
 * - Westin Rooms
 * - Media Coverage
 * - Selling Units
 *
 * @package Nirup_Island_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Custom Post Type: Experiences
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
 * Register Custom Post Type: Events & Offers
 */
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
 * Register Custom Post Type: Restaurants
 */
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

/**
 * Register Custom Post Type: Ferry Schedules
 */
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

/**
 * Register Custom Post Type: Private Charters
 */
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

/**
 * Register Custom Post Type: Villas
 */
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
 * Register Custom Post Type: Westin Rooms
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
 * Register Custom Post Type: Media Coverage
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
 * Register Custom Post Type: Selling Units
 */
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
