<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo('name'); ?></title>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
  <div class="container header-inner">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">GameTracker</a>

    <nav class="main-nav">
      <a href="#">Browse Games</a>
      <a href="#">My Backlog</a>
      <a href="#">Stats</a>
      <a href="#">Login</a>
    </nav>
  </div>
</header>
