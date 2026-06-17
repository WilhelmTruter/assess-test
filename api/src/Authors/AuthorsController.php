<?php

namespace Api\Authors;

use Api\Database\Database;
use Api\Api\ApiController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDOException;

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

    public function create(Request $request, Response $response): Response
    {
        $params = (array) ($request->getParsedBody() ?? []);

        if (empty($params['first_name']) || empty($params['last_name'])) {
            return $this->jsonResponse($response, ['error' => 'First name and last name are required.'], 422);
        }

        $db = Database::getConnection();

        try {
            $stmt = $db->prepare('
                INSERT INTO authors (first_name, last_name)
                VALUES (:first_name, :last_name)
            ');

            $stmt->execute([
                ':first_name' => $params['first_name'],
                ':last_name'  => $params['last_name'],
            ]);

            $newAuthorId = $db->lastInsertId();

            $db->commit();


        } catch (PDOException $e) {
            $db->rollBack();
            return $this->jsonResponse($response, ['error' => 'Failed to create author.'], 500);
        }

        $stmt = $db->prepare('
            SELECT
                id,
                first_name,
                last_name
            FROM authors
            WHERE id = :id');

        $stmt->execute([':id' => $newAuthorId]);
        $author = $stmt->fetch();   

        return $this->jsonResponse($response, $author, 201);
    }
}