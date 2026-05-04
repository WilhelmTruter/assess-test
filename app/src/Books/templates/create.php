<?php
/**
 * @var array $authors
 * @var array $currencies
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
        max-width: 760px;
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

    .back-link {
        color: #315b8f;
        font-weight: 700;
        text-decoration: none;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .form-panel {
        background: #ffffff;
        border: 1px solid #dde3ea;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(23, 32, 51, 0.06);
    }

    .field {
        margin-bottom: 18px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #445169;
        font-size: 14px;
        font-weight: 700;
    }

    input,
    select {
        box-sizing: border-box;
        width: 100%;
        min-height: 44px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 10px 12px;
        color: #172033;
        font-size: 16px;
        background: #ffffff;
    }

    input:focus,
    select:focus {
        border-color: #315b8f;
        outline: 3px solid rgba(49, 91, 143, 0.14);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 24px;
    }

    .button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        border: 1px solid #315b8f;
        border-radius: 6px;
        padding: 0 18px;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .button-primary {
        color: #ffffff;
        background: #315b8f;
    }

    .button-secondary {
        color: #315b8f;
        background: #ffffff;
    }

    @media (max-width: 560px) {
        .page {
            padding: 24px 14px;
        }

        .page-header,
        .form-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .button {
            width: 100%;
        }
    }
</style>

<main class="page">
    <div class="page-header">
        <h1>Create Book</h1>
        <a class="back-link" href="/books">Back to books</a>
    </div>

    <form class="form-panel" method="get" action="">
        <div class="field">
            <label for="title">Title</label>
            <input id="title" type="text" name="title" required />
        </div>

        <div class="field">
            <label for="author_id">Author</label>
            <select id="author_id" name="author_id" required>
                <?php foreach ($authors as $author): ?>
                    <option value="<?= htmlspecialchars($author->id) ?>">
                        <?= htmlspecialchars($author->first_name.' '.$author->last_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="field">
            <label for="currency_id">Currency</label>
            <select id="currency_id" name="currency_id" required>
                <?php foreach ($currencies as $currency): ?>
                    <option value="<?= htmlspecialchars($currency->id) ?>">
                        <?= htmlspecialchars($currency->name.' ('.$currency->iso.')') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="field">
            <label for="price">Price</label>
            <input id="price" type="number" name="price" step="0.01" min="0" required />
        </div>

        <div class="form-actions">
            <a class="button button-secondary" href="/books">Cancel</a>
            <input class="button button-primary" type="submit" value="Create Book" />
        </div>
    </form>
</main>
