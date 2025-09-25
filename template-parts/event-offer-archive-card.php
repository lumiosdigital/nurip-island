<?php
/**
 * Template part for displaying event/offer cards in the archive grid
 * File: template-parts/event-offer-archive-card.php
 * EXACT match to experiences structure
 */

$short_description = get_post_meta(get_the_ID(), '_event_offer_short_description', true);

// Link directly to the event/offer page (all are single pages)
$event_offer_link = get_permalink();
?>

<article class="archive-event-offer-card">
    <a href="<?php echo esc_url($event_offer_link); ?>" class="archive-event-offer-link">
        
        <!-- Card Image -->
        <div class="archive-event-offer-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('master', array('class' => 'archive-event-offer-img')); ?>
            <?php else : ?>
                <div class="archive-event-offer-placeholder">
                    <span>No Image Available</span>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Card Content -->
        <div class="archive-event-offer-content">
            
            <!-- Title -->
            <h2 class="archive-event-offer-title"><?php the_title(); ?></h2>
            
            <!-- Description -->
            <div class="archive-event-offer-description">
                <?php 
                if ($short_description) : ?>
                    <p><?php echo esc_html($short_description); ?></p>
                <?php elseif (has_excerpt()) : ?>
                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php else : ?>
                    <p><?php echo esc_html(wp_trim_words(get_the_content(), 25, '...')); ?></p>
                <?php endif; ?>
            </div>
            
            <!-- CTA Link -->
            <div class="archive-event-offer-cta">
                <span class="archive-event-offer-link-text">Discover More</span>
            </div>
            
        </div>
        
    </a>
</article>