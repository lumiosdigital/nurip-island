/**
 * Accommodations Page Carousels - UPDATED WITH LIVE DRAGGING
 * File: assets/js/accommodations-carousel.js
 * Two separate carousels: Riahi Residences and Westin Rooms
 * Updated to match homepage carousel behavior with live dragging
 */

// Initialize both carousels when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initRiahiCarousel();
    initWestinCarousel();
});

/**
 * Initialize Riahi Residences Carousel
 */
function initRiahiCarousel() {
    const carousel = document.querySelector('.riahi-carousel');
    if (!carousel) return;

    const track = carousel.querySelector('.riahi-track');
    const cards = track.querySelectorAll('.accpage-card');
    const prevBtn = carousel.querySelector('.riahi-prev');
    const nextBtn = carousel.querySelector('.riahi-next');

    if (!track || cards.length === 0 || !prevBtn || !nextBtn) return;

    let currentIndex = 0;
    let maxIndex = 0;
    let cardWidth = 380;
    let gap = 20;
    let visibleCards = 3;

    function calculateMaxIndex() {
        const containerWidth = carousel.offsetWidth;
        const paddingTotal = 40;
        const availableWidth = containerWidth - paddingTotal;
        
        visibleCards = Math.floor((availableWidth + gap) / (cardWidth + gap));
        visibleCards = Math.max(1, Math.min(visibleCards, cards.length));
        
        maxIndex = Math.max(0, cards.length - visibleCards);
        
        if (currentIndex > maxIndex) {
            currentIndex = maxIndex;
        }
    }

    function updateCarousel() {
        const offset = -currentIndex * (cardWidth + gap);
        track.style.transform = `translateX(${offset}px)`;
        
        prevBtn.disabled = currentIndex <= 0;
        nextBtn.disabled = currentIndex >= maxIndex;
        
        prevBtn.style.opacity = currentIndex <= 0 ? '0.5' : '1';
        nextBtn.style.opacity = currentIndex >= maxIndex ? '0.5' : '1';
        
        prevBtn.style.cursor = currentIndex <= 0 ? 'default' : 'pointer';
        nextBtn.style.cursor = currentIndex >= maxIndex ? 'default' : 'pointer';
    }

    function updateLayout() {
        calculateMaxIndex();
        updateCarousel();
    }

    // Navigation
    prevBtn.addEventListener('click', function() {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });

    nextBtn.addEventListener('click', function() {
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateCarousel();
        }
    });

    // Window resize
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(updateLayout, 150);
    });

    // Touch/swipe handling with LIVE DRAGGING (matches homepage)
    let startX = 0;
    let currentX = 0;
    let isDragging = false;

    track.addEventListener('touchstart', function(e) {
        startX = e.touches[0].clientX;
        isDragging = true;
        track.style.transition = 'none';
    }, { passive: true });

    track.addEventListener('touchmove', function(e) {
        if (!isDragging) return;
        
        currentX = e.touches[0].clientX;
        const diff = currentX - startX;
        const translateX = -currentIndex * (cardWidth + gap) + diff;
        track.style.transform = `translateX(${translateX}px)`;
    }, { passive: true });

    track.addEventListener('touchend', function() {
        if (!isDragging) return;
        
        isDragging = false;
        track.style.transition = 'transform 0.3s ease-in-out';
        
        const diff = currentX - startX;
        const threshold = (cardWidth + gap) * 0.2; // 20% of card width
        
        if (diff > threshold && currentIndex > 0) {
            currentIndex--;
        } else if (diff < -threshold && currentIndex < maxIndex) {
            currentIndex++;
        }
        
        updateCarousel();
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        const rect = carousel.getBoundingClientRect();
        const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
        
        if (isVisible) {
            if (e.key === 'ArrowLeft' && currentIndex > 0) {
                e.preventDefault();
                currentIndex--;
                updateCarousel();
            } else if (e.key === 'ArrowRight' && currentIndex < maxIndex) {
                e.preventDefault();
                currentIndex++;
                updateCarousel();
            }
        }
    });

    // Initialize
    currentIndex = 0;
    updateLayout();
    
    console.log('Riahi Carousel initialized with live dragging:', {
        totalCards: cards.length,
        visibleCards: visibleCards,
        maxIndex: maxIndex,
        currentIndex: currentIndex
    });
}

/**
 * Initialize Westin Carousel
 */
function initWestinCarousel() {
    const carousel = document.querySelector('.westin-carousel');
    if (!carousel) return;

    const track = carousel.querySelector('.westin-track');
    const cards = track.querySelectorAll('.accpage-card');
    const prevBtn = carousel.querySelector('.westin-prev');
    const nextBtn = carousel.querySelector('.westin-next');

    if (!track || cards.length === 0 || !prevBtn || !nextBtn) return;

    let currentIndex = 0;
    let maxIndex = 0;
    let cardWidth = 380;
    let gap = 20;
    let visibleCards = 3;

    function calculateMaxIndex() {
        const containerWidth = carousel.offsetWidth;
        const paddingTotal = 40;
        const availableWidth = containerWidth - paddingTotal;
        
        visibleCards = Math.floor((availableWidth + gap) / (cardWidth + gap));
        visibleCards = Math.max(1, Math.min(visibleCards, cards.length));
        
        maxIndex = Math.max(0, cards.length - visibleCards);
        
        if (currentIndex > maxIndex) {
            currentIndex = maxIndex;
        }
    }

    function updateCarousel() {
        const offset = -currentIndex * (cardWidth + gap);
        track.style.transform = `translateX(${offset}px)`;
        
        prevBtn.disabled = currentIndex <= 0;
        nextBtn.disabled = currentIndex >= maxIndex;
        
        prevBtn.style.opacity = currentIndex <= 0 ? '0.5' : '1';
        nextBtn.style.opacity = currentIndex >= maxIndex ? '0.5' : '1';
        
        prevBtn.style.cursor = currentIndex <= 0 ? 'default' : 'pointer';
        nextBtn.style.cursor = currentIndex >= maxIndex ? 'default' : 'pointer';
    }

    function updateLayout() {
        calculateMaxIndex();
        updateCarousel();
    }

    // Navigation
    prevBtn.addEventListener('click', function() {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });

    nextBtn.addEventListener('click', function() {
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateCarousel();
        }
    });

    // Window resize
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(updateLayout, 150);
    });

    // Touch/swipe handling with LIVE DRAGGING (matches homepage)
    let startX = 0;
    let currentX = 0;
    let isDragging = false;

    track.addEventListener('touchstart', function(e) {
        startX = e.touches[0].clientX;
        isDragging = true;
        track.style.transition = 'none';
    }, { passive: true });

    track.addEventListener('touchmove', function(e) {
        if (!isDragging) return;
        
        currentX = e.touches[0].clientX;
        const diff = currentX - startX;
        const translateX = -currentIndex * (cardWidth + gap) + diff;
        track.style.transform = `translateX(${translateX}px)`;
    }, { passive: true });

    track.addEventListener('touchend', function() {
        if (!isDragging) return;
        
        isDragging = false;
        track.style.transition = 'transform 0.3s ease-in-out';
        
        const diff = currentX - startX;
        const threshold = (cardWidth + gap) * 0.2; // 20% of card width
        
        if (diff > threshold && currentIndex > 0) {
            currentIndex--;
        } else if (diff < -threshold && currentIndex < maxIndex) {
            currentIndex++;
        }
        
        updateCarousel();
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        const rect = carousel.getBoundingClientRect();
        const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
        
        if (isVisible) {
            if (e.key === 'ArrowLeft' && currentIndex > 0) {
                e.preventDefault();
                currentIndex--;
                updateCarousel();
            } else if (e.key === 'ArrowRight' && currentIndex < maxIndex) {
                e.preventDefault();
                currentIndex++;
                updateCarousel();
            }
        }
    });

    // Initialize
    currentIndex = 0;
    updateLayout();
    
    console.log('Westin Carousel initialized with live dragging:', {
        totalCards: cards.length,
        visibleCards: visibleCards,
        maxIndex: maxIndex,
        currentIndex: currentIndex
    });
}