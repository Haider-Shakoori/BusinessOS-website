@extends('layouts.admin')

@section('title', 'Overview')
@section('page-heading', 'Overview')

@section('content')
<div class="admin-page-head">
    <div>
        <span class="admin-kicker">Last 30 days</span>
        <h1>Website and content overview.</h1>
        <p>First-party traffic numbers exclude known bots and do not store raw visitor IP addresses.</p>
    </div>
    <a class="admin-primary-button" href="{{ route('admin.guides.create') }}">New guide <span>+</span></a>
</div>

<div class="admin-metric-grid">
    <article><span>ALL VISITS</span><strong>{{ number_format($allVisits) }}</strong><small>Page views</small></article>
    <article><span>UNIQUE VISITS</span><strong>{{ number_format($uniqueVisits) }}</strong><small>Anonymous visitors</small></article>
    <article><span>COUNTRIES</span><strong>{{ number_format($countries) }}</strong><small>Known country codes</small></article>
    <article><span>INQUIRIES</span><strong>{{ number_format($inquiries) }}</strong><small>Contact & demo requests</small></article>
</div>

<div class="admin-panel-grid">
    <section class="admin-panel">
        <div class="admin-panel-head"><div><span>ANALYTICS</span><h2>Understand where visits come from.</h2></div><a href="{{ route('admin.analytics') }}">Open analytics →</a></div>
        <p class="admin-panel-copy">The analytics page separates unique visitors from total page views and breaks both measurements down by country.</p>
        <div class="admin-mini-features"><span>Unique visits by country</span><span>All visits by country</span><span>Top pages</span><span>7 / 30 / 90 day ranges</span></div>
    </section>
    <section class="admin-panel">
        <div class="admin-panel-head"><div><span>CONTENT</span><h2>Publish useful resources.</h2></div><a href="{{ route('admin.guides.index') }}">Manage guides →</a></div>
        <p class="admin-panel-copy">Create draft or published guides with SEO titles and descriptions. Published resources receive their own crawlable URL and Article schema.</p>
    </section>
</div>
@endsection
