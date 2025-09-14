<?php
/**
 * Template part for displaying individual event/offer cards in the carousel
 */

$short_description = get_post_meta(get_the_ID(), '_event_offer_short_description', true);
$event_offer_link = get_permalink();
?>

<div class="event-offer-card">
    <div class="event-offer-image-container">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('full', array(
                'class' => 'event-offer-image',
                'alt' => get_the_title() . ' - ' . get_bloginfo('name')
            )); ?>
        <?php else : ?>
            <div class="event-offer-image-placeholder">
                <span>No Image Available</span>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="event-offer-content">
        <h3 class="event-offer-title"><?php the_title(); ?></h3>
        
        <?php if ($short_description) : ?>
            <p class="event-offer-description"><?php echo esc_html($short_description); ?></p>
        <?php elseif (has_excerpt()) : ?>
            <p class="event-offer-description"><?php echo esc_html(get_the_excerpt()); ?></p>
        <?php else : ?>
            <p class="event-offer-description"><?php echo esc_html(wp_trim_words(get_the_content(), 15, '...')); ?></p>
        <?php endif; ?>
        
        <a href="<?php echo esc_url($event_offer_link); ?>" class="event-offer-link">
            View Details
        </a>
    </div>
</div>