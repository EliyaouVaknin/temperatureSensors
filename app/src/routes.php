<?php

use Slim\App;
use App\SensorController;

return function (App $app) {
    // ✅ Health check
    /** @var App $app */
    $app->get('/ping', function ($req, $res) {
        $res->getBody()->write('pong');
        return $res;
    });

    // ✅ POST sensor data
    $app->post('/sensor-data', [SensorController::class, 'receiveData']);

    // ✅ GET hourly temperature averages (last 7 days)
    $app->get('/reports/hourly', [SensorController::class, 'getHourlyReport']);

    // ✅ GET hourly temperature averages by face (optional filter)
    $app->get('/reports/hourly/{face}', [SensorController::class, 'getHourlyReportByFace']);

    // ✅ GET malfunctioning sensors (all faces)
    $app->get('/reports/malfunctioning', [SensorController::class, 'getMalfunctioningSensors']);

    // ✅ GET malfunctioning sensors by face (optional filter)
    $app->get('/reports/malfunctioning/{face}', [SensorController::class, 'getMalfunctioningSensorsByFace']);
};
