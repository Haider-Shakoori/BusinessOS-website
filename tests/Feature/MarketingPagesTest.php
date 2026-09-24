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
            ->assertSee('Run the business.')
            ->assertSee('FieldPulse')
            ->assertSee('application/ld+json', false)
            ->assertSee('id="products"', false)
            ->assertSee('id="performance"', false);
    }

    public function test_app_directory_is_public_and_indexable(): void
    {
        $this->get('/apps')
            ->assertOk()
            ->assertSee('BusinessOS applications')
            ->assertSee('FieldPulse');
    }

    public function test_fieldpulse_has_a_dedicated_product_page_and_schema(): void
    {
        $this->get('/apps/fieldpulse')
            ->assertOk()
            ->assertSee('Field sales tracking built for teams that work outside the office.')
            ->assertSee('SoftwareApplication')
            ->assertSee('Offline-first mobile operation');
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
