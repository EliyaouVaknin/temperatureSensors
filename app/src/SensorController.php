<?php
namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SensorController
{
    public static function receiveData(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $redis = new \Redis();
        $redis->connect('redis', 6379);
        $redis->rPush('sensor_queue', json_encode([
            'id' => (int)$data['id'],
            'timestamp' => (int)$data['timestamp'],
            'face' => strtolower($data['face']),
            'temperature' => (float)$data['temperature']
          ]));

        $response->getBody()->write(json_encode(['status' => 'queued']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function getHourlyReport(Request $request, Response $response): Response
    {
        $pdo = Database::connect();
        $result = $pdo->query("SELECT * FROM hourly_face_aggregates ORDER BY hour DESC LIMIT 168");
        $data = $result->fetchAll(\PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function getMalfunctioningSensors(Request $request, Response $response): Response
    {
        $pdo = Database::connect();
        $result = $pdo->query("SELECT * FROM malfunctioning_sensors ORDER BY id ASC");
        $data = $result->fetchAll(\PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
