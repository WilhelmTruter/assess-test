<?php

// Bootstrap Slim Framework
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true, // you would want this false in production
    ],
]);

$app->get('/authors', '\Api\Authors\AuthorsController:index');
$app->post('/authors/create', '\Api\Authors\AuthorsController:create');

$app->get('/currencies', '\Api\Currencies\CurrenciesController:index');

$app->get('/books', '\Api\Books\BooksController:index');
$app->post('/books/create', '\Api\Books\BooksController:create');

$app->run();
