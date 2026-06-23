<div>
    {{-- ===== SIDEBAR ===== --}}
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 border-r border-gray-200/80 bg-white/90 backdrop-blur-xl shadow-sm flex flex-col transition-transform duration-300 -translate-x-full md:translate-x-0">
        <div class="flex items-center gap-2.5 px-5 pt-4 pb-3 shrink-0">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 shadow-sm transition-shadow group-hover:shadow-md">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5l8.5 5.5-8.5 5.5L3.5 13 12 7.5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5l8.5 5.5-8.5 5.5L3.5 8 12 2.5z" />
                    </svg>
                </div>
                <span class="text-lg font-bold tracking-tight text-gray-900">PIPE</span>
            </a>
            <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="md:hidden absolute right-3 top-4 p-1 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
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
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                Dashboard
            </a>
            <a href="{{ route('bills.index') }}" class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                Legislative Tracker
            </a>
            <a href="{{ route('expert-query.submit') }}" class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-sm">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" /></svg>
                Ask an Expert
            </a>
        </nav>
        <div class="px-3 py-3 border-t border-gray-200/60">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
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
                    <span class="text-sm font-medium text-gray-500">Ask an Expert</span>
                </div>
                <div class="flex items-center gap-3">
                    <a href="/" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                    </a>
                </div>
            </div>
        </header>

        <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-50 to-blue-100/80 shadow-sm">
                        <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Ask an Expert</h1>
                        <p class="text-sm text-gray-500">Submit a research request to the intelligence division</p>
                    </div>
                </div>
            </div>

            <form wire:submit="submit" class="space-y-8">
                {{-- SECTION 1: Query Details --}}
                <div class="rounded-xl border border-gray-200/60 bg-white p-6 shadow-sm space-y-5">
                    <h2 class="text-sm font-semibold text-gray-900">Query Details</h2>

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">Query Title</label>
                        <input id="title" type="text" wire:model="title"
                            placeholder="e.g., Economic impact of proposed mining regulations"
                            class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm transition" />
                        @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Detailed Description</label>
                        <textarea id="description" wire:model="explicit_description" rows="5"
                            placeholder="Describe the analysis you need, including specific questions, data points, and any context or background..."
                            class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm transition"></textarea>
                        @error('explicit_description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Supporting Documents</label>
                        <div class="mt-1 flex justify-center rounded-lg border-2 border-dashed border-gray-200 bg-gray-50/50 px-6 py-8">
                            <div class="text-center">
                                <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                </svg>
                                <div class="mt-3 flex text-sm text-gray-500">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-700">
                                        <span>Upload files</span>
                                        <input id="file-upload" type="file" wire:model="attachments" multiple class="sr-only" />
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">PDF, Office docs, images, audio/video up to 15MB each</p>
                            </div>
                        </div>
                        @error('attachments.*') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        <div wire:loading wire:target="attachments" class="mt-2 text-xs text-blue-600">Uploading files...</div>
                        @if ($attachments && count($attachments) > 0)
                            <ul class="mt-3 space-y-1">
                                @foreach ($attachments as $idx => $file)
                                    <li class="flex items-center gap-2 text-xs text-gray-500">
                                        <svg class="h-3.5 w-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $file->getClientOriginalName() }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                {{-- SECTION 2: Turnaround Tier --}}
                <div class="rounded-xl border border-gray-200/60 bg-white p-6 shadow-sm space-y-4">
                    <h2 class="text-sm font-semibold text-gray-900">Priority &amp; Turnaround</h2>
                    <p class="text-xs text-gray-500">Select the urgency level for your request</p>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                        @foreach ($tierOptions as $tierKey => $tier)
                            <label class="relative cursor-pointer rounded-lg border p-4 transition-all duration-150
                                {{ $turnaroundTier === $tierKey ? 'border-blue-500/50 bg-blue-50 ring-1 ring-blue-500/20' : 'border-gray-200 bg-white hover:border-gray-300' }}">
                                <input type="radio" wire:model="turnaroundTier" value="{{ $tierKey }}" class="sr-only" />
                                <div class="flex items-start gap-3">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg
                                        {{ $turnaroundTier === $tierKey ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-500' }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $tier['icon'] }}" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium {{ $turnaroundTier === $tierKey ? 'text-gray-900' : 'text-gray-700' }}">{{ $tier['label'] }}</span>
                                        <span class="block text-xs text-gray-500 mt-0.5">{{ $tier['description'] }}</span>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('turnaroundTier') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- SECTION 3: Conditional Bill Reference --}}
                @if ($turnaroundTier === '30min_floor_support')
                    <div class="rounded-xl border border-amber-200/60 bg-gradient-to-r from-amber-50 to-amber-100/50 p-6 shadow-sm space-y-4">
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            <h2 class="text-sm font-semibold text-amber-800">Floor Support — Bill Reference Required</h2>
                        </div>
                        <div>
                            <label for="billId" class="block text-sm font-medium text-gray-700 mb-1.5">Associated Bill or Floor Debate Reference</label>
                            <select id="billId" wire:model="billId"
                                class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm transition">
                                <option value="">— Select a bill —</option>
                                @foreach ($billOptions as $bill)
                                    <option value="{{ $bill['id'] }}">{{ $bill['local_identifier'] }} — {{ Str::limit($bill['title'], 60) }}</option>
                                @endforeach
                            </select>
                            @error('billId') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            <p class="mt-1.5 text-xs text-gray-500">Choose the bill currently being debated on the floor.</p>
                        </div>
                    </div>
                @endif

                {{-- FORM ACTIONS --}}
                <div class="flex items-center justify-between">
                    <button type="button" wire:click="cancel" class="text-sm text-gray-500 hover:text-gray-700 transition">
                        Discard draft
                    </button>
                    <button type="submit" wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-md hover:from-blue-700 hover:to-blue-800 disabled:opacity-50 transition-all">
                        <svg wire:loading class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                        </svg>
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
