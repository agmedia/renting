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

    'pagination' => [
        'front' => 12,
        'back' => 30
    ],

    'search_keyword' => 'pojam',

    'sorting_list' => [
        0 => [
            'title' => 'Najnovije',
            'value' => 'novi'
        ],
        1 => [
            'title' => 'Najmanja cijena',
            'value' => 'price_up'
        ],
        2 => [
            'title' => 'Najveća cijena',
            'value' => 'price_down'
        ],
        3 => [
            'title' => 'A - Ž',
            'value' => 'naziv_up'
        ],
        4 => [
            'title' => 'Ž - A',
            'value' => 'naziv_down'
        ],
    ],

    'order' => [
        'made_text' => 'Narudžba napravljena.',
        'status' => [
            'new' => 1,
            'unfinished' => 8,
            'declined' => 7,
            'paid' => 3,
            'send' => 4,
        ]
    ],

    'payment' => [
        'providers' => [
            'wspay' => \App\Models\Front\Checkout\Payment\Wspay::class,
            'payway' => \App\Models\Front\Checkout\Payment\Payway::class,
            'cod' => \App\Models\Front\Checkout\Payment\Cod::class,
            'bank' => \App\Models\Front\Checkout\Payment\Bank::class
        ]
    ]

];
