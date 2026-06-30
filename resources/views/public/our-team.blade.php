@php
    $teamData = \App\Models\PageContent::getSection('our-team', 'team_members');
    $team = $teamData['items'] ?? [];

    $avatarColors = ['bg-blue-100 text-blue-600', 'bg-indigo-100 text-indigo-600', 'bg-cyan-100 text-cyan-600', 'bg-sky-100 text-sky-600', 'bg-teal-100 text-teal-600', 'bg-violet-100 text-violet-600'];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Our Team — PIPE</title>
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
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 shadow-sm">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5l8.5 5.5-8.5 5.5L3.5 13 12 7.5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5l8.5 5.5-8.5 5.5L3.5 8 12 2.5z" />
                    </svg>
                </div>
                <span class="text-lg font-bold tracking-tight text-gray-900">PIPE</span>
            </a>
            <nav class="hidden md:flex items-center gap-1">
                <a href="/" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Home</a>
                <a href="{{ route('mp-profiles') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">MP's Profile</a>
                <a href="{{ route('gov-sites') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Province Sites</a>
                <a href="{{ route('our-team') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-sm transition-all">Our Team</a>
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
                <a href="{{ route('mp-profiles') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">MP's Profile</a>
                <a href="{{ route('gov-sites') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">Province Sites</a>
                <a href="{{ route('our-team') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700">Our Team</a>
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
                $header = \App\Models\PageContent::getSection('our-team', 'header');
            @endphp
            <div class="animate-fade-up text-center mb-12">
                <span class="inline-block rounded-full border border-blue-200/60 bg-gradient-to-r from-blue-50 to-blue-100/50 px-4 py-1.5 text-xs font-semibold tracking-wider uppercase text-blue-700 shadow-sm">{{ $header['badge'] ?? 'Team' }}</span>
                <h1 class="mt-4 text-3xl sm:text-4xl font-bold tracking-tight text-gray-900">{{ $header['title'] ?? 'Our Team' }}</h1>
                <p class="mt-3 text-base text-gray-500 max-w-xl mx-auto">{{ $header['description'] ?? 'The people behind PIPE — a Pokhara Research Centre initiative connecting citizens with provincial information, data, and engagement tools.' }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($team as $i => $member)
                    @php
                        $colorIdx = $loop->index % count($avatarColors);
                        $initials = '';
                        $nameParts = explode(' ', $member['name'] ?? '');
                        if (count($nameParts) >= 2) {
                            $initials = substr($nameParts[0], 0, 1) . substr(end($nameParts), 0, 1);
                        } else {
                            $initials = substr($member['name'] ?? '?', 0, 2);
                        }
                    @endphp
                    <div class="animate-fade-up animate-fade-up-d{{ min($loop->index + 1, 5) }} group relative rounded-xl border border-gray-200/60 bg-white transition-all hover:border-blue-200/80 hover:shadow-xl hover:-translate-y-0.5 shadow-sm overflow-hidden">
                        <div class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-full bg-gradient-to-br from-blue-50/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>

                        <div class="relative h-40 bg-gradient-to-br from-blue-50 via-white to-blue-100/50 flex items-center justify-center border-b border-gray-100">
                            @php $photo = $member['photo'] ?? ''; @endphp
                            @if ($photo && (\Illuminate\Support\Facades\Storage::disk('public')->exists($photo) || str_starts_with($photo, 'http')))
                                <img src="{{ str_starts_with($photo, 'http') ? $photo : \Illuminate\Support\Facades\Storage::url($photo) }}" alt="{{ $member['name'] ?? '' }}"
                                    class="h-24 w-24 sm:h-28 sm:w-28 rounded-full object-cover ring-4 ring-white shadow-lg" />
                            @else
                                <div class="h-24 w-24 sm:h-28 sm:w-28 rounded-full {{ $avatarColors[$colorIdx] }} flex items-center justify-center ring-4 ring-white shadow-lg">
                                    <span class="text-3xl sm:text-4xl font-bold">{{ strtoupper($initials) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-5">
                            <div class="text-center">
                                <h3 class="text-base font-semibold text-gray-900">{{ $member['name'] ?? 'Unknown' }}</h3>
                                @if (!empty($member['role']))
                                    <span class="mt-1.5 inline-flex items-center gap-1.5 rounded-full bg-gradient-to-r from-blue-50 to-blue-100/80 px-2.5 py-0.5 text-xs font-medium text-blue-700 shadow-sm">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                        {{ $member['role'] }}
                                    </span>
                                @endif
                                @if (!empty($member['email']))
                                    <p class="mt-2 text-xs text-gray-500">{{ $member['email'] }}</p>
                                @endif
                                @if (!empty($member['bio']))
                                    <p class="mt-3 text-xs text-gray-400 leading-relaxed line-clamp-3">{{ $member['bio'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                        <p class="mt-4 text-gray-500">No team members found. Add them from the admin CMS.</p>
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
                    <a href="{{ route('mp-profiles') }}" class="hover:text-gray-200 transition-colors">MP's Profile</a>
                    <a href="{{ route('gov-sites') }}" class="hover:text-gray-200 transition-colors">Province Sites</a>
                </nav>
            </div>
        </div>
    </footer>

</body>
</html>
