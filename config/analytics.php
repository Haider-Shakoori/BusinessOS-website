<?php

return [
    'enabled' => env('ANALYTICS_ENABLED', true),
    'visitor_cookie' => 'bos_vid',
    'internal_cookie' => 'bos_internal',
    'country_cookie' => 'bos_country',
    'cookie_days' => 400,
    'country_cookie_days' => 1,
    'retention_days' => (int) env('ANALYTICS_RETENTION_DAYS', 400),

    // Country detection stays local/privacy-first. Trusted host/CDN country
    // headers are preferred. If none exist, BusinessOS resolves the request IP
    // against a local DB-IP Country Lite MMDB file and never stores the raw IP.
    'local_country_lookup' => env('ANALYTICS_LOCAL_COUNTRY_LOOKUP', true),
    'country_database_path' => env(
        'ANALYTICS_COUNTRY_DATABASE_PATH',
        storage_path('app/analytics/dbip-country-lite.mmdb')
    ),
    'country_database_url_template' => env(
        'ANALYTICS_COUNTRY_DATABASE_URL_TEMPLATE',
        'https://download.db-ip.com/free/dbip-country-lite-%s.mmdb.gz'
    ),
    'country_headers' => array_values(array_filter([
        env('ANALYTICS_COUNTRY_HEADER'),
        'CF-IPCountry',
        'CloudFront-Viewer-Country',
        'X-Vercel-IP-Country',
        'X-Country-Code',
        'X-GeoIP-Country',
        'X-AppEngine-Country',
    ])),
    'country_server_vars' => [
        'GEOIP_COUNTRY_CODE',
        'MM_COUNTRY_CODE',
        'COUNTRY_CODE',
        'HTTP_CF_IPCOUNTRY',
        'HTTP_CLOUDFRONT_VIEWER_COUNTRY',
        'HTTP_X_COUNTRY_CODE',
        'HTTP_X_GEOIP_COUNTRY',
        'HTTP_X_APPENGINE_COUNTRY',
    ],

    'country_names' => [
        'AF' => 'Afghanistan',
        'AE' => 'United Arab Emirates',
        'AU' => 'Australia',
        'CA' => 'Canada',
        'CN' => 'China',
        'DE' => 'Germany',
        'FR' => 'France',
        'GB' => 'United Kingdom',
        'IN' => 'India',
        'IQ' => 'Iraq',
        'IR' => 'Iran',
        'JP' => 'Japan',
        'KG' => 'Kyrgyzstan',
        'KR' => 'South Korea',
        'KZ' => 'Kazakhstan',
        'NL' => 'Netherlands',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'QA' => 'Qatar',
        'RU' => 'Russia',
        'SA' => 'Saudi Arabia',
        'TJ' => 'Tajikistan',
        'TM' => 'Turkmenistan',
        'TR' => 'Türkiye',
        'US' => 'United States',
        'UZ' => 'Uzbekistan',
    ],
];
