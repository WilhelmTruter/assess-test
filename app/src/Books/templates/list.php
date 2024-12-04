<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        let currentPage = 1;
        const limit = 10;

        // Fetch books with pagination
        async function fetchBooks(page) {
            try {
                const response = await fetch(`http://api.localtest.me:8080/books?page=${page}&limit=${limit}`);
                const data = await response.json();
                console.log(data);
                if (!data.books || !data.pagination) {
                    console.error("Invalid API response:", data);
                    return;
                }

                const booksTable = document.getElementById('booksTable');
                booksTable.innerHTML = ''; // Clear previous data

                data.books.forEach(book => {
                    const row = `
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">${book.title}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">${book.author?.first_name ?? 'Unknown'} ${book.author?.last_name ?? ''}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">${book.iso} ${book.price}</td>
                        </tr>
                    `;
                    booksTable.insertAdjacentHTML('beforeend', row);
                });

                // Update pagination controls
                updatePaginationControls(data.pagination);
            } catch (error) {
                console.error("Error fetching books:", error);
            }
        }

        // Update pagination controls
        function updatePaginationControls(pagination) {
            const paginationControls = document.getElementById('paginationControls');
            paginationControls.innerHTML = ''; // Clear previous controls

            if (pagination.current_page > 1) {
                paginationControls.innerHTML += `
                    <button onclick="changePage(${pagination.current_page - 1})" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Previous
                    </button>
                `;
            }

            if (pagination.current_page < pagination.total_pages) {
                paginationControls.innerHTML += `
                    <button onclick="changePage(${pagination.current_page + 1})" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Next
                    </button>
                `;
            }
        }

        // Change page
        function changePage(page) {
            currentPage = page;
            fetchBooks(currentPage);
        }

        // Initial fetch
        document.addEventListener('DOMContentLoaded', () => {
            fetchBooks(currentPage);
        });
    </script>
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-700 mb-6">Books List</h1>
        <table class="min-w-full table-auto border-collapse border border-gray-200 rounded-lg overflow-hidden shadow">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Author</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Price</th>
                </tr>
            </thead>
            <tbody id="booksTable">
                <!-- Books will be dynamically inserted here -->
            </tbody>
        </table>
        <div id="paginationControls" class="mt-6 flex justify-between">
            <!-- Pagination controls will be dynamically inserted here -->
        </div>
    </div>
</body>
</html>
