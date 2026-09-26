@extends('layouts.marketing')

@section('content')
<section class="product-hero">
    <div class="shell product-hero-grid">
        <div>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">{{ __('marketing.ui.product.home') }}</a><span>/</span>
                <a href="{{ route('apps.index') }}">{{ __('marketing.ui.product.apps') }}</a><span>/</span>
                <strong>{{ $app['name'] }}</strong>
            </nav>

            <div class="product-title-row">
                <div class="app-letter-icon large" aria-hidden="true">{{ $app['icon_letter'] }}</div>
                <div><span class="kicker">{{ $app['eyebrow'] }}</span><h1>{{ $app['name'] }}</h1></div>
            </div>

            <h2 class="product-headline">{{ $app['headline'] }}</h2>
            <p class="product-lede">{{ $app['description'] }}</p>

            <div class="hero-actions">
                <a class="button button-primary" href="{{ route('demo', ['app' => $app['slug']]) }}">{{ __('marketing.ui.product.request_demo') }}</a>
                <a class="product-inline-link" href="#features">{{ __('marketing.ui.product.explore_features') }} <span aria-hidden="true">↓</span></a>
            </div>

            @if (!empty($app['live_note']))
                <p class="product-live-note">{{ $app['live_note'] }}</p>
            @endif

            <div class="platform-row">
                <span>{{ __('marketing.ui.product.platforms') }}</span>
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
            <div><span class="kicker">{{ __('marketing.ui.product.interface') }}</span><h2>{{ __('marketing.ui.product.interface_title') }}</h2></div>
            <p>{{ __('marketing.ui.product.interface_copy') }}</p>
        </div>
        <div class="product-screenshot-grid">
            @foreach($app['screenshots'] as $screenshot)
                @php
                    $screenshotUrl = is_array($screenshot) ? ($screenshot['url'] ?? '') : $screenshot;
                    $screenshotAlt = is_array($screenshot) ? trim((string) ($screenshot['alt'] ?? '')) : '';
                    $screenshotCaption = is_array($screenshot) ? trim((string) ($screenshot['caption'] ?? '')) : '';
                @endphp
                @if($screenshotUrl)
                    <figure>
                        <img src="{{ $screenshotUrl }}" alt="{{ $screenshotAlt ?: $app['name'].' interface screenshot '.$loop->iteration }}" loading="lazy" decoding="async">
                        @if($screenshotCaption)<figcaption>{{ $screenshotCaption }}</figcaption>@endif
                    </figure>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section product-problem">
    <div class="shell two-column">
        <div>
            <span class="kicker">{{ __('marketing.ui.product.problem') }}</span>
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
            <div><span class="kicker">{{ __('marketing.ui.product.capabilities') }}</span><h2>{{ $app['features_intro']['title'] }}</h2></div>
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
            <span class="kicker">{{ __('marketing.ui.product.use_cases') }}</span>
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
            <span class="kicker">{{ __('marketing.ui.product.pricing_rollout') }}</span>
            <h2>{{ $app['commercial']['pricing_status'] }}</h2>
            <p>{{ $app['commercial']['pricing_note'] }}</p>
            @if(!empty($app['commercial']['pricing_model']))
                <div class="product-commercial-model"><small>{{ strtoupper(__('marketing.ui.product.pricing_model')) }}</small><strong>{{ $app['commercial']['pricing_model'] }}</strong></div>
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

@if($relatedServices->count() || $relatedGuides->count() || $relatedCaseStudies->count())
<section class="section muted-section">
    <div class="shell">
        <div class="section-heading split-heading">
            <div><span class="kicker">{{ __('marketing.ui.product.deeper') }}</span><h2>{{ __('marketing.ui.product.deeper_title') }}</h2></div>
            <p>{{ __('marketing.ui.product.deeper_copy') }}</p>
        </div>

        @if($relatedServices->count())
            <div class="resource-grid">
                @foreach($relatedServices as $page)
                    <article class="resource-card">
                        <div class="resource-card-top"><span>{{ $page->eyebrow ?: 'BusinessOS service' }}</span></div>
                        <h3><a href="{{ route('seo-pages.show', $page) }}">{{ $page->title }}</a></h3>
                        <p>{{ $page->excerpt }}</p>
                        <a class="text-link" href="{{ route('seo-pages.show', $page) }}">{{ __('marketing.ui.product.explore_service') }} <span>→</span></a>
                    </article>
                @endforeach
            </div>
        @endif

        @if($relatedCaseStudies->count())
            <div class="resource-grid">
                @foreach($relatedCaseStudies as $caseStudy)
                    <article class="resource-card">
                        <div class="resource-card-top"><span>{{ __('marketing.ui.product.case_study') }} · {{ $caseStudy->industry }}</span></div>
                        <h3><a href="{{ route('case-studies.show', $caseStudy) }}">{{ $caseStudy->title }}</a></h3>
                        <p>{{ $caseStudy->summary }}</p>
                        <a class="text-link" href="{{ route('case-studies.show', $caseStudy) }}">{{ __('marketing.ui.product.read_case') }} <span>→</span></a>
                    </article>
                @endforeach
            </div>
        @endif

        @if($relatedGuides->count())
            <div class="resource-grid">
                @foreach($relatedGuides as $guide)
                    <article class="resource-card">
                        <div class="resource-card-top"><span>{{ $guide->category }}</span></div>
                        <h3><a href="{{ route('resources.show', $guide) }}">{{ $guide->title }}</a></h3>
                        <p>{{ $guide->excerpt }}</p>
                        <a class="text-link" href="{{ route('resources.show', $guide) }}">{{ __('marketing.ui.product.read_guide') }} <span>→</span></a>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endif

<section class="section faq-section" id="faq">
    <div class="shell two-column faq-layout">
        <div>
            <span class="kicker">{{ __('marketing.ui.product.questions') }}</span>
            <h2>{{ __('marketing.ui.product.questions_title', ['product' => $app['name']]) }}</h2>
            <p class="section-copy">{{ __('marketing.ui.product.questions_copy') }}</p>
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
            <a class="button button-primary" href="{{ route('demo', ['app' => $app['slug']]) }}">{{ __('marketing.actions.request_demo') }}</a>
            <a class="button button-ghost" href="{{ route('apps.index') }}">{{ __('marketing.nav.all_apps') }}</a>
        </div>
    </div>
</section>
@endsection
