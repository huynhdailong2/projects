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

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'momo' => [
        'base_url_v2' => env('MOMO_BASE_URL_V2'),
        'partner_code' => env('MOMO_PARTNER_CODE'),
        'partner_name' => env('MOMO_PARTNER_NAME'),
        'public_key' => env('MOMO_PUBLIC_KEY'),
        'secret_key' => env('MOMO_SECRET_KEY'),
        'access_key' => env('MOMO_ACCESS_KEY'),
        'redirect' => env('MOMO_REDIRECT'),
        'deeplink' => env('MOMO_DEEPLINK'),
        'beautyx-protocol' => env('MOMO_BEAUTYX_PROTOCOL', 'beautyx://app'),
        'beautyx-zalo-protocol' => env('MOMO_BEAUTYX_ZALO_PROTOCOL'),
    ],

];
