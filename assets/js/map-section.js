/**
 * Map Section JavaScript
 * File: assets/js/map-section.js
 * 
 * Handles map pin interactions, tooltips, and future pin management
 */

(function($) {
    'use strict';

    /**
     * Map Section Functionality
     */
    const MapSection = {
        
        // Initialize map functionality
        init: function() {
            this.bindEvents();
            this.setupTooltips();
            this.initAccessibility();
            
            if (typeof nirup_map !== 'undefined' && nirup_map.pins_enabled) {
                this.initPinManagement();
            }
        },

        // Bind all event handlers
        bindEvents: function() {
            $(document).ready(() => {
                this.setupPinInteractions();
                this.setupResponsiveBehavior();
            });
        },

        // Setup pin hover and click interactions
        setupPinInteractions: function() {
            const $pins = $('.map-pin');
            const $tooltip = $('#map-tooltip');

            if ($pins.length === 0) return;

            // Pin hover events
            $pins.on('mouseenter', function(e) {
                MapSection.showTooltip($(this), $tooltip);
            });

            $pins.on('mouseleave', function(e) {
                MapSection.hideTooltip($tooltip);
            });

            // Pin click events
            $pins.on('click', function(e) {
                e.preventDefault();
                MapSection.handlePinClick($(this));
            });

            // Pin keyboard events
            $pins.on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    MapSection.handlePinClick($(this));
                }
            });
        },

        // Show tooltip for a pin
        showTooltip: function($pin, $tooltip) {
            const title = $pin.data('title');
            const description = $pin.data('description');
            
            if (!title) return;

            // Update tooltip content
            $tooltip.find('.tooltip-title').text(title);
            $tooltip.find('.tooltip-description').text(description || '');

            // Position tooltip
            this.positionTooltip($pin, $tooltip);

            // Show tooltip
            $tooltip.addClass('visible');
        },

        // Hide tooltip
        hideTooltip: function($tooltip) {
            $tooltip.removeClass('visible');
        },

        // Position tooltip relative to pin
        positionTooltip: function($pin, $tooltip) {
            const $container = $('.map-image-container');
            const containerOffset = $container.offset();
            const containerWidth = $container.width();
            const containerHeight = $container.height();
            
            const pinPosition = $pin.position();
            const tooltipWidth = $tooltip.outerWidth();
            const tooltipHeight = $tooltip.outerHeight();

            let left = pinPosition.left + 15;
            let top = pinPosition.top - tooltipHeight - 10;

            // Adjust if tooltip goes outside container
            if (left + tooltipWidth > containerWidth) {
                left = pinPosition.left - tooltipWidth - 15;
            }

            if (top < 0) {
                top = pinPosition.top + 30;
            }

            $tooltip.css({
                left: left + 'px',
                top: top + 'px'
            });
        },

        // Handle pin click interactions
        handlePinClick: function($pin) {
            const pinId = $pin.data('pin-id');
            const title = $pin.data('title');
            
            // Analytics tracking
            this.trackPinInteraction(pinId, title);
            
            // Add visual feedback
            this.addClickFeedback($pin);
            
            // Future: Open detailed modal or navigate to specific page
            console.log('Pin clicked:', pinId, title);
        },

        // Add visual feedback for pin clicks
        addClickFeedback: function($pin) {
            $pin.addClass('clicked');
            setTimeout(() => {
                $pin.removeClass('clicked');
            }, 300);
        },

        // Track pin interactions for analytics
        trackPinInteraction: function(pinId, title) {
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
            
            // Console log for development
            if (typeof nirup_theme !== 'undefined' && nirup_theme.debug) {
                console.log('Map pin interaction:', {
                    pin_id: pinId,
                    title: title,
                    timestamp: new Date().toISOString()
                });
            }
        },

        // Setup tooltip behavior
        setupTooltips: function() {
            // Ensure tooltip is hidden on page load
            $('#map-tooltip').removeClass('visible');
            
            // Hide tooltip when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.map-pin, #map-tooltip').length) {
                    $('#map-tooltip').removeClass('visible');
                }
            });
        },

        // Setup accessibility features
        initAccessibility: function() {
            // Add ARIA labels to pins
            $('.map-pin').each(function() {
                const title = $(this).data('title');
                const description = $(this).data('description');
                
                if (title) {
                    $(this).attr('aria-label', `${title}. ${description || ''}`);
                }
            });

            // Add keyboard navigation
            $('.map-pin').attr('tabindex', '0');
        },

        // Setup responsive behavior
        setupResponsiveBehavior: function() {
            let resizeTimer;
            
            $(window).on('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    // Hide tooltip on resize to prevent positioning issues
                    $('#map-tooltip').removeClass('visible');
                }, 150);
            });
        },

        // Future: Initialize pin management for admin
        initPinManagement: function() {
            // This will be implemented when admin pin management is added
            console.log('Pin management initialized');
        },

        // Utility: Check if element is in viewport
        isInViewport: function($element) {
            const elementTop = $element.offset().top;
            const elementBottom = elementTop + $element.outerHeight();
            const viewportTop = $(window).scrollTop();
            const viewportBottom = viewportTop + $(window).height();
            
            return elementBottom > viewportTop && elementTop < viewportBottom;
        }
    };

    /**
     * Initialize when DOM is ready
     */
    $(document).ready(function() {
        if ($('.map-section').length > 0) {
            MapSection.init();
        }
    });

    /**
     * Make MapSection available globally for debugging
     */
    window.NirupMapSection = MapSection;

})(jQuery);