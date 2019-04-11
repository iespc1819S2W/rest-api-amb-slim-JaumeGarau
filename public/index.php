<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = '/var/docker-compose-lamp/www' . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require '/var/docker-compose-lamp/www' . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require '/var/docker-compose-lamp/www' . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require '/var/docker-compose-lamp/www' . '/../src/dependencies.php';

// Register middleware
require '/var/docker-compose-lamp/www' . '/../src/middleware.php';

// Register routes
require '/var/docker-compose-lamp/www' . '/../src/routes.php';

// Carregam el nostre codi
require '/var/docker-compose-lamp/www' . '/../app/app_loader.php';

// Run app
$app->run();
