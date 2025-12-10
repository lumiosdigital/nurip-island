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
                     * Collect all villa calendar IDs
                     */
                    $villa_calendar_ids = array();
                    
                    $villas_query = new WP_Query( array(
                        'post_type'      => 'villa',
                        'post_status'    => 'publish',
                        'posts_per_page' => -1,
                        'no_found_rows'  => true,
                        'fields'         => 'ids',
                    ) );
                    
                    if ( $villas_query->have_posts() ) {
                        foreach ( $villas_query->posts as $villa_id ) {
                            $calendar_id = get_post_meta( $villa_id, 'villa_calendar_id', true );
                            if ( ! empty( $calendar_id ) ) {
                                $villa_calendar_ids[] = absint( $calendar_id );
                            }
                        }
                    }
                    
                    wp_reset_postdata();
                    
                    // De-duplicate and build calendars string
                    $villa_calendar_ids = array_unique( array_filter( $villa_calendar_ids ) );
                    $calendar_ids_string = ! empty( $villa_calendar_ids )
                        ? implode( ',', $villa_calendar_ids )
                        : 'all';
                    

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