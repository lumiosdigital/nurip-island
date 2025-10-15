(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // Check if returning from WooCommerce payment
        checkForSuccessfulBooking();
        
        // Open modal for specific villa
        $(document).on('click', '.nirup-book-btn', function(e) {
            e.preventDefault();
            
            var villaId = $(this).data('villa-id');
            var modalId = '#nirup-booking-modal-' + villaId;
            
            console.log('Opening modal:', modalId);
            
            $(modalId).addClass('active').attr('aria-hidden','false');
            $('body').addClass('villa-booking-open');
            $(modalId + ' .villa-booking-close').focus();

            // Mark that we're starting a booking
            sessionStorage.setItem('nirup_booking_in_progress', 'true');

            setTimeout(function(){
                if (window.wpbs) {
                    if (typeof wpbs.init === 'function') wpbs.init();
                    $(document).trigger('wpbs:calendar_loaded');
                    $('.wpbs-calendar').trigger('wpbs:init');
                }
            }, 100);
        });
        
        // DO NOT INTERCEPT FORM SUBMISSION
        // Let WPBS + WooCommerce handle the redirect naturally
        
        // Close modal handlers
        $(document).on('click', '.villa-booking-close, .villa-booking-backdrop', function() {
            $(this).closest('.villa-booking-modal').removeClass('active').attr('aria-hidden', 'true');
            $('body').removeClass('villa-booking-open');
        });
        
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                $('.villa-booking-modal.active').removeClass('active').attr('aria-hidden', 'true');
                $('body').removeClass('villa-booking-open');
            }
        });
    });
    
    // Check if user just completed a booking payment
    function checkForSuccessfulBooking() {
        var urlParams = new URLSearchParams(window.location.search);
        var isOrderReceived = urlParams.has('order-received') || 
                             $('body').hasClass('woocommerce-order-received');
        
        var bookingInProgress = sessionStorage.getItem('nirup_booking_in_progress');
        
        if (isOrderReceived && bookingInProgress === 'true') {
            // Clear the flag
            sessionStorage.removeItem('nirup_booking_in_progress');
            
            // Show thank you modal
            var message = 'Thank you for your booking! Your payment has been confirmed and we will be in touch soon.';
            $('#villa-thankyou-text').text(message);
            $('#villa-thankyou-modal').addClass('active').attr('aria-hidden', 'false');
            
            // Auto-close after 6 seconds
            setTimeout(function() {
                $('#villa-thankyou-modal').removeClass('active').attr('aria-hidden', 'true');
            }, 6000);
        }
    }
    
})(jQuery);