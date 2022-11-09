<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @livewireStyles

    @stack('css')

</head>

<body class="font-sans antialiased bg-gray-50 text-gray-700">
    <x-jet-banner />

    @php
        $links = [
            [
                'titel' => 'Dashboard',
                'url' => route('admin.dashboard'),
                'active' => request()->routeIs('home'),
            ],
            [
                'titel' => 'Post',
                'url' => route('admin.posts.index'),
                'active' => request()->routeIs('admin.posts.*'),
            ],
        ];
    @endphp

    <div class="flex">

        @include('layouts.partials.admin.sidebar')

        <div class="flex-1">
            @include('layouts.partials.admin.navigation')

            <div class="max-w-7x1 mx-auto px-4 sm:px-6 lg:px-8 py-6">
                {{ $slot }}
            </div>
        </div>

    </div>

    @stack('modals')

    @livewireScripts

    @stack('js')

</body>

</html>
