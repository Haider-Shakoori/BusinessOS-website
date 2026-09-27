<?php

namespace Database\Seeders;

use App\Models\SeoPage;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class AfghanistanSearchAuthoritySeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->pages() as $page) {
            SeoPage::updateOrCreate(
                ['slug' => $page['slug']],
                [
                    ...$page,
                    'status' => 'published',
                    'published_at' => now(),
                ]
            );
        }

        $settings = [
            'seo_default_title' => 'BusinessOS Afghanistan — ERP, POS & Business Software',
            'seo_default_description' => 'BusinessOS provides ERP, POS, field sales, inventory, pharmacy, restaurant and custom business software for Afghanistan, with multilingual and offline-ready workflows.',
            'homepage_hero_eyebrow' => 'Business operating system & software for Afghanistan',
            'homepage_hero_title' => 'Business software built for Afghanistan — from ERP and POS to field operations.',
            'homepage_hero_description' => 'BusinessOS brings ERP, POS, field sales, inventory, finance and industry-specific software into a practical product family designed for Afghan businesses, including multilingual workflows and unreliable internet conditions.',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                [
                    'group' => str_starts_with($key, 'seo_') ? 'seo' : 'homepage',
                    'value' => $value,
                ]
            );
        }
    }

    private function pages(): array
    {
        return [
            [
                'title' => 'Business Operating System for Afghanistan',
                'slug' => 'business-operating-system-afghanistan',
                'eyebrow' => 'BusinessOS Afghanistan',
                'headline' => 'BusinessOS — a business operating system built around how Afghan companies actually work.',
                'excerpt' => 'Connect ERP, POS, field sales, inventory, finance and industry workflows through software designed for multilingual teams, local operations and unreliable connectivity.',
                'content' => <<<'TEXT'
A business operating system is not one oversized screen that tries to do everything. It is a connected software foundation that helps a company run core work with shared data, clear responsibilities and reliable workflows.

For businesses in Afghanistan, that foundation also needs to fit local realities: internet connectivity can be inconsistent, teams may work in English, Dari and Pashto, cash and branch operations remain important, and many companies need software that can grow from a focused tool into a broader ERP environment.

## What a business operating system means

A business operating system connects the activities that create the company's operational record. Depending on the business, this can include customers, products, inventory, sales, purchases, production, accounting, field visits, collections, employees, approvals and management reporting.

The goal is not to force every employee into every module. Each team should see the tools it needs while management receives a consistent view of what happened across the business.

## Why Afghanistan needs a different software approach

Business software designed only for stable broadband and always-online cloud access can create unnecessary risk for Afghan teams. Important transactions may happen in shops, warehouses, factories or field locations where mobile data is slow or temporarily unavailable.

A practical architecture should minimize unnecessary network calls, keep pages lightweight, cache appropriate reference data and support offline-capable mobile workflows where the business process requires them. Synchronization should preserve transaction identity and avoid silently duplicating records when connectivity returns.

## English, Dari and Pashto workflows

Language support is more than translating menu labels. A useful multilingual system needs readable right-to-left layouts, clear forms, printable documents and reports that remain understandable when users switch between English, Dari and Pashto.

BusinessOS products are designed with multilingual interfaces in mind so teams can work in the language that fits their role while the underlying business records remain consistent.

## ERP for the back office

BusinessOS ERP covers connected operational areas such as sales, purchasing, inventory, accounting, HR, production and management reporting. The system can be configured around the workflows a company actually uses rather than requiring every module on day one.

For manufacturers, the ERP layer can connect BOM planning, actual material consumption, finished-goods output, stock movements and production cost. For distributors and trading companies, the focus may instead be customers, purchases, stock, receivables, payments and sales.

## POS for retail operations

BusinessOS POS focuses on fast checkout, cashier responsibility, inventory movement, returns, discounts and daily closing. Retail users need a simple counter interface while owners and managers need the resulting sales and stock information to remain traceable.

A POS should be able to stand on its own for a smaller shop or connect with broader back-office workflows as the business grows.

## Field sales and distribution

FieldPulse by BusinessOS connects territories, customers, visits, orders, collections, follow-ups and supervisor visibility. Field teams often work where connectivity is unreliable, so the mobile workflow is designed around offline-first principles and later synchronization.

Location can help validate visits and customer coverage, but the useful business record is the combination of location, customer interaction, order, collection and follow-up outcome.

## Industry-specific systems

Some industries need workflows that general ERP screens do not express clearly. BusinessOS includes focused solutions for pharmacy management, restaurant operations, raw-material tracking, manufacturing and other custom business requirements.

The shared principle is to keep the industry workflow clear while preserving integration with inventory, finance, users, reporting and other relevant business data.

## One product family, not one forced interface

BusinessOS is a product family. A company can begin with the application that solves its immediate problem and expand when the business requires additional capabilities.

This approach keeps day-to-day interfaces focused while still creating a path toward a broader operating platform. ERP, POS, field sales and specialized applications can remain distinct experiences instead of becoming one crowded application.

## Data migration and integration

A new system is only useful when the starting data can be trusted. Customer records, products, stock, balances and other masters often need cleanup before migration from spreadsheets or legacy databases.

BusinessOS also supports integrations and application modernization where an existing system should be connected or upgraded rather than replaced completely.

## Who BusinessOS is designed for

BusinessOS is intended for businesses that need practical operational software rather than a generic website dashboard. Relevant use cases include retail, distribution, manufacturing, field sales, pharmacies, restaurants and organizations that need custom ERP or MIS workflows.

The architecture can be adapted to the size of the organization, the number of branches or users, connectivity conditions and the degree of process control required.

## A local-first implementation mindset

Software should reflect the real operating environment. For Afghanistan that means paying attention to performance, language, deployment constraints, offline continuity, straightforward training and maintainable workflows.

BusinessOS combines those concerns with modern web and mobile development so companies can digitize operations without assuming perfect infrastructure.
TEXT,
                'target_keywords' => [
                    'business operating system Afghanistan',
                    'BusinessOS Afghanistan',
                    'business management system Afghanistan',
                    'ERP Afghanistan',
                    'POS Afghanistan',
                    'offline business software Afghanistan',
                    'Dari Pashto business software',
                ],
                'related_product_slugs' => ['erp', 'pos', 'fieldpulse', 'pharmacy-management', 'restaurant-management'],
                'faq' => [
                    ['question' => 'What is a business operating system?', 'answer' => 'A business operating system is a connected software foundation for core operational workflows such as customers, sales, inventory, purchasing, finance, field work and reporting.'],
                    ['question' => 'Is BusinessOS an ERP?', 'answer' => 'BusinessOS includes an ERP product, but the BusinessOS product family is broader and also includes POS, field sales and industry-specific applications.'],
                    ['question' => 'Can BusinessOS work with unreliable internet?', 'answer' => 'BusinessOS is designed for low-bandwidth environments, and workflows that require continuity can use local or offline-first patterns with controlled synchronization when connectivity returns.'],
                    ['question' => 'Does BusinessOS support Dari and Pashto?', 'answer' => 'BusinessOS products are designed for multilingual operation, including English, Dari and Pashto where the product workflow requires localized interfaces.'],
                    ['question' => 'What types of Afghan businesses can use BusinessOS?', 'answer' => 'Relevant use cases include retail, distribution, manufacturing, field sales, pharmacies, restaurants and organizations that need custom ERP, MIS or operational software.'],
                ],
                'meta_title' => 'Business Operating System for Afghanistan | BusinessOS',
                'meta_description' => 'BusinessOS is a business operating system for Afghanistan connecting ERP, POS, field sales, inventory, finance and industry workflows with multilingual and offline-ready design.',
            ],
            [
                'title' => 'Business Software in Afghanistan',
                'slug' => 'business-software-afghanistan',
                'eyebrow' => 'Software for Afghan businesses',
                'headline' => 'Business software for Afghanistan: ERP, POS, field sales, inventory and custom systems.',
                'excerpt' => 'Choose business software around real Afghan operating conditions: multilingual teams, unreliable connectivity, local workflows, inventory control and practical implementation.',
                'content' => <<<'TEXT'
Business software in Afghanistan has to solve the same core problems found anywhere else — sales, inventory, purchasing, finance, employees and reporting — while also working within local infrastructure and language conditions.

The strongest system is not necessarily the one with the longest feature list. It is the one that fits the business process, stays usable for staff and preserves reliable data from day to day.

## Start with the workflow, not the software category

Before choosing ERP, POS, CRM, MIS or another label, identify the transactions that actually run the business. A retailer may need fast checkout and reliable stock. A distributor may care more about customer visits, orders, collections and receivables. A factory needs material planning, production consumption and costing.

Software selection becomes easier when those workflows are documented first.

## ERP software in Afghanistan

ERP is useful when several departments need to share the same operational data. Sales, purchasing, inventory, accounting, HR and production can then work from connected records instead of separate spreadsheets.

A good ERP implementation should still remain modular. Businesses should be able to introduce the processes they need without making every user navigate unrelated screens.

BusinessOS ERP is built around this practical approach, with configurable workflows for trading, distribution, manufacturing and other operational models.

## POS software for shops and supermarkets

Retail software should keep checkout fast while connecting every completed sale to controlled inventory movement. Cashier shifts, returns, discounts and daily closing also need clear responsibility.

BusinessOS POS is designed as a focused retail interface that can operate as a dedicated checkout system and connect with broader inventory or ERP workflows when required.

## Field sales software for distributors

Salesmen working outside the office need customer assignments, visit planning, orders, collections and follow-up history available from mobile devices.

FieldPulse by BusinessOS connects those activities with territory and supervisor visibility. Offline-first behavior is important because the salesman should not lose the ability to work simply because mobile internet is temporarily unavailable.

## Inventory management

Inventory software should explain why stock changed. Purchases, sales, transfers, production, returns and approved adjustments should create traceable movements instead of leaving management with an unexplained balance.

Warehouses, locations, units of measure and item identity become increasingly important as the organization grows.

## Pharmacy and restaurant software

Industry-specific workflows often need more than a generic ERP form. Pharmacy software may need batch and expiry control, while restaurant software may need waiter ordering, kitchen tickets, table workflow, billing and shift closing.

Focused BusinessOS applications keep those operational steps clear while still allowing the business to connect them with broader reporting and management processes.

## English, Dari and Pashto

Many Afghan teams use more than one language across management, finance, sales and operational staff. Business software should therefore consider translation quality, right-to-left layout, printed output and data-entry clarity.

BusinessOS supports multilingual product design so English, Dari and Pashto interfaces can be provided where required by the workflow.

## Plan for poor or unstable internet

Cloud software is useful, but a system should not make every important action depend on a perfect connection. Lightweight pages, efficient APIs, local caching and offline-capable mobile workflows can reduce disruption.

The correct offline strategy depends on the transaction. Some information can be cached safely, while writes such as sales, orders or collections need stable identifiers and controlled synchronization.

## Data migration matters

Moving from Excel or an older system should include cleanup, mapping and reconciliation. Duplicated customers, inconsistent product codes and unreliable opening balances can damage a new implementation if they are imported without review.

BusinessOS provides data-migration and modernization work alongside new application development so the transition can be planned rather than treated as a one-time file upload.

## Custom software when packaged systems do not fit

Some organizations have approval chains, production formulas, reporting requirements or field workflows that packaged software does not model well.

Custom development can be appropriate when those processes create real business value and cannot be handled cleanly through configuration. The goal should still be maintainability, clear permissions, auditability and reliable upgrades.

## How to evaluate a provider

Ask a software provider to explain the workflow, data model, backup approach, deployment method, offline behavior, user permissions and support process. A demo should show how a real transaction moves through the system instead of only presenting dashboard charts.

It is also useful to confirm how the system will handle future branches, users, integrations, languages and reporting requirements.

## BusinessOS in Afghanistan

BusinessOS develops business applications and custom systems for operational needs in Afghanistan. The product family includes ERP, POS, FieldPulse, pharmacy management, restaurant management and other focused solutions, alongside website development, integrations, data migration and application modernization.

The objective is practical software that remains understandable for users and maintainable for the organization as it grows.
TEXT,
                'target_keywords' => [
                    'business software in Afghanistan',
                    'business software Afghanistan',
                    'ERP software Afghanistan',
                    'POS software Afghanistan',
                    'inventory software Afghanistan',
                    'field sales software Afghanistan',
                    'custom software Afghanistan',
                ],
                'related_product_slugs' => ['erp', 'pos', 'fieldpulse', 'pharmacy-management', 'restaurant-management'],
                'faq' => [
                    ['question' => 'What business software is commonly needed in Afghanistan?', 'answer' => 'Common needs include ERP, POS, inventory, accounting, field sales, payroll, pharmacy, restaurant and custom workflow systems, depending on the organization.'],
                    ['question' => 'Should business software in Afghanistan work offline?', 'answer' => 'Important workflows should be designed for the connectivity conditions where they are used. Mobile field work and some branch operations can benefit from offline-first or local continuity with later synchronization.'],
                    ['question' => 'Can business software support Dari and Pashto?', 'answer' => 'Yes. A multilingual application can provide English, Dari and Pashto interfaces, including right-to-left layouts where required.'],
                    ['question' => 'What is the difference between ERP and POS?', 'answer' => 'POS focuses on checkout and retail transactions, while ERP connects broader business processes such as purchasing, inventory, accounting, HR and production. They can operate separately or integrate.'],
                    ['question' => 'Does BusinessOS build custom systems?', 'answer' => 'Yes. BusinessOS provides focused products as well as custom ERP, MIS, web applications, integrations, data migration and modernization for workflows that need a tailored solution.'],
                ],
                'meta_title' => 'Business Software in Afghanistan | ERP, POS & More | BusinessOS',
                'meta_description' => 'Business software in Afghanistan from BusinessOS: ERP, POS, field sales, inventory, pharmacy, restaurant and custom systems designed for local workflows and connectivity.',
            ],
        ];
    }
}
