<?php

namespace Api\Authors;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class AuthorsController
{
    public function index(Request $request, Response $response)
    {
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        $authors = $db->query('SELECT * FROM authors')
            ->fetchAll();

        return $response->getBody()->write(json_encode($authors));
    }

    public function getCurrency(Request $request, Response $response)
    {
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        $currency = $db->query('SELECT * FROM currencies')
            ->fetchAll();

        return $response->getBody()->write(json_encode($currency));
    }

}
