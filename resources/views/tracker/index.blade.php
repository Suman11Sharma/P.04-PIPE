@extends('components.layouts.app')

@section('title', 'Activity Tracker')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    {{-- Page header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Activity Tracker</h1>
            <p class="mt-1 text-sm text-gray-500">Real-time overview of platform activity across all sections</p>
        </div>
    </div>



    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="rounded-xl border border-gray-200/60 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_users'] }}</p>
                    <p class="text-xs text-gray-500">Platform Users</p>
                </div>
            </div>
        </div>
        <div class="rounded-xl border border-gray-200/60 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_queries'] }}</p>
                    <p class="text-xs text-gray-500">Expert Queries</p>
                </div>
            </div>
        </div>
        <div class="rounded-xl border border-gray-200/60 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-50 text-green-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['policy_briefs'] }}</p>
                    <p class="text-xs text-gray-500">Policy Briefs</p>
                </div>
            </div>
        </div>
        <div class="rounded-xl border border-gray-200/60 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_bills'] }}</p>
                    <p class="text-xs text-gray-500">Active Bills</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Recent Expert Queries --}}
        <div class="rounded-xl border border-gray-200/60 bg-white shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Recent Expert Queries</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($recentQueries as $query)
                    <div class="px-5 py-3.5 hover:bg-gray-50 transition">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $query->title }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            {{ $query->user?->name ?? 'Unknown' }} &middot; {{ $query->created_at->diffForHumans() }}
                        </p>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center">
                        <p class="text-sm text-gray-400">No queries submitted yet</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Bills --}}
        <div class="rounded-xl border border-gray-200/60 bg-white shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Recently Tabled Bills</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($recentBills as $bill)
                    <div class="px-5 py-3.5 hover:bg-gray-50 transition">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $bill->title }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            {{ $bill->local_identifier }} &middot; {{ $bill->tabled_at?->diffForHumans() ?? 'N/A' }}
                        </p>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center">
                        <p class="text-sm text-gray-400">No bills tabled yet</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Policy Briefs --}}
        <div class="rounded-xl border border-gray-200/60 bg-white shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Published Policy Briefs</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($recentBriefs as $brief)
                    <div class="px-5 py-3.5 hover:bg-gray-50 transition">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $brief->title }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            {{ $brief->published_at?->diffForHumans() ?? 'Unpublished' }}
                        </p>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center">
                        <p class="text-sm text-gray-400">No briefs published yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
