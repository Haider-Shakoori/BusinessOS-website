@extends('layouts.marketing')

@section('content')
@php
    $homeText = static fn (string $key, string $fallback): string =>
        app()->getLocale() === 'en' ? (string) $siteSettings->get($key, $fallback) : $fallback;
@endphp
<section class="ecosystem-hero" id="top">
    <div class="shell ecosystem-hero-grid">
        <div class="ecosystem-hero-copy">
            <span class="calm-eyebrow">{{ $homeText('homepage_hero_eyebrow', __('marketing.home.hero_eyebrow')) }}</span>
            <h1>{{ $siteSettings->localized('homepage_hero_title', __('marketing.home.hero_title')) }}</h1>
            <p>{{ $siteSettings->localized('homepage_hero_description', __('marketing.home.hero_description')) }}</p>

            <div class="calm-hero-actions">
                <a class="button button-primary" href="{{ route('services') }}">{{ __('marketing.nav.solutions') }} <span aria-hidden="true">→</span></a>
                <a class="button button-ghost" href="{{ route('apps.index') }}">{{ __('marketing.actions.explore_apps') }}</a>
            </div>

            <div class="ecosystem-trust-row" aria-label="BusinessOS product principles">
                <span><i></i> {{ __('marketing.home.trust_field') }}</span>
                <span><i></i> {{ __('marketing.home.trust_erp') }}</span>
                <span><i></i> {{ __('marketing.home.trust_pos') }}</span>
            </div>
        </div>

        <div class="ecosystem-scene" aria-label="BusinessOS product ecosystem preview">
            <div class="ecosystem-depth ecosystem-depth-back" aria-hidden="true"></div>
            <div class="ecosystem-depth ecosystem-depth-mid" aria-hidden="true"></div>

            <div class="ecosystem-console">
                <div class="ecosystem-console-top">
                    <div><i></i><i></i><i></i></div>
                    <strong>BusinessOS</strong>
                    <span>{{ __('marketing.ui.home.ecosystem') }}</span>
                </div>

                <div class="ecosystem-console-body">
                    <div class="ecosystem-console-intro">
                        <small>{{ strtoupper(__('marketing.home.one_family')) }}</small>
                        <h2>{{ __('marketing.home.choose_software') }}</h2>
                        <p>{{ __('marketing.home.family_copy') }}</p>
                    </div>

                    <div class="ecosystem-console-products">
                        @foreach ($apps as $app)
                            <a class="ecosystem-mini-app ecosystem-mini-{{ $app['slug'] }}" href="{{ route('apps.show', $app['slug']) }}">
                                <span class="app-letter-icon" aria-hidden="true">{{ $app['icon_letter'] }}</span>
                                <div>
                                    <small>{{ $app['eyebrow'] }}</small>
                                    <strong>{{ $app['name'] }}</strong>
                                </div>
                                <i>→</i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            @foreach ($apps->take(3) as $app)
                <a class="ecosystem-float ecosystem-float-{{ ['field', 'erp', 'pos'][$loop->index] }}" href="{{ route('apps.show', $app['slug']) }}">
                    <span>{{ $app['icon_letter'] }}</span>
                    <div><small>{{ strtoupper($app['eyebrow']) }}</small><strong>{{ $app['name'] }}</strong></div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="calm-signal-bar ecosystem-signal-bar">
    <div class="shell">
        <span>{{ __('marketing.ui.home.website_development') }}</span>
        <span>{{ __('marketing.ui.home.custom_erp') }}</span>
        <span>{{ __('marketing.ui.home.web_apps') }}</span>
        <span>{{ __('marketing.ui.home.data_migration') }}</span>
        <span>{{ __('marketing.ui.home.app_upgrades') }}</span>
    </div>
</section>

<section class="calm-section business-services" id="services">
    <div class="shell calm-heading">
        <div>
            <span class="calm-kicker">{{ __('marketing.ui.home.services_kicker') }}</span>
            <h2>{{ __('marketing.ui.home.services_title') }}</h2>
        </div>
        <p>{{ __('marketing.ui.home.services_copy') }}</p>
    </div>

    <div class="shell business-service-grid">
        @foreach ($services->take(6) as $service)
            <article>
                <span class="service-card-index">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                <h3>{{ $service['name'] }}</h3>
                <p>{{ $service['short'] }}</p>
                <a class="text-link" href="{{ route('services') }}#{{ $service['slug'] }}">{{ __('marketing.ui.home.learn_more') }} <span>→</span></a>
            </article>
        @endforeach
    </div>

    <div class="shell business-services-cta">
        <p>{{ __('marketing.ui.home.specialized_copy') }}</p>
        <a class="button button-primary" href="{{ route('services') }}">{{ __('marketing.ui.home.all_services') }} <span aria-hidden="true">→</span></a>
    </div>
</section>

<section class="calm-section ecosystem-products" id="products">
    <div class="shell calm-heading">
        <div>
            <span class="calm-kicker">{{ __('marketing.home.apps_kicker') }}</span>
            <h2>{{ $homeText('homepage_apps_title', __('marketing.home.apps_title')) }}</h2>
        </div>
        <p>{{ $homeText('homepage_apps_description', __('marketing.home.apps_description')) }}</p>
    </div>

    <div class="shell ecosystem-product-grid">
        @foreach ($apps as $app)
            <article class="ecosystem-product-card ecosystem-product-{{ $app['slug'] }}">
                <div class="ecosystem-product-top">
                    <div class="app-letter-icon" aria-hidden="true">{{ $app['icon_letter'] }}</div>
                    <span class="status-pill">{{ $app['status'] }}</span>
                </div>

                <span class="calm-app-kicker">{{ $app['eyebrow'] }}</span>
                <h3>{{ $app['name'] }}</h3>
                <p>{{ $app['short_description'] }}</p>

                <div class="ecosystem-product-highlights">
                    @foreach (array_slice($app['highlights'], 0, 3) as $highlight)
                        <span><i>✓</i>{{ $highlight }}</span>
                    @endforeach
                </div>

                <div class="ecosystem-product-actions">
                    <a class="button button-ghost" href="{{ route('apps.show', $app['slug']) }}">{{ __('marketing.ui.home.explore') }} {{ $app['name'] }}</a>
                </div>
            </article>
        @endforeach
    </div>
</section>

<section class="calm-section calm-outcomes" id="solutions">
    <div class="shell calm-heading">
        <div>
            <span class="calm-kicker">{{ __('marketing.home.across_business') }}</span>
            <h2>{{ $homeText('homepage_solutions_title', __('marketing.home.solutions_title')) }}</h2>
        </div>
        <p>{{ $homeText('homepage_solutions_description', __('marketing.home.solutions_description')) }}</p>
    </div>

    <div class="shell ecosystem-solution-grid">
        @foreach ($apps as $app)
            <article>
                <span class="calm-card-number">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                <div class="app-letter-icon" aria-hidden="true">{{ $app['icon_letter'] }}</div>
                <h3>{{ $app['headline'] }}</h3>
                <p>{{ $app['short_description'] }}</p>
                <a class="text-link" href="{{ route('apps.show', $app['slug']) }}">{{ __('marketing.ui.home.explore') }} {{ $app['name'] }} <span>→</span></a>
            </article>
        @endforeach
    </div>
</section>

<section class="calm-section calm-values" id="why-businessos">
    <div class="shell calm-values-grid">
        <div class="calm-values-intro">
            <span class="calm-kicker">{{ __('marketing.home.why_kicker') }}</span>
            <h2>{{ $homeText('homepage_why_title', __('marketing.home.why_title')) }}</h2>
            <p>{{ $homeText('homepage_why_description', __('marketing.home.why_copy')) }}</p>
        </div>

        <div class="calm-value-list">
            <article><span>01</span><div><h3>{{ __('marketing.ui.home.value_1_title') }}</h3><p>{{ __('marketing.ui.home.value_1_copy') }}</p></div></article>
            <article><span>02</span><div><h3>{{ __('marketing.ui.home.value_2_title') }}</h3><p>{{ __('marketing.ui.home.value_2_copy') }}</p></div></article>
            <article><span>03</span><div><h3>{{ __('marketing.ui.home.value_3_title') }}</h3><p>{{ __('marketing.ui.home.value_3_copy') }}</p></div></article>
        </div>
    </div>
</section>

<section class="calm-section calm-dark">
    <div class="shell calm-dark-grid">
        <div>
            <span class="calm-kicker">{{ __('marketing.home.engineering_kicker') }}</span>
            <h2>{{ $homeText('homepage_engineering_title', __('marketing.home.engineering_title')) }}</h2>
            <p>{{ $homeText('homepage_engineering_description', __('marketing.home.engineering_copy')) }}</p>
        </div>

        <div class="calm-dark-cards">
            <article><strong>{{ __('marketing.ui.home.responsive') }}</strong><span>{{ __('marketing.ui.home.responsive_copy') }}</span></article>
            <article><strong>{{ __('marketing.ui.home.lightweight') }}</strong><span>{{ __('marketing.ui.home.lightweight_copy') }}</span></article>
            <article><strong>{{ __('marketing.ui.home.search_ready') }}</strong><span>{{ __('marketing.ui.home.search_ready_copy') }}</span></article>
            <article><strong>{{ __('marketing.ui.home.product_focused') }}</strong><span>{{ __('marketing.ui.home.product_focused_copy') }}</span></article>
        </div>
    </div>
</section>

<section class="calm-section calm-resources" id="case-studies">
    <div class="shell calm-heading">
        <div>
            <span class="calm-kicker">{{ __('marketing.ui.home.evidence') }}</span>
            <h2>{{ __('marketing.ui.home.evidence_title') }}</h2>
        </div>
        <a class="text-link" href="{{ route('case-studies.index') }}">{{ __('marketing.ui.home.view_cases') }} <span>→</span></a>
    </div>

    <div class="shell">
        @if ($latestCaseStudies->count())
            <div class="calm-resource-grid">
                @foreach ($latestCaseStudies as $caseStudy)
                    <article>
                        <div class="calm-resource-meta">
                            <span>{{ $caseStudy->industry }}</span>
                            <time datetime="{{ $caseStudy->published_at?->toDateString() }}">{{ $caseStudy->published_at?->locale(app()->getLocale())->translatedFormat('M j, Y') }}</time>
                        </div>
                        <h3><a href="{{ route('case-studies.show', $caseStudy) }}">{{ $caseStudy->title }}</a></h3>
                        <p>{{ $caseStudy->summary }}</p>
                        <a class="text-link" href="{{ route('case-studies.show', $caseStudy) }}">{{ __('marketing.ui.home.read_case') }} <span>→</span></a>
                    </article>
                @endforeach
            </div>
        @else
            <div class="calm-empty">
                <strong>{{ __('marketing.ui.home.cases_empty_title') }}</strong>
                <span>{{ __('marketing.ui.home.cases_empty_copy') }}</span>
            </div>
        @endif
    </div>
</section>

<section class="calm-section calm-resources" id="resources">
    <div class="shell calm-heading">
        <div>
            <span class="calm-kicker">{{ __('marketing.ui.home.resources') }}</span>
            <h2>{{ $homeText('homepage_resources_title', __('marketing.home.resources_title')) }}</h2>
        </div>
        <a class="text-link" href="{{ route('resources.index') }}">{{ __('marketing.actions.view_resources') }} <span>→</span></a>
    </div>

    <div class="shell">
        @if ($latestGuides->count())
            <div class="calm-resource-grid">
                @foreach ($latestGuides as $guide)
                    <article>
                        <div class="calm-resource-meta">
                            <span>{{ $guide->category }}</span>
                            <time datetime="{{ $guide->published_at?->toDateString() }}">{{ $guide->published_at?->locale(app()->getLocale())->translatedFormat('M j, Y') }}</time>
                        </div>
                        <h3><a href="{{ route('resources.show', $guide) }}">{{ $guide->title }}</a></h3>
                        <p>{{ $guide->excerpt }}</p>
                        <a class="text-link" href="{{ route('resources.show', $guide) }}">{{ __('marketing.actions.read_guide') }} <span>→</span></a>
                    </article>
                @endforeach
            </div>
        @else
            <div class="calm-empty">
                <strong>{{ __('marketing.ui.home.resources_empty_title') }}</strong>
                <span>{{ __('marketing.ui.home.resources_empty_copy') }}</span>
            </div>
        @endif
    </div>
</section>

<section class="calm-section calm-final">
    <div class="shell calm-final-card">
        <div>
            <span class="calm-kicker">BusinessOS</span>
            <h2>{{ $homeText('homepage_final_title', __('marketing.home.final_title')) }}</h2>
            <p>{{ $homeText('homepage_final_description', __('marketing.home.final_copy')) }}</p>
        </div>
        <div class="calm-final-actions">
            <a class="button button-primary" href="{{ route('apps.index') }}">{{ __('marketing.actions.explore_all_apps') }} <span>→</span></a>
            <a class="button button-ghost" href="{{ route('demo') }}">{{ __('marketing.actions.request_demo') }}</a>
        </div>
    </div>
</section>
@endsection
