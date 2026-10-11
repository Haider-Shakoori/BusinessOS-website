<?php

return [
    // G-XXXXXXXXXX (public Google tag ID) and numeric GA4 property ID.
    'measurement_id' => trim((string) env('GA4_MEASUREMENT_ID', '')),
    'property_id' => trim((string) env('GA4_PROPERTY_ID', '')),

    // Absolute path to an untracked Google Cloud service-account JSON file.
    // Never place service-account private keys in the repository or public/ directory.
    'credentials_path' => trim((string) env('GA4_CREDENTIALS_PATH', '')),
    'report_cache_minutes' => max(5, (int) env('GA4_REPORT_CACHE_MINUTES', 15)),
    'trusted_country_header' => trim((string) env('GA4_TRUSTED_COUNTRY_HEADER', '')),
    // EEA, United Kingdom and Switzerland require prior consent for non-essential tracking.
    'consent_countries' => [
        'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GR',
        'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PL', 'PT', 'RO', 'SK',
        'SI', 'ES', 'SE', 'IS', 'LI', 'NO', 'GB', 'CH',
    ],
];
