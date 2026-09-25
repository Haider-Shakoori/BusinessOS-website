<?php

return [
    'indexnow' => [
        'enabled' => env('INDEXNOW_ENABLED', false),
        'key' => env('INDEXNOW_KEY'),
        'endpoint' => env('INDEXNOW_ENDPOINT', 'https://api.indexnow.org/indexnow'),
        'key_path' => '/indexnow-key.txt',
        'timeout' => (int) env('INDEXNOW_TIMEOUT', 4),
    ],
];
