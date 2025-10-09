<?php
/**
 * Template Name: Private Events Page
 * Description: Private events page matching Figma design exactly (node 1291:4062)
 */

get_header();
?>

<?php get_template_part('template-parts/breadcrumbs'); ?>

<main id="private-events-page" class="private-events-page">
    
    <!-- Hero Section with Image -->
    <section class="private-events-hero">
        <?php 
        $hero_image_id = get_theme_mod('nirup_private_events_hero_image');
        if ($hero_image_id) {
            echo wp_get_attachment_image($hero_image_id, 'full', false, array('class' => 'hero-bg-image'));
        }
        ?>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">
                <?php echo esc_html(get_theme_mod('nirup_private_events_title', 'PRIVATE EVENTS')); ?>
            </h1>
            <p class="hero-subtitle">
                <?php echo esc_html(get_theme_mod('nirup_private_events_hero_subtitle', 'Versatile venues where elegance meets island beauty — ideal for meetings, weddings, and celebrations')); ?>
            </p>
        </div>
    </section>

    <!-- Events Section Header -->
    <section class="events-section-header">
        <div class="events-header-container">
            <h2 class="events-section-title">
                <?php echo esc_html(get_theme_mod('nirup_private_events_section_title', 'EVENTS')); ?>
            </h2>
            <p class="events-section-description">
                <?php echo esc_html(get_theme_mod('nirup_private_events_section_description', 'Versatile venues for weddings, meetings, and private celebrations on Nirup Island, offering elegant spaces, breathtaking views, and tailored experiences to make every event truly unforgettable.')); ?>
            </p>
        </div>
    </section>

    <!-- Event Cards Grid -->
    <section class="events-cards-section">
        <div class="events-cards-container">
            
            <!-- Card 1: Ballroom -->
            <div class="event-card">
                <div class="event-card-image">
                    <?php 
                    $ballroom_image_id = get_theme_mod('nirup_event_ballroom_image');
                    if ($ballroom_image_id) {
                        echo wp_get_attachment_image($ballroom_image_id, 'full', false, array('class' => 'card-img'));
                    }
                    ?>
                </div>
                <div class="event-card-content">
                    <p class="event-card-location">
                        <?php echo esc_html(get_theme_mod('nirup_event_ballroom_location', 'Westin Nirup Island Resort & Spa')); ?>
                    </p>
                    <h3 class="event-card-title">
                        <?php echo esc_html(get_theme_mod('nirup_event_ballroom_title', 'BALLROOM')); ?>
                    </h3>
                    <p class="event-card-description">
                        <?php echo esc_html(get_theme_mod('nirup_event_ballroom_description', 'Celebrate life\'s most important moments at Nirup Island\'s elegant ballroom. Perfect for weddings, anniversaries, and milestone events, the ballroom offers a pillarless 450 sqm space that can be transformed to match your vision. With breathtaking views and access to the island\'s unique venues, your celebration becomes truly unforgettable.')); ?>
                    </p>
                    <div class="event-card-details">
                        <div class="detail-item">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <path d="M14 28C6.26801 28 0 21.732 0 14C0 6.26801 0 0 14 0C21.732 0 28 6.26801 28 14C28 21.732 21.732 28 14 28Z" fill="#A48456"/>
                            </svg>
                            <span>Up to 200 guests<br/>(round table setup)</span>
                        </div>
                        <div class="detail-item">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <path d="M14 28C6.26801 28 0 21.732 0 14C0 6.26801 0 0 14 0C21.732 0 28 6.26801 28 14C28 21.732 21.732 28 14 28Z" fill="#A48456"/>
                            </svg>
                            <span>Up to 400 guests<br/>(cocktail reception)</span>
                        </div>
                        <div class="detail-item">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <path d="M14 28C6.26801 28 0 21.732 0 14C0 6.26801 0 0 14 0C21.732 0 28 6.26801 28 14C28 21.732 21.732 28 14 28Z" fill="#A48456"/>
                            </svg>
                            <span>450 sqm pillarless space</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Meeting Rooms -->
            <div class="event-card">
                <div class="event-card-image">
                    <?php 
                    $meeting_image_id = get_theme_mod('nirup_event_meeting_image');
                    if ($meeting_image_id) {
                        echo wp_get_attachment_image($meeting_image_id, 'full', false, array('class' => 'card-img'));
                    }
                    ?>
                </div>
                <div class="event-card-content">
                    <p class="event-card-location">
                        <?php echo esc_html(get_theme_mod('nirup_event_meeting_location', 'Westin Nirup Island Resort & Spa')); ?>
                    </p>
                    <h3 class="event-card-title">
                        <?php echo esc_html(get_theme_mod('nirup_event_meeting_title', 'MEETING ROOMS')); ?>
                    </h3>
                    <p class="event-card-description">
                        <?php echo esc_html(get_theme_mod('nirup_event_meeting_description', 'Designed for productivity and collaboration, our meeting rooms combine a professional setting with the island\'s calming atmosphere. Ideal for board meetings, team workshops, or small conferences, each space offers flexible layouts, modern amenities, and the option to be combined for larger gatherings.')); ?>
                    </p>
                    <div class="event-card-details">
                        <div class="detail-item">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <path d="M14 28C6.26801 28 0 21.732 0 14C0 6.26801 0 0 14 0C21.732 0 28 6.26801 28 14C28 21.732 21.732 28 14 28Z" fill="#A48456"/>
                            </svg>
                            <span>3 meeting rooms<br/>in total</span>
                        </div>
                        <div class="detail-item">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <path d="M14 28C6.26801 28 0 21.732 0 14C0 6.26801 0 0 14 0C21.732 0 28 6.26801 28 14C28 21.732 21.732 28 14 28Z" fill="#A48456"/>
                            </svg>
                            <span>Up to 20 people<br/>(U-shape setup)</span>
                        </div>
                        <div class="detail-item">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <path d="M14 28C6.26801 28 0 21.732 0 14C0 6.26801 0 0 14 0C21.732 0 28 6.26801 28 14C28 21.732 21.732 28 14 28Z" fill="#A48456"/>
                            </svg>
                            <span>Up to 20 people<br/>(theater style setup)</span>
                        </div>
                        <div class="detail-item">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <path d="M14 28C6.26801 28 0 21.732 0 14C0 6.26801 0 0 14 0C21.732 0 28 6.26801 28 14C28 21.732 21.732 28 14 28Z" fill="#A48456"/>
                            </svg>
                            <span>Up to 50 people<br/>(combined space, without partitions)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Weddings -->
            <div class="event-card">
                <div class="event-card-image">
                    <?php 
                    $wedding_image_id = get_theme_mod('nirup_event_wedding_image');
                    if ($wedding_image_id) {
                        echo wp_get_attachment_image($wedding_image_id, 'full', false, array('class' => 'card-img'));
                    }
                    ?>
                </div>
                <div class="event-card-content">
                    <p class="event-card-location">
                        <?php echo esc_html(get_theme_mod('nirup_event_wedding_location', 'Nirup Island')); ?>
                    </p>
                    <h3 class="event-card-title">
                        <?php echo esc_html(get_theme_mod('nirup_event_wedding_title', 'WEDDINGS')); ?>
                    </h3>
                    <p class="event-card-description">
                        <?php echo esc_html(get_theme_mod('nirup_event_wedding_description', 'Exchange vows against the backdrop of shimmering waters and lush landscapes. Nirup Island offers an enchanting setting for weddings of every scale — from intimate ceremonies to grand celebrations. Our team perfects every detail—from custom décor to curated dining—creating memories that last a lifetime.')); ?>
                    </p>
                    <div class="event-card-details">
                        <div class="detail-item">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <path d="M14 28C6.26801 28 0 21.732 0 14C0 6.26801 0 0 14 0C21.732 0 28 6.26801 28 14C28 21.732 21.732 28 14 28Z" fill="#A48456"/>
                            </svg>
                            <span>Stunning oceanfront<br/>and garden venues</span>
                        </div>
                        <div class="detail-item">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <path d="M14 28C6.26801 28 0 21.732 0 14C0 6.26801 0 0 14 0C21.732 0 28 6.26801 28 14C28 21.732 21.732 28 14 28Z" fill="#A48456"/>
                            </svg>
                            <span>Tailored wedding<br/>planning services</span>
                        </div>
                        <div class="detail-item">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <path d="M14 28C6.26801 28 0 21.732 0 14C0 6.26801 0 0 14 0C21.732 0 28 6.26801 28 14C28 21.732 21.732 28 14 28Z" fill="#A48456"/>
                            </svg>
                            <span>Customizable dining<br/>& décor packages</span>
                        </div>
                        <div class="detail-item">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <path d="M14 28C6.26801 28 0 21.732 0 14C0 6.26801 0 0 14 0C21.732 0 28 6.26801 28 14C28 21.732 21.732 28 14 28Z" fill="#A48456"/>
                            </svg>
                            <span>Bridal preparation<br/>suite available</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Form Section -->
    <section class="form-section">
        <div class="form-section-container">
            <h2 class="form-section-title">
                <?php echo esc_html(get_theme_mod('nirup_private_events_form_title', 'PLAN YOUR EVENT WITH US')); ?>
            </h2>
            <p class="form-section-description">
                <?php echo esc_html(get_theme_mod('nirup_private_events_form_description', 'From corporate gatherings to once-in-a-lifetime celebrations, Nirup Island provides the perfect backdrop for unforgettable moments. Get in touch with our team today to start planning your event.')); ?>
            </p>

            <form id="private-events-form" class="private-events-form">
                <div class="form-columns">
                    <!-- Left Column -->
                    <div class="form-column-left">
                        <div class="form-field">
                            <label class="form-label">Name*</label>
                            <input type="text" name="name" class="form-input" placeholder="Your Name" required>
                        </div>
                        <div class="form-field">
                            <label class="form-label">E-mail*</label>
                            <input type="email" name="email" class="form-input" placeholder="Your E-mail" required>
                        </div>
                        <div class="form-field">
                            <label class="form-label">Phone*</label>
                            <input type="tel" name="phone" class="form-input" placeholder="Your Phone Number" required>
                        </div>
                        <div class="form-field">
                            <label class="form-label">Preferred Event Date</label>
                            <input type="text" name="event_date" class="form-input" placeholder="dd.mm.yyyy">
                        </div>
                        <div class="form-field">
                            <label class="form-label">Event Type</label>
                            <select name="event_type" class="form-select">
                                <option value="">Choose event type</option>
                                <option value="Wedding">Wedding</option>
                                <option value="Corporate Meeting">Corporate Meeting</option>
                                <option value="Team Building Event">Team Building Event</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="form-column-right">
                        <div class="form-field">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-textarea" placeholder="Tell us about your event details or special requests"></textarea>
                        </div>
                        <button type="submit" class="form-submit-btn">
                            <span class="btn-text">Submit Inquiry</span>
                            <span class="btn-loader"></span>
                        </button>
                    </div>
                </div>

                <div class="form-message" id="form-message"></div>
            </form>
        </div>
    </section>

</main>

<!-- Thank You Modal -->
<div id="thank-you-modal" class="thank-you-modal">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <h2 class="modal-title">
            <?php echo esc_html(get_theme_mod('nirup_private_events_modal_title', 'THANK YOU FOR REACHING OUT')); ?>
        </h2>
        <p class="modal-intro-text">
            <?php echo esc_html(get_theme_mod('nirup_private_events_modal_intro', 'Your event request has been received. Our team will be in touch within 1-2 business days to discuss your plans in detail and guide you through the possibilities.')); ?>
        </p>
        
        <div class="modal-links">
            <div class="modal-links-left">
                <?php 
                $link1_url = get_theme_mod('nirup_private_events_modal_link1_url', '/dining/');
                $link1_text = get_theme_mod('nirup_private_events_modal_link1_text', 'Explore our dining experiences');
                if ($link1_url && $link1_text) : ?>
                <a href="<?php echo esc_url($link1_url); ?>" class="modal-link">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" stroke="#A48456" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" stroke="#A48456" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span><?php echo esc_html($link1_text); ?></span>
                </a>
                <?php endif; ?>
                
                <?php 
                $link2_url = get_theme_mod('nirup_private_events_modal_link2_url', '/accommodations/');
                $link2_text = get_theme_mod('nirup_private_events_modal_link2_text', 'Discover accommodation for your guests');
                if ($link2_url && $link2_text) : ?>
                <a href="<?php echo esc_url($link2_url); ?>" class="modal-link">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" stroke="#A48456" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" stroke="#A48456" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span><?php echo esc_html($link2_text); ?></span>
                </a>
                <?php endif; ?>
            </div>
            
            <div class="modal-links-right">
                <?php 
                $phone_text = get_theme_mod('nirup_private_events_modal_phone_text', 'Contact us directly for time-sensitive enquiries at +62 811-6220-999');
                $phone_number = get_theme_mod('nirup_private_events_modal_phone_number', '+62 811-6220-999');
                if ($phone_text) : ?>
                <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone_number)); ?>" class="modal-link modal-phone-link">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" stroke="#A48456" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span><?php echo esc_html($phone_text); ?></span>
                </a>
                <?php endif; ?>
            </div>
        </div>
        
        <p class="modal-closing-text">
            <?php echo esc_html(get_theme_mod('nirup_private_events_modal_closing', 'We look forward to helping you create an event that is both seamless and memorable.')); ?>
        </p>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    window.nirup_private_events_ajax = {
        ajax_url: '<?php echo admin_url('admin-ajax.php'); ?>',
        nonce: '<?php echo wp_create_nonce('private_events_form_nonce'); ?>'
    };
});
</script>

<?php get_footer(); ?>