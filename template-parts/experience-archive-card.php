<?php
/**
 * Template part for displaying experience cards in the archive grid
 */

$experience_type = get_post_meta(get_the_ID(), '_experience_type', true);
$short_description = get_post_meta(get_the_ID(), '_experience_short_description', true);

// Determine the link based on experience type
if ($experience_type === 'category') {
    // Link to archive page showing sub-experiences
    $experience_link = get_post_type_archive_link('experience') . '?parent=' . get_the_ID();
} else {
    // Link directly to the experience page
    $experience_link = get_permalink();
}

// Get additional meta fields for the archive display
$operating_hours = get_post_meta(get_the_ID(), '_operating_hours', true);
$additional_info = get_post_meta(get_the_ID(), '_additional_info', true);
?>

<article class="archive-experience-card">
    <a href="<?php echo esc_url($experience_link); ?>" class="archive-card-link">
        
        <!-- Card Image -->
        <div class="archive-card-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('experience-featured', array(
                    'class' => 'archive-card-img',
                    'alt' => get_the_title() . ' - ' . get_bloginfo('name')
                )); ?>
            <?php else : ?>
                <div class="archive-card-placeholder">
                    <span>No Image Available</span>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Card Content -->
        <div class="archive-card-content">
            
            <!-- Title -->
            <h2 class="archive-card-title"><?php the_title(); ?></h2>
            
            <!-- Description -->
            <div class="archive-card-description">
                <?php if ($short_description) : ?>
                    <p><?php echo esc_html($short_description); ?></p>
                <?php elseif (has_excerpt()) : ?>
                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php else : ?>
                    <p><?php echo esc_html(wp_trim_words(get_the_content(), 25, '...')); ?></p>
                <?php endif; ?>
            </div>
            
            <!-- Operating Hours / Additional Info -->
            <?php if ($operating_hours || $additional_info) : ?>
                <div class="archive-card-info">
                    <?php if ($operating_hours) : ?>
                        <p class="archive-card-hours"><?php echo esc_html($operating_hours); ?></p>
                    <?php endif; ?>
                    <?php if ($additional_info) : ?>
                        <p class="archive-card-additional"><?php echo esc_html($additional_info); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <!-- CTA Link -->
            <div class="archive-card-cta">
                <span class="archive-cta-text">Discover More</span>
            </div>
            
        </div>
        
    </a>
</article>