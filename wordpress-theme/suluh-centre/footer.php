</main>

<div class="subscribe-band">
  <svg class="flame-wm" width="290" height="450" viewBox="0 0 64 100" style="left:-90px;top:-90px" aria-hidden="true"><path d="M32 2C44 20 60 34 60 52C60 72 46 88 32 98C18 88 4 72 4 52C4 34 20 20 32 2Z" fill="#EC6B6E"/></svg>
  <div class="wrap closing2-in">
    <h2>Light, carried from the ground up. Follow the work as it happens.</h2>
    <form class="c2-form" id="c2Form" novalidate>
      <label for="c2Email">Email address</label>
      <input type="email" id="c2Email" placeholder="you@example.com" required>
      <button class="btn2" type="submit">Subscribe <svg><use href="#c2-ico-arrow"/></svg></button>
    </form>
    <p class="c2-status" id="c2Status" role="status" aria-live="polite"></p>
  </div>
</div>

<footer class="c2-footer">
  <div class="wrap c2-fgrid">
    <div class="foot-brand">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.png' ); ?>" alt="" style="width:130px" aria-hidden="true">
      <p style="font-family:var(--sans);font-size:.85rem;margin-top:16px;line-height:1.6">30-1, Jalan Medan Setia 2<br>Bukit Damansara, 50490<br>Kuala Lumpur, Malaysia</p>
    </div>
    <div>
      <h5>Work</h5>
      <?php if ( has_nav_menu( 'footer_work' ) ) : wp_nav_menu( array( 'theme_location' => 'footer_work', 'container' => 'ul', 'menu_class' => '', 'depth' => 1 ) ); else : ?>
      <ul>
        <li><a href="<?php echo esc_url( home_url( '/work' ) ); ?>">Community</a></li>
        <li><a href="<?php echo esc_url( home_url( '/work' ) ); ?>">Youth &amp; Education</a></li>
        <li><a href="<?php echo esc_url( home_url( '/work' ) ); ?>">Ideas, Ethics &amp; Society</a></li>
      </ul>
      <?php endif; ?>
    </div>
    <div>
      <h5>Read</h5>
      <?php if ( has_nav_menu( 'footer_read' ) ) : wp_nav_menu( array( 'theme_location' => 'footer_read', 'container' => 'ul', 'menu_class' => '', 'depth' => 1 ) ); else : ?>
      <ul>
        <li><a href="<?php echo esc_url( home_url( '/research' ) ); ?>">Research</a></li>
        <li><a href="<?php echo esc_url( home_url( '/stories' ) ); ?>">Stories</a></li>
        <li><a href="<?php echo esc_url( home_url( '/grounded' ) ); ?>">Grounded</a></li>
        <li><a href="<?php echo esc_url( home_url( '/events' ) ); ?>">Convenings</a></li>
      </ul>
      <?php endif; ?>
    </div>
    <div>
      <h5>Organisation</h5>
      <?php if ( has_nav_menu( 'footer_org' ) ) : wp_nav_menu( array( 'theme_location' => 'footer_org', 'container' => 'ul', 'menu_class' => '', 'depth' => 1 ) ); else : ?>
      <ul>
        <li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a></li>
        <li><a href="<?php echo esc_url( home_url( '/about/people' ) ); ?>">People</a></li>
        <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a></li>
        <li><a href="<?php echo esc_url( home_url( '/privacy' ) ); ?>">Privacy</a></li>
      </ul>
      <?php endif; ?>
    </div>
  </div>
  <div class="wrap c2-fbot">
    <span>Suluh Centre &middot; Kuala Lumpur, Malaysia</span>
    <span>Independent &middot; Secular &middot; National</span>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
