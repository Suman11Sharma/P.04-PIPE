<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In — PIPE — Province Information Portal and Engagement Platform</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    @livewireStyles

    <style>
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fade-up 0.5s ease-out forwards; opacity: 0; }
        .animate-fade-up-d1 { animation-delay: 0.1s; }
        .animate-fade-up-d2 { animation-delay: 0.2s; }
        .animate-fade-up-d3 { animation-delay: 0.3s; }
    </style>
</head>
<body class="h-full font-sans antialiased text-gray-600 bg-gradient-to-br from-gray-50 via-white to-gray-100 overflow-x-hidden">

    {{-- NAVBAR --}}
    <header class="fixed inset-x-0 top-0 z-50 border-b border-gray-200/80 bg-white/80 backdrop-blur-xl shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 py-3.5">
            <a href="/" class="flex items-center gap-2.5 group shrink-0">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 shadow-sm transition-shadow group-hover:shadow-md">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5l8.5 5.5-8.5 5.5L3.5 13 12 7.5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5l8.5 5.5-8.5 5.5L3.5 8 12 2.5z" />
                    </svg>
                </div>
                <span class="text-lg font-bold tracking-tight text-gray-900">PIPE</span>
            </a>
            <nav class="hidden md:flex items-center gap-1">
                <a href="/" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Home</a>
                <a href="{{ route('mp-profiles') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">MP's Profile</a>
                <a href="{{ route('gov-sites') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Gov Site</a>
                <a href="{{ route('our-team') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Our Team</a>
                <a href="{{ route('contact') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Contact</a>
            </nav>
            <div class="hidden md:block">
                <a href="{{ route('login') }}" class="rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:from-blue-700 hover:to-blue-800 hover:shadow-md transition-all">Log in</a>
            </div>
            <button id="mobile-menu-btn" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden p-2 text-gray-500 hover:text-gray-900 rounded-lg hover:bg-gray-100/80 transition-all">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
            </button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200/80 bg-white/95 backdrop-blur-xl">
            <div class="px-4 py-3 space-y-1">
                <a href="/" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">Home</a>
                <a href="{{ route('mp-profiles') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">MP's Profile</a>
                <a href="{{ route('gov-sites') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">Gov Site</a>
                <a href="{{ route('our-team') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">Our Team</a>
                <a href="{{ route('contact') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">Contact</a>
                <hr class="border-gray-200 my-2">
                <a href="{{ route('login') }}" class="block rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-3 py-2.5 text-sm font-semibold text-white text-center shadow-sm">Log in</a>
            </div>
        </div>
    </header>

    {{-- Login Section --}}
    <div class="relative min-h-screen flex items-center justify-center pt-20 pb-12 px-4 sm:px-6">
        {{-- Subtle background ornament --}}
        <div class="pointer-events-none absolute inset-0 -z-10">
            <div class="absolute -right-40 -top-40 h-[500px] w-[500px] rounded-full bg-gradient-to-br from-blue-100/20 to-blue-200/10 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 h-[400px] w-[400px] rounded-full bg-gradient-to-tr from-gray-100/60 to-transparent blur-3xl"></div>
        </div>

        <div class="w-full max-w-md">
            <div class="animate-fade-up text-center mb-8">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 shadow-md">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5l8.5 5.5-8.5 5.5L3.5 13 12 7.5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5l8.5 5.5-8.5 5.5L3.5 8 12 2.5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.5 13l8.5 5.5-8.5 5.5L3.5 13z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.5 13l-8.5 5.5" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Welcome back</h1>
                <p class="mt-1.5 text-sm text-gray-500">Sign in to your PIPE account — <strong>Pokhara Research Centre</strong></p>
            </div>

            <div class="animate-fade-up animate-fade-up-d1 rounded-xl border border-gray-200/60 bg-white p-8 shadow-xl shadow-gray-200/50">
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    @if (session('status'))
                        <div class="rounded-lg border border-green-200/60 bg-gradient-to-r from-green-50 to-green-100/50 p-3 text-sm text-green-700 shadow-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="rounded-lg border border-red-200/60 bg-gradient-to-r from-red-50 to-red-100/50 p-3 text-sm text-red-600 shadow-sm">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="rounded-lg border border-gray-200/60 bg-gradient-to-br from-gray-50 to-gray-100/50 p-3 shadow-sm">
                        <div class="flex items-start gap-2.5">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <div class="text-xs text-gray-500">
                                <span class="text-gray-700 font-medium">Demo accounts available:</span><br />
                                Admin: <code class="text-blue-600 bg-blue-50/80 px-1 rounded shadow-sm">admin@pipe.gov</code><br />
                                MP: <code class="text-blue-600 bg-blue-50/80 px-1 rounded shadow-sm">david.ochieng@pipe.gov</code><br />
                                Password: <code class="text-blue-600 bg-blue-50/80 px-1 rounded shadow-sm">password</code>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-700">Official Email Address</label>
                        <div class="mt-1.5">
                            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm transition"
                                placeholder="you@parliament.gov" />
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-700">Password</label>
                        <div class="mt-1.5">
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm transition"
                                placeholder="Enter your password" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember" class="flex items-center gap-2 text-sm text-gray-500 cursor-pointer hover:text-gray-700 transition">
                            <input id="remember" name="remember" type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 bg-white text-blue-600 focus:ring-blue-500 focus:ring-offset-0" />
                            Remember this device
                        </label>
                    </div>

                    <button type="submit"
                        class="flex w-full justify-center rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 text-sm font-semibold leading-6 text-white shadow-md hover:from-blue-700 hover:to-blue-800 hover:shadow-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all">
                        Sign in
                    </button>
                </form>
            </div>

            <p class="animate-fade-up animate-fade-up-d2 mt-6 text-center text-xs text-gray-400">
                <a href="/" class="text-gray-500 hover:text-gray-700 transition-colors">← Back to home</a>
                &middot;
                Authorised personnel only. All access is monitored.
            </p>
        </div>
    </div>

    @livewireScripts
</body>
</html>
