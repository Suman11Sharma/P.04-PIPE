<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $seo = \App\Models\PageContent::getSection('home', 'seo');
    @endphp
    <title>{{ $seo['meta_title'] ?? config('app.name', 'PIPE') . ' — Province Information Portal and Engagement Platform' }}</title>
    <meta name="description" content="{{ $seo['meta_description'] ?? 'Province Information Portal and Engagement Platform — connecting citizens with provincial government data, legislative tracking, and community engagement. Part of the Pokhara Research Centre.' }}">

    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css'])

    <style>
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .animate-fade-up { animation: fade-up 0.6s ease-out forwards; opacity: 0; }
        .animate-fade-up-d1 { animation-delay: 0.1s; }
        .animate-fade-up-d2 { animation-delay: 0.2s; }
        .animate-fade-up-d3 { animation-delay: 0.3s; }
        .animate-fade-up-d4 { animation-delay: 0.4s; }
        .animate-fade-up-d5 { animation-delay: 0.5s; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .bg-dot-pattern {
            background-image: radial-gradient(circle, rgba(148, 163, 184, 0.12) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-gray-600 bg-gradient-to-br from-gray-50 via-white to-gray-100 overflow-x-hidden">

    {{-- NAVBAR --}}
    <header class="fixed inset-x-0 top-0 z-50 border-b border-gray-200/80 bg-white/80 backdrop-blur-xl shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 py-3.5">
            <a href="/" class="flex items-center gap-2.5 group shrink-0">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 shadow-sm transition-shadow group-hover:shadow-md">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5l8.5 5.5-8.5 5.5L3.5 13 12 7.5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5l8.5 5.5-8.5 5.5L3.5 8 12 2.5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.5 13l8.5 5.5-8.5 5.5L3.5 13z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.5 13l-8.5 5.5" />
                    </svg>
                </div>
                <span class="text-lg font-bold tracking-tight text-gray-900">PIPE</span>
            </a>

            <nav class="hidden md:flex items-center gap-1">
                <a href="/" class="relative rounded-lg px-3.5 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-sm transition-all">Home</a>
                <a href="{{ route('mp-profiles') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">MP's Profile</a>
                <a href="{{ route('gov-sites') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Gov Site</a>
                <a href="{{ route('our-team') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Our Team</a>
                <a href="{{ route('contact') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Contact</a>
            </nav>

            <button id="mobile-menu-btn" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden p-2 text-gray-500 hover:text-gray-900 rounded-lg hover:bg-gray-100/80 transition-all">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <div class="hidden md:block">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg bg-gradient-to-r from-blue-50 to-blue-100/80 px-4 py-2 text-sm font-semibold text-blue-700 ring-1 ring-blue-200/50 hover:from-blue-100 hover:to-blue-200/80 transition-all shadow-sm">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:from-blue-700 hover:to-blue-800 hover:shadow-md transition-all">Log in</a>
                @endauth
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200/80 bg-white/95 backdrop-blur-xl">
            <div class="px-4 py-3 space-y-1">
                <a href="/" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700">Home</a>
                <a href="{{ route('mp-profiles') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">MP's Profile</a>
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

    {{-- HERO SECTION --}}
    <section class="relative min-h-screen flex items-center overflow-hidden pt-20 bg-gradient-to-br from-white via-blue-50/20 to-white">
        <div class="pointer-events-none absolute inset-0 -z-10">
            <div class="absolute -right-40 -top-40 h-[600px] w-[600px] rounded-full bg-gradient-to-br from-blue-100/20 to-blue-200/10 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 h-[500px] w-[500px] rounded-full bg-gradient-to-tr from-gray-100/60 to-transparent blur-3xl"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center py-16 md:py-24">

                @php
                    $hero = \App\Models\PageContent::getSection('home', 'hero');
                @endphp
                <div class="animate-fade-up">
                    <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-blue-200/60 bg-gradient-to-r from-blue-50 to-blue-100/50 px-4 py-1.5 text-xs font-medium tracking-wider uppercase text-blue-700 shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                        {{ $hero['badge'] ?? 'Province Information Portal' }}
                    </div>

                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight text-gray-900 leading-[1.1]">
                        <span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">{{ $hero['title_highlight'] ?? 'PIPE' }}</span>
                        <br />
                        {{ $hero['title'] ?? 'Empowering Citizens' }}
                    </h1>

                    <p class="mt-5 text-base sm:text-lg leading-relaxed text-gray-500 max-w-xl">
                        {{ $hero['description'] ?? 'Province Information Portal and Engagement Platform — connecting citizens with provincial government data, real-time legislative tracking, and community engagement tools. Part of the Pokhara Research Centre.' }}
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-7 py-3.5 text-base font-semibold text-white shadow-md hover:from-blue-700 hover:to-blue-800 hover:shadow-lg transition-all">
                                Go to Dashboard
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                            </a>
                        @else
                            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-7 py-3.5 text-base font-semibold text-white shadow-md hover:from-blue-700 hover:to-blue-800 hover:shadow-lg transition-all">
                                Contact Us
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white/80 px-7 py-3.5 text-base font-semibold text-gray-700 shadow-sm hover:bg-white hover:border-gray-300 hover:shadow-md transition-all backdrop-blur-sm">
                                Sign In
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="animate-fade-up animate-fade-up-d2 flex justify-center lg:justify-end">
                    <div class="relative w-full max-w-lg">
                        <div class="relative rounded-xl border border-gray-200/80 bg-white/90 p-6 shadow-xl shadow-gray-200/50 backdrop-blur-sm">
                            <div class="pointer-events-none absolute inset-0 -z-10 rounded-xl bg-gradient-to-br from-blue-50/20 via-transparent to-transparent"></div>

                            <div class="flex items-center gap-2 mb-5">
                                <div class="flex gap-1.5">
                                    <span class="h-2.5 w-2.5 rounded-full bg-red-400"></span>
                                    <span class="h-2.5 w-2.5 rounded-full bg-yellow-400"></span>
                                    <span class="h-2.5 w-2.5 rounded-full bg-green-400"></span>
                                </div>
                                <span class="ml-2 text-xs text-gray-400">pipe.gov / dashboard</span>
                            </div>

                            <div class="space-y-4">
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="rounded-lg bg-white p-3 border border-gray-100 shadow-sm">
                                        <div class="text-xs text-gray-500">Briefs</div>
                                        <div class="text-lg font-bold text-gray-900">24</div>
                                        <div class="mt-1 h-1 w-full rounded-full bg-blue-100"><div class="h-1 w-3/4 rounded-full bg-gradient-to-r from-blue-500 to-blue-600"></div></div>
                                    </div>
                                    <div class="rounded-lg bg-white p-3 border border-gray-100 shadow-sm">
                                        <div class="text-xs text-gray-500">Bills</div>
                                        <div class="text-lg font-bold text-gray-900">15</div>
                                        <div class="mt-1 h-1 w-full rounded-full bg-blue-100"><div class="h-1 w-1/2 rounded-full bg-gradient-to-r from-blue-500 to-blue-600"></div></div>
                                    </div>
                                    <div class="rounded-lg bg-white p-3 border border-gray-100 shadow-sm">
                                        <div class="text-xs text-gray-500">Queries</div>
                                        <div class="text-lg font-bold text-gray-900">8</div>
                                        <div class="mt-1 h-1 w-full rounded-full bg-blue-100"><div class="h-1 w-2/3 rounded-full bg-gradient-to-r from-blue-500 to-blue-600"></div></div>
                                    </div>
                                </div>

                                <div class="space-y-2.5">
                                    <div class="flex items-center gap-3 rounded-lg bg-white p-2.5 border border-gray-100 shadow-sm hover:shadow-md transition-all">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-gradient-to-br from-blue-50 to-blue-100 text-blue-700 text-xs font-bold">PB</span>
                                        <div class="min-w-0 flex-1">
                                            <div class="truncate text-sm font-medium text-gray-900">Climate Resilience Grid Assessment</div>
                                            <div class="text-xs text-gray-500">Updated 2 hours ago</div>
                                        </div>
                                        <span class="shrink-0 rounded-full bg-gradient-to-r from-blue-50 to-blue-100/80 px-2 py-0.5 text-xs font-medium text-blue-700">High</span>
                                    </div>
                                    <div class="flex items-center gap-3 rounded-lg bg-white p-2.5 border border-gray-100 shadow-sm hover:shadow-md transition-all">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-gradient-to-br from-blue-50 to-blue-100 text-blue-700 text-xs font-bold">BL</span>
                                        <div class="min-w-0 flex-1">
                                            <div class="truncate text-sm font-medium text-gray-900">Electricity Regulation Amendment Bill</div>
                                            <div class="text-xs text-gray-500">Committee Stage</div>
                                        </div>
                                        <span class="shrink-0 rounded-full bg-gradient-to-r from-blue-50 to-blue-100/80 px-2 py-0.5 text-xs font-medium text-blue-700">Active</span>
                                    </div>
                                    <div class="flex items-center gap-3 rounded-lg bg-white p-2.5 border border-gray-100 shadow-sm hover:shadow-md transition-all">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-gradient-to-br from-blue-50 to-blue-100 text-blue-700 text-xs font-bold">EQ</span>
                                        <div class="min-w-0 flex-1">
                                            <div class="truncate text-sm font-medium text-gray-900">Mining Bill Amendment Implications</div>
                                            <div class="text-xs text-gray-500">Floor Support • 30min SLA</div>
                                        </div>
                                        <span class="shrink-0 rounded-full bg-gradient-to-r from-blue-50 to-blue-100/80 px-2 py-0.5 text-xs font-medium text-blue-700">Urgent</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -bottom-3 -left-3 flex items-center gap-2 rounded-lg border border-blue-200/60 bg-gradient-to-r from-blue-50 to-blue-100/80 px-4 py-2 shadow-sm backdrop-blur-sm">
                            <span class="relative flex h-2 w-2"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span><span class="relative inline-flex h-2 w-2 rounded-full bg-blue-500"></span></span>
                            <span class="text-xs font-medium text-blue-700">Live Data Feed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-float">
            <span class="text-[10px] font-medium tracking-widest uppercase text-gray-400">Scroll</span>
            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
        </div>
    </section>

    {{-- STATS SECTION --}}
    <section class="relative -mt-12 pb-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                @php
                    $statItems = [
                        ['value' => $stats['active_users'], 'label' => 'Active Users', 'icon' => 'users'],
                        ['value' => $stats['total_queries'], 'label' => 'Total Queries', 'icon' => 'chat'],
                        ['value' => $stats['policy_briefs'], 'label' => 'Policy Briefs', 'icon' => 'document'],
                    ];
                @endphp
                @foreach ($statItems as $s)
                    <div class="animate-fade-up animate-fade-up-d{{ $loop->index + 2 }} group relative overflow-hidden rounded-xl border border-gray-200/60 bg-white p-6 text-center shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        <div class="pointer-events-none absolute -right-8 -top-8 h-20 w-20 rounded-full bg-gradient-to-br from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-blue-50 to-blue-100/80 shadow-sm">
                            @if ($s['icon'] === 'users')
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                            @elseif ($s['icon'] === 'chat')
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" /></svg>
                            @else
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                            @endif
                        </div>
                        <div class="text-3xl sm:text-4xl font-bold text-gray-900">{{ $s['value'] }}</div>
                        <div class="mt-1 text-sm text-gray-500">{{ $s['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FEATURES SECTION --}}
    <section id="features" class="relative py-24 md:py-32">
        <div class="pointer-events-none absolute inset-0 -z-10">
            <div class="absolute left-1/2 top-0 h-[500px] w-[800px] -translate-x-1/2 rounded-full bg-gradient-to-r from-blue-50/30 via-transparent to-transparent blur-3xl"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="mx-auto max-w-2xl text-center">
                <span class="inline-block rounded-full border border-blue-200/60 bg-gradient-to-r from-blue-50 to-blue-100/50 px-4 py-1.5 text-xs font-semibold tracking-wider uppercase text-blue-700 shadow-sm">Platform Capabilities</span>
                <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Everything you need to govern with insight</h2>
                <p class="mt-4 text-base leading-relaxed text-gray-500">A unified platform designed for the unique demands of provincial information, policy research, and citizen engagement.</p>
            </div>

            @php
                $featuresData = \App\Models\PageContent::getSection('home', 'features');
                $features = $featuresData['items'] ?? [];
            @endphp

            <div class="mt-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                @php
                    $iconSvgs = [
                        'document' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />',
                        'scale' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />',
                        'chat' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />',
                        'dashboard' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />',
                        'kanban' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />',
                        'compare' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />',
                    ];
                @endphp

                @if (!empty($features))
                    @foreach ($features as $f)
                        <div class="group animate-fade-up animate-fade-up-d{{ min($loop->index + 1, 5) }} relative rounded-xl border border-gray-200/60 bg-white p-6 transition-all hover:border-blue-200/80 hover:shadow-xl hover:-translate-y-0.5 shadow-sm">
                            <div class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-full bg-gradient-to-br from-blue-50/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-blue-50 to-blue-100/80 shadow-sm group-hover:shadow-md group-hover:from-blue-100 group-hover:to-blue-200/80 transition-all">
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">{!! $iconSvgs[$f['icon']] !!}</svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $f['title'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-gray-500">{{ $f['description'] }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full text-center py-16">
                        <p class="text-gray-400">No features configured. Add them from the CMS.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- CTA SECTION --}}
    <section class="relative py-24 bg-gradient-to-br from-white via-blue-50/10 to-white border-t border-gray-200/60">
        <div class="pointer-events-none absolute inset-0 -z-10">
            <div class="absolute left-1/2 top-1/2 h-[400px] w-[400px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-gradient-to-r from-blue-100/20 to-transparent blur-3xl"></div>
        </div>
        <div class="mx-auto max-w-4xl px-4 sm:px-6 text-center">
            @php
                $cta = \App\Models\PageContent::getSection('home', 'cta');
            @endphp
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ $cta['title'] ?? 'Ready to engage with provincial intelligence?' }}</h2>
            <p class="mx-auto mt-4 max-w-xl text-base leading-relaxed text-gray-500">{{ $cta['description'] ?? 'Join South Africa leading provincial information portal connecting citizens with government data and engagement tools.' }}</p>
            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-3.5 text-base font-semibold text-white shadow-md hover:from-blue-700 hover:to-blue-800 hover:shadow-lg transition-all">Go to Dashboard <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg></a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-3.5 text-base font-semibold text-white shadow-md hover:from-blue-700 hover:to-blue-800 hover:shadow-lg transition-all">
                        Sign in to PIPE
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white/80 px-8 py-3.5 text-base font-semibold text-gray-700 shadow-sm hover:bg-white hover:border-gray-300 hover:shadow-md transition-all backdrop-blur-sm">Contact our team</a>
                @endauth
            </div>
        </div>
    </section>

    {{-- FOOTER — stronger visual separation --}}
    <footer class="bg-gray-900 border-t border-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2.5 mb-5">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 shadow-sm">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5l8.5 5.5-8.5 5.5L3.5 13 12 7.5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5l8.5 5.5-8.5 5.5L3.5 8 12 2.5z" /></svg>
                        </div>
                        <span class="text-lg font-bold text-white">{{ config('app.name', 'PIPE') }}</span>
                        <span class="px-2 py-0.5 rounded-md bg-blue-500/10 text-xs font-medium text-blue-400 border border-blue-500/20">v2.0</span>
                    </div>
                    <p class="text-sm text-gray-400 max-w-md leading-relaxed">
                        <strong class="text-gray-300">Province Information Portal and Engagement Platform</strong> — connecting South African citizens with provincial government data, legislative tracking, and community resources. Part of the <strong class="text-gray-300">Pokhara Research Centre</strong>.
                    </p>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-gray-300 mb-4">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="/" class="text-sm text-gray-500 hover:text-gray-200 transition-colors">Home</a></li>
                        <li><a href="{{ route('mp-profiles') }}" class="text-sm text-gray-500 hover:text-gray-200 transition-colors">MP's Profile</a></li>
                        <li><a href="{{ route('gov-sites') }}" class="text-sm text-gray-500 hover:text-gray-200 transition-colors">Gov Site</a></li>
                        <li><a href="{{ route('our-team') }}" class="text-sm text-gray-500 hover:text-gray-200 transition-colors">Our Team</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-gray-300 mb-4">Resources</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-gray-500 hover:text-gray-200 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-gray-200 transition-colors">Terms of Service</a></li>
                        <li><a href="{{ route('contact') }}" class="text-sm text-gray-500 hover:text-gray-200 transition-colors">Contact Support</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-500">&copy; {{ date('Y') }} Province Information Portal and Engagement Platform. All rights reserved. | Pokhara Research Centre</p>
                <div class="flex items-center gap-5">
                    <a href="#" class="text-gray-500 hover:text-gray-300 transition-colors" aria-label="Twitter/X">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" /></svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-300 transition-colors" aria-label="GitHub">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" /></svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-300 transition-colors" aria-label="LinkedIn">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" /></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
