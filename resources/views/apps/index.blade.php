@extends('layouts.marketing')

@section('content')
<section class="page-hero">
    <div class="shell narrow-shell">
        <div class="eyebrow"><span class="pulse-dot"></span> BusinessOS applications</div>
        <h1>Software for the work that keeps a business moving.</h1>
        <p>Explore focused BusinessOS products for sales, field operations, management and automation. Each application is designed to stand on its own while fitting into one coherent software ecosystem.</p>
    </div>
</section>

<section class="section app-directory">
    <div class="shell">
        <div class="directory-meta">
            <span>{{ $apps->count() }} {{ $apps->count() === 1 ? 'application' : 'applications' }}</span>
            <span>More products will appear here as they are ready.</span>
        </div>

        <div class="directory-grid">
            @foreach ($apps as $app)
                <article class="directory-card">
                    <div class="directory-card-top">
                        <div class="app-icon fieldpulse-icon" aria-hidden="true"><span></span><span></span></div>
                        <span class="status-pill">{{ $app['status'] }}</span>
                    </div>
                    <span class="kicker">{{ $app['eyebrow'] }}</span>
                    <h2>{{ $app['name'] }}</h2>
                    <p>{{ $app['short_description'] }}</p>
                    <div class="chip-row">
                        @foreach ($app['platforms'] as $platform)
                            <span>{{ $platform }}</span>
                        @endforeach
                    </div>
                    <a class="text-link" href="{{ route('apps.show', $app['slug']) }}">Explore {{ $app['name'] }} <span>→</span></a>
                </article>
            @endforeach

            <article class="directory-card future-card">
                <div class="future-mark" aria-hidden="true">+</div>
                <span class="kicker">The ecosystem grows here</span>
                <h2>More BusinessOS apps</h2>
                <p>New products will only be published when they have a clear purpose, complete product content and a real experience worth indexing.</p>
            </article>
        </div>
    </div>
</section>
@endsection
