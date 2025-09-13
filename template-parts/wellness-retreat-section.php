<?php
/**
 * Template Part: Wellness Retreat Section
 * File: template-parts/wellness-retreat-section.php
 * 
 * NO ENABLED/DISABLED LOGIC - JUST FUCKING SHOWS LIKE OTHER SECTIONS
 */

// Get customizer values - NO OPTIONS ARRAY, NO ENABLED CHECK, NO BULLSHIT
$small_title = get_theme_mod('nirup_wellness_small_title', 'Wellness Retreat Package');
$main_title = get_theme_mod('nirup_wellness_main_title', 'WELLNESS RETREAT BY WESTIN');
$date_range = get_theme_mod('nirup_wellness_date_range', 'June 03, 2025 – September 02, 2025');
$description = get_theme_mod('nirup_wellness_description', 'The Nirup Wellness Retreat at The Westin Nirup Island Resort & Spa offers guests a holistic escape, featuring daily wellness and family activities, access to the WestinWORKOUT® Fitness Studio, and a curated program of rejuvenating experiences.');
$button_text = get_theme_mod('nirup_wellness_button_text', 'Book Your Stay');
$button_link = get_theme_mod('nirup_wellness_button_link', '#');
$image_id = get_theme_mod('nirup_wellness_image');

// Get image URL
$image_url = $image_id ? wp_get_attachment_image_url($image_id, 'full') : '';
?>

<section class="wellness-retreat-section">
    <div class="relative">
        <!-- Content Side -->
        <div class="wellness-content">
            <div class="content-wrapper">
                <!-- Small Title -->
                <div class="small-title">
                    <p><?php echo esc_html($small_title); ?></p>
                </div>

                <!-- Main Title -->
                <div class="main-title">
                    <h2><?php echo wp_kses_post(nl2br($main_title)); ?></h2>
                </div>

                <!-- Date Range -->
                <div class="date-range">
                    <p><?php echo esc_html($date_range); ?></p>
                </div>

                <!-- Description -->
                <div class="description">
                    <p><?php echo wp_kses_post($description); ?></p>
                </div>

                <!-- CTA Button -->
                <div class="cta-button">
                    <a href="<?php echo esc_url($button_link); ?>">
                        <span><?php echo esc_html($button_text); ?></span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Image Side -->
        <div class="wellness-image">
            <?php if ($image_url): ?>
            <img src="<?php echo esc_url($image_url); ?>" 
                 alt="Wellness Retreat" />
            <?php endif; ?>
        </div>
    </div>
</section>