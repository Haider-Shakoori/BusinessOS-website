<?php

return [
    // Exact URL-prefix or sc-domain: property registered in Google Search Console.
    'site_url' => trim((string) env('SEARCH_CONSOLE_SITE_URL', '')),
    // May reuse the GA4 JSON if its service account has Search Console access.
    'credentials_path' => trim((string) env('SEARCH_CONSOLE_CREDENTIALS_PATH', env('GA4_CREDENTIALS_PATH', ''))),
    'report_cache_minutes' => max(5, (int) env('SEARCH_CONSOLE_CACHE_MINUTES', 30)),
];
