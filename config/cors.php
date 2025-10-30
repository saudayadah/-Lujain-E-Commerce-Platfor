<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    /*
     * 🔒 Security: في Production، يجب تحديد domains المسموح لها فقط
     * في Development، يمكن استخدام '*' للسماح لجميع origins
     * 
     * مثال للـ Production:
     * 'allowed_origins' => [
     *     'https://yourdomain.com',
     *     'https://www.yourdomain.com',
     *     'https://admin.yourdomain.com',
     * ],
     */
    'allowed_origins' => env('APP_ENV') === 'local' 
        ? ['*'] 
        : array_filter(explode(',', env('CORS_ALLOWED_ORIGINS', ''))),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];

