<?php
/**
 * Template Name: Visa Free Countries
 *
 * @package Nirup_Island
 */

get_header(); ?>

<div class="legal-page-wrapper">
    <?php get_template_part('template-parts/breadcrumbs'); ?>

    <div class="legal-page-header">
        <div class="container">
            <h1 class="legal-page-title">Visa Free Countries</h1>
        </div>
    </div>

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