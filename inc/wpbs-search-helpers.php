<?php
/**
 * Helper functions for styling WP Booking System search results
 * for the Availability Results page.
 *
 * - Uses the Search Add-on filter `wpbs_search_results_html`
 *   to output custom card markup that matches the Nirup design.
 * - Maps calendars to Villa posts via the `villa_calendar_id` meta.
 * - Uses the Villa featured image and `villa_base_price` meta
 *   for the "Starting from" price text.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Get Villa ID associated with a WPBS calendar ID.
 *
 * @param int $calendar_id
 * @return int Villa post ID or 0.
 */
function nirup_get_villa_id_for_calendar( $calendar_id ) {
    static $cache = array();

    $calendar_id = absint( $calendar_id );
    if ( ! $calendar_id ) {
        return 0;
    }

    if ( isset( $cache[ $calendar_id ] ) ) {
        return $cache[ $calendar_id ];
    }

    $villa_query = new WP_Query(
        array(
            'post_type'      => 'villa',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'meta_query'     => array(
                array(
                    'key'   => 'villa_calendar_id',
                    'value' => $calendar_id,
                ),
            ),
        )
    );

    $villa_id = 0;

    if ( $villa_query->have_posts() ) {
        $villa_id = (int) $villa_query->posts[0];
    }

    $cache[ $calendar_id ] = $villa_id;

    wp_reset_postdata();

    return $villa_id;
}

/**
 * Optional: Ensure WPBS uses the Villa featured image for calendars
 * (for any other WPBS output that relies on this filter).
 *
 * @param string $image_url
 * @param int    $calendar_id
 *
 * @return string
 */
function nirup_use_villa_featured_image( $image_url, $calendar_id ) {
    $villa_id = nirup_get_villa_id_for_calendar( $calendar_id );

    if ( $villa_id ) {
        $featured_url = get_the_post_thumbnail_url( $villa_id, 'master' );
        if ( $featured_url ) {
            return $featured_url;
        }
    }

    return $image_url;
}
add_filter( 'wpbs_calendar_featured_image', 'nirup_use_villa_featured_image', 10, 2 );


function nirup_get_villa_starting_price_text( $calendar_id, $data = array(), $original_html = '' ) {
    $calendar_id = absint( $calendar_id );
    $villa_id    = $calendar_id ? nirup_get_villa_id_for_calendar( $calendar_id ) : 0;

    // 1) WPBS price array → already in current currency.
    if ( ! empty( $data['price'] ) && is_array( $data['price'] ) ) {

        if ( ! empty( $data['price']['formatted_price_per_night'] ) ) {
            $formatted = wp_strip_all_tags( $data['price']['formatted_price_per_night'] );

            return sprintf(
                __( 'Starting from %s per night.', 'nirup' ),
                $formatted
            );
        }

        if ( ! empty( $data['price']['price_per_night'] ) ) {
            $price_number = (float) $data['price']['price_per_night'];

            return sprintf(
                __( 'Starting from %s per night.', 'nirup' ),
                number_format_i18n( $price_number, 2 )
            );
        }
    }

    // 2) Fallback: parse the original WPBS HTML (trim off "View" etc).
    if ( ! empty( $original_html ) ) {
        $plain = wp_strip_all_tags( $original_html );
        $pos   = strpos( $plain, 'Starting from' );

        if ( false !== $pos ) {
            // Try to cut at " per day" / " per night"
            $end_markers = array(
                ' per day.',
                ' per day',
                ' per night.',
                ' per night',
            );

            $end_pos = false;

            foreach ( $end_markers as $marker ) {
                $marker_pos = strpos( $plain, $marker, $pos );
                if ( false !== $marker_pos ) {
                    $candidate_end = $marker_pos + strlen( $marker );
                    if ( false === $end_pos || $candidate_end < $end_pos ) {
                        $end_pos = $candidate_end;
                    }
                }
            }

            if ( false !== $end_pos ) {
                $fragment = substr( $plain, $pos, $end_pos - $pos );
                return trim( $fragment );
            }

            // If markers fail, just take up to the next period.
            $fragment    = substr( $plain, $pos );
            $period_pos  = strpos( $fragment, '.' );
            if ( false !== $period_pos ) {
                $fragment = substr( $fragment, 0, $period_pos + 1 );
            }

            return trim( $fragment );
        }
    }

    // 3) Final fallback: villa_base_price meta (assumed USD).
    if ( $villa_id ) {
        $base_price = get_post_meta( $villa_id, 'villa_base_price', true );

        if ( '' !== $base_price && null !== $base_price ) {
            $price_number = (float) $base_price;

            return sprintf(
                __( 'Starting from $%s USD per night.', 'nirup' ),
                number_format_i18n( $price_number, 2 )
            );
        }
    }

    return '';
}


/**
 * Override WPBS search result HTML with our custom card layout.
 *
 * @param string $output Default HTML from the plugin.
 * @param array  $data   Result data.
 *
 * @return string
 */
function nirup_wpbs_search_result_card_html( $output, $data ) {

    // Basic data with fallbacks.
    $calendar_name = isset( $data['calendar_name'] ) ? $data['calendar_name'] : '';
    $link          = ! empty( $data['link'] ) ? $data['link'] : '#';
    $calendar_id   = isset( $data['calendar_id'] ) ? (int) $data['calendar_id'] : 0;
    $post_id       = isset( $data['post_id'] ) ? (int) $data['post_id'] : 0;

    // Determine a Villa ID (either via calendar mapping or linked post).
    $villa_id = $calendar_id ? nirup_get_villa_id_for_calendar( $calendar_id ) : 0;
    if ( ! $villa_id && $post_id ) {
        $villa_id = $post_id;
    }

    // Build image HTML (prefer the Villa featured image).
    $image_html = '';
    if ( $villa_id ) {
        $image_html = get_the_post_thumbnail(
            $villa_id,
            'large',
            array(
                'class'   => 'attachment-large size-large wp-post-image',
                'loading' => 'lazy',
            )
        );
    }

    // If we still don't have an image and no name, keep default output.
    if ( empty( $image_html ) && empty( $calendar_name ) ) {
        return $output;
    }

    // Starting price text (meta → WPBS → parse original HTML).
    $price_text = nirup_get_villa_starting_price_text( $calendar_id, $data, $output );

    // Build card HTML: only the button has a link.
    ob_start();
    ?>
    <div class="wpbs_s-search-widget-result wpbs_s-has-thumb">
        <?php if ( ! empty( $image_html ) ) : ?>
            <div class="wpbs_s-search-widget-result-image">
                <?php echo $image_html; ?>
            </div>
        <?php endif; ?>

        <div class="wpbs_s-search-widget-result-content">
            <div class="wpbs_s-search-widget-result-title">
                <?php if ( $calendar_name ) : ?>
                    <h3 class="wpbs_s-search-widget-result-heading">
                        <?php echo esc_html( $calendar_name ); ?>
                    </h3>
                <?php endif; ?>
            </div>

            <div class="wpbs_s-search-widget-result-buttons">
                <a class="wpbs_s-search-widget-result-link"
                   href="<?php echo esc_url( $link ); ?>"
                   title="<?php echo esc_attr( $calendar_name ); ?>">
                    <?php esc_html_e( 'Discover More', 'nirup' ); ?>
                </a>
            </div>

            <?php if ( $price_text ) : ?>
                <div class="wpbs_s-search-widget-result-price">
                    <span><?php echo esc_html( $price_text ); ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php

    return ob_get_clean();
}
add_filter( 'wpbs_search_results_html', 'nirup_wpbs_search_result_card_html', 10, 2 );
add_filter( 'wpbs_search_resuts_html', 'nirup_wpbs_search_result_card_html', 10, 2 );

