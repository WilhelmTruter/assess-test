<?php

use App\Authors\AuthorsController;
use App\Books\BooksController;

$app->get('/books',          BooksController::class   . ':index');
$app->get('/books/create',   BooksController::class   . ':create');
$app->post('/books/create',  BooksController::class   . ':create');

$app->get('/authors',        AuthorsController::class . ':index');
$app->get('/authors/create', AuthorsController::class . ':create');
$app->post('/authors/create',AuthorsController::class . ':create');
