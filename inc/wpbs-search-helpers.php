<?php
/**
 * WPBS Search Integration Helper Functions
 * File: inc/wpbs-search-helpers.php
 * 
 * Ensures villa data is properly formatted for WPBS Search Widget display
 */

/**
 * Filter WPBS search results to add custom villa data
 * This ensures the subtitle (villa location) appears correctly
 */
add_filter( 'wpbs_search_result_data', 'nirup_customize_wpbs_search_result', 10, 2 );
function nirup_customize_wpbs_search_result( $result_data, $calendar_id ) {
    
    // Find the villa post associated with this calendar
    $villas = get_posts( array(
        'post_type'      => 'villa',
        'posts_per_page' => 1,
        'meta_query'     => array(
            array(
                'key'   => 'villa_calendar_id',
                'value' => $calendar_id,
            ),
        ),
    ) );
    
    if ( ! empty( $villas ) ) {
        $villa = $villas[0];
        
        // Add villa location as subtitle (e.g., "Riahi Residence, Villa 201")
        $villa_location = get_post_meta( $villa->ID, 'villa_location', true );
        if ( ! empty( $villa_location ) ) {
            $result_data['subtitle'] = $villa_location;
        }
        
        // Ensure featured image is included
        if ( has_post_thumbnail( $villa->ID ) ) {
            $result_data['image'] = get_the_post_thumbnail_url( $villa->ID, 'large' );
        }
        
        // Add villa URL for "Discover More" button
        $result_data['url'] = get_permalink( $villa->ID );
    }
    
    return $result_data;
}

/**
 * Customize WPBS search result HTML output
 * This modifies the button text to match the design
 */
add_filter( 'wpbs_search_result_html', 'nirup_customize_wpbs_result_html', 10, 2 );
function nirup_customize_wpbs_result_html( $html, $result_data ) {
    
    // Replace button text to match Figma design
    // "View" becomes "Discover More"
    $html = str_replace( '>View</', '>Discover More</', $html );
    
    // Ensure "Book Now" button text is correct
    // This might already be "Book Now" but we'll make sure
    $html = str_replace( '>Book</', '>Book Now</', $html );
    
    return $html;
}

/**
 * Add villa location to calendar post meta
 * This makes the location available to WPBS
 */
add_action( 'save_post_villa', 'nirup_sync_villa_location_to_calendar', 20, 1 );
function nirup_sync_villa_location_to_calendar( $post_id ) {
    
    // Skip if autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    // Get villa calendar ID
    $calendar_id = get_post_meta( $post_id, 'villa_calendar_id', true );
    
    if ( empty( $calendar_id ) ) {
        return;
    }
    
    // Get villa location
    $villa_location = get_post_meta( $post_id, 'villa_location', true );
    
    // If using WPBS calendar posts, update the calendar post meta
    if ( post_type_exists( 'wpbs_calendar' ) ) {
        
        $calendar_posts = get_posts( array(
            'post_type'      => 'wpbs_calendar',
            'posts_per_page' => 1,
            'p'              => $calendar_id,
        ) );
        
        if ( ! empty( $calendar_posts ) ) {
            $calendar_post = $calendar_posts[0];
            
            // Store villa location in calendar meta
            update_post_meta( $calendar_post->ID, 'villa_location', $villa_location );
            
            // Store villa ID for reverse lookup
            update_post_meta( $calendar_post->ID, 'villa_post_id', $post_id );
        }
    }
}

/**
 * Ensure villa featured image is used in WPBS results
 */
add_filter( 'wpbs_calendar_featured_image', 'nirup_use_villa_featured_image', 10, 2 );
function nirup_use_villa_featured_image( $image_url, $calendar_id ) {
    
    // Find villa associated with this calendar
    $villas = get_posts( array(
        'post_type'      => 'villa',
        'posts_per_page' => 1,
        'meta_query'     => array(
            array(
                'key'   => 'villa_calendar_id',
                'value' => $calendar_id,
            ),
        ),
    ) );
    
    if ( ! empty( $villas ) && has_post_thumbnail( $villas[0]->ID ) ) {
        return get_the_post_thumbnail_url( $villas[0]->ID, 'large' );
    }
    
    return $image_url;
}

/**
 * Format the starting price display
 */
add_filter( 'wpbs_search_result_price', 'nirup_format_search_result_price', 10, 2 );
function nirup_format_search_result_price( $price_html, $calendar_id ) {
    
    // Find villa for this calendar
    $villas = get_posts( array(
        'post_type'      => 'villa',
        'posts_per_page' => 1,
        'meta_query'     => array(
            array(
                'key'   => 'villa_calendar_id',
                'value' => $calendar_id,
            ),
        ),
    ) );
    
    if ( ! empty( $villas ) ) {
        $villa_id = $villas[0]->ID;
        
        // Get base price from villa meta
        $base_price = get_post_meta( $villa_id, 'villa_base_price', true );
        
        if ( ! empty( $base_price ) ) {
            // Format: "Starting from $XX.XX USD per day."
            $formatted_price = sprintf(
                'Starting from $%s USD per day.',
                number_format( (float) $base_price, 2 )
            );
            
            return '<h3>' . esc_html( $formatted_price ) . '</h3>';
        }
    }
    
    return $price_html;
}