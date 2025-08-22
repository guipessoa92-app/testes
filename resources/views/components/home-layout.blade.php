{{-- Arquivo: resources/views/layouts/home-layout.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FitApp') }}</title>

        <!-- PWA & Favicon -->
        <link rel="manifest" href="/manifest.webmanifest" crossorigin="use-credentials">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png?v=2') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        {{-- O conteúdo da nossa home page será injetado aqui, sem nenhum container extra --}}
        {{ $slot }}
    </body>
</html>