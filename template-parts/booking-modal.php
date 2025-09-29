<?php
/**
 * Booking Modal Template
 * File: template-parts/booking-modal.php
 * 
 * Reusable modal component for booking accommodations
 */

// Get customizer values for the modal content
$modal_title = get_theme_mod('nirup_booking_modal_title', __('BOOK YOUR STAY', 'nirup-island'));

// Resort Hotel - Left Side
$resort_label = get_theme_mod('nirup_booking_resort_label', __('RESORT HOTEL', 'nirup-island'));
$resort_name = get_theme_mod('nirup_booking_resort_name', __('The Westin Nirup Island Resort & Spa', 'nirup-island'));
$resort_description = get_theme_mod('nirup_booking_resort_description', __('Unwind in elegant guest rooms and overwater villas with panoramic sea views. Enjoy Heavenly Spa by Westin™, the WestinWORKOUT® Fitness Studio, and family-friendly Kids Club.', 'nirup-island'));
$resort_button_text = get_theme_mod('nirup_booking_resort_button_text', __('Book on Westin Website', 'nirup-island'));
$resort_button_link = get_theme_mod('nirup_booking_resort_button_link', 'https://www.marriott.com/');
$resort_image_id = get_theme_mod('nirup_booking_resort_image');
$resort_image_url = $resort_image_id ? wp_get_attachment_image_url($resort_image_id, 'full') : get_template_directory_uri() . '/assets/images/default-resort.jpg';

// Private Villas - Right Side
$villas_label = get_theme_mod('nirup_booking_villas_label', __('PRIVATE VILLAS', 'nirup-island'));
$villas_name = get_theme_mod('nirup_booking_villas_name', __('Riahi Residences', 'nirup-island'));
$villas_description = get_theme_mod('nirup_booking_villas_description', __('Spacious 1–4 bedroom villas with private pools and full kitchens. Designed for privacy and comfort, with access to Westin resort amenities and in-villa dining options.', 'nirup-island'));
$villas_button_text = get_theme_mod('nirup_booking_villas_button_text', __('Book Now', 'nirup-island'));
$villas_button_link = get_theme_mod('nirup_booking_villas_button_link', '#');
$villas_image_id = get_theme_mod('nirup_booking_villas_image');
$villas_image_url = $villas_image_id ? wp_get_attachment_image_url($villas_image_id, 'full') : get_template_directory_uri() . '/assets/images/default-villas.jpg';
?>

<!-- Booking Modal -->
<div id="booking-modal" class="booking-modal" aria-hidden="true" role="dialog" aria-labelledby="booking-modal-title">
    <!-- Modal Backdrop -->
    <div class="booking-modal-backdrop"></div>
    
    <!-- Modal Container -->
    <div class="booking-modal-container" role="document">
        <!-- Close Button -->
        <button class="booking-modal-close" aria-label="<?php _e('Close booking modal', 'nirup-island'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                <circle cx="15" cy="15" r="14.5" stroke="currentColor"/>
                <path d="M10 10L20 20M20 10L10 20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </button>

        <!-- Modal Header -->
        <div class="booking-modal-header">
            <h2 id="booking-modal-title" class="booking-modal-title"><?php echo esc_html($modal_title); ?></h2>
        </div>

        <!-- Modal Content -->
        <div class="booking-modal-content">
            <!-- Left Option: Resort Hotel -->
            <div class="booking-option booking-option-resort">
                <div class="booking-option-image-wrapper">
                    <img src="<?php echo esc_url($resort_image_url); ?>" 
                         alt="<?php echo esc_attr($resort_name); ?>" 
                         class="booking-option-image">
                    <div class="booking-option-overlay"></div>
                </div>
                
                <div class="booking-option-info">
                    <div class="booking-option-labels">
                        <span class="booking-option-label"><?php echo esc_html($resort_label); ?></span>
                        <h3 class="booking-option-name"><?php echo esc_html($resort_name); ?></h3>
                    </div>
                    
                    <div class="booking-option-details">
                        <p class="booking-option-description"><?php echo esc_html($resort_description); ?></p>
                        
                        <a href="<?php echo esc_url($resort_button_link); ?>" 
                           class="booking-option-button" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <span><?php echo esc_html($resort_button_text); ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M1 7H13M13 7L7 1M13 7L7 13" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Vertical Divider -->
            <div class="booking-modal-divider"></div>

            <!-- Right Option: Private Villas -->
            <div class="booking-option booking-option-villas">
                <div class="booking-option-image-wrapper">
                    <img src="<?php echo esc_url($villas_image_url); ?>" 
                         alt="<?php echo esc_attr($villas_name); ?>" 
                         class="booking-option-image">
                    <div class="booking-option-overlay"></div>
                </div>
                
                <div class="booking-option-info">
                    <div class="booking-option-labels">
                        <span class="booking-option-label"><?php echo esc_html($villas_label); ?></span>
                        <h3 class="booking-option-name"><?php echo esc_html($villas_name); ?></h3>
                    </div>
                    
                    <div class="booking-option-details">
                        <p class="booking-option-description"><?php echo esc_html($villas_description); ?></p>
                        
                        <a href="<?php echo esc_url($villas_button_link); ?>" 
                           class="booking-option-button">
                            <span><?php echo esc_html($villas_button_text); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>