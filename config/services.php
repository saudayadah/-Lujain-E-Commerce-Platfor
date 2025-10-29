<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Services Configuration
    |--------------------------------------------------------------------------
    */
    
    'whatsapp' => [
        'enabled' => env('WHATSAPP_ENABLED', false),
        'provider' => env('WHATSAPP_PROVIDER', 'ultramsg'), // ultramsg, twilio, wati, whatsapp_business
        
        // Ultramsg Configuration
        'ultramsg' => [
            'instance_id' => env('ULTRAMSG_INSTANCE_ID'),
            'token' => env('ULTRAMSG_TOKEN'),
        ],
        
        // Twilio WhatsApp Configuration
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from_number' => env('TWILIO_WHATSAPP_FROM'),
        ],
        
        // WATI Configuration
        'wati' => [
            'api_key' => env('WATI_API_KEY'),
            'api_url' => env('WATI_API_URL', 'https://live-server.wati.io'),
        ],
        
        // WhatsApp Business API Configuration
        'whatsapp_business' => [
            'access_token' => env('WHATSAPP_BUSINESS_ACCESS_TOKEN'),
            'phone_number_id' => env('WHATSAPP_BUSINESS_PHONE_NUMBER_ID'),
            'api_url' => env('WHATSAPP_BUSINESS_API_URL', 'https://graph.facebook.com/v18.0'),
            'language' => env('WHATSAPP_BUSINESS_LANGUAGE', 'ar'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Meta (Facebook/Instagram) Services Configuration
    |--------------------------------------------------------------------------
    */
    
    'meta' => [
        'enabled' => env('META_PIXEL_ENABLED', false),
        'pixel_id' => env('META_PIXEL_ID'),
        'access_token' => env('META_ACCESS_TOKEN'),
        'api_version' => env('META_API_VERSION', 'v18.0'),
    ],

];

