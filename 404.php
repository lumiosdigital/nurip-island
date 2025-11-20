<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Nirup_Island
 */

get_header(); ?>

<main class="error-404-page">
    <div class="error-404-container">
        <h1 class="error-404-title">404 – Page Not Found</h1>
        
        <div class="error-404-message">
            <p>
                We're sorry, the page you're looking for cannot be found.<br>
                Return to the <a href="<?php echo esc_url(home_url('/')); ?>" class="homepage-link">Homepage</a> or explore our other pages to continue your journey.
            </p>
        </div>
    </div>
</main>

<?php get_footer(); ?>