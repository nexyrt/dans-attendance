<?php

return [
    'name' => 'LaravelPWA',
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => 'PWA',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => 'black',
        'icons' => [
            '72x72' => [
                'path' => '/images/jkb.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/images/jkb.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/images/jkb.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/images/jkb.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/images/jkb.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/images/jkb.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/images/jkb.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/images/jkb.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/images/jkb.png',
            '750x1334' => '/images/jkb.png',
            '828x1792' => '/images/jkb.png',
            '1125x2436' => '/images/jkb.png',
            '1242x2208' => '/images/jkb.png',
            '1242x2688' => '/images/jkb.png',
            '1536x2048' => '/images/jkb.png',
            '1668x2224' => '/images/jkb.png',
            '1668x2388' => '/images/jkb.png',
            '2048x2732' => '/images/jkb.png',
        ],
        'custom' => []
    ]
];
