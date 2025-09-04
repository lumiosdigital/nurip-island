<?php
/**
 * The template for displaying the front page/homepage
 * 
 * This is the template that displays the homepage when WordPress is configured
 * to show a static page on the front page.
 *
 * @package Nirup_Island
 */

get_header(); ?>

<main id="primary" class="site-main" role="main">
    
    <?php
    /**
     * Hero Section
     * The main hero banner with background image, text, and video
     */
    get_template_part('template-parts/hero-section');
    ?>
    
    <?php
    /**
     * Future homepage sections will go here
     * Examples:
     * - Features/Amenities section
     * - Accommodation preview
     * - Dining section
     * - Contact/Location section
     * - Newsletter signup
     */
    
    // get_template_part('template-parts/features-section');
    // get_template_part('template-parts/accommodations-preview');
    // get_template_part('template-parts/dining-preview');
    // get_template_part('template-parts/contact-section');
    ?>
    
    <?php
    /**
     * Optional: Display page content if this page has content in the editor
     * This allows you to add additional content through the WordPress editor
     * while still maintaining the custom sections above
     */
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            
            // Only display content if it's not empty
            $content = get_the_content();
            if (!empty(trim($content))) :
    ?>
                <section class="homepage-content">
                    <div class="container">
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </section>
    <?php
            endif;
        endwhile;
    endif;
    ?>

</main>

<?php get_footer(); ?>