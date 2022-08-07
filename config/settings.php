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
        'front' => 30,
        'back' => 30
    ],

    'search_keyword' => 'pojam',
    'author_path' => 'autor',
    'publisher_path' => 'nakladnik',

    'images_domain' => 'https://images.antikvarijatbibl.lin73.host25.com/',

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

    /**
     * Treba prebaciti u administraciju
     * + treba smisliti kako implementirati drugi jezik.
     */
    'apartment_types' => [
        0 => [
            'title' => 'Apartman',
            'id' => 1,
            'default' => 1
        ],
        1 => [
            'title' => 'Kuća',
            'id' => 2,
            'default' => 0
        ],
        2 => [
            'title' => 'Soba',
            'id' => 3,
            'default' => 0
        ]
    ],
    'apartment_targets' => [
        0 => [
            'title' => 'Najam',
            'id' => 1,
            'default' => 1
        ],
        1 => [
            'title' => 'Prodaja',
            'id' => 2,
            'default' => 0
        ]
    ],
    'apartment_price_by' => [
        1 => [
            'title' => 'Dan',
            'default' => 1
        ],
        2 => [
            'title' => 'Tjedan',
            'default' => 0
        ],
        3 => [
            'title' => 'Mjesec',
            'default' => 0
        ]
    ],

    'apartment_details' => [
        1 => [
            'title' => 'Parking',
            'icon' => 'carpark',
            'code' => null,
            'status' => 0
        ],
        2 => [
            'title' => 'Bazen',
            'icon' => 'pool',
            'code' => null,
            'status' => 0
        ],
        3 => [
            'title' => 'Klima',
            'icon' => 'ac',
            'code' => null,
            'status' => 0
        ],
        4 => [
            'title' => 'Kuhinja',
            'icon' => 'kitchen',
            'code' => null,
            'status' => 0
        ],
        5 => [
            'title' => 'Igralište',
            'icon' => 'pool',
            'code' => null,
            'status' => 0
        ],
        6 => [
            'title' => 'Roštilj',
            'icon' => 'ac',
            'code' => null,
            'status' => 0
        ],
        7 => [
            'title' => 'Garaža',
            'icon' => 'kitchen',
            'code' => null,
            'status' => 0
        ],
        8 => [
            'title' => 'Alarm',
            'icon' => 'kitchen',
            'code' => null,
            'status' => 0
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
            'bank' => \App\Models\Front\Checkout\Payment\Bank::class,
            'pickup' => \App\Models\Front\Checkout\Payment\Pickup::class
        ]
    ],

    'sitemap' => [
        0 => 'pages',
        1 => 'categories',
        2 => 'products',
        3 => 'authors',
        4 => 'publishers'
    ]

];
