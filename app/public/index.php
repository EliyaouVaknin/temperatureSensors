<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $dotenv = Dotenv::createImmutable(dirname($envPath));
    $dotenv->load();
}

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

// TEMP TEST ROUTE
$app->get('/_alive', function ($req, $res) {
    $res->getBody()->write('alive');
    return $res;
});

require __DIR__ . '/../src/routes.php';

$app->run();
