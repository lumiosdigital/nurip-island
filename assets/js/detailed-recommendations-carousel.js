/**
 * Detailed Recommendations Carousel JavaScript
 * Matching home page carousel behavior exactly
 */

document.addEventListener('DOMContentLoaded', function() {
    initDetailedRecommendationsCarousel();
});

function initDetailedRecommendationsCarousel() {
    const carousel = document.getElementById('detailedRecommendationsCarousel');
    const track = document.getElementById('detailedRecommendationsCarouselTrack');
    const prevBtn = document.getElementById('detailedRecommendationsPrevBtn');
    const nextBtn = document.getElementById('detailedRecommendationsNextBtn');
    
    if (!carousel || !track || !prevBtn || !nextBtn) return;
    
    const cards = track.querySelectorAll('.detailed-recommendation-card');
    if (cards.length === 0) return;
    
    let currentIndex = 0;
    let maxIndex = 0;
    let visibleCards = 3;
    let cardWidth = 380;
    let cardGap = 20;
    let cardStep = 400;
    
    function calculateCardDimensions() {
        // Get actual card width from first card
        if (cards.length > 0) {
            const firstCard = cards[0];
            cardWidth = firstCard.offsetWidth;
            
            // Get gap from track
            const trackStyle = window.getComputedStyle(track);
            cardGap = parseInt(trackStyle.gap) || 20;
            
            cardStep = cardWidth + cardGap;
        }
    }
    
    function calculateVisibleCards() {
        const containerWidth = carousel.offsetWidth;
        const availableWidth = containerWidth - 40;
        const newVisibleCards = Math.floor((availableWidth + cardGap) / cardStep);
        visibleCards = Math.max(1, Math.min(newVisibleCards, cards.length));
        return visibleCards;
    }
    
    function calculateMaxIndex() {
        calculateCardDimensions();
        calculateVisibleCards();
        maxIndex = Math.max(0, cards.length - visibleCards);
        
        if (currentIndex > maxIndex) {
            currentIndex = maxIndex;
        }
    }
    
    function updateCarousel() {
        const translateX = -currentIndex * cardStep;
        track.style.transform = `translateX(${translateX}px)`;
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
    
    // Touch/swipe handling with improved scroll prevention
    let startX = 0;
    let startY = 0;
    let currentX = 0;
    let isDragging = false;
    let isHorizontalSwipe = false;

    track.addEventListener('touchstart', function(e) {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
        currentX = startX;
        isDragging = true;
        isHorizontalSwipe = false;
        track.style.transition = 'none';
    }, { passive: true });

    track.addEventListener('touchmove', function(e) {
        if (!isDragging) return;

        currentX = e.touches[0].clientX;
        const currentY = e.touches[0].clientY;
        const diffX = Math.abs(currentX - startX);
        const diffY = Math.abs(currentY - startY);

        // Determine swipe direction on first significant movement
        if (!isHorizontalSwipe && (diffX > 5 || diffY > 5)) {
            isHorizontalSwipe = diffX > diffY;
        }

        // Only handle horizontal swipes and prevent vertical scroll
        if (isHorizontalSwipe) {
            e.preventDefault();

            const diff = currentX - startX;
            let translateX = -currentIndex * cardStep + diff;

            // Boundary checks
            const minTranslate = -maxIndex * cardStep;
            const maxTranslate = 0;
            translateX = Math.max(minTranslate, Math.min(maxTranslate, translateX));

            track.style.transform = `translateX(${translateX}px)`;
        }
    }, { passive: false });

    track.addEventListener('touchend', function() {
        if (!isDragging) return;

        isDragging = false;
        track.style.transition = 'transform 0.3s ease-in-out';

        // Only change slide if it was a horizontal swipe
        if (isHorizontalSwipe) {
            const diff = currentX - startX;
            const threshold = cardStep * 0.3;

            if (diff > threshold && currentIndex > 0) {
                currentIndex--;
            } else if (diff < -threshold && currentIndex < maxIndex) {
                currentIndex++;
            }
        }

        updateCarousel();
        isHorizontalSwipe = false;
    });
    
    // Keyboard navigation
    carousel.addEventListener('keydown', function(e) {
        switch(e.key) {
            case 'ArrowLeft':
                e.preventDefault();
                if (currentIndex > 0) {
                    currentIndex--;
                    updateCarousel();
                }
                break;
            case 'ArrowRight':
                e.preventDefault();
                if (currentIndex < maxIndex) {
                    currentIndex++;
                    updateCarousel();
                }
                break;
        }
    });
    
    // Add tabindex for keyboard navigation
    carousel.setAttribute('tabindex', '0');
    
    // Initialize
    currentIndex = 0;
    updateLayout();
    
    console.log('Detailed Recommendations Carousel initialized:', {
        totalCards: cards.length,
        cardWidth: cardWidth,
        cardGap: cardGap,
        cardStep: cardStep,
        visibleCards: visibleCards,
        maxIndex: maxIndex
    });
}