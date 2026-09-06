# Suluh Centre — WordPress theme

This theme is deliberately small. Every marketing page (Home, About,
Contact, Work, People, the three pillar pages, the programme pages) is a
plain WordPress Page built and edited visually in **Elementor** — this
theme doesn't template those at all. It exists only for the parts
Elementor can't do:

1. **The shared header and footer** (`header.php` / `footer.php`) — the
   real nav, dropdown, mobile drawer and footer link grid, so every page
   (Elementor-built or not) shares the same chrome without needing
   Elementor Pro's Theme Builder. The header nav and mobile drawer pull
   from **Appearance → Menus → Primary Navigation** — see below for how
   to set that menu up so it reproduces the Pillars dropdown/grouped
   list. The footer's four columns are still hardcoded (they don't
   change often); ask if you want those menu-driven too.
2. **The three CMS-driven surfaces**, which need real dynamic loops/
   filtering that free Elementor can't do:
   - **Research** (`archive-publication.php`) — the `publication` post
     type, at `/research/`, filterable by type, each row gated behind a
     name + email modal before the PDF downloads.
   - **Publications** (`archive-story.php` / `single-story.php`) — the
     `story` post type, at `/publications/`, the newsroom stream with an
     "Upcoming" band for future Convenings.
   - **Grounded** (`page-templates/grounded.php`) — not a separate post
     type, a filtered view of Publications where `story_type = grounded`,
     per the original wireframe's own design note. Has its own admin
     sidebar shortcut too (see "Managing Grounded episodes" below) so
     finding existing episodes doesn't mean filtering the full
     Publications list by hand each time.

   Renamed at the client's request (2026-09): the PHP post_type keys
   (`publication` and `story`) are the *reverse* of these public labels —
   `publication` is labeled "Research" and `story` is labeled
   "Publications". The keys were deliberately left alone rather than
   renamed, since that would mean migrating every existing post's
   post_type in the database; only labels, URLs and on-page text changed.
   See the note atop `inc/content-types.php` if this trips you up while
   reading the code.

Every one of these ports the approved static pages
(`research.html` / `stories.html` / `story-detail.html` / `grounded.html`
in the repo root) verbatim: same CSS classes, same
`assets/js/concept2.js` (filter chips, the gated-download modal, reveal
animations) — just with the repeated blocks replaced by a WordPress
loop over real posts. (Those static files keep their original filenames
and internal "Stories"/"Publications" wording — they're frozen design
references, not served by WordPress, so they weren't touched by the
rename.)

## Requirements

- **Elementor** (free tier) — builds/edits every non-CMS page.
- **Advanced Custom Fields** (free) — the `story`/`publication` field
  groups in `inc/acf-fields.php` use only free-tier field types.
- PHP 8.0+.

## What's here

- `inc/content-types.php` — registers the `story` and `publication` post
  types (labeled "Publications" and "Research" respectively — see the
  rename note above) and their `story_type` / `publication_type`
  taxonomies (labeled "Publication Types" and "Research Types"), and
  seeds the taxonomy terms (News, Convenings, Grounded, From the field,
  Notes; Policy brief, Survey, Report, Commentary).
- `inc/acf-fields.php` — field groups for both post types: the
  `publication` post type ("Research Details") has Year, Document ID,
  Cover image, PDF file; the `story` post type ("Publication Details")
  has a dek/standfirst, display date, an "Upcoming" flag, an optional
  Location/Partners/Scale fact box (Convenings), and an optional episode
  number + audio URL (Grounded).
- `inc/template-tags.php` — the SVG icon sprite, and small query/render
  helpers shared between the Publications archive and the Grounded page
  so the story-card markup never drifts between the two.
- `header.php` / `footer.php` / `page.php` / `index.php` — shared chrome
  plus the bare-passthrough template every Elementor page uses.
  `page.php` deliberately does nothing but call `the_content()` — no
  wrapper markup — since Elementor's own sections build their own
  full-width backgrounds and padding.
- `archive-publication.php`, `archive-story.php`, `single-story.php`,
  `page-templates/grounded.php` — the three CMS templates described
  above.
- `single-publication.php` — there's no standalone detail page for a
  `publication` post in this design (the PDF is only ever offered from
  the gated modal on the Research archive), so this just 301-redirects
  back to `/research/` rather than rendering an ungated direct-download
  link.
- `inc/download-leads.php` — the private "Downloads" admin list and the
  AJAX endpoint that records a name + email before handing back the
  real PDF URL (validated server-side, not trusted from the client).

## Install

```
# Copy wordpress-theme/suluh-centre/ into wp-content/themes/, then:
wp theme activate suluh-centre
wp plugin install advanced-custom-fields --activate
wp rewrite flush

# Elementor (install separately, this theme doesn't bundle it):
wp plugin install elementor --activate
```

If you're deploying the Publications/Research rename onto a site that
was already running the old `story` archive at `/stories/`, run
`wp rewrite flush` again after activating this update — the archive slug
changed from `stories` to `publications` and stale rewrite rules will
otherwise 404 it. A 301 redirect from old `/stories/*` links is already
wired in (`suluh_redirect_old_stories_urls()` in `functions.php`), so
existing bookmarks/backlinks won't break.

Then in WP Admin:

1. **Settings → Reading**: set "Your homepage displays" to a static page,
   and create/pick a Page called "Home" — build it in Elementor.
2. Build the rest of the marketing pages (About, Contact, Work, People,
   Community, Youth & Education, Ideas/Ethics/Society, the programme
   pages) as normal Pages, each edited in Elementor. `elementor-templates/about.json`
   in the repo root is a ready-made starting point for About.
3. Create a Page called "Grounded", and under **Page Attributes → Template**
   pick "Grounded (podcast)".
4. Add posts under **Research** and **Publications** in the admin
   sidebar to populate `/research/` and `/publications/` — both archives
   and `/grounded/` render automatically from whatever posts exist.
5. **Appearance → Menus → create a new menu**, add these items, then
   assign it to the **Primary Navigation** location:
   - Our Work → `/work/`
   - Pillars → `/work/` (a Custom Link; the URL doesn't matter much
     since it's mainly a dropdown trigger)
     - drag **Community** → `/community/`, **Youth & Education** →
       `/youth-education/`, and **Ideas, Ethics & Society** →
       `/ideas-ethics-society/` so each is indented *under* Pillars
       (this nesting is what produces the dropdown/grouped list)
   - About → `/about/`
   - Impact → `/#impact`
   - Publications → `/publications/`
   - Contact → `/contact/`

   Until a menu is assigned here, the header/drawer fall back to the
   exact nav shown above automatically — nothing breaks in the meantime.

## Managing Grounded episodes

Grounded episodes are just Publications tagged with the "Grounded"
Publication Type — there's no separate "Add New Grounded" screen. To add
one: **Publications → Add New**, fill it in like any other Publication
(dek, display date, episode number + audio URL under the "Podcast
(Grounded)" tab), and tick **Grounded** in the Publication Types box. It
appears in the main `/publications/` stream immediately, same as any
other Publication.

For a quick list of just the existing episodes without filtering the
full Publications screen by hand, use the **Grounded** item in the
sidebar (added by `suluh_add_grounded_admin_menu()` in
`inc/content-types.php`) — it's a shortcut to the same Publications list
table, pre-filtered to `story_type=grounded`. It's not a separate post
type or a separate database of episodes; it's a one-click filter.

## Who downloaded what

Every Research PDF download is recorded once the visitor submits a
valid name + email: check **wp-admin → Downloads** for a sortable/
searchable list (Name, Email, Research item, Date). See
`inc/download-leads.php` for the AJAX endpoint the gated-download modal
posts to.

## Known gaps

- No bilingual (EN/BM) support is wired in. If that's still needed,
  it's a separate pass (Polylang or WPML) on top of this.
