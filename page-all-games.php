<?php
/*
Template Name: All Games Page
*/
?>

<?php get_header(); ?>

<main class="site-main">
  <section class="all-games-page">
    <div class="container">
      <div class="section-heading">
        <h1>All Games</h1>
        <p>Browse the complete game library.</p>
      </div>

      <div class="games-grid">
        <?php
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;

        $games_query = new WP_Query(array(
          'post_type'      => 'game',
          'posts_per_page' => 12,
          'paged'          => $paged
        ));

        if ($games_query->have_posts()) :
          while ($games_query->have_posts()) : $games_query->the_post();
        ?>

          <article class="game-card">
            <div class="game-card-image">
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium'); ?>
              <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="No image">
              <?php endif; ?>
            </div>

            <h3>
              <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
              </a>
            </h3>

            <?php
              $main_story_hours = get_post_meta(get_the_ID(), '_main_story_hours', true);
              $completionist_hours = get_post_meta(get_the_ID(), '_completionist_hours', true);
            ?>

            <div class="game-meta">
              <?php if ($main_story_hours) : ?>
                <p>Main Story: <?php echo esc_html($main_story_hours); ?>h</p>
              <?php endif; ?>
              <?php if ($completionist_hours) : ?>
                <p>Completionist: <?php echo esc_html($completionist_hours); ?>h</p>
              <?php endif; ?>
            </div>

            <p><?php the_excerpt(); ?></p>

            <a href="<?php the_permalink(); ?>" class="btn btn-primary">View Details</a>
          </article>

        <?php
          endwhile;
        ?>
        <div class="pagination">
          <?php
          echo paginate_links(array(
            'total' => $games_query->max_num_pages,
            'current' => $paged,
            'prev_text' => '← Previous',
            'next_text' => 'Next →'
          ));
          ?>
        </div>
        <?php 
          wp_reset_postdata();
        else :
        ?>
          <p>No games found.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>