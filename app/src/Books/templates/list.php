<?php
/**
 * @var array $books
 */
?>

<table>
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Price</th>
    </tr>
    <?php foreach ($books as $book): ?>
        <tr>
            <td><?= $book->title ?></td>
            <td><?= $book->first_name ?> <?= $book->last_name ?></td>
            <td><?= $book->iso ?> <?= $book->price ?></td>
        </tr>
        </tr>
    <?php endforeach; ?>
</table>

<a href="/books/create">Create New Book</a>
