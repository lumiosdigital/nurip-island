<?php
/**
 * Reusable Map Component
 * File: template-parts/map-component.php
 * 
 * This component can be used on both the homepage and the full Getting Here page
 * with optional parameters to customize display
 */

// Accept parameters or use defaults
$show_controls = isset($args['show_controls']) ? $args['show_controls'] : true;
$show_route_info = isset($args['show_route_info']) ? $args['show_route_info'] : true;
$map_height = isset($args['map_height']) ? $args['map_height'] : '700px';
$container_class = isset($args['container_class']) ? $args['container_class'] : 'getting-here-map-container';

// Get Google Maps settings from the dedicated Ferry Map Settings section
$google_maps_api_key = get_theme_mod('nirup_google_maps_api_key', '');
$map_center_lat = get_theme_mod('nirup_map_center_lat', '1.1304753');
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
$map_style = get_theme_mod('nirup_map_style', 'terrain');

// Map labels
$label_from_singapore = get_theme_mod('nirup_map_label_from_singapore', __('From Singapore', 'nirup-island'));
$label_from_batam = get_theme_mod('nirup_map_label_from_batam', __('From Batam', 'nirup-island'));
$btn_singapore = get_theme_mod('nirup_map_btn_singapore', __('Singapore Route', 'nirup-island'));
$btn_batam = get_theme_mod('nirup_map_btn_batam', __('Batam Route', 'nirup-island'));
$btn_view_all = get_theme_mod('nirup_map_btn_view_all', __('View All', 'nirup-island'));
$loading_text = get_theme_mod('nirup_map_loading_text', __('Loading interactive map...', 'nirup-island'));
?>

<div class="<?php echo esc_attr($container_class); ?>" style="height: <?php echo esc_attr($map_height); ?>;">
    
    <?php if ($google_maps_api_key): ?>
    <!-- Google Maps Container -->
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
        
        <!-- Loading indicator -->
        <div class="map-loading">
            <div class="loading-spinner"></div>
            <p><?php echo esc_html($loading_text); ?></p>
        </div>
    </div>
    
    <?php else: ?>
    <!-- Fallback: Google Maps Embed (no API key required) -->
    <div class="google-maps-embed">
        <iframe
            width="100%"
            height="100%"
            frameborder="0"
            style="border:0"
            referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255015.89465855814!2d103.70665374999999!3d1.1304753!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwMDcnNDkuNyJOIDEwNMKwMDEnMzUuOCJF!5e0!3m2!1sen!2s!4v1234567890123!5m2!1sen!2s"
            allowfullscreen>
        </iframe>
    </div>
    <?php endif; ?>
    
    <?php if ($show_route_info || $show_controls): ?>
    <!-- Map Info Overlay -->
    <div class="map-info-overlay">
        
        <?php if ($show_route_info): ?>
        <div class="ferry-routes-info">
            <div class="route-info singapore-route-info">
                <div class="route-icon singapore-icon"></div>
                <div class="route-details">
                    <h4><?php echo esc_html($label_from_singapore); ?></h4>
                    <p><?php echo esc_html($singapore_ferry_info); ?></p>
                </div>
            </div>
            
            <div class="route-info batam-route-info">
                <div class="route-icon batam-icon"></div>
                <div class="route-details">
                    <h4><?php echo esc_html($label_from_batam); ?></h4>
                    <p><?php echo esc_html($batam_ferry_info); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($show_controls): ?>
        <!-- Map Controls -->
        <div class="map-controls">
            <button class="map-control-btn" id="show-singapore-route" data-route="singapore">
                <?php echo esc_html($btn_singapore); ?>
            </button>
            <button class="map-control-btn" id="show-batam-route" data-route="batam">
                <?php echo esc_html($btn_batam); ?>
            </button>
            <button class="map-control-btn active" id="show-all-routes" data-route="all">
                <?php echo esc_html($btn_view_all); ?>
            </button>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<?php if ($google_maps_api_key): ?>
<script>
// Pass PHP data to JavaScript (only once per page)
if (!window.nirupMapData) {
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
}
</script>
<?php endif; ?>