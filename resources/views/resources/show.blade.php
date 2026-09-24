@extends('layouts.marketing')

@section('content')
<article class="guide-page">
    <header class="guide-header">
        <div class="shell guide-shell">
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span>/</span>
                <a href="{{ route('resources.index') }}">Resources</a><span>/</span>
                <strong>{{ $guide->category }}</strong>
            </nav>
            <span class="kicker">{{ $guide->category }}</span>
            <h1>{{ $guide->title }}</h1>
            <p>{{ $guide->excerpt }}</p>
            <div class="guide-meta">
                <span>BusinessOS</span>
                <time datetime="{{ $guide->published_at?->toDateString() }}">{{ $guide->published_at?->format('F j, Y') }}</time>
            </div>
        </div>
    </header>

    <section class="section guide-body-section">
        <div class="shell guide-shell">
            <div class="guide-body">{!! nl2br(e($guide->content)) !!}</div>
            <div class="guide-end">
                <span class="kicker">BusinessOS resources</span>
                <h2>Turn useful ideas into better operations.</h2>
                <div class="hero-actions">
                    <a class="button button-primary" href="{{ route('apps.index') }}">Explore apps <span>↗</span></a>
                    <a class="button button-ghost" href="{{ route('resources.index') }}">More guides</a>
                </div>
            </div>
        </div>
    </section>
</article>
@endsection
