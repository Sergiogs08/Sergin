<?php
// app/Core/Database.php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $conn = null;

    public static function getConn(): PDO
    {
        if (self::$conn === null) {
            $host = $_ENV['DB_HOST']    ?? $_SERVER['DB_HOST']    ?? getenv('DB_HOST');
            $db   = $_ENV['DB_NAME']    ?? $_SERVER['DB_NAME']    ?? getenv('DB_NAME');
            $user = $_ENV['DB_USER']    ?? $_SERVER['DB_USER']    ?? getenv('DB_USER');
            $pass = $_ENV['DB_PASS']    ?? $_SERVER['DB_PASS']    ?? getenv('DB_PASS');
            $dsn  = "mysql:host={$host};dbname={$db};charset=utf8";

            try {
                self::$conn = new PDO(
                    $dsn,
                    $user,
                    $pass,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                die("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}

