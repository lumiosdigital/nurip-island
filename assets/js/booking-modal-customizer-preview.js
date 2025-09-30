/**
 * Booking Modal Customizer Live Preview
 * File: assets/js/booking-modal-customizer-preview.js
 * 
 * Updates the booking modal in real-time as you type in the Customizer
 */

(function($) {
    'use strict';

    // Wait for customizer to be ready
    wp.customize('nirup_booking_modal_title', function(value) {
        value.bind(function(newval) {
            $('#booking-modal-title').text(newval);
        });
    });

    // Resort Hotel Fields
    wp.customize('nirup_booking_resort_label', function(value) {
        value.bind(function(newval) {
            $('.booking-option-resort .booking-option-label').text(newval);
        });
    });

    wp.customize('nirup_booking_resort_name', function(value) {
        value.bind(function(newval) {
            $('.booking-option-resort .booking-option-name').text(newval);
            $('.booking-option-resort .booking-option-image').attr('alt', newval);
        });
    });

    wp.customize('nirup_booking_resort_description', function(value) {
        value.bind(function(newval) {
            $('.booking-option-resort .booking-option-description').text(newval);
        });
    });

    wp.customize('nirup_booking_resort_button_text', function(value) {
        value.bind(function(newval) {
            $('.booking-option-resort .booking-option-button span').text(newval);
        });
    });

    wp.customize('nirup_booking_resort_button_link', function(value) {
        value.bind(function(newval) {
            $('.booking-option-resort .booking-option-button').attr('href', newval);
        });
    });

    wp.customize('nirup_booking_resort_image', function(value) {
        value.bind(function(newval) {
            if (newval) {
                // Get the attachment data
                wp.media.attachment(newval).fetch().done(function() {
                    var attachment = wp.media.attachment(newval);
                    var imageUrl = attachment.get('url');
                    $('.booking-option-resort .booking-option-image').attr('src', imageUrl);
                });
            }
        });
    });

    // Private Villas Fields
    wp.customize('nirup_booking_villas_label', function(value) {
        value.bind(function(newval) {
            $('.booking-option-villas .booking-option-label').text(newval);
        });
    });

    wp.customize('nirup_booking_villas_name', function(value) {
        value.bind(function(newval) {
            $('.booking-option-villas .booking-option-name').text(newval);
            $('.booking-option-villas .booking-option-image').attr('alt', newval);
        });
    });

    wp.customize('nirup_booking_villas_description', function(value) {
        value.bind(function(newval) {
            $('.booking-option-villas .booking-option-description').text(newval);
        });
    });

    wp.customize('nirup_booking_villas_button_text', function(value) {
        value.bind(function(newval) {
            $('.booking-option-villas .booking-option-button span').text(newval);
        });
    });

    wp.customize('nirup_booking_villas_button_link', function(value) {
        value.bind(function(newval) {
            $('.booking-option-villas .booking-option-button').attr('href', newval);
        });
    });

    wp.customize('nirup_booking_villas_image', function(value) {
        value.bind(function(newval) {
            if (newval) {
                // Get the attachment data
                wp.media.attachment(newval).fetch().done(function() {
                    var attachment = wp.media.attachment(newval);
                    var imageUrl = attachment.get('url');
                    $('.booking-option-villas .booking-option-image').attr('src', imageUrl);
                });
            }
        });
    });

    // Helper function to open modal in customizer for preview
    $(document).ready(function() {
        // Add a small helper to open the modal when customizer section is expanded
        if (window.wp && window.wp.customize) {
            wp.customize.section('nirup_booking_modal', function(section) {
                section.expanded.bind(function(isExpanded) {
                    if (isExpanded) {
                        // Open the modal for easier preview
                        setTimeout(function() {
                            $('#booking-modal').addClass('active');
                            $('body').addClass('booking-modal-open');
                        }, 300);
                    } else {
                        // Close the modal when leaving the section
                        $('#booking-modal').removeClass('active');
                        $('body').removeClass('booking-modal-open');
                    }
                });
            });
        }
    });

})(jQuery);