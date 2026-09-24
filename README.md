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
- FieldPulse as the first configured BusinessOS application
- Organization, WebSite, SoftwareApplication and Breadcrumb JSON-LD
- XML sitemap
- robots.txt
- Mobile-first responsive navigation
- Low-bandwidth delivery defaults
- Automated feature tests and Pint style validation

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
- `/sitemap.xml` — XML sitemap
- `/robots.txt` — crawler policy

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

The next implementation batches will add the remaining trust pages, content/guides architecture, CMS/admin product management, localization infrastructure for English/Dari/Pashto, image optimization, analytics hooks, accessibility regression checks, and production performance measurement.

## Engineering principle

> Modern software. Serious engineering. Fast everywhere.

Performance measurements and ranking claims are only published after real production validation; they are not fabricated in marketing copy.
