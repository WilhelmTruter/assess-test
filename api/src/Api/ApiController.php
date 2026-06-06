<?php
namespace Api\Api;

use Psr\Http\Message\ResponseInterface as Response;

// Shared base — both controllers extend this
abstract class ApiController
{
    protected function jsonResponse(Response $response, $data, int $status = 200): Response
    {
        $response->getBody()->write(json_encode($data));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}