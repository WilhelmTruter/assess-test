<?php

namespace Api\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class BooksController
{
    public function index(Request $request, Response $response)
    {
        // TODO; create a separate Database class into a separate file and move this code there, 
        // TODO: then we can just call $db = Database::getConnection() here instead of repeating this code in every controller
        // TODO: move 'root', 'secret' into environment variables and load them here as well
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        //use prepared statuements to avoind sql injecion

        $books = $db->query('SELECT  books.id, books.title, books.author_id, book_pricing.price, currencies.id, currencies.iso,
                                authors.first_name, authors.last_name
                            FROM books 
                            LEFT JOIN book_pricing ON books.id = book_pricing.book_id 
LEFT JOIN authors ON books.author_id = authors.id 
                            LEFT JOIN currencies ON book_pricing.currency_id = currencies.id')
            ->fetchAll();

        return $response->getBody()->write(json_encode($books));
    }

    public function create(Request $request, Response $response)
    {
        //TODO: Same as above, move this code into a separate Database class and use prepared statements to avoind sql injecion
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        $params = $request->getQueryParams();

        //TODO: use prepared statuements to avoind sql injecion
        // TODO: validate the input data before using it in the query, e.g. check if title is a string, author_id is an integer, price is a number, etc.
        // Create the new book
        $db->exec('INSERT INTO books (title, author_id) VALUES ("'.$params['title'].'", "'.$params['author_id'].'")');

        $book_id = $db->lastInsertId();

        // Create the ZAR price for the book
        $zar = $db->query('SELECT * FROM currencies WHERE iso = "ZAR"')->fetch();
        $db->exec('INSERT INTO book_pricing (book_id, currency_id, price) VALUES ('.$book_id.', '.$zar['id'].', '.$params['price']['ZAR'].')');

        // Fetch the book we just created so we can return it in the response
        $return = $db->query('SELECT * FROM books WHERE id = '.$book_id)
            ->fetchAll();

        return $response->getBody()->write(json_encode($return));
    }
}
