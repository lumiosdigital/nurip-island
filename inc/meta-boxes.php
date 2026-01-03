<?php
/**
 * Meta Boxes Registration and Handlers
 * 
 * This file contains all meta box related functions for custom post types and pages.
 * Includes registration, callback/render, and save functions for:
 * - Experiences
 * - Events & Offers  
 * - Restaurants
 * - Ferry Schedules
 * - Marina
 * - Private Charters
 * - Villas
 * - Media Coverage
 * - Selling Units
 * 
 * @package Nirup_Island
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * NEW: Add custom fields for experiences
 */
function add_experience_meta_boxes() {
    add_meta_box(
        'experience_details',
        'Experience Details',
        'experience_details_callback',
        'experience',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_experience_meta_boxes');

function experience_details_callback($post) {
    wp_nonce_field('save_experience_details', 'experience_details_nonce');
    
    $short_description = get_post_meta($post->ID, '_experience_short_description', true);
    $experience_type = get_post_meta($post->ID, '_experience_type', true);
    $category_template = get_post_meta($post->ID, '_category_template', true);
    $hero_gallery = get_post_meta($post->ID, '_hero_banner_gallery', true);
    $featured_in_carousel = get_post_meta($post->ID, '_featured_in_carousel', true);
    $featured_in_archive = get_post_meta($post->ID, '_featured_in_archive', true);
    
    // New detailed template fields
    $detailed_subtitle = get_post_meta($post->ID, '_detailed_subtitle', true);
    $quote_title = get_post_meta($post->ID, '_quote_title', true);
    $quote_text = get_post_meta($post->ID, '_quote_text', true);
    $show_nature_section = get_post_meta($post->ID, '_show_nature_section', true);
    $nature_section_text = get_post_meta($post->ID, '_nature_section_text', true);
    $show_region_section = get_post_meta($post->ID, '_show_region_section', true);
    $region_section_text = get_post_meta($post->ID, '_region_section_text', true);
    
    // Additional content section fields
    $show_additional_section = get_post_meta($post->ID, '_show_additional_section', true);
    $additional_images = get_post_meta($post->ID, '_additional_section_images', true);
    $additional_quote_title = get_post_meta($post->ID, '_additional_quote_title', true);
    $additional_quote_text = get_post_meta($post->ID, '_additional_quote_text', true);
    $additional_content = get_post_meta($post->ID, '_additional_content', true);

    $cta_title = get_post_meta($post->ID, '_cta_title', true);
    $cta_subtitle = get_post_meta($post->ID, '_cta_subtitle', true);
    $cta_primary_button = get_post_meta($post->ID, '_cta_primary_button', true);
    $cta_secondary_button = get_post_meta($post->ID, '_cta_secondary_button', true);
    $cta_pdf_file = get_post_meta($post->ID, '_cta_pdf_file', true);
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th>Display Options</th>';
    echo '<td>';
    echo '<label><input type="checkbox" name="featured_in_carousel" value="1"' . checked($featured_in_carousel, 1, false) . ' /> Display in Homepage Carousel</label><br>';
    echo '<label><input type="checkbox" name="featured_in_archive" value="1"' . checked($featured_in_archive, 1, false) . ' /> Display in Experiences Archive Page</label><br>';
    echo '<label><input type="checkbox" name="display_in_dining" value="1"' . checked(get_post_meta($post->ID, '_display_in_dining', true), 1, false) . ' /> Display in Dining Page</label>';
    echo '<p class="description">Choose where this experience should appear.</p>';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="experience_short_description">Short Description</label></th>';
    echo '<td><input type="text" id="experience_short_description" name="experience_short_description" value="' . esc_attr($short_description) . '" class="widefat" placeholder="e.g., Banana boat, flying donut, kayak, paddle boat" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="experience_type">Experience Type</label></th>';
    echo '<td>';
    echo '<select id="experience_type" name="experience_type" onchange="toggleCategoryFields()">';
    echo '<option value="single"' . selected($experience_type, 'single', false) . '>Single Experience</option>';
    echo '<option value="category"' . selected($experience_type, 'category', false) . '>Category (has sub-experiences)</option>';
    echo '</select>';
    echo '<p class="description">Choose "Category" if this experience contains multiple sub-experiences.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Category Template Selection Row
    echo '<tr id="category_template_row" style="' . ($experience_type !== 'category' ? 'display: none;' : '') . '">';
    echo '<th><label for="category_template">Category Template</label></th>';
    echo '<td>';
    echo '<select id="category_template" name="category_template" onchange="toggleDetailedFields()">';
    echo '<option value="listing"' . selected($category_template, 'listing', false) . '>Listing (Simple Grid)</option>';
    echo '<option value="detailed"' . selected($category_template, 'detailed', false) . '>Detailed (Magazine Style)</option>';
    echo '</select>';
    echo '<p class="description">Choose the layout style for category pages.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Hero Gallery Row - Show for both single experiences and detailed categories
    $show_detailed_fields = ($experience_type === 'single') || ($experience_type === 'category' && $category_template === 'detailed');
    echo '<tr id="hero_gallery_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Hero Banner Gallery</label></th>';
    echo '<td>';
    echo '<div class="hero-gallery-images">';
    
    if ($hero_gallery && is_array($hero_gallery)) {
        foreach ($hero_gallery as $index => $image_id) {
            $image_url = wp_get_attachment_image_src($image_id, 'thumbnail');
            if ($image_url) {
                echo '<div class="hero-gallery-item" data-id="' . $image_id . '">';
                echo '<img src="' . $image_url[0] . '" style="max-width: 100px; margin: 5px;">';
                echo '<button type="button" class="remove-hero-gallery-image button">Remove</button>';
                echo '<input type="hidden" name="hero_banner_gallery[' . $index . ']" value="' . $image_id . '">';
                echo '</div>';
            }
        }
    }
    
    echo '</div>';
    echo '<button type="button" id="add_hero_gallery_image" class="button">Add Gallery Images</button>';
    echo '<button type="button" id="clear_hero_gallery" class="button">Clear All</button>';
    echo '<p class="description">Upload 4 images for the hero banner gallery. Images will be arranged in a grid layout.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Detailed Subtitle
    echo '<tr id="detailed_subtitle_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label for="detailed_subtitle">Subtitle</label></th>';
    echo '<td><input type="text" id="detailed_subtitle" name="detailed_subtitle" value="' . esc_attr($detailed_subtitle) . '" class="widefat" placeholder="Subtitle text displayed below the main title" /></td>';
    echo '</tr>';
    
    // Quote Section
    echo '<tr id="quote_section_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Quote Section</label></th>';
    echo '<td>';
    echo '<input type="text" name="quote_title" value="' . esc_attr($quote_title) . '" placeholder="Quote Title" class="widefat" style="margin-bottom: 10px;" />';
    echo '<textarea name="quote_text" placeholder="Quote Text" class="widefat" rows="3">' . esc_textarea($quote_text) . '</textarea>';
    echo '<p class="description">Optional quote section displayed after the gallery.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Nature Section
    echo '<tr id="nature_section_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Nature Section</label></th>';
    echo '<td>';
    echo '<label><input type="checkbox" name="show_nature_section" value="1"' . checked($show_nature_section, 1, false) . ' /> Show Nature Section</label><br><br>';
    wp_editor($nature_section_text, 'nature_section_text', array(
        'textarea_name' => 'nature_section_text',
        'textarea_rows' => 5,
        'teeny' => true,
        'media_buttons' => false,
    ));
    echo '<p class="description">Content for the nature section. Check the box above to display this section.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Region Section
    echo '<tr id="region_section_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Region Section</label></th>';
    echo '<td>';
    echo '<label><input type="checkbox" name="show_region_section" value="1"' . checked($show_region_section, 1, false) . ' /> Show Region Section</label><br><br>';
    wp_editor($region_section_text, 'region_section_text', array(
        'textarea_name' => 'region_section_text',
        'textarea_rows' => 5,
        'teeny' => true,
        'media_buttons' => false,
    ));
    echo '<p class="description">Content for the region section. Check the box above to display this section.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Additional Section Toggle
    echo '<tr id="additional_section_toggle_row" style="' . (!$show_detailed_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Additional Content Section</label></th>';
    echo '<td>';
    echo '<label><input type="checkbox" name="show_additional_section" value="1"' . checked($show_additional_section, 1, false) . ' onchange="toggleAdditionalSectionFields()" /> Show Additional Content Section</label>';
    echo '<p class="description">Check this to enable the additional content section with images and text.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Additional Section Images
    echo '<tr id="additional_images_row" style="' . (!$show_detailed_fields || !$show_additional_section ? 'display: none;' : '') . '">';
    echo '<th><label>Additional Section Images</label></th>';
    echo '<td>';
    echo '<div class="additional-images">';
    
    if ($additional_images && is_array($additional_images)) {
        foreach ($additional_images as $index => $image_id) {
            $image_url = wp_get_attachment_image_src($image_id, 'thumbnail');
            if ($image_url) {
                echo '<div class="additional-image-item" data-id="' . $image_id . '">';
                echo '<img src="' . $image_url[0] . '" style="max-width: 100px; margin: 5px;">';
                echo '<button type="button" class="remove-additional-image button">Remove</button>';
                echo '<input type="hidden" name="additional_section_images[' . $index . ']" value="' . $image_id . '">';
                echo '</div>';
            }
        }
    }
    
    echo '</div>';
    echo '<button type="button" id="add_additional_images" class="button">Add Images</button>';
    echo '<button type="button" id="clear_additional_images" class="button">Clear All</button>';
    echo '<p class="description">Add images for the additional content section.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Additional Section Quote
    echo '<tr id="additional_quote_row" style="' . (!$show_detailed_fields || !$show_additional_section ? 'display: none;' : '') . '">';
    echo '<th><label>Additional Section Quote</label></th>';
    echo '<td>';
    echo '<input type="text" name="additional_quote_title" value="' . esc_attr($additional_quote_title) . '" placeholder="Quote Title" class="widefat" style="margin-bottom: 10px;" />';
    echo '<textarea name="additional_quote_text" placeholder="Quote Text" class="widefat" rows="3">' . esc_textarea($additional_quote_text) . '</textarea>';
    echo '<p class="description">Optional quote for the additional section.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Additional Content
    echo '<tr id="additional_content_row" style="' . (!$show_detailed_fields || !$show_additional_section ? 'display: none;' : '') . '">';
    echo '<th><label for="additional_content">Additional Content</label></th>';
    echo '<td>';
    wp_editor($additional_content, 'additional_content', array(
        'textarea_name' => 'additional_content',
        'textarea_rows' => 8,
        'teeny' => false,
        'media_buttons' => true,
    ));
    echo '<p class="description">Content for the additional section. If left empty, no content will be displayed in this section.</p>';
    echo '</td>';
    echo '</tr>';

 // CTA Section Fields - Show ONLY for single experiences
    $show_cta_fields = ($experience_type === 'single');
    echo '<tr id="cta_section_row" style="' . (!$show_cta_fields ? 'display: none;' : '') . '">';
    echo '<th><label>Call to Action Section</label></th>';
    echo '<td>';
    echo '<input type="text" name="cta_title" value="' . esc_attr($cta_title) . '" placeholder="e.g., Book your experience" class="widefat" style="margin-bottom: 10px;" />';
    echo '<p class="description" style="margin-bottom: 10px;">CTA Title (if empty, will use: Book your [experience title])</p>';
    echo '<input type="text" name="cta_subtitle" value="' . esc_attr($cta_subtitle) . '" placeholder="e.g., Make your journey unforgettable — reserve your experience in advance" class="widefat" style="margin-bottom: 10px;" />';
    echo '<p class="description" style="margin-bottom: 10px;">CTA Subtitle</p>';
    echo '<input type="text" name="cta_secondary_button" value="' . esc_attr($cta_secondary_button) . '" placeholder="e.g., Download Our Map" class="widefat" style="margin-bottom: 10px;" />';
    echo '<p class="description" style="margin-bottom: 10px;">Secondary Button Text (transparent with gold border)</p>';
    
    // PDF Upload Field
    echo '<div id="cta_pdf_upload_container" style="margin-bottom: 15px;">';
    echo '<label style="display: block; margin-bottom: 5px; font-weight: bold;">PDF File for Download Button:</label>';
    
    if ($cta_pdf_file) {
        $pdf_url = wp_get_attachment_url($cta_pdf_file);
        $pdf_filename = basename(get_attached_file($cta_pdf_file));
        echo '<div id="current_pdf_display" style="background: #f1f1f1; padding: 10px; border-radius: 3px; margin-bottom: 10px;">';
        echo '<strong>Current PDF:</strong> <a href="' . esc_url($pdf_url) . '" target="_blank">' . esc_html($pdf_filename) . '</a>';
        echo ' <button type="button" id="remove_pdf_btn" class="button" style="margin-left: 10px;">Remove PDF</button>';
        echo '</div>';
    }
    
    echo '<button type="button" id="upload_pdf_btn" class="button">' . ($cta_pdf_file ? 'Change PDF' : 'Upload PDF') . '</button>';
    echo '<input type="hidden" id="cta_pdf_file" name="cta_pdf_file" value="' . esc_attr($cta_pdf_file) . '" />';
    echo '<p class="description">Upload a PDF file that will be downloaded when users click the secondary button.</p>';
    echo '</div>';
    
    echo '<input type="text" name="cta_primary_button" value="' . esc_attr($cta_primary_button) . '" placeholder="e.g., Book Now" class="widefat" style="margin-bottom: 10px;" />';
    echo '<p class="description">Primary Button Text (gold background)</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '</table>';
    
    // Add JavaScript for gallery management and field toggling
       ?>
    <script>
    jQuery(document).ready(function($) {
        
        // ===== HERO GALLERY UPLOADER =====
        var heroGalleryUploader;
        
        $('#add_hero_gallery_image').on('click', function(e) {
            e.preventDefault();
            
            if (heroGalleryUploader) {
                heroGalleryUploader.open();
                return;
            }
            
            heroGalleryUploader = wp.media({
                title: 'Select Images for Hero Gallery',
                button: {
                    text: 'Add to Gallery'
                },
                multiple: true,
                library: {
                    type: 'image'
                }
            });
            
            heroGalleryUploader.on('select', function() {
                var attachments = heroGalleryUploader.state().get('selection').toJSON();
                var currentCount = $('.hero-gallery-item').length;
                var maxImages = 4;
                var availableSlots = maxImages - currentCount;
                
                if (availableSlots <= 0) {
                    alert('Maximum of 4 images allowed for hero banner gallery. Please remove some images first.');
                    return;
                }
                
                // Add selected images (up to available slots)
                attachments.slice(0, availableSlots).forEach(function(attachment, index) {
                    var imageIndex = currentCount + index;
                    var imageHtml = '<div class="hero-gallery-item" data-id="' + attachment.id + '" style="position: relative; display: inline-block; margin: 5px;">';
                    imageHtml += '<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" style="max-width: 100px; height: 80px; object-fit: cover; border: 2px solid #ddd;" />';
                    imageHtml += '<button type="button" class="remove-hero-gallery-image button" style="position: absolute; top: -5px; right: -5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1; padding: 0;">×</button>';
                    imageHtml += '<input type="hidden" name="hero_banner_gallery[' + imageIndex + ']" value="' + attachment.id + '">';
                    imageHtml += '</div>';
                    
                    $('.hero-gallery-images').append(imageHtml);
                });
                
                if (attachments.length > availableSlots) {
                    alert('Only ' + availableSlots + ' images were added. Maximum of 4 images total allowed for hero gallery.');
                }
            });
            
            heroGalleryUploader.open();
        });
        
        // Remove hero gallery image
        $(document).on('click', '.remove-hero-gallery-image', function(e) {
            e.preventDefault();
            $(this).closest('.hero-gallery-item').remove();
            
            // Reindex the remaining images
            $('.hero-gallery-item').each(function(index) {
                $(this).find('input[type="hidden"]').attr('name', 'hero_banner_gallery[' + index + ']');
            });
        });
        
        // Clear all hero gallery images
        $('#clear_hero_gallery').on('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to clear all gallery images?')) {
                $('.hero-gallery-images').empty();
            }
        });
        
        // ===== ADDITIONAL SECTION IMAGES UPLOADER =====
        var additionalMediaUploader;
        
        $('#add_additional_images').on('click', function(e) {
            e.preventDefault();
            
            if (additionalMediaUploader) {
                additionalMediaUploader.open();
                return;
            }
            
            additionalMediaUploader = wp.media({
                title: 'Select Images for Additional Section',
                button: {
                    text: 'Use Selected Images'
                },
                multiple: true,
                library: {
                    type: 'image'
                }
            });
            
            additionalMediaUploader.on('select', function() {
                var attachments = additionalMediaUploader.state().get('selection').toJSON();
                var currentCount = $('.additional-image-item').length;
                var maxImages = 2;
                var availableSlots = maxImages - currentCount;
                
                if (availableSlots <= 0) {
                    alert('Maximum of 2 images allowed for additional section. Please remove some images first.');
                    return;
                }
                
                // Add selected images (up to available slots)
                attachments.slice(0, availableSlots).forEach(function(attachment, index) {
                    var imageIndex = currentCount + index;
                    var imageHtml = '<div class="additional-image-item" data-id="' + attachment.id + '" style="position: relative; display: inline-block; margin: 5px;">';
                    imageHtml += '<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" style="max-width: 100px; height: 80px; object-fit: cover; border: 2px solid #ddd;" />';
                    imageHtml += '<button type="button" class="remove-additional-image button" style="position: absolute; top: -5px; right: -5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1; padding: 0;">×</button>';
                    imageHtml += '<input type="hidden" name="additional_section_images[' + imageIndex + ']" value="' + attachment.id + '">';
                    imageHtml += '</div>';
                    
                    $('.additional-images').append(imageHtml);
                });
                
                if (attachments.length > availableSlots) {
                    alert('Only ' + availableSlots + ' images were added. Maximum of 2 images total allowed for additional section.');
                }
            });
            
            additionalMediaUploader.open();
        });
        
        // Remove additional image
        $(document).on('click', '.remove-additional-image', function(e) {
            e.preventDefault();
            $(this).closest('.additional-image-item').remove();
            
            // Reindex the remaining images
            $('.additional-image-item').each(function(index) {
                $(this).find('input[type="hidden"]').attr('name', 'additional_section_images[' + index + ']');
            });
        });
        
        // Clear all additional images
        $('#clear_additional_images').on('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to clear all additional images?')) {
                $('.additional-images').empty();
            }
        });
        
        // ===== PDF UPLOAD FUNCTIONALITY =====
        var ctaPdfUploader;
        
        $('#upload_pdf_btn').on('click', function(e) {
            e.preventDefault();
            
            if (ctaPdfUploader) {
                ctaPdfUploader.open();
                return;
            }
            
            ctaPdfUploader = wp.media({
                title: 'Select PDF File',
                library: {
                    type: 'application/pdf'
                },
                button: {
                    text: 'Use this PDF'
                },
                multiple: false
            });
            
            ctaPdfUploader.on('select', function() {
                var attachment = ctaPdfUploader.state().get('selection').first().toJSON();
                
                if (attachment.mime !== 'application/pdf') {
                    alert('Please select a PDF file.');
                    return;
                }
                
                $('#cta_pdf_file').val(attachment.id);
                
                var displayHtml = '<div id="current_pdf_display" style="background: #f1f1f1; padding: 10px; border-radius: 3px; margin-bottom: 10px;">';
                displayHtml += '<strong>Current PDF:</strong> <a href="' + attachment.url + '" target="_blank">' + attachment.filename + '</a>';
                displayHtml += ' <button type="button" id="remove_pdf_btn" class="button" style="margin-left: 10px;">Remove PDF</button>';
                displayHtml += '</div>';
                
                $('#current_pdf_display').remove();
                $('#upload_pdf_btn').before(displayHtml);
                $('#upload_pdf_btn').text('Change PDF');
            });
            
            ctaPdfUploader.open();
        });
        
        // Remove PDF functionality
        $(document).on('click', '#remove_pdf_btn', function(e) {
            e.preventDefault();
            $('#cta_pdf_file').val('');
            $('#current_pdf_display').remove();
            $('#upload_pdf_btn').text('Upload PDF');
        });
        
        // ===== FORM FIELD TOGGLES =====
        function toggleCategoryFields() {
            var experienceType = document.getElementById("experience_type").value;
            var categoryTemplateRow = document.getElementById("category_template_row");
            
            if (experienceType === "category") {
                categoryTemplateRow.style.display = "table-row";
                toggleDetailedFields(); // Check if detailed fields should be shown
            } else {
                categoryTemplateRow.style.display = "none";
                // For single experiences, always show detailed fields
                showDetailedFields();
            }
            
            // Always update CTA visibility based on experience type
            toggleCTAFields();
        }
        
        function toggleDetailedFields() {
            var experienceType = document.getElementById("experience_type").value;
            var categoryTemplate = document.getElementById("category_template").value;
            var showFields = (experienceType === "single") || (experienceType === "category" && categoryTemplate === "detailed");
            
            if (showFields) {
                showDetailedFields();
            } else {
                hideDetailedFields();
            }
            
            // Always update CTA visibility based on experience type
            toggleCTAFields();
        }
        
        function showDetailedFields() {
            // These fields show for both single experiences AND detailed category templates
            var detailedRows = [
                "detailed_subtitle_row",
                "quote_section_row", 
                "nature_section_row",
                "region_section_row",
                "hero_gallery_row",
                "additional_section_toggle_row"
                // Note: CTA section is handled separately
            ];
            
            detailedRows.forEach(function(rowId) {
                var row = document.getElementById(rowId);
                if (row) {
                    row.style.display = "table-row";
                }
            });
            
            // Also check if additional section should be shown
            toggleAdditionalSectionFields();
        }
        
        function hideDetailedFields() {
            var detailedRows = [
                "detailed_subtitle_row",
                "quote_section_row", 
                "nature_section_row",
                "region_section_row",
                "hero_gallery_row",
                "additional_section_toggle_row",
                "additional_images_row",
                "additional_quote_row",
                "additional_content_row"
                // Note: CTA section is handled separately
            ];
            
            detailedRows.forEach(function(rowId) {
                var row = document.getElementById(rowId);
                if (row) {
                    row.style.display = "none";
                }
            });
        }

        function toggleCTAFields() {
            var experienceType = document.getElementById("experience_type").value;
            var ctaRow = document.getElementById("cta_section_row");
            
            if (ctaRow) {
                // CTA section only shows for single experiences
                if (experienceType === "single") {
                    ctaRow.style.display = "table-row";
                } else {
                    ctaRow.style.display = "none";
                }
            }
        }
        
        function toggleAdditionalSectionFields() {
            var showAdditional = document.querySelector('input[name="show_additional_section"]');
            if (!showAdditional) return;
            
            var isChecked = showAdditional.checked;
            var additionalRows = [
                "additional_images_row",
                "additional_quote_row",
                "additional_content_row"
            ];
            
            additionalRows.forEach(function(rowId) {
                var row = document.getElementById(rowId);
                if (row) {
                    row.style.display = isChecked ? "table-row" : "none";
                }
            });
        }
        
        // Make functions global so they can be called from inline handlers
        window.toggleCategoryFields = toggleCategoryFields;
        window.toggleDetailedFields = toggleDetailedFields;
        window.toggleAdditionalSectionFields = toggleAdditionalSectionFields;
        
        // Initialize on page load
        toggleCategoryFields();
        
        // Make galleries sortable
        if ($('.hero-gallery-images').length) {
            $('.hero-gallery-images').sortable({
                items: '.hero-gallery-item',
                cursor: 'move',
                update: function() {
                    // Reindex after sorting
                    $('.hero-gallery-item').each(function(index) {
                        $(this).find('input[type="hidden"]').attr('name', 'hero_banner_gallery[' + index + ']');
                    });
                }
            });
        }
        
        if ($('.additional-images').length) {
            $('.additional-images').sortable({
                items: '.additional-image-item',
                cursor: 'move',
                update: function() {
                    // Reindex after sorting
                    $('.additional-image-item').each(function(index) {
                        $(this).find('input[type="hidden"]').attr('name', 'additional_section_images[' + index + ']');
                    });
                }
            });
        }
    });
    </script>
    <?php
}

function save_experience_details($post_id) {
    if (!isset($_POST['experience_details_nonce']) || !wp_verify_nonce($_POST['experience_details_nonce'], 'save_experience_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['experience_short_description'])) {
        update_post_meta($post_id, '_experience_short_description', sanitize_text_field($_POST['experience_short_description']));
    }

    if (isset($_POST['experience_type'])) {
        update_post_meta($post_id, '_experience_type', sanitize_text_field($_POST['experience_type']));
    }
    
    // Save category template selection
    if (isset($_POST['category_template'])) {
        update_post_meta($post_id, '_category_template', sanitize_text_field($_POST['category_template']));
    }
    
    // Save detailed template fields
    if (isset($_POST['detailed_subtitle'])) {
        update_post_meta($post_id, '_detailed_subtitle', sanitize_text_field($_POST['detailed_subtitle']));
    }
    
    if (isset($_POST['quote_title'])) {
        update_post_meta($post_id, '_quote_title', sanitize_text_field($_POST['quote_title']));
    }
    
    if (isset($_POST['quote_text'])) {
        update_post_meta($post_id, '_quote_text', sanitize_textarea_field($_POST['quote_text']));
    }
    
    // Save section toggles and text
    $show_nature_section = isset($_POST['show_nature_section']) ? 1 : 0;
    update_post_meta($post_id, '_show_nature_section', $show_nature_section);
    
    if (isset($_POST['nature_section_text'])) {
        update_post_meta($post_id, '_nature_section_text', sanitize_text_field($_POST['nature_section_text']));
    }
    
    $show_region_section = isset($_POST['show_region_section']) ? 1 : 0;
    update_post_meta($post_id, '_show_region_section', $show_region_section);
    
    if (isset($_POST['region_section_text'])) {
        update_post_meta($post_id, '_region_section_text', sanitize_text_field($_POST['region_section_text']));
    }
    
    // Save additional content section
    $show_additional_section = isset($_POST['show_additional_section']) ? 1 : 0;
    update_post_meta($post_id, '_show_additional_section', $show_additional_section);
    
    if (isset($_POST['additional_quote_title'])) {
        update_post_meta($post_id, '_additional_quote_title', sanitize_text_field($_POST['additional_quote_title']));
    }
    
    if (isset($_POST['additional_quote_text'])) {
        update_post_meta($post_id, '_additional_quote_text', sanitize_textarea_field($_POST['additional_quote_text']));
    }
    
    if (isset($_POST['additional_content'])) {
        update_post_meta($post_id, '_additional_content', wp_kses_post($_POST['additional_content']));
    }
    
    // Save additional section images
    if (isset($_POST['additional_section_images']) && is_array($_POST['additional_section_images'])) {
        $additional_image_ids = array_map('intval', $_POST['additional_section_images']);
        $additional_image_ids = array_filter($additional_image_ids); // Remove empty values
        $additional_image_ids = array_slice($additional_image_ids, 0, 2); // Limit to 2 images
        update_post_meta($post_id, '_additional_section_images', $additional_image_ids);
    } else {
        delete_post_meta($post_id, '_additional_section_images');
    }
    
    // Save hero banner gallery
    if (isset($_POST['hero_banner_gallery']) && is_array($_POST['hero_banner_gallery'])) {
        $gallery_ids = array_map('intval', $_POST['hero_banner_gallery']);
        $gallery_ids = array_filter($gallery_ids); // Remove empty values
        $gallery_ids = array_slice($gallery_ids, 0, 4); // Limit to 4 images
        update_post_meta($post_id, '_hero_banner_gallery', $gallery_ids);
    } else {
        delete_post_meta($post_id, '_hero_banner_gallery');
    }
   // Save CTA section fields
    if (isset($_POST['cta_title'])) {
        update_post_meta($post_id, '_cta_title', sanitize_text_field($_POST['cta_title']));
    }
    
    if (isset($_POST['cta_subtitle'])) {
        update_post_meta($post_id, '_cta_subtitle', sanitize_textarea_field($_POST['cta_subtitle']));
    }
    
    if (isset($_POST['cta_primary_button'])) {
        update_post_meta($post_id, '_cta_primary_button', sanitize_text_field($_POST['cta_primary_button']));
    }
    
    if (isset($_POST['cta_secondary_button'])) {
        update_post_meta($post_id, '_cta_secondary_button', sanitize_text_field($_POST['cta_secondary_button']));
    }
    
    if (isset($_POST['cta_pdf_file'])) {
        update_post_meta($post_id, '_cta_pdf_file', intval($_POST['cta_pdf_file']));
    }

    $featured_carousel = isset($_POST['featured_in_carousel']) ? 1 : 0;
    update_post_meta($post_id, '_featured_in_carousel', $featured_carousel);
    
    $featured_archive = isset($_POST['featured_in_archive']) ? 1 : 0;
    update_post_meta($post_id, '_featured_in_archive', $featured_archive);

    $display_in_dining = isset($_POST['display_in_dining']) ? 1 : 0;
    update_post_meta($post_id, '_display_in_dining', $display_in_dining);
}
add_action('save_post', 'save_experience_details');

// ============================================
// EVENTS & OFFERS META BOXES
// ============================================

/**
 * Add custom fields for events and offers
 */
function add_event_offer_meta_boxes() {
    add_meta_box(
        'event_offer_details',
        'Event/Offer Details',
        'event_offer_details_callback',
        'event_offer',
        'normal',
        'high'
    );
    
    // Add gallery meta box
    add_meta_box(
        'event_offer_gallery',
        'Event/Offer Gallery',
        'event_offer_gallery_callback',
        'event_offer',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_event_offer_meta_boxes');

function event_offer_details_callback($post) {
    wp_nonce_field('save_event_offer_details', 'event_offer_details_nonce');
    
    $short_description = get_post_meta($post->ID, '_event_offer_short_description', true);
    $featured_in_carousel = get_post_meta($post->ID, '_event_offer_featured_in_carousel', true);
    $featured_in_archive = get_post_meta($post->ID, '_event_offer_featured_in_archive', true);
    $event_date = get_post_meta($post->ID, '_event_offer_date', true);
    $event_end_date = get_post_meta($post->ID, '_event_offer_end_date', true);
    $event_type = get_post_meta($post->ID, '_event_offer_type', true);
    $event_location = get_post_meta($post->ID, '_event_offer_location', true);
    $event_location_description = get_post_meta($post->ID, '_event_offer_location_description', true);
    $additional_info = get_post_meta($post->ID, '_event_offer_additional_info', true);
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<td colspan="2" style="padding: 15px 0; border-bottom: 1px solid #ddd;">';
    echo '<p style="margin: 0; font-style: italic; color: #666;"><strong>Note:</strong> Make sure to add content in the main editor above to display the event description on the page.</p>';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="event_offer_short_description">Subtitle</label></th>';
    echo '<td><input type="text" id="event_offer_short_description" name="event_offer_short_description" value="' . esc_attr($short_description) . '" class="widefat" placeholder="e.g., An Evening of Music & Magic" />';
    echo '<p class="description">This will appear as the large subtitle under the hero section.</p></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="event_offer_type">Type</label></th>';
    echo '<td>';
    echo '<select id="event_offer_type" name="event_offer_type">';
    echo '<option value="event"' . selected($event_type, 'event', false) . '>Event</option>';
    echo '<option value="offer"' . selected($event_type, 'offer', false) . '>Special Offer</option>';
    echo '</select>';
    echo '<p class="description">Specify whether this is an event or a special offer.</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="event_offer_date">Start Date</label></th>';
    echo '<td><input type="datetime-local" id="event_offer_date" name="event_offer_date" value="' . esc_attr($event_date) . '" /></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="event_offer_end_date">End Date/Time (Optional)</label></th>';
    echo '<td><input type="datetime-local" id="event_offer_end_date" name="event_offer_end_date" value="' . esc_attr($event_end_date) . '" />';
    echo '<p class="description">Leave empty for single-day events or ongoing offers.</p></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="event_offer_location">Location</label></th>';
    echo '<td><input type="text" id="event_offer_location" name="event_offer_location" value="' . esc_attr($event_location) . '" class="widefat" placeholder="e.g., Constellate Rooftop Bar & Lounge" /></td>';
    // echo '<p class="description"></p>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="event_offer_location_description">Location Description</label></th>';
    echo '<td><textarea id="event_offer_location_description" name="event_offer_location_description" class="widefat" rows="2" placeholder="e.g., Located on the rooftop of The Westin Nirup Island">' . esc_textarea($event_location_description) . '</textarea>';
    echo '<p class="description">Additional description for the location. Leave empty to hide.</p></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="event_offer_additional_info">Additional Information</label></th>';
    echo '<td><textarea id="event_offer_additional_info" name="event_offer_additional_info" class="widefat" rows="3" placeholder="Additional details about the event/offer...">' . esc_textarea($additional_info) . '</textarea>';
    echo '<p class="description">This text will appear below the main content description, after the divider line and before the "How to Book" button.</p></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="event_offer_booking_link">Booking Link (External)</label></th>';
    echo '<td>';
    $booking_link = get_post_meta($post->ID, '_event_offer_booking_link', true);
    echo '<input type="url" id="event_offer_booking_link" name="event_offer_booking_link" value="' . esc_attr($booking_link) . '" class="widefat" placeholder="https://example.com/booking" />';
    echo '<p class="description">Enter an external URL for booking. The "Book Now" button will only appear if this field is filled. Link will open in a new tab.</p>';
    echo '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<th>Display Options</th>';
    echo '<td>';
    echo '<label><input type="checkbox" name="event_offer_featured_in_carousel" value="1"' . checked($featured_in_carousel, 1, false) . ' /> Display in Homepage Carousel</label><br>';
    echo '<label><input type="checkbox" name="event_offer_featured_in_archive" value="1"' . checked($featured_in_archive, 1, false) . ' /> Display in Events & Offers Archive Page</label>';
    echo '<p class="description">Choose where this event/offer should appear.</p>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

function event_offer_gallery_callback($post) {
    wp_nonce_field('save_event_offer_gallery', 'event_offer_gallery_nonce');
    
    $gallery_images = get_post_meta($post->ID, '_event_offer_gallery', true);
    $gallery_images = is_array($gallery_images) ? $gallery_images : array();
    
    echo '<div class="event-offer-gallery-container">';
    echo '<p class="description">Upload images for the event/offer gallery. These will be displayed in a carousel at the bottom of the single event/offer page.</p>';
    
    echo '<div class="gallery-images-wrapper">';
    echo '<div id="gallery-images-container" class="gallery-images-grid">';
    
    // Display existing images
    foreach ($gallery_images as $image_id) {
        $image_url = wp_get_attachment_thumb_url($image_id);
        if ($image_url) {
            echo '<div class="gallery-image-item" data-attachment-id="' . esc_attr($image_id) . '">';
            echo '<img src="' . esc_url($image_url) . '" alt="" style="max-width: 150px; height: 100px; object-fit: cover;">';
            echo '<button type="button" class="remove-gallery-image" style="position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer;">×</button>';
            echo '<input type="hidden" name="event_offer_gallery[]" value="' . esc_attr($image_id) . '">';
            echo '</div>';
        }
    }
    
    echo '</div>';
    echo '<button type="button" id="add-gallery-images" class="button button-secondary" style="margin-top: 10px;">Add Images to Gallery</button>';
    echo '</div>';
    
    echo '</div>';
    
    // Add the media upload script
    ?>
    <style>
    .gallery-images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
        margin-bottom: 10px;
    }
    .gallery-image-item {
        position: relative;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }
    .gallery-image-item img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        display: block;
    }
    .remove-gallery-image {
        position: absolute !important;
        top: 5px !important;
        right: 5px !important;
        background: #dc3232 !important;
        color: white !important;
        border: none !important;
        border-radius: 50% !important;
        width: 20px !important;
        height: 20px !important;
        cursor: pointer !important;
        font-size: 12px !important;
        line-height: 1 !important;
        padding: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    .remove-gallery-image:hover {
        background: #a00 !important;
    }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        var galleryFrame;
        
        // Add images to gallery
        $('#add-gallery-images').on('click', function(e) {
            e.preventDefault();
            
            if (galleryFrame) {
                galleryFrame.open();
                return;
            }
            
            galleryFrame = wp.media({
                title: 'Select Gallery Images',
                button: {
                    text: 'Add to Gallery'
                },
                multiple: true,
                library: {
                    type: 'image'
                }
            });
            
            galleryFrame.on('select', function() {
                var selection = galleryFrame.state().get('selection');
                var container = $('#gallery-images-container');
                
                selection.map(function(attachment) {
                    attachment = attachment.toJSON();
                    var imageHtml = '<div class="gallery-image-item" data-attachment-id="' + attachment.id + '">' +
                        '<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" alt="" style="max-width: 150px; height: 100px; object-fit: cover;">' +
                        '<button type="button" class="remove-gallery-image" style="position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer;">×</button>' +
                        '<input type="hidden" name="event_offer_gallery[]" value="' + attachment.id + '">' +
                        '</div>';
                    container.append(imageHtml);
                });
            });
            
            galleryFrame.open();
        });
        
        // Remove image from gallery
        $(document).on('click', '.remove-gallery-image', function(e) {
            e.preventDefault();
            $(this).closest('.gallery-image-item').remove();
        });
    });
    </script>
    <?php
}

function save_event_offer_details($post_id) {
    if (!isset($_POST['event_offer_details_nonce']) || !wp_verify_nonce($_POST['event_offer_details_nonce'], 'save_event_offer_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['event_offer_short_description'])) {
        update_post_meta($post_id, '_event_offer_short_description', sanitize_text_field($_POST['event_offer_short_description']));
    }

    if (isset($_POST['event_offer_type'])) {
        update_post_meta($post_id, '_event_offer_type', sanitize_text_field($_POST['event_offer_type']));
    }

    if (isset($_POST['event_offer_date'])) {
        update_post_meta($post_id, '_event_offer_date', sanitize_text_field($_POST['event_offer_date']));
    }

    if (isset($_POST['event_offer_end_date'])) {
        update_post_meta($post_id, '_event_offer_end_date', sanitize_text_field($_POST['event_offer_end_date']));
    }

    if (isset($_POST['event_offer_location'])) {
        update_post_meta($post_id, '_event_offer_location', sanitize_text_field($_POST['event_offer_location']));
    }

    if (isset($_POST['event_offer_location_description'])) {
        update_post_meta($post_id, '_event_offer_location_description', sanitize_textarea_field($_POST['event_offer_location_description']));
    }

    if (isset($_POST['event_offer_additional_info'])) {
        update_post_meta($post_id, '_event_offer_additional_info', wp_kses_post($_POST['event_offer_additional_info']));
    }

    if (isset($_POST['event_offer_booking_link'])) {
        update_post_meta($post_id, '_event_offer_booking_link', esc_url_raw($_POST['event_offer_booking_link']));
    }

    $featured_carousel = isset($_POST['event_offer_featured_in_carousel']) ? 1 : 0;
    update_post_meta($post_id, '_event_offer_featured_in_carousel', $featured_carousel);

    $featured_archive = isset($_POST['event_offer_featured_in_archive']) ? 1 : 0;
    update_post_meta($post_id, '_event_offer_featured_in_archive', $featured_archive);
}
add_action('save_post', 'save_event_offer_details');

function save_event_offer_gallery($post_id) {
    if (!isset($_POST['event_offer_gallery_nonce']) || !wp_verify_nonce($_POST['event_offer_gallery_nonce'], 'save_event_offer_gallery')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save gallery images
    if (isset($_POST['event_offer_gallery']) && is_array($_POST['event_offer_gallery'])) {
        $gallery_images = array_map('intval', $_POST['event_offer_gallery']);
        update_post_meta($post_id, '_event_offer_gallery', $gallery_images);
    } else {
        delete_post_meta($post_id, '_event_offer_gallery');
    }
}
add_action('save_post', 'save_event_offer_gallery');

// ============================================
// RESTAURANT META BOXES
// ============================================

// Restaurant Meta Boxes
function nirup_add_restaurant_meta_boxes() {
    add_meta_box(
        'restaurant-archive-card-info',
        __('📋 Archive Card Information', 'nirup-island'),
        'nirup_restaurant_archive_card_callback',
        'restaurant',
        'normal',
        'high'
    );
    
    add_meta_box(
        'restaurant-single-page-info',
        __('📄 Single Page Information', 'nirup-island'),
        'nirup_restaurant_single_page_callback',
        'restaurant',
        'normal',
        'high'
    );
    
    add_meta_box(
        'restaurant-gallery',
        __('🖼️ Restaurant Gallery', 'nirup-island'),
        'nirup_restaurant_gallery_callback',
        'restaurant',
        'normal',
        'default'
    );
    
    add_meta_box(
        'restaurant-archive-settings',
        __('⚙️ Archive Display Settings', 'nirup-island'),
        'nirup_restaurant_archive_settings_callback',
        'restaurant',
        'side'
    );
}
add_action('add_meta_boxes', 'nirup_add_restaurant_meta_boxes');


// Restaurant Details Meta Box Callback
function nirup_restaurant_details_callback($post) {
    wp_nonce_field('nirup_restaurant_details', 'nirup_restaurant_details_nonce');
    
    $restaurant_category = get_post_meta($post->ID, '_restaurant_category', true);
    $short_description = get_post_meta($post->ID, '_restaurant_short_description', true);
    $operating_hours = get_post_meta($post->ID, '_restaurant_operating_hours', true);
    $additional_info = get_post_meta($post->ID, '_restaurant_additional_info', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="restaurant_category"><?php _e('Category', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="restaurant_category" name="restaurant_category" value="<?php echo esc_attr($restaurant_category); ?>" class="regular-text" />
                <p class="description"><?php _e('e.g., "All-day Dining / Multiple Cuisines"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_short_description"><?php _e('Short Description', 'nirup-island'); ?></label></th>
            <td>
                <textarea id="restaurant_short_description" name="restaurant_short_description" rows="3" class="large-text"><?php echo esc_textarea($short_description); ?></textarea>
                <p class="description"><?php _e('Brief description shown on archive cards.', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_operating_hours"><?php _e('Operating Hours', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="restaurant_operating_hours" name="restaurant_operating_hours" value="<?php echo esc_attr($operating_hours); ?>" class="regular-text" />
                <p class="description"><?php _e('e.g., "Open daily: 6:00 AM – 10:30 PM"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_additional_info"><?php _e('Additional Information', 'nirup-island'); ?></label></th>
            <td>
                <textarea id="restaurant_additional_info" name="restaurant_additional_info" rows="3" class="large-text"><?php echo esc_textarea($additional_info); ?></textarea>
                <p class="description"><?php _e('Any additional details about the restaurant.', 'nirup-island'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

function nirup_restaurant_archive_card_callback($post) {
    wp_nonce_field('nirup_restaurant_card_info', 'nirup_restaurant_card_info_nonce');
    
    $card_category = get_post_meta($post->ID, '_restaurant_card_category', true);
    $card_short_description = get_post_meta($post->ID, '_restaurant_card_short_description', true);
    $card_operating_hours = get_post_meta($post->ID, '_restaurant_card_operating_hours', true);
    ?>
    <p><strong>⚠️ These fields are used ONLY for the restaurant cards on the dining archive page.</strong></p>
    <table class="form-table">
        <tr>
            <th><label for="restaurant_card_category"><?php _e('Category (for card)', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="restaurant_card_category" name="restaurant_card_category" value="<?php echo esc_attr($card_category); ?>" class="regular-text" />
                <p class="description"><?php _e('e.g., "Seafood Specialty Restaurant" - shown on archive cards only', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_card_short_description"><?php _e('Short Description (for card)', 'nirup-island'); ?></label></th>
            <td>
                <textarea id="restaurant_card_short_description" name="restaurant_card_short_description" rows="3" class="large-text"><?php echo esc_textarea($card_short_description); ?></textarea>
                <p class="description"><?php _e('Brief description shown on archive cards only.', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_card_operating_hours"><?php _e('Operating Hours (for card)', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="restaurant_card_operating_hours" name="restaurant_card_operating_hours" value="<?php echo esc_attr($card_operating_hours); ?>" class="large-text" />
                <p class="description"><?php _e('e.g., "Open daily: 6:00 AM – 10:30 PM" - shown on archive cards only', 'nirup-island'); ?></p>
            </td>
        </tr>
    </table>
    <p><em>Note: The featured image is also used for the archive cards.</em></p>
    <?php
}

function nirup_restaurant_single_page_callback($post) {
    wp_nonce_field('nirup_restaurant_page_info', 'nirup_restaurant_page_info_nonce');
    
    $page_subtitle = get_post_meta($post->ID, '_restaurant_page_subtitle', true);
    $page_category_title = get_post_meta($post->ID, '_restaurant_page_category_title', true);
    $page_cuisine_type = get_post_meta($post->ID, '_restaurant_page_cuisine_type', true);
    $page_operating_hours = get_post_meta($post->ID, '_restaurant_page_operating_hours', true);
    $page_menu_pdf = get_post_meta($post->ID, '_restaurant_menu_pdf', true);
    ?>
    <p><strong>ℹ️ These fields are used ONLY for the individual restaurant page.</strong></p>
    <table class="form-table">
        <tr>
            <th><label for="restaurant_page_subtitle"><?php _e('Page Subtitle', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="restaurant_page_subtitle" name="restaurant_page_subtitle" value="<?php echo esc_attr($page_subtitle); ?>" class="large-text" />
                <p class="description"><?php _e('e.g., "Fresh from the Ocean, Served with Elegance" - shown under main title on single page', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_page_category_title"><?php _e('Category Title (for single page)', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="restaurant_page_category_title" name="restaurant_page_category_title" value="<?php echo esc_attr($page_category_title); ?>" class="regular-text" />
                <p class="description"><?php _e('e.g., "Seafood Specialty Restaurant" - shown as section title on single page', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_page_cuisine_type"><?php _e('Cuisine Type (sidebar)', 'nirup-island'); ?></label></th>
            <td>
                <textarea id="restaurant_page_cuisine_type" name="restaurant_page_cuisine_type" rows="2" class="regular-text"><?php echo esc_textarea($page_cuisine_type); ?></textarea>
                <p class="description"><?php _e('e.g., "Seafood Specialty, Farm-to-Table Concept" - shown in sidebar', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_page_operating_hours"><?php _e('Operating Hours (sidebar)', 'nirup-island'); ?></label></th>
            <td>
                <textarea id="restaurant_page_operating_hours" name="restaurant_page_operating_hours" rows="3" class="regular-text"><?php echo esc_textarea($page_operating_hours); ?></textarea>
                <p class="description"><?php _e('e.g., "Friday – Sunday: 11:00 AM – 10:00 PM<br>Closed: Monday – Thursday" - shown in sidebar', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="restaurant_menu_pdf"><?php _e('Menu PDF', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="restaurant_menu_pdf" name="restaurant_menu_pdf" value="<?php echo esc_attr($page_menu_pdf); ?>" class="regular-text" />
                <button type="button" class="button" id="upload_menu_pdf_button"><?php _e('Upload/Select PDF', 'nirup-island'); ?></button>
                <button type="button" class="button" id="remove_menu_pdf_button" <?php echo empty($page_menu_pdf) ? 'style="display:none;"' : ''; ?>><?php _e('Remove PDF', 'nirup-island'); ?></button>
                <p class="description"><?php _e('Upload a PDF file for the "Discover Menu" button. Visitors will download this file.', 'nirup-island'); ?></p>
                <?php if (!empty($page_menu_pdf)) : ?>
                    <p><a href="<?php echo esc_url($page_menu_pdf); ?>" target="_blank">View current PDF</a></p>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <p><em>Note: The main content editor above is used as the restaurant description paragraph on the single page.</em></p>
    
    <script>
    jQuery(document).ready(function($) {
        var frame;
        
        $('#upload_menu_pdf_button').on('click', function(e) {
            e.preventDefault();
            
            if (frame) {
                frame.open();
                return;
            }
            
            frame = wp.media({
                title: 'Select Menu PDF',
                multiple: false,
                library: {
                    type: 'application/pdf'
                }
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#restaurant_menu_pdf').val(attachment.url);
                $('#remove_menu_pdf_button').show();
            });
            
            frame.open();
        });
        
        $('#remove_menu_pdf_button').on('click', function(e) {
            e.preventDefault();
            $('#restaurant_menu_pdf').val('');
            $(this).hide();
        });
    });
    </script>
    <?php
}

function nirup_restaurant_gallery_callback($post) {
    wp_nonce_field('nirup_restaurant_gallery', 'nirup_restaurant_gallery_nonce');
    
    $gallery_images = get_post_meta($post->ID, '_restaurant_gallery', true);
    $gallery_images = $gallery_images ? $gallery_images : array();
    ?>
    <p><strong>🖼️ Restaurant Gallery - Upload images for the restaurant gallery (displays 5 photos with "see more" option if more are uploaded)</strong></p>
    
    <div class="restaurant-gallery-container">
        <div id="restaurant-gallery-images" class="gallery-images-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; margin-bottom: 20px;">
            <?php foreach ($gallery_images as $image_id) : ?>
                <?php $image_url = wp_get_attachment_thumb_url($image_id); ?>
                <?php if ($image_url) : ?>
                    <div class="gallery-image-item" data-attachment-id="<?php echo esc_attr($image_id); ?>" style="position: relative;">
                        <img src="<?php echo esc_url($image_url); ?>" alt="" style="width: 100%; height: 100px; object-fit: cover; border: 2px solid #ddd;">
                        <button type="button" class="remove-gallery-image" style="position: absolute; top: 5px; right: 5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px;">×</button>
                        <input type="hidden" name="restaurant_gallery[]" value="<?php echo esc_attr($image_id); ?>">
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        
        <button type="button" class="button button-primary" id="add-gallery-images"><?php _e('Add Gallery Images', 'nirup-island'); ?></button>
        <p class="description"><?php _e('The first 5 images will be displayed in the gallery layout. If more than 5 images are uploaded, a "See All Photos" button will appear.', 'nirup-island'); ?></p>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var frame;
        
        // Add images
        $('#add-gallery-images').on('click', function(e) {
            e.preventDefault();
            
            if (frame) {
                frame.open();
                return;
            }
            
            frame = wp.media({
                title: 'Select Gallery Images',
                multiple: true,
                library: {
                    type: 'image'
                }
            });
            
            frame.on('select', function() {
                var attachments = frame.state().get('selection').toJSON();
                
                attachments.forEach(function(attachment) {
                    var html = '<div class="gallery-image-item" data-attachment-id="' + attachment.id + '" style="position: relative;">' +
                               '<img src="' + attachment.sizes.thumbnail.url + '" alt="" style="width: 100%; height: 100px; object-fit: cover; border: 2px solid #ddd;">' +
                               '<button type="button" class="remove-gallery-image" style="position: absolute; top: 5px; right: 5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px;">×</button>' +
                               '<input type="hidden" name="restaurant_gallery[]" value="' + attachment.id + '">' +
                               '</div>';
                    
                    $('#restaurant-gallery-images').append(html);
                });
            });
            
            frame.open();
        });
        
        // Remove images
        $(document).on('click', '.remove-gallery-image', function(e) {
            e.preventDefault();
            $(this).closest('.gallery-image-item').remove();
        });
    });
    </script>
    <?php
}

function nirup_restaurant_archive_settings_callback($post) {
    wp_nonce_field('nirup_restaurant_archive_settings', 'nirup_restaurant_archive_settings_nonce');
    
    $featured_in_archive = get_post_meta($post->ID, '_featured_in_archive', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="featured_in_archive"><?php _e('Show in Archive', 'nirup-island'); ?></label></th>
            <td>
                <input type="checkbox" id="featured_in_archive" name="featured_in_archive" value="1" <?php checked($featured_in_archive, 1); ?> />
                <label for="featured_in_archive"><?php _e('Display this restaurant on the dining archive page', 'nirup-island'); ?></label>
            </td>
        </tr>
    </table>
    <?php
}

// Save Restaurant Meta
function nirup_save_restaurant_meta($post_id) {
    // Verify nonces
    $nonces_valid = 
        (isset($_POST['nirup_restaurant_card_info_nonce']) && wp_verify_nonce($_POST['nirup_restaurant_card_info_nonce'], 'nirup_restaurant_card_info')) ||
        (isset($_POST['nirup_restaurant_page_info_nonce']) && wp_verify_nonce($_POST['nirup_restaurant_page_info_nonce'], 'nirup_restaurant_page_info')) ||
        (isset($_POST['nirup_restaurant_gallery_nonce']) && wp_verify_nonce($_POST['nirup_restaurant_gallery_nonce'], 'nirup_restaurant_gallery')) ||
        (isset($_POST['nirup_restaurant_archive_settings_nonce']) && wp_verify_nonce($_POST['nirup_restaurant_archive_settings_nonce'], 'nirup_restaurant_archive_settings'));
    
    if (!$nonces_valid) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save archive card info
    if (isset($_POST['restaurant_card_category'])) {
        update_post_meta($post_id, '_restaurant_card_category', sanitize_text_field($_POST['restaurant_card_category']));
    }

    if (isset($_POST['restaurant_card_short_description'])) {
        update_post_meta($post_id, '_restaurant_card_short_description', sanitize_textarea_field($_POST['restaurant_card_short_description']));
    }

    if (isset($_POST['restaurant_card_operating_hours'])) {
        update_post_meta($post_id, '_restaurant_card_operating_hours', sanitize_text_field($_POST['restaurant_card_operating_hours']));
    }

    // Save single page info
    if (isset($_POST['restaurant_page_subtitle'])) {
        update_post_meta($post_id, '_restaurant_page_subtitle', sanitize_text_field($_POST['restaurant_page_subtitle']));
    }

    if (isset($_POST['restaurant_page_category_title'])) {
        update_post_meta($post_id, '_restaurant_page_category_title', sanitize_text_field($_POST['restaurant_page_category_title']));
    }

    if (isset($_POST['restaurant_page_cuisine_type'])) {
        update_post_meta($post_id, '_restaurant_page_cuisine_type', sanitize_textarea_field($_POST['restaurant_page_cuisine_type']));
    }

    if (isset($_POST['restaurant_page_operating_hours'])) {
        update_post_meta($post_id, '_restaurant_page_operating_hours', sanitize_textarea_field($_POST['restaurant_page_operating_hours']));
    }

    if (isset($_POST['restaurant_menu_pdf'])) {
        update_post_meta($post_id, '_restaurant_menu_pdf', esc_url_raw($_POST['restaurant_menu_pdf']));
    }

    // Save gallery
    if (isset($_POST['restaurant_gallery'])) {
        $gallery_images = array_map('intval', $_POST['restaurant_gallery']);
        update_post_meta($post_id, '_restaurant_gallery', $gallery_images);
    } else {
        delete_post_meta($post_id, '_restaurant_gallery');
    }

    // Save archive settings
    if (isset($_POST['nirup_restaurant_archive_settings_nonce']) && wp_verify_nonce($_POST['nirup_restaurant_archive_settings_nonce'], 'nirup_restaurant_archive_settings')) {
        $featured_in_archive = isset($_POST['featured_in_archive']) ? 1 : 0;
        update_post_meta($post_id, '_featured_in_archive', $featured_in_archive);
    }
}
add_action('save_post', 'nirup_save_restaurant_meta');

// ============================================
// FERRY SCHEDULE META BOXES
// ============================================

// Ferry Schedule Meta Boxes
function nirup_add_ferry_schedule_meta_boxes() {
    add_meta_box(
        'ferry-schedule-details',
        __('⛴️ Ferry Schedule Details', 'nirup-island'),
        'nirup_ferry_schedule_details_callback',
        'ferry_schedule',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_ferry_schedule_meta_boxes');

// Ferry Schedule Details Meta Box Callback
function nirup_ferry_schedule_details_callback($post) {
    wp_nonce_field('nirup_ferry_schedule_details', 'nirup_ferry_schedule_details_nonce');

    $route_type = get_post_meta($post->ID, '_ferry_route_type', true);
    $route_from = get_post_meta($post->ID, '_ferry_route_from', true);
    $route_to = get_post_meta($post->ID, '_ferry_route_to', true);
    $etd = get_post_meta($post->ID, '_ferry_etd', true);
    $eta = get_post_meta($post->ID, '_ferry_eta', true);
    $operator = get_post_meta($post->ID, '_ferry_operator', true);
    $duration = get_post_meta($post->ID, '_ferry_duration', true);
    $price = get_post_meta($post->ID, '_ferry_price', true);
    $frequency = get_post_meta($post->ID, '_ferry_frequency', true);
    $checkin_location = get_post_meta($post->ID, '_ferry_checkin_location', true);
    $menu_order = get_post_meta($post->ID, '_ferry_menu_order', true);
    ?>
    <style>
        .ferry-schedule-table { width: 100%; border-collapse: collapse; }
        .ferry-schedule-table th { text-align: left; padding: 12px; background: #f5f5f5; width: 200px; }
        .ferry-schedule-table td { padding: 12px; }
        .ferry-schedule-table tr { border-bottom: 1px solid #ddd; }
        .ferry-schedule-table input[type="text"],
        .ferry-schedule-table select { width: 100%; max-width: 500px; }
        .ferry-schedule-table textarea { width: 100%; max-width: 500px; rows: 3; }
        .ferry-schedule-table .description { color: #666; font-size: 13px; margin-top: 5px; }
    </style>
    <table class="ferry-schedule-table">
        <tr>
            <th><label for="ferry_route_type"><?php _e('Route Type', 'nirup-island'); ?></label></th>
            <td>
                <select id="ferry_route_type" name="ferry_route_type">
                    <option value="singapore" <?php selected($route_type, 'singapore'); ?>>Singapore</option>
                    <option value="batam" <?php selected($route_type, 'batam'); ?>>Batam</option>
                </select>
                <p class="description"><?php _e('Select which route this schedule belongs to (Singapore or Batam)', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_route_from"><?php _e('Route From', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_route_from" name="ferry_route_from" value="<?php echo esc_attr($route_from); ?>" />
                <p class="description"><?php _e('e.g., "Singapore", "Nirup", "Batam"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_route_to"><?php _e('Route To', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_route_to" name="ferry_route_to" value="<?php echo esc_attr($route_to); ?>" />
                <p class="description"><?php _e('e.g., "Singapore", "Nirup", "Batam"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_etd"><?php _e('ETD (Departure Time)', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_etd" name="ferry_etd" value="<?php echo esc_attr($etd); ?>" />
                <p class="description"><?php _e('e.g., "10:30 (SGT)" or "09:45 (IDT)"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_eta"><?php _e('ETA (Arrival Time)', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_eta" name="ferry_eta" value="<?php echo esc_attr($eta); ?>" />
                <p class="description"><?php _e('e.g., "11:10 (SGT)" or "10:05 (IDT)"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_operator"><?php _e('Operator', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_operator" name="ferry_operator" value="<?php echo esc_attr($operator); ?>" />
                <p class="description"><?php _e('e.g., "Horizon Fast Ferry", "Rans Fadhila"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_duration"><?php _e('Duration', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_duration" name="ferry_duration" value="<?php echo esc_attr($duration); ?>" />
                <p class="description"><?php _e('e.g., "50 minutes", "20 minutes"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_price"><?php _e('Price', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_price" name="ferry_price" value="<?php echo esc_attr($price); ?>" />
                <p class="description"><?php _e('e.g., "SGD 76 /per way", "Rp150,000 /per way"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_frequency"><?php _e('Frequency / Days', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="ferry_frequency" name="ferry_frequency" value="<?php echo esc_attr($frequency); ?>" />
                <p class="description"><?php _e('e.g., "Daily", "Fri–Sun only"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_checkin_location"><?php _e('Check-in Location', 'nirup-island'); ?></label></th>
            <td>
                <textarea id="ferry_checkin_location" name="ferry_checkin_location" rows="2"><?php echo esc_textarea($checkin_location); ?></textarea>
                <p class="description"><?php _e('e.g., "Tanah Merah Ferry Terminal"', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="ferry_menu_order"><?php _e('Display Order', 'nirup-island'); ?></label></th>
            <td>
                <input type="number" id="ferry_menu_order" name="ferry_menu_order" value="<?php echo esc_attr($menu_order ? $menu_order : 0); ?>" min="0" />
                <p class="description"><?php _e('Lower numbers appear first. Leave at 0 for default ordering.', 'nirup-island'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

// Save Ferry Schedule Meta
function nirup_save_ferry_schedule_meta($post_id) {
    // Check nonce
    if (!isset($_POST['nirup_ferry_schedule_details_nonce']) || !wp_verify_nonce($_POST['nirup_ferry_schedule_details_nonce'], 'nirup_ferry_schedule_details')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save all fields
    $fields = array(
        'ferry_route_type' => 'sanitize_text_field',
        'ferry_route_from' => 'sanitize_text_field',
        'ferry_route_to' => 'sanitize_text_field',
        'ferry_etd' => 'sanitize_text_field',
        'ferry_eta' => 'sanitize_text_field',
        'ferry_operator' => 'sanitize_text_field',
        'ferry_duration' => 'sanitize_text_field',
        'ferry_price' => 'sanitize_text_field',
        'ferry_frequency' => 'sanitize_text_field',
        'ferry_checkin_location' => 'sanitize_textarea_field',
        'ferry_menu_order' => 'absint',
    );

    foreach ($fields as $field => $sanitize_callback) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, $sanitize_callback($_POST[$field]));
        }
    }
}
add_action('save_post', 'nirup_save_ferry_schedule_meta');

// ============================================
// MARINA META BOXES
// ============================================

function nirup_add_marina_meta_boxes() {
    add_meta_box(
        'marina_details',
        '🏖️ Marina Page Settings',
        'nirup_marina_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_marina_meta_boxes');

function nirup_marina_meta_box_callback($post) {
    // Only show for Marina page template
    $template = get_post_meta($post->ID, '_wp_page_template', true);
    if ($template !== 'page-marina.php') {
        echo '<p>This meta box is only available when using the Marina Page template.</p>';
        return;
    }

    wp_nonce_field('nirup_marina_meta_box', 'nirup_marina_meta_box_nonce');

    // Get saved values (existing fields)
    $subtitle = get_post_meta($post->ID, '_marina_subtitle', true);
    $title = get_post_meta($post->ID, '_marina_title', true);
    $berthing_desc_1 = get_post_meta($post->ID, '_marina_berthing_description_1', true);
    $berthing_desc_2 = get_post_meta($post->ID, '_marina_berthing_description_2', true);
    $gallery_images = get_post_meta($post->ID, '_marina_gallery', true);
    $gallery_images = is_array($gallery_images) ? $gallery_images : array();

    // NEW: Get PDF file IDs
    $berthing_rates_pdf = get_post_meta($post->ID, '_berthing_rates_pdf', true);
    $arrival_procedure_pdf = get_post_meta($post->ID, '_arrival_procedure_pdf', true);
    $marina_rules_en_pdf = get_post_meta($post->ID, '_marina_rules_en_pdf', true);
    $marina_rules_id_pdf = get_post_meta($post->ID, '_marina_rules_id_pdf', true);

    ?>
    <style>
        .marina-meta-section { margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #ddd; }
        .marina-meta-section:last-child { border-bottom: none; }
        .marina-meta-field { margin-bottom: 15px; }
        .marina-meta-field label { display: block; font-weight: bold; margin-bottom: 5px; }
        .marina-meta-field input[type="text"],
        .marina-meta-field textarea { width: 100%; }
        .pdf-upload-container { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-top: 10px; }
        .current-pdf { background: #f1f1f1; padding: 10px; border-radius: 3px; margin-bottom: 10px; }
        .pdf-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px; }
    </style>

    <!-- Existing Hero Section Fields -->
    <div class="marina-meta-section">
        <h3>🏝️ Hero Section</h3>
        
        <div class="marina-meta-field">
            <label for="marina_subtitle">Subtitle</label>
            <input type="text" id="marina_subtitle" name="marina_subtitle" 
                   value="<?php echo esc_attr($subtitle); ?>" 
                   placeholder="e.g., Welcome to ONE°15 Marina Nirup Island" />
        </div>

        <div class="marina-meta-field">
            <label for="marina_title">Main Title</label>
            <input type="text" id="marina_title" name="marina_title" 
                   value="<?php echo esc_attr($title); ?>" 
                   placeholder="e.g., Arrive in Style" />
        </div>
    </div>

    <!-- Existing Berthing Description -->
    <div class="marina-meta-section">
        <h3>⚓ Berthing Descriptions</h3>
        
        <div class="marina-meta-field">
            <label for="marina_berthing_description_1">Description 1</label>
            <textarea id="marina_berthing_description_1" name="marina_berthing_description_1" 
                      rows="3"><?php echo esc_textarea($berthing_desc_1); ?></textarea>
        </div>

        <div class="marina-meta-field">
            <label for="marina_berthing_description_2">Description 2</label>
            <textarea id="marina_berthing_description_2" name="marina_berthing_description_2" 
                      rows="3"><?php echo esc_textarea($berthing_desc_2); ?></textarea>
        </div>
    </div>

    <!-- Marina Gallery Section -->
    <div class="marina-meta-section">
        <h3>📸 Marina Gallery</h3>
        <p style="color: #666; margin-bottom: 15px;">Upload images for the marina gallery. The first image will be used as the main image, and the next 4 will appear in the grid.</p>

        <div class="marina-gallery-images" style="margin-bottom: 15px; min-height: 50px; border: 2px dashed #ddd; padding: 10px; background: #fafafa;">
            <?php
            if ($gallery_images && is_array($gallery_images)) {
                foreach ($gallery_images as $index => $image_id) {
                    $image_url = wp_get_attachment_image_src($image_id, 'thumbnail');
                    if ($image_url) {
                        echo '<div class="marina-gallery-item" data-id="' . $image_id . '" style="position: relative; display: inline-block; margin: 5px; cursor: move;">';
                        echo '<img src="' . $image_url[0] . '" style="max-width: 100px; height: 80px; object-fit: cover; border: 2px solid #ddd;" />';
                        echo '<button type="button" class="remove-marina-gallery-image button" style="position: absolute; top: -5px; right: -5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1; padding: 0;">×</button>';
                        echo '<input type="hidden" name="marina_gallery[' . $index . ']" value="' . $image_id . '">';
                        echo '</div>';
                    }
                }
            }
            ?>
        </div>

        <button type="button" id="add_marina_gallery_image" class="button button-primary">Add Images to Gallery</button>
        <button type="button" id="clear_marina_gallery" class="button" style="margin-left: 10px;">Clear All Images</button>
        <p class="description" style="margin-top: 10px;">You can drag and drop images to reorder them. The first image is the main gallery image.</p>
    </div>

    <!-- NEW: PDF Downloads Section -->
    <div class="marina-meta-section">
        <h3>📄 Downloadable PDFs</h3>
        <p style="color: #666; margin-bottom: 15px;">Upload PDF files that users can download from the marina page.</p>
        
        <div class="pdf-grid">
            <!-- Berthing Rates PDF -->
            <div class="marina-meta-field">
                <label>Berthing Rates PDF</label>
                <div class="pdf-upload-container">
                    <?php if ($berthing_rates_pdf): 
                        $pdf_url = wp_get_attachment_url($berthing_rates_pdf);
                        $pdf_filename = basename(get_attached_file($berthing_rates_pdf));
                    ?>
                        <div class="current-pdf" id="berthing_rates_display">
                            <strong>Current PDF:</strong> 
                            <a href="<?php echo esc_url($pdf_url); ?>" target="_blank"><?php echo esc_html($pdf_filename); ?></a>
                            <button type="button" class="button remove-pdf-btn" data-field="berthing_rates" style="margin-left: 10px;">Remove</button>
                        </div>
                    <?php endif; ?>
                    <button type="button" class="button upload-pdf-btn" data-field="berthing_rates">
                        <?php echo $berthing_rates_pdf ? 'Change PDF' : 'Upload PDF'; ?>
                    </button>
                    <input type="hidden" id="berthing_rates_pdf" name="berthing_rates_pdf" value="<?php echo esc_attr($berthing_rates_pdf); ?>" />
                </div>
            </div>

            <!-- Arrival Procedure PDF -->
            <div class="marina-meta-field">
                <label>Arrival Procedure PDF</label>
                <div class="pdf-upload-container">
                    <?php if ($arrival_procedure_pdf): 
                        $pdf_url = wp_get_attachment_url($arrival_procedure_pdf);
                        $pdf_filename = basename(get_attached_file($arrival_procedure_pdf));
                    ?>
                        <div class="current-pdf" id="arrival_procedure_display">
                            <strong>Current PDF:</strong> 
                            <a href="<?php echo esc_url($pdf_url); ?>" target="_blank"><?php echo esc_html($pdf_filename); ?></a>
                            <button type="button" class="button remove-pdf-btn" data-field="arrival_procedure" style="margin-left: 10px;">Remove</button>
                        </div>
                    <?php endif; ?>
                    <button type="button" class="button upload-pdf-btn" data-field="arrival_procedure">
                        <?php echo $arrival_procedure_pdf ? 'Change PDF' : 'Upload PDF'; ?>
                    </button>
                    <input type="hidden" id="arrival_procedure_pdf" name="arrival_procedure_pdf" value="<?php echo esc_attr($arrival_procedure_pdf); ?>" />
                </div>
            </div>

            <!-- Marina Rules (EN) PDF -->
            <div class="marina-meta-field">
                <label>Marina Rules & Regulations (EN) PDF</label>
                <div class="pdf-upload-container">
                    <?php if ($marina_rules_en_pdf): 
                        $pdf_url = wp_get_attachment_url($marina_rules_en_pdf);
                        $pdf_filename = basename(get_attached_file($marina_rules_en_pdf));
                    ?>
                        <div class="current-pdf" id="marina_rules_en_display">
                            <strong>Current PDF:</strong> 
                            <a href="<?php echo esc_url($pdf_url); ?>" target="_blank"><?php echo esc_html($pdf_filename); ?></a>
                            <button type="button" class="button remove-pdf-btn" data-field="marina_rules_en" style="margin-left: 10px;">Remove</button>
                        </div>
                    <?php endif; ?>
                    <button type="button" class="button upload-pdf-btn" data-field="marina_rules_en">
                        <?php echo $marina_rules_en_pdf ? 'Change PDF' : 'Upload PDF'; ?>
                    </button>
                    <input type="hidden" id="marina_rules_en_pdf" name="marina_rules_en_pdf" value="<?php echo esc_attr($marina_rules_en_pdf); ?>" />
                </div>
            </div>

            <!-- Marina Rules (ID) PDF -->
            <div class="marina-meta-field">
                <label>Marina Rules & Regulations (ID) PDF</label>
                <div class="pdf-upload-container">
                    <?php if ($marina_rules_id_pdf): 
                        $pdf_url = wp_get_attachment_url($marina_rules_id_pdf);
                        $pdf_filename = basename(get_attached_file($marina_rules_id_pdf));
                    ?>
                        <div class="current-pdf" id="marina_rules_id_display">
                            <strong>Current PDF:</strong> 
                            <a href="<?php echo esc_url($pdf_url); ?>" target="_blank"><?php echo esc_html($pdf_filename); ?></a>
                            <button type="button" class="button remove-pdf-btn" data-field="marina_rules_id" style="margin-left: 10px;">Remove</button>
                        </div>
                    <?php endif; ?>
                    <button type="button" class="button upload-pdf-btn" data-field="marina_rules_id">
                        <?php echo $marina_rules_id_pdf ? 'Change PDF' : 'Upload PDF'; ?>
                    </button>
                    <input type="hidden" id="marina_rules_id_pdf" name="marina_rules_id_pdf" value="<?php echo esc_attr($marina_rules_id_pdf); ?>" />
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for PDF Upload -->
    <script>
    jQuery(document).ready(function($) {
        var pdfUploaders = {};
        
        // Upload PDF
        $('.upload-pdf-btn').on('click', function(e) {
            e.preventDefault();
            var fieldName = $(this).data('field');
            var button = $(this);
            
            if (pdfUploaders[fieldName]) {
                pdfUploaders[fieldName].open();
                return;
            }
            
            pdfUploaders[fieldName] = wp.media({
                title: 'Select PDF File',
                library: { type: 'application/pdf' },
                button: { text: 'Use this PDF' },
                multiple: false
            });
            
            pdfUploaders[fieldName].on('select', function() {
                var attachment = pdfUploaders[fieldName].state().get('selection').first().toJSON();
                
                if (attachment.mime !== 'application/pdf') {
                    alert('Please select a PDF file.');
                    return;
                }
                
                $('#' + fieldName + '_pdf').val(attachment.id);
                
                var displayHtml = '<div class="current-pdf" id="' + fieldName + '_display">';
                displayHtml += '<strong>Current PDF:</strong> <a href="' + attachment.url + '" target="_blank">' + attachment.filename + '</a>';
                displayHtml += ' <button type="button" class="button remove-pdf-btn" data-field="' + fieldName + '" style="margin-left: 10px;">Remove</button>';
                displayHtml += '</div>';
                
                $('#' + fieldName + '_display').remove();
                button.before(displayHtml);
                button.text('Change PDF');
            });
            
            pdfUploaders[fieldName].open();
        });
        
        // Remove PDF
        $(document).on('click', '.remove-pdf-btn', function(e) {
            e.preventDefault();
            var fieldName = $(this).data('field');
            $('#' + fieldName + '_pdf').val('');
            $('#' + fieldName + '_display').remove();
            $('.upload-pdf-btn[data-field="' + fieldName + '"]').text('Upload PDF');
        });

        // ===== MARINA GALLERY UPLOADER =====
        var marinaGalleryUploader;

        $('#add_marina_gallery_image').on('click', function(e) {
            e.preventDefault();

            if (marinaGalleryUploader) {
                marinaGalleryUploader.open();
                return;
            }

            marinaGalleryUploader = wp.media({
                title: 'Select Images for Marina Gallery',
                button: {
                    text: 'Add to Gallery'
                },
                multiple: true,
                library: {
                    type: 'image'
                }
            });

            marinaGalleryUploader.on('select', function() {
                var attachments = marinaGalleryUploader.state().get('selection').toJSON();
                var currentCount = $('.marina-gallery-item').length;

                // Add selected images
                attachments.forEach(function(attachment, index) {
                    var imageIndex = currentCount + index;
                    var imageHtml = '<div class="marina-gallery-item" data-id="' + attachment.id + '" style="position: relative; display: inline-block; margin: 5px; cursor: move;">';
                    imageHtml += '<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" style="max-width: 100px; height: 80px; object-fit: cover; border: 2px solid #ddd;" />';
                    imageHtml += '<button type="button" class="remove-marina-gallery-image button" style="position: absolute; top: -5px; right: -5px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1; padding: 0;">×</button>';
                    imageHtml += '<input type="hidden" name="marina_gallery[' + imageIndex + ']" value="' + attachment.id + '">';
                    imageHtml += '</div>';

                    $('.marina-gallery-images').append(imageHtml);
                });
            });

            marinaGalleryUploader.open();
        });

        // Remove marina gallery image
        $(document).on('click', '.remove-marina-gallery-image', function(e) {
            e.preventDefault();
            $(this).closest('.marina-gallery-item').remove();

            // Reindex the remaining images
            $('.marina-gallery-item').each(function(index) {
                $(this).find('input[type="hidden"]').attr('name', 'marina_gallery[' + index + ']');
            });
        });

        // Clear all marina gallery images
        $('#clear_marina_gallery').on('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to clear all gallery images?')) {
                $('.marina-gallery-images').empty();
            }
        });

        // Make marina gallery sortable
        if ($('.marina-gallery-images').length) {
            $('.marina-gallery-images').sortable({
                items: '.marina-gallery-item',
                cursor: 'move',
                update: function() {
                    // Reindex after sorting
                    $('.marina-gallery-item').each(function(index) {
                        $(this).find('input[type="hidden"]').attr('name', 'marina_gallery[' + index + ']');
                    });
                }
            });
        }
    });
    </script>
    <?php
}

/**
 * Save Marina Meta Data
 */
function nirup_save_marina_meta($post_id) {
    // Security checks
    if (!isset($_POST['nirup_marina_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['nirup_marina_meta_box_nonce'], 'nirup_marina_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save Hero Section
    if (isset($_POST['marina_subtitle'])) {
        update_post_meta($post_id, '_marina_subtitle', sanitize_text_field($_POST['marina_subtitle']));
    }

    if (isset($_POST['marina_title'])) {
        update_post_meta($post_id, '_marina_title', sanitize_text_field($_POST['marina_title']));
    }

    // Save Gallery
    if (isset($_POST['marina_gallery'])) {
        $gallery_images = array_map('intval', $_POST['marina_gallery']);
        update_post_meta($post_id, '_marina_gallery', $gallery_images);
    } else {
        delete_post_meta($post_id, '_marina_gallery');
    }

    // Save Berthing Descriptions
    if (isset($_POST['marina_berthing_description_1'])) {
        update_post_meta($post_id, '_marina_berthing_description_1', wp_kses_post($_POST['marina_berthing_description_1']));
    }

    if (isset($_POST['marina_berthing_description_2'])) {
        update_post_meta($post_id, '_marina_berthing_description_2', wp_kses_post($_POST['marina_berthing_description_2']));
    }

    // ============================================
    // NEW: Save PDF files - ADD THIS SECTION
    // ============================================
    if (isset($_POST['berthing_rates_pdf'])) {
        update_post_meta($post_id, '_berthing_rates_pdf', intval($_POST['berthing_rates_pdf']));
    }
    
    if (isset($_POST['arrival_procedure_pdf'])) {
        update_post_meta($post_id, '_arrival_procedure_pdf', intval($_POST['arrival_procedure_pdf']));
    }
    
    if (isset($_POST['marina_rules_en_pdf'])) {
        update_post_meta($post_id, '_marina_rules_en_pdf', intval($_POST['marina_rules_en_pdf']));
    }
    
    if (isset($_POST['marina_rules_id_pdf'])) {
        update_post_meta($post_id, '_marina_rules_id_pdf', intval($_POST['marina_rules_id_pdf']));
    }
    // ============================================

    // Save Private Charters
    if (isset($_POST['marina_charters']) && is_array($_POST['marina_charters'])) {
        $charters = array();
        foreach ($_POST['marina_charters'] as $charter) {
            $charters[] = array(
                'image' => intval($charter['image'] ?? 0),
                'name' => sanitize_text_field($charter['name'] ?? ''),
                'description' => wp_kses_post($charter['description'] ?? ''),
                'bedrooms' => sanitize_text_field($charter['bedrooms'] ?? ''),
                'bathrooms' => sanitize_text_field($charter['bathrooms'] ?? ''),
                'kitchen' => sanitize_text_field($charter['kitchen'] ?? ''),
                'meal_addon' => sanitize_text_field($charter['meal_addon'] ?? ''),
                'length' => sanitize_text_field($charter['length'] ?? ''),
                'capacity' => sanitize_text_field($charter['capacity'] ?? ''),
                'top_speed' => sanitize_text_field($charter['top_speed'] ?? ''),
                'travel_time' => sanitize_text_field($charter['travel_time'] ?? ''),
                'pricing' => wp_kses_post($charter['pricing'] ?? ''),
            );
        }
        update_post_meta($post_id, '_marina_private_charters', $charters);
    } else {
        delete_post_meta($post_id, '_marina_private_charters');
    }
}
add_action('save_post', 'nirup_save_marina_meta');

// ============================================
// PRIVATE CHARTER META BOXES
// ============================================

function nirup_add_charter_meta_boxes() {
    add_meta_box(
        'charter_details',
        '⛵ Private Charter Details',
        'nirup_charter_details_callback',
        'private_charter',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_charter_meta_boxes');

function nirup_charter_details_callback($post) {
    wp_nonce_field('nirup_charter_meta_box', 'nirup_charter_meta_box_nonce');

    $description = get_post_meta($post->ID, '_charter_description', true);
    $specifications = get_post_meta($post->ID, '_charter_specifications', true);
    $specifications = is_array($specifications) ? $specifications : array();
    $pricing = get_post_meta($post->ID, '_charter_pricing', true);
    
    // NEW: Get booking calendar fields
    $calendar_id = get_post_meta($post->ID, '_charter_booking_calendar_id', true);
    $form_id = get_post_meta($post->ID, '_charter_booking_form_id', true);
    ?>

    <style>
        .charter-meta-box .form-group { margin-bottom: 20px; }
        .charter-meta-box label { display: block; font-weight: 600; margin-bottom: 8px; }
        .charter-meta-box input[type="text"],
        .charter-meta-box textarea { width: 100%; padding: 8px; }
        .charter-meta-box textarea { min-height: 100px; }
        .charter-meta-box .description { color: #666; font-style: italic; margin-top: 5px; }
        .spec-item { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9; position: relative; }
        .spec-item h4 { margin: 0 0 10px 0; padding-right: 100px; }
        .remove-spec { position: absolute; top: 15px; right: 15px; }
        .booking-calendar-section { 
            background: #f0f6fc; 
            border: 1px solid #0073aa; 
            padding: 20px; 
            margin: 20px 0; 
            border-radius: 4px; 
        }
        .booking-calendar-section h3 { margin-top: 0; color: #0073aa; }
    </style>

    <div class="charter-meta-box">
        <p><strong>Note:</strong> The charter name is the post title. The featured image is the main charter image.</p>

        <div class="form-group">
            <label for="charter_description">Description</label>
            <textarea id="charter_description" name="charter_description" rows="4"><?php echo esc_textarea($description); ?></textarea>
            <p class="description">Brief description of the charter</p>
        </div>

        <h3>📋 Specifications</h3>
        <p><em>Add specifications below. They will automatically split into two columns on the page.</em></p>
        
        <div id="charter-specifications-container">
            <?php if (!empty($specifications)) : ?>
                <?php foreach ($specifications as $index => $spec) : ?>
                    <div class="spec-item" data-spec-index="<?php echo $index; ?>">
                        <h4>Specification #<?php echo $index + 1; ?></h4>
                        <button type="button" class="button button-secondary remove-spec">Remove</button>
                        
                        <div class="form-group">
                            <label>Specification Text</label>
                            <input type="text" name="charter_specifications[<?php echo $index; ?>][text]" value="<?php echo esc_attr($spec['text'] ?? ''); ?>" placeholder="e.g., 3 bedrooms, Length: 21.58 m, Capacity: 15 Max">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <button type="button" class="button button-primary" id="add-specification">Add Specification</button>

        <h3>💵 Pricing</h3>

        <div class="form-group">
            <label for="charter_pricing">Pricing Information</label>
            <textarea id="charter_pricing" name="charter_pricing" rows="5"><?php echo esc_textarea($pricing); ?></textarea>
            <p class="description">Add pricing details. Use line breaks for multiple routes.</p>
        </div>

        <!-- NEW: Booking Calendar Section -->
        <div class="booking-calendar-section">
            <h3>📅 WP Booking System Calendar</h3>
            
            <div class="form-group">
                <label for="charter_booking_calendar_id">WP Booking Calendar ID</label>
                <input type="text" 
                       id="charter_booking_calendar_id" 
                       name="charter_booking_calendar_id" 
                       value="<?php echo esc_attr($calendar_id); ?>" 
                       placeholder="e.g., 1">
                <p class="description">
                    Enter the WP Booking System calendar ID for this charter.<br>
                    Find it in: <strong>WP Booking System > Calendars</strong>
                </p>
            </div>

            <div class="form-group">
                <label for="charter_booking_form_id">WP Booking Form ID</label>
                <input type="text" 
                       id="charter_booking_form_id" 
                       name="charter_booking_form_id" 
                       value="<?php echo esc_attr($form_id); ?>" 
                       placeholder="e.g., 1">
                <p class="description">
                    Enter the WP Booking System form ID to attach to the calendar.<br>
                    Find it in: <strong>WP Booking System > Forms</strong>
                </p>
            </div>

            <?php if (class_exists('WP_Booking_System')) : ?>
                <p style="padding: 10px; background: #d4edda; border-left: 3px solid #28a745; margin-top: 10px;">
                    ✓ WP Booking System is active
                </p>
            <?php else : ?>
                <p style="padding: 10px; background: #f8d7da; border-left: 3px solid #dc3545; margin-top: 10px;">
                    ⚠ WP Booking System plugin not detected. Please install and activate it.
                </p>
            <?php endif; ?>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        let specIndex = <?php echo count($specifications); ?>;

        // Add Specification
        $('#add-specification').on('click', function() {
            const html = `
                <div class="spec-item" data-spec-index="${specIndex}">
                    <h4>Specification #${specIndex + 1}</h4>
                    <button type="button" class="button button-secondary remove-spec">Remove</button>
                    
                    <div class="form-group">
                        <label>Specification Text</label>
                        <input type="text" name="charter_specifications[${specIndex}][text]" placeholder="e.g., 3 bedrooms, Length: 21.58 m, Capacity: 15 Max">
                    </div>
                </div>
            `;
            $('#charter-specifications-container').append(html);
            specIndex++;
        });

        // Remove Specification
        $(document).on('click', '.remove-spec', function() {
            if (confirm('Are you sure you want to remove this specification?')) {
                $(this).closest('.spec-item').remove();
            }
        });
    });
    </script>
    <?php
}

function nirup_save_charter_meta($post_id) {
    if (!isset($_POST['nirup_charter_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['nirup_charter_meta_box_nonce'], 'nirup_charter_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save Description
    if (isset($_POST['charter_description'])) {
        update_post_meta($post_id, '_charter_description', wp_kses_post($_POST['charter_description']));
    }

    // Save Specifications
    if (isset($_POST['charter_specifications']) && is_array($_POST['charter_specifications'])) {
        $specifications = array();
        foreach ($_POST['charter_specifications'] as $spec) {
            if (!empty($spec['text'])) {
                $specifications[] = array(
                    'text' => sanitize_text_field($spec['text'])
                );
            }
        }
        update_post_meta($post_id, '_charter_specifications', $specifications);
    } else {
        delete_post_meta($post_id, '_charter_specifications');
    }

    // Save Pricing
    if (isset($_POST['charter_pricing'])) {
        update_post_meta($post_id, '_charter_pricing', wp_kses_post($_POST['charter_pricing']));
    }

    // NEW: Save Booking Calendar ID
    if (isset($_POST['charter_booking_calendar_id'])) {
        update_post_meta(
            $post_id, 
            '_charter_booking_calendar_id', 
            sanitize_text_field($_POST['charter_booking_calendar_id'])
        );
    }

    // NEW: Save Booking Form ID
    if (isset($_POST['charter_booking_form_id'])) {
        update_post_meta(
            $post_id, 
            '_charter_booking_form_id', 
            sanitize_text_field($_POST['charter_booking_form_id'])
        );
    }
}
add_action('save_post_private_charter', 'nirup_save_charter_meta');

// ============================================
// VILLA META BOXES
// ============================================

function nirup_add_villa_meta_boxes() {
    add_meta_box(
        'villa_details',
        __('Villa Details', 'nirup-island'),
        'nirup_villa_meta_box_callback',
        'villa',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_villa_meta_boxes');

/**
 * Villa Meta Box Callback
 */
function nirup_villa_meta_box_callback($post) {
    // Add nonce for security
    wp_nonce_field('nirup_save_villa_meta', 'nirup_villa_meta_nonce');
    
    // Get current values
    $villa_category = get_post_meta($post->ID, '_villa_category', true);
    ?>
    
    <div style="margin-bottom: 20px;">
        <label for="villa_category" style="display: block; margin-bottom: 5px; font-weight: 600;">
            <?php _e('Villa Category', 'nirup-island'); ?>
        </label>
        <input 
            type="text" 
            id="villa_category" 
            name="villa_category" 
            value="<?php echo esc_attr($villa_category); ?>" 
            style="width: 100%; max-width: 500px;"
            placeholder="e.g., Riahi Residence, Villa 201"
        />
        <p class="description">
            <?php _e('This appears above the villa type name on the card (e.g., "Riahi Residence, Villa 201").', 'nirup-island'); ?>
        </p>
    </div>
    
    <p style="padding: 15px; background: #f0f0f1; border-left: 4px solid #2271b1;">
        <strong><?php _e('Note:', 'nirup-island'); ?></strong> 
        <?php _e('More villa details (bedrooms, amenities, pricing, etc.) will be added in the next phase when we create the single villa page.', 'nirup-island'); ?>
    </p>
    
    <?php
}

/**
 * Save Villa Meta
 */
function nirup_save_villa_meta($post_id) {
    // Check nonce
    if (!isset($_POST['nirup_villa_meta_nonce']) || 
        !wp_verify_nonce($_POST['nirup_villa_meta_nonce'], 'nirup_save_villa_meta')) {
        return;
    }
    
    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save villa category
    if (isset($_POST['villa_category'])) {
        update_post_meta(
            $post_id,
            '_villa_category',
            sanitize_text_field($_POST['villa_category'])
        );
    }
}
add_action('save_post_villa', 'nirup_save_villa_meta');
function nirup_add_villa_features_meta_box() {
    add_meta_box(
        'villa_features',
        __('Villa Features', 'nirup-island'),
        'nirup_villa_features_meta_box_callback',
        'villa',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_villa_features_meta_box');

/**
 * Villa Features Meta Box Callback
 */
function nirup_villa_features_meta_box_callback($post) {
    wp_nonce_field('nirup_save_villa_features', 'nirup_villa_features_nonce');
    
    $features = get_post_meta($post->ID, '_villa_features', true);
    if (!is_array($features)) {
        $features = array();
    }
    ?>
    
    <div id="villa-features-wrapper">
        <div id="villa-features-list">
            <?php
            if (!empty($features)) {
                foreach ($features as $index => $feature) {
                    ?>
                    <div class="villa-feature-item" style="margin-bottom: 15px; padding: 15px; background: #f9f9f9; border: 1px solid #ddd;">
                        <input 
                            type="text" 
                            name="villa_features[]" 
                            value="<?php echo esc_attr($feature); ?>" 
                            placeholder="e.g., 2 Bedrooms, Swimming Pool, Full Kitchen"
                            style="width: 80%; margin-right: 10px;"
                        />
                        <button type="button" class="button remove-feature">Remove</button>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <button type="button" id="add-feature" class="button button-secondary" style="margin-top: 10px;">
            + Add Feature
        </button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Add feature
        $('#add-feature').on('click', function() {
            var featureHtml = '<div class="villa-feature-item" style="margin-bottom: 15px; padding: 15px; background: #f9f9f9; border: 1px solid #ddd;">' +
                '<input type="text" name="villa_features[]" value="" placeholder="e.g., 2 Bedrooms, Swimming Pool, Full Kitchen" style="width: 80%; margin-right: 10px;" />' +
                '<button type="button" class="button remove-feature">Remove</button>' +
                '</div>';
            $('#villa-features-list').append(featureHtml);
        });
        
        // Remove feature
        $(document).on('click', '.remove-feature', function() {
            $(this).closest('.villa-feature-item').remove();
        });
    });
    </script>
    
    <style>
        .villa-feature-item {
            display: flex;
            align-items: center;
        }
    </style>
    
    <?php
}

/**
 * Save Villa Features
 */
function nirup_save_villa_features($post_id) {
    // Check nonce
    if (!isset($_POST['nirup_villa_features_nonce']) || 
        !wp_verify_nonce($_POST['nirup_villa_features_nonce'], 'nirup_save_villa_features')) {
        return;
    }
    
    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save features
    $features = array();
    if (isset($_POST['villa_features']) && is_array($_POST['villa_features'])) {
        foreach ($_POST['villa_features'] as $feature) {
            $feature = sanitize_text_field($feature);
            if (!empty($feature)) {
                $features[] = $feature;
            }
        }
    }
    
    update_post_meta($post_id, '_villa_features', $features);
}
add_action('save_post_villa', 'nirup_save_villa_features');
function nirup_add_villa_features_with_icons_meta_box() {
    add_meta_box(
        'villa_features',
        __('Villa Features', 'nirup-island'),
        'nirup_villa_features_with_icons_meta_box',
        'villa',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_villa_features_with_icons_meta_box');
add_action('save_post_villa', 'nirup_save_villa_features_with_icons');
function nirup_add_single_villa_meta_boxes() {
    add_meta_box(
        'villa_single_page_content',
        '🏝️ Single Villa Page Content',
        'nirup_villa_single_page_meta_box_callback',
        'villa',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_single_villa_meta_boxes');

/**
 * Single Villa Page Meta Box Callback
 */
function nirup_villa_single_page_meta_box_callback($post) {
    wp_nonce_field('nirup_save_villa_single_page', 'nirup_villa_single_page_nonce');
    
    // Get saved values
    $subtitle = get_post_meta($post->ID, '_villa_subtitle', true);
    $category_title = get_post_meta($post->ID, '_villa_category_title', true);
    $description = get_post_meta($post->ID, '_villa_description', true);
    $features_list = get_post_meta($post->ID, '_villa_features_list', true);
    $booking_url = get_post_meta($post->ID, '_villa_booking_url', true);
    $gallery_images = get_post_meta($post->ID, '_villa_gallery', true);
    $gallery_images = is_array($gallery_images) ? $gallery_images : array();
    ?>
    
    <style>
        .villa-meta-section {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #ddd;
        }
        .villa-meta-section:last-child {
            border-bottom: none;
        }
        .villa-meta-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1d2327;
        }
        .villa-meta-input {
            width: 100%;
            max-width: 100%;
            padding: 8px 12px;
            font-size: 14px;
        }
        .villa-meta-textarea {
            width: 100%;
            min-height: 120px;
            padding: 8px 12px;
            font-size: 14px;
        }
        .villa-meta-description {
            margin-top: 5px;
            color: #646970;
            font-size: 13px;
        }
        .villa-section-title {
            font-size: 14px;
            font-weight: 600;
            color: #1d2327;
            margin: 20px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #2271b1;
        }
        .villa-gallery-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .villa-gallery-item {
            position: relative;
            width: 120px;
            height: 120px;
            border: 2px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }
        .villa-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .villa-gallery-remove {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #dc3232;
            color: white;
            border: none;
            border-radius: 3px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
        }
        .villa-gallery-add {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 120px;
            height: 120px;
            border: 2px dashed #8c8f94;
            border-radius: 4px;
            background: #f6f7f7;
            color: #50575e;
            cursor: pointer;
            transition: all 0.2s;
        }
        .villa-gallery-add:hover {
            border-color: #2271b1;
            background: #f0f0f1;
            color: #2271b1;
        }
    </style>

    <!-- Hero Section -->
    <div class="villa-meta-section">
        <h3 class="villa-section-title">📍 Hero Section</h3>
        
        <div style="margin-bottom: 20px;">
            <label class="villa-meta-label" for="villa_subtitle">
                Subtitle (appears above title)
            </label>
            <input 
                type="text" 
                id="villa_subtitle" 
                name="villa_subtitle" 
                value="<?php echo esc_attr($subtitle); ?>" 
                class="villa-meta-input"
                placeholder="e.g., 2 Bedroom with Pool"
            />
            <p class="villa-meta-description">This text appears above the main villa title</p>
        </div>
    </div>

    <!-- Gallery Section -->
    <div class="villa-meta-section">
        <h3 class="villa-section-title">📸 Gallery Section</h3>
        
        <div>
            <label class="villa-meta-label">Gallery Images</label>
            <p class="villa-meta-description" style="margin-bottom: 15px;">
                The first image will be the main large image, images 2-5 will appear in the grid. 
                Click and drag to reorder.
            </p>
            
            <div id="villa-gallery-container" class="villa-gallery-container">
                <?php foreach ($gallery_images as $image_id) : 
                    $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                    if ($image_url) :
                ?>
                    <div class="villa-gallery-item" data-id="<?php echo esc_attr($image_id); ?>">
                        <img src="<?php echo esc_url($image_url); ?>" alt="">
                        <button type="button" class="villa-gallery-remove" onclick="removeVillaGalleryImage(this)">×</button>
                        <input type="hidden" name="villa_gallery[]" value="<?php echo esc_attr($image_id); ?>">
                    </div>
                <?php 
                    endif;
                endforeach; 
                ?>
                <div class="villa-gallery-add" onclick="openVillaMediaUploader()">
                    <span style="font-size: 40px; line-height: 1;">+</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="villa-meta-section">
        <h3 class="villa-section-title">📝 Main Content Section</h3>
        
        <div style="margin-bottom: 20px;">
            <label class="villa-meta-label" for="villa_category_title">
                Category Title
            </label>
            <input 
                type="text" 
                id="villa_category_title" 
                name="villa_category_title" 
                value="<?php echo esc_attr($category_title); ?>" 
                class="villa-meta-input"
                placeholder="e.g., Your Private Island Retreat"
            />
            <p class="villa-meta-description">Large heading that appears above the description</p>
        </div>

        <div style="margin-bottom: 20px;">
            <label class="villa-meta-label" for="villa_description">
                Main Description
            </label>
            <textarea 
                id="villa_description" 
                name="villa_description" 
                class="villa-meta-textarea"
                placeholder="Enter the main descriptive paragraph about this villa..."
            ><?php echo esc_textarea($description); ?></textarea>
            <p class="villa-meta-description">The main description paragraph (supports HTML)</p>
        </div>

        <div style="margin-bottom: 20px;">
            <label class="villa-meta-label" for="villa_features_list">
                Features List (Bullet Points)
            </label>
            <textarea 
                id="villa_features_list" 
                name="villa_features_list" 
                class="villa-meta-textarea"
                placeholder="Enter features as a bulleted list..."
            ><?php echo esc_textarea($features_list); ?></textarea>
            <p class="villa-meta-description">
                Use HTML list format: &lt;ul&gt;&lt;li&gt;Feature 1&lt;/li&gt;&lt;li&gt;Feature 2&lt;/li&gt;&lt;/ul&gt;
            </p>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        // Make gallery sortable
        $('#villa-gallery-container').sortable({
            items: '.villa-gallery-item',
            cursor: 'move',
            placeholder: 'villa-gallery-placeholder',
            update: function() {
                // Update order in hidden inputs
            }
        });
    });

    let villaMediaUploader;

    function openVillaMediaUploader() {
        if (villaMediaUploader) {
            villaMediaUploader.open();
            return;
        }

        villaMediaUploader = wp.media({
            title: 'Select Villa Gallery Images',
            button: {
                text: 'Add to Gallery'
            },
            multiple: true
        });

        villaMediaUploader.on('select', function() {
            const attachments = villaMediaUploader.state().get('selection').toJSON();
            const container = document.getElementById('villa-gallery-container');
            const addButton = container.querySelector('.villa-gallery-add');

            attachments.forEach(function(attachment) {
                const item = document.createElement('div');
                item.className = 'villa-gallery-item';
                item.setAttribute('data-id', attachment.id);
                item.innerHTML = `
                    <img src="${attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url}" alt="">
                    <button type="button" class="villa-gallery-remove" onclick="removeVillaGalleryImage(this)">×</button>
                    <input type="hidden" name="villa_gallery[]" value="${attachment.id}">
                `;
                container.insertBefore(item, addButton);
            });
        });

        villaMediaUploader.open();
    }

    function removeVillaGalleryImage(button) {
        if (confirm('Remove this image from the gallery?')) {
            button.closest('.villa-gallery-item').remove();
        }
    }
    </script>
    
    <?php
}

/**
 * Save Single Villa Page Meta
 */
function nirup_save_villa_single_page_meta($post_id) {
    // Check nonce
    if (!isset($_POST['nirup_villa_single_page_nonce']) || 
        !wp_verify_nonce($_POST['nirup_villa_single_page_nonce'], 'nirup_save_villa_single_page')) {
        return;
    }
    
    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save all fields
    $fields = array(
        '_villa_subtitle' => 'sanitize_text_field',
        '_villa_category_title' => 'sanitize_text_field',
        '_villa_description' => 'wp_kses_post',
        '_villa_features_list' => 'wp_kses_post',
        '_villa_booking_url' => 'esc_url_raw'
    );
    
    foreach ($fields as $meta_key => $sanitize_callback) {
        $post_key = str_replace('_villa_', 'villa_', $meta_key);
        if (isset($_POST[$post_key])) {
            update_post_meta($post_id, $meta_key, $sanitize_callback($_POST[$post_key]));
        }
    }
    
    // Save gallery
    if (isset($_POST['villa_gallery']) && is_array($_POST['villa_gallery'])) {
        $gallery_images = array_map('intval', $_POST['villa_gallery']);
        update_post_meta($post_id, '_villa_gallery', $gallery_images);
    } else {
        delete_post_meta($post_id, '_villa_gallery');
    }
}
add_action('save_post_villa', 'nirup_save_villa_single_page_meta');
function nirup_add_villa_booking_calendar_field() {
    add_meta_box(
        'villa_booking_calendar',
        '📅 WP Booking System Calendar',
        'nirup_villa_booking_calendar_callback',
        'villa',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_villa_booking_calendar_field');

/**
 * Villa Booking Calendar Meta Box Callback
 */
function nirup_villa_booking_calendar_callback($post) {
    wp_nonce_field('nirup_save_villa_booking_calendar', 'nirup_villa_booking_calendar_nonce');
    
    $calendar_id = get_post_meta($post->ID, '_villa_booking_calendar_id', true);
    $form_id = get_post_meta($post->ID, '_villa_booking_form_id', true);
    ?>
    
    <style>
        .villa-booking-field {
            margin-bottom: 15px;
        }
        .villa-booking-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .villa-booking-input {
            width: 100%;
            padding: 6px 8px;
        }
        .villa-booking-help {
            margin-top: 5px;
            color: #666;
            font-size: 12px;
        }
    </style>

    <div class="villa-booking-field">
        <label class="villa-booking-label" for="villa_booking_calendar_id">
            WP Booking Calendar ID
        </label>
        <input 
            type="text" 
            id="villa_booking_calendar_id" 
            name="villa_booking_calendar_id" 
            value="<?php echo esc_attr($calendar_id); ?>" 
            class="villa-booking-input"
            placeholder="e.g., 1"
        />
        <p class="villa-booking-help">
            Enter the WP Booking System calendar ID for this villa. 
            <br>Find it in: <strong>WP Booking System > Calendars</strong>
        </p>
    </div>

    <div class="villa-booking-field">
        <label class="villa-booking-label" for="villa_booking_form_id">
            WP Booking Form ID
        </label>
        <input 
            type="text" 
            id="villa_booking_form_id" 
            name="villa_booking_form_id" 
            value="<?php echo esc_attr($form_id); ?>" 
            class="villa-booking-input"
            placeholder="e.g., 1"
        />
        <p class="villa-booking-help">
            Enter the WP Booking System form ID to attach to the calendar. 
            <br>Find it in: <strong>WP Booking System > Forms</strong>
        </p>
    </div>

    <?php if (class_exists('WP_Booking_System')) : ?>
        <p style="padding: 10px; background: #d4edda; border-left: 3px solid #28a745; margin-top: 10px;">
            ✓ WP Booking System is active
        </p>
    <?php else : ?>
        <p style="padding: 10px; background: #f8d7da; border-left: 3px solid #dc3545; margin-top: 10px;">
            ⚠ WP Booking System plugin not detected. Please install and activate it.
        </p>
    <?php endif; ?>
    <?php
}

/**
 * Save Villa Booking Calendar Meta
 */
function nirup_save_villa_booking_calendar($post_id) {
    // Check nonce
    if (!isset($_POST['nirup_villa_booking_calendar_nonce']) || 
        !wp_verify_nonce($_POST['nirup_villa_booking_calendar_nonce'], 'nirup_save_villa_booking_calendar')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save Calendar ID
    if (isset($_POST['villa_booking_calendar_id'])) {
        update_post_meta(
            $post_id, 
            '_villa_booking_calendar_id', 
            sanitize_text_field($_POST['villa_booking_calendar_id'])
        );
    }

    // Save Form ID
    if (isset($_POST['villa_booking_form_id'])) {
        update_post_meta(
            $post_id, 
            '_villa_booking_form_id', 
            sanitize_text_field($_POST['villa_booking_form_id'])
        );
    }
}
add_action('save_post_villa', 'nirup_save_villa_booking_calendar');

// ============================================
// EXPERIENCE BOOKING CALENDAR META BOX
// ============================================

function nirup_add_experience_booking_calendar_meta_box() {
    add_meta_box(
        'experience_booking_calendar',
        '📅 WP Booking System Calendar',
        'nirup_experience_booking_calendar_callback',
        'experience',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_experience_booking_calendar_meta_box');

/**
 * Experience Booking Calendar Meta Box Callback
 */
function nirup_experience_booking_calendar_callback($post) {
    wp_nonce_field('nirup_save_experience_booking_calendar', 'nirup_experience_booking_calendar_nonce');
    
    $calendar_id = get_post_meta($post->ID, '_experience_booking_calendar_id', true);
    $form_id = get_post_meta($post->ID, '_experience_booking_form_id', true);
    ?>
    
    <style>
        .experience-booking-field {
            margin-bottom: 15px;
        }
        .experience-booking-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .experience-booking-input {
            width: 100%;
            padding: 6px 8px;
        }
        .experience-booking-help {
            margin-top: 5px;
            color: #666;
            font-size: 12px;
        }
    </style>

    <div class="experience-booking-field">
        <label class="experience-booking-label" for="experience_booking_calendar_id">
            WP Booking Calendar ID
        </label>
        <input 
            type="text" 
            id="experience_booking_calendar_id" 
            name="experience_booking_calendar_id" 
            value="<?php echo esc_attr($calendar_id); ?>" 
            class="experience-booking-input"
            placeholder="e.g., 1"
        />
        <p class="experience-booking-help">
            Enter the WP Booking System calendar ID for this experience. 
            <br>Find it in: <strong>WP Booking System > Calendars</strong>
        </p>
    </div>

    <div class="experience-booking-field">
        <label class="experience-booking-label" for="experience_booking_form_id">
            WP Booking Form ID
        </label>
        <input 
            type="text" 
            id="experience_booking_form_id" 
            name="experience_booking_form_id" 
            value="<?php echo esc_attr($form_id); ?>" 
            class="experience-booking-input"
            placeholder="e.g., 1"
        />
        <p class="experience-booking-help">
            Enter the WP Booking System form ID to attach to the calendar. 
            <br>Find it in: <strong>WP Booking System > Forms</strong>
        </p>
    </div>

    <?php if (class_exists('WP_Booking_System')) : ?>
        <p style="padding: 10px; background: #d4edda; border-left: 3px solid #28a745; margin-top: 10px;">
            ✓ WP Booking System is active
        </p>
    <?php else : ?>
        <p style="padding: 10px; background: #f8d7da; border-left: 3px solid #dc3545; margin-top: 10px;">
            ⚠ WP Booking System plugin not detected. Please install and activate it.
        </p>
    <?php endif; ?>
    <?php
}

/**
 * Save Experience Booking Calendar Data
 */
function nirup_save_experience_booking_calendar($post_id) {
    // Security checks
    if (!isset($_POST['nirup_experience_booking_calendar_nonce']) || 
        !wp_verify_nonce($_POST['nirup_experience_booking_calendar_nonce'], 'nirup_save_experience_booking_calendar')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save Calendar ID
    if (isset($_POST['experience_booking_calendar_id'])) {
        update_post_meta(
            $post_id, 
            '_experience_booking_calendar_id', 
            sanitize_text_field($_POST['experience_booking_calendar_id'])
        );
    }

    // Save Form ID
    if (isset($_POST['experience_booking_form_id'])) {
        update_post_meta(
            $post_id, 
            '_experience_booking_form_id', 
            sanitize_text_field($_POST['experience_booking_form_id'])
        );
    }
}
add_action('save_post_experience', 'nirup_save_experience_booking_calendar');

// ============================================
// MEDIA COVERAGE META BOXES
// ============================================
function nirup_add_media_coverage_meta_boxes() {
    add_meta_box(
        'media_article_details',
        '📰 Media Article Details',
        'nirup_media_article_details_callback',
        'media_coverage',
        'normal',
        'high'
    );
}


add_action('add_meta_boxes', 'nirup_add_media_coverage_meta_boxes');

/**
 * Media Coverage Meta Box Callback
 */
function nirup_media_article_details_callback($post) {
    wp_nonce_field('nirup_media_article_meta_box', 'nirup_media_article_meta_box_nonce');

    $source = get_post_meta($post->ID, '_media_article_source', true);
    $date = get_post_meta($post->ID, '_media_article_date', true);
    $quote = get_post_meta($post->ID, '_media_article_quote', true);
    $link = get_post_meta($post->ID, '_media_article_link', true);
    ?>

    <style>
        .media-article-meta-box .form-group { margin-bottom: 20px; }
        .media-article-meta-box label { display: block; font-weight: 600; margin-bottom: 8px; }
        .media-article-meta-box input[type="text"],
        .media-article-meta-box input[type="url"],
        .media-article-meta-box textarea { width: 100%; padding: 8px; }
        .media-article-meta-box textarea { min-height: 100px; }
        .media-article-meta-box .description { color: #666; font-style: italic; margin-top: 5px; font-size: 13px; }
        .media-article-meta-box .note-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px;
            margin-bottom: 20px;
        }
    </style>

    <div class="media-article-meta-box">
        <div class="note-box">
            <strong>📌 Note:</strong> The article title is the post title above. Enter additional details below.
        </div>

        <div class="form-group">
            <label for="media_article_source">Publication / Author</label>
            <input type="text" 
                   id="media_article_source" 
                   name="media_article_source" 
                   value="<?php echo esc_attr($source); ?>" 
                   placeholder="e.g., Condé Nast Traveller - July 2025">
            <p class="description">Enter the publication name and date (this will be displayed on the page)</p>
        </div>

        <div class="form-group">
            <label for="media_article_date">Date (for sorting)</label>
            <input type="text" 
                   id="media_article_date" 
                   name="media_article_date" 
                   value="<?php echo esc_attr($date); ?>" 
                   placeholder="e.g., 2025-07">
            <p class="description">Format: YYYY-MM (used for sorting articles chronologically)</p>
        </div>

        <div class="form-group">
            <label for="media_article_quote">Article Quote</label>
            <textarea id="media_article_quote" 
                      name="media_article_quote" 
                      rows="4"><?php echo esc_textarea($quote); ?></textarea>
            <p class="description">A memorable quote or excerpt from the article</p>
        </div>

        <div class="form-group">
            <label for="media_article_link">Article URL</label>
            <input type="url" 
                   id="media_article_link" 
                   name="media_article_link" 
                   value="<?php echo esc_url($link); ?>" 
                   placeholder="https://example.com/article">
            <p class="description">The full URL to the article on the external website</p>
        </div>
    </div>

    <?php
}

/**
 * Save Media Coverage Meta Data
 */
function nirup_save_media_coverage_meta($post_id) {
    // Check if our nonce is set and verify it
    if (!isset($_POST['nirup_media_article_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['nirup_media_article_meta_box_nonce'], 'nirup_media_article_meta_box')) {
        return;
    }

    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save the data
    if (isset($_POST['media_article_source'])) {
        update_post_meta($post_id, '_media_article_source', sanitize_text_field($_POST['media_article_source']));
    }

    if (isset($_POST['media_article_date'])) {
        update_post_meta($post_id, '_media_article_date', sanitize_text_field($_POST['media_article_date']));
    }

    if (isset($_POST['media_article_quote'])) {
        update_post_meta($post_id, '_media_article_quote', sanitize_textarea_field($_POST['media_article_quote']));
    }

    if (isset($_POST['media_article_link'])) {
        update_post_meta($post_id, '_media_article_link', esc_url_raw($_POST['media_article_link']));
    }
}
add_action('save_post', 'nirup_save_media_coverage_meta');

// ============================================
// SELLING UNIT META BOXES
// ============================================

function nirup_add_selling_unit_meta_boxes() {
    add_meta_box(
        'selling_unit_details',
        __('Unit Details', 'nirup-island'),
        'nirup_render_selling_unit_details_meta_box',
        'selling_unit',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_selling_unit_meta_boxes');

function nirup_render_selling_unit_details_meta_box($post) {
    wp_nonce_field('nirup_save_selling_unit_details', 'nirup_selling_unit_nonce');
    
    $subtitle = get_post_meta($post->ID, '_unit_subtitle', true);
    $bedrooms = get_post_meta($post->ID, '_unit_bedrooms', true);
    $size = get_post_meta($post->ID, '_unit_size', true);
    $status = get_post_meta($post->ID, '_unit_status', true);
    $price = get_post_meta($post->ID, '_unit_price', true);
    ?>
    
    <table class="form-table">
        <tr>
            <th><label for="unit_subtitle"><?php _e('Subtitle', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="unit_subtitle" name="unit_subtitle" 
                       value="<?php echo esc_attr($subtitle); ?>" class="regular-text"
                       placeholder="e.g., Ocean view villa with private pool">
                <p class="description"><?php _e('Descriptive subtitle shown above the unit title', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="unit_bedrooms"><?php _e('Bedrooms', 'nirup-island'); ?></label></th>
            <td>
                <input type="number" id="unit_bedrooms" name="unit_bedrooms" 
                       value="<?php echo esc_attr($bedrooms); ?>" class="small-text" min="1" max="10">
                <p class="description"><?php _e('Number of bedrooms', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="unit_size"><?php _e('Size (sqm)', 'nirup-island'); ?></label></th>
            <td>
                <input type="number" id="unit_size" name="unit_size" 
                       value="<?php echo esc_attr($size); ?>" class="small-text" min="1">
                <p class="description"><?php _e('Size in square meters', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="unit_status"><?php _e('Status', 'nirup-island'); ?></label></th>
            <td>
                <select id="unit_status" name="unit_status">
                    <option value="Available" <?php selected($status, 'Available'); ?>><?php _e('Available', 'nirup-island'); ?></option>
                    <option value="Reserved" <?php selected($status, 'Reserved'); ?>><?php _e('Reserved', 'nirup-island'); ?></option>
                    <option value="Sold" <?php selected($status, 'Sold'); ?>><?php _e('Sold', 'nirup-island'); ?></option>
                </select>
                <p class="description"><?php _e('Current availability status', 'nirup-island'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="unit_price"><?php _e('Price', 'nirup-island'); ?></label></th>
            <td>
                <input type="text" id="unit_price" name="unit_price" 
                       value="<?php echo esc_attr($price); ?>" class="regular-text"
                       placeholder="e.g., $289,000 USD">
                <p class="description"><?php _e('Display price with currency (e.g., $289,000 USD)', 'nirup-island'); ?></p>
            </td>
        </tr>
    </table>
    
    <?php
}

function nirup_save_selling_unit_details($post_id) {
    if (!isset($_POST['nirup_selling_unit_nonce']) || 
        !wp_verify_nonce($_POST['nirup_selling_unit_nonce'], 'nirup_save_selling_unit_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['unit_subtitle'])) {
        update_post_meta($post_id, '_unit_subtitle', sanitize_text_field($_POST['unit_subtitle']));
    }
    
    if (isset($_POST['unit_bedrooms'])) {
        update_post_meta($post_id, '_unit_bedrooms', absint($_POST['unit_bedrooms']));
    }
    
    if (isset($_POST['unit_size'])) {
        update_post_meta($post_id, '_unit_size', absint($_POST['unit_size']));
    }
    
    if (isset($_POST['unit_status'])) {
        update_post_meta($post_id, '_unit_status', sanitize_text_field($_POST['unit_status']));
    }
    
    if (isset($_POST['unit_price'])) {
        update_post_meta($post_id, '_unit_price', sanitize_text_field($_POST['unit_price']));
    }
}
add_action('save_post_selling_unit', 'nirup_save_selling_unit_details');
function nirup_add_selling_unit_features_meta_box() {
    add_meta_box(
        'selling_unit_features',
        __('Unit Features', 'nirup-island'),
        'nirup_selling_unit_features_meta_box_callback',
        'selling_unit',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_selling_unit_features_meta_box');

/**
 * Selling Unit Features Meta Box Callback
 */
function nirup_selling_unit_features_meta_box_callback($post) {
    wp_nonce_field('nirup_save_selling_unit_features', 'nirup_selling_unit_features_nonce');
    
    $features = get_post_meta($post->ID, '_unit_features', true);
    if (!is_array($features)) {
        $features = array();
    }
    
    $available_icons = nirup_get_villa_feature_icons(); // Use the same icon library
    ?>
    
    <div id="selling-unit-features-wrapper">
        <div id="selling-unit-features-list">
            <?php
            if (!empty($features)) {
                foreach ($features as $index => $feature) {
                    $feature_text = isset($feature['text']) ? $feature['text'] : (is_string($feature) ? $feature : '');
                    $feature_icon = isset($feature['icon']) ? $feature['icon'] : '';
                    
                    nirup_render_selling_unit_feature_row($feature_text, $feature_icon, $available_icons);
                }
            }
            ?>
        </div>
        
        <button type="button" id="add-unit-feature" class="button button-secondary" style="margin-top: 10px;">
            + Add Feature
        </button>
        
        <?php if (empty($available_icons)) : ?>
            <p style="margin-top: 15px; padding: 12px; background: #fff3cd; border-left: 4px solid #ffc107;">
                <strong>No icons available.</strong> 
                <a href="<?php echo admin_url('edit.php?post_type=villa&page=villa-feature-icons'); ?>">Upload icons to the library</a> first.
            </p>
        <?php endif; ?>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Add feature
        $('#add-unit-feature').on('click', function() {
            var featureHtml = <?php echo json_encode(nirup_get_selling_unit_feature_row_html($available_icons)); ?>;
            $('#selling-unit-features-list').append(featureHtml);
        });
        
        // Remove feature
        $(document).on('click', '.remove-unit-feature', function() {
            $(this).closest('.selling-unit-feature-item').remove();
        });
        
        // Icon preview on change
        $(document).on('change', '.unit-feature-icon-select', function() {
            var iconUrl = $(this).find(':selected').data('icon-url');
            var preview = $(this).siblings('.unit-icon-preview');
            
            if (iconUrl) {
                preview.html('<img src="' + iconUrl + '" style="width: 28px; height: 28px;">');
            } else {
                preview.html('<span style="font-size: 20px; color: #a48456;">•</span>');
            }
        });
    });
    </script>
    
    <style>
        .selling-unit-feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            padding: 15px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .unit-icon-preview {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .unit-feature-icon-select {
            width: 200px;
        }
        .unit-feature-text-input {
            flex: 1;
        }
    </style>
    
    <?php
}

/**
 * Render a single selling unit feature row
 */
function nirup_render_selling_unit_feature_row($text = '', $icon = '', $available_icons = array()) {
    ?>
    <div class="selling-unit-feature-item">
        <div class="unit-icon-preview">
            <?php if ($icon && isset($available_icons[$icon])) : ?>
                <img src="<?php echo esc_url($available_icons[$icon]['url']); ?>" style="width: 28px; height: 28px;">
            <?php else : ?>
                <span style="font-size: 20px; color: #a48456;">•</span>
            <?php endif; ?>
        </div>
        
        <select name="unit_features_icon[]" class="unit-feature-icon-select">
            <option value="">No icon (bullet point)</option>
            <?php foreach ($available_icons as $available_icon) : ?>
                <option value="<?php echo esc_attr($available_icon['filename']); ?>" 
                        data-icon-url="<?php echo esc_url($available_icon['url']); ?>"
                        <?php selected($icon, $available_icon['filename']); ?>>
                    <?php echo esc_html($available_icon['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <input 
            type="text" 
            name="unit_features_text[]" 
            value="<?php echo esc_attr($text); ?>" 
            placeholder="e.g., Private Pool, Ocean View, Modern Kitchen"
            class="unit-feature-text-input"
        />
        
        <button type="button" class="button remove-unit-feature">Remove</button>
    </div>
    <?php
}

/**
 * Get HTML for new selling unit feature row
 */
function nirup_get_selling_unit_feature_row_html($available_icons) {
    ob_start();
    nirup_render_selling_unit_feature_row('', '', $available_icons);
    return ob_get_clean();
}

/**
 * Save Selling Unit Features
 */
function nirup_save_selling_unit_features($post_id) {
    if (!isset($_POST['nirup_selling_unit_features_nonce']) || 
        !wp_verify_nonce($_POST['nirup_selling_unit_features_nonce'], 'nirup_save_selling_unit_features')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $features = array();
    
    if (isset($_POST['unit_features_text']) && is_array($_POST['unit_features_text'])) {
        $feature_texts = $_POST['unit_features_text'];
        $feature_icons = isset($_POST['unit_features_icon']) ? $_POST['unit_features_icon'] : array();
        
        foreach ($feature_texts as $index => $text) {
            $text = sanitize_text_field($text);
            if (!empty($text)) {
                $features[] = array(
                    'text' => $text,
                    'icon' => isset($feature_icons[$index]) ? sanitize_file_name($feature_icons[$index]) : ''
                );
            }
        }
    }
    
    update_post_meta($post_id, '_unit_features', $features);
}
add_action('save_post_selling_unit', 'nirup_save_selling_unit_features');

// ============================================
// EVENT OFFER BOOKING CALENDAR META BOX
// ============================================

function nirup_add_event_offer_booking_calendar_meta_box() {
    add_meta_box(
        'event_offer_booking_calendar',
        '📅 WP Booking System Calendar',
        'nirup_event_offer_booking_calendar_callback',
        'event_offer',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'nirup_add_event_offer_booking_calendar_meta_box');

/**
 * Event Offer Booking Calendar Meta Box Callback
 */
function nirup_event_offer_booking_calendar_callback($post) {
    wp_nonce_field('nirup_save_event_offer_booking_calendar', 'nirup_event_offer_booking_calendar_nonce');
    
    $calendar_id = get_post_meta($post->ID, '_event_offer_booking_calendar_id', true);
    $form_id = get_post_meta($post->ID, '_event_offer_booking_form_id', true);
    ?>
    
    <style>
        .event-offer-booking-field {
            margin-bottom: 15px;
        }
        .event-offer-booking-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .event-offer-booking-input {
            width: 100%;
            padding: 6px 8px;
        }
        .event-offer-booking-help {
            margin-top: 5px;
            color: #666;
            font-size: 12px;
        }
        .event-offer-booking-note {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 12px;
        }
    </style>

    <div class="event-offer-booking-note">
        <strong>Note:</strong> If both a booking link and calendar/form are set, the booking link takes priority.
    </div>

    <div class="event-offer-booking-field">
        <label class="event-offer-booking-label" for="event_offer_booking_calendar_id">
            WP Booking Calendar ID
        </label>
        <input 
            type="text" 
            id="event_offer_booking_calendar_id" 
            name="event_offer_booking_calendar_id" 
            value="<?php echo esc_attr($calendar_id); ?>" 
            class="event-offer-booking-input"
            placeholder="e.g., 1"
        />
        <p class="event-offer-booking-help">
            Enter the WP Booking System calendar ID for this event/offer. 
            <br>Find it in: <strong>WP Booking System > Calendars</strong>
        </p>
    </div>

    <div class="event-offer-booking-field">
        <label class="event-offer-booking-label" for="event_offer_booking_form_id">
            WP Booking Form ID
        </label>
        <input 
            type="text" 
            id="event_offer_booking_form_id" 
            name="event_offer_booking_form_id" 
            value="<?php echo esc_attr($form_id); ?>" 
            class="event-offer-booking-input"
            placeholder="e.g., 1"
        />
        <p class="event-offer-booking-help">
            Enter the WP Booking System form ID to attach to the calendar.
            <br>Find it in: <strong>WP Booking System > Forms</strong>
        </p>
    </div>
    <?php
}

/**
 * Save Event Offer Booking Calendar Meta
 */
function nirup_save_event_offer_booking_calendar_meta($post_id) {
    // Verify nonce
    if (!isset($_POST['nirup_event_offer_booking_calendar_nonce']) || 
        !wp_verify_nonce($_POST['nirup_event_offer_booking_calendar_nonce'], 'nirup_save_event_offer_booking_calendar')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save calendar ID
    if (isset($_POST['event_offer_booking_calendar_id'])) {
        update_post_meta($post_id, '_event_offer_booking_calendar_id', sanitize_text_field($_POST['event_offer_booking_calendar_id']));
    }

    // Save form ID
    if (isset($_POST['event_offer_booking_form_id'])) {
        update_post_meta($post_id, '_event_offer_booking_form_id', sanitize_text_field($_POST['event_offer_booking_form_id']));
    }
}
add_action('save_post_event_offer', 'nirup_save_event_offer_booking_calendar_meta');

// ============================================
// ADMIN SCRIPTS FOR META BOXES
// ============================================

function nirup_admin_enqueue_scripts($hook) {
    global $post_type;
    
    // Only load on post edit/new pages for experiences and event_offers
    if ($hook == 'post-new.php' || $hook == 'post.php') {
        if ($post_type == 'experience' || $post_type == 'event_offer') {
            // Enqueue WordPress media library
            wp_enqueue_media();
            
            // Enqueue required scripts
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-sortable');
            
            // Enqueue WordPress media scripts
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
            wp_enqueue_style('thickbox');
        }
    }
}
add_action('admin_enqueue_scripts', 'nirup_admin_enqueue_scripts');
function load_media_scripts_for_event_offers($hook) {
    global $post_type;
    
    if ($hook == 'post.php' || $hook == 'post-new.php') {
        if ($post_type == 'event_offer') {
            wp_enqueue_media();
            wp_enqueue_script('jquery');
        }
    }
}
add_action('admin_enqueue_scripts', 'load_media_scripts_for_event_offers');
