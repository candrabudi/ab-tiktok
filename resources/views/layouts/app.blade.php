<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" class="opacity-0" lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="ceKdwoQjZ4VuoGqoSQaSREwB7MD9sjwFnfhlp7MH">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, midone Admin Template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="LEFT4CODE">
    <title>@yield('title') | Mager Tools</title>
    <link rel="stylesheet" href="{{ asset('dist/css/vendors/tippy.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/vendors/litepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/vendors/tiny-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/themes/enigma/side-nav.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/vendors/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/vendors/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/components/mobile-menu.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"
        integrity="sha512-EKWWs1ZcA2ZY9lbLISPz8aGR2+L7JVYqBAYTq5AXgBkSjRSuQEGqWx8R1zAX16KdXPaCjOCaKE8MCpU0wcHlHA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div
        class="enigma py-5 px-5 md:py-0 sm:px-8 md:px-0 before:content-[''] before:bg-gradient-to-b before:from-theme-1 before:to-theme-2 dark:before:from-darkmode-800 dark:before:to-darkmode-800 md:before:bg-none md:bg-slate-200 md:dark:bg-darkmode-800 before:fixed before:inset-0 before:z-[-1]">
        @include('layouts.partials.mobile_menu')
        <div
            class="h-[70px] md:h-[65px] z-[51] border-b border-white/[0.08] mt-12 md:mt-0 -mx-5 sm:-mx-8 md:-mx-0 px-3 md:border-b-0 relative md:fixed md:inset-x-0 md:top-0 sm:px-8 md:px-10 md:pt-10 md:bg-gradient-to-b md:from-slate-100 md:to-transparent dark:md:from-darkmode-700 before:content-[''] before:absolute before:h-[65px] before:inset-0 before:top-0 before:mx-7 before:bg-primary/30 before:mt-3 before:rounded-xl before:hidden before:md:block before:dark:bg-darkmode-600/30 after:content-[''] after:absolute after:inset-0 after:h-[65px] after:mx-3 after:bg-primary after:mt-5 after:rounded-xl after:shadow-md after:hidden after:md:block after:dark:bg-darkmode-600">
            <div class="flex h-full items-center">
                <a href="#" class="-intro-x hidden md:flex xl:w-[180px]">
                    <img class="w-6" src="https://cdn-icons-png.flaticon.com/512/3437/3437352.png" alt="Enigma Tailwind HTML Admin Template">
                    <span class="ml-3 text-lg text-white hidden xl:block">
                        Mager Tools
                    </span>
                </a>
                <nav aria-label="breadcrumb"
                    class="flex h-[45px] md:ml-10 md:border-l border-white/[0.08] dark:border-white/[0.08] mr-auto -intro-x md:pl-6">
                </nav>
                <div data-tw-merge="" data-tw-placement="bottom-end" class="dropdown relative"><button
                        data-tw-toggle="dropdown" aria-expanded="false"
                        class="cursor-pointer image-fit zoom-in intro-x block h-8 w-8 scale-110 overflow-hidden rounded-full shadow-lg"><img
                            src="dist/images/fakers/profile-12.jpg" alt="Midone Tailwind HTML Admin Template">
                    </button>
                    <div data-transition="" data-selector=".show" data-enter="transition-all ease-linear duration-150"
                        data-enter-from="absolute !mt-5 invisible opacity-0 translate-y-1"
                        data-enter-to="!mt-1 visible opacity-100 translate-y-0"
                        data-leave="transition-all ease-linear duration-150"
                        data-leave-from="!mt-1 visible opacity-100 translate-y-0"
                        data-leave-to="absolute !mt-5 invisible opacity-0 translate-y-1"
                        class="dropdown-menu absolute z-[9999] hidden">
                        <div data-tw-merge=""
                            class="dropdown-content rounded-md border-transparent p-2 shadow-[0px_3px_10px_#00000017] dark:border-transparent dark:bg-darkmode-600 relative mt-px w-56 bg-theme-1/80 text-white before:absolute before:inset-0 before:z-[-1] before:block before:rounded-md before:bg-black">
                            <div class="p-2 font-medium font-normal">
                                <div class="font-medium">{{ Auth::user()->name }}</div>
                            </div>
                            <div class="h-px my-2 -mx-2 bg-slate-200/60 dark:bg-darkmode-400 bg-white/[0.08]">
                            </div>
                            <a
                                class="cursor-pointer flex items-center p-2 transition duration-300 ease-in-out rounded-md hover:bg-slate-200/60 dark:bg-darkmode-600 dark:hover:bg-darkmode-400 dropdown-item hover:bg-white/5"><i
                                    data-tw-merge="" data-lucide="toggle-right" class="stroke-1.5 mr-2 h-4 w-4"></i>
                                Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex overflow-hidden">
            @include('layouts.partials.side_menu')
            <div
                class="max-w-full md:max-w-none rounded-[30px] md:rounded-none px-4 md:px-[22px] min-w-0 min-h-screen bg-slate-100 flex-1 md:pt-20 pb-10 mt-5 md:mt-1 relative dark:bg-darkmode-700 before:content-[''] before:w-full before:h-px before:block">
                
                    @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('dist/js/vendors/dom.js') }}"></script>
    <script src="{{ asset('dist/js/vendors/tailwind-merge.js') }}"></script>
    <script src="{{ asset('dist/js/vendors/lucide.js') }}"></script>
    <script src="{{ asset('dist/js/vendors/tippy.js') }}"></script>
    <script src="{{ asset('dist/js/vendors/dayjs.js') }}"></script>
    <script src="{{ asset('dist/js/vendors/litepicker.js') }}"></script>
    <script src="{{ asset('dist/js/vendors/popper.js') }}"></script>
    <script src="{{ asset('dist/js/vendors/dropdown.js') }}"></script>
    <script src="{{ asset('dist/js/vendors/tiny-slider.js') }}"></script>
    <script src="{{ asset('dist/js/vendors/transition.js') }}"></script>
    <script src="{{ asset('dist/js/vendors/chartjs.js') }}"></script>
    <script src="{{ asset('dist/js/vendors/leaflet-map.js') }}"></script>
    <script src="{{ asset('dist/js/vendors/axios.js') }}"></script>
    <script src="{{ asset('dist/js/utils/colors.js') }}"></script>
    <script src="{{ asset('dist/js/utils/helper.js') }}"></script>
    <script src="{{ asset('dist/js/vendors/simplebar.js') }}"></script>
    <script src="{{ asset('dist/js/vendors/modal.js') }}"></script>
    <script src="{{ asset('dist/js/components/base/theme-color.js') }}"></script>
    <script src="{{ asset('dist/js/components/base/lucide.js') }}"></script>
    <script src="{{ asset('dist/js/components/base/tippy.js') }}"></script>
    <script src="{{ asset('dist/js/components/base/litepicker.js') }}"></script>
    <script src="{{ asset('dist/js/components/report-line-chart.js') }}"></script>
    <script src="{{ asset('dist/js/components/report-pie-chart.js') }}"></script>
    <script src="{{ asset('dist/js/components/report-donut-chart.js') }}"></script>
    <script src="{{ asset('dist/js/components/report-donut-chart-1.js') }}"></script>
    <script src="{{ asset('dist/js/components/simple-line-chart-1.js') }}"></script>
    <script src="{{ asset('dist/js/components/base/tiny-slider.js') }}"></script>
    <script src="{{ asset('dist/js/themes/enigma.js') }}"></script>
    <script src="{{ asset('dist/js/components/base/leaflet-map-loader.js') }}"></script>
    <script src="{{ asset('dist/js/components/mobile-menu.js') }}"></script>
    <script src="{{ asset('dist/js/components/themes/enigma/top-bar.js') }}"></script>
    @yield('scripts')
</body>
</html>
