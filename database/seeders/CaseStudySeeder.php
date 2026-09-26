<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use Illuminate\Database\Seeder;

class CaseStudySeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->caseStudies() as $caseStudy) {
            CaseStudy::updateOrCreate(
                ['slug' => $caseStudy['slug']],
                $caseStudy
            );
        }
    }

    private function caseStudies(): array
    {
        return [
            [
                'title' => 'Corrugated Carton Manufacturing ERP: From BOM Planning to Actual Production Cost',
                'slug' => 'corrugated-carton-manufacturing-erp',
                'industry' => 'Manufacturing / Corrugated Cartons',
                'summary' => 'A custom manufacturing ERP connects carton BOMs, raw-material stock, quotation costing, production planning, actual consumption, business-unit separation and realized production cost.',
                'challenge' => <<<'TEXT'
Corrugated-carton production depends on dimensions, paper GSM, layers, material rates and production quantities. Planning values are useful for quotation and preparation, but the business also needs to know what material production actually consumed and how that changes realized cost and profit.

The system also had to keep different operating businesses separated without losing shared master data or making staff maintain disconnected applications. BOM screens, stock, production and reporting therefore needed clear business-unit context.
TEXT,
                'solution' => <<<'TEXT'
The ERP implementation formalized BOM-driven material planning while preserving stock units and raw-material identities. BOM screens were made business-unit aware, and production completion captures actual quantities instead of replacing the original plan.

Actual material consumption remains separate from planned consumption so production variance can be reviewed. Realized profit is recalculated from approved actual usage rather than assuming the standard BOM was consumed exactly.

Production completion, BOM behavior and quantity handling are protected by regression tests, including the real-world carton workflow and actual-production-quantity UI contract.
TEXT,
                'outcome' => <<<'TEXT'
The resulting workflow preserves both the planning baseline and the execution record. Management can compare planned versus actual production, trace material usage into stock, and see realized production economics without deleting the standard BOM reference.

The latest implementation also includes a production-completion fix that ensures the submitted actual production quantity reaches the server correctly and remains covered by automated tests.
TEXT,
                'meta_title' => 'Corrugated Carton Manufacturing ERP Case Study | BusinessOS',
                'meta_description' => 'Case study of a custom corrugated-carton ERP connecting BOM planning, actual material consumption, stock, production quantity, business units and realized costing.',
                'status' => 'published',
                'published_at' => '2026-09-26 00:00:00',
            ],
            [
                'title' => 'FieldPulse: Building a Web + Mobile Field Sales Operations Platform',
                'slug' => 'fieldpulse-field-sales-platform',
                'industry' => 'Field Sales / Distribution',
                'summary' => 'FieldPulse combines a Laravel web platform and Flutter mobile app for customer visits, territories, attendance, collections, field activity and offline-capable mobile workflows.',
                'challenge' => <<<'TEXT'
Field sales work happens away from the office, so managers need more than end-of-day summaries. The system needed to connect people, customers, territories, attendance and field actions while remaining usable when mobile connectivity is unreliable.

Location data also needed to be operational rather than decorative: customer coordinates, salesman locations and territory boundaries had to be manageable through maps instead of forcing administrators to type raw latitude, longitude or geofence data.
TEXT,
                'solution' => <<<'TEXT'
The web application added salesman attendance and worked-hours reporting, map-selected user locations, map-based territory drawing and editing, and an overview map that can show stored territories together.

The Flutter application uses offline-capable workflows and includes queued visit data. One implemented example is offline visit voice notes: recording, local persistence and later synchronization are covered in the mobile codebase.

Collections, expenses and order-status actions were also hardened so important state changes are atomic and secondary notification failures do not incorrectly surface as HTTP 500 errors after a successful confirmation.
TEXT,
                'outcome' => <<<'TEXT'
FieldPulse now has a connected web-and-mobile operating model: managers can work with territories and attendance in the web application while salesmen use mobile field workflows that can tolerate connectivity interruptions.

Recent reliability work reduced the risk of successful collection, expense or order actions being reported to users as server failures because of non-critical notification problems.
TEXT,
                'meta_title' => 'FieldPulse Field Sales Platform Case Study | BusinessOS',
                'meta_description' => 'Case study of FieldPulse, a Laravel and Flutter field-sales platform with territories, maps, attendance, collections and offline-capable mobile workflows.',
                'status' => 'published',
                'published_at' => '2026-09-26 00:10:00',
            ],
            [
                'title' => 'BusinessOS POS: Full-Screen Multilingual Retail Checkout',
                'slug' => 'businessos-pos-retail-checkout',
                'industry' => 'Retail / Supermarket',
                'summary' => 'A retail POS was redesigned into a focused cashier workspace with multilingual screens, role controls, shift awareness and immediate post-sale receipt printing.',
                'challenge' => <<<'TEXT'
A cashier-facing POS needs speed and screen space. Traditional application navigation can compete with the cart, product catalog and checkout controls, while missing post-sale receipt handling forces staff into extra steps after each transaction.

The product also needed English, Dari and Pashto interfaces, right-to-left behavior where required, role permissions and clear cashier-shift state.
TEXT,
                'solution' => <<<'TEXT'
The POS was redesigned into an immersive cashier workspace that keeps products, cart and checkout actions central. A full-screen POS shell with an in-app menu gives the sale interface more usable space without removing access to the rest of the application.

Checkout now returns receipt URLs and presents a printable receipt immediately after a sale, including embedded receipt preview support inside the POS workspace.

Role and permission administration was added with protected built-in roles and auditing. The language UX was changed from a locale cycle into explicit English, Dari and Pashto selection while preserving authorization, locale persistence, RTL behavior and financial logic.
TEXT,
                'outcome' => <<<'TEXT'
The POS now supports a faster cashier-oriented interaction model with explicit shift state and immediate receipt handling after checkout.

The role, permission and language work was validated through automated workflow tests, including checkout, receipt, permissions and multilingual behavior.
TEXT,
                'meta_title' => 'Afghanistan Retail POS Modernization Case Study | BusinessOS',
                'meta_description' => 'Case study of BusinessOS POS: full-screen Laravel checkout, receipt printing, cashier shifts, permissions and English/Dari/Pashto retail UX.',
                'status' => 'published',
                'published_at' => '2026-09-26 00:20:00',
            ],
            [
                'title' => 'Localized E-commerce Storefront Modernization',
                'slug' => 'localized-ecommerce-storefront-modernization',
                'industry' => 'E-commerce / Fashion',
                'summary' => 'An existing storefront was reworked with localized content, SEO controls, legacy URL migration, closer visual alignment and safer release checks.',
                'challenge' => <<<'TEXT'
The storefront needed to align closely with an established live brand rather than merely approximate its layout. At the same time, the implementation had to support localized content and search metadata without losing legacy URLs or introducing fragile manual page edits.

The project therefore combined visual migration, content management, search visibility and application safety rather than treating the storefront as a static redesign.
TEXT,
                'solution' => <<<'TEXT'
The implementation added localized content management, structured search metadata, sitemap coverage, legacy URL migration, controlled publishing and safer product-detail mapping.

A later alignment pass brought the storefront closer to the live visual reference using the actual branding, imagery and catalog media. English, Dari and Pashto language resources were maintained alongside regression tests for catalog behavior and live-site asset alignment.
TEXT,
                'outcome' => <<<'TEXT'
The storefront moved from a generic implementation toward a maintainable localized application that preserves the established visual identity while making content and SEO manageable inside the system.

Both the localized SEO/CMS work and the live-site alignment work were completed with green feature and pull-request validation in the project repository, without making unverified claims about commercial conversion or traffic impact.
TEXT,
                'meta_title' => 'Localized E-commerce Modernization Case Study | BusinessOS',
                'meta_description' => 'Case study of an e-commerce modernization with localized content management, search optimization, legacy URL migration, visual alignment and release validation.',
                'status' => 'published',
                'published_at' => '2026-09-26 00:30:00',
            ],
        ];
    }
}
