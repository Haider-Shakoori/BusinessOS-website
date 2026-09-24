@extends('layouts.marketing')

@section('content')
<section class="enterprise-hero" id="top">
    <div class="shell enterprise-hero-copy">
        <span class="enterprise-eyebrow">BusinessOS software ecosystem</span>
        <h1>Operate with clarity.<br>Move the business forward.</h1>
        <p>Focused software for field sales, operations and management—built to reduce admin work, improve visibility and keep teams moving.</p>

        <div class="enterprise-hero-actions">
            <a class="button button-primary" href="{{ route('demo', ['app' => 'fieldpulse']) }}">Request a demo <span aria-hidden="true">→</span></a>
            <a class="button button-ghost" href="#products">Explore products</a>
        </div>

        <div class="enterprise-principles" aria-label="BusinessOS product principles">
            <span>Focused workflows</span>
            <span>Web and mobile</span>
            <span>Fast on real networks</span>
            <span>Built for operational teams</span>
        </div>
    </div>

    <div class="shell enterprise-dashboard-wrap" aria-label="BusinessOS operations dashboard preview">
        <div class="enterprise-dashboard">
            <div class="enterprise-dashboard-top">
                <div class="enterprise-window-controls"><i></i><i></i><i></i></div>
                <strong>BusinessOS / FieldPulse</strong>
                <span>Live operations</span>
            </div>

            <div class="enterprise-dashboard-body">
                <aside class="enterprise-dashboard-nav" aria-hidden="true">
                    <b>F</b>
                    <span class="active"></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </aside>

                <main class="enterprise-dashboard-main">
                    <div class="enterprise-dashboard-heading">
                        <div>
                            <small>FIELD OPERATIONS</small>
                            <h2>Today at a glance</h2>
                        </div>
                        <button type="button" tabindex="-1">Today</button>
                    </div>

                    <div class="enterprise-dashboard-metrics">
                        <article><small>Active team</small><strong>18</strong><span>Field users working</span></article>
                        <article><small>Client visits</small><strong>42</strong><span>Recorded today</span></article>
                        <article><small>Coverage</small><strong>76%</strong><span>Planned territory</span></article>
                        <article><small>Sync status</small><strong>Ready</strong><span>Offline queue clear</span></article>
                    </div>

                    <div class="enterprise-dashboard-grid">
                        <section class="enterprise-map">
                            <header><strong>Field activity</strong><span>Live map</span></header>
                            <div class="enterprise-map-canvas">
                                <div class="enterprise-map-grid"></div>
                                <span class="enterprise-map-route route-one"></span>
                                <span class="enterprise-map-route route-two"></span>
                                <i class="enterprise-map-pin pin-one"></i>
                                <i class="enterprise-map-pin pin-two"></i>
                                <i class="enterprise-map-pin pin-three"></i>
                                <i class="enterprise-map-pin pin-four"></i>
                            </div>
                        </section>

                        <section class="enterprise-activity">
                            <header><strong>Recent activity</strong><span>Live</span></header>
                            <div><i></i><span><strong>Client visit recorded</strong><small>2 minutes ago</small></span></div>
                            <div><i></i><span><strong>Route synchronized</strong><small>8 minutes ago</small></span></div>
                            <div><i></i><span><strong>Work session started</strong><small>14 minutes ago</small></span></div>
                            <div><i></i><span><strong>Attendance updated</strong><small>22 minutes ago</small></span></div>
                        </section>
                    </div>
                </main>
            </div>
        </div>
    </div>
</section>

<section class="enterprise-strip" aria-label="BusinessOS capability areas">
    <div class="shell">
        <span>Field sales</span>
        <span>Team operations</span>
        <span>Customer visits</span>
        <span>Mobile work</span>
        <span>Analytics</span>
    </div>
</section>

<section class="enterprise-section enterprise-product-section" id="products">
    <div class="shell enterprise-section-heading">
        <div>
            <span class="enterprise-kicker">Products</span>
            <h2>Software with a clear job to do.</h2>
        </div>
        <p>BusinessOS products are designed around defined operational workflows instead of forcing every business process into one oversized platform.</p>
    </div>

    <div class="shell enterprise-product">
        <div class="enterprise-product-copy">
            <div class="enterprise-product-name">
                <div class="app-icon fieldpulse-icon" aria-hidden="true"><span></span><span></span></div>
                <div>
                    <small>{{ $featured['eyebrow'] }}</small>
                    <h3>{{ $featured['name'] }}</h3>
                </div>
            </div>

            <h4>{{ $featured['headline'] }}</h4>
            <p>{{ $featured['short_description'] }}</p>

            <div class="enterprise-product-features">
                @foreach ($featured['highlights'] as $highlight)
                    <span><i>✓</i>{{ $highlight }}</span>
                @endforeach
            </div>

            <div class="enterprise-product-actions">
                <a class="button button-primary" href="{{ route('apps.show', $featured['slug']) }}">Explore {{ $featured['name'] }} <span>→</span></a>
                <a class="text-link" href="{{ route('demo', ['app' => $featured['slug']]) }}">Request demo <span>→</span></a>
            </div>
        </div>

        <div class="enterprise-mobile-stage" aria-hidden="true">
            <div class="enterprise-phone">
                <div class="enterprise-phone-top"><span>9:41</span><i></i></div>
                <div class="enterprise-phone-brand"><b>F</b><span>FieldPulse</span></div>
                <small>WORK SESSION</small>
                <strong>06:42:18</strong>
                <em>Active</em>
                <div class="enterprise-phone-stats">
                    <span><small>Visits</small><b>7</b></span>
                    <span><small>Distance</small><b>18.2 km</b></span>
                </div>
                <div class="enterprise-phone-map">
                    <div></div><i></i><i></i><i></i>
                </div>
            </div>

            <div class="enterprise-stat-card stat-a"><small>VISITS</small><strong>42</strong><span>87% verified</span></div>
            <div class="enterprise-stat-card stat-b"><small>SYNC</small><strong>Ready</strong><span>Queue clear</span></div>
        </div>
    </div>
</section>

<section class="enterprise-section enterprise-solutions" id="solutions">
    <div class="shell enterprise-section-heading">
        <div>
            <span class="enterprise-kicker">Solutions</span>
            <h2>Less admin. Better visibility. Faster decisions.</h2>
        </div>
        <p>The product experience is centered on business outcomes rather than software complexity.</p>
    </div>

    <div class="shell enterprise-solution-grid">
        <article>
            <span>01</span>
            <h3>See the work clearly</h3>
            <p>Bring field activity, customer visits and operational context into one view managers can understand quickly.</p>
        </article>
        <article>
            <span>02</span>
            <h3>Keep teams moving</h3>
            <p>Give field staff focused mobile workflows that work where the job actually happens.</p>
        </article>
        <article>
            <span>03</span>
            <h3>Make better decisions</h3>
            <p>Keep analytics and AI-assisted insights close to the operational data that created them.</p>
        </article>
    </div>
</section>

<section class="enterprise-section enterprise-standard" id="why-businessos">
    <div class="shell enterprise-standard-grid">
        <div>
            <span class="enterprise-kicker">Why BusinessOS</span>
            <h2>Modern software without unnecessary complexity.</h2>
            <p>BusinessOS is built around disciplined product decisions: clear scope, responsive interfaces, lightweight delivery and software that remains maintainable as the ecosystem grows.</p>
        </div>

        <div class="enterprise-standard-list">
            <article><span>01</span><div><h3>Focused by design</h3><p>Every product starts from a specific operational problem and keeps complexity accountable.</p></div></article>
            <article><span>02</span><div><h3>Mobile where it matters</h3><p>Field products treat mobile as a primary workspace, not a smaller desktop screen.</p></div></article>
            <article><span>03</span><div><h3>Fast on real networks</h3><p>Server-rendered pages and lightweight assets keep the experience useful on constrained connections.</p></div></article>
            <article><span>04</span><div><h3>Built to evolve</h3><p>Clear architecture and product boundaries make future applications easier to operate and extend.</p></div></article>
        </div>
    </div>
</section>

<section class="enterprise-section enterprise-engineering">
    <div class="shell enterprise-engineering-grid">
        <div>
            <span class="enterprise-kicker">Engineering</span>
            <h2>Performance is part of the product.</h2>
            <p>BusinessOS is designed to load quickly, remain readable without heavy JavaScript and stay useful across desktops, phones and imperfect network conditions.</p>
            <a class="text-link" href="{{ route('about') }}">Learn about BusinessOS <span>→</span></a>
        </div>

        <div class="enterprise-engineering-cards">
            <article><strong>Server-rendered</strong><span>Core public content arrives as crawlable HTML.</span></article>
            <article><strong>Responsive</strong><span>Layouts reflow naturally across desktop, tablet and mobile.</span></article>
            <article><strong>Lightweight</strong><span>No external font dependency or heavy front-end framework for core pages.</span></article>
            <article><strong>Offline-aware</strong><span>Field products are designed around unreliable connectivity.</span></article>
        </div>
    </div>
</section>

<section class="enterprise-section enterprise-resources" id="resources">
    <div class="shell enterprise-section-heading">
        <div>
            <span class="enterprise-kicker">Resources</span>
            <h2>Practical ideas for better operations.</h2>
        </div>
        <a class="text-link" href="{{ route('resources.index') }}">View all resources <span>→</span></a>
    </div>

    <div class="shell">
        @if ($latestGuides->count())
            <div class="enterprise-resource-grid">
                @foreach ($latestGuides as $guide)
                    <article>
                        <div><span>{{ $guide->category }}</span><time datetime="{{ $guide->published_at?->toDateString() }}">{{ $guide->published_at?->format('M j, Y') }}</time></div>
                        <h3><a href="{{ route('resources.show', $guide) }}">{{ $guide->title }}</a></h3>
                        <p>{{ $guide->excerpt }}</p>
                        <a class="text-link" href="{{ route('resources.show', $guide) }}">Read guide <span>→</span></a>
                    </article>
                @endforeach
            </div>
        @else
            <div class="enterprise-empty">
                <strong>Resources are being prepared.</strong>
                <span>Published guides will appear here automatically from the BusinessOS CMS.</span>
            </div>
        @endif
    </div>
</section>

<section class="enterprise-section enterprise-final">
    <div class="shell enterprise-final-card">
        <div>
            <span class="enterprise-kicker">FieldPulse</span>
            <h2>Bring clarity to your field operations.</h2>
            <p>Tell us how your team currently works and what you want to improve. We will keep the demo aligned with the current FieldPulse release.</p>
        </div>
        <div>
            <a class="button button-primary" href="{{ route('demo', ['app' => 'fieldpulse']) }}">Request a demo <span>→</span></a>
            <a class="button button-ghost" href="{{ route('apps.show', 'fieldpulse') }}">Explore FieldPulse</a>
        </div>
    </div>
</section>
@endsection
