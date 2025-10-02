<?php
/**
 * Template Name: Marina Page
 */

get_header(); ?>

<main class="marina-page">
    <?php
    // Include breadcrumbs
    get_template_part('template-parts/breadcrumbs');
    ?>

    <?php while (have_posts()) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class('marina-content'); ?>>
            
            <!-- Hero Section -->
            <div class="marina-hero">
                <div class="marina-hero-content">
                    <h1 class="marina-title"><?php echo esc_html(get_post_meta(get_the_ID(), '_marina_title', true) ?: 'Marina at Nirup Island'); ?></h1>
                    <p class="marina-subtitle"><?php echo esc_html(get_post_meta(get_the_ID(), '_marina_subtitle', true) ?: 'Seamless access, exclusive facilities'); ?></p>
                </div>
            </div>

            <!-- Gallery Section - EXACTLY COPIED FROM SINGLE RESTAURANT -->
            <div class="marina-gallery-wrapper">
                <?php 
                $gallery_images = get_post_meta(get_the_ID(), '_marina_gallery', true);
                $gallery_images = is_array($gallery_images) ? array_filter($gallery_images) : array();
                $gallery_count = count($gallery_images);
                ?>
                
                <?php if ($gallery_count > 0) : ?>
                    <div class="marina-gallery">
                        <!-- Main Image -->
                        <div class="gallery-main-image">
                            <?php 
                            $main_image_id = $gallery_images[0];
                            $main_image = wp_get_attachment_image_src($main_image_id, 'full');
                            $main_image_alt = get_post_meta($main_image_id, '_wp_attachment_image_alt', true);
                            ?>
                            <img src="<?php echo esc_url($main_image[0]); ?>" 
                                 alt="<?php echo esc_attr($main_image_alt ?: get_the_title()); ?>"
                                 data-full="<?php echo esc_url($main_image[0]); ?>">
                        </div>

                        <!-- Grid Images -->
                        <div class="gallery-grid">
                            <?php 
                            // Display up to 4 more images in the grid
                            $grid_images = array_slice($gallery_images, 1, 4);
                            $grid_count = count($grid_images);
                            
                            foreach ($grid_images as $index => $image_id) :
                                $image = wp_get_attachment_image_src($image_id, 'full');
                                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                                $is_last = ($index === 3 || $index === $grid_count - 1);
                                $has_more = $gallery_count > 5;
                            ?>
                                <div class="gallery-grid-item <?php echo ($is_last && $has_more) ? 'has-overlay' : ''; ?>">
                                    <img src="<?php echo esc_url($image[0]); ?>" 
                                         alt="<?php echo esc_attr($image_alt ?: get_the_title()); ?>"
                                         data-full="<?php echo esc_url($image[0]); ?>">
                                    <?php if ($is_last && $has_more) : ?>
                                        <div class="gallery-overlay">
                                            <button class="see-all-photos-btn">
                                                <span>see all photos</span>
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                    <path d="M3 6H9M9 6L6 3M9 6L6 9" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else : ?>
                    <!-- No Images Placeholder -->
                    <div class="marina-gallery">
                        <div class="gallery-no-images">
                            <div class="gallery-placeholder-main">
                                <div class="gallery-placeholder-content">
                                    No gallery images available
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Fullscreen Gallery Modal - EXACTLY COPIED FROM SINGLE RESTAURANT -->
            <div id="marinaGalleryModal" class="marina-gallery-fullscreen-modal" onclick="closeMarinaGalleryModal()">
                <span class="marina-gallery-modal-close" onclick="closeMarinaGalleryModal()">&times;</span>
                <img class="marina-gallery-modal-content" id="marinaGalleryModalImage" onclick="event.stopPropagation()">
                <div class="marina-gallery-modal-nav">
                    <button class="marina-gallery-modal-prev" onclick="prevMarinaModalImage(event)">&lsaquo;</button>
                    <button class="marina-gallery-modal-next" onclick="nextMarinaModalImage(event)">&rsaquo;</button>
                </div>
            </div>

            <!-- Berthing Section -->
            <div class="marina-berthing-section">
                <div class="berthing-content">
                    <div class="berthing-text">
                        <div>
                            <h2 class="berthing-title">Exclusive Berthing at Nirup Island</h2>
                            <div class="berthing-description">
                                <p><?php echo wp_kses_post(get_post_meta(get_the_ID(), '_marina_berthing_description_1', true) ?: 'Experience effortless access to Nirup Island with berthing for up to 70 private yachts. Whether arriving with your own vessel or enjoying a private charter, our marina offers a seamless blend of convenience, privacy, and island serenity.'); ?></p>
                                <p><?php echo wp_kses_post(get_post_meta(get_the_ID(), '_marina_berthing_description_2', true) ?: 'ONE°15 Marina provides premium berthing for guests arriving on their private vessels. With easy access to the island, guests can choose to stay aboard their yacht or enjoy the comfort of The Westin Nirup Island Resort & Spa or Riahi Residences. The marina combines privacy and convenience, allowing you to fully embrace the island\'s tranquil beauty while remaining close to refined resort amenities.'); ?></p>
                            </div>
                        </div>
                            <div class="berthing-links">
                                <a href="#" class="berthing-link">Berthing Rates</a>
                                <a href="#" class="berthing-link">Arrival Procedure</a>
                                <a href="#" class="berthing-link">Marina Rules and Regulations</a>
                            </div>
                    </div>

                    <div class="berthing-divider"></div>

                    <div class="berthing-amenities">
                        <ul class="amenities-list">
                            <li class="amenity-item">
                                <div class="amenity-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="28" viewBox="0 0 26 28" fill="none">
                                        <path d="M13 0.900391C16.0355 0.900391 18.5087 3.31872 18.5088 6.2959C18.5086 8.64457 17.1164 10.6907 15.8828 12.0459C15.8988 12.6939 15.9636 13.3411 16.0684 13.8926C16.2518 14.8589 16.6385 15.6421 17.208 16.2314C17.7774 16.8207 18.5351 17.2211 19.4697 17.4131C19.8728 17.4959 20.5293 17.6122 21.3711 17.6973H22.0771C23.7461 17.6973 25.0996 19.0873 25.0996 20.791V24.0059C25.0996 24.099 25.0933 24.1854 25.0879 24.2559C25.0745 24.4264 24.9985 24.5857 24.874 24.7021C24.7495 24.8186 24.586 24.8836 24.416 24.8838H23.5049C23.1314 26.1647 21.9651 27.0994 20.6123 27.0996H5.38867C4.03572 27.0996 2.8686 26.1649 2.49512 24.8838H1.58496C1.4149 24.8838 1.25058 24.8186 1.12598 24.7021C1.00165 24.5857 0.925571 24.4263 0.912109 24.2559C0.906515 24.1851 0.900391 24.099 0.900391 24.0059V20.791C0.900391 19.0873 2.25384 17.6973 3.92285 17.6973H4.62891C5.30579 17.6297 5.98295 17.5295 6.53809 17.4141C7.48251 17.2176 8.24505 16.8149 8.81445 16.2266C9.38393 15.6381 9.76625 14.8576 9.94043 13.8975C10.0397 13.3503 10.1004 12.7015 10.1162 12.0459C8.88283 10.6909 7.49138 8.64415 7.49121 6.2959C7.49121 3.31877 9.96447 0.900404 13 0.900391ZM3.95312 24.8838C4.24746 25.3949 4.78643 25.7363 5.38867 25.7363H20.6123C21.2145 25.7362 21.7537 25.395 22.0479 24.8838H3.95312ZM3.92285 19.0615C3.00353 19.0615 2.25 19.8344 2.25 20.791V23.5195H23.75V20.791C23.75 19.8344 22.9964 19.0615 22.0771 19.0615H3.92285ZM13 2.26465C10.704 2.26469 8.84082 4.076 8.84082 6.2959C8.84101 8.29974 10.1601 10.1237 11.2832 11.3105C11.4042 11.4384 11.4716 11.6085 11.4707 11.7852C11.4667 12.6061 11.3946 13.4433 11.2676 14.1436C10.9913 15.6659 10.2784 16.8761 9.19629 17.6973H16.8184C15.8178 16.9336 15.1291 15.8315 14.8066 14.4521L14.7432 14.1494C14.6085 13.4398 14.5324 12.5999 14.5293 11.7842C14.5287 11.608 14.5961 11.4382 14.7168 11.3105C15.84 10.1237 17.159 8.29976 17.1592 6.2959C17.1592 4.07597 15.296 2.26465 13 2.26465Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                    </svg>
                                </div>
                                <span class="amenity-text">Customs, Immigration, Quarantine (CIQ) Facility</span>
                            </li>
                            <li class="amenity-item">
                                <div class="amenity-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="24" viewBox="0 0 28 24" fill="none">
                                        <path d="M10.8643 0.92041C8.89537 0.00204063 6.55848 0.853024 5.64062 2.82178C5.54186 3.03344 3.85718 6.64765 3.79102 6.78955C2.87525 8.75345 3.7276 11.0958 5.69141 12.0122V12.0132L9.07324 13.5884L7.63086 16.6821H4.40137C4.10754 15.4295 2.98284 14.4937 1.6416 14.4937H0.546875C0.189676 14.4938 -0.099674 14.7837 -0.0996094 15.1411V22.8013C-0.0996094 23.1586 0.18969 23.4485 0.546875 23.4487H1.6416C2.98286 23.4487 4.10647 22.5128 4.40039 21.2603H8.74023C9.83777 21.2603 10.8466 20.6175 11.3105 19.6226L13.2217 15.5239L17.5938 17.563C18.2602 17.8738 19.0201 17.7256 19.5225 17.2534L21.0322 17.9585C21.9087 18.367 22.9415 17.9853 23.3467 17.1157L25.1973 13.1489C25.3396 12.8441 25.3861 12.51 25.3438 12.187C26.5288 11.7174 27.4908 10.8192 28.0391 9.64404C28.1115 9.48847 28.1192 9.31025 28.0605 9.14893C28.0019 8.98765 27.8819 8.85623 27.7266 8.78369L10.8643 0.92041ZM1.6416 15.7876C2.49161 15.7876 3.18359 16.4796 3.18359 17.3296V20.6128C3.18359 21.4628 2.49156 22.1548 1.6416 22.1548H1.19434V15.7876H1.6416ZM12.0488 14.9761L10.1377 19.0757C9.88549 19.6163 9.33645 19.9653 8.74023 19.9653H4.47754V17.9771H8.04199C8.29353 17.9771 8.52257 17.8309 8.62891 17.603L10.2461 14.1362L12.0488 14.9761ZM21.9668 12.3091C22.6228 12.5191 23.3256 12.5964 24.0537 12.5112C24.047 12.542 24.0378 12.5722 24.0244 12.6011L22.1738 16.5688C22.069 16.7936 21.8035 16.8903 21.5791 16.7856L20.1826 16.1333L21.9668 12.3091ZM20.7754 11.7993L18.7354 16.1733L18.6895 16.2515C18.5657 16.4184 18.3377 16.4814 18.1416 16.3901L6.23926 10.8394C4.92211 10.2248 4.34983 8.65351 4.96387 7.33643L6.07812 4.94678L20.7754 11.7993ZM6.81348 3.36865C7.4292 2.04805 8.99618 1.47847 10.3164 2.09424L26.541 9.65869C25.5533 11.0753 23.6954 11.6409 22.0684 10.9712L21.9082 10.9009L6.62598 3.77393L6.81348 3.36865Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                    </svg>
                                </div>
                                <span class="amenity-text">24-hour Security & CCTV Surveillance</span>
                            </li>
                            <li class="amenity-item">
                                <div class="amenity-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                        <path d="M25.701 9.68723L21.326 7.93723C21.2893 7.92236 21.2517 7.91098 21.2132 7.90136C19.1097 7.37548 16.993 7.09549 14.8755 7.03161V5.97548C17.4209 5.08561 17.0928 1.37386 14.4695 0.91711C12.8586 0.623985 11.3755 1.86386 11.3755 3.50011C11.3755 3.98398 11.7675 4.37511 12.2505 4.37511C12.7335 4.37511 13.1255 3.98398 13.1255 3.50011C13.1255 2.97598 13.5963 2.53498 14.1668 2.64086C15.0733 2.79923 15.1258 4.11261 14.2228 4.34711C13.577 4.51423 13.1255 5.08386 13.1255 5.73048V7.03161C11.008 7.09549 8.8914 7.37636 6.7879 7.90136C6.75027 7.91098 6.71177 7.92323 6.67502 7.93723L2.30003 9.68723C1.91853 9.84036 1.69453 10.2385 1.7619 10.6436L2.6369 15.8936C2.7209 16.3967 3.21878 16.7249 3.71228 16.5989L6.12552 15.996V18.3751C6.12552 18.859 6.51752 19.2501 7.00052 19.2501C7.48352 19.2501 7.87552 18.859 7.87552 18.3751V14.8751C7.87552 14.6056 7.75127 14.351 7.53865 14.1856C7.32602 14.0202 7.0469 13.959 6.7879 14.0264L4.20753 14.6712L3.60465 11.0514L7.27002 9.58486C8.11265 9.37574 8.95702 9.21998 9.80315 9.08961C10.3351 10.9175 12.0309 12.2501 14.0005 12.2501C15.9675 12.2501 17.6659 10.9166 18.1988 9.08961C19.044 9.21998 19.8893 9.37574 20.731 9.58486L24.3964 11.0514L23.7935 14.6721L21.2132 14.0272C20.9533 13.9616 20.675 14.0202 20.4624 14.1865C20.2498 14.351 20.1255 14.6056 20.1255 14.8751V25.3751H15.7505C15.2675 25.3751 14.8755 25.7662 14.8755 26.2501C14.8755 26.734 15.2675 27.1251 15.7505 27.1251H21.0005C21.4835 27.1251 21.8755 26.734 21.8755 26.2501V15.996L24.2879 16.598C24.7753 16.7231 25.2784 16.402 25.3633 15.8927L26.2383 10.6427C26.3057 10.2385 26.0825 9.84036 25.701 9.68723ZM14.0005 10.5001C12.919 10.5001 11.9819 9.82723 11.5847 8.87348C13.1947 8.73086 14.8064 8.73086 16.4164 8.87348C16.0183 9.82723 15.0803 10.5001 14.0005 10.5001Z" fill="#A48456"/>
                                        <path d="M3.5 22.3125C3.5 22.5531 3.696 22.75 3.9375 22.75H13.125C13.608 22.75 14 23.1411 14 23.625C14 24.1089 13.608 24.5 13.125 24.5H3.9375C3.696 24.5 3.5 24.6969 3.5 24.9375C3.5 25.1781 3.696 25.375 3.9375 25.375H13.125C13.608 25.375 14 25.7661 14 26.25C14 26.7339 13.608 27.125 13.125 27.125H3.9375C2.73175 27.125 1.75 26.1441 1.75 24.9375C1.75 24.4431 1.92063 23.9916 2.19888 23.625C1.92063 23.2584 1.75 22.8069 1.75 22.3125C1.75 21.1059 2.73175 20.125 3.9375 20.125H13.125C13.608 20.125 14 20.5161 14 21C14 21.4839 13.608 21.875 13.125 21.875H3.9375C3.696 21.875 3.5 22.0719 3.5 22.3125Z" fill="#A48456"/>
                                    </svg>
                                </div>
                                <span class="amenity-text">Laundry Amenities</span>
                            </li>
                            <li class="amenity-item">
                                <div class="amenity-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                        <path d="M22.7507 23.3335C23.719 23.3335 24.5007 22.4585 24.5007 21.3852C24.5007 19.6352 22.7507 17.5002 22.7507 17.5002C22.7507 17.5002 21.0007 19.6235 21.0007 21.3852C21.0007 22.4585 21.7823 23.3335 22.7507 23.3335ZM11.084 25.6668C12.0523 25.6668 12.834 24.7918 12.834 23.7185C12.834 21.9685 11.084 19.8335 11.084 19.8335C11.084 19.8335 9.33398 21.9568 9.33398 23.7185C9.33398 24.7918 10.1157 25.6668 11.084 25.6668ZM18.6673 23.7185C18.6673 21.9685 16.9173 19.8335 16.9173 19.8335C16.9173 19.8335 15.1673 21.9568 15.1673 23.7185C15.1673 24.7918 15.949 25.6668 16.9173 25.6668C17.8857 25.6668 18.6673 24.7918 18.6673 23.7185ZM5.25065 23.3335C6.21898 23.3335 7.00065 22.4585 7.00065 21.3852C7.00065 19.6352 5.25065 17.5002 5.25065 17.5002C5.25065 17.5002 3.50065 19.6235 3.50065 21.3852C3.50065 22.4585 4.28232 23.3335 5.25065 23.3335ZM15.0503 4.7485L15.0503 3.3335C15.0503 2.78121 14.6026 2.3335 14.0503 2.3335H13.9551C13.4028 2.3335 12.9551 2.78121 12.9551 3.3335L12.9551 4.7485C8.35846 5.32016 4.66732 9.25183 4.66732 14.0002H3.33366C2.78155 14.0002 2.33398 14.4477 2.33398 14.9998C2.33398 15.5519 2.78155 15.9995 3.33366 15.9995L24.6676 15.9995C25.2197 15.9995 25.6673 15.5519 25.6673 14.9998C25.6673 14.4477 25.2197 14.0002 24.6676 14.0002H23.334C23.334 9.25183 19.647 5.32016 15.0503 4.7485ZM6.5 13.9995C6.5 10.1378 10.1383 6.49951 14 6.49951C17.8617 6.49951 21.5 10.1378 21.5 13.9995H6.5Z" fill="#A48456"/>
                                    </svg>
                                </div>
                                <span class="amenity-text">Shower Rooms</span>
                            </li>
                            <li class="amenity-item">
                                <div class="amenity-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="none">
                                    <path d="M3.57638 8.32692C3.11777 8.78554 3.11777 9.53191 3.57638 9.99502C4.035 10.4536 4.78137 10.4536 5.24448 9.99502C8.41881 6.82069 13.585 6.82069 16.7593 9.99502C16.9886 10.2243 17.2899 10.3412 17.5911 10.3412C17.8923 10.3412 18.1936 10.2243 18.4229 9.99502C18.8815 9.53641 18.8815 8.79004 18.4229 8.32692C14.3313 4.23087 7.66794 4.23087 3.57638 8.32692Z" fill="#A48456"/>
                                    <path d="M6.75802 11.5103C6.29941 11.9689 6.29941 12.7153 6.75802 13.1784C7.21664 13.637 7.96301 13.637 8.42612 13.1784C9.84243 11.7576 12.1535 11.7576 13.5698 13.1784C13.7991 13.4077 14.1003 13.5246 14.4016 13.5246C14.7028 13.5246 15.0041 13.4077 15.2334 13.1784C15.692 12.7198 15.692 11.9734 15.2334 11.5148C12.8999 9.17225 9.09606 9.17225 6.75802 11.5103Z" fill="#A48456"/>
                                    <path d="M11.0008 17.3151C11.8675 17.3151 12.57 16.6126 12.57 15.7459C12.57 14.8793 11.8675 14.1768 11.0008 14.1768C10.1342 14.1768 9.43164 14.8793 9.43164 15.7459C9.43164 16.6126 10.1342 17.3151 11.0008 17.3151Z" fill="#A48456"/>
                                    <path d="M21.656 5.08959C15.7795 -0.782469 6.22052 -0.782469 0.343961 5.08959C-0.114654 5.54821 -0.114654 6.29458 0.343961 6.75769C0.802575 7.2163 1.54895 7.2163 2.01206 6.75769C6.96689 1.79836 15.0331 1.79836 19.9924 6.75769C20.2217 6.987 20.523 7.1039 20.8242 7.1039C21.1255 7.1039 21.4267 6.987 21.656 6.75769C22.1147 6.29908 22.1147 5.5527 21.656 5.08959Z" fill="#A48456"/>
                                    </svg>
                                </div>
                                <span class="amenity-text">WiFi</span>
                            </li>
                            <li class="amenity-item">
                                <div class="amenity-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                        <path d="M14.875 3.5C12.95 3.5 11.375 5.075 11.375 7V15.75C11.375 16.7125 12.1625 17.5 13.125 17.5H14.875V23.625C14.875 24.15 15.225 24.5 15.75 24.5C16.275 24.5 16.625 24.15 16.625 23.625V16.625V5.25C16.625 4.2875 15.8375 3.5 14.875 3.5ZM14.875 15.75H13.125V7C13.125 6.0375 13.9125 5.25 14.875 5.25V15.75Z" fill="#A48456"/>
                                        <path d="M22.75 3.5C20.475 3.5 19.25 7.0875 19.25 9.625C19.25 12.25 20.5625 13.475 21.875 13.9125V23.625C21.875 24.15 22.225 24.5 22.75 24.5C23.275 24.5 23.625 24.15 23.625 23.625V13.9125C24.9375 13.5625 26.25 12.3375 26.25 9.625C26.25 7.0875 25.025 3.5 22.75 3.5ZM22.75 12.25C21.2625 12.25 21 10.5875 21 9.625C21 7.2625 22.1375 5.25 22.75 5.25C23.3625 5.25 24.5 7.2625 24.5 9.625C24.5 10.5875 24.2375 12.25 22.75 12.25Z" fill="#A48456"/>
                                        <path d="M8.75 4.375V9.625C8.75 11.1125 7.6125 12.25 6.125 12.25V23.625C6.125 24.15 5.775 24.5 5.25 24.5C4.725 24.5 4.375 24.15 4.375 23.625V12.25C2.8875 12.25 1.75 11.1125 1.75 9.625V4.375C1.75 3.85 2.1 3.5 2.625 3.5C3.15 3.5 3.5 3.85 3.5 4.375V9.625C3.5 10.15 3.85 10.5 4.375 10.5V4.375C4.375 3.85 4.725 3.5 5.25 3.5C5.775 3.5 6.125 3.85 6.125 4.375V10.5C6.65 10.5 7 10.15 7 9.625V4.375C7 3.85 7.35 3.5 7.875 3.5C8.4 3.5 8.75 3.85 8.75 4.375Z" fill="#A48456"/>
                                    </svg>
                                </div>
                                <span class="amenity-text">Restaurants</span>
                            </li>
                            <li class="amenity-item">
                                <div class="amenity-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="26" viewBox="0 0 24 26" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.8758 22.0017C21.1484 22.0017 21.8464 22.2432 22.1966 22.9705C22.4185 23.4315 22.4856 24.2516 22.4856 24.2516H1.52478C1.64675 22.5074 2.28526 22.0018 4.12675 22.0018L19.8758 22.0017ZM0.00195312 25.0016C0.00195312 25.4157 0.33772 25.7515 0.751889 25.7515H23.2506C23.6647 25.7515 24.0005 25.4157 24.0005 25.0016C24.0005 21.8684 22.8442 20.5018 19.8757 20.5018H4.12675C1.15828 20.5018 0.00195312 21.8684 0.00195312 25.0016ZM12.0013 9.62744C5.60337 9.62744 1.50187 13.5662 1.50187 19.0019C1.50187 19.416 1.83763 19.7518 2.2518 19.7518H21.7506C22.1649 19.7518 22.5006 19.416 22.5006 19.0019C22.5007 13.5662 18.3992 9.62744 12.0013 9.62744ZM3.03277 18.2519C3.38534 14.0564 6.72642 11.1274 12.0013 11.1274C17.277 11.1274 20.6183 14.0574 20.9699 18.2519H3.03277Z" fill="#A48456"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.2513 10.0019C11.2513 10.416 11.5871 10.7518 12.0012 10.7518C12.4154 10.7518 12.7512 10.416 12.7512 10.0019V8.87694H14.2511C14.6653 8.87694 15.001 8.54117 15.001 8.127C15.001 7.71283 14.6653 7.37707 14.2511 7.37707H9.75139C9.33722 7.37707 9.00145 7.71283 9.00145 8.127C9.00145 8.54121 9.33722 8.87694 9.75139 8.87694H11.2513V10.0019ZM12.7512 1.00238C12.7512 0.588209 12.4154 0.252441 12.0012 0.252441C11.5871 0.252441 11.2513 0.588209 11.2513 1.00238V3.62726C11.2513 4.04143 11.5871 4.37719 12.0012 4.37719C12.4154 4.37719 12.7512 4.04143 12.7512 3.62726V1.00238ZM1.23201 4.92601C0.913808 4.66086 0.440932 4.70385 0.175789 5.02201C-0.0893548 5.34017 -0.0463699 5.81309 0.271794 6.07824L2.52164 7.95314C2.83985 8.21828 3.31273 8.1753 3.57787 7.85713C3.84301 7.53893 3.80003 7.06605 3.48186 6.80091L1.23201 4.92601ZM23.7307 6.07828C24.0489 5.81313 24.0919 5.34022 23.8267 5.02205C23.5615 4.70389 23.0886 4.66086 22.7705 4.92605L20.5206 6.80095C20.2024 7.06609 20.1594 7.53901 20.4246 7.85717C20.6898 8.17538 21.1627 8.21837 21.4808 7.95318L23.7307 6.07828Z" fill="#A48456"/>
                                    </svg>
                                </div>
                                <span class="amenity-text">Marina Reception</span>
                            </li>
                            <li class="amenity-item">
                                <div class="amenity-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M0.705078 23.1548L0.845234 23.2949C10.709 22.2461 21.8774 14.1952 23.297 0.843059L23.1569 0.702903C9.80483 2.12256 1.75391 13.2909 0.705078 23.1548Z" stroke="#A48456" stroke-width="1.7" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <span class="amenity-text">Sea Sports Centre</span>
                            </li>
                        </ul>

                        <div class="berthing-buttons">
                            <a href="#" class="btn-outline">Reserve a CIQ Slot</a>
                            <a href="#" class="btn-primary">Book a Berth</a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Private Charters Section -->
            <div class="private-charters-section">
                <div class="charters-header">
                    <h2 class="charters-title">Private Charters</h2>
                    <p class="charters-subtitle">Exclusive journeys tailored to you</p>
                </div>

                <?php
                // Get all published private charters
                $charters_query = new WP_Query(array(
                    'post_type' => 'private_charter',
                    'posts_per_page' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                    'post_status' => 'publish'
                ));

                if ($charters_query->have_posts()) :
                    while ($charters_query->have_posts()) : $charters_query->the_post();
                        $charter_id = get_the_ID();
                        $description = get_post_meta($charter_id, '_charter_description', true);
                        $specifications = get_post_meta($charter_id, '_charter_specifications', true);
                        $specifications = is_array($specifications) ? $specifications : array();
                        $pricing = get_post_meta($charter_id, '_charter_pricing', true);

                        // Split specifications into two columns
                        $total_specs = count($specifications);
                        $mid_point = ceil($total_specs / 2);
                        $specs_col1 = array_slice($specifications, 0, $mid_point);
                        $specs_col2 = array_slice($specifications, $mid_point);
                ?>
                    <div class="charter-item">
                        <div class="charter-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('full'); ?>
                            <?php endif; ?>
                        </div>

                        <div class="charter-content">
                            <h3 class="charter-name"><?php the_title(); ?></h3>
                            <?php if ($description) : ?>
                                <p class="charter-description"><?php echo wp_kses_post($description); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($specifications)) : ?>
                                <div class="charter-specifications">
                                    <div class="charter-divider"></div>
                                    <div class="charter-specs-container">
                                        <div class="charter-details">
                                            <div class="charter-specs">
                                                <?php foreach ($specs_col1 as $spec) : ?>
                                                    <div class="charter-spec">
                                                        <span><?php echo esc_html($spec['text']); ?></span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
        
                                            <div class="charter-info">
                                                <?php foreach ($specs_col2 as $spec) : ?>
                                                    <div class="charter-spec">
                                                        <span><?php echo esc_html($spec['text']); ?></span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <?php if ($pricing) : ?>
                                            <div class="charter-pricing-section">
                                                <div class="charter-spec">
                                                    <div class="charter-pricing"><?php echo wp_kses_post(nl2br($pricing)); ?></div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <a href="#" class="btn-primary charter-book-btn">Book Now</a>                                        
            
                                    </div>

                                </div>
                                
                            <?php endif; ?>

                        </div>
                    </div>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>

        </article>

    <?php endwhile; ?>
</main>

<script>
// Marina Gallery Modal JavaScript - EXACTLY COPIED FROM SINGLE RESTAURANT
let currentMarinaModalImageIndex = 0;
let marinaModalImages = [];

document.addEventListener('DOMContentLoaded', function() {
    // See All Photos button
    const seeAllBtn = document.querySelector('.see-all-photos-btn');
    
    if (seeAllBtn) {
        // Collect all gallery images
        const galleryImages = document.querySelectorAll('.marina-gallery img[data-full]');
        marinaModalImages = Array.from(galleryImages);
        
        seeAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Open modal starting from first image
            if (marinaModalImages.length > 0) {
                openMarinaGalleryModal(marinaModalImages[0]);
            }
        });
        
        // Add click handlers to all gallery images
        marinaModalImages.forEach((img) => {
            img.style.cursor = 'pointer';
            img.addEventListener('click', function() {
                openMarinaGalleryModal(this);
            });
        });
    }
});

function openMarinaGalleryModal(imgElement) {
    const modal = document.getElementById('marinaGalleryModal');
    const modalImg = document.getElementById('marinaGalleryModalImage');
    
    currentMarinaModalImageIndex = marinaModalImages.indexOf(imgElement);
    
    modal.style.display = 'block';
    modalImg.src = imgElement.getAttribute('data-full') || imgElement.src;
    modalImg.alt = imgElement.alt;
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
}

function closeMarinaGalleryModal() {
    const modal = document.getElementById('marinaGalleryModal');
    modal.style.display = 'none';
    
    // Restore body scroll
    document.body.style.overflow = 'auto';
}

function prevMarinaModalImage(event) {
    event.stopPropagation();
    
    if (currentMarinaModalImageIndex > 0) {
        currentMarinaModalImageIndex--;
    } else {
        currentMarinaModalImageIndex = marinaModalImages.length - 1;
    }
    
    updateMarinaModalImage();
}

function nextMarinaModalImage(event) {
    event.stopPropagation();
    
    if (currentMarinaModalImageIndex < marinaModalImages.length - 1) {
        currentMarinaModalImageIndex++;
    } else {
        currentMarinaModalImageIndex = 0;
    }
    
    updateMarinaModalImage();
}

function updateMarinaModalImage() {
    const modalImg = document.getElementById('marinaGalleryModalImage');
    const currentImg = marinaModalImages[currentMarinaModalImageIndex];
    
    modalImg.src = currentImg.getAttribute('data-full') || currentImg.src;
    modalImg.alt = currentImg.alt;
}

// Keyboard navigation for modal
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('marinaGalleryModal');
    if (modal && modal.style.display === 'block') {
        switch(e.key) {
            case 'Escape':
                closeMarinaGalleryModal();
                break;
            case 'ArrowLeft':
                prevMarinaModalImage(e);
                break;
            case 'ArrowRight':
                nextMarinaModalImage(e);
                break;
        }
    }
});
</script>

<?php get_footer(); ?>