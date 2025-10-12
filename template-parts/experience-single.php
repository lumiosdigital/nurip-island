<?php
/**
 * Template part for single experience layout (magazine style)
 * Based on Figma design node 1035-299
 * Used when experience type is "single"
 */

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
$single_subtitle = get_post_meta(get_the_ID(), '_detailed_subtitle', true);
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

<div class="single-category-wrapper" style="background: #f3eeea; position: relative;">
    
    <!-- Hero Section -->
    <section class="single-hero-section">
        <div class="single-hero-container">
            <div class="single-hero-content">
                <h1 class="single-hero-title"><?php the_title(); ?></h1>
                
                <?php if (!empty($single_subtitle)) : ?>
                    <p class="single-hero-subtitle"><?php echo esc_html($single_subtitle); ?></p>
                <?php elseif (has_excerpt()) : ?>
                    <p class="single-hero-subtitle"><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- Nature Tag Section -->
    <?php if ($show_nature_section) : ?>
    <section class="single-nature-tag-section">
        <div class="single-nature-tag-container">
            <div class="single-nature-tag-flex">
                <span class="single-nature-tag-text"><?php echo esc_html($nature_section_text); ?></span>
                <div class="single-nature-tag-line"></div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Gallery/Images Section -->
    <section class="single-gallery-section">
        <div class="single-gallery-container">
            <div class="single-gallery-grid">
                <!-- Left large image -->
                <div class="single-gallery-large">
                    <?php if (!empty($gallery_images[0]['url'])) : ?>
                        <img src="<?php echo esc_url($gallery_images[0]['url']); ?>" 
                             alt="<?php echo esc_attr($gallery_images[0]['alt']); ?>" />
                    <?php else : ?>
                        <div class="single-gallery-placeholder">No image uploaded</div>
                    <?php endif; ?>
                </div>
                
                <!-- Right small images grid -->
                <div class="single-gallery-small-grid">
                    <?php for ($i = 1; $i <= 3; $i++) : ?>
                        <div class="single-gallery-small">
                            <?php if (!empty($gallery_images[$i]['url'])) : ?>
                                <img src="<?php echo esc_url($gallery_images[$i]['url']); ?>" 
                                     alt="<?php echo esc_attr($gallery_images[$i]['alt']); ?>" />
                            <?php else : ?>
                                <div class="single-gallery-placeholder">No image uploaded</div>
                            <?php endif; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </section>



    <!-- Main Content Section with Quote -->
    <section class="single-main-content-section">
        <div class="single-main-content-container">
            <!-- Quote Column -->
            <div class="single-quote-column">
                <?php if (!empty($quote_title) || !empty($quote_text)) : ?>
                    <?php if (!empty($quote_title)) : ?>
                        <p class="single-quote-column-title"><?php echo esc_html($quote_title); ?></p>
                    <?php else : ?>
                        <p class="single-quote-column-title">ISLAND WISDOM</p>
                    <?php endif; ?>
                    
                    <?php if (!empty($quote_text)) : ?>
                        <p class="single-quote-column-text">"<?php echo esc_html($quote_text); ?>"</p>
                    <?php else : ?>
                        <p class="single-quote-column-text">"The sea whispers secrets only travelers can hear."</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            
            <!-- Content Columns -->
            <div class="single-content-columns">
                <?php
                // Get and process the post content
                $content = get_the_content();
                $content = apply_filters('the_content', $content);
                
                // Remove empty paragraphs and clean content
                $content = preg_replace('/<p>\s*<\/p>/', '', $content);
                $content = preg_replace('/<p>\s*&nbsp;\s*<\/p>/', '', $content);
                
                // Split content into paragraphs
                $paragraphs = explode('</p>', $content);
                $clean_paragraphs = array();
                
                foreach ($paragraphs as $paragraph) {
                    $paragraph = trim($paragraph);
                    if (!empty($paragraph) && $paragraph !== '<p>') {
                        $paragraph = str_replace('<p>', '', $paragraph);
                        $paragraph = trim($paragraph);
                        if (!empty($paragraph)) {
                            $clean_paragraphs[] = $paragraph;
                        }
                    }
                }
                
                $total_paragraphs = count($clean_paragraphs);
                $middle_count = ceil($total_paragraphs / 2);
                ?>
                
                <!-- Left Content Column -->
                <div class="single-content-column-left">
                    <?php 
                    // Display first half of paragraphs
                    if ($total_paragraphs > 0) {
                        for ($i = 0; $i < $middle_count; $i++) {
                            if (isset($clean_paragraphs[$i])) {
                                echo '<p class="single-content-text">' . wp_kses_post($clean_paragraphs[$i]) . '</p>';
                            }
                        }
                    }
                    ?>
                </div>
                
                <!-- Right Content Column -->
                <div class="single-content-column-right">
                    <?php 
                    // Display remaining paragraphs
                    if ($total_paragraphs > 0) {
                        for ($i = $middle_count; $i < $total_paragraphs; $i++) {
                            if (isset($clean_paragraphs[$i])) {
                                echo '<p class="single-content-text">' . wp_kses_post($clean_paragraphs[$i]) . '</p>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Region Separator -->
    <?php if ($show_region_section) : ?>
    <section class="single-section-separator">
        <div class="single-section-separator-flex">
            <span class="single-section-separator-text"><?php echo esc_html($region_section_text); ?></span>
            <div class="single-section-separator-line"></div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Additional Content Section - EXACT copy from detailed template -->
    <?php if ($show_additional_section) : ?>
    <section class="single-additional-section">
        <div class="single-additional-grid">
            <?php 
            // Get additional images
            $additional_image_data = array();
            if ($additional_images && is_array($additional_images)) {
                foreach ($additional_images as $image_id) {
                    $image_data = wp_get_attachment_image_src($image_id, 'master');
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
            <div class="single-additional-left">
                <!-- Top: Large Image -->
                <div class="single-additional-large-image">
                    <?php if (!empty($additional_image_data[0]['url'])) : ?>
                        <img src="<?php echo esc_url($additional_image_data[0]['url']); ?>" 
                             alt="<?php echo esc_attr($additional_image_data[0]['alt']); ?>" />
                    <?php else : ?>
                        <div class="single-gallery-placeholder" style="height: 100%;"></div>
                    <?php endif; ?>
                </div>
                
                <!-- Bottom Row: Quote + Small Image -->
                <div class="single-additional-bottom">
                    <!-- Quote Section -->
                    <div class="single-additional-quote">
                        <?php if (!empty($additional_quote_title)) : ?>
                            <p class="single-additional-quote-title"><?php echo esc_html($additional_quote_title); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($additional_quote_text)) : ?>
                            <p class="single-additional-quote-text">"<?php echo esc_html($additional_quote_text); ?>"</p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Small Image -->
                    <div class="single-additional-image-small">
                        <?php if (!empty($additional_image_data[1]['url'])) : ?>
                            <img src="<?php echo esc_url($additional_image_data[1]['url']); ?>" 
                                 alt="<?php echo esc_attr($additional_image_data[1]['alt']); ?>" />
                        <?php else : ?>
                            <div class="single-gallery-placeholder" style="height: 100%;"></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Right Side: Content Only -->
            <div class="single-additional-right">
                <div class="single-additional-content">
                    <?php 
                    // Only display content if additional_content is provided and not empty
                    if (!empty($additional_content)) {
                        $content_to_display = apply_filters('the_content', $additional_content);
                        
                        if (!empty(strip_tags($content_to_display))) {
                            // Extract paragraphs
                            preg_match_all('/<p[^>]*>(.*?)<\/p>/s', $content_to_display, $matches);
                            $paragraphs = $matches[1];
                            
                            // Clean and display paragraphs
                            foreach ($paragraphs as $paragraph) {
                                $paragraph = trim($paragraph);
                                if (!empty($paragraph) && $paragraph !== '&nbsp;') {
                                    echo '<p class="single-content-text">' . wp_kses_post($paragraph) . '</p>';
                                }
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Call to Action Section -->
    <section class="single-cta-section">
        <div class="single-cta-container">
            <!-- Top Separator Line -->
            <div class="single-cta-separator-top"></div>
            
            <div class="single-cta-content">
                <?php 
                // Get CTA fields with defaults
                $cta_title = get_post_meta(get_the_ID(), '_cta_title', true);
                $cta_subtitle = get_post_meta(get_the_ID(), '_cta_subtitle', true);
                $cta_primary_button = get_post_meta(get_the_ID(), '_cta_primary_button', true);
                $cta_secondary_button = get_post_meta(get_the_ID(), '_cta_secondary_button', true);
                $cta_pdf_file = get_post_meta(get_the_ID(), '_cta_pdf_file', true);
                
                // Set defaults if fields are empty
                if (empty($cta_title)) {
                    $cta_title = 'Book your ' . strtolower(get_the_title());
                }
                if (empty($cta_subtitle)) {
                    $cta_subtitle = 'Make your journey unforgettable — reserve your experience in advance';
                }
                if (empty($cta_primary_button)) {
                    $cta_primary_button = 'BOOK NOW';
                }
                if (empty($cta_secondary_button)) {
                    $cta_secondary_button = 'DOWNLOAD OUR MAP';
                }
                
                // Get PDF file details
                $pdf_url = '';
                $pdf_filename = '';
                if ($cta_pdf_file) {
                    $pdf_url = wp_get_attachment_url($cta_pdf_file);
                    $pdf_filename = basename(get_attached_file($cta_pdf_file));
                }
                
                // Check if this experience has a booking calendar configured
                $calendar_id = get_post_meta(get_the_ID(), '_experience_booking_calendar_id', true);
                ?>
                
                <h2 class="single-cta-title"><?php echo esc_html($cta_title); ?></h2>
                <p class="single-cta-subtitle"><?php echo esc_html($cta_subtitle); ?></p>
            </div>
            
            <div class="single-cta-buttons-container">
                <!-- Secondary Button (Download PDF or disabled if no PDF) -->
                <?php if ($pdf_url) : ?>
                    <a href="<?php echo esc_url($pdf_url); ?>" 
                       class="single-cta-button-secondary" 
                       download="<?php echo esc_attr($pdf_filename); ?>"
                       title="Download <?php echo esc_attr($pdf_filename); ?>">
                        <?php echo esc_html($cta_secondary_button); ?>
                    </a>
                <?php else : ?>
                    <span class="single-cta-button-secondary single-cta-button-disabled" 
                          title="PDF not available">
                        <?php echo esc_html($cta_secondary_button); ?>
                    </span>
                <?php endif; ?>
                
                <!-- Primary Button (Gold background) - UPDATED TO USE MODAL -->
                <?php if ($calendar_id) : ?>
                    <button class="single-cta-button-primary experience-book-btn" 
                            data-experience-id="<?php echo get_the_ID(); ?>">
                        <?php echo esc_html($cta_primary_button); ?>
                    </button>
                <?php else : ?>
                    <a href="#contact" class="single-cta-button-primary">
                        <?php echo esc_html($cta_primary_button); ?>
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Bottom Separator Line -->
            <div class="single-cta-separator-bottom"></div>
        </div>
    </section>

</div>