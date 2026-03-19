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

    'biometric' => [
        'token' => env('BIOMETRIC_API_TOKEN'),
        'device_ids' => array_filter(array_map('trim', explode(',', env('BIOMETRIC_DEVICE_IDS', '')))),
        'office_start_time' => env('BIOMETRIC_OFFICE_START', '09:00'),
        'late_after_minutes' => (int) env('BIOMETRIC_LATE_AFTER_MINUTES', 15),
        'short_attendance_minutes' => (int) env('BIOMETRIC_SHORT_ATTENDANCE_MINUTES', 10),
    ],

];
