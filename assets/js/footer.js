/**
 * Footer JavaScript - Newsletter Subscription and Interactions
 * Nirup Island Theme
 */

(function($) {
    'use strict';

    /**
     * Newsletter Subscription Handler
     */
    function initNewsletterSubscription() {
        const $form = $('#footer-newsletter-form');
        const $input = $('.newsletter-email-input');
        const $button = $('.newsletter-submit-btn');
        
        if (!$form.length) {
            console.log('Newsletter form not found');
            return;
        }

        $form.on('submit', function(e) {
            e.preventDefault();

            const email = $input.val().trim();

            console.log('📧 Newsletter form submitted');
            console.log('📧 Email:', email);

            // Basic validation
            if (!email) {
                console.log('❌ Validation failed: empty email');
                showMessage('Please enter your email address.', 'error');
                return;
            }

            if (!isValidEmail(email)) {
                console.log('❌ Validation failed: invalid email format');
                showMessage('Please enter a valid email address.', 'error');
                return;
            }

            console.log('✅ Email validation passed');

            // Show loading state
            const originalText = $button.text();
            $button.text(nirup_footer_ajax.messages.subscribing)
                   .prop('disabled', true)
                   .addClass('loading');

            console.log('📤 Sending AJAX request to:', nirup_footer_ajax.ajax_url);
            console.log('📤 Request data:', {
                action: 'nirup_newsletter_subscribe',
                email: email,
                nonce: nirup_footer_ajax.nonce
            });

            // AJAX request
            $.ajax({
                url: nirup_footer_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'nirup_newsletter_subscribe',
                    email: email,
                    nonce: nirup_footer_ajax.nonce
                },
                success: function(response) {
                    console.log('📥 Server response received:', response);

                    if (response.success) {
                        console.log('✅ Subscription successful!');
                        console.log('✅ Message:', response.data.message);
                        showMessage(response.data.message, 'success');
                        $input.val(''); // Clear the input
                    } else {
                        console.log('❌ Subscription failed');
                        console.log('❌ Error message:', response.data.message);
                        showMessage(response.data.message || nirup_footer_ajax.messages.error, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('❌ AJAX request failed');
                    console.log('❌ Status:', status);
                    console.log('❌ Error:', error);
                    console.log('❌ Response:', xhr.responseText);
                    showMessage(nirup_footer_ajax.messages.error, 'error');
                },
                complete: function() {
                    console.log('🏁 Request complete, resetting button');
                    // Reset button state
                    $button.text(originalText)
                           .prop('disabled', false)
                           .removeClass('loading');
                }
            });
        });
    }

    /**
     * Email validation helper
     */
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * Show message to user
     */
    function showMessage(message, type = 'info') {
        // Remove existing messages
        $('.footer-newsletter-message').remove();
        
        // Create message element
        const $message = $('<div>', {
            class: `footer-newsletter-message footer-newsletter-${type}`,
            html: message
        });
        
        // Add to DOM
        $('#footer-newsletter-form').after($message);
        
        // Fade in
        $message.hide().fadeIn(300);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            $message.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }

    /**
     * Social Media Link Analytics (optional)
     */
    function initSocialMediaTracking() {
        $('.footer-social-icons .social-link').on('click', function() {
            const platform = $(this).attr('class').match(/social-link\s+(\w+)/)?.[1] || 'unknown';
            
            // Google Analytics tracking (if available)
            if (typeof gtag !== 'undefined') {
                gtag('event', 'click', {
                    'event_category': 'Social Media',
                    'event_label': platform,
                    'value': 1
                });
            }
            
            // Console log for debugging
            console.log(`Social media link clicked: ${platform}`);
        });
    }

    /**
     * Contact Information Interactions
     */
    function initContactInteractions() {
        // Track phone number clicks
        $('.footer-contact-text a[href^="tel:"]').on('click', function() {
            const phoneNumber = $(this).text().trim();
            
            if (typeof gtag !== 'undefined') {
                gtag('event', 'click', {
                    'event_category': 'Contact',
                    'event_label': 'Phone Call',
                    'value': phoneNumber
                });
            }
            
            console.log(`Phone number clicked: ${phoneNumber}`);
        });

        // Track email clicks
        $('.footer-contact-text a[href^="mailto:"]').on('click', function() {
            const email = $(this).text().trim();
            
            if (typeof gtag !== 'undefined') {
                gtag('event', 'click', {
                    'event_category': 'Contact',
                    'event_label': 'Email',
                    'value': email
                });
            }
            
            console.log(`Email link clicked: ${email}`);
        });
    }

    /**
     * Footer Menu Enhancement
     */
    function initFooterMenus() {
        // Add smooth scrolling for internal links
        $('.footer-nav-menu a[href^="#"]').on('click', function(e) {
            e.preventDefault();
            
            const target = $($(this).attr('href'));
            
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 100 // Account for fixed header
                }, 800);
            }
        });

        // Track footer navigation clicks
        $('.footer-nav-menu a').on('click', function() {
            const linkText = $(this).text().trim();
            const column = $(this).closest('.footer-nav-column').find('.footer-nav-title').text();
            
            if (typeof gtag !== 'undefined') {
                gtag('event', 'click', {
                    'event_category': 'Footer Navigation',
                    'event_label': `${column} - ${linkText}`,
                    'value': 1
                });
            }
            
            console.log(`Footer menu clicked: ${column} - ${linkText}`);
        });
    }

    /**
     * Responsive Footer Adjustments
     */
    function initResponsiveFooter() {
        function adjustFooterLayout() {
            const $footer = $('.site-footer');
            const $socialIcons = $('.footer-social-icons');
            const $logoSection = $('.footer-logo-section');
            
            if ($(window).width() <= 1024) {
                // Mobile/tablet adjustments
                if ($socialIcons.parent().hasClass('footer-content')) {
                    $logoSection.append($socialIcons);
                }
            } else {
                // Desktop layout
                if (!$socialIcons.parent().hasClass('footer-content')) {
                    $('.footer-content').append($socialIcons);
                }
            }
        }
        
        // Initial adjustment
        adjustFooterLayout();
        
        // Adjust on window resize
        $(window).on('resize', debounce(adjustFooterLayout, 250));
    }

    /**
     * Debounce helper function
     */
    function debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction() {
            const context = this;
            const args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    /**
     * Initialize all footer functionality
     */
    function initFooter() {
        initNewsletterSubscription();
        initSocialMediaTracking();
        initContactInteractions();
        initFooterMenus();
        initResponsiveFooter();
        
        console.log('Footer functionality initialized');
    }

    // Initialize when DOM is ready
    $(document).ready(function() {
        initFooter();
    });

    // Make functions available globally if needed
    window.nirupFooter = {
        showMessage: showMessage,
        isValidEmail: isValidEmail
    };

})(jQuery);