<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use App\Models\Inquiry;
use App\Models\PageVisit;
use App\Models\Product;
use Illuminate\Http\Request;
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

        return view('admin.analytics.index', [
            'days' => $days,
            'start' => $start,
            'allVisits' => (clone $base)->count(),
            'uniqueVisits' => (clone $base)->distinct('visitor_id')->count('visitor_id'),
            'allByCountry' => $allByCountry,
            'uniqueByCountry' => $uniqueByCountry,
            'topPages' => $topPages,
            'daily' => $daily,
        ]);
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

[executed on device: ubuntu-6gb-dal-x8mx (c447f909-fdcc-4121-9924-27a69d35e9b2)]