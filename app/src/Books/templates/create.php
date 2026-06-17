<?php
/**
 * @var array  $authors
 * @var array  $currencies
 */
?>

<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-8">
        <a href="/books"
           class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-900 transition-colors duration-150 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Books
        </a>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">Add New Book</h1>
        <p class="mt-1 text-sm text-slate-500">Fill in the details to add a book to the catalogue.</p>
    </div>

    <!-- Form card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <form method="POST" action="/books/create">

            <div class="divide-y divide-slate-100">

                <!-- Title -->
                <div class="px-6 py-5 flex items-start gap-6">
                    <label for="title"
                           class="w-1/4 pt-2.5 text-sm font-medium text-slate-700 shrink-0">
                        Title
                    </label>
                    <div class="flex-1">
                        <input
                            type="text"
                            id="title"
                            name="title"
                            placeholder="e.g. The Great Gatsby"
                            required
                            class="w-full px-3.5 py-2.5 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-lg placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
                        />
                    </div>
                </div>

                <!-- Author -->
                <div class="px-6 py-5 flex items-start gap-6">
                    <label for="author_id"
                           class="w-1/4 pt-2.5 text-sm font-medium text-slate-700 shrink-0">
                        Author
                    </label>
                    <div class="flex-1">
                        <select
                            id="author_id"
                            name="author_id"
                            required
                            class="w-full px-3.5 py-2.5 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition appearance-none"
                        >
                            <option value="" disabled selected>Select an author</option>
                            <?php foreach ($authors as $author): ?>
                                <option value="<?= (int) $author['id'] ?>">
                                    <?= htmlspecialchars($author['first_name']) ?>
                                    <?= htmlspecialchars($author['last_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Price + Currency -->
                <div class="px-6 py-5 flex items-start gap-6">
                    <label class="w-1/4 pt-2.5 text-sm font-medium text-slate-700 shrink-0">
                        Price
                    </label>
                    <div class="flex-1 flex gap-3">

                        <!-- Currency -->
                        <select
                            id="currency_id"
                            name="currency_id"
                            required
                            class="w-28 px-3.5 py-2.5 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition appearance-none"
                        >
                            <option value="" disabled selected>CCY</option>
                            <?php foreach ($currencies as $currency): ?>
                                <option value="<?= (int) $currency['id'] ?>">
                                    <?= htmlspecialchars($currency['iso']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Amount -->
                        <input
                            type="number"
                            id="price"
                            name="price"
                            placeholder="0.00"
                            step="0.01"
                            min="0"
                            required
                            class="flex-1 px-3.5 py-2.5 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-lg placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
                        />
                    </div>
                </div>

            </div>

            <!-- Actions -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="/books"
                   class="px-4 py-2.5 text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors duration-150">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Book
                </button>
            </div>

        </form>
    </div>

</div>