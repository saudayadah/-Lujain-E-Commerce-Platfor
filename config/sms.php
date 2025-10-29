<?php

return [
    'enabled' => env('SMS_ENABLED', false),
    
    'default_provider' => env('SMS_PROVIDER', 'unifonic'),
    
    'providers' => [
        'unifonic' => [
            'app_sid' => env('UNIFONIC_APP_SID'),
            'sender_id' => env('UNIFONIC_SENDER_ID', 'Lujain'),
        ],
        
        'msegat' => [
            'username' => env('MSEGAT_USERNAME'),
            'api_key' => env('MSEGAT_API_KEY'),
            'sender_id' => env('MSEGAT_SENDER_ID', 'Lujain'),
        ],
        
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from_number' => env('TWILIO_FROM_NUMBER'),
        ],
        
        '4jawaly' => [
            'username' => env('JAWALY_USERNAME'),
            'password' => env('JAWALY_PASSWORD'),
            'sender_id' => env('JAWALY_SENDER_ID', 'Lujain'),
        ],
    ],
    
    'otp' => [
        'length' => 4,
        'expires_in' => 5, // minutes
        'max_attempts' => 3,
        'resend_delay' => 60, // seconds
    ],
];

