# Elementor templates — Suluh Centre

This folder holds native-Elementor-widget templates, one JSON file per page,
built from the approved static pages in the repo root. `about.json` is the
first one, built as a proof of concept — please import it and check it in
your actual WordPress + Elementor install before I build out the rest of
the pages the same way. I have no way to test-render Elementor JSON myself,
so this first page is the checkpoint that catches any schema mismatch
(Elementor's exact widget control keys vary a little by version) before I
replicate the pattern 14 more times.

## Requirements

- **Elementor** (free tier covers everything used in `about.json`).
- A theme that supports Elementor "Canvas" / full-width page templates
  (Hello Elementor, Astra, GeneratePress, etc. all work — Hello Elementor
  is the simplest since it has almost no theme chrome of its own).
- The site's assets uploaded somewhere reachable — see **Assets** below.

## How to import

1. In WP Admin: **Templates → Saved Templates → Import Templates**, upload
   `about.json`.
2. Create the actual page: **Pages → Add New**, title it "About", set the
   **Page Attributes → Template** to your theme's blank/canvas template
   (in Hello Elementor this is "Elementor Canvas") so no theme header/
   footer doubles up with whatever site-wide header/footer you build
   separately in Elementor.
3. Edit the page with Elementor, and insert the imported template:
   the folder icon in the panel → **My Templates** → About → Insert.
4. Fix the two placeholders this template ships with (find them by
   editing any Button/Image widget, or use **Elementor → Tools → Regenerate
   CSS** afterward if you bulk find-and-replace at the database level):
   - `{{BASE_URL}}` → wherever you upload the `assets/` folder (Media
     Library gives every file its own URL — easiest is uploading
     `about-people.png` there directly and re-picking it in the Image
     widget rather than editing the URL by hand).
   - `{{SITE_URL}}` → your real domain, in the two Button widgets that
     link to `/people/` and `/contact/`, `/our-work/`.

## What this page uses

Section (dark green, two columns: heading/text/text, then image) →
Section (dark green, two columns: Vision quote, Mission text + tag chips) →
Section (two cream cards side by side) → Section (section heading) →
Section (two more cards, "Our Work" / "Get in touch").

Widgets: **Heading**, **Text Editor**, **Image**, **Button**, **Spacer** —
all free-tier. Colors, fonts (Inria Serif / Manrope — both are in
Elementor's built-in Google Fonts picker, no extra plugin needed),
spacing and card backgrounds are set per-widget/column to match the
static build's tokens.

## What's simplified vs. the static about.html

Being upfront about the gap, since "native widgets" was chosen over the
pixel-perfect HTML-embed approach:

- **No flame watermark / radial glow decorations.** The static page layers
  a large translucent flame SVG and a radial-gradient glow behind the
  hero and vision sections. Native Elementor sections don't have an easy
  equivalent for a decorative absolutely-positioned bleeding graphic
  without a background image trick or Elementor Pro's shape dividers /
  extra positioning controls. Left out rather than faked badly.
- **No scroll-reveal animations.** The static build fades/slides each
  block in on scroll via a shared IntersectionObserver. Elementor's free
  entrance animations (Advanced tab → Motion Effects, actually a Pro
  feature) could approximate this per-widget if you want it back — not
  included here since it's a per-element manual setting, not something
  that survives a JSON import cleanly.
- **Card hover-lift** on the two closing "bento" cards isn't included —
  native columns don't expose a hover-transform control without Pro's
  Motion Effects.
- **Uppercase eyebrow labels are typed as literal caps** ("ABOUT", "VISION")
  rather than relying on a text-transform CSS rule, since the free Heading
  widget doesn't expose that control in every Elementor version.
- The two closing cards and the "Who we are" card are not clickable as a
  whole block (a real limitation of free Elementor) — only the Button text
  inside each is a link, whereas the static page makes the entire card
  a link. Elementor Pro's Container "Link" setting fixes this if you have
  it.

None of this affects content or information architecture — only motion
and a few decorative flourishes that free-tier native widgets can't
reproduce without Elementor Pro.

## Status

- [x] `about.json` — built, awaiting your test-import
- [ ] Everything else (homepage, Contact, Research, Stories, Story
      Detail, Grounded, People, Work, Community, Youth & Education,
      Ideas/Ethics/Society, Care & Wellbeing, Women's Leadership ×2) —
      once About imports and renders correctly for you, say so and I'll
      build the rest the same way.
