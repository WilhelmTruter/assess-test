<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function showCurrency() {
            const selectElement = document.getElementById('currency_id');
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const isoValue = selectedOption.getAttribute('data-iso');
            document.getElementById('selectedCurrency').innerText = isoValue ? `(${isoValue})` : ``;
        }

        // Add form validation
        function validateForm(event) {
            const selectElement = document.getElementById('currency_id');
            const priceInput = document.querySelector('input[name="price"]');
            const selectedValue = selectElement.value;
            const priceValue = priceInput.value.trim();
            const titleValue = document.querySelector('input[name="title"]').value.trim();

            // Check if a currency is selected
            if (!selectedValue || selectedValue === "Please select") {
                alert('Please select a valid currency.');
                event.preventDefault();
                return false;
            }

            // Check if price is valid
            if (!priceValue || isNaN(priceValue) || parseFloat(priceValue) <= 0) {
                alert('Please enter a valid numeric price greater than 0.');
                event.preventDefault();
                return false;
            }

            // Check if title is valid
            if (!titleValue) {
                alert('Please enter a valid title.');
                event.preventDefault();
                return false;
            }

            return true;
        }
    </script>
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-700 mb-6">Create Book</h1>
        <form method="post" action="/books/createBook" onsubmit="return validateForm(event)" class="space-y-6">
            <div>
                <label for="author_id" class="block text-sm font-medium text-gray-700">Author</label>
                <select name="author_id" id="author_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <?php foreach ($authors as $author): ?>
                        <option value="<?= $author->id ?>"><?= $author->first_name ?> <?= $author->last_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="currency_id" class="block text-sm font-medium text-gray-700">Currency</label>
                <select id="currency_id" name="currency_id" onChange="showCurrency()" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Please select</option>
                    <?php foreach ($currencies as $currency): ?>
                        <option value="<?= $currency->id ?>" data-iso="<?= $currency->iso ?>"><?= $currency->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price <span id="selectedCurrency" class="text-gray-500"></span></label>
                <input type="text" name="price" id="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
            </div>
            <div class="text-right">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create
                </button>
            </div>
        </form>
    </div>
</body>
</html>
