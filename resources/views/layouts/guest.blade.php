<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <style>
        body {
            background: url("{{ asset('assets/imgs/bg-login.jpg') }}") !important;
            background-repeat: no-repeat !important;
            background-size: cover !important;
            background-position: center !important;
        }
        .min-h-screen, .bg-gray-100 {
            background-color: transparent !important;
        }

        /* CODE BARU: Tambah border pada kotak login putih */
        .w-full.sm\:max-w-md {
            border: 2px solid #000000 !important; /* Tukar #000000 (hitam) ke warna lain kalau nak */
            border-radius: 12px !important;       /* Bagi bucu dia bulat/smooth sikit */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important; /* Tambah bayang bagi timbul */
        }
    </style>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
