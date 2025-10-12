(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // Open modal for specific villa
        $(document).on('click', '.nirup-book-btn', function(e) {
            e.preventDefault();
            
            var villaId = $(this).data('villa-id');
            var modalId = '#nirup-booking-modal-' + villaId;
            
            console.log('Opening modal:', modalId);
            
            $(modalId).addClass('active').attr('aria-hidden','false');
            $('body').addClass('villa-booking-open');
            $(modalId + ' .villa-booking-close').focus();

            setTimeout(function(){
                if (window.wpbs) {
                    if (typeof wpbs.init === 'function') wpbs.init();
                    $(document).trigger('wpbs:calendar_loaded');
                    $('.wpbs-calendar').trigger('wpbs:init');
                }
            }, 100);
        });
        
        // Detect WPBS form submission success
        var checkInterval = setInterval(function() {
            var $confirmation = $('.wpbs-form-confirmation-message');
            
            if ($confirmation.length > 0 && $confirmation.is(':visible')) {
                clearInterval(checkInterval);
                
                $confirmation.hide();
                
                var message = $confirmation.find('p').text() || 'We have received your booking request and will contact you soon.';
                
                // Close all booking modals
                $('.villa-booking-modal').removeClass('active').attr('aria-hidden', 'true');
                
                $('#villa-thankyou-text').text(message);
                $('#villa-thankyou-modal').addClass('active').attr('aria-hidden', 'false');
                
                setTimeout(function() {
                    window.location.reload();
                }, 4000);
            }
        }, 500);
                    
        // Close modal
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
    
})(jQuery);