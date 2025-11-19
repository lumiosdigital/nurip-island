(function($) {
    'use strict';

    $(document).ready(function() {

        // Check if returning from payment
        checkForSuccessfulPayment();

        // Open modal for specific villa
        $(document).on('click', '.nirup-book-btn', function(e) {
            e.preventDefault();

            var villaId = $(this).data('villa-id');
            var modalId = '#nirup-booking-modal-' + villaId;

            console.log('Opening modal:', modalId);

            $(modalId).addClass('active').attr('aria-hidden','false');
            $('body').addClass('villa-booking-open');
            $(modalId + ' .villa-booking-close').focus();

            // Store villa ID for form submission
            sessionStorage.setItem('nirup_current_villa_id', villaId);
            sessionStorage.setItem('nirup_booking_in_progress', 'true');

            setTimeout(function(){
                if (window.wpbs) {
                    if (typeof wpbs.init === 'function') wpbs.init();
                    $(document).trigger('wpbs:calendar_loaded');
                    $('.wpbs-calendar').trigger('wpbs:init');
                }

                // Attach form submission handler
                attachFormSubmissionHandler(villaId);
            }, 100);
        });

        // Close modal handlers
        $(document).on('click', '.villa-booking-close, .villa-booking-backdrop', function() {
            $(this).closest('.villa-booking-modal').removeClass('active').attr('aria-hidden', 'true');
            $('body').removeClass('villa-booking-open');
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                $('.villa-booking-modal.active').removeClass('active').attr('aria-hidden', 'true');
                $('body').removeClass('villa-booking-open');
            }
        });
    });

    // Attach form submission handler to intercept WPBS form
    function attachFormSubmissionHandler(villaId) {
        var modalId = '#nirup-booking-modal-' + villaId;
        var $modal = $(modalId);

        // Wait for WPBS form to be loaded
        var checkFormInterval = setInterval(function() {
            var $form = $modal.find('.wpbs-form, form[id^="wpbs-form"]');

            if ($form.length > 0) {
                clearInterval(checkFormInterval);

                console.log('WPBS form found, attaching handler');

                // Intercept form submission
                $form.on('submit', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    console.log('Form submission intercepted');

                    // Get form data
                    var formData = $(this).serializeArray();
                    var bookingData = {};

                    // Parse form data
                    $.each(formData, function(i, field) {
                        bookingData[field.name] = field.value;
                    });

                    // Extract booking details from WPBS form
                    var checkIn = $modal.find('input[name*="check_in"], input[name*="checkin"], input[name*="date_start"]').val() || '';
                    var checkOut = $modal.find('input[name*="check_out"], input[name*="checkout"], input[name*="date_end"]').val() || '';
                    var guests = $modal.find('input[name*="guests"], select[name*="guests"]').val() || 1;
                    var totalPrice = $modal.find('.wpbs-form-total, .wpbs-price-total, input[name*="total"]').text() || $modal.find('input[name*="total"]').val() || '0';

                    // Clean price (remove currency symbols)
                    totalPrice = totalPrice.toString().replace(/[^0-9.]/g, '');

                    // Get customer details
                    var customerName = $modal.find('input[name*="name"], input[name*="first_name"]').val() || '';
                    var customerEmail = $modal.find('input[name*="email"]').val() || '';
                    var customerPhone = $modal.find('input[name*="phone"], input[name*="telephone"]').val() || '';

                    // Validate required fields
                    if (!checkIn || !checkOut) {
                        alert('Please select check-in and check-out dates.');
                        return false;
                    }

                    if (!customerEmail) {
                        alert('Please provide your email address.');
                        return false;
                    }

                    // Prepare booking data
                    var bookingPayload = {
                        check_in: checkIn,
                        check_out: checkOut,
                        guests: guests,
                        total_price: totalPrice,
                        name: customerName,
                        email: customerEmail,
                        phone: customerPhone,
                        raw_form_data: bookingData
                    };

                    console.log('Booking data:', bookingPayload);

                    // Show loading state
                    var $submitBtn = $(this).find('button[type="submit"], input[type="submit"]');
                    var originalBtnText = $submitBtn.text() || $submitBtn.val();
                    $submitBtn.prop('disabled', true).text('Processing...');

                    // Send to server to create order and get payment URL
                    $.ajax({
                        url: wpbsAjax.ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'process_villa_booking_payment',
                            villa_id: villaId,
                            booking_data: bookingPayload,
                            nonce: wpbsAjax.nonce
                        },
                        success: function(response) {
                            console.log('Payment processing response:', response);

                            if (response.success && response.data.payment_url) {
                                // Store order ID for tracking
                                sessionStorage.setItem('nirup_order_id', response.data.order_id);

                                // Redirect to Midtrans payment page
                                console.log('Redirecting to payment:', response.data.payment_url);
                                window.location.href = response.data.payment_url;
                            } else {
                                alert('Error: ' + (response.data.message || 'Failed to process booking'));
                                $submitBtn.prop('disabled', false).text(originalBtnText);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', error);
                            alert('An error occurred while processing your booking. Please try again.');
                            $submitBtn.prop('disabled', false).text(originalBtnText);
                        }
                    });

                    return false;
                });
            }
        }, 500);

        // Clear interval after 10 seconds if form not found
        setTimeout(function() {
            clearInterval(checkFormInterval);
        }, 10000);
    }

    // Check if user just completed a payment
    function checkForSuccessfulPayment() {
        var urlParams = new URLSearchParams(window.location.search);
        var isOrderReceived = urlParams.has('order-received') ||
                             $('body').hasClass('woocommerce-order-received');

        // Check for Midtrans return parameters
        var transactionStatus = urlParams.get('transaction_status');
        var paymentStatus = urlParams.get('payment_status');
        var statusCode = urlParams.get('status_code');
        var orderIdFromUrl = urlParams.get('order_id');

        var bookingInProgress = sessionStorage.getItem('nirup_booking_in_progress');
        var orderId = sessionStorage.getItem('nirup_order_id');

        // Determine if this is a payment return
        var hasPaymentReturn = (isOrderReceived || transactionStatus || paymentStatus || orderIdFromUrl);

        if (hasPaymentReturn && bookingInProgress === 'true') {
            // Clear the flags
            sessionStorage.removeItem('nirup_booking_in_progress');
            sessionStorage.removeItem('nirup_order_id');
            sessionStorage.removeItem('nirup_current_villa_id');

            // Check if payment was successful
            var isSuccessful = false;

            // Check multiple status indicators
            var status = transactionStatus || paymentStatus;

            if (status) {
                // Midtrans status check
                isSuccessful = (status === 'settlement' ||
                              status === 'capture' ||
                              status === 'success' ||
                              status === 'completed');
            } else if (isOrderReceived) {
                // WooCommerce order received page
                isSuccessful = true;
            }

            if (isSuccessful) {
                // Show success message
                var message = 'Thank you for your booking! Your payment has been confirmed and we will be in touch soon.';
                $('#villa-thankyou-text').text(message);
                $('#villa-thankyou-modal').addClass('active').attr('aria-hidden', 'false');

                // Auto-close after 6 seconds
                setTimeout(function() {
                    $('#villa-thankyou-modal').removeClass('active').attr('aria-hidden', 'true');

                    // Clean up URL
                    if (window.history && window.history.replaceState) {
                        var cleanUrl = window.location.pathname;
                        window.history.replaceState({}, document.title, cleanUrl);
                    }
                }, 6000);
            } else {
                // Payment failed or pending
                var failMessage = 'Your payment was not successful. Please try again or contact us for assistance.';
                alert(failMessage);
            }
        }
    }

})(jQuery);
