(function($) {
    'use strict';

    function initVillaSellingForm() {
        const $form = $('#villa-selling-form');
        const $submitBtn = $('.villa-selling-submit-btn');
        const $formMessage = $('#villa-form-message');
        const $modal = $('#villaThankYouModal');

        if (!$form.length) {
            console.log('❌ Villa selling form not found on this page');
            return;
        }

        if (typeof nirup_villa_selling_ajax === 'undefined') {
            console.error('❌ nirup_villa_selling_ajax is not defined! Script localization missing.');
            showMessage('Configuration error. Please contact the site administrator.', 'error');
            return;
        }

        $form.on('submit', function(e) {
            e.preventDefault();
            console.log('📧 Villa selling form submission started...');
            hideMessage();

            const formData = {
                name: $('#villa-name').val().trim(),
                email: $('#villa-email').val().trim(),
                phone: $('#villa-phone').val().trim(),
                language: $('#villa-language').val(),
                villa_unit: $('#villa-unit').val(),
                message: $('#villa-message').val().trim()
            };

            // Basic validation
            if (!formData.name || !formData.email || !formData.phone) {
                console.log('❌ Validation failed: Missing required fields');
                showMessage('Please fill in all required fields.', 'error');
                return;
            }
            if (!isValidEmail(formData.email)) {
                console.log('❌ Validation failed: Invalid email');
                showMessage('Please enter a valid email address.', 'error');
                return;
            }

            // Loading state
            $submitBtn.addClass('loading');

            // Function to send AJAX with optional token
            function sendVillaSellingAjax(recaptchaToken) {
                $.ajax({
                    url: nirup_villa_selling_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'nirup_villa_selling_form_submit',
                        nonce: nirup_villa_selling_ajax.nonce,
                        form_data: formData,
                        recaptcha_token: recaptchaToken
                    },
                    success: function(response) {
                        console.log('✅ Villa selling AJAX Success:', response);
                        if (response.success) {
                            console.log('✅ Villa form submitted successfully');
                            $form[0].reset();
                            showThankYouModal();
                        } else {
                            console.log('❌ Villa submission failed:', response.data.message);
                            const msg = response.data && response.data.message
                                ? response.data.message
                                : 'Something went wrong. Please try again.';
                            showMessage(msg, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('❌ Villa selling AJAX error:', status, error);
                        if (xhr && xhr.responseText) {
                            console.error('Response:', xhr.responseText);
                        }
                        showMessage('Failed to send your enquiry. Please try again later.', 'error');
                    },
                    complete: function() {
                        $submitBtn.removeClass('loading');
                    }
                });
            }

            // reCAPTCHA handling
            var hasRecaptcha =
                typeof nirup_villa_selling_ajax !== 'undefined' &&
                nirup_villa_selling_ajax.recaptcha &&
                nirup_villa_selling_ajax.recaptcha.site_key;

            if (hasRecaptcha && typeof grecaptcha !== 'undefined') {
                grecaptcha.ready(function() {
                    grecaptcha.execute(
                        nirup_villa_selling_ajax.recaptcha.site_key,
                        { action: nirup_villa_selling_ajax.recaptcha.action }
                    ).then(function(token) {
                        console.log('✅ Got reCAPTCHA token for villa selling');
                        sendVillaSellingAjax(token);
                    }).catch(function(err) {
                        console.warn('⚠️ reCAPTCHA error, sending without token', err);
                        sendVillaSellingAjax('');
                    });
                });
            } else {
                console.log('ℹ️ reCAPTCHA not configured or grecaptcha not loaded, sending without token');
                sendVillaSellingAjax('');
            }
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

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function showMessage(message, type) {
        const $formMessage = $('#villa-form-message');
        $formMessage
            .removeClass('success error')
            .addClass(type)
            .text(message)
            .fadeIn(300);

        setTimeout(function() {
            hideMessage();
        }, 5000);
    }

    function hideMessage() {
        $('#villa-form-message').fadeOut(300);
    }

    function showThankYouModal() {
        const $modal = $('#villaThankYouModal');
        $modal.addClass('active');
        $('body').css('overflow', 'hidden');

        setTimeout(function() {
            hideThankYouModal();
        }, 5000);
    }

    function hideThankYouModal() {
        const $modal = $('#villaThankYouModal');
        $modal.removeClass('active');
        $('body').css('overflow', '');
    }

    $(document).ready(function() {
        initVillaSellingForm();
    });

})(jQuery);