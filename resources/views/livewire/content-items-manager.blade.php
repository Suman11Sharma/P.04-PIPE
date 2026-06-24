<div>
    {{-- Success message --}}
    @if ($message)
        <div class="mb-6 rounded-lg border border-green-200/60 bg-gradient-to-r from-green-50 to-green-100/50 p-4 text-sm text-green-700 shadow-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 shrink-0 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $message }}</span>
                </div>
                <button type="button" wire:click="dismissMessage" class="text-green-600 hover:text-green-800">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    @endif

    {{-- Error message --}}
    @if ($errorMessage)
        <div class="mb-6 rounded-lg border border-red-200/60 bg-gradient-to-r from-red-50 to-red-100/50 p-4 text-sm text-red-700 shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <span>{{ $errorMessage }}</span>
            </div>
        </div>
    @endif

    {{-- Items count + Add button --}}
    <div class="flex items-center justify-between mb-5">
        <p class="text-sm text-gray-500">
            <span class="font-medium text-gray-700">{{ count($items) }}</span> item(s)
        </p>
        @if (!$showAddForm)
            <button type="button" wire:click="showAdd"
                class="inline-flex items-center gap-1.5 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:from-blue-700 hover:to-blue-800 transition-all">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add New
            </button>
        @endif
    </div>

    {{-- Existing items --}}
    <div class="space-y-4">
        @foreach ($items as $index => $item)
            <div class="rounded-xl border border-gray-200/60 bg-white shadow-sm overflow-hidden transition-all hover:border-gray-300">
                {{-- Card header — always visible --}}
                <div class="flex items-center justify-between px-5 py-3 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <div class="flex items-center gap-3 min-w-0">
                        {{-- Drag handle / reorder badge --}}
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-gray-100 text-xs font-bold text-gray-500">
                            {{ $index + 1 }}
                        </span>
                        <span class="text-sm font-medium text-gray-900 truncate">{{ $this->getItemSummary($item) }}</span>
                    </div>

                    <div class="flex items-center gap-1 shrink-0">
                        {{-- Move up/down --}}
                        @if ($index > 0)
                            <button type="button" wire:click="moveUp({{ $index }})"
                                class="p-1.5 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition"
                                title="Move up">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                </svg>
                            </button>
                        @endif
                        @if ($index < count($items) - 1)
                            <button type="button" wire:click="moveDown({{ $index }})"
                                class="p-1.5 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition"
                                title="Move down">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        @endif

                        {{-- Edit / Delete --}}
                        <button type="button" wire:click="editItem({{ $index }})"
                            class="p-1.5 rounded-md text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition"
                            title="Edit">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>
                        </button>
                        <button type="button" wire:click="deleteItem({{ $index }})"
                            wire:confirm="Are you sure you want to delete this item?"
                            class="p-1.5 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 transition"
                            title="Delete">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Card body — field previews when not editing --}}
                @if ($editIndex !== $index)
                    <div class="px-5 py-3 space-y-1.5">
                        @foreach ($itemFields as $key => $field)
                            @php
                                $value = $item[$key] ?? '';
                            @endphp
                            @if ($value !== '' && $value !== null)
                                <div class="flex items-start gap-2 text-sm">
                                    <span class="text-xs font-medium text-gray-400 w-20 shrink-0">{{ $field['label'] }}:</span>
                                    @if ($field['type'] === 'image')
                                        @if ($value && \Illuminate\Support\Facades\Storage::disk('public')->exists($value))
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($value) }}" alt="Photo" class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-100" />
                                        @elseif ($value && (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')))
                                            <img src="{{ $value }}" alt="Photo" class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-100" />
                                        @else
                                            <span class="text-xs text-gray-400 italic">No photo</span>
                                        @endif
                                    @elseif ($field['type'] === 'select' && isset($field['options'][$value]))
                                        <span class="text-gray-700">
                                            @if (isset($item['color']) && $key === 'color')
                                                <span class="inline-flex items-center gap-1.5">
                                                    <span class="h-2.5 w-2.5 rounded-full" style="background-color: {{ \App\Livewire\ContentItemsManager::colorMap()[$value] ?? '#6b7280' }}"></span>
                                                    {{ $field['options'][$value] }}
                                                </span>
                                            @else
                                                {{ $field['options'][$value] }}
                                            @endif
                                        </span>
                                    @elseif ($field['type'] === 'textarea')
                                        <span class="text-gray-600 line-clamp-2">{{ $value }}</span>
                                    @else
                                        <span class="text-gray-700">{{ $value }}</span>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                {{-- Expanded editing form --}}
                @if ($editIndex === $index)
                    <div class="px-5 py-4 space-y-4 bg-gradient-to-b from-blue-50/30 to-white border-t border-blue-100/50">
                        @foreach ($itemFields as $key => $field)
                            <div>
                                <label for="edit_{{ $index }}_{{ $key }}" class="block text-xs font-medium text-gray-600 mb-1">
                                    {{ $field['label'] }}
                                </label>

                                @if ($field['type'] === 'image')
                                    {{-- Image upload --}}
                                    <div class="space-y-2">
                                        @php
                                            $photoPath = $editValues[$key] ?? '';
                                        @endphp
                                        @if ($photoPath)
                                            <div class="relative inline-block">
                                                @if (\Illuminate\Support\Facades\Storage::disk('public')->exists($photoPath))
                                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($photoPath) }}" alt="Preview" class="h-20 w-20 rounded-lg object-cover ring-2 ring-gray-100" />
                                                @elseif (str_starts_with($photoPath, 'http://') || str_starts_with($photoPath, 'https://'))
                                                    <img src="{{ $photoPath }}" alt="Preview" class="h-20 w-20 rounded-lg object-cover ring-2 ring-gray-100" />
                                                @endif
                                                <button type="button" wire:click="removeEditPhoto"
                                                    class="absolute -top-1.5 -right-1.5 rounded-full bg-red-500 text-white p-0.5 shadow-sm hover:bg-red-600 transition"
                                                    title="Remove photo">
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="text-xs text-gray-400">Current photo. Upload a new one to replace it.</div>
                                        @endif
                                        <input type="file" wire:model="editPhoto" accept="image/jpeg,image/png,image/webp,image/gif"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition" />
                                        <div wire:loading wire:target="editPhoto" class="text-xs text-blue-600">Uploading...</div>
                                        @error('editPhoto') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                @elseif ($field['type'] === 'textarea')
                                    <textarea id="edit_{{ $index }}_{{ $key }}"
                                        wire:model="editValues.{{ $key }}"
                                        rows="{{ $field['rows'] ?? 3 }}"
                                        class="block w-full rounded-lg border-0 bg-white px-3 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 text-sm transition resize-y">{{ $editValues[$key] ?? '' }}</textarea>
                                @elseif ($field['type'] === 'select')
                                    <select id="edit_{{ $index }}_{{ $key }}"
                                        wire:model="editValues.{{ $key }}"
                                        class="block w-full rounded-lg border-0 bg-white px-3 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 focus:ring-2 focus:ring-inset focus:ring-blue-600 text-sm transition">
                                        <option value="">— Select —</option>
                                        @foreach ($field['options'] as $optKey => $optLabel)
                                            <option value="{{ $optKey }}">{{ $optLabel }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input id="edit_{{ $index }}_{{ $key }}"
                                        type="text"
                                        wire:model="editValues.{{ $key }}"
                                        class="block w-full rounded-lg border-0 bg-white px-3 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 text-sm transition"
                                        placeholder="{{ $field['label'] }}" />
                                @endif

                                @error("editValues.{$key}")
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach

                        <div class="flex items-center gap-2 pt-2">
                            <button type="button" wire:click="saveItem({{ $index }})"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:from-blue-700 hover:to-blue-800 transition-all">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                Save
                            </button>
                            <button type="button" wire:click="cancelEdit"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white/80 px-4 py-2 text-xs font-medium text-gray-600 shadow-sm hover:bg-white hover:border-gray-300 transition-all">
                                Cancel
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach

        @if (count($items) === 0 && !$showAddForm)
            <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50/50 p-10 text-center">
                <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <p class="mt-3 text-sm font-medium text-gray-500">No items yet</p>
                <p class="mt-1 text-xs text-gray-400">Click "Add New" to create the first item.</p>
            </div>
        @endif
    </div>

    {{-- Add new item form --}}
    @if ($showAddForm)
        <div class="mt-6 rounded-xl border-2 border-dashed border-blue-200/60 bg-gradient-to-b from-blue-50/20 to-white p-5 shadow-sm">
            <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New Item
            </h4>

            <div class="space-y-4">
                @foreach ($itemFields as $key => $field)
                    <div>
                        <label for="new_{{ $key }}" class="block text-xs font-medium text-gray-600 mb-1">
                            {{ $field['label'] }}
                        </label>

                        @if ($field['type'] === 'image')
                            {{-- Image upload --}}
                            <div class="space-y-2">
                                @php
                                    $newPhotoPath = $newItem[$key] ?? '';
                                @endphp
                                @if ($newPhotoPath)
                                    <div class="relative inline-block">
                                        @if (\Illuminate\Support\Facades\Storage::disk('public')->exists($newPhotoPath))
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($newPhotoPath) }}" alt="Preview" class="h-20 w-20 rounded-lg object-cover ring-2 ring-gray-100" />
                                        @elseif (str_starts_with($newPhotoPath, 'http://') || str_starts_with($newPhotoPath, 'https://'))
                                            <img src="{{ $newPhotoPath }}" alt="Preview" class="h-20 w-20 rounded-lg object-cover ring-2 ring-gray-100" />
                                        @endif
                                        <button type="button" wire:click="removeNewPhoto"
                                            class="absolute -top-1.5 -right-1.5 rounded-full bg-red-500 text-white p-0.5 shadow-sm hover:bg-red-600 transition"
                                            title="Remove photo">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                                <input type="file" wire:model="newPhoto" accept="image/jpeg,image/png,image/webp,image/gif"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition" />
                                <div wire:loading wire:target="newPhoto" class="text-xs text-blue-600">Uploading...</div>
                                @error('newPhoto') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        @elseif ($field['type'] === 'textarea')
                            <textarea id="new_{{ $key }}"
                                wire:model="newItem.{{ $key }}"
                                rows="{{ $field['rows'] ?? 3 }}"
                                class="block w-full rounded-lg border-0 bg-white px-3 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 text-sm transition resize-y"></textarea>
                        @elseif ($field['type'] === 'select')
                            <select id="new_{{ $key }}"
                                wire:model="newItem.{{ $key }}"
                                class="block w-full rounded-lg border-0 bg-white px-3 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 focus:ring-2 focus:ring-inset focus:ring-blue-600 text-sm transition">
                                <option value="">— Select —</option>
                                @foreach ($field['options'] as $optKey => $optLabel)
                                    <option value="{{ $optKey }}">{{ $optLabel }}</option>
                                @endforeach
                            </select>
                        @else
                            <input id="new_{{ $key }}"
                                type="text"
                                wire:model="newItem.{{ $key }}"
                                class="block w-full rounded-lg border-0 bg-white px-3 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 text-sm transition"
                                placeholder="{{ $field['label'] }}" />
                        @endif

                        @error("newItem.{$key}")
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach

                <div class="flex items-center gap-2 pt-2">
                    <button type="button" wire:click="saveNewItem"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:from-blue-700 hover:to-blue-800 transition-all">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add Item
                    </button>
                    <button type="button" wire:click="cancelAdd"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white/80 px-4 py-2 text-xs font-medium text-gray-600 shadow-sm hover:bg-white hover:border-gray-300 transition-all">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
