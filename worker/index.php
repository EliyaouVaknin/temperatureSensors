<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Connect to Redis
$redis = new Redis();
$redis->connect('redis', 6379);

// Connect to PostgreSQL
$pdo = new PDO(
    "pgsql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']}",
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

echo "Worker started. Listening for sensor data...\n";

// Continuous batch processor
while (true) {
    $batch = [];

    // Pull up to 1000 items from Redis (fast, non-blocking)
    for ($i = 0; $i < 1000; $i++) {
        $data = $redis->lPop('sensor_queue');
        if ($data === false) break;
        $sensor = json_decode($data, true);

        // Validate sensor format
        if (!isset($sensor['id'], $sensor['timestamp'], $sensor['face'], $sensor['temperature'])) {
            continue;
        }

        $batch[] = [
            'timestamp' => date('Y-m-d H:00:00', $sensor['timestamp']),
            'id' => (int)$sensor['id'],
            'face' => $sensor['face'],
            'temperature' => (float)$sensor['temperature']
        ];
    }

    if (empty($batch)) {
        usleep(100000); // Sleep 100ms if no data
        continue;
    }

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("
            INSERT INTO sensor_data (timestamp, id, face, temperature)
            VALUES (?, ?, ?, ?)
        ");

        foreach ($batch as $row) {
            $stmt->execute([
                $row['timestamp'],
                $row['id'],
                $row['face'],
                $row['temperature']
            ]);
        }

        $pdo->commit();
        echo "✅ Inserted batch of " . count($batch) . " records\n";
    } catch (Throwable $e) {
        $pdo->rollBack();
        echo "❌ Error inserting batch: " . $e->getMessage() . "\n";
    }

    // Optionally: move this into hourly aggregator logic
}
