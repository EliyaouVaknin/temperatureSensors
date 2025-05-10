<?php

use Slim\App;
use App\SensorController;

/** @var App $app */
$app->get('/ping', fn($req, $res) => $res->getBody()->write('pong'));

$app->post('/sensor-data', [SensorController::class, 'receiveData']);
$app->get('/reports/hourly', [SensorController::class, 'getHourlyReport']);
$app->get('/reports/malfunctioning', [SensorController::class, 'getMalfunctioningSensors']);
