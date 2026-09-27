@extends('layouts.admin')

@section('title', 'Analytics')
@section('page-heading', 'Website analytics')

@section('content')
<div class="admin-page-head">
    <div>
        <span class="admin-kicker">{{ $days }} day report</span>
        <h1>First-party website analytics.</h1>
        <p>Human traffic is separated from search crawlers, AI / LLM crawlers and other automated clients — without storing raw visitor IP addresses.</p>
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
    <article><span>HUMAN PAGE VIEWS</span><strong>{{ number_format($allVisits) }}</strong><small>Automated traffic excluded</small></article>
    <article><span>HUMAN VISITORS</span><strong>{{ number_format($uniqueVisits) }}</strong><small>Distinct anonymous browser IDs</small></article>
    <article><span>AUTOMATED REQUESTS</span><strong>{{ number_format($automatedHits) }}</strong><small>Search, AI and other bots tracked separately</small></article>
    <article><span>COUNTRY COVERAGE</span><strong>{{ number_format($countryCoverage) }}%</strong><small>{{ number_format($knownCountryViews) }} human views had a trusted country signal</small></article>
</div>

<div class="admin-panel-grid analytics-bottom">
    <section class="admin-panel">
        <div class="admin-panel-head"><div><span>AUTOMATION</span><h2>Automated traffic by category</h2></div><strong>{{ number_format($automatedHits) }}</strong></div>
        <p class="admin-panel-copy">These requests are excluded from every human visitor, country, acquisition and content-interest KPI below.</p>
        <div class="analytics-table">
            <div class="analytics-table-head"><span>Category</span><span></span><span>Requests</span></div>
            @foreach ($trafficSummary as $traffic)
                <div><span>{{ $traffic->label }}</span><b></b><b>{{ number_format($traffic->total) }}</b></div>
            @endforeach
        </div>
    </section>

    <section class="admin-panel">
        <div class="admin-panel-head"><div><span>AUTOMATED CLIENTS</span><h2>Top crawlers, bots & scanners</h2></div></div>
        <p class="admin-panel-copy">Identified from the request user agent. Bot IP addresses are not stored in analytics.</p>
        <div class="analytics-table">
            <div class="analytics-table-head"><span>Client</span><span>Type</span><span>Requests</span></div>
            @forelse ($botFamilies as $bot)
                @php($typeLabel = match ($bot->traffic_type) {
                    'search_crawler' => 'Search',
                    'ai_crawler' => 'AI / LLM',
                    default => 'Other bot',
                })
                <div><span>{{ $bot->label }}</span><b>{{ $typeLabel }}</b><b>{{ number_format($bot->total) }}</b></div>
            @empty
                <p class="analytics-empty">No automated traffic recorded in this period.</p>
            @endforelse
        </div>
    </section>
</div>

@if ($legacyVisits > 0)
    <div class="analytics-note">
        <strong>{{ number_format($legacyVisits) }} historical views are unclassified</strong>
        <p>They were collected before human/bot separation was enabled, so they are preserved for audit purposes but excluded from the human KPIs above. New traffic is classified at request time.</p>
    </div>
@endif

<div class="analytics-country-grid">
    <section class="admin-panel analytics-country-panel">
        <div class="admin-panel-head">
            <div><span>VISITORS</span><h2>Visitors by country</h2></div>
            <strong>{{ number_format($uniqueVisits) }}</strong>
        </div>
        <p class="admin-panel-copy">Human visitors only. Each anonymous browser is counted once in the selected period and automated clients are excluded.</p>

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
        <p class="admin-panel-copy">Human page views only. Repeat browsing is included, while search crawlers, AI crawlers and other bots are excluded.</p>

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
        <div class="admin-panel-head"><div><span>PRODUCT INTEREST</span><h2>Product pages human visitors viewed</h2></div></div>
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
    <p>Human visitors are anonymous browser IDs, not verified people. Search / Google crawlers, AI / LLM crawlers, scanners and scripted clients are classified separately and never contribute to the human KPIs. Country uses trusted host/CDN signals when available and otherwise resolves the request IP locally against DB-IP Country Lite; raw visitor IP addresses are never stored or sent to an external geolocation API. <a href="https://db-ip.com" target="_blank" rel="noopener noreferrer">IP Geolocation by DB-IP</a>. Use “Exclude my browser” above to remove your own browser history and stop future public-page visits from affecting the report.</p>
</div>
@endsection