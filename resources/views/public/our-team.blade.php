@php
    use App\Models\User;
    $team = User::all();

    $roleIcons = [
        'admin' => 'shield', 'senior_researcher' => 'academic', 'junior_researcher' => 'research',
        'committee_chair' => 'gavel', 'mp' => 'users', 'staff' => 'briefcase',
    ];
    $roleSvgs = [
        'shield' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />',
        'academic' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342" />',
        'research' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />',
        'gavel' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />',
        'users' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />',
        'briefcase' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />',
    ];

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
                <a href="{{ route('gov-sites') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Gov Site</a>
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
                <a href="{{ route('gov-sites') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">Gov Site</a>
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
            <div class="animate-fade-up text-center mb-12">
                <span class="inline-block rounded-full border border-blue-200/60 bg-gradient-to-r from-blue-50 to-blue-100/50 px-4 py-1.5 text-xs font-semibold tracking-wider uppercase text-blue-700 shadow-sm">Team</span>
                <h1 class="mt-4 text-3xl sm:text-4xl font-bold tracking-tight text-gray-900">Our Team</h1>
                <p class="mt-3 text-base text-gray-500 max-w-xl mx-auto">The people behind PIPE — a <strong class="text-gray-700">Pokhara Research Centre</strong> initiative connecting citizens with provincial information, data, and engagement tools.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($team as $i => $member)
                    @php
                        $iconKey = $roleIcons[$member->role_enum->value] ?? 'users';
                        $colorIdx = $loop->index % count($avatarColors);
                        $initials = substr($member->name, 0, 1) . substr(strrchr($member->name, ' ') ?: $member->name, 1, 1);
                    @endphp
                    <div class="animate-fade-up animate-fade-up-d{{ min($loop->index + 1, 5) }} group relative rounded-xl border border-gray-200/60 bg-white transition-all hover:border-blue-200/80 hover:shadow-xl hover:-translate-y-0.5 shadow-sm overflow-hidden">
                        <div class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-full bg-gradient-to-br from-blue-50/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>

                        {{-- Photo section --}}
                        <div class="relative h-40 bg-gradient-to-br from-blue-50 via-white to-blue-100/50 flex items-center justify-center border-b border-gray-100">
                            @if ($member->profile_photo_path)
                                <img src="{{ Storage::url($member->profile_photo_path) }}" alt="{{ $member->name }}"
                                    class="h-24 w-24 sm:h-28 sm:w-28 rounded-full object-cover ring-4 ring-white shadow-lg" />
                            @else
                                <div class="h-24 w-24 sm:h-28 sm:w-28 rounded-full {{ $avatarColors[$colorIdx] }} flex items-center justify-center ring-4 ring-white shadow-lg">
                                    <span class="text-3xl sm:text-4xl font-bold">{{ $initials }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-5">
                            <div class="text-center">
                                <h3 class="text-base font-semibold text-gray-900">{{ $member->name }}</h3>
                                <span class="mt-1.5 inline-flex items-center gap-1.5 rounded-full bg-gradient-to-r from-blue-50 to-blue-100/80 px-2.5 py-0.5 text-xs font-medium text-blue-700 shadow-sm">
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">{!! $roleSvgs[$iconKey] !!}</svg>
                                    {{ $member->role_label }}
                                </span>
                                <p class="mt-2 text-xs text-gray-500">{{ $member->email }}</p>
                                @if ($member->constituency)
                                    <p class="mt-1 text-xs text-gray-400">{{ $member->constituency->name }}, {{ $member->constituency->province_name }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
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
                    <a href="{{ route('gov-sites') }}" class="hover:text-gray-200 transition-colors">Gov Site</a>
                </nav>
            </div>
        </div>
    </footer>

</body>
</html>
