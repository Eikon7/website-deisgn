<?php
/**
 * Generic page template — every Elementor-built page (Home, About,
 * Contact, Work, People, the pillar pages, the programme pages) uses
 * this. Deliberately bare: Elementor's sections build their own
 * full-width backgrounds and padding, so this must not wrap the_content()
 * in anything that would constrain or double-pad it.
 */
get_header();
while ( have_posts() ) : the_post();
	the_content();
endwhile;
get_footer();
