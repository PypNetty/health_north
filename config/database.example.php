<?php
return [
    'dsn' => 'mysql:host=localhost;dbname=health_north;charset=utf8mb4',
    'username' => 'your_username',
    'password' => 'your_password',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
]; 