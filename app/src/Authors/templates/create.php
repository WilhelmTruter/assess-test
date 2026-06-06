<?php
/**
 * @var string $title
 */
?>

<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-8">
        <a href="/authors"
           class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-900 transition-colors duration-150 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Authors
        </a>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">Add New Author</h1>
        <p class="mt-1 text-sm text-slate-500">Fill in the details to add an author to the catalogue.</p>
    </div>

    <!-- Form card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <form method="POST" action="/authors/create">

            <div class="divide-y divide-slate-100">

                <!-- First Name -->
                <div class="px-6 py-5 flex items-start gap-6">
                    <label for="first_name"
                           class="w-1/4 pt-2.5 text-sm font-medium text-slate-700 shrink-0">
                        First Name
                    </label>
                    <div class="flex-1">
                        <input
                            type="text"
                            id="first_name"
                            name="first_name"
                            placeholder="e.g. Ernest"
                            required
                            class="w-full px-3.5 py-2.5 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-lg placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
                        />
                    </div>
                </div>

                <!-- Last Name -->
                <div class="px-6 py-5 flex items-start gap-6">
                    <label for="last_name"
                           class="w-1/4 pt-2.5 text-sm font-medium text-slate-700 shrink-0">
                        Last Name
                    </label>
                    <div class="flex-1">
                        <input
                            type="text"
                            id="last_name"
                            name="last_name"
                            placeholder="e.g. Hemingway"
                            required
                            class="w-full px-3.5 py-2.5 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-lg placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition"
                        />
                    </div>
                </div>

            </div>

            <!-- Actions -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="/authors"
                   class="px-4 py-2.5 text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors duration-150">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Author
                </button>
            </div>

        </form>
    </div>

</div>