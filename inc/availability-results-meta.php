<?php
/**
 * Availability Results Page Meta Box
 *
 * Adds a custom field for configuring which calendar IDs to search
 * on the Availability Results page.
 *
 * @package Nirup_Island
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add meta box to Availability Results page
 */
function nirup_add_availability_results_meta_box() {
    // Get all pages with the "Availability Results" template
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-availability-results.php'
    ));

    // Only add meta box if this page exists and we're editing it
    if (!empty($pages)) {
        $page_ids = wp_list_pluck($pages, 'ID');
        global $post;

        if (isset($post->ID) && in_array($post->ID, $page_ids)) {
            add_meta_box(
                'availability_search_settings',
                'Availability Search Settings',
                'nirup_availability_results_meta_box_callback',
                'page',
                'side',
                'default'
            );
        }
    }
}
add_action('add_meta_boxes', 'nirup_add_availability_results_meta_box');

/**
 * Meta box callback - renders the input field
 */
function nirup_availability_results_meta_box_callback($post) {
    // Add nonce for security
    wp_nonce_field('nirup_save_search_calendar_ids', 'nirup_search_calendar_ids_nonce');

    // Get current value
    $calendar_ids = get_post_meta($post->ID, 'search_calendar_ids', true);

    // Default value
    if (empty($calendar_ids)) {
        $calendar_ids = '1,4,5,6';
    }

    ?>
    <p>
        <label for="search_calendar_ids" style="display: block; margin-bottom: 8px; font-weight: 600;">
            Calendar IDs to Search
        </label>
        <input
            type="text"
            id="search_calendar_ids"
            name="search_calendar_ids"
            value="<?php echo esc_attr($calendar_ids); ?>"
            class="widefat"
            placeholder="1,4,5,6"
            style="width: 100%;"
        />
    </p>
    <p class="description" style="margin-top: 8px; font-size: 12px; line-height: 1.5;">
        Enter comma-separated calendar IDs to include in the availability search.<br>
        <strong>Example:</strong> 1,4,5,6<br>
        <em>Default: 1,4,5,6</em>
    </p>
    <?php
}

/**
 * Save meta box data
 */
function nirup_save_availability_results_meta($post_id) {
    // Check nonce
    if (!isset($_POST['nirup_search_calendar_ids_nonce']) ||
        !wp_verify_nonce($_POST['nirup_search_calendar_ids_nonce'], 'nirup_save_search_calendar_ids')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check if this is the right page template
    $template = get_post_meta($post_id, '_wp_page_template', true);
    if ($template !== 'page-availability-results.php') {
        return;
    }

    // Save or delete the meta
    if (isset($_POST['search_calendar_ids'])) {
        $calendar_ids = sanitize_text_field($_POST['search_calendar_ids']);

        // Validate format (comma-separated numbers)
        if (preg_match('/^[0-9,\s]+$/', $calendar_ids)) {
            // Clean up the string (remove extra spaces)
            $calendar_ids = preg_replace('/\s+/', '', $calendar_ids);
            update_post_meta($post_id, 'search_calendar_ids', $calendar_ids);
        }
    }
}
add_action('save_post', 'nirup_save_availability_results_meta');
