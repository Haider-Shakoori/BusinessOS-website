@extends('layouts.marketing')

@section('content')
<section class="product-hero">
    <div class="shell product-hero-grid">
        <div>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span>/</span>
                <a href="{{ route('apps.index') }}">Apps</a><span>/</span>
                <strong>{{ $app['name'] }}</strong>
            </nav>

            <div class="product-title-row">
                <div class="app-letter-icon large" aria-hidden="true">{{ $app['icon_letter'] }}</div>
                <div><span class="kicker">{{ $app['eyebrow'] }}</span><h1>{{ $app['name'] }}</h1></div>
            </div>

            <h2 class="product-headline">{{ $app['headline'] }}</h2>
            <p class="product-lede">{{ $app['description'] }}</p>

            <div class="hero-actions">
                @if (!empty($app['web_url']))
                    <a class="button button-primary" href="{{ $app['web_url'] }}" target="_blank" rel="noopener noreferrer">Open {{ $app['name'] }} <span aria-hidden="true">↗</span></a>
                @endif
                <a class="button button-ghost" href="{{ route('demo', ['app' => $app['slug']]) }}">Request a demo</a>
                <a class="product-inline-link" href="#features">Explore features <span aria-hidden="true">↓</span></a>
            </div>

            @if (!empty($app['web_url']))
                <a class="product-live-domain" href="{{ $app['web_url'] }}" target="_blank" rel="noopener noreferrer">
                    <span class="app-live-dot" aria-hidden="true"></span>
                    Live app: {{ parse_url($app['web_url'], PHP_URL_HOST) }}
                    <span aria-hidden="true">↗</span>
                </a>
            @endif

            @if (!empty($app['live_note']))
                <p class="product-live-note">{{ $app['live_note'] }}</p>
            @endif

            <div class="platform-row">
                <span>Platforms</span>
                @foreach ($app['platforms'] as $platform)<strong>{{ $platform }}</strong>@endforeach
            </div>
        </div>

        <div class="app-preview-stage app-preview-{{ $app['slug'] }}" aria-label="{{ $app['name'] }} interface preview">
            <div class="app-preview-window">
                <div class="window-top">
                    <div class="window-dots"><span></span><span></span><span></span></div>
                    <div class="window-title">{{ $app['name'] }}</div>
                    <div class="window-status">{{ $app['preview']['status'] }}</div>
                </div>

                <div class="app-preview-body">
                    <aside aria-hidden="true">
                        <b>{{ $app['icon_letter'] }}</b>
                        <span class="active"></span><span></span><span></span><span></span>
                    </aside>

                    <main>
                        <div class="app-preview-heading">
                            <div><small>{{ strtoupper($app['preview']['section']) }}</small><strong>{{ $app['preview']['title'] }}</strong></div>
                            <i>{{ $app['status'] }}</i>
                        </div>

                        <div class="app-preview-metrics">
                            @foreach ($app['preview']['metrics'] as $metric)
                                <span><small>{{ $metric['label'] }}</small><strong>{{ $metric['value'] }}</strong><em>{{ $metric['detail'] }}</em></span>
                            @endforeach
                        </div>

                        <div class="app-preview-list">
                            @foreach ($app['preview']['rows'] as $row)
                                <div><span><i></i>{{ $row }}</span><b>→</b></div>
                            @endforeach
                        </div>
                    </main>
                </div>
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

@if(!empty($app['screenshots']))
<section class="section product-screenshot-section">
    <div class="shell">
        <div class="section-heading split-heading">
            <div><span class="kicker">Product interface</span><h2>See the product in context.</h2></div>
            <p>Published screenshots are managed from the Product and Media CMS.</p>
        </div>
        <div class="product-screenshot-grid">
            @foreach($app['screenshots'] as $screenshot)
                <figure>
                    <img src="{{ $screenshot }}" alt="{{ $app['name'] }} interface screenshot {{ $loop->iteration }}" loading="lazy" decoding="async">
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section product-problem">
    <div class="shell two-column">
        <div>
            <span class="kicker">The problem</span>
            <h2>{{ $app['problem']['title'] }}</h2>
        </div>
        <div class="body-copy">
            @foreach ($app['problem']['body'] as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    </div>
</section>

<section class="section feature-section" id="features">
    <div class="shell">
        <div class="section-heading split-heading">
            <div><span class="kicker">Core capabilities</span><h2>{{ $app['features_intro']['title'] }}</h2></div>
            <p>{{ $app['features_intro']['description'] }}</p>
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
            <h2>{{ $app['use_cases_intro']['title'] }}</h2>
            <p class="section-copy">{{ $app['use_cases_intro']['description'] }}</p>
        </div>
        <div class="use-case-list">
            @foreach ($app['use_cases'] as $index => $useCase)
                <div><span>0{{ $index + 1 }}</span><strong>{{ $useCase }}</strong><i>↗</i></div>
            @endforeach
        </div>
    </div>
</section>

<section class="section product-spotlight-section">
    <div class="shell product-spotlight-card">
        <div>
            <span class="kicker">{{ $app['spotlight']['kicker'] }}</span>
            <h2>{{ $app['spotlight']['title'] }}</h2>
            <p>{{ $app['spotlight']['description'] }}</p>
        </div>
        <div class="product-spotlight-items">
            @foreach ($app['spotlight']['items'] as $index => $item)
                <span><i>0{{ $index + 1 }}</i><strong>{{ $item }}</strong></span>
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
            @if(!empty($app['commercial']['pricing_model']))
                <div class="product-commercial-model"><small>PRICING MODEL</small><strong>{{ $app['commercial']['pricing_model'] }}</strong></div>
            @endif
            @if(!empty($app['commercial']['deployment_options']))
                <div class="product-commercial-options">
                    @foreach($app['commercial']['deployment_options'] as $option)<span>✓ {{ $option }}</span>@endforeach
                </div>
            @endif
        </div>
        <div class="product-commercial-actions">
            @if(!empty($app['commercial']['pricing_plans']))
                <div class="product-plan-stack">
                    @foreach($app['commercial']['pricing_plans'] as $plan)
                        <article><span><strong>{{ $plan['name'] }}</strong><small>{{ $plan['description'] }}</small></span><b>{{ $plan['price'] }}</b></article>
                    @endforeach
                </div>
            @endif
            <a class="button button-primary" href="{{ route('demo', ['app' => $app['slug']]) }}">{{ __('marketing.actions.request_demo') }}</a>
            <a class="button button-ghost" href="{{ route('pricing') }}">{{ __('marketing.nav.pricing') }}</a>
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
        <span class="kicker">{{ $app['name'] }}</span>
        <h2>{{ $app['final']['title'] }}</h2>
        <p>{{ $app['final']['description'] }}</p>
        <div class="hero-actions centered-actions">
            @if (!empty($app['web_url']))
                <a class="button button-primary" href="{{ $app['web_url'] }}" target="_blank" rel="noopener noreferrer">Open {{ $app['name'] }} <span aria-hidden="true">↗</span></a>
            @endif
            <a class="button button-ghost" href="{{ route('demo', ['app' => $app['slug']]) }}">{{ __('marketing.actions.request_demo') }}</a>
            <a class="button button-ghost" href="{{ route('apps.index') }}">{{ __('marketing.nav.all_apps') }}</a>
        </div>
    </div>
</section>
@endsection

[executed on device: ubuntu-6gb-dal-x8mx (c447f909-fdcc-4121-9924-27a69d35e9b2)]