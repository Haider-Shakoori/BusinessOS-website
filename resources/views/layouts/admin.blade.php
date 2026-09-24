<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <meta name="color-scheme" content="dark">
    <title>@yield('title', 'CMS') — BusinessOS</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>
<body>
<div class="admin-shell">
    <aside class="admin-sidebar">
        <a class="admin-brand" href="{{ route('admin.dashboard') }}">
            <span class="admin-brand-mark"><i></i><i></i><i></i></span>
            <span>BusinessOS <small>CMS</small></span>
        </a>

        <nav aria-label="CMS navigation">
            <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><span>⌂</span>Overview</a>
            <a class="{{ request()->routeIs('admin.analytics') ? 'active' : '' }}" href="{{ route('admin.analytics') }}"><span>⌁</span>Analytics</a>
            <a class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><span>◫</span>Products</a>
            <a class="{{ request()->routeIs('admin.guides.*') ? 'active' : '' }}" href="{{ route('admin.guides.index') }}"><span>▤</span>Guides</a>
        </nav>

        <div class="admin-sidebar-bottom">
            <a href="{{ route('home') }}" target="_blank" rel="noopener"><span>↗</span>View website</a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"><span>→</span>Sign out</button>
            </form>
        </div>
    </aside>

    <main class="admin-main">
        <header class="admin-topbar">
            <div>
                <small>BUSINESSOS CMS</small>
                <strong>@yield('page-heading', 'Overview')</strong>
            </div>
            <div class="admin-user">
                <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <div><strong>{{ auth()->user()->name }}</strong><small>Administrator</small></div>
            </div>
        </header>

        <div class="admin-content">
            @if (session('status'))
                <div class="admin-flash">{{ session('status') }}</div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
