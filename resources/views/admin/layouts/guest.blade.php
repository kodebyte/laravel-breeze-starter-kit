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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 px-4">
            
            <div class="mb-6">
                <a href="/" class="flex items-center gap-2">
                    <div class="p-2 bg-gray-900 rounded-lg">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                        </svg>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-gray-900">
                        Kode<span class="text-primary">byte</span>
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md bg-white px-8 py-10 shadow-sm border border-gray-200 sm:rounded-2xl">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} PT. Kodebyte Inti Teknologi.
            </div>
        </div>
    </body>
</html>