<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'PIPE')) — Province Information Portal &amp; Engagement Platform</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css'])
    @livewireStyles
</head>
<body class="h-full font-sans antialiased text-gray-600 bg-gradient-to-br from-gray-50 via-white to-gray-100 overflow-x-hidden">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        {{-- Brand --}}
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="flex justify-center">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 shadow-md">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5l8.5 5.5-8.5 5.5L3.5 13 12 7.5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5l8.5 5.5-8.5 5.5L3.5 8 12 2.5z" />
                    </svg>
                </div>
            </div>
            <h2 class="mt-6 text-center text-2xl font-bold tracking-tight text-gray-900">
                Province Information Portal &amp; Engagement Platform
            </h2>
            <p class="mt-2 text-center text-sm text-gray-500">
                Pokhara Research Centre
            </p>
        </div>

        {{-- Card --}}
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="rounded-xl border border-gray-200/60 bg-white px-8 py-8 shadow-xl shadow-gray-200/50">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
