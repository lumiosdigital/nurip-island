/**
 * Nirup Theme - Core Utilities
 * File: assets/js/utils.js
 */

(function($) {
    'use strict';

    // Create global namespace
    window.NirupTheme = window.NirupTheme || {};

    // Core utilities
    window.NirupTheme.Utils = {
        
        // Debug logging
        log: function(message, data) {
            if (window.nirup_theme && window.nirup_theme.debug) {
                console.log('[Nirup Theme]', message, data || '');
            }
        },

        // Debounce function for performance
        debounce: function(func, wait, immediate) {
            var timeout;
            return function() {
                var context = this, args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        },

        // Check if element is in viewport
        isInViewport: function(element) {
            var rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        },

        // Smooth scroll to element
        scrollTo: function(target, offset) {
            offset = offset || 100;
            var $target = $(target);
            
            if ($target.length) {
                $('html, body').animate({
                    scrollTop: $target.offset().top - offset
                }, 1000);
                return true;
            }
            return false;
        },

        // Close all open overlays/dropdowns
        closeAllOverlays: function() {
            // Close search overlay
            $('.search-overlay').removeClass('active');
            $('body').removeClass('search-open');
            
            // Close language dropdown
            $('.language-switcher-container').removeClass('active');
            
            // Close mobile menu
            $('.mobile-menu').removeClass('active');
            $('.mobile-menu-toggle').removeClass('active');
            $('body').removeClass('mobile-menu-open');
            $('.mobile-menu-toggle').attr('aria-expanded', 'false');
            
            this.log('All overlays closed');
        },

        // Preload images
        preloadImages: function(imagePaths) {
            imagePaths.forEach(function(src) {
                var img = new Image();
                img.src = src;
            });
            this.log('Images preloaded', imagePaths);
        },

        // Add loading state
        addLoadingState: function(element, className) {
            className = className || 'loading';
            $(element).addClass(className);
        },

        // Remove loading state
        removeLoadingState: function(element, className) {
            className = className || 'loading';
            $(element).removeClass(className);
        },

        // Track events (wrapper for analytics)
        trackEvent: function(eventName, eventData) {
            // This will be called by the analytics module
            $(document).trigger('nirup:track', [eventName, eventData]);
        },

        // Initialize common event handlers
        initCommonEvents: function() {
            var self = this;

            // ESC key handler
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    self.closeAllOverlays();
                }
            });

            // Click outside handler
            $(document).on('click', function(e) {
                // Close language dropdown if clicking outside
                if (!$(e.target).closest('.language-switcher-container').length) {
                    $('.language-switcher-container').removeClass('active');
                }
            });

            // Smooth scrolling for anchor links
            $('a[href*="#"]:not([href="#"])').on('click', function(e) {
                if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                    location.hostname === this.hostname) {
                    
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    
                    if (target.length) {
                        e.preventDefault();
                        self.scrollTo(target, 100);
                    }
                }
            });

            this.log('Common events initialized');
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        window.NirupTheme.Utils.log('Utils module loaded');
        window.NirupTheme.Utils.initCommonEvents();
    });

})(jQuery);