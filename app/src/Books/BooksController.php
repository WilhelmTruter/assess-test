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
            $inputs['price']['ZAR'] = isset($request->getParsedBody()['price']['ZAR']) ? filter_var($request->getParsedBody()['price']['ZAR'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : null;

            // Check if selected author is exists.
            if(!empty($inputs['author_id'])) {
                // Validate that the author exists before trying to create the book
                $ch = curl_init('http://api.localtest.me/authors/fetch?id='.$inputs['author_id']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $author = json_decode(curl_exec($ch));
                curl_close($ch);

                if(empty($author)) {
                    $errors[] = 'Author not found - Please check your selection and try again.';
                }
            } else {
                $errors[] = 'Please select an author to create the book.';
            }
            // Check the title
            if(empty($inputs['title'])) {
                $errors[] = 'Please enter a title for the book.';
            } else {
                // Only enter letters, numbers, spaces and hypen and aphostrophes for the title
                if(!preg_match("/^[a-zA-Z0-9\s\-\']+$/", $inputs['title'])) {
                    $errors[] = 'The title entered had some invalid characters, please check your input and try again.';
                }
                // Check if the original name is the same as the one after sanitization, if not then it means there were some invalid characters that were removed and we should ask the user to check their input and try again
                if($inputs['title'] != $request->getParsedBody()['title']) {
                    $errors[] = 'The title entered had some invalid characters, please check your input and try again.';
                }
            }
            // Check the price            
            if(empty($inputs['price']['ZAR'])) {
                $errors[] = 'Please enter the amount of the book';
            } else {
                // Check if the price entered is the same after sanitization.
                if($inputs['price']['ZAR'] != $request->getParsedBody()['price']['ZAR']) {
                    $errors[] = 'The price entered had some invalid characters, please check your input and try again.';
                }
            }
            
            if(count($errors) == 0) {
                // Make the api call to create the book
                $ch = curl_init('http://api.localtest.me/books/create?'.http_build_query($inputs));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_exec($ch);
                curl_close($ch);

                // Redirect back to book listing
                return $response->withStatus(302)->withHeader('Location', '/books');
            } else {
                $inputs                 = [];
                $inputs['author_id']    = isset($request->getParsedBody()['author_id']) ? filter_var($request->getParsedBody()['author_id'], FILTER_SANITIZE_NUMBER_INT) : null;
                $inputs['title']        = isset($request->getParsedBody()['title']) ? $request->getParsedBody()['title'] : null;
                $inputs['price']['ZAR'] = isset($request->getParsedBody()['price']['ZAR']) ? $request->getParsedBody()['price']['ZAR'] : null;
            }
        }

        // Get all the authors
        $ch = curl_init('http://api.localtest.me/authors');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $authors = json_decode(curl_exec($ch));
        curl_close($ch);

        $renderer = new PhpRenderer('../src/Books/templates/');

        return $renderer->render($response, 'create.php', [
            'authors' => $authors, 
            'errors' => (!empty($errors) ? implode("<br />", $errors) : null),
            'inputs' => (!empty($inputs) ? $inputs : null)
        ]);
    }
}
