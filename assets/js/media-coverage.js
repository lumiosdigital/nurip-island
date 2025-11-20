/**
 * Media Coverage - Load More Functionality
 */

jQuery(document).ready(function($) {
    $('.load-more-btn').on('click', function() {
        var button = $(this);
        var page = parseInt(button.attr('data-page'));
        var maxPages = parseInt(button.attr('data-max'));
        
        // Don't allow multiple clicks
        if (button.hasClass('loading')) {
            return;
        }
        
        // Increment page
        page++;
        
        // Add loading state
        button.addClass('loading');
        button.find('.load-more-text').text('Loading...');
        
        // AJAX request
        $.ajax({
            url: nirup_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'load_more_media_articles',
                page: page,
                nonce: nirup_ajax.nonce
            },
            success: function(response) {
                if (response.success && response.data.html) {
                    // Insert new articles before the load more button
                    $('.media-load-more').before(response.data.html);
                    
                    // Update button state
                    button.attr('data-page', page);
                    button.removeClass('loading');
                    button.find('.load-more-text').text('Load More');
                    
                    // Hide button if we've reached the last page
                    if (page >= maxPages) {
                        button.parent().fadeOut();
                    }
                    
                    // Smooth scroll to first new article
                    var firstNewArticle = $('.media-article-item[data-page="' + page + '"]').first();
                    if (firstNewArticle.length) {
                        $('html, body').animate({
                            scrollTop: firstNewArticle.offset().top - 100
                        }, 600);
                    }
                } else {
                    button.removeClass('loading');
                    button.find('.load-more-text').text('No More Articles');
                    setTimeout(function() {
                        button.parent().fadeOut();
                    }, 2000);
                }
            },
            error: function() {
                button.removeClass('loading');
                button.find('.load-more-text').text('Error Loading');
                setTimeout(function() {
                    button.find('.load-more-text').text('Load More');
                }, 3000);
            }
        });
    });
});