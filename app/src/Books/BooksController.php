<?php

namespace App\Books;

use App\Authors\AuthorService;
use App\Currencies\CurrencyService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class BooksController
{
    private BookService $bookService;
    private AuthorService $authorService;
    private CurrencyService $currencyService;
    private PhpRenderer $renderer;

    public function __construct(
        BookService $bookService,
        AuthorService $authorService,
        CurrencyService $currencyService,
        PhpRenderer $renderer
    ) {
        $this->bookService     = $bookService;
        $this->authorService   = $authorService;
        $this->currencyService = $currencyService;
        $this->renderer        = $renderer;
    }

    public function index(Request $request, Response $response): Response
    {
        $page   = max(1, (int) ($request->getQueryParams()['page'] ?? 1));
        $result = $this->bookService->getAll($page);

        return $this->renderer->render($response, 'Books/templates/list.php', [
            'title' => 'Books — BookShelf',
            'books' => $result['books'] ?? [],
            'pagination' => $result['pagination'] ?? null,
        ]);
    }

    public function create(Request $request, Response $response): Response
    {
        if ($request->getMethod() === 'POST') {
            $params = (array) ($request->getParsedBody() ?? []);
            // var_dump($params);die;
            $this->bookService->create($params);

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/books');
        }

        $authors    = $this->authorService->getAll();
        $currencies = $this->currencyService->getAll();

        return $this->renderer->render($response, 'Books/templates/create.php', [
            'title'      => 'Add New Book — BookShelf',
            'authors'    => $authors,
            'currencies' => $currencies,
        ]);
    }
}