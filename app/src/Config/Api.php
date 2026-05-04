<?php

namespace App\Config;

class Api
{
    private static $baseUrl;

    public static function url($path)
    {
        return self::baseUrl().'/'.ltrim($path, '/');
    }

    private static function baseUrl()
    {
        if (self::$baseUrl === null) {
            self::$baseUrl = rtrim(getenv('API_BASE_URL') ?: 'http://api.localtest.me', '/');
        }

        return self::$baseUrl;
    }
}
