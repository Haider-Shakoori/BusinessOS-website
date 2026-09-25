@extends('layouts.admin')

@section('title', $caseStudy->exists ? 'Edit Case Study' : 'New Case Study')
@section('page-heading', $caseStudy->exists ? 'Edit Case Study' : 'New Case Study')

@section('content')
<div class="admin-page-head">
    <div><span class="admin-kicker">Authority content</span><h1>{{ $caseStudy->exists ? $caseStudy->title : 'Create a verified case study.' }}</h1><p>Describe the problem, implementation and outcome accurately. Keep unverifiable claims out.</p></div>
    @if($caseStudy->exists && $caseStudy->status === 'published')<a class="admin-secondary-button" href="{{ route('case-studies.show', $caseStudy) }}" target="_blank" rel="noopener">View live ↗</a>@endif
</div>
<form class="cms-editor" method="POST" action="{{ $caseStudy->exists ? route('admin.case-studies.update', $caseStudy) : route('admin.case-studies.store') }}">
    @csrf @if($caseStudy->exists) @method('PUT') @endif
    <div class="cms-editor-main">
        <section class="admin-panel admin-form">
            <label>Title<input name="title" maxlength="190" value="{{ old('title', $caseStudy->title) }}" required></label>
            <div class="admin-form-row">
                <label>Slug<input name="slug" maxlength="190" value="{{ old('slug', $caseStudy->slug) }}"></label>
                <label>Industry<input name="industry" maxlength="120" value="{{ old('industry', $caseStudy->industry) }}" required></label>
            </div>
            <label>Summary<textarea name="summary" rows="4" required>{{ old('summary', $caseStudy->summary) }}</textarea></label>
            <label>Challenge<textarea class="cms-content-editor" name="challenge" rows="12" required>{{ old('challenge', $caseStudy->challenge) }}</textarea></label>
            <label>Solution<textarea class="cms-content-editor" name="solution" rows="14" required>{{ old('solution', $caseStudy->solution) }}</textarea></label>
            <label>Outcome <span>use only verified outcomes</span><textarea name="outcome" rows="10">{{ old('outcome', $caseStudy->outcome) }}</textarea></label>
        </section>
        <section class="admin-panel admin-form">
            <div class="admin-form-section-head"><span>SEARCH</span><h2>SEO metadata</h2></div>
            <label>SEO title<input name="meta_title" maxlength="190" value="{{ old('meta_title', $caseStudy->meta_title) }}"></label>
            <label>Meta description<textarea name="meta_description" rows="3" maxlength="255">{{ old('meta_description', $caseStudy->meta_description) }}</textarea></label>
        </section>
    </div>
    <aside class="cms-editor-side">
        <section class="admin-panel admin-form">
            <label>Status<select name="status"><option value="draft" @selected(old('status', $caseStudy->status ?: 'draft') === 'draft')>Draft</option><option value="published" @selected(old('status', $caseStudy->status) === 'published')>Published</option></select></label>
            <button class="admin-primary-button" type="submit">{{ $caseStudy->exists ? 'Save changes' : 'Create case study' }}</button>
        </section>
        @if($caseStudy->exists)<section class="admin-panel danger-panel"><button class="danger-button" type="submit" form="delete-case-study">Move to trash</button></section>@endif
    </aside>
</form>
@if($caseStudy->exists)<form id="delete-case-study" method="POST" action="{{ route('admin.case-studies.destroy', $caseStudy) }}">@csrf @method('DELETE')</form>@endif
@endsection
