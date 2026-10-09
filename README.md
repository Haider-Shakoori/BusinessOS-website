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

The first-party BusinessOS analytics (including AI crawler counts) remains independent.
The CMS overview and /admin/analytics now show a separate Google Analytics 4 report
with users, sessions, page views, engagement, key events, acquisition sources,
and identifiable AI referral sessions. These are attributed referrals, not
evidence of every AI answer mentioning BusinessOS.

1. Create a Google Analytics account/property and a **Web data stream**
   for `https://businessos.af`. Copy its Measurement ID (`G-...`) and
   numeric **Property ID**.
2. Enable **Google Analytics Data API** for your Google Cloud project.
3. Create a Google Cloud service account, securely download its JSON key,
   store it **outside the site document root and repository**, and give its
   email **Viewer** access to the GA4 property (Analytics Admin > Property
   access management).
4. On the server set these values in `.env` and run `php artisan config:cache`:

```env
GA4_MEASUREMENT_ID=G-XXXXXXXXXX
GA4_PROPERTY_ID=123456789
GA4_CREDENTIALS_PATH=/absolute/private/path/ga4-service-account.json
GA4_REPORT_CACHE_MINUTES=15
```

**Security:** Never paste the private key into GitHub or the CMS settings.
Ensure the JSON file permissions allow only the PHP application user to
read it. The Google tag is placed on public marketing pages only, and is
not included for signed-in administrators or browsers excluded with the
`bos_internal` cookie. The server-side reports are cached and fail
gracefully if Google is unavailable. Confirm any cookie/consent requirements
for your visitors before enabling third-party tracking. Test the Google
tag using GA4 Realtime/DebugView and confirm CMS reports after processing.

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
