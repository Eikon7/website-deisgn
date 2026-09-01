<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php suluh_svg_sprite(); ?>

<header class="c2-header" id="c2Header">
  <div class="wrap c2-hd">
    <a class="c2-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>">
    </a>
    <?php
    if ( has_nav_menu( 'primary' ) ) {
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'c2-nav',
            'depth'          => 1,
        ) );
    } else {
        ?>
        <nav class="c2-nav" aria-label="Primary">
          <a href="<?php echo esc_url( home_url( '/work' ) ); ?>">Our Work</a>
          <a href="#idea">The Idea</a>
          <a href="<?php echo esc_url( home_url( '/research' ) ); ?>">Research</a>
          <a href="<?php echo esc_url( home_url( '/stories' ) ); ?>">Stories</a>
          <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a>
        </nav>
        <?php
    }
    ?>
    <button class="c2-hd-cta" id="c2SubscribeBtn" type="button">Subscribe</button>
    <button class="c2-burger" id="c2Burger" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

<div class="c2-drawer" id="c2Drawer">
  <button class="c2-drawer-close" id="c2DrawerClose" aria-label="Close menu"><svg width="20" height="20"><use href="#c2-ico-close"/></svg></button>
  <a href="<?php echo esc_url( home_url( '/work' ) ); ?>">Our Work</a>
  <a href="<?php echo esc_url( home_url( '/research' ) ); ?>">Research</a>
  <a href="<?php echo esc_url( home_url( '/stories' ) ); ?>">Stories</a>
  <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a>
</div>

<main id="top">
