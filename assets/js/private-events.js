(function ($) {
    'use strict';

    function initPrivateEventsForm() {
        var $form        = $('#private-events-form');
        var $submitBtn   = $('.private-form-submit-btn');
        var $formMessage = $('#form-message');
        var $modal       = $('#thank-you-modal');

        if (!$form.length) {
            console.log('❌ Private events form not found on this page');
            return;
        }

        if (typeof nirup_private_events_ajax === 'undefined') {
            console.error('❌ nirup_private_events_ajax is not defined! Script localization missing.');
            showMessage('Configuration error. Please contact the site administrator.', 'error');
            return;
        }

        $form.on('submit', function (e) {
            e.preventDefault();
            console.log('📧 Private events form submission started');
            hideMessage();

            var formData = {
                name:        ($('#event-name').val()    || '').trim(),
                email:       ($('#event-email').val()   || '').trim(),
                phone:       ($('#event-phone').val()   || '').trim(),
                event_type:  $('#event-type').val()     || '',
                event_date:  $('#event-date').val()     || '',
                // Field doesn’t exist in the markup right now – this keeps it safe
                guest_count: $('#event-guests').length ? $('#event-guests').val() : '',
                message:     ($('#event-message').val() || '').trim()
            };

            // Basic validation
            if (!formData.name || !formData.email || !formData.event_type || !formData.message) {
                console.log('❌ Validation failed: missing required fields', formData);
                showMessage('Please fill in all required fields.', 'error');
                return;
            }

            if (!isValidEmail(formData.email)) {
                console.log('❌ Validation failed: invalid email', formData.email);
                showMessage('Please enter a valid email address.', 'error');
                return;
            }

            // Loading state
            $submitBtn.addClass('loading');

            // Internal helper to actually send AJAX
            function sendPrivateEventsAjax(token) {
                var ajaxData = {
                    action:          'nirup_private_events_form_submit',
                    nonce:           nirup_private_events_ajax.nonce,
                    form_data:       formData,
                    recaptcha_token: token || ''
                };

                $.ajax({
                    url:      nirup_private_events_ajax.ajax_url,
                    type:     'POST',
                    dataType: 'json',
                    data:     ajaxData,
                    success: function (response) {
                        console.log('✅ Private events AJAX response:', response);

                        if (response && response.success) {
                            $form[0].reset();
                            showThankYouModal();
                        } else {
                            var msg = (response && response.data && response.data.message)
                                ? response.data.message
                                : 'Something went wrong. Please try again.';
                            showMessage(msg, 'error');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('❌ Private events AJAX error:', status, error);
                        if (xhr && xhr.responseText) {
                            console.error('Response:', xhr.responseText);
                        }
                        showMessage('Failed to send your request. Please try again later.', 'error');
                    },
                    complete: function () {
                        $submitBtn.removeClass('loading');
                    }
                });
            }

            // reCAPTCHA handling
            var hasRecaptcha =
                typeof nirup_private_events_ajax !== 'undefined' &&
                nirup_private_events_ajax.recaptcha &&
                nirup_private_events_ajax.recaptcha.site_key;

            if (hasRecaptcha && typeof grecaptcha !== 'undefined') {
                grecaptcha.ready(function () {
                    grecaptcha.execute(
                        nirup_private_events_ajax.recaptcha.site_key,
                        { action: nirup_private_events_ajax.recaptcha.action }
                    ).then(function (token) {
                        console.log('✅ Got reCAPTCHA token for private events');
                        sendPrivateEventsAjax(token);
                    }).catch(function (err) {
                        console.warn('⚠️ reCAPTCHA error, sending without token', err);
                        sendPrivateEventsAjax('');
                    });
                });
            } else {
                console.log('ℹ️ reCAPTCHA not configured or grecaptcha not loaded, sending without token');
                sendPrivateEventsAjax('');
            }
        });

        // Modal overlay click to close
        $('.modal-overlay').on('click', function () {
            hideThankYouModal();
        });

        // ESC key to close modal
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape' && $modal.hasClass('active')) {
                hideThankYouModal();
            }
        });
    }

    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function showMessage(message, type) {
        var $formMessage = $('#form-message');

        $formMessage
            .removeClass('success error')
            .addClass(type)
            .text(message)
            .fadeIn(300);

        setTimeout(function () {
            hideMessage();
        }, 5000);
    }

    function hideMessage() {
        $('#form-message').fadeOut(300);
    }

    function showThankYouModal() {
        var $modal = $('#thank-you-modal');
        $modal.addClass('active');
        $('body').css('overflow', 'hidden');

        setTimeout(function () {
            hideThankYouModal();
        }, 5000);
    }

    function hideThankYouModal() {
        var $modal = $('#thank-you-modal');
        $modal.removeClass('active');
        $('body').css('overflow', '');
    }

    $(document).ready(function () {
        initPrivateEventsForm();
    });

})(jQuery);
