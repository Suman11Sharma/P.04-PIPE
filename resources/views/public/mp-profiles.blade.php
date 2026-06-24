@php
    $mpsData = \App\Models\PageContent::getSection('mp-profiles', 'members');
    $mps = $mpsData['items'] ?? [];
    $avatarColors = ['bg-blue-100 text-blue-600', 'bg-indigo-100 text-indigo-600', 'bg-cyan-100 text-cyan-600', 'bg-sky-100 text-sky-600', 'bg-teal-100 text-teal-600'];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MP Profiles — PIPE</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    <style>
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fade-up 0.5s ease-out forwards; opacity: 0; }
        .animate-fade-up-d1 { animation-delay: 0.1s; }
        .animate-fade-up-d2 { animation-delay: 0.2s; }
        .animate-fade-up-d3 { animation-delay: 0.3s; }
        .animate-fade-up-d4 { animation-delay: 0.4s; }
        .animate-fade-up-d5 { animation-delay: 0.5s; }
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
                <a href="{{ route('mp-profiles') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-sm transition-all">MP's Profile</a>
                <a href="{{ route('gov-sites') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Gov Site</a>
                <a href="{{ route('our-team') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Our Team</a>
                <a href="{{ route('contact') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Contact</a>
            </nav>
            <div class="hidden md:block">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg bg-gradient-to-r from-blue-50 to-blue-100/80 px-4 py-2 text-sm font-semibold text-blue-700 ring-1 ring-blue-200/50 hover:from-blue-100 hover:to-blue-200/80 transition-all shadow-sm">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:from-blue-700 hover:to-blue-800 hover:shadow-md transition-all">Log in</a>
                @endauth
            </div>
            <button id="mobile-menu-btn" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden p-2 text-gray-500 hover:text-gray-900 rounded-lg hover:bg-gray-100/80 transition-all">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
            </button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200/80 bg-white/95 backdrop-blur-xl">
            <div class="px-4 py-3 space-y-1">
                <a href="/" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">Home</a>
                <a href="{{ route('mp-profiles') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700">MP's Profile</a>
                <a href="{{ route('gov-sites') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">Gov Site</a>
                <a href="{{ route('our-team') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">Our Team</a>
                <a href="{{ route('contact') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">Contact</a>
                <hr class="border-gray-200 my-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="block rounded-lg bg-gradient-to-r from-blue-50 to-blue-100/80 px-3 py-2.5 text-sm font-semibold text-blue-700 text-center">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-3 py-2.5 text-sm font-semibold text-white text-center shadow-sm">Log in</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="pt-24 pb-16 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            @php
                $header = \App\Models\PageContent::getSection('mp-profiles', 'header');
            @endphp
            <div class="animate-fade-up text-center mb-12">
                <span class="inline-block rounded-full border border-blue-200/60 bg-gradient-to-r from-blue-50 to-blue-100/50 px-4 py-1.5 text-xs font-semibold tracking-wider uppercase text-blue-700 shadow-sm">{{ $header['badge'] ?? 'Parliament' }}</span>
                <h1 class="mt-4 text-3xl sm:text-4xl font-bold tracking-tight text-gray-900">{{ $header['title'] ?? 'Member of Parliament Profiles' }}</h1>
                <p class="mt-3 text-base text-gray-500 max-w-xl mx-auto">{{ $header['description'] ?? 'Meet the parliamentary members serving their constituencies through the Province Information Portal and Engagement Platform — a Pokhara Research Centre initiative.' }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($mps as $i => $mp)
                    @php
                        $colorIdx = $loop->index % count($avatarColors);
                        $nameParts = explode(' ', $mp['name'] ?? '');
                        $initials = count($nameParts) >= 2
                            ? substr($nameParts[0], 0, 1) . substr(end($nameParts), 0, 1)
                            : substr($mp['name'] ?? '?', 0, 2);
                    @endphp
                    <div class="animate-fade-up animate-fade-up-d{{ min($loop->index + 1, 5) }} group relative rounded-xl border border-gray-200/60 bg-white transition-all hover:border-blue-200/80 hover:shadow-xl hover:-translate-y-0.5 shadow-sm overflow-hidden">
                        <div class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-full bg-gradient-to-br from-blue-50/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>

                        <div class="relative h-44 sm:h-48 bg-gradient-to-br from-blue-50 via-white to-blue-100/50 flex items-center justify-center border-b border-gray-100">
                            @php $photo = $mp['photo'] ?? ''; @endphp
                            @if ($photo && (\Illuminate\Support\Facades\Storage::disk('public')->exists($photo) || str_starts_with($photo, 'http')))
                                <img src="{{ str_starts_with($photo, 'http') ? $photo : \Illuminate\Support\Facades\Storage::url($photo) }}" alt="{{ $mp['name'] ?? '' }}"
                                    class="h-28 w-28 sm:h-32 sm:w-32 rounded-full object-cover ring-4 ring-white shadow-lg" />
                            @else
                                <div class="relative">
                                    <div class="h-28 w-28 sm:h-32 sm:w-32 rounded-full {{ $avatarColors[$colorIdx] }} flex items-center justify-center ring-4 ring-white shadow-lg">
                                        <span class="text-4xl sm:text-5xl font-bold">{{ strtoupper($initials) }}</span>
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 h-8 w-8 rounded-full bg-white shadow-sm flex items-center justify-center">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="p-5">
                            <div class="text-center">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $mp['name'] ?? 'Unknown' }}</h3>
                                @if (!empty($mp['role']))
                                    <span class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-gradient-to-r from-blue-50 to-blue-100/80 px-3 py-0.5 text-xs font-medium text-blue-700 shadow-sm">
                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                        {{ $mp['role'] }}
                                    </span>
                                @endif
                            </div>

                            @if (!empty($mp['constituency']) || !empty($mp['province']))
                                <div class="mt-4 rounded-lg bg-gradient-to-br from-gray-50 to-gray-100/50 p-3 border border-gray-100/80">
                                    <div class="text-xs text-gray-500">Constituency</div>
                                    <div class="text-sm font-medium text-gray-900">{{ $mp['constituency'] ?? 'National Level' }}</div>
                                    @if (!empty($mp['province']))
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $mp['province'] }}</div>
                                    @endif
                                </div>
                            @endif

                            <div class="mt-3 text-xs text-gray-500">{{ $mp['email'] ?? '' }}</div>

                            <button onclick="this.nextElementSibling.classList.toggle('hidden'); this.classList.toggle('hidden')"
                                    class="mt-4 w-full rounded-lg border border-gray-200 bg-white/80 px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-white hover:border-gray-300 hover:shadow-md transition-all backdrop-blur-sm">
                                More Details
                            </button>

                            <div class="hidden mt-3 w-full space-y-2">
                                @if (!empty($mp['bio']))
                                    <div class="rounded-lg bg-gradient-to-br from-gray-50 to-gray-100/50 p-3 border border-gray-100/80 text-left">
                                        <div class="text-xs font-semibold text-gray-600 mb-2">Biography</div>
                                        <p class="text-xs text-gray-700 leading-relaxed">{{ $mp['bio'] }}</p>
                                    </div>
                                @endif
                                <button onclick="this.parentElement.classList.toggle('hidden'); this.parentElement.previousElementSibling.classList.toggle('hidden')"
                                        class="w-full rounded-lg border border-gray-200 bg-white/80 px-4 py-2 text-xs font-medium text-gray-500 shadow-sm hover:bg-white hover:border-gray-300 hover:shadow-md transition-all backdrop-blur-sm">
                                    Show Less
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                        <p class="mt-4 text-gray-500">No MP profiles found. Add them from the admin CMS.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 border-t border-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-12">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-md bg-gradient-to-br from-blue-500 to-blue-600 shadow-sm">
                        <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5l8.5 5.5-8.5 5.5L3.5 13 12 7.5z" /></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-200">PIPE</span>
                    <span class="text-xs text-blue-400">Pokhara Research Centre</span>
                </div>
                <p class="text-xs text-gray-500">&copy; {{ date('Y') }} Province Information Portal and Engagement Platform.</p>
                <nav class="flex items-center gap-4 text-xs text-gray-500">
                    <a href="/" class="hover:text-gray-200 transition-colors">Home</a>
                    <a href="{{ route('gov-sites') }}" class="hover:text-gray-200 transition-colors">Gov Site</a>
                    <a href="{{ route('our-team') }}" class="hover:text-gray-200 transition-colors">Our Team</a>
                </nav>
            </div>
        </div>
    </footer>

</body>
</html>
