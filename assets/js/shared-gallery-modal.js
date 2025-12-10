/* ===========================
   SHARED GALLERY MODAL - RESTAURANT, MARINA & VILLA
   Replace assets/js/shared-gallery-modal.js
   =========================== */

(function($) {
    'use strict';

    // Detect which page we're on
    const isRestaurantPage = $('.single-restaurant-gallery').length > 0;
    const isMarinaPage = $('.marina-gallery').length > 0;
    const isVillaPage = $('.single-villa-gallery').length > 0;

    // Set modal ID based on page type
    let modalId, modalClass, galleryClass;
    
    if (isRestaurantPage) {
        modalId = '#restaurant-gallery-modal';
        modalClass = 'restaurant-gallery-modal';
        galleryClass = '.single-restaurant-gallery';
    } else if (isMarinaPage) {
        modalId = '#marina-gallery-modal';
        modalClass = 'marina-gallery-modal';
        galleryClass = '.marina-gallery';
    } else if (isVillaPage) {
        modalId = '#villa-gallery-fullscreen-modal';
        modalClass = 'villa-gallery-fullscreen-modal';
        galleryClass = '.single-villa-gallery';
    } else {
        console.log('No gallery detected on this page');
        return;
    }

    let currentImageIndex = 0;
    let galleryImages = [];

    // Collect all images from gallery
    function collectGalleryImages() {
        galleryImages = [];
        $(galleryClass + ' img').each(function() {
            const fullSrc = $(this).data('full') || $(this).attr('src');
            if (fullSrc) {
                galleryImages.push(fullSrc);
            }
        });
        console.log(`Found ${galleryImages.length} images in gallery`);
    }

    // Open modal
    function openModal(index = 0) {
        currentImageIndex = index;
        showImage(currentImageIndex);
        $(modalId).addClass('active');
        $('body').css('overflow', 'hidden');
    }

    // Close modal
    function closeModal() {
        $(modalId).removeClass('active');
        $('body').css('overflow', '');
    }

    // Show specific image
    function showImage(index) {
        if (galleryImages.length === 0) return;
        
        // Wrap around
        if (index < 0) {
            currentImageIndex = galleryImages.length - 1;
        } else if (index >= galleryImages.length) {
            currentImageIndex = 0;
        } else {
            currentImageIndex = index;
        }

        const modalContent = $(modalId + ' .modal-fullscreen-image');
        modalContent.attr('src', galleryImages[currentImageIndex]);
    }

    // Next image
    function nextImage() {
        showImage(currentImageIndex + 1);
    }

    // Previous image
    function prevImage() {
        showImage(currentImageIndex - 1);
    }

    // Initialize when DOM is ready
    $(document).ready(function() {
        collectGalleryImages();

        // "See All Photos" button click
        $('.see-all-photos-btn').on('click', function(e) {
            e.preventDefault();
            openModal(0);
        });

        // Gallery image clicks
        $(galleryClass + ' img').on('click', function() {
            const clickedIndex = $(galleryClass + ' img').index(this);
            openModal(clickedIndex);
        });

        // Modal navigation
        $(modalId + ' .modal-close').on('click', closeModal);
        $(modalId + ' .modal-prev').on('click', prevImage);
        $(modalId + ' .modal-next').on('click', nextImage);

        // Click outside to close
        $(modalId).on('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Keyboard navigation
        $(document).on('keydown', function(e) {
            if (!$(modalId).hasClass('active')) return;

            switch(e.key) {
                case 'Escape':
                    closeModal();
                    break;
                case 'ArrowLeft':
                    prevImage();
                    break;
                case 'ArrowRight':
                    nextImage();
                    break;
            }
        });

        // Touch swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        $(modalId).on('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });

        $(modalId).on('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            if (touchEndX < touchStartX - swipeThreshold) {
                nextImage(); // Swipe left
            }
            if (touchEndX > touchStartX + swipeThreshold) {
                prevImage(); // Swipe right
            }
        }
    });

    // Expose functions globally for inline onclick handlers (if needed)
    if (isRestaurantPage) {
        window.openRestaurantGalleryModal = openModal;
        window.closeRestaurantGalleryModal = closeModal;
        window.nextRestaurantImage = nextImage;
        window.prevRestaurantImage = prevImage;
    } else if (isMarinaPage) {
        window.openMarinaGalleryModal = openModal;
        window.closeMarinaGalleryModal = closeModal;
        window.nextMarinaImage = nextImage;
        window.prevMarinaImage = prevImage;
    } else if (isVillaPage) {
        window.openVillaGalleryModal = openModal;
        window.closeVillaGalleryModal = closeModal;
        window.nextVillaImage = nextImage;
        window.prevVillaImage = prevImage;
    }
    

})(jQuery);