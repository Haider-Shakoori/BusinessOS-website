<?php

namespace Tests\Feature;

use App\Models\SeoPage;
use Database\Seeders\AfghanistanSearchAuthoritySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AfghanistanSearchAuthorityTest extends TestCase
{
    use RefreshDatabase;

    public function test_afghanistan_pillar_pages_use_root_canonical_urls_and_structured_data(): void
    {
        $this->seed(AfghanistanSearchAuthoritySeeder::class);

        $this->assertDatabaseHas('seo_pages', [
            'slug' => 'business-operating-system-afghanistan',
            'status' => 'published',
        ]);
        $this->assertDatabaseHas('seo_pages', [
            'slug' => 'business-software-afghanistan',
            'status' => 'published',
        ]);

        $this->get('/business-operating-system-afghanistan')
            ->assertOk()
            ->assertSee('<title>Business Operating System for Afghanistan | BusinessOS</title>', false)
            ->assertSee('BusinessOS — a business operating system built around how Afghan companies actually work.')
            ->assertSee('"areaServed":{"@type":"Country","name":"Afghanistan"}', false)
            ->assertSee('"availableLanguage":["English","Dari","Pashto"]', false);

        $this->get('/business-software-afghanistan')
            ->assertOk()
            ->assertSee('<title>Business Software in Afghanistan | ERP, POS &amp; More | BusinessOS</title>', false)
            ->assertSee('Business software for Afghanistan: ERP, POS, field sales, inventory and custom systems.');

        $this->get('/services/business-operating-system-afghanistan')
            ->assertRedirect('/business-operating-system-afghanistan');

        $this->get('/services/business-software-afghanistan')
            ->assertRedirect('/business-software-afghanistan');

        $this->assertSame(
            url('/business-operating-system-afghanistan'),
            SeoPage::where('slug', 'business-operating-system-afghanistan')->firstOrFail()->publicUrl()
        );
    }

    public function test_sitemap_and_homepage_promote_afghanistan_authority_pages(): void
    {
        $this->seed(AfghanistanSearchAuthoritySeeder::class);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('/business-operating-system-afghanistan', false)
            ->assertSee('/business-software-afghanistan', false)
            ->assertDontSee('/services/business-operating-system-afghanistan', false)
            ->assertDontSee('/services/business-software-afghanistan', false);

        $this->get('/')
            ->assertOk()
            ->assertSee('BusinessOS Afghanistan — ERP, POS &amp; Business Software', false)
            ->assertSee('Business software designed around Afghan operating realities.')
            ->assertSee('/business-operating-system-afghanistan', false)
            ->assertSee('/business-software-afghanistan', false)
            ->assertSee('"alternateName":"BusinessOS Afghanistan"', false)
            ->assertSee('"name":"Afghanistan"', false);
    }
}
