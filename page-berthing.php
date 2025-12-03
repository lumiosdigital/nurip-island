<?php
/**
 * Template Name: Berthing Form
 * Description: Arrival Notice & Berth Reservation Form
 */

get_header(); ?>

<div class="berthing-page">
    
<?php get_template_part('template-parts/breadcrumbs'); ?>

    <!-- Hero Section -->
    <section class="berthing-hero">
        <div class="container">
            <h1 class="berthing-hero-title">
                <?php echo esc_html(get_theme_mod('nirup_berthing_hero_title', 'ARRIVAL NOTICE & BERTH RESERVATION FORM')); ?>
            </h1>
            <div class="berthing-hero-description">
                <?php echo wpautop(wp_kses_post(get_theme_mod('nirup_berthing_hero_description', 
                    'Please complete the form in full and provide at least 48 hours\' notice prior to your boat\'s arrival.<br>Our team will review your submission and contact you as soon as possible.<br>For urgent inquiries, please contact the marina at +62 811‑6253‑888.'))); ?>
            </div>
        </div>
    </section>

    <!-- Form Section -->
    <section class="berthing-form-section">
        <div class="container">
            <form
                id="berthing-form"
                class="berthing-form"
                method="post"
                enctype="multipart/form-data"
            >
                
                <!-- Contact Information -->
                <div class="berthing-form-row berthing-form-row-2">
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Name of Yacht Owner *</label>
                        <input type="text" name="yacht_owner_name" class="berthing-form-input" placeholder="Name" required>
                    </div>
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Contact Name (Captain/ Owner/ Agent/ Yacht Representative) *</label>
                        <input type="text" name="contact_name" class="berthing-form-input" placeholder="Contact Name" required>
                    </div>
                </div>

                <div class="berthing-form-row berthing-form-row-2">
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Phone Number *</label>
                        <input type="tel" name="phone" class="berthing-form-input" placeholder="Phone" required>
                    </div>
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Email *</label>
                        <input type="email" name="email" class="berthing-form-input" placeholder="Email" required>
                    </div>
                </div>

                <div class="berthing-form-row berthing-form-row-1">
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Owner's Address *</label>
                        <input type="text" name="owner_address" class="berthing-form-input" placeholder="Owner's Address" required>
                    </div>
                </div>

                <!-- Vessel Particulars -->
                <h2 class="berthing-section-title">Vessel Particulars</h2>

                <div class="berthing-form-row berthing-form-row-3">
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Vessel Name *</label>
                        <input type="text" name="vessel_name" class="berthing-form-input" placeholder="Vessel Name" required>
                    </div>
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Vessel's Type *</label>
                        <input type="text" name="vessel_type" class="berthing-form-input" placeholder="Vessel's Type" required>
                    </div>
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Flag of Vessel *</label>
                        <input type="text" name="vessel_flag" class="berthing-form-input" placeholder="Country" required>
                    </div>
                </div>

                <div class="berthing-form-row berthing-form-row-3">
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Length *</label>
                        <input type="text" name="vessel_length" class="berthing-form-input" placeholder="Meter" required>
                    </div>
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Beam *</label>
                        <input type="text" name="vessel_beam" class="berthing-form-input" placeholder="Meter" required>
                    </div>
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Draft *</label>
                        <input type="text" name="vessel_draft" class="berthing-form-input" placeholder="Meter" required>
                    </div>
                </div>

                <div class="berthing-form-row berthing-form-row-3">
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Arrival Date *</label>
                        <input type="date" name="arrival_date" class="berthing-form-input" required>
                    </div>
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Arrival Time *</label>
                        <input type="time" name="arrival_time" class="berthing-form-input" placeholder="09:00 AM" required>
                    </div>
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Departure Date</label>
                        <input type="date" name="departure_date" class="berthing-form-input">
                    </div>
                </div>

                <!-- Documents Submission -->
                <h2 class="berthing-section-title">Documents Submission</h2>
                <p class="berthing-section-subtitle">Please upload all required documents</p>

                <div class="berthing-form-row berthing-form-row-3">
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Vessel Registration *</label>
                        <div class="berthing-file-upload">
                            <input
                                type="file"
                                name="vessel_registration"
                                id="vessel_registration"
                                accept=".pdf,.jpg,.jpeg,.png"
                                required
                            >
                            <label for="vessel_registration" class="file-upload-label">
                                <svg class="paperclip-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M17.5 8.75V14.375C17.5 16.375 16 18.125 13.75 18.125C11.5 18.125 10 16.375 10 14.375V7.5C10 6 11 4.375 12.5 4.375C14 4.375 15 6 15 7.5V13.125C15 13.875 14.5 14.375 14.0625 14.375C13.625 14.375 13.125 13.875 13.125 13.125V8.75" stroke="#8B5E1D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="file-label-text">Choose the file</span>
                                <span class="file-label-size">Max. file size: 5MB</span>
                            </label>
                            <div class="file-name"></div>
                        </div>
                    </div>
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Vessel Insurance *</label>
                        <div class="berthing-file-upload">
                            <input
                                type="file"
                                name="vessel_insurance"
                                id="vessel_insurance"
                                accept=".pdf,.jpg,.jpeg,.png"
                                required
                            >
                            <label for="vessel_insurance" class="file-upload-label">
                                <svg class="paperclip-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M17.5 8.75V14.375C17.5 16.375 16 18.125 13.75 18.125C11.5 18.125 10 16.375 10 14.375V7.5C10 6 11 4.375 12.5 4.375C14 4.375 15 6 15 7.5V13.125C15 13.875 14.5 14.375 14.0625 14.375C13.625 14.375 13.125 13.875 13.125 13.125V8.75" stroke="#8B5E1D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="file-label-text">Choose the file</span>
                                <span class="file-label-size">Max. file size: 5 MB.</span>
                            </label>
                            <div class="file-name"></div>
                        </div>
                    </div>
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Vessel MMSI Certificate *</label>
                        <div class="berthing-file-upload">
                            <input
                                type="file"
                                name="vessel_mmsi"
                                id="vessel_mmsi"
                                accept=".pdf,.jpg,.jpeg,.png"
                                required
                            >
                            <label for="vessel_mmsi" class="file-upload-label">
                                <svg class="paperclip-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M17.5 8.75V14.375C17.5 16.375 16 18.125 13.75 18.125C11.5 18.125 10 16.375 10 14.375V7.5C10 6 11 4.375 12.5 4.375C14 4.375 15 6 15 7.5V13.125C15 13.875 14.5 14.375 14.0625 14.375C13.625 14.375 13.125 13.875 13.125 13.125V8.75" stroke="#8B5E1D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="file-label-text">Choose the file</span>
                                <span class="file-label-size">Max. file size: 5 MB.</span>
                            </label>
                            <div class="file-name"></div>
                        </div>
                    </div>
                </div>

                <div class="berthing-form-row berthing-form-row-3">
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Crew List *</label>
                        <div class="berthing-file-upload">
                            <input 
                                type="file" 
                                name="crew_list" 
                                id="crew_list" 
                                accept=".pdf,.jpg,.jpeg,.png" 
                                required
                            >
                            <label for="crew_list" class="file-upload-label">
                                <svg class="paperclip-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M17.5 8.75V14.375C17.5 16.375 16 18.125 13.75 18.125C11.5 18.125 10 16.375 10 14.375V7.5C10 6 11 4.375 12.5 4.375C14 4.375 15 6 15 7.5V13.125C15 13.875 14.5 14.375 14.0625 14.375C13.625 14.375 13.125 13.875 13.125 13.125V8.75" stroke="#8B5E1D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="file-label-text">Choose the file</span>
                                <span class="file-label-size">Max. file size: 5MB</span>
                            </label>
                            <div class="file-name"></div>
                        </div>
                    </div>
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Passenger List *</label>
                        <div class="berthing-file-upload">
                            <input
                                type="file"
                                name="passenger_list"
                                id="passenger_list"
                                accept=".pdf,.jpg,.jpeg,.png"
                                required
                            >
                            <label for="passenger_list" class="file-upload-label">
                                <svg class="paperclip-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M17.5 8.75V14.375C17.5 16.375 16 18.125 13.75 18.125C11.5 18.125 10 16.375 10 14.375V7.5C10 6 11 4.375 12.5 4.375C14 4.375 15 6 15 7.5V13.125C15 13.875 14.5 14.375 14.0625 14.375C13.625 14.375 13.125 13.875 13.125 13.125V8.75" stroke="#8B5E1D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="file-label-text">Choose the file</span>
                                <span class="file-label-size">Max. file size: 5 MB.</span>
                            </label>
                            <div class="file-name"></div>
                        </div>
                    </div>
                    <div class="berthing-form-field">
                        <label class="berthing-form-label">Last Port Clearance *</label>
                        <div class="berthing-file-upload">
                            <input
                                type="file"
                                name="port_clearance"
                                id="port_clearance"
                                accept=".pdf,.jpg,.jpeg,.png"
                                required
                            >
                            <label for="port_clearance" class="file-upload-label">
                                <svg class="paperclip-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M17.5 8.75V14.375C17.5 16.375 16 18.125 13.75 18.125C11.5 18.125 10 16.375 10 14.375V7.5C10 6 11 4.375 12.5 4.375C14 4.375 15 6 15 7.5V13.125C15 13.875 14.5 14.375 14.0625 14.375C13.625 14.375 13.125 13.875 13.125 13.125V8.75" stroke="#8B5E1D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="file-label-text">Choose the file</span>
                                <span class="file-label-size">Max. file size: 64 MB.</span>
                            </label>
                            <div class="file-name"></div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="berthing-form-submit-wrapper">
                    <button type="submit" class="berthing-submit-btn">
                        <span class="submit-text">Submit Reservation</span>
                        <span class="submit-loading" style="display: none;">Sending<span class="dots"></span></span>
                    </button>
                </div>

                <!-- Form Message -->
                <div class="form-message" id="berthing-form-message"></div>
            </form>
        </div>
    </section>

</div>

<!-- Thank You Modal -->
<div id="berthing-thank-you-modal" class="berthing-thank-you-modal">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <div class="modal-icon">
            <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="30" cy="30" r="28" stroke="#A48456" stroke-width="4"/>
                <path d="M18 30L26 38L42 22" stroke="#A48456" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h3 class="modal-title">Thank You!</h3>
        <p class="modal-message">Your berthing request has been submitted successfully. Our marina team will review your submission and contact you shortly.</p>
    </div>
</div>

<?php get_footer(); ?>