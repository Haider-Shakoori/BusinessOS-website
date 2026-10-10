<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use ZipArchive;

class AndroidReleaseController extends Controller
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        // Installer management is deliberately restricted to FieldPulse.
        abort_unless($product->slug === 'fieldpulse', 404);

        $data = $request->validate([
            'apk' => ['required', 'file', 'max:153600'], // 150 MB, subject to cPanel/PHP limits
            'version' => ['required', 'string', 'max:60', 'regex:/^\\d+\\.\\d+\\.\\d+(?:[-+][a-zA-Z0-9.-]+)?$/'],
            'sha256' => ['required', 'string', 'regex:/^[a-fA-F0-9]{64}$/'],
            'publish' => ['nullable', 'boolean'],
            'signed_confirmed' => ['accepted'],
        ]);

        $file = $request->file('apk');
        if (strtolower($file->getClientOriginalExtension()) !== 'apk') {
            throw ValidationException::withMessages(['apk' => 'Select an Android .apk file.']);
        }

        // APKs are ZIP containers. Reject renamed arbitrary files; do not unpack untrusted archives.
        if (! class_exists(ZipArchive::class)) {
            throw ValidationException::withMessages(['apk' => 'The hosting PHP ZIP extension is required to verify APK files.']);
        }

        $zip = new ZipArchive;
        $opened = $zip->open($file->getRealPath());
        if ($opened !== true) {
            throw ValidationException::withMessages(['apk' => 'The file is not a valid APK archive.']);
        }

        try {
            if ($zip->locateName('AndroidManifest.xml') === false || $zip->locateName('classes.dex') === false) {
                throw ValidationException::withMessages(['apk' => 'Missing Android package manifest or executable code.']);
            }
        } finally {
            $zip->close();
        }

        $actualHash = hash_file('sha256', $file->getRealPath());
        if (! hash_equals(strtolower($data['sha256']), $actualHash)) {
            throw ValidationException::withMessages(['sha256' => 'The SHA-256 checksum does not match the uploaded APK.']);
        }

        $folder = 'android-releases/fieldpulse';
        $filename = (string) Str::uuid().'.apk';
        $path = $file->storeAs($folder, $filename, 'local');
        if (! $path) {
            throw ValidationException::withMessages(['apk' => 'Could not store the APK on the private hosting disk.']);
        }

        $previousPath = data_get($product->content, 'android_release.path');
        $content = is_array($product->content) ? $product->content : [];
        $content['android_release'] = [
            'path' => $path,
            'version' => $data['version'],
            'sha256' => $actualHash,
            'size_bytes' => (int) $file->getSize(),
            'published' => $request->boolean('publish'),
            'uploaded_at' => now()->toIso8601String(),
        ];

        try {
            $product->update(['content' => $content]);
        } catch (\Throwable $exception) {
            Storage::disk('local')->delete($path);
            throw $exception;
        }

        if (is_string($previousPath) && str_starts_with($previousPath, $folder.'/') && $previousPath !== $path) {
            Storage::disk('local')->delete($previousPath);
        }

        return back()->with('status', $request->boolean('publish')
            ? 'FieldPulse Android release uploaded and published.'
            : 'FieldPulse Android release uploaded as a draft. Public download is disabled.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        abort_unless($product->slug === 'fieldpulse', 404);

        $content = is_array($product->content) ? $product->content : [];
        $oldPath = data_get($content, 'android_release.path');
        unset($content['android_release']);
        $product->update(['content' => $content]);

        if (is_string($oldPath) && str_starts_with($oldPath, 'android-releases/fieldpulse/')) {
            Storage::disk('local')->delete($oldPath);
        }

        return back()->with('status', 'FieldPulse Android download unpublished and removed.');
    }
}
