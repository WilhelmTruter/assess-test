<?php

namespace Api\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class BooksController
{
    public function index(Request $request, Response $response)
    {
        // user and pass needs to moved away from here - ideally to env vars
        // also need to add error handling
        // prepared statements would be good too
        // database connection should be moved to a separate class
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        $books = $db->query('SELECT * FROM books')
            ->fetchAll();

        return $response->getBody()->write(json_encode($books));
    }

    public function create(Request $request, Response $response)
    {
        //addressed above
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        // rather use getParsedBody() for POST data - given this create a new record
        $params = $request->getQueryParams();

        // Create the new book
        // error handling and prepared statements would be good here too
        $db->exec('INSERT INTO books (title, author_id) VALUES ("'.$params['title'].'", "'.$params['author_id'].'")');
        $book_id = $db->lastInsertId();

        // Create the ZAR price for the book
        // iso value hardcoded here - ideally this would be dynamic
        // prepared statements would be good here too

        // $zar = $db->query('SELECT * FROM currencies WHERE iso = "ZAR"')->fetch();

        $db->exec('INSERT INTO book_pricing (book_id, currency_id, price) 
            VALUES ('.$book_id.', '.$params['currency_id'].', '.$params['price'].')');

        // Fetch the book we just created so we can return it in the response
        // single book request - fetch() would be better here
        $return = $db->query('SELECT * FROM books WHERE id = '.$book_id)
            ->fetchAll();

        return $response->getBody()->write(json_encode($return));
    }
}
