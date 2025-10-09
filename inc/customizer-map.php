<?php
/**
 * Ferry Map Customizer Settings
 * Add this to your inc/customizer.php file or create a new file inc/customizer-map.php
 * 
 * These settings are separate from any specific page/section since the map appears in multiple places
 */

function nirup_register_ferry_map_customizer($wp_customize) {
    
    // ========================================
    // FERRY MAP SETTINGS SECTION
    // ========================================
    $wp_customize->add_section('nirup_ferry_map_settings', array(
        'title'       => __('Ferry Map Settings', 'nirup-island'),
        'description' => __('Configure the interactive ferry map that appears on the homepage and Getting Here page. These settings control map markers, routes, and information displayed.', 'nirup-island'),
        'priority'    => 35, // Adjust as needed
        'panel'       => '', // Leave empty or add to a panel if you have one
    ));

    // ========================================
    // GOOGLE MAPS API
    // ========================================
    $wp_customize->add_setting('nirup_google_maps_api_key', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_google_maps_api_key', array(
        'label'       => __('Google Maps API Key', 'nirup-island'),
        'description' => __('Enter your Google Maps JavaScript API key. Get one at: https://console.cloud.google.com/apis', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'text',
        'priority'    => 10,
    ));

    // ========================================
    // MAP DISPLAY SETTINGS
    // ========================================
    $wp_customize->add_setting('nirup_map_zoom', array(
        'default'           => '10',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_map_zoom', array(
        'label'       => __('Map Zoom Level', 'nirup-island'),
        'description' => __('Default zoom level (1-20). Recommended: 10', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'number',
        'priority'    => 20,
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 20,
            'step' => 1,
        ),
    ));

    $wp_customize->add_setting('nirup_map_style', array(
        'default'           => 'terrain',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_map_style', array(
        'label'       => __('Map Style', 'nirup-island'),
        'description' => __('Choose the map display style', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'select',
        'priority'    => 30,
        'choices'     => array(
            'roadmap'   => __('Roadmap', 'nirup-island'),
            'satellite' => __('Satellite', 'nirup-island'),
            'hybrid'    => __('Hybrid', 'nirup-island'),
            'terrain'   => __('Terrain', 'nirup-island'),
        ),
    ));

    // ========================================
    // NIRUP ISLAND COORDINATES
    // ========================================
    $wp_customize->add_setting('nirup_map_center_lat', array(
        'default'           => '1.1304753',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_map_center_lat', array(
        'label'       => __('Nirup Island - Latitude', 'nirup-island'),
        'description' => __('Center point of the map (Nirup Island location)', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'text',
        'priority'    => 40,
    ));

    $wp_customize->add_setting('nirup_map_center_lng', array(
        'default'           => '104.0266055',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_map_center_lng', array(
        'label'       => __('Nirup Island - Longitude', 'nirup-island'),
        'description' => __('Center point of the map (Nirup Island location)', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'text',
        'priority'    => 50,
    ));

    // ========================================
    // SINGAPORE FERRY TERMINAL
    // ========================================
    $wp_customize->add_setting('nirup_singapore_lat', array(
        'default'           => '1.2650543',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_singapore_lat', array(
        'label'       => __('Singapore Terminal - Latitude', 'nirup-island'),
        'description' => __('HarbourFront Centre coordinates', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'text',
        'priority'    => 60,
    ));

    $wp_customize->add_setting('nirup_singapore_lng', array(
        'default'           => '103.8232508',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_singapore_lng', array(
        'label'       => __('Singapore Terminal - Longitude', 'nirup-island'),
        'description' => __('HarbourFront Centre coordinates', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'text',
        'priority'    => 70,
    ));

    $wp_customize->add_setting('nirup_singapore_ferry_info', array(
        'default'           => __('50 minutes from HarbourFront Centre', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_singapore_ferry_info', array(
        'label'       => __('Singapore Route - Info Text', 'nirup-island'),
        'description' => __('Short description shown on the map overlay', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'text',
        'priority'    => 80,
    ));

    // ========================================
    // BATAM FERRY TERMINAL
    // ========================================
    $wp_customize->add_setting('nirup_batam_lat', array(
        'default'           => '1.1210997',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_batam_lat', array(
        'label'       => __('Batam Terminal - Latitude', 'nirup-island'),
        'description' => __('Harbour Bay Ferry Terminal coordinates', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'text',
        'priority'    => 90,
    ));

    $wp_customize->add_setting('nirup_batam_lng', array(
        'default'           => '104.0538234',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_batam_lng', array(
        'label'       => __('Batam Terminal - Longitude', 'nirup-island'),
        'description' => __('Harbour Bay Ferry Terminal coordinates', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'text',
        'priority'    => 100,
    ));

    $wp_customize->add_setting('nirup_batam_ferry_info', array(
        'default'           => __('20 minutes from Harbour Bay Terminal', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_batam_ferry_info', array(
        'label'       => __('Batam Route - Info Text', 'nirup-island'),
        'description' => __('Short description shown on the map overlay', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'text',
        'priority'    => 110,
    ));

    // ========================================
    // MAP CONTROL BUTTON LABELS
    // ========================================
    $wp_customize->add_setting('nirup_map_btn_singapore', array(
        'default'           => __('Singapore Route', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_map_btn_singapore', array(
        'label'       => __('Button: Singapore Route', 'nirup-island'),
        'description' => __('Text for the Singapore route button', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'text',
        'priority'    => 120,
    ));

    $wp_customize->add_setting('nirup_map_btn_batam', array(
        'default'           => __('Batam Route', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_map_btn_batam', array(
        'label'       => __('Button: Batam Route', 'nirup-island'),
        'description' => __('Text for the Batam route button', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'text',
        'priority'    => 130,
    ));

    $wp_customize->add_setting('nirup_map_btn_view_all', array(
        'default'           => __('View All', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_map_btn_view_all', array(
        'label'       => __('Button: View All Routes', 'nirup-island'),
        'description' => __('Text for the view all routes button', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'text',
        'priority'    => 140,
    ));

    $wp_customize->add_setting('nirup_map_label_from_singapore', array(
        'default'           => __('From Singapore', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_map_label_from_singapore', array(
        'label'       => __('Overlay Label: From Singapore', 'nirup-island'),
        'description' => __('Label shown in the route info overlay', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'text',
        'priority'    => 150,
    ));

    $wp_customize->add_setting('nirup_map_label_from_batam', array(
        'default'           => __('From Batam', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_map_label_from_batam', array(
        'label'       => __('Overlay Label: From Batam', 'nirup-island'),
        'description' => __('Label shown in the route info overlay', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'text',
        'priority'    => 160,
    ));

    $wp_customize->add_setting('nirup_map_loading_text', array(
        'default'           => __('Loading interactive map...', 'nirup-island'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('nirup_map_loading_text', array(
        'label'       => __('Loading Text', 'nirup-island'),
        'description' => __('Text shown while the map is loading', 'nirup-island'),
        'section'     => 'nirup_ferry_map_settings',
        'type'        => 'text',
        'priority'    => 170,
    ));
}
add_action('customize_register', 'nirup_register_ferry_map_customizer');