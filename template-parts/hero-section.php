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
$hero_logo_id = get_theme_mod('nirup_hero_logo');
$hero_cta_text = get_theme_mod('nirup_hero_cta_text', __('Book Your Stay', 'nirup-island'));
$hero_cta_link = get_theme_mod('nirup_hero_cta_link', '');
$hero_layer1_id = get_theme_mod('nirup_hero_layer1_image');
$hero_layer2_id = get_theme_mod('nirup_hero_layer2_image');
$hero_layer3_id = get_theme_mod('nirup_hero_layer3_image');

// Get image URLs
$hero_bg_url = $hero_bg_image_id ? wp_get_attachment_image_url($hero_bg_image_id, 'full') : '';
$hero_pattern_url = $hero_pattern_image_id ? wp_get_attachment_image_url($hero_pattern_image_id, 'full') : '';
$hero_logo_url = $hero_logo_id ? wp_get_attachment_image_url($hero_logo_id, 'full') : '';
$hero_layer1_url = $hero_layer1_id ? wp_get_attachment_image_url($hero_layer1_id, 'full') : '';
$hero_layer2_url = $hero_layer2_id ? wp_get_attachment_image_url($hero_layer2_id, 'full') : '';
$hero_layer3_url = $hero_layer3_id ? wp_get_attachment_image_url($hero_layer3_id, 'full') : '';

// Build inline styles
$inline_styles = '';
if ($hero_bg_url) {
    $inline_styles .= '.hero-main-bg { background-image: url(' . esc_url($hero_bg_url) . '); }';
}
if ($hero_pattern_url) {
    $inline_styles .= '.hero-pattern-bg { background-image: url(' . esc_url($hero_pattern_url) . '); }';
}
if ($hero_logo_url) {
    $inline_styles .= '.hero-logo { background-image: url(' . esc_url($hero_logo_url) . '); }';
}
if ($hero_layer1_url) {
    $inline_styles .= '.hero-layer-1 { background-image: url(' . esc_url($hero_layer1_url) . '); }';
}
if ($hero_layer2_url) {
    $inline_styles .= '.hero-layer-2 { background-image: url(' . esc_url($hero_layer2_url) . '); }';
}
if ($hero_layer3_url) {
    $inline_styles .= '.hero-layer-3 { background-image: url(' . esc_url($hero_layer3_url) . '); }';
}

// Add inline styles if we have any
if ($inline_styles) {
    wp_add_inline_style('nirup-hero', $inline_styles);
}
?>

<section class="hero-section" id="hero">
    <?php if ($hero_layer1_url || $hero_layer2_url || $hero_layer3_url): ?>
    <!-- Layered Backgrounds -->
    <div class="hero-layered-bg">
        <?php if ($hero_layer1_url): ?>
        <div class="hero-layer hero-layer-1"></div>
        <?php endif; ?>
        
        <?php if ($hero_layer2_url): ?>
        <div class="hero-layer hero-layer-2"></div>
        <?php endif; ?>
        
        <?php if ($hero_layer3_url): ?>
        <div class="hero-layer hero-layer-3"></div>
        <?php endif; ?>
        
        <!-- Overlay for layered effect -->
        <div class="hero-layer" style="
            position: absolute;
            top: 720px;
            left: 50%;
            transform: translateX(-50%);
            width: 1400px;
            height: 780px;
            background: rgba(41, 26, 26, 0.08);
            mask-image: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 1400 780&quot;><ellipse cx=&quot;700&quot; cy=&quot;390&quot; rx=&quot;700&quot; ry=&quot;390&quot; fill=&quot;black&quot;/></svg>');
            mask-size: 1400px 780px;
            mask-position: 0px;
            mask-repeat: no-repeat;
        "></div>
    </div>
    <?php endif; ?>
    
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
        
        <?php if ($hero_logo_url): ?>
        <!-- Hero Logo -->
        <div class="hero-logo" role="img" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>"></div>
        <?php endif; ?>
        
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