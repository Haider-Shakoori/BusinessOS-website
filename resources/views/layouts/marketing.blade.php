<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#08090d">
    <meta name="color-scheme" content="dark">
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <link rel="canonical" href="{{ $meta['canonical'] }}">
    <meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="BusinessOS">
    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:url" content="{{ $meta['canonical'] }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $meta['title'] }}">
    <meta name="twitter:description" content="{{ $meta['description'] }}">

    <link rel="stylesheet" href="{{ asset('assets/css/businessos.css') }}">

    @foreach ($schema ?? [] as $entity)
        <script type="application/ld+json">{!! json_encode($entity, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endforeach
</head>
<body>
    <a class="skip-link" href="#main">Skip to content</a>

    <header class="site-header">
        <div class="shell nav-shell">
            <a class="brand" href="{{ route('home') }}" aria-label="BusinessOS home">
                <span class="brand-mark" aria-hidden="true">
                    <span></span><span></span><span></span>
                </span>
                <span>BusinessOS</span>
            </a>

            <nav class="desktop-nav" aria-label="Primary navigation">
                <a href="{{ route('apps.index') }}">Apps</a>
                <a href="{{ route('home') }}#solutions">Solutions</a>
                <a href="{{ route('home') }}#why-businessos">Why BusinessOS</a>
                <a href="{{ route('home') }}#performance">Performance</a>
            </nav>

            <div class="nav-actions">
                <a class="button button-ghost desktop-cta" href="{{ route('apps.index') }}">Explore apps</a>
                <details class="mobile-menu">
                    <summary aria-label="Open navigation"><span></span><span></span><span></span></summary>
                    <nav aria-label="Mobile navigation">
                        <a href="{{ route('apps.index') }}">Apps</a>
                        <a href="{{ route('home') }}#solutions">Solutions</a>
                        <a href="{{ route('home') }}#why-businessos">Why BusinessOS</a>
                        <a href="{{ route('home') }}#performance">Performance</a>
                    </nav>
                </details>
            </div>
        </div>
    </header>

    <main id="main">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="shell footer-grid">
            <div>
                <a class="brand footer-brand" href="{{ route('home') }}">
                    <span class="brand-mark" aria-hidden="true"><span></span><span></span><span></span></span>
                    <span>BusinessOS</span>
                </a>
                <p>Modern business software engineered to stay clear, fast and useful.</p>
            </div>
            <div class="footer-links">
                <div>
                    <strong>Product</strong>
                    <a href="{{ route('apps.index') }}">All apps</a>
                    <a href="{{ route('apps.show', 'fieldpulse') }}">FieldPulse</a>
                </div>
                <div>
                    <strong>Principles</strong>
                    <a href="{{ route('home') }}#performance">Fast everywhere</a>
                    <a href="{{ route('home') }}#why-businessos">Practical by design</a>
                </div>
            </div>
        </div>
        <div class="shell footer-bottom">
            <span>© {{ date('Y') }} BusinessOS.</span>
            <span>Built for real businesses and real networks.</span>
        </div>
    </footer>
</body>
</html>
