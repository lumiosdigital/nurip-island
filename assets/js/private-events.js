(function($) {
    'use strict';

    /**
     * Initialize Private Events Form
     */
    function initPrivateEventsForm() {
        const $form = $('#private-events-form');
        const $submitBtn = $('.private-form-submit-btn');
        const $formMessage = $('#form-message');
        const $modal = $('#thank-you-modal');
        
        if (!$form.length) {
            return;
        }

        console.log('🎉 Private Events Form initialized');

        // Form submission handler
        $form.on('submit', function(e) {
            e.preventDefault();
            
            console.log('📝 Form submitted');
            
            // Clear previous messages
            hideMessage();
            
            // Get form data
            const formData = {
                name: $('#event-name').val().trim(),
                email: $('#event-email').val().trim(),
                phone: $('#event-phone').val().trim(),
                event_type: $('#event-type').val(),
                event_date: $('#event-date').val(),
                guest_count: $('#event-guests').val(),
                message: $('#event-message').val().trim()
            };
            
            console.log('📋 Form data:', formData);
            
            // Basic validation
            if (!formData.name || !formData.email || !formData.event_type || !formData.message) {
                showMessage('Please fill in all required fields.', 'error');
                return;
            }
            
            if (!isValidEmail(formData.email)) {
                showMessage('Please enter a valid email address.', 'error');
                return;
            }
            
            // Show loading state
            $submitBtn.addClass('loading');
            console.log('⏳ Sending AJAX request...');
            
            // AJAX request
            $.ajax({
                url: window.nirup_private_events_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'nirup_private_events_form_submit',
                    nonce: window.nirup_private_events_ajax.nonce,
                    form_data: formData
                },
                success: function(response) {
                    console.log('✅ AJAX Success:', response);
                    
                    if (response.success) {
                        // Clear form
                        $form[0].reset();
                        
                        // Show thank you modal
                        showThankYouModal();
                        
                        console.log('🎊 Form submission successful!');
                    } else {
                        console.error('❌ Error:', response.data.message);
                        showMessage(response.data.message || 'Something went wrong. Please try again.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('❌ AJAX Error:', status, error);
                    console.error('Response:', xhr.responseText);
                    showMessage('Failed to send your request. Please try again later.', 'error');
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
        initPrivateEventsForm();
    });

})(jQuery);