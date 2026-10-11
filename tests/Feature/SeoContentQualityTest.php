<?php

namespace Tests\Feature;

use App\Models\Guide;
use App\Models\SeoPage;
use Database\Seeders\SearchGrowthPhase2Seeder;
use Database\Seeders\SeoPageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoContentQualityTest extends TestCase
{
    use RefreshDatabase;

    public function test_internal_keyword_targets_are_not_rendered_as_public_keyword_lists(): void
    {
        $this->seed(SeoPageSeeder::class);

        $page = SeoPage::where('slug', 'erp-software-afghanistan')->firstOrFail();

        $this->assertContains('ERP Kabul', $page->target_keywords);

        $this->get('/services/erp-software-afghanistan')
            ->assertOk()
            ->assertSee('ERP software adapted to the operational realities')
            ->assertDontSee('ERP Kabul')
            ->assertDontSee('Afghanistan inventory software')
            ->assertDontSee('service-topic-row')
            ->assertDontSee('"keywords":', false);
    }

    public function test_field_sales_pages_serve_different_intents_and_link_to_each_other(): void
    {
        $this->seed(SeoPageSeeder::class);
        $this->seed(SearchGrowthPhase2Seeder::class);

        $this->get('/services/field-sales-management-software')
            ->assertOk()
            ->assertSee('Organize people and territories')
            ->assertSee('See the customer visit management workflow')
            ->assertSee('/services/field-sales-visit-management-software"', false);

        $this->get('/services/field-sales-visit-management-software')
            ->assertOk()
            ->assertSee('Plan customer visits, capture outcomes')
            ->assertSee('Before the visit: prepare the daily plan')
            ->assertSee('In a hypothetical daily route')
            ->assertSee('Explore Field Sales Management Software')
            ->assertSee('/services/field-sales-management-software"', false);
    }

    public function test_live_copy_migration_does_not_overwrite_a_cms_edit(): void
    {
        $this->seed(SearchGrowthPhase2Seeder::class);

        $page = SeoPage::where('slug', 'field-sales-visit-management-software')->firstOrFail();
        $page->update(['content' => 'Customized by the BusinessOS editorial team.']);

        $migration = require database_path('migrations/2026_10_11_000001_refine_field_sales_visit_content.php');
        $migration->up();

        $this->assertSame('Customized by the BusinessOS editorial team.', $page->fresh()->content);
    }
    public function test_bom_guide_provides_worked_costing_and_preserves_cms_edits(): void
    {
        $this->seed(SearchGrowthPhase2Seeder::class);

        $this->get('/guides/manufacturing-bom-costing-guide')
            ->assertOk()
            ->assertSee('Worked example: 1,000 cartons')
            ->assertSee('AFN 9,635')
            ->assertSee('AFN 395')
            ->assertSee('Where paper rolls cannot be weighed on site');

        $guide = Guide::where('slug', 'manufacturing-bom-costing-guide')->firstOrFail();
        $enhancedContent = $guide->content;
        $migration = require database_path('migrations/2026_10_11_000002_refine_manufacturing_bom_guide.php');

        $migration->down();
        $this->assertNotSame($enhancedContent, $guide->fresh()->content);

        $migration->up();
        $this->assertSame($enhancedContent, $guide->fresh()->content);

        $guide->update(['content' => 'Reviewed and edited by a BusinessOS subject-matter expert.']);
        $migration->up();
        $this->assertSame('Reviewed and edited by a BusinessOS subject-matter expert.', $guide->fresh()->content);
    }
}
