<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaAsset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(): View
    {
        return view('admin.media.index', [
            'assets' => MediaAsset::query()->latest()->paginate(30),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:10240'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:2000'],
        ]);

        $file = $request->file('image');
        $folder = 'media/'.now()->format('Y/m');
        $base = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'image';
        $base .= '-'.Str::lower(Str::random(8));

        $extension = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $originalPath = $file->storeAs($folder, $base.'.'.$extension, 'public');

        [$width, $height] = @getimagesize($file->getRealPath()) ?: [null, null];
        $webpPath = null;
        $avifPath = null;

        $binary = @file_get_contents(Storage::disk('public')->path($originalPath));
        $image = $binary !== false && function_exists('imagecreatefromstring')
            ? @imagecreatefromstring($binary)
            : false;

        if ($image !== false) {
            if (function_exists('imagewebp')) {
                $webpPath = $folder.'/'.$base.'.webp';
                @imagewebp($image, Storage::disk('public')->path($webpPath), 82);
                if (! Storage::disk('public')->exists($webpPath)) {
                    $webpPath = null;
                }
            }

            if (function_exists('imageavif')) {
                $avifPath = $folder.'/'.$base.'.avif';
                @imageavif($image, Storage::disk('public')->path($avifPath), 68);
                if (! Storage::disk('public')->exists($avifPath)) {
                    $avifPath = null;
                }
            }

            imagedestroy($image);
        }

        MediaAsset::create([
            'created_by' => $request->user()?->getKey(),
            'disk' => 'public',
            'original_path' => $originalPath,
            'webp_path' => $webpPath,
            'avif_path' => $avifPath,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType() ?: 'application/octet-stream',
            'size_bytes' => (int) $file->getSize(),
            'width' => $width,
            'height' => $height,
            'alt_text' => $data['alt_text'] ?? null,
            'caption' => $data['caption'] ?? null,
        ]);

        return back()->with('status', 'Media uploaded and optimized where supported by the server.');
    }

    public function update(Request $request, MediaAsset $media): RedirectResponse
    {
        $data = $request->validate([
            'alt_text' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:2000'],
        ]);

        $media->update([
            'alt_text' => trim((string) ($data['alt_text'] ?? '')) ?: null,
            'caption' => trim((string) ($data['caption'] ?? '')) ?: null,
        ]);

        return back()->with('status', 'Media metadata updated.');
    }

    public function destroy(MediaAsset $media): RedirectResponse
    {
        foreach (array_filter([$media->original_path, $media->webp_path, $media->avif_path]) as $path) {
            Storage::disk($media->disk)->delete($path);
        }

        $media->delete();

        return back()->with('status', 'Media asset deleted.');
    }
}
