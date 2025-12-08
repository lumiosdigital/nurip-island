<?php
/**
 * Template Part: Check Availability Modal
 * File: template-parts/check-availability-modal.php
 *
 * Modal for checking availability across all villas using WP Booking System Search
 */
?>

<!-- Check Availability Modal -->
<div id="check-availability-modal" class="check-availability-modal" aria-hidden="true" role="dialog">
    <div class="check-availability-backdrop"></div>

    <div class="check-availability-container" role="document">
        <!-- Close Button -->
        <button class="check-availability-close" aria-label="Close availability search">
            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 8 8" fill="none">
                <path d="M1 1L7 7M7 1L1 7" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" />
            </svg>
        </button>

        <div class="check-availability-content">
            <?php
            // Make sure shortcode exists
            if ( shortcode_exists( 'wpbs-search' ) ) {

                /**
                 * Collect all villa calendar IDs
                 * (assumes each Villa post has meta 'villa_calendar_id')
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

                /**
                 * URL of the results page
                 * Create a normal WP page with slug "availability-results"
                 * and place another [wpbs-search] widget there (with redirect left empty).
                 * You can change this slug if you want.
                 */
                $results_page_url = esc_url( home_url( '/availability-results/' ) );

                /**
                 * Build the shortcode
                 * Attribute names taken from plugin examples. :contentReference[oaicite:1]{index=1}
                 * - redirect="" makes the search send users to the results page
                 *   instead of showing results below the widget.
                 */
                $shortcode = sprintf(
                    '[wpbs-search calendars="%1$s" language="auto" start_day="1" title="no" mark_selection="yes" selection_type="date_range" minimum_stay="0" featured_image="yes" starting_price="yes" results_layout="grid" results_per_page="9" show_results_on_load="no" redirect="%2$s"]',
                    esc_attr( $calendar_ids_string ),
                    $results_page_url
                );

                echo do_shortcode( $shortcode );

            } else {

                // Helpful note for admins if the add-on isn't active
                if ( current_user_can( 'manage_options' ) ) {
                    echo '<p><strong>WP Booking System Search Widget</strong> add-on is not active. Please install/activate it to use the availability search.</p>';
                }

            }
            ?>
        </div>
    </div>
</div>
