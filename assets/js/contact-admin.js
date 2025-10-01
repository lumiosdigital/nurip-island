/**
 * Contact Form Submissions - Admin JavaScript
 * Save as: assets/js/contact-admin.js
 */

(function($) {
    'use strict';
    
    const ContactAdmin = {
        init: function() {
            this.bindEvents();
        },
        
        bindEvents: function() {
            // View submission button
            $(document).on('click', '.view-submission', this.viewSubmission);
            
            // Close modal
            $(document).on('click', '.modal-close, .button-close, .modal-backdrop', this.closeModal);
            
            // Prevent modal close when clicking inside content
            $(document).on('click', '.modal-content', function(e) {
                e.stopPropagation();
            });
            
            // ESC key to close modal
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    ContactAdmin.closeModal();
                }
            });
            
            // Reply button
            $(document).on('click', '.reply-submission', this.replyToSubmission);
        },
        
        viewSubmission: function(e) {
            e.preventDefault();
            const $button = $(this);
            const submissionId = $button.data('id');
            
            // Show loading state
            $button.prop('disabled', true).text('Loading...');
            
            // AJAX request to get submission details
            $.ajax({
                url: nirupContactAdmin.ajax_url,
                type: 'POST',
                data: {
                    action: 'nirup_get_submission_details',
                    nonce: nirupContactAdmin.nonce,
                    id: submissionId
                },
                success: function(response) {
                    if (response.success) {
                        // Show modal with content
                        $('#submission-modal .submission-details').html(response.data.html);
                        $('#submission-modal').fadeIn(300);
                        $('body').css('overflow', 'hidden');
                    } else {
                        alert('Error loading submission: ' + response.data);
                    }
                },
                error: function() {
                    alert('Failed to load submission details. Please try again.');
                },
                complete: function() {
                    // Reset button
                    $button.prop('disabled', false).html('<span class="dashicons dashicons-visibility"></span> View');
                }
            });
        },
        
        closeModal: function(e) {
            if (e) {
                e.preventDefault();
            }
            $('#submission-modal').fadeOut(300);
            $('body').css('overflow', '');
        },
        
        replyToSubmission: function(e) {
            e.preventDefault();
            const email = $(this).data('email');
            const name = $(this).data('name');
            
            // Create mailto link with pre-filled content
            const subject = encodeURIComponent('Re: Your inquiry to ' + document.title);
            const body = encodeURIComponent('Hi ' + name + ',\n\nThank you for contacting us.\n\n');
            const mailtoLink = 'mailto:' + email + '?subject=' + subject + '&body=' + body;
            
            // Open default email client
            window.location.href = mailtoLink;
        }
    };
    
    // Initialize when document is ready
    $(document).ready(function() {
        ContactAdmin.init();
    });
    
})(jQuery);