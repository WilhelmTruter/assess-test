<?php
// src/Currencies/CurrencyService.php

namespace App\Currencies;

use App\Shared\ApiClient;

class CurrencyService
{
    private ApiClient $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function getAll(): array
    {
        return $this->client->get('/currencies');
    }
}