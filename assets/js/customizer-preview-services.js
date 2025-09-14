/**
 * Customizer Live Preview for Services Section
 * File: assets/js/customize-preview-services.js
 * 
 * Note: Link fields use 'refresh' transport and will automatically
 * refresh the preview when changed (since they affect HTML structure)
 */

(function($) {
    'use strict';

    // Services Section Show/Hide
    wp.customize('nirup_services_show', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $('.services-section').show();
            } else {
                $('.services-section').hide();
            }
        });
    });

    // Private Events Title
    wp.customize('nirup_service_events_title', function(value) {
        value.bind(function(newval) {
            $('.service-card[data-service="private_events"] .service-title').text(newval);
        });
    });

    // Private Events Description
    wp.customize('nirup_service_events_desc', function(value) {
        value.bind(function(newval) {
            $('.service-card[data-service="private_events"] .service-description p').text(newval);
        });
    });

    // Marina Title
    wp.customize('nirup_service_marina_title', function(value) {
        value.bind(function(newval) {
            $('.service-card[data-service="marina"] .service-title').text(newval);
        });
    });

    // Marina Description
    wp.customize('nirup_service_marina_desc', function(value) {
        value.bind(function(newval) {
            $('.service-card[data-service="marina"] .service-description p').text(newval);
        });
    });

    // Sustainability Title
    wp.customize('nirup_service_sustainability_title', function(value) {
        value.bind(function(newval) {
            $('.service-card[data-service="sustainability"] .service-title').text(newval);
        });
    });

    // Sustainability Description
    wp.customize('nirup_service_sustainability_desc', function(value) {
        value.bind(function(newval) {
            $('.service-card[data-service="sustainability"] .service-description p').text(newval);
        });
    });

    // Links and images use 'refresh' transport, so they automatically
    // refresh the preview when changed - no need to handle them here

})(jQuery);