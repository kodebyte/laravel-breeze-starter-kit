<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Banner Zones Configuration
    |--------------------------------------------------------------------------
    | Define available banner locations and their capabilities.
    */
    'banner_zones' => [
        'home_hero' => [
            'name' => 'Home Page - Hero Section',
            'aspect_ratio' => '16:9',
            'recommendation' => 'Desktop: 1920x1080px | Mobile: 1080x1920px',
            'has_mobile' => true,
            'allowed_types' => ['image', 'video'], // Support Video
        ],
        'home_middle' => [
            'name' => 'Home Page - Middle Promo',
            'aspect_ratio' => '3:1',
            'recommendation' => 'Desktop: 1200x400px',
            'has_mobile' => false,
            'allowed_types' => ['image'], // Image Only
        ],
        'sidebar_promo' => [
            'name' => 'Sidebar Widget',
            'aspect_ratio' => '1:1',
            'recommendation' => 'Square: 500x500px',
            'has_mobile' => false,
            'allowed_types' => ['image'],
        ],
    ],
];