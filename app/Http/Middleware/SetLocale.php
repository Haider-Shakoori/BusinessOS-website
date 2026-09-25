<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const ALLOWED = ['en', 'fa', 'ps'];

    public function handle(Request $request, Closure $next): Response
    {
        $requested = strtolower((string) $request->query('lang', ''));

        if (in_array($requested, self::ALLOWED, true)) {
            $request->session()->put('locale', $requested);
        }

        $locale = (string) $request->session()->get('locale', config('app.locale', 'en'));

        if (! in_array($locale, self::ALLOWED, true)) {
            $locale = 'en';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
