@extends('layouts.app')

@section('content')
    <div class="col-span-12 mt-8">
        <div class="intro-y flex h-10 items-center">
            <h2 class="mr-5 truncate text-lg font-medium">General Report</h2>
        </div>
        <div class="mt-5 grid grid-cols-12 gap-6">
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div
                    class="relative zoom-in before:box before:absolute before:inset-x-3 before:mt-3 before:h-full before:bg-slate-50 before:content-['']">
                    <div class="box p-5">
                        <div class="flex">
                            <i data-tw-merge="" data-lucide="credit-card"
                                class="stroke-1.5 h-[28px] w-[28px] text-pending"></i>
                        </div>
                        <div class="mt-6 text-3xl font-medium leading-8">{{ $totalAccount }}</div>
                        <div class="mt-1 text-base text-slate-500">Total Akun TikTok</div>
                    </div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div
                    class="relative zoom-in before:box before:absolute before:inset-x-3 before:mt-3 before:h-full before:bg-slate-50 before:content-['']">
                    <div class="box p-5">
                        <div class="flex">
                            <i data-tw-merge="" data-lucide="credit-card"
                                class="stroke-1.5 h-[28px] w-[28px] text-pending"></i>
                        </div>
                        <div class="mt-6 text-3xl font-medium leading-8">{{ $totalSearch }}</div>
                        <div class="mt-1 text-base text-slate-500">Total Pencarian</div>
                    </div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div
                    class="relative zoom-in before:box before:absolute before:inset-x-3 before:mt-3 before:h-full before:bg-slate-50 before:content-['']">
                    <div class="box p-5">
                        <div class="flex">
                            <i data-tw-merge="" data-lucide="credit-card"
                                class="stroke-1.5 h-[28px] w-[28px] text-pending"></i>
                        </div>
                        <div class="mt-6 text-3xl font-medium leading-8">{{ $totalResult }}</div>
                        <div class="mt-1 text-base text-slate-500">
                            Total Scrap
                        </div>
                    </div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div
                    class="relative zoom-in before:box before:absolute before:inset-x-3 before:mt-3 before:h-full before:bg-slate-50 before:content-['']">
                    <div class="box p-5">
                        <div class="flex">
                            <i data-tw-merge="" data-lucide="credit-card"
                                class="stroke-1.5 h-[28px] w-[28px] text-pending"></i>
                        </div>
                        <div class="mt-6 text-3xl font-medium leading-8">{{ $totalVideo }}</div>
                        <div class="mt-1 text-base text-slate-500">
                            Total Video Tiktok
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    </div>
                </div>
            </div>
            <div class="mt-5 grid grid-cols-12 gap-6">
                <div id="videos-container" class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <div id="loading-spinner" class="hidden text-center">
                        <svg role="status" class="inline w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.59C100 78.21 77.61 100.6 50 100.6 22.39 100.6 0 78.21 0 50.59 0 22.98 22.39 0.59 50 0.59 77.61 0.59 100 22.98 100 50.59zM9.081 50.59C9.081 73.92 26.67 91.51 50 91.51 73.33 91.51 90.92 73.92 90.92 50.59 90.92 27.26 73.33 9.669 50 9.669 26.67 9.669 9.081 27.26 9.081 50.59z"
                                fill="currentColor" />
                            <path d="M93.967 39.04c2.384-.637 3.813-3.092 3.062-5.465-1.69-5.317-4.457-10.304-8.159-14.623C85.239 14.58 80.534 11.092 75.09 8.954 69.648 6.816 63.69 6.149 57.869 6.988c-2.444.348-4.049 2.585-3.484 5.046.564 2.46 2.79 4.005 5.234 3.658 4.45-.635 8.978-.067 13.032 1.63 4.053 1.696 7.65 4.447 10.296 7.997 2.648 3.55 4.469 7.71 5.264 12.162.497 2.4 2.88 3.796 5.435 3.062z"
                                fill="currentFill" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function performSearch() {
                var keywords = $('#search-keywords').val();
                $('#loading-spinner').removeClass('hidden');
                $.ajax({
                    url: "{{ route('tiktok.search') }}",
                    method: 'GET',
                    data: {
                        keywords: keywords
                    },
                    success: function(data) {
                        var resultsHtml = '<table class="w-full text-left -mt-2 border-separate border-spacing-y-[10px]">';
                        resultsHtml += '<thead><tr>';
                        resultsHtml += '<tr><td colspan="6" class="text-center py-5">Berhasil mengambil data '+ keywords +' dengan total data ' + data.cursor +'</td></tr>';
    
                        resultsHtml += '</tbody></table>';
                        $('#videos-container').html(resultsHtml);
                        $('#loading-spinner').addClass('hidden');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        $('#loading-spinner').addClass('hidden');
                    }
                });
            }
    
            $('#search-button').click(performSearch);
    
            $('#search-keywords').keypress(function(e) {
                if (e.which == 13) {
                    performSearch();
                }
            });
        });
    </script>
@endsection
