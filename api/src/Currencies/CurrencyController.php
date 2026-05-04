<?php

namespace Api\Currencies;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Api\Database\Connection;

class CurrencyController
{
    public function index(Request $request, Response $response)
    {
        $db = Connection::make();

        $currencies = $db->query('SELECT * FROM currencies')
            ->fetchAll();

        return $response->getBody()->write(json_encode($currencies));
    }

}
