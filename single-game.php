<?php get_header(); ?>

<main class="site-main">
  <section class="single-game-page">
    <div class="container">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <article class="single-game-card">
          <h1><?php the_title(); ?></h1>

          <?php if (has_post_thumbnail()) : ?>
            <div class="single-game-image">
              <?php the_post_thumbnail('large'); ?>
            </div>
          <?php endif; ?>

          <?php
            $main_story_hours = get_post_meta(get_the_ID(), '_main_story_hours', true);
            $completionist_hours = get_post_meta(get_the_ID(), '_completionist_hours', true);
          ?>

          <div class="single-game-meta">
            <?php if ($main_story_hours) : ?>
              <p><strong>Main Story:</strong> <?php echo esc_html($main_story_hours); ?>h</p>
            <?php endif; ?>

            <?php if ($completionist_hours) : ?>
              <p><strong>Completionist:</strong> <?php echo esc_html($completionist_hours); ?>h</p>
            <?php endif; ?>
          </div>

          <div class="single-game-content">
            <?php the_content(); ?>
          </div>
        </article>

      <?php endwhile; endif; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>