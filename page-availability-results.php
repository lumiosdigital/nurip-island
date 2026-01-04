<?php
/**
 * Template Name: Availability Results
 * Description: Template for displaying villa availability search results
 */

get_header(); ?>

<main id="main" class="site-main availability-results-page">
    
    <?php while ( have_posts() ) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <?php
            // Breadcrumbs
            if ( function_exists( 'nirup_breadcrumbs' ) ) {
                echo '<div class="container">';
                nirup_breadcrumbs();
                echo '</div>';
            }
            ?>
            
            <div class="entry-content">
                
                <?php
                // Page Title
                if ( get_the_title() ) {
                    echo '<h1>' . get_the_title() . '</h1>';
                }
                ?>
                
                <?php
                // WPBS Search Widget
                // This outputs the search form and handles the results display
                if ( shortcode_exists( 'wpbs-search' ) ) {

                    /**
                     * Get calendar IDs from custom field
                     * Default to calendars: 1, 4, 5, and 6 if not set
                     */
                    $calendar_ids_string = get_post_meta( get_the_ID(), 'search_calendar_ids', true );

                    // Default calendar IDs if custom field is empty
                    if ( empty( $calendar_ids_string ) ) {
                        $calendar_ids_string = '1,4,5,6';
                    }

                    $shortcode = sprintf(
                        '[wpbs-search calendars="%1$s" language="auto" start_day="1" title="no" mark_selection="yes" selection_type="date_range" minimum_stay="0" featured_image="yes" starting_price="yes" results_layout="grid" results_per_page="9" show_results_on_load="no"]',
                        esc_attr( $calendar_ids_string )
                    );
                    
                    echo do_shortcode( $shortcode );
                    
                } else {
                    
                    // Error message if plugin not active
                    if ( current_user_can( 'manage_options' ) ) {
                        echo '<div class="notice notice-warning">';
                        echo '<p><strong>WP Booking System Search Widget</strong> add-on is not active. Please install/activate it to display availability search results.</p>';
                        echo '</div>';
                    }
                    
                }
                ?>
                
            </div>
            
        </article>
        
    <?php endwhile; ?>
    
</main>

<?php get_footer(); ?>