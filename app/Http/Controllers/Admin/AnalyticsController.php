<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use App\Models\Inquiry;
use App\Models\PageVisit;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function dashboard(): View
    {
        $start = now()->subDays(29)->startOfDay();

        return view('admin.dashboard', [
            'allVisits' => PageVisit::where('occurred_at', '>=', $start)->count(),
            'uniqueVisits' => PageVisit::where('occurred_at', '>=', $start)->distinct('visitor_id')->count('visitor_id'),
            'countries' => PageVisit::where('occurred_at', '>=', $start)->whereNotNull('country_code')->distinct('country_code')->count('country_code'),
            'inquiries' => Inquiry::where('created_at', '>=', $start)->count(),
            'newInquiries' => Inquiry::where('status', 'new')->count(),
            'products' => Product::query()->publiclyVisible()->count(),
            'publishedGuides' => Guide::query()->published()->count(),
            'latestInquiries' => Inquiry::query()->latest()->limit(6)->get(),
        ]);
    }

    public function index(Request $request): View
    {
        $days = in_array((int) $request->integer('days', 30), [7, 30, 90], true)
            ? (int) $request->integer('days', 30)
            : 30;

        $start = now()->subDays($days - 1)->startOfDay();
        $base = PageVisit::query()->where('occurred_at', '>=', $start);

        $allVisits = (clone $base)->count();
        $uniqueVisits = (clone $base)->distinct('visitor_id')->count('visitor_id');
        $knownCountryViews = (clone $base)->whereNotNull('country_code')->count();
        $countryCoverage = $allVisits > 0 ? (int) round(($knownCountryViews / $allVisits) * 100) : 0;

        $allByCountry = (clone $base)
            ->selectRaw("COALESCE(country_code, 'Unknown') as country, COUNT(*) as total")
            ->groupBy('country')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($row) => [
                'code' => $row->country,
                'name' => $this->countryName($row->country),
                'total' => (int) $row->total,
            ]);

        $uniqueByCountry = (clone $base)
            ->selectRaw("COALESCE(country_code, 'Unknown') as country, COUNT(DISTINCT visitor_id) as total")
            ->groupBy('country')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($row) => [
                'code' => $row->country,
                'name' => $this->countryName($row->country),
                'total' => (int) $row->total,
            ]);

        $topPages = (clone $base)
            ->selectRaw('path, COUNT(*) as total, COUNT(DISTINCT visitor_id) as unique_total')
            ->groupBy('path')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $daily = (clone $base)
            ->selectRaw('DATE(occurred_at) as day, COUNT(*) as total, COUNT(DISTINCT visitor_id) as unique_total')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $siteHost = strtolower((string) parse_url((string) config('app.url'), PHP_URL_HOST));

        $topReferrers = (clone $base)
            ->whereNotNull('referrer_host')
            ->where('referrer_host', '!=', '')
            ->when($siteHost !== '', fn ($query) => $query->where('referrer_host', '!=', $siteHost))
            ->selectRaw('referrer_host as label, COUNT(*) as total, COUNT(DISTINCT visitor_id) as unique_total')
            ->groupBy('referrer_host')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $directVisits = (clone $base)
            ->where(function ($query): void {
                $query->whereNull('referrer_host')->orWhere('referrer_host', '');
            })
            ->count();

        $browsers = (clone $base)
            ->selectRaw("COALESCE(user_agent_family, 'Unknown') as label, COUNT(*) as total, COUNT(DISTINCT visitor_id) as unique_total")
            ->groupBy('user_agent_family')
            ->orderByDesc('total')
            ->get();

        $devices = (clone $base)
            ->selectRaw("COALESCE(device_type, 'Unknown') as label, COUNT(*) as total, COUNT(DISTINCT visitor_id) as unique_total")
            ->groupBy('device_type')
            ->orderByDesc('total')
            ->get();

        $landingPages = (clone $base)
            ->orderBy('occurred_at')
            ->orderBy('id')
            ->get(['visitor_id', 'path'])
            ->unique('visitor_id')
            ->countBy('path')
            ->sortDesc()
            ->take(8)
            ->map(fn ($total, $path) => (object) [
                'path' => $path,
                'total' => (int) $total,
            ])
            ->values();

        $productInterest = (clone $base)
            ->where('path', 'like', '/apps/%')
            ->selectRaw('path, COUNT(*) as total, COUNT(DISTINCT visitor_id) as unique_total')
            ->groupBy('path')
            ->orderByDesc('unique_total')
            ->limit(10)
            ->get()
            ->map(function ($row) {
                $slug = trim(Str::after((string) $row->path, '/apps/'), '/');

                return (object) [
                    'slug' => $slug,
                    'label' => $slug !== '' ? Str::headline($slug) : 'Unknown product',
                    'path' => $row->path,
                    'total' => (int) $row->total,
                    'unique_total' => (int) $row->unique_total,
                ];
            });

        return view('admin.analytics.index', [
            'days' => $days,
            'start' => $start,
            'allVisits' => $allVisits,
            'uniqueVisits' => $uniqueVisits,
            'allByCountry' => $allByCountry,
            'uniqueByCountry' => $uniqueByCountry,
            'knownCountryViews' => $knownCountryViews,
            'countryCoverage' => $countryCoverage,
            'topPages' => $topPages,
            'daily' => $daily,
            'topReferrers' => $topReferrers,
            'directVisits' => $directVisits,
            'browsers' => $browsers,
            'devices' => $devices,
            'landingPages' => $landingPages,
            'productInterest' => $productInterest,
            'internalBrowserExcluded' => (string) $request->cookie(config('analytics.internal_cookie', 'bos_internal')) === '1',
        ]);
    }

    public function excludeBrowser(Request $request): RedirectResponse
    {
        $visitorCookie = config('analytics.visitor_cookie', 'bos_vid');
        $internalCookie = config('analytics.internal_cookie', 'bos_internal');
        $visitorId = $request->cookie($visitorCookie);
        $deleted = 0;

        if (is_string($visitorId) && Str::isUuid($visitorId)) {
            $deleted = PageVisit::where('visitor_id', $visitorId)->delete();
        }

        return redirect()
            ->route('admin.analytics')
            ->with('status', "This browser is now excluded from analytics. {$deleted} historical page views from this browser were removed.")
            ->withCookie(cookie(
                $internalCookie,
                '1',
                60 * 24 * 365 * 5,
                '/',
                null,
                app()->isProduction(),
                true,
                false,
                'lax'
            ));
    }

    public function includeBrowser(): RedirectResponse
    {
        return redirect()
            ->route('admin.analytics')
            ->with('status', 'This browser will be included in analytics again on future public-page visits.')
            ->withCookie(cookie()->forget(config('analytics.internal_cookie', 'bos_internal')));
    }

    private function countryName(?string $code): string
    {
        if (! $code || $code === 'Unknown') {
            return 'Unknown';
        }

        $configured = config('analytics.country_names.'.$code);

        if (is_string($configured) && $configured !== '') {
            return $configured;
        }

        if (class_exists(\Locale::class)) {
            $name = \Locale::getDisplayRegion('-'.$code, 'en');

            if (is_string($name) && $name !== '') {
                return $name;
            }
        }

        return $code;
    }
}
