<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Throwable;

class IndexNowService
{
    public function submit(string|array $urls): bool
    {
        if (! config('search.indexnow.enabled') || ! config('search.indexnow.key')) {
            return false;
        }

        $urls = collect((array) $urls)
            ->filter(fn ($url) => is_string($url) && str_starts_with($url, url('/')))
            ->unique()
            ->take(10000)
            ->values();

        if ($urls->isEmpty()) {
            return false;
        }

        try {
            $response = Http::timeout((int) config('search.indexnow.timeout', 4))
                ->acceptJson()
                ->post((string) config('search.indexnow.endpoint'), [
                    'host' => request()->getHost() ?: parse_url(config('app.url'), PHP_URL_HOST),
                    'key' => (string) config('search.indexnow.key'),
                    'keyLocation' => url((string) config('search.indexnow.key_path', '/indexnow-key.txt')),
                    'urlList' => $urls->all(),
                ]);

            return $response->successful() || $response->status() === 202;
        } catch (Throwable) {
            return false;
        }
    }
}
