<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FieldPulseWebLaunchTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_fieldpulse_product_copy_distinguishes_live_web_from_unreleased_android(): void
    {
        $this->get('/apps/fieldpulse')
            ->assertOk()
            ->assertSee('Web live')
            ->assertSee('Web platform available for demo requests. Android APK download is coming separately.')
            ->assertSee('Is the FieldPulse web platform available now?')
            ->assertDontSee('Active development')
            ->assertDontSee('Download Android APK');

        $this->seed(ProductSeeder::class);
        $product = Product::query()->where('slug', 'fieldpulse')->firstOrFail();
        $this->assertSame('Web live', $product->status);
        $this->assertSame(['Web'], $product->platforms);
    }

    public function test_migration_updates_only_legacy_defaults_and_keeps_admin_android_release(): void
    {
        $this->seed(ProductSeeder::class);
        $product = Product::query()->where('slug', 'fieldpulse')->firstOrFail();
        $content = $product->content;
        $content['status'] = 'Active development';
        $content['operating_system'] = 'Web, Android, iOS';
        $content['platforms'] = ['Web', 'Android', 'iOS'];
        $content['spotlight']['description'] = 'FieldPulse is being built around offline-first mobile foundations so essential workflows can continue through unreliable connections and synchronize when the network is available again.';
        $content['final']['description'] = 'Tell us about your field team and the workflow you want to improve. We will keep the conversation aligned with the current FieldPulse release state.';
        $content['live_note'] = null;
        $content['faq'][0] = [
            'question' => 'Is FieldPulse available as a finished public product?',
            'answer' => 'FieldPulse is currently in active development. Demo and deployment discussions should reflect the current release state rather than presenting the product as generally available before it is ready.',
        ];
        $content['faq'][1] = [
            'question' => 'Can FieldPulse work with unreliable mobile internet?',
            'answer' => 'FieldPulse is being built on an offline-first mobile foundation so essential field workflows can continue during connectivity gaps and synchronize when a connection returns.',
        ];
        $content['android_release'] = [
            'path' => 'android-releases/fieldpulse/saved.apk',
            'published' => false,
            'sha256' => str_repeat('a', 64),
        ];
        $content['custom_admin_note'] = 'Retain this website CMS edit';

        $product->update([
            'status' => 'Active development',
            'operating_system' => 'Web, Android, iOS',
            'platforms' => ['Web', 'Android', 'iOS'],
            'content' => $content,
        ]);

        $migration = require database_path('migrations/2026_10_10_095500_publish_fieldpulse_web_status.php');
        $migration->up();
        $migration->up();

        $product->refresh();
        $this->assertSame('Web live', $product->status);
        $this->assertSame('Web', $product->operating_system);
        $this->assertSame(['Web'], $product->platforms);
        $this->assertSame('android-releases/fieldpulse/saved.apk', data_get($product->content, 'android_release.path'));
        $this->assertFalse(data_get($product->content, 'android_release.published'));
        $this->assertSame('Retain this website CMS edit', data_get($product->content, 'custom_admin_note'));
        $this->assertSame('Is the FieldPulse web platform available now?', data_get($product->content, 'faq.0.question'));
        $this->assertStringContainsString('Android companion', data_get($product->content, 'spotlight.description'));

        $this->get('/apps/fieldpulse')
            ->assertOk()
            ->assertSee('Web live')
            ->assertDontSee('Active development')
            ->assertDontSee('Download Android APK');
    }
}
