<?php
// src/Authors/AuthorService.php

namespace App\Authors;

use App\Shared\ApiClient;

class AuthorService
{
    private ApiClient $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function getAll(): array
    {
        return $this->client->get('/authors');
    }

    public function create(array $data): array
    {
        return $this->client->post('/authors/create', $data);
    }
}