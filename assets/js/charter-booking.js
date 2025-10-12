/**
 * Charter Booking Modal JavaScript
 * File: assets/js/charter-booking.js
 * Create this new file
 */

(function($) {
    'use strict';

    const CharterBooking = {
        init: function() {
            this.bindEvents();
            this.watchFormSubmission();
        },

        bindEvents: function() {
            // Open booking modal when charter book button is clicked
            $(document).on('click', '.charter-book-btn', this.openBookingModal.bind(this));
            
            // Close modal on backdrop or close button click
            $(document).on('click', '.villa-booking-close, .villa-booking-backdrop', this.closeBookingModal.bind(this));
            
            // Prevent modal content click from closing
            $(document).on('click', '.villa-booking-container', function(e) {
                e.stopPropagation();
            });
            
            // Close on ESC key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && $('.villa-booking-modal.active').length > 0) {
                    CharterBooking.closeBookingModal();
                }
            });
        },

        openBookingModal: function(e) {
            e.preventDefault();
            
            const $button = $(e.currentTarget);
            const charterId = $button.data('charter-id');
            
            if (!charterId) {
                console.error('No charter ID found on button');
                return;
            }
            
            console.log('⛵ Opening booking modal for charter:', charterId);
            
            // Find and show the modal for this charter
            const $modal = $('#nirup-booking-modal-' + charterId);
            
            if ($modal.length === 0) {
                console.error('No modal found for charter ID:', charterId);
                return;
            }
            
            // Show modal
            $modal.attr('aria-hidden', 'false');
            $modal.addClass('active');
            $('body').addClass('modal-open');
            
            // Initialize WPBS if available
            setTimeout(function(){
                if (window.wpbs) {
                    if (typeof wpbs.init === 'function') wpbs.init();
                    $(document).trigger('wpbs:calendar_loaded');
                    $('.wpbs-calendar').trigger('wpbs:init');
                }
            }, 100);
            
            // Track event if analytics available
            if (window.NirupTheme && window.NirupTheme.Utils) {
                window.NirupTheme.Utils.trackEvent('charter_booking_opened', {
                    charter_id: charterId,
                    charter_name: $button.closest('.charter-content').find('.charter-name').text().trim()
                });
            }
        },

        closeBookingModal: function(e) {
            if (e) {
                e.preventDefault();
            }
            
            console.log('⛵ Closing charter booking modal');
            
            const $activeModal = $('.villa-booking-modal.active');
            
            // Hide modal if found
            if ($activeModal.length > 0) {
                $activeModal.attr('aria-hidden', 'true');
                $activeModal.removeClass('active');
            }
            
            // ALWAYS remove modal-open class and restore scroll, even if no active modal
            $('body').removeClass('modal-open').css('overflow', '');
            
            // Track event if analytics available
            if (window.NirupTheme && window.NirupTheme.Utils) {
                window.NirupTheme.Utils.trackEvent('charter_booking_closed');
            }
        },

        watchFormSubmission: function() {
            // Detect WPBS form submission success
            var checkInterval = setInterval(function() {
                var $confirmation = $('.wpbs-form-confirmation-message');
                
                if ($confirmation.length > 0 && $confirmation.is(':visible')) {
                    clearInterval(checkInterval);
                    
                    $confirmation.hide();
                    
                    var message = $confirmation.find('p').text() || 'We have received your booking request and will contact you soon.';
                    
                    // Close all booking modals
                    $('.villa-booking-modal').removeClass('active').attr('aria-hidden', 'true');
                    $('body').removeClass('modal-open').css('overflow', '');
                    
                    // Show thank you modal
                    $('#villa-thankyou-text').text(message);
                    $('#villa-thankyou-modal').addClass('active').attr('aria-hidden', 'false');
                    
                    // Reload after 4 seconds
                    setTimeout(function() {
                        window.location.reload();
                    }, 4000);
                }
            }, 500);
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        CharterBooking.init();
        console.log('⛵ Charter Booking initialized');
    });

})(jQuery);