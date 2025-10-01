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
            <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">
                <path d="M6.88965 2.30078C7.53766 2.3135 8.11223 2.57712 8.54395 3.06055L11.8154 6.72266C12.5571 7.55313 12.5913 8.78932 11.8975 9.66016C11.5833 10.0544 11.1866 10.5517 10.707 11.1504C10.3983 11.5357 10.3711 12.0493 10.6377 12.4648C11.4968 13.8038 12.3448 14.8839 13.2305 15.7695C14.116 16.6551 15.1961 17.5032 16.5352 18.3623L16.6953 18.4492C17.0771 18.6183 17.5126 18.5638 17.8496 18.2939C18.4484 17.8142 18.9455 17.4168 19.3398 17.1025C20.2107 16.4086 21.4468 16.4438 22.2773 17.1855L25.9395 20.4561C26.4229 20.8877 26.6865 21.4623 26.6992 22.1104C26.712 22.7584 26.471 23.3425 26.0049 23.793L24.1328 25.6035C23.3722 26.3386 22.3771 26.7002 21.1992 26.7002C20.047 26.7002 18.7178 26.3549 17.2471 25.6787C14.7088 24.5117 11.861 22.4128 9.22363 19.7754C6.58632 17.138 4.48815 14.2901 3.32129 11.752C1.96161 8.79415 1.93262 6.38173 3.39648 4.86719L5.20703 2.99512C5.65721 2.52952 6.24175 2.2869 6.88965 2.30078ZM6.86719 3.4502C6.53792 3.44507 6.26191 3.55848 6.03418 3.79395L4.22363 5.66699C3.55852 6.35528 3.37605 7.28518 3.47363 8.29297C3.57144 9.30214 3.94862 10.3631 4.36621 11.2715C5.47154 13.6759 7.48353 16.4093 10.0371 18.9629C12.5905 21.5164 15.3232 23.5284 17.7275 24.6338C18.6359 25.0514 19.6968 25.4285 20.7061 25.5264C21.7143 25.6241 22.6455 25.4419 23.334 24.7764L25.2061 22.9668C25.4423 22.7385 25.5563 22.4613 25.5498 22.1328C25.5433 21.8045 25.4188 21.5322 25.1738 21.3135H25.1729L21.5107 18.043C21.0992 17.6754 20.4882 17.6581 20.0566 18.002C19.663 18.3156 19.1664 18.7123 18.5684 19.1914C17.7937 19.8119 16.7494 19.8659 15.9141 19.3301C14.5109 18.4298 13.3657 17.5316 12.417 16.583C11.4682 15.6342 10.5701 14.489 9.66992 13.0859C9.13386 12.2504 9.1889 11.2063 9.80957 10.4316C10.2885 9.83371 10.6844 9.33701 10.998 8.94336C11.3419 8.51175 11.3246 7.90081 10.957 7.48926L7.68652 3.82715C7.46769 3.58214 7.19557 3.45668 6.86719 3.4502Z" fill="#A48456" stroke="#A48456" stroke-width="0.4"/>
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