<?php

namespace Api\Books;

use Api\Database\Database;
use Api\Api\ApiController;
use PDO;
use PDOException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BooksController extends ApiController
{
    // -------------------------------------------------------------------------
    // GET /books
    // -------------------------------------------------------------------------
    public function index(Request $request, Response $response): Response
    {
        $params  = $request->getQueryParams();
        $page    = max(1, (int) ($params['page'] ?? 1));
        $perPage = 10;
        $offset  = ($page - 1) * $perPage;

        $db = Database::getConnection();

        // Total count for pagination metadata
        $countStmt = $db->prepare('
            SELECT COUNT(DISTINCT books.id) AS total
            FROM books
            LEFT JOIN book_pricing ON books.id        = book_pricing.book_id
            LEFT JOIN authors      ON books.author_id = authors.id
            LEFT JOIN currencies   ON book_pricing.currency_id = currencies.id
        ');
        $countStmt->execute();
        $total    = (int) $countStmt->fetchColumn();
        $lastPage = max(1, (int) ceil($total / $perPage));

        // Paginated results — bindValue enforces integer type for LIMIT/OFFSET
        $stmt = $db->prepare('
            SELECT
                books.id,
                books.title,
                books.author_id,
                book_pricing.price,
                currencies.id  AS currency_id,
                currencies.iso AS currency_iso,
                authors.first_name,
                authors.last_name
            FROM books
            LEFT JOIN book_pricing ON books.id          = book_pricing.book_id
            LEFT JOIN authors      ON books.author_id   = authors.id
            LEFT JOIN currencies   ON book_pricing.currency_id = currencies.id
            ORDER BY books.id ASC
            LIMIT :limit OFFSET :offset');

        $stmt->bindValue(':limit',  $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset,  PDO::PARAM_INT);

        $stmt->execute();
        $books = $stmt->fetchAll();

        // return $this->jsonResponse($response, $books);
        return $this->jsonResponse($response, [
            'books' => $books,
            'pagination' => [
                'total'        => $total,
                'per_page'     => $perPage,
                'current_page' => $page,
                'last_page'    => $lastPage,
                'from'         => $total > 0 ? $offset + 1 : 0,
                'to'           => min($offset + $perPage, $total),
            ],
        ]);
    }

    // -------------------------------------------------------------------------
    // POST /books
    // -------------------------------------------------------------------------
    public function create(Request $request, Response $response): Response
    {
        // getParsedBody() reads POST/JSON body — getQueryParams() only reads ?query=string
        $params = (array) ($request->getParsedBody() ?? []);

        $errors = $this->validateBookParams($params);
        if (!empty($errors)) {
            return $this->jsonResponse($response, ['errors' => $errors], 422);
        }

        $db = Database::getConnection();

        try {
            // Wrap both INSERTs in a transaction so they succeed or fail together
            $db->beginTransaction();

            $stmt = $db->prepare(
                'INSERT INTO books (title, author_id) VALUES (:title, :author_id)'
            );
            $stmt->execute([
                ':title'     => $params['title'],
                ':author_id' => (int) $params['author_id'],
            ]);

            $bookId = (int) $db->lastInsertId();

            $stmt = $db->prepare(
                'INSERT INTO book_pricing (book_id, currency_id, price)
                 VALUES (:book_id, :currency_id, :price)'
            );
            $stmt->execute([
                ':book_id'     => $bookId,
                ':currency_id' => (int) $params['currency_id'],
                ':price'       => (float) $params['price'],
            ]);

            $db->commit();
        } catch (PDOException $e) {
            $db->rollBack();
            return $this->jsonResponse($response, ['error' => 'Failed to create book'], 500);
        }

        // Return the full book record (same shape as index) with 201 Created
        $stmt = $db->prepare('
            SELECT
                books.id,
                books.title,
                books.author_id,
                book_pricing.price,
                currencies.id  AS currency_id,
                currencies.iso AS currency_iso,
                authors.first_name,
                authors.last_name
            FROM books
            LEFT JOIN book_pricing ON books.id          = book_pricing.book_id
            LEFT JOIN authors      ON books.author_id   = authors.id
            LEFT JOIN currencies   ON book_pricing.currency_id = currencies.id
            WHERE books.id = :id
        ');
        $stmt->execute([':id' => $bookId]);
        $book = $stmt->fetch();

        return $this->jsonResponse($response, $book, 201);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Validates required fields for book creation.
     * Returns an associative array of field => message pairs; empty = valid.
     */
    private function validateBookParams(array $params): array
    {
        $errors = [];

        if (empty($params['title']) || !is_string($params['title'])) {
            $errors['title'] = 'Title is required and must be a string.';
        }

        if (empty($params['author_id']) || !ctype_digit((string) $params['author_id'])) {
            $errors['author_id'] = 'Author ID is required and must be a positive integer.';
        }

        if (empty($params['currency_id']) || !ctype_digit((string) $params['currency_id'])) {
            $errors['currency_id'] = 'Currency ID is required and must be a positive integer.';
        }

        if (!isset($params['price']) || !is_numeric($params['price']) || (float) $params['price'] < 0) {
            $errors['price'] = 'Price is required and must be a non-negative number.';
        }

        return $errors;
    }
}