<?php
/**
 * Single Event/Offer Template
 * File: single-event_offer.php
 */

get_header(); ?>

<!-- Breadcrumbs -->
<?php get_template_part('template-parts/breadcrumbs'); ?>

<main class="single-event-offer-main">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="event-offer-<?php the_ID(); ?>" <?php post_class('single-event-offer'); ?>>
                
                <!-- Hero Section -->
                <div class="single-event-offer-hero">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="single-event-offer-hero-bg">
                            <?php the_post_thumbnail('full', array(
                                'class' => 'single-event-offer-hero-image',
                                'alt' => get_the_title() . ' - ' . get_bloginfo('name')
                            )); ?>
                            <div class="single-event-offer-hero-overlay"></div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Hero Content -->
                    <div class="single-event-offer-hero-content">
                        <?php 
                        $event_date = get_post_meta(get_the_ID(), '_event_offer_date', true);
                        if ($event_date) : ?>
                            <div class="single-event-offer-date">
                                <?php echo date('F j, Y', strtotime($event_date)); ?>
                            </div>
                        <?php endif; ?>
                        
                        <h1 class="single-event-offer-hero-title"><?php the_title(); ?></h1>
                    </div>
                </div>
                
                <!-- Content Section -->
                <div class="single-event-offer-content-section">
                    <div class="single-event-offer-container">
                        
                        <!-- Main Content -->
                        <div class="single-event-offer-content">
                            <?php 
                            $short_description = get_post_meta(get_the_ID(), '_event_offer_short_description', true);
                            if ($short_description) : ?>
                                <h2 class="single-event-offer-subtitle"><?php echo esc_html($short_description); ?></h2>
                            <?php endif; ?>
                            
                            <div class="single-event-offer-description">
                                <?php the_content(); ?>
                            </div>
                            
                            <div class="single-event-offer-divider"></div>
                            
                            <?php 
                            $additional_info = get_post_meta(get_the_ID(), '_event_offer_additional_info', true);
                            if ($additional_info) : ?>
                                <div class="single-event-offer-additional-description">
                                    <p><?php echo wp_kses_post($additional_info); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <!-- How to Book Button -->
                            <div class="single-event-offer-booking">
                                <a href="#" class="single-event-offer-book-btn">How to Book</a>
                            </div>
                        </div>
                        
                        <!-- Event Details -->
                        <div class="single-event-offer-details">
                            <?php 
                            $event_date = get_post_meta(get_the_ID(), '_event_offer_date', true);
                            $event_end_date = get_post_meta(get_the_ID(), '_event_offer_end_date', true);
                            $event_location = get_post_meta(get_the_ID(), '_event_offer_location', true);
                            $event_location_description = get_post_meta(get_the_ID(), '_event_offer_location_description', true);
                            ?>
                            
                            <?php if ($event_date) : ?>
                                <div class="event-detail-item">
                                    <div class="event-detail-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="47" height="48" viewBox="0 0 47 48" fill="none">
                                        <path d="M35.9941 40.1553C36.3507 39.8647 36.8756 39.919 37.166 40.2754L41.7793 45.9346C42.0697 46.2909 42.0163 46.815 41.6602 47.1055C41.3055 47.3945 40.781 47.3442 40.4893 46.9863L35.875 41.3271C35.5846 40.9708 35.6379 40.4458 35.9941 40.1553Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                        <path d="M9.67139 40.4756C9.96195 40.1195 10.4861 40.0664 10.8423 40.3564C11.1986 40.6469 11.2518 41.172 10.9614 41.5283L6.51221 46.9863C6.22137 47.3432 5.69603 47.3955 5.34033 47.1055C4.98451 46.815 4.93087 46.2907 5.22119 45.9346L9.67139 40.4756Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                        <path d="M10.542 0.707031C14.0683 0.707067 17.298 2.6373 18.9707 5.74512C19.1885 6.1498 19.0373 6.65508 18.6328 6.87305C18.228 7.09105 17.7227 6.93893 17.5049 6.53418C16.1229 3.9664 13.4548 2.37113 10.542 2.37109C6.1855 2.37109 2.64062 5.91597 2.64062 10.2725C2.64063 12.7984 3.80572 15.1115 5.83691 16.6201C6.20593 16.8943 6.28288 17.4161 6.00879 17.7852C5.73463 18.154 5.21274 18.2311 4.84375 17.957C2.42171 16.1581 0.976563 13.2855 0.976562 10.2725C0.976562 4.9978 5.26733 0.707031 10.542 0.707031Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                        <path d="M36.458 0.707031C41.7326 0.707031 46.0234 4.9978 46.0234 10.2725C46.0234 13.1785 44.7249 15.8929 42.4609 17.7197C42.1039 18.0078 41.5804 17.9532 41.291 17.5947C41.0025 17.2369 41.0583 16.7136 41.416 16.4248C43.2867 14.9154 44.3594 12.673 44.3594 10.2725C44.3594 5.91597 40.8145 2.37109 36.458 2.37109C33.5903 2.37116 30.9418 3.93025 29.5469 6.43945C29.3233 6.84134 28.8167 6.98589 28.415 6.7627C28.0133 6.53929 27.8685 6.03263 28.0918 5.63086C29.7803 2.59365 32.986 0.707097 36.458 0.707031Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                        <path d="M23.5 4.67773C34.9988 4.67779 44.3535 14.0323 44.3535 25.5312C44.3535 37.0301 34.9988 46.3847 23.5 46.3848C12.0011 46.3848 2.64654 37.0302 2.64648 25.5312C2.64648 14.0324 12.001 4.67773 23.5 4.67773ZM23.5 6.3418C12.9192 6.3418 4.31055 14.9504 4.31055 25.5312C4.31055 36.1121 12.9192 44.7207 23.5 44.7207C34.0807 44.7206 42.6885 36.1121 42.6885 25.5312C42.6885 14.9505 34.0808 6.34185 23.5 6.3418Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                        <path d="M34.3672 13.9395C34.6922 13.6146 35.219 13.6147 35.5439 13.9395C35.869 14.2645 35.8691 14.7922 35.5439 15.1172L25.9111 24.75C25.5861 25.075 25.0586 25.0752 24.7334 24.75C24.4085 24.425 24.4087 23.8983 24.7334 23.5732L34.3672 13.9395Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                        <path d="M13.0312 19.5879C13.261 19.1898 13.7698 19.0534 14.168 19.2832L21.6221 23.5859C22.0201 23.8158 22.1566 24.3256 21.9268 24.7236C21.6961 25.123 21.186 25.2574 20.7891 25.0283L13.3359 20.7246C12.9379 20.4947 12.8014 19.986 13.0312 19.5879Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                        <path d="M23.5 22.4395C25.2054 22.4395 26.5928 23.8268 26.5928 25.5322C26.5926 27.2376 25.2054 28.6249 23.5 28.625C21.7945 28.625 20.4074 27.2376 20.4072 25.5322C20.4072 23.8267 21.7944 22.4395 23.5 22.4395ZM23.5 24.1035C22.7125 24.1035 22.0713 24.745 22.0713 25.5322C22.0714 26.3193 22.7126 26.96 23.5 26.96C24.2871 26.9599 24.9276 26.3193 24.9277 25.5322C24.9277 24.745 24.2872 24.1036 23.5 24.1035Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                        <path d="M23.5 9.49023C23.9598 9.49023 24.332 9.86255 24.332 10.3223V11.7314C24.3318 12.1909 23.9596 12.5635 23.5 12.5635C23.0404 12.5635 22.6682 12.1909 22.668 11.7314V10.3223C22.668 9.86254 23.0403 9.49023 23.5 9.49023Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                        <path d="M9.69971 24.6992C10.1592 24.6995 10.5317 25.0716 10.5317 25.5312C10.5317 25.9909 10.1592 26.363 9.69971 26.3633H8.29053C7.83082 26.3633 7.4585 25.9911 7.4585 25.5312C7.4585 25.0714 7.83082 24.6992 8.29053 24.6992H9.69971Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                        <path d="M23.5 38.501C23.9598 38.501 24.332 38.8732 24.332 39.333V40.7412C24.332 41.2009 23.9597 41.5742 23.5 41.5742C23.0403 41.5742 22.668 41.201 22.668 40.7412V39.333C22.668 38.8732 23.0403 38.501 23.5 38.501Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                        <path d="M38.709 24.7002C39.1688 24.7002 39.542 25.0724 39.542 25.5322C39.542 25.9921 39.1687 26.3643 38.709 26.3643H37.3008C36.841 26.3643 36.4688 25.992 36.4688 25.5322C36.4688 25.0724 36.841 24.7002 37.3008 24.7002H38.709Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                        </svg>
                                    </div>
                                    <div class="event-detail-content">
                                        <h3 class="event-detail-title">Date & Time</h3>
                                            <div class="event-detail-text">
                                                <?php if ($event_end_date) : 
                                                    $start_date = date('Y-m-d', strtotime($event_date));
                                                    $end_date = date('Y-m-d', strtotime($event_end_date));
                                                    
                                                    if ($start_date === $end_date) : 
                                                        // Same day - show date once, then times
                                                        ?>
                                                        <p><?php echo date('F j, Y', strtotime($event_date)); ?></p>
                                                        <p><?php echo date('g:i a', strtotime($event_date)) . ' - ' . date('g:i a', strtotime($event_end_date)); ?></p>
                                                    <?php else : 
                                                        // Different days - show full start and end dates
                                                        ?>
                                                        <p><?php echo date('F j, Y', strtotime($event_date)) . ' at ' . date('g:i a', strtotime($event_date)); ?></p>
                                                        <p><?php echo date('F j, Y', strtotime($event_end_date)) . ' at ' . date('g:i a', strtotime($event_end_date)); ?></p>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <p><?php echo date('F j, Y', strtotime($event_date)); ?></p>
                                                    <p><?php echo date('g:i a', strtotime($event_date)); ?></p>
                                                <?php endif; ?>
                                            </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($event_location) : ?>
                                <div class="event-detail-item">
                                    <div class="event-detail-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="48" viewBox="0 0 34 48" fill="none">
                                        <path d="M16.82 44.16C16.9461 44.1602 17.071 44.1354 17.1875 44.0872C17.3039 44.0389 17.4097 43.9681 17.4988 43.8788C18.1371 43.2404 33.14 28.1025 33.14 16.32C33.14 11.9917 31.4206 7.84062 28.36 4.78002C25.2994 1.71942 21.1484 0 16.82 0C12.4917 0 8.34062 1.71942 5.28002 4.78002C2.21943 7.84062 0.5 11.9917 0.5 16.32C0.5 28.1025 15.5029 43.2404 16.1413 43.8788C16.2303 43.9681 16.3361 44.0389 16.4526 44.0872C16.5691 44.1354 16.6939 44.1602 16.82 44.16ZM16.82 1.92C20.6379 1.92417 24.2981 3.44265 26.9978 6.14227C29.6974 8.84189 31.2159 12.5022 31.22 16.32C31.22 25.9472 19.7591 38.7038 16.82 41.8163C13.881 38.7057 2.42 25.9538 2.42 16.32C2.42417 12.5022 3.94265 8.84189 6.64227 6.14227C9.34189 3.44265 13.0022 1.92417 16.82 1.92Z" fill="#A48456"/>
                                        <path d="M25.4597 16.3202C25.4597 14.6114 24.953 12.9409 24.0036 11.5201C23.0542 10.0992 21.7048 8.9918 20.1261 8.33786C18.5473 7.68392 16.8101 7.51282 15.1341 7.84619C13.4581 8.17957 11.9186 9.00245 10.7103 10.2108C9.50197 11.4191 8.67908 12.9586 8.34571 14.6346C8.01233 16.3106 8.18343 18.0478 8.83737 19.6266C9.49131 21.2053 10.5987 22.5547 12.0196 23.5041C13.4404 24.4535 15.1109 24.9602 16.8197 24.9602C19.1104 24.9577 21.3066 24.0466 22.9264 22.4268C24.5461 20.8071 25.4572 18.6109 25.4597 16.3202ZM10.0997 16.3202C10.0997 14.9911 10.4938 13.6919 11.2322 12.5868C11.9706 11.4817 13.0201 10.6203 14.2481 10.1117C15.476 9.60309 16.8272 9.47001 18.1307 9.7293C19.4343 9.9886 20.6317 10.6286 21.5715 11.5684C22.5113 12.5082 23.1513 13.7056 23.4106 15.0092C23.6699 16.3127 23.5368 17.6639 23.0282 18.8918C22.5196 20.1197 21.6582 21.1693 20.5531 21.9077C19.448 22.6461 18.1488 23.0402 16.8197 23.0402C15.0381 23.038 13.3301 22.3293 12.0703 21.0696C10.8105 19.8098 10.1018 18.1018 10.0997 16.3202Z" fill="#A48456"/>
                                        <path d="M25.4597 46.0801H8.17973C7.92512 46.0801 7.68094 46.1812 7.5009 46.3613C7.32087 46.5413 7.21973 46.7855 7.21973 47.0401C7.21973 47.2947 7.32087 47.5389 7.5009 47.7189C7.68094 47.8989 7.92512 48.0001 8.17973 48.0001H25.4597C25.7143 48.0001 25.9585 47.8989 26.1386 47.7189C26.3186 47.5389 26.4197 47.2947 26.4197 47.0401C26.4197 46.7855 26.3186 46.5413 26.1386 46.3613C25.9585 46.1812 25.7143 46.0801 25.4597 46.0801Z" fill="#A48456"/>
                                        </svg>
                                    </div>
                                    <div class="event-detail-content">
                                        <h3 class="event-detail-title"><?php echo esc_html($event_location); ?></h3>
                                        <?php if ($event_location_description) : ?>
                                            <div class="event-detail-text">
                                                <p><?php echo nl2br(esc_html($event_location_description)); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                    </div>
                </div>
                
                <!-- Gallery Section -->
                <?php 
                $gallery_images = get_post_meta(get_the_ID(), '_event_offer_gallery', true);
                if ($gallery_images && is_array($gallery_images) && !empty($gallery_images)) : ?>
                    <div class="single-event-offer-gallery-section">
                        <div class="single-event-offer-container">
                            <h2 class="gallery-title">Gallery</h2>
                            
                            <div class="gallery-carousel" id="galleryCarousel">
                                <div class="gallery-carousel-track" id="galleryCarouselTrack">
                                    <?php foreach ($gallery_images as $image_id) : 
                                        $image_url = wp_get_attachment_image_url($image_id, 'large');
                                        $image_full_url = wp_get_attachment_image_url($image_id, 'full');
                                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                                        if ($image_url) : ?>
                                            <div class="gallery-item">
                                                <img src="<?php echo esc_url($image_url); ?>" 
                                                    data-full="<?php echo esc_url($image_full_url); ?>"
                                                    alt="<?php echo esc_attr($image_alt ? $image_alt : get_the_title()); ?>" 
                                                    class="gallery-image"
                                                    onclick="openGalleryModal(this)">
                                            </div>
                                        <?php endif; 
                                    endforeach; ?>
                                </div>
                            </div>
                            <!-- Fullscreen Modal -->
                            <div id="galleryModal" class="gallery-modal" onclick="closeGalleryModal()">
                                <span class="gallery-modal-close" onclick="closeGalleryModal()">&times;</span>
                                <img class="gallery-modal-content" id="galleryModalImage" onclick="event.stopPropagation()">
                                <div class="gallery-modal-nav">
                                    <button class="gallery-modal-prev" onclick="prevModalImage(event)">&lsaquo;</button>
                                    <button class="gallery-modal-next" onclick="nextModalImage(event)">&rsaquo;</button>
                                </div>
                            </div>
                            
                            <!-- Gallery Navigation -->
                            <?php if (count($gallery_images) > 3) : ?>
                                <div class="gallery-navigation">
                                    <div class="gallery-line"></div>
                                    <div class="gallery-nav-buttons">
                                        <button class="gallery-nav-btn prev" id="galleryPrevBtn" aria-label="Previous gallery images">
                                            <svg class="nav-arrow" width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="#A48456"/>
                                                <path d="M26.5 18.7917H11.9167M11.9167 18.7917L19.2083 11.5M11.9167 18.7917L19.2083 26.0833" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                        <button class="gallery-nav-btn next" id="galleryNextBtn" aria-label="Next gallery images">
                                            <svg class="nav-arrow" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.5" y="0.5" width="39" height="39" rx="19.5" stroke="#A48456"/>
                                                <path d="M12.5 19.7917H27.0833M27.0833 19.7917L19.7917 12.5M27.0833 19.7917L19.7917 27.0833" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Navigation -->
                <div class="single-event-offer-navigation">
                    <div class="single-event-offer-container">
                        <div class="back-to-archive">
                            <a href="<?php echo get_post_type_archive_link('event_offer'); ?>" class="back-to-archive-link">
                                Back to All Events & Offers
                            </a>
                        </div>
                    </div>
                </div>
                
            </article>
            
        <?php endwhile; ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>