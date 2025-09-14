<?php

get_header(); ?>

<main id="primary" class="site-main" role="main">
    
    <?php get_template_part('template-parts/hero-section'); ?>

    <?php get_template_part('template-parts/video-section'); ?>

    <?php get_template_part('template-parts/about-island-section'); ?>

     <?php get_template_part('template-parts/accommodations-section'); ?>

    <?php get_template_part('template-parts/experiences-carousel'); ?>

     <?php
    if (nirup_should_display_map_section()) {
        get_template_part('template-parts/map-section');
    }
    ?>

    <?php get_template_part('template-parts/wellness-retreat-section'); ?>

    <?php
    if (nirup_should_display_getting_here_section()) {
        get_template_part('template-parts/getting-here-section');
    }
    ?>

    <?php get_template_part('template-parts/services-section'); ?>

    <?php get_template_part('template-parts/events-offers-carousel'); ?>


</main>

<?php get_footer(); ?>