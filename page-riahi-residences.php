<?php
/**
 * Template Name: Riahi Residences
 * Description: Template for Riahi Residences page with dynamic villa cards
 */

get_header();

// Get customizer values
$hero_image_id = get_theme_mod('nirup_riahi_hero_image');
$hero_image_url = $hero_image_id ? wp_get_attachment_image_url($hero_image_id, 'full') : get_template_directory_uri() . '/assets/images/riahi-hero-placeholder.jpg';
$hero_subtitle = get_theme_mod('nirup_riahi_hero_subtitle', __('Your Private Island Sanctuary', 'nirup-island'));
$hero_title = get_theme_mod('nirup_riahi_hero_title', __('Riahi Residences', 'nirup-island'));
$overview_heading = get_theme_mod('nirup_riahi_overview_heading', __('Overview', 'nirup-island'));
$overview_description = get_theme_mod('nirup_riahi_overview_description', __('Riahi Residences offers a tranquil and spacious retreat, with 2 to 4-bedroom villas designed for comfort and privacy.', 'nirup-island'));
?>

<?php get_template_part('template-parts/breadcrumbs'); ?>

<div class="riahi-residences-page">
    
    <!-- Hero Section -->
<section class="riahi-hero">
    <?php if ($hero_image_url) : ?>
        <img src="<?php echo esc_url($hero_image_url); ?>" 
             alt="<?php echo esc_attr($hero_title); ?>" 
             class="riahi-hero-bg-image">
    <?php endif; ?>
    <div class="riahi-hero-overlay"></div>
    <div class="riahi-hero-content">
        <p class="riahi-hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
        <h1 class="riahi-hero-title"><?php echo esc_html($hero_title); ?></h1>
    </div>
</section>

    <!-- Overview Section -->
    <div class="riahi-overview">
        <p class="riahi-overview-label">ABOUT THE RIAHI RESIDENCES</p>
        <h2 class="riahi-overview-heading"><?php echo esc_html($overview_heading); ?></h2>
        <div class="riahi-overview-description"><?php echo wpautop(wp_kses_post($overview_description)); ?></div>
    </div>

    <!-- Villas Available Section -->
    <div class="riahi-villas-section">
        <h2 class="riahi-villas-heading">Villas Available</h2>
        
        <div class="riahi-villas-grid">
            <?php
            // Query villa posts
            $villas = new WP_Query(array(
                'post_type' => 'villa',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));

            if ($villas->have_posts()) :
                while ($villas->have_posts()) : $villas->the_post();
                    $villa_features = get_post_meta(get_the_ID(), '_villa_features', true);
                    if (!is_array($villa_features)) {
                        $villa_features = array();
                    }
                    
                    // Get featured image
                    $featured_image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'master') : '';
                    ?>
                    
                    <div class="riahi-villa-card">
                        <?php if ($featured_image_url) : ?>
                            <div class="riahi-villa-image">
                                <img src="<?php echo esc_url($featured_image_url); ?>" alt="<?php the_title(); ?>">
                            </div>
                        <?php endif; ?>
                        
                        <div class="riahi-villa-content">
                            <h3 class="riahi-villa-title"><?php the_title(); ?></h3>
                            
                            <?php if (has_excerpt()) : ?>
                                <p class="riahi-villa-description"><?php the_excerpt(); ?></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($villa_features)) : 
                                $paths = nirup_get_villa_icon_paths();
                                ?>
                                <div class="riahi-villa-features">
                                    <?php 
                                    // Split features into columns (max 3 columns)
                                    $features_per_column = 5;
                                    $feature_chunks = array_chunk($villa_features, $features_per_column);
                                    
                                    foreach ($feature_chunks as $chunk) : ?>
                                        <div class="riahi-features-column">
                                            <?php foreach ($chunk as $feature) : 
                                                // Handle both old format (string) and new format (array)
                                                $feature_text = is_array($feature) ? $feature['text'] : $feature;
                                                $feature_icon = is_array($feature) && !empty($feature['icon']) ? $feature['icon'] : '';
                                                $icon_url = $feature_icon ? $paths['url'] . $feature_icon : '';
                                                ?>
                                                <div class="riahi-feature-item">
                                                    <span class="riahi-feature-icon">
                                                        <?php if ($icon_url) : ?>
                                                            <img src="<?php echo esc_url($icon_url); ?>" alt="" class="feature-icon-img">
                                                        <?php else : ?>
                                                            •
                                                        <?php endif; ?>
                                                    </span>
                                                    <span class="riahi-feature-text"><?php echo esc_html($feature_text); ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            

                            <div class="riahi-villa-buttons">
                                <a href="<?php the_permalink(); ?>" class="riahi-button riahi-button-outline">
                                    Discover more
                                </a>
                                <?php 
                                $calendar_id = get_post_meta(get_the_ID(), '_villa_booking_calendar_id', true);
                                if ($calendar_id) : 
                                ?>
                                    <a href="#" class="riahi-button riahi-button-primary nirup-book-btn" data-villa-id="<?php echo get_the_ID(); ?>" data-villa-name="<?php echo esc_attr(get_the_title()); ?>">
                                        Book villa
                                    </a>
                                <?php else : ?>
                                    <a href="<?php the_permalink(); ?>" class="riahi-button riahi-button-primary">
                                        View details
                                    </a>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                    
                    <?php
                endwhile;
                wp_reset_postdata();
            else : ?>
                <div class="no-villas-message">
                    <p>No villas available at the moment. Please check back later.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php 
// Output a modal for each villa using the snippet
$villas_for_modals = new WP_Query(array(
    'post_type' => 'villa',
    'posts_per_page' => -1,
    'post_status' => 'publish',
));

if ($villas_for_modals->have_posts()) :
    while ($villas_for_modals->have_posts()) : $villas_for_modals->the_post();
        get_template_part('template-parts/booking-calendar-modal');
    endwhile;
    wp_reset_postdata();
endif;

// Include thank you modal once
get_template_part('template-parts/thankyou-modal');
?>

<?php get_footer(); ?>