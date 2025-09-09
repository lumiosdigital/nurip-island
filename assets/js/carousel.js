/**
 * Experiences Carousel JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    initExperiencesCarousel();
});

function initExperiencesCarousel() {
    const carousel = document.getElementById('experiencesCarousel');
    const track = document.getElementById('carouselTrack');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    if (!carousel || !track || !prevBtn || !nextBtn) return;
    
    const cards = track.querySelectorAll('.experience-card');
    if (cards.length === 0) return;
    
    const cardWidth = 380; // Width of each card
    const cardGap = 20; // Gap between cards
    const cardStep = cardWidth + cardGap;
    
    let currentIndex = 0;
    let maxIndex = 0;
    let visibleCards = 3; // Default number of visible cards
    
    function calculateVisibleCards() {
        const containerWidth = carousel.offsetWidth;
        const availableWidth = containerWidth - 40; // Account for padding
        const newVisibleCards = Math.floor(availableWidth / cardStep);
        visibleCards = Math.max(1, Math.min(newVisibleCards, cards.length));
        return visibleCards;
    }
    
    function calculateMaxIndex() {
        calculateVisibleCards();
        maxIndex = Math.max(0, cards.length - visibleCards);
        
        // Ensure current index doesn't exceed max
        if (currentIndex > maxIndex) {
            currentIndex = maxIndex;
        }
    }
    
    function updateCarousel() {
        const translateX = -currentIndex * cardStep;
        track.style.transform = `translateX(${translateX}px)`;
        
        // Update button states
        updateButtonStates();
    }
    
    function updateButtonStates() {
        prevBtn.disabled = currentIndex <= 0;
        nextBtn.disabled = currentIndex >= maxIndex;
        
        prevBtn.style.opacity = currentIndex <= 0 ? '0.5' : '1';
        nextBtn.style.opacity = currentIndex >= maxIndex ? '0.5' : '1';
        
        prevBtn.style.cursor = currentIndex <= 0 ? 'default' : 'pointer';
        nextBtn.style.cursor = currentIndex >= maxIndex ? '0.5' : 'pointer';
    }
    
    function updateLayout() {
        calculateMaxIndex();
        updateCarousel();
    }
    
    // Navigation event listeners
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
    
    // Handle window resize
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(updateLayout, 150);
    });
    
    // Touch/swipe handling for mobile
    let touchStartX = 0;
    let touchStartY = 0;
    let isDragging = false;
    let startTime = 0;
    
    track.addEventListener('touchstart', function(e) {
        touchStartX = e.touches[0].clientX;
        touchStartY = e.touches[0].clientY;
        startTime = Date.now();
        isDragging = true;
    }, { passive: true });
    
    track.addEventListener('touchmove', function(e) {
        if (!isDragging) return;
        
        const touchX = e.touches[0].clientX;
        const touchY = e.touches[0].clientY;
        const deltaX = Math.abs(touchX - touchStartX);
        const deltaY = Math.abs(touchY - touchStartY);
        
        // If horizontal swipe is more significant than vertical, prevent scrolling
        if (deltaX > deltaY && deltaX > 10) {
            e.preventDefault();
        }
    }, { passive: false });
    
    track.addEventListener('touchend', function(e) {
        if (!isDragging) return;
        
        const endX = e.changedTouches[0].clientX;
        const endTime = Date.now();
        const diff = touchStartX - endX;
        const timeDiff = endTime - startTime;
        
        // Only trigger if it's a quick swipe (under 300ms) and significant distance (over 50px)
        if (timeDiff < 300 && Math.abs(diff) > 50) {
            if (diff > 0 && currentIndex < maxIndex) {
                currentIndex++;
            } else if (diff < 0 && currentIndex > 0) {
                currentIndex--;
            }
            updateCarousel();
        }
        
        isDragging = false;
    }, { passive: true });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        // Only trigger if carousel is in viewport
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
    
    // Initialize - Start from leftmost position
    currentIndex = 0;
    updateLayout();
    
    // Debug info (remove in production)
    console.log('Carousel initialized:', {
        totalCards: cards.length,
        visibleCards: visibleCards,
        maxIndex: maxIndex,
        currentIndex: currentIndex
    });
}