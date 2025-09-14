<?php 
/**
 * Archive template for Events and Offers
 * File: archive-event_offer.php
 */

get_header(); ?>

<!-- Breadcrumbs -->
<?php get_template_part('template-parts/breadcrumbs'); ?>

<main class="events-offers-archive-main">
    <div class="events-offers-archive-container">
        
        <!-- Header Section -->
        <div class="events-offers-archive-header">
            <h1 class="events-offers-archive-title">
                <?php echo esc_html(get_theme_mod('nirup_events_offers_archive_title', 'Events & Offers')); ?>
            </h1>
            <p class="events-offers-archive-subtitle">
                <?php echo esc_html(get_theme_mod('nirup_events_offers_archive_subtitle', 'Discover special events and exclusive offers that make your island experience even more memorable')); ?>
            </p>
        </div>

        <!-- Events & Offers Grid -->
        <?php 
        // Show only events/offers marked for archive display
        $args = array(
            'post_type' => 'event_offer',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => '_event_offer_featured_in_archive',
                    'value' => '1',
                    'compare' => '='
                )
            ),
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );
        $events_offers_query = new WP_Query($args);
        
        if ($events_offers_query->have_posts()) : ?>
            <div class="events-offers-archive-grid">
                <?php while ($events_offers_query->have_posts()) : $events_offers_query->the_post(); ?>
                    <?php get_template_part('template-parts/event-offer-archive-card'); ?>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="no-events-offers-found">
                <p><?php esc_html_e('No events or offers are currently available. Please check back later.', 'nirup-island'); ?></p>
            </div>
        <?php endif; ?>
        
    </div>
</main>

<?php get_footer(); ?>