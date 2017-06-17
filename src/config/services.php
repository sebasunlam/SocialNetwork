<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENTID'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT'),
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENTID'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT'),
    ],
    'twitter' => [
        'client_id' => env('TWITTER_CLIENTID'),
        'client_secret' => env('TWITTER_SECRET'),
        'redirect' => env('TWITTER_REDIRECT'),
    ],
    'github' => [
        'client_id' => env('GITHUB_CLIENTID'),
        'client_secret' => env('GITHUB_SECRET'),
        'redirect' => env('GITHUB_REDIRECT'),
    ]
//    'facebook' => [
//        'client_id' => '1732707486745661',
//        'client_secret' => '435ab379da3c40ad74007103ce40e340',
//        'redirect' => 'http://localhost:8000/login/facebook/callback',
//    ],
//    'google' => [
//        'client_id' => '520722018815-glm8n3ep3j9t33hm8b6nhb935bpg3tv1.apps.googleusercontent.com',
//        'client_secret' => 'yhP2FLwzcJaolviIQ0sj7CJJ',
//        'redirect' => 'http://localhost:8000/login/google/callback',
//    ]

];
