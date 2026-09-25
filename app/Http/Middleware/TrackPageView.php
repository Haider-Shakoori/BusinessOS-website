<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TrackPageView
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldTrack($request, $response)) {
            return $response;
        }

        $cookieName = config('analytics.visitor_cookie', 'bos_vid');
        $visitorId = $request->cookie($cookieName);

        if (! is_string($visitorId) || ! Str::isUuid($visitorId)) {
            $visitorId = (string) Str::uuid();
        }

        try {
            PageVisit::create([
                'visitor_id' => $visitorId,
                'path' => Str::limit('/'.ltrim($request->path(), '/'), 1000, ''),
                'route_name' => Str::limit((string) optional($request->route())->getName(), 120, '') ?: null,
                'country_code' => $this->countryCode($request),
                'referrer_host' => $this->referrerHost($request),
                'user_agent_family' => $this->userAgentFamily($request),
                'device_type' => $this->deviceType($request),
                'occurred_at' => now(),
            ]);
        } catch (Throwable) {
            return $response;
        }

        return $response->withCookie(cookie(
            $cookieName,
            $visitorId,
            60 * 24 * (int) config('analytics.cookie_days', 400),
            '/',
            null,
            app()->isProduction(),
            true,
            false,
            'lax'
        ));
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if (! config('analytics.enabled', true) || ! $request->isMethod('GET')) {
            return false;
        }

        if ((string) $request->cookie(config('analytics.internal_cookie', 'bos_internal')) === '1') {
            return false;
        }

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 400) {
            return false;
        }

        if ($request->is('admin*', 'up', 'robots.txt', 'sitemap.xml') || $request->expectsJson()) {
            return false;
        }

        $userAgent = strtolower((string) $request->userAgent());

        return $userAgent === '' || ! preg_match(
            '/bot|crawler|spider|slurp|bingpreview|facebookexternalhit|monitoring|uptime|headless|lighthouse/i',
            $userAgent
        );
    }

    private function countryCode(Request $request): ?string
    {
        foreach (config('analytics.country_headers', []) as $header) {
            $code = $this->normalizeCountryCode($request->header($header));

            if ($code) {
                return $code;
            }
        }

        foreach (config('analytics.country_server_vars', []) as $serverVar) {
            $code = $this->normalizeCountryCode($request->server($serverVar));

            if ($code) {
                return $code;
            }
        }

        return null;
    }

    private function normalizeCountryCode(mixed $value): ?string
    {
        $code = strtoupper(trim((string) $value));

        if (! preg_match('/^[A-Z]{2}$/', $code) || in_array($code, ['XX', 'T1'], true)) {
            return null;
        }

        return $code;
    }

    private function referrerHost(Request $request): ?string
    {
        $host = parse_url((string) $request->headers->get('referer'), PHP_URL_HOST);

        return is_string($host) ? Str::limit(strtolower($host), 255, '') : null;
    }

    private function userAgentFamily(Request $request): ?string
    {
        $userAgent = strtolower((string) $request->userAgent());

        if ($userAgent === '') {
            return null;
        }

        return match (true) {
            str_contains($userAgent, 'edg/') => 'Edge',
            str_contains($userAgent, 'firefox/') || str_contains($userAgent, 'fxios/') => 'Firefox',
            str_contains($userAgent, 'chrome/') || str_contains($userAgent, 'crios/') => 'Chrome',
            str_contains($userAgent, 'safari/') => 'Safari',
            default => 'Other',
        };
    }

    private function deviceType(Request $request): ?string
    {
        $userAgent = strtolower((string) $request->userAgent());

        if ($userAgent === '') {
            return null;
        }

        if (preg_match('/ipad|tablet|kindle|silk\//i', $userAgent)) {
            return 'Tablet';
        }

        if (preg_match('/mobile|iphone|ipod|android.*mobile|windows phone/i', $userAgent)) {
            return 'Mobile';
        }

        return 'Desktop';
    }
}
