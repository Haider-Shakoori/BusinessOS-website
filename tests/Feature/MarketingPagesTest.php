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
            ->assertSee('application/ld+json', false)\n            ->assertSee('id=\"products\"', false)\n            ->assertSee('id=\"performance\"', false);
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

    public function test_unknown_product_returns_not_found(): void
    {
        $this->get('/apps/not-a-real-product')->assertNotFound();
    }

    public function test_sitemap_exposes_core_search_pages(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('/apps/fieldpulse', false);
    }

    public function test_robots_allows_public_marketing_pages_and_points_to_sitemap(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('User-agent: *')
            ->assertSee('Sitemap:');
    }
}
