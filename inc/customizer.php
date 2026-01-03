<?php
/**
 * Theme Customizer Settings
 *
 * All WordPress Customizer settings and controls for the Nirup Island theme.
 * Organized by section for easy maintenance.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

function nirup_customize_register($wp_customize) {
    // Announcement Bar Section
    $wp_customize->add_section('nirup_announcement_bar', array(
        'title' => __('Announcement Bar', 'nirup-island'),
        'priority' => 20,
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

    // Hero Logo Link
    $wp_customize->add_setting('nirup_hero_logo_link', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_hero_logo_link', array(
        'label' => __('Hero Logo Link URL', 'nirup-island'),
        'section' => 'nirup_hero_section',
        'type' => 'url',
        'description' => __('Enter the URL where the logo should link to (e.g., homepage or Westin website)', 'nirup-island'),
    ));

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

// Video Source Type (YouTube or Upload)
$wp_customize->add_setting('nirup_video_source_type', array(
    'default' => 'youtube',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_control('nirup_video_source_type', array(
    'label' => __('Video Source', 'nirup-island'),
    'section' => 'nirup_video_section',
    'type' => 'radio',
    'choices' => array(
        'youtube' => __('YouTube Video', 'nirup-island'),
        'upload' => __('Upload Video', 'nirup-island'),
    ),
));

// YouTube Video URL
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

// Uploaded Video File
$wp_customize->add_setting('nirup_video_upload', array(
    'default' => '',
    'sanitize_callback' => 'absint',
));

$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_video_upload', array(
    'label' => __('Upload Video File', 'nirup-island'),
    'description' => __('Upload an MP4 video file. Recommended size: Max 50MB for better performance.', 'nirup-island'),
    'section' => 'nirup_video_section',
    'mime_type' => 'video',
)));

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

// Autoplay Toggle
$wp_customize->add_setting('nirup_video_autoplay', array(
    'default' => false,
    'sanitize_callback' => 'wp_validate_boolean',
));

$wp_customize->add_control('nirup_video_autoplay', array(
    'label' => __('Autoplay Video', 'nirup-island'),
    'description' => __('Video will autoplay muted when page loads. Best for ambient/background videos.', 'nirup-island'),
    'section' => 'nirup_video_section',
    'type' => 'checkbox',
));

// Loop Toggle
$wp_customize->add_setting('nirup_video_loop', array(
    'default' => false,
    'sanitize_callback' => 'wp_validate_boolean',
));

$wp_customize->add_control('nirup_video_loop', array(
    'label' => __('Loop Video', 'nirup-island'),
    'description' => __('Video will restart automatically when it ends.', 'nirup-island'),
    'section' => 'nirup_video_section',
    'type' => 'checkbox',
));

    // Navigation Settings Section
    $wp_customize->add_section('nirup_navigation', array(
        'title' => __('Navigation Settings', 'nirup-island'),
        'priority' => 21,
    ));

    // Booking Button Text (Header & Mobile)
    $wp_customize->add_setting('nirup_booking_button_text', array(
        'default' => __('Book Your Stay', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_booking_button_text', array(
        'label' => __('Booking Button Text', 'nirup-island'),
        'description' => __('Text for both header and mobile booking buttons', 'nirup-island'),
        'section' => 'nirup_navigation',
        'type' => 'text',
    ));

    // Booking Button Link (Header & Mobile)
    $wp_customize->add_setting('nirup_booking_button_link', array(
        'default' => '/accommodations/the-westin-nirup-island-resort-spa/',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_booking_button_link', array(
        'label' => __('Booking Button Link', 'nirup-island'),
        'description' => __('URL for both header and mobile booking buttons (e.g., Westin page)', 'nirup-island'),
        'section' => 'nirup_navigation',
        'type' => 'url',
    ));


    // Wellness Retreat Section
$wp_customize->add_section('nirup_wellness_retreat', array(
    'title' => __('Promo Banner Section', 'nirup-island'),
    'priority' => 36,
));

// Small Title
$wp_customize->add_setting('nirup_wellness_small_title', array(
    'default' => __('Wellness Retreat Package', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_control('nirup_wellness_small_title', array(
    'label' => __('Small Title', 'nirup-island'),
    'section' => 'nirup_wellness_retreat',
    'type' => 'text',
));

// Main Title
$wp_customize->add_setting('nirup_wellness_main_title', array(
    'default' => __('WELLNESS RETREAT BY WESTIN', 'nirup-island'),
    'sanitize_callback' => 'sanitize_textarea_field',
));

$wp_customize->add_control('nirup_wellness_main_title', array(
    'label' => __('Main Title', 'nirup-island'),
    'section' => 'nirup_wellness_retreat',
    'type' => 'textarea',
));

// Date Range
$wp_customize->add_setting('nirup_wellness_date_range', array(
    'default' => __('June 03, 2025 – September 02, 2025', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_control('nirup_wellness_date_range', array(
    'label' => __('Date Range', 'nirup-island'),
    'section' => 'nirup_wellness_retreat',
    'type' => 'text',
));

// Description
$wp_customize->add_setting('nirup_wellness_description', array(
    'default' => __('The Nirup Wellness Retreat at The Westin Nirup Island Resort & Spa offers guests a holistic escape, featuring daily wellness and family activities, access to the WestinWORKOUT® Fitness Studio, and a curated program of rejuvenating experiences.', 'nirup-island'),
    'sanitize_callback' => 'sanitize_textarea_field',
));

$wp_customize->add_control('nirup_wellness_description', array(
    'label' => __('Description', 'nirup-island'),
    'section' => 'nirup_wellness_retreat',
    'type' => 'textarea',
));

// Button Text
$wp_customize->add_setting('nirup_wellness_button_text', array(
    'default' => __('Book Your Stay', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_control('nirup_wellness_button_text', array(
    'label' => __('Button Text', 'nirup-island'),
    'section' => 'nirup_wellness_retreat',
    'type' => 'text',
));

// Button Link
$wp_customize->add_setting('nirup_wellness_button_link', array(
    'default' => '#',
    'sanitize_callback' => 'esc_url_raw',
));

$wp_customize->add_control('nirup_wellness_button_link', array(
    'label' => __('Button Link', 'nirup-island'),
    'section' => 'nirup_wellness_retreat',
    'type' => 'url',
));

// Wellness Image
$wp_customize->add_setting('nirup_wellness_image', array(
    'default' => '',
    'sanitize_callback' => 'absint',
));

$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_wellness_image', array(
    'label' => __('Wellness Image', 'nirup-island'),
    'section' => 'nirup_wellness_retreat',
    'mime_type' => 'image',
)));
}
add_action('customize_register', 'nirup_customize_register');

function nirup_about_island_customizer($wp_customize) {
    // About Island Section
    $wp_customize->add_section('nirup_about_island', array(
        'title' => __('About Island Section', 'nirup-island'),
        'priority' => 32,
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

function nirup_accommodations_customizer($wp_customize) {
    // Accommodations Section
    $wp_customize->add_section('nirup_accommodations', array(
        'title' => __('Accommodations Section', 'nirup-island'),
        'priority' => 33,
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

function nirup_experiences_archive_customizer($wp_customize) {
    // Experiences Archive Section
    $wp_customize->add_section('nirup_experiences_archive', array(
        'title' => __('Experiences Archive Page', 'nirup-island'),
        'priority' => 41,
        'description' => __('Customize the experiences archive page content', 'nirup-island'),
    ));

    // Archive Title
    $wp_customize->add_setting('nirup_experiences_archive_title', array(
        'default' => __('Island Experiences', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_experiences_archive_title', array(
        'label' => __('Archive Page Title', 'nirup-island'),
        'section' => 'nirup_experiences_archive',
        'type' => 'text',
    ));

    // Archive Subtitle
    $wp_customize->add_setting('nirup_experiences_archive_subtitle', array(
        'default' => __('Discover curated experiences that make every moment unforgettable — from family fun to wellness escapes', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_experiences_archive_subtitle', array(
        'label' => __('Archive Page Subtitle', 'nirup-island'),
        'section' => 'nirup_experiences_archive',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'nirup_experiences_archive_customizer');

function nirup_map_section_customizer($wp_customize) {
    
    // Add Map Section Panel
    $wp_customize->add_section('nirup_map_section', array(
        'title'    => __('Map Section', 'nirup-island'),
        'priority' => 35,
        'description' => __('Customize the island map section settings', 'nirup-island'),
    ));

    // Map Section Display Toggle
    $wp_customize->add_setting('nirup_map_display', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('nirup_map_display', array(
        'label'    => __('Display Map Section', 'nirup-island'),
        'section'  => 'nirup_map_section',
        'type'     => 'checkbox',
        'priority' => 5,
    ));

    // Map Section Title
    $wp_customize->add_setting('nirup_map_title', array(
        'default'           => __('Explore Our Island', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_map_title', array(
        'label'    => __('Map Section Title', 'nirup-island'),
        'section'  => 'nirup_map_section',
        'type'     => 'text',
        'priority' => 10,
    ));

    // Map Section Subtitle
    $wp_customize->add_setting('nirup_map_subtitle', array(
        'default'           => __('Discover amazing locations and experiences across Nirup Island', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('nirup_map_subtitle', array(
        'label'    => __('Map Section Subtitle', 'nirup-island'),
        'section'  => 'nirup_map_section',
        'type'     => 'textarea',
        'priority' => 20,
    ));

    // Map Image
    $wp_customize->add_setting('nirup_map_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_map_image', array(
        'label'     => __('Map Image', 'nirup-island'),
        'section'   => 'nirup_map_section',
        'mime_type' => 'image',
        'priority'  => 30,
        'description' => __('Upload the main map image for your island. Recommended size: 1200x600px or larger.', 'nirup-island'),
    )));
}
add_action('customize_register', 'nirup_map_section_customizer');

function nirup_getting_here_customizer($wp_customize) {
    // Getting Here Section
    $wp_customize->add_section('nirup_getting_here', array(
        'title' => __('Getting Here Section', 'nirup-island'),
        'priority' => 37,
        'description' => __('Customize the Getting Here section with interactive Google Maps', 'nirup-island'),
    ));

    // Section Content Settings
    $wp_customize->add_setting('nirup_getting_here_title', array(
        'default' => __('GETTING HERE', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_getting_here_title', array(
        'label' => __('Section Title', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_getting_here_description', array(
        'default' => __('Nirup Island is just a 20-minute ferry ride from Harbour Bay Ferry Terminal in Batam and 50 minutes from HarbourFront Centre in Singapore.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('nirup_getting_here_description', array(
        'label' => __('Description', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'textarea',
    ));

    // Google Maps API Settings
    $wp_customize->add_setting('nirup_google_maps_api_key', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_google_maps_api_key', array(
        'label' => __('Google Maps API Key', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
        'description' => __('Enter your Google Maps JavaScript API key. Get one at: https://developers.google.com/maps/documentation/javascript/get-api-key', 'nirup-island'),
    ));

    // Map Settings
    $wp_customize->add_setting('nirup_map_center_lat', array(
        'default' => '1.1304753',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_map_center_lat', array(
        'label' => __('Map Center Latitude (Nirup Island)', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
        'description' => __('Latitude coordinate for Nirup Island', 'nirup-island'),
    ));

    $wp_customize->add_setting('nirup_map_center_lng', array(
        'default' => '104.0266055',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_map_center_lng', array(
        'label' => __('Map Center Longitude (Nirup Island)', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
        'description' => __('Longitude coordinate for Nirup Island', 'nirup-island'),
    ));

    $wp_customize->add_setting('nirup_map_zoom', array(
        'default' => '10',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('nirup_map_zoom', array(
        'label' => __('Map Zoom Level', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
        ),
        'description' => __('Map zoom level (1-20, recommended: 10-12)', 'nirup-island'),
    ));

    $wp_customize->add_setting('nirup_map_style', array(
        'default' => 'terrain',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_map_style', array(
        'label' => __('Map Style', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'select',
        'choices' => array(
            'roadmap' => __('Roadmap', 'nirup-island'),
            'satellite' => __('Satellite', 'nirup-island'),
            'hybrid' => __('Hybrid', 'nirup-island'),
            'terrain' => __('Terrain', 'nirup-island'),
        ),
    ));

    // Singapore Ferry Terminal Settings
    $wp_customize->add_setting('nirup_singapore_lat', array(
        'default' => '1.2650543',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_singapore_lat', array(
        'label' => __('Singapore Terminal Latitude', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
        'description' => __('HarbourFront Centre coordinates', 'nirup-island'),
    ));

    $wp_customize->add_setting('nirup_singapore_lng', array(
        'default' => '103.8232508',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_singapore_lng', array(
        'label' => __('Singapore Terminal Longitude', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_singapore_departure', array(
        'default' => __('HarbourFront Centre', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_singapore_departure', array(
        'label' => __('Singapore Departure Point', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_singapore_time', array(
        'default' => __('50 minutes', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_singapore_time', array(
        'label' => __('Singapore Travel Time', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_singapore_ferry_info', array(
        'default' => __('50 minutes from HarbourFront Centre', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_singapore_ferry_info', array(
        'label' => __('Singapore Ferry Info (Map Tooltip)', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    // Batam Ferry Terminal Settings
    $wp_customize->add_setting('nirup_batam_lat', array(
        'default' => '1.1210997',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_batam_lat', array(
        'label' => __('Batam Terminal Latitude', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
        'description' => __('Harbour Bay Ferry Terminal coordinates', 'nirup-island'),
    ));

    $wp_customize->add_setting('nirup_batam_lng', array(
        'default' => '104.0538234',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_batam_lng', array(
        'label' => __('Batam Terminal Longitude', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_batam_departure', array(
        'default' => __('Harbour Bay Ferry Terminal', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_batam_departure', array(
        'label' => __('Batam Departure Point', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_batam_time', array(
        'default' => __('20 minutes', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_batam_time', array(
        'label' => __('Batam Travel Time', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_batam_ferry_info', array(
        'default' => __('20 minutes from Harbour Bay Terminal', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_batam_ferry_info', array(
        'label' => __('Batam Ferry Info (Map Tooltip)', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    // Show/Hide Section
    $wp_customize->add_setting('nirup_getting_here_show', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('nirup_getting_here_show', array(
        'label' => __('Show Getting Here Section', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'checkbox',
    ));

        // See More Button Settings
    $wp_customize->add_setting('nirup_getting_here_show_button', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('nirup_getting_here_show_button', array(
        'label' => __('Show "See More" Button', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'checkbox',
        'description' => __('Display the "See More" button in the header', 'nirup-island'),
    ));

    $wp_customize->add_setting('nirup_getting_here_button_text', array(
        'default' => __('See More', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_getting_here_button_text', array(
        'label' => __('Button Text', 'nirup-island'),
        'section' => 'nirup_getting_here',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_getting_here_button_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

}
add_action('customize_register', 'nirup_getting_here_customizer');

function nirup_services_customize_register($wp_customize) {
    
    // ===========================
    // SERVICES SECTION PANEL
    // ===========================
    
    $wp_customize->add_section('nirup_services_section', array(
        'title'       => __('Services Section', 'nirup-island'),
        'description' => __('Configure the services section with Private Events, Marina, and Sustainability cards.', 'nirup-island'),
        'priority'    => 37,
    ));
    
    // Services Section Show/Hide
    $wp_customize->add_setting('nirup_services_show', array(
        'default'           => true,
        'sanitize_callback' => 'nirup_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_services_show', array(
        'label'       => __('Show Services Section', 'nirup-island'),
        'description' => __('Toggle to show/hide the entire services section.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'checkbox',
        'priority'    => 10,
    ));
    
    // ===========================
    // PRIVATE EVENTS CARD
    // ===========================
    
    // Private Events Title
    $wp_customize->add_setting('nirup_service_events_title', array(
        'default'           => __('Private Events', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_service_events_title', array(
        'label'       => __('Private Events Title', 'nirup-island'),
        'description' => __('Title for the Private Events card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'text',
        'priority'    => 20,
    ));
    
    // Private Events Description
    $wp_customize->add_setting('nirup_service_events_desc', array(
        'default'           => __('Nirup Island provides an exclusive and well-appointed setting for private team-building events, destination weddings, and other special occasions.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_service_events_desc', array(
        'label'       => __('Private Events Description', 'nirup-island'),
        'description' => __('Description text for the Private Events card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'textarea',
        'priority'    => 30,
    ));
    
    // Private Events Image
    $wp_customize->add_setting('nirup_service_events_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_service_events_image', array(
        'label'       => __('Private Events Image', 'nirup-island'),
        'description' => __('Upload an image for the Private Events card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'mime_type'   => 'image',
        'priority'    => 40,
    )));
    
    // Private Events Link
    $wp_customize->add_setting('nirup_service_events_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_service_events_link', array(
        'label'       => __('Private Events Link', 'nirup-island'),
        'description' => __('URL where the Private Events card should link to.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'url',
        'priority'    => 45,
    ));
    
    // ===========================
    // MARINA CARD
    // ===========================
    
    // Marina Title
    $wp_customize->add_setting('nirup_service_marina_title', array(
        'default'           => __('Marina', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_service_marina_title', array(
        'label'       => __('Marina Title', 'nirup-island'),
        'description' => __('Title for the Marina card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'text',
        'priority'    => 50,
    ));
    
    // Marina Description
    $wp_customize->add_setting('nirup_service_marina_desc', array(
        'default'           => __('ONE°15 Marina at Nirup Island offers berthing facilities for up to 70 private yachts, along with private charters for scenic journeys or special events.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_service_marina_desc', array(
        'label'       => __('Marina Description', 'nirup-island'),
        'description' => __('Description text for the Marina card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'textarea',
        'priority'    => 60,
    ));
    
    // Marina Image
    $wp_customize->add_setting('nirup_service_marina_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_service_marina_image', array(
        'label'       => __('Marina Image', 'nirup-island'),
        'description' => __('Upload an image for the Marina card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'mime_type'   => 'image',
        'priority'    => 70,
    )));
    
    // Marina Link
    $wp_customize->add_setting('nirup_service_marina_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_service_marina_link', array(
        'label'       => __('Marina Link', 'nirup-island'),
        'description' => __('URL where the Marina card should link to.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'url',
        'priority'    => 75,
    ));
    
    // ===========================
    // SUSTAINABILITY CARD
    // ===========================
    
    // Sustainability Title
    $wp_customize->add_setting('nirup_service_sustainability_title', array(
        'default'           => __('Sustainability', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_service_sustainability_title', array(
        'label'       => __('Sustainability Title', 'nirup-island'),
        'description' => __('Title for the Sustainability card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'text',
        'priority'    => 80,
    ));
    
    // Sustainability Description
    $wp_customize->add_setting('nirup_service_sustainability_desc', array(
        'default'           => __('From solar panels to rainwater harvesting and local sourcing, sustainability is central to Nirup Island\'s operations. Guests are encouraged to engage in eco-friendly habits and support local communities.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_service_sustainability_desc', array(
        'label'       => __('Sustainability Description', 'nirup-island'),
        'description' => __('Description text for the Sustainability card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'textarea',
        'priority'    => 90,
    ));
    
    // Sustainability Image
    $wp_customize->add_setting('nirup_service_sustainability_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_service_sustainability_image', array(
        'label'       => __('Sustainability Image', 'nirup-island'),
        'description' => __('Upload an image for the Sustainability card.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'mime_type'   => 'image',
        'priority'    => 100,
    )));
    
    // Sustainability Link
    $wp_customize->add_setting('nirup_service_sustainability_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_service_sustainability_link', array(
        'label'       => __('Sustainability Link', 'nirup-island'),
        'description' => __('URL where the Sustainability card should link to.', 'nirup-island'),
        'section'     => 'nirup_services_section',
        'type'        => 'url',
        'priority'    => 105,
    ));
}
add_action('customize_register', 'nirup_services_customize_register');

function nirup_services_customize_preview_js() {
    wp_enqueue_script(
        'nirup-services-customize-preview',
        get_template_directory_uri() . '/assets/js/customize-preview-services.js',
        array('customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'nirup_services_customize_preview_js');

function nirup_events_offers_archive_customizer($wp_customize) {
    // Events & Offers Archive Section
    $wp_customize->add_section('nirup_events_offers_archive', array(
        'title' => __('Events & Offers Archive Page', 'nirup-island'),
        'priority' => 42,
        'description' => __('Customize the events and offers archive page content', 'nirup-island'),
    ));

    // Archive Title
    $wp_customize->add_setting('nirup_events_offers_archive_title', array(
        'default' => __('Events & Offers', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_events_offers_archive_title', array(
        'label' => __('Archive Page Title', 'nirup-island'),
        'section' => 'nirup_events_offers_archive',
        'type' => 'text',
    ));

    // Archive Subtitle
    $wp_customize->add_setting('nirup_events_offers_archive_subtitle', array(
        'default' => __('Discover special events and exclusive offers that make your island experience even more memorable', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_events_offers_archive_subtitle', array(
        'label' => __('Archive Page Subtitle', 'nirup-island'),
        'section' => 'nirup_events_offers_archive',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'nirup_events_offers_archive_customizer');

function nirup_events_offers_carousel_customizer($wp_customize) {
    // Events & Offers Carousel Section
    $wp_customize->add_section('nirup_events_offers_carousel', array(
        'title' => __('Events & Offers Carousel', 'nirup-island'),
        'priority' => 40,
        'description' => __('Customize the events and offers carousel section on the homepage', 'nirup-island'),
    ));

    // Carousel Subtitle
    $wp_customize->add_setting('nirup_events_offers_subtitle', array(
        'default' => __('Events & Offers', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_events_offers_subtitle', array(
        'label' => __('Carousel Subtitle', 'nirup-island'),
        'section' => 'nirup_events_offers_carousel',
        'type' => 'text',
        'description' => __('Leave empty to hide the subtitle completely.', 'nirup-island'),
    ));

    // Carousel Title
    $wp_customize->add_setting('nirup_events_offers_title', array(
        'default' => __('Discover Special Moments', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_events_offers_title', array(
        'label' => __('Carousel Title', 'nirup-island'),
        'section' => 'nirup_events_offers_carousel',
        'type' => 'text',
        'description' => __('Leave empty to hide the title completely.', 'nirup-island'),
    ));
}
add_action('customize_register', 'nirup_events_offers_carousel_customizer');

function nirup_experiences_carousel_customizer($wp_customize) {
    // Experiences Carousel Section
    $wp_customize->add_section('nirup_experiences_carousel', array(
        'title' => __('Experiences Carousel', 'nirup-island'),
        'priority' => 34,
        'description' => __('Customize the experiences carousel section on the homepage', 'nirup-island'),
    ));

    // Carousel Subtitle
    $wp_customize->add_setting('nirup_experiences_subtitle', array(
        'default' => __('Experiences', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_experiences_subtitle', array(
        'label' => __('Carousel Subtitle', 'nirup-island'),
        'section' => 'nirup_experiences_carousel',
        'type' => 'text',
        'description' => __('Leave empty to hide the subtitle completely.', 'nirup-island'),
    ));

    // Carousel Title
    $wp_customize->add_setting('nirup_experiences_title', array(
        'default' => __('Live the Island Lifestyle', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_experiences_title', array(
        'label' => __('Carousel Title', 'nirup-island'),
        'section' => 'nirup_experiences_carousel',
        'type' => 'text',
        'description' => __('Leave empty to hide the title completely.', 'nirup-island'),
    ));
}
add_action('customize_register', 'nirup_experiences_carousel_customizer');

function nirup_footer_customizer($wp_customize) {
    // Footer Section
    $wp_customize->add_section('nirup_footer_settings', array(
        'title' => __('Footer Settings', 'nirup-island'),
        'priority' => 50,
        'description' => __('Customize footer content, social media links, and contact information', 'nirup-island'),
    ));

    // === SOCIAL MEDIA SETTINGS ===
    
    // YouTube URL
    $wp_customize->add_setting('nirup_social_youtube', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_social_youtube', array(
        'label' => __('YouTube URL', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'url',
        'description' => __('Enter your YouTube channel URL. Leave empty to hide the icon.', 'nirup-island'),
    ));

    // Instagram URL
    $wp_customize->add_setting('nirup_social_instagram', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_social_instagram', array(
        'label' => __('Instagram URL', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'url',
        'description' => __('Enter your Instagram profile URL. Leave empty to hide the icon.', 'nirup-island'),
    ));

    // TikTok URL
    $wp_customize->add_setting('nirup_social_tiktok', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_social_tiktok', array(
        'label' => __('TikTok URL', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'url',
        'description' => __('Enter your TikTok profile URL. Leave empty to hide the icon.', 'nirup-island'),
    ));

    // Facebook URL
    $wp_customize->add_setting('nirup_social_facebook', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_social_facebook', array(
        'label' => __('Facebook URL', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'url',
        'description' => __('Enter your Facebook profile URL. Leave empty to hide the icon.', 'nirup-island'),
    ));

    // TripAdvisor URL
    $wp_customize->add_setting('nirup_social_tripadvisor', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_social_tripadvisor', array(
        'label' => __('TripAdvisor URL', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'url',
        'description' => __('Enter your TripAdvisor listing URL. Leave empty to hide the icon.', 'nirup-island'),
    ));

    // === CONTACT INFORMATION SETTINGS ===

    // Contact Email
    $wp_customize->add_setting('nirup_contact_email', array(
        'default' => 'info@nirupisland.com',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('nirup_contact_email', array(
        'label' => __('Contact Email', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'email',
        'description' => __('Main contact email address displayed in the footer', 'nirup-island'),
    ));

    // Primary Phone Number
    $wp_customize->add_setting('nirup_contact_phone_primary', array(
        'default' => '+62 811 6220 999',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_contact_phone_primary', array(
        'label' => __('Primary Phone Number', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'text',
        'description' => __('Main phone number for contact', 'nirup-island'),
    ));

    // Hotel Direct Phone Number
    $wp_customize->add_setting('nirup_contact_phone_direct', array(
        'default' => '+62 778 210 8899',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_contact_phone_direct', array(
        'label' => __('Hotel Direct Phone Number', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'text',
        'description' => __('Direct hotel phone number', 'nirup-island'),
    ));

    // Contact Address
    $wp_customize->add_setting('nirup_contact_address', array(
        'default' => 'Nirup Island, Sekanak Raya, Belakang Padang, Batam, Riau Islands, Indonesia, 29416',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('nirup_contact_address', array(
        'label' => __('Contact Address', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'textarea',
        'description' => __('Full address displayed in the footer', 'nirup-island'),
    ));

    // === BREVO NEWSLETTER SETTINGS ===

        // === reCAPTCHA v3 SETTINGS ===

    // Site Key
    $wp_customize->add_setting('nirup_recaptcha_site_key', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'capability'        => 'manage_options',
    ));
    $wp_customize->add_control('nirup_recaptcha_site_key', array(
        'label'       => __('reCAPTCHA v3 Site Key', 'nirup-island'),
        'section'     => 'nirup_footer_settings',
        'type'        => 'text',
        'description' => __('From Google reCAPTCHA Admin Console. Add all domains (localhost, staging, production).', 'nirup-island'),
    ));

    // Secret Key
    $wp_customize->add_setting('nirup_recaptcha_secret', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'capability'        => 'manage_options',
    ));
    $wp_customize->add_control('nirup_recaptcha_secret', array(
        'label'       => __('reCAPTCHA v3 Secret Key', 'nirup-island'),
        'section'     => 'nirup_footer_settings',
        'type'        => 'text', // change to 'password' if you prefer hidden input
        'description' => __('Server-side secret used to verify tokens. For best security, you can define RECAPTCHA_SECRET in wp-config.php.', 'nirup-island'),
    ));

    // (Optional) tighten Brevo List ID sanitization to integer
    $wp_customize->add_setting('nirup_brevo_list_id', array(
        'default'           => '6',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('nirup_brevo_list_id', array(
        'label'       => __('Brevo List ID', 'nirup-island'),
        'section'     => 'nirup_footer_settings',
        'type'        => 'number',
        'input_attrs' => array('min' => 1, 'step' => 1),
        'description' => __('Numeric List ID (e.g., 6).', 'nirup-island'),
    ));


    // Brevo API Key
    $wp_customize->add_setting('nirup_brevo_api_key', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_brevo_api_key', array(
        'label' => __('Brevo API Key', 'nirup-island'),
        'section' => 'nirup_footer_settings',
        'type' => 'text',
        'description' => __('Enter your Brevo (Sendinblue) API key for newsletter integration', 'nirup-island'),
    ));

}
add_action('customize_register', 'nirup_footer_customizer');

function nirup_sustainability_customizer($wp_customize) {
    
    // Add Sustainability Page Section
    $wp_customize->add_section('nirup_sustainability_page', array(
        'title'    => __('Sustainability Page', 'nirup-island'),
        'priority' => 40,
        'description' => __('Customize the sustainability page content and images', 'nirup-island'),
    ));

    // Hero Section Settings
    // Hero Subtitle
    $wp_customize->add_setting('nirup_sustainability_hero_subtitle', array(
        'default'           => __('Balancing comfort with care for the planet', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('nirup_sustainability_hero_subtitle', array(
        'label'    => __('Hero Subtitle', 'nirup-island'),
        'section'  => 'nirup_sustainability_page',
        'type'     => 'text',
        'priority' => 10,
    ));

    // Hero Title
    $wp_customize->add_setting('nirup_sustainability_hero_title', array(
        'default'           => __('Sustainability', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('nirup_sustainability_hero_title', array(
        'label'    => __('Hero Title', 'nirup-island'),
        'section'  => 'nirup_sustainability_page',
        'type'     => 'text',
        'priority' => 20,
    ));

    // Description Text
    $wp_customize->add_setting('nirup_sustainability_description', array(
        'default'           => __('Nirup Island has been designed with sustainability at its core. Every aspect of the resort — from building design to energy, water, and community engagement — is crafted to harmonize with nature while offering a refined guest experience.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('nirup_sustainability_description', array(
        'label'       => __('Description Text', 'nirup-island'),
        'description' => __('Paragraph text below the hero title', 'nirup-island'),
        'section'     => 'nirup_sustainability_page',
        'type'        => 'textarea',
        'priority'    => 30,
    ));

    // Gallery Images
    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("nirup_sustainability_gallery_image_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'absint',
            'transport'         => 'refresh',
        ));

        $description = '';
        if ($i === 1) {
            $description = __('Large gallery image (left side)', 'nirup-island');
        } elseif ($i === 2) {
            $description = __('Top right gallery image', 'nirup-island');
        } elseif ($i === 3) {
            $description = __('Bottom left small gallery image', 'nirup-island');
        } else {
            $description = __('Bottom right small gallery image', 'nirup-island');
        }

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "nirup_sustainability_gallery_image_{$i}", array(
            'label'       => sprintf(__('Gallery Image %d', 'nirup-island'), $i),
            'description' => $description,
            'section'     => 'nirup_sustainability_page',
            'mime_type'   => 'image',
            'priority'    => 30 + $i,
        )));
    }

    // Practices Section Title
    $wp_customize->add_setting('nirup_sustainability_practices_title', array(
        'default'           => __('Key Sustainability Practices', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('nirup_sustainability_practices_title', array(
        'label'    => __('Practices Section Title', 'nirup-island'),
        'section'  => 'nirup_sustainability_page',
        'type'     => 'text',
        'priority' => 50,
    ));

    // Practice Items (8 practices with exact content)
    $default_practices = array(
        1 => array(
            'title' => 'Building Design',
            'desc1' => 'Passive cooling & natural airflow',
            'desc2' => 'Energy-efficient architecture'
        ),
        2 => array(
            'title' => 'Renewable Energy',
            'desc1' => '1 MW solar panels',
            'desc2' => 'Reducing fossil fuel reliance'
        ),
        3 => array(
            'title' => 'Water Conservation',
            'desc1' => '20,000 m³ rainwater reservoir',
            'desc2' => 'Recycling & efficient fixtures'
        ),
        4 => array(
            'title' => 'Waste Management',
            'desc1' => 'Recycling & composting',
            'desc2' => 'Food scraps into fertilizer'
        ),
        5 => array(
            'title' => 'Green Landscaping',
            'desc1' => 'Native, drought-resistant plants',
            'desc2' => 'Low-maintenance greenery'
        ),
        6 => array(
            'title' => 'Sustainable Transportation',
            'desc1' => 'Electric buggies on island',
            'desc2' => 'Bicycles for eco-exploration'
        ),
        7 => array(
            'title' => 'Environmental Education',
            'desc1' => 'Water refill stations',
            'desc2' => 'Guest eco-awareness programs'
        ),
        8 => array(
            'title' => 'Local Sourcing & Community',
            'desc1' => 'Local ingredients & materials',
            'desc2' => 'Jobs for nearby communities'
        ),
    );

    for ($i = 1; $i <= 8; $i++) {
        // Practice Title
        $wp_customize->add_setting("nirup_sustainability_practice_{$i}_title", array(
            'default'           => isset($default_practices[$i]) ? $default_practices[$i]['title'] : '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ));

        $wp_customize->add_control("nirup_sustainability_practice_{$i}_title", array(
            'label'    => sprintf(__('Practice %d Title', 'nirup-island'), $i),
            'section'  => 'nirup_sustainability_page',
            'type'     => 'text',
            'priority' => 50 + ($i * 3) - 2,
        ));

        // Practice Description 1
        $wp_customize->add_setting("nirup_sustainability_practice_{$i}_desc1", array(
            'default'           => isset($default_practices[$i]) ? $default_practices[$i]['desc1'] : '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ));

        $wp_customize->add_control("nirup_sustainability_practice_{$i}_desc1", array(
            'label'    => sprintf(__('Practice %d Description 1', 'nirup-island'), $i),
            'section'  => 'nirup_sustainability_page',
            'type'     => 'text',
            'priority' => 50 + ($i * 3) - 1,
        ));

        // Practice Description 2
        $wp_customize->add_setting("nirup_sustainability_practice_{$i}_desc2", array(
            'default'           => isset($default_practices[$i]) ? $default_practices[$i]['desc2'] : '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ));

        $wp_customize->add_control("nirup_sustainability_practice_{$i}_desc2", array(
            'label'    => sprintf(__('Practice %d Description 2', 'nirup-island'), $i),
            'section'  => 'nirup_sustainability_page',
            'type'     => 'text',
            'priority' => 50 + ($i * 3),
        ));
    }
}
add_action('customize_register', 'nirup_sustainability_customizer');

function nirup_sustainability_customize_preview_js() {
    wp_enqueue_script(
        'nirup-sustainability-customize-preview',
        get_template_directory_uri() . '/assets/js/customize-preview-sustainability.js',
        array('customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'nirup_sustainability_customize_preview_js');

function nirup_dining_archive_customizer($wp_customize) {
    // Dining Archive Section
    $wp_customize->add_section('nirup_dining_archive', array(
        'title' => __('Dining Archive Page', 'nirup-island'),
        'priority' => 42,
        'description' => __('Customize the dining archive page content', 'nirup-island'),
    ));

    // Hero Section Settings
    $wp_customize->add_setting('dining_hero_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'dining_hero_image', array(
        'label' => __('Hero Background Image', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'settings' => 'dining_hero_image',
    )));

    $wp_customize->add_setting('dining_hero_alt', array(
        'default' => __('Dining Experience', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_hero_alt', array(
        'label' => __('Hero Image Alt Text', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_hero_subtitle', array(
        'default' => __('Welcome to our restaurants', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_hero_title', array(
        'default' => __('Savor Royal Flavors', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_hero_title', array(
        'label' => __('Hero Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    // About Section Settings
    $wp_customize->add_setting('dining_about_category', array(
        'default' => __('About the dining', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_about_category', array(
        'label' => __('About Section Category', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_about_title', array(
        'default' => __('Celebrate The Art of Dining', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_about_title', array(
        'label' => __('About Section Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_about_description', array(
        'default' => __('Step into a world where fine cuisine and refined ambiance come together. Our restaurants feature signature dishes crafted by world-class chefs, complemented by curated wine collections and exceptional service. From intimate dinners to grand celebrations, every detail is designed to create an unforgettable dining journey.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('dining_about_description', array(
        'label' => __('About Section Description', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'textarea',
    ));

    // Feature Icons Section
    // Icon 1 - Fresh Products
    $wp_customize->add_setting('dining_icon1_title', array(
        'default' => __('Fresh Products', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_icon1_title', array(
        'label' => __('Icon 1 - Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_icon1_description', array(
        'default' => __('Carefully selected ingredients from trusted suppliers.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('dining_icon1_description', array(
        'label' => __('Icon 1 - Description', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'textarea',
    ));

    // Icon 2 - Skilled Chefs
    $wp_customize->add_setting('dining_icon2_title', array(
        'default' => __('Skilled Chefs', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_icon2_title', array(
        'label' => __('Icon 2 - Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_icon2_description', array(
        'default' => __('Masters of their craft, creating culinary perfection.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('dining_icon2_description', array(
        'label' => __('Icon 2 - Description', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'textarea',
    ));

    // Icon 3 - Unique Recipes
    $wp_customize->add_setting('dining_icon3_title', array(
        'default' => __('Unique Recipes', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_icon3_title', array(
        'label' => __('Icon 3 - Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_icon3_description', array(
        'default' => __('Signature dishes you won\'t find anywhere else.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('dining_icon3_description', array(
        'label' => __('Icon 3 - Description', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'textarea',
    ));

    // Icon 4 - Premium Service
    $wp_customize->add_setting('dining_icon4_title', array(
        'default' => __('Premium Service', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('dining_icon4_title', array(
        'label' => __('Icon 4 - Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('dining_icon4_description', array(
        'default' => __('Attentive staff making every detail matter.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('dining_icon4_description', array(
        'label' => __('Icon 4 - Description', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'textarea',
    ));

    // Signature Experiences Section
    $wp_customize->add_setting('signature_experiences_category', array(
        'default' => __('For Connoisseurs', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('signature_experiences_category', array(
        'label' => __('Signature Experiences Category', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    $wp_customize->add_setting('signature_experiences_title', array(
        'default' => __('Signature Experience', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('signature_experiences_title', array(
        'label' => __('Signature Experiences Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

      // Toggle to show/hide signature experiences section
    $wp_customize->add_setting('show_signature_experiences', array(
        'default' => true, // Show by default
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('show_signature_experiences', array(
        'label' => __('Show Signature Experiences Section', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'checkbox',
        'description' => __('Check to display the signature experiences section on the dining page.', 'nirup-island'),
    ));

    // Existing signature experiences category setting
    $wp_customize->add_setting('signature_experiences_category', array(
        'default' => __('For Connoisseurs', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('signature_experiences_category', array(
        'label' => __('Signature Experiences Category', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));

    // Existing signature experiences title setting  
    $wp_customize->add_setting('signature_experiences_title', array(
        'default' => __('Signature Experience', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('signature_experiences_title', array(
        'label' => __('Signature Experiences Title', 'nirup-island'),
        'section' => 'nirup_dining_archive',
        'type' => 'text',
    ));
}
add_action('customize_register', 'nirup_dining_archive_customizer');

function nirup_booking_modal_customizer($wp_customize) {
    // Booking Modal Section
    $wp_customize->add_section('nirup_booking_modal', array(
        'title' => __('Booking Modal', 'nirup-island'),
        'priority' => 22,
        'description' => __('Customize the booking modal content and images', 'nirup-island'),
    ));

    // Modal Title
    $wp_customize->add_setting('nirup_booking_modal_title', array(
        'default' => __('BOOK YOUR STAY', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_modal_title', array(
        'label' => __('Modal Title', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'text',
    ));

    // --- RESORT HOTEL SECTION ---
    
    // Resort Label
    $wp_customize->add_setting('nirup_booking_resort_label', array(
        'default' => __('RESORT HOTEL', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_resort_label', array(
        'label' => __('Resort Label', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'text',
        'description' => __('Small label above resort name', 'nirup-island'),
    ));

    // Resort Name
    $wp_customize->add_setting('nirup_booking_resort_name', array(
        'default' => __('The Westin Nirup Island Resort & Spa', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_resort_name', array(
        'label' => __('Resort Name', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'text',
    ));

    // Resort Description
    $wp_customize->add_setting('nirup_booking_resort_description', array(
        'default' => __('Unwind in elegant guest rooms and overwater villas with panoramic sea views. Enjoy Heavenly Spa by Westin™, the WestinWORKOUT® Fitness Studio, and family-friendly Kids Club.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_resort_description', array(
        'label' => __('Resort Description', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'textarea',
        'input_attrs' => array(
            'rows' => 4,
        ),
    ));

    // Resort Button Text
    $wp_customize->add_setting('nirup_booking_resort_button_text', array(
        'default' => __('Book on Westin Website', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_resort_button_text', array(
        'label' => __('Resort Button Text', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'text',
    ));

    // Resort Button Link
    $wp_customize->add_setting('nirup_booking_resort_button_link', array(
        'default' => 'https://www.marriott.com/',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_booking_resort_button_link', array(
        'label' => __('Resort Button Link', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'url',
    ));

    // Resort Image
    $wp_customize->add_setting('nirup_booking_resort_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_booking_resort_image', array(
        'label' => __('Resort Image', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'mime_type' => 'image',
        'description' => __('Recommended size: 896x504px', 'nirup-island'),
    )));

    // --- PRIVATE VILLAS SECTION ---
    
    // Villas Label
    $wp_customize->add_setting('nirup_booking_villas_label', array(
        'default' => __('PRIVATE VILLAS', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_villas_label', array(
        'label' => __('Villas Label', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'text',
        'description' => __('Small label above villas name', 'nirup-island'),
    ));

    // Villas Name
    $wp_customize->add_setting('nirup_booking_villas_name', array(
        'default' => __('Riahi Residences', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_villas_name', array(
        'label' => __('Villas Name', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'text',
    ));

    // Villas Description
    $wp_customize->add_setting('nirup_booking_villas_description', array(
        'default' => __('Spacious 1–4 bedroom villas with private pools and full kitchens. Designed for privacy and comfort, with access to Westin resort amenities and in-villa dining options.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_villas_description', array(
        'label' => __('Villas Description', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'textarea',
        'input_attrs' => array(
            'rows' => 4,
        ),
    ));

    // Villas Button Text
    $wp_customize->add_setting('nirup_booking_villas_button_text', array(
        'default' => __('Book Now', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('nirup_booking_villas_button_text', array(
        'label' => __('Villas Button Text', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'text',
    ));

    // Villas Button Link
    $wp_customize->add_setting('nirup_booking_villas_button_link', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_booking_villas_button_link', array(
        'label' => __('Villas Button Link', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'type' => 'url',
    ));

    // Villas Image
    $wp_customize->add_setting('nirup_booking_villas_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_booking_villas_image', array(
        'label' => __('Villas Image', 'nirup-island'),
        'section' => 'nirup_booking_modal',
        'mime_type' => 'image',
        'description' => __('Recommended size: 896x489px', 'nirup-island'),
    )));
}
add_action('customize_register', 'nirup_booking_modal_customizer');

function nirup_contact_form_customizer($wp_customize) {
    
    // Add Contact Form Section (separate from content)
    $wp_customize->add_section('nirup_contact_form_settings', array(
        'title' => __('Contact Form Settings', 'nirup-island'),
        'priority' => 46,
        'description' => __('Configure email addresses and email content for contact form', 'nirup-island'),
    ));
    
    // ===== EMAIL ADDRESSES =====
    
    // Send FROM Email Setting (noreply address)
    $wp_customize->add_setting('nirup_contact_form_from_email', array(
        'default' => 'explore@nirupisland.com',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_contact_form_from_email', array(
        'label' => __('Send From Email', 'nirup-island'),
        'section' => 'nirup_contact_form_settings',
        'type' => 'email',
        'description' => __('Email address that will appear as the sender (e.g., noreply@yourdomain.com)', 'nirup-island'),
        'priority' => 10,
    ));
    
    // Send TO Email Setting (admin notification)
    $wp_customize->add_setting('nirup_contact_form_email', array(
        'default' => 'explore@nirupisland.com',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_contact_form_email', array(
        'label' => __('Send To Email', 'nirup-island'),
        'section' => 'nirup_contact_form_settings',
        'type' => 'email',
        'description' => __('Email address where contact form submissions will be sent', 'nirup-island'),
        'priority' => 20,
    ));
    
    // ===== USER CONFIRMATION EMAIL CONTENT =====
    
    // Email Subject
    $wp_customize->add_setting('nirup_contact_confirmation_subject', array(
        'default' => __('Thank you for contacting {site_name}', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_contact_confirmation_subject', array(
        'label' => __('Confirmation Email Subject', 'nirup-island'),
        'section' => 'nirup_contact_form_settings',
        'type' => 'text',
        'description' => __('Available tags: {site_name}, {user_name}', 'nirup-island'),
        'priority' => 30,
    ));
    
    // Email Body
    $wp_customize->add_setting('nirup_contact_confirmation_body', array(
        'default' => __("Dear {user_name},\n\nThank you for reaching out to us. We have received your message and our team will review it shortly.\n\nHere's a summary of what you submitted:\n\nType of Inquiry: {inquiry_type}\n\nWe aim to respond within 1-2 business days. If your matter is urgent, please don't hesitate to call us at {phone_number}.\n\nBest regards,\nThe {site_name} Team", 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_contact_confirmation_body', array(
        'label' => __('Confirmation Email Body', 'nirup-island'),
        'section' => 'nirup_contact_form_settings',
        'type' => 'textarea',
        'description' => __('Available tags: {site_name}, {user_name}, {inquiry_type}, {phone_number}, {user_email}, {user_phone}', 'nirup-island'),
        'input_attrs' => array(
            'rows' => 12,
        ),
        'priority' => 40,
    ));
    
    // Email Footer
    $wp_customize->add_setting('nirup_contact_confirmation_footer', array(
        'default' => __("---\nThis is an automated confirmation email. Please do not reply to this message.", 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_contact_confirmation_footer', array(
        'label' => __('Confirmation Email Footer', 'nirup-island'),
        'section' => 'nirup_contact_form_settings',
        'type' => 'textarea',
        'description' => __('Text that appears at the bottom of the confirmation email', 'nirup-island'),
        'input_attrs' => array(
            'rows' => 3,
        ),
        'priority' => 50,
    ));
}
add_action('customize_register', 'nirup_contact_form_customizer');

function nirup_contact_page_customizer($wp_customize) {
    
    $wp_customize->add_section('nirup_contact_page_settings', array(
        'title' => __('Contact Page Content', 'nirup-island'),
        'priority' => 45,
        'description' => __('Customize all text content on the contact page', 'nirup-island'),
    ));
    
    $wp_customize->add_setting('nirup_contact_title', array(
        'default' => __('CONTACT US', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_title', array(
        'label' => __('Page Title', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 10,
    ));
    

    $wp_customize->add_setting('nirup_contact_intro_text', array(
        'default' => __('We welcome your enquiries and are here to assist with every detail of your visit, stay, or event. For urgent matters, please call us at:', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_intro_text', array(
        'label' => __('Introduction Text', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'textarea',
        'priority' => 20,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_phone_label', array(
        'default' => __('General Enquiries:', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_phone_label', array(
        'label' => __('Phone Number Label', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 30,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_closing_text', array(
        'default' => __('For all other requests, please complete the enquiry form below. Our team will review your message and respond within 1-2 business days.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_closing_text', array(
        'label' => __('Closing Text', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'textarea',
        'priority' => 40,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_label_name', array(
        'default' => __('Name*', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_label_name', array(
        'label' => __('Name Field Label', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 50,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_placeholder_name', array(
        'default' => __('Your Name', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_placeholder_name', array(
        'label' => __('Name Field Placeholder', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 60,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_label_email', array(
        'default' => __('E-mail*', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_label_email', array(
        'label' => __('Email Field Label', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 70,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_placeholder_email', array(
        'default' => __('Your E-mail', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_placeholder_email', array(
        'label' => __('Email Field Placeholder', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 80,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_label_phone', array(
        'default' => __('Phone', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_label_phone', array(
        'label' => __('Phone Field Label', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 90,
    ));
    
    
    $wp_customize->add_setting('nirup_contact_placeholder_phone', array(
        'default' => __('Your Phone Number', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_placeholder_phone', array(
        'label' => __('Phone Field Placeholder', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 100,
    ));
    
   
    $wp_customize->add_setting('nirup_contact_label_inquiry', array(
        'default' => __('Type of Enquiry*', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_label_inquiry', array(
        'label' => __('Inquiry Type Label', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 110,
    ));
    

    $wp_customize->add_setting('nirup_contact_placeholder_inquiry', array(
        'default' => __('Choose event type', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_placeholder_inquiry', array(
        'label' => __('Inquiry Type Placeholder', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 120,
    ));
    

    $wp_customize->add_setting('nirup_contact_label_message', array(
        'default' => __('Message*', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_label_message', array(
        'label' => __('Message Field Label', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 130,
    ));
    
    $wp_customize->add_setting('nirup_contact_placeholder_message', array(
        'default' => __('Text your message here', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_placeholder_message', array(
        'label' => __('Message Field Placeholder', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 140,
    ));
    
    $wp_customize->add_setting('nirup_contact_submit_text', array(
        'default' => __('Submit Inquiry', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_submit_text', array(
        'label' => __('Submit Button Text', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 150,
    ));
    

    $wp_customize->add_setting('nirup_contact_modal_title', array(
        'default' => __('THANK YOU!', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_modal_title', array(
        'label' => __('Thank You Modal Title', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 160,
    ));
    
    // Modal Message Line 1
    $wp_customize->add_setting('nirup_contact_modal_message_1', array(
        'default' => __('Your request has been received.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_modal_message_1', array(
        'label' => __('Modal Message Line 1', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 170,
    ));
    
    // Modal Message Line 2
    $wp_customize->add_setting('nirup_contact_modal_message_2', array(
        'default' => __('Our team is at your service', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_modal_message_2', array(
        'label' => __('Modal Message Line 2', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 180,
    ));
    
    // Modal Phone Text
    $wp_customize->add_setting('nirup_contact_modal_phone_text', array(
        'default' => __('For urgent matters, call', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_contact_modal_phone_text', array(
        'label' => __('Modal Phone Text', 'nirup-island'),
        'section' => 'nirup_contact_page_settings',
        'type' => 'text',
        'priority' => 190,
    ));
}
add_action('customize_register', 'nirup_contact_page_customizer');

function nirup_getting_here_page_customizer($wp_customize) {
    
    // Add Getting Here Page Section
    $wp_customize->add_section('nirup_getting_here_page', array(
        'title' => __('Getting Here Page', 'nirup-island'),
        'priority' => 35,
    ));
    
    // ===== HERO SECTION =====
    $wp_customize->add_setting('nirup_getting_here_hero_title', array(
        'default' => __('Getting Here', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_getting_here_hero_title', array(
        'label' => __('Hero Title', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_getting_here_hero_subtitle', array(
        'default' => __('Find the easiest way to reach Nirup Island', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_getting_here_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // ===== FERRY DEPARTURES SECTION =====
    $wp_customize->add_setting('nirup_getting_here_ferry_title', array(
        'default' => __('Ferry Departures', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_getting_here_ferry_title', array(
        'label' => __('Ferry Departures Title', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_getting_here_ferry_subtitle', array(
        'default' => __('Nirup Island is served by direct ferry links from both Singapore & Batam with 12 weekly trips from Singapore and daily trips from Batam.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('nirup_getting_here_ferry_subtitle', array(
        'label' => __('Ferry Departures Subtitle', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'textarea',
    ));
    
    // ===== TAB LABELS =====
    $wp_customize->add_setting('nirup_singapore_to_nirup_tab', array(
        'default' => __('Singapore → Nirup', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_singapore_to_nirup_tab', array(
        'label' => __('Singapore to Nirup Tab', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_nirup_to_singapore_tab', array(
        'default' => __('Nirup → Singapore', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_nirup_to_singapore_tab', array(
        'label' => __('Nirup to Singapore Tab', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_batam_to_nirup_tab', array(
        'default' => __('Batam → Nirup', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_batam_to_nirup_tab', array(
        'label' => __('Batam to Nirup Tab', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_nirup_to_batam_tab', array(
        'default' => __('Nirup → Batam', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_nirup_to_batam_tab', array(
        'label' => __('Nirup to Batam Tab', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_book_ticket_singapore_url', array(
    'default' => '#',
    'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('nirup_book_ticket_singapore_url', array(
        'label' => __('Singapore Ferry - Book Ticket Button URL', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'url',
        'description' => __('URL for the Singapore route booking button', 'nirup-island'),
    ));

    // Batam Ferry Ticket Button URL
    $wp_customize->add_setting('nirup_book_ticket_batam_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('nirup_book_ticket_batam_url', array(
        'label' => __('Batam Ferry - Book Ticket Button URL', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'url',
        'description' => __('URL for the Batam route booking button', 'nirup-island'),
    ));
    
    // ===== DEPARTURE POINTS =====
    $wp_customize->add_setting('nirup_singapore_departure_point', array(
        'default' => __('HarbourFront Centre', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_singapore_departure_point', array(
        'label' => __('Singapore Departure Point', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_batam_departure_point', array(
        'default' => __('HarbourBay Ferry Terminal', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_batam_departure_point', array(
        'label' => __('Batam Departure Point', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_nirup_departure_point', array(
        'default' => __('Nirup Island Ferry Terminal', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_nirup_departure_point', array(
        'label' => __('Nirup Island Departure Point', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // ===== TABLE HEADERS =====
    $wp_customize->add_setting('nirup_ferry_table_route', array(
        'default' => __('Route', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_ferry_table_route', array(
        'label' => __('Table Header: Route', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_ferry_table_etd', array(
        'default' => __('ETD', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_ferry_table_etd', array(
        'label' => __('Table Header: ETD', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_ferry_table_eta', array(
        'default' => __('ETA', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_ferry_table_eta', array(
        'label' => __('Table Header: ETA', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_ferry_table_days', array(
        'default' => __('Days', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_ferry_table_days', array(
        'label' => __('Table Header: Days', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // ===== SIDEBAR LABELS =====
    $wp_customize->add_setting('nirup_sidebar_operator_label', array(
        'default' => __('Operator', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_sidebar_operator_label', array(
        'label' => __('Sidebar Label: Operator', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_sidebar_duration_label', array(
        'default' => __('Duration', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_sidebar_duration_label', array(
        'label' => __('Sidebar Label: Duration', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));

    // Work Days Label
    $wp_customize->add_setting('nirup_sidebar_workdays_label', array(
        'default' => __('Work Days', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_sidebar_workdays_label', array(
        'label' => __('Sidebar: "Work Days" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for work days in the sidebar', 'nirup-island'),
    ));
    
    // Price Label
    $wp_customize->add_setting('nirup_sidebar_price_label', array(
        'default' => __('Price', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_sidebar_price_label', array(
        'label' => __('Sidebar: "Price" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for price in the sidebar', 'nirup-island'),
    ));
    
    // ===== SINGAPORE SIDEBAR VALUES =====
    
    // Singapore Work Days
    $wp_customize->add_setting('nirup_singapore_workdays', array(
        'default' => __('Friday – Sunday', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_singapore_workdays', array(
        'label' => __('Singapore: Work Days', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Operating days for Singapore route', 'nirup-island'),
    ));
    
    // Singapore Price
    $wp_customize->add_setting('nirup_singapore_price', array(
        'default' => __('SGD 76 /per way', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_singapore_price', array(
        'label' => __('Singapore: Price', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Price for Singapore route', 'nirup-island'),
    ));
    
    // ===== BATAM SIDEBAR VALUES =====
    
    // Batam Work Days
    $wp_customize->add_setting('nirup_batam_workdays', array(
        'default' => __('Daily / Friday – Sunday', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_batam_workdays', array(
        'label' => __('Batam: Work Days', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Operating days for Batam route', 'nirup-island'),
    ));
    
    // Batam Price
    $wp_customize->add_setting('nirup_batam_price', array(
        'default' => __('Rp150,000 /per way', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_batam_price', array(
        'label' => __('Batam: Price', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Price for Batam route', 'nirup-island'),
    ));
    
    // ===== CHECK-IN VALUES FOR ROUTES =====
    
    // Singapore to Nirup Check-in
    $wp_customize->add_setting('nirup_singapore_to_nirup_checkin', array(
        'default' => __('Horizon Fast Ferry Counter (Harbour Front Centre, #03-47)', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_singapore_to_nirup_checkin', array(
        'label' => __('Singapore to Nirup: Check-in Location', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Check-in location for Singapore to Nirup route', 'nirup-island'),
    ));
    
    
    // Batam to Nirup Check-in
    $wp_customize->add_setting('nirup_batam_to_nirup_checkin', array(
        'default' => __('Horizon Fast Ferry counter (Bayfront Mall, 2nd floor)', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_batam_to_nirup_checkin', array(
        'label' => __('Batam to Nirup: Check-in Location', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Check-in location for Batam to Nirup route', 'nirup-island'),
    ));
    
    
    $wp_customize->add_setting('nirup_sidebar_checkin_label', array(
        'default' => __('Check In', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_sidebar_checkin_label', array(
        'label' => __('Sidebar Label: Check In', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // ===== SIDEBAR VALUES - SINGAPORE =====
    $wp_customize->add_setting('nirup_singapore_operator', array(
        'default' => __('Sindo Ferry', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_singapore_operator', array(
        'label' => __('Singapore Operator', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_singapore_duration', array(
        'default' => __('1 hr', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_singapore_duration', array(
        'label' => __('Singapore Duration', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // ===== SIDEBAR VALUES - BATAM =====
    $wp_customize->add_setting('nirup_batam_operator', array(
        'default' => __('Sindo Ferry', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_batam_operator', array(
        'label' => __('Batam Operator', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_batam_duration', array(
        'default' => __('20 min', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_batam_duration', array(
        'label' => __('Batam Duration', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    
    // ===== BOOK TICKET BUTTON =====
    $wp_customize->add_setting('nirup_book_ticket_text', array(
        'default' => __('Book Your Ticket', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_book_ticket_text', array(
        'label' => __('Book Ticket Button Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // ===== LUGGAGE SECTION =====
    $wp_customize->add_setting('nirup_getting_here_luggage_title', array(
        'default' => __('Luggage Information', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_getting_here_luggage_title', array(
        'label' => __('Luggage Section Title', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_luggage_singapore_title', array(
        'default' => __('Singapore Departure', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_title', array(
        'label' => __('Luggage: Singapore Title', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));

    // Singapore Free Label
    $wp_customize->add_setting('nirup_luggage_singapore_free_label', array(
        'default' => __('Free', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_free_label', array(
        'label' => __('Singapore: "Free" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for free luggage allowance', 'nirup-island'),
    ));
    
    // Singapore Check-in Label
    $wp_customize->add_setting('nirup_luggage_singapore_checkin_label', array(
        'default' => __('Check-in', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_checkin_label', array(
        'label' => __('Singapore: "Check-in" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for check-in time', 'nirup-island'),
    ));
    
    // Singapore Excess Label
    $wp_customize->add_setting('nirup_luggage_singapore_excess_label', array(
        'default' => __('Excess', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_excess_label', array(
        'label' => __('Singapore: "Excess" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for excess luggage fees', 'nirup-island'),
    ));
    
    // Singapore Counters Label
    $wp_customize->add_setting('nirup_luggage_singapore_counters_label', array(
        'default' => __('Counters', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_counters_label', array(
        'label' => __('Singapore: "Counters" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for counter location', 'nirup-island'),
    ));
    
    
    // Singapore Free Luggage Text
    $wp_customize->add_setting('nirup_luggage_singapore_free', array(
        'default' => __('20 kg / boarding pass', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_free', array(
        'label' => __('Singapore: Free Luggage Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Free luggage allowance for Singapore departure', 'nirup-island'),
    ));
    
    // Singapore Check-in Text
    $wp_customize->add_setting('nirup_luggage_singapore_checkin', array(
        'default' => __('60–20 min before departure', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_checkin', array(
        'label' => __('Singapore: Check-in Time Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Check-in time for Singapore departure', 'nirup-island'),
    ));
    
    // Singapore Excess Luggage Text
    $wp_customize->add_setting('nirup_luggage_singapore_excess', array(
        'default' => __('$1 per kg (max 40 kg)', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_excess', array(
        'label' => __('Singapore: Excess Luggage Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Excess luggage fees for Singapore departure', 'nirup-island'),
    ));
    
    // Singapore Counters Text
    $wp_customize->add_setting('nirup_luggage_singapore_counters', array(
        'default' => __('Next to immigration gate', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_singapore_counters', array(
        'label' => __('Singapore: Counter Location Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Counter location for Singapore departure', 'nirup-island'),
    ));
    
    $wp_customize->add_setting('nirup_luggage_batam_title', array(
        'default' => __('Batam Departure', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_title', array(
        'label' => __('Luggage: Batam Title', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // Batam Free Label
    $wp_customize->add_setting('nirup_luggage_batam_free_label', array(
        'default' => __('Free', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_free_label', array(
        'label' => __('Batam: "Free" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for free luggage allowance', 'nirup-island'),
    ));
    
    // Batam Check-in Label
    $wp_customize->add_setting('nirup_luggage_batam_checkin_label', array(
        'default' => __('Check-in', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_checkin_label', array(
        'label' => __('Batam: "Check-in" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for check-in time', 'nirup-island'),
    ));
    
    // Batam Excess Label
    $wp_customize->add_setting('nirup_luggage_batam_excess_label', array(
        'default' => __('Excess', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_excess_label', array(
        'label' => __('Batam: "Excess" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for excess luggage fees', 'nirup-island'),
    ));
    
    // Batam Counters Label
    $wp_customize->add_setting('nirup_luggage_batam_counters_label', array(
        'default' => __('Counters', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_counters_label', array(
        'label' => __('Batam: "Counters" Label', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Label for counter location', 'nirup-island'),
    ));
    
    // ===== BATAM LUGGAGE VALUES =====
    
    // Batam Free Luggage Text
    $wp_customize->add_setting('nirup_luggage_batam_free', array(
        'default' => __('20 kg / boarding pass', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_free', array(
        'label' => __('Batam: Free Luggage Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Free luggage allowance for Batam departure', 'nirup-island'),
    ));
    
    // Batam Check-in Text
    $wp_customize->add_setting('nirup_luggage_batam_checkin', array(
        'default' => __('60–20 min before departure', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_checkin', array(
        'label' => __('Batam: Check-in Time Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Check-in time for Batam departure', 'nirup-island'),
    ));
    
    // Batam Excess Luggage Text
    $wp_customize->add_setting('nirup_luggage_batam_excess', array(
        'default' => __('$1 per kg (max 40 kg)', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_excess', array(
        'label' => __('Batam: Excess Luggage Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Excess luggage fees for Batam departure', 'nirup-island'),
    ));
    
    // Batam Counters Text
    $wp_customize->add_setting('nirup_luggage_batam_counters', array(
        'default' => __('Next to immigration gate', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_luggage_batam_counters', array(
        'label' => __('Batam: Counter Location Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
        'description' => __('Counter location for Batam departure', 'nirup-island'),
    ));
    
    // ===== VISA SECTION =====
    $wp_customize->add_setting('nirup_getting_here_visa_title', array(
        'default' => __('Visa Requirements', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_getting_here_visa_title', array(
        'label' => __('Visa Section Title', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_getting_here_visa_subtitle', array(
        'default' => __('Entering Nirup Island follows the same process as any Indonesian island.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_getting_here_visa_subtitle', array(
        'label' => __('Visa Section Subtitle', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    // $wp_customize->add_setting('nirup_visa_free_text', array(
    //     'default' => __('Visa Free Countries', 'nirup-island'),
    //     'sanitize_callback' => 'sanitize_text_field',
    // ));
    // $wp_customize->add_control('nirup_visa_free_text', array(
    //     'label' => __('Visa Free Button Text', 'nirup-island'),
    //     'section' => 'nirup_getting_here_page',
    //     'type' => 'text',
    // ));
    
    // $wp_customize->add_setting('nirup_visa_free_url', array(
    //     'default' => '#',
    //     'sanitize_callback' => 'esc_url_raw',
    // ));
    // $wp_customize->add_control('nirup_visa_free_url', array(
    //     'label' => __('Visa Free Button URL', 'nirup-island'),
    //     'section' => 'nirup_getting_here_page',
    //     'type' => 'url',
    // ));
    
    $wp_customize->add_setting('nirup_visa_on_arrival_text', array(
        'default' => __('Visa-On-Arrival Countries', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nirup_visa_on_arrival_text', array(
        'label' => __('Visa On Arrival Button Text', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('nirup_visa_on_arrival_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('nirup_visa_on_arrival_url', array(
        'label' => __('Visa On Arrival Button URL', 'nirup-island'),
        'section' => 'nirup_getting_here_page',
        'type' => 'url',
    ));
}
add_action('customize_register', 'nirup_getting_here_page_customizer');

function nirup_private_events_customizer($wp_customize) {
    
    // ===========================
    // PRIVATE EVENTS PAGE CONTENT
    // ===========================
    
    $wp_customize->add_section('nirup_private_events_content', array(
        'title' => __('Private Events Page Content', 'nirup-island'),
        'priority' => 47,
        'description' => __('Customize all text and images on the private events page', 'nirup-island'),
    ));
    
    // Page Title
    $wp_customize->add_setting('nirup_private_events_title', array(
        'default' => __('PRIVATE EVENTS', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_private_events_title', array(
        'label' => __('Page Title', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 10,
    ));
    
    // Hero Image
    $wp_customize->add_setting('nirup_private_events_hero_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_private_events_hero_image', array(
        'label' => __('Hero Background Image', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'mime_type' => 'image',
        'priority' => 15,
    )));
    
    // Hero Subtitle
    $wp_customize->add_setting('nirup_private_events_hero_subtitle', array(
        'default' => __('Versatile venues where elegance meets island beauty — ideal for meetings, weddings, and celebrations', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_private_events_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'textarea',
        'priority' => 20,
    ));
    
    // Section Title
    $wp_customize->add_setting('nirup_private_events_section_title', array(
        'default' => __('EVENTS', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_private_events_section_title', array(
        'label' => __('Section Title', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 25,
    ));
    
    // Section Description
    $wp_customize->add_setting('nirup_private_events_section_description', array(
        'default' => __('Versatile venues for weddings, meetings, and private celebrations on Nirup Island, offering elegant spaces, breathtaking views, and tailored experiences to make every event truly unforgettable.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_private_events_section_description', array(
        'label' => __('Section Description', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'textarea',
        'priority' => 26,
    ));
    
    // ===========================
    // CARD 1: BALLROOM
    // ===========================
    
    $wp_customize->add_setting('nirup_event_ballroom_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_event_ballroom_image', array(
        'label' => __('Ballroom - Image', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'mime_type' => 'image',
        'priority' => 30,
    )));
    
    $wp_customize->add_setting('nirup_event_ballroom_location', array(
        'default' => __('Westin Nirup Island Resort & Spa', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_ballroom_location', array(
        'label' => __('Ballroom - Venue Name', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 31,
    ));
    
    $wp_customize->add_setting('nirup_event_ballroom_title', array(
        'default' => __('BALLROOM', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_ballroom_title', array(
        'label' => __('Ballroom - Title', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 32,
    ));
    
    $wp_customize->add_setting('nirup_event_ballroom_description', array(
        'default' => __('Celebrate life\'s most important moments at Nirup Island\'s elegant ballroom. Perfect for weddings, anniversaries, and milestone events, the ballroom offers a pillarless 450 sqm space that can be transformed to match your vision. With breathtaking views and access to the island\'s unique venues, your celebration becomes truly unforgettable.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_ballroom_description', array(
        'label' => __('Ballroom - Description', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'textarea',
        'priority' => 33,
    ));
    
    // ===========================
    // CARD 2: MEETING ROOMS
    // ===========================
    
    $wp_customize->add_setting('nirup_event_meeting_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_event_meeting_image', array(
        'label' => __('Meeting Rooms - Image', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'mime_type' => 'image',
        'priority' => 40,
    )));
    
    $wp_customize->add_setting('nirup_event_meeting_location', array(
        'default' => __('Westin Nirup Island Resort & Spa', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_meeting_location', array(
        'label' => __('Meeting Rooms - Venue Name', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 41,
    ));
    
    $wp_customize->add_setting('nirup_event_meeting_title', array(
        'default' => __('MEETING ROOMS', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_meeting_title', array(
        'label' => __('Meeting Rooms - Title', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 42,
    ));
    
    $wp_customize->add_setting('nirup_event_meeting_description', array(
        'default' => __('Designed for productivity and collaboration, our meeting rooms combine a professional setting with the island\'s calming atmosphere. Ideal for board meetings, team workshops, or small conferences, each space offers flexible layouts, modern amenities, and the option to be combined for larger gatherings.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_meeting_description', array(
        'label' => __('Meeting Rooms - Description', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'textarea',
        'priority' => 43,
    ));
    
    // ===========================
    // CARD 3: WEDDINGS
    // ===========================
    
    $wp_customize->add_setting('nirup_event_wedding_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_event_wedding_image', array(
        'label' => __('Weddings - Image', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'mime_type' => 'image',
        'priority' => 50,
    )));
    
    $wp_customize->add_setting('nirup_event_wedding_location', array(
        'default' => __('Nirup Island', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_wedding_location', array(
        'label' => __('Weddings - Venue Name', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 51,
    ));
    
    $wp_customize->add_setting('nirup_event_wedding_title', array(
        'default' => __('WEDDINGS', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_wedding_title', array(
        'label' => __('Weddings - Title', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'text',
        'priority' => 52,
    ));
    
    $wp_customize->add_setting('nirup_event_wedding_description', array(
        'default' => __('Exchange vows against the backdrop of shimmering waters and lush landscapes. Nirup Island offers an enchanting setting for weddings of every scale — from intimate ceremonies to grand celebrations. Our team perfects every detail—from custom décor to curated dining—creating memories that last a lifetime.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_event_wedding_description', array(
        'label' => __('Weddings - Description', 'nirup-island'),
        'section' => 'nirup_private_events_content',
        'type' => 'textarea',
        'priority' => 53,
    ));
    
    // ===========================
    // FORM SECTION
    // ===========================
    
    $wp_customize->add_section('nirup_private_events_form_settings', array(
        'title' => __('Private Events Form Settings', 'nirup-island'),
        'priority' => 48,
    ));
    
    // Form Title
    $wp_customize->add_setting('nirup_private_events_form_title', array(
        'default' => __('INQUIRE ABOUT AN EVENT', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_private_events_form_title', array(
        'label' => __('Form Section Title', 'nirup-island'),
        'section' => 'nirup_private_events_form_settings',
        'type' => 'text',
        'priority' => 10,
    ));
    
    // Form Description
    $wp_customize->add_setting('nirup_private_events_form_description', array(
        'default' => __('Ready to create an unforgettable experience? Get in touch with our team today to start planning your event.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_private_events_form_description', array(
        'label' => __('Form Section Description', 'nirup-island'),
        'section' => 'nirup_private_events_form_settings',
        'type' => 'textarea',
        'priority' => 15,
    ));
    
    // Admin Recipient Email
    $wp_customize->add_setting('nirup_private_events_form_email', array(
        'default' => 'explore@nirupisland.com',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_private_events_form_email', array(
        'label' => __('Admin Recipient Email', 'nirup-island'),
        'description' => __('Where event inquiries will be sent', 'nirup-island'),
        'section' => 'nirup_private_events_form_settings',
        'type' => 'email',
        'priority' => 20,
    ));
    
    // From Email Address
    $wp_customize->add_setting('nirup_private_events_form_from_email', array(
        'default' => 'explore@nirupisland.com',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_private_events_form_from_email', array(
        'label' => __('From Email Address', 'nirup-island'),
        'description' => __('Email address that will appear in the "From" field', 'nirup-island'),
        'section' => 'nirup_private_events_form_settings',
        'type' => 'email',
        'priority' => 25,
    ));
    
    // Confirmation Email Subject
    $wp_customize->add_setting('nirup_private_events_confirmation_subject', array(
        'default' => __('Thank you for your event inquiry - {site_name}', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_private_events_confirmation_subject', array(
        'label' => __('Confirmation Email Subject', 'nirup-island'),
        'section' => 'nirup_private_events_form_settings',
        'type' => 'text',
        'description' => __('Available tag: {site_name}', 'nirup-island'),
        'priority' => 30,
    ));
    
    // Confirmation Email Body
    $wp_customize->add_setting('nirup_private_events_confirmation_body', array(
        'default' => __("Dear {user_name},\n\nThank you for your interest in hosting your event at {site_name}. We have received your request and our events team is reviewing the details.\n\nEvent Request Summary:\nEvent Type: {event_type}\nPreferred Date: {event_date}\nExpected Guests: {guest_count}\n\nOur events coordinator will contact you within 1-2 business days with a customized proposal tailored to your needs.\n\nIf you have any immediate questions, please don't hesitate to call us at {phone_number}.\n\nWe look forward to making your event extraordinary!\n\nWarm regards,\nThe {site_name} Events Team", 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_private_events_confirmation_body', array(
        'label' => __('Confirmation Email Body', 'nirup-island'),
        'section' => 'nirup_private_events_form_settings',
        'type' => 'textarea',
        'description' => __('Available tags: {site_name}, {user_name}, {event_type}, {event_date}, {guest_count}, {phone_number}', 'nirup-island'),
        'input_attrs' => array(
            'rows' => 12,
        ),
        'priority' => 40,
    ));
    
    // Confirmation Email Footer
    $wp_customize->add_setting('nirup_private_events_confirmation_footer', array(
        'default' => __("---\nThis is an automated confirmation email. Please do not reply to this message.", 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_private_events_confirmation_footer', array(
        'label' => __('Confirmation Email Footer', 'nirup-island'),
        'section' => 'nirup_private_events_form_settings',
        'type' => 'textarea',
        'input_attrs' => array(
            'rows' => 3,
        ),
        'priority' => 50,
    ));

    // ===========================
// MODAL SETTINGS
// ===========================

$wp_customize->add_section('nirup_private_events_modal_settings', array(
    'title' => __('Private Events Thank You Modal', 'nirup-island'),
    'priority' => 49,
    'description' => __('Customize the thank you modal that appears after form submission', 'nirup-island'),
));

// Preview Modal Toggle (hidden setting, just for preview)
$wp_customize->add_setting('nirup_private_events_modal_preview', array(
    'default' => false,
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_validate_boolean',
));

$wp_customize->add_control('nirup_private_events_modal_preview', array(
    'label' => __('👁️ Show Modal Preview', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'checkbox',
    'priority' => 5,
    'description' => __('Check this box to preview the modal while editing', 'nirup-island'),
));

// Modal Title
$wp_customize->add_setting('nirup_private_events_modal_title', array(
    'default' => __('THANK YOU FOR REACHING OUT', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage',
));

$wp_customize->add_control('nirup_private_events_modal_title', array(
    'label' => __('Modal Title', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'text',
    'priority' => 10,
));

// Modal Intro Text
$wp_customize->add_setting('nirup_private_events_modal_intro', array(
    'default' => __('Your event request has been received. Our team will be in touch within 1-2 business days to discuss your plans in detail and guide you through the possibilities.', 'nirup-island'),
    'sanitize_callback' => 'sanitize_textarea_field',
    'transport' => 'postMessage',
));

$wp_customize->add_control('nirup_private_events_modal_intro', array(
    'label' => __('Modal Intro Text', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'textarea',
    'priority' => 20,
));

// Link 1 - URL
$wp_customize->add_setting('nirup_private_events_modal_link1_url', array(
    'default' => '/dining/',
    'sanitize_callback' => 'esc_url_raw',
    'transport' => 'refresh',
));

$wp_customize->add_control('nirup_private_events_modal_link1_url', array(
    'label' => __('Link 1 - URL', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'url',
    'priority' => 30,
));

// Link 1 - Text
$wp_customize->add_setting('nirup_private_events_modal_link1_text', array(
    'default' => __('Explore our dining experiences', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage',
));

$wp_customize->add_control('nirup_private_events_modal_link1_text', array(
    'label' => __('Link 1 - Text', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'text',
    'priority' => 40,
));

// Link 2 - URL
$wp_customize->add_setting('nirup_private_events_modal_link2_url', array(
    'default' => '/accommodations/',
    'sanitize_callback' => 'esc_url_raw',
    'transport' => 'refresh',
));

$wp_customize->add_control('nirup_private_events_modal_link2_url', array(
    'label' => __('Link 2 - URL', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'url',
    'priority' => 50,
));

// Link 2 - Text
$wp_customize->add_setting('nirup_private_events_modal_link2_text', array(
    'default' => __('Discover accommodation for your guests', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage',
));

$wp_customize->add_control('nirup_private_events_modal_link2_text', array(
    'label' => __('Link 2 - Text', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'text',
    'priority' => 60,
));

// Phone Text
$wp_customize->add_setting('nirup_private_events_modal_phone_text', array(
    'default' => __('Contact us directly for time-sensitive enquiries at +62 811-6220-999', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage',
));

$wp_customize->add_control('nirup_private_events_modal_phone_text', array(
    'label' => __('Phone Link - Text', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'text',
    'priority' => 70,
));

// Phone Number
$wp_customize->add_setting('nirup_private_events_modal_phone_number', array(
    'default' => '+62 811-6220-999',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'refresh',
));

$wp_customize->add_control('nirup_private_events_modal_phone_number', array(
    'label' => __('Phone Number', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'text',
    'description' => __('The actual phone number that will be dialed when clicked', 'nirup-island'),
    'priority' => 80,
));

// Modal Closing Text
$wp_customize->add_setting('nirup_private_events_modal_closing', array(
    'default' => __('We look forward to helping you create an event that is both seamless and memorable.', 'nirup-island'),
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'postMessage',
));

$wp_customize->add_control('nirup_private_events_modal_closing', array(
    'label' => __('Modal Closing Text', 'nirup-island'),
    'section' => 'nirup_private_events_modal_settings',
    'type' => 'text',
    'priority' => 90,
));
}
add_action('customize_register', 'nirup_private_events_customizer');

function nirup_private_events_customizer_preview() {
    wp_enqueue_script(
        'nirup-private-events-customizer-preview',
        get_template_directory_uri() . '/assets/js/private-events-customizer-preview.js',
        array('jquery', 'customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'nirup_private_events_customizer_preview');

function nirup_accommodations_page_customizer($wp_customize) {
    // Accommodations PAGE Section
    $wp_customize->add_section('nirup_accommodations_page', array(
        'title' => __('Accommodations Page', 'nirup-island'),
        'priority' => 36,
        'description' => __('Customize the full accommodations page (not the homepage section)', 'nirup-island'),
    ));

    // === HERO SECTION ===
    
    // Hero Image
    $wp_customize->add_setting('nirup_accommodations_hero_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_accommodations_hero_image', array(
        'label' => __('Hero Background Image', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'mime_type' => 'image',
        'description' => __('Recommended size: 1400x780px', 'nirup-island'),
    )));

    // Hero Title
    $wp_customize->add_setting('nirup_accommodations_hero_title', array(
        'default' => __('ACCOMMODATION', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_accommodations_hero_title', array(
        'label' => __('Hero Title', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('nirup_accommodations_hero_subtitle', array(
        'default' => __('Find your perfect retreat on Nirup Island — from luxurious resort stays to private residences', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('nirup_accommodations_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'textarea',
    ));

    // === RIAHI RESIDENCES SECTION ===
    
    // Riahi Section Title
    $wp_customize->add_setting('nirup_riahi_section_title', array(
        'default' => __('RIAHI RESIDENCES', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_riahi_section_title', array(
        'label' => __('Riahi Section Title', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'text',
    ));

    // Riahi Section Description
    $wp_customize->add_setting('nirup_riahi_section_description', array(
        'default' => __('Riahi Residences offers a tranquil and spacious retreat, with elegantly designed villas featuring fully equipped kitchens and private pools in select units—providing an exclusive sanctuary where guests can enjoy both comfort and privacy. While offering seclusion, the residences remain just a short walk from the island\'s restaurants and the amenities of The Westin Nirup Island Resort & Spa, accessible with day passes.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('nirup_riahi_section_description', array(
        'label' => __('Riahi Section Description', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'textarea',
        'input_attrs' => array(
            'rows' => 6,
        ),
    ));

    // Riahi CTA Text
    $wp_customize->add_setting('nirup_riahi_cta_text', array(
        'default' => __('SEE ALL VILLAS', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_riahi_cta_text', array(
        'label' => __('Riahi CTA Button Text', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'text',
    ));

    // Riahi CTA Link
    $wp_customize->add_setting('nirup_riahi_booking_link', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_riahi_booking_link', array(
        'label' => __('Riahi Booking Link', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'url',
        'description' => __('Link for the Riahi Residences booking button', 'nirup-island'),
    ));

    // === WESTIN SECTION ===
    
    // Westin Section Title
    $wp_customize->add_setting('nirup_westin_section_title', array(
        'default' => __('THE WESTIN NIRUP ISLAND RESORT & SPA', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_westin_section_title', array(
        'label' => __('Westin Section Title', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'text',
    ));

    // Westin Section Description
    $wp_customize->add_setting('nirup_westin_section_description', array(
        'default' => __('Set atop the island\'s hill, each room features beautiful sea views of the Riau Islands. Relax with a soothing spa treatment, enjoy a session in the wellness center, or simply take in the serene surroundings. Families will appreciate the Kids Club, where children can enjoy engaging activities in a safe and fun environment, allowing parents to relax nearby. For those seeking more privacy, the island offers 1 to 3-bedroom villas over the water, each with a private pool, providing direct access to the sea and a closer connection to the island.', 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('nirup_westin_section_description', array(
        'label' => __('Westin Section Description', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'textarea',
        'input_attrs' => array(
            'rows' => 6,
        ),
    ));

    // Westin CTA Text
    $wp_customize->add_setting('nirup_westin_cta_text', array(
        'default' => __('BOOK AT THE WESTIN', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_westin_cta_text', array(
        'label' => __('Westin CTA Button Text', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'text',
    ));

    // Westin CTA Link
    $wp_customize->add_setting('nirup_westin_booking_link', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('nirup_westin_booking_link', array(
        'label' => __('Westin Booking Link', 'nirup-island'),
        'section' => 'nirup_accommodations_page',
        'type' => 'url',
        'description' => __('External link to Westin booking website', 'nirup-island'),
    ));
}
add_action('customize_register', 'nirup_accommodations_page_customizer');

function nirup_customizer_preview_scripts() {
    wp_enqueue_script(
        'nirup-video-customizer-preview',
        get_template_directory_uri() . '/assets/js/video-customizer-preview.js',
        array('jquery', 'customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'nirup_customizer_preview_scripts');

function nirup_riahi_residences_customizer($wp_customize) {
    // Riahi Residences Section
    $wp_customize->add_section('nirup_riahi_residences', array(
        'title' => __('Riahi Residences Page', 'nirup-island'),
        'priority' => 37,
        'description' => __('Customize the Riahi Residences page', 'nirup-island'),
    ));

    // === HERO SECTION ===
    
    // Hero Image
    $wp_customize->add_setting('nirup_riahi_hero_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'nirup_riahi_hero_image', array(
        'label' => __('Hero Background Image', 'nirup-island'),
        'section' => 'nirup_riahi_residences',
        'mime_type' => 'image',
        'description' => __('Recommended size: 1400x780px', 'nirup-island'),
    )));

    // Hero Subtitle
    $wp_customize->add_setting('nirup_riahi_hero_subtitle', array(
        'default' => __('Your Private Island Sanctuary', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_riahi_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'nirup-island'),
        'section' => 'nirup_riahi_residences',
        'type' => 'text',
    ));

    // Hero Title
    $wp_customize->add_setting('nirup_riahi_hero_title', array(
        'default' => __('Riahi Residences', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_riahi_hero_title', array(
        'label' => __('Hero Title', 'nirup-island'),
        'section' => 'nirup_riahi_residences',
        'type' => 'text',
    ));

    // === OVERVIEW SECTION ===
    
    // Overview Heading
    $wp_customize->add_setting('nirup_riahi_overview_heading', array(
        'default' => __('Overview', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('nirup_riahi_overview_heading', array(
        'label' => __('Overview Section Heading', 'nirup-island'),
        'section' => 'nirup_riahi_residences',
        'type' => 'text',
    ));

    $wp_customize->add_setting('nirup_riahi_overview_description', array(
        'default' => __('Riahi Residences offers a tranquil and spacious retreat, with 2 to 4-bedroom villas designed for comfort and privacy. Each unit features a fully equipped kitchen, and some include a private plunge or swimming pool. While offering seclusion, the residences remain just a short distance from the island\'s dining venues and the amenities of The Westin Nirup Island Resort & Spa, accessible with day passes. Guests have the flexibility to dine at various restaurants across the island or prepare their own meals in the comfort of their villa.', 'nirup-island'),
        'sanitize_callback' => 'wp_kses_post',  // Changed from sanitize_textarea_field
    ));

    $wp_customize->add_control('nirup_riahi_overview_description', array(
        'label' => __('Overview Description', 'nirup-island'),
        'section' => 'nirup_riahi_residences',
        'type' => 'textarea',
        'input_attrs' => array(
            'rows' => 6,
        ),
    ));
}
add_action('customize_register', 'nirup_riahi_residences_customizer');

function nirup_media_coverage_customizer($wp_customize) {
    // Media Coverage Section
    $wp_customize->add_section('nirup_media_coverage_page', array(
        'title' => __('Media Coverage Page', 'nirup-island'),
        'priority' => 45,
        'description' => __('Customize the Media Coverage page hero section', 'nirup-island'),
    ));

    // Page Title
    $wp_customize->add_setting('nirup_media_coverage_title', array(
        'default' => __('Media Coverage', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('nirup_media_coverage_title', array(
        'label' => __('Page Title', 'nirup-island'),
        'section' => 'nirup_media_coverage_page',
        'type' => 'text',
        'description' => __('Main heading for the Media Coverage page', 'nirup-island'),
    ));

    // Page Subtitle
    $wp_customize->add_setting('nirup_media_coverage_subtitle', array(
        'default' => __('Stay up to date with how Nirup Island is being recognized', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('nirup_media_coverage_subtitle', array(
        'label' => __('Subtitle Line', 'nirup-island'),
        'section' => 'nirup_media_coverage_page',
        'type' => 'text',
        'description' => __('Subtitle', 'nirup-island'),
    ));


    // Show/Hide Subtitle
    $wp_customize->add_setting('nirup_media_coverage_show_subtitle', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('nirup_media_coverage_show_subtitle', array(
        'label' => __('Show Subtitle', 'nirup-island'),
        'section' => 'nirup_media_coverage_page',
        'type' => 'checkbox',
        'description' => __('Toggle to show/hide the subtitle text', 'nirup-island'),
    ));
}
add_action('customize_register', 'nirup_media_coverage_customizer');

function nirup_press_kit_customizer($wp_customize) {
    
    // Add Press Kit Section
    $wp_customize->add_section('nirup_press_kit', array(
        'title' => __('Press Kit Page', 'nirup-island'),
        'priority' => 90,
    ));

    // Hero Section Settings
    // Subtitle
    $wp_customize->add_setting('press_kit_subtitle', array(
        'default' => 'FOR YOUR MEDIA COVERAGE',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('press_kit_subtitle', array(
        'label' => __('Hero Subtitle', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'text',
    ));

    // Title
    $wp_customize->add_setting('press_kit_title', array(
        'default' => 'Press kit',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('press_kit_title', array(
        'label' => __('Hero Title', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'text',
    ));

    // Description
    $wp_customize->add_setting('press_kit_description', array(
        'default' => 'Welcome to the Nirup Island Press Kit. Here you\'ll find everything you need to cover our story — from official logos and brand assets to high-resolution photos and videos. These materials are free to use for editorial purposes when featuring Nirup Island.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('press_kit_description', array(
        'label' => __('Description Text', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'textarea',
    ));

    // Card 1 - Logos
    // Card 1 Image
    $wp_customize->add_setting('press_kit_card1_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'press_kit_card1_image', array(
        'label' => __('Card 1 - Image', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'settings' => 'press_kit_card1_image',
    )));

    // Card 1 Title
    $wp_customize->add_setting('press_kit_card1_title', array(
        'default' => 'Logos',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('press_kit_card1_title', array(
        'label' => __('Card 1 - Title', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'text',
    ));

    // Card 1 File
    $wp_customize->add_setting('press_kit_card1_file', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'press_kit_card1_file', array(
        'label' => __('Card 1 - Download File (ZIP)', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'settings' => 'press_kit_card1_file',
    )));

    // Card 2 - Photos
    // Card 2 Image
    $wp_customize->add_setting('press_kit_card2_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'press_kit_card2_image', array(
        'label' => __('Card 2 - Image', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'settings' => 'press_kit_card2_image',
    )));

    // Card 2 Title
    $wp_customize->add_setting('press_kit_card2_title', array(
        'default' => 'Photos',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('press_kit_card2_title', array(
        'label' => __('Card 2 - Title', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'text',
    ));

    // Card 2 File
    $wp_customize->add_setting('press_kit_card2_file', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'press_kit_card2_file', array(
        'label' => __('Card 2 - Download File (ZIP)', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'settings' => 'press_kit_card2_file',
    )));

    // Card 3 - Videos
    // Card 3 Image
    $wp_customize->add_setting('press_kit_card3_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'press_kit_card3_image', array(
        'label' => __('Card 3 - Image', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'settings' => 'press_kit_card3_image',
    )));

    // Card 3 Title
    $wp_customize->add_setting('press_kit_card3_title', array(
        'default' => 'Videos',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('press_kit_card3_title', array(
        'label' => __('Card 3 - Title', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'text',
    ));

    // Card 3 File
    $wp_customize->add_setting('press_kit_card3_file', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'press_kit_card3_file', array(
        'label' => __('Card 3 - Download File (ZIP)', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'settings' => 'press_kit_card3_file',
    )));

    // Press Contacts Section
    // Title
    $wp_customize->add_setting('press_kit_contacts_title', array(
        'default' => 'Press Contacts',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('press_kit_contacts_title', array(
        'label' => __('Press Contacts - Title', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'text',
    ));

    // Label
    $wp_customize->add_setting('press_kit_contacts_label', array(
        'default' => 'For media inquiries:',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('press_kit_contacts_label', array(
        'label' => __('Press Contacts - Label', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'text',
    ));

    // Email
    $wp_customize->add_setting('press_kit_contacts_email', array(
        'default' => 'Marcomm@citrabuanaprakarsa.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('press_kit_contacts_email', array(
        'label' => __('Press Contacts - Email', 'nirup-island'),
        'section' => 'nirup_press_kit',
        'type' => 'email',
    ));
}
add_action('customize_register', 'nirup_press_kit_customizer');

function nirup_berthing_form_customizer($wp_customize) {
    // Add Berthing Form Section
    $wp_customize->add_section('nirup_berthing_form_settings', array(
        'title'       => __('Berthing Form Settings', 'nirup-island'),
        'priority'    => 47,
        'description' => __('Configure email addresses and content for the berthing form', 'nirup-island'),
    ));

    // Hero Title
    $wp_customize->add_setting('nirup_berthing_hero_title', array(
        'default'           => __('ARRIVAL NOTICE & BERTH RESERVATION FORM', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_berthing_hero_title', array(
        'label'    => __('Hero Title', 'nirup-island'),
        'section'  => 'nirup_berthing_form_settings',
        'type'     => 'text',
        'priority' => 5,
    ));

    // Hero Description
    $wp_customize->add_setting('nirup_berthing_hero_description', array(
        'default'           => __('Please complete the form in full and provide at least 48 hours\' notice prior to your boat\'s arrival.<br>Our team will review your submission and contact you as soon as possible.<br>For urgent inquiries, please contact the marina at +62 811-6253-888.', 'nirup-island'),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('nirup_berthing_hero_description', array(
        'label'    => __('Hero Description', 'nirup-island'),
        'section'  => 'nirup_berthing_form_settings',
        'type'     => 'textarea',
        'priority' => 10,
    ));

    // Admin Recipient Email
    $wp_customize->add_setting('nirup_berthing_form_email', array(
        'default'           => 'marina@nirupisland.com',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_berthing_form_email', array(
        'label'       => __('Admin Recipient Email', 'nirup-island'),
        'description' => __('Primary email where berthing requests will be sent', 'nirup-island'),
        'section'     => 'nirup_berthing_form_settings',
        'type'        => 'email',
        'priority'    => 20,
    ));

    // CC Email
    $wp_customize->add_setting('nirup_berthing_form_cc_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_berthing_form_cc_email', array(
        'label'       => __('CC Email (Optional)', 'nirup-island'),
        'description' => __('Additional email to receive a copy of berthing requests', 'nirup-island'),
        'section'     => 'nirup_berthing_form_settings',
        'type'        => 'email',
        'priority'    => 25,
    ));

    // From Email Address
    $wp_customize->add_setting('nirup_berthing_form_from_email', array(
        'default'           => 'marina@nirupisland.com',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_berthing_form_from_email', array(
        'label'       => __('From Email Address', 'nirup-island'),
        'description' => __('Email address that will appear in the "From" field', 'nirup-island'),
        'section'     => 'nirup_berthing_form_settings',
        'type'        => 'email',
        'priority'    => 30,
    ));

    // Confirmation Email Subject
    $wp_customize->add_setting('nirup_berthing_confirmation_subject', array(
        'default'           => __('Thank you for your berthing request - {site_name}', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_berthing_confirmation_subject', array(
        'label'       => __('Confirmation Email Subject', 'nirup-island'),
        'description' => __('Available tag: {site_name}', 'nirup-island'),
        'section'     => 'nirup_berthing_form_settings',
        'type'        => 'text',
        'priority'    => 40,
    ));

    // Confirmation Email Body
    $wp_customize->add_setting('nirup_berthing_confirmation_body', array(
        'default'           => __("Dear {contact_name},\n\nThank you for submitting your arrival notice and berth reservation request for {vessel_name}.\n\nOur marina team has received your submission and will review it shortly. We aim to respond within 24 hours with confirmation and berth assignment details.\n\nYour Request Summary:\nVessel: {vessel_name} ({vessel_type})\nArrival Date: {arrival_date}\nArrival Time: {arrival_time}\nLength: {vessel_length}m | Beam: {vessel_beam}m | Draft: {vessel_draft}m\n\nFor urgent inquiries, please contact our marina directly at +62 811-6253-888.\n\nWe look forward to welcoming you to Nirup Island Marina.\n\nBest regards,\n{site_name} Marina Team", 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_berthing_confirmation_body', array(
        'label'       => __('Confirmation Email Body', 'nirup-island'),
        'description' => __('Available tags: {site_name}, {contact_name}, {vessel_name}, {vessel_type}, {vessel_length}, {vessel_beam}, {vessel_draft}, {arrival_date}, {arrival_time}, {departure_date}', 'nirup-island'),
        'section'     => 'nirup_berthing_form_settings',
        'type'        => 'textarea',
        'input_attrs' => array('rows' => 12),
        'priority'    => 50,
    ));

    // Confirmation Email Footer
    $wp_customize->add_setting('nirup_berthing_confirmation_footer', array(
        'default'           => __("---\nThis is an automated confirmation email. Please do not reply to this message.", 'nirup-island'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('nirup_berthing_confirmation_footer', array(
        'label'    => __('Confirmation Email Footer', 'nirup-island'),
        'section'  => 'nirup_berthing_form_settings',
        'type'     => 'textarea',
        'priority' => 60,
    ));
}
add_action('customize_register', 'nirup_berthing_form_customizer');

