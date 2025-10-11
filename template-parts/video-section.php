<?php
/**
 * Video Section Template
 * File: template-parts/video-section.php
 */

// Get customizer values
$video_show = get_theme_mod('nirup_video_show', true);
$video_source_type = get_theme_mod('nirup_video_source_type', 'youtube');
$video_url = get_theme_mod('nirup_video_url', '');
$video_upload_id = get_theme_mod('nirup_video_upload', '');
$video_autoplay = get_theme_mod('nirup_video_autoplay', false);
$video_loop = get_theme_mod('nirup_video_loop', false);

// Only show section if enabled
if (!$video_show) {
    return;
}

// Check if we have a video source
$has_video = false;
$embed_url = '';
$upload_url = '';

if ($video_source_type === 'youtube' && !empty($video_url)) {
    $embed_url = nirup_get_youtube_embed_url($video_url, $video_autoplay, $video_loop);
    $has_video = !empty($embed_url);
} elseif ($video_source_type === 'upload' && !empty($video_upload_id)) {
    $upload_url = wp_get_attachment_url($video_upload_id);
    $has_video = !empty($upload_url);
}

if (!$has_video) {
    return;
}

$video_title = get_theme_mod('nirup_video_title', 'Nirup Island Video');
?>

<section class="video-section" id="video">
    <div class="video-container">
        <div class="video-wrapper">
            <?php if ($video_source_type === 'youtube' && $embed_url) : ?>
                <!-- YouTube Video -->
                <iframe 
                    src="<?php echo esc_url($embed_url); ?>" 
                    title="<?php echo esc_attr($video_title); ?>"
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen
                    loading="lazy">
                </iframe>
            <?php elseif ($video_source_type === 'upload' && $upload_url) : ?>
                <!-- Uploaded Video -->
                <video 
                    <?php echo $video_autoplay ? 'autoplay muted' : 'controls'; ?>
                    <?php echo $video_loop ? 'loop' : ''; ?>
                    <?php echo !$video_autoplay ? 'controls' : 'controls'; ?>
                    preload="<?php echo $video_autoplay ? 'auto' : 'metadata'; ?>"
                    playsinline
                    title="<?php echo esc_attr($video_title); ?>"
                    class="uploaded-video">
                    <source src="<?php echo esc_url($upload_url); ?>" type="video/mp4">
                    <?php _e('Your browser does not support the video tag.', 'nirup-island'); ?>
                </video>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    <?php if ($video_source_type === 'youtube') : ?>
    // YouTube video tracking
    $('.video-section iframe').on('load', function() {
        if (typeof gtag !== 'undefined') {
            gtag('event', 'video_loaded', {
                event_category: 'video',
                event_label: 'youtube_embed',
                autoplay: <?php echo $video_autoplay ? 'true' : 'false'; ?>
            });
        }
        
        if (typeof clarity !== 'undefined') {
            clarity('event', 'video_section_loaded');
        }
    });
    <?php else : ?>
    // Uploaded video tracking
    var videoElement = $('.uploaded-video')[0];
    
    if (videoElement) {
        videoElement.addEventListener('play', function() {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'video_play', {
                    event_category: 'video',
                    event_label: 'uploaded_video',
                    autoplay: <?php echo $video_autoplay ? 'true' : 'false'; ?>
                });
            }
            
            if (typeof clarity !== 'undefined') {
                clarity('event', 'uploaded_video_play');
            }
        });
        
        // Respect user's motion preferences
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            <?php if ($video_autoplay) : ?>
            videoElement.pause();
            <?php endif; ?>
        }
    }
    <?php endif; ?>
    
    // Track when video section comes into view
    if ('IntersectionObserver' in window) {
        const videoObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'video_section_viewed', {
                            event_category: 'engagement',
                            event_label: 'video_section'
                        });
                    }
                    
                    if (typeof clarity !== 'undefined') {
                        clarity('event', 'video_section_viewed');
                    }
                    
                    videoObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });
        
        const videoSection = document.querySelector('.video-section');
        if (videoSection) {
            videoObserver.observe(videoSection);
        }
    }
});
</script>