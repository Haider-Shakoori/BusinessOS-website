<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AnalyticsPreferenceController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $choice = $request->validate(['choice' => ['required', 'in:yes,no']])['choice'];

        return redirect()->route('privacy')->withCookie(cookie(
            'bos_ga4_choice',
            $choice,
            60 * 24 * 180,
            '/',
            null,
            app()->isProduction(),
            true,
            false,
            'lax'
        ));
    }
}
