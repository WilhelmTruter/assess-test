<?php

namespace Api\Authors;

use Api\Database\Database;
use Api\Api\ApiController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthorsController extends ApiController
{
    // -------------------------------------------------------------------------
    // GET /authors
    // -------------------------------------------------------------------------
    public function index(Request $request, Response $response): Response
    {
        $db = Database::getConnection();

        $stmt = $db->prepare('
            SELECT
                id,
                first_name,
                last_name
            FROM authors
        ');

        $stmt->execute();
        $authors = $stmt->fetchAll();

        return $this->jsonResponse($response, $authors);
    }
}