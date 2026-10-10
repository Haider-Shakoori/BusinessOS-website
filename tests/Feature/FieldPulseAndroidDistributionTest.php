<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use ZipArchive;

class FieldPulseAndroidDistributionTest extends TestCase
{
    use RefreshDatabase;

    private Product $product;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ProductSeeder::class);
        Storage::fake('local');

        $this->product = Product::query()->where('slug', 'fieldpulse')->firstOrFail();
        $this->admin = User::create([
            'name' => 'Distribution Admin',
            'email' => 'distribution@example.com',
            'password' => 'test-password',
            'is_admin' => true,
        ]);
    }

    public function test_apk_is_private_until_an_admin_publishes_it(): void
    {
        $bytes = $this->sampleApk();
        $hash = hash('sha256', $bytes);

        $this->get('/apps/fieldpulse/android/download')->assertNotFound();
        $this->get('/apps/fieldpulse')->assertDontSee('Download Android APK');

        $this->post(route('admin.products.android-release.store', $this->product), $this->payload($bytes))
            ->assertRedirect(route('login'));

        $this->actingAs($this->admin)->post(route('admin.products.android-release.store', $this->product), $this->payload($bytes))
            ->assertRedirect();

        $this->product->refresh();
        $path = data_get($this->product->content, 'android_release.path');
        $this->assertFalse(data_get($this->product->content, 'android_release.published'));
        $this->assertSame($hash, data_get($this->product->content, 'android_release.sha256'));
        Storage::disk('local')->assertExists($path);
        $this->get('/apps/fieldpulse/android/download')->assertNotFound();
        $this->get('/apps/fieldpulse')->assertDontSee('Download Android APK');

        $this->actingAs($this->admin)->post(route('admin.products.android-release.store', $this->product), $this->payload($bytes, ['publish' => '1']))
            ->assertRedirect();

        $this->product->refresh();
        $newPath = data_get($this->product->content, 'android_release.path');
        $this->assertTrue(data_get($this->product->content, 'android_release.published'));
        Storage::disk('local')->assertMissing($path);
        Storage::disk('local')->assertExists($newPath);
        $this->get('/apps/fieldpulse')
            ->assertOk()
            ->assertSee('Download Android APK (v1.0.2)')
            ->assertSee($hash);

        $this->get('/apps/fieldpulse/android/download')
            ->assertOk()
            ->assertDownload('FieldPulse-1.0.2.apk');

        $this->actingAs($this->admin)->delete(route('admin.products.android-release.destroy', $this->product))
            ->assertRedirect();

        Storage::disk('local')->assertMissing($newPath);
        $this->get('/apps/fieldpulse/android/download')->assertNotFound();
    }

    public function test_invalid_hash_non_apk_and_missing_confirmation_are_rejected(): void
    {
        $bytes = $this->sampleApk();

        $this->actingAs($this->admin)->post(
            route('admin.products.android-release.store', $this->product),
            $this->payload($bytes, ['sha256' => str_repeat('0', 64)])
        )->assertSessionHasErrors('sha256');

        $this->actingAs($this->admin)->post(
            route('admin.products.android-release.store', $this->product),
            $this->payload('not an apk')
        )->assertSessionHasErrors('apk');

        $this->actingAs($this->admin)->post(
            route('admin.products.android-release.store', $this->product),
            $this->payload($bytes, ['signed_confirmed' => '0'])
        )->assertSessionHasErrors('signed_confirmed');

        $this->assertNull(data_get($this->product->fresh()->content, 'android_release.path'));
    }

    public function test_public_download_is_hidden_when_product_is_unpublished_or_file_missing(): void
    {
        $bytes = $this->sampleApk();
        $this->actingAs($this->admin)->post(
            route('admin.products.android-release.store', $this->product),
            $this->payload($bytes, ['publish' => '1'])
        )->assertRedirect();

        $path = data_get($this->product->fresh()->content, 'android_release.path');
        Storage::disk('local')->delete($path);
        $this->get('/apps/fieldpulse/android/download')->assertNotFound();
        $this->get('/apps/fieldpulse')->assertDontSee('Download Android APK');

        $this->product->update(['publication_state' => 'draft']);
        $this->get('/apps/fieldpulse/android/download')->assertNotFound();
    }

    private function payload(string $bytes, array $override = []): array
    {
        return array_merge([
            'apk' => UploadedFile::fake()->createWithContent('FieldPulse.apk', $bytes),
            'version' => '1.0.2',
            'sha256' => hash('sha256', $bytes),
            'signed_confirmed' => '1',
            'publish' => '0',
        ], $override);
    }

    private function sampleApk(): string
    {
        $file = tempnam(sys_get_temp_dir(), 'fieldpulse-apk-');
        $zip = new ZipArchive;
        if ($zip->open($file, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('Could not generate Android archive test fixture.');
        }

        $zip->addFromString('AndroidManifest.xml', 'fixture-manifest');
        $zip->addFromString('classes.dex', 'fixture-dex');
        $zip->close();

        $bytes = file_get_contents($file);
        unlink($file);

        return $bytes;
    }
}
