<?php

namespace Api\Currencies;

use Api\Database\Database;
use Api\Api\ApiController;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class CurrenciesController extends ApiController
{
    public function index(Request $request, Response $response)
    {

        $db = Database::getConnection();

        $stmt = $db->prepare('
            SELECT
                id,
                iso,
                name
            FROM currencies
        ');
        
        $stmt->execute();
        $currencies = $stmt->fetchAll();

        return $this->jsonResponse($response, $currencies);
    }
}
