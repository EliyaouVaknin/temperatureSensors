<?php
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return function (App $app) {
    $app->addBodyParsingMiddleware();

    // Optional: Add CORS
    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
    });

    $app->addRoutingMiddleware();

    $errorMiddleware = new ErrorMiddleware(
        $app->getCallableResolver(),
        $app->getResponseFactory(),
        true, // displayErrorDetails
        false,
        false
    );
    $app->add($errorMiddleware);
};
