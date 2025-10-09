(function($) {
    'use strict';

    $(document).ready(function() {
        console.log('Private Events Preview JS loaded');

        var $modal = $('#thank-you-modal');
        console.log('Modal element found:', $modal.length > 0);

        // Toggle modal visibility
        wp.customize('nirup_private_events_modal_preview', function(value) {
            value.bind(function(isChecked) {
                console.log('Modal preview toggle:', isChecked);
                if (isChecked) {
                    $modal.addClass('active');
                    $('body').css('overflow', 'hidden');
                    $modal.find('.modal-overlay').off('click');
                } else {
                    $modal.removeClass('active');
                    $('body').css('overflow', '');
                }
            });
        });

        // Live updates
        wp.customize('nirup_private_events_modal_title', function(value) {
            value.bind(function(newval) {
                $('.modal-title').text(newval);
            });
        });

        wp.customize('nirup_private_events_modal_intro', function(value) {
            value.bind(function(newval) {
                $('.modal-intro-text').text(newval);
            });
        });

        wp.customize('nirup_private_events_modal_link1_text', function(value) {
            value.bind(function(newval) {
                $('.modal-links-left .modal-link:first-child span').text(newval);
            });
        });

        wp.customize('nirup_private_events_modal_link2_text', function(value) {
            value.bind(function(newval) {
                $('.modal-links-left .modal-link:last-child span').text(newval);
            });
        });

        wp.customize('nirup_private_events_modal_phone_text', function(value) {
            value.bind(function(newval) {
                $('.modal-phone-link span').text(newval);
            });
        });

        wp.customize('nirup_private_events_modal_closing', function(value) {
            value.bind(function(newval) {
                $('.modal-closing-text').text(newval);
            });
        });
    });

})(jQuery);