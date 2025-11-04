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


    <section class="getting-here-map-section">
        <div class="getting-here-page-container">
            <?php 
            get_template_part('template-parts/map-component', null, array(
                'show_controls' => true,
                'show_route_info' => true,
                'map_height' => '700px',
                'container_class' => 'getting-here-map-wrapper'
            )); 
            ?>
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
                
                <a href="<?php echo esc_url(get_theme_mod('nirup_book_ticket_singapore_url', '#')); ?>" 
                class="book-ticket-btn" 
                target="_blank" 
                rel="noopener noreferrer">
                    <?php echo esc_html(get_theme_mod('nirup_book_ticket_text', __('BOOK FERRY TICKET', 'nirup-island'))); ?>
                </a>
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
                
                <a href="<?php echo esc_url(get_theme_mod('nirup_book_ticket_batam_url', '#')); ?>" 
                class="book-ticket-btn" 
                target="_blank" 
                rel="noopener noreferrer">
                    <?php echo esc_html(get_theme_mod('nirup_book_ticket_text', __('BOOK FERRY TICKET', 'nirup-island'))); ?>
                </a>
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
                <!-- <a href="<?php echo esc_url(get_theme_mod('nirup_visa_free_url', '#')); ?>" class="visa-btn visa-btn-outline"><?php echo esc_html(get_theme_mod('nirup_visa_free_text', __('Visa Free Countries', 'nirup-island'))); ?></a> -->
                <a href="<?php echo esc_url(get_theme_mod('nirup_visa_on_arrival_url', '#')); ?>" class="visa-btn visa-btn-filled"><?php echo esc_html(get_theme_mod('nirup_visa_on_arrival_text', __('Visa-On-Arrival Countries', 'nirup-island'))); ?></a>
            </div>
        </div>
    </section>

</main>

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

<style>
/* Ferry Map Styles */
.getting-here-map-wrapper {
    width: 100%;
    height: 700px;
    background: #e5e5e5;
    margin-bottom: 0;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.nirup-google-map {
    width: 100%;
    height: 100%;
    position: relative;
}

.google-maps-embed {
    width: 100%;
    height: 100%;
}

.google-maps-embed iframe {
    width: 100%;
    height: 100%;
    border: 0;
}

/* Map Loading */
.map-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: #3D332F;
    z-index: 5;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #A48456;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 10px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Map Info Overlay */
.map-info-overlay {
    position: absolute;
    top: 20px;
    left: 20px;
    right: 20px;
    z-index: 10;
    pointer-events: none;
}

.ferry-routes-info {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.route-info {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    padding: 15px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    pointer-events: auto;
    transition: transform 0.2s ease;
}

.route-info:hover {
    transform: translateY(-2px);
}

.route-icon {
    flex-shrink: 0;
}

.route-details h4 {
    margin: 0 0 4px 0;
    font-size: 14px;
    font-weight: 600;
    color: #3D332F;
}

.route-details p {
    margin: 0;
    font-size: 12px;
    color: #666;
}

/* Map Controls */
.map-controls {
    display: flex;
    gap: 10px;
    justify-content: flex-start;
    pointer-events: auto;
}

.map-control-btn {
    background: rgba(255,255,255,0.95);
    border: 2px solid transparent;
    border-radius: 0px;
    padding: 8px 16px;
    font-size: 12px;
    font-weight: 500;
    color: #3D332F;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.map-control-btn:hover,
.map-control-btn.active {
    background: #A48456;
    color: white;
    border-color: #A48456;
}

/* Responsive Design */
@media (max-width: 768px) {
    .getting-here-map-wrapper {
        height: 400px;
    }
    
    .ferry-routes-info {
        flex-direction: column;
        gap: 10px;
    }
    
    .route-info {
        padding: 12px;
    }
    
    .map-controls {
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .map-control-btn {
        padding: 6px 12px;
        font-size: 11px;
    }
}

@media (max-width: 480px) {
    .getting-here-map-wrapper {
        height: 300px;
    }
    
    .map-info-overlay {
        top: 10px;
        left: 10px;
        right: 10px;
    }
}
</style>

<?php get_footer(); ?>