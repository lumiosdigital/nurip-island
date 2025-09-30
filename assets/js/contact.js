/**
 * Contact Form JavaScript
 * Nirup Island Theme
 */

(function($) {
    'use strict';

    /**
     * Initialize Contact Form
     */
    function initContactForm() {
        const $form = $('#contact-form');
        const $submitBtn = $('.contact-submit-btn');
        const $formMessage = $('#form-message');
        const $modal = $('#thank-you-modal');
        
        if (!$form.length) {
            return;
        }

        // Form submission handler
        $form.on('submit', function(e) {
            e.preventDefault();
            
            // Clear previous messages
            hideMessage();
            
            // Get form data
            const formData = {
                name: $('#contact-name').val().trim(),
                email: $('#contact-email').val().trim(),
                phone: $('#contact-phone').val().trim(),
                inquiry_type: $('#contact-inquiry-type').val(),
                message: $('#contact-message').val().trim()
            };
            
            // Basic validation
            if (!formData.name || !formData.email || !formData.inquiry_type || !formData.message) {
                showMessage('Please fill in all required fields.', 'error');
                return;
            }
            
            if (!isValidEmail(formData.email)) {
                showMessage('Please enter a valid email address.', 'error');
                return;
            }
            
            // Show loading state
            $submitBtn.addClass('loading');
            
            // AJAX request
            $.ajax({
                url: nirup_contact_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'nirup_contact_form_submit',
                    nonce: nirup_contact_ajax.nonce,
                    form_data: formData
                },
                success: function(response) {
                    if (response.success) {
                        // Clear form
                        $form[0].reset();
                        
                        // Show thank you modal
                        showThankYouModal();
                    } else {
                        showMessage(response.data.message || 'Something went wrong. Please try again.', 'error');
                    }
                },
                error: function() {
                    showMessage('Failed to send your message. Please try again later.', 'error');
                },
                complete: function() {
                    // Remove loading state
                    $submitBtn.removeClass('loading');
                }
            });
        });

        // Modal overlay click to close
        $('.modal-overlay').on('click', function() {
            hideThankYouModal();
        });

        // ESC key to close modal
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $modal.hasClass('active')) {
                hideThankYouModal();
            }
        });
    }

    /**
     * Email validation
     */
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * Show form message
     */
    function showMessage(message, type) {
        const $formMessage = $('#form-message');
        $formMessage
            .removeClass('success error')
            .addClass(type)
            .text(message)
            .fadeIn(300);
        
        // Auto hide after 5 seconds
        setTimeout(function() {
            hideMessage();
        }, 5000);
    }

    /**
     * Hide form message
     */
    function hideMessage() {
        $('#form-message').fadeOut(300);
    }

    /**
     * Show thank you modal
     */
    function showThankYouModal() {
        const $modal = $('#thank-you-modal');
        $modal.addClass('active');
        $('body').css('overflow', 'hidden');
        
        // Auto close after 5 seconds
        setTimeout(function() {
            hideThankYouModal();
        }, 5000);
    }

    /**
     * Hide thank you modal
     */
    function hideThankYouModal() {
        const $modal = $('#thank-you-modal');
        $modal.removeClass('active');
        $('body').css('overflow', '');
    }

    /**
     * Initialize on document ready
     */
    $(document).ready(function() {
        initContactForm();
    });

})(jQuery);