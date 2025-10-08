<?php
/**
 * Template Name: Getting Here Page
 * 
 * @package Nirup_Island
 */

get_header(); 

// Get all customizer settings
$hero_title = get_theme_mod('nirup_getting_here_hero_title', __('Getting Here', 'nirup-island'));
$hero_subtitle = get_theme_mod('nirup_getting_here_hero_subtitle', __('Find the easiest way to reach Nirup Island', 'nirup-island'));

$ferry_title = get_theme_mod('nirup_getting_here_ferry_title', __('Ferry Departures', 'nirup-island'));
$ferry_subtitle = get_theme_mod('nirup_getting_here_ferry_subtitle', __('Nirup Island is served by direct ferry links from both Singapore & Batam with 12 weekly trips from Singapore and daily trips from Batam.', 'nirup-island'));

$luggage_title = get_theme_mod('nirup_getting_here_luggage_title', __('Luggage Information', 'nirup-island'));
$visa_title = get_theme_mod('nirup_getting_here_visa_title', __('Visa Requirements', 'nirup-island'));
$visa_subtitle = get_theme_mod('nirup_getting_here_visa_subtitle', __('Entering Nirup Island follows the same process as any Indonesian island.', 'nirup-island'));

// Map settings (USES EXISTING CUSTOMIZER SETTINGS from homepage)
$google_maps_api_key = get_theme_mod('nirup_google_maps_api_key', '');
$map_center_lat = get_theme_mod('nirup_map_center_lat', '1.1304753');
$map_center_lng = get_theme_mod('nirup_map_center_lng', '104.0266055');
?>

<main class="getting-here-page-main">
    
    <!-- Breadcrumbs -->
    <?php get_template_part('template-parts/breadcrumbs'); ?>

    <!-- Hero Section -->
    <section class="getting-here-hero">
        <div class="getting-here-hero-container">
            <h1 class="getting-here-hero-title"><?php echo esc_html($hero_title); ?></h1>
            <p class="getting-here-hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
        </div>
    </section>

    <!-- Map Section -->
    <section class="getting-here-map-section">
        <div class="getting-here-page-container">
            <div class="getting-here-map-wrapper">
                <?php if ($google_maps_api_key): ?>
                    <div id="nirup-location-map" class="nirup-location-map"></div>
                <?php else: ?>
                    <iframe
                        width="100%"
                        height="600"
                        frameborder="0"
                        style="border:0"
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255015.89465855814!2d103.70665374999999!3d1.1304753!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwMDcnNDkuNyJOIDEwNMKwMDEnMzUuOCJF!5e0!3m2!1sen!2s!4v1234567890123!5m2!1sen!2s"
                        allowfullscreen>
                    </iframe>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Ferry Departures Section -->
    <section class="ferry-departures-section">
        <div class="getting-here-page-container">
            <h2 class="ferry-departures-title"><?php echo esc_html($ferry_title); ?></h2>
            <p class="ferry-departures-subtitle"><?php echo wp_kses_post(nl2br($ferry_subtitle)); ?></p>
            
            <!-- Singapore Routes -->
            <div class="route-block">
                <div class="route-header">
                    <div class="route-tabs">
                        <button class="route-tab active" data-tab="singapore-to-nirup">
                            <span><?php echo esc_html(get_theme_mod('nirup_singapore_to_nirup_tab', __('Singapore → Nirup', 'nirup-island'))); ?></span>
                        </button>
                        <button class="route-tab" data-tab="nirup-to-singapore">
                            <span><?php echo esc_html(get_theme_mod('nirup_nirup_to_singapore_tab', __('Nirup → Singapore', 'nirup-island'))); ?></span>
                        </button>
                    </div>
                </div>
                
                <div class="route-content-wrapper">
                    
                    <!-- Singapore to Nirup Tab -->
                    <div class="route-tab-content active" id="singapore-to-nirup">
                        <div class="route-departure-point"><?php echo esc_html(get_theme_mod('nirup_singapore_departure_point', __('HarbourFront Centre', 'nirup-island'))); ?></div>
                        
                        <div class="route-table-wrapper">
                            <table class="ferry-schedule-table">
                                <thead>
                                    <tr>
                                        <th><?php echo esc_html(get_theme_mod('nirup_ferry_table_route', __('Route', 'nirup-island'))); ?></th>
                                        <th><?php echo esc_html(get_theme_mod('nirup_ferry_table_etd', __('ETD', 'nirup-island'))); ?></th>
                                        <th><?php echo esc_html(get_theme_mod('nirup_ferry_table_eta', __('ETA', 'nirup-island'))); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo esc_html(get_theme_mod('nirup_singapore_to_nirup_route', __('Singapore → Nirup', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_singapore_to_nirup_etd', __('10:30 (SGT)', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_singapore_to_nirup_eta', __('11:10 (SGT)', 'nirup-island'))); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <!-- Sidebar - EXACTLY 5 items as per Figma -->
                            <div class="route-sidebar">
                                <!-- 1. Operator -->
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <path d="M26 10.5C26 12.7091 21.5228 14.5 16 14.5C10.4772 14.5 6 12.7091 6 10.5M26 10.5C26 8.29086 21.5228 6.5 16 6.5C10.4772 6.5 6 8.29086 6 10.5M26 10.5V17.5C26 19.7091 21.5228 21.5 16 21.5M6 10.5V17.5C6 19.7091 10.4772 21.5 16 21.5M16 21.5L18 25" stroke="#A48456" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_operator_label', __('Operator', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_singapore_operator', __('Horizon Fast Ferry', 'nirup-island'))); ?></p>
                                </div>
                                
                                <!-- 2. Duration -->
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <circle cx="14" cy="14" r="10" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M14 8V14L18 16" stroke="#A48456" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_duration_label', __('Duration', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_singapore_duration', __('50 minutes', 'nirup-island'))); ?></p>
                                </div>
                                
                                <!-- 3. Work Days -->
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <rect x="5" y="6" width="18" height="16" rx="2" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M19 4V8M9 4V8M5 12H23" stroke="#A48456" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_workdays_label', __('Work Days', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_singapore_workdays', __('Friday – Sunday', 'nirup-island'))); ?></p>
                                </div>
                                
                                <!-- 4. Price -->
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <circle cx="19" cy="11" r="5" stroke="#A48456" stroke-width="1.5"/>
                                            <circle cx="8" cy="17" r="5" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M14 13L12 15" stroke="#A48456" stroke-width="1.5"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_price_label', __('Price', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_singapore_price', __('SGD 76 /per way', 'nirup-island'))); ?></p>
                                </div>
                                
                                <!-- 5. Check-in -->
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <rect x="5" y="5" width="18" height="18" rx="2" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M9 14L12 17L19 10" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_checkin_label', __('Check-in', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_singapore_to_nirup_checkin', __('Horizon Fast Ferry Counter (Harbour Front Centre, #03-47)', 'nirup-island'))); ?></p>
                                </div>
                                
                                <button class="book-ticket-btn"><?php echo esc_html(get_theme_mod('nirup_book_ticket_text', __('BOOK FERRY TICKET', 'nirup-island'))); ?></button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nirup to Singapore Tab -->
                    <div class="route-tab-content" id="nirup-to-singapore">
                        <div class="route-departure-point"><?php echo esc_html(get_theme_mod('nirup_nirup_departure_point', __('Nirup Island Ferry Terminal', 'nirup-island'))); ?></div>
                        
                        <div class="route-table-wrapper">
                            <table class="ferry-schedule-table">
                                <thead>
                                    <tr>
                                        <th><?php echo esc_html(get_theme_mod('nirup_ferry_table_route', __('Route', 'nirup-island'))); ?></th>
                                        <th><?php echo esc_html(get_theme_mod('nirup_ferry_table_etd', __('ETD', 'nirup-island'))); ?></th>
                                        <th><?php echo esc_html(get_theme_mod('nirup_ferry_table_eta', __('ETA', 'nirup-island'))); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_singapore_route', __('Nirup → Singapore', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_singapore_etd', __('10:30 (SGT)', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_singapore_eta', __('11:30 (SGT)', 'nirup-island'))); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <div class="route-sidebar">
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <path d="M26 10.5C26 12.7091 21.5228 14.5 16 14.5C10.4772 14.5 6 12.7091 6 10.5M26 10.5C26 8.29086 21.5228 6.5 16 6.5C10.4772 6.5 6 8.29086 6 10.5M26 10.5V17.5C26 19.7091 21.5228 21.5 16 21.5M6 10.5V17.5C6 19.7091 10.4772 21.5 16 21.5M16 21.5L18 25" stroke="#A48456" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_operator_label', __('Operator', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_singapore_operator', __('Horizon Fast Ferry', 'nirup-island'))); ?></p>
                                </div>
                                
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <circle cx="14" cy="14" r="10" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M14 8V14L18 16" stroke="#A48456" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_duration_label', __('Duration', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_singapore_duration', __('50 minutes', 'nirup-island'))); ?></p>
                                </div>
                                
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <rect x="5" y="6" width="18" height="16" rx="2" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M19 4V8M9 4V8M5 12H23" stroke="#A48456" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_workdays_label', __('Work Days', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_singapore_workdays', __('Friday – Sunday', 'nirup-island'))); ?></p>
                                </div>
                                
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <circle cx="19" cy="11" r="5" stroke="#A48456" stroke-width="1.5"/>
                                            <circle cx="8" cy="17" r="5" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M14 13L12 15" stroke="#A48456" stroke-width="1.5"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_price_label', __('Price', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_singapore_price', __('SGD 76 /per way', 'nirup-island'))); ?></p>
                                </div>
                                
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <rect x="5" y="5" width="18" height="18" rx="2" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M9 14L12 17L19 10" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_checkout_label', __('Check-out', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_nirup_to_singapore_checkout', __('45 min before departure', 'nirup-island'))); ?></p>
                                </div>
                                
                                <button class="book-ticket-btn"><?php echo esc_html(get_theme_mod('nirup_book_ticket_text', __('BOOK FERRY TICKET', 'nirup-island'))); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Batam Routes -->
            <div class="route-block">
                <div class="route-header">
                    <div class="route-tabs">
                        <button class="route-tab active" data-tab="batam-to-nirup">
                            <span><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_tab', __('Batam → Nirup', 'nirup-island'))); ?></span>
                        </button>
                        <button class="route-tab" data-tab="nirup-to-batam">
                            <span><?php echo esc_html(get_theme_mod('nirup_nirup_to_batam_tab', __('Nirup → Batam', 'nirup-island'))); ?></span>
                        </button>
                    </div>
                </div>
                
                <div class="route-content-wrapper">
                    <!-- Batam to Nirup Tab -->
                    <div class="route-tab-content active" id="batam-to-nirup">
                        <div class="route-departure-point"><?php echo esc_html(get_theme_mod('nirup_batam_departure_point', __('HarbourBay Ferry Terminal', 'nirup-island'))); ?></div>
                        
                        <div class="route-table-wrapper">
                            <table class="ferry-schedule-table batam-table">
                                <thead>
                                    <tr>
                                        <th><?php echo esc_html(get_theme_mod('nirup_ferry_table_route', __('Route', 'nirup-island'))); ?></th>
                                        <th><?php echo esc_html(get_theme_mod('nirup_ferry_table_etd', __('ETD', 'nirup-island'))); ?></th>
                                        <th><?php echo esc_html(get_theme_mod('nirup_ferry_table_eta', __('ETA', 'nirup-island'))); ?></th>
                                        <th><?php echo esc_html(get_theme_mod('nirup_ferry_table_days', __('Days', 'nirup-island'))); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_route_1', __('Batam → Nirup', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_etd_1', __('09:45 (IDT)', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_eta_1', __('10:05 (IDT)', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_days_1', __('Daily', 'nirup-island'))); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_route_2', __('Batam → Nirup', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_etd_2', __('13:00 (IDT)', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_eta_2', __('13:20 (IDT)', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_days_2', __('Daily', 'nirup-island'))); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_route_3', __('Batam → Nirup', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_etd_3', __('15:30 (IDT)', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_eta_3', __('15:50 (IDT)', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_days_3', __('Fri–Sun', 'nirup-island'))); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <div class="route-sidebar">
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <path d="M26 10.5C26 12.7091 21.5228 14.5 16 14.5C10.4772 14.5 6 12.7091 6 10.5M26 10.5C26 8.29086 21.5228 6.5 16 6.5C10.4772 6.5 6 8.29086 6 10.5M26 10.5V17.5C26 19.7091 21.5228 21.5 16 21.5M6 10.5V17.5C6 19.7091 10.4772 21.5 16 21.5M16 21.5L18 25" stroke="#A48456" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_operator_label', __('Operator', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_batam_operator', __('Reni Fadhila', 'nirup-island'))); ?></p>
                                </div>
                                
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <circle cx="14" cy="14" r="10" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M14 8V14L18 16" stroke="#A48456" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_duration_label', __('Duration', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_batam_duration', __('20 minutes', 'nirup-island'))); ?></p>
                                </div>
                                
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <rect x="5" y="6" width="18" height="16" rx="2" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M19 4V8M9 4V8M5 12H23" stroke="#A48456" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_workdays_label', __('Work Days', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_batam_workdays', __('Daily / Friday – Sunday', 'nirup-island'))); ?></p>
                                </div>
                                
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <circle cx="19" cy="11" r="5" stroke="#A48456" stroke-width="1.5"/>
                                            <circle cx="8" cy="17" r="5" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M14 13L12 15" stroke="#A48456" stroke-width="1.5"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_price_label', __('Price', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_batam_price', __('Rp150,000 /per way', 'nirup-island'))); ?></p>
                                </div>
                                
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <rect x="5" y="5" width="18" height="18" rx="2" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M9 14L12 17L19 10" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_checkin_label', __('Check-in', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_checkin', __('Horizon Fast Ferry counter (Bayfront Mall, 2nd floor)', 'nirup-island'))); ?></p>
                                </div>
                                
                                <button class="book-ticket-btn"><?php echo esc_html(get_theme_mod('nirup_book_ticket_text', __('BOOK FERRY TICKET', 'nirup-island'))); ?></button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nirup to Batam Tab -->
                    <div class="route-tab-content" id="nirup-to-batam">
                        <div class="route-departure-point"><?php echo esc_html(get_theme_mod('nirup_nirup_departure_point', __('Nirup Island Ferry Terminal', 'nirup-island'))); ?></div>
                        
                        <div class="route-table-wrapper">
                            <table class="ferry-schedule-table batam-table">
                                <thead>
                                    <tr>
                                        <th><?php echo esc_html(get_theme_mod('nirup_ferry_table_route', __('Route', 'nirup-island'))); ?></th>
                                        <th><?php echo esc_html(get_theme_mod('nirup_ferry_table_etd', __('ETD', 'nirup-island'))); ?></th>
                                        <th><?php echo esc_html(get_theme_mod('nirup_ferry_table_eta', __('ETA', 'nirup-island'))); ?></th>
                                        <th><?php echo esc_html(get_theme_mod('nirup_ferry_table_days', __('Days', 'nirup-island'))); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_batam_route_1', __('Nirup → Batam', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_batam_etd_1', __('09:00 (IDT)', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_batam_eta_1', __('09:20 (IDT)', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_batam_days_1', __('Daily', 'nirup-island'))); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_batam_route_2', __('Nirup → Batam', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_batam_etd_2', __('14:00 (IDT)', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_batam_eta_2', __('14:20 (IDT)', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_batam_days_2', __('Daily', 'nirup-island'))); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_batam_route_3', __('Nirup → Batam', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_batam_etd_3', __('18:00 (IDT)', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_batam_eta_3', __('18:20 (IDT)', 'nirup-island'))); ?></td>
                                        <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_batam_days_3', __('Fri–Sun', 'nirup-island'))); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <div class="route-sidebar">
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <path d="M26 10.5C26 12.7091 21.5228 14.5 16 14.5C10.4772 14.5 6 12.7091 6 10.5M26 10.5C26 8.29086 21.5228 6.5 16 6.5C10.4772 6.5 6 8.29086 6 10.5M26 10.5V17.5C26 19.7091 21.5228 21.5 16 21.5M6 10.5V17.5C6 19.7091 10.4772 21.5 16 21.5M16 21.5L18 25" stroke="#A48456" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_operator_label', __('Operator', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_batam_operator', __('Reni Fadhila', 'nirup-island'))); ?></p>
                                </div>
                                
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <circle cx="14" cy="14" r="10" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M14 8V14L18 16" stroke="#A48456" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_duration_label', __('Duration', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_batam_duration', __('20 minutes', 'nirup-island'))); ?></p>
                                </div>
                                
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <rect x="5" y="6" width="18" height="16" rx="2" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M19 4V8M9 4V8M5 12H23" stroke="#A48456" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_workdays_label', __('Work Days', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_batam_workdays', __('Daily / Friday – Sunday', 'nirup-island'))); ?></p>
                                </div>
                                
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <circle cx="19" cy="11" r="5" stroke="#A48456" stroke-width="1.5"/>
                                            <circle cx="8" cy="17" r="5" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M14 13L12 15" stroke="#A48456" stroke-width="1.5"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_price_label', __('Price', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_batam_price', __('Rp150,000 /per way', 'nirup-island'))); ?></p>
                                </div>
                                
                                <div class="sidebar-item">
                                    <div class="sidebar-label">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <rect x="5" y="5" width="18" height="18" rx="2" stroke="#A48456" stroke-width="1.5"/>
                                            <path d="M9 14L12 17L19 10" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="label-title"><?php echo esc_html(get_theme_mod('nirup_sidebar_checkout_label', __('Check-out', 'nirup-island'))); ?></span>
                                    </div>
                                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_nirup_to_batam_checkout', __('30 min before departure', 'nirup-island'))); ?></p>
                                </div>
                                
                                <button class="book-ticket-btn"><?php echo esc_html(get_theme_mod('nirup_book_ticket_text', __('BOOK FERRY TICKET', 'nirup-island'))); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <!-- Luggage Information Section -->
    <section class="luggage-info-section">
        <div class="getting-here-page-container">
            <h2 class="section-title"><?php echo esc_html($luggage_title); ?></h2>
            
            <div class="luggage-grid">
                <div class="luggage-block">
                    <h3 class="luggage-block-title"><?php echo esc_html(get_theme_mod('nirup_luggage_singapore_title', __('Singapore Departure', 'nirup-island'))); ?></h3>
                    
                    <div class="luggage-items">
                        <div class="luggage-item">
                            <div class="luggage-icon">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <rect x="8" y="6" width="12" height="16" rx="2" stroke="#A48456" stroke-width="1.5"/>
                                    <path d="M11 6V4M17 6V4M11 22H17" stroke="#A48456" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="luggage-info">
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_free_label', __('Free', 'nirup-island'))); ?></div>
                                <div class="luggage-value"><?php echo esc_html(get_theme_mod('nirup_luggage_singapore_free', __('20 kg / boarding pass', 'nirup-island'))); ?></div>
                            </div>
                        </div>
                        
                        <div class="luggage-item">
                            <div class="luggage-icon">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <path d="M8 14L14 8L20 14M14 8V24" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="luggage-info">
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_excess_label', __('Excess', 'nirup-island'))); ?></div>
                                <div class="luggage-value"><?php echo esc_html(get_theme_mod('nirup_luggage_singapore_excess', __('$1 per kg (max 40 kg)', 'nirup-island'))); ?></div>
                            </div>
                        </div>
                        
                        <div class="luggage-item">
                            <div class="luggage-icon">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <circle cx="14" cy="14" r="10" stroke="#A48456" stroke-width="1.5"/>
                                    <path d="M14 8V14L18 16" stroke="#A48456" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="luggage-info">
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_checkin_label', __('Check-in', 'nirup-island'))); ?></div>
                                <div class="luggage-value"><?php echo esc_html(get_theme_mod('nirup_luggage_singapore_checkin', __('60–20 min before departure', 'nirup-island'))); ?></div>
                            </div>
                        </div>
                        
                        <div class="luggage-item">
                            <div class="luggage-icon">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <rect x="6" y="8" width="16" height="12" rx="2" stroke="#A48456" stroke-width="1.5"/>
                                    <path d="M10 8V6C10 4.89543 10.8954 4 12 4H16C17.1046 4 18 4.89543 18 6V8" stroke="#A48456" stroke-width="1.5"/>
                                </svg>
                            </div>
                            <div class="luggage-info">
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_counters_label', __('Counters', 'nirup-island'))); ?></div>
                                <div class="luggage-value"><?php echo esc_html(get_theme_mod('nirup_luggage_singapore_counters', __('Next to immigration gate', 'nirup-island'))); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="luggage-block">
                    <h3 class="luggage-block-title"><?php echo esc_html(get_theme_mod('nirup_luggage_batam_title', __('Batam Departure', 'nirup-island'))); ?></h3>
                    
                    <div class="luggage-items">
                        <div class="luggage-item">
                            <div class="luggage-icon">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <rect x="8" y="6" width="12" height="16" rx="2" stroke="#A48456" stroke-width="1.5"/>
                                    <path d="M11 6V4M17 6V4M11 22H17" stroke="#A48456" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="luggage-info">
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_free_label', __('Free', 'nirup-island'))); ?></div>
                                <div class="luggage-value"><?php echo esc_html(get_theme_mod('nirup_luggage_batam_free', __('20 kg / boarding pass', 'nirup-island'))); ?></div>
                            </div>
                        </div>
                        
                        <div class="luggage-item">
                            <div class="luggage-icon">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <path d="M8 14L14 8L20 14M14 8V24" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="luggage-info">
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_excess_label', __('Excess', 'nirup-island'))); ?></div>
                                <div class="luggage-value"><?php echo esc_html(get_theme_mod('nirup_luggage_batam_excess', __('$1 per kg (max 40 kg)', 'nirup-island'))); ?></div>
                            </div>
                        </div>
                        
                        <div class="luggage-item">
                            <div class="luggage-icon">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <circle cx="14" cy="14" r="10" stroke="#A48456" stroke-width="1.5"/>
                                    <path d="M14 8V14L18 16" stroke="#A48456" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="luggage-info">
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_checkin_label', __('Check-in', 'nirup-island'))); ?></div>
                                <div class="luggage-value"><?php echo esc_html(get_theme_mod('nirup_luggage_batam_checkin', __('60–20 min before departure', 'nirup-island'))); ?></div>
                            </div>
                        </div>
                        
                        <div class="luggage-item">
                            <div class="luggage-icon">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <rect x="6" y="8" width="16" height="12" rx="2" stroke="#A48456" stroke-width="1.5"/>
                                    <path d="M10 8V6C10 4.89543 10.8954 4 12 4H16C17.1046 4 18 4.89543 18 6V8" stroke="#A48456" stroke-width="1.5"/>
                                </svg>
                            </div>
                            <div class="luggage-info">
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_counters_label', __('Counters', 'nirup-island'))); ?></div>
                                <div class="luggage-value"><?php echo esc_html(get_theme_mod('nirup_luggage_batam_counters', __('Next to immigration gate', 'nirup-island'))); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visa Requirements Section -->
    <section class="visa-requirements-section">
        <div class="getting-here-page-container">
            <h2 class="section-title"><?php echo esc_html($visa_title); ?></h2>
            <p class="section-subtitle"><?php echo esc_html($visa_subtitle); ?></p>
            
            <div class="visa-buttons-wrapper">
                <a href="<?php echo esc_url(get_theme_mod('nirup_visa_free_url', '#')); ?>" class="visa-btn visa-btn-outline"><?php echo esc_html(get_theme_mod('nirup_visa_free_text', __('Visa Free Countries', 'nirup-island'))); ?></a>
                <a href="<?php echo esc_url(get_theme_mod('nirup_visa_on_arrival_url', '#')); ?>" class="visa-btn visa-btn-filled"><?php echo esc_html(get_theme_mod('nirup_visa_on_arrival_text', __('Visa-On-Arrival Countries', 'nirup-island'))); ?></a>
            </div>
        </div>
    </section>

</main>

<?php if ($google_maps_api_key): ?>
<script>
// Pass PHP data to JavaScript
window.nirupMapData = {
    lat: <?php echo floatval($map_center_lat); ?>,
    lng: <?php echo floatval($map_center_lng); ?>
};

// Map initialization (USES EXISTING GOOGLE MAPS SETUP)
function initGettingHereMap() {
    const mapElement = document.getElementById('nirup-location-map');
    if (!mapElement) return;
    
    const nirupLocation = {
        lat: window.nirupMapData.lat,
        lng: window.nirupMapData.lng
    };
    
    const map = new google.maps.Map(mapElement, {
        center: nirupLocation,
        zoom: 10,
        styles: [
            {
                featureType: 'water',
                elementType: 'geometry',
                stylers: [{ color: '#9DD1E8' }]
            },
            {
                featureType: 'landscape',
                elementType: 'geometry',
                stylers: [{ color: '#CBE5C0' }]
            },
            {
                featureType: 'poi',
                stylers: [{ visibility: 'off' }]
            }
        ]
    });
    
    // Create Nirup Island marker (ONLY THE PIN, no routes)
    new google.maps.Marker({
        position: nirupLocation,
        map: map,
        title: 'Nirup Island',
        icon: {
            url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                <svg xmlns="http://www.w3.org/2000/svg" width="47" height="56" viewBox="0 0 47 56" fill="none">
                    <path d="M23.5 0C36.4787 0 47 10.5213 47 23.5C47 36.4787 23.5 56 23.5 56C23.5 56 0 36.4787 0 23.5C0 10.5213 10.5213 0 23.5 0Z" fill="#22284F"/>
                    <circle cx="23.5" cy="23.5" r="8" fill="white"/>
                </svg>
            `),
            scaledSize: new google.maps.Size(47, 56),
            anchor: new google.maps.Point(23.5, 56)
        }
    });
}
</script>
<?php endif; ?>

<script>
// Tab functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.route-tab');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            const parentBlock = this.closest('.route-block');
            
            // Remove active from all tabs in this block
            parentBlock.querySelectorAll('.route-tab').forEach(t => t.classList.remove('active'));
            
            // Remove active from all contents in this block
            parentBlock.querySelectorAll('.route-tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Add active to clicked tab
            this.classList.add('active');
            
            // Show corresponding content
            const targetContent = parentBlock.querySelector(`#${targetTab}`);
            if (targetContent) {
                targetContent.classList.add('active');
            }
        });
    });
});
</script>

<?php get_footer(); ?>