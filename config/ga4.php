<?php

return [
    // G-XXXXXXXXXX (public Google tag ID) and numeric GA4 property ID.
    'measurement_id' => trim((string) env('GA4_MEASUREMENT_ID', '')),
    'property_id' => trim((string) env('GA4_PROPERTY_ID', '')),

    // Absolute path to an untracked Google Cloud service-account JSON file.
    // Never place service-account private keys in the repository or public/ directory.
    'credentials_path' => trim((string) env('GA4_CREDENTIALS_PATH', '')),
    'report_cache_minutes' => max(5, (int) env('GA4_REPORT_CACHE_MINUTES', 15)),
];
