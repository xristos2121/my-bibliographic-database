<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle ?? config('app.name', 'Publications Manager') }}</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800&display=swap"
        rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    <!-- Scripts -->
</head>

<body class="font-sans antialiased">
<div x-data="mainState" :class="{ dark: isDarkMode }" x-on:resize.window="handleWindowResize" x-cloak>
    <div class="min-h-screen text-gray-900 bg-gray-100 dark:bg-dark-eval-0 dark:text-gray-200">
        <!-- Sidebar -->
        <x-sidebar.sidebar/>

        <!-- Page Wrapper -->
        <div class="flex flex-col min-h-screen" :class="{ 'lg:ml-64': isSidebarOpen, 'md:ml-16': !isSidebarOpen }"
             style="transition-property: margin; transition-duration: 150ms;">
            <!-- Navbar -->
            <x-navbar/>

            <!-- Header -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="px-4 sm:px-6 flex-1">
                {{ $slot }}
            </main>

            <!-- Page Footer -->
            <x-footer/>
        </div>
    </div>
</div>
</body>
</html>
