<?php

namespace App\Shared;

use RuntimeException;

class ApiClient
{
    private string $baseUrl;

    public function __construct()
    {
        $baseUrl = $_ENV['API_BASE_URL'] ?? '';

        if (!$baseUrl) {
            throw new RuntimeException('API_BASE_URL environment variable is not set.');
        }

        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function get(string $endpoint): array
    {
        $ch = curl_init($this->baseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $error  = curl_error($ch);
        curl_close($ch);

        if ($result === false) {
            throw new RuntimeException("GET {$endpoint} failed: {$error}");
        }

        return json_decode($result, true) ?? [];
    }

    public function post(string $endpoint, array $data): array
    {
        $ch = curl_init($this->baseUrl . $endpoint);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
        ]);

        $result = curl_exec($ch);
        $error  = curl_error($ch);
        curl_close($ch);

        if ($result === false) {
            throw new RuntimeException("POST {$endpoint} failed: {$error}");
        }

        return json_decode($result, true) ?? [];
    }
}