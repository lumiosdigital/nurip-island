/**
 * Nirup Theme - Analytics and Tracking
 * File: assets/js/analytics.js
 */

(function($) {
    'use strict';

    window.NirupTheme = window.NirupTheme || {};

    window.NirupTheme.Analytics = {
        
        // Configuration
        config: {
            gtag: typeof gtag !== 'undefined',
            clarity: typeof clarity !== 'undefined',
            debug: false
        },

        // Initialize analytics
        init: function() {
            this.config.debug = window.nirup_theme && window.nirup_theme.debug;
            this.bindEvents();
            this.setupEventListeners();
            window.NirupTheme.Utils.log('Analytics module initialized', this.config);
        },

        // Bind analytics events
        bindEvents: function() {
            var self = this;

            // Listen for custom tracking events
            $(document).on('nirup:track', function(e, eventName, eventData) {
                self.trackEvent(eventName, eventData);
            });

            // Hero CTA button tracking
            $('.hero-cta').on('click', function() {
                self.trackHeroCTA($(this));
            });

            // Booking button tracking
            $('.booking-button, .mobile-booking-button').on('click', function() {
                self.trackBookingButton($(this));
            });

            // Navigation tracking
            $('.primary-menu-left a, .secondary-menu a, .mobile-primary-menu a, .mobile-secondary-menu a').on('click', function() {
                self.trackNavigation($(this));
            });

            // Search tracking
            $('.search-form').on('submit', function() {
                self.trackSearch($(this));
            });

            // Language switcher tracking
            $('.language-option a').on('click', function() {
                self.trackLanguageChange($(this));
            });

            // Announcement bar tracking
            $('.announcement-link').on('click', function() {
                self.trackAnnouncement($(this));
            });

            // Scroll depth tracking
            this.setupScrollTracking();

            // Time on page tracking
            this.setupTimeTracking();
        },

        // Setup custom event listeners
        setupEventListeners: function() {
            var self = this;

            // Page view
            this.trackPageView();

            // User engagement events
            $(document).on('click', 'a[href^="mailto:"]', function() {
                self.trackEvent('email_click', {
                    email: $(this).attr('href').replace('mailto:', '')
                });
            });

            $(document).on('click', 'a[href^="tel:"]', function() {
                self.trackEvent('phone_click', {
                    phone: $(this).attr('href').replace('tel:', '')
                });
            });

            // Form submissions (general)
            $('form:not(.search-form)').on('submit', function() {
                var formId = $(this).attr('id') || 'unknown-form';
                self.trackEvent('form_submit', {
                    form_id: formId,
                    form_action: $(this).attr('action') || 'current-page'
                });
            });
        },

        // Track generic events
        trackEvent: function(eventName, eventData) {
            eventData = eventData || {};
            
            if (this.config.debug) {
                window.NirupTheme.Utils.log('Tracking event', { name: eventName, data: eventData });
            }

            // Google Analytics 4
            if (this.config.gtag) {
                gtag('event', eventName, eventData);
            }

            // Microsoft Clarity
            if (this.config.clarity) {
                clarity('event', eventName, eventData);
            }

            // Custom analytics (if any)
            this.trackCustom(eventName, eventData);
        },

        // Track hero CTA button
        trackHeroCTA: function($button) {
            var buttonText = $button.text();
            var buttonUrl = $button.attr('href');
            
            this.trackEvent('hero_cta_click', {
                text: buttonText,
                url: buttonUrl,
                location: 'hero'
            });
        },

        // Track booking buttons
        trackBookingButton: function($button) {
            var buttonText = $button.text();
            var buttonLocation = $button.hasClass('mobile-booking-button') ? 'mobile' : 'desktop';
            var buttonUrl = $button.attr('href');
            
            this.trackEvent('booking_click', {
                text: buttonText,
                url: buttonUrl,
                location: buttonLocation,
                device_type: window.nirup_theme && window.nirup_theme.is_mobile ? 'mobile' : 'desktop'
            });
        },

        // Track navigation clicks
        trackNavigation: function($link) {
            var linkText = $link.text();
            var linkUrl = $link.attr('href');
            var menuType = 'unknown';
            
            if ($link.closest('.primary-menu-left, .mobile-primary-menu').length) {
                menuType = 'primary';
            } else if ($link.closest('.secondary-menu, .mobile-secondary-menu').length) {
                menuType = 'secondary';
            }
            
            var isMobile = $link.closest('.mobile-primary-menu, .mobile-secondary-menu').length > 0;
            
            this.trackEvent('navigation_click', {
                text: linkText,
                url: linkUrl,
                menu_type: menuType,
                device_type: isMobile ? 'mobile' : 'desktop'
            });
        },

        // Track search
        trackSearch: function($form) {
            var searchTerm = $form.find('.search-field').val().trim();
            
            this.trackEvent('search', {
                search_term: searchTerm,
                search_length: searchTerm.length
            });
        },

        // Track language changes
        trackLanguageChange: function($link) {
            var language = $link.text();
            var languageUrl = $link.attr('href');
            
            this.trackEvent('language_change', {
                language: language,
                url: languageUrl
            });
        },

        // Track announcement clicks
        trackAnnouncement: function($link) {
            var text = $link.find('.announcement-text').text();
            var url = $link.attr('href');
            
            this.trackEvent('announcement_click', {
                text: text,
                url: url
            });
        },

        // Track page views
        trackPageView: function() {
            var pageData = {
                page_title: document.title,
                page_location: window.location.href,
                page_path: window.location.pathname
            };

            // Add custom page data
            if (window.nirup_theme) {
                pageData.theme_version = '1.0.0';
                pageData.is_mobile = window.nirup_theme.is_mobile;
            }

            this.trackEvent('page_view', pageData);
        },

        // Setup scroll depth tracking
        setupScrollTracking: function() {
            var self = this;
            var scrollMarks = [25, 50, 75, 90];
            var marksReached = [];
            
            $(window).on('scroll', window.NirupTheme.Utils.debounce(function() {
                var scrollPercent = Math.round(($(window).scrollTop() / ($(document).height() - $(window).height())) * 100);
                
                scrollMarks.forEach(function(mark) {
                    if (scrollPercent >= mark && marksReached.indexOf(mark) === -1) {
                        marksReached.push(mark);
                        self.trackEvent('scroll_depth', {
                            percent: mark,
                            page_path: window.location.pathname
                        });
                    }
                });
            }, 500));
        },

        // Setup time on page tracking
        setupTimeTracking: function() {
            var self = this;
            var startTime = Date.now();
            var timeMarks = [30, 60, 120, 300]; // seconds
            var marksReached = [];
            
            setInterval(function() {
                var timeSpent = Math.round((Date.now() - startTime) / 1000);
                
                timeMarks.forEach(function(mark) {
                    if (timeSpent >= mark && marksReached.indexOf(mark) === -1) {
                        marksReached.push(mark);
                        self.trackEvent('time_on_page', {
                            seconds: mark,
                            page_path: window.location.pathname
                        });
                    }
                });
            }, 10000); // Check every 10 seconds

            // Track when leaving page
            $(window).on('beforeunload', function() {
                var totalTime = Math.round((Date.now() - startTime) / 1000);
                self.trackEvent('page_exit', {
                    total_time: totalTime,
                    page_path: window.location.pathname
                });
            });
        },

        // Custom analytics for specific integrations
        trackCustom: function(eventName, eventData) {
            // Add any custom analytics integrations here
            // Example: send to custom backend, third-party services, etc.
            
            if (this.config.debug) {
                window.NirupTheme.Utils.log('Custom tracking', { name: eventName, data: eventData });
            }
        },

        // Enhanced ecommerce tracking (for future use)
        trackEcommerce: function(action, data) {
            if (this.config.gtag) {
                gtag('event', action, {
                    event_category: 'ecommerce',
                    ...data
                });
            }
        },

        // Track errors
        trackError: function(error, context) {
            this.trackEvent('javascript_error', {
                error_message: error.message || 'Unknown error',
                error_stack: error.stack || 'No stack trace',
                context: context || 'unknown',
                page_path: window.location.pathname
            });
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        window.NirupTheme.Analytics.init();
    });

    // Global error tracking
    window.addEventListener('error', function(e) {
        if (window.NirupTheme && window.NirupTheme.Analytics) {
            window.NirupTheme.Analytics.trackError(e.error, 'global_error');
        }
    });

    // Unhandled promise rejection tracking
    window.addEventListener('unhandledrejection', function(e) {
        if (window.NirupTheme && window.NirupTheme.Analytics) {
            window.NirupTheme.Analytics.trackError({
                message: e.reason,
                stack: e.reason && e.reason.stack
            }, 'promise_rejection');
        }
    });

})(jQuery);