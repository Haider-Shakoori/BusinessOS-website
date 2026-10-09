<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class GoogleAnalytics
{
    public function report(int $days = 30): array
    {
        $days = in_array($days, [7, 30, 90], true) ? $days : 30;
        $property = (string) config('ga4.property_id', '');
        $path = (string) config('ga4.credentials_path', '');

        if (! preg_match('/^\d+$/', $property) || $path === '' || ! is_readable($path) || ! is_file($path)) {
            return [
                'status' => 'setup_required',
                'measurement_enabled' => $this->measurementEnabled(),
                'days' => $days,
            ];
        }

        $cacheKey = 'ga4:report:'.hash('sha256', $property.':'.$days);

        try {
            $cached = Cache::get($cacheKey);
            if (is_array($cached)) {
                return $cached;
            }

            $report = $this->fetchReport($property, $path, $days);
            Cache::put($cacheKey, $report, now()->addMinutes((int) config('ga4.report_cache_minutes', 15)));

            return $report;
        } catch (Throwable $exception) {
            report($exception);

            return [
                'status' => 'unavailable',
                'measurement_enabled' => $this->measurementEnabled(),
                'days' => $days,
            ];
        }
    }

    public function measurementEnabled(): bool
    {
        return (bool) preg_match('/^G-[A-Z0-9]+$/', (string) config('ga4.measurement_id', ''));
    }

    private function fetchReport(string $property, string $path, int $days): array
    {
        $token = $this->accessToken($path);
        $range = [['startDate' => ($days - 1).'daysAgo', 'endDate' => 'today']];

        $response = Http::withToken($token)
            ->acceptJson()
            ->timeout(12)
            ->post('https://analyticsdata.googleapis.com/v1beta/properties/'.$property.':batchRunReports', [
                'requests' => [
                    [
                        'dateRanges' => $range,
                        'metrics' => [
                            ['name' => 'activeUsers'],
                            ['name' => 'sessions'],
                            ['name' => 'screenPageViews'],
                            ['name' => 'engagementRate'],
                            ['name' => 'keyEvents'],
                        ],
                    ],
                    [
                        'dateRanges' => $range,
                        'dimensions' => [['name' => 'sessionSource']],
                        'metrics' => [['name' => 'sessions']],
                        'limit' => '500',
                        'orderBys' => [['metric' => ['metricName' => 'sessions'], 'desc' => true]],
                    ],
                    [
                        'dateRanges' => $range,
                        'dimensions' => [['name' => 'pagePath']],
                        'metrics' => [['name' => 'screenPageViews']],
                        'limit' => '8',
                        'orderBys' => [['metric' => ['metricName' => 'screenPageViews'], 'desc' => true]],
                    ],
                    [
                        'dateRanges' => $range,
                        'dimensions' => [['name' => 'country']],
                        'metrics' => [['name' => 'activeUsers']],
                        'limit' => '8',
                        'orderBys' => [['metric' => ['metricName' => 'activeUsers'], 'desc' => true]],
                    ],
                ],
            ]);

        if (! $response->successful() || ! is_array($response->json('reports'))) {
            throw new RuntimeException('GA4 Data API request failed.');
        }

        $reports = $response->json('reports');
        if (count($reports) !== 4) {
            throw new RuntimeException('Incomplete GA4 reporting response.');
        }

        $totals = $reports[0]['rows'][0]['metricValues'] ?? [];
        $sources = $this->rows($reports[1]);
        $aiReferrers = array_values(array_filter($sources, fn (array $row) => $this->isAiReferrer($row['label'])));

        return [
            'status' => 'ready',
            'measurement_enabled' => $this->measurementEnabled(),
            'days' => $days,
            'active_users' => (int) ($totals[0]['value'] ?? 0),
            'sessions' => (int) ($totals[1]['value'] ?? 0),
            'page_views' => (int) ($totals[2]['value'] ?? 0),
            'engagement_rate' => round(((float) ($totals[3]['value'] ?? 0)) * 100, 1),
            'key_events' => (int) ($totals[4]['value'] ?? 0),
            'ai_referral_sessions' => array_sum(array_column($aiReferrers, 'count')),
            'ai_referrers' => $aiReferrers,
            'sources' => array_slice($sources, 0, 8),
            'pages' => $this->rows($reports[2]),
            'countries' => $this->rows($reports[3]),
        ];
    }

    private function accessToken(string $path): string
    {
        $credentials = json_decode((string) file_get_contents($path), true);

        if (! is_array($credentials)
            || ($credentials['type'] ?? null) !== 'service_account'
            || ! filter_var($credentials['client_email'] ?? null, FILTER_VALIDATE_EMAIL)
            || empty($credentials['private_key'])) {
            throw new RuntimeException('Invalid GA4 service account credentials.');
        }

        $cacheKey = 'ga4:oauth:'.hash('sha256', $credentials['client_email'].':'.$credentials['private_key_id'] ?? '');
        $cached = Cache::get($cacheKey);
        if (is_string($cached) && $cached !== '') {
            return $cached;
        }

        $now = time();
        $encode = static fn (array $payload): string => rtrim(strtr(base64_encode((string) json_encode($payload, JSON_UNESCAPED_SLASHES)), '+/', '-_'), '=');
        $unsigned = $encode(['alg' => 'RS256', 'typ' => 'JWT']).'.'.$encode([
            'iss' => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/analytics.readonly',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600,
        ]);

        if (! openssl_sign($unsigned, $signature, $credentials['private_key'], OPENSSL_ALGO_SHA256)) {
            throw new RuntimeException('Could not sign GA4 OAuth assertion.');
        }

        $assertion = $unsigned.'.'.rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

        $response = Http::asForm()
            ->acceptJson()
            ->timeout(10)
            ->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $assertion,
            ]);

        if (! $response->successful() || ! is_string($response->json('access_token'))) {
            throw new RuntimeException('GA4 service account could not obtain an access token.');
        }

        $token = $response->json('access_token');
        Cache::put($cacheKey, $token, now()->addSeconds(max(60, min(3300, (int) $response->json('expires_in', 3600) - 120))));

        return $token;
    }

    private function rows(array $report): array
    {
        return array_map(static fn (array $row) => [
            'label' => (string) ($row['dimensionValues'][0]['value'] ?? 'Unknown'),
            'count' => (int) ($row['metricValues'][0]['value'] ?? 0),
        ], $report['rows'] ?? []);
    }

    private function isAiReferrer(string $source): bool
    {
        $source = strtolower(trim($source));

        foreach ([
            'chatgpt.com', 'chat.openai.com', 'perplexity.ai', 'claude.ai',
            'gemini.google.com', 'copilot.microsoft.com', 'poe.com', 'you.com',
        ] as $hostname) {
            if ($source === $hostname || str_ends_with($source, '.'.$hostname)) {
                return true;
            }
        }

        return false;
    }
}
