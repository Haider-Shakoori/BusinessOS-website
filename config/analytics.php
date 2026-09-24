<?php

return [
    'enabled' => env('ANALYTICS_ENABLED', true),
    'visitor_cookie' => 'bos_vid',
    'cookie_days' => 400,
    'retention_days' => (int) env('ANALYTICS_RETENTION_DAYS', 400),
    'country_headers' => array_values(array_filter([
        env('ANALYTICS_COUNTRY_HEADER'),
        'CF-IPCountry',
        'CloudFront-Viewer-Country',
        'X-Vercel-IP-Country',
        'X-Country-Code',
    ])),
];
