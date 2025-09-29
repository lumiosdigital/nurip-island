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

                        <!-- Search Icon -->
                        <button class="search-toggle" aria-label="<?php _e('Search', 'nirup-island'); ?>">
                            <svg class="search-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" fill="currentColor"/>
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

            <!-- Search Overlay -->
            <div class="search-overlay" id="search-overlay">
                <div class="search-overlay-content">
                    <button class="search-close" aria-label="<?php _e('Close Search', 'nirup-island'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M14 14L11.1067 11.1067M12.6667 7.33333C12.6667 10.2789 10.2789 12.6667 7.33333 12.6667C4.38781 12.6667 2 10.2789 2 7.33333C2 4.38781 4.38781 2 7.33333 2C10.2789 2 12.6667 4.38781 12.6667 7.33333Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="search-form-wrapper">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </div>
        </header>

        <?php
        // Yoast Breadcrumbs
        if (function_exists('yoast_breadcrumb') && !is_front_page()) {
            nirup_yoast_breadcrumbs();
        }
        ?>