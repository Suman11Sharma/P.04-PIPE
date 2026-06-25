<div>
    {{-- FILTER BAR --}}
    <div class="mb-6 rounded-xl border border-gray-200/60 bg-white p-4 shadow-sm">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
            <div class="sm:col-span-2">
                <label for="search" class="block text-xs font-medium text-gray-500 mb-1.5">Search bills</label>
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input id="search" type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Search by title or bill ID..."
                        class="block w-full rounded-lg border-0 bg-white py-2.5 pl-10 pr-4 text-sm text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 transition" />
                </div>
            </div>
            <div>
                <label for="filterStatus" class="block text-xs font-medium text-gray-500 mb-1.5">Current stage</label>
                <select id="filterStatus" wire:model.live="filterStatus"
                    class="block w-full rounded-lg border-0 bg-white py-2.5 pl-3 pr-8 text-sm text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 focus:ring-2 focus:ring-inset focus:ring-blue-600 transition">
                    <option value="">All stages</option>
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="filterHouse" class="block text-xs font-medium text-gray-500 mb-1.5">House of origin</label>
                <select id="filterHouse" wire:model.live="filterHouse"
                    class="block w-full rounded-lg border-0 bg-white py-2.5 pl-3 pr-8 text-sm text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 focus:ring-2 focus:ring-inset focus:ring-blue-600 transition">
                    <option value="">All houses</option>
                    @foreach ($houseOptions as $house)
                        <option value="{{ $house }}">{{ $house }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if ($filterStatus || $filterHouse || $search)
            <div class="mt-3 flex flex-wrap items-center gap-2">
                <span class="text-xs text-gray-500">Active filters:</span>
                @if ($filterStatus)
                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-0.5 text-xs text-blue-700 ring-1 ring-blue-200/60">
                        Status: {{ $statusOptions[$filterStatus] ?? $filterStatus }}
                        <button wire:click="clearFilter('filterStatus')" class="hover:text-blue-900 transition">&times;</button>
                    </span>
                @endif
                @if ($filterHouse)
                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-0.5 text-xs text-blue-700 ring-1 ring-blue-200/60">
                        House: {{ $filterHouse }}
                        <button wire:click="clearFilter('filterHouse')" class="hover:text-blue-900 transition">&times;</button>
                    </span>
                @endif
                @if ($search)
                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-0.5 text-xs text-blue-700 ring-1 ring-blue-200/60">
                        Search: "{{ $search }}"
                        <button wire:click="$set('search', '')" class="hover:text-blue-900 transition">&times;</button>
                    </span>
                @endif
                <button wire:click="resetFilters" class="text-xs text-gray-500 hover:text-gray-700 underline transition">Clear all</button>
            </div>
        @endif
    </div>

    @php
        $stepperColors = [
            'tabled' => 'bg-gray-500',
            'first_reading' => 'bg-blue-500',
            'second_reading' => 'bg-indigo-500',
            'committee_stage' => 'bg-amber-500',
            'passed' => 'bg-green-500',
        ];
        $statusBadgeStyle = [
            'tabled' => 'bg-gray-50 text-gray-600 ring-1 ring-gray-200/60',
            'first_reading' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/60',
            'second_reading' => 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200/60',
            'committee_stage' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/60',
            'passed' => 'bg-green-50 text-green-700 ring-1 ring-green-200/60',
            'vetoed' => 'bg-red-50 text-red-700 ring-1 ring-red-200/60',
        ];
    @endphp

    <div class="overflow-x-auto rounded-xl border border-gray-200/60 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="text-xs font-medium uppercase tracking-wider text-gray-500">
                    <th scope="col" class="px-5 py-4 text-left">
                        <button wire:click="sortBy('local_identifier')" class="flex items-center gap-1 hover:text-gray-700 transition">
                            Bill ID
                            @if ($sortField === 'local_identifier')
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    @if ($sortDirection === 'asc')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    @endif
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th scope="col" class="px-5 py-4 text-left">
                        <button wire:click="sortBy('title')" class="flex items-center gap-1 hover:text-gray-700 transition">
                            Title
                            @if ($sortField === 'title')
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    @if ($sortDirection === 'asc')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    @endif
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th scope="col" class="px-5 py-4 text-left">House</th>
                    <th scope="col" class="px-5 py-4 text-left">Sector</th>
                    <th scope="col" class="px-5 py-4 text-left min-w-[280px]">Progress</th>
                    <th scope="col" class="px-5 py-4 text-left">
                        <button wire:click="sortBy('tabled_at')" class="flex items-center gap-1 hover:text-gray-700 transition">
                            Tabled
                            @if ($sortField === 'tabled_at')
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    @if ($sortDirection === 'asc')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    @endif
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th scope="col" class="px-5 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($bills as $bill)
                    @php
                        $statusIdx = $this->stepperIndex($bill->status_enum->value);
                        $isVetoed = $bill->status_enum->value === 'vetoed';
                    @endphp
                    <tr class="group hover:bg-gray-50 transition">
                        <td class="whitespace-nowrap px-5 py-4">
                            <a href="{{ route('bills.show', $bill->local_identifier) }}"
                               class="font-mono text-xs font-medium text-blue-600 hover:text-blue-700 transition">
                                {{ $bill->local_identifier }}
                            </a>
                        </td>
                        <td class="px-5 py-4">
                            <a href="{{ route('bills.show', $bill->local_identifier) }}"
                               class="text-sm font-medium text-gray-900 hover:text-blue-600 transition line-clamp-1 max-w-xs">
                                {{ $bill->title }}
                            </a>
                        </td>
                        <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">{{ $bill->house_origin ?? '—' }}</td>
                        <td class="whitespace-nowrap px-5 py-4">
                            @if ($bill->relationLoaded('sector') && $bill->sector)
                                <span class="text-sm text-gray-500">{{ $bill->sector->name }}</span>
                            @else
                                <span class="text-sm text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            @if ($isVetoed)
                                <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700 ring-1 ring-red-200/60">Vetoed</span>
                            @else
                                <div class="flex items-center gap-1">
                                    @foreach ($stepperOrder as $sIdx => $stageKey)
                                        @php $isReached = $sIdx <= $statusIdx; $stage = $stepperStages[$stageKey]; @endphp
                                        <div class="flex-1 flex flex-col items-center">
                                            <div class="h-2 w-full rounded-full transition-all duration-300
                                                {{ $isReached ? $stepperColors[$stageKey] : 'bg-gray-200' }}
                                                {{ $sIdx === 0 ? 'rounded-r-none' : ($sIdx === count($stepperOrder) - 1 ? 'rounded-l-none' : 'rounded-none') }}">
                                            </div>
                                            <span class="mt-1 text-[10px] {{ $isReached ? 'text-gray-500' : 'text-gray-300' }}">{{ $stage['label'] }}</span>
                                        </div>
                                        @if ($sIdx < count($stepperOrder) - 1)
                                            <div class="w-px self-stretch bg-gray-200 last:hidden"></div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">{{ $bill->tabled_at?->format('j M Y') ?? '—' }}</td>
                        <td class="whitespace-nowrap px-5 py-4 text-right">
                            <a href="{{ route('bills.show', $bill->local_identifier) }}"
                               class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white/80 px-3 py-1.5 text-xs font-medium text-gray-600 shadow-sm hover:bg-white hover:border-gray-300 hover:shadow-md transition-all backdrop-blur-sm">
                                Compare
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center">
                            <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <p class="mt-3 text-sm font-medium text-gray-500">No bills found</p>
                            <p class="mt-1 text-xs text-gray-400">Try adjusting your filters or search query.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($bills->hasPages())
        <div class="mt-4">{{ $bills->links(data: ['class' => 'text-sm']) }}</div>
    @endif

    <div class="mt-3 text-xs text-gray-500 text-right">
        Showing {{ $bills->firstItem() ?? 0 }}–{{ $bills->lastItem() ?? 0 }} of {{ $bills->total() }} bills
    </div>
</div>
