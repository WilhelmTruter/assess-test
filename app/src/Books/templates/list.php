<?php
/**
 * @var array $books
 */
?>
<?php
var_dump($bookprices);

var_dump($currencies);
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
            <td><?= $book->author->first_name ?> <?= $book->author->last_name ?></td>

            <!-- it should actually be this: (i used the wrong variable for currency)
            <td><?// = $book->currency ?> <? //= $book->price ?></td>     -->
            <td><?= $book->currency_id ?> <?= $book->price ?></td>
            
        </tr>
    <?php endforeach; ?>
    
    <tr>
        <td><a href="/books/create">Create New Book</a></td>
    </tr>
</table>