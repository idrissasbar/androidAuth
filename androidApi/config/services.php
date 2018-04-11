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
    'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID','183071394163-vdr26uhga84sscsj7itk4cu97m1o3bhm.apps.googleusercontent.com'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET','GEEkCtlKZmC239mZlCYCSmRT'),
    'redirect' => env('GOOGLE_CALLBACk'),

    ],
    'facebook' => [
    'client_id' => env('FACEBOOK_CLIENT_ID','256268084880625'),
    'client_secret' => env('FACEBOOK_CLIENT_SECRET','e01e981b615906f91769db728d97eda4'),
    'redirect' => env('FACEBOOK_CALLBACk'),
    ],




];

