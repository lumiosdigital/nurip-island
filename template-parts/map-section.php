<?php
/**
 * Updated Map Section Template Part
 * File: template-parts/map-section.php
 * REPLACE your existing map-section.php with this
 */

// Get customizer values
$map_image_id = get_theme_mod('nirup_map_image');
$map_title = get_theme_mod('nirup_map_title', __('Explore Our Island', 'nirup-island'));
$map_subtitle = get_theme_mod('nirup_map_subtitle', __('Discover amazing locations and experiences across Nirup Island', 'nirup-island'));

// Get map image URL
$map_image_url = $map_image_id ? wp_get_attachment_image_url($map_image_id, 'full') : get_template_directory_uri() . '/assets/images/map-placeholder.jpg';

// Get pins from database
$map_pins = nirup_get_map_pins();

// Fallback to sample pins if no admin pins exist
if (empty($map_pins)) {
    $map_pins = array(
        array(
            'id' => 'sample-resort',
            'title' => 'The Westin Resort',
            'description' => 'Luxury accommodations with spa and dining',
            'x' => 25,
            'y' => 40,
            'link' => '',
            'pin_type' => 'accommodation'
        ),
        array(
            'id' => 'sample-villas',
            'title' => 'Riahi Residences',
            'description' => 'Private villas with pools and sea views',
            'x' => 70,
            'y' => 30,
            'link' => '',
            'pin_type' => 'accommodation'
        ),
        array(
            'id' => 'sample-beach',
            'title' => 'Crystal Beach',
            'description' => 'Pristine white sand beach and water sports',
            'x' => 60,
            'y' => 80,
            'link' => '',
            'pin_type' => 'public'
        ),
        array(
            'id' => 'sample-spa',
            'title' => 'Island Spa',
            'description' => 'Wellness treatments and relaxation',
            'x' => 35,
            'y' => 25,
            'link' => '',
            'pin_type' => 'public'
        )
    );
}
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
                
                <!-- Map Pins -->
                <div class="map-pins">
                    <?php foreach ($map_pins as $pin): ?>
                        <button 
                            class="map-pin map-pin-<?php echo esc_attr($pin['pin_type']); ?>" 
                            data-pin-id="<?php echo esc_attr($pin['id']); ?>"
                            style="left: <?php echo esc_attr($pin['x']); ?>%; top: <?php echo esc_attr($pin['y']); ?>%;"
                            aria-label="<?php echo esc_attr($pin['title']); ?>"
                            data-title="<?php echo esc_attr($pin['title']); ?>"
                            data-description="<?php echo esc_attr($pin['description']); ?>"
                            data-link="<?php echo esc_attr($pin['link']); ?>"
                            data-pin-type="<?php echo esc_attr($pin['pin_type']); ?>"
                        >
                            <div class="pin-icon pin-icon-<?php echo esc_attr($pin['pin_type']); ?>">
                                <?php echo nirup_get_pin_icon_svg($pin['pin_type']); ?>
                            </div>
                            <div class="pin-pulse"></div>
                        </button>
                    <?php endforeach; ?>
                </div>
                
                <!-- Tooltip -->
                <div class="map-tooltip" id="map-tooltip">
                    <div class="tooltip-content">
                        <h4 class="tooltip-title"></h4>
                        <p class="tooltip-description"></p>
                        <div class="tooltip-actions" style="display: none;">
                            <a href="#" class="tooltip-link"><?php _e('Learn More', 'nirup-island'); ?> →</a>
                        </div>
                    </div>
                    <div class="tooltip-arrow"></div>
                </div>
            </div>
        </div>
    </div>
</section>