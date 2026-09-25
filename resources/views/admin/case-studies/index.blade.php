@extends('layouts.admin')

@section('title', 'Case Studies')
@section('page-heading', 'Case Studies')

@section('content')
<div class="admin-page-head">
    <div><span class="admin-kicker">Authority content</span><h1>Case studies.</h1><p>Publish only evidence-backed implementation stories. Do not invent client names, metrics or outcomes.</p></div>
    <a class="admin-primary-button" href="{{ route('admin.case-studies.create') }}">New case study <span>+</span></a>
</div>
<section class="admin-panel">
    <div class="cms-table">
        <div class="cms-table-head"><span>Case study</span><span>Status</span><span>Updated</span><span></span></div>
        @forelse($caseStudies as $caseStudy)
            <div class="cms-table-row">
                <div><strong>{{ $caseStudy->title }}</strong><small>{{ $caseStudy->industry }}</small></div>
                <span class="status-chip {{ $caseStudy->status }}">{{ ucfirst($caseStudy->status) }}</span>
                <time datetime="{{ $caseStudy->updated_at->toAtomString() }}">{{ $caseStudy->updated_at->format('M j, Y') }}</time>
                <a href="{{ route('admin.case-studies.edit', $caseStudy) }}">Edit →</a>
            </div>
        @empty
            <div class="cms-empty">No case studies yet.</div>
        @endforelse
    </div>
</section>
@endsection
