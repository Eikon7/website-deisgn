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

<header class="c2-header<?php echo is_front_page() ? '' : ' solid'; ?>" id="c2Header">
  <div class="wrap c2-hd">
    <a class="c2-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>">
    </a>
    <nav class="c2-nav" aria-label="Primary">
      <?php if ( has_nav_menu( 'primary' ) ) : ?>
        <?php wp_nav_menu( array(
          'theme_location' => 'primary',
          'container'      => false,
          'items_wrap'     => '%3$s',
          'depth'          => 2,
        ) ); ?>
      <?php else : ?>
        <!-- No menu assigned yet at Appearance > Menus > Primary Navigation — this
             is the same nav as before, so the site still looks right until you set one up. -->
        <a href="<?php echo esc_url( home_url( '/work/' ) ); ?>">Our Work</a>
        <div class="c2-nav-item">
          <a href="<?php echo esc_url( home_url( '/work/' ) ); ?>" aria-haspopup="true">Pillars <span class="caret" aria-hidden="true"></span></a>
          <div class="c2-dropdown">
            <a href="<?php echo esc_url( home_url( '/community/' ) ); ?>">Community</a>
            <a href="<?php echo esc_url( home_url( '/youth-education/' ) ); ?>">Youth &amp; Education</a>
            <a href="<?php echo esc_url( home_url( '/ideas-ethics-society/' ) ); ?>">Ideas, Ethics &amp; Society</a>
          </div>
        </div>
        <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a>
        <a href="<?php echo esc_url( home_url( '/#impact' ) ); ?>">Impact</a>
        <a href="<?php echo esc_url( home_url( '/stories/' ) ); ?>">Stories</a>
        <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>
      <?php endif; ?>
    </nav>
    <a class="c2-hd-cta" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">Subscribe</a>
    <button class="c2-burger" id="c2Burger" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

<div class="c2-drawer" id="c2Drawer">
  <button class="c2-drawer-close" id="c2DrawerClose" aria-label="Close menu"><svg width="20" height="20"><use href="#c2-ico-close"/></svg></button>
  <?php if ( has_nav_menu( 'primary' ) ) : ?>
    <?php wp_nav_menu( array(
      'theme_location' => 'primary',
      'container'      => false,
      'items_wrap'     => '%3$s',
      'depth'          => 2,
    ) ); ?>
  <?php else : ?>
    <a href="<?php echo esc_url( home_url( '/work/' ) ); ?>">Our Work</a>
    <div class="c2-drawer-sub">
      <span class="c2-drawer-sublabel">Pillars</span>
      <a href="<?php echo esc_url( home_url( '/community/' ) ); ?>">Community</a>
      <a href="<?php echo esc_url( home_url( '/youth-education/' ) ); ?>">Youth &amp; Education</a>
      <a href="<?php echo esc_url( home_url( '/ideas-ethics-society/' ) ); ?>">Ideas, Ethics &amp; Society</a>
    </div>
    <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a>
    <a href="<?php echo esc_url( home_url( '/#impact' ) ); ?>">Impact</a>
    <a href="<?php echo esc_url( home_url( '/stories/' ) ); ?>">Stories</a>
    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>
  <?php endif; ?>
</div>

<main<?php echo is_front_page() ? ' id="top"' : ''; ?>>
