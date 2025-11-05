<?php
/**
 * Experiences Customizer Settings
 * File: inc/customizer-experiences.php
 *
 * Settings for experience pages and booking behavior
 */

function nirup_register_experiences_customizer($wp_customize) {

    // ========================================
    // EXPERIENCES SETTINGS SECTION
    // ========================================
    $wp_customize->add_section('nirup_experiences_settings', array(
        'title'       => __('Experiences Settings', 'nirup-island'),
        'description' => __('Configure settings for experience pages, including booking behavior and alternative text when no calendar is attached.', 'nirup-island'),
        'priority'    => 36,
        'panel'       => '',
    ));

    // ========================================
    // NO CALENDAR ALTERNATIVE TEXT
    // ========================================
    $wp_customize->add_setting('nirup_experience_no_calendar_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_experience_no_calendar_text', array(
        'label'       => __('Alternative Text (No Calendar)', 'nirup-island'),
        'description' => __('Text to display in the CTA section when an experience does not have a booking calendar attached. Leave empty to show no text. The "Book Now" button and booking title will be hidden automatically.', 'nirup-island'),
        'section'     => 'nirup_experiences_settings',
        'type'        => 'textarea',
        'priority'    => 10,
    ));
}
add_action('customize_register', 'nirup_register_experiences_customizer');
