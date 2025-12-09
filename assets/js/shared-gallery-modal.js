/**
 * Shared Gallery Modal JavaScript
 * Works for: Single Restaurant, Marina, and any page with gallery
 * File: assets/js/shared-gallery-modal.js
 */

(function() {
    'use strict';

    /**
     * Generic Gallery Modal Handler
     * @param {string} gallerySelector - CSS selector for gallery container
     * @param {string} modalId - ID of the modal element
     * @param {string} modalImageId - ID of the modal image element
     * @param {string} prefix - Prefix for function names (e.g., 'restaurant', 'marina')
     */
    function initGalleryModal(gallerySelector, modalId, modalImageId, prefix) {
        let currentModalImageIndex = 0;
        let modalImages = [];

        const seeAllBtn = document.querySelector(`${gallerySelector} .see-all-photos-btn`);
        
        if (seeAllBtn) {
            // Collect all gallery images
            const galleryImages = document.querySelectorAll(`${gallerySelector} img[data-full]`);
            modalImages = Array.from(galleryImages);
            
            // See All Photos button
            seeAllBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (modalImages.length > 0) {
                    openModal(modalImages[0]);
                }
            });
            
            // Add click handlers to all gallery images
            modalImages.forEach((img) => {
                img.style.cursor = 'pointer';
                img.addEventListener('click', function() {
                    openModal(this);
                });
            });
        }

        // Open modal
        function openModal(imgElement) {
            const modal = document.getElementById(modalId);
            const modalImg = document.getElementById(modalImageId);
            
            if (!modal || !modalImg) return;
            
            currentModalImageIndex = modalImages.indexOf(imgElement);
            
            modal.style.display = 'block';
            modalImg.src = imgElement.getAttribute('data-full') || imgElement.src;
            modalImg.alt = imgElement.alt;
            
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }

        // Close modal
        function closeModal() {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Previous image
        function prevImage(event) {
            if (event) event.stopPropagation();
            
            if (modalImages.length === 0) return;
            
            currentModalImageIndex--;
            if (currentModalImageIndex < 0) {
                currentModalImageIndex = modalImages.length - 1;
            }
            
            const modalImg = document.getElementById(modalImageId);
            const imgElement = modalImages[currentModalImageIndex];
            
            if (modalImg && imgElement) {
                modalImg.src = imgElement.getAttribute('data-full') || imgElement.src;
                modalImg.alt = imgElement.alt;
            }
        }

        // Next image
        function nextImage(event) {
            if (event) event.stopPropagation();
            
            if (modalImages.length === 0) return;
            
            currentModalImageIndex++;
            if (currentModalImageIndex >= modalImages.length) {
                currentModalImageIndex = 0;
            }
            
            const modalImg = document.getElementById(modalImageId);
            const imgElement = modalImages[currentModalImageIndex];
            
            if (modalImg && imgElement) {
                modalImg.src = imgElement.getAttribute('data-full') || imgElement.src;
                modalImg.alt = imgElement.alt;
            }
        }

        // Expose functions globally with prefix
        window[`open${prefix}GalleryModal`] = openModal;
        window[`close${prefix}GalleryModal`] = closeModal;
        window[`prev${prefix}ModalImage`] = prevImage;
        window[`next${prefix}ModalImage`] = nextImage;

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById(modalId);
            if (!modal || modal.style.display !== 'block') return;
            
            if (e.key === 'Escape') closeModal();
            if (e.key === 'ArrowLeft') prevImage();
            if (e.key === 'ArrowRight') nextImage();
        });

        console.log(`${prefix} gallery modal initialized`);
    }

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        // Single Restaurant Gallery
        if (document.querySelector('.single-restaurant-gallery')) {
            initGalleryModal(
                '.single-restaurant-gallery',
                'restaurantGalleryModal',
                'restaurantGalleryModalImage',
                'Restaurant'
            );
        }

        // Marina Gallery
        if (document.querySelector('.marina-gallery')) {
            initGalleryModal(
                '.marina-gallery',
                'marinaGalleryModal',
                'marinaGalleryModalImage',
                'Marina'
            );
        }

        // Add mobile swipe enhancement if on mobile
        if (window.innerWidth <= 768) {
            enhanceMobileSwipe();
        }
    });

    /**
     * Enhanced Mobile Swipe Experience
     * Works for any gallery with horizontal scroll
     */
    function enhanceMobileSwipe() {
        const galleries = document.querySelectorAll('.single-restaurant-gallery, .marina-gallery');
        
        galleries.forEach(gallery => {
            if (!gallery) return;

            let touchStartX = 0;
            let touchEndX = 0;
            let isDragging = false;

            gallery.addEventListener('touchstart', function(e) {
                touchStartX = e.touches[0].clientX;
                isDragging = true;
                gallery.style.scrollSnapType = 'none';
            });

            gallery.addEventListener('touchmove', function(e) {
                if (!isDragging) return;
                touchEndX = e.touches[0].clientX;
            });

            gallery.addEventListener('touchend', function() {
                if (!isDragging) return;
                isDragging = false;
                
                gallery.style.scrollSnapType = 'x mandatory';
                
                const swipeDistance = touchStartX - touchEndX;
                const threshold = 50;
                
                // Optional: haptic feedback
                if (Math.abs(swipeDistance) > threshold && navigator.vibrate) {
                    navigator.vibrate(10);
                }
            });

            // Prevent image context menu
            const images = gallery.querySelectorAll('img');
            images.forEach(img => {
                img.addEventListener('contextmenu', e => e.preventDefault());
            });
        });

        console.log('Mobile swipe enhancement initialized');
    }
})();