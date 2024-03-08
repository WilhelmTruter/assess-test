<?php

// Bootstrap Slim Framework
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true, // you would want this false in production
    ],
]);

$app->get('/authors', '\Api\Authors\AuthorsController:index');

$app->get('/books', '\Api\Books\BooksController:index');
// would use the POST method here
// would also follow REST API principles and use /books only
$app->get('/books/create', '\Api\Books\BooksController:create');

$app->get('/currencies', '\Api\Currencies\CurrenciesController:index');
$app->get('/pricing', '\Api\Currencies\CurrenciesController:getPricing');

$app->run();
