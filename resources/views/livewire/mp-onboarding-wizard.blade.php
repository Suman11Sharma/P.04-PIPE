<div>
    {{-- SIDEBAR --}}
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 border-r border-gray-200/80 bg-white/90 backdrop-blur-xl shadow-sm flex flex-col transition-transform duration-300 -translate-x-full md:translate-x-0">
        <div class="flex items-center gap-2.5 px-5 pt-4 pb-3 shrink-0">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 shadow-sm"><svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5l8.5 5.5-8.5 5.5L3.5 13 12 7.5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5l8.5 5.5-8.5 5.5L3.5 8 12 2.5z" /></svg></div>
                <span class="text-lg font-bold tracking-tight text-gray-900">PIPE</span>
            </a>
        </div>
        <div class="px-5 py-3 border-b border-gray-200/60">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-50 to-blue-100/80 text-sm font-bold text-blue-600 shadow-sm">{{ substr(auth()->user()->name, 0, 1) }}{{ substr(strrchr(auth()->user()->name, ' ') ?: auth()->user()->name, 1, 1) }}</div>
                <div class="min-w-0"><p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p><p class="text-xs text-gray-500 truncate">Setup</p></div>
            </div>
        </div>
        <div class="px-3 py-3 border-t border-gray-200/60 mt-auto">
            <button wire:click="skip" class="flex w-full items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white/80 px-4 py-2.5 text-sm font-medium text-gray-600 shadow-sm hover:bg-white hover:border-gray-300 hover:shadow-md transition-all backdrop-blur-sm">Skip for now &rarr;</button>
        </div>
    </aside>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 md:ml-64">
        <header class="sticky top-0 z-30 border-b border-gray-200/80 bg-white/80 backdrop-blur-xl shadow-sm">
            <div class="flex items-center justify-between px-4 sm:px-6 py-3">
                <div class="flex items-center gap-3">
                    <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="md:hidden p-2 -ml-2 rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg></button>
                    <span class="text-sm font-medium text-gray-500">Profile Setup</span>
                </div>
            </div>
        </header>

        <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
            {{-- Progress bar --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-lg font-semibold text-gray-900">Setup your profile</h2>
                    <span class="text-sm text-gray-500">Step {{ $step }} of {{ $totalSteps }}</span>
                </div>
                <div class="h-2 rounded-full bg-gray-200">
                    <div class="h-2 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 transition-all duration-500 ease-out" style="width: {{ $progressPercentage }}%"></div>
                </div>
            </div>

            {{-- Step Card --}}
            <div class="rounded-xl border border-gray-200/60 bg-white p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-blue-50 to-blue-100/80 text-blue-600 font-bold text-sm shadow-sm">{{ $step }}</div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $this->stepTitle }}</h3>
                        <p class="text-sm text-gray-500">{{ $this->stepDescription }}</p>
                    </div>
                </div>

                @if ($step === 1)
                    <div class="space-y-6">
                        <div>
                            <label for="province" class="block text-sm font-medium leading-6 text-gray-700">Select Province</label>
                            <div class="mt-2">
                                <select id="province" wire:model.live="selectedProvince"
                                    class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm transition">
                                    <option value="">— Choose a province —</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province }}">{{ $province }}</option>
                                    @endforeach
                                </select>
                                @error('selectedProvince') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        @if ($selectedProvince)
                            <div>
                                <label for="constituency" class="block text-sm font-medium leading-6 text-gray-700">Select Constituency</label>
                                <div class="mt-2">
                                    <select id="constituency" wire:model="selectedConstituencyId"
                                        class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm transition">
                                        <option value="">— Choose a constituency —</option>
                                        @foreach ($availableConstituencies as $constituency)
                                            <option value="{{ $constituency['id'] }}">{{ $constituency['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedConstituencyId') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        @endif
                        <div class="rounded-lg bg-gray-50 p-4 text-xs text-gray-500 border border-gray-100/80">
                            <svg class="inline h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                            Your constituency mapping determines the geographic intelligence shown on your dashboard.
                        </div>
                    </div>
                @elseif ($step === 2)
                    <div class="space-y-4">
                        <p class="text-sm text-gray-500 mb-4">Select the parliamentary committees you are officially assigned to:</p>
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            @foreach ($committeeOptions as $key => $label)
                                <label class="relative flex cursor-pointer items-center gap-3 rounded-lg border px-4 py-3 transition duration-150
                                    {{ in_array($key, $selectedCommittees) ? 'border-blue-500/50 bg-blue-50 ring-1 ring-blue-500/20' : 'border-gray-200 bg-white hover:border-gray-300' }}">
                                    <input type="checkbox" value="{{ $key }}" wire:model="selectedCommittees"
                                        class="h-4 w-4 rounded border-gray-300 bg-white text-blue-600 focus:ring-blue-500 focus:ring-offset-0" />
                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('selectedCommittees') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                @elseif ($step === 3)
                    <div class="space-y-4">
                        <p class="text-sm text-gray-500 mb-4">Select the policy sectors you want to track for personalised briefings:</p>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            @forelse ($availableSectors as $sector)
                                <label class="relative flex cursor-pointer flex-col gap-2 rounded-lg border p-5 transition-all duration-150
                                    {{ in_array($sector['id'], $selectedSectorIds) ? 'border-blue-500/50 bg-blue-50 ring-1 ring-blue-500/20 shadow-sm' : 'border-gray-200 bg-white hover:border-gray-300' }}">
                                    <div class="flex items-start gap-3">
                                        <input type="checkbox" value="{{ $sector['id'] }}" wire:model="selectedSectorIds"
                                            class="mt-0.5 h-4 w-4 rounded border-gray-300 bg-white text-blue-600 focus:ring-blue-500 focus:ring-offset-0" />
                                        <div>
                                            <span class="block text-sm font-medium text-gray-700">{{ $sector['name'] }}</span>
                                            @if (!empty($sector['slug'])) <span class="text-xs text-gray-500">{{ $sector['slug'] }}</span> @endif
                                        </div>
                                    </div>
                                </label>
                            @empty
                                <div class="col-span-full rounded-lg bg-gray-50 p-6 text-center border border-gray-100/80">
                                    <p class="text-sm text-gray-500">No sectors have been configured yet.</p>
                                </div>
                            @endforelse
                        </div>
                        @error('selectedSectorIds') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                @endif
            </div>

            {{-- Navigation --}}
            <div class="mt-6 flex items-center justify-between">
                <div>
                    @if ($step > 1)
                        <button wire:click="previous" type="button"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white/80 px-4 py-2.5 text-sm font-medium text-gray-600 shadow-sm hover:bg-white hover:border-gray-300 hover:shadow-md transition-all backdrop-blur-sm">
                            &larr; Back
                        </button>
                    @endif
                </div>
                <div>
                    @if ($step < $totalSteps)
                        <button wire:click="next" type="button"
                            class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-2.5 text-sm font-semibold text-white shadow-md hover:from-blue-700 hover:to-blue-800 transition-all">
                            Continue &rarr;
                        </button>
                    @else
                        <button wire:click="complete" type="button"
                            class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-green-600 to-green-700 px-6 py-2.5 text-sm font-semibold text-white shadow-md hover:from-green-700 hover:to-green-800 transition-all">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            Complete Setup
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
