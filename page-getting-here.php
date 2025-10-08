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
        
        <!-- Singapore Routes Block -->
        <div class="route-block">
            <!-- Left Column: Tabs + Content -->
            <div class="route-left-column">
                <div class="route-tabs">
                    <button class="route-tab active" data-tab="singapore-to-nirup">
                        <span><?php echo esc_html(get_theme_mod('nirup_singapore_to_nirup_tab', __('Singapore → Nirup', 'nirup-island'))); ?></span>
                    </button>
                    <button class="route-tab" data-tab="nirup-to-singapore">
                        <span><?php echo esc_html(get_theme_mod('nirup_nirup_to_singapore_tab', __('Nirup → Singapore', 'nirup-island'))); ?></span>
                    </button>
                </div>
                
                <!-- Singapore to Nirup Tab -->
                <div class="route-tab-content active" id="singapore-to-nirup">
                    <div class="route-departure-point"><?php echo esc_html(get_theme_mod('nirup_singapore_departure_point', __('HarbourFront Centre', 'nirup-island'))); ?></div>
                    
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
                </div>
                
                <!-- Nirup to Singapore Tab -->
                <div class="route-tab-content" id="nirup-to-singapore">
                    <div class="route-departure-point"><?php echo esc_html(get_theme_mod('nirup_nirup_departure_point', __('Nirup Island Ferry Terminal', 'nirup-island'))); ?></div>
                    
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
                                <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_singapore_etd', __('12:00 (SGT)', 'nirup-island'))); ?></td>
                                <td><?php echo esc_html(get_theme_mod('nirup_nirup_to_singapore_eta', __('12:50 (SGT)', 'nirup-island'))); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Right Column: Sidebar -->
            <div class="route-sidebar">
                <div class="sidebar-item">
                    <div class="sidebar-header">
                        <div class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <g clip-path="url(#clip0_1161_2113)">
                                    <path d="M12.9863 0.956055C13.2536 0.885008 13.5351 1.00237 13.6729 1.24219L22.9668 17.4414C23.0712 17.6236 23.0746 17.8468 22.9756 18.0322C22.8764 18.2177 22.6884 18.3382 22.4785 18.3525L22.4795 18.3535L13.7539 18.9502V19.9434L26.5107 18.9873L26.5957 18.9863C26.7919 18.9987 26.9716 19.1063 27.0762 19.2764C27.1956 19.4708 27.1971 19.7156 27.0791 19.9111L24.418 24.3213C23.3541 26.0841 21.4142 27.1787 19.3555 27.1787H6.92676C4.56751 27.1787 2.43737 25.7804 1.50098 23.6162L1.49805 23.6084C1.49782 23.6077 1.33866 23.1206 1.17969 22.6348C1.10014 22.3916 1.0206 22.1482 0.960938 21.9658C0.931103 21.8746 0.906075 21.7983 0.888672 21.7451C0.880011 21.7186 0.87281 21.6978 0.868164 21.6836C0.865859 21.6765 0.864477 21.6706 0.863281 21.667C0.862733 21.6653 0.861615 21.664 0.861328 21.6631V21.6621L0.860352 21.6602C0.805623 21.4829 0.835034 21.2901 0.939453 21.1367C1.04399 20.983 1.21332 20.8851 1.39844 20.8711L12.5332 20.0361V19.0273L3.88477 19.5234C3.87371 19.5241 3.86192 19.5244 3.84961 19.5244C3.66242 19.5244 3.4862 19.4385 3.37109 19.293L3.3252 19.2266C3.20861 19.031 3.21036 18.7864 3.33008 18.5928L12.5332 3.69727V1.5459C12.5332 1.26929 12.7191 1.02734 12.9863 0.956055ZM2.25195 22.0312L2.44336 22.6494L2.46973 22.7285L15.9844 21.6729C16.3204 21.6471 16.6139 21.8976 16.6406 22.2334C16.6668 22.5695 16.4159 22.8633 16.0801 22.8896L3.05176 23.9082C3.914 25.1747 5.35529 25.958 6.92676 25.958H19.3555C20.9886 25.958 22.5282 25.0887 23.3721 23.6904L24.2451 22.2432L21.8818 22.4287C21.5457 22.4549 21.2518 22.2044 21.2256 21.8682C21.1992 21.5323 21.4502 21.2382 21.7861 21.2119L25.0215 20.958L25.4219 20.292L2.25195 22.0312ZM4.98438 18.2363L12.5332 17.8037V6.01953L4.98438 18.2363ZM13.7539 17.7266L21.4219 17.2021L13.7539 3.83496V17.7266Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                    <path d="M18.5049 21.4746C18.7037 21.4346 18.9127 21.4995 19.0547 21.6406H19.0557C19.0835 21.6684 19.1087 21.6996 19.1309 21.7334L19.1865 21.8389H19.1875C19.2027 21.8756 19.2138 21.9142 19.2217 21.9531C19.2297 21.9929 19.2334 22.0334 19.2334 22.0723C19.2334 22.1112 19.2297 22.1516 19.2217 22.1914L19.1875 22.3057C19.1722 22.3429 19.153 22.378 19.1309 22.4111V22.4121C19.1091 22.4444 19.0842 22.4754 19.0557 22.5039H19.0547C18.9406 22.6173 18.7845 22.6826 18.623 22.6826C18.5837 22.6826 18.5434 22.6788 18.5039 22.6709C18.4642 22.6629 18.4256 22.6508 18.3896 22.6357L18.2852 22.5801C18.2521 22.5582 18.2196 22.5321 18.1914 22.5039C18.1635 22.476 18.1374 22.4449 18.1152 22.4111L18.0596 22.3057C18.0444 22.2692 18.0332 22.2311 18.0254 22.1924L18.0137 22.0723C18.0137 22.0336 18.0171 21.993 18.0254 21.9531L18.0596 21.8389H18.0605C18.0757 21.8021 18.0943 21.7663 18.1162 21.7334C18.1385 21.6994 18.1639 21.6682 18.1914 21.6406C18.2199 21.6119 18.2524 21.5871 18.2852 21.5654V21.5645C18.3179 21.543 18.353 21.524 18.3896 21.5088C18.4256 21.4938 18.4644 21.4813 18.5049 21.4736V21.4746Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_1161_2113">
                                    <rect width="28" height="28" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <p class="sidebar-label"><?php echo esc_html(get_theme_mod('nirup_sidebar_operator_label', __('Operator', 'nirup-island'))); ?></p>
                    </div>
                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_singapore_operator', __('Horizon Fast Ferry', 'nirup-island'))); ?></p>
                </div>
                
                <div class="sidebar-item">
                    <div class="sidebar-header">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M11 5V11L15 13M21 11C21 16.5228 16.5228 21 11 21C5.47715 21 1 16.5228 1 11C1 5.47715 5.47715 1 11 1C16.5228 1 21 5.47715 21 11Z" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <p class="sidebar-label"><?php echo esc_html(get_theme_mod('nirup_sidebar_duration_label', __('Duration', 'nirup-island'))); ?></p>
                    </div>
                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_singapore_duration', __('50 minutes', 'nirup-island'))); ?></p>
                </div>
                
                <div class="sidebar-item">
                    <div class="sidebar-header">
                        <div class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                               <path d="M22.8 4.46667H20.6V3.73333C20.6 3.53884 20.5227 3.35232 20.3852 3.21479C20.2477 3.07726 20.0612 3 19.8667 3C19.6722 3 19.4856 3.07726 19.3481 3.21479C19.2106 3.35232 19.1333 3.53884 19.1333 3.73333V4.46667H8.86667V3.73333C8.86667 3.53884 8.7894 3.35232 8.65188 3.21479C8.51435 3.07726 8.32783 3 8.13333 3C7.93884 3 7.75232 3.07726 7.61479 3.21479C7.47726 3.35232 7.4 3.53884 7.4 3.73333V4.46667H5.2C4.61673 4.46733 4.05753 4.69932 3.64509 5.11176C3.23266 5.5242 3.00066 6.08339 3 6.66667V22.8C3.00066 23.3833 3.23266 23.9425 3.64509 24.3549C4.05753 24.7673 4.61673 24.9993 5.2 25H22.8C23.3833 24.9993 23.9425 24.7673 24.3549 24.3549C24.7673 23.9425 24.9993 23.3833 25 22.8V6.66667C24.9993 6.08339 24.7673 5.5242 24.3549 5.11176C23.9425 4.69932 23.3833 4.46733 22.8 4.46667ZM23.5333 22.8C23.5333 22.9945 23.4561 23.181 23.3185 23.3185C23.181 23.4561 22.9945 23.5333 22.8 23.5333H5.2C5.00551 23.5333 4.81898 23.4561 4.68146 23.3185C4.54393 23.181 4.46667 22.9945 4.46667 22.8V11.8H23.5333V22.8ZM23.5333 10.3333H4.46667V6.66667C4.46667 6.47217 4.54393 6.28565 4.68146 6.14812C4.81898 6.0106 5.00551 5.93333 5.2 5.93333H7.4V6.66667C7.4 6.86116 7.47726 7.04769 7.61479 7.18521C7.75232 7.32274 7.93884 7.4 8.13333 7.4C8.32783 7.4 8.51435 7.32274 8.65188 7.18521C8.7894 7.04769 8.86667 6.86116 8.86667 6.66667V5.93333H19.1333V6.66667C19.1333 6.86116 19.2106 7.04769 19.3481 7.18521C19.4856 7.32274 19.6722 7.4 19.8667 7.4C20.0612 7.4 20.2477 7.32274 20.3852 7.18521C20.5227 7.04769 20.6 6.86116 20.6 6.66667V5.93333H22.8C22.9945 5.93333 23.181 6.0106 23.3185 6.14812C23.4561 6.28565 23.5333 6.47217 23.5333 6.66667V10.3333Z" fill="#A48456"/>
                                <path d="M8 20C8.26522 20 8.51957 19.9122 8.70711 19.7559C8.89464 19.5996 9 19.3877 9 19.1667V15.8333C9 15.6123 8.89464 15.4004 8.70711 15.2441C8.51957 15.0878 8.26522 15 8 15C7.73478 15 7.48043 15.0878 7.29289 15.2441C7.10536 15.4004 7 15.6123 7 15.8333V19.1667C7 19.3877 7.10536 19.5996 7.29289 19.7559C7.48043 19.9122 7.73478 20 8 20Z" fill="#A48456"/>
                                <path d="M14 20C14.2652 20 14.5196 19.9122 14.7071 19.7559C14.8946 19.5996 15 19.3877 15 19.1667V15.8333C15 15.6123 14.8946 15.4004 14.7071 15.2441C14.5196 15.0878 14.2652 15 14 15C13.7348 15 13.4804 15.0878 13.2929 15.2441C13.1054 15.4004 13 15.6123 13 15.8333V19.1667C13 19.3877 13.1054 19.5996 13.2929 19.7559C13.4804 19.9122 13.7348 20 14 20Z" fill="#A48456"/>
                                <path d="M20 20C20.2652 20 20.5196 19.9122 20.7071 19.7559C20.8946 19.5996 21 19.3877 21 19.1667V15.8333C21 15.6123 20.8946 15.4004 20.7071 15.2441C20.5196 15.0878 20.2652 15 20 15C19.7348 15 19.4804 15.0878 19.2929 15.2441C19.1054 15.4004 19 15.6123 19 15.8333V19.1667C19 19.3877 19.1054 19.5996 19.2929 19.7559C19.4804 19.9122 19.7348 20 20 20Z" fill="#A48456"/>
                            </svg>
                        </div>
                        <p class="sidebar-label"><?php echo esc_html(get_theme_mod('nirup_sidebar_workdays_label', __('Work Days', 'nirup-island'))); ?></p>
                    </div>
                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_singapore_workdays', __('Friday – Sunday', 'nirup-island'))); ?></p>
                </div>
                
                <div class="sidebar-item">
                    <div class="sidebar-header">
                        <div class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
                            <path d="M16.2227 0.900391C18.4864 0.900391 20.6256 1.15957 22.2451 1.63379C23.1618 1.90221 23.8711 2.23021 24.3535 2.61035C24.8371 2.99141 25.1005 3.43261 25.1006 3.92383C25.1006 4.41508 24.8371 4.85623 24.3535 5.2373C23.8711 5.61746 23.1618 5.94544 22.2451 6.21387C20.6256 6.68808 18.4864 6.94824 16.2227 6.94824C13.9591 6.94821 11.8206 6.68805 10.2012 6.21387C9.28451 5.94544 8.57522 5.61746 8.09277 5.2373C7.60917 4.85622 7.3457 4.41509 7.3457 3.92383C7.34574 3.43261 7.60921 2.99141 8.09277 2.61035C8.57522 2.23023 9.28458 1.9022 10.2012 1.63379C11.8206 1.15962 13.9591 0.900421 16.2227 0.900391ZM16.2227 2.09961C14.0642 2.09964 12.0452 2.34478 10.5381 2.78613C9.72808 3.02335 9.22285 3.27337 8.92285 3.48633C8.773 3.59274 8.67627 3.68864 8.61816 3.7666C8.55888 3.84625 8.54496 3.89968 8.54492 3.92383C8.54492 3.94796 8.55859 4.0021 8.61816 4.08203C8.67627 4.15994 8.77317 4.25503 8.92285 4.36133C9.22287 4.5743 9.72796 4.82526 10.5381 5.0625C12.0453 5.50385 14.0643 5.74802 16.2227 5.74805C18.3809 5.74805 20.4 5.50374 21.9072 5.0625C22.7174 4.82526 23.2224 4.57429 23.5225 4.36133C23.6724 4.25488 23.77 4.16002 23.8281 4.08203C23.8877 4.0021 23.9004 3.94797 23.9004 3.92383C23.9004 3.89968 23.8873 3.84618 23.8281 3.7666C23.77 3.68859 23.6725 3.59282 23.5225 3.48633C23.2224 3.27337 22.7173 3.02333 21.9072 2.78613C20.4 2.34481 18.3811 2.09961 16.2227 2.09961Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                            <path d="M8.54492 6.80664V6.90625C8.54492 6.93042 8.55859 6.98449 8.61816 7.06445C8.67627 7.14238 8.77319 7.23744 8.92285 7.34375C9.22292 7.5568 9.72872 7.80762 10.5391 8.04492C12.0465 8.48631 14.0652 8.73047 16.2236 8.73047C18.382 8.73046 20.4009 8.48639 21.9082 8.04492C22.7184 7.80761 23.2234 7.55678 23.5234 7.34375C23.6731 7.23745 23.77 7.14239 23.8281 7.06445C23.8877 6.9845 23.9014 6.93042 23.9014 6.90625V6.80664H25.1016V6.90625C25.1016 7.39743 24.8379 7.83865 24.3545 8.21973C23.872 8.59996 23.1619 8.9278 22.2451 9.19629C20.6257 9.67057 18.4872 9.93066 16.2236 9.93066C13.9598 9.93066 11.8208 9.6706 10.2012 9.19629C9.28452 8.92781 8.57522 8.59993 8.09277 8.21973C7.60914 7.83858 7.3457 7.39756 7.3457 6.90625V6.80664H8.54492Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                            <path d="M25.0977 9.7334V9.83301C25.0977 10.3243 24.8342 10.7653 24.3506 11.1465C23.8681 11.5267 23.1589 11.8546 22.2422 12.123C20.6228 12.5973 18.4843 12.8574 16.2207 12.8574C15.8213 12.8574 15.4274 12.8496 15.0508 12.834L14.9502 12.8301L14.9551 12.7295L14.9961 11.7305L15 11.6309L15.1006 11.6348C15.4605 11.6497 15.8376 11.6572 16.2207 11.6572C18.379 11.6572 20.3981 11.4131 21.9053 10.9717C22.7154 10.7344 23.2205 10.4835 23.5205 10.2705C23.6702 10.1642 23.7671 10.0691 23.8252 9.99121C23.8848 9.91126 23.8984 9.85718 23.8984 9.83301V9.7334H25.0977Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                            <path d="M25.1006 12.6582V12.7578C25.1006 13.249 24.8369 13.6902 24.3535 14.0713C23.871 14.4515 23.1609 14.7793 22.2441 15.0479C20.6247 15.5221 18.4862 15.7822 16.2227 15.7822H16.123V14.582H16.2227C18.3811 14.582 20.3999 14.3379 21.9072 13.8965C22.7175 13.6592 23.2224 13.4084 23.5225 13.1953C23.6722 13.089 23.769 12.994 23.8271 12.916C23.8867 12.8361 23.9004 12.782 23.9004 12.7578V12.6582H25.1006Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                            <path d="M25.1006 4.07812V15.6855C25.1006 16.2123 24.8023 16.6606 24.3154 17.0322C23.829 17.4034 23.1429 17.7074 22.3379 17.9502C20.7268 18.436 18.6106 18.6831 16.5762 18.708C16.4594 18.7095 16.3407 18.71 16.2227 18.71H16.123V17.5107H16.2227C16.3356 17.5107 16.4489 17.5103 16.5605 17.5088C18.9949 17.479 20.8452 17.1583 22.083 16.7686C22.7022 16.5736 23.1652 16.3629 23.4707 16.1641C23.6236 16.0646 23.7338 15.9703 23.8047 15.8857C23.8766 15.8 23.9004 15.7324 23.9004 15.6855V4.07812H25.1006Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                            <path d="M8.54492 4.07812V9.54688H7.3457V4.07812H8.54492Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                            <path d="M9.11816 8.73047C13.6494 8.73047 17.3369 12.4015 17.3369 16.915C17.3368 21.4286 13.6493 25.0996 9.11816 25.0996C4.58701 25.0995 0.9005 21.4285 0.900391 16.915C0.900391 12.4015 4.58695 8.73053 9.11816 8.73047ZM9.11816 9.92969C5.24794 9.92975 2.09961 13.0642 2.09961 16.915C2.09974 20.7658 5.24807 23.8994 9.11816 23.8994C12.9883 23.8994 16.1366 20.7658 16.1367 16.915C16.1367 13.0642 12.9884 9.92969 9.11816 9.92969Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                            <path d="M9.55664 16.2393C10.2104 16.5058 10.7147 16.8093 11.0547 17.1953C11.3972 17.5844 11.5683 18.0515 11.5684 18.6328C11.5684 19.6555 10.8692 20.6049 9.58203 20.8516V22.1787H8.68945V22.0791H8.58984V20.9023C7.87661 20.8725 7.14759 20.6512 6.70801 20.3379L6.64551 20.2939L6.67188 20.2227L6.97363 19.3799L7.0166 19.2598L7.12305 19.3301C7.55999 19.6215 8.19489 19.8535 8.87793 19.8535C9.3054 19.8535 9.65598 19.7302 9.89746 19.5293C10.1375 19.3296 10.2753 19.0496 10.2754 18.7217C10.2754 18.4036 10.1636 18.1483 9.94238 17.9258C9.71753 17.6997 9.37677 17.5052 8.91602 17.3184V17.3174C8.27219 17.0648 7.73886 16.7894 7.36621 16.4316C6.98911 16.0695 6.77833 15.6253 6.77832 15.0498C6.77832 13.9745 7.52896 13.1631 8.67773 12.9434V11.6553H9.65723V12.8809C10.3768 12.9197 10.8798 13.1157 11.2422 13.3281L11.3154 13.3711L11.2852 13.4502L10.9707 14.2803L10.9297 14.3896L10.8281 14.332C10.571 14.1845 10.0724 13.918 9.29297 13.918C8.82943 13.918 8.52366 14.0559 8.33398 14.2412C8.14356 14.4274 8.06064 14.6706 8.06055 14.8984C8.06055 15.1949 8.16333 15.4132 8.39551 15.6152C8.63481 15.8233 9.01043 16.0132 9.55664 16.2393Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                            </svg>
                        </div>
                        <p class="sidebar-label"><?php echo esc_html(get_theme_mod('nirup_sidebar_price_label', __('Price', 'nirup-island'))); ?></p>
                    </div>
                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_singapore_price', __('SGD 76 /per way', 'nirup-island'))); ?></p>
                </div>
                
                <div class="sidebar-item">
                    <div class="sidebar-header">
                        <div class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                            <path d="M8.5 10.8333L12 14.3333L23.6667 2.66667M22.5 12V20.1667C22.5 20.7855 22.2542 21.379 21.8166 21.8166C21.379 22.2542 20.7855 22.5 20.1667 22.5H3.83333C3.21449 22.5 2.621 22.2542 2.18342 21.8166C1.74583 21.379 1.5 20.7855 1.5 20.1667V3.83333C1.5 3.21449 1.74583 2.621 2.18342 2.18342C2.621 1.74583 3.21449 1.5 3.83333 1.5H16.6667" stroke="#A48456" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <p class="sidebar-label"><?php echo esc_html(get_theme_mod('nirup_sidebar_checkin_label', __('Check-in', 'nirup-island'))); ?></p>
                    </div>
                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_singapore_to_nirup_checkin', __('Horizon Fast Ferry Counter (Harbour Front Centre, #03-47)', 'nirup-island'))); ?></p>
                </div>
                
                <button class="book-ticket-btn"><?php echo esc_html(get_theme_mod('nirup_book_ticket_text', __('BOOK FERRY TICKET', 'nirup-island'))); ?></button>
            </div>
        </div>
        
        <!-- Batam Routes Block -->
        <div class="route-block">
            <!-- Left Column: Tabs + Content -->
            <div class="route-left-column">
                <div class="route-tabs">
                    <button class="route-tab active" data-tab="batam-to-nirup">
                        <span><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_tab', __('Batam → Nirup', 'nirup-island'))); ?></span>
                    </button>
                    <button class="route-tab" data-tab="nirup-to-batam">
                        <span><?php echo esc_html(get_theme_mod('nirup_nirup_to_batam_tab', __('Nirup → Batam', 'nirup-island'))); ?></span>
                    </button>
                </div>
                
                <!-- Batam to Nirup Tab -->
                <div class="route-tab-content active" id="batam-to-nirup">
                    <div class="route-departure-point"><?php echo esc_html(get_theme_mod('nirup_batam_departure_point', __('HarbourBay Ferry Terminal', 'nirup-island'))); ?></div>
                    
                    <table class="ferry-schedule-table">
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
                </div>
                
                <!-- Nirup to Batam Tab -->
                <div class="route-tab-content" id="nirup-to-batam">
                    <div class="route-departure-point"><?php echo esc_html(get_theme_mod('nirup_nirup_departure_point', __('Nirup Island Ferry Terminal', 'nirup-island'))); ?></div>
                    
                    <table class="ferry-schedule-table">
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
                </div>
            </div>
            
            <!-- Right Column: Sidebar -->
            <div class="route-sidebar">
                <div class="sidebar-item">
                    <div class="sidebar-header">
                        <div class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <g clip-path="url(#clip0_1161_2113)">
                                    <path d="M12.9863 0.956055C13.2536 0.885008 13.5351 1.00237 13.6729 1.24219L22.9668 17.4414C23.0712 17.6236 23.0746 17.8468 22.9756 18.0322C22.8764 18.2177 22.6884 18.3382 22.4785 18.3525L22.4795 18.3535L13.7539 18.9502V19.9434L26.5107 18.9873L26.5957 18.9863C26.7919 18.9987 26.9716 19.1063 27.0762 19.2764C27.1956 19.4708 27.1971 19.7156 27.0791 19.9111L24.418 24.3213C23.3541 26.0841 21.4142 27.1787 19.3555 27.1787H6.92676C4.56751 27.1787 2.43737 25.7804 1.50098 23.6162L1.49805 23.6084C1.49782 23.6077 1.33866 23.1206 1.17969 22.6348C1.10014 22.3916 1.0206 22.1482 0.960938 21.9658C0.931103 21.8746 0.906075 21.7983 0.888672 21.7451C0.880011 21.7186 0.87281 21.6978 0.868164 21.6836C0.865859 21.6765 0.864477 21.6706 0.863281 21.667C0.862733 21.6653 0.861615 21.664 0.861328 21.6631V21.6621L0.860352 21.6602C0.805623 21.4829 0.835034 21.2901 0.939453 21.1367C1.04399 20.983 1.21332 20.8851 1.39844 20.8711L12.5332 20.0361V19.0273L3.88477 19.5234C3.87371 19.5241 3.86192 19.5244 3.84961 19.5244C3.66242 19.5244 3.4862 19.4385 3.37109 19.293L3.3252 19.2266C3.20861 19.031 3.21036 18.7864 3.33008 18.5928L12.5332 3.69727V1.5459C12.5332 1.26929 12.7191 1.02734 12.9863 0.956055ZM2.25195 22.0312L2.44336 22.6494L2.46973 22.7285L15.9844 21.6729C16.3204 21.6471 16.6139 21.8976 16.6406 22.2334C16.6668 22.5695 16.4159 22.8633 16.0801 22.8896L3.05176 23.9082C3.914 25.1747 5.35529 25.958 6.92676 25.958H19.3555C20.9886 25.958 22.5282 25.0887 23.3721 23.6904L24.2451 22.2432L21.8818 22.4287C21.5457 22.4549 21.2518 22.2044 21.2256 21.8682C21.1992 21.5323 21.4502 21.2382 21.7861 21.2119L25.0215 20.958L25.4219 20.292L2.25195 22.0312ZM4.98438 18.2363L12.5332 17.8037V6.01953L4.98438 18.2363ZM13.7539 17.7266L21.4219 17.2021L13.7539 3.83496V17.7266Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                    <path d="M18.5049 21.4746C18.7037 21.4346 18.9127 21.4995 19.0547 21.6406H19.0557C19.0835 21.6684 19.1087 21.6996 19.1309 21.7334L19.1865 21.8389H19.1875C19.2027 21.8756 19.2138 21.9142 19.2217 21.9531C19.2297 21.9929 19.2334 22.0334 19.2334 22.0723C19.2334 22.1112 19.2297 22.1516 19.2217 22.1914L19.1875 22.3057C19.1722 22.3429 19.153 22.378 19.1309 22.4111V22.4121C19.1091 22.4444 19.0842 22.4754 19.0557 22.5039H19.0547C18.9406 22.6173 18.7845 22.6826 18.623 22.6826C18.5837 22.6826 18.5434 22.6788 18.5039 22.6709C18.4642 22.6629 18.4256 22.6508 18.3896 22.6357L18.2852 22.5801C18.2521 22.5582 18.2196 22.5321 18.1914 22.5039C18.1635 22.476 18.1374 22.4449 18.1152 22.4111L18.0596 22.3057C18.0444 22.2692 18.0332 22.2311 18.0254 22.1924L18.0137 22.0723C18.0137 22.0336 18.0171 21.993 18.0254 21.9531L18.0596 21.8389H18.0605C18.0757 21.8021 18.0943 21.7663 18.1162 21.7334C18.1385 21.6994 18.1639 21.6682 18.1914 21.6406C18.2199 21.6119 18.2524 21.5871 18.2852 21.5654V21.5645C18.3179 21.543 18.353 21.524 18.3896 21.5088C18.4256 21.4938 18.4644 21.4813 18.5049 21.4736V21.4746Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_1161_2113">
                                    <rect width="28" height="28" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <p class="sidebar-label"><?php echo esc_html(get_theme_mod('nirup_sidebar_operator_label', __('Operator', 'nirup-island'))); ?></p>
                    </div>
                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_batam_operator', __('Rans Fadhila', 'nirup-island'))); ?></p>
                </div>
                
                <div class="sidebar-item">
                    <div class="sidebar-header">
                        <div class="sidebar-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M11 5V11L15 13M21 11C21 16.5228 16.5228 21 11 21C5.47715 21 1 16.5228 1 11C1 5.47715 5.47715 1 11 1C16.5228 1 21 5.47715 21 11Z" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        </div>
                        <p class="sidebar-label"><?php echo esc_html(get_theme_mod('nirup_sidebar_duration_label', __('Duration', 'nirup-island'))); ?></p>
                    </div>
                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_batam_duration', __('20 minutes', 'nirup-island'))); ?></p>
                </div>
                
                <div class="sidebar-item">
                    <div class="sidebar-header">
                        <div class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                               <path d="M22.8 4.46667H20.6V3.73333C20.6 3.53884 20.5227 3.35232 20.3852 3.21479C20.2477 3.07726 20.0612 3 19.8667 3C19.6722 3 19.4856 3.07726 19.3481 3.21479C19.2106 3.35232 19.1333 3.53884 19.1333 3.73333V4.46667H8.86667V3.73333C8.86667 3.53884 8.7894 3.35232 8.65188 3.21479C8.51435 3.07726 8.32783 3 8.13333 3C7.93884 3 7.75232 3.07726 7.61479 3.21479C7.47726 3.35232 7.4 3.53884 7.4 3.73333V4.46667H5.2C4.61673 4.46733 4.05753 4.69932 3.64509 5.11176C3.23266 5.5242 3.00066 6.08339 3 6.66667V22.8C3.00066 23.3833 3.23266 23.9425 3.64509 24.3549C4.05753 24.7673 4.61673 24.9993 5.2 25H22.8C23.3833 24.9993 23.9425 24.7673 24.3549 24.3549C24.7673 23.9425 24.9993 23.3833 25 22.8V6.66667C24.9993 6.08339 24.7673 5.5242 24.3549 5.11176C23.9425 4.69932 23.3833 4.46733 22.8 4.46667ZM23.5333 22.8C23.5333 22.9945 23.4561 23.181 23.3185 23.3185C23.181 23.4561 22.9945 23.5333 22.8 23.5333H5.2C5.00551 23.5333 4.81898 23.4561 4.68146 23.3185C4.54393 23.181 4.46667 22.9945 4.46667 22.8V11.8H23.5333V22.8ZM23.5333 10.3333H4.46667V6.66667C4.46667 6.47217 4.54393 6.28565 4.68146 6.14812C4.81898 6.0106 5.00551 5.93333 5.2 5.93333H7.4V6.66667C7.4 6.86116 7.47726 7.04769 7.61479 7.18521C7.75232 7.32274 7.93884 7.4 8.13333 7.4C8.32783 7.4 8.51435 7.32274 8.65188 7.18521C8.7894 7.04769 8.86667 6.86116 8.86667 6.66667V5.93333H19.1333V6.66667C19.1333 6.86116 19.2106 7.04769 19.3481 7.18521C19.4856 7.32274 19.6722 7.4 19.8667 7.4C20.0612 7.4 20.2477 7.32274 20.3852 7.18521C20.5227 7.04769 20.6 6.86116 20.6 6.66667V5.93333H22.8C22.9945 5.93333 23.181 6.0106 23.3185 6.14812C23.4561 6.28565 23.5333 6.47217 23.5333 6.66667V10.3333Z" fill="#A48456"/>
                                <path d="M8 20C8.26522 20 8.51957 19.9122 8.70711 19.7559C8.89464 19.5996 9 19.3877 9 19.1667V15.8333C9 15.6123 8.89464 15.4004 8.70711 15.2441C8.51957 15.0878 8.26522 15 8 15C7.73478 15 7.48043 15.0878 7.29289 15.2441C7.10536 15.4004 7 15.6123 7 15.8333V19.1667C7 19.3877 7.10536 19.5996 7.29289 19.7559C7.48043 19.9122 7.73478 20 8 20Z" fill="#A48456"/>
                                <path d="M14 20C14.2652 20 14.5196 19.9122 14.7071 19.7559C14.8946 19.5996 15 19.3877 15 19.1667V15.8333C15 15.6123 14.8946 15.4004 14.7071 15.2441C14.5196 15.0878 14.2652 15 14 15C13.7348 15 13.4804 15.0878 13.2929 15.2441C13.1054 15.4004 13 15.6123 13 15.8333V19.1667C13 19.3877 13.1054 19.5996 13.2929 19.7559C13.4804 19.9122 13.7348 20 14 20Z" fill="#A48456"/>
                                <path d="M20 20C20.2652 20 20.5196 19.9122 20.7071 19.7559C20.8946 19.5996 21 19.3877 21 19.1667V15.8333C21 15.6123 20.8946 15.4004 20.7071 15.2441C20.5196 15.0878 20.2652 15 20 15C19.7348 15 19.4804 15.0878 19.2929 15.2441C19.1054 15.4004 19 15.6123 19 15.8333V19.1667C19 19.3877 19.1054 19.5996 19.2929 19.7559C19.4804 19.9122 19.7348 20 20 20Z" fill="#A48456"/>
                            </svg>
                        </div>
                        <p class="sidebar-label"><?php echo esc_html(get_theme_mod('nirup_sidebar_workdays_label', __('Work Days', 'nirup-island'))); ?></p>
                    </div>
                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_batam_workdays', __('Daily / Friday – Sunday', 'nirup-island'))); ?></p>
                </div>
                
                <div class="sidebar-item">
                    <div class="sidebar-header">
                        <div class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
                                <path d="M16.2227 0.900391C18.4864 0.900391 20.6256 1.15957 22.2451 1.63379C23.1618 1.90221 23.8711 2.23021 24.3535 2.61035C24.8371 2.99141 25.1005 3.43261 25.1006 3.92383C25.1006 4.41508 24.8371 4.85623 24.3535 5.2373C23.8711 5.61746 23.1618 5.94544 22.2451 6.21387C20.6256 6.68808 18.4864 6.94824 16.2227 6.94824C13.9591 6.94821 11.8206 6.68805 10.2012 6.21387C9.28451 5.94544 8.57522 5.61746 8.09277 5.2373C7.60917 4.85622 7.3457 4.41509 7.3457 3.92383C7.34574 3.43261 7.60921 2.99141 8.09277 2.61035C8.57522 2.23023 9.28458 1.9022 10.2012 1.63379C11.8206 1.15962 13.9591 0.900421 16.2227 0.900391ZM16.2227 2.09961C14.0642 2.09964 12.0452 2.34478 10.5381 2.78613C9.72808 3.02335 9.22285 3.27337 8.92285 3.48633C8.773 3.59274 8.67627 3.68864 8.61816 3.7666C8.55888 3.84625 8.54496 3.89968 8.54492 3.92383C8.54492 3.94796 8.55859 4.0021 8.61816 4.08203C8.67627 4.15994 8.77317 4.25503 8.92285 4.36133C9.22287 4.5743 9.72796 4.82526 10.5381 5.0625C12.0453 5.50385 14.0643 5.74802 16.2227 5.74805C18.3809 5.74805 20.4 5.50374 21.9072 5.0625C22.7174 4.82526 23.2224 4.57429 23.5225 4.36133C23.6724 4.25488 23.77 4.16002 23.8281 4.08203C23.8877 4.0021 23.9004 3.94797 23.9004 3.92383C23.9004 3.89968 23.8873 3.84618 23.8281 3.7666C23.77 3.68859 23.6725 3.59282 23.5225 3.48633C23.2224 3.27337 22.7173 3.02333 21.9072 2.78613C20.4 2.34481 18.3811 2.09961 16.2227 2.09961Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                <path d="M8.54492 6.80664V6.90625C8.54492 6.93042 8.55859 6.98449 8.61816 7.06445C8.67627 7.14238 8.77319 7.23744 8.92285 7.34375C9.22292 7.5568 9.72872 7.80762 10.5391 8.04492C12.0465 8.48631 14.0652 8.73047 16.2236 8.73047C18.382 8.73046 20.4009 8.48639 21.9082 8.04492C22.7184 7.80761 23.2234 7.55678 23.5234 7.34375C23.6731 7.23745 23.77 7.14239 23.8281 7.06445C23.8877 6.9845 23.9014 6.93042 23.9014 6.90625V6.80664H25.1016V6.90625C25.1016 7.39743 24.8379 7.83865 24.3545 8.21973C23.872 8.59996 23.1619 8.9278 22.2451 9.19629C20.6257 9.67057 18.4872 9.93066 16.2236 9.93066C13.9598 9.93066 11.8208 9.6706 10.2012 9.19629C9.28452 8.92781 8.57522 8.59993 8.09277 8.21973C7.60914 7.83858 7.3457 7.39756 7.3457 6.90625V6.80664H8.54492Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                <path d="M25.0977 9.7334V9.83301C25.0977 10.3243 24.8342 10.7653 24.3506 11.1465C23.8681 11.5267 23.1589 11.8546 22.2422 12.123C20.6228 12.5973 18.4843 12.8574 16.2207 12.8574C15.8213 12.8574 15.4274 12.8496 15.0508 12.834L14.9502 12.8301L14.9551 12.7295L14.9961 11.7305L15 11.6309L15.1006 11.6348C15.4605 11.6497 15.8376 11.6572 16.2207 11.6572C18.379 11.6572 20.3981 11.4131 21.9053 10.9717C22.7154 10.7344 23.2205 10.4835 23.5205 10.2705C23.6702 10.1642 23.7671 10.0691 23.8252 9.99121C23.8848 9.91126 23.8984 9.85718 23.8984 9.83301V9.7334H25.0977Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                <path d="M25.1006 12.6582V12.7578C25.1006 13.249 24.8369 13.6902 24.3535 14.0713C23.871 14.4515 23.1609 14.7793 22.2441 15.0479C20.6247 15.5221 18.4862 15.7822 16.2227 15.7822H16.123V14.582H16.2227C18.3811 14.582 20.3999 14.3379 21.9072 13.8965C22.7175 13.6592 23.2224 13.4084 23.5225 13.1953C23.6722 13.089 23.769 12.994 23.8271 12.916C23.8867 12.8361 23.9004 12.782 23.9004 12.7578V12.6582H25.1006Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                <path d="M25.1006 4.07812V15.6855C25.1006 16.2123 24.8023 16.6606 24.3154 17.0322C23.829 17.4034 23.1429 17.7074 22.3379 17.9502C20.7268 18.436 18.6106 18.6831 16.5762 18.708C16.4594 18.7095 16.3407 18.71 16.2227 18.71H16.123V17.5107H16.2227C16.3356 17.5107 16.4489 17.5103 16.5605 17.5088C18.9949 17.479 20.8452 17.1583 22.083 16.7686C22.7022 16.5736 23.1652 16.3629 23.4707 16.1641C23.6236 16.0646 23.7338 15.9703 23.8047 15.8857C23.8766 15.8 23.9004 15.7324 23.9004 15.6855V4.07812H25.1006Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                <path d="M8.54492 4.07812V9.54688H7.3457V4.07812H8.54492Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                <path d="M9.11816 8.73047C13.6494 8.73047 17.3369 12.4015 17.3369 16.915C17.3368 21.4286 13.6493 25.0996 9.11816 25.0996C4.58701 25.0995 0.9005 21.4285 0.900391 16.915C0.900391 12.4015 4.58695 8.73053 9.11816 8.73047ZM9.11816 9.92969C5.24794 9.92975 2.09961 13.0642 2.09961 16.915C2.09974 20.7658 5.24807 23.8994 9.11816 23.8994C12.9883 23.8994 16.1366 20.7658 16.1367 16.915C16.1367 13.0642 12.9884 9.92969 9.11816 9.92969Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                                <path d="M9.55664 16.2393C10.2104 16.5058 10.7147 16.8093 11.0547 17.1953C11.3972 17.5844 11.5683 18.0515 11.5684 18.6328C11.5684 19.6555 10.8692 20.6049 9.58203 20.8516V22.1787H8.68945V22.0791H8.58984V20.9023C7.87661 20.8725 7.14759 20.6512 6.70801 20.3379L6.64551 20.2939L6.67188 20.2227L6.97363 19.3799L7.0166 19.2598L7.12305 19.3301C7.55999 19.6215 8.19489 19.8535 8.87793 19.8535C9.3054 19.8535 9.65598 19.7302 9.89746 19.5293C10.1375 19.3296 10.2753 19.0496 10.2754 18.7217C10.2754 18.4036 10.1636 18.1483 9.94238 17.9258C9.71753 17.6997 9.37677 17.5052 8.91602 17.3184V17.3174C8.27219 17.0648 7.73886 16.7894 7.36621 16.4316C6.98911 16.0695 6.77833 15.6253 6.77832 15.0498C6.77832 13.9745 7.52896 13.1631 8.67773 12.9434V11.6553H9.65723V12.8809C10.3768 12.9197 10.8798 13.1157 11.2422 13.3281L11.3154 13.3711L11.2852 13.4502L10.9707 14.2803L10.9297 14.3896L10.8281 14.332C10.571 14.1845 10.0724 13.918 9.29297 13.918C8.82943 13.918 8.52366 14.0559 8.33398 14.2412C8.14356 14.4274 8.06064 14.6706 8.06055 14.8984C8.06055 15.1949 8.16333 15.4132 8.39551 15.6152C8.63481 15.8233 9.01043 16.0132 9.55664 16.2393Z" fill="#A48456" stroke="#A48456" stroke-width="0.2"/>
                            </svg>
                        </div>
                        <p class="sidebar-label"><?php echo esc_html(get_theme_mod('nirup_sidebar_price_label', __('Price', 'nirup-island'))); ?></p>
                    </div>
                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_batam_price', __('Rp150,000 /per way', 'nirup-island'))); ?></p>
                </div>
                
                <div class="sidebar-item">
                    <div class="sidebar-header">
                        <div class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                <path d="M8.5 10.8333L12 14.3333L23.6667 2.66667M22.5 12V20.1667C22.5 20.7855 22.2542 21.379 21.8166 21.8166C21.379 22.2542 20.7855 22.5 20.1667 22.5H3.83333C3.21449 22.5 2.621 22.2542 2.18342 21.8166C1.74583 21.379 1.5 20.7855 1.5 20.1667V3.83333C1.5 3.21449 1.74583 2.621 2.18342 2.18342C2.621 1.74583 3.21449 1.5 3.83333 1.5H16.6667" stroke="#A48456" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <p class="sidebar-label"><?php echo esc_html(get_theme_mod('nirup_sidebar_checkin_label', __('Check-in', 'nirup-island'))); ?></p>
                    </div>
                    <p class="sidebar-value"><?php echo esc_html(get_theme_mod('nirup_batam_to_nirup_checkin', __('Horizon Fast Ferry counter (Bayfront Mall, 2nd floor)', 'nirup-island'))); ?></p>
                </div>
                
                <button class="book-ticket-btn"><?php echo esc_html(get_theme_mod('nirup_book_ticket_text', __('BOOK FERRY TICKET', 'nirup-island'))); ?></button>
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
                            <div class="luggage-icon-label">
                                <div class="luggage-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                        <path d="M22.2975 5.93951H19.5602C19.5367 5.57239 19.2313 5.28162 18.8572 5.28162H18.8208V3.77374C18.8208 2.79578 18.0145 2 17.0235 2H10.9767C9.98549 2 9.17921 2.79578 9.17921 3.77374V5.28162H9.14284C8.76872 5.28162 8.46329 5.57239 8.43997 5.93951H5.70247C3.66087 5.93951 2 7.59534 2 9.63074V22.9848C2 24.6474 3.35672 26 5.02438 26H22.9756C24.6433 26 26 24.6474 26 22.9848V9.63074C26 7.59534 24.3389 5.93951 22.2975 5.93951ZM14.4393 7.34576C15.0686 7.47101 15.6161 7.8266 15.9848 8.35266C16.3641 8.89374 16.5094 9.5498 16.3937 10.1996C16.3481 10.4562 16.2638 10.6992 16.1437 10.9251L14.162 11.152C13.9594 11.175 13.7768 11.2845 13.6613 11.4521L10.7583 15.66C10.6524 15.8137 10.612 16.003 10.6459 16.1865C10.6799 16.3699 10.7857 16.5322 10.9398 16.6378L13.8351 18.623C13.957 18.7067 14.0962 18.7468 14.234 18.7468C14.4584 18.7468 14.679 18.6404 14.8156 18.4421L17.7186 14.2342C17.8342 14.0667 17.8714 13.8575 17.8206 13.6607L17.3186 11.7136C17.5465 11.3221 17.7023 10.8964 17.7825 10.4454C17.964 9.42548 17.7363 8.39624 17.141 7.54736C17.0925 7.47797 17.0413 7.41132 16.9888 7.34576H19.5354V24.5938H8.46458V7.34576H14.4393ZM16.3748 13.7008L14.0533 17.0659L12.3202 15.8776L14.6417 12.5125L16.0275 12.3541L16.3748 13.7008ZM10.5897 3.77374C10.5897 3.56427 10.7561 3.40625 10.9767 3.40625H17.0235C17.244 3.40625 17.4103 3.56427 17.4103 3.77374V5.28162H17.3739C16.9998 5.28162 16.6943 5.57239 16.671 5.93951H11.3292C11.3057 5.57239 11.0004 5.28162 10.6261 5.28162H10.5897V3.77374ZM3.41053 22.9848V9.63074C3.41053 8.37079 4.43868 7.34576 5.70247 7.34576H7.05386V24.5938H5.02438C4.13453 24.5938 3.41053 23.8719 3.41053 22.9848ZM24.5895 22.9848C24.5895 23.8719 23.8657 24.5938 22.9756 24.5938H20.9461V7.34576H22.2975C23.5613 7.34576 24.5895 8.37079 24.5895 9.63074V22.9848Z" fill="#A48456"/>
                                    </svg>
                                </div>  
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_free_label', __('Free', 'nirup-island'))); ?></div>                          
                            </div>
                            <div class="luggage-info">
                                <div class="luggage-value"><?php echo esc_html(get_theme_mod('nirup_luggage_singapore_free', __('20 kg / boarding pass', 'nirup-island'))); ?></div>
                            </div>
                        </div>                       
                        <div class="luggage-item">
                            <div class="luggage-icon-label">
                                <div class="luggage-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <path d="M11 5V11L15 13M21 11C21 16.5228 16.5228 21 11 21C5.47715 21 1 16.5228 1 11C1 5.47715 5.47715 1 11 1C16.5228 1 21 5.47715 21 11Z" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_checkin_label', __('Check-in', 'nirup-island'))); ?></div>       
                            </div>
                            <div class="luggage-info">
                                <div class="luggage-value"><?php echo esc_html(get_theme_mod('nirup_luggage_singapore_checkin', __('60–20 min before departure', 'nirup-island'))); ?></div>
                            </div>
                        </div>
                        <div class="luggage-item">
                            <div class="luggage-icon-label">
                                <div class="luggage-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="24" viewBox="0 0 26 24" fill="none">
                                    <path d="M21.5573 4.42428H4.44571C2.55566 4.42428 1.02344 2.89206 1.02344 1.00195H24.9796C24.9796 2.89206 23.4474 4.42428 21.5573 4.42428Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15.691 4.42383H9.82422V7.35724H15.691V4.42383Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M24.0015 23.0012H2.00149C1.39859 23.0012 0.939381 22.4611 1.03642 21.866L2.70917 9.24533C2.86401 8.16146 3.79226 7.35645 4.88708 7.35645H21.1158C22.2107 7.35645 23.139 8.16146 23.2938 9.24533L24.9665 21.866C25.0637 22.4611 24.6044 23.0012 24.0015 23.0012Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13.0029 20.5556C15.9731 20.5556 18.3808 18.1479 18.3808 15.1777C18.3808 12.2076 15.9731 9.7998 13.0029 9.7998C10.0328 9.7998 7.625 12.2076 7.625 15.1777C7.625 18.1479 10.0328 20.5556 13.0029 20.5556Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13.0039 9.7998V11.2666" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13.0039 19.0889V20.5556" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M7.625 15.1787H9.09173" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M16.9141 15.1787H18.3808" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12.3099 15.8715C11.928 15.4895 11.928 14.8704 12.3099 14.4885C12.6917 14.1067 13.3109 14.1067 13.6927 14.4885C14.0745 14.8705 14.0745 15.4896 13.6927 15.8715C13.3109 16.2532 12.6917 16.2532 12.3099 15.8715Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13.6914 14.487L15.0778 13.1006" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_excess_label', __('Excess', 'nirup-island'))); ?></div>
                            </div>
                            <div class="luggage-info">
                                <div class="luggage-value"><?php echo esc_html(get_theme_mod('nirup_luggage_singapore_excess', __('$1 per kg (max 40 kg)', 'nirup-island'))); ?></div>
                            </div>
                        </div>    
                        <div class="luggage-item">
                            <div class="luggage-icon-label">
                                <div class="luggage-icon"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <mask id="mask0_1253_2198" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="28" height="28">
                                        <path d="M0 1.90735e-06H28V28H0V1.90735e-06Z" fill="white"/>
                                    </mask>
                                    <g mask="url(#mask0_1253_2198)">
                                        <path d="M19.9609 24.8008V20.043H23.2422V24.8008" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8.91519 16.7617H25.5402C26.4425 16.7617 27.1808 17.5 27.1808 18.4023C27.1808 19.3047 26.4425 20.043 25.5402 20.043H8.69141" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.8911 9.87145H21.4917C22.1237 9.87145 22.6406 10.3884 22.6406 11.0203V15.6158C22.6406 16.2476 22.1237 16.7646 21.4917 16.7646H13.8911C13.2591 16.7646 12.7422 16.2476 12.7422 15.6158V11.0203C12.7422 10.3884 13.2591 9.87145 13.8911 9.87145Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M0.820312 20.043H8.20312V4.40234H0.820312V20.043Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M15.3125 9.87109V8.23047C15.3125 7.32687 16.0495 6.58984 16.9531 6.58984H18.2656C19.1692 6.58984 19.9062 7.32687 19.9062 8.23047V9.87109" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M0.820312 24.8008V20.043" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8.20312 24.8008V20.043" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M2.46094 4.23828V3.19922" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6.5625 4.23828V3.19922" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.14844 7.68359H7.65625" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    </svg>
                                </div>
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_counters_label', __('Counters', 'nirup-island'))); ?></div>     
                            </div>
                            <div class="luggage-info">
                                <div class="luggage-value"><?php echo esc_html(get_theme_mod('nirup_luggage_singapore_counters', __('Next to immigration gate', 'nirup-island'))); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="luggage-block">
                    <h3 class="luggage-block-title"><?php echo esc_html(get_theme_mod('nirup_luggage_batam_title', __('Batam Departure', 'nirup-island'))); ?></h3>
                    
                    <div class="luggage-items">
                        <div class="luggage-item">
                            <div class="luggage-icon-label">
                                <div class="luggage-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                        <path d="M22.2975 5.93951H19.5602C19.5367 5.57239 19.2313 5.28162 18.8572 5.28162H18.8208V3.77374C18.8208 2.79578 18.0145 2 17.0235 2H10.9767C9.98549 2 9.17921 2.79578 9.17921 3.77374V5.28162H9.14284C8.76872 5.28162 8.46329 5.57239 8.43997 5.93951H5.70247C3.66087 5.93951 2 7.59534 2 9.63074V22.9848C2 24.6474 3.35672 26 5.02438 26H22.9756C24.6433 26 26 24.6474 26 22.9848V9.63074C26 7.59534 24.3389 5.93951 22.2975 5.93951ZM14.4393 7.34576C15.0686 7.47101 15.6161 7.8266 15.9848 8.35266C16.3641 8.89374 16.5094 9.5498 16.3937 10.1996C16.3481 10.4562 16.2638 10.6992 16.1437 10.9251L14.162 11.152C13.9594 11.175 13.7768 11.2845 13.6613 11.4521L10.7583 15.66C10.6524 15.8137 10.612 16.003 10.6459 16.1865C10.6799 16.3699 10.7857 16.5322 10.9398 16.6378L13.8351 18.623C13.957 18.7067 14.0962 18.7468 14.234 18.7468C14.4584 18.7468 14.679 18.6404 14.8156 18.4421L17.7186 14.2342C17.8342 14.0667 17.8714 13.8575 17.8206 13.6607L17.3186 11.7136C17.5465 11.3221 17.7023 10.8964 17.7825 10.4454C17.964 9.42548 17.7363 8.39624 17.141 7.54736C17.0925 7.47797 17.0413 7.41132 16.9888 7.34576H19.5354V24.5938H8.46458V7.34576H14.4393ZM16.3748 13.7008L14.0533 17.0659L12.3202 15.8776L14.6417 12.5125L16.0275 12.3541L16.3748 13.7008ZM10.5897 3.77374C10.5897 3.56427 10.7561 3.40625 10.9767 3.40625H17.0235C17.244 3.40625 17.4103 3.56427 17.4103 3.77374V5.28162H17.3739C16.9998 5.28162 16.6943 5.57239 16.671 5.93951H11.3292C11.3057 5.57239 11.0004 5.28162 10.6261 5.28162H10.5897V3.77374ZM3.41053 22.9848V9.63074C3.41053 8.37079 4.43868 7.34576 5.70247 7.34576H7.05386V24.5938H5.02438C4.13453 24.5938 3.41053 23.8719 3.41053 22.9848ZM24.5895 22.9848C24.5895 23.8719 23.8657 24.5938 22.9756 24.5938H20.9461V7.34576H22.2975C23.5613 7.34576 24.5895 8.37079 24.5895 9.63074V22.9848Z" fill="#A48456"/>
                                    </svg>
                                </div>
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_free_label', __('Free', 'nirup-island'))); ?></div>
                            </div>
                            <div class="luggage-info">
                                <div class="luggage-value"><?php echo esc_html(get_theme_mod('nirup_luggage_batam_free', __('20 kg / boarding pass', 'nirup-island'))); ?></div>
                            </div>
                        </div>
                        <div class="luggage-item">
                            <div class="luggage-icon-label">
                                <div class="luggage-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <path d="M11 5V11L15 13M21 11C21 16.5228 16.5228 21 11 21C5.47715 21 1 16.5228 1 11C1 5.47715 5.47715 1 11 1C16.5228 1 21 5.47715 21 11Z" stroke="#A48456" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>                                
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_checkin_label', __('Check-in', 'nirup-island'))); ?></div>
                            </div>                            

                            <div class="luggage-info">
                                <div class="luggage-value"><?php echo esc_html(get_theme_mod('nirup_luggage_batam_checkin', __('60–20 min before departure', 'nirup-island'))); ?></div>
                            </div>
                        </div>                       
                        <div class="luggage-item">
                            <div class="luggage-icon-label">
                                <div class="luggage-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="24" viewBox="0 0 26 24" fill="none">
                                    <path d="M21.5573 4.42428H4.44571C2.55566 4.42428 1.02344 2.89206 1.02344 1.00195H24.9796C24.9796 2.89206 23.4474 4.42428 21.5573 4.42428Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15.691 4.42383H9.82422V7.35724H15.691V4.42383Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M24.0015 23.0012H2.00149C1.39859 23.0012 0.939381 22.4611 1.03642 21.866L2.70917 9.24533C2.86401 8.16146 3.79226 7.35645 4.88708 7.35645H21.1158C22.2107 7.35645 23.139 8.16146 23.2938 9.24533L24.9665 21.866C25.0637 22.4611 24.6044 23.0012 24.0015 23.0012Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13.0029 20.5556C15.9731 20.5556 18.3808 18.1479 18.3808 15.1777C18.3808 12.2076 15.9731 9.7998 13.0029 9.7998C10.0328 9.7998 7.625 12.2076 7.625 15.1777C7.625 18.1479 10.0328 20.5556 13.0029 20.5556Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13.0039 9.7998V11.2666" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13.0039 19.0889V20.5556" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M7.625 15.1787H9.09173" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M16.9141 15.1787H18.3808" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12.3099 15.8715C11.928 15.4895 11.928 14.8704 12.3099 14.4885C12.6917 14.1067 13.3109 14.1067 13.6927 14.4885C14.0745 14.8705 14.0745 15.4896 13.6927 15.8715C13.3109 16.2532 12.6917 16.2532 12.3099 15.8715Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13.6914 14.487L15.0778 13.1006" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_excess_label', __('Excess', 'nirup-island'))); ?></div>           
                            </div>
                            <div class="luggage-info">
                                <div class="luggage-value"><?php echo esc_html(get_theme_mod('nirup_luggage_batam_excess', __('$1 per kg (max 40 kg)', 'nirup-island'))); ?></div>
                            </div>
                        </div>   
                        <div class="luggage-item">
                            <div class="luggage-icon-label">
                                <div class="luggage-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <mask id="mask0_1253_2198" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="28" height="28">
                                        <path d="M0 1.90735e-06H28V28H0V1.90735e-06Z" fill="white"/>
                                    </mask>
                                    <g mask="url(#mask0_1253_2198)">
                                        <path d="M19.9609 24.8008V20.043H23.2422V24.8008" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8.91519 16.7617H25.5402C26.4425 16.7617 27.1808 17.5 27.1808 18.4023C27.1808 19.3047 26.4425 20.043 25.5402 20.043H8.69141" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.8911 9.87145H21.4917C22.1237 9.87145 22.6406 10.3884 22.6406 11.0203V15.6158C22.6406 16.2476 22.1237 16.7646 21.4917 16.7646H13.8911C13.2591 16.7646 12.7422 16.2476 12.7422 15.6158V11.0203C12.7422 10.3884 13.2591 9.87145 13.8911 9.87145Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M0.820312 20.043H8.20312V4.40234H0.820312V20.043Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M15.3125 9.87109V8.23047C15.3125 7.32687 16.0495 6.58984 16.9531 6.58984H18.2656C19.1692 6.58984 19.9062 7.32687 19.9062 8.23047V9.87109" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M0.820312 24.8008V20.043" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8.20312 24.8008V20.043" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M2.46094 4.23828V3.19922" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6.5625 4.23828V3.19922" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.14844 7.68359H7.65625" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="22.926" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    </svg>
                                </div>                            
                                <div class="luggage-label"><?php echo esc_html(get_theme_mod('nirup_luggage_counters_label', __('Counters', 'nirup-island'))); ?></div>
                            </div>

                            <div class="luggage-info">
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
            <h2 class="visa-section-title"><?php echo esc_html($visa_title); ?></h2>
            <p class="section-subtitle"><?php echo esc_html($visa_subtitle); ?></p>
            <div class="visa-section-divider"></div> 
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
<svg width="101" height="134" viewBox="0 0 101 134" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M50.7461 0.311523C23.1471 0.34789 0.782552 22.6565 0.746094 50.1863C0.746094 85.9922 47.3294 130.838 49.3086 132.729C50.1081 133.506 51.3841 133.506 52.1836 132.729C54.1628 130.838 100.746 85.9922 100.746 50.1863C100.71 22.6565 78.345 0.34789 50.7461 0.311523Z" fill="#22284F"/>
                    <g clip-path="url(#clip0_845_201)">
                    <path d="M33.9919 63.6142C33.9919 62.4446 33.9919 62.2279 33.9777 61.9822C33.9614 61.7199 33.8872 61.5892 33.7206 61.5508C33.6373 61.527 33.5387 61.5197 33.4493 61.5197C33.3731 61.5197 33.3284 61.5032 33.3284 61.442C33.3284 61.3964 33.3893 61.3818 33.5082 61.3818C33.7958 61.3818 34.2714 61.4036 34.4908 61.4036C34.6798 61.4036 35.1249 61.3818 35.4125 61.3818C35.51 61.3818 35.57 61.3964 35.57 61.442C35.57 61.5042 35.5253 61.5197 35.4501 61.5197C35.3749 61.5197 35.3129 61.527 35.2235 61.5415C35.0182 61.5809 34.9583 61.7126 34.944 61.9811C34.9278 62.2269 34.9278 62.4436 34.9278 63.6132V64.9704C34.9278 65.717 34.9278 66.3256 34.9583 66.6564C34.9816 66.8638 35.0345 67.0038 35.2611 67.0349C35.3668 67.0494 35.5324 67.0639 35.6462 67.0639C35.7285 67.0639 35.7671 67.0877 35.7671 67.1261C35.7671 67.1811 35.7061 67.2039 35.6228 67.2039C35.1249 67.2039 34.6494 67.18 34.4461 67.18C34.2714 67.18 33.7958 67.2039 33.494 67.2039C33.3954 67.2039 33.3426 67.18 33.3426 67.1261C33.3426 67.0877 33.3731 67.0639 33.4635 67.0639C33.5773 67.0639 33.6667 67.0494 33.7348 67.0349C33.8862 67.0038 33.932 66.8731 33.9543 66.6491C33.9919 66.3256 33.9919 65.716 33.9919 64.9704V63.6132V63.6142Z" fill="white"/>
                    <path d="M37.7485 67.1111C37.6276 67.0572 37.6042 67.0189 37.6042 66.8488C37.6042 66.4247 37.6347 65.9633 37.6418 65.8389C37.65 65.7238 37.6723 65.6388 37.7323 65.6388C37.8004 65.6388 37.8075 65.7083 37.8075 65.7694C37.8075 65.87 37.838 66.0318 37.8766 66.1624C38.0422 66.7316 38.4883 66.9411 38.9557 66.9411C39.6345 66.9411 39.9668 66.4704 39.9668 66.0629C39.9668 65.6865 39.854 65.3319 39.227 64.8311L38.8805 64.5532C38.0503 63.8906 37.7628 63.3525 37.7628 62.7283C37.7628 61.8801 38.4578 61.2715 39.5065 61.2715C39.9973 61.2715 40.3143 61.3492 40.5104 61.4021C40.5785 61.4187 40.6171 61.4405 40.6171 61.4944C40.6171 61.594 40.5866 61.8179 40.5866 62.4183C40.5866 62.5873 40.5633 62.6495 40.5033 62.6495C40.4505 62.6495 40.4281 62.6039 40.4281 62.5116C40.4281 62.4421 40.3905 62.2036 40.232 62.0035C40.1182 61.8563 39.8987 61.6251 39.4089 61.6251C38.8511 61.6251 38.5106 61.9558 38.5106 62.4183C38.5106 62.7729 38.6854 63.0425 39.3114 63.5277L39.5237 63.6895C40.4362 64.3904 40.7614 64.9213 40.7614 65.6543C40.7614 66.1002 40.5958 66.6311 40.0521 66.994C39.6741 67.2408 39.2514 67.3102 38.8521 67.3102C38.4141 67.3102 38.0747 67.2563 37.7506 67.1101" fill="white"/>
                    <path d="M44.2612 64.9705C44.2612 65.9566 44.2612 66.4875 44.4197 66.6264C44.5477 66.7425 44.7438 66.7954 45.3322 66.7954C45.7315 66.7954 46.0272 66.7881 46.2152 66.5808C46.3057 66.4802 46.3971 66.2645 46.4124 66.1183C46.4195 66.0489 46.4337 66.0022 46.4947 66.0022C46.5485 66.0022 46.5556 66.0406 46.5556 66.1328C46.5556 66.2179 46.5018 66.7954 46.4418 67.0183C46.3971 67.1873 46.3595 67.2257 45.9673 67.2257C45.4236 67.2257 45.0314 67.2112 44.691 67.2039C44.3526 67.1873 44.0793 67.1801 43.7714 67.1801C43.6881 67.1801 43.5214 67.1801 43.3405 67.1873C43.1678 67.1873 42.9717 67.2039 42.8203 67.2039C42.7227 67.2039 42.6689 67.1801 42.6689 67.1262C42.6689 67.0878 42.6994 67.064 42.7898 67.064C42.9036 67.064 42.993 67.0494 43.0611 67.0349C43.2125 67.0038 43.2501 66.8338 43.2806 66.6108C43.3182 66.2873 43.3182 65.6777 43.3182 64.9705V63.6132C43.3182 62.4437 43.3182 62.2269 43.304 61.9812C43.2877 61.7189 43.2288 61.5955 42.9798 61.5416C42.9188 61.5271 42.8284 61.5198 42.7298 61.5198C42.6475 61.5198 42.6018 61.5032 42.6018 61.4503C42.6018 61.3974 42.6546 61.3809 42.7674 61.3809C43.1221 61.3809 43.5976 61.4026 43.8019 61.4026C43.9838 61.4026 44.5345 61.3809 44.8292 61.3809C44.9359 61.3809 44.9877 61.3954 44.9877 61.4503C44.9877 61.5053 44.943 61.5198 44.8526 61.5198C44.7692 61.5198 44.6493 61.5271 44.5579 61.5416C44.3547 61.581 44.2937 61.7127 44.2784 61.9812C44.2642 62.2269 44.2642 62.4437 44.2642 63.6132V64.9705H44.2612Z" fill="white"/>
                    <path d="M49.0969 65.1945C49.0593 65.1945 49.043 65.2091 49.0288 65.2547L48.6203 66.3569C48.5451 66.5497 48.5075 66.7333 48.5075 66.8266C48.5075 66.9645 48.5756 67.0651 48.8093 67.0651H48.9221C49.0125 67.0651 49.0359 67.0816 49.0359 67.1273C49.0359 67.1895 48.9912 67.205 48.9079 67.205C48.666 67.205 48.3409 67.1812 48.1071 67.1812C48.0248 67.1812 47.6092 67.205 47.216 67.205C47.1184 67.205 47.0737 67.1884 47.0737 67.1273C47.0737 67.0816 47.1042 67.0651 47.1642 67.0651C47.2322 67.0651 47.3369 67.0578 47.3979 67.0505C47.7454 67.0049 47.8887 66.7426 48.0401 66.3579L49.9352 61.5209C50.0256 61.2969 50.0703 61.2119 50.1455 61.2119C50.2146 61.2119 50.2593 61.2814 50.3345 61.4587C50.5164 61.8828 51.7236 65.0245 52.2063 66.1962C52.4928 66.8888 52.7123 66.9966 52.8708 67.036C52.9846 67.0578 53.0974 67.0651 53.1879 67.0651C53.2488 67.0651 53.2854 67.0733 53.2854 67.1273C53.2854 67.1895 53.2173 67.205 52.9379 67.205C52.6585 67.205 52.1158 67.205 51.5112 67.1884C51.3761 67.1812 51.2846 67.1812 51.2846 67.1262C51.2846 67.0806 51.3151 67.064 51.3903 67.0568C51.4432 67.0422 51.496 66.9728 51.4584 66.8805L50.8538 65.2474C50.8396 65.2091 50.8162 65.1945 50.7786 65.1945H49.0959H49.0969ZM50.6373 64.8088C50.6749 64.8088 50.6821 64.785 50.6749 64.7622L49.9962 62.8605C49.988 62.8294 49.9799 62.79 49.9586 62.79C49.9352 62.79 49.92 62.8294 49.9128 62.8605L49.2188 64.7549C49.2107 64.786 49.2188 64.8088 49.2493 64.8088H50.6384H50.6373Z" fill="white"/>
                    <path d="M55.2638 66.1564C55.278 66.7568 55.3766 66.9569 55.528 67.0118C55.656 67.0575 55.7993 67.0647 55.9202 67.0647C56.0035 67.0647 56.0483 67.0813 56.0483 67.1269C56.0483 67.1891 55.9802 67.2047 55.8755 67.2047C55.3837 67.2047 55.0819 67.1808 54.9376 67.1808C54.8695 67.1808 54.5149 67.2047 54.1227 67.2047C54.0251 67.2047 53.957 67.1964 53.957 67.1269C53.957 67.0813 54.0017 67.0647 54.078 67.0647C54.1755 67.0647 54.3117 67.0575 54.4163 67.0263C54.6124 66.9641 54.6429 66.7422 54.6511 66.0714L54.7191 61.5112C54.7191 61.3578 54.7405 61.251 54.8177 61.251C54.9 61.251 54.9681 61.3505 55.0961 61.4895C55.1866 61.589 56.3348 62.8446 57.4363 63.9614C57.9495 64.485 58.9697 65.5944 59.0977 65.7168H59.1353L59.0591 62.2588C59.052 61.7891 58.9839 61.6419 58.802 61.5662C58.6892 61.5206 58.5073 61.5206 58.4027 61.5206C58.3122 61.5206 58.2817 61.4967 58.2817 61.4511C58.2817 61.3889 58.3651 61.3816 58.4779 61.3816C58.8721 61.3816 59.2339 61.4034 59.3924 61.4034C59.4747 61.4034 59.7613 61.3816 60.1321 61.3816C60.2307 61.3816 60.3049 61.3889 60.3049 61.4511C60.3049 61.4967 60.2602 61.5206 60.1687 61.5206C60.0935 61.5206 60.0336 61.5206 59.9421 61.5423C59.7298 61.6045 59.6698 61.7663 59.6627 62.1976L59.5804 67.0585C59.5804 67.2275 59.5499 67.298 59.4818 67.298C59.3985 67.298 59.307 67.213 59.2247 67.1269C58.7492 66.6645 57.7828 65.6566 56.9963 64.8624C56.1743 64.0308 55.3359 63.0686 55.2008 62.9214H55.1774L55.2607 66.1574L55.2638 66.1564Z" fill="white"/>
                    <path d="M62.7518 63.6142C62.7518 62.4446 62.7518 62.2279 62.7376 61.9822C62.7213 61.7199 62.6624 61.5965 62.4134 61.5426C62.3525 61.528 62.2244 61.5208 62.1188 61.5208C62.0354 61.5208 61.9907 61.5042 61.9907 61.4513C61.9907 61.3984 62.0425 61.3818 62.1564 61.3818C62.5557 61.3818 63.0313 61.4036 63.2436 61.4036C63.4773 61.4036 63.9529 61.3818 64.4061 61.3818C65.3491 61.3818 66.6101 61.3818 67.4332 62.259C67.8092 62.6593 68.1648 63.299 68.1648 64.2166C68.1648 65.1861 67.7655 65.9264 67.3428 66.365C66.9952 66.7269 66.2108 67.2744 64.8136 67.2744C64.5423 67.2744 64.2323 67.2505 63.9458 67.2277C63.6602 67.2059 63.395 67.1821 63.207 67.1821C63.1237 67.1821 62.9571 67.1821 62.7762 67.1894C62.6035 67.1894 62.4073 67.2059 62.2559 67.2059C62.1574 67.2059 62.1045 67.1821 62.1045 67.1282C62.1045 67.0898 62.135 67.066 62.2255 67.066C62.3393 67.066 62.4287 67.0514 62.4968 67.0369C62.6482 67.0058 62.6858 66.8358 62.7162 66.6129C62.7538 66.2893 62.7538 65.6797 62.7538 64.9725V63.6153L62.7518 63.6142ZM63.6958 64.4613C63.6958 65.2784 63.7029 65.8715 63.71 66.0187C63.7172 66.2105 63.7334 66.5185 63.7934 66.6025C63.8909 66.7497 64.1856 66.9115 64.7811 66.9115C65.5513 66.9115 66.0644 66.757 66.5176 66.3567C67.0013 65.9327 67.1517 65.2328 67.1517 64.4396C67.1517 63.4608 66.7524 62.8293 66.4282 62.5131C65.7332 61.8349 64.8725 61.7437 64.2842 61.7437C64.1328 61.7437 63.8543 61.7655 63.7934 61.7966C63.7253 61.8277 63.7029 61.8661 63.7029 61.9511C63.6958 62.2134 63.6958 62.8822 63.6958 63.4919V64.4613Z" fill="white"/>
                    <path d="M37.1298 47.8879C37.1298 45.1402 37.1298 44.6342 37.0953 44.0556C37.0597 43.4418 36.8819 43.1349 36.4927 43.0436C36.2976 42.9907 36.0669 42.971 35.8556 42.971C35.6777 42.971 35.571 42.9358 35.571 42.7906C35.571 42.6828 35.7133 42.6465 35.9968 42.6465C36.6705 42.6465 37.7862 42.7004 38.3004 42.7004C38.7435 42.7004 39.787 42.6465 40.4607 42.6465C40.6914 42.6465 40.8326 42.6828 40.8326 42.7906C40.8326 42.9358 40.7259 42.971 40.5481 42.971C40.3703 42.971 40.2291 42.9897 40.0177 43.0249C39.5391 43.1162 39.3978 43.4221 39.3633 44.0546C39.3267 44.6331 39.3267 45.1391 39.3267 47.8868V51.0669C39.3267 52.8213 39.3267 54.248 39.3978 55.0257C39.4507 55.513 39.5757 55.8396 40.1061 55.9112C40.354 55.9464 40.7453 55.9827 41.0105 55.9827C41.2056 55.9827 41.293 56.0377 41.293 56.1268C41.293 56.2533 41.1517 56.3083 40.9566 56.3083C39.787 56.3083 38.6723 56.2533 38.1937 56.2533C37.7873 56.2533 36.6705 56.3083 35.9623 56.3083C35.7316 56.3083 35.6076 56.2533 35.6076 56.1268C35.6076 56.0366 35.6788 55.9827 35.8901 55.9827C36.1574 55.9827 36.3687 55.9464 36.5293 55.9112C36.8829 55.8386 36.9896 55.5317 37.0424 55.0081C37.1308 54.2491 37.1308 52.8213 37.1308 51.0669V47.8868L37.1298 47.8879Z" fill="white"/>
                    <path d="M46.9122 47.8879C46.9122 45.1402 46.9122 44.6342 46.8776 44.0556C46.8421 43.4418 46.7008 43.1525 46.1145 43.026C45.9733 42.9907 45.6715 42.971 45.4256 42.971C45.2295 42.971 45.1238 42.9358 45.1238 42.8093C45.1238 42.6828 45.2477 42.6465 45.513 42.6465C46.4519 42.6465 47.5676 42.7004 47.9385 42.7004C48.5411 42.7004 49.8865 42.6465 50.4362 42.6465C51.5519 42.6465 52.7388 42.7554 53.695 43.4231C54.1908 43.7673 54.8991 44.6881 54.8991 45.9002C54.8991 47.2377 54.3494 48.4664 52.5609 49.9481C54.137 51.9721 55.3584 53.5803 56.404 54.7011C57.3968 55.7484 58.1213 55.8759 58.3875 55.9298C58.5826 55.9651 58.7422 55.9838 58.8834 55.9838C59.0246 55.9838 59.0968 56.0387 59.0968 56.1279C59.0968 56.272 58.9728 56.3093 58.7594 56.3093H57.0777C56.0849 56.3093 55.6429 56.2181 55.1816 55.9651C54.4205 55.5503 53.7478 54.7011 52.756 53.3086C52.0478 52.3153 51.2328 51.0866 51.0022 50.8139C50.9148 50.7061 50.8071 50.6874 50.6831 50.6874L49.1426 50.6522C49.0532 50.6522 49.0004 50.6874 49.0004 50.7963V51.0493C49.0004 52.7301 49.0004 54.1578 49.0898 54.9168C49.1426 55.4404 49.2483 55.8396 49.7808 55.9122C50.046 55.9475 50.4352 55.9838 50.6475 55.9838C50.7898 55.9838 50.8609 56.0387 50.8609 56.1279C50.8609 56.2544 50.737 56.3093 50.5063 56.3093C49.48 56.3093 48.1681 56.2544 47.9029 56.2544C47.5666 56.2544 46.4509 56.3093 45.7426 56.3093C45.5119 56.3093 45.388 56.2544 45.388 56.1279C45.388 56.0377 45.4591 55.9838 45.6705 55.9838C45.9377 55.9838 46.1491 55.9475 46.3096 55.9122C46.6632 55.8396 46.7527 55.4415 46.8228 54.9168C46.9112 54.1578 46.9112 52.7301 46.9112 51.0669V47.8868L46.9122 47.8879ZM49.0014 49.3156C49.0014 49.5147 49.038 49.5863 49.1619 49.6412C49.5338 49.7677 50.0643 49.8216 50.5073 49.8216C51.2156 49.8216 51.4462 49.7501 51.7653 49.5137C52.2978 49.1166 52.8109 48.285 52.8109 46.8033C52.8109 44.237 51.1455 43.4957 50.1009 43.4957C49.6578 43.4957 49.3398 43.5143 49.1619 43.5693C49.038 43.6046 49.0014 43.6771 49.0014 43.8223V49.3156Z" fill="white"/>
                    <path d="M61.2144 47.8878C61.2144 45.1401 61.2144 44.6341 61.1788 44.0555C61.1443 43.4417 61.003 43.1524 60.4177 43.0259C60.2765 42.9907 59.9747 42.972 59.7268 42.972C59.5317 42.972 59.427 42.9367 59.427 42.8102C59.427 42.6838 59.551 42.6475 59.8162 42.6475C60.7551 42.6475 61.8698 42.7014 62.4023 42.7014C62.828 42.7014 63.9428 42.6475 64.5799 42.6475C64.8471 42.6475 64.9711 42.6838 64.9711 42.8102C64.9711 42.9367 64.8644 42.972 64.6866 42.972C64.4915 42.972 64.3848 42.9907 64.1734 43.0259C63.6948 43.1172 63.5536 43.423 63.519 44.0555C63.4824 44.6341 63.4824 45.1401 63.4824 47.8878V50.4178C63.4824 53.039 63.9956 54.1412 64.8644 54.8639C65.6621 55.5337 66.477 55.6052 67.0786 55.6052C67.859 55.6052 68.8152 55.3522 69.5234 54.6295C70.4969 53.6341 70.5497 52.0083 70.5497 50.1472V47.8878C70.5497 45.1401 70.5497 44.6341 70.5152 44.0555C70.4796 43.4417 70.3374 43.1524 69.7541 43.0259C69.6108 42.9907 69.311 42.972 69.1149 42.972C68.9188 42.972 68.8152 42.9367 68.8152 42.8102C68.8152 42.6838 68.9391 42.6475 69.1871 42.6475C70.0894 42.6475 71.2062 42.7014 71.2234 42.7014C71.4358 42.7014 72.5515 42.6475 73.2425 42.6475C73.4905 42.6475 73.6144 42.6838 73.6144 42.8102C73.6144 42.9367 73.5077 42.972 73.2954 42.972C73.1003 42.972 72.9936 42.9907 72.7822 43.0259C72.3036 43.1172 72.1624 43.423 72.1258 44.0555C72.0912 44.6341 72.0912 45.1401 72.0912 47.8878V49.8216C72.0912 51.8279 71.8961 53.9597 70.4085 55.262C69.1505 56.3642 67.8763 56.5633 66.725 56.5633C65.786 56.5633 64.086 56.5094 62.7925 55.3149C61.8891 54.4833 61.2164 53.1479 61.2164 50.5266V47.8878H61.2144Z" fill="white"/>
                    <path d="M78.8455 47.8878C78.8455 45.1401 78.8455 44.6341 78.811 44.0555C78.7754 43.4417 78.6342 43.1524 78.0479 43.0259C77.9066 42.9907 77.6048 42.972 77.3569 42.972C77.1618 42.972 77.0571 42.9367 77.0571 42.8102C77.0571 42.6838 77.1811 42.6475 77.4463 42.6475C78.3852 42.6475 79.502 42.7014 79.9958 42.7014C80.7224 42.7014 81.7497 42.6475 82.5646 42.6475C84.7788 42.6475 85.5755 43.4065 85.86 43.6771C86.2492 44.0566 86.7451 44.8705 86.7451 45.8286C86.7451 48.3948 84.9018 50.2021 82.3868 50.2021C82.2984 50.2021 82.1043 50.2021 82.0149 50.1834C81.9275 50.1658 81.8025 50.1482 81.8025 50.0217C81.8025 49.8776 81.9265 49.8226 82.2984 49.8226C83.2902 49.8226 84.6721 48.6841 84.6721 46.8395C84.6721 46.2433 84.6193 45.0323 83.6265 44.1291C82.9894 43.5329 82.2618 43.4241 81.8554 43.4241C81.5902 43.4241 81.3249 43.4427 81.1644 43.4967C81.076 43.5329 81.0231 43.6418 81.0231 43.8409V51.0689C81.0231 52.7321 81.0231 54.1588 81.1115 54.9365C81.1654 55.4425 81.2721 55.8416 81.8025 55.9132C82.0505 55.9484 82.4397 55.9847 82.7059 55.9847C82.902 55.9847 82.9904 56.0397 82.9904 56.1289C82.9904 56.2554 82.8492 56.3103 82.6541 56.3103C81.4845 56.3103 80.3677 56.2554 79.9084 56.2554C79.502 56.2554 78.3852 56.3103 77.677 56.3103C77.4463 56.3103 77.3223 56.2554 77.3223 56.1289C77.3223 56.0387 77.3935 55.9847 77.6048 55.9847C77.8721 55.9847 78.0834 55.9484 78.244 55.9132C78.5976 55.8406 78.687 55.4425 78.7571 54.9178C78.8455 54.1588 78.8455 52.731 78.8455 51.0679V47.8878Z" fill="white"/>
                    <path d="M32.5011 56.1551C32.5011 56.1551 32.1099 56.1457 31.676 56.1551C30.9098 56.1727 29.9984 54.8237 29.9984 54.8237L29.6508 54.3582L29.8175 44.6095C29.8358 43.5913 29.978 43.2076 30.477 43.0625C30.6914 43.0065 30.8336 43.0065 31.0125 43.0065C31.2269 43.0065 31.3326 42.9536 31.3326 42.8427C31.3326 42.6975 31.1537 42.6788 30.921 42.6788C30.0502 42.6788 29.3724 42.7348 29.1753 42.7348C28.8003 42.7348 27.9468 42.6788 27.018 42.6788C26.7518 42.6788 26.5546 42.6975 26.5546 42.8427C26.5546 42.9536 26.6268 43.0065 26.8392 43.0065C27.0902 43.0065 27.5169 43.0065 27.7862 43.1174C28.213 43.2999 28.3735 43.6452 28.3908 44.7536L28.5697 52.919H28.4792C28.1764 52.6287 25.7712 50.0085 24.5579 48.7736C21.9586 46.1368 19.2516 43.1703 19.0362 42.936C18.8746 42.7618 18.6633 42.598 18.4712 42.4818C18.1735 42.2786 18.0586 42.3139 18.0586 42.3139H14.995C14.6698 42.3139 14.6403 42.7753 15.0458 42.8033C15.0458 42.8033 15.436 42.8126 15.8709 42.8033C16.6371 42.7856 17.5485 44.1346 17.5485 44.1346L18.1186 44.8998L17.9865 53.7547C17.9682 55.3349 17.8961 55.8627 17.4327 56.0078C17.1848 56.0814 16.8637 56.1001 16.631 56.1001C16.4521 56.1001 16.3464 56.1343 16.3464 56.2453C16.3464 56.4091 16.507 56.4278 16.7366 56.4278C17.6654 56.4278 18.5037 56.3718 18.6643 56.3718C19.0026 56.3718 19.714 56.4278 20.8724 56.4278C21.1233 56.4278 21.2839 56.3904 21.2839 56.2453C21.2839 56.1343 21.1752 56.1001 20.978 56.1001C20.6935 56.1001 20.3551 56.0814 20.0523 55.9705C19.6957 55.844 19.465 55.3712 19.4294 53.9548L19.2333 46.3141H19.2882C19.6093 46.6594 21.5877 48.9353 23.5296 50.8981C25.1341 52.5219 27.0597 54.5241 28.278 55.7413C28.4894 55.9757 28.6703 56.1499 28.8217 56.2784C29.0066 56.4672 29.2078 56.6434 29.3927 56.6434C29.4019 56.6434 29.408 56.6372 29.4171 56.6362C29.4659 56.6465 29.4893 56.6434 29.4893 56.6434H32.5529C32.8781 56.6434 32.9076 56.182 32.5021 56.154" fill="white"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_845_201">
                    <rect width="72" height="25" fill="white" transform="translate(14.7461 42.3115)"/>
                    </clipPath>
                    </defs>
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