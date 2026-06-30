@extends('components.layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    {{-- Page header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manage Users</h1>
            <p class="mt-1 text-sm text-gray-500">View and manage all platform users</p>
        </div>
        <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700 ring-1 ring-blue-200/60">
            {{ $users->total() }} total users
        </span>
    </div>

    {{-- Users table --}}
    <div class="rounded-xl border border-gray-200/60 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">User</th>
                        <th scope="col" class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Role</th>
                        <th scope="col" class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Constituency</th>
                        <th scope="col" class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        <th scope="col" class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-50 to-blue-100/80 text-sm font-bold text-blue-600 shadow-sm">
                                        {{ substr($user->name, 0, 1) }}{{ substr(strrchr($user->name, ' ') ?: $user->name, 1, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                    {{ match($user->role_enum->value) {
                                        'admin' => 'bg-purple-50 text-purple-700 ring-1 ring-purple-200/60',
                                        'senior_researcher' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/60',
                                        'junior_researcher' => 'bg-cyan-50 text-cyan-700 ring-1 ring-cyan-200/60',
                                        'committee_chair' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/60',
                                        'mp' => 'bg-green-50 text-green-700 ring-1 ring-green-200/60',
                                        'staff' => 'bg-gray-50 text-gray-600 ring-1 ring-gray-200/60',
                                        default => 'bg-gray-50 text-gray-600 ring-1 ring-gray-200/60',
                                    } }}">
                                    {{ $user->role_label }}
                                </span>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $user->constituency?->name ?? '—' }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                @if ($user->email_verified_at)
                                    <span class="inline-flex items-center gap-1 text-xs text-green-600">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Verified
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs text-amber-600">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                        </svg>
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('j M Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($users->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
