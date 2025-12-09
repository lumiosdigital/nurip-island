/**
 * Experiences Carousel JavaScript
 * Updated with live dragging behavior
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
        nextBtn.style.cursor = currentIndex >= maxIndex ? 'default' : 'pointer';
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
    
    // Touch/swipe handling with LIVE DRAGGING (matches events-offers carousel)
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
        const translateX = -currentIndex * cardStep + diff;
        track.style.transform = `translateX(${translateX}px)`;
    }, { passive: true });
    
    track.addEventListener('touchend', function() {
        if (!isDragging) return;
        
        isDragging = false;
        track.style.transition = 'transform 0.3s ease-in-out';
        
        const diff = currentX - startX;
        const threshold = cardStep * 0.2; // 20% of card width
        
        if (diff > threshold && currentIndex > 0) {
            currentIndex--;
        } else if (diff < -threshold && currentIndex < maxIndex) {
            currentIndex++;
        }
        
        updateCarousel();
    });
    
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
    console.log('Experiences Carousel initialized with live dragging:', {
        totalCards: cards.length,
        visibleCards: visibleCards,
        maxIndex: maxIndex,
        currentIndex: currentIndex
    });
}