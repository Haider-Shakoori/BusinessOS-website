<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('products')) {
            return;
        }

        $product = DB::table('products')->where('slug', 'fieldpulse')->first();

        if (! $product) {
            return;
        }

        $attributes = [];
        $content = json_decode((string) ($product->content ?? '{}'), true);
        $content = is_array($content) ? $content : [];
        $original = $content;

        // Only upgrade legacy launch-copy defaults; preserve subsequent CMS customizations.
        if ($product->status === 'Active development') {
            $attributes['status'] = 'Web live';
        }

        if ($product->operating_system === 'Web, Android, iOS') {
            $attributes['operating_system'] = 'Web';
        }

        $platforms = json_decode((string) ($product->platforms ?? '[]'), true);
        if ($platforms === ['Web', 'Android', 'iOS']) {
            $attributes['platforms'] = json_encode(['Web'], JSON_UNESCAPED_UNICODE);
        }

        if (($content['status'] ?? null) === 'Active development') {
            $content['status'] = 'Web live';
        }

        if (($content['operating_system'] ?? null) === 'Web, Android, iOS') {
            $content['operating_system'] = 'Web';
        }

        if (($content['platforms'] ?? null) === ['Web', 'Android', 'iOS']) {
            $content['platforms'] = ['Web'];
        }

        $oldSpotlight = 'FieldPulse is being built around offline-first mobile foundations so essential workflows can continue through unreliable connections and synchronize when the network is available again.';
        if (data_get($content, 'spotlight.description') === $oldSpotlight) {
            data_set($content, 'spotlight.description', 'FieldPulse web is available now. Its offline-first Android companion will be offered for direct download after the separate mobile release and acceptance checks are completed.');
        }

        if (data_get($content, 'final.description') === 'Tell us about your field team and the workflow you want to improve. We will keep the conversation aligned with the current FieldPulse release state.') {
            data_set($content, 'final.description', 'Request a demonstration or web onboarding discussion. The Android installer will be available separately when the mobile release is approved.');
        }

        if (empty($content['live_note'])) {
            $content['live_note'] = 'Web platform available for demo requests. Android APK download is coming separately.';
        }

        foreach ($content['faq'] ?? [] as $i => $item) {
            if (! is_array($item)) {
                continue;
            }

            if (($item['question'] ?? '') === 'Is FieldPulse available as a finished public product?') {
                $content['faq'][$i] = [
                    'question' => 'Is the FieldPulse web platform available now?',
                    'answer' => 'The FieldPulse web platform is available for demos and onboarding discussions. The Android app is a separate release and is not yet published for installation.',
                ];
            } elseif (($item['question'] ?? '') === 'Can FieldPulse work with unreliable mobile internet?'
                && ($item['answer'] ?? '') === 'FieldPulse is being built on an offline-first mobile foundation so essential field workflows can continue during connectivity gaps and synchronize when a connection returns.') {
                $content['faq'][$i]['answer'] = 'The offline-first Android application is designed for working through connectivity gaps and safe synchronization. It will be downloadable after its separate mobile release checks.';
            }
        }

        if ($content !== $original) {
            $attributes['content'] = json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        }

        if ($attributes !== []) {
            $attributes['updated_at'] = now();
            DB::table('products')->where('id', $product->id)->update($attributes);
        }
    }

    public function down(): void
    {
        // Reversing a code deployment must not silently roll back an announced product status
        // or overwrite later product edits made through the CMS.
    }
};
