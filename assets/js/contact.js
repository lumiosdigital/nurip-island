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
            console.log('❌ Contact form not found on this page');
            return;
        }
        
        // DEBUG: Check if localized data is available
        if (typeof nirup_contact_ajax === 'undefined') {
            console.error('❌ nirup_contact_ajax is not defined! Script localization missing.');
            showMessage('Configuration error. Please contact the site administrator.', 'error');
            return;
        }
        

        // Form submission handler
        $form.on('submit', function(e) {
            e.preventDefault();
            
            console.log('📧 Form submission started...');
            
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
                console.log('❌ Validation failed: Missing required fields');
                showMessage('Please fill in all required fields.', 'error');
                return;
            }
            
            if (!isValidEmail(formData.email)) {
                console.log('❌ Validation failed: Invalid email');
                showMessage('Please enter a valid email address.', 'error');
                return;
            }
            
            
            // Show loading state
            $submitBtn.addClass('loading');
            
            // Prepare AJAX data
            const ajaxData = {
                action: 'nirup_contact_form_submit',
                nonce: nirup_contact_ajax.nonce,
                form_data: formData
            };

            $.ajax({
                url: nirup_contact_ajax.ajax_url,
                type: 'POST',
                data: ajaxData,
                success: function(response) {
                    
                    
                    if (response.success) {
                        
                        $form[0].reset();
                        

                        showThankYouModal();
                    } else {
                        showMessage(response.data.message || 'Something went wrong. Please try again.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('❌ AJAX Error:', status, error);
                    console.error('Response:', xhr.responseText);
                    showMessage('Failed to send your message. Please try again later.', 'error');
                },
                complete: function() {
                    console.log('🏁 AJAX request completed');
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