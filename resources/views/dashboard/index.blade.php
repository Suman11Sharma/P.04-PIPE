@extends('components.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">

    {{-- 1. HERO BANNER --}}
    <div class="relative mb-8 overflow-hidden rounded-2xl border border-gray-200/60 bg-white p-6 sm:p-8 shadow-sm">
        <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-gradient-to-br from-blue-50/40 to-transparent blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-16 -left-16 h-48 w-48 rounded-full bg-gradient-to-tr from-blue-50/20 to-transparent blur-3xl"></div>

        <div class="relative">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs font-medium uppercase tracking-widest text-blue-600 mb-2">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        {{ $constituencyName }}
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">
                        Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ auth()->user()->name }}
                    </h1>
                    <p class="mt-1.5 text-sm text-gray-500 max-w-xl">
                        Province Information Portal &amp; Engagement Platform — {{ now()->format('l, j F Y') }}
                    </p>
                </div>
            </div>

            @if ($criticalNotification)
                <div class="mt-5 flex items-start gap-3 rounded-xl border border-amber-200/60 bg-gradient-to-r from-amber-50 to-amber-100/50 p-4 shadow-sm">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100">
                        <svg class="h-4 w-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-wider text-amber-700">Policy Risk Warning</p>
                        <p class="mt-0.5 text-sm text-amber-800/90">
                            <a href="{{ route('policy-briefs.show', $criticalNotification->slug) }}" class="underline decoration-amber-500/30 hover:decoration-amber-600 transition">
                                {{ $criticalNotification->title }}
                            </a>
                        </p>
                        <p class="mt-0.5 text-xs text-amber-600/70">
                            {{ str($criticalNotification->summary)->limit(120) }}
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Pre-defined class maps for Tailwind v4 JIT detection --}}
    @php
        $urgencyBadge = [
            'low' => 'bg-green-50 text-green-700 ring-1 ring-green-200/60',
            'medium' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/60',
            'high' => 'bg-red-50 text-red-700 ring-1 ring-red-200/60',
        ];
        $statusBadge = [
            'tabled' => 'bg-gray-50 text-gray-600 ring-1 ring-gray-200/60',
            'first_reading' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/60',
            'second_reading' => 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200/60',
            'committee_stage' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/60',
            'passed' => 'bg-green-50 text-green-700 ring-1 ring-green-200/60',
            'vetoed' => 'bg-red-50 text-red-700 ring-1 ring-red-200/60',
        ];
    @endphp

    {{-- 2. INTELLIGENCE FEED --}}
    <section class="mb-10">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Intelligence Feed</h2>
                <p class="text-sm text-gray-500">Curated policy briefs matching your sector interests</p>
            </div>
            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition">View all &rarr;</a>
        </div>

        @if ($intelligenceFeed->isEmpty())
            <div class="rounded-xl border border-dashed border-gray-200 bg-white/50 p-10 text-center">
                <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <p class="mt-3 text-sm font-medium text-gray-500">No briefs yet</p>
                <p class="mt-1 text-xs text-gray-400">Briefs matching your sector interests will appear here once published.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($intelligenceFeed as $brief)
                    <a href="{{ route('policy-briefs.show', $brief->slug) }}"
                       class="group relative rounded-xl border border-gray-200/60 bg-white p-5 shadow-sm transition-all hover:border-blue-200/80 hover:shadow-xl hover:-translate-y-0.5">
                        <div class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-full bg-gradient-to-br from-blue-50/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $urgencyBadge[$brief->urgency_level_enum->value] ?? 'bg-gray-50 text-gray-600 ring-1 ring-gray-200/60' }}">
                                {{ $brief->urgency_level_enum->label() }}
                            </span>
                            @if ($brief->sector)
                                <span class="text-xs text-gray-400">{{ $brief->sector->name }}</span>
                            @endif
                        </div>

                        <h3 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2">
                            {{ $brief->title }}
                        </h3>

                        <p class="mt-2 text-xs text-gray-500 line-clamp-3 leading-relaxed">
                            {{ $brief->summary }}
                        </p>

                        <div class="mt-4 flex items-center justify-between text-xs text-gray-400">
                            <span>{{ $brief->published_at?->diffForHumans() ?? 'Unpublished' }}</span>
                            <span class="flex items-center gap-1">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ number_format($brief->views_count) }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    {{-- 3. QUERY STATUS TRACKER --}}
    <section class="mb-10">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Query Status Tracker</h2>
                <p class="text-sm text-gray-500">Track your submitted expert research requests</p>
            </div>
            <a href="{{ route('expert-query.submit') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition">New query &rarr;</a>
        </div>

        @php
            $pipelineSteps = [
                'pending' => ['label' => 'Submitted', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                'assigned' => ['label' => 'Assigned', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
                'in_progress' => ['label' => 'Draft Review', 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
                'completed' => ['label' => 'Complete', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ];
            $statusOrder = ['pending', 'assigned', 'in_progress', 'completed'];
        @endphp

        @if ($activeQueries->isEmpty() && $recentCompleted->isEmpty())
            <div class="rounded-xl border border-dashed border-gray-200 bg-white/50 p-10 text-center">
                <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                </svg>
                <p class="mt-3 text-sm font-medium text-gray-500">No queries yet</p>
                <p class="mt-1 text-xs text-gray-400">Submit an expert query to see its progress here.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($activeQueries as $query)
                    <div class="rounded-xl border border-gray-200/60 bg-white p-5 shadow-sm">
                        <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                            <div class="min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900">{{ $query->title }}</h4>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    @if ($query->assignedResearcher)
                                        Assigned to {{ $query->assignedResearcher->name }}
                                    @else
                                        Awaiting assignment
                                    @endif
                                    &middot; {{ $query->turnaround_tier_enum->label() }}
                                    @if ($query->target_deadline)
                                        &middot; Due {{ $query->target_deadline->diffForHumans() }}
                                    @endif
                                </p>
                            </div>
                            @if ($query->target_deadline && $query->target_deadline->isFuture())
                                @php
                                    $hoursLeft = now()->diffInHours($query->target_deadline, false);
                                    $urgent = $hoursLeft < 6;
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $urgent ? 'bg-red-50 text-red-700 ring-1 ring-red-200/60' : 'bg-gray-50 text-gray-600 ring-1 ring-gray-200/60' }}">
                                    {{ $query->target_deadline->diffForHumans() }}
                                </span>
                            @endif
                        </div>

                        {{-- Pipeline steps --}}
                        <div class="flex items-center gap-0">
                            @foreach ($statusOrder as $idx => $statusKey)
                                @php
                                    $value = \App\Enums\QueryStatus::tryFrom($statusKey);
                                    $step = $pipelineSteps[$statusKey];
                                    $isReached = $query->status_enum === $value || array_search($query->status_enum->value, $statusOrder) >= $idx;
                                    $isCurrent = $query->status_enum === $value;
                                @endphp
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full transition-all duration-300
                                        {{ $isCurrent ? 'bg-blue-600 ring-2 ring-blue-200 ring-offset-2 ring-offset-white' : ($isReached ? 'bg-green-100' : 'bg-gray-100') }}">
                                        @if ($isReached)
                                            <svg class="h-4 w-4 {{ $isCurrent ? 'text-white' : 'text-green-600' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}" />
                                            </svg>
                                        @else
                                            <div class="h-2 w-2 rounded-full bg-gray-300"></div>
                                        @endif
                                    </div>
                                    <span class="mt-1.5 text-xs {{ $isCurrent ? 'font-semibold text-blue-600' : ($isReached ? 'text-gray-600' : 'text-gray-400') }}">
                                        {{ $step['label'] }}
                                    </span>
                                </div>
                                @if ($idx < count($statusOrder) - 1)
                                    <div class="flex-1 h-px -mt-5 {{ $isReached && array_search($query->status_enum->value, $statusOrder) > $idx ? 'bg-green-300' : 'bg-gray-200' }}"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach

                @if ($recentCompleted->isNotEmpty())
                    <details class="group">
                        <summary class="flex cursor-pointer items-center gap-2 text-xs text-gray-500 hover:text-gray-700 transition">
                            <svg class="h-3.5 w-3.5 transition-transform group-open:rotate-90" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                            Recently completed ({{ $recentCompleted->count() }})
                        </summary>
                        <div class="mt-3 space-y-2">
                            @foreach ($recentCompleted as $query)
                                <div class="flex items-center justify-between rounded-lg bg-gray-50 px-4 py-2.5 border border-gray-100/80">
                                    <span class="text-sm text-gray-700">{{ $query->title }}</span>
                                    <span class="text-xs text-green-600/70">{{ $query->resolved_at?->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        </div>
                    </details>
                @endif
            </div>
        @endif
    </section>

    {{-- 4. UPCOMING LEGISLATION --}}
    <section>
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Upcoming Legislation</h2>
                <p class="text-sm text-gray-500">Bills scheduled for floor debate</p>
            </div>
            <a href="{{ route('bills.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition">All bills &rarr;</a>
        </div>

        @if ($upcomingBills->isEmpty())
            <div class="rounded-xl border border-dashed border-gray-200 bg-white/50 p-10 text-center">
                <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <p class="mt-3 text-sm font-medium text-gray-500">No upcoming legislation</p>
                <p class="mt-1 text-xs text-gray-400">No bills are currently scheduled for floor debate.</p>
            </div>
        @else
            <div class="divide-y divide-gray-100 rounded-xl border border-gray-200/60 bg-white shadow-sm overflow-hidden">
                @foreach ($upcomingBills as $bill)
                    <div class="flex items-center gap-4 px-5 py-4 transition hover:bg-gray-50">
                        <span class="inline-flex shrink-0 items-center rounded-full px-2.5 py-0.5 text-xs font-medium w-28 text-center justify-center {{ $statusBadge[$bill->status_enum->value] ?? 'bg-gray-50 text-gray-600 ring-1 ring-gray-200/60' }}">
                            {{ $bill->status_enum->label() }}
                        </span>

                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $bill->title }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $bill->local_identifier }}
                                @if ($bill->house_origin)
                                    &middot; {{ $bill->house_origin }}
                                @endif
                                @if ($bill->tabled_at)
                                    &middot; Tabled {{ $bill->tabled_at->format('j M Y') }}
                                @endif
                            </p>
                        </div>

                        <a href="{{ route('bills.show', $bill->local_identifier) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white/80 px-3 py-1.5 text-xs font-medium text-gray-600 shadow-sm hover:bg-white hover:border-gray-300 hover:shadow-md transition-all shrink-0 backdrop-blur-sm">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501A11.972 11.972 0 0012 18.75c.504 0 .998-.034 1.483-.101.487-.067.973-.164 1.45-.287.324-.084.678.042.876.337a1.49 1.49 0 01.24.87c0 .346.115.724.334.996.078.097.178.174.29.228.63.305 1.295.527 1.992.654.14.025.28-.022.371-.108a.534.534 0 00.139-.384V8.25c0-2.29-1.077-4.346-2.75-5.618A9.028 9.028 0 0012 1.5c-1.214 0-2.378.24-3.44.678A7.448 7.448 0 005.273 3.55a.372.372 0 00-.068.582A8.977 8.977 0 014.5 7.5v4.26z" />
                            </svg>
                            Details
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
