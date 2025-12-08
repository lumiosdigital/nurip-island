/**
 * Nirup Theme - Check Availability Button Handler
 * File: assets/js/check-availability.js
 */

(function($) {
    'use strict';

    window.NirupTheme = window.NirupTheme || {};

    window.NirupTheme.CheckAvailability = {
        
        // Initialize
        init: function() {
            this.bindEvents();
            this.setupAccessibility();

            // Make sure labels are already correct before the modal is opened
            this.customizeLabels();

            window.NirupTheme.Utils.log('Check Availability module initialized');
        },


        // Bind events
        bindEvents: function() {
            var self = this;

            // Check availability button click
            $('.check-availability-toggle').on('click', function(e) {
                e.preventDefault();
                self.handleCheckAvailability();
            });

            // Keyboard support
            $('.check-availability-toggle').on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    self.handleCheckAvailability();
                }
            });
        },

        // Setup accessibility
        setupAccessibility: function() {
            var $toggle = $('.check-availability-toggle');
            
            // ARIA attributes
            $toggle.attr('aria-label', 'Check availability and book your stay');
        },

        // Handle check availability action
        handleCheckAvailability: function() {
            window.NirupTheme.Utils.log('Check availability clicked');
            
            // Open the check availability modal
            this.openModal();
            
            // Track event
            window.NirupTheme.Utils.trackEvent('Navigation', 'Check Availability Click', 'Header Button');
        },

        // Open check availability modal
        openModal: function() {
            var self = this;
            var $modal = $('#check-availability-modal');
            var $body = $('body');
            
            if ($modal.length === 0) {
                window.NirupTheme.Utils.log('Check availability modal not found', 'error');
                return;
            }
            
            window.NirupTheme.Utils.log('Opening check availability modal');
            
            // Show modal
            $modal.addClass('active');
            $modal.attr('aria-hidden', 'false');
            
            // Lock body scroll
            $body.addClass('check-availability-modal-open');
            
            // Customize labels after modal is shown
            setTimeout(function() {
                self.customizeLabels();
                self.preventAutoOpenDatepicker();
            }, 100);
            
            // Bind close events
            this.bindCloseEvents($modal);
        },

        // Customize WPBS labels
        customizeLabels: function() {
            var $modal = $('#check-availability-modal');

            // START DATE → CHECK-IN
            var $startLabel = $modal.find(
                '.wpbs_s-search-widget-field-start-date label, ' +
                '.wpbs-search-widget-field-start-date label'
            ).first();

            if (!$startLabel.length) {
                $startLabel = $modal.find('label').filter(function() {
                    return $(this).text().trim().toLowerCase() === 'start date';
                }).first();
            }

            if ($startLabel.length) {
                $startLabel.text('Check-in');
            }

            // END DATE → CHECK-OUT
            var $endLabel = $modal.find(
                '.wpbs_s-search-widget-field-end-date label, ' +
                '.wpbs-search-widget-field-end-date label'
            ).first();

            if (!$endLabel.length) {
                $endLabel = $modal.find('label').filter(function() {
                    return $(this).text().trim().toLowerCase() === 'end date';
                }).first();
            }

            if ($endLabel.length) {
                $endLabel.text('Check-out');
            }

            window.NirupTheme.Utils.log('Labels customized to Check-in/Check-out');
        },


        // Prevent datepicker from auto-opening
        preventAutoOpenDatepicker: function() {
            var $modal = $('#check-availability-modal');
            
            // Remove focus from any date inputs
            $modal.find('.wpbs_s-search-widget-datepicker').blur();
            
            // Prevent any jQuery UI datepicker from opening automatically
            if (typeof $.datepicker !== 'undefined') {
                $.datepicker._hideDatepicker();
            }
            
            // Additional prevention: temporarily disable the datepicker inputs
            $modal.find('.wpbs_s-search-widget-datepicker').each(function() {
                var $input = $(this);
                
                // Store the original click handler
                var clickEvents = $._data($input[0], 'events');
                
                // Temporarily unbind focus/click events
                $input.off('focus.wpbs click.wpbs');
                
                // Re-bind after a short delay
                setTimeout(function() {
                    if (clickEvents && clickEvents.focus) {
                        clickEvents.focus.forEach(function(event) {
                            $input.on('focus.wpbs', event.handler);
                        });
                    }
                    if (clickEvents && clickEvents.click) {
                        clickEvents.click.forEach(function(event) {
                            $input.on('click.wpbs', event.handler);
                        });
                    }
                }, 500);
            });
            
            window.NirupTheme.Utils.log('Prevented auto-opening datepicker');
        },

        // Close modal
        closeModal: function() {
            var $modal = $('#check-availability-modal');
            var $body = $('body');
            
            window.NirupTheme.Utils.log('Closing check availability modal');
            
            // Hide modal
            $modal.removeClass('active');
            $modal.attr('aria-hidden', 'true');
            
            // Unlock body scroll
            $body.removeClass('check-availability-modal-open');
            
            // Close any open datepickers
            if (typeof $.datepicker !== 'undefined') {
                $.datepicker._hideDatepicker();
            }
            
            // Unbind close events
            this.unbindCloseEvents($modal);
        },

        // Bind close events for modal
        bindCloseEvents: function($modal) {
            var self = this;
            
            // Close button click
            $modal.find('.check-availability-close').on('click.checkAvailability', function(e) {
                e.preventDefault();
                self.closeModal();
            });
            
            // Backdrop click
            $modal.find('.check-availability-backdrop').on('click.checkAvailability', function(e) {
                e.preventDefault();
                self.closeModal();
            });
            
            // ESC key press
            $(document).on('keydown.checkAvailability', function(e) {
                if (e.key === 'Escape' || e.keyCode === 27) {
                    self.closeModal();
                }
            });
        },

        // Unbind close events
        unbindCloseEvents: function($modal) {
            $modal.find('.check-availability-close').off('click.checkAvailability');
            $modal.find('.check-availability-backdrop').off('click.checkAvailability');
            $(document).off('keydown.checkAvailability');
        }
    };

    // Initialize when document is ready
    $(document).ready(function() {
        window.NirupTheme.CheckAvailability.init();
    });

})(jQuery);