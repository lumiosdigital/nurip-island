<?php
/**
 * Getting Here Section Template with Google Maps
 * File: template-parts/getting-here-section.php
 */

// Get customizer values with defaults that match the Figma design
$getting_here_title = get_theme_mod('nirup_getting_here_title', __('GETTING HERE', 'nirup-island'));
$getting_here_description = get_theme_mod('nirup_getting_here_description', __('Nirup Island is just a 20-minute ferry ride from Harbour Bay Ferry Terminal in Batam and 50 minutes from HarbourFront Centre in Singapore.', 'nirup-island'));

// Google Maps settings
$google_maps_api_key = get_theme_mod('nirup_google_maps_api_key', '');
$map_center_lat = get_theme_mod('nirup_map_center_lat', '1.1304753'); // Nirup Island approximate coordinates
$map_center_lng = get_theme_mod('nirup_map_center_lng', '104.0266055');

// Ferry terminal coordinates
$singapore_terminal_lat = get_theme_mod('nirup_singapore_lat', '1.2650543');
$singapore_terminal_lng = get_theme_mod('nirup_singapore_lng', '103.8232508');
$batam_terminal_lat = get_theme_mod('nirup_batam_lat', '1.1210997');  
$batam_terminal_lng = get_theme_mod('nirup_batam_lng', '104.0538234');

// Ferry route information
$singapore_ferry_info = get_theme_mod('nirup_singapore_ferry_info', __('50 minutes from HarbourFront Centre', 'nirup-island'));
$batam_ferry_info = get_theme_mod('nirup_batam_ferry_info', __('20 minutes from Harbour Bay Terminal', 'nirup-island'));

// Map style and zoom
$map_zoom = get_theme_mod('nirup_map_zoom', '10');
$map_style = get_theme_mod('nirup_map_style', 'terrain'); // roadmap, satellite, hybrid, terrain
?>

<section class="getting-here-section" id="getting-here">
    <!-- Background Pattern -->
    <div class="getting-here-pattern-bg"></div>
    
    <!-- Section Content -->
    <div class="getting-here-container">
        
        <!-- Header Content -->
        <div class="getting-here-header">
            <?php 
            $getting_here_title = get_theme_mod('nirup_getting_here_title', __('GETTING HERE', 'nirup-island'));
            $getting_here_description = get_theme_mod('nirup_getting_here_description', __('Nirup Island is just a 20-minute ferry ride from Harbour Bay Ferry Terminal in Batam and 50 minutes from HarbourFront Centre in Singapore.', 'nirup-island'));
            ?>
            
            <div class="getting-here-title-row">
                <?php if ($getting_here_title): ?>
                    <h2 class="getting-here-title"><?php echo esc_html($getting_here_title); ?></h2>
                <?php endif; ?>
                
                <!-- See More Button -->
                <div class="getting-here-see-more">
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('getting-here'))); ?>" class="getting-here-see-more-link">
                        <span>See More</span>
                        <svg class="see-more-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M1 7H13M13 7L7 1M13 7L7 13" stroke="#A48456" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <?php if ($getting_here_description): ?>
                <p class="getting-here-description"><?php echo esc_html($getting_here_description); ?></p>
            <?php endif; ?>
        </div>
        

       <!-- <div class="getting-here-map-container">
            
            <?php if ($google_maps_api_key): ?>

            <div id="nirup-ferry-map" class="nirup-google-map" 
                 data-center-lat="<?php echo esc_attr($map_center_lat); ?>"
                 data-center-lng="<?php echo esc_attr($map_center_lng); ?>"
                 data-zoom="<?php echo esc_attr($map_zoom); ?>"
                 data-style="<?php echo esc_attr($map_style); ?>"
                 data-singapore-lat="<?php echo esc_attr($singapore_terminal_lat); ?>"
                 data-singapore-lng="<?php echo esc_attr($singapore_terminal_lng); ?>"
                 data-batam-lat="<?php echo esc_attr($batam_terminal_lat); ?>"
                 data-batam-lng="<?php echo esc_attr($batam_terminal_lng); ?>"
                 data-singapore-info="<?php echo esc_attr($singapore_ferry_info); ?>"
                 data-batam-info="<?php echo esc_attr($batam_ferry_info); ?>">
                

                <div class="map-loading">
                    <div class="loading-spinner"></div>
                    <p><?php _e('Loading interactive map...', 'nirup-island'); ?></p>
                </div>
            </div>
            
            <?php else: ?>

            <div class="google-maps-embed">
                <iframe
                    width="100%"
                    height="646"
                    frameborder="0"
                    style="border:0"
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255015.89465855814!2d103.70665374999999!3d1.1304753!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwMDcnNDkuNyJOIDEwNMKwMDEnMzUuOCJF!5e0!3m2!1sen!2s!4v1234567890123!5m2!1sen!2s"
                    allowfullscreen>
                </iframe>
            </div>
            <?php endif; ?>
            

            <div class="map-info-overlay">
                <div class="ferry-routes-info">
                    <div class="route-info singapore-route-info">
                        <div class="route-icon singapore-icon">

                        </div>
                        <div class="route-details">
                            <h4><?php _e('From Singapore', 'nirup-island'); ?></h4>
                            <p><?php echo esc_html($singapore_ferry_info); ?></p>
                        </div>
                    </div>
                    
                    <div class="route-info batam-route-info">
                        <div class="route-icon batam-icon">

                        </div>
                        <div class="route-details">
                            <h4><?php _e('From Batam', 'nirup-island'); ?></h4>
                            <p><?php echo esc_html($batam_ferry_info); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="map-controls">
                    <button class="map-control-btn" id="show-singapore-route" data-route="singapore">
                        <?php _e('Singapore Route', 'nirup-island'); ?>
                    </button>
                    <button class="map-control-btn" id="show-batam-route" data-route="batam">
                        <?php _e('Batam Route', 'nirup-island'); ?>
                    </button>
                    <button class="map-control-btn active" id="show-all-routes" data-route="all">
                        <?php _e('View All', 'nirup-island'); ?>
                    </button>
                </div>
            </div>
        </div> 
    </div> -->

    <?php 
        get_template_part('template-parts/map-component', null, array(
            'show_controls' => true,
            'show_route_info' => true,
            'map_height' => '700px',
            'container_class' => 'getting-here-map-container'
        )); 
    ?>
</section>

<?php if ($google_maps_api_key): ?>
<script>
// Pass PHP data to JavaScript
window.nirupMapData = {
    apiKey: '<?php echo esc_js($google_maps_api_key); ?>',
    center: {
        lat: <?php echo floatval($map_center_lat); ?>,
        lng: <?php echo floatval($map_center_lng); ?>
    },
    singapore: {
        lat: <?php echo floatval($singapore_terminal_lat); ?>,
        lng: <?php echo floatval($singapore_terminal_lng); ?>,
        info: '<?php echo esc_js($singapore_ferry_info); ?>'
    },
    batam: {
        lat: <?php echo floatval($batam_terminal_lat); ?>,
        lng: <?php echo floatval($batam_terminal_lng); ?>,
        info: '<?php echo esc_js($batam_ferry_info); ?>'
    },
    zoom: <?php echo intval($map_zoom); ?>,
    style: '<?php echo esc_js($map_style); ?>'
};
</script>
<?php endif; ?>

<style>
/* Getting Here Section Styles */
.getting-here-section {
    position: relative;
    /* background-color: #F8F6F3; */
    padding: 70px 0 80px;
    overflow: hidden;
}

/* .getting-here-pattern-bg {
    position: absolute;
    top: -100px;
    left: 0;
    right: 0;
    height: calc(100% + 200px);
    background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/pattern-bg.png');
    background-size: 102.75px 102.75px;
    background-repeat: repeat;
    opacity: 0.1;
    pointer-events: none;
} */

.getting-here-container {
    max-width: 1400px;
    margin: 0 auto;
    /* padding: 0 20px; */
}

.getting-here-header {
    /* position: relative; */
    text-align: center;
    margin-bottom: 60px;
    /* max-width: 574px; */
    margin-left: auto;
    margin-right: auto;
    width: 100%;
}

.getting-here-title-row {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    text-align: center;
    margin-bottom: 20px;
}

.getting-here-title {
    font-family: 'Amiri', serif;
    font-size: 48px;
    font-weight: 400;
    line-height: 1;
    letter-spacing: -1px;
    text-transform: uppercase;
    color: #3D332F;
    margin: 0;
}

.getting-here-see-more {
    position: absolute;
    top: 0;
    right: 0;
}

.getting-here-see-more-link {
    display: flex;
    text-transform: uppercase;
    gap: 10px;
    align-items: center;
    font-family: 'Albert Sans', sans-serif;
    font-weight: 300;
    font-size: 14px;
    color: #8B5E1D;
    text-decoration: none;
    letter-spacing: 0.5px;
    padding-bottom: 1px;
    border-bottom: 0.5px solid #8B5E1D;
    transition: all 0.2s ease;
}

.getting-here-see-more-link:hover {
    opacity: 0.8;
    transform: translateY(-1px);
    border-bottom-color: transparent;
}

.see-more-arrow {
    transition: transform 0.2s ease;
}

.getting-here-see-more-link:hover {
        opacity: 0.8;
    transform: translateY(-1px);
    border-bottom-color: transparent;
}

/* @media (max-width: 768px) {
    .getting-here-see-more {
        position: static;
        text-align: center;
        margin-top: 15px;
    }
    
    .getting-here-title-row {
        margin-bottom: 30px;
    }
} */

.getting-here-description {
    font-family: 'Amiri', serif;
    font-size: 16px;
    line-height: 1.4;
    color: #3D332F;
    margin: 0;
    max-width: 574px;
    margin-left: auto;
    margin-right: auto;
}

.getting-here-map-container {
    position: relative;
    max-width: 1400px;
    margin: 0 auto 60px;
    /* border-radius: 20px; */
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    height: 700px;
}

/* Google Maps Styling */
.nirup-google-map {
    width: 100%;
    height: 100%;
    position: relative;
}

.google-maps-embed {
    width: 100%;
    height: 100%;
}

.google-maps-embed iframe {
    /* border-radius: 20px; */
}

/* Map Loading */
.map-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: #3D332F;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #A48456;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 10px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Map Info Overlay */
.map-info-overlay {
    position: absolute;
    top: 20px;
    left: 20px;
    right: 20px;
    z-index: 10;
    pointer-events: none;
}

.ferry-routes-info {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.route-info {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    /* border-radius: 12px; */
    padding: 15px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    pointer-events: auto;
    transition: transform 0.2s ease;
}

.route-info:hover {
    transform: translateY(-2px);
}

.route-icon {
    flex-shrink: 0;
}

.route-details h4 {
    margin: 0 0 4px 0;
    font-size: 14px;
    font-weight: 600;
    color: #3D332F;
}

.route-details p {
    margin: 0;
    font-size: 12px;
    color: #666;
}

/* Map Controls */
.map-controls {
    display: flex;
    gap: 10px;
    justify-content: flex-start;
    pointer-events: auto;
}

.map-control-btn {
    background: rgba(255,255,255,0.95);
    border: 2px solid transparent;
    border-radius: 0px;
    padding: 8px 16px;
    font-size: 12px;
    font-weight: 500;
    color: #3D332F;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.map-control-btn:hover,
.map-control-btn.active {
    background: #A48456;
    color: white;
    border-color: #A48456;
}

/* Ferry Schedule Info */
.ferry-schedule-info {
    margin-top: 40px;
}

.schedule-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    max-width: 800px;
    margin: 0 auto;
}

.schedule-item {
    background: white;
    /* border-radius: 16px; */
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: transform 0.2s ease;
}

/* .schedule-item:hover {
    transform: translateY(-2px);
} */

.schedule-item h3 {
    margin: 0 0 15px 0;
    font-size: 18px;
    font-weight: 600;
    color: #3D332F;
    border-bottom: 1px solid #A48456;
    padding-bottom: 8px;
}

.schedule-details {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.departure-point,
.travel-time {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.departure-point strong,
.travel-time strong {
    color: #3D332F;
    font-size: 14px;
}

.departure-point span,
.travel-time span {
    color: #666;
    font-size: 14px;
}

@media (max-width: 1024px) {
    .getting-here-section {
        padding: 60px 25px;
    }

    /* Stack title and button vertically - SAME AS EXPERIENCES CAROUSEL */
    .getting-here-title-row {
        flex-direction: column;
        gap: 0;
        margin-bottom: 0;
    }

    .getting-here-title {
        padding-bottom: 25px;
        position: relative;
        margin-bottom: 0;
    }

    /* Add decorative line below title on tablet */
    .getting-here-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 1px;
        background: #A48456;
        opacity: 0.3;
    }

    /* Button below line */
    .getting-here-see-more {
        position: static;
        text-align: center;
        margin-top: 25px;
        margin-bottom: 25px;
    }

    .getting-here-see-more-link {
        border-bottom: none;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .getting-here-section {
        padding: 50px 0 60px;
    }
    
    .getting-here-container {
        padding: 0 15px;
    }

    /* Stack title and button vertically - SAME AS EXPERIENCES CAROUSEL */
    .getting-here-title-row {
        flex-direction: column;
        gap: 0;
        margin-bottom: 0;
    }
    
    .getting-here-title {
        font-size: 36px;
        padding-bottom: 20px;
        position: relative;
        margin-bottom: 0;
    }

    /* Add decorative line below title - SAME AS EXPERIENCES CAROUSEL */
    .getting-here-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 1px;
        background: #A48456;
        opacity: 0.3;
    }

    /* Button below line - SAME AS EXPERIENCES CAROUSEL */
    .getting-here-see-more {
        position: static;
        text-align: center;
        margin-top: 20px;
    }

    .getting-here-see-more-link {
        font-size: 12px;
        border-bottom: none; /* Remove underline on mobile */
    }
    
    .getting-here-description {
        font-size: 14px;
        margin-top: 20px;
    }
    
    .getting-here-map-container {
        height: 400px;
        margin-bottom: 40px;
    }
    
    .ferry-routes-info {
        flex-direction: column;
        gap: 10px;
    }
    
    .route-info {
        padding: 12px;
    }
    
    .map-controls {
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .map-control-btn {
        padding: 6px 12px;
        font-size: 11px;
    }
    
    .schedule-container {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .schedule-item {
        padding: 20px;
    }
}

@media (max-width: 480px) {
    /* Stack title and button */
    .getting-here-title-row {
        flex-direction: column;
        gap: 0;
    }

    .getting-here-title {
        font-size: 28px;
        padding-bottom: 20px;
    }

    /* Decorative line */
    .getting-here-title::after {
        width: 80px;
    }

    /* Button styling */
    .getting-here-see-more {
        position: static;
        margin-top: 20px;
        text-align: center;
    }

    .getting-here-see-more-link {
        font-size: 11px;
        border-bottom: none;
    }
    
    .getting-here-map-container {
        height: 300px;
    }
    
    .map-info-overlay {
        top: 10px;
        left: 10px;
        right: 10px;
    }
}


</style>