/**
 * Villa Booking Modal - UPDATED WITH FORM ID SUPPORT
 * Replace the existing villa-booking.js file
 */
(function($) {
    'use strict';

    const VillaBooking = {
        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            // Open booking modal
            $('.single-villa-book-btn').on('click', this.openBookingModal.bind(this));
            
            // Close modal
            $(document).on('click', '.villa-booking-modal-close, .villa-booking-modal-backdrop', this.closeBookingModal.bind(this));
            
            // Prevent modal content click from closing
            $(document).on('click', '.villa-booking-modal-content', function(e) {
                e.stopPropagation();
            });
            
            // Close on ESC key
            $(document).keyup(function(e) {
                if (e.key === "Escape") {
                    VillaBooking.closeBookingModal();
                }
            });
        },

        openBookingModal: function(e) {
            e.preventDefault();
            
            const $button = $(e.currentTarget);
            const villaId = $button.data('villa-id');
            
            console.log('🏝️ Opening booking modal for villa:', villaId);
            
            // Create modal
            this.createModal();
            
            // Load calendar via AJAX
            this.loadCalendar(villaId);
        },

        createModal: function() {
            const modalHtml = `
                <div class="villa-booking-modal" style="display: none;">
                    <div class="villa-booking-modal-backdrop"></div>
                    <div class="villa-booking-modal-dialog">
                        <div class="villa-booking-modal-content">
                            <button class="villa-booking-modal-close" aria-label="Close">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </button>
                            <div class="villa-booking-modal-body">
                                <div class="villa-booking-loader">
                                    <div class="spinner"></div>
                                    <p>Loading booking calendar...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing modal if any
            $('.villa-booking-modal').remove();
            
            // Append new modal
            $('body').append(modalHtml);
            
            // Show modal with animation
            setTimeout(() => {
                $('.villa-booking-modal').fadeIn(300);
                $('body').addClass('villa-booking-modal-open');
            }, 10);
        },

        closeBookingModal: function() {
            $('.villa-booking-modal').fadeOut(300, function() {
                $(this).remove();
            });
            $('body').removeClass('villa-booking-modal-open');
        },

        loadCalendar: function(villaId) {
            console.log('📅 Loading calendar for villa:', villaId);
            
            $.ajax({
                url: wpbsAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'process_villa_booking_shortcode',
                    villa_id: villaId,
                    nonce: wpbsAjax.nonce
                },
                success: function(response) {
                    console.log('✅ AJAX Success:', response);
                    
                    if (response.success) {
                        console.log('📊 Calendar ID:', response.data.calendar_id);
                        console.log('📋 Form ID:', response.data.form_id);
                        
                        $('.villa-booking-modal-body').html(response.data.html);
                        
                        // Trigger WPBS initialization if needed
                        if (typeof wpbs !== 'undefined' && wpbs.init) {
                            wpbs.init();
                        }
                    } else {
                        $('.villa-booking-modal-body').html(`
                            <div class="villa-booking-error">
                                <p>⚠️ ${response.data.message}</p>
                            </div>
                        `);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('❌ AJAX Error:', error);
                    
                    $('.villa-booking-modal-body').html(`
                        <div class="villa-booking-error">
                            <p>⚠️ Unable to load booking calendar.</p>
                            <p style="font-size: 12px; color: #999; margin-top: 10px;">Error: ${error}</p>
                        </div>
                    `);
                }
            });
        }
    };

    // Initialize when document is ready
    $(document).ready(function() {
        VillaBooking.init();
    });

})(jQuery);