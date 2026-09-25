@extends('layouts.admin')

@section('title', 'Analytics')
@section('page-heading', 'Website analytics')

@section('content')
<div class="admin-page-head">
    <div>
        <span class="admin-kicker">{{ $days }} day report</span>
        <h1>First-party website analytics.</h1>
        <p>Page views, anonymous visitors, acquisition sources, landing pages, product interest and audience signals — without storing raw visitor IP addresses.</p>
    </div>
    <div style="display:grid;gap:9px;justify-items:end">
        <nav class="range-switch" aria-label="Analytics date range">
            @foreach ([7, 30, 90] as $range)
                <a class="{{ $days === $range ? 'active' : '' }}" href="{{ route('admin.analytics', ['days' => $range]) }}">{{ $range }}d</a>
            @endforeach
        </nav>

        @if ($internalBrowserExcluded)
            <form method="POST" action="{{ route('admin.analytics.include-browser') }}">
                @csrf
                <button class="admin-secondary-button" type="submit">Include this browser</button>
            </form>
        @else
            <form method="POST" action="{{ route('admin.analytics.exclude-browser') }}" onsubmit="return confirm('Exclude this browser and remove its existing analytics history?')">
                @csrf
                <button class="admin-secondary-button" type="submit">Exclude my browser from analytics</button>
            </form>
        @endif
    </div>
</div>

<div class="admin-metric-grid analytics-metrics">
    <article><span>PAGE VIEWS</span><strong>{{ number_format($allVisits) }}</strong><small>Every tracked public-page view</small></article>
    <article><span>VISITORS</span><strong>{{ number_format($uniqueVisits) }}</strong><small>Distinct anonymous browser IDs</small></article>
    <article><span>COUNTRY COVERAGE</span><strong>{{ number_format($countryCoverage) }}%</strong><small>{{ number_format($knownCountryViews) }} views had a trusted country signal</small></article>
    <article><span>FROM</span><strong class="metric-date">{{ $start->format('M j') }}</strong><small>through today</small></article>
</div>

<div class="analytics-country-grid">
    <section class="admin-panel analytics-country-panel">
        <div class="admin-panel-head">
            <div><span>VISITORS</span><h2>Visitors by country</h2></div>
            <strong>{{ number_format($uniqueVisits) }}</strong>
        </div>
        <p class="admin-panel-copy">Each anonymous browser is counted once in the selected period, grouped only when the host or CDN supplies a trusted ISO country code.</p>

        @php($uniqueMax = max(1, (int) ($uniqueByCountry->max('total') ?? 1)))
        <div class="country-table">
            @forelse ($uniqueByCountry as $row)
                <div class="country-row">
                    <span class="country-code">{{ $row['code'] === 'Unknown' ? '—' : $row['code'] }}</span>
                    <div class="country-name"><strong>{{ $row['name'] }}</strong><i style="--bar: {{ round(($row['total'] / $uniqueMax) * 100) }}%"></i></div>
                    <b>{{ number_format($row['total']) }}</b>
                </div>
            @empty
                <div class="analytics-empty">No visitors recorded in this period.</div>
            @endforelse
        </div>
    </section>

    <section class="admin-panel analytics-country-panel">
        <div class="admin-panel-head">
            <div><span>PAGE VIEWS</span><h2>Page views by country</h2></div>
            <strong>{{ number_format($allVisits) }}</strong>
        </div>
        <p class="admin-panel-copy">Repeat browsing is included here, so this shows traffic volume rather than people.</p>

        @php($allMax = max(1, (int) ($allByCountry->max('total') ?? 1)))
        <div class="country-table">
            @forelse ($allByCountry as $row)
                <div class="country-row">
                    <span class="country-code">{{ $row['code'] === 'Unknown' ? '—' : $row['code'] }}</span>
                    <div class="country-name"><strong>{{ $row['name'] }}</strong><i style="--bar: {{ round(($row['total'] / $allMax) * 100) }}%"></i></div>
                    <b>{{ number_format($row['total']) }}</b>
                </div>
            @empty
                <div class="analytics-empty">No page views recorded in this period.</div>
            @endforelse
        </div>
    </section>
</div>

<div class="admin-panel-grid analytics-bottom">
    <section class="admin-panel">
        <div class="admin-panel-head"><div><span>ACQUISITION</span><h2>External referrers</h2></div><strong>{{ number_format($directVisits) }}</strong></div>
        <p class="admin-panel-copy">The number at right is direct / unknown page views. The table shows external sites that actually sent traffic.</p>
        <div class="analytics-table">
            <div class="analytics-table-head"><span>Source</span><span>Visitors</span><span>Views</span></div>
            @forelse ($topReferrers as $source)
                <div><span>{{ $source->label }}</span><b>{{ number_format($source->unique_total) }}</b><b>{{ number_format($source->total) }}</b></div>
            @empty
                <p class="analytics-empty">No external referrers recorded in this period.</p>
            @endforelse
        </div>
    </section>

    <section class="admin-panel">
        <div class="admin-panel-head"><div><span>LANDING PAGES</span><h2>Where visitors entered</h2></div></div>
        <p class="admin-panel-copy">The first tracked page for each anonymous visitor in the selected period.</p>
        <div class="analytics-table">
            <div class="analytics-table-head"><span>Landing page</span><span>Visitors</span><span></span></div>
            @forelse ($landingPages as $page)
                <div><span title="{{ $page->path }}">{{ $page->path }}</span><b>{{ number_format($page->total) }}</b><b></b></div>
            @empty
                <p class="analytics-empty">No landing-page data yet.</p>
            @endforelse
        </div>
    </section>
</div>

<div class="admin-panel-grid analytics-bottom">
    <section class="admin-panel">
        <div class="admin-panel-head"><div><span>PRODUCT INTEREST</span><h2>Product pages people viewed</h2></div></div>
        <p class="admin-panel-copy">Useful for seeing which BusinessOS products are attracting attention before an inquiry is submitted.</p>
        <div class="analytics-table">
            <div class="analytics-table-head"><span>Product</span><span>Visitors</span><span>Views</span></div>
            @forelse ($productInterest as $product)
                <div><span title="{{ $product->path }}">{{ $product->label }}</span><b>{{ number_format($product->unique_total) }}</b><b>{{ number_format($product->total) }}</b></div>
            @empty
                <p class="analytics-empty">No product-page activity yet.</p>
            @endforelse
        </div>
    </section>

    <section class="admin-panel">
        <div class="admin-panel-head"><div><span>PAGES</span><h2>Most visited pages</h2></div></div>
        <div class="analytics-table">
            <div class="analytics-table-head"><span>Page</span><span>Visitors</span><span>Views</span></div>
            @forelse ($topPages as $page)
                <div><span title="{{ $page->path }}">{{ $page->path }}</span><b>{{ number_format($page->unique_total) }}</b><b>{{ number_format($page->total) }}</b></div>
            @empty
                <p class="analytics-empty">No page activity yet.</p>
            @endforelse
        </div>
    </section>
</div>

<div class="admin-panel-grid analytics-bottom">
    <section class="admin-panel">
        <div class="admin-panel-head"><div><span>BROWSERS</span><h2>Browser mix</h2></div></div>
        <div class="analytics-table">
            <div class="analytics-table-head"><span>Browser</span><span>Visitors</span><span>Views</span></div>
            @forelse ($browsers as $browser)
                <div><span>{{ $browser->label }}</span><b>{{ number_format($browser->unique_total) }}</b><b>{{ number_format($browser->total) }}</b></div>
            @empty
                <p class="analytics-empty">No browser data yet.</p>
            @endforelse
        </div>
    </section>

    <section class="admin-panel">
        <div class="admin-panel-head"><div><span>DEVICES</span><h2>Device mix</h2></div></div>
        <p class="admin-panel-copy">Device type is recorded from the user agent after this analytics upgrade. Older visits may appear as Unknown.</p>
        <div class="analytics-table">
            <div class="analytics-table-head"><span>Device</span><span>Visitors</span><span>Views</span></div>
            @forelse ($devices as $device)
                <div><span>{{ $device->label }}</span><b>{{ number_format($device->unique_total) }}</b><b>{{ number_format($device->total) }}</b></div>
            @empty
                <p class="analytics-empty">No device data yet.</p>
            @endforelse
        </div>
    </section>
</div>

<section class="admin-panel analytics-bottom">
    <div class="admin-panel-head"><div><span>DAILY</span><h2>Traffic over time</h2></div></div>
    @php($dailyMax = max(1, (int) ($daily->max('total') ?? 1)))
    <div class="daily-bars">
        @forelse ($daily as $day)
            <div title="{{ $day->day }} — {{ $day->total }} page views / {{ $day->unique_total }} visitors">
                <i style="--height: {{ max(5, round(($day->total / $dailyMax) * 100)) }}%"></i>
                <span>{{ (int) substr($day->day, 8, 2) }}</span>
            </div>
        @empty
            <p class="analytics-empty">No daily traffic yet.</p>
        @endforelse
    </div>
</section>

<div class="analytics-note">
    <strong>How to read these numbers</strong>
    <p>Visitors are anonymous browser IDs, not verified people. Obvious bots, admin pages, health checks, robots.txt and sitemap requests are excluded. Country is recorded only from trusted host/CDN country signals; BusinessOS does not send visitor IPs to an external geolocation service. Use “Exclude my browser” above to remove your own browser history and stop future public-page visits from affecting the report.</p>
</div>
@endsection
