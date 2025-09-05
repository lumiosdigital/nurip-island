<?php
/**
 * Video Section Template
 * File: template-parts/video-section.php
 */

// Get customizer values
$video_url = get_theme_mod('nirup_video_url', '');
$video_show = get_theme_mod('nirup_video_show', true);

// Only show section if enabled and video URL is provided
if (!$video_show || empty($video_url)) {
    return;
}

// Convert YouTube URL to embed format
$embed_url = nirup_get_youtube_embed_url($video_url);

if (!$embed_url) {
    return; // Invalid YouTube URL
}
?>

<section class="video-section" id="video">
    <div class="video-container">
        <div class="video-wrapper">
            <iframe 
                src="<?php echo esc_url($embed_url); ?>" 
                title="<?php echo esc_attr(get_theme_mod('nirup_video_title', 'Nirup Island Video')); ?>"
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen
                loading="lazy">
            </iframe>
        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    // Track video section interaction
    $('.video-section iframe').on('load', function() {
        // Track video load
        if (typeof gtag !== 'undefined') {
            gtag('event', 'video_loaded', {
                event_category: 'video',
                event_label: 'youtube_embed'
            });
        }
        
        // Microsoft Clarity tracking
        if (typeof clarity !== 'undefined') {
            clarity('event', 'video_section_loaded');
        }
    });
    
    // Track when video section comes into view
    if ('IntersectionObserver' in window) {
        const videoObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    // Track video section view
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'video_section_viewed', {
                            event_category: 'engagement',
                            event_label: 'video_section'
                        });
                    }
                    
                    if (typeof clarity !== 'undefined') {
                        clarity('event', 'video_section_viewed');
                    }
                    
                    // Stop observing after first view
                    videoObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5 // Trigger when 50% of section is visible
        });
        
        const videoSection = document.querySelector('.video-section');
        if (videoSection) {
            videoObserver.observe(videoSection);
        }
    }
});
</script>