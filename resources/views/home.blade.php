@extends('layouts.marketing')

@section('content')
<section class="story-hero" id="top">
    <div class="story-grid" aria-hidden="true"></div>
    <div class="story-aurora story-aurora-a" aria-hidden="true"></div>
    <div class="story-aurora story-aurora-b" aria-hidden="true"></div>

    <div class="shell story-hero-shell">
        <div class="story-hero-copy">
            <div class="eyebrow"><span class="pulse-dot"></span> BusinessOS software ecosystem</div>
            <h1>Run the business.<br><span>Not the software.</span></h1>
            <p>BusinessOS builds focused applications for the work companies actually do—selling, coordinating teams, managing operations and making decisions—without the weight of bloated enterprise software.</p>

            <div class="hero-actions">
                <a class="button button-primary" href="#products">Explore the ecosystem <span aria-hidden="true">↓</span></a>
                <a class="button button-ghost" href="{{ route('apps.index') }}">View all apps <span aria-hidden="true">↗</span></a>
            </div>

            <div class="story-signals" aria-label="BusinessOS product principles">
                <span><i></i> Fast on weak connections</span>
                <span><i></i> Mobile-first where work happens</span>
                <span><i></i> Focused around real workflows</span>
            </div>
        </div>

        <div class="story-command" aria-label="BusinessOS product preview">
            <div class="story-command-bar">
                <span class="brand-mark mini" aria-hidden="true"><span></span><span></span><span></span></span>
                <div><small>BUSINESSOS</small><strong>Operations overview</strong></div>
                <span class="story-live">● Live</span>
            </div>
            <div class="story-command-body">
                <div class="story-kpis">
                    <article><small>Active field team</small><strong>18</strong><span>+3 today</span></article>
                    <article><small>Client visits</small><strong>42</strong><span>87% verified</span></article>
                    <article><small>Coverage</small><strong>76%</strong><span>On target</span></article>
                </div>
                <div class="story-command-grid">
                    <div class="story-map">
                        <div class="map-grid"></div>
                        <span class="story-route r1"></span><span class="story-route r2"></span>
                        <i class="story-pin p1"></i><i class="story-pin p2"></i><i class="story-pin p3"></i><i class="story-pin p4"></i>
                        <div class="story-map-label"><span></span> Field activity</div>
                    </div>
                    <div class="story-feed">
                        <small>LIVE ACTIVITY</small>
                        <div><i></i><span><strong>Client visit verified</strong><small>2 min ago</small></span></div>
                        <div><i></i><span><strong>Route synchronized</strong><small>8 min ago</small></span></div>
                        <div><i></i><span><strong>Work session started</strong><small>14 min ago</small></span></div>
                    </div>
                </div>
            </div>
            <div class="story-float story-float-a"><span>⌁</span><div><small>Connectivity</small><strong>Offline-ready</strong></div></div>
            <div class="story-float story-float-b"><span>✦</span><div><small>BusinessOS AI</small><strong>Insights available</strong></div></div>
        </div>
    </div>

    <a class="story-scroll" href="#products" aria-label="Scroll to BusinessOS products"><span></span> Discover</a>
</section>

<section class="story-ticker" aria-label="BusinessOS capability areas">
    <div class="shell">
        <span>Sales</span><i>•</i><span>Field Operations</span><i>•</i><span>Automation</span><i>•</i><span>Analytics</span><i>•</i><span>Management</span><i>•</i><span>Mobile Work</span>
    </div>
</section>

<section class="story-section story-products" id="products">
    <div class="shell">
        <div class="story-section-head">
            <span class="story-index">01 / PRODUCTS</span>
            <div>
                <span class="kicker">The ecosystem</span>
                <h2>One brand. Focused software for different parts of the business.</h2>
            </div>
            <p>BusinessOS products are designed to solve a defined operational problem well. Each app gets its own identity while sharing the same standard for speed, clarity and serious engineering.</p>
        </div>

        <article class="story-product-card">
            <div class="story-product-copy">
                <div class="story-product-top">
                    <div class="app-icon fieldpulse-icon" aria-hidden="true"><span></span><span></span></div>
                    <span class="status-pill">{{ $featured['status'] }}</span>
                </div>
                <span class="kicker">{{ $featured['eyebrow'] }}</span>
                <h3>{{ $featured['name'] }}</h3>
                <p class="story-product-headline">{{ $featured['headline'] }}</p>
                <p>{{ $featured['short_description'] }}</p>

                <div class="story-feature-list">
                    @foreach ($featured['highlights'] as $index => $highlight)
                        <span><i>0{{ $index + 1 }}</i>{{ $highlight }}</span>
                    @endforeach
                </div>

                <div class="story-product-actions">
                    <a class="button button-primary" href="{{ route('apps.show', $featured['slug']) }}">Explore {{ $featured['name'] }} <span aria-hidden="true">↗</span></a>
                    <a class="text-link" href="{{ route('apps.index') }}">All BusinessOS apps <span>→</span></a>
                </div>
            </div>

            <div class="story-product-visual">
                <div class="story-phone">
                    <div class="phone-island"></div>
                    <div class="story-phone-screen">
                        <div class="story-phone-brand"><b>F</b><span>FieldPulse</span><i></i></div>
                        <small>Good afternoon</small>
                        <strong>Your field day</strong>
                        <div class="story-work-card">
                            <div><span>↗</span><p><small>Work session</small><strong>06h 42m</strong></p></div>
                            <em>Active</em>
                        </div>
                        <div class="story-phone-stats">
                            <span><small>Visits</small><strong>7</strong></span>
                            <span><small>Distance</small><strong>18.2 km</strong></span>
                        </div>
                        <div class="story-mini-map">
                            <div class="map-grid"></div><span></span>
                            <i></i><i></i><i></i>
                        </div>
                    </div>
                </div>
                <div class="story-desk-card card-one"><small>VISITS</small><strong>42</strong><span>87% verified</span></div>
                <div class="story-desk-card card-two"><small>SYNC</small><strong>Ready</strong><span>Offline queue clear</span></div>
            </div>
        </article>
    </div>
</section>

<section class="story-section story-problem" id="solutions">
    <div class="shell">
        <div class="story-section-head compact">
            <span class="story-index">02 / PURPOSE</span>
            <div>
                <span class="kicker">Built around work</span>
                <h2>Software should make the business easier to run.</h2>
            </div>
        </div>

        <div class="story-purpose-grid">
            <article>
                <span>01</span>
                <h3>See what is happening</h3>
                <p>Turn fragmented operational activity into a clear view managers can understand and act on.</p>
            </article>
            <article>
                <span>02</span>
                <h3>Keep teams moving</h3>
                <p>Design mobile workflows around people working in the field instead of forcing office software onto them.</p>
            </article>
            <article>
                <span>03</span>
                <h3>Reduce repeated work</h3>
                <p>Connect workflows, records and automation so information does not need to be entered and explained again and again.</p>
            </article>
            <article>
                <span>04</span>
                <h3>Make decisions faster</h3>
                <p>Put useful information and AI-assisted insight close to the operational data that produced it.</p>
            </article>
        </div>
    </div>
</section>

<section class="story-section story-principles" id="why-businessos">
    <div class="shell">
        <div class="story-section-head">
            <span class="story-index">03 / PRINCIPLES</span>
            <div>
                <span class="kicker">Why BusinessOS</span>
                <h2>Serious engineering without enterprise bloat.</h2>
            </div>
            <p>The experience should feel premium because the product is thoughtful, not because the browser downloaded megabytes of decoration.</p>
        </div>

        <div class="story-principle-stage">
            <article>
                <span class="story-big-number">01</span>
                <div><small>FOCUSED</small><h3>Only what earns its place.</h3><p>Every feature should support a real business workflow. Complexity is a cost, so we make it justify itself.</p></div>
            </article>
            <article>
                <span class="story-big-number">02</span>
                <div><small>MOBILE</small><h3>Work happens away from desks.</h3><p>Mobile experiences are designed as primary product surfaces, especially for field teams and operators.</p></div>
            </article>
            <article>
                <span class="story-big-number">03</span>
                <div><small>FAST</small><h3>Useful even when the network is not.</h3><p>Server-rendered pages, lightweight assets and offline-aware product design keep BusinessOS practical on constrained connections.</p></div>
            </article>
        </div>
    </div>
</section>

<section class="story-section story-performance" id="performance">
    <div class="shell story-performance-grid">
        <div class="story-performance-copy">
            <span class="story-index">04 / PERFORMANCE</span>
            <span class="kicker">Fast everywhere</span>
            <h2>Designed for the internet people actually have.</h2>
            <p>BusinessOS treats bandwidth, latency and unstable connections as product constraints—not edge cases. That matters in Afghanistan, and it makes the experience better everywhere else too.</p>

            <div class="story-checks">
                <span><i>✓</i> No external font dependency</span>
                <span><i>✓</i> Core content without JavaScript</span>
                <span><i>✓</i> Server-rendered crawlable HTML</span>
                <span><i>✓</i> Aggressive asset caching</span>
            </div>
        </div>

        <div class="story-performance-panel">
            <div class="story-speed-main">
                <small>INITIAL TRANSFER TARGET</small>
                <strong>&lt;500<span>KB</span></strong>
                <p>for ordinary marketing pages where practical</p>
            </div>
            <div class="story-vitals">
                <div><span>LCP</span><strong>≤ 2.5s</strong><small>target</small></div>
                <div><span>INP</span><strong>≤ 200ms</strong><small>target</small></div>
                <div><span>CLS</span><strong>≤ 0.1</strong><small>target</small></div>
            </div>
            <small class="story-disclaimer">Performance values are engineering targets. Real production results are measured after deployment rather than invented for marketing.</small>
        </div>
    </div>
</section>

<section class="story-section story-resources" id="resources">
    <div class="shell">
        <div class="story-section-head">
            <span class="story-index">05 / RESOURCES</span>
            <div>
                <span class="kicker">Guides & resources</span>
                <h2>Useful ideas for better operations.</h2>
            </div>
            <p>Focused guidance on field work, software choices, mobile operations and the systems behind clearer execution.</p>
        </div>

        @if ($latestGuides->count())
            <div class="home-resource-grid">
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
            <div class="home-resource-empty">
                <span>Resources are managed from the BusinessOS CMS and will appear here when published.</span>
            </div>
        @endif

        <div class="home-resource-more">
            <a class="button button-ghost" href="{{ route('resources.index') }}">View all resources <span aria-hidden="true">↗</span></a>
        </div>
    </div>
</section>

<section class="story-section story-final">
    <div class="shell story-final-card">
        <div class="story-final-glow" aria-hidden="true"></div>
        <span class="story-index">06 / NEXT</span>
        <span class="kicker">BusinessOS</span>
        <h2>Start with one problem.<br>Build a better operating system for the business.</h2>
        <p>Explore FieldPulse now and follow the BusinessOS ecosystem as more focused applications are released.</p>
        <div class="hero-actions story-final-actions">
            <a class="button button-primary" href="{{ route('apps.show', 'fieldpulse') }}">Explore FieldPulse <span aria-hidden="true">↗</span></a>
            <a class="button button-ghost" href="{{ route('apps.index') }}">Browse all apps</a>
        </div>
    </div>
</section>
@endsection
