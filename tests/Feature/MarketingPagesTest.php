<?php

namespace Tests\Feature;

use Tests\TestCase;

class MarketingPagesTest extends TestCase
{
    public function test_homepage_is_fast_renderable_and_contains_primary_product(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Less friction.')
            ->assertSee('FieldPulse')
            ->assertSee('BusinessOS ERP')
            ->assertSee('BusinessOS POS')
            ->assertSee('erp.businessos.af')
            ->assertSee('pos.businessos.af')
            ->assertSee('application/ld+json', false)
            ->assertSee('id="products"', false)
            ->assertSee('id="solutions"', false)
            ->assertSee('id="why-businessos"', false)
            ->assertSee('class="modern-site professional-light calm-premium"', false)
            ->assertSee('<meta name="theme-color" content="#ffffff">', false)
            ->assertSee('<meta name="color-scheme" content="light">', false)
            ->assertSee('calm-hero-visual calm-hero-scene', false)
            ->assertSee('calm-depth-plane', false)
            ->assertSee('calm-window calm-window-3d', false)
            ->assertSee('calm-product-grid', false)
            ->assertSee('calm-bento', false)
            ->assertSee('assets/css/businessos-calm.css', false)
            ->assertDontSee('businessos-3d.js', false);
    }

    public function test_app_directory_is_public_and_indexable(): void
    {
        $this->get('/apps')
            ->assertOk()
            ->assertSee('BusinessOS applications')
            ->assertSee('FieldPulse')
            ->assertSee('https://fieldpulse.businessos.af', false)
            ->assertSee('fieldpulse.businessos.af')
            ->assertSee('BusinessOS ERP')
            ->assertSee('https://erp.businessos.af', false)
            ->assertSee('BusinessOS POS')
            ->assertSee('https://pos.businessos.af', false);
    }

    public function test_fieldpulse_has_a_dedicated_product_page_and_schema(): void
    {
        $this->get('/apps/fieldpulse')
            ->assertOk()
            ->assertSee('Field sales tracking built for teams that work outside the office.')
            ->assertSee('SoftwareApplication')
            ->assertSee('Offline-first mobile operation')
            ->assertSee('app-preview-stage app-preview-fieldpulse', false)
            ->assertSee('Open FieldPulse')
            ->assertSee('Live app: fieldpulse.businessos.af')
            ->assertSee('https://fieldpulse.businessos.af', false);
    }

    public function test_erp_has_a_dedicated_product_page_and_live_subdomain(): void
    {
        $this->get('/apps/erp')
            ->assertOk()
            ->assertSee('Keep customers, sales, payments and business records connected.')
            ->assertSee('Customer ledgers & statements')
            ->assertSee('Multi-business switching')
            ->assertSee('Open BusinessOS ERP')
            ->assertSee('Live app: erp.businessos.af')
            ->assertSee('https://erp.businessos.af', false);
    }

    public function test_pos_has_a_dedicated_product_page_and_modernization_status(): void
    {
        $this->get('/apps/pos')
            ->assertOk()
            ->assertSee('Retail checkout and stock management designed for Afghanistan.')
            ->assertSee('AFN-only retail operation')
            ->assertSee('English, Dari & Pashto')
            ->assertSee('Modernization in progress')
            ->assertSee('newer Laravel BusinessOS POS')
            ->assertSee('Open BusinessOS POS')
            ->assertSee('Live app: pos.businessos.af')
            ->assertSee('https://pos.businessos.af', false);
    }

    public function test_demo_form_lists_all_businessos_products(): void
    {
        $this->get('/request-demo?app=erp')
            ->assertOk()
            ->assertSee('<option value="fieldpulse"', false)
            ->assertSee('<option value="erp"', false)
            ->assertSee('<option value="pos"', false)
            ->assertSee('BusinessOS ERP')
            ->assertSee('BusinessOS POS');
    }

    public function test_trust_pricing_and_conversion_pages_render(): void
    {
        $this->get('/pricing')->assertOk()->assertSee('Pricing should match the product');
        $this->get('/about')->assertOk()->assertSee('About BusinessOS');
        $this->get('/security')->assertOk()->assertSee('Security is part of the product architecture');
        $this->get('/privacy')->assertOk()->assertSee('BusinessOS Privacy Policy');
        $this->get('/terms')->assertOk()->assertSee('BusinessOS Website Terms of Use');
        $this->get('/contact')->assertOk()->assertSee('Tell us what your business needs');
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

    public function test_sitemap_exposes_core_search_pages(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('/apps/fieldpulse', false)
            ->assertSee('/apps/erp', false)
            ->assertSee('/apps/pos', false)
            ->assertSee('/pricing', false)
            ->assertSee('/security', false)
            ->assertSee('/privacy', false);
    }

    public function test_robots_allows_public_marketing_pages_and_points_to_sitemap(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('User-agent: *')
            ->assertSee('Sitemap:');
    }
}
