<?php

ini_set('display_errors', 'Off');
try {
    require '../vendor/autoload.php';
    session_start();
    $uri = trim($_SERVER['REQUEST_URI'], '/');
    $router = new App\PatternRouter();
    $router->route($uri);
} catch (\Throwable $exception) {
    $errorMessage = $exception->getMessage();
    require __DIR__ . '/../views/exception.php';
}