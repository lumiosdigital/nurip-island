/**
 * Map Section JavaScript - WITH IMAGE LOADING
 * File: assets/js/map-section.js
 * REPLACE your current map-section.js with this
 */

(function($) {
    'use strict';

    const MapSection = {
        activePin: null,
        
        init: function() {
            this.bindEvents();
            this.setupTooltips();
            this.initAccessibility();
            this.setupResponsiveBehavior();
        },

        bindEvents: function() {
            $(document).ready(() => {
                this.setupPinInteractions();
            });
        },

        setupPinInteractions: function() {
            const $pins = $('.map-pin');
            const $tooltip = $('#map-tooltip');

            if ($pins.length === 0) return;

            // Pin click events
            $pins.on('click', (e) => {
                e.preventDefault();
                const $clickedPin = $(e.currentTarget);

                if (this.activePin && this.activePin.is($clickedPin) && $tooltip.hasClass('visible')) {
                    this.hideTooltip($tooltip);
                } else {
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

            // Close button
            $tooltip.find('.tooltip-close').on('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.hideTooltip($tooltip);
            });
        },

        handlePinClick: function($pin, $tooltip) {
            $pin.addClass('pin-clicked');
            setTimeout(() => {
                $pin.removeClass('pin-clicked');
            }, 200);

            this.showTooltip($pin, $tooltip);
            $tooltip.addClass('pinned');

            if (this.activePin) {
                this.activePin.removeClass('active-pin');
            }
            this.activePin = $pin;
            $pin.addClass('active-pin');
        },

        /**
         * FIX FOR assets/js/map-section.js
         * FIND the showTooltip function and REPLACE it with this complete version
         */

                

        showTooltip: function($pin, $tooltip) {
            const title = $pin.data('title');
            const description = $pin.data('description');
            const link = $pin.data('link');
            const image1 = $pin.data('image_1');
            const image2 = $pin.data('image_2');
            const hours = $pin.data('hours');
            
            console.log('=== SHOWING TOOLTIP ===');
            console.log('Title:', title);
            console.log('Image 1 ID:', image1, 'Type:', typeof image1);
            console.log('Image 2 ID:', image2, 'Type:', typeof image2);
            console.log('Hours:', hours);
            
            if (!title) return;

            // Update title
            $tooltip.find('.tooltip-title').text(title);
            
            // Update description
            // Update description
            if (description) {
                $tooltip.find('.tooltip-description').text(description).show();
            } else {
                $tooltip.find('.tooltip-description').hide();
            }

            /**
             * ICON IN TOOLTIP
             * - clone ONLY the SVG from the pin
             * - add a class based on pin type so CSS can colour it (blue / gold)
             */
            const pinType = $pin.data('pin-type'); // e.g. "public", "accommodation"
            const $tooltipIcon = $tooltip.find('.tooltip-icon');

            // grab the SVG inside .pin-icon
            const $iconSvg = $pin.find('.pin-icon svg').first().clone();

            // reset previous icon classes & content
            $tooltipIcon
                .attr('class', 'tooltip-icon')  // keep base class, drop old modifiers
                .empty();

            // add modifier class so we can colour by type in CSS
            if (pinType) {
                $tooltipIcon.addClass('tooltip-icon--' + pinType);
            }

            // inject the svg if we have one
            if ($iconSvg.length) {
                $tooltipIcon.append($iconSvg);
            }

            // UPDATE IMAGES - THIS IS THE CRITICAL PART
            const $imagesContainer = $tooltip.find('.tooltip-images');

            $imagesContainer.empty(); // Clear previous images
            
            console.log('Checking images...');
            
            // Load Image 1
            if (image1 && image1 != '0' && image1 !== 0 && image1 != '') {
                console.log('Loading image 1:', image1);
                this.loadImage(image1, function(url) {
                    if (url) {
                        console.log('Image 1 URL:', url);
                        $imagesContainer.append('<div class="tooltip-image"><img src="' + url + '" alt=""></div>');
                    }
                });
            } else {
                console.log('No image 1');
            }
            
            // Load Image 2
            if (image2 && image2 != '0' && image2 !== 0 && image2 != '') {
                console.log('Loading image 2:', image2);
                this.loadImage(image2, function(url) {
                    if (url) {
                        console.log('Image 2 URL:', url);
                        $imagesContainer.append('<div class="tooltip-image"><img src="' + url + '" alt=""></div>');
                    }
                });
            } else {
                console.log('No image 2');
            }

            // UPDATE HOURS
            if (hours && hours.trim() !== '') {
                console.log('Showing hours:', hours);
                $tooltip.find('.tooltip-hours').show();
                $tooltip.find('.hours-text').text(hours);
            } else {
                $tooltip.find('.tooltip-hours').hide();
            }

            // UPDATE LINK BUTTON
            if (link && link.trim() !== '') {
                $tooltip.find('.tooltip-button').attr('href', link);
                $tooltip.find('.tooltip-actions').show();
            } else {
                $tooltip.find('.tooltip-actions').hide();
            }

            // Position tooltip
            this.positionTooltip($pin, $tooltip);

            // Show tooltip
            $tooltip.addClass('visible');
        },

        /**
         * ADD THIS NEW FUNCTION right after showTooltip
         * This loads images via AJAX
         */
        loadImage: function(imageId, callback) {
            if (!imageId || imageId == '0' || imageId === 0) {
                console.log('Invalid image ID:', imageId);
                callback(null);
                return;
            }

            console.log('Fetching image via AJAX, ID:', imageId);

            // ✅ Use the object that WordPress actually localized
            var ajaxUrl = (window.nirup_map && nirup_map.ajax_url)
                ? nirup_map.ajax_url
                : (window.ajaxurl || '/wp-admin/admin-ajax.php'); // fallback

            jQuery.ajax({
                url: ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'nirup_get_image_url',
                    image_id: imageId,
                    size: 'medium'
                    // If you later add nonce check in PHP:
                    // nonce: nirup_map ? nirup_map.nonce : ''
                },
                success: function(response) {
                    console.log('Image AJAX response:', response);
                    if (response.success && response.data) {
                        callback(response.data); // response.data is the URL string
                    } else {
                        console.error('Image load failed:', response);
                        callback(null);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Image AJAX error:', error);
                    console.error('Response text:', xhr.responseText);
                    callback(null);
                }
            });
        },


        hideTooltip: function($tooltip) {
            $tooltip.removeClass('visible pinned');
            if (this.activePin) {
                this.activePin.removeClass('active-pin');
                this.activePin = null;
            }
        },

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

        setupResponsiveBehavior: function() {
            let resizeTimer;
            
            $(window).on('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    this.hideTooltip($('#map-tooltip'));
                }, 250);
            });
        },

        setupTooltips: function() {
            const $tooltip = $('#map-tooltip');
            
            $tooltip.removeClass('visible');
            
            $(document).on('click', (e) => {
                if (!$(e.target).closest('.map-pin, #map-tooltip').length) {
                    this.hideTooltip($tooltip);
                }
            });

            $tooltip.on('click', (e) => {
                e.stopPropagation();
            });
        },

        initAccessibility: function() {
            $('.map-pin').each(function() {
                const title = $(this).data('title');
                const description = $(this).data('description');
                const iconType = $(this).data('pin-type');
                
                if (title) {
                    const ariaLabel = `${title}. ${description || ''}. Pin type: ${iconType || 'default'}.`;
                    $(this).attr('aria-label', ariaLabel);
                }
            });

            $('.map-pin').attr('tabindex', '0');
        }
    };

    $(document).ready(function() {
        if ($('.map-section').length > 0) {
            console.log('Initializing map section...');
            MapSection.init();
        }
    });

    window.NirupMapSection = MapSection;

})(jQuery);