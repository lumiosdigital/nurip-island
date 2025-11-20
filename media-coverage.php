<?php
/**
 * Template Name: Media Coverage
 * 
 * @package Nirup_Island
 */

get_header(); ?>

<div class="media-coverage-page">
    <!-- Breadcrumbs -->
    <?php get_template_part('template-parts/breadcrumbs'); ?>

    <!-- Hero Section -->
    <div class="media-coverage-hero">
        <div class="media-coverage-hero-inner">
            <h1 class="media-coverage-title">
                <?php echo esc_html(get_theme_mod('nirup_media_coverage_title', 'Media Coverage')); ?>
            </h1>
            
            <?php if (get_theme_mod('nirup_media_coverage_show_subtitle', true)) : ?>
                <p class="media-coverage-subtitle">
                    <?php 
                    $subtitle = get_theme_mod('nirup_media_coverage_subtitle', 'Stay up to date with how Nirup Island is being recognized');
                    
                    if ($subtitle) echo esc_html($subtitle);
                    ?>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Publications Divider -->
    <div class="media-coverage-divider">
        <span class="divider-text">Publications</span>
        <div class="divider-line"></div>
    </div>

    <!-- Articles List -->
    <div class="media-coverage-articles">
        <?php
        // Get all published media articles
        $articles_query = new WP_Query(array(
            'post_type' => 'media_coverage',
            'posts_per_page' => 5, // Show 5 initially
            'orderby' => 'meta_value',
            'meta_key' => '_media_article_date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1
        ));

        if ($articles_query->have_posts()) :
            while ($articles_query->have_posts()) : $articles_query->the_post();
                $article_id = get_the_ID();
                $source = get_post_meta($article_id, '_media_article_source', true);
                $quote = get_post_meta($article_id, '_media_article_quote', true);
                $link = get_post_meta($article_id, '_media_article_link', true);
                ?>
                
                <div class="media-article-item">
                    <div class="article-header">
                        <h2 class="article-title"><?php echo esc_html(get_the_title()); ?></h2>
                        
                        <?php if ($source) : ?>
                            <p class="article-source"><?php echo esc_html($source); ?></p>
                        <?php endif; ?>
                        
                        <div class="article-divider"></div>
                    </div>
                    
                    <div class="article-content">
                        <?php if ($quote) : ?>
                            <blockquote class="article-quote"><?php echo esc_html($quote); ?></blockquote>
                        <?php endif; ?>
                        
                        <?php if ($link) : ?>
                            <a href="<?php echo esc_url($link); ?>" 
                               class="article-link-btn" 
                               target="_blank" 
                               rel="noopener noreferrer">
                                Read Full Article
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

            <?php
            endwhile;
            
            // Load More Button
            if ($articles_query->max_num_pages > 1) :
                ?>
                <div class="media-load-more">
                    <button type="button" class="load-more-btn" data-page="1" data-max="<?php echo $articles_query->max_num_pages; ?>">
                        <span class="load-more-text">Load More</span>
                        <svg class="load-more-icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.29289 11.7071C5.68342 12.0976 6.31658 12.0976 6.70711 11.7071L11.7071 6.70711C12.0976 6.31658 12.0976 5.68342 11.7071 5.29289C11.3166 4.90237 10.6834 4.90237 10.2929 5.29289L6 9.58579L1.70711 5.29289C1.31658 4.90237 0.683417 4.90237 0.292893 5.29289C-0.0976311 5.68342 -0.0976311 6.31658 0.292893 6.70711L5.29289 11.7071Z" fill="#8B5E1D"/>
                        </svg>
                    </button>
                </div>
                <?php
            endif;
            
            wp_reset_postdata();
        else :
            ?>
            <div class="no-articles">
                <p>No media coverage articles found. Please check back soon!</p>
            </div>
            <?php
        endif;
        ?>
    </div>
</div>

<?php get_footer(); ?>