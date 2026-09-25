@extends('layouts.admin')

@section('title', 'Overview')
@section('page-heading', 'Overview')

@section('content')
<div class="admin-page-head">
    <div>
        <span class="admin-kicker">BusinessOS CMS</span>
        <h1>Website, products and customer interest.</h1>
        <p>Manage the public product catalog, inquiries, content, media and first-party website analytics from one workspace.</p>
    </div>
    <a class="admin-primary-button" href="{{ route('admin.products.create') }}">New product <span>+</span></a>
</div>

<div class="admin-metric-grid">
    <article><span>ALL VISITS</span><strong>{{ number_format($allVisits) }}</strong><small>Last 30 days</small></article>
    <article><span>UNIQUE VISITS</span><strong>{{ number_format($uniqueVisits) }}</strong><small>Anonymous visitors</small></article>
    <article><span>LIVE PRODUCTS</span><strong>{{ number_format($products) }}</strong><small>Published & visible</small></article>
    <article><span>NEW INQUIRIES</span><strong>{{ number_format($newInquiries) }}</strong><small>Need follow-up</small></article>
</div>

<div class="admin-panel-grid">
    <section class="admin-panel">
        <div class="admin-panel-head"><div><span>PRODUCT CMS</span><h2>Manage the BusinessOS ecosystem.</h2></div><a href="{{ route('admin.products.index') }}">Manage products →</a></div>
        <p class="admin-panel-copy">Product names, subdomains, status, product stories, SEO, localized copy, commercial information and homepage ordering are CMS-managed.</p>
        <div class="admin-mini-features"><span>{{ $products }} live products</span><span>Homepage ordering</span><span>Dari & Pashto copy</span><span>Pricing & rollout</span></div>
    </section>

    <section class="admin-panel">
        <div class="admin-panel-head"><div><span>INQUIRIES</span><h2>Follow up without losing context.</h2></div><a href="{{ route('admin.inquiries.index') }}">Open inbox →</a></div>
        <p class="admin-panel-copy">Move requests through New, In Progress, Resolved and Archived states, schedule follow-ups and maintain internal notes.</p>
        <div class="admin-mini-features"><span>{{ $inquiries }} requests in 30 days</span><span>{{ $newInquiries }} new</span><span>Product filters</span><span>Internal history</span></div>
    </section>

    <section class="admin-panel">
        <div class="admin-panel-head"><div><span>MEDIA & CONTENT</span><h2>Publish without code changes.</h2></div><a href="{{ route('admin.media.index') }}">Open media →</a></div>
        <p class="admin-panel-copy">Upload product screenshots, publish guides and manage website-wide brand, homepage, contact and SEO content.</p>
        <div class="admin-mini-features"><span>{{ $publishedGuides }} published guides</span><span>WebP / AVIF where supported</span><span>Global settings</span><span>SEO defaults</span></div>
    </section>

    <section class="admin-panel">
        <div class="admin-panel-head"><div><span>ANALYTICS</span><h2>Understand website demand.</h2></div><a href="{{ route('admin.analytics') }}">Open analytics →</a></div>
        <p class="admin-panel-copy">First-party traffic excludes known bots and does not store raw visitor IP addresses.</p>
        <div class="admin-mini-features"><span>{{ $countries }} known countries</span><span>Top pages</span><span>Unique visits</span><span>7 / 30 / 90 day ranges</span></div>
    </section>
</div>

<section class="admin-panel">
    <div class="admin-panel-head"><div><span>LATEST INQUIRIES</span><h2>Recent customer requests.</h2></div><a href="{{ route('admin.inquiries.index') }}">View all →</a></div>
    <div class="cms-table">
        <div class="cms-table-head"><span>Contact</span><span>Product</span><span>Status</span><span></span></div>
        @forelse($latestInquiries as $inquiry)
            <div class="cms-table-row">
                <div><strong>{{ $inquiry->name }}</strong><small>{{ $inquiry->email }}</small></div>
                <span>{{ $inquiry->app_slug ?: 'General' }}</span>
                <span class="status-chip {{ $inquiry->status === 'resolved' ? 'published' : 'draft' }}">{{ str($inquiry->status)->replace('_',' ')->title() }}</span>
                <a href="{{ route('admin.inquiries.show', $inquiry) }}">Open →</a>
            </div>
        @empty
            <div class="cms-empty">No inquiries yet.</div>
        @endforelse
    </div>
</section>
@endsection
