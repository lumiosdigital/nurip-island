/**
 * Nirup Island Theme JavaScript - Fixed Based on Working Version
 */

jQuery(document).ready(function($) {
    'use strict';

    console.log('Nirup Theme JS loaded - based on working version');

    // Mobile menu toggle with improved animations
    $('.mobile-menu-toggle').on('click', function() {
        console.log('Mobile menu toggle clicked');
        var $toggle = $(this);
        var $menu = $('.mobile-menu');
        var $body = $('body');
        
        $toggle.toggleClass('active');
        
        if ($toggle.hasClass('active')) {
            $menu.show().addClass('active');
            $body.addClass('mobile-menu-open');
            $toggle.attr('aria-expanded', 'true');
        } else {
            $menu.removeClass('active');
            setTimeout(function() {
                $menu.hide();
            }, 300);
            $body.removeClass('mobile-menu-open');
            $toggle.attr('aria-expanded', 'false');
        }
    });

    // Search overlay toggle with improved animations
    $('.search-toggle').on('click', function(e) {
        e.preventDefault();
        console.log('Search toggle clicked');
        var $overlay = $('.search-overlay');
        
        $overlay.show().addClass('active');
        $('body').addClass('search-open');
        
        setTimeout(function() {
            $('.search-field').focus();
        }, 350);
    });

    // Close search overlay - Fixed version
    $('.search-close').on('click', function(e) {
        e.preventDefault();
        console.log('Search close clicked');
        var $overlay = $('.search-overlay');
        $overlay.removeClass('active');
        $('body').removeClass('search-open');
        
        setTimeout(function() {
            $overlay.hide();
        }, 300);
    });

    // Close search when clicking overlay background
    $('.search-overlay').on('click', function(e) {
        if (e.target === this) {
            console.log('Search overlay background clicked');
            var $overlay = $(this);
            $overlay.removeClass('active');
            $('body').removeClass('search-open');
            
            setTimeout(function() {
                $overlay.hide();
            }, 300);
        }
    });

    // Language dropdown functionality - FIXED to match your HTML structure
    $('.language-current').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Language dropdown clicked');
        
        var $container = $(this).closest('.language-switcher-container');
        
        // Close other dropdowns
        $('.language-switcher-container').not($container).removeClass('active');
        
        // Toggle current dropdown
        $container.toggleClass('active');
    });

    // Language option selection
    $(document).on('click', '.language-option a', function(e) {
        console.log('Language option clicked:', $(this).text());
        
        var selectedLang = $(this).text();
        var $container = $(this).closest('.language-switcher-container');
        var $currentButton = $container.find('.language-current');
        
        // Update the current language display - simple method
        var $textNode = $currentButton.contents().filter(function() {
            return this.nodeType === 3;
        }).first();
        
        if ($textNode.length) {
            $textNode[0].nodeValue = selectedLang;
        }
        
        // Close dropdown
        $container.removeClass('active');
        
        // Update current language styling
        $container.find('.language-option').removeClass('current-language');
        $(this).closest('.language-option').addClass('current-language');
        
        // Let the link work normally for TranslatePress
    });

    // Close language dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.language-switcher-container').length) {
            $('.language-switcher-container').removeClass('active');
        }
    });

    // Close overlays with Escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            // Close search overlay
            var $searchOverlay = $('.search-overlay');
            if ($searchOverlay.hasClass('active')) {
                $searchOverlay.removeClass('active');
                $('body').removeClass('search-open');
                setTimeout(function() {
                    $searchOverlay.hide();
                }, 300);
            }
            
            // Close language dropdown
            $('.language-switcher-container').removeClass('active');
            
            // Close mobile menu
            var $mobileMenu = $('.mobile-menu');
            if ($mobileMenu.hasClass('active')) {
                $mobileMenu.removeClass('active');
                $('.mobile-menu-toggle').removeClass('active');
                $('body').removeClass('mobile-menu-open');
                $('.mobile-menu-toggle').attr('aria-expanded', 'false');
                setTimeout(function() {
                    $mobileMenu.hide();
                }, 300);
            }
        }
    });

    // Close mobile menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.mobile-menu, .mobile-menu-toggle').length) {
            var $menu = $('.mobile-menu');
            var $toggle = $('.mobile-menu-toggle');
            
            if ($menu.hasClass('active')) {
                $menu.removeClass('active');
                $toggle.removeClass('active');
                $('body').removeClass('mobile-menu-open');
                $toggle.attr('aria-expanded', 'false');
                
                setTimeout(function() {
                    $menu.hide();
                }, 300);
            }
        }
    });

    // Smooth scrolling for anchor links
    $('a[href*="#"]:not([href="#"])').on('click', function() {
        if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
            location.hostname === this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 1000);
                return false;
            }
        }
    });

    // Announcement bar link functionality
    $('.announcement-link').on('click', function(e) {
        // If no link is provided, prevent default action
        if ($(this).attr('href') === '#' || $(this).attr('href') === '') {
            e.preventDefault();
        }
    });

    // Navigation menu accessibility enhancements
    $('.primary-menu-left a, .secondary-menu a').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });

    // Booking button analytics tracking
    $('.booking-button, .mobile-booking-button').on('click', function() {
        var buttonText = $(this).text();
        var buttonLocation = $(this).hasClass('mobile-booking-button') ? 'mobile' : 'desktop';
        
        // Microsoft Clarity tracking
        if (typeof clarity !== 'undefined') {
            clarity('event', 'booking_button_click', {
                location: buttonLocation,
                text: buttonText
            });
        }
    });

    // Search form enhancements
    $('.search-form').on('submit', function() {
        var searchTerm = $('.search-field').val();
        
        // Analytics tracking for search
        if (typeof gtag !== 'undefined') {
            gtag('event', 'search', {
                search_term: searchTerm
            });
        }
        
        // Microsoft Clarity tracking
        if (typeof clarity !== 'undefined') {
            clarity('event', 'search_performed', {
                search_term: searchTerm
            });
        }
    });

    // Plugin-specific JavaScript integration
    
    // WP Booking System integration hooks
    if (typeof wpbs !== 'undefined') {
        // Custom booking system functionality can be added here
        $(document).on('wpbs_calendar_loaded', function() {
            console.log('WP Booking System calendar loaded');
        });
    }
    
    // TranslatePress language switcher enhancements
    if (typeof trp_data !== 'undefined') {
        // TranslatePress is active
        $(document).on('change', '.trp-language-switcher select', function() {
            var selectedLanguage = $(this).val();
            
            // Track language changes
            if (typeof gtag !== 'undefined') {
                gtag('event', 'language_change', {
                    language: selectedLanguage
                });
            }
        });
    }

    // Brevo form integration
    $(document).on('submit', '.sib-form', function() {
        // Track newsletter subscriptions
        if (typeof gtag !== 'undefined') {
            gtag('event', 'newsletter_signup', {
                event_category: 'engagement'
            });
        }
    });

    // Handle window resize for responsive behavior
    var resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if ($(window).width() > 768) {
                // Close mobile menu on desktop
                $('.mobile-menu').removeClass('active').hide();
                $('.mobile-menu-toggle').removeClass('active');
                $('body').removeClass('mobile-menu-open');
                $('.mobile-menu-toggle').attr('aria-expanded', 'false');
                
                // Close language dropdown
                $('.language-switcher-container').removeClass('active');
            }
        }, 250);
    });

    // Preload critical images for better performance
    function preloadImages() {
        var images = [
            // Add paths to critical images that should be preloaded
            // Example: '/wp-content/themes/nirup-island/assets/images/logo.svg'
        ];
        
        images.forEach(function(src) {
            var img = new Image();
            img.src = src;
        });
    }
    
    // Call preload function
    preloadImages();

    // Add loading states for better UX
    $('.search-form').on('submit', function() {
        $(this).closest('.search-overlay').addClass('loading');
    });

    // Remove loading states when page loads
    $(window).on('load', function() {
        $('.loading').removeClass('loading');
    });

    console.log('Nirup Theme JS initialization complete');

});