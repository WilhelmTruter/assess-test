<?php
namespace Api\Database;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
    private static ?PDO $instance = null;

    // Prevent direct instantiation
    private function __construct() {}

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            self::$instance = self::createConnection();
        }

        return self::$instance;
    }

    private static function createConnection(): PDO
    {
        $host     = self::requireEnv('DB_HOST');
        $dbname   = self::requireEnv('DB_NAME');
        $user     = self::requireEnv('DB_USER');
        $password = self::requireEnv('DB_PASSWORD');

        try {
            return new PDO(
                "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
                $user,
                $password,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,   // ✅ real prepared statements
                ]
            );
        } catch (PDOException $e) {
            throw new PDOException(
                'Database connection failed: ' . $e->getMessage(),
                (int) $e->getCode(),
                $e  // ✅ preserve original exception chain
            );
        }
    }

    private static function requireEnv(string $key): string
    {
        $value = $_ENV[$key] ?? '';

        if ($value === false || $value === '') {
            throw new RuntimeException("Missing required environment variable: {$key}");
        }

        return $value;
    }
}