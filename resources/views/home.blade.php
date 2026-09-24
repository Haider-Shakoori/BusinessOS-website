@extends('layouts.marketing')

@section('content')
<section class="benchmark-hero" id="top">
    <div class="shell benchmark-hero-grid">
        <div class="benchmark-hero-copy">
            <span class="benchmark-eyebrow">Business software, built around real work</span>
            <h1>Software that makes your business easier to run.</h1>
            <p>BusinessOS builds focused applications for sales, field operations and management—designed to stay clear, fast and practical as your business grows.</p>

            <div class="benchmark-actions">
                <a class="button button-primary" href="{{ route('demo', ['app' => 'fieldpulse']) }}">Request a demo <span aria-hidden="true">→</span></a>
                <a class="button button-ghost" href="#products">Explore products</a>
            </div>

            <div class="benchmark-proof" aria-label="BusinessOS product principles">
                <span>Focused workflows</span>
                <span>Web + mobile</span>
                <span>Low-bandwidth aware</span>
            </div>
        </div>

        <div class="benchmark-product-preview" aria-label="FieldPulse operations preview">
            <div class="benchmark-preview-bar">
                <div>
                    <span class="benchmark-product-mark" aria-hidden="true">F</span>
                    <div><small>FIELD PULSE</small><strong>Operations overview</strong></div>
                </div>
                <span class="benchmark-status">Active development</span>
            </div>

            <div class="benchmark-preview-body">
                <aside class="benchmark-preview-nav" aria-hidden="true">
                    <b>F</b>
                    <i class="active"></i><i></i><i></i><i></i>
                </aside>

                <div class="benchmark-preview-main">
                    <div class="benchmark-preview-heading">
                        <div><small>Today</small><strong>Field operations</strong></div>
                        <span>Live view</span>
                    </div>

                    <div class="benchmark-preview-metrics">
                        <article><small>Active team</small><strong>18</strong><span>working</span></article>
                        <article><small>Client visits</small><strong>42</strong><span>today</span></article>
                        <article><small>Coverage</small><strong>76%</strong><span>planned</span></article>
                    </div>

                    <div class="benchmark-preview-grid">
                        <div class="benchmark-map-card">
                            <div class="benchmark-map-grid"></div>
                            <span class="benchmark-route route-a"></span>
                            <span class="benchmark-route route-b"></span>
                            <i class="benchmark-pin pin-1"></i>
                            <i class="benchmark-pin pin-2"></i>
                            <i class="benchmark-pin pin-3"></i>
                            <i class="benchmark-pin pin-4"></i>
                            <small>Field activity</small>
                        </div>

                        <div class="benchmark-activity-card">
                            <small>RECENT ACTIVITY</small>
                            <div><i></i><span><strong>Client visit recorded</strong><small>2 min ago</small></span></div>
                            <div><i></i><span><strong>Route synchronized</strong><small>8 min ago</small></span></div>
                            <div><i></i><span><strong>Work session started</strong><small>14 min ago</small></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="benchmark-mobile-preview" aria-hidden="true">
                <div class="benchmark-mobile-top"><span>9:41</span><i></i></div>
                <small>WORK SESSION</small>
                <strong>06:42:18</strong>
                <span class="benchmark-mobile-state">Active</span>
                <div class="benchmark-mobile-stats">
                    <span><small>Visits</small><b>7</b></span>
                    <span><small>Distance</small><b>18.2 km</b></span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="benchmark-capabilities" aria-label="BusinessOS capability areas">
    <div class="shell">
        <span>Field sales</span>
        <span>Team operations</span>
        <span>Business visibility</span>
        <span>Mobile workflows</span>
        <span>Analytics</span>
    </div>
</section>

<section class="benchmark-section benchmark-products" id="products">
    <div class="shell">
        <div class="benchmark-section-head">
            <div>
                <span class="benchmark-kicker">Products</span>
                <h2>Start with the workflow that matters most.</h2>
            </div>
            <p>Each BusinessOS application is built around a clear operational problem instead of trying to become one oversized system.</p>
        </div>

        <article class="benchmark-featured-product">
            <div class="benchmark-featured-copy">
                <div class="benchmark-product-title">
                    <div class="app-icon fieldpulse-icon" aria-hidden="true"><span></span><span></span></div>
                    <div>
                        <span>{{ $featured['eyebrow'] }}</span>
                        <h3>{{ $featured['name'] }}</h3>
                    </div>
                </div>

                <p class="benchmark-featured-headline">{{ $featured['headline'] }}</p>
                <p>{{ $featured['short_description'] }}</p>

                <div class="benchmark-feature-list">
                    @foreach ($featured['highlights'] as $highlight)
                        <span><i aria-hidden="true">✓</i>{{ $highlight }}</span>
                    @endforeach
                </div>

                <div class="benchmark-actions">
                    <a class="button button-primary" href="{{ route('apps.show', $featured['slug']) }}">Explore {{ $featured['name'] }} <span aria-hidden="true">→</span></a>
                    <a class="button button-ghost" href="{{ route('demo', ['app' => $featured['slug']]) }}">Request demo</a>
                </div>
            </div>

            <div class="benchmark-featured-visual" aria-hidden="true">
                <div class="benchmark-browser">
                    <div class="benchmark-browser-top"><span></span><span></span><span></span><small>field operations</small></div>
                    <div class="benchmark-browser-content">
                        <aside><b>F</b><i></i><i></i><i></i></aside>
                        <main>
                            <div class="benchmark-browser-heading"><span><small>Operations</small><strong>Team activity</strong></span><i>Today</i></div>
                            <div class="benchmark-browser-cards"><span></span><span></span><span></span></div>
                            <div class="benchmark-browser-map"><div></div><i></i><i></i><i></i></div>
                        </main>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>

<section class="benchmark-section benchmark-solutions" id="solutions">
    <div class="shell">
        <div class="benchmark-section-head">
            <div>
                <span class="benchmark-kicker">What better software should do</span>
                <h2>Less admin. More operational clarity.</h2>
            </div>
            <p>BusinessOS is designed around a simple idea: software should reduce the effort required to understand and run the business.</p>
        </div>

        <div class="benchmark-solution-grid">
            <article>
                <span>01</span>
                <h3>See the work clearly</h3>
                <p>Bring activity, customers and operational context into views managers can understand quickly.</p>
            </article>
            <article>
                <span>02</span>
                <h3>Keep execution moving</h3>
                <p>Give field and operational teams focused workflows that work where the job actually happens.</p>
            </article>
            <article>
                <span>03</span>
                <h3>Make decisions with context</h3>
                <p>Keep reporting and AI-assisted insight close to the operational data that produced it.</p>
            </article>
        </div>
    </div>
</section>

<section class="benchmark-section benchmark-principles" id="why-businessos">
    <div class="shell">
        <div class="benchmark-section-head">
            <div>
                <span class="benchmark-kicker">Why BusinessOS</span>
                <h2>Built like modern business software should be.</h2>
            </div>
            <p>Strong software should feel simple because the product decisions are disciplined—not because important work is hidden.</p>
        </div>

        <div class="benchmark-principle-grid">
            <article>
                <span class="benchmark-principle-icon">01</span>
                <h3>Focused</h3>
                <p>Every product starts with a defined workflow and avoids unnecessary enterprise complexity.</p>
            </article>
            <article>
                <span class="benchmark-principle-icon">02</span>
                <h3>Mobile-ready</h3>
                <p>Products used in the field treat mobile as a primary experience instead of an afterthought.</p>
            </article>
            <article>
                <span class="benchmark-principle-icon">03</span>
                <h3>Fast</h3>
                <p>Server-rendered pages and lightweight assets keep core experiences practical on constrained networks.</p>
            </article>
            <article>
                <span class="benchmark-principle-icon">04</span>
                <h3>Maintainable</h3>
                <p>Clear architecture and product boundaries make the ecosystem easier to operate and extend over time.</p>
            </article>
        </div>
    </div>
</section>

<section class="benchmark-section benchmark-engineering">
    <div class="shell benchmark-engineering-grid">
        <div>
            <span class="benchmark-kicker">Engineering standard</span>
            <h2>Performance is a product feature.</h2>
            <p>BusinessOS is designed for real networks and real devices. Core marketing content is server-rendered, requires no external font service, and remains useful without a heavy front-end framework.</p>
            <a class="text-link" href="{{ route('about') }}">How BusinessOS is built <span>→</span></a>
        </div>

        <div class="benchmark-engineering-list">
            <div><strong>Server rendered</strong><span>Core public content arrives as crawlable HTML.</span></div>
            <div><strong>Responsive by default</strong><span>Layouts reflow for phones, tablets and desktops.</span></div>
            <div><strong>Low-bandwidth aware</strong><span>Visual polish without unnecessary asset weight.</span></div>
            <div><strong>Offline-aware products</strong><span>Field workflows are designed around imperfect connectivity.</span></div>
        </div>
    </div>
</section>

<section class="benchmark-section benchmark-resources" id="resources">
    <div class="shell">
        <div class="benchmark-section-head">
            <div>
                <span class="benchmark-kicker">Resources</span>
                <h2>Practical ideas for better operations.</h2>
            </div>
            <a class="text-link benchmark-head-link" href="{{ route('resources.index') }}">View all resources <span>→</span></a>
        </div>

        @if ($latestGuides->count())
            <div class="benchmark-resource-grid">
                @foreach ($latestGuides as $guide)
                    <article>
                        <div class="benchmark-resource-meta">
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
            <div class="benchmark-empty">
                <strong>Resources are being prepared.</strong>
                <span>Published guides will appear here automatically from the BusinessOS CMS.</span>
            </div>
        @endif
    </div>
</section>

<section class="benchmark-section benchmark-cta">
    <div class="shell benchmark-cta-card">
        <div>
            <span class="benchmark-kicker">Start with FieldPulse</span>
            <h2>Make field operations easier to see and manage.</h2>
            <p>Tell us about your team and the workflow you want to improve. We will keep the conversation aligned with the current FieldPulse release state.</p>
        </div>
        <div class="benchmark-cta-actions">
            <a class="button button-primary" href="{{ route('demo', ['app' => 'fieldpulse']) }}">Request a demo <span aria-hidden="true">→</span></a>
            <a class="button button-ghost" href="{{ route('apps.show', 'fieldpulse') }}">Explore FieldPulse</a>
        </div>
    </div>
</section>
@endsection
