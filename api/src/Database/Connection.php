<?php

namespace Api\Database;

class Connection
{
    public static function make()
    {
        $host = self::env('DB_HOST');
        $database = self::env('DB_DATABASE');
        $username = self::env('DB_USERNAME');
        $password = self::env('DB_PASSWORD');

        $db = new \PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        return $db;
    }

    private static function env($key)
    {
        $value = getenv($key);

        if ($value === false || $value === '') {
            throw new \RuntimeException($key.' environment variable is not configured.');
        }

        return $value;
    }
}
