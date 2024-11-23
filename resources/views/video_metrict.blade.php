@extends('layouts.app')

@section('content')
    <div class="col-span-12 mt-6 xl:col-span-12">
        <div class="intro-y box mt-12 p-5 sm:mt-5" id="search-results">
            <form id="videoMetricsForm">
                <div class="relative w-full text-slate-500">
                    <textarea id="tiktokUrls"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800/50 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80 group-[.form-inline]:flex-1 group-[.input-group]:rounded-none group-[.input-group]:[&:not(:first-child)]:border-l-transparent group-[.input-group]:first:rounded-l group-[.input-group]:last:rounded-r group-[.input-group]:z-10"
                        cols="30" rows="10" style="resize: none;" placeholder="Masukkan URL TikTok, satu per baris..."></textarea>
                    <div class="mt-2 flex items-center">
                        <button type="button" id="processButton"
                            class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary"
                            disabled>
                            Process
                        </button>
                        <div id="processCount" class="ml-4 text-sm text-slate-500 dark:text-slate-400"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const processButton = document.getElementById('processButton');
        const textarea = document.getElementById('tiktokUrls');
        const processCount = document.getElementById('processCount');

        textarea.addEventListener('input', () => {
            processButton.disabled = textarea.value.trim() === '';
        });

        processButton.addEventListener('click', async () => {
            const urls = textarea.value.trim().split('\n');
            const endpoint = '/api/video-metrics';

            if (urls.length === 0) {
                alert('Textarea is empty. Please enter TikTok URLs.');
                return;
            }

            textarea.disabled = true;
            processButton.disabled = true;

            let processedCount = 0;
            processCount.innerText = `Processing 0 of ${urls.length}`;

            try {
                for (const [index, url] of urls.entries()) {
                    if (url.trim() === '') continue; // Skip empty lines

                    await axios.post(endpoint, {
                        tiktok_url: url.trim()
                    });

                    processedCount++;
                    processCount.innerText = `Processing ${processedCount} of ${urls.length}`;
                }

                alert('All URLs have been processed successfully.');
            } catch (error) {
                console.error('Error processing URLs:', error);
                alert('Failed to process some URLs. Check console for details.');
            } finally {
                // Enable textarea and button after completion
                textarea.disabled = false;
                processButton.disabled = false;

                // Clear textarea and process count
                textarea.value = '';
                processCount.innerText = '';
            }
        });
    </script>


    <div class="col-span-12 mt-6 xl:col-span-12">
        <div class="intro-y box mt-12 p-5 sm:mt-5" id="search-results">
            <div class="mt-5 grid grid-cols-12 gap-6">
                <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
                    <div class="mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto md:ml-0">
                        <div class="relative w-56 text-slate-500">
                            <input id="search-keywords" type="text" placeholder="Search..."
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80 group-[.form-inline]:flex-1 group-[.input-group]:rounded-none group-[.input-group]:[&amp;:not(:first-child)]:border-l-transparent group-[.input-group]:first:rounded-l group-[.input-group]:last:rounded-r group-[.input-group]:z-10 !box w-56 pr-10">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" data-lucide="search"
                                class="lucide lucide-search stroke-1.5 absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </div>
                        <a href="{{ route('export.videomatrics') }}"
                            class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary mt-2"
                            disabled>
                            Export Video Matrics
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-5 grid grid-cols-12 gap-6">
                <div id="videos-container" class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                        <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
                            <select id="per-page"
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 group-[.form-inline]:flex-1 !box mt-3 w-20 sm:mt-0"
                                style="margin-bottom: 30px;">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="35">35</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <table id="products-table" data-tw-merge=""
                            class="w-full text-left -mt-2 border-separate border-spacing-y-[10px]">
                            <thead data-tw-merge="" class="">
                                <tr data-tw-merge="" class="">
                                    <th data-tw-merge=""
                                        class="font-medium px-5 py-3 dark:border-darkmode-300 whitespace-nowrap border-b-0">
                                        Link Video
                                    </th>
                                    <th data-tw-merge=""
                                        class="font-medium px-5 py-3 dark:border-darkmode-300 whitespace-nowrap border-b-0">
                                        Views
                                    </th>
                                    <th data-tw-merge=""
                                        class="font-medium px-5 py-3 dark:border-darkmode-300 whitespace-nowrap border-b-0">
                                        Like
                                    </th>
                                    <th data-tw-merge=""
                                        class="font-medium px-5 py-3 dark:border-darkmode-300 whitespace-nowrap border-b-0">
                                        Comment
                                    </th>
                                    <th data-tw-merge=""
                                        class="font-medium px-5 py-3 dark:border-darkmode-300 whitespace-nowrap border-b-0">
                                        Share
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
                            <nav class="w-full sm:mr-auto sm:w-auto">
                                <ul id="pagination" class="flex w-full mr-0 sm:mr-auto sm:w-auto">

                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div id="loading-spinner" class="hidden text-center">
                        <svg role="status"
                            class="inline w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
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
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateDataButton = document.getElementById('update-data-button');
            const tableBody = document.querySelector('#products-table tbody');
            const loadingSpinner = document.getElementById('loading-spinner');
            const paginationContainer = document.getElementById('pagination');
            const perPageSelect = document.getElementById('per-page');

            let page = 1;
            let perPage = perPageSelect.value;
            let totalPages = 0;
            let nextPageUrl = null;
            let prevPageUrl = null;

            const updatePagination = () => {
                paginationContainer.innerHTML = '';

                if (prevPageUrl) {
                    const prevButton = document.createElement('li');
                    prevButton.innerHTML =
                        `<a class="transition duration-200 border items-center justify-center py-2 rounded-md cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed min-w-0 sm:min-w-[40px] shadow-none font-normal flex border-transparent text-slate-800 sm:mr-2 dark:text-slate-300 px-1 sm:px-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="chevron-left" class="lucide lucide-chevron-left stroke-1.5 h-4 w-4"><path d="m15 18-6-6 6-6"></path></svg></a>`;
                    prevButton.addEventListener('click', () => {
                        if (prevPageUrl) {
                            page--;
                            loadData(prevPageUrl);
                        }
                    });
                    paginationContainer.appendChild(prevButton);
                }

                const maxPagesToShow = 5;
                const pageRange = Math.min(maxPagesToShow, totalPages);
                let startPage = Math.max(1, page - Math.floor(maxPagesToShow / 2));
                let endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);

                if (endPage - startPage + 1 < maxPagesToShow && startPage > 1) {
                    startPage = Math.max(1, endPage - maxPagesToShow + 1);
                }

                if (startPage > 1) {
                    const firstPage = document.createElement('li');
                    firstPage.innerHTML =
                        `<a class="transition duration-200 border items-center justify-center py-2 rounded-md cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed min-w-0 sm:min-w-[40px] shadow-none font-normal flex border-transparent text-slate-800 sm:mr-2 dark:text-slate-300">1</a>`;
                    firstPage.addEventListener('click', () => {
                        page = 1;
                        loadData(`{{ route('tiktok.load.scrap.username') }}?page=${page}`);
                    });
                    paginationContainer.appendChild(firstPage);

                    const ellipsis = document.createElement('li');
                    ellipsis.innerHTML =
                        `<span class="transition duration-200 border items-center justify-center py-2 rounded-md cursor-pointer disabled:opacity-70 disabled:cursor-not-allowed min-w-0 sm:min-w-[40px] shadow-none font-normal flex border-transparent text-slate-800 sm:mr-2 dark:text-slate-300">...</span>`;
                    paginationContainer.appendChild(ellipsis);
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageItem = document.createElement('li');
                    pageItem.innerHTML =
                        `<a class="transition duration-200 border items-center justify-center py-2 rounded-md cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed min-w-0 sm:min-w-[40px] shadow-none font-normal flex border-transparent text-slate-800 sm:mr-2 dark:text-slate-300 ${i === page ? '!box dark:bg-darkmode-400' : ''}">${i}</a>`;
                    pageItem.addEventListener('click', () => {
                        if (i !== page) {
                            page = i;
                            loadData(`{{ route('tiktok.load.scrap.username') }}?page=${page}`);
                        }
                    });
                    paginationContainer.appendChild(pageItem);
                }

                if (endPage < totalPages) {
                    const ellipsis = document.createElement('li');
                    ellipsis.innerHTML =
                        `<span class="transition duration-200 border items-center justify-center py-2 rounded-md cursor-pointer disabled:opacity-70 disabled:cursor-not-allowed min-w-0 sm:min-w-[40px] shadow-none font-normal flex border-transparent text-slate-800 sm:mr-2 dark:text-slate-300">...</span>`;
                    paginationContainer.appendChild(ellipsis);

                    const lastPage = document.createElement('li');
                    lastPage.innerHTML =
                        `<a class="transition duration-200 border items-center justify-center py-2 rounded-md cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed min-w-0 sm:min-w-[40px] shadow-none font-normal flex border-transparent text-slate-800 sm:mr-2 dark:text-slate-300">${totalPages}</a>`;
                    lastPage.addEventListener('click', () => {
                        page = totalPages;
                        loadData(`{{ route('tiktok.load.scrap.username') }}?page=${page}`);
                    });
                    paginationContainer.appendChild(lastPage);
                }

                if (nextPageUrl) {
                    const nextButton = document.createElement('li');
                    nextButton.innerHTML =
                        `<a class="transition duration-200 border items-center justify-center py-2 rounded-md cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed min-w-0 sm:min-w-[40px] shadow-none font-normal flex border-transparent text-slate-800 sm:mr-2 dark:text-slate-300 px-1 sm:px-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="chevron-right" class="lucide lucide-chevron-right stroke-1.5 h-4 w-4"><path d="m9 18 6-6-6-6"></path></svg></a>`;
                    nextButton.addEventListener('click', () => {
                        if (nextPageUrl) {
                            page++;
                            loadData(nextPageUrl);
                        }
                    });
                    paginationContainer.appendChild(nextButton);
                }
            };

            const loadData = async (url = `/load/video-metrics?page=${page}&perPage=${perPage}`) => {
                loadingSpinner.classList.remove('hidden');
                const response = await fetch(url);
                const data = await response.json();

                tableBody.innerHTML = '';
                data.data.forEach(search => {
                    const row = document.createElement('tr');
                    row.classList.add('intro-x');
                    row.innerHTML = `
                        <td data-tw-merge="" class="px-5 py-3 border-b dark:border-darkmode-300 box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            <a href="${search.tiktok_url}" target="_blank">${search.tiktok_url}</a>
                        </td>
                        <td data-tw-merge="" class="px-5 py-3 border-b dark:border-darkmode-300 box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            ${search.views}
                        </td>
                        <td data-tw-merge="" class="px-5 py-3 border-b dark:border-darkmode-300 box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            ${search.like}
                        </td>
                        <td data-tw-merge="" class="px-5 py-3 border-b dark:border-darkmode-300 box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            ${search.comment}
                        </td>
                        <td data-tw-merge="" class="px-5 py-3 border-b dark:border-darkmode-300 box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            ${search.share}
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                totalPages = Math.ceil(data.total / data.per_page);
                nextPageUrl = data.next_page_url;
                prevPageUrl = data.prev_page_url;

                updatePagination();
                loadingSpinner.classList.add('hidden');
            };

            perPageSelect.addEventListener('change', (event) => {
                perPage = event.target.value;
                page = 1;
                loadData();
            });

            loadData();

            function formatDate(dateString) {
                const options = {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                };
                const date = new Date(dateString);
                return date.toLocaleString('en-GB', options);
            }
        });
    </script>
@endsection
