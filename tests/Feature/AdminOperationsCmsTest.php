<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use App\Models\MediaAsset;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\User;
use Database\Seeders\ProductSeeder;
use Database\Seeders\SiteSettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminOperationsCmsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([SiteSettingSeeder::class, ProductSeeder::class]);

        $this->admin = User::create([
            'name' => 'CMS Admin',
            'email' => 'admin-ops@example.com',
            'password' => 'a-secure-admin-password',
            'is_admin' => true,
        ]);
    }

    public function test_admin_can_manage_inquiry_status_followup_and_notes(): void
    {
        $inquiry = Inquiry::create([
            'name' => 'Prospect',
            'email' => 'prospect@example.com',
            'inquiry_type' => 'demo',
            'app_slug' => 'erp',
            'message' => 'We need a product demo for our commercial workflow.',
            'status' => 'new',
        ]);

        $this->actingAs($this->admin)
            ->get('/admin/inquiries')
            ->assertOk()
            ->assertSee('Prospect');

        $this->actingAs($this->admin)
            ->put('/admin/inquiries/'.$inquiry->id, [
                'status' => 'in_progress',
                'follow_up_at' => '2026-10-01 10:00:00',
            ])
            ->assertRedirect();

        $this->actingAs($this->admin)
            ->post('/admin/inquiries/'.$inquiry->id.'/notes', [
                'note' => 'Demo requirements reviewed with the customer.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('inquiries', [
            'id' => $inquiry->id,
            'status' => 'in_progress',
        ]);
        $this->assertDatabaseHas('inquiry_notes', [
            'inquiry_id' => $inquiry->id,
            'note' => 'Demo requirements reviewed with the customer.',
        ]);
    }

    public function test_global_settings_update_the_public_homepage(): void
    {
        $this->actingAs($this->admin)
            ->put('/admin/settings', $this->settingsPayload([
                'homepage_hero_title' => 'Run every part of the business with clarity.',
                'nav_demo_label' => 'Book product demo',
            ]))
            ->assertRedirect();

        $this->get('/')
            ->assertOk()
            ->assertSee('Run every part of the business with clarity.')
            ->assertSee('Book product demo');

        $this->assertDatabaseHas('site_settings', [
            'key' => 'homepage_hero_title',
            'value' => 'Run every part of the business with clarity.',
        ]);
    }

    public function test_product_localized_copy_is_served_for_dari(): void
    {
        $product = Product::query()->where('slug', 'erp')->firstOrFail();
        $content = $product->content;
        $content['translations']['fa']['headline'] = 'سیستم یکپارچه مدیریت تجارت';

        $product->update(['content' => $content]);

        $this->get('/apps/erp?lang=fa')
            ->assertOk()
            ->assertSee('سیستم یکپارچه مدیریت تجارت', false)
            ->assertSee('dir="rtl"', false);
    }

    public function test_pricing_page_uses_product_commercial_configuration(): void
    {
        $this->get('/pricing')
            ->assertOk()
            ->assertSee('Per field user + annual platform')
            ->assertSee('Deployment and module scope')
            ->assertSee('Shop license + deployment');
    }

    public function test_admin_can_upload_media_asset(): void
    {
        Storage::fake('public');

        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9Y9ZQmcAAAAASUVORK5CYII=');

        $this->actingAs($this->admin)
            ->post('/admin/media', [
                'image' => UploadedFile::fake()->createWithContent('product.png', $png),
                'alt_text' => 'Product dashboard preview',
                'caption' => 'A CMS-managed product screenshot.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('media_assets', [
            'original_name' => 'product.png',
            'alt_text' => 'Product dashboard preview',
        ]);

        $asset = MediaAsset::query()->firstOrFail();
        Storage::disk('public')->assertExists($asset->original_path);
    }

    private function settingsPayload(array $overrides = []): array
    {
        $payload = SiteSetting::query()->pluck('value', 'key')->all();

        return array_merge($payload, $overrides);
    }
}
