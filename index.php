<?php
/**
 * The main template file
 * This is the fallback template for all pages
 */

get_header(); ?>

<main id="main" class="site-main">
  <div class="container">
    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>
      >
      <header class="entry-header">
        <h1 class="entry-title">
          <?php if (is_singular()) : ?>
          <?php the_title(); ?>
          <?php else : ?>
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          <?php endif; ?>
        </h1>
      </header>

      <div class="entry-content">
        <?php
                        if (is_singular()) {
                            the_content();
                        } else {
                            the_excerpt();
                        }
                        ?>
      </div>
    </article>
    <?php endwhile; ?>

    <?php
            // Pagination
            the_posts_pagination(array(
                'mid_size' =>
    2, 'prev_text' => __('Previous', 'nirup-island'), 'next_text' => __('Next', 'nirup-island'), ));
    ?>

    <?php else : ?>
    <div class="no-posts">
      <h1><?php _e('Nothing Found', 'nirup-island'); ?></h1>
      <p><?php _e('Sorry, no posts matched your criteria.', 'nirup-island'); ?></p>
      <?php get_search_form(); ?>
    </div>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>
