<div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50/50">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Query</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Submitted By</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Priority</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Date</th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($queries as $query)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-4 py-3.5">
                            <p class="text-sm font-medium text-gray-900 truncate max-w-[220px]">{{ $query->title }}</p>
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-gray-100 text-[10px] font-bold text-gray-500">
                                    {{ substr($query->submitter?->name ?? '?', 0, 1) }}
                                </div>
                                <span class="text-sm text-gray-600">{{ $query->submitter?->name ?? 'Unknown' }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            @php
                                $tierColors = [
                                    '30min_floor_support' => 'bg-amber-100 text-amber-700 ring-1 ring-amber-200/60',
                                    '48hr_analysis' => 'bg-blue-100 text-blue-700 ring-1 ring-blue-200/60',
                                    'standard_request' => 'bg-gray-100 text-gray-600 ring-1 ring-gray-200/60',
                                ];
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $tierColors[$query->turnaround_tier_enum->value] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $query->turnaround_tier_enum->label() }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700 ring-1 ring-yellow-200/60',
                                    'assigned' => 'bg-blue-100 text-blue-700 ring-1 ring-blue-200/60',
                                    'in_progress' => 'bg-indigo-100 text-indigo-700 ring-1 ring-indigo-200/60',
                                    'senior_review' => 'bg-purple-100 text-purple-700 ring-1 ring-purple-200/60',
                                    'completed' => 'bg-green-100 text-green-700 ring-1 ring-green-200/60',
                                ];
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColors[$query->status_enum->value] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $query->status_enum->label() }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap text-sm text-gray-500">
                            {{ $query->created_at->format('j M Y') }}
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap text-right">
                            @if ($query->status_enum->value === 'pending' || !$query->assigned_researcher_id)
                                <div class="flex items-center justify-end gap-2">
                                    <select
                                        wire:change="assignQuery({{ $query->id }}, $event.target.value)"
                                        class="rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-600 shadow-sm hover:border-gray-300 transition">
                                        <option value="">Assign to...</option>
                                        @foreach ($researchers as $researcher)
                                            <option value="{{ $researcher->id }}">{{ $researcher->name }} ({{ $researcher->role_label }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <span class="text-xs text-gray-400">
                                    Assigned to {{ $query->assignedResearcher?->name ?? '—' }}
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center">
                            <svg class="mx-auto h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No pending queries</p>
                            <p class="text-xs text-gray-400">New queries will appear here once submitted by MPs.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($queries->hasPages())
        <div class="px-4 py-3 border-t border-gray-100">
            {{ $queries->links() }}
        </div>
    @endif
</div>
