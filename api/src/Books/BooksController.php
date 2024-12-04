<?php

namespace Api\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class BooksController
{
    public function index(Request $request, Response $response)
    {
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        // Get page and limit from query parameters (default to page 1 and 10 items per page)
        $params = $request->getQueryParams();
        $page = isset($params['page']) ? (int)$params['page'] : 1;
        $limit = isset($params['limit']) ? (int)$params['limit'] : 10;

        // Calculate the offset
        $offset = ($page - 1) * $limit;

        // Fetch total number of books for pagination metadata
        $totalBooks = $db->query('SELECT COUNT(*) AS count FROM books')->fetch()['count'];

        // Fetch paginated books
        $query = $db->prepare(
            'SELECT books.*, book_pricing.price, currencies.iso 
            FROM books
            JOIN book_pricing ON book_pricing.book_id = books.id
            JOIN currencies ON currencies.id = book_pricing.currency_id
            LIMIT :limit OFFSET :offset'
        );
        $query->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $query->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $query->execute();

        $books = $query->fetchAll();

        // Add pagination metadata to the response
        $responseBody = [
            'books' => $books,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total' => $totalBooks,
                'total_pages' => ceil($totalBooks / $limit),
            ],
        ];

        return $response->withHeader('Content-Type', 'application/json')->write(json_encode($responseBody));
    }

    public function create(Request $request, Response $response)
    {
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        $params = $request->getParsedBody();
  
        // Create the new book
        $db->exec('INSERT INTO books (title, author_id) VALUES ("'.$params['title'].'", "'.$params['author_id'].'")');
        $book_id = $db->lastInsertId();

        // Create the ZAR price for the book
        $db->exec('INSERT INTO book_pricing (book_id, currency_id, price) VALUES ('.$book_id.', '.$params['currency_id'].', '.$params['price'].')');

        // Fetch the book we just created so we can return it in the response
        $return = $db->query('SELECT * FROM books WHERE id = '.$book_id)
            ->fetchAll();

        return $response->getBody()->write(json_encode($return));
    }
}
