@extends('layouts.admin')

@section('title', 'Analytics')
@section('page-heading', 'Website analytics')

@section('content')
<div class="admin-page-head">
    <div>
        <span class="admin-kicker">{{ $days }} day report</span>
        <h1>First-party website analytics.</h1>
        <p>Unique visits are based on an anonymous browser cookie. All visits count every tracked page view.</p>
    </div>
    <nav class="range-switch" aria-label="Analytics date range">
        @foreach ([7, 30, 90] as $range)
            <a class="{{ $days === $range ? 'active' : '' }}" href="{{ route('admin.analytics', ['days' => $range]) }}">{{ $range }}d</a>
        @endforeach
    </nav>
</div>

<div class="admin-metric-grid analytics-metrics">
    <article><span>ALL VISITS</span><strong>{{ number_format($allVisits) }}</strong><small>Every page view</small></article>
    <article><span>UNIQUE VISITS</span><strong>{{ number_format($uniqueVisits) }}</strong><small>Distinct anonymous visitors</small></article>
    <article><span>KNOWN COUNTRIES</span><strong>{{ number_format($allByCountry->where('code', '!=', 'Unknown')->count()) }}</strong><small>Country groups</small></article>
    <article><span>FROM</span><strong class="metric-date">{{ $start->format('M j') }}</strong><small>through today</small></article>
</div>

<div class="analytics-country-grid">
    <section class="admin-panel analytics-country-panel">
        <div class="admin-panel-head">
            <div><span>UNIQUE VISITS</span><h2>Unique visits by country</h2></div>
            <strong>{{ number_format($uniqueVisits) }}</strong>
        </div>
        <p class="admin-panel-copy">Each anonymous visitor is counted once in the selected period, then grouped by the country signal supplied by the host or CDN.</p>

        @php($uniqueMax = max(1, (int) ($uniqueByCountry->max('total') ?? 1)))
        <div class="country-table">
            @forelse ($uniqueByCountry as $row)
                <div class="country-row">
                    <span class="country-code">{{ $row['code'] === 'Unknown' ? '—' : $row['code'] }}</span>
                    <div class="country-name"><strong>{{ $row['name'] }}</strong><i style="--bar: {{ round(($row['total'] / $uniqueMax) * 100) }}%"></i></div>
                    <b>{{ number_format($row['total']) }}</b>
                </div>
            @empty
                <div class="analytics-empty">No unique visits recorded in this period.</div>
            @endforelse
        </div>
    </section>

    <section class="admin-panel analytics-country-panel">
        <div class="admin-panel-head">
            <div><span>ALL VISITS</span><h2>All visits by country</h2></div>
            <strong>{{ number_format($allVisits) }}</strong>
        </div>
        <p class="admin-panel-copy">Every tracked page view is counted, so repeat browsing by the same visitor is included here.</p>

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
        <div class="admin-panel-head"><div><span>PAGES</span><h2>Most visited pages</h2></div></div>
        <div class="analytics-table">
            <div class="analytics-table-head"><span>Page</span><span>Unique</span><span>All</span></div>
            @forelse ($topPages as $page)
                <div><span title="{{ $page->path }}">{{ $page->path }}</span><b>{{ number_format($page->unique_total) }}</b><b>{{ number_format($page->total) }}</b></div>
            @empty
                <p class="analytics-empty">No page activity yet.</p>
            @endforelse
        </div>
    </section>

    <section class="admin-panel">
        <div class="admin-panel-head"><div><span>DAILY</span><h2>Visits over time</h2></div></div>
        @php($dailyMax = max(1, (int) ($daily->max('total') ?? 1)))
        <div class="daily-bars">
            @forelse ($daily as $day)
                <div title="{{ $day->day }} — {{ $day->total }} visits / {{ $day->unique_total }} unique">
                    <i style="--height: {{ max(5, round(($day->total / $dailyMax) * 100)) }}%"></i>
                    <span>{{ (int) substr($day->day, 8, 2) }}</span>
                </div>
            @empty
                <p class="analytics-empty">No daily traffic yet.</p>
            @endforelse
        </div>
    </section>
</div>

<div class="analytics-note">
    <strong>Country detection</strong>
    <p>Country is recorded only when your CDN or hosting environment provides a trusted country code header. Otherwise the visit is shown as Unknown. BusinessOS analytics does not call an external geolocation API or store raw IP addresses.</p>
</div>
@endsection
