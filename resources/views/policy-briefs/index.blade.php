@extends('components.layouts.app')

@section('title', 'Policy Briefs')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    {{-- Page header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Policy Briefs</h1>
            <p class="mt-1 text-sm text-gray-500">Curated policy analysis and research briefs</p>
        </div>
    </div>

    @php
        $urgencyBadgeMap = [
            'low' => 'bg-green-50 text-green-700 ring-1 ring-green-200/60',
            'medium' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/60',
            'high' => 'bg-red-50 text-red-700 ring-1 ring-red-200/60',
        ];
    @endphp

    @if ($briefs->isEmpty())
        <div class="rounded-xl border border-dashed border-gray-200 bg-white/50 p-16 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
            <p class="mt-4 text-sm font-medium text-gray-500">No policy briefs published yet</p>
            <p class="mt-1 text-xs text-gray-400">Briefs will appear here once published by researchers.</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($briefs as $brief)
                <a href="{{ route('policy-briefs.show', $brief->slug) }}"
                   class="group relative rounded-xl border border-gray-200/60 bg-white p-5 shadow-sm transition-all hover:border-blue-200/80 hover:shadow-xl hover:-translate-y-0.5">
                    <div class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-full bg-gradient-to-br from-blue-50/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>

                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $urgencyBadgeMap[$brief->urgency_level_enum->value] ?? 'bg-gray-50 text-gray-600 ring-1 ring-gray-200/60' }}">
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

                    @if ($brief->compiler)
                        <div class="mt-3 pt-3 border-t border-gray-100 flex items-center gap-2">
                            <div class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-gray-100 text-[10px] font-bold text-gray-500">
                                {{ substr($brief->compiler->name, 0, 1) }}
                            </div>
                            <span class="text-[11px] text-gray-400 truncate">{{ $brief->compiler->name }}</span>
                        </div>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if ($briefs->hasPages())
            <div class="mt-8">
                {{ $briefs->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
