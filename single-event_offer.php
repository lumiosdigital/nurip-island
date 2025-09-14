
<?php
/**
 * Single Event/Offer Template
 * File: single-event_offer.php
 */

get_header(); ?>

<!-- Breadcrumbs -->
<?php get_template_part('template-parts/breadcrumbs'); ?>

<main class="single-event-offer-main">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="event-offer-<?php the_ID(); ?>" <?php post_class('single-event-offer'); ?>>
                
                <!-- Hero Section -->
                <div class="single-event-offer-hero">
                    <div class="single-event-offer-hero-container">
                        
                        <!-- Featured Image -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="single-event-offer-image">
                                <?php the_post_thumbnail('full', array(
                                    'class' => 'single-event-offer-featured-image',
                                    'alt' => get_the_title() . ' - ' . get_bloginfo('name')
                                )); ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Hero Content -->
                        <div class="single-event-offer-hero-content">
                            
                            <!-- Meta Information -->
                            <div class="single-event-offer-meta">
                                <?php 
                                $event_type = get_post_meta(get_the_ID(), '_event_offer_type', true);
                                $event_date = get_post_meta(get_the_ID(), '_event_offer_date', true);
                                $event_end_date = get_post_meta(get_the_ID(), '_event_offer_end_date', true);
                                ?>
                                
                                <?php if ($event_type) : ?>
                                    <span class="event-offer-type-badge <?php echo esc_attr($event_type); ?>">
                                        <?php echo esc_html(ucfirst($event_type)); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($event_date) : ?>
                                    <div class="event-offer-dates">
                                        <?php 
                                        $formatted_start = date('F j, Y', strtotime($event_date));
                                        if ($event_end_date) {
                                            $formatted_end = date('F j, Y', strtotime($event_end_date));
                                            echo $formatted_start . ' - ' . $formatted_end;
                                        } else {
                                            echo $formatted_start;
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Title -->
                            <h1 class="single-event-offer-title"><?php the_title(); ?></h1>
                            
                            <!-- Short Description -->
                            <?php 
                            $short_description = get_post_meta(get_the_ID(), '_event_offer_short_description', true);
                            if ($short_description) : ?>
                                <div class="single-event-offer-short-description">
                                    <p><?php echo esc_html($short_description); ?></p>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </div>
                
                <!-- Content Section -->
                <div class="single-event-offer-content-section">
                    <div class="single-event-offer-container">
                        
                        <!-- Main Content -->
                        <div class="single-event-offer-content">
                            <?php the_content(); ?>
                        </div>
                        
                        <!-- Additional Information -->
                        <?php 
                        // You can add more custom fields here if needed
                        $additional_info = get_post_meta(get_the_ID(), '_event_offer_additional_info', true);
                        if ($additional_info) : ?>
                            <div class="single-event-offer-additional-info">
                                <h3>Additional Information</h3>
                                <p><?php echo wp_kses_post($additional_info); ?></p>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
                
                <!-- Navigation -->
                <div class="single-event-offer-navigation">
                    <div class="single-event-offer-container">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        
                        if ($prev_post || $next_post) : ?>
                            <div class="event-offer-nav-links">
                                <?php if ($prev_post) : ?>
                                    <a href="<?php echo get_permalink($prev_post->ID); ?>" class="event-offer-nav-link prev">
                                        <span class="nav-direction">← Previous</span>
                                        <span class="nav-title"><?php echo get_the_title($prev_post->ID); ?></span>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($next_post) : ?>
                                    <a href="<?php echo get_permalink($next_post->ID); ?>" class="event-offer-nav-link next">
                                        <span class="nav-direction">Next →</span>
                                        <span class="nav-title"><?php echo get_the_title($next_post->ID); ?></span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Back to Archive -->
                        <div class="back-to-archive">
                            <a href="<?php echo get_post_type_archive_link('event_offer'); ?>" class="back-to-archive-link">
                                ← Back to All Events & Offers
                            </a>
                        </div>
                    </div>
                </div>
                
            </article>
            
        <?php endwhile; ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>