<?php
/**
 * Hero Section Template
 * File: template-parts/hero-section.php
 */

// Get customizer values
$hero_bg_image_id = get_theme_mod('nirup_hero_bg_image');
$hero_pattern_image_id = get_theme_mod('nirup_hero_pattern_image');
$hero_title = get_theme_mod('nirup_hero_title', __('Your Island Escape', 'nirup-island'));
$hero_subtitle = get_theme_mod('nirup_hero_subtitle', __('Just 50 minutes from Singapore', 'nirup-island'));
$hero_cta_text = get_theme_mod('nirup_hero_cta_text', __('Book Your Stay', 'nirup-island'));
$hero_cta_link = get_theme_mod('nirup_hero_cta_link', '');
$hero_logo_id = get_theme_mod('nirup_hero_logo');
$hero_logo_link = get_theme_mod('nirup_hero_logo_link', '');

// Get image URLs
$hero_bg_url = $hero_bg_image_id ? wp_get_attachment_image_url($hero_bg_image_id, 'full') : '';
$hero_pattern_url = $hero_pattern_image_id ? wp_get_attachment_image_url($hero_pattern_image_id, 'full') : '';

// Build inline styles
$inline_styles = '';
if ($hero_bg_url) {
    $inline_styles .= '.hero-main-bg { background-image: url(' . esc_url($hero_bg_url) . '); }';
}
if ($hero_pattern_url) {
    $inline_styles .= '.hero-pattern-bg { background-image: url(' . esc_url($hero_pattern_url) . '); }';
}

// Add inline styles if we have any
if ($inline_styles) {
    wp_add_inline_style('nirup-hero', $inline_styles);
}
?>

<section class="hero-section" id="hero">

    <!-- Hero Content -->
    <div class="hero-content">
        <!-- Text Content -->
        <div class="hero-text">
            <?php if ($hero_title): ?>
            <h1 class="hero-title"><?php echo esc_html($hero_title); ?></h1>
            <?php endif; ?>
            
            <?php if ($hero_subtitle): ?>
            <p class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
            <?php endif; ?>
        </div>
        
        <!-- Decorative Line -->
        <div class="hero-divider"></div>
        
        <!-- Hero Logo -->
        <div class="hero-bottom">
            <div class="hero-logo">
                <?php 
                // Get logo URL or fallback to default
                $hero_logo_url = $hero_logo_id ? wp_get_attachment_image_url($hero_logo_id, 'full') : get_template_directory_uri() . '#';
                $hero_logo_alt = $hero_logo_id ? get_post_meta($hero_logo_id, '_wp_attachment_image_alt', true) : 'The Westin Logo';
                
                if ($hero_logo_link): ?>
                    <a href="<?php echo esc_url($hero_logo_link); ?>" target="_blank" 
                           rel="noopener noreferrer" title="<?php echo esc_attr($hero_logo_alt); ?>">
                        <img src="<?php echo esc_url($hero_logo_url); ?>" 
                             alt="<?php echo esc_attr($hero_logo_alt); ?>">
                    </a>
                <?php else: ?>
                    <img src="<?php echo esc_url($hero_logo_url); ?>" 
                         alt="<?php echo esc_attr($hero_logo_alt); ?>">
                <?php endif; ?>
            </div>
            
            <?php if ($hero_cta_text): ?>
            <!-- CTA Button -->
            <a href="<?php echo esc_url($hero_cta_link ? $hero_cta_link : '#'); ?>" 
            class="hero-cta"
            <?php if (empty($hero_cta_link)): ?>onclick="return false;"<?php endif; ?>>
                <?php echo esc_html($hero_cta_text); ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    // Hero CTA button tracking
    $('.hero-cta').on('click', function() {
        var buttonText = $(this).text();
        var buttonUrl = $(this).attr('href');
        
        // Analytics tracking
        if (typeof gtag !== 'undefined') {
            gtag('event', 'click', {
                event_category: 'hero',
                event_label: 'cta_button',
                value: buttonText
            });
        }
        
        // Microsoft Clarity tracking
        if (typeof clarity !== 'undefined') {
            clarity('event', 'hero_cta_click', {
                text: buttonText,
                url: buttonUrl
            });
        }
    });
});
</script>
