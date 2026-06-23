<div>
    {{-- SIDEBAR --}}
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 border-r border-gray-200/80 bg-white/90 backdrop-blur-xl shadow-sm flex flex-col transition-transform duration-300 -translate-x-full md:translate-x-0">
        <div class="flex items-center gap-2.5 px-5 pt-4 pb-3 shrink-0">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 shadow-sm"><svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5l8.5 5.5-8.5 5.5L3.5 13 12 7.5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5l8.5 5.5-8.5 5.5L3.5 8 12 2.5z" /></svg></div>
                <span class="text-lg font-bold tracking-tight text-gray-900">PIPE</span>
            </a>
            <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="md:hidden absolute right-3 top-4 p-1 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>
        <div class="px-5 py-3 border-b border-gray-200/60">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-50 to-blue-100/80 text-sm font-bold text-blue-600 shadow-sm">{{ substr(auth()->user()->name, 0, 1) }}{{ substr(strrchr(auth()->user()->name, ' ') ?: auth()->user()->name, 1, 1) }}</div>
                <div class="min-w-0"><p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p><p class="text-xs text-gray-500 truncate">Senior Researcher</p></div>
            </div>
        </div>
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                Dashboard
            </a>
            <a href="{{ route('researcher.kanban') }}" class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-sm">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" /></svg>
                Research Workspace
            </a>
            <span class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium text-gray-500">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5h3m-6.75 2.25h10.5a2.25 2.25 0 002.25-2.25v-9.093M6.75 21.75H5.25a2.25 2.25 0 01-2.25-2.25v-9.093M21.75 10.5L12 2.25 2.25 10.5" /></svg>
                Senior Review
            </span>
        </nav>
        <div class="px-3 py-3 border-t border-gray-200/60">
            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3.5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all"><svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>Sign Out</button></form>
        </div>
    </aside>

    <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black/20 backdrop-blur-sm hidden md:hidden" onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full'); this.classList.toggle('hidden')"></div>

    {{-- MAIN --}}
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 md:ml-64">
        <header class="sticky top-0 z-30 border-b border-gray-200/80 bg-white/80 backdrop-blur-xl shadow-sm">
            <div class="flex items-center justify-between px-4 sm:px-6 py-3">
                <div class="flex items-center gap-3">
                    <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full'); document.getElementById('sidebar-overlay').classList.toggle('hidden')"
                        class="md:hidden p-2 -ml-2 rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg></button>
                    <span class="text-sm font-medium text-gray-500">Senior Review</span>
                </div>
                <a href="/" class="text-xs text-gray-400 hover:text-gray-600 transition-colors"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg></a>
            </div>
        </header>

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            {{-- Query Header --}}
            <div class="mb-6">
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-amber-200/60">Senior Editorial Review</span>
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                        {{ $query->turnaround_tier_enum->value === '30min_floor_support' ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/60' : ($query->turnaround_tier_enum->value === '48hr_analysis' ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/60' : 'bg-gray-50 text-gray-600 ring-1 ring-gray-200/60') }}">
                        {{ $query->turnaround_tier_enum->label() }}
                    </span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $query->title }}</h1>
                <div class="mt-1 flex flex-wrap gap-3 text-sm text-gray-500">
                    <span>Submitted by {{ $query->submitter?->name ?? 'Unknown MP' }}</span>
                    @if ($query->assignedResearcher) <span>&middot; Prepared by {{ $query->assignedResearcher->name }}</span> @endif
                    @if ($query->bill) <span>&middot; Bill: {{ $query->bill->local_identifier }}</span> @endif
                    <span>&middot; Created {{ $query->created_at?->diffForHumans() }}</span>
                </div>
            </div>

            {{-- Original Request --}}
            <div class="mb-6 rounded-xl border border-gray-200/60 bg-white p-5 shadow-sm">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">MP's Original Request</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $query->explicit_description }}</p>
            </div>

            {{-- Side-by-side editing pane --}}
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
                <div class="flex flex-col rounded-xl border border-gray-200/60 bg-white shadow-sm overflow-hidden">
                    <div class="border-b border-gray-200/60 bg-gray-50 px-4 py-3">
                        <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500">Original Researcher Response</h3>
                    </div>
                    <div class="flex-1 p-4">
                        @if ($originalResponse)
                            <div class="prose-serif max-w-none text-sm text-gray-600 leading-relaxed whitespace-pre-wrap">{{ $originalResponse }}</div>
                        @else
                            <p class="text-sm text-gray-400 italic">No response has been written yet.</p>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col rounded-xl border border-gray-200/60 bg-white shadow-sm overflow-hidden">
                    <div class="border-b border-gray-200/60 bg-gray-50 px-4 py-3 flex items-center justify-between">
                        <h3 class="text-xs font-semibold uppercase tracking-wider text-{{ $isModified ? 'amber-600' : 'gray-500' }}">{{ $isModified ? 'MODIFIED' : 'Revised Response' }}</h3>
                        @if ($isModified) <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-medium text-amber-700 ring-1 ring-amber-200/60">Unsaved changes</span> @endif
                    </div>
                    <div class="flex-1 p-4">
                        <textarea wire:model="revisedResponse" rows="12"
                            class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 transition font-mono leading-relaxed"
                            placeholder="Edit the response text here..."></textarea>
                        @error('revisedResponse') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Senior Notes & Actions --}}
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 rounded-xl border border-gray-200/60 bg-white p-5 shadow-sm">
                    <label for="seniorNotes" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Editorial Notes</label>
                    <textarea id="seniorNotes" wire:model="seniorNotes" rows="4"
                        class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 transition"
                        placeholder="Add internal editorial notes (not visible to the MP)..."></textarea>
                </div>
                <div class="space-y-3">
                    <button wire:click="saveDraft" class="flex w-full items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white/80 px-4 py-3 text-sm font-medium text-gray-600 shadow-sm hover:bg-white hover:border-gray-300 hover:shadow-md transition-all backdrop-blur-sm">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        Save Draft Notes
                    </button>
                    <button wire:click="requestRevisions" class="flex w-full items-center justify-center gap-2 rounded-lg border border-amber-200/60 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-700 shadow-sm hover:bg-amber-100 transition-all">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" /></svg>
                        Request Revisions
                    </button>
                    <button wire:click="approveAndPublish" wire:loading.attr="disabled"
                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 text-sm font-semibold text-white shadow-md hover:from-blue-700 hover:to-blue-800 disabled:opacity-50 transition-all">
                        <svg wire:loading class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" /></svg>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Approve &amp; Publish
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
