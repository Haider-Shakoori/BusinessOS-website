@extends('layouts.admin')

@section('title', 'Search Pages')
@section('page-heading', 'Search Pages')

@section('content')
<div class="admin-page-head">
    <div><span class="admin-kicker">Organic search</span><h1>Search landing pages.</h1><p>Create substantial service pages for real search intent. Avoid thin keyword variants.</p></div>
    <a class="admin-primary-button" href="{{ route('admin.seo-pages.create') }}">New search page <span>+</span></a>
</div>
<section class="admin-panel">
    <div class="cms-table">
        <div class="cms-table-head"><span>Page</span><span>Status</span><span>Updated</span><span></span></div>
        @forelse($pages as $page)
            <div class="cms-table-row">
                <div><strong>{{ $page->title }}</strong><small>/services/{{ $page->slug }}</small></div>
                <span class="status-chip {{ $page->status }}">{{ ucfirst($page->status) }}</span>
                <time datetime="{{ $page->updated_at->toAtomString() }}">{{ $page->updated_at->format('M j, Y') }}</time>
                <a href="{{ route('admin.seo-pages.edit', $page) }}">Edit →</a>
            </div>
        @empty
            <div class="cms-empty">No search landing pages yet.</div>
        @endforelse
    </div>
</section>
@endsection
