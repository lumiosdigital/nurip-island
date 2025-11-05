<?php
/**
 * Helper Functions
 *
 * Utility and query functions used throughout the theme
 * Extracted from functions.php for better organization
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get Experiences displayed in Dining page
 */
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

/**
 * Get featured experiences for carousel
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
 * Get all experiences (for archive page)
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
 * Get child experiences for category-type experiences
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
 * Get featured events and offers for carousel
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
 * Get YouTube embed URL from various YouTube URL formats
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
        'rel' => '0',
        'modestbranding' => '1',
        'iv_load_policy' => '3',
        'enablejsapi' => '1',
    );

    // Add autoplay parameter if enabled
    if ($autoplay) {
        $params['autoplay'] = '1';
        $params['mute'] = '1';
    }

    // Add loop parameter if enabled
    if ($loop) {
        $params['loop'] = '1';
        $params['playlist'] = $video_id;
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

/**
 * Get template part with arguments (like get_template_part but with args)
 */
function nirup_get_template_part($slug, $name = null, $args = array()) {
    extract($args);

    $templates = array();
    if ($name) {
        $templates[] = "{$slug}-{$name}.php";
    }
    $templates[] = "{$slug}.php";

    locate_template($templates, true, false);
}
