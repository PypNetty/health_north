<?php

return [
    'name' => 'Health North',
    'env' => getenv('APP_ENV', 'production'),
    'debug' => getenv('APP_DEBUG', false),
    'url' => getenv('APP_URL', 'http://localhost'),

    'paths' => [
        'root' => dirname(__DIR__),
        'public' => dirname(__DIR__) . '/public',
        'views' => dirname(__DIR__) . '/src/views',
        'controllers' => dirname(__DIR__) . '/src/Controllers',
        'models' => dirname(__DIR__) . '/src/Models',
    ],

    'session' => [
        'lifetime' => 120,
        'secure' => true,
        'http_only' => true,
    ],

    'auth_routes' => [
        '/profile',
        '/appointment',
        '/medical/schedule',
    ],
];