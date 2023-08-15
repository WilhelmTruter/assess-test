<?php

namespace Api\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class BooksController
{
    public function index(Request $request, Response $response)
    {
        // @TODO configure DB connection , remove from controller function
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        $books = $db->query('SELECT * FROM books')
            ->fetchAll();

        return $response->getBody()->write(json_encode($books));
    }

    public function create(Request $request, Response $response)
    {
        // @TODO configure DB connection , remove from controller function
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        // @TODO use POST and retrieve request body
        $params = $request->getQueryParams();

        // Create the new book
        $db->exec('INSERT INTO books (title, author_id) VALUES ("'.$params['title'].'", "'.$params['author_id'].'")');
        $book_id = $db->lastInsertId();

        // Create the ZAR price for the book
        // $zar = $db->query('SELECT * FROM currencies WHERE iso = "ZAR"')->fetch();
        // $db->exec('INSERT INTO book_pricing (book_id, currency_id, price) VALUES ('.$book_id.', '.$zar['id'].', '.$params['price']['ZAR'].')');
        var_dump($params);
        die();
        $db->exec('INSERT INTO book_pricing (book_id, currency_id, price) VALUES ('.$book_id.', '.$params['currency'].', '.$params['price'].')');

        // Fetch the book we just created so we can return it in the response
        $return = $db->query('SELECT * FROM books WHERE id = '.$book_id)
            ->fetchAll();

        return $response->getBody()->write(json_encode($return));
    }

    public function getBookPricingCurrencies(Request $request, Response $response)
    {
        // @TODO configure DB connection , remove from controller function
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        $bookPricings = $db->query('SELECT * FROM currencies') //id, iso, name
            ->fetchAll();

        return $response->getBody()->write(json_encode($bookPricings));
    }
}
