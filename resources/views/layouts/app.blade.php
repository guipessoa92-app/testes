<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- PWA & Favicon -->
        <link rel="manifest" href="{{ asset('manifest.json') }}" crossorigin="use-credentials">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png?v=2') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            @if (session('success'))
                <div x-data="{ show: true }"
                     x-init="setTimeout(() => show = false, 4000)"
                     x-show="show"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed top-24 right-5 bg-green-500 text-white py-2 px-4 rounded-xl text-sm shadow-lg z-50"
                >
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            <main>
                {{ $slot }}
            </main>
        </div>
        @stack('scripts')
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js').then(registration => {
                        console.log('Service Worker registrado com sucesso:', registration);
                    }).catch(error => {
                        console.log('Falha ao registrar o Service Worker:', error);
                    });
                });
            }
        </script>
    </body>
</html>
