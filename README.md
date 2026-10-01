# All Star Health Spine & Joint Care — Website + Dashboard

A custom website for **allstarspinecenter.com** built from the *Website Rebuild Brief*, plus an app-style dashboard for managing it. It's plain PHP 8 + MySQL, with no framework, no WordPress and no build step needed on the server, so it runs on standard SiteGround hosting.

- **Public site:** modern design system, mega menu, mobile slide-out menu, the 18-section homepage, all 32 treatment pages (plus Wharton's Jelly and Prolotherapy as drafts), provider directory and profiles, locations, appointment, contact, billing & insurance, about, testimonials, legal pages, and HTML and XML sitemaps.
- **Dashboard (`/admin/`):** a single-page app where every action runs over AJAX. It covers treatments, providers, pages, testimonials, FAQs, locations, a media library (drag & drop, automatic WebP and thumbnails), a form inbox, users & roles, settings, redirects, an activity log, analytics, Ctrl+K search and dark mode.

---

## 1. Install on SiteGround (staging: `ahrons20.sg-host.com`)

1. **Create a database.** In Site Tools → Site → MySQL, create a database and a user, and add the user to the database with all privileges. Note the database name, user and password.
2. **Upload the files** into the site's `public_html` folder, using the File Manager (upload the ZIP and extract it) or FTP. Upload everything in this repository, including the hidden `.htaccess` files.
3. Open **`https://ahrons20.sg-host.com/install/`** in a browser:
   - Choose **MySQL** and enter the database details (the host is `localhost`).
   - Create the administrator account (username, email and password).
   - Leave **"Hide the site from search engines"** turned ON while the site is on the staging domain.
4. Click **Install website**. The installer creates the tables, loads all content and then locks itself.
5. Sign in at **`/admin/`**.

> Requirements: PHP 8.0+ with PDO MySQL, DOM, mbstring and GD (all enabled by default on SiteGround). Turn on HTTPS under Site Tools → Security → SSL Manager / HTTPS Enforce.

### Moving to the live domain later
Point allstarspinecenter.com at the same files. The site detects its domain automatically. Then go to **Dashboard → Settings → SEO** and turn off *Hide site from search engines*.

---

## 2. Deploying updates (FTP)

After FTP access is set up, updates can be pushed in either of these ways:

```bash
# From any machine with lftp installed
FTP_HOST=ftp.ahrons20.sg-host.com FTP_USER=… FTP_PASS=… FTP_DIR=/public_html ./scripts/deploy.sh
# SiteGround SFTP:   FTP_PROTO=sftp FTP_PORT=18765 …
# Preview only:      DRY_RUN=1 …
```

You can also use the GitHub Action **"Deploy to SiteGround"**. It runs manually and needs the repository secrets `FTP_HOST`, `FTP_USERNAME`, `FTP_PASSWORD` and optionally `FTP_DIR`.

Deploys **never** overwrite or delete `app/config.php`, the database, sessions or logs, or media in `uploads/`. All content stays intact.

---

## 3. Dashboard

| Area | What it does |
|---|---|
| Dashboard | Page-view chart (cookie-free counter), top pages, new form submissions, a website health checklist, content still needing review, recent activity |
| Treatments | All service pages with the brief's page template: hero, *What is it*, conditions, how it works, benefits, what to expect, FAQ (with FAQ schema), related treatments, "Where does it hurt?" body areas, menu visibility, featured, coming soon, SEO with a Google preview. Drag to reorder. |
| Providers | Profiles with photo plus a **focal-point picker** so faces are never cropped, plus bio, education, experience, philosophy, focus areas, locations and services |
| Pages | Core pages (URLs locked) and any new standard or legal pages |
| Testimonials / FAQs / Locations | Carousel content; homepage and billing FAQs; addresses, hours (with opening-hours schema), maps |
| Media Library | Drag & drop uploads with progress, automatic resize and WebP and thumbnails, alt text, search, filters, bulk delete. It also serves as the image and PDF picker everywhere. |
| Form Inbox | Appointment, contact and benefits-check submissions; call, text and email buttons; read, archive and delete; CSV export |
| Users & Roles | **Administrator** (everything), **Editor** (all content, media, inbox, redirects), **Author** (drafts and uploads only), **Viewer** (read-only) |
| Settings | Brand and colours, logos, homepage hero, stats and featured treatments, GoHighLevel embeds and webhook, chat widget, analytics, patient form PDFs, social links, SEO |
| Redirects | 301/302 manager with hit counts (preserves SEO for any changed URL) |
| Activity Log | Who changed what, and when |

Shortcuts: **Ctrl/Cmd + K** opens search, **Ctrl/Cmd + S** saves.

### Forms & GoHighLevel
The built-in forms work out of the box. Submissions go to the Form Inbox and are emailed to the notification address. To use GoHighLevel/LeadConnector:
- paste the GHL **embed code** for each form in *Settings → Forms & Integrations* (the embed replaces the built-in form), **or**
- keep the built-in forms and add a **GHL inbound webhook URL**, so every submission is also posted to GHL as JSON.

The chat/text widget, GA4 ID and tracking pixels go on the same screen.

---

## 4. Content still to supply

The current site was not reachable from the build environment, so treatment and provider copy is careful, brief-compliant starter text (no guaranteed outcomes or invented credentials). Each item is flagged **Needs content review** on the dashboard. Before launch:

- [ ] Paste the original treatment descriptions (cleaned up) and untick *Needs content review*
- [ ] Provider photos, bios, education and verified credentials
- [ ] Original testimonial wording (seeded as drafts with the existing names)
- [ ] Official logo and favicon (Settings → Branding); adjust brand colours to match the logo
- [ ] Hero and office photography
- [ ] The five patient-form PDFs (Settings → Patient Forms)
- [ ] GoHighLevel embeds or webhook, chat widget, social links
- [ ] Confirm the items in section 11 of the brief (IV Therapy URL, Wharton's Jelly / Prolotherapy, 4th statistic, cookie notice, newsletter)
- [ ] Turn off "Hide from search engines" at launch

---

## 5. Project structure

```
index.php              Front controller (all public URLs; trailing-slash URLs as on the old site)
.htaccess              Rewrites, caching, compression, private-folder protection
app/                   Application code (blocked from the web)
  bootstrap.php        Config, autoload, DB connection
  schema.php           Tables (MySQL + SQLite)
  seed/                Initial content from the brief
  lib/                 DB, Auth (roles/CSRF), Html sanitizer, Media, Forms, Seo, Content, Resources
  views/               Layout, partials and page templates
  storage/             SQLite DB (if used), sessions, logs (not deployed)
admin/                 Dashboard SPA (index.php shell, api.php JSON API, assets/)
install/               One-time installer (locks after use)
assets/                CSS, JS (with .min builds), self-hosted fonts, images
uploads/               Media library files (PHP execution disabled)
scripts/deploy.sh      FTP/SFTP deploy
```

### Local development
```bash
php app/cli/install.php --driver=sqlite --username=admin --email=you@example.com --password=change-me
php -S 127.0.0.1:8080 index.php     # http://127.0.0.1:8080  and  /admin/
npm install && npm run build        # regenerate assets/*.min.* after editing site.css / site.js
```

### Security notes
- Passwords use `password_hash`. Sessions are HttpOnly and SameSite, regenerated at login, with a 12-hour idle timeout.
- CSRF tokens are required on every dashboard write, and sign-in is rate-limited.
- Role checks are enforced on the server for every API call, not only in the interface.
- Rich text runs through an allowlist sanitizer. Uploads are type-checked, renamed, and served from a folder where PHP can't execute.
- `app/config.php` is generated at install time and is never committed or deployed.
