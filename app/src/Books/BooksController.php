<?php

namespace App\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\Views\PhpRenderer;

class BooksController
{

    public function index(Request $request, Response $response)
    {
        // would refactor this call into a new namespace like `integrations` or even repository
        // would also make use of a good http client library like guzzle to make development faster as well
        // to make it possible to do things like retires and even asynchronous calls
        // Get all the books to show
        $ch = curl_init('http://api.localtest.me/books'); // ask for pagination here too
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $books = json_decode(curl_exec($ch));
        curl_close($ch);


        // Get all the authors
        // would refactor this call into a new namespace like `integrations` or even repository
        // would also make use of a good http client library like guzzle to make development faster as well
        // to make it possible to do things like retires and even asynchronous calls
        $ch = curl_init('http://api.localtest.me/authors'); // would ask for pagination here.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $authors = json_decode(curl_exec($ch));
        curl_close($ch);


        $ch = curl_init('http://api.localtest.me/currencies'); // would ask for pagination here.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $currencies = json_decode(curl_exec($ch));
        curl_close($ch);

        $ch = curl_init('http://api.localtest.me/pricing'); // would ask for pagination here.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $prices = json_decode(curl_exec($ch));
        curl_close($ch);

        

    
        // Loop through all books and add the author to each one for use in the listing template
        // instead of double loop, might ask for eager loading of the author details and the use ith here
        foreach ($books as $key => $book) {
            foreach ($authors as $author) {
                if ($book->author_id == $author->id) {
                    $books[$key]->author = $author;
                }
            }
        }

        foreach($prices as $price) {
            foreach($books as $key => $book) {
                if ($price->book_id == $book->id) {
                    $book->price = $price;
                    $book->currency_id = $price->currency_id;
                }
            }
        }

        foreach($books as $key => $book) {
            foreach($currencies as $currency) {
                if($book->currency_id == $currency->id) {
                    $books[$key]->currency = $currency;
                }
            }
        }

        $renderer = new PhpRenderer('../src/Books/templates/');
        return $renderer->render($response, 'list.php', [
            'books' => $books,
        ]);
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

            // Redirect back to book listing
            return $response->withStatus(302)->withHeader('Location', '/books');
        }

        // Get all the authors
        $ch = curl_init('http://api.localtest.me/authors');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $authors = json_decode(curl_exec($ch));
        curl_close($ch);

        $ch = curl_init('http://api.localtest.me/currencies'); // would ask for pagination here.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $currencies = json_decode(curl_exec($ch));
        curl_close($ch);

        $renderer = new PhpRenderer('../src/Books/templates/');

        return $renderer->render($response, 'create.php', [
            'authors' => $authors,
            'currencies' => $currencies,
        ]);
    }
}
