<?php
/**
 * Template part for detailed category experience layout (magazine style)
 * Based on Figma design with dynamic WordPress content and gallery support
 */

// Get child experiences for recommendations section
$child_experiences = new WP_Query(array(
    'post_type' => 'experience',
    'posts_per_page' => 4, // Limit to 4 for the recommendations section
    'post_status' => 'publish',
    'post_parent' => get_the_ID(),
    'orderby' => 'menu_order',
    'order' => 'ASC'
));

// Get hero banner gallery images
$hero_gallery = get_post_meta(get_the_ID(), '_hero_banner_gallery', true);
$gallery_images = array();

if ($hero_gallery && is_array($hero_gallery)) {
    foreach ($hero_gallery as $image_id) {
        $image_data = wp_get_attachment_image_src($image_id, 'full');
        if ($image_data) {
            $gallery_images[] = array(
                'id' => $image_id,
                'url' => $image_data[0],
                'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true)
            );
        }
    }
}

// No fallback images - just use empty placeholders if no gallery is set
while (count($gallery_images) < 4) {
    $gallery_images[] = array(
        'id' => 0,
        'url' => '',
        'alt' => 'No image uploaded'
    );
}

// Get customizable content
$detailed_subtitle = get_post_meta(get_the_ID(), '_detailed_subtitle', true);
$quote_title = get_post_meta(get_the_ID(), '_quote_title', true);
$quote_text = get_post_meta(get_the_ID(), '_quote_text', true);
$show_nature_section = get_post_meta(get_the_ID(), '_show_nature_section', true);
$nature_section_text = get_post_meta(get_the_ID(), '_nature_section_text', true);
$show_region_section = get_post_meta(get_the_ID(), '_show_region_section', true);
$region_section_text = get_post_meta(get_the_ID(), '_region_section_text', true);

// Additional content section
$show_additional_section = get_post_meta(get_the_ID(), '_show_additional_section', true);
$additional_images = get_post_meta(get_the_ID(), '_additional_section_images', true);
$additional_quote_title = get_post_meta(get_the_ID(), '_additional_quote_title', true);
$additional_quote_text = get_post_meta(get_the_ID(), '_additional_quote_text', true);
$additional_content = get_post_meta(get_the_ID(), '_additional_content', true);

// Set defaults
if (empty($nature_section_text)) {
    $nature_section_text = 'NATURE';
}
if (empty($region_section_text)) {
    $region_section_text = 'REGION';
}
?>

<div class="detailed-category-wrapper">
    
    <!-- Hero Section -->
    <section class="detailed-hero-section">
        <div class="detailed-hero-container">
            <!-- Title and Subtitle -->
            <div class="detailed-hero-content">
                <h1 class="detailed-hero-title"><?php the_title(); ?></h1>
                
                <?php if (!empty($detailed_subtitle)) : ?>
                    <p class="detailed-hero-subtitle"><?php echo esc_html($detailed_subtitle); ?></p>
                <?php elseif (has_excerpt()) : ?>
                    <p class="detailed-hero-subtitle"><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php endif; ?>
            </div>   

            <!-- Category Tag (Nature Section) -->
            <?php if ($show_nature_section) : ?>
            <div class="detailed-category-tag">
                <div class="detailed-category-tag-flex">
                    <span class="detailed-category-tag-text"><?php echo esc_html($nature_section_text); ?></span>
                    <div class="detailed-category-tag-line"></div>
                </div>
            </div>
            <?php endif; ?>  
        </div>
    </section>
    
    <!-- Gallery/Images Section -->
    <section class="detailed-gallery-section">
        <div class="detailed-gallery-container">
            <div class="detailed-gallery-grid">
                <!-- Left large image -->
                <div class="detailed-gallery-large" data-image-index="0">
                    <?php if (!empty($gallery_images[0]['url'])) : ?>
                        <img src="<?php echo esc_url($gallery_images[0]['url']); ?>" 
                             alt="<?php echo esc_attr($gallery_images[0]['alt']); ?>" />
                    <?php else : ?>
                        <div class="detailed-gallery-placeholder"></div>
                    <?php endif; ?>
                </div>
                
                <!-- Right grid -->
                <div class="detailed-gallery-right">
                    <!-- Top right image -->
                    <div class="detailed-gallery-top" data-image-index="1">
                        <?php if (!empty($gallery_images[1]['url'])) : ?>
                            <img src="<?php echo esc_url($gallery_images[1]['url']); ?>" 
                                 alt="<?php echo esc_attr($gallery_images[1]['alt']); ?>" />
                        <?php else : ?>
                            <div class="detailed-gallery-placeholder"></div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Bottom grid -->
                    <div class="detailed-gallery-bottom">
                        <div class="detailed-gallery-small" data-image-index="2">
                            <?php if (!empty($gallery_images[2]['url'])) : ?>
                                <img src="<?php echo esc_url($gallery_images[2]['url']); ?>" 
                                     alt="<?php echo esc_attr($gallery_images[2]['alt']); ?>" />
                            <?php else : ?>
                                <div class="detailed-gallery-placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <div class="detailed-gallery-small" data-image-index="3">
                            <?php if (!empty($gallery_images[3]['url'])) : ?>
                                <img src="<?php echo esc_url($gallery_images[3]['url']); ?>" 
                                     alt="<?php echo esc_attr($gallery_images[3]['alt']); ?>" />
                            <?php else : ?>
                                <div class="detailed-gallery-placeholder"></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Content Section -->
    <?php 
    $content = get_the_content();
    $content = apply_filters('the_content', $content); // Apply WordPress content filters
    $content = trim($content);
    if (!empty(strip_tags($content))) : ?>
    <section class="detailed-content-section">
        <div class="detailed-content-grid">
            <!-- Left Quote -->
            <?php if (!empty($quote_title) || !empty($quote_text)) : ?>
            <div class="detailed-content-quote">
                <?php if (!empty($quote_title)) : ?>
                    <p class="detailed-content-quote-title"><?php echo esc_html($quote_title); ?></p>
                <?php endif; ?>
                <?php if (!empty($quote_text)) : ?>
                    <p class="detailed-content-quote-text">"<?php echo esc_html($quote_text); ?>"</p>
                <?php endif; ?>
            </div>
            <?php else : ?>
            <div class="detailed-content-quote">
                <!-- Empty quote section if no custom quote is set -->
            </div>
            <?php endif; ?>
            
            <!-- Middle Content -->
            <div class="detailed-content-column">
                <?php 
                // Extract paragraphs while preserving their structure
                preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $content, $matches);
                $paragraphs = $matches[1]; // Get the content inside <p> tags
                
                if (empty($paragraphs)) {
                    // Fallback: if no <p> tags found, split by double line breaks
                    $content_clean = strip_tags($content);
                    $paragraphs = explode("\n\n", $content_clean);
                    $paragraphs = array_filter(array_map('trim', $paragraphs));
                }
                
                // Clean up paragraphs and remove empty ones
                $clean_paragraphs = array();
                foreach ($paragraphs as $p) {
                    $cleaned = trim(strip_tags($p));
                    if (!empty($cleaned)) {
                        $clean_paragraphs[] = $p;
                    }
                }
                
                // Display first half of paragraphs in middle column
                $total_paragraphs = count($clean_paragraphs);
                if ($total_paragraphs > 0) {
                    $middle_count = ceil($total_paragraphs / 2);
                    
                    for ($i = 0; $i < $middle_count; $i++) {
                        if (isset($clean_paragraphs[$i])) {
                            echo '<p class="detailed-content-text">' . wp_kses_post($clean_paragraphs[$i]) . '</p>';
                        }
                    }
                }
                ?>
            </div>
            
            <!-- Right Content -->
            <div class="detailed-content-column">
                <?php 
                // Display remaining paragraphs in right column
                if ($total_paragraphs > 0) {
                    for ($i = $middle_count; $i < $total_paragraphs; $i++) {
                        if (isset($clean_paragraphs[$i])) {
                            echo '<p class="detailed-content-text">' . wp_kses_post($clean_paragraphs[$i]) . '</p>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </section>
    
    <!-- Region Separator -->
    <?php if ($show_region_section) : ?>
    <section class="detailed-section-separator">
        <div class="detailed-section-separator-flex">
            <span class="detailed-section-separator-text"><?php echo esc_html($region_section_text); ?></span>
            <div class="detailed-section-separator-line"></div>
        </div>
    </section>
    <?php endif; ?>
    <?php endif; ?>
    
    <!-- Additional Content Section -->
    <?php if ($show_additional_section) : ?>
    <section class="detailed-additional-section">
        <div class="detailed-additional-grid">
            <?php 
            // Get additional images
            $additional_image_data = array();
            if ($additional_images && is_array($additional_images)) {
                foreach ($additional_images as $image_id) {
                    $image_data = wp_get_attachment_image_src($image_id, 'full');
                    if ($image_data) {
                        $additional_image_data[] = array(
                            'id' => $image_id,
                            'url' => $image_data[0],
                            'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true)
                        );
                    }
                }
            }
            
            // Ensure we have 2 slots (with placeholders if needed)
            while (count($additional_image_data) < 2) {
                $additional_image_data[] = array(
                    'id' => 0,
                    'url' => '',
                    'alt' => 'No image uploaded'
                );
            }
            ?>
            
            <!-- Left Side: Nested Grid -->
            <div class="detailed-additional-left">
                <!-- Top: Large Image -->
                <div class="detailed-additional-large-image">
                    <?php if (!empty($additional_image_data[0]['url'])) : ?>
                        <img src="<?php echo esc_url($additional_image_data[0]['url']); ?>" 
                             alt="<?php echo esc_attr($additional_image_data[0]['alt']); ?>" />
                    <?php else : ?>
                        <div class="detailed-gallery-placeholder" style="height: 100%;"></div>
                    <?php endif; ?>
                </div>
                
                <!-- Bottom Row: Quote + Small Image -->
                <div class="detailed-additional-bottom">
                    <!-- Quote Section -->
                    <div class="detailed-additional-quote">
                        <?php if (!empty($additional_quote_title)) : ?>
                            <p class="detailed-additional-quote-title"><?php echo esc_html($additional_quote_title); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($additional_quote_text)) : ?>
                            <p class="detailed-additional-quote-text">"<?php echo esc_html($additional_quote_text); ?>"</p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Small Image -->
                    <div class="detailed-additional-image-small">
                        <?php if (!empty($additional_image_data[1]['url'])) : ?>
                            <img src="<?php echo esc_url($additional_image_data[1]['url']); ?>" 
                                 alt="<?php echo esc_attr($additional_image_data[1]['alt']); ?>" />
                        <?php else : ?>
                            <div class="detailed-gallery-placeholder" style="height: 100%;"></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Right Side: Content Only -->
            <div class="detailed-additional-right">
                <div class="detailed-additional-content">
                    <?php 
                    // Use additional content if provided, otherwise continue from main content
                    if (!empty($additional_content)) {
                        $content_to_display = apply_filters('the_content', $additional_content);
                    } else {
                        // Use main content as continuation
                        $main_content = get_the_content();
                        $main_content = apply_filters('the_content', $main_content);
                        $content_to_display = $main_content;
                    }
                    
                    if (!empty(strip_tags($content_to_display))) {
                        // Extract paragraphs
                        preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $content_to_display, $matches);
                        $paragraphs = $matches[1];
                        
                        if (empty($paragraphs)) {
                            $content_clean = strip_tags($content_to_display);
                            $paragraphs = explode("\n\n", $content_clean);
                            $paragraphs = array_filter(array_map('trim', $paragraphs));
                        }
                        
                        // Display paragraphs
                        foreach ($paragraphs as $paragraph) {
                            $cleaned = trim(strip_tags($paragraph));
                            if (!empty($cleaned)) {
                                echo '<p>' . wp_kses_post($paragraph) . '</p>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Recommendations Section -->
    <section class="detailed-recommendations-section">
        <h2 class="detailed-recommendations-title">Recommendations</h2>
        
        <?php if ($child_experiences->have_posts()) : ?>
            <div class="detailed-recommendations-grid">
                <?php while ($child_experiences->have_posts()) : $child_experiences->the_post(); ?>
                    <article class="detailed-recommendation-card">
                        <!-- Card Image -->
                        <div class="detailed-recommendation-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large'); ?>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="detailed-recommendation-content">
                            <?php $short_description = get_post_meta(get_the_ID(), '_experience_short_description', true); ?>
                            
                            <p class="detailed-recommendation-category">
                                <?php echo $short_description ? esc_html($short_description) : 'Unique experience'; ?>
                            </p>
                            
                            <h3 class="detailed-recommendation-title"><?php the_title(); ?></h3>
                            
                            <p class="detailed-recommendation-description">
                                <?php 
                                if (has_excerpt()) {
                                    echo esc_html(get_the_excerpt());
                                } else {
                                    echo esc_html(wp_trim_words(get_the_content(), 20, '...'));
                                }
                                ?>
                            </p>
                            
                            <a href="<?php the_permalink(); ?>" class="detailed-recommendation-link">
                                BOOK VIA WHATSAPP
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        
        <?php wp_reset_postdata(); ?>
    </section>
    
</div>