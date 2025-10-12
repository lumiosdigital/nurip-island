<?php
/**
 * Reusable Booking Modal
 */

$post_id = get_the_ID();
$calendar_id = get_post_meta($post_id, '_villa_booking_calendar_id', true);
$form_id = get_post_meta($post_id, '_villa_booking_form_id', true);

$post_type = get_post_type();
$post_type_label = '';

switch ($post_type) {
    case 'villa':
        $post_type_label = 'Villa';
        break;
    case 'boat':
    case 'marina':
        $post_type_label = 'Boat';
        break;
    case 'experience':
        $post_type_label = 'Experience';
        break;
    case 'event':
        $post_type_label = 'Event';
        break;
    default:
        $post_type_label = '';
}

if ($calendar_id) : 
?>
<!-- Booking Modal for <?php the_title(); ?> -->
<div id="nirup-booking-modal-<?php echo $post_id; ?>" class="villa-booking-modal" aria-hidden="true" role="dialog">
    <div class="villa-booking-backdrop"></div>
    <div class="villa-booking-container" role="document">
        <button class="villa-booking-close" aria-label="Close booking">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                <circle cx="15" cy="15" r="14.5" stroke="currentColor"/>
                <path d="M10 10L20 20M20 10L10 20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </button>
        
        <div class="villa-booking-header">
            <h2 class="villa-booking-title">Book <?php echo esc_html($post_type_label . ' ' . get_the_title()); ?></h2>
            <p class="villa-booking-subtitle">Select your dates and complete your reservation</p>
        </div>
        
        <div class="villa-booking-content">
            <div class="villa-booking-calendar-wrapper">
                <?php 
                if ($calendar_id) {
                    echo do_shortcode(
                        sprintf('[wpbs id="%s"%s]',
                            esc_attr($calendar_id),
                            $form_id ? ' form_id="' . esc_attr($form_id) . '"' : ''
                        )
                    );
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>