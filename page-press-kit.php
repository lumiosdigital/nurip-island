<?php
/**
 * Template Name: Press Kit
 * 
 * @package Nirup_Island
 */

get_header(); ?>

<div class="press-kit-wrapper">
    <!-- Breadcrumbs -->
    <?php get_template_part('template-parts/breadcrumbs'); ?>

    <!-- Hero Section -->
    <div class="press-kit-hero">
        <div class="press-kit-hero-content">
            <p class="press-kit-subtitle"><?php echo esc_html(get_theme_mod('press_kit_subtitle', 'FOR YOUR MEDIA COVERAGE')); ?></p>
            <h1 class="press-kit-title"><?php echo esc_html(get_theme_mod('press_kit_title', 'Press kit')); ?></h1>
            <div class="press-kit-hero-line"></div>
        </div>
    </div>

    <!-- Description Section -->
    <div class="press-kit-description">
        <div class="press-kit-description-inner">
            <p><?php echo wp_kses_post(get_theme_mod('press_kit_description', 'Welcome to the Nirup Island Press Kit. Here you\'ll find everything you need to cover our story — from official logos and brand assets to high-resolution photos and videos. These materials are free to use for editorial purposes when featuring Nirup Island.')); ?></p>
        </div>
    </div>

    <!-- Cards Section -->
    <div class="press-kit-cards">
        <div class="press-kit-cards-inner">
            <?php
            // Card 1 - Logos
            $card1_image = get_theme_mod('press_kit_card1_image');
            $card1_title = get_theme_mod('press_kit_card1_title', 'Logos');
            $card1_file = get_theme_mod('press_kit_card1_file');
            
            if ($card1_image || $card1_title || $card1_file) :
            ?>
            <div class="press-kit-card">
                <?php if ($card1_image) : ?>
                <div class="press-kit-card-image">
                    <img src="<?php echo esc_url($card1_image); ?>" alt="<?php echo esc_attr($card1_title); ?>">
                </div>
                <?php endif; ?>
                <div class="press-kit-card-content">
                    <h3 class="press-kit-card-title"><?php echo esc_html($card1_title); ?></h3>
                </div>
                <?php if ($card1_file) : ?>
                <a href="<?php echo esc_url($card1_file); ?>" class="press-kit-card-button" download>
                    <span>DOWNLOAD</span>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php
            // Card 2 - Photos
            $card2_image = get_theme_mod('press_kit_card2_image');
            $card2_title = get_theme_mod('press_kit_card2_title', 'Photos');
            $card2_file = get_theme_mod('press_kit_card2_file');
            
            if ($card2_image || $card2_title || $card2_file) :
            ?>
            <div class="press-kit-card">
                <?php if ($card2_image) : ?>
                <div class="press-kit-card-image">
                    <img src="<?php echo esc_url($card2_image); ?>" alt="<?php echo esc_attr($card2_title); ?>">
                </div>
                <?php endif; ?>
                <div class="press-kit-card-content">
                    <h3 class="press-kit-card-title"><?php echo esc_html($card2_title); ?></h3>
                </div>
                <?php if ($card2_file) : ?>
                <a href="<?php echo esc_url($card2_file); ?>" class="press-kit-card-button" download>
                    <span>DOWNLOAD</span>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php
            // Card 3 - Videos
            $card3_image = get_theme_mod('press_kit_card3_image');
            $card3_title = get_theme_mod('press_kit_card3_title', 'Videos');
            $card3_file = get_theme_mod('press_kit_card3_file');
            
            if ($card3_image || $card3_title || $card3_file) :
            ?>
            <div class="press-kit-card">
                <?php if ($card3_image) : ?>
                <div class="press-kit-card-image">
                    <img src="<?php echo esc_url($card3_image); ?>" alt="<?php echo esc_attr($card3_title); ?>">
                </div>
                <?php endif; ?>
                <div class="press-kit-card-content">
                    <h3 class="press-kit-card-title"><?php echo esc_html($card3_title); ?></h3>
                </div>
                <?php if ($card3_file) : ?>
                <a href="<?php echo esc_url($card3_file); ?>" class="press-kit-card-button" download>
                    <span>DOWNLOAD</span>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Press Contacts Section -->
    <div class="press-kit-contacts">
        <div class="press-kit-contacts-inner">
            <h2 class="press-kit-contacts-title"><?php echo esc_html(get_theme_mod('press_kit_contacts_title', 'Press Contacts')); ?></h2>
            <div class="press-kit-contacts-divider"></div>
            <div class="press-kit-contacts-content">
                <p><?php echo esc_html(get_theme_mod('press_kit_contacts_label', 'For media inquiries:')); ?></p>
                <p><?php echo esc_html(get_theme_mod('press_kit_contacts_email', 'Marcomm@citrabuanaprakarsa.com')); ?></p>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>