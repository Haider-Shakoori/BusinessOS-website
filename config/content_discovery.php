<?php

return [
    'products' => [
        'fieldpulse' => [
            'services' => ['field-sales-management-software', 'software-development-afghanistan'],
            'guides' => ['how-to-track-field-sales-team'],
            'case_studies' => ['fieldpulse-field-sales-platform'],
        ],
        'erp' => [
            'services' => ['custom-erp-development', 'erp-software-afghanistan', 'inventory-management-software'],
            'guides' => ['erp-vs-mis-difference', 'how-to-migrate-from-excel-to-erp', 'custom-erp-vs-off-the-shelf-erp'],
            'case_studies' => ['corrugated-carton-manufacturing-erp'],
        ],
        'pos' => [
            'services' => ['inventory-management-software'],
            'guides' => ['pos-vs-erp', 'excel-vs-inventory-management-software'],
            'case_studies' => ['businessos-pos-retail-checkout'],
        ],
        'pharmacy-management' => [
            'services' => ['pharmacy-management-software', 'inventory-management-software'],
            'guides' => ['pharmacy-expiry-tracking', 'excel-vs-inventory-management-software'],
        ],
        'raw-materials-db' => [
            'services' => ['inventory-management-software', 'data-migration-services'],
            'guides' => ['how-to-migrate-from-excel-to-erp', 'excel-vs-inventory-management-software'],
        ],
        'pvc-pipe-factory' => [
            'services' => ['manufacturing-erp', 'inventory-management-software'],
            'guides' => ['bom-actual-consumption-production-costing'],
        ],
        'financial-systems' => [
            'services' => ['financial-management-software', 'custom-erp-development'],
            'guides' => ['financial-management-system-controls', 'erp-vs-mis-difference'],
        ],
        'restaurant-management' => [
            'services' => ['restaurant-management-software', 'inventory-management-software'],
            'guides' => ['restaurant-kot-kitchen-station-workflow', 'pos-vs-erp'],
        ],
    ],

    'services' => [
        'custom-erp-development' => [
            'guides' => ['custom-erp-vs-off-the-shelf-erp', 'erp-vs-mis-difference', 'how-to-migrate-from-excel-to-erp'],
        ],
        'mis-development' => [
            'guides' => ['erp-vs-mis-difference'],
        ],
        'website-development-afghanistan' => [
            'guides' => ['business-website-seo-foundation', 'modernize-old-laravel-application'],
        ],
        'data-migration-services' => [
            'guides' => ['how-to-migrate-from-excel-to-erp', 'excel-vs-inventory-management-software'],
        ],
        'legacy-application-modernization' => [
            'guides' => ['modernize-old-laravel-application'],
        ],
        'manufacturing-erp' => [
            'guides' => ['bom-actual-consumption-production-costing', 'custom-erp-vs-off-the-shelf-erp'],
        ],
        'pharmacy-management-software' => [
            'guides' => ['pharmacy-expiry-tracking', 'excel-vs-inventory-management-software'],
        ],
        'erp-software-afghanistan' => [
            'guides' => ['erp-vs-mis-difference', 'custom-erp-vs-off-the-shelf-erp', 'how-to-migrate-from-excel-to-erp'],
        ],
        'restaurant-management-software' => [
            'guides' => ['restaurant-kot-kitchen-station-workflow', 'pos-vs-erp'],
        ],
        'software-development-afghanistan' => [
            'guides' => ['business-website-seo-foundation', 'modernize-old-laravel-application', 'custom-erp-vs-off-the-shelf-erp'],
        ],
        'inventory-management-software' => [
            'guides' => ['excel-vs-inventory-management-software', 'how-to-migrate-from-excel-to-erp', 'bom-actual-consumption-production-costing'],
        ],
        'field-sales-management-software' => [
            'guides' => ['how-to-track-field-sales-team'],
        ],
        'financial-management-software' => [
            'guides' => ['financial-management-system-controls', 'erp-vs-mis-difference'],
        ],
    ],

    'guides' => [
        'erp-vs-mis-difference' => ['products' => ['erp', 'financial-systems']],
        'how-to-migrate-from-excel-to-erp' => ['products' => ['erp', 'raw-materials-db']],
        'custom-erp-vs-off-the-shelf-erp' => ['products' => ['erp']],
        'bom-actual-consumption-production-costing' => ['products' => ['pvc-pipe-factory', 'raw-materials-db']],
        'pharmacy-expiry-tracking' => ['products' => ['pharmacy-management']],
        'modernize-old-laravel-application' => ['products' => ['erp']],
        'business-website-seo-foundation' => ['products' => []],
        'pos-vs-erp' => ['products' => ['pos', 'erp']],
        'excel-vs-inventory-management-software' => ['products' => ['erp', 'pos', 'raw-materials-db']],
        'how-to-track-field-sales-team' => ['products' => ['fieldpulse']],
        'restaurant-kot-kitchen-station-workflow' => ['products' => ['restaurant-management']],
        'financial-management-system-controls' => ['products' => ['financial-systems', 'erp']],
    ],

    'case_studies' => [
        'corrugated-carton-manufacturing-erp' => [
            'products' => ['erp', 'raw-materials-db'],
            'services' => ['manufacturing-erp', 'custom-erp-development'],
            'guides' => ['bom-actual-consumption-production-costing'],
        ],
        'fieldpulse-field-sales-platform' => [
            'products' => ['fieldpulse'],
            'services' => ['field-sales-management-software'],
            'guides' => ['how-to-track-field-sales-team'],
        ],
        'businessos-pos-retail-checkout' => [
            'products' => ['pos'],
            'services' => ['inventory-management-software'],
            'guides' => ['pos-vs-erp', 'excel-vs-inventory-management-software'],
        ],
        'localized-ecommerce-storefront-modernization' => [
            'products' => [],
            'services' => ['legacy-application-modernization', 'website-development-afghanistan'],
            'guides' => ['modernize-old-laravel-application', 'business-website-seo-foundation'],
        ],
    ],

];
