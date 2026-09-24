<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <meta name="color-scheme" content="dark">
    <title>CMS Sign In — BusinessOS</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>
<body class="admin-login-body">
    <main class="admin-login-card">
        <a class="admin-brand login-brand" href="{{ route('home') }}">
            <span class="admin-brand-mark"><i></i><i></i><i></i></span>
            <span>BusinessOS <small>CMS</small></span>
        </a>
        <div class="admin-login-copy">
            <span>ADMINISTRATION</span>
            <h1>Sign in to BusinessOS CMS.</h1>
            <p>Manage guides and review first-party website analytics.</p>
        </div>

        <form method="POST" action="{{ route('admin.login.store') }}" class="admin-form">
            @csrf
            <label>Email
                <input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
                @error('email')<small>{{ $message }}</small>@enderror
            </label>
            <label>Password
                <input type="password" name="password" autocomplete="current-password" required>
                @error('password')<small>{{ $message }}</small>@enderror
            </label>
            <label class="admin-check"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
            <button class="admin-primary-button" type="submit">Sign in <span>→</span></button>
        </form>

        <p class="admin-login-note">CMS accounts are created deliberately from the server. Public registration is disabled.</p>
    </main>
</body>
</html>
