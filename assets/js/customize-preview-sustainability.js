/**
 * Customizer Live Preview for Sustainability Page - Clean Version
 * File: assets/js/customize-preview-sustainability.js
 */

(function($) {
    'use strict';

    // Hero Subtitle
    wp.customize('nirup_sustainability_hero_subtitle', function(value) {
        value.bind(function(newval) {
            $('.sustainability-hero-subtitle').text(newval);
        });
    });

    // Hero Title
    wp.customize('nirup_sustainability_hero_title', function(value) {
        value.bind(function(newval) {
            $('.sustainability-hero-title').text(newval);
        });
    });

    // Description
    wp.customize('nirup_sustainability_description', function(value) {
        value.bind(function(newval) {
            $('.sustainability-description-text').text(newval);
        });
    });

    // Practices Title
    wp.customize('nirup_sustainability_practices_title', function(value) {
        value.bind(function(newval) {
            $('.sustainability-practices-title').text(newval);
        });
    });

    // Practice Items (1-8)
    for (let i = 1; i <= 8; i++) {
        // Practice Title
        wp.customize(`nirup_sustainability_practice_${i}_title`, function(value) {
            value.bind(function(newval) {
                const $practices = $('.sustainability-practice-title');
                if ($practices.length >= i) {
                    $practices.eq(i - 1).text(newval);
                }
            });
        });

        // Practice Description 1
        wp.customize(`nirup_sustainability_practice_${i}_desc1`, function(value) {
            value.bind(function(newval) {
                const $descriptions = $('.sustainability-practice-desc');
                const descIndex = (i - 1) * 2; // Each practice has 2 descriptions
                if ($descriptions.length > descIndex) {
                    $descriptions.eq(descIndex).text(newval);
                }
            });
        });

        // Practice Description 2
        wp.customize(`nirup_sustainability_practice_${i}_desc2`, function(value) {
            value.bind(function(newval) {
                const $descriptions = $('.sustainability-practice-desc');
                const descIndex = (i - 1) * 2 + 1; // Each practice has 2 descriptions
                if ($descriptions.length > descIndex) {
                    $descriptions.eq(descIndex).text(newval);
                }
            });
        });
    }

    // Images use 'refresh' transport, so they automatically
    // refresh the preview when changed - no need to handle them here

})(jQuery);