/**
 * Nirup Island Theme JavaScript
 */

jQuery(document).ready(function($) {
    'use strict';

    // Mobile menu toggle
    $('.menu-toggle').on('click', function() {
        $(this).toggleClass('active');
        $('#primary-menu').toggleClass('active');
        $(this).attr('aria-expanded', $(this).attr('aria-expanded') === 'false' ? 'true' : 'false');
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

    // Close mobile menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.main-navigation').length) {
            $('.menu-toggle').removeClass('active');
            $('#primary-menu').removeClass('active');
            $('.menu-toggle').attr('aria-expanded', 'false');
        }
    });

    // Plugin-specific JavaScript will be added here as needed
    
    // WP Booking System integration hooks
    if (typeof wpbs !== 'undefined') {
        // Custom booking system functionality
    }
    
    // TranslatePress language switcher enhancements
    $('.trp-language-switcher').on('change', function() {
        // Custom language switch handling if needed
    });

});