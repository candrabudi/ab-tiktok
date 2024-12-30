@extends('layouts.app')

@section('content')
    <div class="col-span-12 mt-6 xl:col-span-12">
        <div class="intro-y box mt-12 p-5 sm:mt-5" id="search-results">
            <form id="videoMetricsForm">
                <div class="relative w-full text-slate-500">
                    <textarea id="tiktokUrls"
                        class="transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary dark:bg-darkmode-800"
                        cols="30" rows="10" style="resize: none;" placeholder="Masukkan URL TikTok, satu per baris..."></textarea>
                    <div class="mt-2 flex items-center">
                        <button type="button" id="processButton"
                            class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium bg-primary border-primary text-white"
                            disabled>
                            Process
                        </button>
                    </div>
                    <div id="progressText" class="mt-2 text-center">0% (0/0)</div>
                </div>
            </form>
        </div>
        <div id="videoMetricsTable" class="mt-4">
            <!-- Table will appear here -->
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div id="videos-container" class="intro-y box col-span-12 overflow-auto lg:overflow-visible mt-12 p-5 sm:mt-5">
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
                    <div class="flex items-center">
                        <select id="per-page"
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 transition duration-200 ease-in-out text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary dark:bg-darkmode-800 group-[.form-inline]:flex-1 !box sm:w-20"
                            style="margin-bottom: 30px;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="35">35</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <!-- Export to Excel Button aligned to the right -->
                    <div class="ml-auto flex items-center">
                        <button id="exportButton" type="button"
                            class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium bg-primary border-primary text-white">
                            Export to Excel
                        </button>
                    </div>
                </div>

                <table id="products-table" class="w-full text-left border-separate border-spacing-y-[10px]">
                    <thead>
                        <tr>
                            <th class="font-medium px-5 py-3 dark:border-darkmode-300 whitespace-nowrap border-b-0">
                                Link Video
                            </th>
                            <th class="font-medium px-5 py-3 dark:border-darkmode-300 whitespace-nowrap border-b-0">
                                Views
                            </th>
                            <th class="font-medium px-5 py-3 dark:border-darkmode-300 whitespace-nowrap border-b-0">
                                Likes
                            </th>
                            <th class="font-medium px-5 py-3 dark:border-darkmode-300 whitespace-nowrap border-b-0">
                                Comments
                            </th>
                            <th class="font-medium px-5 py-3 dark:border-darkmode-300 whitespace-nowrap border-b-0">
                                Shares
                            </th>
                            <th class="font-medium px-5 py-3 dark:border-darkmode-300 whitespace-nowrap border-b-0">
                                Saved
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Content will be populated dynamically -->
                    </tbody>
                </table>
                <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
                    <nav class="w-full sm:mr-auto sm:w-auto">
                        <ul id="pagination" class="flex w-full mr-0 sm:mr-auto sm:w-auto">
                            <!-- Pagination links will go here -->
                        </ul>
                    </nav>
                </div>
            </div>
            <div id="loading-spinner" class="hidden text-center">
                <svg role="status" class="inline w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.59C100 78.21 77.61 100.6 50 100.6 22.39 100.6 0 78.21 0 50.59 0 22.98 22.39 0.59 50 0.59 77.61 0.59 100 22.98 100 50.59zM9.081 50.59C9.081 73.92 26.67 91.51 50 91.51 73.33 91.51 90.92 73.92 90.92 50.59 90.92 27.26 73.33 9.669 50 9.669 26.67 9.669 9.081 27.26 9.081 50.59z"
                        fill="currentColor" />
                    <path
                        d="M93.967 39.04c2.384-.637 3.813-3.092 3.062-5.465-1.69-5.317-4.457-10.304-8.159-14.623C85.239 14.58 80.534 11.092 75.09 8.954 69.648 6.816 63.69 6.149 57.869 6.988c-2.444.348-4.049 2.585-3.484 5.046.564 2.46 2.79 4.005 5.234 3.658 4.45-.635 8.978-.067 13.032 1.63 4.053 1.696 7.65 4.447 10.296 7.997 2.648 3.55 4.469 7.71 5.264 12.162.497 2.4 2.88 3.796 5.435 3.062z"
                        fill="currentFill" />
                </svg>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const processButton = document.getElementById('processButton');
        const textarea = document.getElementById('tiktokUrls');
        const videoMetricsTable = document.getElementById('videoMetricsTable');
        const perPageSelect = document.getElementById('per-page');
        const tableBody = document.querySelector('#products-table tbody');
        const pagination = document.getElementById('pagination');
        const progressText = document.getElementById('progressText');
        let currentPage = 1;
        let perPage = 10;
        let allVideoMetrics = [];

        function removeUnwantedParams(url) {
            const urlObj = new URL(url);
            urlObj.searchParams.delete("is_from_webapp");
            urlObj.searchParams.delete("sender_device");
            return urlObj.toString();
        }

        textarea.addEventListener('input', () => {
            processButton.disabled = textarea.value.trim() === '';
        });

        processButton.addEventListener('click', async () => {
            const urls = textarea.value.trim().split('\n');
            const apiUrl = 'https://tiktok-download-video1.p.rapidapi.com/getVideo';
            const headers = {
                'x-rapidapi-host': 'tiktok-download-video1.p.rapidapi.com',
                'x-rapidapi-key': '{{ $rapidAPI->rapid_key }}',
            };

            if (urls.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Textarea is empty. Please enter TikTok URLs.'
                });
                return;
            }

            textarea.disabled = true;
            processButton.disabled = true;

            let processedCount = 0;
            let failedUrls = [];
            allVideoMetrics = [];
            progressText.innerText = `0% (0/${urls.length})`;

            try {
                for (const [index, url] of urls.entries()) {
                    if (url.trim() === '') continue;

                    const cleanedUrl = removeUnwantedParams(url.trim());

                    try {
                        const response = await axios.get(apiUrl, {
                            headers,
                            params: {
                                url: cleanedUrl,
                                hd: 1
                            }
                        });

                        const data = response.data.data;
                        console.log(data);
                        allVideoMetrics.push({
                            url: cleanedUrl,
                            views: data.play_count,
                            likes: data.digg_count,
                            comments: data.comment_count,
                            shares: data.share_count,
                            saves: data.collect_count,
                        });

                        processedCount++;
                        const percentage = Math.floor((processedCount / urls.length) * 100);
                        progressText.innerText = `${percentage}% (${processedCount}/${urls.length})`;

                    } catch (error) {
                        console.error('Error fetching TikTok data for URL:', cleanedUrl, error);
                        allVideoMetrics.push({
                            url: cleanedUrl,
                            views: 0,
                            likes: 0,
                            comments: 0,
                            shares: 0,
                        });

                        failedUrls.push(url);
                    }
                }
                displayTable();
                textarea.value = '';
            } finally {
                textarea.disabled = false;
                processButton.disabled = false;
            }
        });

        function displayTable() {
            tableBody.innerHTML = ''; // Clear previous table content

            // Pagination logic
            const startIndex = (currentPage - 1) * perPage;
            const paginatedMetrics = allVideoMetrics.slice(startIndex, startIndex + perPage);

            paginatedMetrics.forEach(item => {
                const row = document.createElement('tr');
                row.classList.add('intro-x');

                row.innerHTML = `
                <td class="px-5 py-3 border-b dark:border-darkmode-300 box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">${item.url}</td>
                <td class="px-5 py-3 border-b dark:border-darkmode-300 box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">${item.views}</td>
                <td class="px-5 py-3 border-b dark:border-darkmode-300 box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">${item.likes}</td>
                <td class="px-5 py-3 border-b dark:border-darkmode-300 box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">${item.comments}</td>
                <td class="px-5 py-3 border-b dark:border-darkmode-300 box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">${item.shares}</td>
                <td class="px-5 py-3 border-b dark:border-darkmode-300 box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">${item.saves}</td>
            `;

                tableBody.appendChild(row);
            });

            updatePagination();
        }

        // Function to update pagination
        function updatePagination() {
            pagination.innerHTML = '';

            const totalPages = Math.ceil(allVideoMetrics.length / perPage);

            for (let i = 1; i <= totalPages; i++) {
                const pageItem = document.createElement('li');
                pageItem.classList.add('page-item');
                pageItem.innerHTML = `
                <button class="transition duration-200 border items-center justify-center py-2 rounded-md cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&:hover:not(:disabled)]:bg-opacity-90 [&:hover:not(:disabled)]:border-opacity-90 [&:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed min-w-0 sm:min-w-[40px] shadow-none font-normal flex border-transparent text-slate-800 sm:mr-2 dark:text-slate-300 px-1 sm:px-3 !box dark:bg-darkmode-400 page-link ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>
            `;
                pagination.appendChild(pageItem);
            }
        }

        // Function to change page
        function changePage(page) {
            currentPage = page;
            displayTable();
        }

        // Export table to Excel
        document.getElementById('exportButton').addEventListener('click', () => {
            const ws = XLSX.utils.json_to_sheet(allVideoMetrics); // Convert the video metrics to a sheet
            const wb = XLSX.utils.book_new(); // Create a new workbook
            XLSX.utils.book_append_sheet(wb, ws, 'TikTok Video Metrics'); // Append the sheet to the workbook
            XLSX.writeFile(wb, 'TikTok_Video_Metrics.xlsx'); // Write to file
        });
    </script>
@endsection
