@extends('layouts.admin')

@section('title', 'Guides')
@section('page-heading', 'Guides')

@section('content')
<div class="admin-page-head">
    <div>
        <span class="admin-kicker">Content</span>
        <h1>Guides & resources.</h1>
        <p>Create useful, indexable resources without publishing thin placeholder pages.</p>
    </div>
    <a class="admin-primary-button" href="{{ route('admin.guides.create') }}">New guide <span>+</span></a>
</div>

<section class="admin-panel">
    <div class="cms-table">
        <div class="cms-table-head"><span>Guide</span><span>Status</span><span>Updated</span><span></span></div>
        @forelse ($guides as $guide)
            <div class="cms-table-row">
                <div><strong>{{ $guide->title }}</strong><small>/guides/{{ $guide->slug }}</small></div>
                <span class="status-chip {{ $guide->status }}">{{ ucfirst($guide->status) }}</span>
                <time datetime="{{ $guide->updated_at->toAtomString() }}">{{ $guide->updated_at->format('M j, Y') }}</time>
                <a href="{{ route('admin.guides.edit', $guide) }}">Edit →</a>
            </div>
        @empty
            <div class="cms-empty">No guides yet. Create the first resource.</div>
        @endforelse
    </div>

    @if ($guides->hasPages())
        <div class="admin-pagination">
            @if (!$guides->onFirstPage())<a href="{{ $guides->previousPageUrl() }}">← Previous</a>@else<span>← Previous</span>@endif
            <span>Page {{ $guides->currentPage() }} of {{ $guides->lastPage() }}</span>
            @if ($guides->hasMorePages())<a href="{{ $guides->nextPageUrl() }}">Next →</a>@else<span>Next →</span>@endif
        </div>
    @endif
</section>
@endsection
