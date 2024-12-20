<?php

require_once __DIR__ . '/vendor/autoload.php';

// Chargement du fichier .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Récupération des variables d'environnement
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$charset = getenv('DB_CHARSET');

// Gestion des options PDO
$optionsStr = getenv('DB_OPTIONS');
$options = [];

if ($optionsStr) {
    try {
        foreach (explode(',', $optionsStr) as $option) {
            $pair = explode('=>', $option);
            if (count($pair) === 2) {
                $key = constant(trim($pair[0])); // Convertit "PDO::..." en constante PHP
                $value = trim($pair[1], '"');
                $options[$key] = is_numeric($value) ? (int) $value : $value;
            } else {
                throw new Exception("Option PDO mal formatée : $option");
            }
        }
    } catch (Exception $e) {
        error_log("Erreur dans DB_OPTIONS : " . $e->getMessage());
        die("Erreur de configuration des options PDO.");
    }
} else {
    error_log("DB_OPTIONS est vide ou manquant.");
    die("Erreur : DB_OPTIONS non configuré dans le fichier .env.");
}

// Retour des paramètres (ou utilisation directe pour un test de connexion)
return [
    'host' => $host,
    'dbname' => $dbname,
    'username' => $username,
    'password' => $password,
    'charset' => $charset,
    'options' => $options,
];
