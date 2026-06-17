<?php
/**
 * @var array $authors
 */
?>

<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Authors</h1>
            <p class="mt-1 text-sm text-slate-500"><?= count($authors) ?> authors in the catalogue</p>
        </div>
        <a href="/authors/create"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors duration-150">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Author
        </a>
    </div>

    <!-- Empty state -->
    <?php if (empty($authors)): ?>
        <div class="text-center py-20 bg-white rounded-2xl border border-slate-200">
            <p class="text-slate-400 text-sm">No authors found.</p>
            <a href="/authors/create"
               class="mt-4 inline-block text-sm font-medium text-slate-900 underline underline-offset-2">
                Add the first one
            </a>
        </div>

    <!-- Table -->
    <?php else: ?>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <th class="text-left px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-widest">
                            Author
                        </th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-widest">
                            First Name
                        </th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-widest">
                            Last Name
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($authors as $author): ?>
                        <tr class="hover:bg-slate-50 transition-colors duration-100">

                            <!-- Initials badge -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold shrink-0">
                                        <?= htmlspecialchars(mb_substr($author['first_name'], 0, 1)) ?>
                                        <?= htmlspecialchars(mb_substr($author['last_name'], 0, 1)) ?>
                                    </span>
                                    <span class="font-medium text-slate-900">
                                        <?= htmlspecialchars($author['first_name']) ?>
                                        <?= htmlspecialchars($author['last_name']) ?>
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-slate-500">
                                <?= htmlspecialchars($author['first_name']) ?>
                            </td>

                            <td class="px-6 py-4 text-slate-500">
                                <?= htmlspecialchars($author['last_name']) ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>