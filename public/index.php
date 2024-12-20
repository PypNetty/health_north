<?php

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict',
]);
session_start();

define('ROOT_PATH', dirname(__DIR__));
define('VIEW_PATH', __DIR__ . '/../src/views');

$appConfig = require ROOT_PATH . '/config/app.php';
$dbConfig = require ROOT_PATH . '/config/database.php';

if ($appConfig['env'] === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

try {
    $pdo = new PDO(
        $dbConfig['dsn'],
        $dbConfig['username'],
        $dbConfig['password'],
        $dbConfig['options']
    );

    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    if (in_array($requestUri, $appConfig['auth_routes']) && !isset($_SESSION['user_id'])) {
        $_SESSION['error'] = "Veuillez vous connecter pour accéder à cette page.";
        header('Location: ' . $appConfig['url'] . '/login');
        exit();
    }

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

        case '/appointment':
            require $appConfig['paths']['views'] . '/patient/appointment.php';
            break;

        case '/medical/schedule':
            require $appConfig['paths']['views'] . '/medical/schedule.php';
            break;

        case '/auth/login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                require $appConfig['paths']['controllers'] . '/AuthController.php';
                $controller = new AuthController($pdo);
                $controller->login();
            }
            break;

        case '/auth/register':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                require $appConfig['paths']['controllers'] . '/AuthController.php';
                $controller = new AuthController($pdo);
                $controller->register();
            }
            break;

        case '/auth/logout':
            session_destroy();
            header('Location: ' . $appConfig['url'] . '/login');
            exit();
            break;

        case '/dashboard':
            if (!isset($_SESSION['user_id'])) {
                $_SESSION['error'] = "Veuillez vous connecter pour accéder à cette page.";
                header('Location: /login');
                exit;
            }
            require $appConfig['paths']['views'] . '/patient/dashboard.php';
            break;

        default:
            header("HTTP/1.0 404 Not Found");
            require $appConfig['paths']['views'] . '/errors/404.php';
            break;
    }
} catch (PDOException $e) {
    error_log(sprintf(
        "[%s] Erreur BD : %s",
        date('Y-m-d H:i:s'),
        $e->getMessage()
    ));

    $_SESSION['error'] = "Une erreur est survenue avec la base de données.";
    require $appConfig['paths']['views'] . '/errors/500.php';
} catch (Exception $e) {
    error_log(sprintf(
        "[%s] Erreur : %s",
        date('Y-m-d H:i:s'),
        $e->getMessage()
    ));

    $_SESSION['error'] = "Une erreur inattendue s'est produite.";
    require $appConfig['paths']['views'] . '/errors/500.php';
}