<?php
/**
 * @var array $books
 */
?>

<style>
    :root {
        color: #172033;
        font-family: Arial, Helvetica, sans-serif;
        background: #f6f7f9;
    }

    body {
        margin: 0;
        background: #f6f7f9;
    }

    .page {
        max-width: 1040px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
    }

    h1 {
        margin: 0;
        font-size: 30px;
        font-weight: 700;
    }

    .button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        border-radius: 6px;
        padding: 0 18px;
        color: #ffffff;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        background: #315b8f;
    }

    .table-wrap {
        overflow-x: auto;
        background: #ffffff;
        border: 1px solid #dde3ea;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(23, 32, 51, 0.06);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 16px 18px;
        text-align: left;
        border-bottom: 1px solid #e8edf3;
    }

    th {
        color: #445169;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
    }

    tr:last-child td {
        border-bottom: 0;
    }

    tbody tr:hover {
        background: #f9fbfd;
    }

    .book-title {
        font-weight: 700;
    }

    .price {
        white-space: nowrap;
        font-variant-numeric: tabular-nums;
    }

    .empty-state {
        padding: 40px 20px;
        text-align: center;
        background: #ffffff;
        border: 1px solid #dde3ea;
        border-radius: 8px;
    }

    .empty-state p {
        margin: 0 0 18px;
        color: #445169;
    }

    @media (max-width: 640px) {
        .page {
            padding: 24px 14px;
        }

        .page-header {
            align-items: stretch;
            flex-direction: column;
        }

        .button {
            width: 100%;
        }

        th,
        td {
            padding: 14px 12px;
        }
    }
</style>

<main class="page">
    <div class="page-header">
        <h1>Books</h1>
        <a class="button" href="/books/create">Create Book</a>
    </div>

    <?php if (empty($books)): ?>
        <div class="empty-state">
            <p>No books have been added yet.</p>
            <a class="button" href="/books/create">Create Book</a>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td class="book-title"><?= htmlspecialchars($book->title) ?></td>
                            <td><?= htmlspecialchars($book->author->first_name.' '.$book->author->last_name) ?></td>
                            <td class="price"><?= htmlspecialchars($book->iso.' '.number_format($book->price, 2)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>
