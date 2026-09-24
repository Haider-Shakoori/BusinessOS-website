<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_seeder_imports_current_businessos_catalog(): void
    {
        $this->seed(ProductSeeder::class);

        $this->assertDatabaseCount('products', 3);
        $this->assertSame(3, Product::query()->publiclyVisible()->count());
        $this->assertDatabaseHas('products', [
            'slug' => 'fieldpulse',
            'publication_state' => 'published',
            'is_visible' => true,
        ]);
    }

    public function test_admin_can_publish_a_new_product_without_code_changes(): void
    {
        $admin = User::create([
            'name' => 'CMS Admin',
            'email' => 'products@example.com',
            'password' => 'a-secure-admin-password',
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->post('/admin/products', $this->payload());

        $product = Product::query()->where('slug', 'crm')->firstOrFail();

        $response->assertRedirect(route('admin.products.edit', $product));
        $this->assertSame('published', $product->publication_state);
        $this->assertNotNull($product->published_at);

        $this->get('/apps/crm')
            ->assertOk()
            ->assertSee('BusinessOS CRM')
            ->assertSee('Customer relationships without scattered follow-up.');

        $this->get('/apps')
            ->assertOk()
            ->assertSee('BusinessOS CRM');

        $this->get('/')
            ->assertOk()
            ->assertSee('BusinessOS CRM');

        $this->get('/request-demo?app=crm')
            ->assertOk()
            ->assertSee('<option value="crm" selected', false);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('/apps/crm', false);
    }

    public function test_draft_product_is_not_public(): void
    {
        Product::create([
            'name' => 'Private Product',
            'slug' => 'private-product',
            'icon_letter' => 'P',
            'headline' => 'Private headline',
            'short_description' => 'Private short description.',
            'description' => 'Private full description.',
            'category' => 'BusinessApplication',
            'application_category' => 'BusinessApplication',
            'operating_system' => 'Web',
            'status' => 'Draft',
            'publication_state' => 'draft',
            'is_visible' => true,
            'show_on_homepage' => true,
        ]);

        $this->get('/apps/private-product')->assertNotFound();
        $this->get('/apps')->assertDontSee('Private Product');
        $this->get('/')->assertDontSee('Private Product');
        $this->get('/sitemap.xml')->assertDontSee('/apps/private-product', false);
    }

    private function payload(): array
    {
        return [
            'name' => 'BusinessOS CRM',
            'slug' => 'crm',
            'icon_letter' => 'C',
            'eyebrow' => 'CRM & Customer Success',
            'headline' => 'Customer relationships without scattered follow-up.',
            'short_description' => 'Manage customer activity and follow-up in one focused BusinessOS application.',
            'description' => 'BusinessOS CRM connects customer records, follow-up and sales activity in a clear workflow for growing teams.',
            'category' => 'BusinessApplication',
            'application_category' => 'BusinessApplication',
            'operating_system' => 'Web',
            'platforms_text' => "Web\nMobile web",
            'status' => 'Live',
            'accent' => 'blue',
            'subdomain' => 'crm.businessos.af',
            'web_url' => 'https://crm.businessos.af',
            'featured' => '0',
            'is_visible' => '1',
            'show_on_homepage' => '1',
            'sort_order' => 40,
            'homepage_order' => 40,
            'publication_state' => 'published',
            'seo_title' => 'BusinessOS CRM — Customer Follow-up Software',
            'seo_description' => 'Manage customer relationships and follow-up with BusinessOS CRM.',
            'highlights_text' => "Customer records\nFollow-up visibility\nSales activity",
            'features_intro_title' => 'Keep customer work connected.',
            'features_intro_description' => 'Practical CRM capabilities without unnecessary complexity.',
            'features_text' => "Customer records | Keep customer details organized.\nFollow-ups | Track the next action.",
            'use_cases_intro_title' => 'Built for customer-facing teams.',
            'use_cases_intro_description' => 'Use it where customer follow-up needs structure.',
            'use_cases_text' => "Lead follow-up\nCustomer account management",
            'preview_section' => 'Customer operations',
            'preview_title' => 'Relationship overview',
            'preview_status' => 'Live',
            'preview_metrics_text' => "Customers | Managed | account records\nFollow-ups | Visible | next actions",
            'preview_rows_text' => "Customer timeline\nFollow-up queue",
            'spotlight_kicker' => 'Focused CRM',
            'spotlight_title' => 'Know the next customer action.',
            'spotlight_description' => 'Keep follow-up visible without adding unnecessary process.',
            'spotlight_items_text' => "Customer-first\nClear ownership",
            'pricing_status' => 'Pricing in preparation',
            'pricing_note' => 'Commercial packaging will be published after rollout validation.',
            'final_title' => 'Bring customer follow-up into one workflow.',
            'final_description' => 'Tell us how your team manages customer relationships today.',
            'faq_text' => 'Is BusinessOS CRM available? | This test product is published through the CMS.',
            'screenshots_text' => '/assets/products/crm/dashboard.webp',
            'live_note' => '',
        ];
    }
}
