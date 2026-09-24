@extends('layouts.marketing')

@section('content')
<section class="product-hero">
    <div class="hero-glow hero-glow-a" aria-hidden="true"></div>
    <div class="shell product-hero-grid">
        <div>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span>/</span>
                <a href="{{ route('apps.index') }}">Apps</a><span>/</span>
                <strong>{{ $app['name'] }}</strong>
            </nav>
            <div class="product-title-row">
                <div class="app-icon fieldpulse-icon large" aria-hidden="true"><span></span><span></span></div>
                <div><span class="kicker">{{ $app['eyebrow'] }}</span><h1>{{ $app['name'] }}</h1></div>
            </div>
            <h2 class="product-headline">{{ $app['headline'] }}</h2>
            <p class="product-lede">{{ $app['description'] }}</p>
            <div class="hero-actions">
                <a class="button button-primary" href="{{ route('demo', ['app' => $app['slug']]) }}">Request a demo <span aria-hidden="true">↗</span></a>
                <a class="button button-ghost" href="#features">Explore features</a>
            </div>
            <div class="platform-row">
                <span>Platforms</span>
                @foreach ($app['platforms'] as $platform)<strong>{{ $platform }}</strong>@endforeach
            </div>
        </div>

        <div class="fieldpulse-stage">
            <div class="stage-browser">
                <div class="window-top"><div class="window-dots"><span></span><span></span><span></span></div><div class="window-title">FieldPulse</div><div class="window-status">Live</div></div>
                <div class="stage-body">
                    <div class="stage-sidebar"><b>F</b><span class="active"></span><span></span><span></span><span></span></div>
                    <div class="stage-main">
                        <div class="stage-title"><span><small>Operations</small><strong>Live field view</strong></span><i>Today</i></div>
                        <div class="stage-stats"><span><small>Active</small><strong>18</strong></span><span><small>Visits</small><strong>42</strong></span><span><small>Coverage</small><strong>76%</strong></span></div>
                        <div class="stage-map"><div class="map-grid"></div><i class="map-pin pin-a"></i><i class="map-pin pin-b"></i><i class="map-pin pin-c"></i><span class="route-line"></span></div>
                    </div>
                </div>
            </div>
            <div class="stage-phone">
                <div class="phone-island"></div>
                <div class="stage-phone-content"><small>Work session</small><strong>06:42:18</strong><span>Active</span><div class="stage-bars"><i></i><i></i><i></i><i></i></div></div>
            </div>
        </div>
    </div>
</section>

<section class="product-proof">
    <div class="shell proof-grid">
        @foreach ($app['highlights'] as $index => $highlight)
            <div><span>0{{ $index + 1 }}</span><strong>{{ $highlight }}</strong></div>
        @endforeach
    </div>
</section>

<section class="section product-problem">
    <div class="shell two-column">
        <div>
            <span class="kicker">The problem</span>
            <h2>Field work becomes invisible when the team leaves the office.</h2>
        </div>
        <div class="body-copy">
            <p>Traditional attendance, spreadsheets, chat messages and end-of-day reports create gaps between what managers need to know and what actually happened in the field.</p>
            <p>{{ $app['name'] }} brings attendance, field activity, client visits and location context into one operational view while keeping the mobile workflow practical for field staff.</p>
        </div>
    </div>
</section>

<section class="section feature-section" id="features">
    <div class="shell">
        <div class="section-heading split-heading">
            <div><span class="kicker">Core capabilities</span><h2>Built around the field day, not the office desk.</h2></div>
            <p>Each capability is designed to answer a real operational question without burying teams in unnecessary complexity.</p>
        </div>

        <div class="feature-grid">
            @foreach ($app['features'] as $index => $feature)
                <article class="{{ $index === 0 || $index === 3 ? 'feature-wide' : '' }}">
                    <span class="feature-index">0{{ $index + 1 }}</span>
                    <div class="feature-glyph glyph-{{ ($index % 3) + 1 }}" aria-hidden="true"><i></i><i></i><i></i></div>
                    <h3>{{ $feature['title'] }}</h3>
                    <p>{{ $feature['description'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section use-case-section">
    <div class="shell two-column">
        <div>
            <span class="kicker">Use cases</span>
            <h2>One field platform, several daily questions answered.</h2>
            <p class="section-copy">Use {{ $app['name'] }} where visibility, accountability and mobile execution need to stay connected.</p>
        </div>
        <div class="use-case-list">
            @foreach ($app['use_cases'] as $index => $useCase)
                <div><span>0{{ $index + 1 }}</span><strong>{{ $useCase }}</strong><i>↗</i></div>
            @endforeach
        </div>
    </div>
</section>

<section class="section product-commercial-section">
    <div class="shell product-commercial-card">
        <div>
            <span class="kicker">Pricing & rollout</span>
            <h2>{{ $app['commercial']['pricing_status'] }}</h2>
            <p>{{ $app['commercial']['pricing_note'] }}</p>
        </div>
        <div class="product-commercial-actions">
            <a class="button button-primary" href="{{ route('demo', ['app' => $app['slug']]) }}">Request a demo</a>
            <a class="button button-ghost" href="{{ route('pricing') }}">Pricing approach</a>
        </div>
    </div>
</section>

<section class="section offline-section">
    <div class="shell offline-card">
        <div>
            <span class="kicker">Designed for imperfect connectivity</span>
            <h2>Work should not stop when the signal does.</h2>
            <p>FieldPulse is being built around offline-first mobile foundations so essential workflows can continue through unreliable connections and synchronize when the network is available again.</p>
        </div>
        <div class="signal-visual" aria-hidden="true">
            <span></span><span></span><span></span><span></span>
            <strong>Offline<br>ready</strong>
        </div>
    </div>
</section>

<section class="section faq-section" id="faq">
    <div class="shell two-column faq-layout">
        <div>
            <span class="kicker">Questions</span>
            <h2>What to know before evaluating {{ $app['name'] }}.</h2>
            <p class="section-copy">Product status, deployment and pricing information stay explicit so the page does not promise more than the current release supports.</p>
        </div>
        <div class="faq-list">
            @foreach ($app['faq'] as $item)
                <details>
                    <summary>{{ $item['question'] }}<span aria-hidden="true">+</span></summary>
                    <p>{{ $item['answer'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

<section class="section final-cta">
    <div class="shell final-cta-card">
        <div class="cta-orb" aria-hidden="true"></div>
        <span class="kicker">{{ $app['name'] }}</span>
        <h2>Make field activity easier to see, understand and manage.</h2>
        <p>Tell us about your field team and the workflow you want to improve. We will keep the conversation aligned with the current FieldPulse release state.</p>
        <div class="hero-actions centered-actions">
            <a class="button button-primary" href="{{ route('demo', ['app' => $app['slug']]) }}">Request FieldPulse demo <span aria-hidden="true">↗</span></a>
            <a class="button button-ghost" href="{{ route('apps.index') }}">All BusinessOS apps</a>
        </div>
    </div>
</section>
@endsection
