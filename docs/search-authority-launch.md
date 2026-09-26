# BusinessOS Search & Authority Launch Checklist

Use this after deploying the current BusinessOS website code to production.

## 1. Deploy application changes

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize
```

## 2. Seed public search content

The seeders use stable slugs and update the current content rather than creating duplicate public pages.

```bash
php artisan db:seed --class=ProductSeeder --force
php artisan db:seed --class=SearchGuideSeeder --force
php artisan db:seed --class=SeoPageSeeder --force
php artisan db:seed --class=CaseStudySeeder --force
```

The CaseStudySeeder publishes only implementation stories grounded in work represented in the project repositories. It intentionally avoids invented ROI, revenue or conversion metrics.

## 3. Add webmaster verification tokens

In the BusinessOS CMS SEO settings, save:

- Google Search Console verification token
- Bing Webmaster verification token

Only the token value should be stored. The marketing layout renders the required verification meta tags.

## 4. Configure IndexNow

Production environment:

```dotenv
INDEXNOW_ENABLED=true
INDEXNOW_KEY=<generated-indexnow-key>
INDEXNOW_ENDPOINT=https://api.indexnow.org/indexnow
INDEXNOW_TIMEOUT=4
```

After changing environment values:

```bash
php artisan optimize:clear
php artisan optimize
```

The public key endpoint is:

```text
https://businessos.af/indexnow-key.txt
```

## 5. Check search readiness

```bash
php artisan search:status
```

The report should show:

- Google Search Console verification: configured
- Bing Webmaster verification: configured
- IndexNow enabled: yes
- IndexNow key: configured
- Published product/service/guide/case-study counts

## 6. Verify public crawl surfaces

Open these production URLs and confirm HTTP 200:

```text
https://businessos.af/robots.txt
https://businessos.af/sitemap.xml
https://businessos.af/llms.txt
https://businessos.af/case-studies
```

Confirm the sitemap includes current products, service pages, guides and case studies.

## 7. Submit the public URL inventory to IndexNow

```bash
php artisan search:indexnow
```

A successful command reports the number of unique public URLs submitted.

## 8. Search Console and Bing

After the verification meta tags are live:

1. Complete ownership verification in Google Search Console.
2. Submit `https://businessos.af/sitemap.xml`.
3. Complete ownership verification in Bing Webmaster Tools.
4. Submit the same sitemap in Bing.
5. Record the first search-query and indexing baseline before creating additional search pages.

## 9. Screenshot evidence

Do not publish fabricated product screenshots.

For each priority product, capture genuine screens from the working application, then upload them through the BusinessOS Media CMS with descriptive alt text and a factual caption.

Priority order:

1. FieldPulse: live map / territory view, customer or visit workflow, mobile field workflow.
2. BusinessOS ERP: BOM/production, inventory, business-unit reporting.
3. BusinessOS POS: full-screen cashier workspace and post-sale receipt.
4. Restaurant Management System: only after the actual waiter/kitchen product exists.

Use the Media CMS generated screenshot reference in the related Product CMS record so the product page receives image metadata, schema and image-sitemap coverage.
