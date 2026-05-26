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
        <th>Currency</th>
    </tr>
    <?php foreach ($books as $book): ?>
        <tr>
            <td><?= $book->title ?></td>
            <td><?= $book->author->first_name ?> <?= $book->author->last_name ?></td>
            <td><?= $book->price ?></td>
            <td><?= $book->iso ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="/books/create">Create New Book</a>
