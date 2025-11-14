<?php
/**
 * Map Section Template - WITH IMAGE & HOURS SUPPORT
 * File: template-parts/map-section.php
 * REPLACE your current map-section.php with this
 */

// Get customizer values
$map_image_id = get_theme_mod('nirup_map_image');
$map_title = get_theme_mod('nirup_map_title', __('Explore Our Island', 'nirup-island'));
$map_subtitle = get_theme_mod('nirup_map_subtitle', __('Discover amazing locations and experiences across Nirup Island', 'nirup-island'));

// Get map image URL
$map_image_url = $map_image_id ? wp_get_attachment_image_url($map_image_id, 'full') : get_template_directory_uri() . '/assets/images/default-map.jpg';

// Get all map pins
$map_pins = nirup_get_map_pins();
?>

<section class="map-section">
    <div class="map-container">
        <div class="map-header">
            <h2 class="map-title"><?php echo esc_html($map_title); ?></h2>
            <p class="map-subtitle"><?php echo esc_html($map_subtitle); ?></p>
        </div>
        
        <div class="map-content">
            <div class="map-interactive-wrapper">
                <div class="map-image-container">
                    <img src="<?php echo esc_url($map_image_url); ?>" alt="<?php echo esc_attr($map_title); ?>" class="map-image">
                    
                    <!-- Map Pins -->
                    <div class="map-pins">
                        <?php if (!empty($map_pins)): ?>
                            <?php foreach ($map_pins as $pin): ?>
                                <button 
                                    class="map-pin map-pin-<?php echo esc_attr($pin['pin_type']); ?>" 
                                    data-pin-id="<?php echo esc_attr($pin['id']); ?>"
                                    data-title="<?php echo esc_attr($pin['title']); ?>"
                                    data-description="<?php echo esc_attr(isset($pin['description']) ? $pin['description'] : ''); ?>"
                                    data-link="<?php echo esc_attr(isset($pin['link']) ? $pin['link'] : ''); ?>"
                                    data-pin-type="<?php echo esc_attr($pin['pin_type']); ?>"
                                    data-image_1="<?php echo esc_attr(isset($pin['image_1']) ? $pin['image_1'] : '0'); ?>"
                                    data-image_2="<?php echo esc_attr(isset($pin['image_2']) ? $pin['image_2'] : '0'); ?>"
                                    data-hours="<?php echo esc_attr(isset($pin['hours']) ? $pin['hours'] : ''); ?>"
                                    style="left: <?php echo esc_attr($pin['x']); ?>%; top: <?php echo esc_attr($pin['y']); ?>%;"
                                >
                                    <div class="pin-icon pin-icon-<?php echo esc_attr($pin['pin_type']); ?>">
                                        <?php
                                        $icon_key = isset($pin['icon']) ? $pin['icon'] : '';
                                        echo nirup_get_pin_icon_svg($pin['pin_type'], $icon_key);
                                        ?>
                                    </div>
                                    <div class="pin-pulse"></div>
                                </button>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="map-tooltip" id="map-tooltip">
                        <button class="tooltip-close" aria-label="<?php _e('Close', 'nirup-island'); ?>">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L13 13M13 1L1 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </button>
                        
                        <div class="tooltip-content">
                            <div class="tooltip-header">
                                <!-- <div class="tooltip-icon"></div> -->
                                <h4 class="tooltip-title"></h4>
                            </div>
                            
                            <p class="tooltip-description"></p>
                            
                            <div class="tooltip-images"></div>
                            
                            <div class="tooltip-hours" style="display: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11" fill="none">
                                <path d="M5.5 2.5V5.5L7.5 6.5M10.5 5.5C10.5 8.26142 8.26142 10.5 5.5 10.5C2.73858 10.5 0.5 8.26142 0.5 5.5C0.5 2.73858 2.73858 0.5 5.5 0.5C8.26142 0.5 10.5 2.73858 10.5 5.5Z" stroke="#A48456" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="hours-text"></span>
                            </div>
                            
                            <div class="tooltip-actions" style="display: none;">
                                <a href="#" class="tooltip-button">
                                    <?php _e('Discover more', 'nirup-island'); ?>
                                </a>
                            </div>
                        </div>
                        
                        <div class="tooltip-arrow"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>