/**
 * Nirup Theme - Mobile Menu Functionality
 * File: assets/js/mobile-menu.js
 */

(function($) {
    'use strict';

    window.NirupTheme = window.NirupTheme || {};

    window.NirupTheme.MobileMenu = {
        
        // Configuration
        config: {
            animationDuration: 300,
            isOpen: false
        },

        // Initialize mobile menu
        init: function() {
            this.bindEvents();
            this.setupAccessibility();
            window.NirupTheme.Utils.log('Mobile menu module initialized');
        },

        // Bind mobile menu events
        bindEvents: function() {
            var self = this;

            // Mobile menu toggle
            $('.mobile-menu-toggle').on('click', function() {
                self.toggle();
            });

            // Close mobile menu when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.mobile-menu, .mobile-menu-toggle').length) {
                    if (self.config.isOpen) {
                        self.close();
                    }
                }
            });

            // Mobile menu item clicks
            $('.mobile-primary-menu a, .mobile-secondary-menu a').on('click', function() {
                self.trackMenuClick($(this));
                
                // Close menu after clicking a link (optional)
                setTimeout(function() {
                    self.close();
                }, 150);
            });

            // Handle window resize
            $(window).on('resize', window.NirupTheme.Utils.debounce(function() {
                if ($(window).width() > 768 && self.config.isOpen) {
                    self.close();
                }
            }, 250));
        },

        // Setup accessibility features
        setupAccessibility: function() {
            // Ensure proper ARIA attributes
            var $toggle = $('.mobile-menu-toggle');
            var $menu = $('.mobile-menu');
            
            $toggle.attr('aria-controls', 'mobile-menu');
            $toggle.attr('aria-expanded', 'false');
            $menu.attr('id', 'mobile-menu');
            $menu.attr('aria-hidden', 'true');

            // Handle keyboard navigation
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && this.config.isOpen) {
                    this.close();
                }
            }.bind(this));
        },

        // Toggle mobile menu
        toggle: function() {
            if (this.config.isOpen) {
                this.close();
            } else {
                this.open();
            }
        },


        // Open mobile menu
        open: function() {
            var $toggle = $('.mobile-menu-toggle');
            var $menu = $('.mobile-menu');
            var $body = $('body');
            var $html = $('html');
            
            window.NirupTheme.Utils.log('Opening mobile menu');
            
            // Add active classes
            $toggle.addClass('active');
            $menu.show().addClass('active');
            $body.addClass('mobile-menu-open');
            $html.addClass('mobile-menu-open'); // ADD THIS LINE
            
            // Update ARIA attributes
            $toggle.attr('aria-expanded', 'true');
            $menu.attr('aria-hidden', 'false');
            
            // Set state
            this.config.isOpen = true;
            
            // Track event
            window.NirupTheme.Utils.trackEvent('mobile_menu_open');
            
            // Focus management
            setTimeout(function() {
                $menu.find('a').first().focus();
            }, this.config.animationDuration);
        },

        // Close mobile menu
        close: function() {
            var $toggle = $('.mobile-menu-toggle');
            var $menu = $('.mobile-menu');
            var $body = $('body');
            var $html = $('html');
            
            window.NirupTheme.Utils.log('Closing mobile menu');
            
            // Remove active classes
            $toggle.removeClass('active');
            $menu.removeClass('active');
            $body.removeClass('mobile-menu-open');
            $html.removeClass('mobile-menu-open'); // ADD THIS LINE
            
            // Update ARIA attributes
            $toggle.attr('aria-expanded', 'false');
            $menu.attr('aria-hidden', 'true');
            
            // Hide menu after animation
            setTimeout(function() {
                $menu.hide();
            }, this.config.animationDuration);
            
            // Set state
            this.config.isOpen = false;
            
            // Track event
            window.NirupTheme.Utils.trackEvent('mobile_menu_close');
        },

        // Track menu item clicks
        trackMenuClick: function($link) {
            var linkText = $link.text();
            var linkUrl = $link.attr('href');
            var menuType = $link.closest('.mobile-primary-menu').length ? 'primary' : 'secondary';
            
            window.NirupTheme.Utils.trackEvent('mobile_menu_click', {
                text: linkText,
                url: linkUrl,
                menu_type: menuType
            });
            
            window.NirupTheme.Utils.log('Mobile menu item clicked', {
                text: linkText,
                url: linkUrl,
                menu_type: menuType
            });
        },

        // Get current state
        isOpen: function() {
            return this.config.isOpen;
        },

        // Force close (useful for other modules)
        forceClose: function() {
            if (this.config.isOpen) {
                this.close();
            }
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        window.NirupTheme.MobileMenu.init();
    });

    // Make force close available globally
    $(document).on('nirup:closeAllOverlays', function() {
        window.NirupTheme.MobileMenu.forceClose();
    });

})(jQuery);