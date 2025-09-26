<?php
/**
 * Template Name: Terms & Conditions
 * 
 * @package Nirup_Island
 */

get_header(); ?>

<div class="legal-page-wrapper">
    <!-- Breadcrumbs using existing template part -->
    <?php get_template_part('template-parts/breadcrumbs'); ?>

    <!-- Page Header -->
    <div class="legal-page-header">
        <div class="container">
            <h1 class="legal-page-title">Terms & Conditions</h1>
        </div>
    </div>

    <!-- Page Content -->
    <div class="legal-page-content">
        <div class="container">
            <div class="legal-content-wrapper">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <div class="legal-content-body">
                        <?php the_content(); ?>
                    </div>
                    <?php
                endwhile;
                ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>