<?php

namespace Api\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Api\Database\Connection;

class BooksController
{
    public function index(Request $request, Response $response)
    {
        $db = Connection::make();

        $books = $db->query('SELECT * FROM books 
                join book_pricing on books.id = book_pricing.book_id 
                join currencies on book_pricing.currency_id = currencies.id')
            ->fetchAll();

        return $response->getBody()->write(json_encode($books));
    }

    public function create(Request $request, Response $response)
    {
        $db = Connection::make();

        $params = $request->getQueryParams();

        // Create the new book
        $db->exec('INSERT INTO books (title, author_id) VALUES ("'.$params['title'].'", "'.$params['author_id'].'")');
        $book_id = $db->lastInsertId();

        // Create the ZAR price for the book
        // $zar = $db->query('SELECT * FROM currencies WHERE iso = "ZAR"')->fetch();
        $db->exec('INSERT INTO book_pricing (book_id, currency_id, price) VALUES ('.$book_id.', '.$params['currency_id'].', '.$params['price'].')');

        // Fetch the book we just created so we can return it in the response
        $return = $db->query('SELECT * FROM books WHERE id = '.$book_id)
            ->fetchAll();

        return $response->getBody()->write(json_encode($return));
    }
}
