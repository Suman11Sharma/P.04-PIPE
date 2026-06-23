@extends('components.layouts.app')

@section('title', $bill->title . ' — Comparison')

@push('styles')
<style>
    /* ── Diff highlighting layer ─────────────────────────────── */
    .diff-added {
        background-color: rgba(16, 185, 129, 0.06);
        border-left: 3px solid rgb(16, 185, 129);
    }
    .diff-added ins {
        background-color: rgba(16, 185, 129, 0.15);
        text-decoration: none;
        border-radius: 2px;
        padding: 0 2px;
    }
    .diff-removed {
        background-color: rgba(239, 68, 68, 0.06);
        border-left: 3px solid rgb(239, 68, 68);
    }
    .diff-removed del {
        background-color: rgba(239, 68, 68, 0.15);
        text-decoration: line-through;
        border-radius: 2px;
        padding: 0 2px;
    }
    .diff-modified {
        background-color: rgba(99, 102, 241, 0.05);
        border-left: 3px solid rgb(99, 102, 241);
    }
    .diff-modified ins {
        background-color: rgba(99, 102, 241, 0.12);
        text-decoration: none;
        border-radius: 2px;
        padding: 0 2px;
    }
    .diff-modified del {
        background-color: rgba(239, 68, 68, 0.12);
        text-decoration: line-through;
        border-radius: 2px;
        padding: 0 2px;
    }

    .diff-column {
        max-height: 70vh;
        overflow-y: auto;
    }
    .diff-column::-webkit-scrollbar { width: 4px; }
    .diff-column::-webkit-scrollbar-track { background: transparent; }
    .diff-column::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 2px; }

    .vote-bar-yea { background-color: rgb(16, 185, 129); }
    .vote-bar-nay { background-color: rgb(239, 68, 68); }
    .vote-bar-abstain { background-color: rgb(156, 163, 175); }

    .sidebar-panel {
        transition: max-height 0.3s ease, opacity 0.25s ease, padding 0.3s ease;
        max-height: 0;
        opacity: 0;
        overflow: hidden;
        padding-top: 0;
        padding-bottom: 0;
    }
    .sidebar-panel.open {
        max-height: 600px;
        opacity: 1;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    {{-- Bill Header --}}
    <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
        <div class="min-w-0 flex-1">
            <div class="flex items-center gap-3 mb-2">
                <span class="font-mono text-xs font-medium text-blue-600">{{ $bill->local_identifier }}</span>
                @php
                    $badgeMap = [
                        'tabled' => 'bg-gray-50 text-gray-600 ring-1 ring-gray-200/60',
                        'first_reading' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/60',
                        'second_reading' => 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200/60',
                        'committee_stage' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/60',
                        'passed' => 'bg-green-50 text-green-700 ring-1 ring-green-200/60',
                        'vetoed' => 'bg-red-50 text-red-700 ring-1 ring-red-200/60',
                    ];
                @endphp
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeMap[$bill->status_enum->value] ?? 'bg-gray-50 text-gray-600 ring-1 ring-gray-200/60' }}">
                    {{ $bill->status_enum->label() }}
                </span>
                @if ($bill->house_origin)
                    <span class="text-xs text-gray-500">{{ $bill->house_origin }}</span>
                @endif
            </div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $bill->title }}</h1>
            @if ($bill->tabled_at)
                <p class="mt-1 text-sm text-gray-500">Tabled on {{ $bill->tabled_at->format('j F Y') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4 text-xs text-gray-500">
            <span class="flex items-center gap-1.5">
                <span class="inline-block h-3 w-3 rounded bg-emerald-400/50"></span> Added
            </span>
            <span class="flex items-center gap-1.5">
                <span class="inline-block h-3 w-3 rounded bg-red-400/50"></span> Removed
            </span>
            <span class="flex items-center gap-1.5">
                <span class="inline-block h-3 w-3 rounded bg-indigo-400/50"></span> Modified
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        {{-- LEFT: Side-by-side comparison (3 cols) --}}
        <div class="lg:col-span-3">
            <div class="grid grid-cols-1 gap-0 md:grid-cols-2 rounded-xl border border-gray-200/60 overflow-hidden bg-white shadow-sm">
                <div class="border-b border-r-0 md:border-r border-gray-200/60 bg-gray-50 px-4 py-3">
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Original Bill Text</span>
                </div>
                <div class="border-b border-gray-200/60 bg-gray-50 px-4 py-3">
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Amended Bill Text</span>
                </div>

                <div class="diff-column bg-gray-50/30 p-4 space-y-3">
                    @forelse ($diffData as $section)
                        <div class="rounded-lg p-3 {{ $section['type'] === 'added' ? 'diff-added' : ($section['type'] === 'removed' ? 'diff-removed' : ($section['type'] === 'modified' ? 'diff-modified' : '')) }}">
                            @if (!empty($section['section']))
                                <p class="text-[10px] font-medium uppercase tracking-wider text-gray-400 mb-1">{{ $section['section'] }}</p>
                            @endif
                            <p class="text-sm leading-relaxed text-gray-600">
                                @if ($section['type'] === 'added')
                                    <del class="text-gray-400 italic">—</del>
                                @elseif ($section['type'] === 'removed')
                                    <del class="text-red-500/70">{{ $section['original'] }}</del>
                                @elseif ($section['type'] === 'modified')
                                    <del class="text-red-500/70">{{ $section['original'] }}</del>
                                @else
                                    {{ $section['original'] }}
                                @endif
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-sm text-gray-500">No original text available.</p>
                        </div>
                    @endforelse
                </div>

                <div class="diff-column bg-gray-50/30 p-4 space-y-3">
                    @forelse ($diffData as $section)
                        <div class="rounded-lg p-3 {{ $section['type'] === 'added' ? 'diff-added' : ($section['type'] === 'removed' ? 'diff-removed' : ($section['type'] === 'modified' ? 'diff-modified' : '')) }}">
                            @if (!empty($section['section']))
                                <p class="text-[10px] font-medium uppercase tracking-wider text-gray-400 mb-1">{{ $section['section'] }}</p>
                            @endif
                            <p class="text-sm leading-relaxed text-gray-600">
                                @if ($section['type'] === 'removed')
                                    <del class="text-gray-400 italic">—</del>
                                @elseif ($section['type'] === 'added')
                                    <ins class="text-emerald-600/90">{{ $section['amended'] }}</ins>
                                @elseif ($section['type'] === 'modified')
                                    <ins class="text-indigo-600/90">{{ $section['amended'] }}</ins>
                                @else
                                    {{ $section['amended'] }}
                                @endif
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-sm text-gray-500">No amended text available.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            @if ($bill->current_stage_description)
                <div class="mt-4 rounded-xl border border-gray-200/60 bg-white p-5 shadow-sm">
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Current Stage Description</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $bill->current_stage_description }}</p>
                </div>
            @endif
        </div>

        {{-- RIGHT: Structural data sidebar (1 col) --}}
        <div class="space-y-5">
            {{-- Constitutional Implications --}}
            <div class="rounded-xl border border-gray-200/60 bg-white shadow-sm overflow-hidden">
                <button onclick="this.closest('div').querySelector('.sidebar-panel').classList.toggle('open'); this.querySelector('.chevron').classList.toggle('rotate-180')"
                    class="flex w-full items-center justify-between px-4 py-3 text-left hover:bg-gray-50 transition">
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                        <svg class="inline h-3.5 w-3.5 mr-1.5 -mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        Constitutional Implications
                    </span>
                    <svg class="chevron h-4 w-4 text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="sidebar-panel px-4 {{ $bill->constitutional_implications_summary ? 'open' : '' }}">
                    @if ($bill->constitutional_implications_summary)
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $bill->constitutional_implications_summary }}</p>
                    @else
                        <p class="text-sm text-gray-400 italic">No constitutional implications summary available.</p>
                    @endif
                </div>
            </div>

            {{-- Amendment History --}}
            <div class="rounded-xl border border-gray-200/60 bg-white shadow-sm overflow-hidden">
                <button onclick="this.closest('div').querySelector('.sidebar-panel').classList.toggle('open'); this.querySelector('.chevron').classList.toggle('rotate-180')"
                    class="flex w-full items-center justify-between px-4 py-3 text-left hover:bg-gray-50 transition">
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                        <svg class="inline h-3.5 w-3.5 mr-1.5 -mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        Amendment History
                    </span>
                    <svg class="chevron h-4 w-4 text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="sidebar-panel px-4">
                    @php $amendments = $bill->amendments ?? collect(); @endphp
                    @if ($amendments->isNotEmpty())
                        <div class="space-y-3">
                            @foreach ($amendments as $amendment)
                                <div class="rounded-lg border border-gray-200/60 bg-gray-50 p-3">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-semibold text-gray-900">v{{ $amendment->version }}</span>
                                        @if ($amendment->applied_at)
                                            <span class="text-[10px] text-gray-500">{{ $amendment->applied_at->format('j M Y') }}</span>
                                        @endif
                                    </div>
                                    @if ($amendment->amendment_notes)
                                        <p class="text-xs text-gray-600">{{ $amendment->amendment_notes }}</p>
                                    @endif
                                    @if ($amendment->proposer)
                                        <p class="text-[10px] text-gray-400 mt-1">Proposed by {{ $amendment->proposer->name }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400 italic">No amendments recorded yet.</p>
                    @endif
                </div>
            </div>

            {{-- Voting Ledger --}}
            <div class="rounded-xl border border-gray-200/60 bg-white shadow-sm overflow-hidden">
                <button onclick="this.closest('div').querySelector('.sidebar-panel').classList.toggle('open'); this.querySelector('.chevron').classList.toggle('rotate-180')"
                    class="flex w-full items-center justify-between px-4 py-3 text-left hover:bg-gray-50 transition">
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                        <svg class="inline h-3.5 w-3.5 mr-1.5 -mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                        Voting Ledger
                    </span>
                    <svg class="chevron h-4 w-4 text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="sidebar-panel px-4 open">
                    @if (!empty($votingLedger))
                        @php
                            $yea = $votingLedger['yea'] ?? 0;
                            $nay = $votingLedger['nay'] ?? 0;
                            $abstain = $votingLedger['abstain'] ?? 0;
                            $total = max($yea + $nay + $abstain, 1);
                        @endphp
                        <div class="mb-4">
                            <div class="flex h-8 w-full overflow-hidden rounded-lg">
                                <div class="vote-bar-yea flex items-center justify-center text-xs font-bold text-white transition-all duration-500"
                                     style="width: {{ ($yea / $total) * 100 }}%">{{ $yea > 0 ? $yea : '' }}</div>
                                <div class="vote-bar-nay flex items-center justify-center text-xs font-bold text-white transition-all duration-500"
                                     style="width: {{ ($nay / $total) * 100 }}%">{{ $nay > 0 ? $nay : '' }}</div>
                                <div class="vote-bar-abstain flex items-center justify-center text-xs font-bold text-white transition-all duration-500"
                                     style="width: {{ ($abstain / $total) * 100 }}%">{{ $abstain > 0 ? $abstain : '' }}</div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <span class="flex items-center gap-2 text-gray-600"><span class="inline-block h-2.5 w-2.5 rounded bg-emerald-500"></span> Yea</span>
                                <span class="font-semibold text-gray-900">{{ $yea }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="flex items-center gap-2 text-gray-600"><span class="inline-block h-2.5 w-2.5 rounded bg-red-500"></span> Nay</span>
                                <span class="font-semibold text-gray-900">{{ $nay }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="flex items-center gap-2 text-gray-600"><span class="inline-block h-2.5 w-2.5 rounded bg-gray-400"></span> Abstain</span>
                                <span class="font-semibold text-gray-900">{{ $abstain }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2 mt-2 flex items-center justify-between text-xs text-gray-500">
                                <span>Total votes</span>
                                <span class="font-semibold text-gray-700">{{ $total }}</span>
                            </div>
                        </div>
                        @if (!empty($votingLedger['caucus']))
                            <div class="mt-4 pt-3 border-t border-gray-200/60">
                                <p class="text-[10px] font-medium uppercase tracking-wider text-gray-500 mb-2">Caucus Support Split</p>
                                @foreach ($votingLedger['caucus'] as $party => $votes)
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-xs text-gray-600">{{ $party }}</span>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-emerald-600">{{ $votes['yea'] ?? 0 }}</span>
                                            <span class="text-xs text-red-600">{{ $votes['nay'] ?? 0 }}</span>
                                            <span class="text-xs text-gray-500">{{ $votes['abstain'] ?? 0 }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <p class="text-sm text-gray-400 italic">No voting records available.</p>
                    @endif
                </div>
            </div>

            {{-- Bill Metadata --}}
            <div class="rounded-xl border border-gray-200/60 bg-white p-4 shadow-sm">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Bill Metadata</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Identifier</span>
                        <span class="font-mono text-gray-900">{{ $bill->local_identifier }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">House</span>
                        <span class="text-gray-900">{{ $bill->house_origin ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tabled</span>
                        <span class="text-gray-900">{{ $bill->tabled_at?->format('j M Y') ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Amendments</span>
                        <span class="text-gray-900">{{ $bill->amendments_count ?? $bill->amendments->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
