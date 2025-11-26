<?php
/**
 * The template for displaying the footer
 * Contains the footer navigation, contact information, social links, and newsletter subscription
 */
?>

<footer class="site-footer">
    <!-- Decorative line separator -->
    <div class="footer-line-separator">
        <div class="footer-line"></div>
    </div>
    
    <div class="footer-container">
        <div class="footer-content">
            
            <!-- Logo Section -->
            <div class="footer-logo-section">
                <?php if (has_custom_logo()) : ?>
                    <div class="footer-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <div class="footer-logo-text">
                        <a href="<?php echo home_url(); ?>">
                            <?php bloginfo('name'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Social Media Icons -->
            <div class="footer-social-icons">
                <?php
                // Get social media links from Customizer
                $youtube_url = get_theme_mod('nirup_social_youtube', '');
                $instagram_url = get_theme_mod('nirup_social_instagram', '');
                $tiktok_url = get_theme_mod('nirup_social_tiktok', '');
                $facebook_url = get_theme_mod('nirup_social_facebook', '');
                $tripadvisor_url = get_theme_mod('nirup_social_tripadvisor', '');
                ?>
                
                <?php if ($youtube_url) : ?>
                    <a href="<?php echo esc_url($youtube_url); ?>" target="_blank" rel="noopener noreferrer" class="social-link youtube">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
                    <path d="M13 0C5.82029 0 0 5.82029 0 13C0 20.1797 5.82029 26 13 26C20.1797 26 26 20.1797 26 13C26 5.82029 20.1797 0 13 0ZM20.1184 16.5759C19.9476 17.2148 19.4443 17.719 18.8045 17.8899C17.6456 18.2 13 18.2 13 18.2C13 18.2 8.35436 18.2 7.1955 17.8899C6.55664 17.719 6.05243 17.2157 5.88157 16.5759C5.57143 15.4171 5.57143 13 5.57143 13C5.57143 13 5.57143 10.5829 5.88157 9.42407C6.05243 8.78521 6.55571 8.281 7.1955 8.11014C8.35436 7.8 13 7.8 13 7.8C13 7.8 17.6456 7.8 18.8045 8.11014C19.4434 8.281 19.9476 8.78429 20.1184 9.42407C20.4286 10.5829 20.4286 13 20.4286 13C20.4286 13 20.4286 15.4171 20.1184 16.5759ZM11.5143 10.7714L15.3744 13L11.5143 15.2286V10.7714V10.7714Z" fill="#A48456"/>
                    </svg>
                    </a>
                <?php endif; ?>
                
                <?php if ($instagram_url) : ?>
                    <a href="<?php echo esc_url($instagram_url); ?>" target="_blank" rel="noopener noreferrer" class="social-link instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                    <g clip-path="url(#clip0_490_1142)">
                        <path d="M16.667 14C16.667 15.473 15.473 16.667 14 16.667C12.527 16.667 11.333 15.473 11.333 14C11.333 12.527 12.527 11.333 14 11.333C15.473 11.333 16.667 12.527 16.667 14ZM20.512 10.767C20.551 11.611 20.559 11.864 20.559 14C20.559 16.136 20.551 16.389 20.512 17.233C20.476 18.013 20.346 18.437 20.237 18.718C20.092 19.091 19.919 19.358 19.639 19.638C19.359 19.918 19.093 20.091 18.719 20.236C18.437 20.346 18.014 20.476 17.234 20.511C16.39 20.549 16.138 20.558 14.001 20.558C11.864 20.558 11.612 20.55 10.768 20.511C9.988 20.475 9.564 20.345 9.283 20.236C8.91 20.091 8.643 19.918 8.363 19.638C8.083 19.358 7.91 19.092 7.765 18.718C7.655 18.436 7.525 18.013 7.49 17.233C7.451 16.389 7.443 16.136 7.443 14C7.443 11.864 7.451 11.611 7.49 10.767C7.526 9.987 7.656 9.563 7.765 9.282C7.91 8.909 8.083 8.642 8.363 8.362C8.643 8.082 8.909 7.909 9.283 7.763C9.565 7.654 9.988 7.523 10.768 7.488C11.612 7.45 11.865 7.441 14.001 7.441C16.137 7.441 16.39 7.449 17.234 7.488C18.014 7.524 18.438 7.654 18.719 7.763C19.092 7.908 19.359 8.082 19.639 8.361C19.919 8.64 20.092 8.907 20.237 9.281C20.347 9.563 20.477 9.987 20.512 10.766V10.767ZM18.108 14C18.108 11.731 16.269 9.892 14 9.892C11.731 9.892 9.892 11.731 9.892 14C9.892 16.269 11.731 18.108 14 18.108C16.269 18.108 18.108 16.269 18.108 14ZM19.23 9.73C19.23 9.2 18.8 8.77 18.27 8.77C17.74 8.77 17.31 9.2 17.31 9.73C17.31 10.26 17.74 10.69 18.27 10.69C18.8 10.69 19.23 10.26 19.23 9.73ZM28 14C28 21.732 21.732 28 14 28C6.268 28 0 21.732 0 14C0 6.268 6.268 0 14 0C21.732 0 28 6.268 28 14ZM22 14C22 11.827 21.991 11.555 21.952 10.702C21.913 9.85 21.778 9.269 21.58 8.76C21.376 8.234 21.102 7.788 20.657 7.343C20.212 6.898 19.766 6.625 19.24 6.42C18.731 6.222 18.15 6.087 17.298 6.048C16.445 6.009 16.172 6 14 6C11.828 6 11.555 6.009 10.702 6.048C9.85 6.087 9.269 6.222 8.76 6.42C8.234 6.624 7.788 6.898 7.343 7.343C6.898 7.788 6.625 8.234 6.42 8.76C6.222 9.269 6.087 9.85 6.048 10.702C6.009 11.555 6 11.828 6 14C6 16.172 6.009 16.445 6.048 17.298C6.087 18.15 6.222 18.731 6.42 19.24C6.624 19.766 6.898 20.212 7.343 20.657C7.788 21.102 8.234 21.375 8.76 21.58C9.269 21.778 9.85 21.913 10.702 21.952C11.555 21.991 11.828 22 14 22C16.172 22 16.445 21.991 17.298 21.952C18.15 21.913 18.731 21.778 19.24 21.58C19.766 21.376 20.212 21.102 20.657 20.657C21.102 20.212 21.375 19.766 21.58 19.24C21.778 18.731 21.913 18.15 21.952 17.298C21.991 16.445 22 16.172 22 14Z" fill="#A48456"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_490_1142">
                        <rect width="28" height="28" fill="white"/>
                        </clipPath>
                    </defs>
                    </svg>
                    </a>
                <?php endif; ?>
                
                <?php if ($tiktok_url) : ?>
                    <a href="<?php echo esc_url($tiktok_url); ?>" target="_blank" rel="noopener noreferrer" class="social-link tiktok">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                    <g clip-path="url(#clip0_490_1143)">
                        <path d="M14 0C6.268 0 0 6.268 0 14C0 21.732 6.268 28 14 28C21.732 28 28 21.732 28 14C28 6.268 21.732 0 14 0ZM20.934 12.57C20.934 12.57 19.969 12.53 19.253 12.34C18.255 12.073 17.615 11.663 17.615 11.663C17.615 11.663 17.171 11.369 17.138 11.349V16.986C17.138 17.299 17.055 18.083 16.806 18.737C16.588 19.296 16.277 19.814 15.885 20.268C15.885 20.268 15.272 21.028 14.194 21.539C13.223 21.999 12.367 21.989 12.112 21.999C12.112 21.999 10.637 22.058 9.307 21.154L9.3 21.147V21.154C8.85 20.84 8.449 20.462 8.11 20.031C7.689 19.494 7.431 18.857 7.364 18.67V18.663C7.258 18.346 7.036 17.579 7.069 16.839C7.122 15.535 7.56 14.731 7.676 14.531C7.981 13.983 8.379 13.492 8.853 13.08C9.946 12.164 11.372 11.747 12.786 11.929L12.783 14.727C12.553 14.652 12.312 14.614 12.069 14.614C10.789 14.614 9.751 15.658 9.751 16.947C9.751 18.236 10.789 19.28 12.069 19.28C12.468 19.28 12.86 19.177 13.206 18.98C13.881 18.596 14.321 17.902 14.38 17.128V17.122C14.382 17.114 14.382 17.106 14.382 17.098C14.383 17.079 14.385 17.063 14.385 17.046C14.391 16.907 14.391 16.766 14.391 16.623V6H17.139C17.139 6 17.106 6.263 17.175 6.67H17.172C17.255 7.16 17.48 7.861 18.084 8.551C18.325 8.812 18.597 9.042 18.893 9.238C18.995 9.304 19.1 9.366 19.208 9.421C19.911 9.771 20.597 9.878 20.935 9.841V12.569L20.934 12.57Z" fill="#A48456"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_490_1143">
                        <rect width="28" height="28" fill="white"/>
                        </clipPath>
                    </defs>
                    </svg>
                    </a>
                <?php endif; ?>
                
                <?php if ($facebook_url) : ?>
                    <a href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener noreferrer" class="social-link facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
                        <path d="M13 0C5.82036 0 0 5.82036 0 13C0 19.0965 4.19744 24.2122 9.85972 25.6173V16.9728H7.17912V13H9.85972V11.2882C9.85972 6.86348 11.8622 4.8126 16.2063 4.8126C17.03 4.8126 18.4512 4.97432 19.0325 5.13552V8.73652C18.7257 8.70428 18.1927 8.68816 17.5308 8.68816C15.3993 8.68816 14.5756 9.49572 14.5756 11.595V13H18.8219L18.0924 16.9728H14.5756V25.9048C21.0127 25.1274 26.0005 19.6466 26.0005 13C26 5.82036 20.1796 0 13 0Z" fill="#A48456"/>
                    </svg>
                    </a>
                <?php endif; ?>
                
                <?php if ($tripadvisor_url) : ?>
                    <a href="<?php echo esc_url($tripadvisor_url); ?>" target="_blank" rel="noopener noreferrer" class="social-link tripadvisor">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                    <path d="M14 0C21.732 0 28 6.26801 28 14C28 21.732 21.732 28 14 28C6.26801 28 0 21.732 0 14C0 6.26801 6.26801 0 14 0ZM14.0049 7.77734C11.7076 7.77739 9.46371 8.48185 7.56445 9.79785H3.88867L5.54199 11.6289C5.02208 12.1107 4.60706 12.6986 4.32324 13.3535C4.03954 14.0082 3.89367 14.716 3.89453 15.4316C3.89453 18.2733 6.15595 20.577 8.94629 20.5771C10.22 20.5789 11.4469 20.0882 12.3799 19.2051L14 21L15.6191 19.2061C16.552 20.0885 17.7795 20.578 19.0527 20.5762C21.8432 20.5759 24.1064 18.2727 24.1064 15.4316C24.1072 14.7158 23.9617 14.0074 23.6777 13.3525C23.3937 12.6978 22.978 12.1105 22.458 11.6289L24.1113 9.79785H20.4463C18.5469 8.48174 16.3023 7.77734 14.0049 7.77734ZM8.94629 11.9502C9.62248 11.9502 10.2834 12.1546 10.8457 12.5371C11.408 12.9197 11.8467 13.4634 12.1055 14.0996C12.3642 14.7358 12.4317 15.4359 12.2998 16.1113C12.1679 16.7866 11.8423 17.4067 11.3643 17.8936C10.8861 18.3805 10.2766 18.7123 9.61328 18.8467C8.95007 18.981 8.26242 18.9119 7.6377 18.6484C7.01306 18.3849 6.47916 17.9387 6.10352 17.3662C5.72783 16.7936 5.52734 16.1203 5.52734 15.4316C5.52743 14.5083 5.8872 13.6226 6.52832 12.9697C7.16952 12.3168 8.0395 11.9503 8.94629 11.9502ZM19.0518 11.9502C19.9585 11.9503 20.8285 12.3168 21.4697 12.9697C22.1108 13.6226 22.4706 14.5084 22.4707 15.4316C22.4707 16.1203 22.2702 16.7936 21.8945 17.3662C21.5189 17.9387 20.985 18.3849 20.3604 18.6484C19.7356 18.9119 19.048 18.981 18.3848 18.8467C17.7215 18.7123 17.112 18.3805 16.6338 17.8936C16.1557 17.4067 15.8302 16.7866 15.6982 16.1113C15.5663 15.4359 15.6338 14.7358 15.8926 14.0996C16.1513 13.4635 16.5893 12.9197 17.1514 12.5371C17.7137 12.1545 18.3755 11.9502 19.0518 11.9502ZM9.2959 13.6416C8.94834 13.5712 8.58815 13.6071 8.26074 13.7451C7.93319 13.8833 7.653 14.1178 7.45605 14.418C7.25921 14.7181 7.15429 15.0707 7.1543 15.4316C7.15436 15.9157 7.34261 16.3804 7.67871 16.7227C8.01481 17.0649 8.471 17.2568 8.94629 17.2568C9.30081 17.2569 9.64759 17.1498 9.94238 16.9492C10.2371 16.7487 10.4669 16.4633 10.6025 16.1299C10.7381 15.7964 10.7732 15.4292 10.7041 15.0752C10.6349 14.7213 10.4645 14.3958 10.2139 14.1406C9.96319 13.8854 9.64355 13.712 9.2959 13.6416ZM19.0518 13.6064C18.0618 13.6064 17.2588 14.4235 17.2588 15.4316C17.2588 16.4397 18.0618 17.2568 19.0518 17.2568C20.0416 17.2567 20.8437 16.4396 20.8438 15.4316C20.8438 14.4236 20.0416 13.6066 19.0518 13.6064ZM13.999 9.46094C15.3021 9.45929 16.5926 9.72174 17.7949 10.2334C15.6371 11.0742 14.0012 13.0404 14.001 15.3311C14.0008 13.0401 12.3641 11.074 10.2061 10.2334C11.4075 9.72212 12.6969 9.45954 13.999 9.46094Z" fill="#A48456"/>
                    </svg>
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Main Footer Content -->
            <div class="footer-main-content">
                
                <!-- Navigation Menus -->
                <div class="footer-navigation-columns">
                    
                    <!-- Stay Column -->
                    <div class="footer-nav-column">
                        <h3 class="footer-nav-title">Stay</h3>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer_stay',
                            'menu_class' => 'footer-nav-menu',
                            'container' => false,
                            'fallback_cb' => function() {
                                echo '<ul class="footer-nav-menu">
                                    <li><a href="#">The Westin Nirup Island Resort & Spa</a></li>
                                    <li><a href="#">Riahi Residences</a></li>
                                </ul>';
                            }
                        ));
                        ?>
                    </div>
                    
                    <!-- Experiences Column -->
                    <div class="footer-nav-column">
                        <h3 class="footer-nav-title">Experiences</h3>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer_experiences',
                            'menu_class' => 'footer-nav-menu',
                            'container' => false,
                            'fallback_cb' => function() {
                                echo '<ul class="footer-nav-menu">
                                    <li><a href="#">Kids Club</a></li>
                                    <li><a href="#">Excursions</a></li>
                                    <li><a href="#">WestinWORKOUT® Fitness Studio</a></li>
                                    <li><a href="#">Heavenly Spa by Westin™</a></li>
                                    <li><a href="#">Sea Sports Centre</a></li>
                                    <li><a href="#">Beaches & Pools</a></li>
                                    <li><a href="#">Marina</a></li>
                                    <li><a href="#">Private Events</a></li>
                                </ul>';
                            }
                        ));
                        ?>
                    </div>
                    
                    <!-- Dining Column -->
                    <div class="footer-nav-column">
                        <h3 class="footer-nav-title">Dining</h3>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer_dining',
                            'menu_class' => 'footer-nav-menu',
                            'container' => false,
                            'fallback_cb' => function() {
                                echo '<ul class="footer-nav-menu">
                                    <li><a href="#">Overview</a></li>
                                    <li><a href="#">Island Kitchen</a></li>
                                    <li><a href="#">Salt Simply Seafood</a></li>
                                    <li><a href="#">Constellate (Rooftop)</a></li>
                                    <li><a href="#">Nirup Social</a></li>
                                    <li><a href="#">TriPoint Clubhouse</a></li>
                                    <li><a href="#">In-Room Dining</a></li>
                                </ul>';
                            }
                        ));
                        ?>
                    </div>
                    
                    <!-- Information Column -->
                    <div class="footer-nav-column">
                        <h3 class="footer-nav-title">Information</h3>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer_information',
                            'menu_class' => 'footer-nav-menu',
                            'container' => false,
                            'fallback_cb' => function() {
                                echo '<ul class="footer-nav-menu">
                                    <li><a href="#">Events & Offers</a></li>
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Getting Here</a></li>
                                    <li><a href="#">Sustainability</a></li>
                                    <li><a href="#">Contact</a></li>
                                    <li><a href="#">Press Kit</a></li>
                                    <li><a href="#">Media Coverage</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Terms & Conditions</a></li>
                                    <li><a href="#">Cookie Policy</a></li>
                                </ul>';
                            }
                        ));
                        ?>
                    </div>
                </div>
                
                <!-- Newsletter and Contact Section -->
                <div class="footer-sidebar-content">
                    
                    <!-- Newsletter Section -->
                    <div class="footer-newsletter-section">
                        <h3 class="footer-section-title">Stay Connected</h3>
                        <p class="footer-newsletter-description">Subscribe to our newsletter for the latest updates, offers, and exclusive releases</p>

                        <form class="footer-newsletter-form" id="footer-newsletter-form">
                            <div class="newsletter-input-group">
                                <input 
                                    type="email" 
                                    name="newsletter_email" 
                                    placeholder="E-mail address" 
                                    class="newsletter-email-input"
                                    required
                                >
                                <button type="submit" class="newsletter-submit-btn">
                                    Subscribe
                                </button>
                            </div>
                        </form>
                        <small class="recaptcha-note-nirup">
                        This site is protected by reCAPTCHA and the Google
                        <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Privacy Policy</a> and
                        <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Terms of Service</a> apply.
                        </small>
                    </div>
                    
                    
                    <!-- Contact Information -->
                    <div class="footer-contact-section">
                        <div class="footer-contact-item">
                            <div class="footer-contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 3.44699C0 3.02075 0.169323 2.61196 0.470721 2.31057C0.772119 2.00917 1.1809 1.83984 1.60714 1.83984H13.3929C13.8191 1.83984 14.2279 2.00917 14.5293 2.31057C14.8307 2.61196 15 3.02075 15 3.44699V3.81342L7.91036 8.54056C7.7866 8.61504 7.64442 8.65327 7.5 8.65092C7.35558 8.65327 7.2134 8.61504 7.08964 8.54056L0 3.81342V3.44699ZM0 5.4227V12.5541C0 12.9804 0.169323 13.3892 0.470721 13.6906C0.772119 13.992 1.1809 14.1613 1.60714 14.1613H13.3929C13.8191 14.1613 14.2279 13.992 14.5293 13.6906C14.8307 13.3892 15 12.9804 15 12.5541V5.4227L8.64964 9.65699L8.64429 9.66127C8.30243 9.87868 7.90512 9.99288 7.5 9.9902C7.09821 9.9902 6.69321 9.88092 6.35571 9.66127L6.35036 9.65699L0 5.4227Z" fill="#A48456"/>
                                </svg>
                            </div>
                            <div class="footer-contact-text">
                                <a href="mailto:<?php echo esc_attr(get_theme_mod('nirup_contact_email', 'info@nirupisland.com')); ?>">
                                    <?php echo esc_html(get_theme_mod('nirup_contact_email', 'info@nirupisland.com')); ?>
                                </a>
                            </div>
                        </div>
                        
                        <div class="footer-contact-item">
                            <div class="footer-contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <g clip-path="url(#clip0_490_1132)">
                                    <path d="M6.16962 14.1853C5.48343 14.6285 4.66551 14.8218 3.85352 14.7326C3.04154 14.6434 2.28506 14.2772 1.71141 13.6957L1.20998 13.205C0.990228 12.9802 0.867188 12.6783 0.867188 12.3639C0.867187 12.0495 0.990228 11.7477 1.20998 11.5228L3.33784 9.41642C3.56084 9.19734 3.86094 9.07459 4.17355 9.07459C4.48616 9.07459 4.78627 9.19734 5.00927 9.41642C5.23412 9.63649 5.53624 9.75973 5.85087 9.75973C6.16551 9.75973 6.46762 9.63649 6.69248 9.41642L10.0353 6.07356C10.1469 5.96361 10.2354 5.83259 10.2959 5.68811C10.3563 5.54362 10.3875 5.38857 10.3875 5.23195C10.3875 5.07533 10.3563 4.92028 10.2959 4.7758C10.2354 4.63132 10.1469 4.50029 10.0353 4.39034C9.81626 4.16735 9.69351 3.86724 9.69351 3.55463C9.69351 3.24202 9.81626 2.94191 10.0353 2.71892L12.1546 0.59963C12.3794 0.379876 12.6813 0.256836 12.9957 0.256836C13.3101 0.256836 13.612 0.379876 13.8368 0.59963L14.3275 1.10106C14.9087 1.67462 15.2748 2.4308 15.3642 3.2425C15.4536 4.0542 15.2608 4.87192 14.8182 5.5582C12.5112 8.95858 9.57572 11.8868 6.16962 14.1853Z" fill="#A48456"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_490_1132">
                                    <rect width="15" height="15" fill="white"/>
                                    </clipPath>
                                </defs>
                                </svg>
                            </div>
                            <div class="footer-contact-text">
                                <div>
                                    <a href="https://wa.me/<?php echo esc_attr(str_replace([' ', '+'], '', get_theme_mod('nirup_contact_phone_primary', '+62 811 6220 999'))); ?>" target="_blank" rel="noopener noreferrer">
                                        <?php echo esc_html(get_theme_mod('nirup_contact_phone_primary', '+62 811 6220 999')); ?>
                                    </a>
                                </div>
                                <div>
                                    <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('nirup_contact_phone_direct', '+62 778 210 8899'))); ?>">
                                        <?php echo esc_html(get_theme_mod('nirup_contact_phone_direct', '+62 778 210 8899')); ?> (Hotel direct)
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="footer-contact-item">
                            <div class="footer-contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path d="M7.74107 0C4.52679 0 1.875 2.625 1.875 5.86607C1.875 10.9018 6.83036 14.3839 7.74107 15C8.65179 14.4107 13.6071 10.9018 13.6071 5.86607C13.6071 2.625 10.9554 0 7.74107 0ZM7.74107 9.08036C5.97321 9.08036 4.5 7.63393 4.5 5.83929C4.5 4.04464 5.97321 2.625 7.74107 2.625C9.50893 2.625 10.9821 4.07143 10.9821 5.86607C10.9821 7.66071 9.50893 9.08036 7.74107 9.08036Z" fill="#A48456"/>
                                </svg>
                            </div>
                            <div class="footer-contact-text">
                                <?php echo wp_kses_post(get_theme_mod('nirup_contact_address', 'Nirup Island, Sekanak Raya, Belakang Padang, Batam, Riau Islands, Indonesia, 29416')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom-design">
         <p>Designed and developed by <a href='https://lumiosdigital.com/' target="_blank" rel="noopener noreferrer" >Lumios Digital</a></p>
    </div>
</footer>

</div>
<?php get_template_part('template-parts/booking-modal'); ?>
<?php wp_footer(); ?>
</body>
</html>