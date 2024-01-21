<?php

ini_set('display_errors', 'Off');

// Start output buffering
ob_start();

try {
    require '../vendor/autoload.php';
    session_start();
    $uri = trim($_SERVER['REQUEST_URI'], '/');
    $router = new App\PatternRouter();
    $router->route($uri);

    // Flush the output buffer and send to the browser
    ob_end_flush();
} catch (\Throwable $exception) {
    ob_clean();
    require_once __DIR__ . '/../views/exception.php';
}
