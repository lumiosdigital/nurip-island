/**
 * Nirup Theme - Navigation and Header Behavior - CORRECTED
 * File: assets/js/navigation.js
 */

(function($) {
    'use strict';

    window.NirupTheme = window.NirupTheme || {};

    window.NirupTheme.Navigation = {
        
        // FIXED Configuration
        config: {
            scrollThreshold: 100,
            headerHideDelay: 150,
            lastScrollTop: 0,
            isHeaderHidden: false
        },

        // Initialize navigation
        init: function() {
            this.bindEvents();
            this.handleMenuAccessibility();
            window.NirupTheme.Utils.log('Navigation module initialized');
        },

        // Bind all navigation events
        bindEvents: function() {
            var self = this;

            // FIXED: Scroll behavior for header
            $(window).on('scroll', window.NirupTheme.Utils.debounce(function() {
                self.handleHeaderScroll();
            }, 10));

            // Menu focus states for accessibility
            $('.primary-menu-left a, .secondary-menu a').on('focus', function() {
                $(this).parent().addClass('focused');
            }).on('blur', function() {
                $(this).parent().removeClass('focused');
            });

            // Booking button clicks
            $('.booking-button, .mobile-booking-button').on('click', function() {
                self.trackBookingClick($(this));
            });

            // Announcement bar clicks
            $('.announcement-link').on('click', function(e) {
                self.handleAnnouncementClick(e, $(this));
            });
        },

        // FIXED: Handle header scroll behavior - completely rewritten
        handleHeaderScroll: function() {
            var currentScrollTop = $(window).scrollTop();
            var $header = $('.site-header');
            var $announcementBar = $('.announcement-bar');
            
            // Add scrolled class for styling
            if (currentScrollTop > 50) {
                $header.addClass('header-scrolled');
            } else {
                $header.removeClass('header-scrolled');
            }

            // FIXED: Header hide/show logic
            if (currentScrollTop > this.config.scrollThreshold) {
                if (currentScrollTop > this.config.lastScrollTop && !this.config.isHeaderHidden) {
                    // Scrolling down - hide header
                    this.hideHeader();
                } else if (currentScrollTop < this.config.lastScrollTop && this.config.isHeaderHidden) {
                    // Scrolling up - show header
                    this.showHeader();
                }
            } else {
                // At top of page - always show header
                if (this.config.isHeaderHidden) {
                    this.showHeader();
                }
            }

            this.config.lastScrollTop = currentScrollTop;
        },

        // FIXED: Hide header completely
        hideHeader: function() {
            $('.site-header, .announcement-bar').addClass('header-hidden');
            this.config.isHeaderHidden = true;
            window.NirupTheme.Utils.log('Header hidden');
        },

        // FIXED: Show header
        showHeader: function() {
            $('.site-header, .announcement-bar').removeClass('header-hidden');
            this.config.isHeaderHidden = false;
            window.NirupTheme.Utils.log('Header shown');
        },

        // Handle accessibility for menus
        handleMenuAccessibility: function() {
            // Ensure proper ARIA attributes
            $('.mobile-menu-toggle').attr('aria-controls', 'mobile-menu');
            $('.mobile-menu-toggle').attr('aria-expanded', 'false');
            
            // Handle keyboard navigation
            $(document).on('keydown', function(e) {
                // Tab navigation improvements
                if (e.key === 'Tab') {
                    // Add focus handling if needed
                }
            });
        },

        // Track booking button clicks
        trackBookingClick: function($button) {
            var buttonText = $button.text();
            var buttonLocation = $button.hasClass('mobile-booking-button') ? 'mobile' : 'desktop';
            
            window.NirupTheme.Utils.trackEvent('booking_button_click', {
                location: buttonLocation,
                text: buttonText
            });
            
            window.NirupTheme.Utils.log('Booking button clicked', {
                location: buttonLocation,
                text: buttonText
            });
        },

        // Handle announcement bar clicks
        handleAnnouncementClick: function(e, $link) {
            // If no link is provided, prevent default action
            if ($link.attr('href') === '#' || $link.attr('href') === '') {
                e.preventDefault();
                window.NirupTheme.Utils.log('Announcement clicked but no URL provided');
                return;
            }

            window.NirupTheme.Utils.trackEvent('announcement_click', {
                url: $link.attr('href'),
                text: $link.find('.announcement-text').text()
            });
        },

        // Handle window resize
        handleResize: function() {
            var self = this;
            
            $(window).on('resize', window.NirupTheme.Utils.debounce(function() {
                if ($(window).width() > 768) {
                    // Desktop mode - ensure mobile menu is closed
                    $('.mobile-menu').removeClass('active').hide();
                    $('.mobile-menu-toggle').removeClass('active');
                    $('body').removeClass('mobile-menu-open');
                    $('.mobile-menu-toggle').attr('aria-expanded', 'false');
                    
                    // Close language dropdown
                    $('.language-switcher-container').removeClass('active');
                }
                
                // Reset header state on resize
                self.config.lastScrollTop = 0;
                self.handleHeaderScroll();
                
            }, 250));
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        window.NirupTheme.Navigation.init();
        window.NirupTheme.Navigation.handleResize();
    });

})(jQuery);