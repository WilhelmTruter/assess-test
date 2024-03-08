<?php

namespace Api\Currencies;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class CurrenciesController
{
    public function index(Request $request, Response $response)
    {

        // extract this into it own class and make use of env variables.
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        // might make use of the repository pattern here. helps in not exposing the 
        // table structure straight to the frontend
        // make use of pagination to reduce the load and response time
        $currencies = $db->query('SELECT id, iso, name FROM currencies')
            ->fetchAll();

        // might make use of DTOs/ Resource to shape the data and detach the response from rhe table structure
        return $response->getBody()->write(json_encode($currencies));
    }


    public function getPricing(Request $request, Response $response)
    {

        // extract this into it own class and make use of env variables.
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        // might make use of the repository pattern here. helps in not exposing the 
        // table structure straight to the frontend
        // make use of pagination to reduce the load and response time
        $currencies = $db->query('SELECT * FROM book_pricing')
            ->fetchAll();

        // might make use of DTOs/ Resource to shape the data and detach the response from rhe table structure
        return $response->getBody()->write(json_encode($currencies));
    }

    
}
