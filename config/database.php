<?php

// Chargez le fichier .env à l'aide de phpdotenv
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Maintenant vous pouvez accéder à vos variables d'environnement
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$charset = getenv('DB_CHARSET');

// Charger les options PDO depuis l'environnement
$optionsStr = getenv('DB_OPTIONS'); // La chaîne récupérée depuis .env
$options = [];
foreach (explode(',', $optionsStr) as $option) {
    list($key, $value) = explode('=>', $option);
    $options[trim($key)] = trim($value, '"');
}

// Utilisation de ces variables pour la connexion à la base de données
return [
    'host' => $host,
    'dbname' => $dbname,
    'username' => $username,
    'password' => $password,
    'charset' => $charset,
    'options' => $options
];
