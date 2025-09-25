<?php

get_header(); ?>

<!-- Breadcrumbs -->
<?php get_template_part('template-parts/breadcrumbs'); ?>

<main class="single-restaurant-main">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="restaurant-<?php the_ID(); ?>" <?php post_class('single-restaurant'); ?>>
                
                <div class="single-restaurant-container">
                    
                    <!-- Hero Section -->
                    <div class="single-restaurant-hero">
                        <div class="single-restaurant-hero-content">
                            <h1 class="single-restaurant-title"><?php the_title(); ?></h1>
                            <?php 
                            $page_subtitle = get_post_meta(get_the_ID(), '_restaurant_page_subtitle', true);
                            if ($page_subtitle) : ?>
                                <div class="single-restaurant-subtitle">
                                    <?php echo esc_html($page_subtitle); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Gallery Section -->
                    <div class="single-restaurant-gallery">
                        <?php 
                        $gallery_images = get_post_meta(get_the_ID(), '_restaurant_gallery', true);
                        $gallery_images = $gallery_images ? $gallery_images : array();
                        $display_images = array_slice($gallery_images, 0, 5); // Show first 5 images
                        $has_more_images = count($gallery_images) > 5;
                        ?>
                        
                        <?php if (!empty($display_images)) : ?>
                            <!-- Main large image -->
                            <div class="gallery-main-image">
                                <?php 
                                $main_image = wp_get_attachment_image_src($display_images[0], 'master');
                                if ($main_image) : ?>
                                    <img src="<?php echo esc_url($main_image[0]); ?>" alt="<?php the_title(); ?> - Main Gallery Image">
                                <?php endif; ?>
                            </div>
                            
                            <!-- Grid of 4 smaller images -->
                            <div class="gallery-grid">
                                <?php for ($i = 1; $i < 5 && $i < count($display_images); $i++) : ?>
                                    <div class="gallery-grid-item <?php echo ($i === 4 && $has_more_images) ? 'has-overlay' : ''; ?>">
                                        <?php 
                                        $grid_image = wp_get_attachment_image_src($display_images[$i], 'master');
                                        if ($grid_image) : ?>
                                            <img src="<?php echo esc_url($grid_image[0]); ?>" alt="<?php the_title(); ?> - Gallery Image <?php echo $i + 1; ?>">
                                        <?php endif; ?>
                                        
                                        <?php if ($i === 4 && $has_more_images) : ?>
                                            <div class="gallery-overlay">
                                                <button class="see-all-photos-btn" data-restaurant-id="<?php echo get_the_ID(); ?>">
                                                    <span>See All Photos</span>
                                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                        <path d="M3 6H9M9 6L6 3M9 6L6 9" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        <?php elseif ($i === 3 && count($display_images) === 4 && $has_more_images) : ?>
                                            <div class="gallery-overlay">
                                                <button class="see-all-photos-btn" data-restaurant-id="<?php echo get_the_ID(); ?>">
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
                                for ($i = $displayed_grid_images; $i < 4; $i++) : ?>
                                    <div class="gallery-grid-item gallery-placeholder">
                                        <div class="gallery-placeholder-content">
                                            <span>No Image</span>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        <?php else : ?>
                            <!-- No gallery images -->
                            <div class="gallery-no-images">
                                <div class="gallery-placeholder-main">
                                    <span>No Gallery Images</span>
                                </div>
                                <div class="gallery-grid">
                                    <?php for ($i = 0; $i < 4; $i++) : ?>
                                        <div class="gallery-grid-item gallery-placeholder">
                                            <div class="gallery-placeholder-content">
                                                <span>No Image</span>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Content Section -->
                    <div class="single-restaurant-content">
                        <div class="restaurant-main-content">
                            <?php 
                            $page_category_title = get_post_meta(get_the_ID(), '_restaurant_page_category_title', true);
                            if ($page_category_title) : ?>
                                <h2 class="restaurant-category-title"><?php echo esc_html($page_category_title); ?></h2>
                            <?php endif; ?>
                            
                            <div class="restaurant-description">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        
                        <!-- Vertical Divider -->
                        <div class="content-divider"></div>
                        
                        <!-- Sidebar -->
                        <div class="restaurant-sidebar">
                            <?php 
                            $page_cuisine_type = get_post_meta(get_the_ID(), '_restaurant_page_cuisine_type', true);
                            $page_operating_hours = get_post_meta(get_the_ID(), '_restaurant_page_operating_hours', true);
                            $menu_pdf = get_post_meta(get_the_ID(), '_restaurant_menu_pdf', true);
                            ?>
                            
                            <!-- Cuisine Info -->
                            <?php if ($page_cuisine_type) : ?>
                                <div class="sidebar-item">
                                    <div class="sidebar-item-header">
                                        <div class="sidebar-icon">
                                            <!-- Cutlery Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                                <path d="M14.875 3.5C12.95 3.5 11.375 5.075 11.375 7V15.75C11.375 16.7125 12.1625 17.5 13.125 17.5H14.875V23.625C14.875 24.15 15.225 24.5 15.75 24.5C16.275 24.5 16.625 24.15 16.625 23.625V16.625V5.25C16.625 4.2875 15.8375 3.5 14.875 3.5ZM14.875 15.75H13.125V7C13.125 6.0375 13.9125 5.25 14.875 5.25V15.75Z" fill="#A48456"/>
                                                <path d="M22.75 3.5C20.475 3.5 19.25 7.0875 19.25 9.625C19.25 12.25 20.5625 13.475 21.875 13.9125V23.625C21.875 24.15 22.225 24.5 22.75 24.5C23.275 24.5 23.625 24.15 23.625 23.625V13.9125C24.9375 13.5625 26.25 12.3375 26.25 9.625C26.25 7.0875 25.025 3.5 22.75 3.5ZM22.75 12.25C21.2625 12.25 21 10.5875 21 9.625C21 7.2625 22.1375 5.25 22.75 5.25C23.3625 5.25 24.5 7.2625 24.5 9.625C24.5 10.5875 24.2375 12.25 22.75 12.25Z" fill="#A48456"/>
                                                <path d="M8.75 4.375V9.625C8.75 11.1125 7.6125 12.25 6.125 12.25V23.625C6.125 24.15 5.775 24.5 5.25 24.5C4.725 24.5 4.375 24.15 4.375 23.625V12.25C2.8875 12.25 1.75 11.1125 1.75 9.625V4.375C1.75 3.85 2.1 3.5 2.625 3.5C3.15 3.5 3.5 3.85 3.5 4.375V9.625C3.5 10.15 3.85 10.5 4.375 10.5V4.375C4.375 3.85 4.725 3.5 5.25 3.5C5.775 3.5 6.125 3.85 6.125 4.375V10.5C6.65 10.5 7 10.15 7 9.625V4.375C7 3.85 7.35 3.5 7.875 3.5C8.4 3.5 8.75 3.85 8.75 4.375Z" fill="#A48456"/>
                                            </svg>
                                        </div>
                                        <h3 class="sidebar-item-title">Cuisine</h3>
                                    </div>
                                    <div class="sidebar-item-content">
                                        <p><?php echo nl2br(esc_html($page_cuisine_type)); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Opening Hours -->
                            <?php if ($page_operating_hours) : ?>
                                <div class="sidebar-item">
                                    <div class="sidebar-item-header">
                                        <div class="sidebar-icon">
                                            <!-- Clock Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                                <path d="M11 5V11L15 13M21 11C21 16.5228 16.5228 21 11 21C5.47715 21 1 16.5228 1 11C1 5.47715 5.47715 1 11 1C16.5228 1 21 5.47715 21 11Z" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <h3 class="sidebar-item-title">Opening Hours</h3>
                                    </div>
                                    <div class="sidebar-item-content">
                                        <p><?php echo nl2br(esc_html($page_operating_hours)); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Menu Download Button -->
                            <?php if ($menu_pdf) : ?>
                                <div class="sidebar-menu-button">
                                    <a href="<?php echo esc_url($menu_pdf); ?>" class="discover-menu-btn" download>
                                        <span>Discover Menu</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="14" viewBox="0 0 20 14" fill="none">
                                                <path d="M5.16732 10.7507C5.91136 10.7507 6.63553 10.8374 7.33982 11.0111C8.04428 11.1847 8.73678 11.4451 9.41732 11.7923V2.89648C8.79232 2.47982 8.1144 2.1569 7.38357 1.92773C6.65274 1.69857 5.91398 1.58398 5.16732 1.58398C4.63953 1.58398 4.12218 1.64994 3.61523 1.7819C3.10829 1.91386 2.59787 2.07703 2.08398 2.27148V11.3131C2.51454 11.1187 3.00412 10.9764 3.55273 10.8861C4.10135 10.7958 4.63953 10.7507 5.16732 10.7507ZM10.6673 11.7923C11.3618 11.4451 12.0423 11.1847 12.709 11.0111C13.3757 10.8374 14.084 10.7507 14.834 10.7507C15.3618 10.7507 15.9069 10.7923 16.4694 10.8756C17.0319 10.959 17.5145 11.0701 17.9173 11.209V2.27148C17.4451 2.03536 16.9464 1.86178 16.4211 1.75065C15.8958 1.63953 15.3668 1.58398 14.834 1.58398C14.084 1.58398 13.3583 1.69857 12.6569 1.92773C11.9555 2.1569 11.2923 2.47982 10.6673 2.89648V11.7923ZM10.0423 13.6673C9.33399 13.1395 8.56315 12.7333 7.72982 12.4486C6.89648 12.1639 6.04232 12.0215 5.16732 12.0215C4.44511 12.0215 3.66385 12.1639 2.82357 12.4486C1.98329 12.7333 1.3201 13.0284 0.833984 13.334V1.41732C1.41732 1.08398 2.09871 0.820097 2.87815 0.625651C3.6576 0.431205 4.42065 0.333984 5.16732 0.333984C6.04232 0.333984 6.89303 0.452039 7.7194 0.688151C8.54578 0.924264 9.32011 1.28536 10.0423 1.77148C10.7507 1.28536 11.5111 0.924264 12.3236 0.688151C13.1361 0.452039 13.9729 0.333984 14.834 0.333984C15.5807 0.333984 16.3437 0.43468 17.1232 0.636068C17.9026 0.837455 18.584 1.09787 19.1673 1.41732V13.334C18.6951 13.0145 18.0354 12.7159 17.1882 12.4381C16.3409 12.1604 15.5562 12.0215 14.834 12.0215C13.959 12.0215 13.1187 12.1673 12.3132 12.459C11.5076 12.7506 10.7507 13.1534 10.0423 13.6673ZM11.6673 5.04232V4.04232C12.1257 3.84786 12.5944 3.70203 13.0736 3.60482C13.5527 3.50761 14.0562 3.45898 14.584 3.45898C14.9451 3.45898 15.2993 3.48678 15.6465 3.54232C15.9937 3.59786 16.334 3.66732 16.6673 3.75065V4.66732C16.334 4.54232 15.9972 4.44857 15.6569 4.38607C15.3166 4.32357 14.959 4.29232 14.584 4.29232C14.0562 4.29232 13.5493 4.35828 13.0632 4.49023C12.577 4.62219 12.1118 4.80619 11.6673 5.04232ZM11.6673 9.62565V8.60482C12.1257 8.41732 12.5944 8.27669 13.0736 8.18294C13.5527 8.08919 14.0562 8.04232 14.584 8.04232C14.9451 8.04232 15.2993 8.07011 15.6465 8.12565C15.9937 8.18119 16.334 8.25065 16.6673 8.33398V9.25065C16.334 9.12565 15.9972 9.0319 15.6569 8.9694C15.3166 8.9069 14.959 8.87565 14.584 8.87565C14.0562 8.87565 13.5493 8.93815 13.0632 9.06315C12.577 9.18815 12.1118 9.37565 11.6673 9.62565ZM11.6673 7.33398V6.33398C12.1257 6.13953 12.5944 5.99369 13.0736 5.89648C13.5527 5.79928 14.0562 5.75065 14.584 5.75065C14.9451 5.75065 15.2993 5.77844 15.6465 5.83398C15.9937 5.88953 16.334 5.95898 16.6673 6.04232V6.95898C16.334 6.83398 15.9972 6.74023 15.6569 6.67773C15.3166 6.61523 14.959 6.58398 14.584 6.58398C14.0562 6.58398 13.5493 6.64994 13.0632 6.7819C12.577 6.91386 12.1118 7.09786 11.6673 7.33398Z" fill="white"/>
                                            </svg>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                </div>
                
                <div id="restaurant-gallery-modal" class="restaurant-gallery-modal" style="display: none;">
                    <div class="restaurant-gallery-modal-overlay"></div>
                    <div class="restaurant-gallery-modal-content">
                        <div class="restaurant-gallery-modal-header">
                            <h3><?php the_title(); ?> - Gallery</h3>
                            <button class="restaurant-gallery-modal-close">&times;</button>
                        </div>
                        <div class="restaurant-gallery-modal-grid">
                            <?php if (!empty($gallery_images)) : ?>
                                <?php foreach ($gallery_images as $image_id) : ?>
                                    <?php 
                                    $full_image = wp_get_attachment_image_src($image_id, 'large');
                                    $thumb_image = wp_get_attachment_image_src($image_id, 'medium');
                                    if ($full_image && $thumb_image) : ?>
                                        <div class="restaurant-gallery-modal-item">
                                            <img src="<?php echo esc_url($thumb_image[0]); ?>" alt="<?php the_title(); ?> Gallery" 
                                                 data-full="<?php echo esc_url($full_image[0]); ?>"
                                                 onclick="openImageViewer('<?php echo esc_url($full_image[0]); ?>')">
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
            </article>
            
        <?php endwhile; ?>
    <?php endif; ?>
    
</main>

<!-- Gallery JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // See All Photos button
    const seeAllBtn = document.querySelector('.see-all-photos-btn');
    const restaurantGalleryModal = document.getElementById('restaurant-gallery-modal');
    const modalClose = document.querySelector('.restaurant-gallery-modal-close');
    const modalOverlay = document.querySelector('.restaurant-gallery-modal-overlay');
    
    if (seeAllBtn && restaurantGalleryModal) {
        seeAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            restaurantGalleryModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
    }
    
    if (modalClose) {
        modalClose.addEventListener('click', function() {
            restaurantGalleryModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
    }
    
    if (modalOverlay) {
        modalOverlay.addEventListener('click', function() {
            restaurantGalleryModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
    }
});

function openImageViewer(imageSrc) {
    // You can implement a lightbox here if desired
    window.open(imageSrc, '_blank');
}
</script>

<?php get_footer(); ?>