<?php
/**
 * Template Name: Villa Selling Page

 */

get_header();

// Get page data
$hero_image_id = get_theme_mod('nirup_villa_selling_hero_image');
$hero_image_url = $hero_image_id ? wp_get_attachment_url($hero_image_id) : '';
$hero_title = get_theme_mod('nirup_villa_selling_hero_title', 'RIAHI RESIDENCES');
$hero_subtitle = get_theme_mod('nirup_villa_selling_hero_subtitle', 'Luxury living on Nirup Island');
$overview_col1_heading = get_theme_mod('nirup_villa_selling_overview_col1_heading', 'OVERVIEW');
$overview_col2_text = get_theme_mod('nirup_villa_selling_overview_col2_text', '');
$overview_col3_text = get_theme_mod('nirup_villa_selling_overview_col3_text', '');
$form_heading = get_theme_mod('nirup_villa_selling_form_heading', 'ENQUIRY FORM');
$form_description = get_theme_mod('nirup_villa_selling_form_description', 'Please fill out the form below to inquire about available units.');
?>

<?php get_template_part('template-parts/breadcrumbs'); ?>

<div class="villa-selling-page">
    
    <!-- Hero Section -->
    <div class="villa-selling-hero">
        <div class="villa-selling-hero-image" style="background-image: url('<?php echo esc_url($hero_image_url); ?>');">
            <div class="villa-selling-hero-overlay"></div>
        </div>
        <div class="villa-selling-hero-content">
            <h1 class="villa-selling-hero-title"><?php echo esc_html($hero_title); ?></h1>
            <p class="villa-selling-hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
        </div>
    </div>

    <!-- Overview Section -->
    <div class="villa-selling-overview">
        <div class="villa-selling-overview-col">
            <p class="villa-selling-overview-heading"><?php echo esc_html($overview_col1_heading); ?></p>
        </div>
        <div class="villa-selling-overview-col">
            <div class="villa-selling-overview-text"><?php echo wpautop(wp_kses_post($overview_col2_text)); ?></div>
        </div>
        <div class="villa-selling-overview-col">
            <div class="villa-selling-overview-text"><?php echo wpautop(wp_kses_post($overview_col3_text)); ?></div>
        </div>
    </div>

    <div class="villa-selling-features">
        <div class="villa-selling-feature-item">
            <div class="villa-selling-feature-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                    <path d="M24.5 6.125V5.25C24.5 3.31975 22.9303 1.75 21 1.75C19.0697 1.75 17.5 3.31975 17.5 5.25V6.125H14.875V5.25C14.875 3.31975 13.3053 1.75 11.375 1.75C9.44475 1.75 7.875 3.31975 7.875 5.25V6.125H1.75V7.875H7.875V17.5C7.875 17.983 8.267 18.375 8.75 18.375C9.233 18.375 9.625 17.983 9.625 17.5V15.75H17.5V17.5C17.5 17.983 17.892 18.375 18.375 18.375C18.858 18.375 19.25 17.983 19.25 17.5V7.875H26.25V6.125H24.5ZM9.625 5.25C9.625 4.28487 10.4099 3.5 11.375 3.5C12.3401 3.5 13.125 4.28487 13.125 5.25V6.125H9.625V5.25ZM9.625 14V11.375H17.5V14H9.625ZM17.5 9.625H9.625V7.875H17.5V9.625ZM19.25 5.25C19.25 4.28487 20.0349 3.5 21 3.5C21.9651 3.5 22.75 4.28487 22.75 5.25V6.125H19.25V5.25Z" fill="#A48456"/>
                    <path d="M22.6712 19.7295C23.8997 19.2448 25.522 18.5141 26.25 18.515V20.2808C25.5124 20.4496 25.4704 20.5056 23.3144 21.357C21.5469 22.0535 19.5431 22.0395 17.8115 21.357L15.6721 20.5126C14.3517 19.9911 12.7741 19.9911 11.4546 20.5126L9.31525 21.357C7.56612 22.0465 5.5615 22.0465 3.81237 21.357C3.39587 21.1934 2.16912 20.699 1.75 20.5634V18.7819C2.21113 18.7819 4.0005 19.551 4.45375 19.7295C5.77413 20.251 7.35175 20.251 8.67125 19.7295L10.8106 18.8851C12.5597 18.1956 14.5644 18.1956 16.3135 18.8851L18.4529 19.7295C19.7741 20.251 21.3509 20.251 22.6712 19.7295Z" fill="#A48456"/>
                    <path d="M22.6712 24.1045C23.8997 23.6198 25.522 22.8891 26.25 22.89V24.6558C25.5124 24.8246 25.4704 24.8806 23.3144 25.732C21.5469 26.4285 19.5431 26.4145 17.8115 25.732L15.6721 24.8876C14.3517 24.3661 12.7741 24.3661 11.4546 24.8876L9.31525 25.732C7.56612 26.4215 5.5615 26.4215 3.81237 25.732C3.39587 25.5684 2.16912 25.074 1.75 24.9384V23.1569C2.21113 23.1569 4.0005 23.926 4.45375 24.1045C5.77413 24.626 7.35175 24.626 8.67125 24.1045L10.8106 23.2601C12.5597 22.5706 14.5644 22.5706 16.3135 23.2601L18.4529 24.1045C19.7741 24.626 21.3509 24.626 22.6712 24.1045Z" fill="#A48456"/>
                </svg>
            </div>
            <span class="villa-selling-feature-text">Private Pool*</span>
        </div>

        <div class="villa-selling-feature-item">
            <div class="villa-selling-feature-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                <path d="M7.875 22.75H20.125C20.6089 22.75 21 22.358 21 21.875V14C21 13.517 20.6089 13.125 20.125 13.125H7.875C7.39113 13.125 7 13.517 7 14V21.875C7 22.358 7.39113 22.75 7.875 22.75ZM8.75 14.875H19.25V21H8.75V14.875Z" fill="#A48456"/>
                <path d="M22.75 4.375H5.25C4.28487 4.375 3.5 5.15987 3.5 6.125V10.5V25.375C3.5 25.858 3.89113 26.25 4.375 26.25H23.625C24.1089 26.25 24.5 25.858 24.5 25.375V10.5V6.125C24.5 5.15987 23.7151 4.375 22.75 4.375ZM5.25 6.125H22.75V9.625H5.25V6.125ZM22.75 24.5H5.25V11.375H22.75V24.5Z" fill="#A48456"/>
                <path d="M9.625 7.875C9.625 8.358 9.233 8.75 8.75 8.75C8.267 8.75 7.875 8.358 7.875 7.875C7.875 7.392 8.267 7 8.75 7C9.233 7 9.625 7.392 9.625 7.875Z" fill="#A48456"/>
                <path d="M20.125 7.875C20.125 8.358 19.733 8.75 19.25 8.75C18.767 8.75 18.375 8.358 18.375 7.875C18.375 7.392 18.767 7 19.25 7C19.733 7 20.125 7.392 20.125 7.875Z" fill="#A48456"/>
                <path d="M16.625 7.875C16.625 8.358 16.2339 8.75 15.75 8.75H12.25C11.7661 8.75 11.375 8.358 11.375 7.875C11.375 7.392 11.7661 7 12.25 7H15.75C16.2339 7 16.625 7.392 16.625 7.875Z" fill="#A48456"/>
                <path d="M6.125 2.625C6.125 2.142 6.51613 1.75 7 1.75H10.5C10.9839 1.75 11.375 2.142 11.375 2.625C11.375 3.108 10.9839 3.5 10.5 3.5H7C6.51613 3.5 6.125 3.108 6.125 2.625Z" fill="#A48456"/>
                <path d="M16.625 2.625C16.625 2.142 17.0161 1.75 17.5 1.75H21C21.4839 1.75 21.875 2.142 21.875 2.625C21.875 3.108 21.4839 3.5 21 3.5H17.5C17.0161 3.5 16.625 3.108 16.625 2.625Z" fill="#A48456"/>
                </svg>
            </div>
            <span class="villa-selling-feature-text">Fully Equipped Kitchen</span>
        </div>

        <div class="villa-selling-feature-item">
            <div class="villa-selling-feature-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                <path d="M24.5 11.536V6.73662C24.5 5.4495 23.5506 4.333 22.2915 4.13875C16.7895 3.29 11.2087 3.29087 5.70412 4.13962C4.44763 4.333 3.5 5.44775 3.5 6.73225V11.536C2.48413 11.8983 1.75 12.8608 1.75 14V23.625C1.75 24.108 2.14113 24.5 2.625 24.5C3.10888 24.5 3.5 24.108 3.5 23.625V21H24.5V23.625C24.5 24.108 24.8911 24.5 25.375 24.5C25.8589 24.5 26.25 24.108 26.25 23.625V14C26.25 12.8608 25.5159 11.8983 24.5 11.536ZM5.25 6.73225C5.25 6.3035 5.55975 5.93162 5.97013 5.86862C11.2989 5.047 16.6994 5.047 22.0246 5.86775C22.4385 5.9325 22.75 6.30612 22.75 6.73662V11.375H21V9.625C21 8.65987 20.2151 7.875 19.25 7.875H16.625C15.6599 7.875 14.875 8.65987 14.875 9.625V11.375H13.125V9.625C13.125 8.65987 12.3401 7.875 11.375 7.875H8.75C7.78487 7.875 7 8.65987 7 9.625V11.375H5.25V6.73225ZM19.25 9.625V11.375H16.625V9.625H19.25ZM11.375 9.625V11.375H8.75V9.625H11.375ZM24.5 19.25H3.5V17.5H24.5V19.25ZM24.5 15.75H3.5V14C3.5 13.5179 3.892 13.125 4.375 13.125H23.625C24.108 13.125 24.5 13.5179 24.5 14V15.75Z" fill="#A48456"/>
                </svg>
            </div>
            <span class="villa-selling-feature-text">Maid's Room*</span>
        </div>

        <div class="villa-selling-feature-item">
            <div class="villa-selling-feature-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="25" viewBox="0 0 26 25" fill="none">
                <path d="M22.8877 6.83594C22.3345 6.83594 21.8159 6.98526 21.3686 7.24468V3.79774C21.3686 1.70367 19.665 0 17.5709 0H8.35503C6.26096 0 4.55729 1.70367 4.55729 3.79774V7.24468C4.11002 6.98526 3.5914 6.83594 3.03819 6.83594C1.36293 6.83594 0 8.19887 0 9.87413C0 10.9706 0.592549 11.9697 1.5191 12.5053V16.7607C1.5191 18.5948 2.82593 20.1292 4.55729 20.482V25H6.07639V20.5584H19.8495V25H21.3686V20.482C23.1 20.1292 24.4068 18.5948 24.4068 16.7607V12.5053C25.3334 11.9697 25.9259 10.9706 25.9259 9.87413C25.9259 8.19887 24.563 6.83594 22.8877 6.83594ZM6.07639 15.2416C6.07639 13.9852 7.09859 12.963 8.35503 12.963H17.5709C18.8273 12.963 19.8495 13.9852 19.8495 15.2416V16.0012H6.07639V15.2416ZM6.07639 3.79774C6.07639 2.5413 7.09859 1.5191 8.35503 1.5191H17.5709C18.8273 1.5191 19.8495 2.5413 19.8495 3.79774V12.2055C19.2144 11.7276 18.4252 11.4439 17.5709 11.4439H8.35503C7.50074 11.4439 6.71157 11.7276 6.07639 12.2055V3.79774ZM23.3941 11.3065L22.8877 11.4855V16.7607C22.8877 18.0172 21.8655 19.0394 20.6091 19.0394H5.31684C4.06039 19.0394 3.03819 18.0172 3.03819 16.7607V11.4855L2.53183 11.3065C1.92611 11.0923 1.5191 10.5167 1.5191 9.87413C1.5191 9.0365 2.20056 8.35503 3.03819 8.35503C3.87582 8.35503 4.55729 9.0365 4.55729 9.87413V17.5203H21.3686V9.87413C21.3686 9.0365 22.0501 8.35503 22.8877 8.35503C23.7254 8.35503 24.4068 9.0365 24.4068 9.87413C24.4068 10.5167 23.9999 11.0923 23.3941 11.3065Z" fill="#A48456"/>
                </svg>
            </div>
            <span class="villa-selling-feature-text">Fully Furnished</span>
        </div>
    </div>

    <!-- Available Units Section Header -->
    <div class="villa-selling-units-header">
        <span class="villa-selling-units-label">Available Units</span>
        <div class="villa-selling-units-divider"></div>
    </div>

    <!-- Available Units Grid -->
    <div class="villa-selling-units-section">
        <div class="villa-selling-units-grid">
            <?php
            // Query selling unit posts
            $units = new WP_Query(array(
                'post_type' => 'selling_unit',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));

            if ($units->have_posts()) :
                while ($units->have_posts()) : $units->the_post();
                    // Get unit meta
                    $unit_subtitle = get_post_meta(get_the_ID(), '_unit_subtitle', true);
                    $unit_features = get_post_meta(get_the_ID(), '_unit_features', true);
                    
                    // Get featured image
                    $featured_image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : get_template_directory_uri() . '/assets/images/unit-placeholder.jpg';
                    
                    // Get icon paths
                    $paths = nirup_get_villa_icon_paths();
                    ?>
                    <div class="villa-selling-unit-card">
                        <div class="villa-selling-unit-image">
                            <img src="<?php echo esc_url($featured_image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                        </div>
                        
                        <div class="villa-selling-unit-content">
                            <?php if ($unit_subtitle) : ?>
                                <p class="villa-selling-unit-subtitle"><?php echo esc_html($unit_subtitle); ?></p>
                            <?php endif; ?>
                            
                            <h3 class="villa-selling-unit-title"><?php echo esc_html(get_the_title()); ?></h3>
                            
                            <!-- DYNAMIC FEATURES FROM META BOX -->
                            <?php if (!empty($unit_features) && is_array($unit_features)) : ?>
                                <div class="villa-selling-unit-details">
                                    <?php 
                                    // Split features into two columns
                                    $total_features = count($unit_features);
                                    $half = ceil($total_features / 2);
                                    $first_column = array_slice($unit_features, 0, $half);
                                    $second_column = array_slice($unit_features, $half);
                                    ?>
                                    
                                    <!-- First Column -->
                                    <div class="villa-selling-unit-details-column">
                                        <?php foreach ($first_column as $feature) : 
                                            $icon_filename = isset($feature['icon']) ? $feature['icon'] : '';
                                            $feature_text = isset($feature['text']) ? $feature['text'] : '';
                                            $icon_url = $icon_filename ? $paths['url'] . $icon_filename : '';
                                        ?>
                                            <div class="villa-selling-unit-detail-item">
                                                <?php if ($icon_url) : ?>
                                                    <div class="villa-selling-unit-icon">
                                                        <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($feature_text); ?>">
                                                    </div>
                                                <?php endif; ?>
                                                <span class="villa-selling-unit-detail-text"><?php echo esc_html($feature_text); ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <!-- Second Column -->
                                    <?php if (!empty($second_column)) : ?>
                                        <div class="villa-selling-unit-details-column">
                                            <?php foreach ($second_column as $feature) : 
                                                $icon_filename = isset($feature['icon']) ? $feature['icon'] : '';
                                                $feature_text = isset($feature['text']) ? $feature['text'] : '';
                                                $icon_url = $icon_filename ? $paths['url'] . $icon_filename : '';
                                            ?>
                                                <div class="villa-selling-unit-detail-item">
                                                    <?php if ($icon_url) : ?>
                                                        <div class="villa-selling-unit-icon">
                                                            <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($feature_text); ?>">
                                                        </div>
                                                    <?php endif; ?>
                                                    <span class="villa-selling-unit-detail-text"><?php echo esc_html($feature_text); ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <p class="no-units-message">No units available at this time.</p>
                <?php
            endif;
            ?>
        </div>
    </div>

    <!-- Enquiry Form Section -->
    <div class="villa-selling-form-section">
        <div class="villa-selling-form-intro">
            <h2 class="villa-selling-form-heading"><?php echo esc_html($form_heading); ?></h2>
            <p class="villa-selling-form-description"><?php echo esc_html($form_description); ?></p>
        </div>
        
        <form id="villa-selling-form" class="villa-selling-form">
            <!-- Left Column: Name, Email, Phone, Language, Villa -->
            <div class="villa-selling-form-column villa-selling-form-column-left">
                <div class="villa-selling-form-group">
                    <label for="villa-name">Name*</label>
                    <input type="text" id="villa-name" name="name" placeholder="Your Name" required>
                </div>
                
                <div class="villa-selling-form-group">
                    <label for="villa-email">E-mail*</label>
                    <input type="email" id="villa-email" name="email" placeholder="Your E-mail" required>
                </div>
                
                <div class="villa-selling-form-group">
                    <label for="villa-phone">Phone*</label>
                    <input type="tel" id="villa-phone" name="phone" placeholder="Your Phone Number" required>
                </div>
                
                <div class="villa-selling-form-group">
                    <label for="villa-language">Preferred Language</label>
                    <input type="text" id="villa-language" name="language" placeholder="e.g., English, Spanish">
                </div>
                
                <div class="villa-selling-form-group">
                    <label for="villa-unit">Interested Villa</label>
                    <select id="villa-unit" name="unit">
                        <option value="">Select a unit</option>
                        <?php
                        $unit_options = new WP_Query(array(
                            'post_type' => 'selling_unit',
                            'posts_per_page' => -1,
                            'post_status' => 'publish',
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        ));
                        
                        if ($unit_options->have_posts()) :
                            while ($unit_options->have_posts()) : $unit_options->the_post();
                                echo '<option value="' . esc_attr(get_the_title()) . '">' . esc_html(get_the_title()) . '</option>';
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </select>
                </div>
            </div>
            
            <!-- Right Column: Message & Submit -->
            <div class="villa-selling-form-column villa-selling-form-column-right">
                <div class="villa-selling-form-group villa-selling-message-group">
                    <label for="villa-message">Message</label>
                    <textarea id="villa-message" name="message" placeholder="Tell us about your requirements..."></textarea>
                </div>
                
                <div>
                    <button type="submit" class="villa-selling-submit-btn">
                        <span class="submit-text">Submit Enquiry</span>
                        <span class="submit-loading" style="display: none;">Sending<span class="dots"></span></span>
                    </button>
                    <small class="recaptcha-note-nirup">
                        This site is protected by reCAPTCHA and the Google
                        <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Privacy Policy</a> and
                        <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Terms of Service</a> apply.
                    </small>                    
                </div>

            </div>
            
            <!-- Form Messages -->
            <div class="form-message" id="villa-form-message"></div>
        </form>
    </div>

    <!-- Thank You Modal -->
    <div id="villaThankYouModal" class="villa-thank-you-modal">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <div class="modal-icon">
                <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="30" cy="30" r="28" stroke="#A48456" stroke-width="4"/>
                    <path d="M18 30L26 38L42 22" stroke="#A48456" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3 class="modal-title">Thank You!</h3>
            <p class="modal-message">Your enquiry has been submitted successfully. We'll get back to you soon.</p>
        </div>
    </div>

</div>

<?php get_footer(); ?>