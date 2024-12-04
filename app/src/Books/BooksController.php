<?php

namespace App\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\Views\PhpRenderer;

class BooksController
{
    public function index(Request $request, Response $response)
    {
        // Get the current page from the query parameters, default to 1
        $queryParams = $request->getQueryParams();
        $page = isset($queryParams['page']) ? (int)$queryParams['page'] : 1;
        $limit = 10; // Set the number of items per page

        // Request books with pagination from the API
        $ch = curl_init("http://api.localtest.me/books?page=$page&limit=$limit");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $apiResponse = json_decode(curl_exec($ch));

        curl_close($ch);

        // Extract books and pagination metadata
        $books = $apiResponse->books;
        $pagination = $apiResponse->pagination;

        // Get all the authors
        $ch = curl_init('http://api.localtest.me/authors');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $authors = json_decode(curl_exec($ch));
        curl_close($ch);

        // Add the author to each book for use in the listing template
        foreach ($books as $key => $book) {
            foreach ($authors as $author) {
                if ($book->author_id == $author->id) {
                    $books[$key]->author = $author;
                }
            }
        }

        // Render the template
        $renderer = new PhpRenderer('../src/Books/templates/');
        return $renderer->render($response, 'list.php', [
            'books' => $books,
            'pagination' => $pagination,
        ]);
    }


    public function add(Request $request, Response $response)
    {
        $ch = curl_init('http://api.localtest.me/books/create');
        $params = $request->getParsedBody();
        // Set the POST data
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        // Return the response instead of outputting it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request
        $responseAPI = curl_exec($ch);

        // Close the cURL session
        curl_close($ch);
        // Optionally process the response
        if ($response) {
             // Redirect back to book listing
            return $response->withStatus(302)->withHeader('Location', '/books');
            exit; // Ensure no further code is executed after redirect
        } else {
            echo 'Failed to create the book.';
        }
    }

    public function create(Request $request, Response $response)
    {
        // Check if form data has been sent
        if ($params = $request->getQueryParams()) {
            // Make the api call to create the book
            $ch = curl_init('http://api.localtest.me/books/create?'.http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);

           
            
        }

        // Get all the authors
        $ch = curl_init('http://api.localtest.me/authors');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $authors = json_decode(curl_exec($ch));
        curl_close($ch);

        $ch = curl_init('http://api.localtest.me/currencies');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $currencies = json_decode(curl_exec($ch));
        curl_close($ch);

        $renderer = new PhpRenderer('../src/Books/templates/');

        return $renderer->render($response, 'create.php', [
            'authors' => $authors,
            'currencies' => $currencies
        ]);
    }
}
