<?php

// Bootstrap Slim Framework
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true, // you would want this false in production
    ],
]);

// Web app frontend routes
$app->get('/books', '\App\Books\BooksController:index');
// use post here, since it is a create operation and follow REST API principles
// hence no /create just /books
$app->get('/books/create', '\App\Books\BooksController:create');

// We don't have a homepage for this web app so just head to the books listing on first load
$app->redirect('/', '/books');

$app->run();
