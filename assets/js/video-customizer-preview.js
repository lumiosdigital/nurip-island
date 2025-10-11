(function($) {
    'use strict';

    // Show/hide video source fields based on selection
    wp.customize('nirup_video_source_type', function(value) {
        value.bind(function(newval) {
            if (newval === 'youtube') {
                $('#customize-control-nirup_video_url').show();
                $('#customize-control-nirup_video_upload').hide();
            } else {
                $('#customize-control-nirup_video_url').hide();
                $('#customize-control-nirup_video_upload').show();
            }
        });
    });

    // Initialize on load
    $(document).ready(function() {
        var videoType = wp.customize('nirup_video_source_type')();
        if (videoType === 'youtube') {
            $('#customize-control-nirup_video_url').show();
            $('#customize-control-nirup_video_upload').hide();
        } else {
            $('#customize-control-nirup_video_url').hide();
            $('#customize-control-nirup_video_upload').show();
        }
    });

})(jQuery);