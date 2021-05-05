<?php

namespace Api\BookPrices;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class BookPricesController
{
    public function index(Request $request, Response $response)
    {
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        $bookprices = $db->query('SELECT * FROM book_pricing')
            ->fetchAll();

        return $response->getBody()->write(json_encode($bookprices));
    }
}
