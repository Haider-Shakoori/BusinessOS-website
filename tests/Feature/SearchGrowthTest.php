<?php

namespace Tests\Feature;

use App\Models\CaseStudy;
use App\Models\Guide;
use App\Models\SiteSetting;
use App\Models\User;
use Database\Seeders\CaseStudySeeder;
use Database\Seeders\SearchGuideSeeder;
use Database\Seeders\SeoPageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchGrowthTest extends TestCase
{
    use RefreshDatabase;

    public function test_high_intent_search_pages_are_public_structured_and_in_sitemap(): void
    {
        $this->seed(SeoPageSeeder::class);

        $this->get('/services/custom-erp-development')
            ->assertOk()
            ->assertSee('Custom ERP software built around')
            ->assertSee('Service')
            ->assertSee('FAQPage')
            ->assertSee('BreadcrumbList');

        $this->get('/services')
            ->assertOk()
            ->assertSee('Detailed service guides')
            ->assertSee('Custom ERP Development');

        $this->get('/services/restaurant-management-software')
            ->assertOk()
            ->assertSee('waiters take table orders on mobile')
            ->assertSee('waiter mobile ordering')
            ->assertSee('Kitchen Order Ticket')
            ->assertSee('split bills')
            ->assertSee('Cashier shifts')
            ->assertSee('closing variance')
            ->assertDontSee('customers place restaurant orders', false);

        $this->get('/services/inventory-management-software')
            ->assertOk()
            ->assertSee('<h2>Build one reliable item master</h2>', false)
            ->assertSee('Inventory software that makes stock movements explainable');

        $this->get('/services/software-development-afghanistan')
            ->assertOk()
            ->assertSee('Software development for Afghan businesses');

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('/services/custom-erp-development', false)
            ->assertSee('/services/erp-software-afghanistan', false)
            ->assertSee('/services/restaurant-management-software', false)
            ->assertSee('/services/software-development-afghanistan', false)
            ->assertSee('/services/inventory-management-software', false)
            ->assertSee('/services/field-sales-management-software', false)
            ->assertSee('/services/financial-management-software', false);
    }

    public function test_search_guide_library_has_expert_attribution_and_related_links(): void
    {
        $this->seed(SeoPageSeeder::class);
        $this->seed(SearchGuideSeeder::class);

        $this->assertSame(12, Guide::published()->count());

        $this->get('/guides/how-to-migrate-from-excel-to-erp')
            ->assertOk()
            ->assertSee('BusinessOS Editorial Team')
            ->assertSee('About the author')
            ->assertSee('<h2>Map and transform the data</h2>', false)
            ->assertSee('<h2>Rehearse and validate</h2>', false)
            ->assertSee('Related services')
            ->assertSee('Data Migration Services');

        $this->get('/guides/how-to-migrate-from-excel-to-erp?lang=fa')
            ->assertOk()
            ->assertSee('<link rel="canonical" href="https://businessos.af/guides/how-to-migrate-from-excel-to-erp">', false)
            ->assertDontSee('hreflang="fa-AF"', false)
            ->assertDontSee('hreflang="ps-AF"', false);
    }

    public function test_products_services_and_guides_form_a_bidirectional_internal_link_graph(): void
    {
        $this->seed(SeoPageSeeder::class);
        $this->seed(SearchGuideSeeder::class);

        $this->get('/apps/fieldpulse')
            ->assertOk()
            ->assertSee('/services/field-sales-management-software', false)
            ->assertSee('/guides/how-to-track-field-sales-team', false);

        $this->get('/services/field-sales-management-software')
            ->assertOk()
            ->assertSee('/apps/fieldpulse', false)
            ->assertSee('/guides/how-to-track-field-sales-team', false);

        $this->get('/guides/how-to-track-field-sales-team')
            ->assertOk()
            ->assertSee('/services/field-sales-management-software', false)
            ->assertSee('/apps/fieldpulse', false);
    }

    public function test_verified_case_studies_are_seeded_indexable_and_connected_to_products(): void
    {
        $this->seed(SeoPageSeeder::class);
        $this->seed(SearchGuideSeeder::class);
        $this->seed(CaseStudySeeder::class);

        $this->assertSame(4, CaseStudy::published()->count());

        $this->get('/case-studies')
            ->assertOk()
            ->assertSee('Corrugated Carton Manufacturing ERP')
            ->assertSee('FieldPulse: Building a Web + Mobile Field Sales Operations Platform')
            ->assertSee('BusinessOS POS: Full-Screen Multilingual Retail Checkout for Afghanistan')
            ->assertSee('Localized E-commerce Storefront Modernization in Laravel');

        $this->get('/case-studies/fieldpulse-field-sales-platform')
            ->assertOk()
            ->assertSee('map-based territory drawing')
            ->assertSee('/apps/fieldpulse', false)
            ->assertSee('/services/field-sales-management-software', false)
            ->assertSee('/guides/how-to-track-field-sales-team', false);

        $this->get('/apps/fieldpulse')
            ->assertOk()
            ->assertSee('/case-studies/fieldpulse-field-sales-platform', false);

        $this->get('/')
            ->assertOk()
            ->assertSee('Implementation evidence')
            ->assertSee('Real systems, documented without invented ROI claims.');

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('/case-studies/corrugated-carton-manufacturing-erp', false)
            ->assertSee('/case-studies/fieldpulse-field-sales-platform', false)
            ->assertSee('/case-studies/businessos-pos-afghanistan', false)
            ->assertSee('/case-studies/localized-ecommerce-storefront-modernization', false);
    }

    public function test_search_status_command_reports_activation_readiness(): void
    {
        SiteSetting::create(['group' => 'seo', 'key' => 'google_site_verification', 'value' => 'google-test-token']);
        SiteSetting::create(['group' => 'seo', 'key' => 'bing_site_verification', 'value' => 'bing-test-token']);

        config([
            'search.indexnow.enabled' => true,
            'search.indexnow.key' => 'BusinessOS-Test-Key-2026',
        ]);

        $this->artisan('search:status')
            ->expectsOutputToContain('Search verification and IndexNow configuration are ready.')
            ->assertExitCode(0);
    }

    public function test_robots_explicitly_allows_search_ai_crawlers(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('User-agent: OAI-SearchBot')
            ->assertSee('User-agent: PerplexityBot')
            ->assertSee('Sitemap:');
    }

    public function test_search_verification_tokens_render_when_configured(): void
    {
        SiteSetting::create(['group' => 'seo', 'key' => 'google_site_verification', 'value' => 'google-test-token']);
        SiteSetting::create(['group' => 'seo', 'key' => 'bing_site_verification', 'value' => 'bing-test-token']);

        $this->get('/')
            ->assertOk()
            ->assertSee('name="google-site-verification" content="google-test-token"', false)
            ->assertSee('name="msvalidate.01" content="bing-test-token"', false);
    }

    public function test_indexnow_key_file_is_available_only_when_enabled(): void
    {
        $this->get('/indexnow-key.txt')->assertNotFound();

        config([
            'search.indexnow.enabled' => true,
            'search.indexnow.key' => 'BusinessOS-Test-Key-2026',
        ]);

        $this->get('/indexnow-key.txt')
            ->assertOk()
            ->assertSee('BusinessOS-Test-Key-2026');
    }

    public function test_admin_can_publish_a_case_study_without_fabricated_seed_content(): void
    {
        $admin = User::create([
            'name' => 'CMS Admin',
            'email' => 'case-studies@example.com',
            'password' => 'a-secure-admin-password',
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->post('/admin/case-studies', [
            'title' => 'Anonymized ERP Implementation',
            'slug' => '',
            'industry' => 'Manufacturing',
            'summary' => 'An evidence-backed implementation story without publishing a client identity.',
            'challenge' => str_repeat('The operating process relied on disconnected records and required a more traceable workflow. ', 3),
            'solution' => str_repeat('The implementation connected structured master data, approvals and operational transactions in one workflow. ', 3),
            'outcome' => str_repeat('The published outcome is limited to verified process changes documented by the implementation team. ', 2),
            'meta_title' => 'Anonymized ERP Implementation | BusinessOS',
            'meta_description' => 'An evidence-backed BusinessOS implementation case study.',
            'status' => 'published',
        ]);

        $caseStudy = CaseStudy::firstOrFail();

        $response->assertRedirect(route('admin.case-studies.edit', $caseStudy));

        $this->get(route('case-studies.show', $caseStudy))
            ->assertOk()
            ->assertSee('The challenge')
            ->assertSee('The solution');

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('/case-studies/'.$caseStudy->slug, false);
    }
}
