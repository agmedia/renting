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
    'admin_input_currency' => 'HRK',
    'default_admin_id' => 3,
    'amenities_list_count' => 6,

    'images_domain' => '#',
    'image_size_ratio' => '1440x960',
    'thumb_size_ratio' => '800x534',
    'default_apartment_image' => 'media/default_img.jpg',

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

    'deposit_scopes' => [
        1 => [
            'title' => [
                'en' => 'Deposit',
                'hr' => 'Polog',
            ],
        ],
        2 => [
            'title' => [
                'en' => 'Additional person',
                'hr' => 'Dodatna osoba',
            ],
        ],
        3 => [
            'title' => [
                'en' => 'Additional night',
                'hr' => 'Dodatno nočenje',
            ],
        ],
        4 => [
            'title' => [
                'en' => 'Check Out',
                'hr' => 'Check Out',
            ],
        ],
        5 => [
            'title' => [
                'en' => 'Check In',
                'hr' => 'Check In',
            ],
        ],
        6 => [
            'title' => [
                'en' => 'Other',
                'hr' => 'Ostalo',
            ],
        ],
    ],

    'default_deposit_order_id' => 15,

    'apartment_select_status' => ['active', 'inactive'/*, 'with_action', 'without_action'*/],
    'apartment_select_sort' => ['new', 'old', 'price_up', 'price_down'/*, 'az', 'za'*/],

    'calendar_colors' => ['3c90df', '2177C7', 'DF8B3C' , '3CDFDC'],
    'calendar_add_events' => [
        1 => [
            'title' => [
                'en' => 'Cleaning',
                'hr' => 'Čišćenje',
            ],
        ],
        2 => [
            'title' => [
                'en' => 'Landscape maintenance',
                'hr' => 'Uređenje okučnice',
            ],
        ],
        3 => [
            'title' => [
                'en' => 'Pool maintenance',
                'hr' => 'Održavanje bazena',
            ],
        ],
    ],

    'order' => [
        'made_text' => 'Narudžba napravljena.',
        'status' => [
            'new' => 1,
            'unfinished' => 8,
            'declined' => 7,
            'paid' => 3,
            'pending' => 2
        ]
    ],

    'payment' => [
        'default' => 'corvus',
        'providers' => [
            //'wspay' => \App\Models\Front\Checkout\Payment\Wspay::class,
            //'payway' => \App\Models\Front\Checkout\Payment\Payway::class,
            'corvus' => \App\Models\Front\Checkout\Payment\Corvus::class,
            //'cod' => \App\Models\Front\Checkout\Payment\Cod::class,
            'bank' => \App\Models\Front\Checkout\Payment\Bank::class,
            //'pickup' => \App\Models\Front\Checkout\Payment\Pickup::class
        ]
    ],

    /**
     * Treba prebaciti u administraciju
     * + treba smisliti kako implementirati drugi jezik.
     */
    'option_references' => [
        1 => [
            'title' => [
                'en' => 'Additional Person',
                'hr' => 'Dodatna Osoba',
            ],
            'id' => 1,
            'reference' => 'person'
        ],
        /*2 => [
            'title' => [
                'en' => 'Additional Adult',
                'hr' => 'Dodatna Odrasla Osoba',
            ],
            'id' => 2,
            'reference' => 'adult'
        ],
        3 => [
            'title' => [
                'en' => 'Additional Child',
                'hr' => 'Dodatno Dijete',
            ],
            'id' => 3,
            'reference' => 'child'
        ],*/
        4 => [
            'title' => [
                'en' => 'Transport',
                'hr' => 'Transport',
            ],
            'id' => 4,
            'reference' => 'transport'
        ],
        5 => [
            'title' => [
                'en' => 'Comfort & Luxury',
                'hr' => 'Konfort i Luksuz',
            ],
            'id' => 5,
            'reference' => 'comfort'
        ],
        6 => [
            'title' => [
                'en' => 'Cleaning',
                'hr' => 'Čišćenje',
            ],
            'id' => 6,
            'reference' => 'service'
        ],
        /*7 => [
            'title' => [
                'en' => 'Service',
                'hr' => 'Uslužne Djelatnosti',
            ],
            'id' => 7,
            'reference' => 'service'
        ],*/
        8 => [
            'title' => [
                'en' => 'Other',
                'hr' => 'Ostalo',
            ],
            'id' => 8,
            'reference' => 'other'
        ]
    ],
    //
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
    //
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
    //
    'apartment_price_by' => [
        1 => [
            'title' => [
                'en' => 'day',
                'hr' => 'dan',
            ],
            'default' => 1
        ],
        2 => [
            'title' => [
                'en' => 'week',
                'hr' => 'tjedan',
            ],
            'default' => 0
        ],
        3 => [
            'title' => [
                'en' => 'month',
                'hr' => 'mjesec',
            ],
            'default' => 0
        ]
    ],
    //
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
            'icon' => 'free_parking_on_premises.svg',
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

        38 => [
            'id' => 38,
            'title' => [
                'en' => 'City skyline view',
                'hr' => 'Panoramski pogled',
            ],
            'icon' => 'city_skyline_view.svg',
            'group' => 'Scenic views',
            'group_title' => [
                'en' => 'Scenic views',
                'hr' => 'Slikoviti pogled',
            ],
            'featured' => 0,
            'status' => 0
        ],
        39 => [
            'id' => 39,
            'title' => [
                'en' => 'Cleaning products',
                'hr' => 'Sredstva za čišćenje',
            ],
            'icon' => 'cleaning_products.svg',
            'group' => 'Bathroom',
            'group_title' => [
                'en' => 'Bathroom',
                'hr' => 'Kupaonica',
            ],
            'featured' => 0,
            'status' => 0
        ],
        40 => [
            'id' => 40,
            'title' => [
                'en' => 'Bidet',
                'hr' => 'Bidet',
            ],
            'icon' => 'bidet.svg',
            'group' => 'Bathroom',
            'group_title' => [
                'en' => 'Bathroom',
                'hr' => 'Kupaonica',
            ],
            'featured' => 0,
            'status' => 0
        ],
        41 => [
            'id' => 41,
            'title' => [
                'en' => 'Outdoor shower',
                'hr' => 'Vanjski tuš',
            ],
            'icon' => 'outdoor_shower.svg',
            'group' => 'Bathroom',
            'group_title' => [
                'en' => 'Bathroom',
                'hr' => 'Kupaonica',
            ],
            'featured' => 0,
            'status' => 0
        ],
        42 => [
            'id' => 42,
            'title' => [
                'en' => 'Room-darkening shades',
                'hr' => 'Sjenila za zamračivanje prostora',
            ],
            'icon' => 'room_darkening_shades.svg',
            'group' => 'Bedroom and laundry',
            'group_title' => [
                'en' => 'Bedroom and laundry',
                'hr' => 'Spavaća soba i praonica rublja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        43 => [
            'id' => 43,
            'title' => [
                'en' => 'Clothing storage: closet and wardrobe',
                'hr' => 'Spremište za odjeću: ormar',
            ],
            'icon' => 'clothing_storage.svg',
            'group' => 'Bedroom and laundry',
            'group_title' => [
                'en' => 'Bedroom and laundry',
                'hr' => 'Spavaća soba i praonica rublja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        44 => [
            'id' => 44,
            'title' => [
                'en' => 'Ethernet connection',
                'hr' => 'Ethernet veza',
            ],
            'icon' => 'ethernet_connection.svg',
            'group' => 'Entertainment',
            'group_title' => [
                'en' => 'Entertainment',
                'hr' => 'Zabava',
            ],
            'featured' => 0,
            'status' => 0
        ],
        45 => [
            'id' => 45,
            'title' => [
                'en' => '50" HDTV with Netflix, premium cable, standard cable',
                'hr' => '50" HDTV s Netflixom, premium kabel, standardni kabel',
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

        46 => [
            'id' => 469,
            'title' => [
                'en' => 'Dedicated workspace',
                'hr' => 'Namjenski radni prostor',
            ],
            'icon' => 'dedicated_workspace.svg',
            'group' => 'Internet and office',
            'group_title' => [
                'en' => 'Internet and office',
                'hr' => 'Wifi',
            ],
            'featured' => 0,
            'status' => 0
        ],
        47 => [
            'id' => 47,
            'title' => [
                'en' => 'Mini fridge',
                'hr' => 'Mini hladnjak',
            ],
            'icon' => 'mini_fridge.svg',
            'group' => 'Kitchen and dining',
            'group_title' => [
                'en' => 'Kitchen and dining',
                'hr' => 'Kuhinja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        48 => [
            'id' => 48,
            'title' => [
                'en' => 'Freezer',
                'hr' => 'Zamrzivač',
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
        49 => [
            'id' => 49,
            'title' => [
                'en' => 'Stainless steel oven',
                'hr' => 'Pećnica od nehrđajućeg čelika',
            ],
            'icon' => 'stainless_steel_oven.svg',
            'group' => 'Kitchen and dining',
            'group_title' => [
                'en' => 'Kitchen and dining',
                'hr' => 'Kuhinja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        50 => [
            'id' => 50,
            'title' => [
                'en' => 'Hot water kettle',
                'hr' => 'Kuhalo za toplu vodu',
            ],
            'icon' => 'hot_water_kettle.svg',
            'group' => 'Kitchen and dining',
            'group_title' => [
                'en' => 'Kitchen and dining',
                'hr' => 'Kuhinja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        51 => [
            'id' => 51,
            'title' => [
                'en' => 'Wine glasses',
                'hr' => 'Čaše za vino',
            ],
            'icon' => 'wine_glasses.svg',
            'group' => 'Kitchen and dining',
            'group_title' => [
                'en' => 'Kitchen and dining',
                'hr' => 'Kuhinja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        52 => [
            'id' => 52,
            'title' => [
                'en' => 'Baking sheet',
                'hr' => 'Folija za pečenje',
            ],
            'icon' => 'baking_sheet.svg',
            'group' => 'Kitchen and dining',
            'group_title' => [
                'en' => 'Kitchen and dining',
                'hr' => 'Kuhinja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        53 => [
            'id' => 53,
            'title' => [
                'en' => 'Barbecue utensils',
                'hr' => 'Roštilj i pribor',
            ],
            'description' => [
                'en' => 'Grill, charcoal, bamboo skewers/iron skewers, etc.',
                'hr' => 'Roštilj, drveni ugljen, bambusovi ražnjići/željezni ražnjići itd.',
            ],
            'icon' => 'barbecue_utensils.svg',
            'group' => 'Kitchen and dining',
            'group_title' => [
                'en' => 'Kitchen and dining',
                'hr' => 'Kuhinja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        54 => [
            'id' => 54,
            'title' => [
                'en' => 'Dining table',
                'hr' => 'Blagovaonski stol',
            ],
            'icon' => 'dining_table.svg',
            'group' => 'Kitchen and dining',
            'group_title' => [
                'en' => 'Kitchen and dining',
                'hr' => 'Kuhinja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        55 => [
            'id' => 55,
            'title' => [
                'en' => 'Single level home',
                'hr' => 'Kuća na jednom katu',
            ],
            'description' => [
                'en' => 'No stairs in home',
                'hr' => 'Nema stepenica u kući',
            ],
            'icon' => 'single_level_home.svg',
            'group' => 'Parking and facilities',
            'group_title' => [
                'en' => 'Parking and facilities',
                'hr' => 'Parking i dodatni sadržaji',
            ],
            'featured' => 0,
            'status' => 0
        ],
        56 => [
            'id' => 56,
            'title' => [
                'en' => 'Private patio or balcony',
                'hr' => 'Kuća na jednom katu',
            ],
            'icon' => 'private_patio_or_balcony.svg',
            'group' => 'Outdoor',
            'group_title' => [
                'en' => 'Outdoor',
                'hr' => 'Vanjski sadržaji',
            ],
            'featured' => 0,
            'status' => 0
        ],
        57 => [
            'id' => 57,
            'title' => [
                'en' => 'Outdoor furniture',
                'hr' => 'Vanjski namještaj',
            ],
            'icon' => 'outdoor_furniture.svg',
            'group' => 'Outdoor',
            'group_title' => [
                'en' => 'Outdoor',
                'hr' => 'Vanjski sadržaji',
            ],
            'featured' => 0,
            'status' => 0
        ],
        58 => [
            'id' => 58,
            'title' => [
                'en' => 'Outdoor dining area',
                'hr' => 'Vanjska blagovaonica',
            ],
            'icon' => 'outdoor_furniture.svg',
            'group' => 'Outdoor',
            'group_title' => [
                'en' => 'Outdoor',
                'hr' => 'Vanjski sadržaji',
            ],
            'featured' => 0,
            'status' => 0
        ],
        59 => [
            'id' => 59,
            'title' => [
                'en' => 'BBQ grill',
                'hr' => 'Vanjski roštilj',
            ],
            'icon' => 'bbq_grill.svg',
            'group' => 'Outdoor',
            'group_title' => [
                'en' => 'Outdoor',
                'hr' => 'Vanjski sadržaji',
            ],
            'featured' => 0,
            'status' => 0
        ],
        60 => [
            'id' => 60,
            'title' => [
                'en' => 'Dryer',
                'hr' => 'Sušilica rublja',
            ],
            'icon' => 'dryer.svg',
            'group' => 'Bedroom and laundry',
            'group_title' => [
                'en' => 'Bedroom and laundry',
                'hr' => 'Spavaća soba i praonica rublja',
            ],
            'featured' => 0,
            'status' => 0
        ],
        61 => [
            'id' => 61,
            'title' => [
                'en' => 'Bathtub',
                'hr' => 'Kada',
            ],
            'icon' => 'bathtub.svg',
            'group' => 'Bathroom',
            'group_title' => [
                'en' => 'Bathroom',
                'hr' => 'Kupaonica',
            ],
            'featured' => 0,
            'status' => 0
        ],

    ]




];
