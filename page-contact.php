<?php
/**
 * Template Name: Contact Page
 * Description: Contact form page for Nirup Island
 */

get_header();
?>

<?php get_template_part('template-parts/breadcrumbs'); ?>

<main id="contact-page" class="contact-page">
    
    <!-- Contact Hero Section -->
    <section class="contact-hero">
        <div class="contact-container">

            <!-- Title -->
            <h1 class="contact-title">CONTACT US</h1>

            <!-- Contact Info -->
            <div class="contact-info-text">
                <p>We welcome your enquiries and are here to assist with every detail of your visit, stay, or event. For urgent matters, please call us at:</p>
                <p class="contact-phone-highlight">
                    <strong>General Enquiries:</strong> 
                    <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('nirup_contact_phone_primary', '+62 811 6220 999'))); ?>">
                        <?php echo esc_html(get_theme_mod('nirup_contact_phone_primary', '+62 811 6220 999')); ?>
                    </a>
                </p>
                <p>For all other requests, please complete the enquiry form below. Our team will review your message and respond within 1-2 business days.</p>
            </div>

            <!-- Contact Form -->
            <form id="contact-form" class="contact-form">
                
                <!-- Name Field -->
                <div class="form-field">
                    <label for="contact-name" class="form-label">Name*</label>
                    <input type="text" id="contact-name" name="name" class="form-input" placeholder="Your Name" required>
                </div>

                <!-- Email Field -->
                <div class="form-field">
                    <label for="contact-email" class="form-label">E-mail*</label>
                    <input type="email" id="contact-email" name="email" class="form-input" placeholder="Your E-mail" required>
                </div>

                <!-- Phone Field -->
                <div class="form-field">
                    <label for="contact-phone" class="form-label">Phone</label>
                    <input type="tel" id="contact-phone" name="phone" class="form-input" placeholder="Your Phone Number">
                </div>

                <!-- Type of Inquiry Dropdown -->
                <div class="form-field">
                    <label for="contact-inquiry-type" class="form-label">Type of Enquiry*</label>
                    <div class="custom-select-wrapper">
                        <select id="contact-inquiry-type" name="inquiry_type" class="form-select" required>
                            <option value="" disabled selected>Choose event type</option>
                            <option value="General Inquiries">General Inquiries</option>
                            <option value="Reservations">Reservations</option>
                            <option value="Riahi Residences">Riahi Residences</option>
                            <option value="The Westin Hotel">The Westin Hotel</option>
                            <option value="Private Events">Private Events</option>
                            <option value="Marina">Marina</option>
                        </select>
                        <svg class="select-arrow" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>

                <!-- Message Field -->
                <div class="form-field form-field-message">
                    <label for="contact-message" class="form-label">Message*</label>
                    <textarea id="contact-message" name="message" class="form-textarea" placeholder="Text your message here" rows="5" required></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="contact-submit-btn">
                    <span class="btn-text">Submit Inquiry</span>
                    <span class="btn-loader"></span>
                </button>

                <!-- Form Messages -->
                <div class="form-message" id="form-message"></div>
            </form>
        </div>
    </section>

</main>

<!-- Thank You Modal -->
<div id="thank-you-modal" class="thank-you-modal">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <h2 class="modal-title">THANK YOU!</h2>
        <p class="modal-text">Your request has been received. Our team is at your service</p>
        <div class="modal-contact">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                <path d="M22 19.92V22.92C22.0011 23.1985 21.9441 23.4741 21.8325 23.7293C21.7209 23.9845 21.5573 24.2136 21.3521 24.4018C21.1469 24.5901 20.9046 24.7335 20.6407 24.8227C20.3769 24.9119 20.0974 24.9451 19.82 24.92C16.7428 24.5856 13.787 23.5341 11.19 21.85C8.77382 20.3147 6.72533 18.2662 5.18999 15.85C3.49997 13.2412 2.44824 10.271 2.11999 7.17997C2.095 6.90344 2.12787 6.62474 2.21649 6.3616C2.30512 6.09846 2.44756 5.85666 2.63476 5.6516C2.82196 5.44653 3.0498 5.28268 3.30379 5.17052C3.55777 5.05836 3.83233 5.00026 4.10999 4.99997H7.10999C7.5953 4.9952 8.06579 5.16705 8.43376 5.48351C8.80173 5.79996 9.04207 6.23942 9.10999 6.71997C9.23662 7.68004 9.47144 8.6227 9.80999 9.52997C9.94454 9.8879 9.97366 10.2769 9.8939 10.6508C9.81415 11.0246 9.62886 11.3681 9.35999 11.64L8.08999 12.91C9.51355 15.4135 11.5864 17.4864 14.09 18.91L15.36 17.64C15.6319 17.3711 15.9753 17.1858 16.3492 17.1061C16.7231 17.0263 17.1121 17.0554 17.47 17.19C18.3773 17.5285 19.3199 17.7634 20.28 17.89C20.7658 17.9585 21.2094 18.2032 21.5265 18.5775C21.8437 18.9518 22.0122 19.4296 22 19.92Z" stroke="#A48456" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>For urgent matters, call 
                <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('nirup_contact_phone_primary', '+62 811 6220 999'))); ?>">
                    <?php echo esc_html(get_theme_mod('nirup_contact_phone_primary', '+62 811 6220 999')); ?>
                </a>
            </span>
        </div>
    </div>
</div>

<?php
get_footer();
?>