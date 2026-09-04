<?php
/**
 * Home template — Concept 2 ("Carried Light"), ported from the static
 * design sample. The "Latest" section below is the one part of Home wired
 * to real content (the story CPT) to prove the CMS loop end-to-end; the
 * rest of Home carries fixed brand/strategy copy per the Master Brief's
 * ownership split (§5) rather than being freely editable per-visit content.
 */
get_header();
?>

  <!-- ============ HERO ============ -->
  <section class="hero2" id="c2Hero">
    <div class="flame-bleed" aria-hidden="true">
      <svg viewBox="0 0 64 100"><path d="M32 2C44 20 60 34 60 52C60 72 46 88 32 98C18 88 4 72 4 52C4 34 20 20 32 2Z" fill="#FBE4E5"/></svg>
    </div>
    <div class="wrap hero2-in">
      <span class="eyebrow">A brighter future is built together</span>
      <h1 id="c2Headline">
        <span class="word c-forest"><span>Putting</span></span> <span class="word c-forest"><span>light</span></span><br>
        <span class="word c-coral"><span>in</span></span> <span class="word c-coral"><span>people's</span></span> <span class="word c-coral"><span>hands</span></span>
      </h1>
      <p class="standfirst">We build communities with purpose, through the people who lead today, the young people who will lead next, and the ideas that light the way.</p>
      <div class="cta"><a class="btn2" href="<?php echo esc_url( home_url( '/work' ) ); ?>">Explore our work <svg><use href="#c2-ico-arrow"/></svg></a></div>
    </div>
    <div class="scroll-cue" aria-hidden="true"><span class="ln"></span> Suluh Centre</div>
  </section>

  <!-- ============ MARQUEE ============ -->
  <div class="marquee-band" aria-hidden="true">
    <div class="marquee-track" id="c2Marquee">
      <?php for ( $i = 0; $i < 2; $i++ ) : ?>
      <span<?php echo $i ? ' aria-hidden="true"' : ''; ?>><svg><use href="#c2-ico-flame-sm"/></svg> Community</span>
      <span<?php echo $i ? ' aria-hidden="true"' : ''; ?>><svg><use href="#c2-ico-flame-sm"/></svg> Youth &amp; Education</span>
      <span<?php echo $i ? ' aria-hidden="true"' : ''; ?>><svg><use href="#c2-ico-flame-sm"/></svg> Ideas, Ethics &amp; Society</span>
      <span<?php echo $i ? ' aria-hidden="true"' : ''; ?>><svg><use href="#c2-ico-flame-sm"/></svg> Research &amp; Advocacy</span>
      <?php endfor; ?>
    </div>
  </div>

  <!-- ============ PILLARS — asymmetric bento ============ -->
  <section class="pillars2 wrap" id="work">
    <div class="pillars2-head reveal2">
      <span class="eyebrow">Our work</span>
      <h2>Three sources of light, one method running through them</h2>
    </div>
    <div class="bento">
      <a class="bento-cell lg reveal2" href="<?php echo esc_url( suluh_term_link( 'community', 'pillar' ) ); ?>">
        <svg class="bento-flame" viewBox="0 0 64 100" aria-hidden="true"><path d="M32 2C44 20 60 34 60 52C60 72 46 88 32 98C18 88 4 72 4 52C4 34 20 20 32 2Z" fill="#EC6B6E"/></svg>
        <span class="num">01</span>
        <h3>Community</h3>
        <p>The present. Women lead here. Strengthening communities through collaboration and shared purpose.</p>
        <span class="go">Explore <svg><use href="#c2-ico-arrow"/></svg></span>
      </a>
      <a class="bento-cell a reveal2" href="<?php echo esc_url( suluh_term_link( 'youth-education', 'pillar' ) ); ?>">
        <span class="num">02</span>
        <h3>Youth &amp; Education</h3>
        <p>Empowering young people with knowledge, skills and confidence.</p>
        <span class="go">Explore <svg><use href="#c2-ico-arrow"/></svg></span>
      </a>
      <a class="bento-cell b reveal2" href="<?php echo esc_url( suluh_term_link( 'ideas-ethics-society', 'pillar' ) ); ?>">
        <span class="num">03</span>
        <h3>Ideas</h3>
        <p>Championing ideas that inform, inspire and create impact.</p>
        <span class="go">Explore <svg><use href="#c2-ico-arrow"/></svg></span>
      </a>
    </div>
    <div class="bento" style="margin-top:20px">
      <a class="bento-cell c reveal2" href="<?php echo esc_url( home_url( '/research' ) ); ?>" style="grid-column:1/-1">
        <span class="num">04</span>
        <h3>Research &amp; Advocacy</h3>
        <p>The spine, not a fourth pillar. Turning evidence into policy, and policy into change on the ground.</p>
        <span class="go">Browse research <svg><use href="#c2-ico-arrow"/></svg></span>
      </a>
    </div>
  </section>

  <!-- ============ THE IDEA — flame draws itself in ============ -->
  <section class="idea2" id="idea">
    <div class="wrap idea2-in">
      <div>
        <span class="eyebrow">The idea</span>
        <h2>Most institutions try to shine a light from above.</h2>
        <p>Suluh means the torch you carry to light the way. That is not decoration, it is the argument. We begin where change actually grows: in communities, in young people, and in the values we build on. When people carry their own light, it lasts.</p>
      </div>
      <div class="idea2-mark">
        <svg viewBox="0 0 64 100" fill="none">
          <path d="M32 2C44 20 60 34 60 52C60 72 46 88 32 98C18 88 4 72 4 52C4 34 20 20 32 2Z" stroke="var(--coral)" stroke-width="2.4"/>
          <path d="M22 32C22 23 46 23 46 36C46 47 22 49 22 61C22 73 46 73 46 65" stroke="var(--blush)" stroke-width="2.4" fill="none" stroke-linecap="round"/>
        </svg>
      </div>
    </div>
  </section>

  <!-- ============ CONTINUITY TIMELINE ============ -->
  <section class="timeline2 wrap" id="continuity">
    <div class="timeline2-head reveal2">
      <span class="eyebrow">Continuity</span>
      <h2>From Polity to Suluh</h2>
      <p>Polity always believed in change from the ground up. Suluh is that belief carried all the way through. Nothing was dropped.</p>
    </div>
    <div class="tl-track reveal2">
      <div class="tl-line"><i></i></div>
      <div class="tl-point">
        <span class="tl-dot"></span>
        <div class="tl-year">2024</div>
        <h4>Polity is founded</h4>
        <p>An independent Malaysian centre, built from the ground up on community leadership, research and evidence-led advocacy.</p>
      </div>
      <div class="tl-point">
        <span class="tl-dot"></span>
        <div class="tl-year">2026</div>
        <h4>Suluh Centre carries it forward</h4>
        <p>The same team, the same grassroots strength, a sharper reason for being. The name is new. The work is not.</p>
      </div>
    </div>
  </section>

  <!-- ============ IMPACT — editorial number spread ============ -->
  <section class="impact2" id="impact">
    <div class="wrap">
      <div class="impact2-head reveal2">
        <div><span class="eyebrow">Impact</span><h2>Groundwork, already laid</h2></div>
        <a class="see-all" href="<?php echo esc_url( home_url( '/research' ) ); ?>">See the evidence <svg width="15" height="15"><use href="#c2-ico-arrow"/></svg></a>
      </div>
      <div class="num-spread reveal2">
        <div class="num-item"><div class="n" data-count="300" data-suffix="+">0</div><div class="l">Women community champions trained</div></div>
        <div class="num-item"><div class="n" data-count="8">0</div><div class="l">States reached</div></div>
        <div class="num-item"><div class="n" data-count="13">0</div><div class="l">Collaborators</div></div>
        <div class="num-item"><div class="n" data-count="6">0</div><div class="l">Policy briefs</div></div>
        <div class="num-item"><div class="n" data-count="2">0</div><div class="l">International conferences</div></div>
        <div class="num-item"><div class="n" data-count="1">0</div><div class="l">Regional network launched</div></div>
      </div>
      <p class="impact2-note reveal2">Suluh Centre grows from the work of Polity, an independent centre established in 2024. <b>The name is new. The work is not.</b></p>
      <p class="impact2-src">Source: Polity 2026 annual report, p.7. Each figure links to the work behind it.</p>
    </div>
  </section>

  <!-- ============ HOW WE WORK — numbered editorial list ============ -->
  <section class="principles2 wrap">
    <div class="principles2-head reveal2">
      <span class="eyebrow">How we work</span>
      <h2>What sets us apart</h2>
    </div>
    <div>
      <div class="p-row reveal2"><div class="idx">01</div><div><h4>We work on the ground</h4><p>Ideas become real programmes in real communities, not reports on a shelf.</p></div></div>
      <div class="p-row reveal2"><div class="idx">02</div><div><h4>We bridge divides</h4><p>Communities, civil society and institutions in the same room.</p></div></div>
      <div class="p-row reveal2"><div class="idx">03</div><div><h4>We back youth and women</h4><p>Central to how we work, not an afterthought.</p></div></div>
      <div class="p-row reveal2"><div class="idx">04</div><div><h4>Rooted in Malaysia</h4><p>Locally grounded, globally aware.</p></div></div>
    </div>
  </section>

  <!-- ============ STORIES — featured + list, live from the CMS ============ -->
  <?php
  $suluh_home_stories = suluh_get_stories( null, 4 );
  ?>
  <section class="stories2 wrap" id="stories">
    <div class="stories2-head reveal2">
      <div><span class="eyebrow">From the ground</span><h2>Latest</h2></div>
      <a class="see-all" href="<?php echo esc_url( home_url( '/stories' ) ); ?>">All stories <svg width="15" height="15"><use href="#c2-ico-arrow"/></svg></a>
    </div>
    <?php if ( $suluh_home_stories->have_posts() ) : ?>
    <div class="story-spread">
      <?php
      $suluh_home_stories->the_post();
      $featured = suluh_story_card_data( get_the_ID() );
      ?>
      <a class="feat-story reveal2" href="<?php echo esc_url( $featured['link'] ); ?>">
        <div class="thumb">
          <?php if ( $featured['image'] ) : ?>
            <img src="<?php echo esc_url( $featured['image'] ); ?>" alt="" loading="lazy">
          <?php endif; ?>
        </div>
        <div class="body">
          <?php if ( $featured['tag'] ) : ?><span class="tag"><?php echo esc_html( $featured['tag'] ); ?></span><?php endif; ?>
          <h3><?php echo esc_html( $featured['title'] ); ?></h3>
          <?php if ( $featured['dek'] ) : ?><p><?php echo esc_html( $featured['dek'] ); ?></p><?php endif; ?>
          <p class="meta"><?php echo esc_html( $featured['date'] ); ?></p>
        </div>
      </a>
      <div class="reveal2">
        <?php while ( $suluh_home_stories->have_posts() ) : $suluh_home_stories->the_post();
          $row = suluh_story_card_data( get_the_ID() );
        ?>
        <a class="list-story" href="<?php echo esc_url( $row['link'] ); ?>" style="display:flex">
          <div class="yr"><?php echo esc_html( $row['date'] ); ?></div>
          <div>
            <?php if ( $row['tag'] ) : ?><span class="tag2"><?php echo esc_html( $row['tag'] ); ?></span><?php endif; ?>
            <h4><?php echo esc_html( $row['title'] ); ?></h4>
            <?php if ( $row['dek'] ) : ?><p><?php echo esc_html( $row['dek'] ); ?></p><?php endif; ?>
          </div>
        </a>
        <?php endwhile; ?>
      </div>
    </div>
    <?php wp_reset_postdata(); ?>
    <?php else : ?>
    <p class="muted">No stories published yet. Add the first one from Stories → Add New in the dashboard.</p>
    <?php endif; ?>
  </section>

<?php get_footer(); ?>
