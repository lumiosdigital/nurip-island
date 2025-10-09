<?php
/**
 * Template Name: Private Events Page
 * Description: Private events page matching Figma design exactly (node 1291:4062)
 */

get_header();
?>

<?php get_template_part('template-parts/breadcrumbs'); ?>

<main id="private-events-page" class="private-events-page">
    
    <!-- Hero Section with Image -->
    <section class="private-events-hero">
        <?php 
        $hero_image_id = get_theme_mod('nirup_private_events_hero_image');
        if ($hero_image_id) {
            echo wp_get_attachment_image($hero_image_id, 'master', false, array('class' => 'private-hero-bg-image'));
        }
        ?>
        <div class="private-hero-overlay"></div>
        <div class="private-hero-content">
            <h1 class="private-hero-title">
                <?php echo esc_html(get_theme_mod('nirup_private_events_title', 'PRIVATE EVENTS')); ?>
            </h1>
            <p class="private-hero-subtitle">
                <?php echo esc_html(get_theme_mod('nirup_private_events_hero_subtitle', 'Versatile venues where elegance meets island beauty Ideal for meetings, weddings, and celebrations')); ?>
            </p>
        </div>
    </section>

    <!-- Events Section Header -->
    <section class="events-section-header">
        <div class="events-header-container">
            <h2 class="events-section-title">
                <?php echo esc_html(get_theme_mod('nirup_private_events_section_title', 'EVENTS')); ?>
            </h2>
            <p class="events-section-description">
                <?php echo esc_html(get_theme_mod('nirup_private_events_section_description', 'Versatile venues for weddings, meetings, and private celebrations on Nirup Island, offering elegant spaces, breathtaking views, and tailored experiences to make every event truly unforgettable.')); ?>
            </p>
        </div>
    </section>

    <!-- Event Cards Grid -->
    <section class="events-cards-section">
        <div class="events-cards-container">
            
            <!-- Card 1: Ballroom -->
            <div class="event-card">
                <div class="event-card-image">
                    <?php 
                    $ballroom_image_id = get_theme_mod('nirup_event_ballroom_image');
                    if ($ballroom_image_id) {
                        echo wp_get_attachment_image($ballroom_image_id, 'full', false, array('class' => 'card-img'));
                    }
                    ?>
                </div>
                <div class="event-card-content">
                    <p class="event-card-location">
                        <?php echo esc_html(get_theme_mod('nirup_event_ballroom_location', 'Westin Nirup Island Resort & Spa')); ?>
                    </p>
                    <h3 class="event-card-title">
                        <?php echo esc_html(get_theme_mod('nirup_event_ballroom_title', 'BALLROOM')); ?>
                    </h3>
                    <p class="event-card-description">
                        <?php echo esc_html(get_theme_mod('nirup_event_ballroom_description', 'Celebrate life\'s most important moments at Nirup Island\'s elegant ballroom. Perfect for weddings, anniversaries, and milestone events, the ballroom offers a pillarless 450 sqm space that can be transformed to match your vision. With breathtaking views and access to the island\'s unique venues, your celebration becomes truly unforgettable.')); ?>
                    </p>
                    <div class="event-card-details">
                        <div class="detail-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <path d="M13.9805 2.60645C17.0846 2.60663 19.6006 5.12339 19.6006 8.22754C19.6004 11.3315 17.0844 13.8475 13.9805 13.8477C10.8763 13.8477 8.35956 11.3316 8.35938 8.22754C8.35938 5.12328 10.8762 2.60645 13.9805 2.60645ZM13.9805 4.08887C11.695 4.08887 9.8418 5.9421 9.8418 8.22754C9.84198 10.5128 11.6952 12.3652 13.9805 12.3652C16.2656 12.3651 18.118 10.5127 18.1182 8.22754C18.1182 5.94222 16.2657 4.08905 13.9805 4.08887Z" fill="#A48456" stroke="#A48456" stroke-width="0.25"/>
                            <path d="M13.9805 15.5605C16.9921 15.5605 19.8838 16.5793 22.0186 18.3975C23.5338 19.6881 24.5805 21.3076 25.0605 23.0625C25.2334 23.6942 25.0456 24.2813 24.6543 24.707C24.2648 25.1307 23.6744 25.3954 23.0332 25.3955H4.92871C4.28726 25.3955 3.69625 25.1309 3.30664 24.707C2.91539 24.2813 2.72759 23.6942 2.90039 23.0625C3.38049 21.3076 4.42709 19.6881 5.94238 18.3975C8.07711 16.5792 10.9688 15.5606 13.9805 15.5605ZM13.9805 17.043C11.292 17.043 8.7485 17.9547 6.90332 19.5264C5.59785 20.6384 4.72583 22.0075 4.33008 23.4541C4.31577 23.5066 4.31618 23.5471 4.3252 23.582C4.33437 23.6176 4.35554 23.6574 4.39844 23.7041C4.49686 23.811 4.68659 23.9131 4.92871 23.9131H23.0332C23.2753 23.913 23.4652 23.811 23.5635 23.7041C23.6064 23.6575 23.6276 23.6176 23.6367 23.582C23.6457 23.5471 23.6452 23.5066 23.6309 23.4541C23.2351 22.0074 22.3632 20.6384 21.0576 19.5264C19.2124 17.9547 16.6691 17.043 13.9805 17.043Z" fill="#A48456" stroke="#A48456" stroke-width="0.25"/>
                            </svg>
                            <span>Up to 200 guests<br/>(round table setup)</span>
                        </div>
                        <div class="detail-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <path d="M13.9805 2.60645C17.0846 2.60663 19.6006 5.12339 19.6006 8.22754C19.6004 11.3315 17.0844 13.8475 13.9805 13.8477C10.8763 13.8477 8.35956 11.3316 8.35938 8.22754C8.35938 5.12328 10.8762 2.60645 13.9805 2.60645ZM13.9805 4.08887C11.695 4.08887 9.8418 5.9421 9.8418 8.22754C9.84198 10.5128 11.6952 12.3652 13.9805 12.3652C16.2656 12.3651 18.118 10.5127 18.1182 8.22754C18.1182 5.94222 16.2657 4.08905 13.9805 4.08887Z" fill="#A48456" stroke="#A48456" stroke-width="0.25"/>
                            <path d="M13.9805 15.5605C16.9921 15.5605 19.8838 16.5793 22.0186 18.3975C23.5338 19.6881 24.5805 21.3076 25.0605 23.0625C25.2334 23.6942 25.0456 24.2813 24.6543 24.707C24.2648 25.1307 23.6744 25.3954 23.0332 25.3955H4.92871C4.28726 25.3955 3.69625 25.1309 3.30664 24.707C2.91539 24.2813 2.72759 23.6942 2.90039 23.0625C3.38049 21.3076 4.42709 19.6881 5.94238 18.3975C8.07711 16.5792 10.9688 15.5606 13.9805 15.5605ZM13.9805 17.043C11.292 17.043 8.7485 17.9547 6.90332 19.5264C5.59785 20.6384 4.72583 22.0075 4.33008 23.4541C4.31577 23.5066 4.31618 23.5471 4.3252 23.582C4.33437 23.6176 4.35554 23.6574 4.39844 23.7041C4.49686 23.811 4.68659 23.9131 4.92871 23.9131H23.0332C23.2753 23.913 23.4652 23.811 23.5635 23.7041C23.6064 23.6575 23.6276 23.6176 23.6367 23.582C23.6457 23.5471 23.6452 23.5066 23.6309 23.4541C23.2351 22.0074 22.3632 20.6384 21.0576 19.5264C19.2124 17.9547 16.6691 17.043 13.9805 17.043Z" fill="#A48456" stroke="#A48456" stroke-width="0.25"/>
                            </svg>
                            <span>Up to 400 guests<br/>(cocktail reception)</span>
                        </div>
                        <div class="detail-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M17.8053 0H4.19467C3.08277 0.0019388 2.01696 0.444498 1.23073 1.23073C0.444498 2.01696 0.0019388 3.08277 0 4.19467V17.8053C0.0019388 18.9172 0.444498 19.983 1.23073 20.7693C2.01696 21.5555 3.08277 21.9981 4.19467 22H17.8053C18.9172 21.9981 19.983 21.5555 20.7693 20.7693C21.5555 19.983 21.9981 18.9172 22 17.8053V4.19467C21.9981 3.08277 21.5555 2.01696 20.7693 1.23073C19.983 0.444498 18.9172 0.0019388 17.8053 0ZM20.5333 17.8053C20.5314 18.5282 20.2434 19.221 19.7322 19.7322C19.221 20.2434 18.5282 20.5314 17.8053 20.5333H4.19467C3.47175 20.5314 2.779 20.2434 2.26782 19.7322C1.75664 19.221 1.4686 18.5282 1.46667 17.8053V4.19467C1.4686 3.47175 1.75664 2.779 2.26782 2.26782C2.779 1.75664 3.47175 1.4686 4.19467 1.46667H17.8053C18.5282 1.4686 19.221 1.75664 19.7322 2.26782C20.2434 2.779 20.5314 3.47175 20.5333 4.19467V17.8053Z" fill="#A48456"/>
                            <path d="M17.3 12.288C17.1143 12.288 16.9363 12.3617 16.805 12.493C16.6737 12.6243 16.6 12.8023 16.6 12.988V15.613L6.387 5.4H9.012C9.19765 5.4 9.3757 5.32625 9.50697 5.19497C9.63825 5.0637 9.712 4.88565 9.712 4.7C9.712 4.51435 9.63825 4.3363 9.50697 4.20503C9.3757 4.07375 9.19765 4 9.012 4H4.483C4.3549 4 4.23205 4.05089 4.14147 4.14147C4.05089 4.23205 4 4.3549 4 4.483V9.012C4 9.19765 4.07375 9.3757 4.20503 9.50697C4.3363 9.63825 4.51435 9.712 4.7 9.712C4.88565 9.712 5.0637 9.63825 5.19497 9.50697C5.32625 9.3757 5.4 9.19765 5.4 9.012V6.387L15.613 16.6H12.988C12.8023 16.6 12.6243 16.6737 12.493 16.805C12.3617 16.9363 12.288 17.1143 12.288 17.3C12.288 17.4857 12.3617 17.6637 12.493 17.795C12.6243 17.9263 12.8023 18 12.988 18H17.517C17.6451 18 17.768 17.9491 17.8585 17.8585C17.9491 17.768 18 17.6451 18 17.517V12.988C18 12.8023 17.9263 12.6243 17.795 12.493C17.6637 12.3617 17.4857 12.288 17.3 12.288Z" fill="#A48456"/>
                            </svg>
                            <span>450 sqm pillarless space</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Meeting Rooms -->
            <div class="event-card">
                <div class="event-card-image">
                    <?php 
                    $meeting_image_id = get_theme_mod('nirup_event_meeting_image');
                    if ($meeting_image_id) {
                        echo wp_get_attachment_image($meeting_image_id, 'full', false, array('class' => 'card-img'));
                    }
                    ?>
                </div>
                <div class="event-card-content">
                    <p class="event-card-location">
                        <?php echo esc_html(get_theme_mod('nirup_event_meeting_location', 'Westin Nirup Island Resort & Spa')); ?>
                    </p>
                    <h3 class="event-card-title">
                        <?php echo esc_html(get_theme_mod('nirup_event_meeting_title', 'MEETING ROOMS')); ?>
                    </h3>
                    <p class="event-card-description">
                        <?php echo esc_html(get_theme_mod('nirup_event_meeting_description', 'Designed for productivity and collaboration, our meeting rooms combine a professional setting with the island\'s calming atmosphere. Ideal for board meetings, team workshops, or small conferences, each space offers flexible layouts, modern amenities, and the option to be combined for larger gatherings.')); ?>
                    </p>
                    <div class="event-card-details">
                        <div class="detail-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <path d="M7.875 22.75H20.125C20.6089 22.75 21 22.358 21 21.875V14C21 13.517 20.6089 13.125 20.125 13.125H7.875C7.39113 13.125 7 13.517 7 14V21.875C7 22.358 7.39113 22.75 7.875 22.75ZM8.75 14.875H19.25V21H8.75V14.875Z" fill="#A48456"/>
                            <path d="M22.75 4.375H5.25C4.28487 4.375 3.5 5.15987 3.5 6.125V10.5V25.375C3.5 25.858 3.89113 26.25 4.375 26.25H23.625C24.1089 26.25 24.5 25.858 24.5 25.375V10.5V6.125C24.5 5.15987 23.7151 4.375 22.75 4.375ZM5.25 6.125H22.75V9.625H5.25V6.125ZM22.75 24.5H5.25V11.375H22.75V24.5Z" fill="#A48456"/>
                            <path d="M9.625 7.875C9.625 8.358 9.233 8.75 8.75 8.75C8.267 8.75 7.875 8.358 7.875 7.875C7.875 7.392 8.267 7 8.75 7C9.233 7 9.625 7.392 9.625 7.875Z" fill="#A48456"/>
                            <path d="M20.125 7.875C20.125 8.358 19.733 8.75 19.25 8.75C18.767 8.75 18.375 8.358 18.375 7.875C18.375 7.392 18.767 7 19.25 7C19.733 7 20.125 7.392 20.125 7.875Z" fill="#A48456"/>
                            <path d="M16.625 7.875C16.625 8.358 16.2339 8.75 15.75 8.75H12.25C11.7661 8.75 11.375 8.358 11.375 7.875C11.375 7.392 11.7661 7 12.25 7H15.75C16.2339 7 16.625 7.392 16.625 7.875Z" fill="#A48456"/>
                            <path d="M6.125 2.625C6.125 2.142 6.51613 1.75 7 1.75H10.5C10.9839 1.75 11.375 2.142 11.375 2.625C11.375 3.108 10.9839 3.5 10.5 3.5H7C6.51613 3.5 6.125 3.108 6.125 2.625Z" fill="#A48456"/>
                            <path d="M16.625 2.625C16.625 2.142 17.0161 1.75 17.5 1.75H21C21.4839 1.75 21.875 2.142 21.875 2.625C21.875 3.108 21.4839 3.5 21 3.5H17.5C17.0161 3.5 16.625 3.108 16.625 2.625Z" fill="#A48456"/>
                            </svg>
                            <span>3 meeting rooms<br/>in total</span>
                        </div>
                        <div class="detail-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <path d="M13.9805 2.60645C17.0846 2.60663 19.6006 5.12339 19.6006 8.22754C19.6004 11.3315 17.0844 13.8475 13.9805 13.8477C10.8763 13.8477 8.35956 11.3316 8.35938 8.22754C8.35938 5.12328 10.8762 2.60645 13.9805 2.60645ZM13.9805 4.08887C11.695 4.08887 9.8418 5.9421 9.8418 8.22754C9.84198 10.5128 11.6952 12.3652 13.9805 12.3652C16.2656 12.3651 18.118 10.5127 18.1182 8.22754C18.1182 5.94222 16.2657 4.08905 13.9805 4.08887Z" fill="#A48456" stroke="#A48456" stroke-width="0.25"/>
                            <path d="M13.9805 15.5605C16.9921 15.5605 19.8838 16.5793 22.0186 18.3975C23.5338 19.6881 24.5805 21.3076 25.0605 23.0625C25.2334 23.6942 25.0456 24.2813 24.6543 24.707C24.2648 25.1307 23.6744 25.3954 23.0332 25.3955H4.92871C4.28726 25.3955 3.69625 25.1309 3.30664 24.707C2.91539 24.2813 2.72759 23.6942 2.90039 23.0625C3.38049 21.3076 4.42709 19.6881 5.94238 18.3975C8.07711 16.5792 10.9688 15.5606 13.9805 15.5605ZM13.9805 17.043C11.292 17.043 8.7485 17.9547 6.90332 19.5264C5.59785 20.6384 4.72583 22.0075 4.33008 23.4541C4.31577 23.5066 4.31618 23.5471 4.3252 23.582C4.33437 23.6176 4.35554 23.6574 4.39844 23.7041C4.49686 23.811 4.68659 23.9131 4.92871 23.9131H23.0332C23.2753 23.913 23.4652 23.811 23.5635 23.7041C23.6064 23.6575 23.6276 23.6176 23.6367 23.582C23.6457 23.5471 23.6452 23.5066 23.6309 23.4541C23.2351 22.0074 22.3632 20.6384 21.0576 19.5264C19.2124 17.9547 16.6691 17.043 13.9805 17.043Z" fill="#A48456" stroke="#A48456" stroke-width="0.25"/>
                            </svg>
                            <span>Up to 20 people<br/>(U-shape setup)</span>
                        </div>
                        <div class="detail-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <path d="M13.9805 2.60645C17.0846 2.60663 19.6006 5.12339 19.6006 8.22754C19.6004 11.3315 17.0844 13.8475 13.9805 13.8477C10.8763 13.8477 8.35956 11.3316 8.35938 8.22754C8.35938 5.12328 10.8762 2.60645 13.9805 2.60645ZM13.9805 4.08887C11.695 4.08887 9.8418 5.9421 9.8418 8.22754C9.84198 10.5128 11.6952 12.3652 13.9805 12.3652C16.2656 12.3651 18.118 10.5127 18.1182 8.22754C18.1182 5.94222 16.2657 4.08905 13.9805 4.08887Z" fill="#A48456" stroke="#A48456" stroke-width="0.25"/>
                                <path d="M13.9805 15.5605C16.9921 15.5605 19.8838 16.5793 22.0186 18.3975C23.5338 19.6881 24.5805 21.3076 25.0605 23.0625C25.2334 23.6942 25.0456 24.2813 24.6543 24.707C24.2648 25.1307 23.6744 25.3954 23.0332 25.3955H4.92871C4.28726 25.3955 3.69625 25.1309 3.30664 24.707C2.91539 24.2813 2.72759 23.6942 2.90039 23.0625C3.38049 21.3076 4.42709 19.6881 5.94238 18.3975C8.07711 16.5792 10.9688 15.5606 13.9805 15.5605ZM13.9805 17.043C11.292 17.043 8.7485 17.9547 6.90332 19.5264C5.59785 20.6384 4.72583 22.0075 4.33008 23.4541C4.31577 23.5066 4.31618 23.5471 4.3252 23.582C4.33437 23.6176 4.35554 23.6574 4.39844 23.7041C4.49686 23.811 4.68659 23.9131 4.92871 23.9131H23.0332C23.2753 23.913 23.4652 23.811 23.5635 23.7041C23.6064 23.6575 23.6276 23.6176 23.6367 23.582C23.6457 23.5471 23.6452 23.5066 23.6309 23.4541C23.2351 22.0074 22.3632 20.6384 21.0576 19.5264C19.2124 17.9547 16.6691 17.043 13.9805 17.043Z" fill="#A48456" stroke="#A48456" stroke-width="0.25"/>
                            </svg>
                            <span>Up to 20 people<br/>(theater style setup)</span>
                        </div>
                        <div class="detail-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <path d="M13.9805 2.60645C17.0846 2.60663 19.6006 5.12339 19.6006 8.22754C19.6004 11.3315 17.0844 13.8475 13.9805 13.8477C10.8763 13.8477 8.35956 11.3316 8.35938 8.22754C8.35938 5.12328 10.8762 2.60645 13.9805 2.60645ZM13.9805 4.08887C11.695 4.08887 9.8418 5.9421 9.8418 8.22754C9.84198 10.5128 11.6952 12.3652 13.9805 12.3652C16.2656 12.3651 18.118 10.5127 18.1182 8.22754C18.1182 5.94222 16.2657 4.08905 13.9805 4.08887Z" fill="#A48456" stroke="#A48456" stroke-width="0.25"/>
                                <path d="M13.9805 15.5605C16.9921 15.5605 19.8838 16.5793 22.0186 18.3975C23.5338 19.6881 24.5805 21.3076 25.0605 23.0625C25.2334 23.6942 25.0456 24.2813 24.6543 24.707C24.2648 25.1307 23.6744 25.3954 23.0332 25.3955H4.92871C4.28726 25.3955 3.69625 25.1309 3.30664 24.707C2.91539 24.2813 2.72759 23.6942 2.90039 23.0625C3.38049 21.3076 4.42709 19.6881 5.94238 18.3975C8.07711 16.5792 10.9688 15.5606 13.9805 15.5605ZM13.9805 17.043C11.292 17.043 8.7485 17.9547 6.90332 19.5264C5.59785 20.6384 4.72583 22.0075 4.33008 23.4541C4.31577 23.5066 4.31618 23.5471 4.3252 23.582C4.33437 23.6176 4.35554 23.6574 4.39844 23.7041C4.49686 23.811 4.68659 23.9131 4.92871 23.9131H23.0332C23.2753 23.913 23.4652 23.811 23.5635 23.7041C23.6064 23.6575 23.6276 23.6176 23.6367 23.582C23.6457 23.5471 23.6452 23.5066 23.6309 23.4541C23.2351 22.0074 22.3632 20.6384 21.0576 19.5264C19.2124 17.9547 16.6691 17.043 13.9805 17.043Z" fill="#A48456" stroke="#A48456" stroke-width="0.25"/>
                            </svg>
                            <span>Up to 50 people<br/>(combined space, without partitions)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Weddings -->
            <div class="event-card">
                <div class="event-card-image">
                    <?php 
                    $wedding_image_id = get_theme_mod('nirup_event_wedding_image');
                    if ($wedding_image_id) {
                        echo wp_get_attachment_image($wedding_image_id, 'full', false, array('class' => 'card-img'));
                    }
                    ?>
                </div>
                <div class="event-card-content">
                    <p class="event-card-location">
                        <?php echo esc_html(get_theme_mod('nirup_event_wedding_location', 'Nirup Island')); ?>
                    </p>
                    <h3 class="event-card-title">
                        <?php echo esc_html(get_theme_mod('nirup_event_wedding_title', 'WEDDINGS')); ?>
                    </h3>
                    <p class="event-card-description">
                        <?php echo esc_html(get_theme_mod('nirup_event_wedding_description', 'Exchange vows against the backdrop of shimmering waters and lush landscapes. Nirup Island offers an enchanting setting for weddings of every scale — from intimate ceremonies to grand celebrations. Our team perfects every detail—from custom décor to curated dining—creating memories that last a lifetime.')); ?>
                    </p>
                    <div class="event-card-details">
                        <div class="detail-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <path d="M27.125 23.625C27.125 24.108 26.733 24.5 26.25 24.5C25.1318 24.5 24.4037 24.864 23.562 25.2858C22.659 25.7381 21.6361 26.25 20.125 26.25C18.606 26.25 17.5788 25.7364 16.6723 25.2831C15.8323 24.8631 15.1069 24.5 14 24.5C12.8931 24.5 12.1678 24.8631 11.3278 25.2831C10.4213 25.7364 9.394 26.25 7.875 26.25C6.36387 26.25 5.341 25.7381 4.438 25.2858C3.59625 24.864 2.86825 24.5 1.75 24.5C1.267 24.5 0.875 24.108 0.875 23.625C0.875 23.142 1.267 22.75 1.75 22.75C3.28212 22.75 4.31287 23.2663 5.222 23.7213C6.05675 24.1386 6.77775 24.5 7.875 24.5C8.981 24.5 9.7055 24.1369 10.5455 23.7178C11.452 23.2636 12.4801 22.75 14 22.75C15.5199 22.75 16.548 23.2636 17.4545 23.7178C18.2945 24.1369 19.019 24.5 20.125 24.5C21.2222 24.5 21.9432 24.1386 22.778 23.7213C23.6871 23.2663 24.7179 22.75 26.25 22.75C26.733 22.75 27.125 23.142 27.125 23.625Z" fill="#A48456"/>
                            <path d="M27.125 19.25C27.125 19.733 26.733 20.125 26.25 20.125C25.1318 20.125 24.4037 20.489 23.562 20.9108C22.659 21.3631 21.6361 21.875 20.125 21.875C18.606 21.875 17.5788 21.3614 16.6723 20.9081C15.8323 20.4881 15.1069 20.125 14 20.125C12.8931 20.125 12.1678 20.4881 11.3278 20.9081C10.4213 21.3614 9.394 21.875 7.875 21.875C6.36387 21.875 5.341 21.3631 4.438 20.9108C3.59625 20.489 2.86825 20.125 1.75 20.125C1.267 20.125 0.875 19.733 0.875 19.25C0.875 18.767 1.267 18.375 1.75 18.375C3.28212 18.375 4.31287 18.8913 5.222 19.3463C6.05675 19.7636 6.77775 20.125 7.875 20.125C8.981 20.125 9.7055 19.7619 10.5455 19.3428C11.452 18.8886 12.4801 18.375 14 18.375C15.5199 18.375 16.548 18.8886 17.4545 19.3428C18.2945 19.7619 19.019 20.125 20.125 20.125C21.2222 20.125 21.9432 19.7636 22.778 19.3463C23.6871 18.8913 24.7179 18.375 26.25 18.375C26.733 18.375 27.125 18.767 27.125 19.25Z" fill="#A48456"/>
                            <path d="M0.875 14.875C0.875 14.392 1.267 14 1.75 14C4.8895 14 6.0725 11.7819 7.56962 8.97312C9.2855 5.75487 11.4205 1.75 17.5 1.75C20.4925 1.75 22.75 3.63037 22.75 6.125C22.75 8.12175 21.1575 9.625 20.125 9.625C19.642 9.625 19.25 9.233 19.25 8.75C19.25 8.5015 19.1931 8.14975 18.7005 7.966C18.046 7.72275 17.122 7.94325 16.6854 8.44725C15.6713 9.61887 15.4735 11.5544 16.205 13.1539C16.9557 14.7971 18.5045 15.7404 20.454 15.7404C21.4051 15.7404 22.0736 15.393 22.8471 14.9905C23.7388 14.5267 24.7511 14 26.25 14C26.733 14 27.125 14.392 27.125 14.875C27.125 15.358 26.733 15.75 26.25 15.75C25.1781 15.75 24.472 16.1175 23.6539 16.5427C22.7999 16.9872 21.8321 17.4904 20.4531 17.4904C17.7896 17.4904 15.6608 16.1752 14.6125 13.881C13.5905 11.6445 13.8915 9.00025 15.3615 7.30187C16.275 6.2475 17.9742 5.82837 19.3112 6.32625C19.8721 6.53537 20.3131 6.888 20.6036 7.34125C20.8171 7.04462 21 6.63425 21 6.125C21 4.62875 19.495 3.5 17.5 3.5C12.4705 3.5 10.8404 6.55812 9.114 9.7965C7.55388 12.7234 5.94037 15.75 1.75 15.75C1.267 15.75 0.875 15.358 0.875 14.875Z" fill="#A48456"/>
                            </svg>
                            <span>Stunning oceanfront<br/>and garden venues</span>
                        </div>
                        <div class="detail-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="28" viewBox="0 0 22 28" fill="none">
                            <path d="M11 9.05078C12.2364 9.05078 13.4198 9.33374 14.5146 9.8916L14.625 9.96289C14.8617 10.1513 14.9415 10.4866 14.7988 10.7666C14.6358 11.0862 14.2444 11.2133 13.9248 11.0508C13.0143 10.5868 12.0302 10.3516 11 10.3516C7.44394 10.3518 4.55102 13.2447 4.55078 16.8008C4.55078 20.357 7.44379 23.2507 11 23.251C14.5564 23.251 17.4502 20.3572 17.4502 16.8008C17.4501 15.9126 17.2756 15.0584 16.9297 14.2559L16.7705 13.915C16.6096 13.5941 16.7397 13.2038 17.0605 13.043C17.3814 12.8822 17.7717 13.0114 17.9326 13.332C18.4752 14.4145 18.7499 15.5823 18.75 16.8008C18.75 21.0743 15.2735 24.5508 11 24.5508C6.72666 24.5505 3.25 21.0742 3.25 16.8008C3.25024 12.5276 6.72681 9.05102 11 9.05078Z" fill="#A48456" stroke="#A48456" stroke-width="0.3"/>
                            <path d="M12.458 1.05078C12.6304 1.05078 12.7961 1.11942 12.918 1.24121L14.9922 3.31543C15.2458 3.56917 15.2456 3.98054 14.9922 4.23438L12.4658 6.75977C17.3702 7.47253 21.1502 11.7019 21.1504 16.8008C21.1504 22.3976 16.5968 26.9512 11 26.9512C5.40316 26.9512 0.849609 22.3976 0.849609 16.8008C0.849803 11.6984 4.63481 7.46629 9.54395 6.75781L7.02051 4.23535C6.8012 4.01604 6.76812 3.6719 6.94043 3.41406L6.95117 3.39941C6.95273 3.39757 6.95398 3.39576 6.95508 3.39453C6.95749 3.39184 6.96031 3.38849 6.96289 3.38574C6.96822 3.38007 6.97592 3.373 6.98438 3.36426C7.0014 3.34665 7.02572 3.32148 7.05566 3.29102C7.11565 3.22998 7.20036 3.14426 7.30078 3.04297C7.50206 2.83995 7.76855 2.57237 8.03418 2.30566C8.3 2.03877 8.56494 1.77247 8.76367 1.57324L9.08887 1.24805C9.09073 1.24619 9.09176 1.24418 9.09277 1.24316L9.09473 1.24219V1.24121C9.21659 1.11939 9.38234 1.05078 9.55469 1.05078H12.458ZM11 7.95117C6.12037 7.95117 2.1506 11.9212 2.15039 16.8008C2.15039 21.6805 6.12024 25.6514 11 25.6514C15.8798 25.6514 19.8496 21.6805 19.8496 16.8008C19.8494 11.9212 15.8796 7.95117 11 7.95117ZM11.0059 6.38184L12.9629 4.4248H9.0498L11.0059 6.38184ZM9.0498 3.125H12.9629L12.1885 2.35156H9.82324L9.0498 3.125Z" fill="#A48456" stroke="#A48456" stroke-width="0.3"/>
                            <path d="M16.0371 11.1475C16.2084 11.1475 16.376 11.2168 16.4971 11.3379C16.6182 11.459 16.6875 11.6265 16.6875 11.7979C16.6875 11.9692 16.6181 12.1367 16.4971 12.2578C16.3757 12.3798 16.208 12.4482 16.0371 12.4482C15.8661 12.4482 15.6986 12.3789 15.5771 12.2568C15.4563 12.1357 15.3867 11.9689 15.3867 11.7979C15.3867 11.6265 15.4561 11.459 15.5771 11.3379C15.6982 11.2169 15.8651 11.1475 16.0371 11.1475Z" fill="#A48456" stroke="#A48456" stroke-width="0.3"/>
                            </svg>
                            <span>Tailored wedding<br/>planning services</span>
                        </div>
                        <div class="detail-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <path d="M14.875 3.5C12.95 3.5 11.375 5.075 11.375 7V15.75C11.375 16.7125 12.1625 17.5 13.125 17.5H14.875V23.625C14.875 24.15 15.225 24.5 15.75 24.5C16.275 24.5 16.625 24.15 16.625 23.625V16.625V5.25C16.625 4.2875 15.8375 3.5 14.875 3.5ZM14.875 15.75H13.125V7C13.125 6.0375 13.9125 5.25 14.875 5.25V15.75Z" fill="#A48456"/>
                            <path d="M22.75 3.5C20.475 3.5 19.25 7.0875 19.25 9.625C19.25 12.25 20.5625 13.475 21.875 13.9125V23.625C21.875 24.15 22.225 24.5 22.75 24.5C23.275 24.5 23.625 24.15 23.625 23.625V13.9125C24.9375 13.5625 26.25 12.3375 26.25 9.625C26.25 7.0875 25.025 3.5 22.75 3.5ZM22.75 12.25C21.2625 12.25 21 10.5875 21 9.625C21 7.2625 22.1375 5.25 22.75 5.25C23.3625 5.25 24.5 7.2625 24.5 9.625C24.5 10.5875 24.2375 12.25 22.75 12.25Z" fill="#A48456"/>
                            <path d="M8.75 4.375V9.625C8.75 11.1125 7.6125 12.25 6.125 12.25V23.625C6.125 24.15 5.775 24.5 5.25 24.5C4.725 24.5 4.375 24.15 4.375 23.625V12.25C2.8875 12.25 1.75 11.1125 1.75 9.625V4.375C1.75 3.85 2.1 3.5 2.625 3.5C3.15 3.5 3.5 3.85 3.5 4.375V9.625C3.5 10.15 3.85 10.5 4.375 10.5V4.375C4.375 3.85 4.725 3.5 5.25 3.5C5.775 3.5 6.125 3.85 6.125 4.375V10.5C6.65 10.5 7 10.15 7 9.625V4.375C7 3.85 7.35 3.5 7.875 3.5C8.4 3.5 8.75 3.85 8.75 4.375Z" fill="#A48456"/>
                            </svg>
                            <span>Customizable dining<br/>& décor packages</span>
                        </div>
                        <div class="detail-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <path d="M11.9427 4V10.8945H6.64648V6.68688" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <mask id="mask0_1291_4228" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="28" height="28">
                                <path d="M0 1.90735e-06H28V28H0V1.90735e-06Z" fill="white"/>
                            </mask>
                            <g mask="url(#mask0_1291_4228)">
                                <path d="M11.1954 1.16817C12.2588 1.73132 12.2695 3.54056 11.2194 5.2091C10.1692 6.8777 8.45581 7.77378 7.39245 7.21058C6.32909 6.64738 6.31841 4.83819 7.36857 3.16965C8.41873 1.50105 10.1321 0.604974 11.1954 1.16817Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M6.2168 14.8691H12.3656V10.7252H6.2168V14.8691Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M6.97404 27H11.6065C12.2803 27 12.8266 26.4631 12.8266 25.8008V14.8695H5.75391V25.8008C5.75391 26.4631 6.30023 27 6.97404 27Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M22.2445 12.3377H15.1719V14.8691H22.2445V12.3377Z" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M22.2445 19.1581V14.8695H15.1719V25.8008C15.1719 26.4631 15.7181 27 16.392 27H21.0244C21.6982 27 22.2445 26.4631 22.2445 25.8008V24.0178" stroke="#A48456" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            </svg>
                            <span>Bridal preparation<br/>suite available</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Form Section -->
    <section class="private-form-section">
        <div class="private-form-section-container">
            <h2 class="private-form-section-title">
                <?php echo esc_html(get_theme_mod('nirup_private_events_form_title', 'PLAN YOUR EVENT WITH US')); ?>
            </h2>
            <p class="private-form-section-description">
                <?php echo esc_html(get_theme_mod('nirup_private_events_form_description', 'From corporate gatherings to once-in-a-lifetime celebrations, Nirup Island provides the perfect backdrop for unforgettable moments. Get in touch with our team today to start planning your event.')); ?>
            </p>

            <form id="private-events-form" class="private-events-form">
                <div class="private-form-columns">
                    <!-- Left Column -->
                    <div class="private-form-column-left">
                        <div class="private-form-field">
                            <label class="private-form-label">Name*</label>
                            <input type="text" name="name" id="event-name" class="private-form-input" placeholder="Your Name" required>
                        </div>
                        <div class="private-form-field">
                            <label class="private-form-label">E-mail*</label>
                            <input type="email" name="email" class="private-form-input" id="event-email" placeholder="Your E-mail" required>
                        </div>
                        <div class="private-form-field">
                            <label class="private-form-label">Phone*</label>
                            <input type="tel" name="phone" class="private-form-input" id="event-phone" placeholder="Your Phone Number" required>
                        </div>
                        <div class="private-form-field">
                            <label class="private-form-label">Preferred Event Date</label>
                            <input type="text" name="event_date" class="private-form-input" id="event-date" placeholder="dd.mm.yyyy">
                        </div>
                        <div class="private-form-field">
                            <label class="private-form-label">Event Type</label>
                            <select name="event_type" id="event-type" class="private-form-select">
                                <option value="">Choose event type</option>
                                <option value="Wedding">Wedding</option>
                                <option value="Corporate Meeting">Corporate Meeting</option>
                                <option value="Team Building Event">Team Building Event</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="private-form-column-right">
                        <div class="private-form-field">
                            <label class="private-form-label">Message</label>
                            <textarea name="message" class="private-form-textarea" id="event-message" placeholder="Tell us about your event details or special requests"></textarea>
                        </div>
                        <button type="submit" class="private-form-submit-btn">
                            <span class="private-btn-text">Submit Inquiry</span>
                            <span class="private-btn-loader"></span>
                        </button>
                    </div>
                </div>

                <div class="private-form-message" id="form-message"></div>
            </form>
        </div>
    </section>

</main>

<!-- Thank You Modal -->
<div id="thank-you-modal" class="thank-you-modal">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <h2 class="modal-title">
            <?php echo esc_html(get_theme_mod('nirup_private_events_modal_title', 'THANK YOU FOR REACHING OUT')); ?>
        </h2>
        <p class="modal-intro-text">
            <?php echo esc_html(get_theme_mod('nirup_private_events_modal_intro', 'Your event request has been received. Our team will be in touch within 1-2 business days to discuss your plans in detail and guide you through the possibilities.')); ?>
        </p>
        
        <div class="modal-links">
            <div class="modal-links-left">
                <?php 
                $link1_url = get_theme_mod('nirup_private_events_modal_link1_url', '/dining/');
                $link1_text = get_theme_mod('nirup_private_events_modal_link1_text', 'Explore our dining experiences');
                if ($link1_url && $link1_text) : ?>
                <a href="<?php echo esc_url($link1_url); ?>" class="modal-link">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" stroke="#A48456" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" stroke="#A48456" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span><?php echo esc_html($link1_text); ?></span>
                </a>
                <?php endif; ?>
                
                <?php 
                $link2_url = get_theme_mod('nirup_private_events_modal_link2_url', '/accommodations/');
                $link2_text = get_theme_mod('nirup_private_events_modal_link2_text', 'Discover accommodation for your guests');
                if ($link2_url && $link2_text) : ?>
                <a href="<?php echo esc_url($link2_url); ?>" class="modal-link">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" stroke="#A48456" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" stroke="#A48456" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span><?php echo esc_html($link2_text); ?></span>
                </a>
                <?php endif; ?>
            </div>
            
            <div class="modal-links-right">
                <?php 
                $phone_text = get_theme_mod('nirup_private_events_modal_phone_text', 'Contact us directly for time-sensitive enquiries at +62 811-6220-999');
                $phone_number = get_theme_mod('nirup_private_events_modal_phone_number', '+62 811-6220-999');
                if ($phone_text) : ?>
                <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone_number)); ?>" class="modal-link modal-phone-link">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" stroke="#A48456" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span><?php echo esc_html($phone_text); ?></span>
                </a>
                <?php endif; ?>
            </div>
        </div>
        
        <p class="modal-closing-text">
            <?php echo esc_html(get_theme_mod('nirup_private_events_modal_closing', 'We look forward to helping you create an event that is both seamless and memorable.')); ?>
        </p>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    window.nirup_private_events_ajax = {
        ajax_url: '<?php echo admin_url('admin-ajax.php'); ?>',
        nonce: '<?php echo wp_create_nonce('private_events_form_nonce'); ?>'
    };
});
</script>

<?php get_footer(); ?>