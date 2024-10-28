<?php

return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'),
    'sandbox' => [
        'client_id'         => env('PAYPAL_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_CLIENT_SECRET', ''),
        'app_id'            => 'APP-80W284485P519543T',
    ],
    'live' => [
        'client_id'         => env('PAYPAL_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_CLIENT_SECRET', ''),
        'app_id'            => env('PAYPAL_APP_ID', ''),
    ],

    'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'),
    'currency'       => env('PAYPAL_CURRENCY', 'USD'),
    'notify_url'     => env('PAYPAL_NOTIFY_URL', ''),
    'locale'         => env('PAYPAL_LOCALE', 'es_ES'),
    'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true),
];