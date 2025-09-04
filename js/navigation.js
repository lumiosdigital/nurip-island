console.log('Navigation JS file loaded');

jQuery(document).ready(function($) {
    console.log('Navigation jQuery ready');
    
    var header = $('.site-header');
    var announcement = $('.announcement-bar');
    
    console.log('Found headers:', header.length);
    console.log('Found announcements:', announcement.length);
    
    var lastScrollTop = 0;
    
    $(window).scroll(function() {
        var scrollTop = $(this).scrollTop();
        console.log('Scroll position:', scrollTop);
        
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            console.log('Hiding navbar');
            header.addClass('header-hidden');
            announcement.addClass('header-hidden');
        } else if (scrollTop < lastScrollTop) {
            console.log('Showing navbar');
            header.removeClass('header-hidden');
            announcement.removeClass('header-hidden');
        }
        
        lastScrollTop = scrollTop;
    });
    
    console.log('Scroll listener ready');
});