<?php
// Allow access from all origins
header("Access-Control-Allow-Origin: *");

// Allow all HTTP methods
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Allow all headers
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // No Content
    exit;
}
// Bootstrap Slim Framework
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true, // you would want this false in production
    ],
]);

$app->get('/authors', '\Api\Authors\AuthorsController:index');
$app->get('/currencies', '\Api\Currencies\CurrenciesController:index');

$app->get('/books', '\Api\Books\BooksController:index');
$app->post('/books/create', '\Api\Books\BooksController:create');

$app->run();
