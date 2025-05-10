<?php
namespace App;

class Database
{
    public static function connect(): \PDO
    {
        $host = $_ENV['DB_HOST'];
        $db   = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        $port = $_ENV['DB_PORT'];

        return new \PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    }
}
