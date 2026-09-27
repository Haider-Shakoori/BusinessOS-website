<?php

return [
    'products' => [
        'fieldpulse' => [
            'services' => ['field-sales-management-software', 'field-sales-visit-management-software', 'offline-business-software'],
            'guides' => ['how-to-track-field-sales-team', 'field-sales-visit-planning-territories', 'offline-first-business-software-poor-internet'],
            'case_studies' => ['fieldpulse-field-sales-platform'],
        ],
        'erp' => [
            'services' => ['custom-erp-development', 'erp-software-afghanistan', 'inventory-management-software', 'manufacturing-inventory-bom-software'],
            'guides' => ['erp-vs-mis-difference', 'how-to-migrate-from-excel-to-erp', 'custom-erp-vs-off-the-shelf-erp', 'manufacturing-bom-costing-guide'],
            'case_studies' => ['corrugated-carton-manufacturing-erp'],
        ],
        'pos' => [
            'services' => ['inventory-management-software', 'supermarket-pos-software'],
            'guides' => ['pos-vs-erp', 'excel-vs-inventory-management-software', 'supermarket-pos-buying-checklist'],
            'case_studies' => ['businessos-pos-retail-checkout'],
        ],
        'pharmacy-management' => [
            'services' => ['pharmacy-management-software', 'inventory-management-software', 'pharmacy-inventory-expiry-software'],
            'guides' => ['pharmacy-expiry-tracking', 'excel-vs-inventory-management-software', 'pharmacy-stock-expiry-reorder-guide'],
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
            'services' => ['restaurant-management-software', 'inventory-management-software', 'restaurant-waiter-ordering-kot-software'],
            'guides' => ['restaurant-kot-kitchen-station-workflow', 'pos-vs-erp', 'restaurant-table-order-kitchen-billing-workflow'],
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
        'offline-business-software' => [
            'guides' => ['offline-first-business-software-poor-internet'],
        ],
        'supermarket-pos-software' => [
            'guides' => ['supermarket-pos-buying-checklist', 'pos-vs-erp'],
        ],
        'pharmacy-inventory-expiry-software' => [
            'guides' => ['pharmacy-stock-expiry-reorder-guide', 'pharmacy-expiry-tracking'],
        ],
        'manufacturing-inventory-bom-software' => [
            'guides' => ['manufacturing-bom-costing-guide', 'bom-actual-consumption-production-costing'],
        ],
        'field-sales-visit-management-software' => [
            'guides' => ['field-sales-visit-planning-territories', 'how-to-track-field-sales-team'],
        ],
        'restaurant-waiter-ordering-kot-software' => [
            'guides' => ['restaurant-table-order-kitchen-billing-workflow', 'restaurant-kot-kitchen-station-workflow'],
        ],
        'dari-pashto-business-software' => [
            'guides' => ['multilingual-business-software-dari-pashto'],
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
        'offline-first-business-software-poor-internet' => ['products' => ['fieldpulse', 'pos', 'pharmacy-management']],
        'supermarket-pos-buying-checklist' => ['products' => ['pos']],
        'pharmacy-stock-expiry-reorder-guide' => ['products' => ['pharmacy-management']],
        'manufacturing-bom-costing-guide' => ['products' => ['erp', 'pvc-pipe-factory', 'raw-materials-db']],
        'field-sales-visit-planning-territories' => ['products' => ['fieldpulse']],
        'restaurant-table-order-kitchen-billing-workflow' => ['products' => ['restaurant-management']],
        'multilingual-business-software-dari-pashto' => ['products' => ['erp', 'pos', 'fieldpulse', 'pharmacy-management', 'restaurant-management']],    ],

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
            'services' => ['inventory-management-software', 'supermarket-pos-software'],
            'guides' => ['pos-vs-erp', 'excel-vs-inventory-management-software', 'supermarket-pos-buying-checklist'],
        ],
        'localized-ecommerce-storefront-modernization' => [
            'products' => [],
            'services' => ['legacy-application-modernization', 'website-development-afghanistan'],
            'guides' => ['modernize-old-laravel-application', 'business-website-seo-foundation'],
        ],
    ],

];
