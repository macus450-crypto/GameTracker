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
          <a href="#" class="btn btn-primary">Browse Games</a>
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

          <h3><?php the_title(); ?></h3>
          <p><?php the_excerpt(); ?></p>
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
