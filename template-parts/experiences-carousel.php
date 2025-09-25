<?php
/**
 * Template part for displaying the experiences carousel section
 */

$featured_experiences = get_featured_experiences();
?>

<section class="experiences-section">
    <div class="experiences-container">
        <!-- Section Header -->
        <div class="experiences-header">
            <?php 
            $experiences_subtitle = get_theme_mod('nirup_experiences_subtitle', '');
            $experiences_title = get_theme_mod('nirup_experiences_title', '');
            ?>
            
            <?php if (!empty($experiences_subtitle)) : ?>
                <div class="experiences-subtitle"><?php echo esc_html($experiences_subtitle); ?></div>
            <?php endif; ?>
            
            <div class="experiences-subtitle-row">
                <?php if (!empty($experiences_title)) : ?>
                    <h2 class="experiences-title"><?php echo esc_html($experiences_title); ?></h2>
                <?php endif; ?>
                
                <!-- See All Button -->
                <div class="experiences-see-all">
                    <a href="<?php echo esc_url(get_post_type_archive_link('experience')); ?>" class="experiences-see-all-link">
                        <span>See All Experiences</span>
                        <svg class="see-all-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M1 7H13M13 7L7 1M13 7L7 13" stroke="#A48456" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Carousel -->
        <div class="experiences-carousel" id="experiencesCarousel">
            <div class="experiences-carousel-track" id="carouselTrack">
                <?php
                if ($featured_experiences->have_posts()) :
                    while ($featured_experiences->have_posts()) : $featured_experiences->the_post();
                        get_template_part('template-parts/experience-card');
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Fallback message when no experiences are found
                    echo '<div class="no-experiences-message">';
                    echo '<p style="text-align: center; color: #888; padding: 40px;">No featured experiences found. Please add some experiences and mark them as featured in the admin.</p>';
                    echo '</div>';
                endif;
                ?>
            </div>
        </div>
        
        <!-- Navigation -->
        <?php if ($featured_experiences->found_posts > 0) : ?>
        <div class="carousel-navigation">
            <div class="carousel-line"></div>
            <div class="carousel-nav-buttons">
                <button class="carousel-nav-btn prev" id="prevBtn" aria-label="Previous experiences">
                <svg class="nav-arrow" width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="    
                #A48456"/><path d="M26.5 18.7917H11.9167M11.9167 18.7917L19.2083 11.5M11.9167 18.7917L19.2083 26.0833" stroke="
                #A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <button class="carousel-nav-btn next" id="nextBtn" aria-label="Next experiences">
                    <svg class="nav-arrow" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0.5" y="0.5" width="39" height="39" rx="19.5" stroke="#A48456"/>
                    <path d="M12.5 19.7917H27.0833M27.0833 19.7917L19.7917 12.5M27.0833 19.7917L19.7917 27.0833" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="carousel-line"></div>
        </div>
        <?php endif; ?>
    </div>
</section>
