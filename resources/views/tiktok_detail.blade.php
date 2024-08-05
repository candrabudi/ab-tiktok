@extends('layouts.app')

@section('content')
    <div class="intro-y box mt-5 px-5 pt-5">
        <div class="-mx-5 flex flex-col border-b border-slate-200/60 pb-5 dark:border-darkmode-400 lg:flex-row">
            <div class="flex flex-1 items-center justify-center px-5 lg:justify-start">
                <div class="image-fit relative h-20 w-20 flex-none sm:h-24 sm:w-24 lg:h-32 lg:w-32">
                    <img class="rounded-full" src="{{ $tiktokResult->avatar_thumb }}"
                        alt="{{ $tiktokResult->nickname }}">
                </div>
                <div class="ml-5">
                    <div class="w-24 truncate text-lg font-medium sm:w-40 sm:whitespace-normal">
                        {{ $tiktokResult->nickname }}
                    </div>
                    <div class="text-slate-500">{{ $tiktokResult->unique_id }}</div>
                </div>
            </div>
            <div
                class="mt-6 flex-1 border-l border-r border-t border-slate-200/60 px-5 pt-5 dark:border-darkmode-400 lg:mt-0 lg:border-t-0 lg:pt-0">
                <div class="text-center font-medium lg:mt-3 lg:text-left">
                    Detail Akun
                </div>
                <div class="mt-4 flex flex-col items-center justify-center lg:items-start">
                    <div class="flex items-center truncate sm:whitespace-normal">
                        <i data-tw-merge="" data-lucide="mail" class="stroke-1.5 mr-2 h-4 w-4"></i>
                        {{ $tiktokResult->followers }}
                    </div>
                    <div class="mt-3 flex items-center truncate sm:whitespace-normal">
                        <i data-tw-merge="" data-lucide="instagram" class="stroke-1.5 mr-2 h-4 w-4"></i>
                        {{ $tiktokResult->likes }} 
                    </div>
                    <div class="mt-3 flex items-center truncate sm:whitespace-normal">
                        <i data-tw-merge="" data-lucide="twitter" class="stroke-1.5 mr-2 h-4 w-4"></i>
                        {{ $tiktokResult->total_video }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
