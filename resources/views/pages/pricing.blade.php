@extends('layouts.marketing')

@section('content')
<section class="page-hero trust-page-hero">
    <div class="shell narrow-shell">
        <span class="kicker">{{ __('marketing.nav.pricing') }}</span>
        <h1>Product pricing should reflect the workflow, rollout and support you actually need.</h1>
        <p>BusinessOS keeps commercial information product-specific. Where a public amount has not been approved, the website shows the real pricing model and deployment options instead of placeholder numbers.</p>
    </div>
</section>

<section class="section pricing-section">
    <div class="shell">
        <div class="product-pricing-grid">
            @foreach($apps as $app)
                <article class="product-pricing-card">
                    <div class="ecosystem-product-top">
                        <div class="app-letter-icon" aria-hidden="true">{{ $app['icon_letter'] }}</div>
                        <span class="status-pill">{{ $app['status'] }}</span>
                    </div>
                    <span class="pricing-label">{{ strtoupper($app['eyebrow']) }}</span>
                    <h2>{{ $app['name'] }}</h2>
                    <p>{{ $app['commercial']['pricing_note'] }}</p>

                    @if(!empty($app['commercial']['pricing_model']))
                        <div class="pricing-model">
                            <small>PRICING MODEL</small>
                            <strong>{{ $app['commercial']['pricing_model'] }}</strong>
                        </div>
                    @endif

                    @if(!empty($app['commercial']['pricing_plans']))
                        <div class="pricing-plan-list">
                            @foreach($app['commercial']['pricing_plans'] as $plan)
                                <div>
                                    <span><strong>{{ $plan['name'] }}</strong><small>{{ $plan['description'] }}</small></span>
                                    <b>{{ $plan['price'] }}</b>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(!empty($app['commercial']['deployment_options']))
                        <ul>
                            @foreach($app['commercial']['deployment_options'] as $option)<li>{{ $option }}</li>@endforeach
                        </ul>
                    @endif

                    <div class="product-pricing-actions">
                        <a class="button button-primary" href="{{ route('demo', ['app' => $app['slug']]) }}">{{ __('marketing.actions.request_demo') }}</a>
                        <a class="button button-ghost" href="{{ route('apps.show', $app['slug']) }}">{{ __('marketing.actions.explore_product') }}</a>
                    </div>
                </article>
            @endforeach
        </div>
        <p class="pricing-note">Approved prices can be published per product from the Product CMS. Until then, BusinessOS does not fabricate discounts, list prices or “starting at” amounts.</p>
    </div>
</section>
@endsection
