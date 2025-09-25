<?php get_header(); ?>
<?php
// Handle old ?parent= URLs as fallback
if (isset($_GET['parent']) && !empty($_GET['parent'])) {
    $parent_id = intval($_GET['parent']);
    $parent_post = get_post($parent_id);
    if ($parent_post) {
        // Redirect to proper URL structure
        wp_redirect(get_permalink($parent_post), 301);
        exit;
    }
}
?>
<!-- Breadcrumbs -->
<?php get_template_part('template-parts/breadcrumbs'); ?>

<main class="experiences-archive-main">
    <div class="experiences-archive-container">
        
        <!-- Header Section -->
        <div class="experiences-archive-header">
            <h1 class="experiences-archive-title">
                <?php echo esc_html(get_theme_mod('nirup_experiences_archive_title', 'Island Experiences')); ?>
            </h1>
            <p class="experiences-archive-subtitle">
                <?php echo esc_html(get_theme_mod('nirup_experiences_archive_subtitle', 'Discover curated experiences that make every moment unforgettable — from family fun to wellness escapes')); ?>
            </p>
        </div>

        <!-- Experiences Grid -->
        <?php 
        // Show only experiences marked for archive display
        $args = array(
            'post_type' => 'experience',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => '_featured_in_archive',
                    'value' => '1',
                    'compare' => '='
                )
            ),
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );
        $experiences_query = new WP_Query($args);
        
        if ($experiences_query->have_posts()) : ?>
            <div class="experiences-archive-grid">
                <?php while ($experiences_query->have_posts()) : $experiences_query->the_post(); ?>
                    
                    <article class="experience-archive-card">
                        <?php 
                        $experience_type = get_post_meta(get_the_ID(), '_experience_type', true);
                        $experience_link = get_permalink();
                        ?>
                        <a href="<?php echo esc_url($experience_link); ?>" class="experience-archive-link">
                            
                            <!-- Card Image -->
                            <div class="experience-archive-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('master', array('class' => 'experience-archive-img')); ?>
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
                <p>No experiences found.</p>
            </div>
        <?php endif; ?>
        
    </div>
</main>

<?php get_footer(); ?>