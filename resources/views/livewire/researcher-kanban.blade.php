<div>
    {{-- ===== SIDEBAR ===== --}}
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 border-r border-gray-200/80 bg-white/90 backdrop-blur-xl shadow-sm flex flex-col transition-transform duration-300 -translate-x-full md:translate-x-0">
        <div class="flex items-center gap-2.5 px-5 pt-4 pb-3 shrink-0">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 shadow-sm">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5l8.5 5.5-8.5 5.5L3.5 13 12 7.5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5l8.5 5.5-8.5 5.5L3.5 8 12 2.5z" /></svg>
                </div>
                <span class="text-lg font-bold tracking-tight text-gray-900">PIPE</span>
            </a>
            <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="md:hidden absolute right-3 top-4 p-1 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <div class="px-5 py-3 border-b border-gray-200/60">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-50 to-blue-100/80 text-sm font-bold text-blue-600 shadow-sm">{{ substr($user->name, 0, 1) }}{{ substr(strrchr($user->name, ' ') ?: $user->name, 1, 1) }}</div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $user->role_label }}</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                Dashboard
            </a>
            <span class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-sm">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" /></svg>
                Research Workspace
            </span>
        </nav>
        <div class="px-3 py-3 border-t border-gray-200/60">
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black/20 backdrop-blur-sm hidden md:hidden" onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full'); this.classList.toggle('hidden')"></div>

    {{-- ===== MAIN ===== --}}
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 md:ml-64">
        {{-- Top header --}}
        <header class="sticky top-0 z-30 border-b border-gray-200/80 bg-white/80 backdrop-blur-xl shadow-sm">
            <div class="flex items-center justify-between px-4 sm:px-6 py-3">
                <div class="flex items-center gap-3">
                    <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full'); document.getElementById('sidebar-overlay').classList.toggle('hidden')"
                        class="md:hidden p-2 -ml-2 rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                    </button>
                    <span class="text-sm font-medium text-gray-500">Research Workspace</span>
                </div>
                <a href="/" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                </a>
            </div>
        </header>

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Research Operations Center</h1>
                    <p class="mt-1 text-sm text-gray-500">Kanban workflow for expert queries</p>
                </div>
                <div class="flex items-center gap-3">
                    <button wire:click="checkSlaBreaches" type="button"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white/80 px-3 py-2 text-xs font-medium text-gray-600 shadow-sm hover:bg-white hover:border-gray-300 hover:shadow-md transition-all backdrop-blur-sm">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        Check SLA
                    </button>
                    <button wire:click="toggleShowMine" type="button"
                        class="inline-flex items-center gap-1.5 rounded-lg border px-3 py-2 text-xs font-medium transition-all
                            {{ $showMineOnly ? 'bg-blue-50 border-blue-200/60 text-blue-700 shadow-sm' : 'border-gray-200 bg-white/80 text-gray-600 hover:bg-white hover:border-gray-300 hover:shadow-md backdrop-blur-sm' }}">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        {{ $showMineOnly ? 'All queries' : 'Mine only' }}
                    </button>
                </div>
            </div>

            {{-- SLA Breach Alert --}}
            @if ($breachCount > 0)
                <div class="mb-6 rounded-xl border border-red-200/60 bg-gradient-to-r from-red-50 to-red-100/50 p-4 shadow-sm">
                    <div class="flex items-center gap-2">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100">
                            <svg class="h-4 w-4 text-red-600 animate-pulse" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-red-700">{{ $breachCount }} SLA Breach(es) Detected</p>
                            <p class="text-xs text-red-600/70">One or more queries have exceeded their deadline. Assign or escalate immediately.</p>
                        </div>
                    </div>
                </div>
            @endif

            @php
                $columnColors = [
                    'pending' => ['header' => 'bg-gray-100', 'accent' => 'border-t-gray-500'],
                    'assigned' => ['header' => 'bg-blue-50', 'accent' => 'border-t-blue-500'],
                    'in_progress' => ['header' => 'bg-indigo-50', 'accent' => 'border-t-indigo-500'],
                    'senior_review' => ['header' => 'bg-amber-50', 'accent' => 'border-t-amber-500'],
                    'completed' => ['header' => 'bg-green-50', 'accent' => 'border-t-green-500'],
                ];
            @endphp

            <div class="grid grid-cols-1 gap-4 overflow-x-auto md:grid-cols-5">
                @foreach ($columnsData as $key => $column)
                    <div class="flex flex-col rounded-xl border border-gray-200/60 bg-white shadow-sm min-w-[240px]">
                        <div class="flex items-center justify-between border-b border-gray-200/60 px-4 py-3 rounded-t-xl {{ $columnColors[$key]['header'] ?? 'bg-gray-50' }}">
                            <div class="flex items-center gap-2">
                                <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-600">{{ $column['label'] }}</h3>
                                <span class="inline-flex items-center justify-center h-5 min-w-[20px] rounded-full bg-gray-200 px-1.5 text-[10px] font-medium text-gray-500">{{ $column['queries']->count() }}</span>
                            </div>
                        </div>
                        <div class="flex-1 space-y-2 p-3 overflow-y-auto max-h-[70vh]">
                            @forelse ($column['queries'] as $query)
                                <div class="group relative rounded-lg border border-gray-200/60 bg-white p-3 shadow-sm transition hover:border-gray-300
                                    {{ $query->sla_breached_at ? 'border-red-300 bg-red-50 animate-pulse' : '' }}
                                    {{ $query->turnaround_tier_enum->value === '30min_floor_support' && !$query->sla_breached_at ? 'border-amber-200/60 bg-amber-50/30' : '' }}">
                                    @if ($query->sla_breached_at)
                                        <div class="absolute -top-1.5 -right-1.5 flex h-5 w-5 items-center justify-center rounded-full bg-red-500">
                                            <svg class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-medium
                                            {{ $query->turnaround_tier_enum->value === '30min_floor_support' ? 'bg-amber-100 text-amber-700' : ($query->turnaround_tier_enum->value === '48hr_analysis' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                                            {{ $query->turnaround_tier_enum->label() }}
                                        </span>
                                        @if ($query->bill)
                                            <span class="text-[10px] font-mono text-gray-400">{{ $query->bill->local_identifier }}</span>
                                        @endif
                                    </div>
                                    <h4 class="text-sm font-medium text-gray-900 line-clamp-2 leading-snug">{{ $query->title }}</h4>
                                    <p class="mt-1 text-[10px] text-gray-500">
                                        {{ $query->submitter?->name ?? 'Unknown MP' }}
                                        @if ($query->assignedResearcher)
                                            &middot; Assigned: {{ $query->assignedResearcher->name }}
                                        @endif
                                    </p>
                                    @if ($query->target_deadline)
                                        <p class="mt-1 text-[10px] font-mono {{ $query->sla_breached_at ? 'text-red-600' : ($query->target_deadline->isPast() ? 'text-red-500' : 'text-gray-500') }}">
                                            @if ($query->sla_breached_at)
                                                BREACHED {{ $query->sla_breached_at->diffForHumans() }}
                                            @else
                                                Due {{ $query->target_deadline->diffForHumans() }}
                                            @endif
                                        </p>
                                    @endif
                                    <div class="mt-3 flex flex-wrap gap-1.5">
                                        @if ($key === 'pending' && !$query->assigned_researcher_id && $user->isResearcher())
                                            <button wire:click="selfAssign({{ $query->id }})"
                                                class="inline-flex items-center gap-1 rounded bg-blue-100 px-2 py-1 text-[10px] font-medium text-blue-700 hover:bg-blue-200 transition">Claim</button>
                                        @endif
                                        @if ($key !== 'completed')
                                            @php $next = $query->status_enum->nextInWorkflow(); @endphp
                                            @if ($next)
                                                <button wire:click="moveQuery({{ $query->id }}, '{{ $next->value }}')"
                                                    class="inline-flex items-center gap-1 rounded bg-gray-100 px-2 py-1 text-[10px] font-medium text-gray-600 hover:bg-gray-200 transition">
                                                    {{ $next->label() }}
                                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                                                </button>
                                            @endif
                                        @endif
                                        @if ($key === 'senior_review' && $user->isSeniorResearcher())
                                            <a href="{{ route('researcher.review', $query->id) }}"
                                                class="inline-flex items-center gap-1 rounded bg-amber-100 px-2 py-1 text-[10px] font-medium text-amber-700 hover:bg-amber-200 transition">
                                                Review &amp; Approve
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-8 text-center">
                                    <svg class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                                    <p class="mt-2 text-xs text-gray-500">No queries</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex flex-wrap items-center gap-4 text-[10px] text-gray-500">
                <span class="flex items-center gap-1.5"><span class="inline-block h-2.5 w-2.5 rounded-full bg-amber-500"></span> Floor Support (30-min)</span>
                <span class="flex items-center gap-1.5"><span class="inline-block h-2.5 w-2.5 rounded-full bg-blue-500"></span> 48-Hour Analysis</span>
                <span class="flex items-center gap-1.5"><span class="inline-block h-2.5 w-2.5 rounded-full bg-gray-500"></span> Standard Request</span>
                <span class="flex items-center gap-1.5"><span class="inline-block h-2.5 w-2.5 rounded-full bg-red-500"></span> SLA Breached</span>
            </div>
        </div>
    </div>
</div>
