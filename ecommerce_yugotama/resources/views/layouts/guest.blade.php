<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Yugotama Mart') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:500,600,700&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-body antialiased min-h-screen bg-neutral-100 text-neutral-900">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
            <!-- Brand -->
            <div class="mb-8 text-center">
                <a href="/" class="inline-flex flex-col items-center gap-3 group">
                    <div class="w-16 h-16 rounded-2xl bg-primary-700 shadow-md flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-heading font-bold text-neutral-900 tracking-tight">Yugotama Mart</h1>
                        <p class="text-sm text-neutral-500 font-medium">Belanja Mudah & Hemat</p>
                    </div>
                </a>
            </div>

            <!-- Auth Card -->
            <div class="w-full max-w-md">
                <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 p-8 md:p-10">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-neutral-500">&copy; {{ date('Y') }} Yugotama Mart. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
