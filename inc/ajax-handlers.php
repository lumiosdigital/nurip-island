<?php
/**
 * AJAX Handlers
 *
 * All AJAX callback functions for frontend and backend operations.
 * Organized by category: Map Pins, Forms, Media, Booking, etc.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// ========================================
// MAP PINS AJAX HANDLERS
// ========================================

/**
 * Get attachment URL via AJAX
 */
function nirup_get_attachment_url_ajax() {
    $attachment_id = intval($_POST['attachment_id']);
    $url = wp_get_attachment_image_url($attachment_id, 'medium');

    if ($url) {
        wp_send_json_success(array('url' => $url));
    } else {
        wp_send_json_error(array('message' => 'Image not found'));
    }
}
add_action('wp_ajax_get_attachment_url', 'nirup_get_attachment_url_ajax');

/**
 * Get image URL via AJAX
 */
function nirup_get_image_url() {
    $image_id = intval($_POST['image_id']);
    $size = isset($_POST['size']) ? sanitize_text_field($_POST['size']) : 'medium';

    if (!$image_id) {
        wp_send_json_error('No image ID provided');
    }

    $url = wp_get_attachment_image_url($image_id, $size);

    if ($url) {
        wp_send_json_success(array('url' => $url));
    } else {
        wp_send_json_error('Image not found');
    }
}
add_action('wp_ajax_nirup_get_image_url', 'nirup_get_image_url');
add_action('wp_ajax_nopriv_nirup_get_image_url', 'nirup_get_image_url');

/**
 * Debug function to get all pins
 */
function nirup_get_all_pins_debug() {
    $pins = get_option('nirup_map_pins', array());
    wp_send_json_success($pins);
}
add_action('wp_ajax_nirup_get_all_pins_debug', 'nirup_get_all_pins_debug');

/**
 * Add new map pin via AJAX
 */
function nirup_add_pin_ajax() {
    // Verify nonce for admin
    check_ajax_referer('nirup_map_nonce', 'nonce');

    // Add your pin addition logic here
    $data = $_POST;
    nirup_add_map_pin($data);

    // Get all pins to return
    $pins = nirup_get_map_pins();

    wp_send_json_success(array(
        'message' => 'Pin added successfully',
        'pins' => $pins
    ));
}
add_action('wp_ajax_nirup_add_pin_ajax', 'nirup_add_pin_ajax');

/**
 * Get pin preview via AJAX
 */
function nirup_get_pin_preview_ajax() {
    $pin_id = sanitize_text_field($_POST['pin_id'] ?? '');
    $pins = nirup_get_map_pins();

    foreach ($pins as $pin) {
        if ($pin['id'] === $pin_id) {
            wp_send_json_success($pin);
            return;
        }
    }

    wp_send_json_error(array('message' => 'Pin not found'));
}
add_action('wp_ajax_nirup_get_pin_preview', 'nirup_get_pin_preview_ajax');

/**
 * Update map pin position via AJAX
 */
function nirup_update_pin_position() {
    $pin_id = sanitize_text_field($_POST['pin_id'] ?? '');
    $x = floatval($_POST['x'] ?? 0);
    $y = floatval($_POST['y'] ?? 0);

    $pins = nirup_get_map_pins();

    foreach ($pins as &$pin) {
        if ($pin['id'] === $pin_id) {
            $pin['x'] = $x;
            $pin['y'] = $y;
            $pin['updated'] = current_time('mysql');
            break;
        }
    }

    update_option('nirup_map_pins', $pins);
    wp_send_json_success(array('message' => 'Position updated'));
}
add_action('wp_ajax_nirup_update_pin_position', 'nirup_update_pin_position');

/**
 * Update map pin data via AJAX
 */
function nirup_update_pin_ajax() {
    // Verify nonce for admin
    check_ajax_referer('nirup_map_nonce', 'nonce');

    $data = $_POST;
    nirup_update_map_pin($data);

    // Get all pins to return
    $pins = nirup_get_map_pins();

    wp_send_json_success(array(
        'message' => 'Pin updated successfully',
        'pins' => $pins
    ));
}
add_action('wp_ajax_nirup_update_pin_ajax', 'nirup_update_pin_ajax');

/**
 * Delete map pin via AJAX
 */
function nirup_delete_pin_ajax() {
    // Verify nonce for admin
    check_ajax_referer('nirup_map_nonce', 'nonce');

    $pin_id = sanitize_text_field($_POST['pin_id'] ?? '');
    nirup_delete_map_pin($pin_id);

    // Get all pins to return
    $pins = nirup_get_map_pins();

    wp_send_json_success(array(
        'message' => 'Pin deleted successfully',
        'pins' => $pins
    ));
}
add_action('wp_ajax_nirup_delete_pin_ajax', 'nirup_delete_pin_ajax');

/**
 * Manage feature icons via AJAX
 */
function nirup_manage_icon_ajax() {
    // Icon management logic
    $action = sanitize_text_field($_POST['icon_action'] ?? '');

    if ($action === 'get_all') {
        $icons = get_option('nirup_feature_icons', array());
        wp_send_json_success($icons);
    } elseif ($action === 'add') {
        // Add icon logic
        wp_send_json_success(array('message' => 'Icon added'));
    } elseif ($action === 'delete') {
        // Delete icon logic
        wp_send_json_success(array('message' => 'Icon deleted'));
    } else {
        wp_send_json_error(array('message' => 'Invalid action'));
    }
}
add_action('wp_ajax_nirup_manage_icon_ajax', 'nirup_manage_icon_ajax');

// ========================================
// FORM SUBMISSION AJAX HANDLERS
// ========================================

/**
 * Handle newsletter subscription
 * Integrates with Brevo (formerly Sendinblue) and local storage
 */
function nirup_handle_newsletter_subscription() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'newsletter_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed'), 403);
        return;
    }

    // Get and validate email
    $email = sanitize_email($_POST['email'] ?? '');
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'), 400);
        return;
    }

    // Get API credentials
    $brevo_api_key = nirup_get_secret('BREVO_API_KEY', 'nirup_brevo_api_key', '');
    $brevo_list_id = nirup_get_secret('BREVO_LIST_ID', 'nirup_brevo_list_id', 6);
    $recaptcha_token = sanitize_text_field($_POST['recaptcha_token'] ?? '');

    // Verify reCAPTCHA if configured
    $recaptcha_secret = nirup_get_secret('RECAPTCHA_SECRET_KEY', 'nirup_recaptcha_secret_key', '');
    if (!empty($recaptcha_secret) && !empty($recaptcha_token)) {
        $verify = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
            'body' => [
                'secret' => $recaptcha_secret,
                'response' => $recaptcha_token,
                'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
            ],
            'timeout' => 10,
        ]);

        if (is_wp_error($verify)) {
            wp_send_json_error(['message' => 'Captcha verification failed. Please try again.'], 400);
            return;
        }

        $vbody = json_decode(wp_remote_retrieve_body($verify), true);
        $score = isset($vbody['score']) ? (float) $vbody['score'] : 0;
        $ok = !empty($vbody['success']) && $score >= 0.5;

        if (!$ok) {
            wp_send_json_error(['message' => 'Captcha failed. Please try again.'], 400);
            return;
        }
    }

    // Brevo API integration
    $brevo_success = false;
    if (!empty($brevo_api_key) && !empty($brevo_list_id)) {
        $data = array(
            'email' => $email,
            'listIds' => array($brevo_list_id),
            'updateEnabled' => true,
        );

        $response = wp_remote_post('https://api.brevo.com/v3/contacts', array(
            'headers' => array(
                'api-key' => $brevo_api_key,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ),
            'body' => wp_json_encode($data),
            'timeout' => 15,
        ));

        if (!is_wp_error($response)) {
            $response_code = wp_remote_retrieve_response_code($response);
            if ($response_code === 201 || $response_code === 204) {
                $brevo_success = true;
            }
        }
    }

    // Local backup storage
    $subscribers = get_option('nirup_newsletter_subscribers', array());
    $already_subscribed = in_array($email, $subscribers, true);
    if (!$already_subscribed) {
        $subscribers[] = $email;
        update_option('nirup_newsletter_subscribers', $subscribers);
    }

    // Send response
    if ($brevo_success) {
        wp_send_json_success(array('message' => 'Thank you for subscribing to our newsletter!'));
    } elseif (!empty($brevo_api_key) && !empty($brevo_list_id)) {
        wp_send_json_error(array('message' => 'There was an issue subscribing you. Please try again later.'));
    } elseif ($already_subscribed) {
        wp_send_json_error(array('message' => 'You are already subscribed.'));
    } else {
        wp_send_json_success(array('message' => 'Thank you for subscribing!'));
    }
}
add_action('wp_ajax_nopriv_nirup_newsletter_subscribe', 'nirup_handle_newsletter_subscription');
add_action('wp_ajax_nirup_newsletter_subscribe', 'nirup_handle_newsletter_subscription');

/**
 * Handle contact form submission
 * Full implementation with reCAPTCHA verification and email notifications
 */
function nirup_contact_form_submit() {
    // Nonce verification
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'contact_form_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed.'));
        return;
    }

    // Get sanitized form data
    $form_data = isset($_POST['form_data']) ? $_POST['form_data'] : array();
    $name = sanitize_text_field($form_data['name'] ?? '');
    $email = sanitize_email($form_data['email'] ?? '');
    $phone = sanitize_text_field($form_data['phone'] ?? '');
    $inquiry_type = sanitize_text_field($form_data['inquiry_type'] ?? '');
    $message = sanitize_textarea_field($form_data['message'] ?? '');

    // Validation
    if (empty($name) || empty($email) || empty($inquiry_type) || empty($message)) {
        wp_send_json_error(array('message' => 'Please fill in all required fields.'));
        return;
    }

    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'));
        return;
    }

    // reCAPTCHA v3 verification
    $recaptcha_secret = nirup_get_secret('RECAPTCHA_SECRET', 'nirup_recaptcha_secret', '');
    $recaptcha_token = sanitize_text_field($_POST['recaptcha_token'] ?? '');

    if (!empty($recaptcha_secret) && !empty($recaptcha_token)) {
        $verify = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
            'body' => array(
                'secret' => $recaptcha_secret,
                'response' => $recaptcha_token,
                'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
            ),
            'timeout' => 10,
        ));

        if (is_wp_error($verify)) {
            wp_send_json_error(array('message' => 'Captcha verification failed. Please try again.'), 400);
            return;
        }

        $vbody = json_decode(wp_remote_retrieve_body($verify), true);
        $score = isset($vbody['score']) ? (float) $vbody['score'] : 0;

        if (empty($vbody['success']) || $score < 0.5) {
            wp_send_json_error(array('message' => 'Captcha failed. Please try again.'), 400);
            return;
        }
    }

    // Store in database FIRST
    nirup_store_contact_submission($name, $email, $phone, $inquiry_type, $message);

    // Get email settings from customizer
    $admin_email = get_theme_mod('nirup_contact_form_email', 'explore@nirupisland.com');
    $cc_email = get_theme_mod('nirup_contact_form_cc_email', '');
    $from_email = get_theme_mod('nirup_contact_form_from_email', 'explore@nirupisland.com');
    $from_name = get_bloginfo('name');

    // ==========================================
    // EMAIL 1: ADMIN NOTIFICATION (Internal)
    // ==========================================
    $admin_subject = '[' . get_bloginfo('name') . '] New Contact Form Submission from ' . $name;

    $admin_body = "New contact form submission:\n\n";
    $admin_body .= "Name: " . $name . "\n";
    $admin_body .= "Email: " . $email . "\n";
    $admin_body .= "Phone: " . $phone . "\n";
    $admin_body .= "Inquiry Type: " . $inquiry_type . "\n\n";
    $admin_body .= "Message:\n" . $message . "\n\n";
    $admin_body .= "---\n";
    $admin_body .= "This email was sent from the contact form on " . get_bloginfo('url') . "\n";
    $admin_body .= "Submitted on: " . current_time('F j, Y g:i A');

    $admin_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );

    if (!empty($cc_email) && is_email($cc_email)) {
        $admin_headers[] = 'Cc: ' . $cc_email;
    }

    $admin_mail_sent = wp_mail($admin_email, $admin_subject, $admin_body, $admin_headers);

    // ==========================================
    // EMAIL 2: USER CONFIRMATION (External)
    // ==========================================
    $user_subject_template = get_theme_mod(
        'nirup_contact_confirmation_subject',
        'Thank you for contacting us - {site_name}'
    );

    $user_body_template = get_theme_mod(
        'nirup_contact_confirmation_body',
        "Dear {user_name},\n\nThank you for reaching out to us. We have received your message and will respond within 24 hours.\n\nYour inquiry: {inquiry_type}\n\nBest regards,\n{site_name} Team"
    );

    $user_footer_template = get_theme_mod(
        'nirup_contact_confirmation_footer',
        "---\n{site_name}\n{site_url}"
    );

    // Replace template tags
    $replacements = array(
        '{site_name}' => get_bloginfo('name'),
        '{site_url}' => get_bloginfo('url'),
        '{user_name}' => $name,
        '{user_email}' => $email,
        '{inquiry_type}' => $inquiry_type,
        '{phone_number}' => get_theme_mod('nirup_contact_phone_primary', '+62 811 6220 999'),
    );

    $user_subject = str_replace(array_keys($replacements), array_values($replacements), $user_subject_template);
    $user_body = str_replace(array_keys($replacements), array_values($replacements), $user_body_template);
    $user_footer = str_replace(array_keys($replacements), array_values($replacements), $user_footer_template);

    $user_body = $user_body . "\n\n" . $user_footer;

    $user_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
    );

    $user_mail_sent = wp_mail($email, $user_subject, $user_body, $user_headers);

    // Log results
    error_log('Contact Form - Admin email result: ' . ($admin_mail_sent ? 'SUCCESS' : 'FAILED'));
    error_log('Contact Form - User email result: ' . ($user_mail_sent ? 'SUCCESS' : 'FAILED'));

    // Return success response
    wp_send_json_success(array(
        'message' => 'Thank you for your message. We will get back to you soon!',
        'admin_sent' => $admin_mail_sent,
        'user_sent' => $user_mail_sent
    ));
}
add_action('wp_ajax_nirup_contact_form_submit', 'nirup_contact_form_submit');
add_action('wp_ajax_nopriv_nirup_contact_form_submit', 'nirup_contact_form_submit');

/**
 * Get submission details for admin
 */
function nirup_get_submission_details() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Unauthorized'], 403);
        return;
    }

    $submission_id = intval($_POST['submission_id'] ?? 0);

    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';

    $submission = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $submission_id),
        ARRAY_A
    );

    if ($submission) {
        wp_send_json_success($submission);
    } else {
        wp_send_json_error(['message' => 'Submission not found']);
    }
}
add_action('wp_ajax_nirup_get_submission_details', 'nirup_get_submission_details');

/**
 * Handle private events form submission
 * Full implementation with reCAPTCHA verification and email notifications
 */
function nirup_private_events_form_submit() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'private_events_form_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed.'));
        return;
    }

    // Get form data
    $form_data = isset($_POST['form_data']) && is_array($_POST['form_data'])
        ? $_POST['form_data']
        : array();

    $name = sanitize_text_field($form_data['name'] ?? '');
    $email = sanitize_email($form_data['email'] ?? '');
    $phone = sanitize_text_field($form_data['phone'] ?? '');
    $event_type = sanitize_text_field($form_data['event_type'] ?? '');
    $event_date = sanitize_text_field($form_data['event_date'] ?? '');
    $guest_count = sanitize_text_field($form_data['guest_count'] ?? '');
    $message = sanitize_textarea_field($form_data['message'] ?? '');

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($event_type)) {
        wp_send_json_error(array('message' => 'Please fill in all required fields.'));
        return;
    }

    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'));
        return;
    }

    // reCAPTCHA v3 verification
    $recaptcha_secret = nirup_get_secret('RECAPTCHA_SECRET', 'nirup_recaptcha_secret', '');
    $recaptcha_token = sanitize_text_field($_POST['recaptcha_token'] ?? '');
    $captcha_enabled = !defined('NIRUP_DISABLE_CAPTCHA') && !empty($recaptcha_secret) && !empty($recaptcha_token);

    if ($captcha_enabled) {
        $verify = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
            'body' => array(
                'secret' => $recaptcha_secret,
                'response' => $recaptcha_token,
                'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
            ),
            'timeout' => 10,
        ));

        if (is_wp_error($verify)) {
            wp_send_json_error(array('message' => 'Captcha verification failed. Please try again.'), 400);
            return;
        }

        $vbody = json_decode(wp_remote_retrieve_body($verify), true);
        $score = isset($vbody['score']) ? (float) $vbody['score'] : 0.0;

        if (empty($vbody['success']) || $score < 0.5) {
            wp_send_json_error(array('message' => 'Captcha failed. Please try again.'), 400);
            return;
        }
    }

    // Store submission in database FIRST
    nirup_store_private_event_submission($name, $email, $phone, $event_type, $event_date, $guest_count, $message);
    error_log('Private Events Form - Submission saved to database');

    // Get email settings from customizer
    $admin_email = get_theme_mod('nirup_private_events_form_email', 'explore@nirupisland.com');
    $cc_email = get_theme_mod('nirup_private_events_form_cc_email', '');
    $from_email = get_theme_mod('nirup_private_events_form_from_email', 'explore@nirupisland.com');
    $from_name = get_bloginfo('name');

    // ==========================================
    // EMAIL 1: ADMIN NOTIFICATION (Internal)
    // ==========================================
    $admin_subject = '[' . get_bloginfo('name') . '] New Private Event Enquiry from ' . $name;

    $admin_body = "New private event enquiry:\n\n";
    $admin_body .= "Name: " . $name . "\n";
    $admin_body .= "Email: " . $email . "\n";
    $admin_body .= "Phone: " . $phone . "\n";
    $admin_body .= "Event Type: " . $event_type . "\n";
    $admin_body .= "Event Date: " . (!empty($event_date) ? date('F j, Y', strtotime($event_date)) : 'Not specified') . "\n";
    $admin_body .= "Guest Count: " . (!empty($guest_count) ? $guest_count : 'Not specified') . "\n\n";
    $admin_body .= "Message:\n" . $message . "\n\n";
    $admin_body .= "---\n";
    $admin_body .= "This email was sent from the private events enquiry form on " . get_bloginfo('url') . "\n";
    $admin_body .= "Submitted on: " . current_time('F j, Y g:i A');

    $admin_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );

    if (!empty($cc_email) && is_email($cc_email)) {
        $admin_headers[] = 'Cc: ' . $cc_email;
    }

    $admin_mail_sent = wp_mail($admin_email, $admin_subject, $admin_body, $admin_headers);

    // ==========================================
    // EMAIL 2: USER CONFIRMATION (External)
    // ==========================================
    $user_subject_template = get_theme_mod(
        'nirup_private_events_confirmation_subject',
        'Thank you for your private event enquiry - {site_name}'
    );

    $user_body_template = get_theme_mod(
        'nirup_private_events_confirmation_body',
        "Dear {user_name},\n\nThank you for your enquiry about hosting a private event at Nirup Island. We have received your request and will be in touch within 24 hours to discuss your requirements.\n\nYour event details:\nEvent Type: {event_type}\nPreferred Date: {event_date}\nEstimated Guests: {guest_count}\n\nWe look forward to helping you create an unforgettable event.\n\nBest regards,\nThe Nirup Island Events Team"
    );

    $user_footer_template = get_theme_mod(
        'nirup_private_events_confirmation_footer',
        "---\n{site_name}\n{site_url}"
    );

    // Replace template tags
    $replacements = array(
        '{site_name}' => get_bloginfo('name'),
        '{site_url}' => get_bloginfo('url'),
        '{user_name}' => $name,
        '{user_email}' => $email,
        '{event_type}' => $event_type,
        '{event_date}' => !empty($event_date) ? date('F j, Y', strtotime($event_date)) : 'Not specified',
        '{guest_count}' => !empty($guest_count) ? $guest_count : 'Not specified',
        '{phone_number}' => $phone,
    );

    $user_subject = str_replace(array_keys($replacements), array_values($replacements), $user_subject_template);
    $user_body = str_replace(array_keys($replacements), array_values($replacements), $user_body_template);
    $user_footer = str_replace(array_keys($replacements), array_values($replacements), $user_footer_template);

    $user_body = $user_body . "\n\n" . $user_footer;

    $user_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
    );

    $user_mail_sent = wp_mail($email, $user_subject, $user_body, $user_headers);

    // Log email results
    error_log('Private Events Form - Admin email result: ' . ($admin_mail_sent ? 'SUCCESS' : 'FAILED'));
    error_log('Private Events Form - User email result: ' . ($user_mail_sent ? 'SUCCESS' : 'FAILED'));

    // Return success response
    wp_send_json_success(array(
        'message' => 'Your enquiry has been received! Our events team will contact you within 24 hours.',
        'admin_sent' => $admin_mail_sent,
        'user_sent' => $user_mail_sent
    ));
}
add_action('wp_ajax_nirup_private_events_form_submit', 'nirup_private_events_form_submit');
add_action('wp_ajax_nopriv_nirup_private_events_form_submit', 'nirup_private_events_form_submit');

/**
 * Handle villa selling form submission
 * Full implementation with reCAPTCHA verification and email notifications
 */
function nirup_villa_selling_form_submit() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'nirup_villa_selling_form_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed.'));
    }

    // Get form data
    $form_data = isset($_POST['form_data']) && is_array($_POST['form_data'])
        ? $_POST['form_data']
        : array();

    $name = sanitize_text_field($form_data['name'] ?? '');
    $email = sanitize_email($form_data['email'] ?? '');
    $phone = sanitize_text_field($form_data['phone'] ?? '');
    $language = sanitize_text_field($form_data['language'] ?? '');
    $villa_unit = sanitize_text_field($form_data['villa_unit'] ?? '');
    $message = sanitize_textarea_field($form_data['message'] ?? '');

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone)) {
        wp_send_json_error(array('message' => 'Please fill in all required fields.'));
    }

    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'));
    }

    // reCAPTCHA v3 verification
    $recaptcha_secret = nirup_get_secret('RECAPTCHA_SECRET', 'nirup_recaptcha_secret', '');
    $recaptcha_token  = isset($_POST['recaptcha_token'])
        ? sanitize_text_field($_POST['recaptcha_token'])
        : '';

    $captcha_enabled = !defined('NIRUP_DISABLE_CAPTCHA')
        && !empty($recaptcha_secret)
        && !empty($recaptcha_token);

    if ($captcha_enabled) {
        $verify = wp_remote_post(
            'https://www.google.com/recaptcha/api/siteverify',
            array(
                'body'    => array(
                    'secret'   => $recaptcha_secret,
                    'response' => $recaptcha_token,
                    'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
                ),
                'timeout' => 10,
            )
        );

        if (is_wp_error($verify)) {
            wp_send_json_error(
                array('message' => 'Captcha verification failed. Please try again.'),
                400
            );
        }

        $vbody = json_decode(wp_remote_retrieve_body($verify), true);
        $score = isset($vbody['score']) ? (float) $vbody['score'] : 0.0;

        if (empty($vbody['success']) || $score < 0.5) {
            wp_send_json_error(
                array('message' => 'Captcha failed. Please try again.'),
                400
            );
        }
    }

    // Store submission in database FIRST
    nirup_store_villa_selling_submission($name, $email, $phone, $language, $villa_unit, $message);
    error_log('Villa Selling Form - Submission saved to database');

    // Get email settings from customizer
    $admin_email = get_theme_mod('nirup_villa_selling_form_email', 'explore@nirupisland.com');
    $cc_emails   = get_theme_mod('nirup_villa_selling_form_cc_email', '');
    $from_email  = get_theme_mod('nirup_villa_selling_form_from_email', 'explore@nirupisland.com');
    $from_name   = get_bloginfo('name');

    // ==========================================
    // EMAIL 1: ADMIN NOTIFICATION (Internal)
    // ==========================================
    $admin_subject = '[' . get_bloginfo('name') . '] New Villa Ownership Enquiry from ' . $name;

    $admin_body  = "New villa ownership enquiry:\n\n";
    $admin_body .= "Name: " . $name . "\n";
    $admin_body .= "Email: " . $email . "\n";
    $admin_body .= "Phone: " . $phone . "\n";
    $admin_body .= "Preferred Language: " . (!empty($language) ? $language : 'Not specified') . "\n";
    $admin_body .= "Interested Villa Unit: " . (!empty($villa_unit) ? $villa_unit : 'Not specified') . "\n\n";
    $admin_body .= "Message:\n" . $message . "\n\n";
    $admin_body .= "---\n";
    $admin_body .= "This email was sent from the villa ownership enquiry form on " . get_bloginfo('url') . "\n";
    $admin_body .= "Submitted on: " . current_time('F j, Y g:i A');

    $admin_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );

    // Add CC headers if CC emails are set
    if (!empty($cc_emails)) {
        $cc_array = array_map('trim', explode(',', $cc_emails));
        $valid_cc_emails = array();

        foreach ($cc_array as $cc_email) {
            if (!empty($cc_email) && is_email($cc_email)) {
                $valid_cc_emails[] = $cc_email;
            }
        }

        if (!empty($valid_cc_emails)) {
            foreach ($valid_cc_emails as $valid_cc) {
                $admin_headers[] = 'Cc: ' . $valid_cc;
            }
        }
    }

    $admin_mail_sent = wp_mail($admin_email, $admin_subject, $admin_body, $admin_headers);

    // ==========================================
    // EMAIL 2: USER CONFIRMATION (External)
    // ==========================================
    $user_subject_template = get_theme_mod(
        'nirup_villa_selling_confirmation_subject',
        'Thank you for your interest in Riahi Residences'
    );

    $user_body_template = get_theme_mod(
        'nirup_villa_selling_confirmation_body',
        "Dear {user_name},\n\nThank you for your enquiry about villa ownership at Nirup Island. We have received your message and will be in touch with you within 24 hours to discuss the available options.\n\nYour enquiry details:\nPreferred Language: {language}\nInterested Villa Unit: {villa_unit}\n\nWe look forward to helping you find your perfect island retreat.\n\nBest regards,\nThe Nirup Island Sales Team"
    );

    $user_footer_template = get_theme_mod(
        'nirup_villa_selling_confirmation_footer',
        "---\n{site_name}\n{site_url}"
    );

    // Replace template tags
    $replacements = array(
        '{site_name}'  => get_bloginfo('name'),
        '{site_url}'   => get_bloginfo('url'),
        '{user_name}'  => $name,
        '{user_email}' => $email,
        '{user_phone}' => $phone,
        '{language}'   => !empty($language) ? $language : 'Not specified',
        '{villa_unit}' => !empty($villa_unit) ? $villa_unit : 'Not specified',
        '{phone_number}' => get_theme_mod('nirup_contact_phone_primary', '+62 811 6220 999'),
    );

    $user_subject = str_replace(array_keys($replacements), array_values($replacements), $user_subject_template);
    $user_body    = str_replace(array_keys($replacements), array_values($replacements), $user_body_template);
    $user_footer  = str_replace(array_keys($replacements), array_values($replacements), $user_footer_template);

    $user_body = $user_body . "\n\n" . $user_footer;

    $user_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
    );

    $user_mail_sent = wp_mail($email, $user_subject, $user_body, $user_headers);

    // Log email results
    error_log('Villa Selling Form - Admin email result: ' . ($admin_mail_sent ? 'SUCCESS' : 'FAILED'));
    error_log('Villa Selling Form - User email result: ' . ($user_mail_sent ? 'SUCCESS' : 'FAILED'));

    // Return success response
    wp_send_json_success(array(
        'message' => 'Your enquiry has been received! Our sales team will contact you within 24 hours.',
        'admin_sent' => $admin_mail_sent,
        'user_sent' => $user_mail_sent
    ));
}
add_action('wp_ajax_nirup_villa_selling_form_submit', 'nirup_villa_selling_form_submit');
add_action('wp_ajax_nopriv_nirup_villa_selling_form_submit', 'nirup_villa_selling_form_submit');

/**
 * Handle berthing form submission
 * Full implementation with file uploads, reCAPTCHA verification and email notifications
 */
function nirup_berthing_form_submit() {
    // Check nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'berthing_form_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed.'));
    }

    // Get and sanitize form data
    $yacht_owner_name = sanitize_text_field($_POST['yacht_owner_name'] ?? '');
    $contact_name     = sanitize_text_field($_POST['contact_name'] ?? '');
    $phone            = sanitize_text_field($_POST['phone'] ?? '');
    $email            = sanitize_email($_POST['email'] ?? '');
    $owner_address    = sanitize_textarea_field($_POST['owner_address'] ?? '');

    $vessel_name   = sanitize_text_field($_POST['vessel_name'] ?? '');
    $vessel_type   = sanitize_text_field($_POST['vessel_type'] ?? '');
    $vessel_flag   = sanitize_text_field($_POST['vessel_flag'] ?? '');
    $vessel_length = sanitize_text_field($_POST['vessel_length'] ?? '');
    $vessel_beam   = sanitize_text_field($_POST['vessel_beam'] ?? '');
    $vessel_draft  = sanitize_text_field($_POST['vessel_draft'] ?? '');

    $arrival_date   = sanitize_text_field($_POST['arrival_date'] ?? '');
    $arrival_time   = sanitize_text_field($_POST['arrival_time'] ?? '');
    $departure_date = sanitize_text_field($_POST['departure_date'] ?? '');

    // Validate required fields
    if (empty($yacht_owner_name) || empty($contact_name) || empty($email) || empty($vessel_name)) {
        wp_send_json_error(array('message' => 'Please fill in all required fields.'));
    }

    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'));
    }

    // reCAPTCHA v3 verification
    $recaptcha_secret = nirup_get_secret('RECAPTCHA_SECRET', 'nirup_recaptcha_secret', '');
    $recaptcha_token  = sanitize_text_field($_POST['recaptcha_token'] ?? '');
    $captcha_enabled  = !defined('NIRUP_DISABLE_CAPTCHA') && !empty($recaptcha_secret);

    if ($captcha_enabled && !empty($recaptcha_token)) {
        $verify = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
            'body' => array(
                'secret'   => $recaptcha_secret,
                'response' => $recaptcha_token,
                'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
            ),
            'timeout' => 10,
        ));

        if (is_wp_error($verify)) {
            wp_send_json_error(array('message' => 'Captcha verification failed. Please try again.'), 400);
        }

        $vbody = json_decode(wp_remote_retrieve_body($verify), true);
        $score = isset($vbody['score']) ? (float) $vbody['score'] : 0;

        if (empty($vbody['success']) || $score < 0.5) {
            wp_send_json_error(array('message' => 'Captcha failed. Please try again.'), 400);
        }
    }

    // Handle file uploads
    $uploaded_files = array();
    $file_fields = array(
        'vessel_registration',
        'vessel_insurance',
        'vessel_mmsi',
        'crew_list',
        'passenger_list',
        'port_clearance'
    );

    require_once(ABSPATH . 'wp-admin/includes/file.php');

    foreach ($file_fields as $field) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $max_size = ($field === 'port_clearance') ? 64 * 1024 * 1024 : 5 * 1024 * 1024;

            if ($_FILES[$field]['size'] > $max_size) {
                wp_send_json_error(array('message' => 'File size exceeds the limit for ' . $field));
            }

            $upload = wp_handle_upload($_FILES[$field], array('test_form' => false));

            if (isset($upload['error'])) {
                error_log('Berthing Form - File upload error for ' . $field . ': ' . $upload['error']);
                wp_send_json_error(array('message' => 'File upload failed for ' . $field));
            }

            $uploaded_files[$field] = $upload['url'];
        } else {
            wp_send_json_error(array('message' => 'Required file missing: ' . $field));
        }
    }

    // Store submission in database
    $submission_id = nirup_store_berthing_submission(
        $yacht_owner_name, $contact_name, $phone, $email, $owner_address,
        $vessel_name, $vessel_type, $vessel_flag, $vessel_length, $vessel_beam, $vessel_draft,
        $arrival_date, $arrival_time, $departure_date, $uploaded_files
    );

    if (!$submission_id) {
        error_log('Berthing Form - Database storage failed');
    } else {
        error_log('Berthing Form - Submission saved to database (ID: ' . $submission_id . ')');
    }

    // Get email settings from customizer
    $admin_email = get_theme_mod('nirup_berthing_form_email', 'marina@nirupisland.com');
    $cc_email    = get_theme_mod('nirup_berthing_form_cc_email', '');
    $from_email  = get_theme_mod('nirup_berthing_form_from_email', 'marina@nirupisland.com');
    $from_name   = get_bloginfo('name');

    // ========== EMAIL 1: ADMIN NOTIFICATION ==========
    $admin_subject = '[' . get_bloginfo('name') . '] New Berthing Request from ' . $yacht_owner_name;

    $admin_body  = "New Berthing & Arrival Notice Submission\n\n";
    $admin_body .= "========== CONTACT INFORMATION ==========\n";
    $admin_body .= "Yacht Owner Name: " . $yacht_owner_name . "\n";
    $admin_body .= "Contact Name: " . $contact_name . "\n";
    $admin_body .= "Phone: " . $phone . "\n";
    $admin_body .= "Email: " . $email . "\n";
    $admin_body .= "Owner's Address: " . $owner_address . "\n\n";

    $admin_body .= "========== VESSEL PARTICULARS ==========\n";
    $admin_body .= "Vessel Name: " . $vessel_name . "\n";
    $admin_body .= "Vessel Type: " . $vessel_type . "\n";
    $admin_body .= "Flag: " . $vessel_flag . "\n";
    $admin_body .= "Length: " . $vessel_length . " meters\n";
    $admin_body .= "Beam: " . $vessel_beam . " meters\n";
    $admin_body .= "Draft: " . $vessel_draft . " meters\n\n";

    $admin_body .= "========== ARRIVAL INFORMATION ==========\n";
    $admin_body .= "Arrival Date: " . (!empty($arrival_date) ? date('F j, Y', strtotime($arrival_date)) : 'Not specified') . "\n";
    $admin_body .= "Arrival Time: " . $arrival_time . "\n";
    $admin_body .= "Departure Date: " . (!empty($departure_date) ? date('F j, Y', strtotime($departure_date)) : 'Not specified') . "\n\n";

    $admin_body .= "========== UPLOADED DOCUMENTS ==========\n";
    foreach ($uploaded_files as $field => $url) {
        $admin_body .= ucwords(str_replace('_', ' ', $field)) . ": " . $url . "\n";
    }

    $admin_body .= "\n---\n";
    $admin_body .= "This email was sent from the berthing form on " . get_bloginfo('url') . "\n";
    $admin_body .= "Submitted on: " . current_time('F j, Y g:i A');

    $admin_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
        'Reply-To: ' . $contact_name . ' <' . $email . '>'
    );

    if (!empty($cc_email) && is_email($cc_email)) {
        $admin_headers[] = 'Cc: ' . $cc_email;
    }

    // ========== EMAIL 2: USER CONFIRMATION ==========
    $user_subject_template = get_theme_mod(
        'nirup_berthing_confirmation_subject',
        'Thank you for your berthing request - {site_name}'
    );

    $user_body_template = get_theme_mod(
        'nirup_berthing_confirmation_body',
        "Dear {contact_name},\n\nThank you for submitting your arrival notice and berth reservation request for {vessel_name}.\n\nOur marina team has received your submission and will review it shortly. We aim to respond within 24 hours with confirmation and berth assignment details.\n\nYour Request Summary:\nVessel: {vessel_name} ({vessel_type})\nArrival Date: {arrival_date}\nArrival Time: {arrival_time}\nLength: {vessel_length}m | Beam: {vessel_beam}m | Draft: {vessel_draft}m\n\nFor urgent inquiries, please contact our marina directly at +62 811-6253-888.\n\nWe look forward to welcoming you to Nirup Island Marina.\n\nBest regards,\n{site_name} Marina Team"
    );

    $user_footer_template = get_theme_mod(
        'nirup_berthing_confirmation_footer',
        "---\nThis is an automated confirmation email. Please do not reply to this message."
    );

    $replacements = array(
        '{site_name}'      => get_bloginfo('name'),
        '{contact_name}'   => $contact_name,
        '{yacht_owner}'    => $yacht_owner_name,
        '{email}'          => $email,
        '{phone}'          => $phone,
        '{vessel_name}'    => $vessel_name,
        '{vessel_type}'    => $vessel_type,
        '{vessel_flag}'    => $vessel_flag,
        '{vessel_length}'  => $vessel_length,
        '{vessel_beam}'    => $vessel_beam,
        '{vessel_draft}'   => $vessel_draft,
        '{arrival_date}'   => !empty($arrival_date) ? date('F j, Y', strtotime($arrival_date)) : 'Not specified',
        '{arrival_time}'   => $arrival_time,
        '{departure_date}' => !empty($departure_date) ? date('F j, Y', strtotime($departure_date)) : 'Not specified',
    );

    $user_subject = str_replace(array_keys($replacements), array_values($replacements), $user_subject_template);
    $user_body    = str_replace(array_keys($replacements), array_values($replacements), $user_body_template);
    $user_footer  = str_replace(array_keys($replacements), array_values($replacements), $user_footer_template);
    $user_body    = $user_body . "\n\n" . $user_footer;

    $user_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>'
    );

    // ========== SEND EMAILS ==========
    $admin_mail_sent = wp_mail($admin_email, $admin_subject, $admin_body, $admin_headers);
    error_log('Berthing Form - Admin email result: ' . ($admin_mail_sent ? 'SUCCESS' : 'FAILED'));

    $user_mail_sent = wp_mail($email, $user_subject, $user_body, $user_headers);
    error_log('Berthing Form - User email result: ' . ($user_mail_sent ? 'SUCCESS' : 'FAILED'));

    // ========== RETURN RESPONSE ==========
    if ($admin_mail_sent || $user_mail_sent) {
        wp_send_json_success(array(
            'message'    => 'Your berthing request has been received! Our marina team will respond within 24 hours.',
            'admin_sent' => $admin_mail_sent,
            'user_sent'  => $user_mail_sent,
        ));
    } else {
        wp_send_json_success(array(
            'message'    => 'Your berthing request has been saved! Our marina team will respond within 24 hours.',
            'admin_sent' => false,
            'user_sent'  => false,
        ));
    }
}
add_action('wp_ajax_nirup_berthing_form_submit', 'nirup_berthing_form_submit');
add_action('wp_ajax_nopriv_nirup_berthing_form_submit', 'nirup_berthing_form_submit');

// ========================================
// BOOKING & MEDIA AJAX HANDLERS
// ========================================

/**
 * Process villa booking shortcode
 * AJAX handler for loading villa booking calendars dynamically
 */
function nirup_process_villa_booking_shortcode() {
    // Verify nonce for security
    check_ajax_referer('villa_booking_nonce', 'nonce');

    // Get villa ID from AJAX request
    $villa_id = isset($_POST['villa_id']) ? intval($_POST['villa_id']) : 0;

    if (!$villa_id) {
        wp_send_json_error('No villa ID provided');
        return;
    }

    // Get calendar ID and form ID from villa meta
    $calendar_id = get_post_meta($villa_id, '_villa_booking_calendar_id', true);
    $form_id = get_post_meta($villa_id, '_villa_booking_form_id', true);

    // Check if calendar ID exists
    if (!$calendar_id) {
        wp_send_json_error('No calendar ID configured for this villa');
        return;
    }

    // Check if WP Booking System is active
    if (!class_exists('WP_Booking_System')) {
        wp_send_json_error('WP Booking System is not active. Please install and activate the plugin.');
        return;
    }

    // Enqueue WPBS styles and scripts
    if (function_exists('wpbs_enqueue_front_end_scripts_and_styles')) {
        wpbs_enqueue_front_end_scripts_and_styles();
    }

    // Capture any enqueued styles
    ob_start();
    wp_print_styles();
    $styles = ob_get_clean();

    // Build shortcode with all necessary attributes for villas
    $shortcode_attrs = array(
        'id' => esc_attr($calendar_id),
        'history' => '1',
        'selection_type' => 'multiple',
        'selection_style' => 'split'
    );

    // Add form_id if available
    if ($form_id) {
        $shortcode_attrs['form_id'] = esc_attr($form_id);
    }

    // Build the shortcode string
    $shortcode_parts = array();
    foreach ($shortcode_attrs as $key => $value) {
        $shortcode_parts[] = $key . '="' . $value . '"';
    }

    $shortcode = '[wpbs ' . implode(' ', $shortcode_parts) . ']';

    // Process the shortcode
    $output = do_shortcode($shortcode);

    // Check if output is valid
    if (empty(trim($output)) || $output === $shortcode) {
        wp_send_json_error('Calendar ID ' . esc_html($calendar_id) . ' not found. Please verify the calendar exists in WP Booking System > Calendars.');
        return;
    }

    // Combine styles and output
    $full_output = $styles . $output;

    // Return success with calendar HTML and metadata
    wp_send_json_success(array(
        'html' => $full_output,
        'calendar_id' => $calendar_id,
        'form_id' => $form_id
    ));
}
add_action('wp_ajax_process_villa_booking_shortcode', 'nirup_process_villa_booking_shortcode');
add_action('wp_ajax_nopriv_process_villa_booking_shortcode', 'nirup_process_villa_booking_shortcode');

/**
 * Load more media articles via AJAX
 * Handles pagination for media coverage archive
 */
function nirup_load_more_media_articles() {
    // Verify nonce
    check_ajax_referer('nirup_nonce', 'nonce');

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    // Query for articles
    $articles_query = new WP_Query(array(
        'post_type' => 'media_coverage',
        'posts_per_page' => 5,
        'orderby' => 'meta_value',
        'meta_key' => '_media_article_date',
        'order' => 'DESC',
        'post_status' => 'publish',
        'paged' => $page
    ));

    if ($articles_query->have_posts()) {
        ob_start();

        while ($articles_query->have_posts()) {
            $articles_query->the_post();
            $article_id = get_the_ID();
            $source = get_post_meta($article_id, '_media_article_source', true);
            $quote = get_post_meta($article_id, '_media_article_quote', true);
            $link = get_post_meta($article_id, '_media_article_link', true);
            ?>

            <div class="media-article-item" data-page="<?php echo esc_attr($page); ?>">
                <div class="article-header">
                    <h2 class="article-title"><?php echo esc_html(get_the_title()); ?></h2>

                    <?php if ($source) : ?>
                        <p class="article-source"><?php echo esc_html($source); ?></p>
                    <?php endif; ?>

                    <div class="article-divider"></div>
                </div>

                <div class="article-content">
                    <?php if ($quote) : ?>
                        <blockquote class="article-quote"><?php echo esc_html($quote); ?></blockquote>
                    <?php endif; ?>

                    <?php if ($link) : ?>
                        <a href="<?php echo esc_url($link); ?>"
                           class="article-link-btn"
                           target="_blank"
                           rel="noopener noreferrer">
                            Read Full Article
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <?php
        }

        $html = ob_get_clean();
        wp_reset_postdata();

        wp_send_json_success(array(
            'html' => $html,
            'page' => $page
        ));
    } else {
        wp_send_json_error(array(
            'message' => 'No more articles found'
        ));
    }

    wp_die();
}
add_action('wp_ajax_load_more_media_articles', 'nirup_load_more_media_articles');
add_action('wp_ajax_nopriv_load_more_media_articles', 'nirup_load_more_media_articles');

// ========================================
// HELPER FUNCTIONS - MAP PINS
// ========================================

/**
 * Get all map pins from options table
 */
function nirup_get_map_pins() {
    return get_option('nirup_map_pins', array());
}

/**
 * Add new map pin
 */
function nirup_add_map_pin($data) {
    $pins = nirup_get_map_pins();

    $new_pin = array(
        'id' => uniqid('pin_'),
        'title' => sanitize_text_field($data['pin_title'] ?? $data['title'] ?? ''),
        'description' => sanitize_textarea_field($data['pin_description'] ?? $data['description'] ?? ''),
        'x' => floatval($data['pin_x'] ?? $data['x'] ?? 0),
        'y' => floatval($data['pin_y'] ?? $data['y'] ?? 0),
        'link' => esc_url_raw($data['pin_link'] ?? $data['link'] ?? ''),
        'pin_type' => sanitize_text_field($data['pin_type'] ?? 'public'),
        'icon' => sanitize_text_field($data['pin_icon'] ?? $data['icon'] ?? ''),
        'image_1' => isset($data['pin_image_1']) ? absint($data['pin_image_1']) : (isset($data['image_1']) ? absint($data['image_1']) : 0),
        'image_2' => isset($data['pin_image_2']) ? absint($data['pin_image_2']) : (isset($data['image_2']) ? absint($data['image_2']) : 0),
        'hours' => isset($data['pin_hours']) ? sanitize_text_field($data['pin_hours']) : (isset($data['hours']) ? sanitize_text_field($data['hours']) : ''),
        'created' => current_time('mysql')
    );

    $pins[] = $new_pin;
    update_option('nirup_map_pins', $pins);

    add_settings_error('nirup_pins', 'pin_added', __('Pin added successfully!', 'nirup-island'), 'updated');
}

/**
 * Update existing map pin
 */
function nirup_update_map_pin($data) {
    $pins = nirup_get_map_pins();
    $pin_id = sanitize_text_field($data['pin_id']);

    foreach ($pins as &$pin) {
        if ($pin['id'] === $pin_id) {
            $pin['title'] = sanitize_text_field($data['pin_title'] ?? $data['title'] ?? $pin['title']);
            $pin['description'] = sanitize_textarea_field($data['pin_description'] ?? $data['description'] ?? $pin['description']);
            $pin['x'] = floatval($data['pin_x'] ?? $data['x'] ?? $pin['x']);
            $pin['y'] = floatval($data['pin_y'] ?? $data['y'] ?? $pin['y']);
            $pin['link'] = esc_url_raw($data['pin_link'] ?? $data['link'] ?? $pin['link']);
            $pin['pin_type'] = sanitize_text_field($data['pin_type'] ?? $pin['pin_type']);
            $pin['icon'] = sanitize_text_field($data['pin_icon'] ?? $data['icon'] ?? $pin['icon'] ?? '');
            $pin['image_1'] = isset($data['pin_image_1']) ? absint($data['pin_image_1']) : (isset($data['image_1']) ? absint($data['image_1']) : ($pin['image_1'] ?? 0));
            $pin['image_2'] = isset($data['pin_image_2']) ? absint($data['pin_image_2']) : (isset($data['image_2']) ? absint($data['image_2']) : ($pin['image_2'] ?? 0));
            $pin['hours'] = isset($data['pin_hours']) ? sanitize_text_field($data['pin_hours']) : (isset($data['hours']) ? sanitize_text_field($data['hours']) : ($pin['hours'] ?? ''));
            $pin['updated'] = current_time('mysql');
            break;
        }
    }

    update_option('nirup_map_pins', $pins);
    add_settings_error('nirup_pins', 'pin_updated', __('Pin updated successfully!', 'nirup-island'), 'updated');
}

/**
 * Delete map pin
 */
function nirup_delete_map_pin($pin_id) {
    $pins = nirup_get_map_pins();
    $pin_id = sanitize_text_field($pin_id);

    $pins = array_filter($pins, function($pin) use ($pin_id) {
        return $pin['id'] !== $pin_id;
    });

    update_option('nirup_map_pins', array_values($pins));
    add_settings_error('nirup_pins', 'pin_deleted', __('Pin deleted successfully!', 'nirup-island'), 'updated');
}

// ========================================
// HELPER FUNCTIONS - DATABASE STORAGE
// ========================================

/**
 * Store contact form submission in database
 */
function nirup_store_contact_submission($name, $email, $phone, $inquiry_type, $message) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';

    // Create table if it doesn't exist
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        nirup_create_contact_submissions_table();
    }

    // Insert submission
    $result = $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'inquiry_type' => $inquiry_type,
            'message' => $message,
            'submission_date' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s')
    );

    if ($result === false) {
        error_log('Contact Form - Database storage failed: ' . $wpdb->last_error);
    } else {
        error_log('Contact Form - Submission saved to database successfully');
    }
}

/**
 * Create contact submissions table
 */
function nirup_create_contact_submissions_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(100) DEFAULT '',
        inquiry_type varchar(255) NOT NULL,
        message text NOT NULL,
        submission_date datetime NOT NULL,
        status varchar(20) DEFAULT 'new',
        PRIMARY KEY (id),
        KEY email (email),
        KEY submission_date (submission_date),
        KEY status (status)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/**
 * Store private event submission in database
 */
function nirup_store_private_event_submission($name, $email, $phone, $event_type, $event_date, $guest_count, $message) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'private_event_submissions';

    // Create table if it doesn't exist
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        nirup_create_private_event_submissions_table();
    }

    // Insert submission
    $result = $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'event_type' => $event_type,
            'event_date' => $event_date,
            'guest_count' => $guest_count,
            'message' => $message,
            'submission_date' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );

    if ($result === false) {
        error_log('Private Events Form - Database storage failed: ' . $wpdb->last_error);
    } else {
        error_log('Private Events Form - Submission saved to database successfully');
    }
}

/**
 * Create private event submissions table
 */
function nirup_create_private_event_submissions_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'private_event_submissions';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(100) DEFAULT '',
        event_type varchar(255) NOT NULL,
        event_date date DEFAULT NULL,
        guest_count varchar(50) DEFAULT '',
        message text NOT NULL,
        submission_date datetime NOT NULL,
        status varchar(20) DEFAULT 'new',
        PRIMARY KEY (id),
        KEY email (email),
        KEY submission_date (submission_date),
        KEY status (status)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/**
 * Store villa selling submission in database
 */
function nirup_store_villa_selling_submission($name, $email, $phone, $language, $villa_unit, $message) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'villa_selling_submissions';

    // Create table if it doesn't exist
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        nirup_create_villa_selling_submissions_table();
    }

    // Insert submission
    $result = $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'language' => $language,
            'villa_unit' => $villa_unit,
            'message' => $message,
            'submission_date' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );

    if ($result === false) {
        error_log('Villa Selling Form - Database storage failed: ' . $wpdb->last_error);
    } else {
        error_log('Villa Selling Form - Submission saved to database successfully');
    }
}

/**
 * Create villa selling submissions table
 */
function nirup_create_villa_selling_submissions_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'villa_selling_submissions';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(50) NOT NULL,
        language varchar(50) DEFAULT NULL,
        villa_unit varchar(255) DEFAULT NULL,
        message text DEFAULT NULL,
        submission_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        status varchar(50) DEFAULT 'pending' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/**
 * Store berthing submission in database
 */
function nirup_store_berthing_submission(
    $yacht_owner_name, $contact_name, $phone, $email, $owner_address,
    $vessel_name, $vessel_type, $vessel_flag, $vessel_length, $vessel_beam, $vessel_draft,
    $arrival_date, $arrival_time, $departure_date, $uploaded_files
) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'berthing_submissions';

    // Create table if it doesn't exist
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        nirup_create_berthing_submissions_table();
    }

    // Insert submission
    $result = $wpdb->insert(
        $table_name,
        array(
            'yacht_owner_name' => $yacht_owner_name,
            'contact_name'     => $contact_name,
            'phone'            => $phone,
            'email'            => $email,
            'owner_address'    => $owner_address,
            'vessel_name'      => $vessel_name,
            'vessel_type'      => $vessel_type,
            'vessel_flag'      => $vessel_flag,
            'vessel_length'    => $vessel_length,
            'vessel_beam'      => $vessel_beam,
            'vessel_draft'     => $vessel_draft,
            'arrival_date'     => $arrival_date,
            'arrival_time'     => $arrival_time,
            'departure_date'   => $departure_date,
            'uploaded_files'   => json_encode($uploaded_files),
            'submission_date'  => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );

    if ($result === false) {
        error_log('Berthing Form - Database storage failed: ' . $wpdb->last_error);
        return false;
    }

    return $wpdb->insert_id;
}

/**
 * Create berthing submissions table
 */
function nirup_create_berthing_submissions_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'berthing_submissions';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        yacht_owner_name varchar(255) NOT NULL,
        contact_name varchar(255) NOT NULL,
        phone varchar(100) NOT NULL,
        email varchar(255) NOT NULL,
        owner_address text NOT NULL,
        vessel_name varchar(255) NOT NULL,
        vessel_type varchar(100) NOT NULL,
        vessel_flag varchar(100) NOT NULL,
        vessel_length varchar(50) NOT NULL,
        vessel_beam varchar(50) NOT NULL,
        vessel_draft varchar(50) NOT NULL,
        arrival_date date DEFAULT NULL,
        arrival_time time DEFAULT NULL,
        departure_date date DEFAULT NULL,
        uploaded_files text DEFAULT NULL,
        submission_date datetime NOT NULL,
        status varchar(20) DEFAULT 'new',
        PRIMARY KEY (id),
        KEY email (email),
        KEY submission_date (submission_date),
        KEY status (status),
        KEY vessel_name (vessel_name),
        KEY arrival_date (arrival_date)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
