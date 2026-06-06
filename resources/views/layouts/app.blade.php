<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
        </style>
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: window.innerWidth >= 768 }">
        <div class="flex min-h-screen relative overflow-hidden">
            
            @include('layouts.sidebar')

            <div x-show="sidebarOpen" @click="sidebarOpen = false" 
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm md:hidden" style="display: none;"></div>

            <div class="flex-1 flex flex-col min-w-0 transition-all duration-300" :class="sidebarOpen ? 'md:pl-64 pl-0' : 'md:pl-20 pl-0'">
                
                <header class="h-16 bg-white border-b border-slate-100 px-4 md:px-8 flex items-center justify-between shrink-0 z-30">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-slate-700 p-1.5 hover:bg-slate-100 rounded-lg transition">
                            <i class="fa-solid fa-bars text-xl"></i>
                        </button>
                        
                        @if (isset($header))
                            <div class="font-bold text-lg text-slate-800 tracking-tight hidden sm:block">
                                {{ $header }}
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] font-semibold text-indigo-600 uppercase tracking-wider mt-1">{{ Auth::user()->role }}</p>
                        </div>
                        <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                    </div>
                </header>

                <main class="flex-grow p-4 md:p-8">
                    {{ $slot }}
                </main>
            </div>

        </div>

        @livewireScripts
    </body>
</html>