<?php

/**
 * Point d'entrée principal de l'application Health North
 * Toutes les requêtes passent par ce fichier qui agit comme un "front controller"
 */

// Démarrage de la session
session_start();

// Définition du chemin racine de l'application
define('ROOT_PATH', dirname(__DIR__));

// Chargement des configurations
$appConfig = require ROOT_PATH . '/config/app.php';
$dbConfig = require ROOT_PATH . '/config/database.php';

// Activation du mode debug si nécessaire
if ($appConfig['env'] === 'development') {
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
}

try {
  // Initialisation de la base de données
  $pdo = new PDO(
    sprintf(
      "mysql:host=%s;dbname=%s;charset=utf8mb4",
      $dbConfig['host'],
      $dbConfig['dbname']
    ),
    $dbConfig['username'],
    $dbConfig['password'],
    $dbConfig['options']
  );

  // Récupération de l'URL demandée
  $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

  // Vérification de l'authentification pour les routes protégées
  if (in_array($requestUri, $appConfig['auth_routes']) && !isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Veuillez vous connecter pour accéder à cette page.";
    header('Location: /login');
    exit();
  }

  // Routage des requêtes
  switch ($requestUri) {
    case '/':
      require $appConfig['paths']['views'] . '/static/home.php';
      break;

    case '/login':
      require $appConfig['paths']['views'] . '/auth/login.php';
      break;

    case '/register':
      require $appConfig['paths']['views'] . '/auth/register.php';
      break;

    case '/profile':
      require $appConfig['paths']['views'] . '/patient/profile.php';
      break;

      // Traitement des formulaires
    case '/auth/login':
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require $appConfig['paths']['controllers'] . '/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->login();
      }
      break;

    default:
      // Page 404 si l'URL n'est pas reconnue
      header("HTTP/1.0 404 Not Found");
      require $appConfig['paths']['views'] . '/errors/404.php';
      break;
  }
} catch (PDOException $e) {
  // Journalisation de l'erreur de base de données
  error_log(sprintf(
    "[%s] Erreur BD : %s",
    date('Y-m-d H:i:s'),
    $e->getMessage()
  ));

  $_SESSION['error'] = "Une erreur est survenue avec la base de données.";
  require $appConfig['paths']['views'] . '/errors/500.php';
} catch (Exception $e) {
  // Journalisation des autres erreurs
  error_log(sprintf(
    "[%s] Erreur : %s",
    date('Y-m-d H:i:s'),
    $e->getMessage()
  ));

  $_SESSION['error'] = "Une erreur inattendue s'est produite.";
  require $appConfig['paths']['views'] . '/errors/500.php';
}
