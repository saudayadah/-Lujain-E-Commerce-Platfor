<?php

return [
    'default_gateway' => env('PAYMENT_GATEWAY', 'moyasar'),
    
    'moyasar' => [
        'enabled' => env('MOYASAR_ENABLED', true),
        'publishable_key' => env('MOYASAR_PUBLISHABLE_KEY'),
        'secret_key' => env('MOYASAR_SECRET_KEY'),
        'webhook_secret' => env('MOYASAR_WEBHOOK_SECRET'),
        'callback_url' => env('MOYASAR_CALLBACK_URL', env('APP_URL') . '/payment/callback'),
        'mode' => env('MOYASAR_MODE', 'test'),
    ],
    
    'supported_methods' => [
        'creditcard' => [
            'enabled' => true,
            'name_ar' => 'بطاقة ائتمانية',
            'name_en' => 'Credit Card',
            'types' => ['mada', 'visa', 'mastercard'],
        ],
        'applepay' => [
            'enabled' => true,
            'name_ar' => 'Apple Pay',
            'name_en' => 'Apple Pay',
        ],
        'stcpay' => [
            'enabled' => true,
            'name_ar' => 'STC Pay',
            'name_en' => 'STC Pay',
        ],
        'cod' => [
            'enabled' => true,
            'name_ar' => 'الدفع عند الاستلام',
            'name_en' => 'Cash on Delivery',
        ],
    ],
    
    'mode' => env('PAYMENT_MODE', 'sandbox'),
    'production_url' => env('PAYMENT_PRODUCTION_URL'),
    'sandbox_url' => env('PAYMENT_SANDBOX_URL'),
    'client_id' => env('PAYMENT_CLIENT_ID'),
    'client_secret' => env('PAYMENT_CLIENT_SECRET'),

    'currency' => 'SAR',
    'timeout' => 30,
    'verify_ssl' => env('APP_ENV') === 'production',
];
