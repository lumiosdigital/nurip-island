/**
 * Events and Offers Carousel JavaScript
 * Fixed with dynamic card width and proper centering
 */

document.addEventListener('DOMContentLoaded', function() {
    initEventsOffersCarousel();
});

function initEventsOffersCarousel() {
    const carousel = document.getElementById('eventsOffersCarousel');
    const track = document.getElementById('eventsOffersCarouselTrack');
    const prevBtn = document.getElementById('eventsOffersPrevBtn');
    const nextBtn = document.getElementById('eventsOffersNextBtn');
    
    if (!carousel || !track || !prevBtn || !nextBtn) return;
    
    const cards = track.querySelectorAll('.event-offer-card');
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
            const cardStyle = window.getComputedStyle(firstCard);
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
    
    // Touch/swipe handling
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
        let translateX = -currentIndex * cardStep + diff;
        
        // Boundary checks
        const minTranslate = -maxIndex * cardStep;
        const maxTranslate = 0;
        translateX = Math.max(minTranslate, Math.min(maxTranslate, translateX));
        
        track.style.transform = `translateX(${translateX}px)`;
    }, { passive: true });
    
    track.addEventListener('touchend', function() {
        if (!isDragging) return;
        
        isDragging = false;
        track.style.transition = 'transform 0.3s ease-in-out';
        
        const diff = currentX - startX;
        const threshold = cardStep * 0.3; // 30% of card width for better snapping
        
        if (diff > threshold && currentIndex > 0) {
            currentIndex--;
        } else if (diff < -threshold && currentIndex < maxIndex) {
            currentIndex++;
        }
        
        updateCarousel();
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
    
    console.log('Events & Offers Carousel initialized:', {
        totalCards: cards.length,
        cardWidth: cardWidth,
        cardGap: cardGap,
        cardStep: cardStep,
        visibleCards: visibleCards,
        maxIndex: maxIndex
    });
}