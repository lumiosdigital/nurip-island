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
     * Video Section
     * YouTube video embed section
     */
    get_template_part('template-parts/video-section');
    ?>

</main>

<?php get_footer(); ?>