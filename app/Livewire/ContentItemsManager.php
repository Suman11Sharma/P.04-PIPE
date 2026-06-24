<?php

namespace App\Livewire;

use App\Models\PageContent;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContentItemsManager extends Component
{
    use WithFileUploads;
    /**
     * The page key (e.g. 'home').
     */
    public string $page;

    /**
     * The section key (e.g. 'features').
     */
    public string $section;

    /**
     * The section label for display (e.g. 'Features Cards').
     */
    public string $sectionLabel = '';

    /**
     * The item field definitions from the controller.
     */
    public array $itemFields = [];

    /**
     * All items in this section.
     */
    public array $items = [];

    /**
     * Whether we are showing the "add new" form.
     */
    public bool $showAddForm = false;

    /**
     * The fields for a new item being added.
     */
    public array $newItem = [];

    /**
     * The index of the item currently being edited, or null.
     */
    public ?int $editIndex = null;

    /**
     * The edited field values for the item being edited.
     */
    public array $editValues = [];

    /**
     * Success message to show.
     */
    public ?string $message = null;

    /**
     * Validation error message.
     */
    public ?string $errorMessage = null;

    /**
     * Temporary upload for the new item's photo.
     */
    public $newPhoto = null;

    /**
     * Temporary upload for the edited item's photo.
     */
    public $editPhoto = null;

    /**
     * Track which field key is the photo field.
     */
    protected ?string $photoFieldKey = null;

    /**
     * Map of color keys to actual CSS color values (avoids Tailwind JIT issues).
     */
    public static function colorMap(): array
    {
        return [
            'emerald' => '#10b981',
            'blue' => '#3b82f6',
            'amber' => '#f59e0b',
            'purple' => '#a855f7',
            'rose' => '#f43f5e',
            'indigo' => '#6366f1',
            'green' => '#22c55e',
            'red' => '#ef4444',
            'yellow' => '#eab308',
            'teal' => '#14b8a6',
            'cyan' => '#06b6d4',
            'sky' => '#0ea5e9',
            'violet' => '#8b5cf6',
            'orange' => '#f97316',
            'slate' => '#64748b',
            'gray' => '#6b7280',
        ];
    }

    /**
     * Get CSS hex color for a color key.
     */
    public function getColor(string $colorKey): string
    {
        return static::colorMap()[$colorKey] ?? '#6b7280';
    }

    public function mount(string $page, string $section, string $sectionLabel = '', array $itemFields = []): void
    {
        $this->page = $page;
        $this->section = $section;
        $this->sectionLabel = $sectionLabel;
        $this->itemFields = $itemFields;

        // Find which field is the photo field
        foreach ($this->itemFields as $key => $field) {
            if (($field['type'] ?? '') === 'image') {
                $this->photoFieldKey = $key;
                break;
            }
        }

        $this->loadItems();
    }

    /**
     * Load items from the database.
     */
    protected function loadItems(): void
    {
        $pageContent = PageContent::where('page', $this->page)
            ->where('section', $this->section)
            ->first();

        $content = $pageContent?->content ?? [];
        $this->items = $content['items'] ?? [];
    }

    /**
     * Save the current items array to the database as JSON.
     */
    protected function persistItems(): void
    {
        PageContent::updateOrCreate(
            ['page' => $this->page, 'section' => $this->section],
            [
                'content' => [
                    'items' => $this->items,
                ],
                'is_active' => true,
                'sort_order' => 0,
            ]
        );
    }

    /**
     * Show the add new item form.
     */
    public function showAdd(): void
    {
        $this->showAddForm = true;
        $this->newItem = [];
        $this->editIndex = null;
        $this->editValues = [];
        $this->errorMessage = null;
    }

    /**
     * Cancel adding a new item.
     */
    public function cancelAdd(): void
    {
        $this->cleanupNewPhoto();
        $this->showAddForm = false;
        $this->newItem = [];
        $this->errorMessage = null;
    }

    /**
     * Save the new item.
     */
    public function saveNewItem(): void
    {
        $this->validateOnlyNewItem();

        // Build the item from newItem, only including fields that have values
        $item = [];
        foreach ($this->itemFields as $key => $field) {
            if (isset($this->newItem[$key]) && $this->newItem[$key] !== '') {
                $item[$key] = $this->newItem[$key];
            }
        }

        $this->items[] = $item;
        $this->persistItems();
        $this->showAddForm = false;
        $this->newItem = [];
        $this->message = 'Item added successfully.';
    }

    /**
     * Start editing an item.
     */
    public function editItem(int $index): void
    {
        $this->editIndex = $index;
        $this->editValues = $this->items[$index] ?? [];
        $this->showAddForm = false;
        $this->errorMessage = null;
    }

    /**
     * Save the edited item.
     */
    public function saveItem(int $index): void
    {
        $this->validateOnlyEditValues();

        if (! isset($this->items[$index])) {
            return;
        }

        // Update only the fields that exist in the definition
        foreach ($this->itemFields as $key => $field) {
            $this->items[$index][$key] = $this->editValues[$key] ?? '';
        }

        $this->persistItems();
        $this->editIndex = null;
        $this->editValues = [];
        $this->message = 'Item updated successfully.';
    }

    /**
     * Cancel editing.
     */
    public function cancelEdit(): void
    {
        // If a new photo was uploaded during editing, delete the permanent file
        $field = $this->photoFieldKey ?? 'photo';
        if ($this->editIndex !== null) {
            $original = $this->items[$this->editIndex][$field] ?? '';
            $replacement = $this->editValues[$field] ?? '';
            if ($replacement !== '' && $replacement !== $original && Storage::disk('public')->exists($replacement)) {
                Storage::disk('public')->delete($replacement);
            }
        }
        $this->cleanupEditPhoto();
        $this->editIndex = null;
        $this->editValues = [];
        $this->errorMessage = null;
    }

    /**
     * Delete an item with confirmation.
     */
    public function deleteItem(int $index): void
    {
        if (! isset($this->items[$index])) {
            return;
        }

        // Delete photo file if it exists
        $field = $this->photoFieldKey ?? 'photo';
        if (! empty($this->items[$index][$field]) && Storage::disk('public')->exists($this->items[$index][$field])) {
            Storage::disk('public')->delete($this->items[$index][$field]);
        }

        array_splice($this->items, $index, 1);
        $this->persistItems();

        // Adjust editIndex if needed
        if ($this->editIndex !== null) {
            if ($this->editIndex === $index) {
                $this->cancelEdit();
            } elseif ($this->editIndex > $index) {
                $this->editIndex--;
            }
        }

        $this->message = 'Item deleted successfully.';
    }

    /**
     * Move an item up in order.
     */
    public function moveUp(int $index): void
    {
        if ($index <= 0 || ! isset($this->items[$index])) {
            return;
        }

        $temp = $this->items[$index - 1];
        $this->items[$index - 1] = $this->items[$index];
        $this->items[$index] = $temp;

        $this->persistItems();

        // Adjust editIndex if needed
        if ($this->editIndex === $index) {
            $this->editIndex = $index - 1;
        } elseif ($this->editIndex === $index - 1) {
            $this->editIndex = $index;
        }
    }

    /**
     * Move an item down in order.
     */
    public function moveDown(int $index): void
    {
        if ($index >= count($this->items) - 1 || ! isset($this->items[$index])) {
            return;
        }

        $temp = $this->items[$index + 1];
        $this->items[$index + 1] = $this->items[$index];
        $this->items[$index] = $temp;

        $this->persistItems();

        // Adjust editIndex if needed
        if ($this->editIndex === $index) {
            $this->editIndex = $index + 1;
        } elseif ($this->editIndex === $index + 1) {
            $this->editIndex = $index;
        }
    }

    /**
     * Dismiss the success message.
     */
    public function dismissMessage(): void
    {
        $this->message = null;
    }

    /**
     * Validate just the new item fields.
     */
    protected function validateOnlyNewItem(): void
    {
        $rules = [];
        $messages = [];
        foreach ($this->itemFields as $key => $field) {
            $label = $field['label'] ?? $key;
            if (($field['type'] ?? '') === 'image') {
                // Photo path is already validated on upload, just ensure it's a string
                $rules["newItem.{$key}"] = 'nullable|string|max:500';
            } else {
                $rules["newItem.{$key}"] = 'nullable|string|max:65535';
            }
            $messages["newItem.{$key}.max"] = "{$label} must not exceed 65535 characters.";
        }

        $this->validate($rules, $messages);
    }

    /**
     * Validate just the edit values fields.
     */
    protected function validateOnlyEditValues(): void
    {
        $rules = [];
        $messages = [];
        foreach ($this->itemFields as $key => $field) {
            $label = $field['label'] ?? $key;
            if (($field['type'] ?? '') === 'image') {
                $rules["editValues.{$key}"] = 'nullable|string|max:500';
            } else {
                $rules["editValues.{$key}"] = 'nullable|string|max:65535';
            }
            $messages["editValues.{$key}.max"] = "{$label} must not exceed 65535 characters.";
        }

        $this->validate($rules, $messages);
    }

    /**
     * Upload a new photo and return the stored path.
     */
    public function updatedNewPhoto(): void
    {
        $this->validate([
            'newPhoto' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ]);

        $path = $this->newPhoto->store('cms', 'public');
        $this->newItem[$this->photoFieldKey ?? 'photo'] = $path;
        $this->newPhoto = null;
    }

    /**
     * Upload an edit photo and return the stored path.
     */
    public function updatedEditPhoto(): void
    {
        $this->validate([
            'editPhoto' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ]);

        // Remove old photo if it exists
        $oldField = $this->photoFieldKey ?? 'photo';
        if (! empty($this->editValues[$oldField]) && Storage::disk('public')->exists($this->editValues[$oldField])) {
            Storage::disk('public')->delete($this->editValues[$oldField]);
        }

        $path = $this->editPhoto->store('cms', 'public');
        $this->editValues[$oldField] = $path;
        $this->editPhoto = null;
    }

    /**
     * Remove the new item photo.
     */
    public function removeNewPhoto(): void
    {
        $field = $this->photoFieldKey ?? 'photo';
        if (! empty($this->newItem[$field]) && Storage::disk('public')->exists($this->newItem[$field])) {
            Storage::disk('public')->delete($this->newItem[$field]);
        }
        $this->cleanupNewPhoto();
        $this->newItem[$field] = '';
    }

    /**
     * Remove the edit item photo.
     */
    public function removeEditPhoto(): void
    {
        $field = $this->photoFieldKey ?? 'photo';
        if (! empty($this->editValues[$field]) && Storage::disk('public')->exists($this->editValues[$field])) {
            Storage::disk('public')->delete($this->editValues[$field]);
        }
        $this->cleanupEditPhoto();
        $this->editValues[$field] = '';
    }

    /**
     * Clean up the new photo temp upload.
     */
    protected function cleanupNewPhoto(): void
    {
        if ($this->newPhoto) {
            try {
                $this->newPhoto->delete();
            } catch (\Exception $e) {
                // Ignore cleanup errors
            }
            $this->newPhoto = null;
        }
    }

    /**
     * Clean up the edit photo temp upload.
     */
    protected function cleanupEditPhoto(): void
    {
        if ($this->editPhoto) {
            try {
                $this->editPhoto->delete();
            } catch (\Exception $e) {
                // Ignore cleanup errors
            }
            $this->editPhoto = null;
        }
    }

    /**
     * Get the URL for a stored photo path.
     */
    public function getPhotoUrl(string $path): string
    {
        if (empty($path)) {
            return '';
        }
        // If it's already a URL, return as-is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return Storage::url($path);
    }

    /**
     * Get the label for an icon by its key.
     */
    public function getIconLabel(string $iconKey): string
    {
        $iconMap = [
            'document' => 'Document',
            'scale' => 'Scale',
            'chat' => 'Chat',
            'dashboard' => 'Dashboard',
            'kanban' => 'Kanban',
            'compare' => 'Compare',
        ];
        return $iconMap[$iconKey] ?? $iconKey;
    }

    /**
     * Get a readable summary of an item for display in the card header.
     */
    public function getItemSummary(array $item): string
    {
        $preferred = ['title', 'name', 'heading', 'label', 'text'];
        foreach ($preferred as $key) {
            if (! empty($item[$key])) {
                return $item[$key];
            }
        }
        // Fallback: use the first non-empty value
        foreach ($item as $key => $value) {
            if (! empty($value) && is_string($value)) {
                return $value;
            }
        }
        return '(empty)';
    }

    public function render()
    {
        return view('livewire.content-items-manager');
    }
}
