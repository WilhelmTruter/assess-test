<?php

namespace App\Authors;

use App\Authors\AuthorService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class AuthorsController
{
    private AuthorService $authorService;
    private PhpRenderer $renderer;

    public function __construct(AuthorService $authorService, PhpRenderer $renderer)
    {
        $this->authorService = $authorService;
        $this->renderer      = $renderer;
    }

    public function index(Request $request, Response $response): Response
    {
        return $this->renderer->render($response, 'Authors/templates/list.php', [
            'title'   => 'Authors — BookShelf',
            'authors' => $this->authorService->getAll(),
        ]);
    }

    public function create(Request $request, Response $response): Response
    {
        if ($request->getMethod() === 'POST') {
            $params = (array) ($request->getParsedBody() ?? []);
            $this->authorService->create($params);

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/authors');
        }

        return $this->renderer->render($response, 'Authors/templates/create.php', [
            'title' => 'Add New Author — BookShelf',
        ]);
    }
}