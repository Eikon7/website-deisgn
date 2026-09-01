# Suluh Centre — WordPress theme

Custom WordPress theme implementing the Home page design (Concept 2,
"Carried Light") plus the core CMS content model from the Website Master
Brief and PRD. No page builder — hand-coded PHP templates on top of the
same HTML/CSS/JS design system used in the static concept.

## What's here

- **Content model** (`inc/content-types.php`): 5 document types —
  Programme, Publication, Story, Person — plus `pillar`, `strand`,
  `story_type`, `publication_type` taxonomies. `/grounded` and `/events`
  are filtered views of the single Story stream, not separate post types
  (Master Brief §9, Rule 6).
- **ACF field groups** (`inc/acf-fields.php`): field-level schemas for
  each content type, registered in PHP so they're version-controlled.
- **Templates**: `front-page.php` (Home), `single-programme.php` (the
  ten-section programme template), `archive-story.php` / `single-story.php`,
  `archive-publication.php` / `single-publication.php`, `taxonomy-pillar.php`,
  `page.php`, plus `page-templates/` for `/work` (pillar overview),
  `/grounded`, and `/events`.

## Known limitations to resolve before real content entry

1. **ACF PRO is required for the real content model.** This was built and
   tested against ACF **Free** (no license available in the dev sandbox
   this was built in), which doesn't include Repeater, Gallery, or
   Flexible Content fields. Those are needed for the Programme template's
   key facts, partners, voices, and photo set, which are naturally
   variable-length lists. `inc/acf-fields.php` detects Pro via
   `acf_is_pro()` and automatically upgrades from the Free fallback (a
   fixed number of Group fields) to real Repeaters once Pro is installed
   and activated — no code changes needed, just install the plugin.

2. **Bilingual (EN/BM) plugin needs a proper setup pass.** Polylang was
   installed and languages (English, Bahasa Malaysia) were added, but its
   "Directory name" URL mode (`/en/...`, `/ms/...`) conflicted with this
   theme's `/work/{pillar}` URL structure in testing and was left
   **deactivated** rather than shipped half-working. Before content entry
   begins bilingually, either: reconcile Polylang's URL mode with the
   routes below, or evaluate WPML (Wartek's non-binding preference in the
   Master Brief §13) which has more mature out-of-the-box handling for
   this exact scenario. Either way, every ACF field group above is ready
   to be duplicated per-language once a plugin is properly wired in.

3. **URL structure deviates from the Master Brief's sitemap in one place.**
   The brief's sitemap (§7) shows programme pages flat under
   `/work/{programme-slug}`, at the same depth as the three pillar pages
   (`/work/community`, etc.). WordPress can't cleanly resolve two
   different content types (a taxonomy archive and a CPT single) on the
   identical rewrite pattern — attempting it produced an intermittent
   wrong-template bug where the correct post was queried but the wrong
   template rendered. Programme URLs are `/work/programme/{slug}` instead.
   Confirm this with Wartek — it's a URL-structure call the brief
   delegates to Eikon7 (§5) but worth a sign-off since it's a visible
   deviation from the documented sitemap.

## Local dev environment this was built against

MariaDB + PHP's built-in server (`php -S`), WP-CLI for setup. WordPress
core and plugins (ACF, Polylang) are **not** included here — only this
theme, which is the actual deliverable. To stand it up elsewhere:

```
wp core download
wp config create --dbname=... --dbuser=... --dbpass=...
wp core install --url=... --title="Suluh Centre" --admin_user=... --admin_email=...
wp plugin install advanced-custom-fields --activate
# Copy this theme/ into wp-content/themes/, then:
wp theme activate suluh-centre
wp rewrite structure '/%postname%/' && wp rewrite flush
```

## Sample content

None is included here (this is the theme only). The dev environment this
was built in was seeded with a handful of demo posts across each content
type to prove every template renders — see the commit history / session
notes for what was created.
