<?php

declare(strict_types=1);

return [
    // Define how much tables a restaurant can offer
    'max_tables' => 30,

    'notify_email' => 'restaurant-email@example.com',

    // Defines how many days in advance you can make a reservation
    'max_days_reservation' => 30,

    'menu' => [
        'monday' => [
            'soup' => [
                'name' => 'Kuřecí vývar',
                'content' => '330 ml',
                'price' => '30 Kč'
            ],
            'main' => [
                'name' => 'Bramborový salát a kuřecí řízky',
                'content' => '400 g',
                'price' => '130 Kč'
            ]
        ],
        'tuesday' => [
            'soup' => [
                'name' => 'Česnečka',
                'content' => '330 ml',
                'price' => '25 Kč'
            ],
            'main' => [
                'name' => 'Svíčková na smetaně s knedlíky',
                'content' => '450 g',
                'price' => '140 Kč'
            ]
        ],
        'wednesday' => [
            'soup' => [
                'name' => 'Hrachová polévka',
                'content' => '330 ml',
                'price' => '28 Kč'
            ],
            'main' => [
                'name' => 'Vepřo knedlo zelo',
                'content' => '450 g',
                'price' => '135 Kč'
            ]
        ],
        'thursday' => [
            'soup' => [
                'name' => 'Rajská polévka',
                'content' => '330 ml',
                'price' => '27 Kč'
            ],
            'main' => [
                'name' => 'Guláš s houskovým knedlíkem',
                'content' => '450 g',
                'price' => '130 Kč'
            ]
        ],
        'friday' => [
            'soup' => [
                'name' => 'Kulajda',
                'content' => '330 ml',
                'price' => '32 Kč'
            ],
            'main' => [
                'name' => 'Smažený sýr s hranolky a tatarskou omáčkou',
                'content' => '400 g',
                'price' => '125 Kč'
            ]
        ],
        'saturday' => [
            'soup' => [
                'name' => 'Dršťková polévka',
                'content' => '330 ml',
                'price' => '35 Kč'
            ],
            'main' => [
                'name' => 'Pečená kachna s červeným zelím a bramborovým knedlíkem',
                'content' => '500 g',
                'price' => '150 Kč'
            ]
        ],
        'sunday' => [
            'soup' => [
                'name' => 'Zeleninový krém',
                'content' => '330 ml',
                'price' => '30 Kč'
            ],
            'main' => [
                'name' => 'Španělský ptáček s rýží',
                'content' => '450 g',
                'price' => '140 Kč'
            ]
        ]
    ]
];


