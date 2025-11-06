/**
 * Map Section JavaScript
 * File: assets/js/map-section.js
 */

(function($) {
    'use strict';

    const MapSection = {
        
        // Initialize map functionality
        init: function() {
            this.bindEvents();
            this.setupTooltips();
            this.initAccessibility();
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

            // Pin hover events (only if tooltip isn't pinned)
            $pins.on('mouseenter', (e) => {
                if (!$tooltip.hasClass('pinned')) {
                    this.showTooltip($(e.currentTarget), $tooltip);
                }
            });

            $pins.on('mouseleave', (e) => {
                // Only hide if tooltip isn't pinned
                if (!$tooltip.hasClass('pinned')) {
                    this.hideTooltip($tooltip);
                }
            });

            // Pin click events - toggle pinned tooltip
            $pins.on('click', (e) => {
                e.preventDefault();
                const $clickedPin = $(e.currentTarget);

                // If clicking same pin again, close tooltip
                if (this.activePin && this.activePin.is($clickedPin) && $tooltip.hasClass('pinned')) {
                    this.hideTooltip($tooltip);
                } else {
                    // Otherwise, show and pin the tooltip
                    this.handlePinClick($clickedPin, $tooltip);
                }
            });

            // Keyboard events
            $pins.on('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.handlePinClick($(e.currentTarget), $tooltip);
                }
            });
        },

        // Show tooltip for a pin
        showTooltip: function($pin, $tooltip) {
            const title = $pin.data('title');
            const description = $pin.data('description');
            const link = $pin.data('link');
            
            if (!title) return;

            // Update tooltip content
            $tooltip.find('.tooltip-title').text(title);
            $tooltip.find('.tooltip-description').text(description || '');

            // Handle link display
            if (link && link.trim() !== '') {
                $tooltip.find('.tooltip-link').attr('href', link);
                $tooltip.find('.tooltip-actions').show();
            } else {
                $tooltip.find('.tooltip-actions').hide();
            }

            // Position tooltip
            this.positionTooltip($pin, $tooltip);

            // Show tooltip
            $tooltip.addClass('visible');
        },

        // Hide tooltip
        hideTooltip: function($tooltip) {
            $tooltip.removeClass('visible pinned');
            this.activePin = null;
        },

        // Position tooltip relative to pin
        positionTooltip: function($pin, $tooltip) {
            const $container = $('.map-image-container');
            const containerWidth = $container.width();
            const containerHeight = $container.height();
            
            const pinPosition = $pin.position();
            const tooltipWidth = $tooltip.outerWidth();
            const tooltipHeight = $tooltip.outerHeight();

            let left = pinPosition.left + 20;
            let top = pinPosition.top - tooltipHeight - 15;

            // Keep tooltip within bounds
            if (left + tooltipWidth > containerWidth) {
                left = pinPosition.left - tooltipWidth - 20;
            }

            if (top < 0) {
                top = pinPosition.top + 40;
            }

            if (left < 0) {
                left = 10;
            }

            // Update arrow position
            const arrowLeft = Math.min(Math.max(pinPosition.left - left, 20), tooltipWidth - 34);
            $tooltip.find('.tooltip-arrow').css('left', arrowLeft + 'px');

            $tooltip.css({
                left: left + 'px',
                top: top + 'px'
            });
        },

        // Handle pin click interactions
        handlePinClick: function($pin, $tooltip) {
            const pinId = $pin.data('pin-id');
            const title = $pin.data('title');
            const link = $pin.data('link');
            const iconType = $pin.data('icon-type');

            // Add visual feedback
            this.addClickFeedback($pin);

            // Track interaction
            this.trackPinInteraction(pinId, title, iconType);

            // Show and pin the tooltip (keep it open)
            this.showTooltip($pin, $tooltip);
            $tooltip.addClass('pinned');

            // Store active pin reference
            this.activePin = $pin;
        },

        // Add visual feedback for pin clicks
        addClickFeedback: function($pin) {
            $pin.addClass('pin-clicked');
            setTimeout(() => {
                $pin.removeClass('pin-clicked');
            }, 300);
        },

        // Track pin interactions for analytics
        trackPinInteraction: function(pinId, title, iconType) {
            // Google Analytics
            if (typeof gtag !== 'undefined') {
                gtag('event', 'map_pin_clicked', {
                    event_category: 'island_map',
                    event_label: pinId,
                    custom_parameters: {
                        pin_title: title,
                        pin_type: iconType,
                        interaction_method: 'click'
                    }
                });
            }
            
            // Microsoft Clarity
            if (typeof clarity !== 'undefined') {
                clarity('event', 'map_pin_interaction', {
                    pin_id: pinId,
                    pin_title: title,
                    pin_type: iconType
                });
            }
            
            // Debug logging
            if (typeof nirup_theme !== 'undefined' && nirup_theme.debug) {
                console.log('Map pin interaction:', {
                    pin_id: pinId,
                    title: title,
                    type: iconType,
                    timestamp: new Date().toISOString()
                });
            }
        },

        // Setup accessibility features
        initAccessibility: function() {
            // Add ARIA labels to pins
            $('.map-pin').each(function() {
                const title = $(this).data('title');
                const description = $(this).data('description');
                const iconType = $(this).data('icon-type');
                
                if (title) {
                    const ariaLabel = `${title}. ${description || ''}. Pin type: ${iconType || 'default'}.`;
                    $(this).attr('aria-label', ariaLabel);
                }
            });

            // Add keyboard navigation
            $('.map-pin').attr('tabindex', '0');
        },

        // Setup responsive behavior
        setupResponsiveBehavior: function() {
            let resizeTimer;
            
            $(window).on('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    // Hide tooltip on resize
                    this.hideTooltip($('#map-tooltip'));
                }, 250);
            });
        },

        // Setup tooltip behavior
        setupTooltips: function() {
            // Hide tooltip on page load
            $('#map-tooltip').removeClass('visible');
            
            // Hide tooltip when clicking outside
            $(document).on('click', (e) => {
                if (!$(e.target).closest('.map-pin, #map-tooltip').length) {
                    this.hideTooltip($('#map-tooltip'));
                }
            });

            // Prevent tooltip from closing when clicking inside it
            $('#map-tooltip').on('click', (e) => {
                e.stopPropagation();
            });
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
     * Make MapSection available globally
     */
    window.NirupMapSection = MapSection;

})(jQuery);

/**
 * Add click feedback styles
 */
$(document).ready(function() {
    const clickStyles = `
        <style>
        .map-pin.pin-clicked {
            transform: translate(-50%, -50%) scale(0.9);
        }
        
        .map-pin.pin-clicked .pin-icon {
            transform: scale(0.9);
        }
        </style>
    `;
    
    if (!$('#map-click-styles').length) {
        $('head').append(clickStyles);
    }
});