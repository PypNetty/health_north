<?php

/**
 * Configuration principale de l'application
 * Ce fichier contient les paramètres globaux de l'application
 */

return [
    // Informations de base de l'application
    'name' => 'Health North',
    'env' => getenv('APP_ENV', 'production'),
    'debug' => getenv('APP_DEBUG', false),
    'url' => getenv('APP_URL', 'http://localhost'),

    // Configuration des chemins de l'application
    'paths' => [
        'root' => dirname(__DIR__),
        'public' => dirname(__DIR__) . '/public',
        'views' => dirname(__DIR__) . '/src/views',
        'controllers' => dirname(__DIR__) . '/src/Controllers',
        'models' => dirname(__DIR__) . '/src/Models',
    ],

    // Configuration des sessions
    'session' => [
        'lifetime' => 120, // Durée de vie en minutes
        'secure' => true,  // Cookies sécurisés en HTTPS
        'http_only' => true,
    ],

    // Routes protégées qui nécessitent une authentification
    'auth_routes' => [
        '/profile',
        '/appointment',
        '/medical/schedule',
    ],
];
