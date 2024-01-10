<?php
require '../vendor/autoload.php';

session_start();

$uri = trim($_SERVER['REQUEST_URI'], '/');

$router = new App\PatternRouter();
$router->route($uri);