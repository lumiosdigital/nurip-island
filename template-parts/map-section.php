<?php
/**
 * Map Section Template Part
 * File: template-parts/map-section.php
 * 
 * Displays an interactive map section with customizable image and pin drops
 */

// Get customizer values
$map_image_id = get_theme_mod('nirup_map_image');
$map_title = get_theme_mod('nirup_map_title', __('Explore Our Island', 'nirup-island'));
$map_subtitle = get_theme_mod('nirup_map_subtitle', __('Discover amazing locations and experiences across Nirup Island', 'nirup-island'));

// Get map image URL
$map_image_url = $map_image_id ? wp_get_attachment_image_url($map_image_id, 'full') : get_template_directory_uri() . '/assets/images/map-placeholder.jpg';

// Map pin locations (this will eventually come from customizer or admin)
$map_pins = array(
    array(
        'id' => 'resort',
        'x' => '25%',
        'y' => '40%',
        'title' => 'The Westin Resort',
        'description' => 'Luxury accommodations with spa and dining'
    ),
    array(
        'id' => 'villas',
        'x' => '70%',
        'y' => '30%',
        'title' => 'Riahi Residences',
        'description' => 'Private villas with pools and sea views'
    ),
    array(
        'id' => 'beach',
        'x' => '60%',
        'y' => '80%',
        'title' => 'Crystal Beach',
        'description' => 'Pristine white sand beach and water sports'
    ),
    array(
        'id' => 'spa',
        'x' => '35%',
        'y' => '25%',
        'title' => 'Heavenly Spa',
        'description' => 'Wellness treatments and relaxation'
    )
);
?>

<section class="map-section" id="island-map">
    <div class="map-container">
        
        <?php if ($map_title || $map_subtitle): ?>
        <div class="map-header">
            <?php if ($map_title): ?>
                <h2 class="map-title"><?php echo esc_html($map_title); ?></h2>
            <?php endif; ?>
            
            <?php if ($map_subtitle): ?>
                <p class="map-subtitle"><?php echo esc_html($map_subtitle); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <div class="map-interactive-wrapper">
            <div class="map-image-container">
                <img 
                    src="<?php echo esc_url($map_image_url); ?>" 
                    alt="<?php echo esc_attr($map_title); ?>"
                    class="map-image"
                    loading="lazy"
                />
                
                <!-- Map Pins (for future interactive functionality) -->
                <div class="map-pins">
                    <?php foreach ($map_pins as $pin): ?>
                        <button 
                            class="map-pin" 
                            data-pin-id="<?php echo esc_attr($pin['id']); ?>"
                            style="left: <?php echo esc_attr($pin['x']); ?>; top: <?php echo esc_attr($pin['y']); ?>;"
                            aria-label="<?php echo esc_attr($pin['title']); ?>"
                            data-title="<?php echo esc_attr($pin['title']); ?>"
                            data-description="<?php echo esc_attr($pin['description']); ?>"
                        >
                            <div class="pin-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M21 10C21 17 12 23 12 23S3 17 3 10C3 5.02944 7.02944 1 12 1C16.9706 1 21 5.02944 21 10Z" stroke="#A48456" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="12" cy="10" r="3" stroke="#A48456" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="pin-pulse"></div>
                        </button>
                    <?php endforeach; ?>
                </div>
                
                <!-- Tooltip for pin hover/click -->
                <div class="map-tooltip" id="map-tooltip">
                    <div class="tooltip-content">
                        <h4 class="tooltip-title"></h4>
                        <p class="tooltip-description"></p>
                    </div>
                    <div class="tooltip-arrow"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    // Basic pin interaction for now (tooltip functionality for future)
    $('.map-pin').on('mouseenter', function() {
        var title = $(this).data('title');
        var description = $(this).data('description');
        var $tooltip = $('#map-tooltip');
        
        // Update tooltip content
        $tooltip.find('.tooltip-title').text(title);
        $tooltip.find('.tooltip-description').text(description);
        
        // Position tooltip near the pin
        var pinOffset = $(this).offset();
        var containerOffset = $('.map-image-container').offset();
        
        // Simple positioning (will be enhanced later)
        $tooltip.css({
            'left': pinOffset.left - containerOffset.left + 15 + 'px',
            'top': pinOffset.top - containerOffset.top - 60 + 'px',
            'opacity': 1,
            'visibility': 'visible'
        });
    });
    
    $('.map-pin').on('mouseleave', function() {
        $('#map-tooltip').css({
            'opacity': 0,
            'visibility': 'hidden'
        });
    });
    
    // Analytics tracking for map interactions
    $('.map-pin').on('click', function() {
        var pinId = $(this).data('pin-id');
        var title = $(this).data('title');
        
        // Google Analytics
        if (typeof gtag !== 'undefined') {
            gtag('event', 'map_pin_clicked', {
                event_category: 'island_map',
                event_label: pinId,
                pin_title: title
            });
        }
        
        // Microsoft Clarity
        if (typeof clarity !== 'undefined') {
            clarity('event', 'map_interaction', {
                pin_id: pinId,
                pin_title: title
            });
        }
    });
});
</script>