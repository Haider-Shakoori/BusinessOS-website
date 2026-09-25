<?php

namespace Database\Seeders;

use App\Models\SeoPage;
use Illuminate\Database\Seeder;

class SeoPageSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->pages() as $page) {
            SeoPage::updateOrCreate(
                ['slug' => $page['slug']],
                [...$page, 'status' => 'published', 'published_at' => now()]
            );
        }
    }

    private function pages(): array
    {
        return [
            [
                'title' => 'Custom ERP Development',
                'slug' => 'custom-erp-development',
                'eyebrow' => 'ERP development services',
                'headline' => 'Custom ERP software built around the way your business actually operates.',
                'excerpt' => 'Design and develop a tailored ERP that connects sales, purchasing, inventory, production, finance, HR, approvals and reporting without forcing your organization into an unsuitable generic workflow.',
                'content' => <<<'TEXT'
Custom ERP development is useful when the business process itself is a competitive or operational requirement and standard software creates too many workarounds. The first step is not choosing modules. It is mapping how orders, purchasing, stock, production, approvals, money and reporting move through the organization today.

A BusinessOS ERP project can start with a narrow scope such as inventory and purchasing, then expand into sales, production, finance or human resources. This reduces implementation risk and lets the organization validate the most important workflows before adding more complexity.

Data design is central to ERP quality. Customers, suppliers, products, materials, warehouses, accounts and transactions need consistent definitions so reports can be trusted. Where existing spreadsheets or databases are involved, migration should include mapping, cleanup, validation and reconciliation rather than a simple copy.

Permissions and approvals should follow business responsibility. A useful ERP makes it clear who can create, approve, reverse or close an operational transaction and keeps a traceable record of important changes.

Reporting should answer real management questions. Instead of creating dozens of unused reports, the implementation should identify the financial and operational decisions managers make repeatedly and ensure the required data is captured accurately at the source.

BusinessOS builds Laravel-based ERP systems with responsive interfaces, APIs, role-based access and maintainable architecture. The result can be hosted by BusinessOS or deployed privately depending on the organization’s requirements.
TEXT,
                'target_keywords' => ['custom ERP', 'ERP development', 'ERP software development', 'tailored ERP', 'business management software'],
                'related_product_slugs' => ['erp', 'financial-systems', 'raw-materials-db'],
                'faq' => [
                    ['question' => 'When is a custom ERP better than an off-the-shelf ERP?', 'answer' => 'Custom ERP is most useful when important workflows, approvals, reporting or integrations cannot be represented cleanly in standard software without repeated workarounds.'],
                    ['question' => 'Can a custom ERP be implemented module by module?', 'answer' => 'Yes. A phased rollout can begin with the highest-value workflow and add modules after the core data and processes are validated.'],
                    ['question' => 'Can existing ERP or spreadsheet data be migrated?', 'answer' => 'Yes. Migration can include source review, field mapping, cleanup, validation, import and reconciliation.'],
                ],
                'meta_title' => 'Custom ERP Development Services | BusinessOS',
                'meta_description' => 'BusinessOS develops custom ERP systems for sales, inventory, procurement, production, finance, HR, approvals, reporting and business-specific workflows.',
            ],
            [
                'title' => 'MIS Development',
                'slug' => 'mis-development',
                'eyebrow' => 'Management information systems',
                'headline' => 'Management information systems that turn operational data into decisions.',
                'excerpt' => 'Build a custom MIS for dashboards, KPIs, approvals, operational reporting and management visibility across departments and business units.',
                'content' => <<<'TEXT'
A management information system should help decision-makers understand what is happening without requiring them to combine reports manually from several departments. The goal is not to create a dashboard with many charts. The goal is to define the questions management needs answered and make the underlying data dependable.

MIS projects usually begin by identifying decision areas such as sales performance, cash position, inventory exposure, procurement status, production output, attendance, receivables or project progress. Each metric needs a clear definition, source and reporting period.

Where data already exists across ERP systems, spreadsheets or databases, the MIS can integrate those sources instead of replacing everything. The design should make data ownership and refresh rules explicit so managers know whether a number is live, daily, monthly or manually confirmed.

Role-based dashboards are often more useful than a universal dashboard. Senior management may need consolidated indicators while department heads need detailed exceptions and operational follow-up.

BusinessOS can build a standalone MIS or add management dashboards and reporting layers to an existing application. Integrations can use APIs, scheduled imports, database connections or approved file-based workflows depending on the source systems.

A useful MIS creates one agreed interpretation of important indicators and makes exceptions easier to see. It should reduce repeated report preparation, not create a new reporting workload.
TEXT,
                'target_keywords' => ['MIS development', 'management information system', 'MIS software', 'management dashboard', 'business reporting system'],
                'related_product_slugs' => ['erp', 'financial-systems', 'fieldpulse'],
                'faq' => [
                    ['question' => 'What is the difference between an MIS and an ERP?', 'answer' => 'ERP systems usually execute and record business transactions. An MIS focuses more heavily on organizing operational information for monitoring, analysis and management decisions. They can work together.'],
                    ['question' => 'Can an MIS use data from existing systems?', 'answer' => 'Yes. An MIS can integrate data from databases, APIs, spreadsheets and other approved sources without replacing every operational application.'],
                    ['question' => 'Can different managers see different dashboards?', 'answer' => 'Yes. Access, KPIs and detail levels can be configured by role, department or business unit.'],
                ],
                'meta_title' => 'Custom MIS Development & Management Dashboards | BusinessOS',
                'meta_description' => 'Build a custom management information system for KPIs, dashboards, approvals, reporting and management visibility across business operations.',
            ],
            [
                'title' => 'Website Development in Afghanistan',
                'slug' => 'website-development-afghanistan',
                'eyebrow' => 'Web development',
                'headline' => 'Modern business websites designed for Afghanistan and international audiences.',
                'excerpt' => 'Business website development with responsive design, multilingual content, SEO foundations, CMS, performance optimization and maintainable Laravel or WordPress architecture.',
                'content' => <<<'TEXT'
A business website should explain what the company does clearly, load reliably on real networks and make it easy for customers or partners to take the next step. For organizations in Afghanistan, multilingual content, mobile usability and efficient page delivery can be especially important.

BusinessOS develops company websites, service websites, product sites, portals and content-managed websites. The technology choice depends on the project. A content-focused site may fit WordPress, while a custom portal or software-connected website may be better served by Laravel.

Search visibility starts with structure. Each important service should have a useful page with a clear title, heading, description, internal links and enough original information to answer the visitor’s question. Technical SEO, sitemap generation, canonical URLs and structured data support discovery but cannot replace useful content.

English, Dari and Pashto can be implemented with correct directionality and language-specific metadata. Translation should preserve the business meaning rather than simply duplicate English keywords.

Performance matters for both users and search systems. Images should be compressed and sized appropriately, unnecessary JavaScript should be avoided, and server-side rendering or caching should be used where it improves reliability.

BusinessOS can also modernize an existing website, migrate content, improve search structure, connect forms to internal systems and build custom administration where ordinary CMS functionality is not enough.
TEXT,
                'target_keywords' => ['website development Afghanistan', 'web development Kabul', 'business website Afghanistan', 'Laravel development Afghanistan', 'multilingual website development'],
                'related_product_slugs' => [],
                'faq' => [
                    ['question' => 'Can BusinessOS build websites in English, Dari and Pashto?', 'answer' => 'Yes. Multilingual interfaces can support English, Dari and Pashto with right-to-left presentation where appropriate.'],
                    ['question' => 'Do you use Laravel or WordPress?', 'answer' => 'Both can be appropriate. The choice depends on whether the project is primarily content publishing or requires custom application logic, integrations and workflows.'],
                    ['question' => 'Can an existing website be redesigned without losing its content?', 'answer' => 'Yes. Existing content, URLs and search considerations can be reviewed as part of a staged redesign or migration.'],
                ],
                'meta_title' => 'Website Development in Afghanistan | BusinessOS',
                'meta_description' => 'BusinessOS builds responsive, multilingual, SEO-ready business websites and web applications for organizations in Afghanistan and international markets.',
            ],
            [
                'title' => 'Data Migration Services',
                'slug' => 'data-migration-services',
                'eyebrow' => 'Data migration & cleanup',
                'headline' => 'Move business data without losing the meaning behind the records.',
                'excerpt' => 'Migrate customers, products, inventory, transactions, balances and operational data from Excel, legacy databases and older applications into modern systems.',
                'content' => <<<'TEXT'
Data migration is not simply importing rows into a new database. Business records often contain duplicated names, inconsistent codes, missing values, historical exceptions and relationships that are understood by staff but not documented in the source file.

A migration should begin with source discovery. The team identifies the files, databases and tables that matter, the time periods that need to be retained and which records are authoritative when sources disagree.

Mapping comes next. Each source field is assigned to a destination field with transformation rules for dates, currencies, units, identifiers, categories and relationships. This is also the right time to decide what should not be migrated.

Validation is essential. Record counts, totals, opening balances, stock quantities and key relationships should be compared before and after import. Financial and inventory migrations may require additional reconciliation because an apparently small mapping error can affect later reporting.

For large or active systems, migration may need rehearsal. A test import exposes problems early and helps estimate the final cutover process. The live migration can then focus on the remaining delta and final verification.

BusinessOS can migrate data into new BusinessOS systems or support modernization projects involving Laravel, MySQL and other structured sources. The exact approach depends on the quality, volume and business importance of the source data.
TEXT,
                'target_keywords' => ['data migration services', 'Excel to ERP migration', 'database migration', 'legacy system migration', 'business data cleanup'],
                'related_product_slugs' => ['erp', 'raw-materials-db', 'financial-systems'],
                'faq' => [
                    ['question' => 'Can you migrate data from Excel into an ERP?', 'answer' => 'Yes. Spreadsheet migration can include cleanup, mapping, transformation, validation and reconciliation before the data is accepted into the new system.'],
                    ['question' => 'Do we have to migrate every historical record?', 'answer' => 'No. The retention scope should be decided based on operational, reporting and compliance needs. Old data can sometimes remain in an archive.'],
                    ['question' => 'How do you verify a migration?', 'answer' => 'Verification can compare record counts, financial totals, stock quantities, relationships and selected sample records between source and destination.'],
                ],
                'meta_title' => 'Data Migration Services — Excel, Databases & Legacy Systems | BusinessOS',
                'meta_description' => 'BusinessOS migrates and cleans business data from Excel, legacy databases and older applications into modern ERP, web and information systems.',
            ],
            [
                'title' => 'Legacy Application Modernization',
                'slug' => 'legacy-application-modernization',
                'eyebrow' => 'Application upgrades',
                'headline' => 'Modernize older business applications without discarding valuable business logic.',
                'excerpt' => 'Upgrade legacy PHP and Laravel applications, supported framework versions, interfaces, database structures, security controls and deployment practices.',
                'content' => <<<'TEXT'
An older application may contain years of useful business rules even when its framework, interface or deployment process has become difficult to maintain. Replacing the entire application is not always the safest option.

Modernization begins with an assessment of the codebase, dependencies, database, authentication, integrations, hosting environment and critical workflows. The objective is to separate technical risk from business functionality that should be preserved.

Framework upgrades should be staged when the version gap is large. Dependency changes, removed APIs and database behavior can affect the application even when the visible interface appears unchanged. Automated tests around important workflows reduce the risk of silent regressions.

Interface modernization can happen alongside or after the technical upgrade. Responsive layouts, clearer navigation and faster workflows can improve usability without changing the underlying business rules unnecessarily.

Security work may include dependency updates, password and session handling, authorization review, validation, storage permissions and production configuration. Deployment can also be improved with environment separation, repeatable builds and safer release steps.

BusinessOS focuses on Laravel and PHP modernization but can also help extract data or functionality from systems that need a more complete rebuild. The correct approach depends on the condition of the current application and how much of it remains valuable.
TEXT,
                'target_keywords' => ['legacy application modernization', 'Laravel upgrade service', 'PHP application upgrade', 'software modernization', 'legacy system upgrade'],
                'related_product_slugs' => ['erp'],
                'faq' => [
                    ['question' => 'Should an old application always be rebuilt from scratch?', 'answer' => 'No. If the business logic and data model are still valuable, a staged upgrade or modernization can be lower risk than a complete rewrite.'],
                    ['question' => 'Can you upgrade old Laravel versions?', 'answer' => 'Yes. The upgrade path depends on the current version, dependencies, tests and custom code. Large version gaps are usually handled in controlled stages.'],
                    ['question' => 'Can the interface be redesigned while keeping the existing database?', 'answer' => 'Often yes. The feasibility depends on the quality of the current data model and how tightly the old interface is coupled to application logic.'],
                ],
                'meta_title' => 'Legacy Application Modernization & Laravel Upgrade Services | BusinessOS',
                'meta_description' => 'Modernize legacy PHP and Laravel applications with framework upgrades, security improvements, responsive UI, database review and safer deployment.',
            ],
            [
                'title' => 'Manufacturing ERP',
                'slug' => 'manufacturing-erp',
                'eyebrow' => 'Factory software',
                'headline' => 'Manufacturing ERP that connects materials, production, costing and finished stock.',
                'excerpt' => 'Build manufacturing workflows for BOMs or formulations, production planning, actual material consumption, wastage, warehouses, costing, quality and sales.',
                'content' => <<<'TEXT'
Manufacturing software becomes useful when planned production, actual material consumption and finished output can be compared using the same product and material definitions. If each department keeps separate spreadsheets, management may know the sales value without knowing the real production cost.

A manufacturing ERP typically begins with master data: raw materials, units, warehouses, finished products and bills of materials or formulations. The BOM should represent the standard expectation, while production execution records what was actually consumed.

Production variance is important because actual usage can differ from standard usage. The system should preserve both values rather than rewriting the plan after production is complete. This makes wastage, yield and costing differences visible.

Inventory needs to move with operations. Raw material receipts increase stock, transfers move it between locations, production consumption reduces it and completed production creates finished goods. Each movement should remain traceable to the business event that caused it.

Costing rules depend on the factory. Material rates, landed costs, labor, overhead, work percentages and wastage may all matter. The software should state the costing method clearly so profit reports are understandable.

BusinessOS manufacturing implementations can connect procurement, production, warehouses, sales and finance while remaining configurable for industry-specific measurements and approval steps.
TEXT,
                'target_keywords' => ['manufacturing ERP', 'factory ERP', 'production management software', 'BOM software', 'manufacturing inventory system'],
                'related_product_slugs' => ['pvc-pipe-factory', 'raw-materials-db', 'financial-systems'],
                'faq' => [
                    ['question' => 'Can manufacturing ERP compare planned and actual material use?', 'answer' => 'Yes. Standard or planned consumption can be retained and compared with actual production usage to calculate variance.'],
                    ['question' => 'Can the system support BOMs and formulations?', 'answer' => 'Yes. The structure can support discrete BOMs, formulations or other standard material recipes depending on the production process.'],
                    ['question' => 'Can production connect directly to inventory?', 'answer' => 'Yes. Material consumption and finished production can create traceable inventory movements when the workflow is configured that way.'],
                ],
                'meta_title' => 'Manufacturing ERP — Production, BOM, Inventory & Costing | BusinessOS',
                'meta_description' => 'Custom manufacturing ERP for BOMs, production planning, material consumption, wastage, finished goods, inventory, costing and factory reporting.',
            ],
            [
                'title' => 'Pharmacy Management Software',
                'slug' => 'pharmacy-management-software',
                'eyebrow' => 'Pharmacy software',
                'headline' => 'Pharmacy software for medicine stock, expiry, purchasing, sales and financial visibility.',
                'excerpt' => 'Manage medicine inventory, batch and expiry information, suppliers, purchasing, sales, receivables and pharmacy reporting in one configurable system.',
                'content' => <<<'TEXT'
Pharmacy inventory has additional operational questions beyond ordinary retail stock. The team may need to know not only how many units are available, but which batch they belong to, when they expire and which supplier provided them.

A structured medicine master reduces inconsistent naming and makes product lookup more reliable. Units, packaging and categories should be defined carefully because purchasing and sales may occur at different pack levels.

Batch and expiry data should be captured when stock enters the business if those controls are required. Reports can then identify stock approaching expiry so staff can review it before it becomes a loss.

Purchasing should connect suppliers, incoming quantities and purchase rates to inventory. Sales should reduce stock through controlled transactions, while customer balances and payments can be included where pharmacies sell on account.

Management reporting can combine stock, purchases, sales, receivables and expiry exposure. Permissions should separate cashier, store, purchasing and management responsibilities where the organization needs those controls.

BusinessOS pharmacy software is customizable because medicine catalogs, units, reporting and commercial workflows differ between organizations. Existing product and supplier lists can also be migrated after source data is reviewed.
TEXT,
                'target_keywords' => ['pharmacy management software', 'pharmacy inventory software', 'medicine expiry tracking', 'pharmacy system', 'pharmacy ERP'],
                'related_product_slugs' => ['pharmacy-management', 'financial-systems'],
                'faq' => [
                    ['question' => 'Can pharmacy software track batches and expiry dates?', 'answer' => 'Yes. Batch and expiry information can be captured with incoming stock and reported for operational review.'],
                    ['question' => 'Can medicine data be imported from Excel?', 'answer' => 'Yes. Existing medicine, supplier and stock lists can be cleaned, mapped and imported after the source structure is reviewed.'],
                    ['question' => 'Can pharmacy sales and receivables be connected?', 'answer' => 'Yes. The system can combine stock deduction, sales history, customer balances and payments when required.'],
                ],
                'meta_title' => 'Pharmacy Management Software — Inventory, Expiry & Sales | BusinessOS',
                'meta_description' => 'Custom pharmacy management software for medicine inventory, batch and expiry tracking, suppliers, purchasing, sales, receivables and reporting.',
            ],
            [
                'title' => 'ERP Software in Afghanistan',
                'slug' => 'erp-software-afghanistan',
                'eyebrow' => 'Business software for Afghanistan',
                'headline' => 'ERP software adapted to the operational realities of businesses in Afghanistan.',
                'excerpt' => 'Customizable ERP for sales, purchasing, inventory, production, finance and management reporting with AFN, local workflows and multilingual interfaces where required.',
                'content' => <<<'TEXT'
Organizations in Afghanistan often need the same core controls as businesses elsewhere—sales, purchasing, inventory, finance and reporting—but implementation details can differ. Currency, language, connectivity, approval practices and existing spreadsheet-based workflows should be considered from the beginning.

ERP selection should start with the operating model rather than a software feature list. A trading business, factory, distributor and service company may all need inventory or accounting, but the transactions and reports behind those modules are different.

BusinessOS ERP implementations can use AFN as an operating currency and support English, Dari and Pashto interfaces where the project requires localization. Low-bandwidth and mobile access can also influence interface and synchronization decisions.

Many ERP projects begin with data already stored in Excel. Customer lists, supplier records, opening balances, product masters and stock quantities should be cleaned and reconciled before import so the new system does not inherit every problem from the old files.

Deployment can be hosted or private depending on the project. Access controls, backups and operational support should be agreed before launch instead of treated as an afterthought.

The objective is not simply to replace paper or spreadsheets. A successful ERP implementation should make transactions more consistent and give management a clearer, traceable view of the business.
TEXT,
                'target_keywords' => ['ERP software Afghanistan', 'ERP Afghanistan', 'business software Afghanistan', 'ERP Kabul', 'Afghanistan inventory software'],
                'related_product_slugs' => ['erp', 'financial-systems', 'pos'],
                'faq' => [
                    ['question' => 'Can ERP software support AFN?', 'answer' => 'Yes. BusinessOS implementations can be configured around AFN and the currency requirements of the organization.'],
                    ['question' => 'Can the interface support Dari and Pashto?', 'answer' => 'Yes. English, Dari and Pashto interfaces with right-to-left presentation can be implemented where required.'],
                    ['question' => 'Can an ERP be deployed for a factory as well as a trading business?', 'answer' => 'Yes. The modules and workflows should be configured differently for manufacturing, trading, retail or service operations.'],
                ],
                'meta_title' => 'ERP Software in Afghanistan — Custom Business Management | BusinessOS',
                'meta_description' => 'BusinessOS provides customizable ERP software in Afghanistan for sales, purchasing, inventory, production, finance and management reporting.',
            ],
            [
                'title' => 'Restaurant Management Software',
                'slug' => 'restaurant-management-software',
                'eyebrow' => 'Restaurant software & waiter ordering',
                'headline' => 'Restaurant management software that lets waiters take table orders on mobile and send them directly to the kitchen.',
                'excerpt' => 'Connect waiter mobile ordering with tables, menu control, kitchen preparation, billing, payments and restaurant reporting in one internal system.',
                'content' => <<<'TEXT'
Restaurant management software should make table service faster without disconnecting waiters from the kitchen or cashier. In the BusinessOS model, the mobile ordering app is used by restaurant waiters—not by outside customers.

A waiter opens the assigned table on the mobile app, selects menu items, adds quantities or notes and submits the order while still serving the table. The order then appears immediately in the restaurant dashboard and kitchen queue with the table number and the details needed for preparation.

The kitchen workflow should have a clear order lifecycle. Common states include new, accepted, preparing, ready, served, completed or cancelled. Waiters and supervisors can see the current status without repeatedly walking to the kitchen to ask whether an order is ready.

Menu management remains centralized. Prices, categories, item availability, modifiers and add-ons can be controlled by authorized restaurant staff so every waiter device uses the current menu.

Table management can connect the active order to the table and responsible waiter. Additional items can be added to the same table during service, and the final bill can be produced from the complete order history rather than combining handwritten tickets.

Billing and payments should remain connected to the table order. Depending on restaurant requirements, the system can support discounts, payment recording, split bills, order adjustments and cashier controls.

Kitchen display views can reduce paper tickets by showing incoming orders and preparation status directly to kitchen staff. If the restaurant prefers printed kitchen tickets, that workflow can also be integrated.

BusinessOS Restaurant Management System is designed as an internal restaurant operations platform: waiter mobile app for order entry, kitchen workflow for preparation, and web administration for menu, tables, billing, users and reporting.
TEXT,
                'target_keywords' => ['restaurant management software', 'waiter ordering app', 'restaurant waiter app', 'table ordering system', 'kitchen order management', 'restaurant POS and kitchen system'],
                'related_product_slugs' => ['restaurant-management', 'financial-systems'],
                'faq' => [
                    ['question' => 'Who uses the mobile ordering app?', 'answer' => 'The app is used by restaurant waiters. They take customer orders at the table and send them directly into the restaurant and kitchen workflow.'],
                    ['question' => 'How does the kitchen receive waiter orders?', 'answer' => 'Submitted orders can appear immediately in a kitchen queue or kitchen display with the table number, items, quantities, notes and preparation status.'],
                    ['question' => 'Can waiters add more items to an existing table order?', 'answer' => 'Yes. The system can keep an active table order open so additional items can be added during service before billing is completed.'],
                    ['question' => 'Can the system track tables and waiter assignments?', 'answer' => 'Yes. Tables, active orders and waiter responsibility can be connected so staff and managers can see the current service state.'],
                ],
                'meta_title' => 'Restaurant Management Software with Waiter Mobile Ordering | BusinessOS',
                'meta_description' => 'Restaurant management software with waiter mobile ordering, table management, kitchen workflow, menu control, billing, payments and reporting.',
            ],
        ];
    }
}
