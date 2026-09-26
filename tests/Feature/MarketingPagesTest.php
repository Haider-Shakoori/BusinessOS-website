<?php

namespace Tests\Feature;

use Tests\TestCase;

class MarketingPagesTest extends TestCase
{
    public function test_homepage_is_fast_renderable_and_contains_primary_products_and_services(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Build, modernize and run your business with better software.')
            ->assertSee('FieldPulse')
            ->assertSee('BusinessOS ERP')
            ->assertSee('BusinessOS POS')
            ->assertSee('Website Development')
            ->assertSee('Custom ERP &amp; MIS', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('BusinessOS — Custom ERP, MIS &amp; Business Software', false)
            ->assertSee('assets/brand/businessos-logo.svg', false)
            ->assertSee('id="services"', false)
            ->assertSee('id="products"', false)
            ->assertSee('id="solutions"', false)
            ->assertSee('id="why-businessos"', false)
            ->assertSee('modern-site professional-light calm-premium', false)
            ->assertSee('<meta name="theme-color" content="#ffffff">', false)
            ->assertSee('<meta name="color-scheme" content="light">', false)
            ->assertSee('ecosystem-scene', false)
            ->assertSee('ecosystem-console', false)
            ->assertSee('ecosystem-float-field', false)
            ->assertSee('ecosystem-float-erp', false)
            ->assertSee('ecosystem-float-pos', false)
            ->assertSee('ecosystem-product-grid', false)
            ->assertSee('ecosystem-solution-grid', false)
            ->assertSee('assets/css/businessos-calm.css', false)
            ->assertSee('Explore BusinessOS apps')
            ->assertSee('Explore all apps')
            ->assertDontSee('href="https://fieldpulse.businessos.af"', false)
            ->assertDontSee('href="https://erp.businessos.af"', false)
            ->assertDontSee('href="https://dukan.businessos.af"', false)
            ->assertDontSee('See FieldPulse in action')
            ->assertDontSee('Featured product')
            ->assertDontSee('businessos-3d.js', false);
    }

    public function test_services_page_is_public_and_search_ready(): void
    {
        $this->get('/services')
            ->assertOk()
            ->assertSee('Business software & digital solutions', false)
            ->assertSee('Website Development')
            ->assertSee('Custom ERP &amp; MIS', false)
            ->assertSee('Web Applications &amp; Portals', false)
            ->assertSee('Data Migration &amp; Cleanup', false)
            ->assertSee('Application Upgrades &amp; Modernization', false)
            ->assertSee('System Integration &amp; Data Exchange', false)
            ->assertSee('Workflow Automation &amp; Dashboards', false)
            ->assertSee('Database &amp; Information Systems', false)
            ->assertSee('application/ld+json', false);
    }

    public function test_app_directory_is_public_indexable_and_hides_direct_app_access(): void
    {
        $this->get('/apps')
            ->assertOk()
            ->assertSee('BusinessOS applications')
            ->assertSee('FieldPulse')
            ->assertSee('BusinessOS ERP')
            ->assertSee('BusinessOS POS')
            ->assertSee('Pharmacy Management System')
            ->assertSee('Raw Materials Database')
            ->assertSee('PVC Pipe Factory Management')
            ->assertSee('Financial Management Systems')
            ->assertDontSee('href="https://fieldpulse.businessos.af"', false)
            ->assertDontSee('href="https://erp.businessos.af"', false)
            ->assertDontSee('href="https://dukan.businessos.af"', false);
    }

    public function test_fieldpulse_has_a_dedicated_product_page_and_schema_without_direct_login(): void
    {
        $this->get('/apps/fieldpulse')
            ->assertOk()
            ->assertSee('<title>FieldPulse — Field Sales &amp; Field Force Software</title>', false)
            ->assertSee('Field sales tracking built for teams that work outside the office.')
            ->assertSee('SoftwareApplication')
            ->assertSee('Offline-first mobile operation')
            ->assertSee('app-preview-stage app-preview-fieldpulse', false)
            ->assertSee('Request a demo')
            ->assertDontSee('Open FieldPulse')
            ->assertDontSee('Live app: fieldpulse.businessos.af')
            ->assertDontSee('href="https://fieldpulse.businessos.af"', false);
    }

    public function test_erp_has_a_dedicated_product_page_without_direct_login(): void
    {
        $this->get('/apps/erp')
            ->assertOk()
            ->assertSee('<title>BusinessOS ERP — Sales, Invoicing, Payments &amp; Expenses</title>', false)
            ->assertSee('Keep customers, sales, payments and business records connected.')
            ->assertSee('Customer ledgers & statements')
            ->assertSee('Multi-business switching')
            ->assertSee('Request a demo')
            ->assertDontSee('Open BusinessOS ERP')
            ->assertDontSee('Live app: erp.businessos.af')
            ->assertDontSee('href="https://erp.businessos.af"', false);
    }

    public function test_pos_has_a_dedicated_product_page_and_modernization_status_without_direct_login(): void
    {
        $this->get('/apps/pos')
            ->assertOk()
            ->assertSee('Retail checkout and stock management built for everyday shop operations.')
            ->assertSee('AFN-only retail operation')
            ->assertSee('English, Dari & Pashto')
            ->assertSee('Pilot ready')
            ->assertSee('legacy pos.businessos.af installation is retained')
            ->assertDontSee('Afghanistan')
            ->assertSee('Request a demo')
            ->assertDontSee('Open BusinessOS POS')
            ->assertDontSee('Live app: dukan.businessos.af')
            ->assertDontSee('href="https://dukan.businessos.af"', false);
    }

    public function test_restaurant_management_is_for_waiter_table_ordering_not_customer_self_ordering(): void
    {
        $this->get('/apps/restaurant-management')
            ->assertOk()
            ->assertSee('Waiter mobile ordering')
            ->assertSee('Waiters select the table')
            ->assertSee('Kitchen stations &amp; KOT', false)
            ->assertSee('Transfer &amp; merge tables', false)
            ->assertSee('Split bills')
            ->assertSee('Waiter shifts &amp; accountability', false)
            ->assertSee('Void, cancellation &amp; complimentary controls', false)
            ->assertSee('Cashier closing')
            ->assertSee('Restaurant reporting')
            ->assertDontSee('customer mobile ordering', false);
    }

    public function test_demo_form_lists_all_businessos_products(): void
    {
        $this->get('/request-demo?app=erp')
            ->assertOk()
            ->assertSee('<option value="fieldpulse"', false)
            ->assertSee('<option value="erp"', false)
            ->assertSee('<option value="pos"', false)
            ->assertSee('<option value="pharmacy-management"', false)
            ->assertSee('<option value="raw-materials-db"', false)
            ->assertSee('<option value="pvc-pipe-factory"', false)
            ->assertSee('<option value="financial-systems"', false)
            ->assertSee('<option value="restaurant-management"', false)
            ->assertSee('BusinessOS ERP')
            ->assertSee('BusinessOS POS');
    }

    public function test_trust_pricing_and_conversion_pages_render(): void
    {
        $this->get('/pricing')->assertOk()->assertSee('Pricing that reflects the workflow');
        $this->get('/about')->assertOk()->assertSee('About BusinessOS');
        $this->get('/security')->assertOk()->assertSee('Security is part of the product design');
        $this->get('/privacy')->assertOk()->assertSee('BusinessOS Privacy Policy');
        $this->get('/terms')->assertOk()->assertSee('BusinessOS Website Terms of Use');
        $this->get('/contact')->assertOk()->assertSee('Tell us what you need to build, modernize or run better.');
        $this->get('/request-demo?app=fieldpulse')->assertOk()->assertSee('See how BusinessOS fits');
    }

    public function test_fieldpulse_includes_conversion_and_faq_content(): void
    {
        $this->get('/apps/fieldpulse')
            ->assertOk()
            ->assertSee('Request a demo')
            ->assertSee('Pricing in preparation')
            ->assertSee('FAQPage')
            ->assertSee('Is FieldPulse available as a finished public product?');
    }

    public function test_unknown_product_returns_not_found(): void
    {
        $this->get('/apps/not-a-real-product')->assertNotFound();
    }

    public function test_sitemap_exposes_core_search_pages_and_new_solution_pages(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('/services', false)
            ->assertSee('/apps/fieldpulse', false)
            ->assertSee('/apps/erp', false)
            ->assertSee('/apps/pos', false)
            ->assertSee('/apps/pharmacy-management', false)
            ->assertSee('/apps/raw-materials-db', false)
            ->assertSee('/apps/pvc-pipe-factory', false)
            ->assertSee('/apps/financial-systems', false)
            ->assertSee('/apps/restaurant-management', false)
            ->assertSee('/pricing', false)
            ->assertSee('/security', false)
            ->assertSee('/privacy', false);
    }

    public function test_localization_hreflang_and_security_headers_are_present(): void
    {
        $response = $this->get('/?lang=fa');

        $response
            ->assertOk()
            ->assertSee('dir="rtl"', false)
            ->assertSee('hreflang="fa-AF"', false)
            ->assertSee('نرم‌افزار', false)
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');

        $this->get('/?lang=ps')
            ->assertOk()
            ->assertSee('dir="rtl"', false)
            ->assertSee('ستاسو', false);
    }

    public function test_product_hreflang_is_exposed_for_fully_localized_products(): void
    {
        $this->get('/apps/fieldpulse?lang=fa')
            ->assertOk()
            ->assertSee('فعالیت تیم‌های ساحوی', false)
            ->assertSee('hreflang="fa-AF"', false)
            ->assertSee('hreflang="ps-AF"', false);

        $this->get('/apps/restaurant-management?lang=fa')
            ->assertOk()
            ->assertSee('Restaurant Management System')
            ->assertSee('سفارش موبایل گارسون', false)
            ->assertSee('<link rel="canonical" href="https://businessos.af/apps/restaurant-management?lang=fa">', false)
            ->assertSee('hreflang="fa-AF"', false)
            ->assertSee('hreflang="ps-AF"', false);
    }

    public function test_robots_allows_public_marketing_pages_and_points_to_sitemap(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('User-agent: *')
            ->assertSee('Sitemap:');
    }
}
