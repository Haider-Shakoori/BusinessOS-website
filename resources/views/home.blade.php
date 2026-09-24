@extends('layouts.marketing')

@section('content')
<section class="ecosystem-hero" id="top">
    <div class="shell ecosystem-hero-grid">
        <div class="ecosystem-hero-copy">
            <span class="calm-eyebrow">BusinessOS software ecosystem</span>
            <h1>Software for the way your business actually runs.</h1>
            <p>BusinessOS brings focused software for field sales, business management and retail operations under one product family—built for practical work, local realities and modern teams.</p>

            <div class="calm-hero-actions">
                <a class="button button-primary" href="{{ route('apps.index') }}">Explore BusinessOS apps <span aria-hidden="true">→</span></a>
                <a class="button button-ghost" href="{{ route('demo') }}">Request a demo</a>
            </div>

            <div class="ecosystem-trust-row" aria-label="BusinessOS product principles">
                <span><i></i> Field operations</span>
                <span><i></i> ERP & business management</span>
                <span><i></i> Retail & point of sale</span>
            </div>
        </div>

        <div class="ecosystem-scene" aria-label="BusinessOS product ecosystem preview">
            <div class="ecosystem-depth ecosystem-depth-back" aria-hidden="true"></div>
            <div class="ecosystem-depth ecosystem-depth-mid" aria-hidden="true"></div>

            <div class="ecosystem-console">
                <div class="ecosystem-console-top">
                    <div><i></i><i></i><i></i></div>
                    <strong>BusinessOS</strong>
                    <span>Product ecosystem</span>
                </div>

                <div class="ecosystem-console-body">
                    <div class="ecosystem-console-intro">
                        <small>ONE BUSINESSOS FAMILY</small>
                        <h2>Choose the software that fits the work.</h2>
                        <p>Each product has a clear job while sharing one BusinessOS identity.</p>
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
                <a class="ecosystem-float ecosystem-float-{{ $loop->iteration }}" href="{{ route('apps.show', $app['slug']) }}">
                    <span>{{ $app['icon_letter'] }}</span>
                    <div><small>{{ strtoupper($app['eyebrow']) }}</small><strong>{{ $app['name'] }}</strong></div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="calm-signal-bar ecosystem-signal-bar">
    <div class="shell">
        <span>Field sales</span>
        <span>Customers & finance</span>
        <span>Quotations & invoices</span>
        <span>Retail & inventory</span>
        <span>Business visibility</span>
    </div>
</section>

<section class="calm-section ecosystem-products" id="products">
    <div class="shell calm-heading">
        <div>
            <span class="calm-kicker">BusinessOS apps</span>
            <h2>Focused products for different parts of the business.</h2>
        </div>
        <p>Use the product that matches the workflow. BusinessOS keeps each application focused instead of forcing every team into one oversized interface.</p>
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
                    <a class="button button-ghost" href="{{ route('apps.show', $app['slug']) }}">Explore {{ $app['name'] }}</a>
                    @if (!empty($app['web_url']))
                        <a class="app-live-link" href="{{ $app['web_url'] }}" target="_blank" rel="noopener noreferrer">
                            <span class="app-live-dot" aria-hidden="true"></span>
                            {{ parse_url($app['web_url'], PHP_URL_HOST) }}
                            <span aria-hidden="true">↗</span>
                        </a>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
</section>

<section class="calm-section calm-outcomes" id="solutions">
    <div class="shell calm-heading">
        <div>
            <span class="calm-kicker">Across the business</span>
            <h2>Different teams. One clear software direction.</h2>
        </div>
        <p>BusinessOS is designed around the work happening in the field, the back office and the shop floor.</p>
    </div>

    <div class="shell ecosystem-solution-grid">
        @foreach ($apps as $app)
            <article>
                <span class="calm-card-number">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                <div class="app-letter-icon" aria-hidden="true">{{ $app['icon_letter'] }}</div>
                <h3>{{ $app['headline'] }}</h3>
                <p>{{ $app['short_description'] }}</p>
                <a class="text-link" href="{{ route('apps.show', $app['slug']) }}">Explore {{ $app['name'] }} <span>→</span></a>
            </article>
        @endforeach
    </div>
</section>

<section class="calm-section calm-values" id="why-businessos">
    <div class="shell calm-values-grid">
        <div class="calm-values-intro">
            <span class="calm-kicker">Why BusinessOS</span>
            <h2>One brand. Clear products. Practical software.</h2>
            <p>BusinessOS is the master platform and product family. Each application solves a specific operational problem while following the same approach to clarity, responsiveness and maintainability.</p>
        </div>

        <div class="calm-value-list">
            <article><span>01</span><div><h3>Built around real workflows</h3><p>Products start from the job people need to complete, not from a generic feature checklist.</p></div></article>
            <article><span>02</span><div><h3>Designed for local realities</h3><p>Low-bandwidth conditions, mobile work and Afghanistan-specific business requirements are considered where they matter.</p></div></article>
            <article><span>03</span><div><h3>Ready to grow as a product family</h3><p>New applications can join BusinessOS without losing a clear identity or making existing products harder to use.</p></div></article>
        </div>
    </div>
</section>

<section class="calm-section calm-dark">
    <div class="shell calm-dark-grid">
        <div>
            <span class="calm-kicker">Engineering standard</span>
            <h2>Modern on the surface. Practical underneath.</h2>
            <p>BusinessOS products are built around responsive interfaces, maintainable application architecture and performance that remains useful on real devices and imperfect networks.</p>
        </div>

        <div class="calm-dark-cards">
            <article><strong>Responsive</strong><span>Purposeful layouts for desktop, tablet and mobile.</span></article>
            <article><strong>Lightweight</strong><span>Public pages avoid unnecessary front-end weight and dependencies.</span></article>
            <article><strong>Search-ready</strong><span>Structured, crawlable product pages support discoverability.</span></article>
            <article><strong>Product-focused</strong><span>Field sales, ERP and retail remain clear applications instead of one overloaded interface.</span></article>
        </div>
    </div>
</section>

<section class="calm-section calm-resources" id="resources">
    <div class="shell calm-heading">
        <div>
            <span class="calm-kicker">Resources</span>
            <h2>Useful ideas for running better operations.</h2>
        </div>
        <a class="text-link" href="{{ route('resources.index') }}">View all resources <span>→</span></a>
    </div>

    <div class="shell">
        @if ($latestGuides->count())
            <div class="calm-resource-grid">
                @foreach ($latestGuides as $guide)
                    <article>
                        <div class="calm-resource-meta">
                            <span>{{ $guide->category }}</span>
                            <time datetime="{{ $guide->published_at?->toDateString() }}">{{ $guide->published_at?->format('M j, Y') }}</time>
                        </div>
                        <h3><a href="{{ route('resources.show', $guide) }}">{{ $guide->title }}</a></h3>
                        <p>{{ $guide->excerpt }}</p>
                        <a class="text-link" href="{{ route('resources.show', $guide) }}">Read guide <span>→</span></a>
                    </article>
                @endforeach
            </div>
        @else
            <div class="calm-empty">
                <strong>Resources are being prepared.</strong>
                <span>Published guides will appear here automatically from the BusinessOS CMS.</span>
            </div>
        @endif
    </div>
</section>

<section class="calm-section calm-final">
    <div class="shell calm-final-card">
        <div>
            <span class="calm-kicker">BusinessOS</span>
            <h2>Find the right product for the part of your business you want to improve.</h2>
            <p>Explore FieldPulse, ERP and POS, or tell us about the workflow you need to improve and choose the product from the demo form.</p>
        </div>
        <div class="calm-final-actions">
            <a class="button button-primary" href="{{ route('apps.index') }}">Explore all apps <span>→</span></a>
            <a class="button button-ghost" href="{{ route('demo') }}">Request a demo</a>
        </div>
    </div>
</section>
@endsection
