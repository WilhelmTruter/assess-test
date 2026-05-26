<?php
/**
 * @var array $authors
 */
?>
<form method="POST" action="/books/create">
    <table>
        <tr>
            <td>Author</td>
            <td>
                <select name="author_id" id="author_id">
                    <?php if(isset($authors) && count($authors) > 0) { ?>
                        <?php foreach ($authors as $author) { ?>
                            <option value="<?= $author->id ?>"><?= $author->first_name ?> <?= $author->last_name ?></option>
                        <?php } 
                        } else {
                            ?>
                            <option value="">No authors found, please create an author first</option>
                         <?php } ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Title</td>
            <td><input type="text" name="title" id="title" value="" /> </td>
        </tr>

        <tr>
            <td>Price (ZAR)</td>
            <td><input type="text" name="price[ZAR]" id="price[ZAR]" value="" /></td>
        </tr>

        <tr>
            <td colspan="2" align="right">
                <input type="submit" value="Create" />
            </td>
        </tr>
    </table>
    <?php if(!empty($errors)) { ?>
        <b style="color: red;">Errors:</b><br />
        <div style="color: red;"><?=$errors;?></div>
    <?php } ?>
</form>
