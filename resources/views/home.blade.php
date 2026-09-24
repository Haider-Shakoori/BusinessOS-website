@extends('layouts.marketing')

@section('content')
<section class="hero">
    <div class="hero-glow hero-glow-a" aria-hidden="true"></div>
    <div class="hero-glow hero-glow-b" aria-hidden="true"></div>
    <div class="shell hero-grid">
        <div class="hero-copy">
            <div class="eyebrow"><span class="pulse-dot"></span> The operating layer for modern business</div>
            <h1>Business software that feels <span>effortless.</span></h1>
            <p class="hero-lede">BusinessOS builds focused applications for teams that sell, operate, coordinate and grow—designed to stay useful on powerful desktops and unreliable mobile connections alike.</p>
            <div class="hero-actions">
                <a class="button button-primary" href="{{ route('apps.index') }}">Explore BusinessOS apps <span aria-hidden="true">↗</span></a>
                <a class="button button-ghost" href="#why-businessos">See how we build</a>
            </div>
            <div class="hero-proof" aria-label="BusinessOS engineering principles">
                <span><i>01</i> Server-rendered</span>
                <span><i>02</i> Mobile-first</span>
                <span><i>03</i> Low-bandwidth aware</span>
            </div>
        </div>

        <div class="hero-visual" aria-label="BusinessOS product ecosystem preview">
            <div class="orbit orbit-one" aria-hidden="true"></div>
            <div class="orbit orbit-two" aria-hidden="true"></div>
            <div class="product-window">
                <div class="window-top">
                    <div class="window-dots"><span></span><span></span><span></span></div>
                    <div class="window-title">BusinessOS / Operations</div>
                    <div class="window-status">Live</div>
                </div>
                <div class="window-body">
                    <aside class="mock-sidebar" aria-hidden="true">
                        <div class="mini-brand"></div>
                        <span class="active"></span><span></span><span></span><span></span><span></span>
                    </aside>
                    <div class="mock-content">
                        <div class="mock-heading">
                            <div><small>Today's overview</small><strong>Field operations</strong></div>
                            <span class="mini-chip">24 Sep</span>
                        </div>
                        <div class="metric-row">
                            <article><small>Active team</small><strong>18</strong><em>+3 today</em></article>
                            <article><small>Client visits</small><strong>42</strong><em>87% verified</em></article>
                            <article><small>Coverage</small><strong>76%</strong><em>On target</em></article>
                        </div>
                        <div class="dashboard-grid">
                            <div class="map-card">
                                <div class="map-grid"></div>
                                <span class="map-road road-a"></span><span class="map-road road-b"></span>
                                <i class="map-pin pin-a"></i><i class="map-pin pin-b"></i><i class="map-pin pin-c"></i><i class="map-pin pin-d"></i>
                                <div class="map-label">Live field map</div>
                            </div>
                            <div class="activity-card">
                                <small>Live activity</small>
                                <div><i></i><span><strong>Client visit</strong><small>2 min ago</small></span></div>
                                <div><i></i><span><strong>Route update</strong><small>8 min ago</small></span></div>
                                <div><i></i><span><strong>Check-in</strong><small>14 min ago</small></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="floating-card floating-card-top"><span class="signal-icon">⌁</span><div><small>Connection</small><strong>Offline ready</strong></div></div>
            <div class="floating-card floating-card-bottom"><span class="spark-icon">✦</span><div><small>BusinessOS AI</small><strong>Insight ready</strong></div></div>
        </div>
    </div>
</section>

<section class="trust-strip">
    <div class="shell trust-inner">
        <p>Built around the work businesses actually do</p>
        <div>
            <span>Sales</span><span>Field Operations</span><span>Automation</span><span>Analytics</span><span>Management</span>
        </div>
    </div>
</section>

<section class="section apps-section" id="solutions">
    <div class="shell">
        <div class="section-heading split-heading">
            <div>
                <span class="kicker">BusinessOS applications</span>
                <h2>Focused tools. One serious software ecosystem.</h2>
            </div>
            <p>Each product is built around a real operational problem, with its own workflow, search identity and room to grow.</p>
        </div>

        <div class="featured-app">
            <div class="app-copy">
                <div class="app-icon fieldpulse-icon" aria-hidden="true"><span></span><span></span></div>
                <span class="kicker">{{ $featured['eyebrow'] }}</span>
                <h3>{{ $featured['name'] }}</h3>
                <p class="app-headline">{{ $featured['headline'] }}</p>
                <p>{{ $featured['short_description'] }}</p>
                <div class="chip-row">
                    @foreach ($featured['highlights'] as $highlight)
                        <span>{{ $highlight }}</span>
                    @endforeach
                </div>
                <a class="text-link" href="{{ route('apps.show', $featured['slug']) }}">Explore {{ $featured['name'] }} <span>→</span></a>
            </div>
            <div class="app-visual">
                <div class="phone">
                    <div class="phone-island"></div>
                    <div class="phone-screen">
                        <div class="phone-top"><span>FieldPulse</span><i></i></div>
                        <small>Good afternoon</small>
                        <strong>Your field day</strong>
                        <div class="phone-card">
                            <div><span class="round-icon">↗</span><span><small>Work session</small><strong>06h 42m</strong></span></div>
                            <span class="status-chip">Active</span>
                        </div>
                        <div class="phone-grid"><span><small>Visits</small><strong>7</strong></span><span><small>Distance</small><strong>18.2 km</strong></span></div>
                        <div class="route-preview"><i></i><i></i><i></i><span></span></div>
                        <div class="phone-nav"><i></i><i></i><i></i><i></i></div>
                    </div>
                </div>
                <div class="visual-note note-a">Offline sync <strong>Ready</strong></div>
                <div class="visual-note note-b">GPS history <strong>Verified</strong></div>
            </div>
        </div>
    </div>
</section>

<section class="section principles" id="why-businessos">
    <div class="shell">
        <div class="section-heading centered">
            <span class="kicker">Why BusinessOS</span>
            <h2>Software should remove friction, not move it somewhere else.</h2>
            <p>Our products are shaped by four engineering principles that keep the experience useful after the launch-day screenshots are forgotten.</p>
        </div>
        <div class="principle-grid">
            <article>
                <span class="principle-number">01</span>
                <div class="line-icon icon-focus" aria-hidden="true"></div>
                <h3>Focused by design</h3>
                <p>Clear workflows and deliberate features instead of menus filled with things your team never uses.</p>
            </article>
            <article>
                <span class="principle-number">02</span>
                <div class="line-icon icon-speed" aria-hidden="true"></div>
                <h3>Fast where it matters</h3>
                <p>Small initial payloads, server-rendered content and minimal JavaScript keep pages responsive on constrained networks.</p>
            </article>
            <article>
                <span class="principle-number">03</span>
                <div class="line-icon icon-mobile" aria-hidden="true"></div>
                <h3>Mobile is a first-class surface</h3>
                <p>Field teams and business owners should not receive a compressed desktop experience disguised as mobile design.</p>
            </article>
            <article>
                <span class="principle-number">04</span>
                <div class="line-icon icon-scale" aria-hidden="true"></div>
                <h3>Built to evolve</h3>
                <p>Each application has a clean product identity and architecture so the ecosystem can expand without becoming chaotic.</p>
            </article>
        </div>
    </div>
</section>

<section class="section performance-section" id="performance">
    <div class="shell performance-grid">
        <div class="performance-copy">
            <span class="kicker">Fast everywhere</span>
            <h2>Premium does not have to mean heavy.</h2>
            <p>A polished website is useless if customers abandon it before the first screen appears. BusinessOS is engineered around real network constraints, including slower and unstable mobile connections.</p>
            <ul class="check-list">
                <li><span>✓</span> No external font download required</li>
                <li><span>✓</span> Core content works without JavaScript</li>
                <li><span>✓</span> Server-rendered, crawlable HTML</li>
                <li><span>✓</span> Designed for aggressive asset caching</li>
            </ul>
        </div>
        <div class="speed-panel">
            <div class="speed-ring"><span><strong>&lt;500</strong><small>KB target</small></span></div>
            <div class="speed-details">
                <div><span>LCP target</span><strong>≤ 2.5s</strong></div>
                <div><span>INP target</span><strong>≤ 200ms</strong></div>
                <div><span>CLS target</span><strong>≤ 0.1</strong></div>
            </div>
            <p>Performance targets are engineering gates, not marketing claims. Production measurements will be published only after deployment testing.</p>
        </div>
    </div>
</section>

<section class="section seo-section">
    <div class="shell seo-card">
        <div>
            <span class="kicker">Built to be discovered</span>
            <h2>Every app gets its own search identity.</h2>
            <p>BusinessOS does not force every product into one generic corporate page. Each application receives focused content, metadata, structured data and internal linking so search engines and people can understand exactly what it solves.</p>
        </div>
        <div class="search-demo" aria-label="Example search result presentation">
            <div class="search-bar"><span>⌕</span> field sales tracking software</div>
            <article>
                <small>businessos.af › apps › fieldpulse</small>
                <strong>FieldPulse — Field Sales Tracking & Field Force Management</strong>
                <p>Track field sales attendance, client visits, GPS activity, routes and team performance...</p>
            </article>
        </div>
    </div>
</section>

<section class="section final-cta">
    <div class="shell final-cta-card">
        <div class="cta-orb" aria-hidden="true"></div>
        <span class="kicker">Explore the ecosystem</span>
        <h2>Find the BusinessOS app built for your next operational problem.</h2>
        <p>Start with FieldPulse today. More focused BusinessOS applications can join the same architecture without diluting the experience.</p>
        <a class="button button-primary" href="{{ route('apps.index') }}">Browse all apps <span aria-hidden="true">↗</span></a>
    </div>
</section>
@endsection
