<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AndroidDownloadController extends Controller
{
    public function __invoke(string $slug): StreamedResponse
    {
        abort_unless($slug === 'fieldpulse', 404);

        $product = Product::query()->publiclyVisible()->where('slug', $slug)->firstOrFail();
        $release = (array) data_get($product->content, 'android_release', []);

        $path = $release['path'] ?? null;
        abort_unless(
            ($release['published'] ?? false) === true
                && is_string($path)
                && str_starts_with($path, 'android-releases/fieldpulse/')
                && Storage::disk('local')->exists($path),
            404
        );

        $version = preg_replace('/[^0-9a-zA-Z.+-]/', '', (string) ($release['version'] ?? ''));
        abort_if($version === '', 404);

        return Storage::disk('local')->download(
            $path,
            'FieldPulse-'.$version.'.apk',
            [
                'Content-Type' => 'application/vnd.android.package-archive',
                'X-Content-Type-Options' => 'nosniff',
                'Cache-Control' => 'private, no-store',
            ]
        );
    }
}
