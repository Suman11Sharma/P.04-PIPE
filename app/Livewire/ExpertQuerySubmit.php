<?php

namespace App\Livewire;

use App\Enums\TurnaroundTier;
use App\Models\Bill;
use App\Models\ExpertQuery;
use App\Services\SLABreachService;
use Livewire\Component;
use Livewire\WithFileUploads;

class ExpertQuerySubmit extends Component
{
    use WithFileUploads;

    // ── Form Fields ─────────────────────────────────────────────────────
    public string $title = '';
    public string $explicit_description = '';
    public $attachments = []; // Temporary uploaded files
    public string $turnaroundTier = 'standard_request';
    public ?string $billId = null;

    /**
     * Available bills for the floor support dropdown.
     */
    public array $billOptions = [];

    /**
     * Turnaround tier options with labels and descriptions.
     */
    public array $tierOptions = [];

    public function mount(): void
    {
        $this->tierOptions = [
            'standard_request' => [
                'label' => 'Standard Request',
                'description' => '7-day turnaround for in-depth policy analysis',
                'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
            ],
            '48hr_analysis' => [
                'label' => '48-Hour Deep Policy Analysis',
                'description' => 'Accelerated analysis for urgent committee preparation',
                'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
            ],
            '30min_floor_support' => [
                'label' => 'On-Demand Floor Support',
                'description' => '30-minute rapid response during floor debate recess',
                'icon' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z',
            ],
        ];

        // Load active bills for the bill dropdown
        $this->billOptions = Bill::query()
            ->active()
            ->select('id', 'local_identifier', 'title')
            ->orderBy('local_identifier')
            ->get()
            ->toArray();
    }

    // ── Validation ──────────────────────────────────────────────────────

    protected function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'explicit_description' => 'required|string|max:5000',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,mp3,wav,mp4|max:15360',
            'turnaroundTier' => 'required|in:30min_floor_support,48hr_analysis,standard_request',
            'billId' => 'nullable|integer|exists:bills,id',
        ];

        // If 30-min floor support is selected, bill_id becomes required
        if ($this->turnaroundTier === '30min_floor_support') {
            $rules['billId'] = 'required|integer|exists:bills,id';
        }

        return $rules;
    }

    protected $messages = [
        'title.required' => 'Please provide a clear title for your query.',
        'explicit_description.required' => 'Please describe what analysis you need.',
        'attachments.*.max' => 'Each file must be under 15MB.',
        'attachments.*.mimes' => 'Files must be PDF, Office documents, images, or audio/video formats.',
        'turnaroundTier.required' => 'Please select a turnaround priority.',
        'billId.required' => 'Floor support requests require an associated bill or floor debate reference.',
    ];

    // ── Actions ─────────────────────────────────────────────────────────

    /**
     * Submit the expert query.
     */
    public function submit(): void
    {
        $this->validate();

        $user = auth()->user();

        // Handle file uploads
        $uploadedPaths = [];
        if ($this->attachments) {
            foreach ($this->attachments as $file) {
                $uploadedPaths[] = $file->store('query-attachments', 'public');
            }
        }

        // Calculate target deadline based on turnaround tier
        $deadline = app(SLABreachService::class)->calculateDeadline($this->turnaroundTier);

        // Create the query
        $query = ExpertQuery::create([
            'user_id' => $user->id,
            'title' => $this->title,
            'explicit_description' => $this->explicit_description,
            'attachments' => ! empty($uploadedPaths) ? $uploadedPaths : null,
            'status_enum' => \App\Enums\QueryStatus::Pending,
            'turnaround_tier_enum' => $this->turnaroundTier,
            'bill_id' => $this->billId,
            'target_deadline' => $deadline,
        ]);

        $this->dispatch('query-submitted', queryId: $query->id);
        $this->dispatch('notify', message: 'Your expert query has been submitted. You will be notified when analysis is complete.');

        // Reset form
        $this->reset(['title', 'explicit_description', 'attachments', 'billId']);
        $this->turnaroundTier = 'standard_request';
    }

    /**
     * Reset the form.
     */
    public function cancel(): void
    {
        $this->reset(['title', 'explicit_description', 'attachments', 'billId']);
        $this->turnaroundTier = 'standard_request';
        $this->dispatch('notify', message: 'Query draft discarded.');
    }

    // ── Render ──────────────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.expert-query-submit')
            ->layout('components.layouts.app');
    }
}
