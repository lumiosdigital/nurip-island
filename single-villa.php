<?php
/**
 * Template Name: Single Villa
 * Template for displaying individual villa pages
 */

get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); 
    // Get villa meta data
    $subtitle = get_post_meta(get_the_ID(), '_villa_subtitle', true);
    $category_title = get_post_meta(get_the_ID(), '_villa_category_title', true);
    $description = get_post_meta(get_the_ID(), '_villa_description', true);
    $features_list = get_post_meta(get_the_ID(), '_villa_features_list', true);
    $gallery_images = get_post_meta(get_the_ID(), '_villa_gallery', true);
    $booking_url = get_post_meta(get_the_ID(), '_villa_booking_url', true);
    
    // Prepare gallery images (exactly like restaurant)
    $display_images = is_array($gallery_images) ? array_slice($gallery_images, 0, 5) : array();
    $has_more_images = is_array($gallery_images) && count($gallery_images) > 5;
    
    // Get villa features with icons
    $villa_features = get_post_meta(get_the_ID(), '_villa_features', true);
    if (!is_array($villa_features)) {
        $villa_features = array();
    }
    
    // Get icon paths
    $upload_dir = wp_upload_dir();
    $icon_url = $upload_dir['baseurl'] . '/villa-feature-icons/';
?>

<!-- Breadcrumbs -->
<?php get_template_part('template-parts/breadcrumbs'); ?>

<main class="single-villa-main">
    <article class="single-villa-article">
        
        <!-- Hero Section -->
        <div class="single-villa-container">
            <div class="single-villa-hero-content">
                <?php if ($subtitle) : ?>
                    <p class="single-villa-subtitle"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
                <h1 class="single-villa-title"><?php the_title(); ?></h1>
            </div>
        </div>

        <!-- Gallery Section - EXACTLY LIKE RESTAURANT -->
        <div class="single-villa-gallery-wrapper">
            <?php if (!empty($display_images)) : ?>
                <div class="single-villa-gallery">
                    <!-- Large main image on left -->
                    <div class="gallery-main-image">
                        <?php 
                        $main_image = wp_get_attachment_image_src($display_images[0], 'master');
                        if ($main_image) : 
                            $main_image_full = wp_get_attachment_image_src($display_images[0], 'master');
                        ?>
                            <img src="<?php echo esc_url($main_image[0]); ?>" 
                                 data-full="<?php echo esc_url($main_image_full ? $main_image_full[0] : $main_image[0]); ?>"
                                 alt="<?php the_title(); ?> - Main Gallery Image">
                        <?php endif; ?>
                    </div>
                    
                    <!-- Grid of 4 smaller images on right -->
                    <div class="gallery-grid">
                        <?php for ($i = 1; $i < 5 && $i < count($display_images); $i++) : ?>
                            <div class="gallery-grid-item <?php echo ($i === 4 && $has_more_images) ? 'has-overlay' : ''; ?>">
                                <?php 
                                $grid_image = wp_get_attachment_image_src($display_images[$i], 'master');
                                if ($grid_image) : 
                                    $grid_image_full = wp_get_attachment_image_src($display_images[$i], 'master');
                                ?>
                                    <img src="<?php echo esc_url($grid_image[0]); ?>" 
                                         data-full="<?php echo esc_url($grid_image_full ? $grid_image_full[0] : $grid_image[0]); ?>"
                                         alt="<?php the_title(); ?> - Gallery Image <?php echo $i + 1; ?>">
                                <?php endif; ?>
                                
                                <?php if ($i === 4 && $has_more_images) : ?>
                                    <div class="gallery-overlay">
                                        <button class="see-all-photos-btn">
                                            <span>See All Photos</span>
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                <path d="M3 6H9M9 6L6 3M9 6L6 9" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                <?php elseif ($i === 3 && count($display_images) === 4 && $has_more_images) : ?>
                                    <div class="gallery-overlay">
                                        <button class="see-all-photos-btn">
                                            <span>See All Photos</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                <path d="M1 7H13M13 7L7 1M13 7L7 13" stroke="#8B5E1D" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                        
                        <!-- Fill remaining grid slots if needed -->
                        <?php 
                        $displayed_grid_images = min(4, count($display_images) - 1);
                        for ($i = $displayed_grid_images; $i < 4; $i++) : 
                        ?>
                            <div class="gallery-grid-item gallery-placeholder">
                                <div class="gallery-placeholder-content">No Image</div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="single-villa-gallery">
                    <div class="gallery-no-images">
                        <div class="gallery-placeholder-main">No images available</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Content Section -->
        <div class="single-villa-container">
            <div class="single-villa-content">
                
                <!-- Main Content -->
                <div class="villa-main-content">
                    <?php if ($category_title) : ?>
                        <h2 class="villa-category-title"><?php echo esc_html($category_title); ?></h2>
                    <?php endif; ?>
                    
                    <?php if ($description) : ?>
                        <div class="villa-description">
                            <?php echo wpautop(wp_kses_post($description)); ?>
                        </div>
                    <?php endif; ?>

                    <div class="content-divider-horizontal"></div>

                    <?php if ($features_list) : ?>
                        <div class="villa-features-list">
                            <?php echo wpautop(wp_kses_post($features_list)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Vertical Divider Between Content and Sidebar -->
                <div class="content-divider"></div>

                <!-- Sidebar -->
                <aside class="villa-sidebar">
                    <?php if (!empty($villa_features)) : ?>
                        <?php foreach ($villa_features as $feature) : 
                            $feature_text = isset($feature['text']) ? $feature['text'] : (is_string($feature) ? $feature : '');
                            $feature_icon = isset($feature['icon']) ? $feature['icon'] : '';
                        ?>
                            <div class="villa-sidebar-item">
                                <div class="villa-sidebar-item-icon">
                                    <?php if ($feature_icon && file_exists($upload_dir['basedir'] . '/villa-feature-icons/' . $feature_icon)) : ?>
                                        <img src="<?php echo esc_url($icon_url . $feature_icon); ?>" 
                                             alt="" 
                                             class="feature-icon-img">
                                    <?php endif; ?>
                                </div>
                                <h3 class="villa-sidebar-item-title"><?php echo esc_html($feature_text); ?></h3>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if ($booking_url) : ?>
                        <div class="villa-sidebar-booking-button">
                            <a href="<?php echo esc_url($booking_url); ?>" 
                               class="book-villa-btn" 
                               target="_blank" 
                               rel="noopener noreferrer">
                                BOOK YOUR STAY
                            </a>
                        </div>
                    <?php endif; ?>
                </aside>
                
            </div>
        </div>

        <!-- Fullscreen Gallery Modal (COPIED FROM RESTAURANT) -->
        <div id="villaGalleryModal" class="villa-gallery-fullscreen-modal" onclick="closeVillaGalleryModal()">
            <span class="villa-gallery-modal-close" onclick="closeVillaGalleryModal()">&times;</span>
            <img class="villa-gallery-modal-content" id="villaGalleryModalImage" onclick="event.stopPropagation()">
            <div class="villa-gallery-modal-nav">
                <button class="villa-gallery-modal-prev" onclick="prevVillaModalImage(event)">&lsaquo;</button>
                <button class="villa-gallery-modal-next" onclick="nextVillaModalImage(event)">&rsaquo;</button>
            </div>
        </div>
        
    </article>
</main>

<script>
// Villa Gallery Modal JavaScript - EXACTLY COPIED FROM SINGLE RESTAURANT
let currentVillaModalImageIndex = 0;
let villaModalImages = [];

document.addEventListener('DOMContentLoaded', function() {
    // Collect all gallery images - ALWAYS, not just when button exists
    const galleryImages = document.querySelectorAll('.single-villa-gallery img[data-full]');
    villaModalImages = Array.from(galleryImages);
    
    // Add click handlers to ALL gallery images
    villaModalImages.forEach((img) => {
        img.style.cursor = 'pointer';
        img.addEventListener('click', function() {
            openVillaGalleryModal(this);
        });
    });
    
    // See All Photos button (if it exists)
    const seeAllBtn = document.querySelector('.see-all-photos-btn');
    if (seeAllBtn) {
        seeAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Open modal starting from first image
            if (villaModalImages.length > 0) {
                openVillaGalleryModal(villaModalImages[0]);
            }
        });
    }
});

function openVillaGalleryModal(imgElement) {
    const modal = document.getElementById('villaGalleryModal');
    const modalImg = document.getElementById('villaGalleryModalImage');
    
    currentVillaModalImageIndex = villaModalImages.indexOf(imgElement);
    
    modal.style.display = 'block';
    modalImg.src = imgElement.getAttribute('data-full') || imgElement.src;
    modalImg.alt = imgElement.alt;
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
}

function closeVillaGalleryModal() {
    const modal = document.getElementById('villaGalleryModal');
    modal.style.display = 'none';
    
    // Restore body scroll
    document.body.style.overflow = 'auto';
}

function prevVillaModalImage(event) {
    event.stopPropagation();
    
    if (currentVillaModalImageIndex > 0) {
        currentVillaModalImageIndex--;
    } else {
        currentVillaModalImageIndex = villaModalImages.length - 1;
    }
    
    updateVillaModalImage();
}

function nextVillaModalImage(event) {
    event.stopPropagation();
    
    if (currentVillaModalImageIndex < villaModalImages.length - 1) {
        currentVillaModalImageIndex++;
    } else {
        currentVillaModalImageIndex = 0;
    }
    
    updateVillaModalImage();
}

function updateVillaModalImage() {
    const modalImg = document.getElementById('villaGalleryModalImage');
    const currentImg = villaModalImages[currentVillaModalImageIndex];
    
    modalImg.src = currentImg.getAttribute('data-full') || currentImg.src;
    modalImg.alt = currentImg.alt;
}

// Keyboard navigation for modal
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('villaGalleryModal');
    if (modal && modal.style.display === 'block') {
        switch(e.key) {
            case 'Escape':
                closeVillaGalleryModal();
                break;
            case 'ArrowLeft':
                prevVillaModalImage(e);
                break;
            case 'ArrowRight':
                nextVillaModalImage(e);
                break;
        }
    }
});
</script>

<?php endwhile; endif; ?>

<!-- Simple Booking Modal with Calendar Inside -->
<?php 
$calendar_id = get_post_meta(get_the_ID(), '_villa_booking_calendar_id', true);
if ($calendar_id) : 
?>
<div id="villa-booking-modal-simple" class="villa-booking-modal" aria-hidden="true" role="dialog">
    <div class="villa-booking-backdrop"></div>
    <div class="villa-booking-container" role="document">
        <button class="villa-booking-close" aria-label="Close booking">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                <circle cx="15" cy="15" r="14.5" stroke="currentColor"/>
                <path d="M10 10L20 20M20 10L10 20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </button>
        
        <div class="villa-booking-header">
            <h2 class="villa-booking-title">Book <?php the_title(); ?></h2>
            <p class="villa-booking-subtitle">Select your dates and complete your reservation</p>
        </div>
        
        <div class="villa-booking-content">
            <div class="villa-booking-calendar-wrapper">
                <?php 
                // Render calendar directly in modal
                $calendar_id = get_post_meta(get_the_ID(), '_villa_booking_calendar_id', true);
                $form_id     = get_post_meta(get_the_ID(), '_villa_booking_form_id', true); // <— add this

                if ($calendar_id) {
                    echo do_shortcode(
                        sprintf('[wpbs id="%s"%s]',
                            esc_attr($calendar_id),
                            $form_id ? ' form_id="' . esc_attr($form_id) . '"' : ''
                        )
                    );
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // Open modal - calendar already inside, just show it
        $(document).on('click', '.book-villa-btn', function(e) {
            e.preventDefault();
            $('#villa-booking-modal-simple').addClass('active').attr('aria-hidden','false');
            $('body').addClass('villa-booking-open');
            $('.villa-booking-close').focus();

            setTimeout(function(){
                if (window.wpbs) {
                if (typeof wpbs.init === 'function') wpbs.init();
                $(document).trigger('wpbs:calendar_loaded');
                $('.wpbs-calendar').trigger('wpbs:init');
                }
            }, 0);
        });
                    
        // Close modal
        function closeModal() {
            $('#villa-booking-modal-simple').removeClass('active');
            $('#villa-booking-modal-simple').attr('aria-hidden', 'true');
            $('body').removeClass('villa-booking-open');
        }
        
        $(document).on('click', '.villa-booking-close, .villa-booking-backdrop', closeModal);
        
        // ESC key to close
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $('#villa-booking-modal-simple').hasClass('active')) {
                closeModal();
            }
        });
    });
    
})(jQuery);
</script>
<?php endif; ?>

<?php get_footer(); ?>