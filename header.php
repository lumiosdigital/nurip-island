<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <div id="page" class="site">
        <?php 
        // Announcement Bar
        if (get_theme_mod('nirup_announcement_show', true)) :
            $announcement_text = get_theme_mod('nirup_announcement_text', __('Wellness Retreat now available – June to September 2025', 'nirup-island'));
            $announcement_link = get_theme_mod('nirup_announcement_link', '');
        ?>
        <div class="announcement-bar">
            <div class="announcement-content">
                <?php if ($announcement_link) : ?>
                    <a href="<?php echo esc_url($announcement_link); ?>" class="announcement-link">
                <?php endif; ?>
                
                <span class="announcement-text"><?php echo esc_html($announcement_text); ?></span>
                <svg class="announcement-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M3.33398 7.99992H12.6673M12.6673 7.99992L8.00065 3.33325M12.6673 7.99992L8.00065 12.6666" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                
                <?php if ($announcement_link) : ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <header id="masthead" class="site-header">
            <div class="header-container">
                <!-- Left Navigation -->
                <nav class="nav-left">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu-left',
                        'menu_class'     => 'primary-menu-left',
                        'container'      => false,
                        'fallback_cb'    => 'nirup_default_left_menu',
                        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    ));
                    ?>
                </nav>

                <!-- Logo -->
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="custom-logo-wrapper">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                    <?php endif; ?>
                </div>

                <!-- Right Navigation -->
                <nav class="nav-right">
                    <div class="nav-right-items">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'secondary',
                            'menu_id'        => 'secondary-menu',
                            'menu_class'     => 'secondary-menu',
                            'container'      => false,
                            'fallback_cb'    => 'nirup_default_right_menu',
                            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        ));
                        ?>
                        
                        <!-- Language Switcher -->
                        <?php nirup_language_dropdown(); ?>

                        <!-- Check Availability Button -->
                        <button class="check-availability-toggle" aria-label="<?php _e('Check Availability', 'nirup-island'); ?>">
                            <span class="check-availability-text"><?php _e('CHECK AVAILABILITY', 'nirup-island'); ?></span>
                            <svg class="check-availability-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M5.33333 1.33337V4.00004M10.6667 1.33337V4.00004M2 6.66671H14M5.33333 9.33337H5.34M8 9.33337H8.00667M10.6667 9.33337H10.6733M5.33333 12H5.34M8 12H8.00667M10.6667 12H10.6733M3.33333 2.66671H12.6667C13.403 2.66671 14 3.26366 14 4.00004V13.3334C14 14.0698 13.403 14.6667 12.6667 14.6667H3.33333C2.59695 14.6667 2 14.0698 2 13.3334V4.00004C2 3.26366 2.59695 2.66671 3.33333 2.66671Z" stroke="#8B5E1D" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <!-- Booking Button -->
                        <?php 
                        $booking_text = get_theme_mod('nirup_booking_button_text', __('Book Your Stay', 'nirup-island'));
                        $booking_link = get_theme_mod('nirup_booking_button_link', '');
                        if ($booking_text) :
                        ?>
                        <a href="#" class="booking-button">
                            <?php echo esc_html($booking_text); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </nav>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="menu-text"><?php _e('Menu', 'nirup-island'); ?></span>
                    <div class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="mobile-menu" id="mobile-menu">
                <div class="mobile-menu-content">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'mobile-primary-menu',
                        'container'      => false,
                        'fallback_cb'    => 'nirup_mobile_default_menu',
                    ));
                    ?>
                    
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'secondary',
                        'menu_class'     => 'mobile-secondary-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ));
                    ?>
                    
                    <?php if ($booking_text) : ?>
                    <div class="mobile-booking">
                        <a href="#" class="mobile-booking-button">
                            <?php echo esc_html($booking_text); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <?php
        // Yoast Breadcrumbs
        if (function_exists('yoast_breadcrumb') && !is_front_page()) {
            nirup_yoast_breadcrumbs();
        }
        
        // Check Availability Modal (global - available on all pages)
        get_template_part('template-parts/check-availability-modal');
        ?>