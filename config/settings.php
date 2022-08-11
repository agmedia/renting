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
            'title' => [
                'en' => 'Apartment',
                'hr' => 'Apartman',
            ],
            'id' => 1,
            'default' => 1
        ],
        1 => [
            'title' => [
                'en' => 'House',
                'hr' => 'Kuća za odmor',
            ],
            'id' => 2,
            'default' => 0
        ]
    ],
    'apartment_targets' => [
        0 => [
            'title' => [
                'en' => 'For Lease',
                'hr' => 'Najam',
            ],
            'id' => 1,
            'default' => 1
        ],
        1 => [
            'title' => [
                'en' => 'For Sale',
                'hr' => 'Prodaja',
            ],
            'id' => 2,
            'default' => 0
        ]
    ],
    'apartment_price_by' => [
        1 => [
            'title' => [
                'en' => 'Day',
                'hr' => 'Dan',
            ],
            'default' => 1
        ],
        2 => [
            'title' => [
                'en' => 'Week',
                'hr' => 'Tjedan',
            ],
            'default' => 0
        ],
        3 => [
            'title' => [
                'en' => 'Month',
                'hr' => 'Mjesec',
            ],
            'default' => 0
        ]
    ],

    'apartment_details' => [
        1 => [
            'id' => 1,
            'title' => [
                'en' => 'Hair dryer',
                'hr' => 'Sušilo',
            ],
            'icon' => 'hair_dryer.svg',
            'group' => 'Bathroom',
            'group_title' => [
                'en' => 'Bathroom',
                'hr' => 'Kupaonica',
            ],
            'featured' => 0,
            'status' => 0
        ],
        2 => [
            'id' => 2,
            'title' => [
                'en' => 'Shampoo',
                'hr' => 'Šampon za kosu',
            ],
            'icon' => 'shampoo.svg',
            'group' => 'Bathroom',
            'group_title' => [
                'en' => 'Bathroom',
                'hr' => 'Kupaonica',
            ],
            'featured' => 0,
            'status' => 0
        ],
        3 => [
            'id' => 3,
            'title' => [
                'en' => 'Hot water',
                'hr' => 'Topla voda',
            ],
            'icon' => 'hot_water.svg',
            'group' => 'Bathroom',
            'group_title' => [
                'en' => 'Bathroom',
                'hr' => 'Kupaonica',
            ],
            'featured' => 0,
            'status' => 0
        ],
        4 => [
            'id' => 4,
            'title' => [
                'en' => 'Shower gel',
                'hr' => 'Gel za tuširanje',
            ],
            'icon' => 'shower_gel.svg',
            'group' => 'Bathroom',
            'group_title' => [
                'en' => 'Bathroom',
                'hr' => 'Kupaonica',
            ],
            'featured' => 0,
            'status' => 0
        ],
        5 => [
            'id' => 5,
            'title' => [
                'en' => 'Washer',
                'hr' => 'Perilica rublja',
            ],
            'icon' => 'washer.svg',
            'group' => 'Bedroom and laundry',
            'group_title' => [
                'en' => 'Bedroom and laundry',
                'hr' => 'Spavaća soba i praonica rublja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        6 => [
            'id' => 6,
            'title' => [
                'en' => 'Essentials',
                'hr' => 'Osnove',
            ],
            'description' => [
                'en' => 'Towels, bed sheets, soap, and toilet paper',
                'hr' => 'Ručnici, posteljina, sapun i toaletni papir',
            ],
            'icon' => 'essentials.svg',
            'group' => 'Bedroom and laundry',
            'group_title' => [
                'en' => 'Bedroom and laundry',
                'hr' => 'Spavaća soba i praonica rublja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        7 => [
            'id' => 7,
            'title' => [
                'en' => 'Hangers',
                'hr' => 'Vješalice',
            ],
            'icon' => 'hangers.svg',
            'group' => 'Bedroom and laundry',
            'group_title' => [
                'en' => 'Bedroom and laundry',
                'hr' => 'Spavaća soba i praonica rublja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        8 => [
            'id' => 8,
            'title' => [
                'en' => 'Bed linens',
                'hr' => 'Posteljina',
            ],
            'icon' => 'bad_linens.svg',
            'group' => 'Bedroom and laundry',
            'group_title' => [
                'en' => 'Bedroom and laundry',
                'hr' => 'Spavaća soba i praonica rublja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        9 => [
            'id' => 9,
            'title' => [
                'en' => 'Extra pillows and blankets',
                'hr' => 'Dodatni jastuci i deke',
            ],
            'icon' => 'extra_pillows_and_blankets.svg',
            'group' => 'Bedroom and laundry',
            'group_title' => [
                'en' => 'Bedroom and laundry',
                'hr' => 'Spavaća soba i praonica rublja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        10 => [
            'id' => 10,
            'title' => [
                'en' => 'Iron',
                'hr' => 'Pegla',
            ],
            'icon' => 'iron.svg',
            'group' => 'Bedroom and laundry',
            'group_title' => [
                'en' => 'Bedroom and laundry',
                'hr' => 'Spavaća soba i praonica rublja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        11 => [
            'id' => 11,
            'title' => [
                'en' => 'TV',
                'hr' => 'TV',
            ],
            'icon' => 'tv.svg',
            'group' => 'Entertainment',
            'group_title' => [
                'en' => 'Entertainment',
                'hr' => 'Zabava',
            ],
            'featured' => 0,
            'status' => 0
        ],
        12 => [
            'id' => 12,
            'title' => [
                'en' => 'Pack ’n play/Travel crib - available upon request',
                'hr' => 'Prijenosni dječji krevetić',
            ],
            'icon' => 'crib.svg',
            'group' => 'Family',
            'group_title' => [
                'en' => 'Family',
                'hr' => 'Obitelj',
            ],
            'featured' => 0,
            'status' => 0
        ],
        13 => [
            'id' => 13,
            'title' => [
                'en' => 'Air conditioning',
                'hr' => 'Klima',
            ],
            'icon' => 'air_conditioning.svg',
            'group' => 'Heating and cooling',
            'group_title' => [
                'en' => 'Heating and cooling',
                'hr' => 'Grijanje i hlađenje',
            ],
            'featured' => 0,
            'status' => 0
        ],
        14 => [
            'id' => 14,
            'title' => [
                'en' => 'Heating',
                'hr' => 'Grijanje',
            ],
            'icon' => 'heating.svg',
            'group' => 'Heating and cooling',
            'group_title' => [
                'en' => 'Heating and cooling',
                'hr' => 'Grijanje i hlađenje',
            ],
            'featured' => 0,
            'status' => 0
        ],
        15 => [
            'id' => 15,
            'title' => [
                'en' => 'Smoke alarm',
                'hr' => 'Alarm za dim',
            ],
            'icon' => 'smoke_alarm.svg',
            'group' => 'Home safety',
            'group_title' => [
                'en' => 'Home safety',
                'hr' => 'Sigurnost',
            ],
            'featured' => 0,
            'status' => 0
        ],
        16 => [
            'id' => 16,
            'title' => [
                'en' => 'Carbon monoxide alarm',
                'hr' => 'Alarm za ugljični monoksid',
            ],
            'icon' => 'carbon_monoxide_alarm.svg',
            'group' => 'Home safety',
            'group_title' => [
                'en' => 'Home safety',
                'hr' => 'Sigurnost',
            ],
            'featured' => 0,
            'status' => 0
        ],
        17 => [
            'id' => 17,
            'title' => [
                'en' => 'Fire extinguisher',
                'hr' => 'Aparat za gašenje požara',
            ],
            'icon' => 'fire_extinguisher.svg',
            'group' => 'Home safety',
            'group_title' => [
                'en' => 'Home safety',
                'hr' => 'Sigurnost',
            ],
            'featured' => 0,
            'status' => 0
        ],
        18 => [
            'id' => 18,
            'title' => [
                'en' => 'First aid kit',
                'hr' => 'Prva pomoć',
            ],
            'icon' => 'first_aid_kit.svg',
            'group' => 'Home safety',
            'group_title' => [
                'en' => 'Home safety',
                'hr' => 'Sigurnost',
            ],
            'featured' => 0,
            'status' => 0
        ],
        19 => [
            'id' => 19,
            'title' => [
                'en' => 'Wifi',
                'hr' => 'Wifi',
            ],
            'icon' => 'wifi.svg',
            'group' => 'Internet and office',
            'group_title' => [
                'en' => 'Internet and office',
                'hr' => 'Wifi',
            ],
            'featured' => 0,
            'status' => 0
        ],
        20 => [
            'id' => 20,
            'title' => [
                'en' => 'Kitchen',
                'hr' => 'Kuhinja',
            ],
            'description' => [
                'en' => 'Space where guests can cook their own meals',
                'hr' => 'Prostor u kojem gosti mogu sami kuhati obroke',
            ],
            'icon' => 'kitchen.svg',
            'group' => 'Kitchen and dining',
            'group_title' => [
                'en' => 'Kitchen and dining',
                'hr' => 'Kuhinja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        21 => [
            'id' => 21,
            'title' => [
                'en' => 'Refrigerator',
                'hr' => 'Hladnjak',
            ],
            'icon' => 'refrigerator.svg',
            'group' => 'Kitchen and dining',
            'group_title' => [
                'en' => 'Kitchen and dining',
                'hr' => 'Kuhinja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        22 => [
            'id' => 22,
            'title' => [
                'en' => 'Microwave',
                'hr' => 'Mikrovalna pećnica',
            ],
            'icon' => 'microwave.svg',
            'group' => 'Kitchen and dining',
            'group_title' => [
                'en' => 'Kitchen and dining',
                'hr' => 'Kuhinja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        23 => [
            'id' => 23,
            'title' => [
                'en' => 'Cooking basics',
                'hr' => 'Osnove za kuhanje',
            ],
            'description' => [
                'en' => 'Pots and pans, oil, salt and pepper',
                'hr' => 'Lonci i tave, ulje, sol i papar',
            ],
            'icon' => 'cooking_basics.svg',
            'group' => 'Kitchen and dining',
            'group_title' => [
                'en' => 'Kitchen and dining',
                'hr' => 'Kuhinja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        24 => [
            'id' => 24,
            'title' => [
                'en' => 'Dishes and silverware',
                'hr' => 'Posuđe i srebrnina',
            ],
            'description' => [
                'en' => 'Bowls, chopsticks, plates, cups, etc.',
                'hr' => 'Zdjele, štapići, tanjuri, šalice itd.',
            ],
            'icon' => 'dishes_and_silverware.svg',
            'group' => 'Kitchen and dining',
            'group_title' => [
                'en' => 'Kitchen and dining',
                'hr' => 'Kuhinja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        25 => [
            'id' => 25,
            'title' => [
                'en' => 'Dishwasher',
                'hr' => 'Perilica suđa',
            ],
            'icon' => 'dishwasher.svg',
            'group' => 'Kitchen and dining',
            'group_title' => [
                'en' => 'Kitchen and dining',
                'hr' => 'Kuhinja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        26 => [
            'id' => 26,
            'title' => [
                'en' => 'Stove',
                'hr' => 'Štednjak',
            ],
            'icon' => 'stove.svg',
            'group' => 'Kitchen and dining',
            'group_title' => [
                'en' => 'Kitchen and dining',
                'hr' => 'Kuhinja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        27 => [
            'id' => 27,
            'title' => [
                'en' => 'Private entrance',
                'hr' => 'Privatni ulaz',
            ],
            'description' => [
                'en' => 'Separate street or building entrance',
                'hr' => 'Poseban ulaz s ulice ili zgrade',
            ],
            'icon' => 'private_entrance.svg',
            'group' => 'Location features',
            'group_title' => [
                'en' => 'Location features',
                'hr' => 'Značajke lokacije',
            ],
            'featured' => 0,
            'status' => 0
        ],
        28 => [
            'id' => 28,
            'title' => [
                'en' => 'Free parking on premises',
                'hr' => 'Besplatan parking u sklopu objekta',
            ],
            'icon' => 'free_parking_on_premises.svg',
            'group' => 'Parking and facilities',
            'group_title' => [
                'en' => 'Parking and facilities',
                'hr' => 'Parking i dodatni sadržaji',
            ],
            'featured' => 0,
            'status' => 0
        ],
        29 => [
            'id' => 29,
            'title' => [
                'en' => 'Free street parking',
                'hr' => 'Besplatan parking na ulici',
            ],
            'icon' => 'free_street_parking.svg',
            'group' => 'Parking and facilities',
            'group_title' => [
                'en' => 'Parking and facilities',
                'hr' => 'Parking i dodatni sadržaji',
            ],
            'featured' => 0,
            'status' => 0
        ],
        30 => [
            'id' => 30,
            'title' => [
                'en' => 'Pool',
                'hr' => 'Bazen',
            ],
            'icon' => 'pool.svg',
            'group' => 'Parking and facilities',
            'group_title' => [
                'en' => 'Parking and facilities',
                'hr' => 'Parking i dodatni sadržaji',
            ],
            'featured' => 0,
            'status' => 0
        ],
        31 => [
            'id' => 31,
            'title' => [
                'en' => 'Hot tub',
                'hr' => 'Vruća kupelj',
            ],
            'icon' => 'hot_tub.svg',
            'group' => 'Parking and facilities',
            'group_title' => [
                'en' => 'Parking and facilities',
                'hr' => 'Parking i dodatni sadržaji',
            ],
            'featured' => 0,
            'status' => 0
        ],
        32 => [
            'id' => 32,
            'title' => [
                'en' => 'EV charger',
                'hr' => 'Punjač za električna vozila',
            ],
            'description' => [
                'en' => 'Guests can charge their electric vehicles on the property.',
                'hr' => 'Gosti mogu puniti svoja električna vozila na imanju.',
            ],
            'icon' => 'ev_charger.svg',
            'group' => 'Parking and facilities',
            'group_title' => [
                'en' => 'Parking and facilities',
                'hr' => 'Parking i dodatni sadržaji',
            ],
            'featured' => 0,
            'status' => 0
        ],
        33 => [
            'id' => 33,
            'title' => [
                'en' => 'Luggage dropoff allowed',
                'hr' => 'Dopušten predaja prtljage',
            ],
            'description' => [
                'en' => 'For guests convenience when they have early arrival or late departure',
                'hr' => 'Za udobnost gostiju kada imaju rani dolazak ili kasni odlazak',
            ],
            'icon' => 'luggage_dropoff_allowed.svg',
            'group' => 'Services',
            'group_title' => [
                'en' => 'Services',
                'hr' => 'Usluge',
            ],
            'featured' => 0,
            'status' => 0
        ],
        34 => [
            'id' => 34,
            'title' => [
                'en' => 'Self check-in',
                'hr' => 'Samostalna prijava',
            ],
            'icon' => 'self_check_in.svg',
            'group' => 'Services',
            'group_title' => [
                'en' => 'Services',
                'hr' => 'Usluge',
            ],
            'featured' => 0,
            'status' => 0
        ],
        35 => [
            'id' => 35,
            'title' => [
                'en' => 'Keypad',
                'hr' => 'Tipkovnica za ulaz',
            ],
            'description' => [
                'en' => 'Check yourself into the home with a door code',
                'hr' => 'Prijavite se u dom pomoću koda na vratima',
            ],
            'icon' => 'keypad.svg',
            'group' => 'Services',
            'group_title' => [
                'en' => 'Services',
                'hr' => 'Usluge',
            ],
            'featured' => 0,
            'status' => 0
        ],
        36 => [
            'id' => 36,
            'title' => [
                'en' => 'Long term stays allowed',
                'hr' => 'Dugotrajni boravci dozvoljeni',
            ],
            'description' => [
                'en' => 'Allow stay for 28 days or more',
                'hr' => 'Dozvoljen boravak 28 dana ili više',
            ],
            'icon' => 'long_term_stays_allowed.svg',
            'group' => 'Services',
            'group_title' => [
                'en' => 'Services',
                'hr' => 'Usluge',
            ],
            'featured' => 0,
            'status' => 0
        ],
        37 => [
            'id' => 37,
            'title' => [
                'en' => 'Security cameras on property',
                'hr' => 'Sigurnosna kamera',
            ],
            'icon' => 'security_cameras_on_property.svg',
            'group' => 'Not included',
            'group_title' => [
                'en' => 'Not included',
                'hr' => 'Nije uključeno',
            ],
            'featured' => 0,
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
