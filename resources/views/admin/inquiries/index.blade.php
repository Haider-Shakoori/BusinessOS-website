@extends('layouts.admin')

@section('title', 'Inquiries')
@section('page-heading', 'Inquiries')

@section('content')
<div class="admin-page-head">
    <div>
        <span class="admin-kicker">Sales & demo inbox</span>
        <h1>Customer inquiries.</h1>
        <p>Search, prioritize and follow up on contact, sales and product demo requests.</p>
    </div>
</div>

<div class="admin-metric-grid inquiry-metrics">
    @foreach (['new' => 'NEW', 'in_progress' => 'IN PROGRESS', 'resolved' => 'RESOLVED', 'archived' => 'ARCHIVED'] as $key => $label)
        <article><span>{{ $label }}</span><strong>{{ number_format((int) ($counts[$key] ?? 0)) }}</strong><small>Inquiries</small></article>
    @endforeach
</div>

<section class="admin-panel">
    <form class="admin-filter-bar" method="GET">
        <input type="search" name="q" value="{{ $search }}" placeholder="Search name, email, company or message">
        <select name="status">
            <option value="">All statuses</option>
            @foreach (['new' => 'New', 'in_progress' => 'In progress', 'resolved' => 'Resolved', 'archived' => 'Archived'] as $key => $label)
                <option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>
            @endforeach
        </select>
        <select name="product">
            <option value="">All products</option>
            @foreach ($products as $item)
                <option value="{{ $item->slug }}" @selected($product === $item->slug)>{{ $item->name }}</option>
            @endforeach
        </select>
        <select name="type">
            <option value="">All inquiry types</option>
            <option value="contact" @selected($type === 'contact')>Contact</option>
            <option value="demo" @selected($type === 'demo')>Demo</option>
            <option value="sales" @selected($type === 'sales')>Sales</option>
        </select>
        <button class="admin-secondary-button" type="submit">Filter</button>
    </form>

    <div class="cms-table inquiry-table">
        <div class="cms-table-head"><span>Contact</span><span>Product / type</span><span>Status</span><span>Received</span><span></span></div>
        @forelse ($inquiries as $inquiry)
            <div class="cms-table-row">
                <div>
                    <strong>{{ $inquiry->name }}</strong>
                    <small>{{ $inquiry->email }}@if($inquiry->company) · {{ $inquiry->company }}@endif</small>
                </div>
                <div><strong>{{ $inquiry->app_slug ?: 'General' }}</strong><small>{{ ucfirst($inquiry->inquiry_type) }}</small></div>
                <span class="status-chip {{ $inquiry->status === 'resolved' ? 'published' : 'draft' }}">{{ str($inquiry->status)->replace('_', ' ')->title() }}</span>
                <span>{{ $inquiry->created_at->format('M j, Y H:i') }}</span>
                <a href="{{ route('admin.inquiries.show', $inquiry) }}">Open →</a>
            </div>
        @empty
            <div class="cms-empty">No inquiries match these filters.</div>
        @endforelse
    </div>

    @if ($inquiries->hasPages())
        <div class="admin-pagination">
            @if (!$inquiries->onFirstPage())<a href="{{ $inquiries->previousPageUrl() }}">← Previous</a>@else<span>← Previous</span>@endif
            <span>Page {{ $inquiries->currentPage() }} of {{ $inquiries->lastPage() }}</span>
            @if ($inquiries->hasMorePages())<a href="{{ $inquiries->nextPageUrl() }}">Next →</a>@else<span>Next →</span>@endif
        </div>
    @endif
</section>
@endsection
