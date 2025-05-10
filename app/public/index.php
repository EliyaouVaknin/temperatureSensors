<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Optional: error middleware
$app->addErrorMiddleware(true, true, true);

// Load routes
require __DIR__ . '/../src/routes.php';

$app->run();
