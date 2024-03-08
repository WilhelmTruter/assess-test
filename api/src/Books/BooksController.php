<?php

namespace Api\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class BooksController
{
    public function index(Request $request, Response $response)
    {
        // would do the same here
        // env('db_name')
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        // would use pagination here and possibly repository pattern
        $books = $db->query('SELECT * FROM books')
            ->fetchAll();

        // make use of DTOs or resource here
        return $response->getBody()->write(json_encode($books));
    }

    public function create(Request $request, Response $response)
    {
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        // would do a validation here 
        // would use a POST method and validate the data
        $params = $request->getQueryParams();

        // Create the new book
        // would make use of parameters here than passing the values straight
        $db->exec('INSERT INTO books (title, author_id) VALUES ("'.$params['title'].'", "'.$params['author_id'].'")');
        $book_id = $db->lastInsertId();

        // Create the ZAR price for the book
        // would make use of parameters here as well as 
        $zar = $db->query('SELECT * FROM currencies WHERE iso = "ZAR"')->fetch();
        $currency =  $db->query('SELECT * FROM currencies WHERE iso = "' .$params['currency_iso'] .'"')->fetch();
        
        // ensure this field exists to prevent a crash. so either checking it or putting it inside a try/catch
        $db->exec('INSERT INTO book_pricing (book_id, currency_id, price) VALUES ('.$book_id.', '.$currency['id'].', '.$params['price'].')');

        // Fetch the book we just created so we can return it in the response
        // use parameters instead of concatenating values
        // use the repository or service pattern
        $return = $db->query('SELECT * FROM books WHERE id = '.$book_id)
            ->fetchAll();

        // make use of a resource / DTO
        return $response->getBody()->write(json_encode($return));
    }
}
