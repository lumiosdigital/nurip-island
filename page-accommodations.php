<?php
/**
 * Template Name: Accommodations Page
 * Description: Main accommodations page with Riahi Residences and Westin carousels
 */

get_header(); ?>

<!-- Breadcrumbs -->
<div class="accommodations-breadcrumbs">
    <?php get_template_part('template-parts/breadcrumbs'); ?>
</div>

<main class="accommodations-page">
    
    <!-- Hero Section -->
    <section class="accommodations-hero-section">
        <?php 
        $hero_image_id = get_theme_mod('nirup_accommodations_hero_image');
        if ($hero_image_id) {
            echo wp_get_attachment_image($hero_image_id, 'full', false, array('class' => 'accommodations-hero-bg-image'));
        }
        ?>
        <div class="accommodations-hero-overlay"></div>
        <div class="accommodations-hero-content">
            <h1 class="accommodations-hero-title">
                <?php echo esc_html(get_theme_mod('nirup_accommodations_hero_title', 'ACCOMMODATION')); ?>
            </h1>
            <p class="accommodations-hero-subtitle">
                <?php echo esc_html(get_theme_mod('nirup_accommodations_hero_subtitle', 'Find your perfect retreat on Nirup Island — from luxurious resort stays to private residences')); ?>
            </p>
        </div>
    </section>

    <!-- Riahi Residences Section (FIRST) -->
    <section class="riahi-section">
        <div class="riahi-container">
            
            <!-- Riahi Header -->
            <div class="riahi-header">
                <h2 class="riahi-title">
                    <?php echo esc_html(get_theme_mod('nirup_riahi_section_title', 'RIAHI RESIDENCES')); ?>
                </h2>
                <p class="riahi-description">
                    <?php echo esc_html(get_theme_mod('nirup_riahi_section_description', 'Riahi Residences offers a tranquil and spacious retreat, with elegantly designed villas featuring fully equipped kitchens and private pools in select units—providing an exclusive sanctuary where guests can enjoy both comfort and privacy. While offering seclusion, the residences remain just a short walk from the island\'s restaurants and the amenities of The Westin Nirup Island Resort & Spa, accessible with day passes.')); ?>
                </p>
            </div>

            <!-- Riahi Amenities -->
            <div class="riahi-amenities">
                <div class="accpage-amenities-row">
                    <div class="accpage-amenity-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                        <path d="M7.875 22.75H20.125C20.6089 22.75 21 22.358 21 21.875V14C21 13.517 20.6089 13.125 20.125 13.125H7.875C7.39113 13.125 7 13.517 7 14V21.875C7 22.358 7.39113 22.75 7.875 22.75ZM8.75 14.875H19.25V21H8.75V14.875Z" fill="#A48456"/>
                        <path d="M22.75 4.375H5.25C4.28487 4.375 3.5 5.15987 3.5 6.125V10.5V25.375C3.5 25.858 3.89113 26.25 4.375 26.25H23.625C24.1089 26.25 24.5 25.858 24.5 25.375V10.5V6.125C24.5 5.15987 23.7151 4.375 22.75 4.375ZM5.25 6.125H22.75V9.625H5.25V6.125ZM22.75 24.5H5.25V11.375H22.75V24.5Z" fill="#A48456"/>
                        <path d="M9.625 7.875C9.625 8.358 9.233 8.75 8.75 8.75C8.267 8.75 7.875 8.358 7.875 7.875C7.875 7.392 8.267 7 8.75 7C9.233 7 9.625 7.392 9.625 7.875Z" fill="#A48456"/>
                        <path d="M20.125 7.875C20.125 8.358 19.733 8.75 19.25 8.75C18.767 8.75 18.375 8.358 18.375 7.875C18.375 7.392 18.767 7 19.25 7C19.733 7 20.125 7.392 20.125 7.875Z" fill="#A48456"/>
                        <path d="M16.625 7.875C16.625 8.358 16.2339 8.75 15.75 8.75H12.25C11.7661 8.75 11.375 8.358 11.375 7.875C11.375 7.392 11.7661 7 12.25 7H15.75C16.2339 7 16.625 7.392 16.625 7.875Z" fill="#A48456"/>
                        <path d="M6.125 2.625C6.125 2.142 6.51613 1.75 7 1.75H10.5C10.9839 1.75 11.375 2.142 11.375 2.625C11.375 3.108 10.9839 3.5 10.5 3.5H7C6.51613 3.5 6.125 3.108 6.125 2.625Z" fill="#A48456"/>
                        <path d="M16.625 2.625C16.625 2.142 17.0161 1.75 17.5 1.75H21C21.4839 1.75 21.875 2.142 21.875 2.625C21.875 3.108 21.4839 3.5 21 3.5H17.5C17.0161 3.5 16.625 3.108 16.625 2.625Z" fill="#A48456"/>
                        </svg>
                        <span>Full Kitchen</span>
                    </div>
                    <div class="accpage-amenity-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                        <g clip-path="url(#clip0_1326_3478)">
                            <path d="M14 0C6.28053 0 0 6.28053 0 14C0 21.7195 6.28053 28 14 28C21.7195 28 28 21.7195 28 14C28 6.28053 21.7195 0 14 0ZM26.25 14C26.25 17.0629 25.1121 19.8599 23.2472 22.01L20.4872 19.25H22.75C23.2337 19.25 23.625 18.8582 23.625 18.375V14.875C23.625 14.3918 23.2337 14 22.75 14H15.2372L5.99003 4.75278C8.14012 2.88794 10.9371 1.75 14 1.75C20.7548 1.75 26.25 7.24522 26.25 14ZM6.125 17.5V15.75H9.625V17.5H6.125ZM11.375 15.75H14.5128L16.2628 17.5H11.375V15.75ZM16.9872 15.75H21.875V17.5H18.7372L16.9872 15.75ZM1.75 14C1.75 10.9371 2.88794 8.14012 4.75278 5.99003L12.7628 14H5.25C4.76634 14 4.375 14.3918 4.375 14.875V18.375C4.375 18.8582 4.76634 19.25 5.25 19.25H18.0128L22.01 23.2472C19.8599 25.1121 17.0629 26.25 14 26.25C7.24522 26.25 1.75 20.7548 1.75 14ZM12.25 6.125C12.25 5.64178 12.6413 5.25 13.125 5.25C13.6087 5.25 14 5.64178 14 6.125C14 7.57247 15.1775 8.75 16.625 8.75H20.125C22.0553 8.75 23.625 10.3202 23.625 12.25C23.625 12.7332 23.2337 13.125 22.75 13.125C22.2663 13.125 21.875 12.7332 21.875 12.25C21.875 11.2849 21.0897 10.5 20.125 10.5H16.625C14.2128 10.5 12.25 8.53716 12.25 6.125Z" fill="#A48456"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_1326_3478">
                            <rect width="28" height="28" fill="white"/>
                            </clipPath>
                        </defs>
                        </svg>
                        <span>Non-smoking rooms</span>
                    </div>

                </div>
                <div class="accpage-amenities-row">
                    <div class="accpage-amenity-item">                     
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                        <path d="M11.606 12.131C12.1896 11.0731 12.3821 9.87263 12.1634 8.65988C11.9315 7.38063 11.2184 6.2335 10.1535 5.42675C10.0012 5.31213 9.81575 5.25 9.625 5.25V3.5C9.625 2.53487 8.84012 1.75 7.875 1.75H6.125C5.15987 1.75 4.375 2.53487 4.375 3.5V5.25C4.186 5.25 4.00225 5.31125 3.85 5.42412C2.51563 6.42337 1.75 7.95462 1.75 9.625C1.75 10.4738 1.96 11.3173 2.35812 12.0645C2.71162 12.7286 2.71162 13.5214 2.35812 14.1855C1.96 14.9327 1.75 15.7762 1.75 16.625V24.5C1.75 25.4651 2.53487 26.25 3.5 26.25H10.5C11.4651 26.25 12.25 25.4651 12.25 24.5V16.625C12.25 15.7815 12.0531 14.9747 11.6655 14.231C11.2954 13.5187 11.2735 12.7348 11.606 12.131ZM6.125 3.5H7.875V5.25H6.125V3.5ZM10.5 24.5H3.5V16.625C3.5 16.0545 3.63562 15.5102 3.90337 15.0071C4.53162 13.8285 4.53162 12.4206 3.90337 11.242C3.63562 10.7397 3.5 10.1955 3.5 9.625C3.5 8.60475 3.92787 7.66238 4.68475 7H9.3135C9.90062 7.5215 10.3066 8.22588 10.4405 8.97138C10.5875 9.78425 10.4597 10.5849 10.073 11.2866C9.45787 12.4031 9.47187 13.8049 10.1132 15.0378C10.3705 15.5313 10.5 16.065 10.5 16.625V24.5Z" fill="#A48456"/>
                        <path d="M24.1526 15.3081C23.5471 13.9781 23.0239 12.8301 22.8296 11.0915C22.7106 10.0275 21.9704 9.18225 21 8.87863V6.84162L21.9713 6.64738C22.3151 8.274 23.5471 9.14987 23.9978 9.46575C24.1509 9.57337 24.3259 9.625 24.4991 9.625C25.319 9.65563 25.7057 8.491 25.0022 8.03425C24.2349 7.49525 23.8219 6.95712 23.6827 6.30612C24.3259 6.1565 25.3785 6.16437 25.375 5.25V2.625C25.375 2.14113 24.9839 1.75 24.5 1.75H18.375C16.9277 1.75 15.75 2.92775 15.75 4.375V8.911C14.7341 9.27325 14 10.2357 14 11.375V24.5C14 25.4651 14.7831 26.25 15.7456 26.25H24.493C24.9664 26.25 25.4091 26.0636 25.739 25.7241C26.0689 25.3855 26.2509 24.9191 26.2386 24.4457C26.1196 19.6271 25.074 17.3329 24.1526 15.3081ZM22.5592 16.0335C22.736 16.422 22.9136 16.8131 23.0869 17.2253C22.4893 17.6199 21.0779 17.5612 20.517 17.1544C20.1932 16.9934 19.803 16.8105 19.2509 16.7072V10.5H20.223C20.6675 10.5 21.0411 10.8378 21.0901 11.2849C21.3141 13.3018 21.9196 14.6291 22.5592 16.0335ZM18.375 3.5H23.625V4.53338L19.9535 5.2675C19.5449 5.34887 19.25 5.70763 19.25 6.125V8.75H17.5V4.375C17.5 3.892 17.892 3.5 18.375 3.5ZM16.625 10.5H17.5V16.7081C16.7072 16.8507 16.3581 17.1369 15.75 17.367V11.375C15.75 10.892 16.142 10.5 16.625 10.5ZM15.75 24.5V19.1669C16.5428 19.0243 16.8919 18.7381 17.5 18.508V21.875C17.5 22.3589 17.8911 22.75 18.375 22.75C18.8589 22.75 19.25 22.3589 19.25 21.875V18.508C20.1154 18.8458 20.475 19.2386 21.875 19.25C22.7238 19.25 23.2645 19.0689 23.688 18.8772C24.1106 20.265 24.4256 22.001 24.486 24.5H15.75Z" fill="#A48456"/>
                        </svg>
                        <span>Daily housekeeping</span>
                    </div>
                    <div class="accpage-amenity-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="none">
                        <path d="M3.57638 8.32692C3.11777 8.78554 3.11777 9.53191 3.57638 9.99502C4.035 10.4536 4.78137 10.4536 5.24448 9.99502C8.41881 6.82069 13.585 6.82069 16.7593 9.99502C16.9886 10.2243 17.2899 10.3412 17.5911 10.3412C17.8923 10.3412 18.1936 10.2243 18.4229 9.99502C18.8815 9.53641 18.8815 8.79004 18.4229 8.32692C14.3313 4.23087 7.66794 4.23087 3.57638 8.32692Z" fill="#A48456"/>
                        <path d="M6.75802 11.5108C6.29941 11.9694 6.29941 12.7158 6.75802 13.1789C7.21664 13.6375 7.96301 13.6375 8.42612 13.1789C9.84243 11.7581 12.1535 11.7581 13.5698 13.1789C13.7991 13.4082 14.1003 13.5251 14.4016 13.5251C14.7028 13.5251 15.0041 13.4082 15.2334 13.1789C15.692 12.7203 15.692 11.9739 15.2334 11.5153C12.8999 9.17274 9.09606 9.17274 6.75802 11.5108Z" fill="#A48456"/>
                        <path d="M11.0008 17.3151C11.8675 17.3151 12.57 16.6126 12.57 15.7459C12.57 14.8793 11.8675 14.1768 11.0008 14.1768C10.1342 14.1768 9.43164 14.8793 9.43164 15.7459C9.43164 16.6126 10.1342 17.3151 11.0008 17.3151Z" fill="#A48456"/>
                        <path d="M21.656 5.08959C15.7795 -0.782469 6.22052 -0.782469 0.343961 5.08959C-0.114654 5.54821 -0.114654 6.29458 0.343961 6.75769C0.802575 7.2163 1.54895 7.2163 2.01206 6.75769C6.96689 1.79836 15.0331 1.79836 19.9924 6.75769C20.2217 6.987 20.523 7.1039 20.8242 7.1039C21.1255 7.1039 21.4267 6.987 21.656 6.75769C22.1147 6.29908 22.1147 5.5527 21.656 5.08959Z" fill="#A48456"/>
                        </svg>
                        <span>Free WiFi</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="accpage-divider">
            <span class="accpage-divider-text">ROOM TYPES</span>
            <div class="accpage-divider-line"></div>
        </div>

        <!-- Riahi Carousel -->
        <div class="accpage-carousel riahi-carousel">
            <div class="accpage-carousel-wrapper">
                <div class="accpage-carousel-track riahi-track">
                    <?php
                    // Query villa posts
                    $villas = new WP_Query(array(
                        'post_type' => 'villa',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                    ));

                    if ($villas->have_posts()) :
                        while ($villas->have_posts()) : $villas->the_post();
                            $villa_category = get_post_meta(get_the_ID(), '_villa_category', true);
                            ?>
                            <div class="accpage-card">
                                <a href="<?php the_permalink(); ?>" class="accpage-link">
                                    <div class="accpage-image-container">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('full', array('class' => 'accpage-image')); ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="accpage-details">
                                        <?php if ($villa_category) : ?>
                                            <p class="accpage-category"><?php echo esc_html($villa_category); ?></p>
                                        <?php endif; ?>
                                        <h3 class="accpage-name"><?php the_title(); ?></h3>
                                    </div>
                                    <button class="accpage-button">Book Now</button>
                                </a>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else : ?>
                        <div class="no-villas-message">
                            <p>No villas available at the moment.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Carousel Navigation -->
            <div class="accpage-carousel-nav">
                <div class="accpage-carousel-line"></div>
                <div class="accpage-nav-controls">
                    <button class="accpage-nav-btn prev riahi-prev" aria-label="Previous villa">
                        <svg class="nav-arrow" width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="#A48456"/>
                            <path d="M26.5 18.7917H11.9167M11.9167 18.7917L19.2083 11.5M11.9167 18.7917L19.2083 26.0833" stroke="
                            #A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button class="accpage-nav-btn next riahi-next" aria-label="Next villa">
                        <svg class="nav-arrow" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.5" y="0.5" width="39" height="39" rx="19.5" stroke="#A48456"/>
                            <path d="M12.5 19.7917H27.0833M27.0833 19.7917L19.7917 12.5M27.0833 19.7917L19.7917 27.0833" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- The Westin Section (SECOND) -->
    <section class="westin-section">
        <div class="westin-container">
            
            <!-- Westin Header -->
            <div class="westin-header">
                <h2 class="westin-title">
                    <?php echo esc_html(get_theme_mod('nirup_westin_section_title', 'THE WESTIN NIRUP ISLAND RESORT & SPA')); ?>
                </h2>
                <p class="westin-description">
                    <?php echo esc_html(get_theme_mod('nirup_westin_section_description', 'Set atop the island\'s hill, each room features beautiful sea views of the Riau Islands. Relax with a soothing spa treatment, enjoy a session in the wellness center, or simply take in the serene surroundings. Families will appreciate the Kids Club, where children can enjoy engaging activities in a safe and fun environment, allowing parents to relax nearby. For those seeking more privacy, the island offers 1 to 3-bedroom villas over the water, each with a private pool, providing direct access to the sea and a closer connection to the island.')); ?>
                </p>
            </div>

            <!-- Westin Amenities -->
            <div class="westin-amenities">
                <div class="accpage-amenities-row">
                    <div class="accpage-amenity-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <path d="M7 14C7 14 7 10 14 10C21 10 21 14 21 14" stroke="#3D332F" stroke-width="1.5"/>
                        </svg>
                        <span>Sea view</span>
                    </div>
                    <div class="accpage-amenity-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <rect x="5" y="9" width="18" height="12" rx="1" stroke="#3D332F" stroke-width="1.5"/>
                        </svg>
                        <span>Heavenly® Bed & Shower</span>
                    </div>
                </div>
                <div class="accpage-amenities-row">
                    <div class="accpage-amenity-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <rect x="5" y="8" width="18" height="10" rx="1" stroke="#3D332F" stroke-width="1.5"/>
                        </svg>
                        <span>Private pool (villas only)</span>
                    </div>
                    <div class="accpage-amenity-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <circle cx="14" cy="14" r="8" stroke="#3D332F" stroke-width="1.5"/>
                        </svg>
                        <span>Heavenly Spa by Westin™</span>
                    </div>
                </div>
                <div class="accpage-amenities-row">
                    <div class="accpage-amenity-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <path d="M8 14L14 8L20 14" stroke="#3D332F" stroke-width="1.5"/>
                        </svg>
                        <span>Curated island dining</span>
                    </div>
                    <div class="accpage-amenity-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <circle cx="11" cy="11" r="4" stroke="#3D332F" stroke-width="1.5"/>
                        </svg>
                        <span>Kids Club access</span>
                    </div>
                </div>
                <div class="accpage-amenities-row">
                    <div class="accpage-amenity-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <rect x="7" y="10" width="14" height="8" rx="1" stroke="#3D332F" stroke-width="1.5"/>
                        </svg>
                        <span>WestinWORKOUT® Fitness Studio</span>
                    </div>
                    <div class="accpage-amenity-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <path d="M8 10H20V19H8V10Z" stroke="#3D332F" stroke-width="1.5"/>
                        </svg>
                        <span>Daily housekeeping</span>
                    </div>
                </div>
                <div class="accpage-amenities-row">
                    <div class="accpage-amenity-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <circle cx="14" cy="14" r="10" stroke="#3D332F" stroke-width="1.5"/>
                        </svg>
                        <span>Non-smoking rooms</span>
                    </div>
                    <div class="accpage-amenity-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <path d="M10 16C10 14.8954 10.8954 14 12 14C13.1046 14 14 14.8954 14 16" stroke="#3D332F" stroke-width="1.5"/>
                        </svg>
                        <span>Free WiFi</span>
                    </div>
                </div>
            </div>

            <!-- Westin CTA Button -->
            <div class="westin-cta-wrapper">
                <a href="<?php echo esc_url(get_theme_mod('nirup_westin_booking_link', '#')); ?>" 
                   class="westin-cta-button" 
                   target="_blank" 
                   rel="noopener noreferrer">
                    <?php echo esc_html(get_theme_mod('nirup_westin_cta_text', 'BOOK AT THE WESTIN')); ?>
                </a>
            </div>

        </div>
        <div class="accpage-divider">
            <span class="accpage-divider-text">ROOM TYPES</span>
            <div class="accpage-divider-line"></div>
        </div>

        <!-- Westin Carousel -->
        <div class="accpage-carousel westin-carousel">
            <div class="accpage-carousel-wrapper">
                <div class="accpage-carousel-track westin-track">
                    <?php
                    // Query westin_room posts
                    $westin_rooms = new WP_Query(array(
                        'post_type' => 'westin_room',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                    ));

                    if ($westin_rooms->have_posts()) :
                        while ($westin_rooms->have_posts()) : $westin_rooms->the_post();
                            ?>
                            <div class="accpage-card westin-card">
                                <div class="accpage-image-container">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('full', array('class' => 'accpage-image')); ?>
                                    <?php endif; ?>
                                </div>
                                <div class="accpage-details">
                                    <!-- <p class="accpage-category">Westin Nirup Island Resort & Spa</p> -->
                                    <h3 class="accpage-name"><?php the_title(); ?></h3>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else : ?>
                        <div class="no-rooms-message">
                            <p>No room types available at the moment.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Carousel Navigation -->
            <div class="accpage-carousel-nav">
                <div class="accpage-carousel-line"></div>
                <div class="accpage-nav-controls">
                    <button class="accpage-nav-btn prev westin-prev" aria-label="Previous room">
                        <svg class="nav-arrow" width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="#A48456"/>
                            <path d="M26.5 18.7917H11.9167M11.9167 18.7917L19.2083 11.5M11.9167 18.7917L19.2083 26.0833" stroke="
                            #A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button class="accpage-nav-btn next westin-next" aria-label="Next room">
                        <svg class="nav-arrow" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.5" y="0.5" width="39" height="39" rx="19.5" stroke="#A48456"/>
                            <path d="M12.5 19.7917H27.0833M27.0833 19.7917L19.7917 12.5M27.0833 19.7917L19.7917 27.0833" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>