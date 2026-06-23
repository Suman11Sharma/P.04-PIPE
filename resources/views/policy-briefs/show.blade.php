@extends('components.layouts.app')

@section('title', $brief->title)

@push('styles')
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=source-serif-pro:400,600,700&display=swap" rel="stylesheet" />
<style>
    .prose-serif h1, .prose-serif h2, .prose-serif h3 {
        font-family: 'Source Serif Pro', Georgia, 'Times New Roman', serif;
    }
    .prose-serif p {
        font-family: 'Source Serif Pro', Georgia, 'Times New Roman', serif;
        font-size: 1.0625rem;
        line-height: 1.8;
        color: #4b5563;
    }
    .prose-serif p + p { margin-top: 1.25em; }
    .prose-serif strong { color: #111827; font-weight: 600; }
    .prose-serif a { color: #2563eb; text-decoration: underline; text-underline-offset: 2px; }
    .prose-serif a:hover { color: #1d4ed8; }
    .prose-serif ul, .prose-serif ol { color: #4b5563; line-height: 1.8; }
    .prose-serif blockquote {
        border-left: 3px solid #2563eb;
        padding-left: 1rem;
        margin: 1.5rem 0;
        color: #6b7280;
        font-style: italic;
    }
</style>
@endpush

@section('content')
<div>
    {{-- Top action bar --}}
    <div class="sticky top-0 z-30 border-b border-gray-200/60 bg-white/80 backdrop-blur-md shadow-sm">
        <div class="mx-auto max-w-4xl px-4 sm:px-6">
            <div class="flex items-center justify-between gap-3 py-3">
                <div class="flex items-center gap-3 text-xs text-gray-500">
                    <span>{{ $brief->published_at?->format('j F Y') }}</span>
                    @if ($brief->compiler)
                        <span>&middot; By {{ $brief->compiler->name }}</span>
                    @endif
                    @if ($brief->verifier)
                        <span>&middot; Verified by {{ $brief->verifier->name }}</span>
                    @endif
                    <span>&middot; {{ number_format($brief->views_count) }} views</span>
                </div>

                <div class="flex items-center gap-2">
                    <button onclick="window.print()" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white/80 px-3 py-1.5 text-xs font-medium text-gray-600 shadow-sm hover:bg-white hover:border-gray-300 hover:shadow-md transition-all backdrop-blur-sm">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>
                        Print
                    </button>
                    <a href="#" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white/80 px-3 py-1.5 text-xs font-medium text-gray-600 shadow-sm hover:bg-white hover:border-gray-300 hover:shadow-md transition-all backdrop-blur-sm">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Download PDF
                    </a>
                    <button onclick="navigator.clipboard.writeText(document.getElementById('brief-title')?.textContent + '\n\n' + document.getElementById('brief-summary')?.textContent)"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:from-blue-700 hover:to-blue-800 transition-all">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                        </svg>
                        Copy Floor Talking Points
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6">
        <header class="mb-10">
            <div class="flex items-center gap-3 mb-4">
                @if ($brief->sector)
                    <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700 ring-1 ring-blue-200/60">
                        {{ $brief->sector->name }}
                    </span>
                @endif
                @php
                    $urgencyBadgeMap = [
                        'low' => 'bg-green-50 text-green-700 ring-1 ring-green-200/60',
                        'medium' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/60',
                        'high' => 'bg-red-50 text-red-700 ring-1 ring-red-200/60',
                    ];
                @endphp
                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium {{ $urgencyBadgeMap[$brief->urgency_level_enum->value] ?? 'bg-gray-50 text-gray-600 ring-1 ring-gray-200/60' }}">
                    {{ $brief->urgency_level_enum->label() }} Urgency
                </span>
            </div>

            <h1 id="brief-title" class="text-3xl font-bold tracking-tight text-gray-900 font-serif">
                {{ $brief->title }}
            </h1>

            <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-gray-500">
                <span>{{ $brief->published_at?->format('l, j F Y') }}</span>
                @if ($brief->compiler)
                    <span>Compiled by {{ $brief->compiler->name }}</span>
                @endif
                @if ($brief->verifier)
                    <span>Verified by {{ $brief->verifier->name }}</span>
                @endif
            </div>

            <div id="brief-summary" class="mt-6 rounded-xl border border-gray-200/60 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Executive Summary</p>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $brief->summary }}</p>
            </div>
        </header>

        <article class="prose-serif max-w-none">
            {!! Str::markdown($brief->full_content) !!}
        </article>

        @if (!empty($brief->attachments))
            <div class="mt-12 rounded-xl border border-gray-200/60 bg-white p-6 shadow-sm">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Attachments &amp; Supporting Documents</h3>
                <div class="space-y-2">
                    @foreach ($brief->attachments as $attachment)
                        <a href="#" class="flex items-center gap-3 rounded-lg bg-gray-50 px-4 py-3 text-sm text-gray-600 hover:bg-gray-100 transition">
                            <svg class="h-5 w-5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <span class="truncate">{{ is_string($attachment) ? $attachment : ($attachment['name'] ?? 'Attachment') }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-12">
            <livewire:policy-brief-feedback
                :brief="$brief"
                :existingFeedback="$existingFeedback"
                :key="'feedback-' . $brief->id"
            />
        </div>

        @if ($relatedBriefs->isNotEmpty())
            <div class="mt-12">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Related Briefs</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    @foreach ($relatedBriefs as $related)
                        <a href="{{ route('policy-briefs.show', $related->slug) }}"
                           class="rounded-lg border border-gray-200/60 bg-white p-4 shadow-sm hover:border-blue-200/80 hover:shadow-md transition-all">
                            <p class="text-sm font-medium text-gray-900 line-clamp-2">{{ $related->title }}</p>
                            <p class="mt-2 text-xs text-gray-500">{{ $related->published_at?->diffForHumans() }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
