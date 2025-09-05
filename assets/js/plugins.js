/**
 * Nirup Theme - Plugin Integrations
 * File: assets/js/plugins.js
 */

(function($) {
    'use strict';

    window.NirupTheme = window.NirupTheme || {};

    window.NirupTheme.Plugins = {
        
        // Plugin detection
        detectedPlugins: {},

        // Initialize plugin integrations
        init: function() {
            this.detectPlugins();
            this.initializeIntegrations();
            window.NirupTheme.Utils.log('Plugins module initialized', this.detectedPlugins);
        },

        // Detect active plugins
        detectPlugins: function() {
            // WP Booking System
            this.detectedPlugins.wpBookingSystem = typeof wpbs !== 'undefined';
            
            // TranslatePress
            this.detectedPlugins.translatePress = typeof trp_data !== 'undefined' || 
                                                  $('.trp-language-switcher').length > 0;
            
            // Brevo (Sendinblue)
            this.detectedPlugins.brevo = $('.sib-form').length > 0 || 
                                         typeof sib_form !== 'undefined';
            
            // Yoast SEO
            this.detectedPlugins.yoastSEO = $('.yoast-breadcrumbs').length > 0 || 
                                            $('#yoast-primary').length > 0;
            
            // Google Site Kit
            this.detectedPlugins.googleSiteKit = typeof googlesitekit !== 'undefined';
            
            // WooCommerce
            this.detectedPlugins.wooCommerce = $('body').hasClass('woocommerce') || 
                                               typeof wc_add_to_cart_params !== 'undefined';
            
            // Contact Form 7
            this.detectedPlugins.contactForm7 = $('.wpcf7-form').length > 0;
            
            // Elementor
            this.detectedPlugins.elementor = $('body').hasClass('elementor-page') || 
                                             $('.elementor').length > 0;
        },

        // Initialize all plugin integrations
        initializeIntegrations: function() {
            if (this.detectedPlugins.wpBookingSystem) {
                this.initWPBookingSystem();
            }
            
            if (this.detectedPlugins.translatePress) {
                this.initTranslatePress();
            }
            
            if (this.detectedPlugins.brevo) {
                this.initBrevo();
            }
            
            if (this.detectedPlugins.yoastSEO) {
                this.initYoastSEO();
            }
            
            if (this.detectedPlugins.googleSiteKit) {
                this.initGoogleSiteKit();
            }
            
            if (this.detectedPlugins.wooCommerce) {
                this.initWooCommerce();
            }
            
            if (this.detectedPlugins.contactForm7) {
                this.initContactForm7();
            }
            
            if (this.detectedPlugins.elementor) {
                this.initElementor();
            }
        },

        // WP Booking System integration
        initWPBookingSystem: function() {
            window.NirupTheme.Utils.log('Initializing WP Booking System integration');
            
            // Listen for booking system events
            $(document).on('wpbs_calendar_loaded', function(e, calendar) {
                window.NirupTheme.Utils.log('WP Booking System calendar loaded', calendar);
                
                // Track calendar view
                window.NirupTheme.Utils.trackEvent('booking_calendar_viewed', {
                    calendar_id: calendar.id || 'unknown'
                });
            });

            // Track booking selections
            $(document).on('wpbs_date_selected', function(e, data) {
                window.NirupTheme.Utils.trackEvent('booking_date_selected', {
                    date: data.date,
                    calendar_id: data.calendar_id
                });
            });

            // Track booking form submissions
            $(document).on('submit', '.wpbs-form', function() {
                window.NirupTheme.Utils.trackEvent('booking_form_submit', {
                    form_id: $(this).attr('id') || 'unknown'
                });
            });
        },

        // TranslatePress integration
        initTranslatePress: function() {
            window.NirupTheme.Utils.log('Initializing TranslatePress integration');
            
            // Track language changes from default TranslatePress switcher
            $(document).on('change', '.trp-language-switcher select', function() {
                var selectedLanguage = $(this).val();
                var selectedText = $(this).find('option:selected').text();
                
                window.NirupTheme.Utils.trackEvent('translatepress_language_change', {
                    language_code: selectedLanguage,
                    language_name: selectedText
                });
            });

            // Track translation editor usage
            if (window.location.href.indexOf('trp-edit-translation=preview') !== -1) {
                window.NirupTheme.Utils.trackEvent('translation_editor_active');
            }

            // Enhance custom language switcher with TranslatePress data
            this.enhanceCustomLanguageSwitcher();
        },

        // Enhance custom language switcher
        enhanceCustomLanguageSwitcher: function() {
            // This integrates with our custom language switcher
            if (typeof trp_data !== 'undefined' && trp_data.language_to_query_var) {
                $('.language-option a').each(function() {
                    var $link = $(this);
                    var href = $link.attr('href');
                    
                    // Ensure TranslatePress URL structure is maintained
                    if (href && href.indexOf('?') === -1 && href.indexOf('#') === -1) {
                        // Add TranslatePress query parameters if needed
                        // This depends on TranslatePress configuration
                    }
                });
            }
        },

        // Brevo (Sendinblue) integration
        initBrevo: function() {
            window.NirupTheme.Utils.log('Initializing Brevo integration');
            
            // Track form submissions
            $(document).on('submit', '.sib-form', function() {
                var formName = $(this).find('input[name="form_name"]').val() || 'newsletter';
                
                window.NirupTheme.Utils.trackEvent('newsletter_signup', {
                    form_name: formName,
                    source: 'brevo'
                });
            });

            // Track form field interactions
            $('.sib-form input[type="email"]').on('focus', function() {
                window.NirupTheme.Utils.trackEvent('newsletter_email_focus');
            });
        },

        // Yoast SEO integration
        initYoastSEO: function() {
            window.NirupTheme.Utils.log('Initializing Yoast SEO integration');
            
            // Track breadcrumb clicks
            $('.yoast-breadcrumbs a').on('click', function() {
                var breadcrumbText = $(this).text();
                var breadcrumbUrl = $(this).attr('href');
                
                window.NirupTheme.Utils.trackEvent('breadcrumb_click', {
                    text: breadcrumbText,
                    url: breadcrumbUrl
                });
            });

            // Add structured data enhancements if needed
            this.enhanceStructuredData();
        },

        // Enhance structured data
        enhanceStructuredData: function() {
            // Add additional structured data for hotel/resort
            var structuredData = {
                "@context": "https://schema.org",
                "@type": "Resort",
                "name": "Nirup Island",
                "description": "Luxury island resort just 50 minutes from Singapore"
            };

            // Only add if not already present
            if (!$('script[type="application/ld+json"]').length) {
                $('<script type="application/ld+json">')
                    .text(JSON.stringify(structuredData))
                    .appendTo('head');
            }
        },

        // Google Site Kit integration
        initGoogleSiteKit: function() {
            window.NirupTheme.Utils.log('Initializing Google Site Kit integration');
            
            // Enhanced analytics integration
            if (typeof googlesitekit !== 'undefined' && googlesitekit.analytics) {
                // Add custom dimensions or events
                this.setupGoogleSiteKitTracking();
            }
        },

        // Setup Google Site Kit tracking
        setupGoogleSiteKitTracking: function() {
            // Add custom tracking for Site Kit
            $(document).on('nirup:track', function(e, eventName, eventData) {
                // Custom integration with Site Kit analytics
                if (typeof gtag !== 'undefined') {
                    gtag('event', eventName, {
                        custom_parameter_1: 'nirup_theme',
                        ...eventData
                    });
                }
            });
        },

        // WooCommerce integration
        initWooCommerce: function() {
            window.NirupTheme.Utils.log('Initializing WooCommerce integration');
            
            // Track add to cart events
            $(document).on('added_to_cart', function(e, fragments, cart_hash, $button) {
                var productId = $button.data('product_id');
                var productName = $button.data('product_name') || 'Unknown Product';
                
                window.NirupTheme.Utils.trackEvent('add_to_cart', {
                    product_id: productId,
                    product_name: productName
                });
            });

            // Track checkout steps
            if ($('body').hasClass('woocommerce-checkout')) {
                window.NirupTheme.Utils.trackEvent('checkout_initiated');
            }
        },

        // Contact Form 7 integration
        initContactForm7: function() {
            window.NirupTheme.Utils.log('Initializing Contact Form 7 integration');
            
            // Track form submissions
            $(document).on('wpcf7mailsent', function(e) {
                var formId = $(e.target).find('input[name="_wpcf7"]').val();
                
                window.NirupTheme.Utils.trackEvent('contact_form_submit', {
                    form_id: formId,
                    form_type: 'contact_form_7'
                });
            });

            // Track form errors
            $(document).on('wpcf7mailfailed', function(e) {
                var formId = $(e.target).find('input[name="_wpcf7"]').val();
                
                window.NirupTheme.Utils.trackEvent('contact_form_error', {
                    form_id: formId,
                    form_type: 'contact_form_7'
                });
            });
        },

        // Elementor integration
        initElementor: function() {
            window.NirupTheme.Utils.log('Initializing Elementor integration');
            
            // Track Elementor widget interactions
            $('.elementor-widget').on('click', 'a, button', function() {
                var widgetType = $(this).closest('.elementor-widget').data('widget_type');
                var elementId = $(this).closest('.elementor-element').data('id');
                
                window.NirupTheme.Utils.trackEvent('elementor_widget_click', {
                    widget_type: widgetType,
                    element_id: elementId
                });
            });

            // Enhance Elementor forms if present
            this.enhanceElementorForms();
        },

        // Enhance Elementor forms
        enhanceElementorForms: function() {
            $('.elementor-form').on('submit', function() {
                var formId = $(this).find('input[name="form_id"]').val();
                var formName = $(this).find('input[name="form_name"]').val();
                
                window.NirupTheme.Utils.trackEvent('elementor_form_submit', {
                    form_id: formId,
                    form_name: formName
                });
            });
        },

        // Generic plugin compatibility
        ensureCompatibility: function() {
            // Ensure our JavaScript doesn't conflict with other plugins
            
            // Namespace protection
            if (window.$ && window.$.fn.nirup) {
                window.NirupTheme.Utils.log('Warning: jQuery.nirup already exists');
            }

            // Event namespace protection
            $(document).off('.nirup');
            
            // Re-initialize if plugins are loaded dynamically
            $(document).on('pluginLoaded', function(e, pluginName) {
                window.NirupTheme.Utils.log('Plugin loaded dynamically:', pluginName);
                // Re-detect and initialize if needed
                setTimeout(function() {
                    this.detectPlugins();
                    this.initializeIntegrations();
                }.bind(this), 100);
            }.bind(this));
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        window.NirupTheme.Plugins.init();
        window.NirupTheme.Plugins.ensureCompatibility();
    });

    // Re-initialize on AJAX page loads (for SPA-like behavior)
    $(document).on('pjax:end ajaxComplete', function() {
        setTimeout(function() {
            window.NirupTheme.Plugins.detectPlugins();
            window.NirupTheme.Plugins.initializeIntegrations();
        }, 100);
    });

})(jQuery);