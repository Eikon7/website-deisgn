# Suluh Center — WordPress theme

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
   - **Research & Advocacy** (`archive-publication.php`) — the
     `publication` post type, filterable by type, each row gated behind a
     name + email modal before the PDF downloads.
   - **Stories** (`archive-story.php` / `single-story.php`) — the `story`
     post type, the newsroom stream with an "Upcoming" band for future
     Convenings.
   - **Grounded** (`page-templates/grounded.php`) — not a separate post
     type, a filtered view of Stories where `story_type = grounded`, per
     the original wireframe's own design note. Has its own admin sidebar
     shortcut too (see "Managing Grounded episodes" below) so finding
     existing episodes doesn't mean filtering the full Stories list by
     hand each time.

Every one of these ports the approved static pages
(`research.html` / `stories.html` / `story-detail.html` / `grounded.html`
in the repo root) verbatim: same CSS classes, same
`assets/js/concept2.js` (filter chips, the gated-download modal, reveal
animations) — just with the repeated blocks replaced by a WordPress
loop over real posts.

## Requirements

- **Elementor** (free tier) — builds/edits every non-CMS page.
- **Advanced Custom Fields** (free) — the Story and Publication field
  groups in `inc/acf-fields.php` use only free-tier field types.
- PHP 8.0+.

## What's here

- `inc/content-types.php` — registers the `story` and `publication` post
  types and their `story_type` / `publication_type` taxonomies, and seeds
  the taxonomy terms (News, Convenings, Grounded, From the field, Notes;
  Policy brief, Survey, Report, Commentary).
- `inc/acf-fields.php` — field groups for both post types: a Publication
  has Year, Document ID, Cover image, PDF file; a Story has a dek/
  standfirst, display date, an "Upcoming" flag, an optional
  Location/Partners/Scale fact box (Convenings), and an optional episode
  number + audio URL (Grounded).
- `inc/template-tags.php` — the SVG icon sprite, and small query/render
  helpers shared between the Stories archive and the Grounded page so
  the story-card markup never drifts between the two.
- `header.php` / `footer.php` / `page.php` / `index.php` — shared chrome
  plus the bare-passthrough template every Elementor page uses.
  `page.php` deliberately does nothing but call `the_content()` — no
  wrapper markup — since Elementor's own sections build their own
  full-width backgrounds and padding.
- `archive-publication.php`, `archive-story.php`, `single-story.php`,
  `page-templates/grounded.php` — the three CMS templates described
  above.
- `single-publication.php` — there's no standalone publication page in
  this design (the PDF is only ever offered from the gated modal on the
  Research archive), so this just 301-redirects back to `/research/`
  rather than rendering an ungated direct-download link.
- `inc/download-leads.php` — the private "Downloads" admin list and the
  AJAX endpoint that records a name + email before handing back the
  real PDF URL (validated server-side, not trusted from the client).
- `inc/elementor-widgets.php` + `inc/elementor-widgets/` — a custom
  "Latest Stories" Elementor widget: drop it into any Elementor page and
  it queries the real `story` post type and renders the site's actual
  featured-card + list markup, editable from the Elementor panel (how
  many to show, an optional Story Type filter, the heading/eyebrow/link
  text). Used on the homepage — see `elementor-templates/README.md` for
  the full writeup. No-ops completely if Elementor isn't active. (Its
  internal widget slug/class/filename still say "publications" — they're
  internal identifiers an existing Elementor page's JSON references by
  name, left stable across the label revert for the same reason the
  `story`/`publication` post_type keys are.)

## Child theme

`../suluh-centre-child/` is a standard WordPress child theme — an
initially-empty place for future site-specific tweaks (CSS overrides, a
copied-and-edited template, small new PHP) so they survive if this
parent theme is ever updated, instead of editing these files directly.
See its own README for how to actually use it. Activating it is
optional — the parent theme works fully on its own.

## Install

```
# Copy wordpress-theme/suluh-centre/ into wp-content/themes/, then:
wp theme activate suluh-centre
wp plugin install advanced-custom-fields --activate
wp rewrite flush

# Elementor (install separately, this theme doesn't bundle it):
wp plugin install elementor --activate

# Optional: also copy wordpress-theme/suluh-centre-child/ into
# wp-content/themes/, then activate that instead of the parent —
# see "Child theme" above.
```

Then in WP Admin:

1. **Settings → Reading**: set "Your homepage displays" to a static page,
   and create/pick a Page called "Home" — build it in Elementor.
2. Build the rest of the marketing pages (About, Contact, Work, People,
   Community, Youth & Education, Ideas/Ethics/Society, the programme
   pages) as normal Pages, each edited in Elementor. `elementor-templates/about.json`
   in the repo root is a ready-made starting point for About.
3. Create a Page called "Grounded", and under **Page Attributes → Template**
   pick "Grounded (podcast)".
4. Add Story and Publication posts (**Stories** / **Publications** in the
   admin sidebar) to populate `/research/` and `/stories/` — both archives
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
   - Stories → `/stories/`
   - Contact → `/contact/`

   Until a menu is assigned here, the header/drawer fall back to the
   exact nav shown above automatically — nothing breaks in the meantime.

## Managing Grounded episodes

Grounded episodes are just Stories tagged with the "Grounded" Story
Type — there's no separate "Add New Grounded" screen. To add one:
**Stories → Add New**, fill it in like any other Story (dek, display
date, episode number + audio/video URL under the "Podcast (Grounded)"
tab), and tick **Grounded** in the Story Types box. It appears in the
main `/stories/` stream immediately, same as any other Story.

For a quick list of just the existing episodes without filtering the
full Stories screen by hand, use the **Grounded** item in the sidebar
(added by `suluh_add_grounded_admin_menu()` in `inc/content-types.php`)
— it's a shortcut to the same Stories list table, pre-filtered to
`story_type=grounded`. It's not a separate post type or a separate
database of episodes; it's a one-click filter.

## Who downloaded what

Every Research PDF download is recorded once the visitor submits a
valid name + email: check **wp-admin → Downloads** for a sortable/
searchable list (Name, Email, Publication, Date). See
`inc/download-leads.php` for the AJAX endpoint the gated-download modal
posts to.

## Footer social links

The footer's first column now has a row of 5 social icons (Facebook,
Instagram, Threads, LinkedIn, TikTok), linking to the client's real
accounts. This is hardcoded in `footer.php` (`.footer-social`), not
menu-driven — same reasoning as the rest of the footer's four link
columns.

The icons are inline SVGs, added as new `<symbol>` entries in the shared
sprite (`suluh_svg_sprite()` in `inc/template-tags.php`), same mechanism
as the site's existing arrow/close/download icons. This is a new
addition — none of the static demo HTML pages have a social row in
their footer to port from. Facebook/Instagram/Threads/TikTok are exact
paths from Simple Icons (CC0); LinkedIn isn't in Simple Icons anymore
(removed at LinkedIn's own request), so that one is from Bootstrap
Icons (MIT) instead. Styling is in `assets/css/concept2.css`
(`.footer-social`) — small circular buttons, coral on hover, matching
the site's existing accent color.

To change a link or add another platform: edit the `<a>` tags in
`footer.php` directly, and add a matching `<symbol>` in
`suluh_svg_sprite()` if it's a new platform.

## Adding a pull quote inside a Story

The Story content editor (the normal WordPress editor for the `story`
post type) has no dedicated "quote" field — a quote inside a story's
body is just part of `the_content()`. The block editor's default Quote
block will render, but with no theme styling (plain browser default),
which won't match the site.

To get an on-brand quote, add a **Custom HTML** block (block editor) or
switch to the **Text** tab (Classic editor) at the point in the story
where the quote goes, and paste:

```html
<blockquote class="story-quote">
  “Quote text goes here.”
  <cite>Name, role</cite>
</blockquote>
```

`.story-quote` is a real CSS class in `assets/css/pages2.css` (coral
left border, serif quote text, same visual family as the site's
existing `.next-callout` border-left callouts) — nothing else needs
touching. Drop the `<cite>` line if there's no attribution to give.

## Using Contact Form 7 instead of the built-in Contact form

The Contact page's form (`elementor-templates/contact.json`) is a plain
`<form>` — client-side validation only via `concept2.js`, no backend
mailer. If you install Contact Form 7 and want that form's look with a
real mailer behind it, paste this into the CF7 form's **Form** tab in
place of the default generated markup:

```html
<div class="contact-card">
  <h4>Send a message</h4>

  <div class="contact-field">
    <label for="ccName">Name</label>
    [text* your-name id:ccName]
  </div>

  <div class="contact-field">
    <label for="ccOrg">Organisation</label>
    [text your-org id:ccOrg]
  </div>

  <div class="contact-field">
    <label for="ccEmail">Email</label>
    [email* your-email id:ccEmail]
  </div>

  <div class="contact-field">
    <label for="ccMessage">Message</label>
    [textarea* your-message id:ccMessage]
  </div>

  [submit class:btn2 "Send"]
</div>
```

The `id:` option just sets the `id` on CF7's generated input/textarea —
CF7 still adds its own `wpcf7-form-control` classes underneath, but
since each field sits inside the existing `.contact-field`/
`.contact-card` divs, the site's current CSS picks it up with no
changes. `pages2.css` has a small extra block
(`.wpcf7-not-valid-tip`, `.wpcf7-response-output`, `.wpcf7-spinner`) for
the three things CF7 adds that the hand-built form never needed:
inline validation errors, the overall success/error message, and the
loading spinner.

To actually use this on the live Contact page: replace the Custom HTML
widget holding the current `<form>` in the Contact page's Elementor
layout with CF7's own Elementor widget (or a Shortcode widget with
`[contact-form-7 id="..."]`), pointed at a form using the markup above.
That swap isn't done in `elementor-templates/contact.json` — the CSS is
ready for it, but wiring in a real plugin/shortcode is a call to make
in wp-admin, not something to bake into the template file.

## GTranslate language switcher styling

The live site added GTranslate (WordPress-menu integration mode) to the
Primary Navigation menu. Left unstyled, it renders as a parent trigger
item ("English") plus a dropdown listing every language including the
current one again — literally "English" appearing twice, which reused
the Pillars-dropdown's vertical-list CSS and read as a bug rather than
a design choice.

`concept2.css` now has rules scoped to GTranslate's own classes
(`.menu-item-gtranslate`, `.gt-current-wrapper`, `.gt-current-lang`) that
flatten this into a plain inline "English / Malay" toggle instead —
appropriate since there are only 2 languages, so a click-to-open
dropdown isn't really needed. The redundant parent trigger is hidden;
the actual language links (which carry GTranslate's own
`data-gt-lang` attribute and click handlers) stay fully functional,
just laid out horizontally with the active language bolded. Covers both
the desktop nav and the mobile drawer.

If a language is ever added or removed, no CSS changes are needed —
this targets GTranslate's own generated classes generically, not a
fixed language count.

## Known gaps

- No bilingual (EN/BM) support is wired in. If that's still needed,
  it's a separate pass (Polylang or WPML) on top of this.
