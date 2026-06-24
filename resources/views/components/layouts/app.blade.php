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
    @stack('styles')
</head>
<body class="h-full font-sans antialiased text-gray-600 bg-gradient-to-br from-gray-50 via-white to-gray-100 overflow-x-hidden">

    <div class="flex h-full">
        {{-- ===== SIDEBAR ===== --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 border-r border-gray-200/80 bg-white/90 backdrop-blur-xl shadow-sm flex flex-col transition-transform duration-300 -translate-x-full md:translate-x-0">
            {{-- Logo --}}
            <div class="flex items-center gap-2.5 px-5 pt-4 pb-3 shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 shadow-sm transition-shadow group-hover:shadow-md">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5l8.5 5.5-8.5 5.5L3.5 13 12 7.5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5l8.5 5.5-8.5 5.5L3.5 8 12 2.5z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold tracking-tight text-gray-900">PIPE</span>
                </a>
            </div>

            {{-- Close button (mobile) --}}
            <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="md:hidden absolute right-3 top-4 p-1 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- User info --}}
            <div class="px-5 py-3 border-b border-gray-200/60">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-50 to-blue-100/80 text-sm font-bold text-blue-600 shadow-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}{{ substr(strrchr(auth()->user()->name, ' ') ?: auth()->user()->name, 1, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->role_label }}</p>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100/80' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    Dashboard
                </a>

                {{-- Bills / Legislative Tracker --}}
                <a href="{{ route('bills.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('bills.*') ? 'text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100/80' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    Legislative Tracker
                </a>

                {{-- MP Users Tracker --}}
                <a href="{{ route('mp-profiles') }}"
                   class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium transition-all text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    MP Users Tracker
                </a>

                {{-- CMS --}}
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.page-contents.index') }}"
                       class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('admin.*') ? 'text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100/80' }}">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                        </svg>
                        CMS
                    </a>
                @endif

                {{-- Expert Query --}}
                <a href="{{ route('expert-query.submit') }}"
                   class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('expert-query.*') ? 'text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100/80' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                    Ask an Expert
                </a>

                {{-- Policy Briefs --}}
                <a href="#" onclick="alert('Policy Briefs index coming soon'); return false;"
                   class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('policy-briefs.*') ? 'text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100/80' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    Policy Briefs
                </a>
            </nav>

            {{-- Sign Out --}}
            <div class="px-3 py-3 border-t border-gray-200/60">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Mobile overlay --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black/20 backdrop-blur-sm hidden md:hidden" onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full'); this.classList.toggle('hidden')"></div>

        {{-- ===== MAIN CONTENT ===== --}}
        <div class="flex-1 flex flex-col min-h-screen md:ml-64">
            {{-- Top header bar --}}
            <header class="sticky top-0 z-30 border-b border-gray-200/80 bg-white/80 backdrop-blur-xl shadow-sm">
                <div class="flex items-center justify-between px-4 sm:px-6 py-3">
                    <div class="flex items-center gap-3">
                        {{-- Mobile hamburger --}}
                        <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full'); document.getElementById('sidebar-overlay').classList.toggle('hidden')"
                            class="md:hidden p-2 -ml-2 rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                        <span class="hidden sm:block text-sm font-medium text-gray-500">@yield('title', 'Dashboard')</span>
                    </div>

                    <div class="flex items-center gap-3">
                        {{-- Quick actions --}}
                        <a href="{{ route('expert-query.submit') }}" class="hidden sm:inline-flex items-center gap-1.5 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-3.5 py-2 text-xs font-semibold text-white shadow-sm hover:from-blue-700 hover:to-blue-800 transition-all">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            New Query
                        </a>
                        <a href="/" class="text-xs text-gray-400 hover:text-gray-600 transition-colors" title="Back to public site">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                        </a>
                    </div>
                </div>
            </header>

            {{-- Page content --}}
            <main class="flex-1">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Sync sidebar overlay with sidebar state on window resize
        document.addEventListener('DOMContentLoaded', function() {
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('sidebar-overlay');
            var mq = window.matchMedia('(min-width: 768px)');
            mq.addEventListener('change', function(e) {
                if (e.matches) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        });
    </script>

    @livewireScripts
    @stack('scripts')
</body>
</html>
