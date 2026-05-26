<?php

namespace App\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Slim\Views\PhpRenderer;

class BooksController
{
    public function index(Request $request, Response $response)
    {
        // Get all the books to show
        $ch = curl_init('http://api.localtest.me/books');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $books = json_decode(curl_exec($ch));
        curl_close($ch);


        // Get all the authors
        $ch = curl_init('http://api.localtest.me/authors');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $authors = json_decode(curl_exec($ch));
        curl_close($ch);

        // Loop through all books and add the author to each one for use in the listing template
        foreach ($books as $key => $book) {
            foreach ($authors as $author) {
                if ($book->author_id == $author->id) {
                    $books[$key]->author = $author;
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
        $errors = [];

        // Check if form data has been sent
        if (!empty($request->getParsedBody())) {
            
            $inputs                 = [];
            $inputs['author_id']    = isset($request->getParsedBody()['author_id']) ? filter_var($request->getParsedBody()['author_id'], FILTER_SANITIZE_NUMBER_INT) : null;
            $inputs['title']        = isset($request->getParsedBody()['title']) ? filter_var($request->getParsedBody()['title']) : null;
            $inputs['price']        = isset($request->getParsedBody()['price']) ? filter_var($request->getParsedBody()['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : null;
            $inputs['currency_iso']  = isset($request->getParsedBody()['currency_iso']) ? filter_var($request->getParsedBody()['currency_iso']) : null;

            // Check if selected currency is exists.
            if(!empty($inputs['currency_iso'])) {
                // Validate that the currency exists before trying to create the book
                $ch = curl_init('http://api.localtest.me/currencies/fetch?iso='.$inputs['currency_iso']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $currency = json_decode(curl_exec($ch));
                curl_close($ch);
                if(empty($currency)) {
                    $errors[] = 'Currency not found - Please check your selection and try again.';
                }
            } else {
                $errors[] = 'Please select a currency to create the book.';
            }

            // Check the title
            if(empty($inputs['title'])) {
                $errors[] = 'Please enter a title for the book.';
            } else {
                // Only enter letters, numbers, spaces and hyphen and apostrophe for the title
                if(!preg_match("/^[a-zA-Z0-9\s\-\']+$/", $inputs['title'])) {
                    $errors[] = 'The title entered had some invalid characters, please check your input and try again.';
                }
                // Check if the original name is the same as the one after sanitization, if not then it means there were some invalid characters that were removed and we should ask the user to check their input and try again
                if($inputs['title'] != $request->getParsedBody()['title']) {
                    $errors[] = 'The title entered had some invalid characters, please check your input and try again.';
                }
            }
            // Check the price            
            if(empty($inputs['price'])) {
                $errors[] = 'Please enter the amount of the book';
            } else {
                // Check if the price entered is the same after sanitization.
                if($inputs['price'] != $request->getParsedBody()['price']) {
                    $errors[] = 'The price entered had some invalid characters, please check your input and try again.';
                }
            }
            
            if(count($errors) == 0) {
                // Make the api call to create the book
                $ch = curl_init('http://api.localtest.me/books/create?'.http_build_query($inputs));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                json_decode(curl_exec($ch));
                curl_close($ch);
                // Redirect back to book listing
                return $response->withStatus(302)->withHeader('Location', '/books');
            } else {
                $inputs                 = [];
                $inputs['author_id']    = isset($request->getParsedBody()['author_id']) ? filter_var($request->getParsedBody()['author_id'], FILTER_SANITIZE_NUMBER_INT) : null;
                $inputs['title']        = isset($request->getParsedBody()['title']) ? $request->getParsedBody()['title'] : null;
                $inputs['price']        = isset($request->getParsedBody()['price']) ? $request->getParsedBody()['price'] : null;
                $inputs['currency_iso'] = isset($request->getParsedBody()['currency_iso']) ? $request->getParsedBody()['currency_iso'] : null;
            }
        }

        // Get all the authors
        $ch = curl_init('http://api.localtest.me/authors');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $authors = json_decode(curl_exec($ch));
        curl_close($ch);

        // Get all the authors
        $ch = curl_init('http://api.localtest.me/currencies');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $currencies = json_decode(curl_exec($ch));
        curl_close($ch);


        $renderer = new PhpRenderer('../src/Books/templates/');

        return $renderer->render($response, 'create.php', [
            'authors' => $authors, 
            'currencies' => $currencies,
            'errors' => (!empty($errors) ? implode("<br />", $errors) : null),
            'inputs' => (!empty($inputs) ? $inputs : null)
        ]);
    }
}
