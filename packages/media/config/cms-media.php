<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Collections
    |--------------------------------------------------------------------------
    |
    | Media collections registered by HasCmsMedia on any model that uses it.
    | 'single' => true keeps only the latest file (e.g. a featured image).
    | 'accepts' filters allowed mime types — exact matches only, no wildcards
    | (spatie/laravel-medialibrary compares them with in_array).
    |
    */
    'collections' => [
        'featured_image' => [
            'single' => true,
            'accepts' => ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'],
        ],
        'gallery' => [
            'single' => false,
            'accepts' => ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Conversions
    |--------------------------------------------------------------------------
    |
    | width/height applied to every collection via Fit::Crop, non-queued.
    |
    */
    'conversions' => [
        'thumb' => ['width' => 300, 'height' => 300],
    ],
];
