/**
 * Experience Booking Modal JavaScript
 * File: assets/js/experience-booking.js
 * Create this new file
 */

(function($) {
    'use strict';

    const ExperienceBooking = {
        init: function() {
            this.bindEvents();
            this.watchFormSubmission();
        },

        bindEvents: function() {
            // Open booking modal when experience book button is clicked
            $(document).on('click', '.experience-book-btn', this.openBookingModal.bind(this));
            
            // Close modal on backdrop or close button click
            $(document).on('click', '.villa-booking-close, .villa-booking-backdrop', this.closeBookingModal.bind(this));
            
            // Prevent modal content click from closing
            $(document).on('click', '.villa-booking-container', function(e) {
                e.stopPropagation();
            });
            
            // Close on ESC key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && $('.villa-booking-modal.active').length > 0) {
                    ExperienceBooking.closeBookingModal();
                }
            });
        },

        openBookingModal: function(e) {
            e.preventDefault();
            
            const $button = $(e.currentTarget);
            const experienceId = $button.data('experience-id');
            
            if (!experienceId) {
                console.error('No experience ID found on button');
                return;
            }
            
            console.log('🎯 Opening booking modal for experience:', experienceId);
            
            // Find and show the modal for this experience
            const $modal = $('#nirup-booking-modal-' + experienceId);
            
            if ($modal.length === 0) {
                console.error('No modal found for experience ID:', experienceId);
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
                window.NirupTheme.Utils.trackEvent('experience_booking_opened', {
                    experience_id: experienceId,
                    experience_name: $button.closest('.single-cta-section').find('.single-cta-title').text().trim()
                });
            }
        },

        closeBookingModal: function() {
            console.log('🚪 Closing experience booking modal');
            
            $('.villa-booking-modal').removeClass('active');
            $('.villa-booking-modal').attr('aria-hidden', 'true');
            $('body').removeClass('modal-open');
            
            // Track event if analytics available
            if (window.NirupTheme && window.NirupTheme.Utils) {
                window.NirupTheme.Utils.trackEvent('experience_booking_closed');
            }
        },

        watchFormSubmission: function() {
            // Watch for successful WPBS form submission
            $(document).on('wpbs_form_submit_success', function(event, data) {
                console.log('✅ Experience booking form submitted successfully');
                
                // Close the booking modal
                ExperienceBooking.closeBookingModal();
                
                // Track successful booking
                if (window.NirupTheme && window.NirupTheme.Utils) {
                    window.NirupTheme.Utils.trackEvent('experience_booking_submitted', {
                        form_data: data
                    });
                }
            });
        }
    };

    // Initialize when document is ready
    $(document).ready(function() {
        ExperienceBooking.init();
        console.log('🎯 Experience Booking Modal initialized');
    });

})(jQuery);