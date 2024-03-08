<?php

namespace Api\Authors;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class AuthorsController
{
    public function index(Request $request, Response $response)
    {

        // extract this into it own class and make use of env variables.
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        // might make use of the repository pattern here. helps in not exposing the 
        // table structure straight to the frontend
        // make use of pagination to reduce the load and response time
        $authors = $db->query('SELECT * FROM authors')
            ->fetchAll();

        // might make use of DTOs/ Resource to shape the data and detach the response from rhe table structure
        return $response->getBody()->write(json_encode($authors));
    }
}
