/**
 * Single Event/Offer Gallery Carousel JavaScript
 * Based on Events & Offers Carousel
 */

document.addEventListener('DOMContentLoaded', function() {
    initGalleryCarousel();
});

function initGalleryCarousel() {
    const carousel = document.getElementById('galleryCarousel');
    const track = document.getElementById('galleryCarouselTrack');
    const prevBtn = document.getElementById('galleryPrevBtn');
    const nextBtn = document.getElementById('galleryNextBtn');
    
    if (!carousel || !track || !prevBtn || !nextBtn) return;
    
    const images = track.querySelectorAll('.gallery-item');
    if (images.length === 0) return;
    
    const imageWidth = 380; // Width of each image
    const imageGap = 19; // Gap between images
    const imageStep = imageWidth + imageGap;
    
    let currentIndex = 0;
    let maxIndex = 0;
    let visibleImages = 3; // Default number of visible images
    
    function calculateVisibleImages() {
        const containerWidth = carousel.offsetWidth;
        const availableWidth = containerWidth - 40; // Account for padding
        const newVisibleImages = Math.floor(availableWidth / imageStep);
        visibleImages = Math.max(1, Math.min(newVisibleImages, images.length));
        return visibleImages;
    }
    
    function calculateMaxIndex() {
        calculateVisibleImages();
        maxIndex = Math.max(0, images.length - visibleImages);
        
        // Ensure current index doesn't exceed max
        if (currentIndex > maxIndex) {
            currentIndex = maxIndex;
        }
    }
    
    function updateCarousel() {
        const translateX = -currentIndex * imageStep;
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
    
    // Event Listeners
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
    
    // Touch/swipe support
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
        const translateX = -currentIndex * imageStep + diff;
        track.style.transform = `translateX(${translateX}px)`;
    }, { passive: true });
    
    track.addEventListener('touchend', function() {
        if (!isDragging) return;
        
        isDragging = false;
        track.style.transition = 'transform 0.3s ease-in-out';
        
        const diff = currentX - startX;
        const threshold = imageStep * 0.2; // 20% of image width
        
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
    
    // Resize handler
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            calculateMaxIndex();
            updateCarousel();
        }, 250);
    });
    
    // Initialize carousel
    calculateMaxIndex();
    updateCarousel();
    
    // Add tabindex for keyboard navigation
    carousel.setAttribute('tabindex', '0');
    
    console.log('Gallery Carousel initialized successfully');
}

// Gallery Modal Functions
let currentModalImageIndex = 0;
let modalImages = [];

function openGalleryModal(imgElement) {
    const modal = document.getElementById('galleryModal');
    const modalImg = document.getElementById('galleryModalImage');
    
    // Get all gallery images
    modalImages = Array.from(document.querySelectorAll('.gallery-image'));
    currentModalImageIndex = modalImages.indexOf(imgElement);
    
    modal.style.display = 'block';
    modalImg.src = imgElement.getAttribute('data-full') || imgElement.src;
    modalImg.alt = imgElement.alt;
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
}

function closeGalleryModal() {
    const modal = document.getElementById('galleryModal');
    modal.style.display = 'none';
    
    // Restore body scroll
    document.body.style.overflow = 'auto';
}

function prevModalImage(event) {
    event.stopPropagation();
    
    if (currentModalImageIndex > 0) {
        currentModalImageIndex--;
    } else {
        currentModalImageIndex = modalImages.length - 1;
    }
    
    updateModalImage();
}

function nextModalImage(event) {
    event.stopPropagation();
    
    if (currentModalImageIndex < modalImages.length - 1) {
        currentModalImageIndex++;
    } else {
        currentModalImageIndex = 0;
    }
    
    updateModalImage();
}

function updateModalImage() {
    const modalImg = document.getElementById('galleryModalImage');
    const currentImg = modalImages[currentModalImageIndex];
    
    modalImg.src = currentImg.getAttribute('data-full') || currentImg.src;
    modalImg.alt = currentImg.alt;
}

// Keyboard navigation for modal
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('galleryModal');
    if (modal && modal.style.display === 'block') {
        switch(e.key) {
            case 'Escape':
                closeGalleryModal();
                break;
            case 'ArrowLeft':
                prevModalImage(e);
                break;
            case 'ArrowRight':
                nextModalImage(e);
                break;
        }
    }
});

// Make functions global
window.openGalleryModal = openGalleryModal;
window.closeGalleryModal = closeGalleryModal;
window.prevModalImage = prevModalImage;
window.nextModalImage = nextModalImage;