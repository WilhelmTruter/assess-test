<?php
/**
 * @var array $books
 */
?>

<table>
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Currency</th>
        <th>Price</th>
    </tr>
    <?php foreach ($books as $book): ?>
        <tr>
            <td><?= $book->title ?></td>
            <td><?= $book->author->first_name ?> <?= $book->author->last_name ?></td>
            <td><?= $book->currency ?> </td>
            <td><?= $book->price ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="/books/create">Create New Book</a>
