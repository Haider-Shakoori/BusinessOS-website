<?php

namespace Database\Seeders;

use App\Models\Guide;
use Illuminate\Database\Seeder;

class SearchGuideSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->guides() as $guide) {
            Guide::updateOrCreate(
                ['slug' => $guide['slug']],
                [
                    ...$guide,
                    'author_name' => 'BusinessOS Editorial Team',
                    'author_role' => 'Business software & operations',
                    'author_bio' => 'BusinessOS publishes practical guidance based on software engineering, operational workflows and implementation experience.',
                    'status' => 'published',
                    'published_at' => now(),
                ]
            );
        }
    }

    private function guides(): array
    {
        return [
            [
                'title' => 'ERP vs MIS: What Is the Difference?',
                'slug' => 'erp-vs-mis-difference',
                'category' => 'ERP & MIS',
                'excerpt' => 'Understand the practical difference between ERP and MIS, where they overlap and when a business may need both.',
                'content' => <<<'TEXT'
ERP and MIS are often discussed as if they are competing products, but they usually solve different layers of the same information problem.

## What an ERP does

An enterprise resource planning system is primarily transactional. It records and controls activities such as sales orders, purchases, receipts, stock movements, production, expenses, payments and accounting entries. Its value depends on consistent operational data.

## What an MIS does

A management information system focuses more directly on information for monitoring and decisions. It may combine data from an ERP, CRM, spreadsheets or other systems and present KPIs, summaries, exceptions and trends to managers.

## Where ERP and MIS overlap

The overlap appears because modern ERP systems usually include dashboards and reporting. The practical question is whether those reports are enough for management or whether the organization needs a broader information layer across several systems.

For example, a factory ERP may record production, material consumption and sales. An MIS may combine those records with targets, external forecasts or manually approved management indicators to show a consolidated executive view.

A business should avoid building an MIS on unreliable source data. If operational records are inconsistent, a polished dashboard can simply make bad data look more convincing. Transaction quality should come first.

## Which approach fits

In many organizations the right architecture is ERP for execution and an MIS layer for consolidated management visibility. In smaller organizations, one well-designed ERP may be enough.
TEXT,
                'meta_title' => 'ERP vs MIS: Difference, Uses and When You Need Both | BusinessOS',
                'meta_description' => 'Learn the practical difference between ERP and MIS, how they work together and when a business needs transactional software, management reporting or both.',
            ],
            [
                'title' => 'How to Migrate from Excel to an ERP System',
                'slug' => 'how-to-migrate-from-excel-to-erp',
                'category' => 'Data Migration',
                'excerpt' => 'A practical migration sequence for moving customers, products, stock, balances and operational records from spreadsheets into ERP software.',
                'content' => <<<'TEXT'
Moving from Excel to ERP should begin with process and data cleanup, not with importing every spreadsheet exactly as it is.

## Inventory the source data

Start by listing the files that actually drive the business. Separate master data such as customers, suppliers and products from transactional data such as invoices, purchases, stock movements and payments.

## Clean identities and codes

Next, identify duplicates and inconsistent codes. Two customer names may refer to the same account, or one product may appear with several spellings and units. The ERP needs one clear identity for records that will participate in future transactions.

## Decide what history matters

Decide how much history to migrate. Opening balances and current stock may be mandatory while years of detailed historical transactions might be kept in an archive. Moving less data can reduce risk when old files are poorly structured.

## Map and transform the data

Create a mapping document that states where every important spreadsheet column will go in the ERP. Include transformation rules for dates, units, currency, codes and empty values.

## Rehearse and validate

Run a test migration before the final cutover. Check record counts, stock totals, customer balances and representative samples. Users who understand the existing files should participate in this validation.

## Cut over carefully

At launch, freeze or control changes to the old files long enough to complete the final migration and reconciliation. Keep a signed-off baseline so the team knows which numbers were accepted into the new system.

A successful migration is not measured by how many rows were imported. It is measured by whether the new system begins with data people can trust.
TEXT,
                'meta_title' => 'How to Migrate from Excel to ERP Safely | BusinessOS',
                'meta_description' => 'A practical step-by-step guide to cleaning, mapping, testing and reconciling customers, products, stock and balances when moving from Excel to ERP.',
            ],
            [
                'title' => 'Custom ERP vs Off-the-Shelf ERP',
                'slug' => 'custom-erp-vs-off-the-shelf-erp',
                'category' => 'ERP Decisions',
                'excerpt' => 'Compare custom ERP and packaged ERP based on workflow fit, implementation effort, ownership, integrations and long-term maintenance.',
                'content' => <<<'TEXT'
The decision between custom ERP and off-the-shelf ERP is not simply a technology decision.

## When packaged ERP fits It is a trade-off between adapting the organization to an existing product and adapting software to the organization.

Packaged ERP can be attractive when business processes are standard, the required modules already exist and the organization is prepared to adopt the product's workflows. It may also provide a larger support ecosystem.

## When custom ERP fits

Custom ERP becomes more attractive when important workflows, approvals, calculations or industry data do not fit standard software cleanly. It can also reduce the number of external spreadsheets and manual workarounds created around a generic system.

Customization has a cost. The organization needs disciplined requirements, testing, documentation and long-term maintenance. A custom system without clear ownership can become difficult to evolve.

## Compare total implementation cost

The comparison should include implementation cost, migration, training, integrations, future change and the cost of manual workarounds—not only the initial license or development amount.

A useful decision process lists the workflows that are truly differentiating or non-negotiable. Standard processes do not need custom software merely because customization is possible.

## Hybrid approaches

Hybrid approaches are also common. A business may use a standard accounting platform while building custom production, field operations or management tools around it through integrations.
TEXT,
                'meta_title' => 'Custom ERP vs Off-the-Shelf ERP: How to Choose | BusinessOS',
                'meta_description' => 'Compare custom and packaged ERP software across workflow fit, cost, implementation, integration, ownership and long-term maintenance.',
            ],
            [
                'title' => 'How BOMs, Actual Consumption and Production Costing Work Together',
                'slug' => 'bom-actual-consumption-production-costing',
                'category' => 'Manufacturing',
                'excerpt' => 'Understand why manufacturing systems should preserve both standard BOM quantities and actual material consumption for variance and costing.',
                'content' => <<<'TEXT'
A bill of materials describes what production is expected to consume.

## Standard BOM as the baseline Actual consumption records what production really used. A manufacturing system needs both values because they answer different questions.

The BOM is the planning baseline. It can drive material requirements, quotations, standard cost and production preparation. If the standard changes, the BOM should be versioned or updated intentionally.

## Actual consumption

Actual consumption is entered during or after execution. It reflects real material usage, including operational differences that may come from machine settings, moisture, scrap, operator decisions or other production conditions.

## Preserve variance

The system should not overwrite the planned amount with actual usage. Doing that removes the ability to calculate variance. Instead, planned and actual quantities should remain side by side.

## Costing and inventory

Costing can then use the actual material quantity when calculating realized production cost, while standard cost remains useful for planning and comparison.

Inventory should follow the actual approved consumption when that is the business rule. The stock movement should reference the production event so the material deduction can be traced later.

## Use variance as a management signal

Variance reports become useful when management can investigate repeated differences by product, material, machine, shift or period. A variance is not automatically a problem; it is a signal that needs context.
TEXT,
                'meta_title' => 'BOM vs Actual Consumption in Manufacturing Costing | BusinessOS',
                'meta_description' => 'Learn how standard BOM quantities, actual material consumption, inventory deduction and production costing should work together in manufacturing software.',
            ],
            [
                'title' => 'How Pharmacy Expiry Tracking Should Work',
                'slug' => 'pharmacy-expiry-tracking',
                'category' => 'Pharmacy Operations',
                'excerpt' => 'A practical model for storing medicine batches and expiry dates, receiving stock and identifying inventory that needs attention.',
                'content' => <<<'TEXT'
Expiry tracking is most reliable when expiry data enters the system at the same time as the stock.

## Capture expiry at receiving Trying to add expiry dates later creates gaps between the physical medicine and the database record.

The receiving workflow should identify the medicine, quantity, batch or lot where required, expiry date and supplier context. The exact level of detail depends on the pharmacy's operating model.

## Keep batch identity through stock

Stock should remain linked to the batch information after receipt. If several batches of the same medicine exist, the system should be able to distinguish them instead of storing one combined expiry date.

## Make reports actionable

Reports should focus on action. Useful views include already expired stock, items expiring within defined periods and the value or quantity exposed to expiry.

## Connect expiry to sales and purchasing

Sales or issue workflows can support policies such as using earlier-expiring stock first, although the physical process still needs staff discipline. Software can guide the decision but cannot guarantee the correct box is physically selected.

Returns, adjustments and damaged stock should preserve batch context where practical so quantities remain accurate.

Expiry tracking becomes more valuable when combined with purchasing. Reorder decisions can then consider available stock, near-expiry stock and historical movement instead of looking only at total quantity.
TEXT,
                'meta_title' => 'Pharmacy Expiry Tracking: Batches, Stock and Reordering | BusinessOS',
                'meta_description' => 'Learn how pharmacy software should capture medicine batches and expiry dates, report near-expiry stock and connect expiry awareness to purchasing.',
            ],
            [
                'title' => 'How to Modernize an Old Laravel Application',
                'slug' => 'modernize-old-laravel-application',
                'category' => 'Application Modernization',
                'excerpt' => 'A staged approach to upgrading an older Laravel application while protecting business logic, data and production reliability.',
                'content' => <<<'TEXT'
A Laravel modernization project should begin with an inventory of the current application:

## Assess the current application framework version, PHP version, Composer dependencies, database, queues, storage, authentication, integrations and deployment environment.

## Protect critical workflows

Identify critical workflows before changing dependencies. Sales posting, payment allocation, inventory movement or any other business-critical action should have automated tests or at least repeatable validation scenarios.

## Upgrade in controlled stages

Large version jumps are safer when handled in stages. Framework upgrade guides identify breaking changes, but custom packages and application assumptions often require additional work.

## Separate data risk from framework risk

Database migrations should be reviewed separately from code upgrades. A framework update does not automatically mean the database structure needs to change, and combining unrelated changes can make rollback more difficult.

After the technical foundation is stable, interface improvements can be introduced with clearer separation between presentation and business logic.

## Deploy with a rollback path

Production deployment should include backups, configuration review, cache rebuilds, queue restarts where relevant and a rollback plan.

Modernization is complete only when the application becomes easier to maintain after the upgrade. Documentation, tests and repeatable deployment are part of the result, not optional extras.
TEXT,
                'meta_title' => 'How to Modernize an Old Laravel Application | BusinessOS',
                'meta_description' => 'A practical Laravel modernization process covering dependency upgrades, testing, database safety, UI improvements, deployment and maintainability.',
            ],
            [
                'title' => 'What a Business Website Needs Before SEO Can Work',
                'slug' => 'business-website-seo-foundation',
                'category' => 'Website & SEO',
                'excerpt' => 'SEO starts with a useful, crawlable website: clear service pages, fast rendering, internal links, structured information and content worth finding.',
                'content' => <<<'TEXT'
Search optimization cannot compensate for a website that does not explain the business clearly.

## Start with useful service pages Before focusing on rankings, every important service needs a page that answers what the service is, who it is for and what problem it solves.

## Make the site crawlable

The site should be crawlable without requiring client-side JavaScript for primary content. Search engines need stable URLs, descriptive titles, canonical links and a sitemap that reflects the public pages.

## Build internal context

Internal linking helps users and crawlers understand relationships. A guide about data migration should link to the relevant migration service, and a product page should link to deeper explanations where they help the visitor.

## Protect performance

Performance affects usability. Large unoptimized images, unnecessary scripts and slow server responses can make an otherwise useful page frustrating to use.

## Add structured information

Structured data can clarify page type, organization information, articles, products and breadcrumbs. It should describe content that is genuinely visible on the page rather than adding claims only for crawlers.

## Build authority with evidence

Authority develops through original explanations, case studies, expert attribution and references from other trustworthy websites. Publishing many shallow pages is not a substitute for useful information.

## Use search data to improve content

Analytics and Search Console data should guide the next content decisions. Impressions without clicks may indicate poor titles or intent mismatch, while pages with growing queries may deserve deeper supporting content.
TEXT,
                'meta_title' => 'Business Website SEO Foundation: What to Build First | BusinessOS',
                'meta_description' => 'Learn the website foundations SEO depends on: useful service pages, crawlability, internal links, performance, structured data, authority and search measurement.',
            ],
        ];
    }
}
