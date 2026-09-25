@extends('layouts.marketing')

@section('content')
<article class="guide-page">
    <header class="guide-header">
        <div class="shell guide-shell">
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span>/</span>
                <a href="{{ route('case-studies.index') }}">Case studies</a><span>/</span>
                <strong>{{ $caseStudy->industry }}</strong>
            </nav>
            <span class="kicker">{{ $caseStudy->industry }}</span>
            <h1>{{ $caseStudy->title }}</h1>
            <p>{{ $caseStudy->summary }}</p>
            <div class="guide-meta">
                <span>BusinessOS</span>
                <time datetime="{{ $caseStudy->published_at?->toDateString() }}">{{ $caseStudy->published_at?->format('F j, Y') }}</time>
            </div>
        </div>
    </header>

    <section class="section guide-body-section">
        <div class="shell guide-shell">
            <div class="guide-body">
                <h2>The challenge</h2>
                @foreach(preg_split('/\R{2,}/', trim($caseStudy->challenge)) as $paragraph)<p>{{ $paragraph }}</p>@endforeach
                <h2>The solution</h2>
                @foreach(preg_split('/\R{2,}/', trim($caseStudy->solution)) as $paragraph)<p>{{ $paragraph }}</p>@endforeach
                @if($caseStudy->outcome)
                    <h2>The outcome</h2>
                    @foreach(preg_split('/\R{2,}/', trim($caseStudy->outcome)) as $paragraph)<p>{{ $paragraph }}</p>@endforeach
                @endif
            </div>
            <div class="guide-end">
                <span class="kicker">BusinessOS implementation</span>
                <h2>Have a similar operational problem?</h2>
                <div class="hero-actions">
                    <a class="button button-primary" href="{{ route('contact') }}">Discuss your workflow <span>→</span></a>
                    <a class="button button-ghost" href="{{ route('case-studies.index') }}">More case studies</a>
                </div>
            </div>
        </div>
    </section>
</article>
@endsection
