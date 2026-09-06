# Suluh Center Child

A standard WordPress child theme of `suluh-centre` (see
`../suluh-centre/README.md` for what the parent theme actually does).
This folder is intentionally empty of real customizations — it exists so
future site-specific tweaks have somewhere safe to live, without editing
the parent theme's files directly.

## Why this exists

Every file in the parent theme could be edited directly, but then a
future update to the parent theme (a new feature, a bug fix) risks
overwriting whatever was changed. A child theme avoids that: WordPress
loads the parent theme's templates and `functions.php` first, and lets
the child theme add to or override specific pieces on top.

## How to actually customize something

- **CSS tweaks**: add rules to this folder's `style.css`, below the
  header comment. They load after the parent's `assets/css/concept2.css`
  and `pages2.css` (see `functions.php`'s enqueue order), so a plain CSS
  rule of matching specificity here overrides the parent without needing
  `!important`.
- **Override a template** (e.g. change `archive-story.php`'s markup):
  copy the file from `../suluh-centre/` into this folder, keeping the
  exact same filename, and edit the copy. WordPress uses the child
  theme's copy instead of the parent's automatically — no code needed to
  wire this up.
- **Add new PHP** (a new shortcode, an extra admin tweak, etc.): add it
  to this folder's `functions.php`. It runs in addition to the parent's
  `functions.php`, not instead of it — every post type, ACF field group,
  and admin menu the parent registers keeps working untouched.

## What NOT to duplicate here

Don't copy `inc/content-types.php`, `inc/acf-fields.php`,
`inc/download-leads.php`, or `inc/template-tags.php` into this theme —
those aren't templates WordPress overrides by filename the way
`archive-story.php` or `single-story.php` are; they're just `require`d
directly by the parent's `functions.php`; a copy here would run
alongside the parent's (both included), not replace it, and would very
likely register the same post types/taxonomies/AJAX hooks twice.

## Install

Same as the parent theme — copy this folder into `wp-content/themes/`
alongside `suluh-centre/`, then in **Appearance → Themes**, activate
**"Suluh Center Child"** (not "Suluh Center" — activate the child, and
WordPress uses the parent automatically for everything this theme
doesn't override).
