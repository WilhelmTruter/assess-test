<?php

use App\Authors\AuthorService;
use App\Books\BookService;
use App\Books\BooksController;
use App\Currencies\CurrencyService;
use App\Shared\ApiClient;
use Slim\Views\PhpRenderer;
use App\Authors\AuthorsController;

// $container is already in scope from index.php — no need to reassign it

$container[ApiClient::class] = function () {
    return new ApiClient();
};

$container[BookService::class] = function ($c) {
    return new BookService($c->get(ApiClient::class));
};

$container[AuthorService::class] = function ($c) {
    return new AuthorService($c->get(ApiClient::class));
};

$container[CurrencyService::class] = function ($c) {
    return new CurrencyService($c->get(ApiClient::class));
};

$container[PhpRenderer::class] = function () {
    $renderer = new PhpRenderer(__DIR__ . '/');
    $renderer->setLayout('templates/layout.php'); // applies to every render call
    return $renderer;
};

$container[BooksController::class] = function ($c) {
    return new BooksController(
        $c->get(BookService::class),
        $c->get(AuthorService::class),
        $c->get(CurrencyService::class),
        $c->get(PhpRenderer::class)
    );
};

$container[AuthorsController::class] = function ($c) {
    return new AuthorsController(
        $c->get(AuthorService::class),
        $c->get(PhpRenderer::class)
    );
};