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
        
        <!-- Hardcoded Hero Logo -->
        <div class="hero-logo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/the-westin-logo.png" 
                 alt="The Westin Logo">
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
    
    // Add loading class and fade in effect
    $('.hero-section').addClass('loading');
    
    // Remove loading class once images are loaded
    $(window).on('load', function() {
        $('.hero-section').removeClass('loading');
    });
});
</script>
