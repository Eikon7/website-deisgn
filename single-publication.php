<?php
/**
 * Publications have no standalone detail page in this design — the PDF
 * is only ever offered from the gated download modal on the /research/
 * archive (archive-publication.php). A single-publication.php that
 * rendered its own page would either duplicate that flow or, worse,
 * link the PDF directly and bypass the name/email gate entirely. Redirect
 * to the archive instead.
 */
wp_safe_redirect( get_post_type_archive_link( 'publication' ), 301 );
exit;
