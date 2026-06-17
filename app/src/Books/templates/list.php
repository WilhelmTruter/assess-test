<?php
/**
 * @var array $books
 * @var array $pagination
 */

// Build page range with ellipsis markers (null = ellipsis)
$pages       = [];
$currentPage = (int) ($pagination['current_page'] ?? 1);
$lastPage    = (int) ($pagination['last_page']    ?? 1);
$window      = 2;

for ($i = 1; $i <= $lastPage; $i++) {
    if ($i === 1 || $i === $lastPage || abs($i - $currentPage) <= $window) {
        $pages[] = $i;
    }
}

$pageRange = [];
$prev      = null;
foreach ($pages as $p) {
    if ($prev !== null && $p - $prev > 1) {
        $pageRange[] = null; // ellipsis
    }
    $pageRange[] = $p;
    $prev = $p;
}
?>

<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Book Catalogue</h1>
            <p class="mt-1 text-sm text-slate-500">
                <?= (int) ($pagination['total'] ?? 0) ?> titles available
            </p>
        </div>
        <a href="/books/create"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors duration-150">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Book
        </a>
    </div>

    <!-- Empty state -->
    <?php if (empty($books)): ?>
        <div class="text-center py-20 bg-white rounded-2xl border border-slate-200">
            <p class="text-slate-400 text-sm">No books found.</p>
            <a href="/books/create"
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
                        <th class="text-left px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-widest">Title</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-widest">Author</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-widest">Price</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($books as $book): ?>
                        <tr class="hover:bg-slate-50 transition-colors duration-100">
                            <td class="px-6 py-4 font-medium text-slate-900">
                                <?= htmlspecialchars($book['title']) ?>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                <?= htmlspecialchars($book['first_name']) ?>
                                <?= htmlspecialchars($book['last_name']) ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex items-center justify-end gap-1.5">
                                    <span class="text-xs font-medium text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">
                                        <?= htmlspecialchars($book['iso']) ?>
                                    </span>
                                    <span class="font-semibold text-slate-900">
                                        <?= number_format((float) $book['price'], 2) ?>
                                    </span>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if ($lastPage > 1): ?>
                <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between gap-4">

                    <!-- Results info -->
                    <p class="text-sm text-slate-500 shrink-0">
                        Showing
                        <span class="font-medium text-slate-900"><?= (int) $pagination['from'] ?></span>
                        –
                        <span class="font-medium text-slate-900"><?= (int) $pagination['to'] ?></span>
                        of
                        <span class="font-medium text-slate-900"><?= (int) $pagination['total'] ?></span>
                    </p>

                    <!-- Controls -->
                    <div class="flex items-center gap-1">

                        <!-- Previous -->
                        <?php if ($currentPage > 1): ?>
                            <a href="?page=<?= $currentPage - 1 ?>"
                               class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-colors duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </a>
                        <?php else: ?>
                            <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-slate-300 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </span>
                        <?php endif; ?>

                        <!-- Page numbers -->
                        <?php foreach ($pageRange as $p): ?>
                            <?php if ($p === null): ?>
                                <span class="inline-flex items-center justify-center w-9 h-9 text-sm text-slate-400">
                                    &hellip;
                                </span>
                            <?php elseif ($p === $currentPage): ?>
                                <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-slate-900 text-white text-sm font-medium">
                                    <?= $p ?>
                                </span>
                            <?php else: ?>
                                <a href="?page=<?= $p ?>"
                                   class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-sm text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-colors duration-150">
                                    <?= $p ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <!-- Next -->
                        <?php if ($currentPage < $lastPage): ?>
                            <a href="?page=<?= $currentPage + 1 ?>"
                               class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-colors duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 5l7 7-7 7"/>
                                </svg>
                            </a>
                        <?php else: ?>
                            <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-slate-300 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 5l7 7-7 7"/>
                                </svg>
                            </span>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

</div>