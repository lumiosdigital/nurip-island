<?php
/**
 * Template part for displaying the events and offers carousel section
 */

$featured_events_offers = get_featured_events_offers();
?>

<section class="events-offers-section">
    <div class="events-offers-container">
        <!-- Section Header -->
        <div class="events-offers-header">
            <?php 
            $events_offers_subtitle = get_theme_mod('nirup_events_offers_subtitle', '');
            $events_offers_title = get_theme_mod('nirup_events_offers_title', '');
            ?>
            
            
                <?php if (!empty($events_offers_subtitle)) : ?>
                    <div class="events-offers-subtitle"><?php echo esc_html($events_offers_subtitle); ?></div>
                <?php endif; ?>
            
            <div class="events-offers-subtitle-row">
            <?php if (!empty($events_offers_title)) : ?>
                <h2 class="events-offers-title"><?php echo esc_html($events_offers_title); ?></h2>
            <?php endif; ?>
            <!-- See All Button -->
                <div class="events-offers-see-all">
                    <a href="<?php echo esc_url(get_post_type_archive_link('event_offer')); ?>" class="events-offers-see-all-link">
                        <span>See All Events & Offers</span>
                            <svg class="see-all-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M1 7H13M13 7L7 1M13 7L7 13" stroke="#A48456" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                    </a>
                </div>
        </div>
        </div>
        
        <!-- Carousel -->
        <div class="events-offers-carousel" id="eventsOffersCarousel">
            <div class="events-offers-carousel-track" id="eventsOffersCarouselTrack">
                <?php
                if ($featured_events_offers->have_posts()) :
                    while ($featured_events_offers->have_posts()) : $featured_events_offers->the_post();
                        get_template_part('template-parts/event-offer-card');
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Fallback message when no events/offers are found
                    echo '<div class="no-events-offers-message">';
                    echo '<p style="text-align: center; color: #888; padding: 40px;">No featured events or offers found. Please add some events/offers and mark them as featured in the admin.</p>';
                    echo '</div>';
                endif;
                ?>
            </div>
        </div>
        
        <!-- Navigation -->
        <?php if ($featured_events_offers->found_posts > 0) : ?>
        <div class="events-offers-navigation">
            <div class="events-offers-line"></div>
            <div class="events-offers-nav-buttons">
                <button class="events-offers-nav-btn prev" id="eventsOffersPrevBtn" aria-label="Previous events and offers">
                    <svg class="nav-arrow" width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="#A48456"/>
                        <path d="M26.5 18.7917H11.9167M11.9167 18.7917L19.2083 11.5M11.9167 18.7917L19.2083 26.0833" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button class="events-offers-nav-btn next" id="eventsOffersNextBtn" aria-label="Next events and offers">
                    <svg class="nav-arrow" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.5" width="39" height="39" rx="19.5" stroke="#A48456"/>
                        <path d="M12.5 19.7917H27.0833M27.0833 19.7917L19.7917 12.5M27.0833 19.7917L19.7917 27.0833" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="events-offers-line"></div>
        </div>
        <?php endif; ?>
    </div>
</section>