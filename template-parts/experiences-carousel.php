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
            <div class="experiences-subtitle">Experiences</div>
            <h2 class="experiences-title">Live the Island Lifestyle</h2>
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
                    <svg class="nav-arrow" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.33333 5L13.3333 10L8.33333 15" stroke="#a48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button class="carousel-nav-btn next" id="nextBtn" aria-label="Next experiences">
                    <svg class="nav-arrow" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.33333 5L13.3333 10L8.33333 15" stroke="#a48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="carousel-line"></div>
        </div>
        <?php endif; ?>
    </div>
</section>
