<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class SearchConsoleAnalytics
{
    public function report(int $days = 30): array
    {
        $days = in_array($days, [7, 30, 90, 365], true) ? $days : 30;
        $siteUrl = (string) config('search_console.site_url', '');
        $path = (string) config('search_console.credentials_path', '');

        if ($siteUrl === '' || $path === '' || ! is_file($path) || ! is_readable($path)) {
            return ['status' => 'setup_required', 'days' => $days];
        }

        $key = 'search-console:'.hash('sha256', $siteUrl.':'.$path.':'.$days);
        try {
            return Cache::remember($key, now()->addMinutes((int) config('search_console.report_cache_minutes', 30)), function () use ($siteUrl, $path, $days): array {
                return $this->fetch($siteUrl, $path, $days);
            });
        } catch (Throwable $exception) {
            report($exception);

            return ['status' => 'unavailable', 'days' => $days];
        }
    }

    private function fetch(string $siteUrl, string $path, int $days): array
    {
        $token = $this->accessToken($path);
        $end = now()->subDays(3)->toDateString();
        $start = now()->subDays($days + 2)->toDateString();

        $endpoint = 'https://searchconsole.googleapis.com/webmasters/v3/sites/'.rawurlencode($siteUrl).'/searchAnalytics/query';
        $query = function (array $dimensions, int $limit) use ($token, $endpoint, $start, $end): array {
            $response = Http::withToken($token)->acceptJson()->timeout(15)->post($endpoint, [
                'startDate' => $start,
                'endDate' => $end,
                'dimensions' => $dimensions,
                'rowLimit' => $limit,
                'dataState' => 'final',
                'type' => 'web',
            ]);

            if (! $response->successful() || ! is_array($response->json())) {
                throw new RuntimeException('Google Search Console reporting failed (HTTP '.$response->status().').');
            }

            return $response->json('rows', []);
        };

        // GSC suppresses anonymized searches. These are known-query impressions,
        // not all site impressions or per-visitor search attribution.
        $byKeyword = collect($query(['query'], 1000))
            ->map(fn (array $row) => $this->row($row, false))
            ->sortByDesc('impressions')
            ->take(20)
            ->values()
            ->all();
        $byLandingPage = collect($query(['query', 'page'], 1000))
            ->map(fn (array $row) => $this->row($row, true))
            ->sortByDesc('impressions')
            ->take(20)
            ->values()
            ->all();

        return [
            'status' => 'ready',
            'days' => $days,
            'start' => $start,
            'end' => $end,
            'source' => 'Google Search',
            'keywords' => $byKeyword,
            'keyword_pages' => $byLandingPage,
        ];
    }

    private function row(array $row, bool $withPage): array
    {
        return [
            'keyword' => (string) ($row['keys'][0] ?? ''),
            'page' => $withPage ? (string) ($row['keys'][1] ?? '') : null,
            'impressions' => (int) ($row['impressions'] ?? 0),
            'clicks' => (int) ($row['clicks'] ?? 0),
            'ctr' => round((float) ($row['ctr'] ?? 0) * 100, 1),
            'position' => round((float) ($row['position'] ?? 0), 1),
        ];
    }

    private function accessToken(string $path): string
    {
        $credentials = json_decode((string) file_get_contents($path), true);
        if (! is_array($credentials)
            || ($credentials['type'] ?? null) !== 'service_account'
            || ! filter_var($credentials['client_email'] ?? null, FILTER_VALIDATE_EMAIL)
            || empty($credentials['private_key'])) {
            throw new RuntimeException('Invalid Search Console service account JSON.');
        }

        $scope = 'https://www.googleapis.com/auth/webmasters.readonly';
        $cacheKey = 'search-console:oauth:'.hash('sha256', ($credentials['client_email']).':'.($credentials['private_key_id'] ?? '').':'.$scope);
        $cached = Cache::get($cacheKey);
        if (is_string($cached) && $cached !== '') {
            return $cached;
        }

        $encode = static fn (array $payload): string => rtrim(strtr(base64_encode((string) json_encode($payload, JSON_UNESCAPED_SLASHES)), '+/', '-_'), '=');
        $time = time();
        $unsigned = $encode(['alg' => 'RS256', 'typ' => 'JWT']).'.'.$encode([
            'iss' => $credentials['client_email'],
            'scope' => $scope,
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $time,
            'exp' => $time + 3600,
        ]);

        if (! openssl_sign($unsigned, $signature, $credentials['private_key'], OPENSSL_ALGO_SHA256)) {
            throw new RuntimeException('Unable to sign Search Console service-account assertion.');
        }

        $response = Http::asForm()->acceptJson()->timeout(10)->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant_type:jwt-bearer',
            'assertion' => $unsigned.'.'.rtrim(strtr(base64_encode($signature), '+/', '-_'), '='),
        ]);

        if (! $response->successful() || ! is_string($response->json('access_token'))) {
            throw new RuntimeException('Unable to authorize Search Console service account.');
        }

        $token = $response->json('access_token');
        Cache::put($cacheKey, $token, now()->addSeconds(max(60, min(3300, (int) $response->json('expires_in', 3600) - 120))));

        return $token;
    }
}
