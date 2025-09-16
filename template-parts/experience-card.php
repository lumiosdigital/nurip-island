<?php
$experience_type = get_post_meta(get_the_ID(), '_experience_type', true);
$short_description = get_post_meta(get_the_ID(), '_experience_short_description', true);

// Always use the permalink - no more ?parent= URLs
$experience_link = get_permalink();
?>

<div class="experience-card" data-experience-id="<?php echo esc_attr(get_the_ID()); ?>">
    <a href="<?php echo esc_url($experience_link); ?>" class="experience-card-link">
    <div class="experience-image-container">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('full', array(
                'class' => 'experience-image',
                'alt' => get_the_title() . ' - ' . get_bloginfo('name')
            )); ?>
        <?php else : ?>
            <!-- Placeholder image if no featured image is set -->
            <div class="experience-image-placeholder" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); display: flex; align-items: center; justify-content: center; color: #888; font-size: 14px;">
                No Image Available
            </div>
        <?php endif; ?>
    </div>
    
    <div class="experience-content">
        <h3 class="experience-title"><?php the_title(); ?></h3>
        
        <?php if ($short_description) : ?>
            <p class="experience-description"><?php echo esc_html($short_description); ?></p>
        <?php elseif (has_excerpt()) : ?>
            <p class="experience-description"><?php echo esc_html(get_the_excerpt()); ?></p>
        <?php else : ?>
            <p class="experience-description"><?php echo esc_html(wp_trim_words(get_the_content(), 15, '...')); ?></p>
        <?php endif; ?>
        
        <span class="experience-link">
            Discover More
        </span>
    </div>
    </a>
</div>