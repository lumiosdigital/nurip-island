<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php _e('Page Not Found', 'nirup-island'); ?></h1>
            </header>

            <div class="page-content">
                <p><?php _e('Sorry, the page you are looking for could not be found. Please try searching or return to the homepage.', 'nirup-island'); ?></p>

                <?php get_search_form(); ?>

                <div class="helpful-links">
                    <h2><?php _e('Helpful Links', 'nirup-island'); ?></h2>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Homepage', 'nirup-island'); ?></a></li>
                        <?php
                        // Show recent posts
                        $recent_posts = wp_get_recent_posts(array(
                            'numberposts' => 3,
                            'post_status' => 'publish'
                        ));
                        
                        if ($recent_posts) {
                            foreach ($recent_posts as $post) {
                                echo '<li><a href="' . get_permalink($post['ID']) . '">' . $post['post_title'] . '</a></li>';
                            }
                            wp_reset_postdata();
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>