<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} Admin</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/admin-app.css', 'resources/js/admin-app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <x-admin.ui.toast />
        
        <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden bg-gray-50">

            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 z-20 bg-gray-900/50 md:hidden">
            </div>

            <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                 class="fixed inset-y-0 left-0 z-30 transition-transform duration-300 ease-in-out md:relative md:translate-x-0">
                 
                 <x-admin.layouts.sidebar />
            </div>

            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
                
                <div class="flex items-center justify-between p-4 bg-white border-b border-gray-100 md:hidden shadow-sm z-10 sticky top-0">
                    <div class="flex items-center font-bold text-lg tracking-tight text-gray-900">
                        Kode<span class="text-primary">byte</span>
                    </div>
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-gray-500 rounded-md hover:bg-gray-100 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                @if (isset($header))
                    <header class="bg-white border-b border-gray-100 shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main class="flex-1">
                    <div class="py-6 md:py-8"> <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            @if(session('error'))
                                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm font-medium flex items-center shadow-sm">
                                    <svg class="w-5 h-5 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ session('error') }}
                                </div>
                            @endif

                            {{ $slot }}
                        </div>
                    </div>
                </main>

                <div class="py-4 text-center text-xs text-gray-400 border-t border-gray-100 mt-auto">
                    &copy; {{ date('Y') }} PT. Kodebyte Inti Teknologi
                </div>
            </div>
        </div>
    </body>
</html>