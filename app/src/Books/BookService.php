<?php
// src/Books/BookService.php

namespace App\Books;

use App\Shared\ApiClient;

class BookService
{
    private ApiClient $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function getAll(int $page = 1): array
    {
        return $this->client->get('/books?page=' . $page);
    }

    public function create(array $data): array
    {
        return $this->client->post('/books/create', $data);
    }
}