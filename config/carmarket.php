<?php

use App\StockUsedCentralEurope;
use App\StockVehicle;
use App\StockVehicleNew;
use App\StockVehicleUsed;
use App\Resolvers\LabelBy\TransactionStatus;
use App\Resolvers\LabelBy\TransactionCountry;
use App\Resolvers\LabelBy\Company;
use App\Resolvers\LabelBy\BuyerId;
use App\Resolvers\LabelBy\ConditionType;

return [
    'autoidat_user' => env('AUTOIDAT_USER'),
    'autoidat_password' => env('AUTOIDAT_PASSWORD'),
    'autoidat_key' => env('AUTOIDAT_KEY'),
    'google_translate_api_key' => env('GOOGLE_TRANSLATE_API_KEY'),
    'used_stock_switzerland_url' => env('USED_STOCK_SWITZERLAND_URL'),
    'used_stock_switzerland_api_token' => env('USED_STOCK_SWITZERLAND_API_TOKEN'),
    'csv_folder' => public_path('storage'),
    'enable_registration' => env('ENABLE_USER_REGISTRATION', false),
    'bidding' => [
        'client_id' => env('BIDDING_CLIENT_ID', 1),
        'api_token' => env('BIDDING_API_TOKEN', 'token:678b60ddbbea86779b36f37af8649a47'),
        'endpoint_url' => env('BIDDING_ENDPOINT_URL', 'https://carpricing.eu/interface/receiving/set_client_data_input.php'),
        'cron_trigger_url' => env('BIDDING_CRON_TRIGGER_URL', 'https://carpricing.eu/interface/receiving/client_price_cron.php'),
    ],
    'autosphere' => [
        'user' => env('AUTOSPHERE_USER', 'efs'),
        'password' => env('AUTOSPHERE_PASSWORD', 'AmiPraha1234'),
//        'endpoint_url' => env('AUTOSPHERE_ENDPOINT_URL', 'https://emilfreyselect.cz/api/rest/v1/ats-sk-export/cars'),
        'endpoint_url' => env('AUTOSPHERE_ENDPOINT_URL', 'https://emilfreyselect.cz/api/rest/v1/carmarket-export/cars'),
    ],
    'morph_map' => [
        'cart.add-used-car' => StockUsedCentralEurope::class
    ],
    'imports' => [
        'used' => [
            'nl' => [
                'folders' => [
                    'import' => storage_path('app/exports/nl'),
                    'processed' => storage_path('app/exports/nl/processed')
                ],
                'mappings' => [
                    '31300' => [
                        // XML fieldname => value or ID from local database: klantnummer == company ID
                        'klantnummer' => 86,
                        'locatie_voertuig' => 'Deventer'
                    ],
                    '32032' => [
                        // XML fieldname => value or ID from local database: klantnummer == company ID
                        'klantnummer' => 88,
                        'locatie_voertuig' => 'Utrecht'
                    ],
                    '33779' => [
                        // XML fieldname => value or ID from local database: klantnummer == company ID
                        'klantnummer' => 87,
                        'locatie_voertuig' => 'Utrecht'
                    ],
                ]
            ],
            'de' => [
                'folders' => [
                    'import' => storage_path('app/exports/de'),
                    'processed' => storage_path('app/exports/de/processed')
                ],
                'mappings' => [
                    'company_data' => [
                        'company_id' => 106, //108
                        'locatie_voertuig' => 'Deventer'
                    ]
                ]
            ],
            'cz' => [
                'folders' => [
                    'import' => storage_path('app/exports/cz'),
                    'processed' => storage_path('app/exports/cz/processed')
                ],
                'mappings' => [
                    'company_data' => [
                        'company_id' => 107, //109
                        'locatie_voertuig' => 'Deventer'
                    ]
                ]
            ]
        ]
    ],
    'resource' => [
        'all' => StockVehicle::class,
        'new' => StockVehicleNew::class,
        'used' => StockVehicleUsed::class,
    ],
    'frontend' => [
        'transactions' => [
            'filters' => [
                'buyer' => [
                    'enquiry_id' => [
                        'column' => 'enquiry_id',
                        'type' => 'single',
                        'values' => []
                    ],
                    'country' => [
                        'column' => 'country',
                        'type' => 'single',
                        'values' => [],
                        'labelBy' => TransactionCountry::class
                    ],
                    'status' => [
                        'column' => 'status',
                        'type' => 'single',
                        'values' => [],
                        'labelBy' => TransactionStatus::class
                    ],
                    'seller_company_id' => [
                        'column' => 'seller_company_id',
                        'type' => 'single',
                        'values' => [],
                        'labelBy' => Company::class
                    ]
                ],
                'seller' => [
                    'enquiry_id' => [
                        'column' => 'enquiry_id',
                        'type' => 'single',
                        'values' => []
                    ],
                    'country' => [
                        'column' => 'country',
                        'type' => 'single',
                        'values' => [],
                        'labelBy' => TransactionCountry::class
                    ],
                    'status' => [
                        'column' => 'status',
                        'type' => 'single',
                        'values' => [],
                        'labelBy' => TransactionStatus::class
                    ],
                    'buyer_id' => [
                        'column' => 'buyer_id',
                        'type' => 'single',
                        'values' => [],
                        'labelBy' => BuyerId::class
                    ]
                ],
                'admin' => [
                    'enquiry_id' => [
                        'column' => 'enquiry_id',
                        'type' => 'single',
                        'values' => []
                    ],
                    'country' => [
                        'column' => 'country',
                        'type' => 'single',
                        'values' => [],
                        'labelBy' => TransactionCountry::class
                    ],
                    'status' => [
                        'column' => 'status',
                        'type' => 'single',
                        'values' => [],
                        'labelBy' => TransactionStatus::class
                    ],
                    'buyer_id' => [
                        'column' => 'buyer_id',
                        'type' => 'single',
                        'values' => [],
                        'labelBy' => BuyerId::class
                    ],
                    'seller_company_id' => [
                        'column' => 'seller_company_id',
                        'type' => 'single',
                        'values' => [],
                        'labelBy' => Company::class
                    ]
                ],
            ]
        ],
        'filters' => [
            'condition_type' => [
                'column' => 'condition_type',
                'type' => 'single',
                'values' => [],
                'labelBy' => ConditionType::class
            ],
            'brand' => [
                'column' => 'brand',
                'type' => 'single',
                'values' => []
            ],
            'model' => [
                'column' => 'model',
                'type' => 'single',
                'values' => []
            ],
            'fuel_type' => [
                'column' => 'fuel_type',
                'type' => 'single',
                'values' => []
            ],
            'gearbox' => [
                'column' => 'gearbox',
                'type' => 'single',
                'values' => [],
                'labelBy' => \App\Resolvers\LabelBy\Gearbox::class
            ],
            'country' => [
                'column' => 'country',
                'type' => 'single',
                'values' => [],
                'labelBy' => \App\Resolvers\LabelBy\Country::class
            ],
            'price_in_euro' => [
                'column' => 'price_in_euro',
                'type' => 'max',
                'values' => 0,
                'labelBy' => \App\Resolvers\LabelBy\MaxPrice::class
            ],
            'km' => [
                'column' => 'km',
                'type' => 'max',
                'values' => 0,
                'labelBy' => \App\Resolvers\LabelBy\MaxKm::class
            ],
            'transaction_status' => [
                'column' => 'transaction_status',
                'type' => 'custom',
                'values' => 0
            ],
            'firstregistration' => [
                'column' => 'firstregistration',
                'type' => 'single',
                'values' => []
            ]
        ],
        'columns' => [
            'search' => [
                'manufacturer_id',
                'brand',
                'model',
                'version_description',
                'color_code',
                'color_description',
                'options_code',
                'option_code_description',
                'option_code_description_english'
            ],
            'list' => [
                [
                    'column' => 'manufacturer_id',
                    'label' => 'Manufacturer Id',
                    'default' => true
                ],
                [
                    'column' => 'origin',
                    'label' => 'Origin',
                    'default' => true
                ],
                [
                    'column' => 'brand',
                    'label' => 'Brand',
                    'default' => true
                ],
                [
                    'column' => 'model',
                    'label' => 'Model',
                    'default' => true
                ],
                [
                    'column' => 'version_description',
                    'label' => 'Version',
                    'default' => true
                ],
                [
                    'column' => 'fuel_type',
                    'label' => 'Fuel Type',
                    'default' => false
                ],
                [
                    'column' => 'gearbox',
                    'label' => 'Gearbox',
                    'default' => false
                ],
                [
                    'column' => 'km',
                    'label' => 'Km',
                    'default' => true
                ],
                [
                    'column' => 'firstregistration',
                    'label' => 'First Registration',
                    'default' => false
                ],
                [
                    'column' => 'color_code',
                    'label' => 'Color Code',
                    'default' => false
                ],
                [
                    'column' => 'color_description',
                    'label' => 'Color Description',
                    'default' => false
                ],
                [
                    'column' => 'options_code',
                    'label' => 'Options Code',
                    'default' => false,
                    'tooltip' => true
                ],
                [
                    'column' => 'option_code_description',
                    'label' => 'Option Code Description',
                    'default' => false,
                    'tooltip' => true
                ],
                [
                    'column' => 'option_code_description_english',
                    'label' => 'Option Code Description English',
                    'default' => false,
                    'tooltip' => true
                ],
                [
                    'column' => 'b2b_price_ex_vat',
                    'label' => 'B2B Price Ex Vat',
                    'default' => true
                ],
                [
                    'column' => 'price_in_euro',
                    'label' => 'Price',
                    'default' => true
                ],
                [
                    'column' => 'vat_deductible',
                    'label' => 'Vat Deductible',
                    'default' => false
                ],
                [
                    'column' => 'damages_excl_vat_info',
                    'label' => 'Damages Excluded Vat Info',
                    'default' => false
                ],
                [
                    'column' => 'disponsibility',
                    'label' => 'Disponsibility',
                    'default' => false
                ],
                [
                    'column' => 'language_option_code_description',
                    'label' => 'Language Option Code Description',
                    'default' => false
                ],
                [
                    'column' => 'currency_iso_codification',
                    'label' => 'Currency Iso Codification',
                    'default' => true
                ],
                [
                    'column' => 'url_address',
                    'label' => 'Url Address',
                    'default' => false
                ],
                [
                    'column' => 'note',
                    'label' => 'Note',
                    'default' => false
                ],
                [
                    'column' => 'media_path',
                    'label' => 'Media',
                    'default' => false
                ],
                [
                    'column' => 'connectivity_partner_id',
                    'label' => 'Connectivity Partner Id',
                    'default' => false
                ],
                [
                    'column' => 'body_type',
                    'label' => 'Body Type',
                    'default' => false
                ],
                [
                    'column' => 'sku_number',
                    'label' => 'SKU Number',
                    'default' => false
                ],
                [
                    'column' => 'certification_code',
                    'label' => 'Certification Code',
                    'default' => false
                ],
                [
                    'column' => 'condition_type',
                    'label' => 'Condition Type',
                    'default' => false
                ],
                [
                    'column' => 'fuel_consumption_city',
                    'label' => 'Fuel Consumption In City',
                    'default' => false
                ],
                [
                    'column' => 'fuel_consumption_land',
                    'label' => 'Fuel Consumption In Land',
                    'default' => false
                ],
                [
                    'column' => 'fuel_consumption_rating',
                    'label' => 'Fuel Consumption Rating',
                    'default' => false
                ],
                [
                    'column' => 'fuel_consumption_total',
                    'label' => 'Fuel Consumption Total',
                    'default' => false
                ],
                [
                    'column' => 'cylinders',
                    'label' => 'Cylinders',
                    'default' => false
                ],
                [
                    'column' => 'documents',
                    'label' => 'Documents',
                    'default' => false
                ],
                [
                    'column' => 'doors',
                    'label' => 'Doors',
                    'default' => false
                ],
                [
                    'column' => 'drive_type',
                    'label' => 'Drive Type',
                    'default' => false
                ],
                [
                    'column' => 'has_warranty',
                    'label' => 'Drive Type',
                    'default' => false
                ],
                [
                    'column' => 'external_id',
                    'label' => 'External Id',
                    'default' => false
                ],
                [
                    'column' => 'model_group',
                    'label' => 'Model Group',
                    'default' => false
                ],
                [
                    'column' => 'pollution_norm',
                    'label' => 'Pollution Norm',
                    'default' => false
                ],
                [
                    'column' => 'price',
                    'label' => 'Price',
                    'default' => false
                ],
                [
                    'column' => 'price_history',
                    'label' => 'Price History',
                    'default' => false
                ],
                [
                    'column' => 'price_new',
                    'label' => 'Price New',
                    'default' => false
                ],
                [
                    'column' => 'properties',
                    'label' => 'Properties',
                    'default' => false
                ],
                [
                    'column' => 'additional_properties',
                    'label' => 'Additional Properties',
                    'default' => false
                ],
                [
                    'column' => 'seats',
                    'label' => 'Seats',
                    'default' => false
                ],
                [
                    'column' => 'segmentation_id',
                    'label' => 'Segmentation Id',
                    'default' => false
                ],
                [
                    'column' => 'seller',
                    'label' => 'Seller',
                    'default' => false
                ],
                [
                    'column' => 'teaser',
                    'label' => 'Teaser',
                    'default' => false
                ],
                [
                    'column' => 'type_name',
                    'label' => 'Type Name',
                    'default' => false
                ],
                [
                    'column' => 'videos',
                    'label' => 'Videos',
                    'default' => false
                ],
                [
                    'column' => 'weight',
                    'label' => 'Weight',
                    'default' => false
                ],
                [
                    'column' => 'vehicle_type',
                    'label' => 'Vehicle Type',
                    'default' => false
                ],
                [
                    'column' => 'country',
                    'label' => 'Country',
                    'default' => false
                ],
                [
                    'column' => 'company',
                    'label' => 'Company',
                    'default' => false
                ],
                [
                    'column' => 'company_id',
                    'label' => 'Company Id',
                    'default' => false
                ],
                [
                    'column' => 'co2',
                    'label' => 'Co2',
                    'default' => false
                ],
                [
                    'column' => 'cm3',
                    'label' => 'Cm3',
                    'default' => false
                ],
                [
                    'column' => 'kw',
                    'label' => 'Kw',
                    'default' => false
                ],
                [
                    'column' => 'hp',
                    'label' => 'Hp',
                    'default' => false
                ],
                [
                    'column' => 'interior',
                    'label' => 'Interior',
                    'default' => false
                ],
                [
                    'column' => 'version_code',
                    'label' => 'Version Code',
                    'default' => false
                ]
            ]
        ]
    ],
    'role_label' => [
        'Uploader' => '(Contact for enquiries to my company)',
        'Logistics' => '(Responsible to maintain the list of available cars for my company)',
    ]
];
