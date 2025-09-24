<?php
/**
 * Template part for displaying restaurant cards in the archive grid
 * File: template-parts/restaurant-archive-card.php
 */

$restaurant_category = get_post_meta(get_the_ID(), '_restaurant_card_category', true);
$short_description = get_post_meta(get_the_ID(), '_restaurant_card_short_description', true);
$operating_hours = get_post_meta(get_the_ID(), '_restaurant_card_operating_hours', true);

// Link directly to the restaurant page
$restaurant_link = get_permalink();
?>

<article class="restaurant-archive-card">
    <a href="<?php echo esc_url($restaurant_link); ?>" class="restaurant-archive-link">
        
        <!-- Card Image -->
        <div class="restaurant-archive-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array(
                    'class' => 'restaurant-archive-img',
                    'alt' => get_the_title() . ' - ' . get_bloginfo('name')
                )); ?>
            <?php else : ?>
                <div class="restaurant-archive-placeholder">
                    <span>No Image Available</span>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Card Content -->
        <div class="restaurant-archive-content">
            <!-- Category -->
            <?php if ($restaurant_category) : ?>
                <div class="restaurant-archive-info">
                    <p class="restaurant-archive-category"><?php echo esc_html($restaurant_category); ?></p>
                </div>
            <?php endif; ?>
            
            <!-- Title -->
            <h2 class="restaurant-archive-card-title"><?php the_title(); ?></h2>
            
            <!-- Description -->
            <div class="restaurant-archive-description">
                <?php if ($short_description) : ?>
                    <p><?php echo esc_html($short_description); ?></p>
                <?php elseif (has_excerpt()) : ?>
                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php else : ?>
                    <p><?php echo esc_html(wp_trim_words(get_the_content(), 25, '...')); ?></p>
                <?php endif; ?>
            </div>
            

            
            <!-- Operating Hours -->
            <?php if ($operating_hours) : ?>
                <div class="restaurant-archive-info">
                    <p class="restaurant-archive-hours"><?php echo esc_html($operating_hours); ?></p>
                </div>
            <?php endif; ?>
            
            <!-- CTA Link -->
            <div class="restaurant-archive-cta">
                <span class="restaurant-archive-link-text">Discover More</span>
            </div>
            
        </div>
        
    </a>
</article>