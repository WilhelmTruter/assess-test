<?php

namespace Api\Currencies;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class CurrenciesController
{
    public function index(Request $request, Response $response)
    {
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        $currencies = $db->query('SELECT * FROM currencies')
            ->fetchAll();

        return $response->getBody()->write(json_encode($currencies));
    }

    public function fetch(Request $request, Response $response)
    {
        $iso = isset($request->getQueryParams()['iso']) ? filter_var($request->getQueryParams()['iso']) : null;
        if(!empty($iso)) {
            $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
            $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

            $currency = $db->query("SELECT * FROM currencies WHERE iso = '".$iso."'")->fetch();
            return $response->getBody()->write(json_encode($currency));
        }
        // Empty array.
        return $response->getBody()->write(json_encode([]));
    }
}
