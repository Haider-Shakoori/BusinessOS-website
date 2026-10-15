# BusinessOS Website

Official website and product discovery platform for **BusinessOS**.

## Current foundation

This repository now contains the first production-oriented BusinessOS marketing foundation:

- Laravel 13 / PHP 8.3+
- Server-rendered Blade pages
- No external fonts
- No frontend framework dependency for core rendering
- Responsive BusinessOS design system
- BusinessOS app directory
- Dedicated SEO product pages
- About, Pricing, Security, Privacy, Terms and Contact pages
- Database-backed contact / sales / demo inquiry capture
- Rate-limited inquiry endpoint with validation and honeypot protection
- FieldPulse conversion, pricing-status and FAQ sections
- FieldPulse as the first configured BusinessOS application
- Organization, WebSite, SoftwareApplication and Breadcrumb JSON-LD
- XML sitemap
- robots.txt
- Mobile-first responsive navigation
- Low-bandwidth delivery defaults
- Automated feature tests and Pint style validation
- Authenticated BusinessOS CMS with guide publishing
- First-party website analytics with unique visits, all visits, country breakdowns and top pages
- Configurable analytics retention with scheduled pruning

## Why the frontend is intentionally lightweight

The public website is designed for users on both fast broadband and constrained mobile networks. Core content is rendered as HTML on the server, the visual layer is plain CSS, and the current foundation requires no JavaScript to read, navigate or index primary content.

This keeps the initial architecture compatible with aggressive caching and small transfer sizes while leaving room to add progressive enhancement only where it produces real user value.

## Local setup

Requirements:

- PHP 8.3+
- Composer 2

Install:

```bash
composer run setup
php artisan serve
```

The local site will be available at `http://127.0.0.1:8000` unless Laravel selects another port.

## Tests

```bash
composer test
vendor/bin/pint --test
```

## Main routes

- `/` — BusinessOS homepage
- `/apps` — app directory
- `/apps/fieldpulse` — FieldPulse product page
- `/pricing` — pricing architecture
- `/about` — BusinessOS positioning and principles
- `/security` — security principles
- `/privacy` — public website privacy policy
- `/terms` — website terms of use
- `/contact` — contact and sales inquiry form
- `/request-demo` — product demo request form
- `/resources` — published guides and resources
- `/guides/{slug}` — individual resource page
- `/admin` — authenticated BusinessOS CMS
- `/sitemap.xml` — XML sitemap
- `/robots.txt` — crawler policy

## Google Analytics 4 integration

GA4 remains separate from the existing first-party BusinessOS analytics. The public tag
is loaded only when GA4_MEASUREMENT_ID is set and the visitor is permitted to be
tracked. This implementation requires no inline JavaScript and dynamically aligns
the site's Content Security Policy with Google Analytics script and collection hosts.

1. Create a **BusinessOS** GA4 property and a Web data stream at https://businessos.af.
2. Configure GA4_MEASUREMENT_ID=G-... on the production server (do not reuse the RelayWA ID).
3. For the optional CMS GA4 dashboard, configure the **numeric** GA4_PROPERTY_ID, enable
   the Google Analytics Data API, grant Viewer access to a service account, and put the
   JSON file **outside public/**; configure GA4_CREDENTIALS_PATH with the private path.
4. For automatic tracking in non-consent regions, configure GA4_TRUSTED_COUNTRY_HEADER
   only if your CDN/edge overwrites a trustworthy country header. Alternatively,
   install the existing local MMDB country database. Unknown locations default to
   opt-in; EEA, UK, and Swiss visitors must explicitly opt in via /privacy.
   All visitors can disable GA4 at /privacy; GPC opt-out signals are respected.
5. Run `php artisan config:cache` after editing the environment. Validate the public
   HTML, CSP headers, browser Network requests and GA4 Realtime; dashboard stats
   require the separate Data API credentials and may lag behind Realtime.

Do not commit service-account credentials, install arbitrary visitor-country headers as
trusted geolocation, or assume GA4 referrals show every AI recommendation.

## Keyword and referral attribution

The admin website analytics screen now provides two different metrics that should
never be confused:

- **Search result impressions**: actual Google organic search impressions, clicks,
  CTR and average position by query and landing page, queried from Search Console.
- **First-party page views**: the existing anonymous visit log, grouped by referring
  domain / campaign source and a supplied search keyword or campaign UTM term.

Historical visit rows retain their existing `referrer_host`, which is used at
report time after migration. Old visits are **never deleted or relabeled** to
manufacture keywords. Historical visits collected before bot classification are
shown as *Historical / unclassified* in acquisition reports, not included in the
human-only KPIs. Unknown search terms display *Not provided*. New requests can
capture a keyword from `utm_term` or recognized search engines' visible query
parameter; organic search usually does not provide individual keywords.

To enable Search Console reports, verify the property at Google Search Console,
enable the Google Search Console API in Google Cloud, and grant the service account
**Full** or **Restricted** access to the property. Configure
`SEARCH_CONSOLE_SITE_URL=sc-domain:businessos.af` (or the **exact** URL prefix).
Set `SEARCH_CONSOLE_CREDENTIALS_PATH` to an untracked service-account JSON file
outside `public/`, or reuse your existing `GA4_CREDENTIALS_PATH` when the
same service account has access to both properties. Run:

```bash
php artisan migrate --force
php artisan config:cache
```

The new nullable columns preserve all existing visits. Search Console may return
up to about 16 months of historical data depending on Google's retention and
privacy suppression, whereas the local visit table follows the configured
retention schedule (default 400 days). The analytics page has 7, 30, 90, and
365-day views. No historical keywords are inferred from aggregate GSC queries.

## Safe cPanel production deployment

BusinessOS marketing website stays on its existing cPanel host (not the
development VPS). The production checkout is
`/home/businessos/businessos-site` and the live public folder is
`/home/businessos/public_html`.

The deployment script uses SQLite `VACUUM INTO` to take a consistent private
backup of the existing database, copies the production `.env` and live
web entry files to `/home/businessos/deployment-backups/`, safely fast-forwards
`main`, installs production dependencies, runs *only pending migrations*,
refreshes Laravel caches and copies static assets. It **never** reseeds,
resets or truncates existing data, and never overwrites
`public_html/index.php` or `public_html/.htaccess`.

Using an authorized BusinessOS cPanel SSH session, run:

```bash
cd /home/businessos/businessos-site
git pull --ff-only origin main
bash scripts/deploy-businessos-analytics.sh
```

If the SQLite database is not present at the expected path or tracked working
files are dirty, the script refuses to deploy. Do not bypass that safeguard:
confirm the actual DB configuration and production state first.

## Inquiry capture

Contact, sales and demo requests are stored in the `inquiries` table before any future email or CRM integration. This avoids depending on an invented or unconfigured recipient address and gives the later admin/CMS batch a reliable source of leads.

Run migrations in every deployed environment:

```bash
php artisan migrate --force
```

The public inquiry endpoint is validation protected, rate limited and includes a honeypot field.

## CMS administration

The CMS has no public registration route. After migrations, create or promote the first administrator interactively:

```bash
php artisan admin:create
```

The current CMS includes:

- overview dashboard
- guide creation, editing, draft/publish workflow and soft delete
- unique website visits by country
- all website visits by country
- top public pages and daily traffic
- 7, 30 and 90 day analytics windows

Website analytics is first-party. It uses an anonymous visitor cookie for unique counting, does not store raw visitor IP addresses, and uses a trusted country code supplied by the host or CDN when available.

Example production analytics configuration:

```env
ANALYTICS_ENABLED=true
ANALYTICS_RETENTION_DAYS=400
ANALYTICS_COUNTRY_HEADER=CF-IPCountry
```

Run Laravel's scheduler in production so expired analytics rows are pruned automatically.

Seed the initial resource library with:

```bash
php artisan db:seed --class=GuideSeeder --force
```

## Product catalog

For the foundation stage, application content lives in:

```
config/businessos.php
```

This is deliberate: it keeps the first public version fast and testable while the later CMS/admin batch introduces database-backed product management without changing public URLs.

## Deployment

Point the web server document root to:

```
/public
```

Production environment values should include:

```env
APP_NAME="BusinessOS"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://businessos.af
APP_TIMEZONE=Asia/Kabul
```

Run Laravel optimization after deployment:

```bash
php artisan optimize
```

## Roadmap

The next implementation batches will expand CMS product and inquiry management, add localization infrastructure for English/Dari/Pashto, real product media and image optimization, consent/analytics refinements where required, accessibility regression checks, and production performance measurement.

## Engineering principle

> Modern software. Serious engineering. Fast everywhere.

Performance measurements and ranking claims are only published after real production validation; they are not fabricated in marketing copy.
