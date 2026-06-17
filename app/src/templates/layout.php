<!-- src/templates/layout.php -->
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'BookShelf') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex flex-col bg-slate-50 text-slate-900 antialiased">

    <!-- Nav -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Brand -->
                <a href="/" class="flex items-center gap-2 font-bold text-slate-900 tracking-tight">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    BookShelf
                </a>

                <!-- Nav links -->
                <nav class="flex items-center gap-6">
                    <a href="/books"
                       class="text-sm text-slate-500 hover:text-slate-900 transition-colors duration-150">
                        Books
                    </a>
                    <a href="/authors"
                        class="text-sm text-slate-500 hover:text-slate-900 transition-colors duration-150">
                        Authors
                    </a>
                    <a href="/books/create"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors duration-150">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Book
                    </a>
                </nav>

            </div>
        </div>
    </header>

    <!-- Page content -->
    <main class="flex-1">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex items-center justify-between">
            <span class="text-xs text-slate-400">© <?= date('Y') ?> BookShelf</span>
            <span class="text-xs text-slate-300">Built with Slim Framework</span>
        </div>
    </footer>

</body>
</html>