(function($) {
    'use strict';

    function initBerthingForm() {
        var $form        = $('#berthing-form');
        var $submitBtn   = $form.find('.berthing-submit-btn');
        var $formMessage = $('#berthing-form-message');
        var $modal       = $('#berthing-thank-you-modal');

        if (!$form.length) {
            console.log('[Berthing] Form NOT found on this page, skipping init.');
            return;
        }

        console.log('[Berthing] Form found, initializing…');

        // We'll store selected File objects here, keyed by field name
        var selectedFiles = {};

        function isValidEmail(email) {
            return /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email);
        }

        function showMessage(message, type) {
            if (!$formMessage.length) return;
            $formMessage
                .removeClass('berthing-message-success berthing-message-error success error')
                .addClass(type === 'error'
                    ? 'berthing-message-error error'
                    : 'berthing-message-success success')
                .text(message)
                .show();
        }

        function hideMessage() {
            if (!$formMessage.length) return;
            $formMessage
                .hide()
                .text('')
                .removeClass('berthing-message-success berthing-message-error success error');
        }

        function setLoading(isLoading) {
            if (!$submitBtn.length) return;
            if (isLoading) {
                $submitBtn.addClass('loading').prop('disabled', true);
                $submitBtn.find('.submit-text').hide();
                $submitBtn.find('.submit-loading').show();
            } else {
                $submitBtn.removeClass('loading').prop('disabled', false);
                $submitBtn.find('.submit-text').show();
                $submitBtn.find('.submit-loading').hide();
            }
        }

        function showThankYouModal() {
            if (!$modal.length) return;
            $modal.addClass('active');
            $('body').css('overflow', 'hidden');
            setTimeout(hideThankYouModal, 5000);
        }

        function hideThankYouModal() {
            if (!$modal.length) return;
            $modal.removeClass('active');
            $('body').css('overflow', '');
        }

        // Close modal on overlay / ESC
        if ($modal && $modal.length) {
            $modal.on('click', '.modal-overlay', function(e) {
                e.preventDefault();
                hideThankYouModal();
            });
        }
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $modal && $modal.hasClass('active')) {
                hideThankYouModal();
            }
        });

        // File label updates + capture File object
        $form.on('change', '.berthing-file-upload input[type="file"]', function() {
            var input      = this;
            var $input     = $(input);
            var $container = $input.closest('.berthing-file-upload');
            var $fileName  = $container.find('.file-name');
            var fieldName  = $input.attr('name');

            console.log(
                '[Berthing] File input changed:',
                'id=' + input.id,
                'name=' + fieldName,
                'files.length=' + (input.files ? input.files.length : 0)
            );

            if (input.files && input.files.length > 0) {
                var file   = input.files[0];
                var sizeMb = (file.size / (1024 * 1024)).toFixed(2);

                // Remember this file under its field name
                if (fieldName) {
                    selectedFiles[fieldName] = file;
                    console.log('[Berthing] Stored file for', fieldName, '=>', file.name, file.size);
                }

                $container.addClass('has-file');
                $fileName.text(file.name + ' (' + sizeMb + ' MB)');
            } else {
                // No file, clear UI + stored file
                if (fieldName && selectedFiles[fieldName]) {
                    delete selectedFiles[fieldName];
                    console.log('[Berthing] Cleared stored file for', fieldName);
                }
                $container.removeClass('has-file');
                $fileName.text('');
            }
        });

        // --- Core submit handler ---
        function handleSubmit(e) {
            if (e) e.preventDefault();

            console.log('[Berthing] Submit handler fired');
            hideMessage();

            if (typeof nirup_berthing_ajax === 'undefined') {
                console.error('[Berthing] nirup_berthing_ajax is not defined.');
                showMessage('Configuration error. Please contact the site administrator.', 'error');
                return;
            }

            // Basic text/email validation only
            var yacht_owner_name = $.trim($form.find('[name="yacht_owner_name"]').val());
            var contact_name     = $.trim($form.find('[name="contact_name"]').val());
            var email            = $.trim($form.find('[name="email"]').val());
            var vessel_name      = $.trim($form.find('[name="vessel_name"]').val());

            if (!yacht_owner_name || !contact_name || !email || !vessel_name) {
                console.log('[Berthing] Client validation failed: missing required text fields');
                showMessage('Please fill in all required fields.', 'error');
                return;
            }

            if (!isValidEmail(email)) {
                console.log('[Berthing] Client validation failed: invalid email');
                showMessage('Please enter a valid email address.', 'error');
                return;
            }

            setLoading(true);

            // -------------------------------
            // Build FormData MANUALLY
            // -------------------------------
            var formData = new FormData();

            // Append all non-file fields
            $form.find('input, select, textarea').each(function() {
                var $field = $(this);
                var name   = $field.attr('name');
                if (!name) return;

                var type = ($field.attr('type') || '').toLowerCase();
                if (type === 'file') return; // skip files here, handled below

                if ((type === 'checkbox' || type === 'radio') && !$field.is(':checked')) {
                    return;
                }

                formData.append(name, $field.val());
            });

            // Required file field names (must match PHP $file_fields)
            var fileNames = [
                'vessel_registration',
                'vessel_insurance',
                'vessel_mmsi',
                'crew_list',
                'passenger_list',
                'port_clearance'
            ];

            fileNames.forEach(function(name) {
                var file = selectedFiles[name];
                if (file) {
                    console.log('[Berthing] Appending stored file for', name, '=>', file.name, file.size);
                    formData.append(name, file);
                } else {
                    console.log('[Berthing] No stored file for', name);
                }
            });

            // WP AJAX fields
            formData.append('action', 'nirup_berthing_form_submit');
            formData.append('nonce', nirup_berthing_ajax.nonce || '');

            // Debug: log FormData keys
            for (var pair of formData.entries()) {
                console.log('[Berthing] FormData:', pair[0], pair[1]);
            }

            function sendAjax(token) {
                if (token) {
                    formData.append('recaptcha_token', token);
                }

                $.ajax({
                    url: nirup_berthing_ajax.ajax_url,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json'
                }).done(function(response) {
                    console.log('[Berthing] AJAX done:', response);
                    if (response && response.success) {
                        var msg = response.data && response.data.message
                            ? response.data.message
                            : 'Your berthing request has been sent successfully.';

                        showMessage(msg, 'success');

                        if ($form[0]) $form[0].reset();
                        selectedFiles = {}; // clear stored files
                        $form.find('.berthing-file-upload')
                             .removeClass('has-file')
                             .find('.file-name').text('');

                        showThankYouModal();
                    } else {
                        var errMsg = response && response.data && response.data.message
                            ? response.data.message
                            : 'Something went wrong. Please try again.';
                        showMessage(errMsg, 'error');
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('[Berthing] AJAX fail:', textStatus, errorThrown);
                    showMessage('Something went wrong. Please try again.', 'error');
                }).always(function() {
                    setLoading(false);
                });
            }

            var hasRecaptcha =
                nirup_berthing_ajax.recaptcha &&
                nirup_berthing_ajax.recaptcha.site_key;

            if (hasRecaptcha && typeof grecaptcha !== 'undefined') {
                grecaptcha.ready(function() {
                    grecaptcha.execute(
                        nirup_berthing_ajax.recaptcha.site_key,
                        { action: nirup_berthing_ajax.recaptcha.action }
                    ).then(function(token) {
                        console.log('[Berthing] reCAPTCHA token obtained');
                        sendAjax(token);
                    }).catch(function(err) {
                        console.error('[Berthing] reCAPTCHA error, sending without token', err);
                        sendAjax('');
                    });
                });
            } else {
                console.log('[Berthing] reCAPTCHA not configured / grecaptcha missing, sending without token');
                sendAjax('');
            }
        }

        // Form submit (Enter key)
        $form.on('submit', function(e) {
            console.log('[Berthing] Native submit triggered');
            e.preventDefault();
            handleSubmit(e);
        });

        // Button click
        if ($submitBtn.length) {
            $submitBtn.on('click', function(e) {
                console.log('[Berthing] Submit button clicked');
                e.preventDefault();
                handleSubmit();
            });
        }

        console.log('[Berthing] Initialization complete');
    }

    $(document).ready(function() {
        initBerthingForm();
    });

})(jQuery);
