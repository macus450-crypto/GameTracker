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
        <article class="game-card">
          <div class="game-card-image"></div>
          <h3>Cyberpunk 2077</h3>
          <p>Main story: 25h</p>
        </article>

        <article class="game-card">
          <div class="game-card-image"></div>
          <h3>The Witcher 3</h3>
          <p>Main story: 50h</p>
        </article>

        <article class="game-card">
          <div class="game-card-image"></div>
          <h3>Resident Evil 4</h3>
          <p>Main story: 16h</p>
        </article>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>
