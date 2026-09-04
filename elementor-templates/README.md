# Elementor templates — Suluh Centre

This folder holds native-Elementor-widget templates, one JSON file per page,
built from the approved static pages in the repo root. `about.json` was the
first one, confirmed working by test-import. `home.json` (the homepage) is
next.

## Requirements

- **Elementor**.
- The **`suluh-centre` theme** from `wordpress-theme/` in this repo, active.
  Unlike an early draft of this doc, pages here do **not** use Elementor's
  "Canvas" template — the theme's own `header.php`/`footer.php` already
  provide the real nav (managed at **Appearance → Menus**), mobile drawer
  and footer, so every imported page just uses the theme's normal/default
  page template and gets that chrome automatically. Using Canvas would
  strip it back out.
- The site's assets uploaded somewhere reachable — see **Assets** below.

## How to import

1. In WP Admin: **Templates → Saved Templates → Import Templates**, upload
   the `.json` file.
2. Create the actual page: **Pages → Add New**, give it the matching title
   (e.g. "About"). Leave **Page Attributes → Template** on **Default**
   (not Canvas) so the theme's header/footer wrap it. For the homepage
   specifically, also set it as the site's front page under
   **Settings → Reading → Your homepage displays → A static page**.
3. Edit the page with Elementor, and insert the imported template:
   the folder icon in the panel → **My Templates** → pick it → Insert.
4. Fix the placeholders each template ships with (find them by editing
   the relevant Image/Button/HTML widget):
   - `{{BASE_URL}}` → wherever you upload the `assets/` folder (Media
     Library gives every file its own URL — easiest is uploading the
     image there directly and re-picking it in the Image widget rather
     than editing the URL by hand).
   - `{{SITE_URL}}` → your real domain, in every Button/link that points
     to another page on the site.

## about.json

Section (dark green, two columns: heading/text/text, then image) →
Section (dark green, two columns: Vision quote, Mission text + tag chips) →
Section (two cream cards side by side) → Section (section heading) →
Section (two more cards, "Our Work" / "Get in touch").

Widgets: **Heading**, **Text Editor**, **Image**, **Button**, **Spacer** —
all free-tier.

## home.json

Ports concept2.html's full sequence: Hero → pillar/programme ticker →
Pillars bento (Community / Youth & Education / Ideas, spanning full-width
Research row) → The Idea → Continuity timeline → Impact numbers → How we
work (numbered list) → Stories (featured + list) → closing subscribe band.

Same widget set as About, plus two **HTML** widgets for the two pieces
that are genuinely bespoke rather than a layout free widgets can express:

- The **pillar ticker** (originally an auto-scrolling marquee) is a
  static wrapped row of pills instead — see "What's simplified" below.
- The **closing subscribe form** is a real `<form id="c2Form">` with the
  exact same field IDs as the static build, specifically so the theme's
  already-enqueued `assets/js/concept2.js` (validates the email,
  shows a status message) keeps working completely unchanged — no
  Elementor Pro Forms widget needed for this one.

## What's simplified vs. the static pages

Being upfront about the gap, since "native widgets" was chosen over the
pixel-perfect HTML-embed approach:

- **No flame watermark / radial glow decorations**, and the homepage's
  large bleeding flame mark behind "The Idea" is a plain centered image
  instead of the oversized left-edge bleed. Native Elementor sections
  don't have an easy equivalent for a decorative absolutely-positioned
  bleeding graphic without a background-image trick or Elementor Pro's
  extra positioning controls.
- **The hero background photo** is set via Elementor's native
  background-image + a translucent cream overlay (classic background,
  `{{BASE_URL}}/assets/hero.png`, 82% cream overlay) rather than the
  static build's own layered/positioned image — same visual effect,
  simpler markup.
- **No scroll-reveal animations, and the homepage's word-by-word kinetic
  headline reveal is a plain static heading.** The static build animates
  both via a shared IntersectionObserver/CSS. Elementor's entrance
  animations (Motion Effects) could approximate the reveal per-widget if
  you want it back, but that's a Pro feature and a per-element manual
  setting, not something that survives a JSON import.
- **The pillar ticker doesn't auto-scroll** — shown as a static wrapped
  row instead of an infinite marquee, which needs a CSS keyframe
  animation with no native widget equivalent.
- **The Impact numbers don't count up on scroll** — shown as their final
  static values. The static build animates 0 → target via JS tied to the
  IntersectionObserver.
- **The Pillars bento** reproduces the real 2-row asymmetric grid (Community
  spanning the full left side, Youth & Education / Ideas stacked on the
  right) using Elementor's nested "inner section" mechanism rather than an
  exact CSS-grid span, so the proportions are close but not pixel-identical.
- **The Continuity timeline's connecting line between the two dots** is a
  static HTML/CSS line rather than the real page's animate-in version
  (decorative, not load-bearing).
- **Card hover-lift** isn't included anywhere — native columns don't
  expose a hover-transform control without Pro's Motion Effects.
- **Uppercase eyebrow labels are typed as literal caps** rather than
  relying on a text-transform CSS rule, since the free Heading widget
  doesn't expose that control in every Elementor version.
- Cards that are a whole clickable block in the static build (bento
  cells, the About "Who we are" card) are not clickable as a whole block
  here — only the Button text inside each is a link. Elementor Pro's
  Container "Link" setting fixes this if you have it.

None of this affects content or information architecture — only motion
and a few decorative flourishes that free-tier native widgets can't
reproduce without Elementor Pro.

## Status

- [x] `about.json` — confirmed working (test-imported successfully)
- [x] `home.json` — built, awaiting your test-import
- [ ] Contact, Research, Stories, Story Detail, Grounded, People, Work,
      Community, Youth & Education, Ideas/Ethics/Society, Care &
      Wellbeing, Women's Leadership ×2 — note Research/Stories/Grounded/
      Story Detail are the theme's PHP templates, not Elementor pages
      (see wordpress-theme/README.md) — say the word and I'll build the
      rest of the plain pages the same way.
