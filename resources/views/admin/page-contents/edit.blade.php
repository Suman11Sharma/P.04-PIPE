@extends('components.layouts.app')

@section('title', 'Edit Content')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">

    <div class="mb-8">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('admin.page-contents.index') }}" class="hover:text-gray-700 transition">Content Management</a>
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
            <span class="text-gray-400">{{ $pages[$page] ?? $page }}</span>
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
            <span class="text-gray-700 font-medium">{{ $sectionDef['label'] }}</span>
        </div>
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">{{ $sectionDef['label'] }}</h1>
        <p class="mt-1 text-sm text-gray-500">{{ $pages[$page] ?? $page }}</p>
    </div>

    <div class="max-w-3xl">
        @if (!empty($sectionDef['repeatable']))
            {{-- Repeatable section: use the Livewire item manager --}}
            @livewire('content-items-manager', [
                'page' => $page,
                'section' => $section,
                'sectionLabel' => $sectionDef['label'],
                'itemFields' => $sectionDef['item_fields'] ?? [],
            ])
        @else
            {{-- Standard section: flat form --}}
            <form method="POST" action="{{ route('admin.page-contents.update', ['page' => $page, 'section' => $section]) }}"
                  class="rounded-xl border border-gray-200/60 bg-white shadow-sm p-6 sm:p-8 space-y-6">
                @csrf
                @method('PUT')

                @foreach ($sectionDef['fields'] as $key => $field)
                    <div>
                        <label for="content_{{ $key }}" class="block text-sm font-medium text-gray-700 mb-1.5">
                            {{ $field['label'] }}
                        </label>

                        @if ($field['type'] === 'textarea')
                            <textarea id="content_{{ $key }}" name="content[{{ $key }}]" rows="4"
                                class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm transition resize-y">{{ old("content.{$key}", $content[$key] ?? '') }}</textarea>
                        @else
                            <input id="content_{{ $key }}" name="content[{{ $key }}]" type="text" value="{{ old("content.{$key}", $content[$key] ?? '') }}"
                                class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm transition" />
                        @endif

                        @error("content.{$key}")
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-md hover:from-blue-700 hover:to-blue-800 hover:shadow-lg transition-all">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        Save Changes
                    </button>
                    <a href="{{ route('admin.page-contents.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white/80 px-6 py-3 text-sm font-medium text-gray-700 shadow-sm hover:bg-white hover:border-gray-300 hover:shadow-md transition-all backdrop-blur-sm">
                        Cancel
                    </a>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
