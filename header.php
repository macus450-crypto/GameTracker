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
    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
      <span class="logo-mark">GT</span>
      <span class="logo-text-wrap">
        <span class="logo-text">GameTracker</span>
        <span class="logo-subtitle">Track. Rate. Discover.</span>
      </span>
    </a>

    <nav class="main-nav" aria-label="Main navigation">
      <a href="<?php echo esc_url(site_url('/all-games')); ?>">Browse Games</a>
      <a href="#">My Backlog</a>
      <a href="#">Stats</a>
      <a href="#" class="nav-login">Login</a>
    </nav>
  </div>
</header>