<footer id="colophon" class="site-footer">
            <?php if (is_active_sidebar('footer-widgets')) : ?>
                <div class="footer-widgets">
                    <div class="container">
                        <?php dynamic_sidebar('footer-widgets'); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="footer-bottom">
                <div class="container">
                    <div class="site-info">
                        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'nirup-island'); ?></p>
                    </div>

                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-menu',
                        'container'      => 'nav',
                        'container_class'=> 'footer-navigation',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>
            </div>
        </footer>
    </div><!-- #page -->

    <?php wp_footer(); ?>
</body>
</html>