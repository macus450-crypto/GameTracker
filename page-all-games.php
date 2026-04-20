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
      $paged = get_query_var('paged') ? (int) get_query_var('paged') : 1;

      $games_data = gametracker_get_rawg_games($paged, 12);

      if (!empty($games_data['results'])) :
        foreach ($games_data['results'] as $game) :
      ?>
        <article class="game-card">
          <div class="game-card-image">
            <?php if (!empty($game['background_image'])) : ?>
              <img src="<?php echo esc_url($game['background_image']); ?>" alt="<?php echo esc_attr($game['name']); ?>">
            <?php else : ?>
              <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder.jpg'); ?>" alt="No image">
            <?php endif; ?>
          </div>

          <h3>
            <?php echo esc_html($game['name']); ?>
          </h3>

          <div class="game-meta">
            <?php if (!empty($game['released'])) : ?>
              <p>Released: <?php echo esc_html($game['released']); ?></p>
           <?php endif; ?>

            <?php if (!empty($game['rating'])) : ?>
              <p>Rating: <?php echo esc_html($game['rating']); ?>/5</p>
            <?php endif; ?>
          </div>

          <?php if (!empty($game['genres'])) : ?>
            <p>
              Genres:
              <?php
              $genre_names = array_map(function ($genre) {
                return $genre['name'];
              }, $game['genres']);

              echo esc_html(implode(', ', $genre_names));
              ?>
            </p>
          <?php endif; ?>

          <?php if (!empty($game['slug'])) : ?>
            <a href="<?php echo esc_url('https://rawg.io/games/' . $game['slug']); ?>" class="btn btn-primary" target="_blank" rel="noopener noreferrer">
              View Details
            </a>
          <?php endif; ?>
        </article>
      <?php
        endforeach;
      ?>
          <div class="pagination">
            <?php
            $total_pages = !empty($games_data['count']) ? ceil($games_data['count'] / 12) : 1;

            echo paginate_links(array(
              'total'      => $total_pages,
              'current'    => $paged,
              'prev_text'  => '← Previous',
              'next_text'  => 'Next →'
            ));
            ?>
          </div>
          <?php
        else :
        ?>
    <p>No games found.</p>
    <?php endif; ?>
        </div>
      </div>
  </section>
</main>

<?php get_footer(); ?>