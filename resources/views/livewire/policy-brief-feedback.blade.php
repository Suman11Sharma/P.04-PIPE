<div class="rounded-xl border border-gray-200/60 bg-white p-6 shadow-sm">
    {{-- Section heading --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h4 class="text-sm font-semibold text-gray-900">Brief Evaluation</h4>
            <p class="text-xs text-gray-500 mt-0.5">
                Your feedback helps improve the quality of future intelligence products.
            </p>
        </div>
        @if ($existingFeedback)
            <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-green-200/60">
                Previously submitted
            </span>
        @endif
    </div>

    {{-- Thumbs Up/Down --}}
    <div class="mb-5">
        <p class="text-xs font-medium text-gray-500 mb-2.5">Overall assessment</p>
        <div class="flex gap-3">
            <button wire:click="quickThumbs(true)" type="button"
                class="inline-flex items-center gap-2 rounded-lg border px-4 py-2.5 text-sm font-medium transition-all duration-150
                    {{ $rating === true ? 'border-green-500/50 bg-green-50 text-green-700 ring-1 ring-green-500/20' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48a4.49 4.49 0 01-1.199-.16 11.948 11.948 0 01-3.444-1.14 2.247 2.247 0 01-.747-.858" />
                </svg>
                Helpful
            </button>
            <button wire:click="quickThumbs(false)" type="button"
                class="inline-flex items-center gap-2 rounded-lg border px-4 py-2.5 text-sm font-medium transition-all duration-150
                    {{ $rating === false ? 'border-red-500/50 bg-red-50 text-red-700 ring-1 ring-red-500/20' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.498 15.25H4.372c-1.026 0-1.945-.694-2.054-1.715a12.137 12.137 0 01-.068-1.285c0-2.848.992-5.464 2.649-7.521C5.287 4.247 5.886 4 6.504 4h4.016a4.5 4.5 0 011.423.23l3.114 1.04a4.5 4.5 0 001.423.23h1.294M7.498 15.25c.618 0 .991.724.725 1.282A7.471 7.471 0 007.5 19.75 2.25 2.25 0 0015 19.75c0-1.036-.172-2.036-.462-2.969" />
                </svg>
                Needs Work
            </button>
        </div>
    </div>

    {{-- Error Classification Tags --}}
    <div class="mb-5">
        <p class="text-xs font-medium text-gray-500 mb-2.5">Classification tags</p>
        <div class="flex flex-wrap gap-2">
            @foreach ($errorTagOptions as $key => $label)
                <button wire:click="toggleTag('{{ $key }}')" type="button"
                    class="inline-flex items-center rounded-full px-3 py-1.5 text-xs font-medium transition-all duration-150
                        {{ in_array($key, $selectedTags) ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/60' : 'bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-gray-700' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Revision Request --}}
    <div class="mb-5">
        <label for="revision" class="text-xs font-medium text-gray-500 mb-2.5 block">Request Revision</label>
        <textarea id="revision" wire:model="revisionRequest" rows="3"
            class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm transition duration-150"
            placeholder="Describe what additional analysis or corrections are needed..."></textarea>
        @error('revisionRequest') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    {{-- Submit --}}
    <div class="flex items-center justify-between">
        <p class="text-xs text-gray-500">Your feedback is sent directly to the research division.</p>
        <button wire:click="submitFeedback" wire:loading.attr="disabled" type="button"
            class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:from-blue-700 hover:to-blue-800 disabled:opacity-50 transition-all">
            <svg wire:loading class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
            </svg>
            {{ $existingFeedback ? 'Update Feedback' : 'Submit Feedback' }}
        </button>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('feedback-saved', function () {});
        });
    </script>
    @endpush
</div>
