<?php get_header(); ?>

<main class="site-main">
  <section class="hero">
    <div class="container hero-inner">
      <div class="hero-content">
        <p class="hero-label">Plan your gaming time smarter</p>
        <h1>Track your backlog, estimate completion time, and choose what to play next.</h1>
        <p class="hero-text">
          GameTracker helps you organize your games, manage statuses, and understand how much time you need to finish your backlog.
        </p>

        <div class="hero-actions">
          <a href="<?php echo esc_url(site_url('/all-games')); ?>" class="btn btn-primary">Browse Games</a>
          <a href="#" class="btn btn-secondary">Create Account</a>
        </div>
      </div>
    </div>
  </section>

  <section class="search-section">
    <div class="container">
      <div class="search-box">
        <h2>Find your next game</h2>
        <p>Search by title, genre, or platform.</p>

        <form class="search-form">
          <input type="text" placeholder="Search for a game..." />
          <button type="submit">Search</button>
        </form>
      </div>
    </div>
  </section>

  <section class="popular-games">
    <div class="container">
      <div class="section-heading">
        <h2>Popular Games</h2>
        <p>Example cards for the future dynamic game catalog.</p>
      </div>

      <div class="games-grid">
        <?php
        $query = new WP_Query(array(
        'post_type' => 'game',
        'posts_per_page' => 3
        ));

        if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
        ?>

        <article class="game-card">
      <div class="game-card-image">
        <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail('medium'); ?>
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

  <?php if ($main_story_hours) : ?>
    <p>Main Story: <?php echo esc_html($main_story_hours); ?>h</p>
  <?php endif; ?>

  <?php if ($completionist_hours) : ?>
    <p>Completionist: <?php echo esc_html($completionist_hours); ?>h</p>
  <?php endif; ?>

  <p><?php the_excerpt(); ?></p>

  <a href="<?php the_permalink(); ?>" class="btn btn-primary">View Details</a>
</article>

        <?php
        endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>
