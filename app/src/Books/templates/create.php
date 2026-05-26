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
                            <option value="<?= $author->id ?>" <?= (isset($inputs['author_id']) && $inputs['author_id'] == $author->id) ? 'selected' : '' ?>><?= $author->first_name ?> <?= $author->last_name ?></option>
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
            <td><input type="text" name="title" id="title" value="<?=(isset($inputs['title']) ? $inputs['title'] : '');?>" Placeholder="Only letters, numbers, spaces and hyphens allowed" size="50" /> </td>
        </tr>
        <tr>
            <td>Currency</td>
            <td>
                <select name="currency_iso" id="currency_iso">
                    <?php if(isset($currencies) && count($currencies) > 0) { ?>
                        <option value=""> -- Select a currency -- </option>
                        <?php foreach ($currencies as $currency) { ?>
                            <option value="<?= $currency->iso ?>" <?= (isset($inputs['currency_iso']) && $inputs['currency_iso'] == $currency->iso) ? 'selected' : '' ?>><?= $currency->name ?></option>
                        <?php } 
                        } else {
                            ?>
                            <option value="">No currencies found, please create a currency first</option>
                         <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Price</td>
            <td><input type="text" name="price" id="price" value="<?=(isset($inputs['price']) ? $inputs['price'] : '');?>"  size="50" placeholder="100.99" /></td>
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
