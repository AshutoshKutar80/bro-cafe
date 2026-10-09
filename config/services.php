<?php
return [
    'postmark' => ['token' => env('POSTMARK_TOKEN')],
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'resend' => ['key' => env('RESEND_KEY')],
    'slack' => ['notifications' => ['bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'), 'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL')]],

    // BRO CAFE SMS
    'sms' => [
        'provider' => env('SMS_PROVIDER', 'msg91'),
        'msg91_key' => env('MSG91_API_KEY'),
        '2factor_key' => env('TWOFACTOR_API_KEY'),
        'sender_id' => env('SMS_SENDER_ID', 'BROCAF'),
        'template_id' => env('SMS_TEMPLATE_ID'),
    ],
];