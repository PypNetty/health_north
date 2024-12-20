<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Chargement du fichier .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

return [
    'dsn' => "mysql:host=localhost;dbname=health_north;charset=utf8mb4",
    'username' => 'root',
    'password' => 'Lavoisier1',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]
];