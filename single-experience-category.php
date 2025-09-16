<?php
/**
 * Template for displaying category-type experiences (shows child experiences)
 * This template is used when viewing experiences marked as "category" type
 */

get_header(); 

// Get the template type for this category
$category_template = get_post_meta(get_the_ID(), '_category_template', true);
// Default to 'listing' if not set
if (empty($category_template)) {
    $category_template = 'listing';
}
?>

<!-- Breadcrumbs -->
<?php get_template_part('template-parts/breadcrumbs'); ?>

<?php if ($category_template === 'detailed') : ?>
    <!-- DETAILED TEMPLATE - Magazine Style Layout -->
    <?php get_template_part('template-parts/experience-category-detailed'); ?>
    
<?php else : ?>
    <!-- LISTING TEMPLATE - Simple Grid Layout -->
    <main class="experiences-archive-main">
        <div class="experiences-archive-container">
            
            <!-- Header Section -->
            <div class="experiences-archive-header">
                <h1 class="experiences-archive-title"><?php echo strtoupper(get_the_title()); ?></h1>
                <?php if (has_excerpt()) : ?>
                    <p class="experiences-archive-subtitle"><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php elseif (get_the_content()) : ?>
                    <p class="experiences-archive-subtitle"><?php echo esc_html(wp_trim_words(get_the_content(), 20, '...')); ?></p>
                <?php endif; ?>
            </div>

            <!-- Child Experiences Grid -->
            <?php 
            // Get child experiences for this parent
            $child_experiences = new WP_Query(array(
                'post_type' => 'experience',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'post_parent' => get_the_ID(),
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            
            if ($child_experiences->have_posts()) : ?>
                <div class="experiences-archive-grid">
                    <?php while ($child_experiences->have_posts()) : $child_experiences->the_post(); ?>
                        
                        <article class="experience-archive-card">
                            <a href="<?php the_permalink(); ?>" class="experience-archive-link">
                                
                                <!-- Card Image -->
                                <div class="experience-archive-image">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('large', array('class' => 'experience-archive-img')); ?>
                                    <?php else : ?>
                                        <div class="experience-archive-placeholder">
                                            <span>No Image Available</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Card Content -->
                                <div class="experience-archive-content">
                                    
                                    <!-- Title -->
                                    <h2 class="experience-archive-card-title"><?php the_title(); ?></h2>
                                    
                                    <!-- Description -->
                                    <div class="experience-archive-description">
                                        <?php 
                                        $short_description = get_post_meta(get_the_ID(), '_experience_short_description', true);
                                        if ($short_description) : ?>
                                            <p><?php echo esc_html($short_description); ?></p>
                                        <?php elseif (has_excerpt()) : ?>
                                            <p><?php echo esc_html(get_the_excerpt()); ?></p>
                                        <?php else : ?>
                                            <p><?php echo esc_html(wp_trim_words(get_the_content(), 25, '...')); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- CTA Link -->
                                    <div class="experience-archive-cta">
                                        <span class="experience-archive-link-text">Discover More</span>
                                    </div>
                                    
                                </div>
                                
                            </a>
                        </article>
                        
                    <?php endwhile; ?>
                </div>
                
                <?php wp_reset_postdata(); ?>
                
            <?php else : ?>
                <div class="no-experiences-found">
                    <p>No experiences found in this category.</p>
                    <a href="<?php echo get_post_type_archive_link('experience'); ?>" class="back-to-experiences">← Back to All Experiences</a>
                </div>
            <?php endif; ?>
            
        </div>
    </main>
<?php endif; ?>

<?php get_footer(); ?>