<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketingExpansionTest extends TestCase
{
    use RefreshDatabase;

    public function test_services_page_describes_custom_software_capabilities(): void
    {
        $this->get('/services')
            ->assertOk()
            ->assertSee('Website Development')
            ->assertSee('Custom ERP &amp; MIS', false)
            ->assertSee('Data Migration &amp; Cleanup', false)
            ->assertSee('Application Upgrades &amp; Modernization', false);
    }

    public function test_product_directory_includes_new_industry_solutions(): void
    {
        $this->get('/apps')
            ->assertOk()
            ->assertSee('Pharmacy Management System')
            ->assertSee('Raw Materials Database')
            ->assertSee('PVC Pipe Factory Management')
            ->assertSee('Financial Management Systems');
    }

    public function test_public_marketing_pages_do_not_publish_direct_app_access_links(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertDontSee('app-live-link', false);

        $this->get('/apps')
            ->assertOk()
            ->assertDontSee('app-live-link', false);

        foreach (['fieldpulse', 'erp', 'pos'] as $slug) {
            $this->get('/apps/'.$slug)
                ->assertOk()
                ->assertDontSee('product-live-domain', false)
                ->assertDontSee('>Open ', false);
        }
    }
}
