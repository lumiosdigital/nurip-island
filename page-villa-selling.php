<?php
/**
 * Template Name: Villa Selling Options
 * Description: Template for villa selling options page with inquiry form
 */

get_header();

// Get customizer values
$hero_image_id = get_theme_mod('nirup_villa_selling_hero_image');
$hero_image_url = $hero_image_id ? wp_get_attachment_image_url($hero_image_id, 'full') : get_template_directory_uri() . '/assets/images/villa-selling-hero-placeholder.jpg';
$hero_subtitle = get_theme_mod('nirup_villa_selling_hero_subtitle', __('Wake up to the sound of the sea and make Nirup Island your home.', 'nirup-island'));
$hero_title = get_theme_mod('nirup_villa_selling_hero_title', __('Own Your Private Island Retreat', 'nirup-island'));

// Overview section
$overview_col1_heading = get_theme_mod('nirup_villa_selling_overview_col1_heading', __('Own a luxury villa on a private island', 'nirup-island'));
$overview_col2_text = get_theme_mod('nirup_villa_selling_overview_col2_text', __('Riahi Residences offers an exclusive opportunity to own a home on Nirup Island, where refined comfort meets the serenity of the sea. Each villa is designed with open, light-filled spaces that capture the island\'s natural beauty and coastal breeze—creating a sense of effortless relaxation and privacy.

Owners enjoy the convenience of a dedicated marina, allowing yacht owners to berth nearby and stay at their villa with ease.', 'nirup-island'));
$overview_col3_text = get_theme_mod('nirup_villa_selling_overview_col3_text', __('Each residence is professionally maintained through a monthly management fee, with optional services provided by The Westin Nirup Island Resort & Spa, including access to the gym, swimming pool, breakfast, laundry, and housekeeping.

For added flexibility, a rental management programme is available, allowing owners to earn income while their villas are expertly managed in their absence.', 'nirup-island'));

// Features - Hardcoded (can be customized by editing this array)
$features = array(
    array('icon' => 'swimming-pool.svg', 'text' => 'Private Pool*'),
    array('icon' => 'stove.svg', 'text' => 'Fully equipped kitchen'),
    array('icon' => 'double-bed.svg', 'text' => 'Maid\'s Room*'),
    array('icon' => 'armchair.svg', 'text' => 'Fully Furnished')
);

// Form section
$form_heading = get_theme_mod('nirup_villa_selling_form_heading', __('Enquire About Villa Ownership', 'nirup-island'));
$form_description = get_theme_mod('nirup_villa_selling_form_description', __('Experience the freedom of owning a home by the sea. Please fill out the form below and our sales team will contact you within 24 hours.', 'nirup-island'));
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

    <!-- Features Section -->
    <?php if (!empty($features)) : ?>
    <div class="villa-selling-features">
        <?php foreach ($features as $feature) : 
            $icon_filename = isset($feature['icon']) ? $feature['icon'] : '';
            $feature_text = isset($feature['text']) ? $feature['text'] : '';
            $paths = nirup_get_villa_icon_paths();
            $icon_url = $icon_filename ? $paths['url'] . $icon_filename : '';
        ?>
            <div class="villa-selling-feature-item">
                <?php if ($icon_url) : ?>
                    <div class="villa-selling-feature-icon">
                        <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($feature_text); ?>" class="feature-icon-img">
                    </div>
                <?php endif; ?>
                <span class="villa-selling-feature-text"><?php echo esc_html($feature_text); ?></span>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

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
                    $unit_bedrooms = get_post_meta(get_the_ID(), '_unit_bedrooms', true);
                    $unit_size = get_post_meta(get_the_ID(), '_unit_size', true);
                    $unit_status = get_post_meta(get_the_ID(), '_unit_status', true);
                    $unit_price = get_post_meta(get_the_ID(), '_unit_price', true);
                    
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
                            
                            <div class="villa-selling-unit-details">
                                <div class="villa-selling-unit-details-column">
                                    <?php if ($unit_bedrooms) : ?>
                                        <div class="villa-selling-unit-detail-item">
                                            <div class="villa-selling-unit-icon">
                                                <img src="<?php echo esc_url($paths['url'] . 'double-bed.svg'); ?>" alt="Bedrooms">
                                            </div>
                                            <span class="villa-selling-unit-detail-text">Bedrooms: <?php echo esc_html($unit_bedrooms); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($unit_size) : ?>
                                        <div class="villa-selling-unit-detail-item">
                                            <div class="villa-selling-unit-icon">
                                                <img src="<?php echo esc_url($paths['url'] . 'size.svg'); ?>" alt="Size">
                                            </div>
                                            <span class="villa-selling-unit-detail-text">Size: <?php echo esc_html($unit_size); ?> sqm</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="villa-selling-unit-details-column">
                                    <?php if ($unit_status) : ?>
                                        <div class="villa-selling-unit-detail-item">
                                            <div class="villa-selling-unit-icon">
                                                <img src="<?php echo esc_url($paths['url'] . 'info.svg'); ?>" alt="Status">
                                            </div>
                                            <span class="villa-selling-unit-detail-text">Status: <?php echo esc_html($unit_status); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($unit_price) : ?>
                                        <div class="villa-selling-unit-detail-item">
                                            <div class="villa-selling-unit-icon">
                                                <img src="<?php echo esc_url($paths['url'] . 'price-tag.svg'); ?>" alt="Price">
                                            </div>
                                            <span class="villa-selling-unit-detail-text">Price: <?php echo esc_html($unit_price); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
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
                    <select id="villa-language" name="language">
                        <option value="">Choose Language</option>
                        <option value="english">English</option>
                        <option value="arabic">Chinese</option>
                        <option value="french">Indonesian</option>
                    </select>
                </div>
                
                <div class="villa-selling-form-group">
                    <label for="villa-unit">Which villa are you interested in?</label>
                    <select id="villa-unit" name="villa_unit">
                        <option value="">Choose Villa</option>
                        <?php
                        $units_query = new WP_Query(array(
                            'post_type' => 'selling_unit',
                            'posts_per_page' => -1,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        ));
                        while ($units_query->have_posts()) : $units_query->the_post();
                            echo '<option value="' . esc_attr(get_the_title()) . '">' . esc_html(get_the_title()) . '</option>';
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </select>
                </div>
            </div>
            
            <!-- Right Column: Message -->
            <div class="villa-selling-form-column villa-selling-form-column-right">
                <div class="villa-selling-form-group villa-selling-message-group">
                    <label for="villa-message">Message</label>
                    <textarea id="villa-message" name="message" placeholder="Tell us about your requirements or special requests"></textarea>
                </div>
                
                <div class="villa-selling-form-submit-wrapper">
                    <button type="submit" class="villa-selling-submit-btn">
                        <span>Submit Enquiry</span>
                    </button>
                </div>
            </div>
            
            <!-- Form Message (spans both columns) -->
            <div id="villa-form-message" class="form-message"></div>
        </form>
    </div>

</div>

<!-- Thank You Modal -->
<div id="villa-thank-you-modal" class="villa-thank-you-modal">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <div class="modal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#a48456" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        </div>
        <h3 class="modal-title">Thank You!</h3>
        <p class="modal-message">Your enquiry has been received. Our sales team will contact you within 24 hours.</p>
    </div>
</div>

<?php get_footer(); ?>