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
$hero_video_id = get_theme_mod('nirup_hero_video_id');
$show_video = get_theme_mod('nirup_hero_show_video', true);
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
    
    <?php if ($show_video && $hero_video_id): ?>
    <!-- Video Play Button -->
    <button class="hero-video-button" 
            aria-label="<?php esc_attr_e('Play video', 'nirup-island'); ?>"
            data-video-id="<?php echo esc_attr($hero_video_id); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="5,3 19,12 5,21"></polygon>
        </svg>
    </button>
    <?php endif; ?>
</section>

<?php if ($show_video && $hero_video_id): ?>
<!-- Video Modal -->
<div class="video-modal" id="video-modal">
    <div class="video-modal-content">
        <button class="video-modal-close" aria-label="<?php esc_attr_e('Close video', 'nirup-island'); ?>">&times;</button>
        <iframe id="hero-video-iframe" 
                src="" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
        </iframe>
    </div>
</div>
<?php endif; ?>

<script>
jQuery(document).ready(function($) {
    <?php if ($show_video && $hero_video_id): ?>
    // Video modal functionality
    $('.hero-video-button').on('click', function() {
        var videoId = $(this).data('video-id');
        var embedUrl = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0&showinfo=0';
        
        $('#hero-video-iframe').attr('src', embedUrl);
        $('#video-modal').addClass('active');
        $('body').addClass('modal-open');
        
        // Analytics tracking
        if (typeof gtag !== 'undefined') {
            gtag('event', 'video_play', {
                video_title: 'Hero Video',
                video_url: embedUrl
            });
        }
        
        // Microsoft Clarity tracking
        if (typeof clarity !== 'undefined') {
            clarity('event', 'hero_video_play', {
                video_id: videoId
            });
        }
    });
    
    // Close video modal
    $('.video-modal-close, .video-modal').on('click', function(e) {
        if (e.target === this) {
            $('#video-modal').removeClass('active');
            $('#hero-video-iframe').attr('src', '');
            $('body').removeClass('modal-open');
        }
    });
    
    // Close video modal with Escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('#video-modal').hasClass('active')) {
            $('#video-modal').removeClass('active');
            $('#hero-video-iframe').attr('src', '');
            $('body').removeClass('modal-open');
        }
    });
    <?php endif; ?>
    
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