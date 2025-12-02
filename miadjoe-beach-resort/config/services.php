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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'semoa' => [
        'endpoint' => env('SEMOA_BASE_URL', 'https://api.semoa-payments.ovh/prod'),
        'username' => env('SEMOA_USERNAME'),
        'password' => env('SEMOA_PASSWORD'),
        'client_id' => env('SEMOA_CLIENT_ID'),
        'client_secret' => env('SEMOA_CLIENT_SECRET'),
        'apikey' => env('SEMOA_APIKEY'),
    ],

];
