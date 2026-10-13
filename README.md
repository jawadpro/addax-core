# Addax Core 2.0

Companion plugin for the **[Addax](https://github.com/jawadpro/addax)** block theme. No third-party plugins needed (no WPBakery, Redux, Meta Box or ACF).

## Blocks (category "Addax")

| Block | Replaces |
|---|---|
| Hero Slider + Hero Slide | Addax Slider post type + shortcode |
| Counter | Counter shortcode |
| Progress (line, rounded, donut) | Skill bar shortcode + donut charts |
| Info Box (classic, modern, inline; icon or image) | Infobox, Infobox Modern, Icon Box shortcodes |
| Tabs + Tab (bullets, pills, underline) | Bullet Tabs shortcode |
| Client Logos (static or marquee) | Clients shortcode |
| Projects (filterable grid + lightbox) | Projects shortcode |
| Team Member | Team post type + shortcode |
| Testimonials + Testimonial | Testimonials post type + shortcode |
| Map (keyless Google embed) | Footer map + API key option |

Heading, Button and Accordion are now block styles on the core blocks (in the theme).

All blocks are dynamic (`render.php`), accessible (keyboard, ARIA, pause controls, `prefers-reduced-motion`) and use no jQuery.

## Settings and meta

- **Addax → Settings** — React screen over the REST API: contact details, social URLs, default header, sticky header, back-to-top, reveal animations, copyright, and a demo-projects importer.
- **Block bindings** — source `addax/options` lets any Paragraph/Heading/Button show a setting, e.g. `{"source":"addax/options","args":{"key":"phone"}}`. Keys: `phone`, `email`, `address`, `hours`, `copyright`, `phone_url`, `email_url`, `social.<network>`.
- **Social Icons** whose link is `#` pick up the saved URLs automatically.
- **Per-page options** (editor sidebar → *Addax layout*): header style, footer style, hide title bar.
- **Project details** (editor sidebar): client, year, services, live URL — bound into the single-project template via core `post-meta` bindings.

## Development

```bash
npm install
npm run build      # or: npm start
npm run icons      # regenerate src/icons.json from @wordpress/icons
npm run plugin-zip
```

`build/` is committed, so the plugin works without a build step.
