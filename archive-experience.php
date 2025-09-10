<?php get_header(); ?>
<?php get_template_part('template-parts/breadcrumbs'); ?>
<main class="experiences-archive-main">
    <div class="experiences-archive-container">
        
        <!-- Header Section -->
        <div class="experiences-archive-header">
            <h1 class="experiences-archive-title">Island Experiences</h1>
            <p class="experiences-archive-subtitle">Discover curated experiences that make every moment unforgettable — from family fun to wellness escapes</p>
        </div>

        <!-- Experiences Grid -->
        <?php if (have_posts()) : ?>
            <div class="experiences-archive-grid">
                <?php while (have_posts()) : the_post(); ?>
                    
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
        <?php else : ?>
            <div class="no-experiences-found">
                <p>No experiences found.</p>
            </div>
        <?php endif; ?>
        
    </div>
</main>

<?php get_footer(); ?>