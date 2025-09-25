<?php
/**
 * Services Section Template
 * File: template-parts/services-section.php
 * Displays Private Events, Marina, and Sustainability cards
 */

// Get customizer values for each service
$services = array(
    'private_events' => array(
        'title' => get_theme_mod('nirup_service_events_title', __('Private Events', 'nirup-island')),
        'description' => get_theme_mod('nirup_service_events_desc', __('Nirup Island provides an exclusive and well-appointed setting for private team-building events, destination weddings, and other special occasions.', 'nirup-island')),
        'image_id' => get_theme_mod('nirup_service_events_image'),
        'link' => get_theme_mod('nirup_service_events_link', ''),
        'fallback_image' => 'private-events-placeholder.jpg'
    ),
    'marina' => array(
        'title' => get_theme_mod('nirup_service_marina_title', __('Marina', 'nirup-island')),
        'description' => get_theme_mod('nirup_service_marina_desc', __('ONE°15 Marina at Nirup Island offers berthing facilities for up to 70 private yachts, along with private charters for scenic journeys or special events.', 'nirup-island')),
        'image_id' => get_theme_mod('nirup_service_marina_image'),
        'link' => get_theme_mod('nirup_service_marina_link', ''),
        'fallback_image' => 'marina-placeholder.jpg'
    ),
    'sustainability' => array(
        'title' => get_theme_mod('nirup_service_sustainability_title', __('Sustainability', 'nirup-island')),
        'description' => get_theme_mod('nirup_service_sustainability_desc', __('From solar panels to rainwater harvesting and local sourcing, sustainability is central to Nirup Island\'s operations. Guests are encouraged to engage in eco-friendly habits and support local communities.', 'nirup-island')),
        'image_id' => get_theme_mod('nirup_service_sustainability_image'),
        'link' => get_theme_mod('nirup_service_sustainability_link', ''),
        'fallback_image' => 'sustainability-placeholder.jpg'
    )
);

// Check if section should be displayed
$show_section = get_theme_mod('nirup_services_show', true);
if (!$show_section) {
    return;
}
?>

<section class="services-section" id="services">
    <div class="services-container">
        
        <?php foreach ($services as $service_key => $service): ?>
        <?php 
        // Get image URL
        $image_url = $service['image_id'] ? 
            wp_get_attachment_image_url($service['image_id'], 'master') : 
            get_template_directory_uri() . '/assets/images/' . $service['fallback_image'];
        
        // Check if service has a link
        $has_link = !empty($service['link']);
        $link_url = $has_link ? esc_url($service['link']) : '';
        ?>
        
        <?php if ($has_link): ?>
            <a href="<?php echo $link_url; ?>" class="service-card service-card-linked" data-service="<?php echo esc_attr($service_key); ?>">
        <?php else: ?>
            <div class="service-card" data-service="<?php echo esc_attr($service_key); ?>">
        <?php endif; ?>
        
            <div class="service-image-container">
                <div class="service-image" style="background-image: url('<?php echo esc_url($image_url); ?>');" aria-hidden="true"></div>
            </div>
            
            <div class="service-content">
                <h3 class="service-title"><?php echo esc_html($service['title']); ?></h3>
                <div class="service-description">
                    <p><?php echo esc_html($service['description']); ?></p>
                </div>
            </div>
        
        <?php if ($has_link): ?>
            </a>
        <?php else: ?>
            </div>
        <?php endif; ?>
        
        <?php endforeach; ?>
        
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    // Track services section interaction
    if ('IntersectionObserver' in window) {
        const servicesObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    // Track services section view
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'services_section_viewed', {
                            event_category: 'engagement',
                            event_label: 'services_section'
                        });
                    }
                    
                    if (typeof clarity !== 'undefined') {
                        clarity('event', 'services_section_viewed');
                    }
                    
                    // Stop observing after first view
                    servicesObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.3 // Trigger when 30% of section is visible
        });
        
        const servicesSection = document.querySelector('.services-section');
        if (servicesSection) {
            servicesObserver.observe(servicesSection);
        }
    }
    
    // Track individual service card clicks/interactions (for non-linked cards)
    $('.service-card:not(.service-card-linked)').on('click', function(e) {
        const serviceType = $(this).data('service');
        
        // Track the click
        if (typeof gtag !== 'undefined') {
            gtag('event', 'service_card_clicked', {
                event_category: 'engagement',
                event_label: serviceType,
                has_link: false
            });
        }
        
        if (typeof clarity !== 'undefined') {
            clarity('event', 'service_card_clicked_' + serviceType);
        }
        
        console.log('Clicked on service card:', serviceType, 'but no link is set');
    });
    
    // Track link clicks specifically
    $('.service-card-linked').on('click', function(e) {
        const serviceType = $(this).data('service');
        const linkUrl = $(this).attr('href');
        
        if (typeof gtag !== 'undefined') {
            gtag('event', 'service_link_clicked', {
                event_category: 'navigation',
                event_label: serviceType,
                link_url: linkUrl
            });
        }
        
        if (typeof clarity !== 'undefined') {
            clarity('event', 'service_link_clicked_' + serviceType);
        }
    });
});
</script>