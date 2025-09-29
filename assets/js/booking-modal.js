/**
 * Booking Modal JavaScript
 * File: assets/js/booking-modal.js
 * 
 * Handles opening, closing, and accessibility for the booking modal
 */

(function($) {
    'use strict';

    // Booking Modal Handler
    window.NirupTheme = window.NirupTheme || {};
    window.NirupTheme.BookingModal = {
        
        config: {
            $modal: null,
            $backdrop: null,
            $closeBtn: null,
            $body: null,
            focusableElements: null,
            lastFocusedElement: null
        },

        init: function() {
            this.setupElements();
            this.bindEvents();
            this.setupAccessibility();
            
            if (window.NirupTheme && window.NirupTheme.Utils) {
                window.NirupTheme.Utils.log('Booking Modal initialized');
            }
        },

        setupElements: function() {
            this.config.$modal = $('#booking-modal');
            this.config.$backdrop = $('.booking-modal-backdrop');
            this.config.$closeBtn = $('.booking-modal-close');
            this.config.$body = $('body');
        },

        bindEvents: function() {
            var self = this;

            // Open modal when clicking Book Your Stay buttons
            $(document).on('click', '.booking-button, .hero-cta, .hero-cta-button, .mobile-booking-button', function(e) {
                e.preventDefault();
                self.openModal($(this));
            });

            // Close modal events
            this.config.$closeBtn.on('click', function(e) {
                e.preventDefault();
                self.closeModal();
            });

            this.config.$backdrop.on('click', function() {
                self.closeModal();
            });

            // Close on ESC key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && self.config.$modal.hasClass('active')) {
                    self.closeModal();
                }
            });

            // Track booking button clicks
            $(document).on('click', '.booking-option-button', function() {
                var buttonText = $(this).text().trim();
                var optionType = $(this).closest('.booking-option').hasClass('booking-option-resort') ? 'resort' : 'villas';
                
                if (window.NirupTheme && window.NirupTheme.Utils && window.NirupTheme.Utils.trackEvent) {
                    window.NirupTheme.Utils.trackEvent('booking_option_click', {
                        option_type: optionType,
                        button_text: buttonText
                    });
                }
            });
        },

        openModal: function($trigger) {
            var self = this;
            
            // Store the element that triggered the modal
            this.config.lastFocusedElement = $trigger[0];

            // Prevent body scroll
            this.config.$body.addClass('booking-modal-open');

            // Show modal
            this.config.$modal.addClass('active');
            this.config.$modal.attr('aria-hidden', 'false');

            // Focus trap setup
            setTimeout(function() {
                self.config.$closeBtn.focus();
                self.trapFocus();
            }, 100);

            // Track modal open event
            if (window.NirupTheme && window.NirupTheme.Utils && window.NirupTheme.Utils.trackEvent) {
                window.NirupTheme.Utils.trackEvent('booking_modal_open', {
                    trigger_element: $trigger.attr('class') || 'unknown'
                });
            }
        },

        closeModal: function() {
            // Hide modal
            this.config.$modal.removeClass('active');
            this.config.$modal.attr('aria-hidden', 'true');

            // Restore body scroll
            this.config.$body.removeClass('booking-modal-open');

            // Return focus to triggering element
            if (this.config.lastFocusedElement) {
                this.config.lastFocusedElement.focus();
                this.config.lastFocusedElement = null;
            }

            // Track modal close event
            if (window.NirupTheme && window.NirupTheme.Utils && window.NirupTheme.Utils.trackEvent) {
                window.NirupTheme.Utils.trackEvent('booking_modal_close');
            }
        },

        setupAccessibility: function() {
            // Set initial ARIA attributes
            this.config.$modal.attr('aria-hidden', 'true');
            this.config.$closeBtn.attr('aria-label', 'Close booking modal');
        },

        trapFocus: function() {
            var self = this;
            
            // Get all focusable elements
            var focusableSelector = 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
            this.config.focusableElements = this.config.$modal.find(focusableSelector).filter(':visible');

            if (this.config.focusableElements.length === 0) return;

            var firstFocusable = this.config.focusableElements.first();
            var lastFocusable = this.config.focusableElements.last();

            // Trap focus within modal
            this.config.$modal.on('keydown', function(e) {
                if (e.key !== 'Tab') return;

                if (e.shiftKey) {
                    // Shift + Tab
                    if (document.activeElement === firstFocusable[0]) {
                        e.preventDefault();
                        lastFocusable.focus();
                    }
                } else {
                    // Tab
                    if (document.activeElement === lastFocusable[0]) {
                        e.preventDefault();
                        firstFocusable.focus();
                    }
                }
            });
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        window.NirupTheme.BookingModal.init();
    });

})(jQuery);