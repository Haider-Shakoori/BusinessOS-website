<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['fa','ps'], true) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Page not found — BusinessOS</title>
    <link rel="stylesheet" href="{{ asset('assets/css/businessos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/businessos-calm.css') }}">
</head>
<body class="modern-site professional-light calm-premium">
<main class="error-page">
    <div class="error-card">
        <span>404</span>
        <h1>That page is not available.</h1>
        <p>The address may have changed, or the content may no longer be published.</p>
        <div><a class="button button-primary" href="{{ route('home') }}">BusinessOS home</a><a class="button button-ghost" href="{{ route('apps.index') }}">Explore apps</a></div>
    </div>
</main>
</body>
</html>
