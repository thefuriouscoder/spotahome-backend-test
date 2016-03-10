<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../App/Settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../App/Dependencies.php';

// Register middleware
require __DIR__ . '/../App/Middleware.php';

// Register routes
require __DIR__ . '/../App/Routes.php';

// Run app
$app->run();
