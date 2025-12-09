/**
 * Single Restaurant Gallery - Enhanced Mobile Swipe
 * Optional: Add scroll position indicators
 * File: assets/js/single-restaurant-gallery-mobile.js
 */

(function() {
    'use strict';

    // Only run on mobile devices
    if (window.innerWidth > 768) return;

    const gallery = document.querySelector('.single-restaurant-gallery');
    if (!gallery) return;

    // Get all gallery items (images)
    const galleryItems = gallery.querySelectorAll('.gallery-main-image, .gallery-grid-item');
    if (galleryItems.length === 0) return;

    // Create scroll indicators
    function createScrollIndicators() {
        const wrapper = gallery.parentElement;
        
        // Create indicator container
        const indicatorContainer = document.createElement('div');
        indicatorContainer.className = 'gallery-scroll-indicator';
        
        // Create dots for each image
        galleryItems.forEach((item, index) => {
            const dot = document.createElement('div');
            dot.className = 'gallery-scroll-dot';
            if (index === 0) dot.classList.add('active');
            dot.dataset.index = index;
            indicatorContainer.appendChild(dot);
        });
        
        // Insert after gallery
        gallery.parentNode.insertBefore(indicatorContainer, gallery.nextSibling);
        
        return indicatorContainer.querySelectorAll('.gallery-scroll-dot');
    }

    // Update active indicator based on scroll position
    function updateScrollIndicator(dots) {
        const scrollLeft = gallery.scrollLeft;
        const itemWidth = gallery.offsetWidth;
        const currentIndex = Math.round(scrollLeft / itemWidth);
        
        dots.forEach((dot, index) => {
            if (index === currentIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    // Create indicators
    const dots = createScrollIndicators();

    // Update indicator on scroll
    let scrollTimeout;
    gallery.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            updateScrollIndicator(dots);
        }, 50);
    });

    // Add touch event handling for better experience
    let touchStartX = 0;
    let touchEndX = 0;
    let isDragging = false;

    gallery.addEventListener('touchstart', function(e) {
        touchStartX = e.touches[0].clientX;
        isDragging = true;
        gallery.style.scrollSnapType = 'none'; // Allow free scrolling
    });

    gallery.addEventListener('touchmove', function(e) {
        if (!isDragging) return;
        touchEndX = e.touches[0].clientX;
    });

    gallery.addEventListener('touchend', function() {
        if (!isDragging) return;
        isDragging = false;
        
        // Re-enable snap scrolling
        gallery.style.scrollSnapType = 'x mandatory';
        
        const swipeDistance = touchStartX - touchEndX;
        const threshold = 50; // Minimum swipe distance
        
        // Optional: Add haptic feedback on iOS
        if (Math.abs(swipeDistance) > threshold && navigator.vibrate) {
            navigator.vibrate(10);
        }
    });

    // Prevent image context menu on long press
    galleryItems.forEach(item => {
        const img = item.querySelector('img');
        if (img) {
            img.addEventListener('contextmenu', e => e.preventDefault());
        }
    });

    // Optional: Auto-scroll to next image after delay (carousel-like)
    // Uncomment if you want auto-advance feature
    /*
    let autoScrollInterval;
    function startAutoScroll() {
        autoScrollInterval = setInterval(() => {
            const currentScroll = gallery.scrollLeft;
            const itemWidth = gallery.offsetWidth;
            const maxScroll = gallery.scrollWidth - itemWidth;
            
            if (currentScroll >= maxScroll) {
                gallery.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                gallery.scrollBy({ left: itemWidth, behavior: 'smooth' });
            }
        }, 3000); // Change image every 3 seconds
    }

    function stopAutoScroll() {
        clearInterval(autoScrollInterval);
    }

    // Start auto-scroll
    startAutoScroll();

    // Pause on touch
    gallery.addEventListener('touchstart', stopAutoScroll);
    gallery.addEventListener('touchend', () => {
        setTimeout(startAutoScroll, 2000); // Resume after 2 seconds
    });
    */

    console.log('Restaurant gallery mobile swipe initialized');
})();