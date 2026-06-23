<?php

namespace App\Livewire;

use App\Enums\QueryStatus;
use App\Models\ExpertQuery;
use Livewire\Component;

class SeniorReviewPane extends Component
{
    /**
     * The query being reviewed.
     */
    public ExpertQuery $query;

    /**
     * The researcher's original response text (read-only).
     */
    public string $originalResponse = '';

    /**
     * The senior's edited/revised response.
     */
    public string $revisedResponse = '';

    /**
     * Editorial notes from the senior researcher.
     */
    public string $seniorNotes = '';

    /**
     * Whether the response has been modified.
     */
    public bool $isModified = false;

    public function mount(ExpertQuery $query): void
    {
        $this->query = $query->load(['submitter', 'assignedResearcher', 'bill']);
        $this->originalResponse = $query->response_text ?? '';
        $this->revisedResponse = $query->response_text ?? '';
        $this->seniorNotes = $query->senior_notes ?? '';
    }

    // ─── Actions ─────────────────────────────────────────────────────────

    /**
     * Track changes to the revised response.
     */
    public function updatedRevisedResponse(): void
    {
        $this->isModified = $this->revisedResponse !== $this->originalResponse;
    }

    /**
     * Save draft notes without publishing.
     */
    public function saveDraft(): void
    {
        $this->query->update([
            'senior_notes' => $this->seniorNotes,
        ]);

        $this->dispatch('notify', message: 'Draft notes saved.');
    }

    /**
     * Approve the response and publish it to the MP's profile.
     * This finalises the query and marks it as completed.
     */
    public function approveAndPublish(): void
    {
        $this->validate([
            'revisedResponse' => 'required|string|min:10',
            'seniorNotes' => 'nullable|string|max:2000',
        ]);

        $this->query->update([
            'response_text' => $this->revisedResponse,
            'senior_notes' => $this->seniorNotes,
            'reviewed_by' => auth()->id(),
            'status_enum' => QueryStatus::Completed,
            'resolved_at' => now(),
        ]);

        $this->dispatch('query-approved', queryId: $this->query->id);
        $this->dispatch('notify', message: 'Response approved and published to MP profile.');
    }

    /**
     * Send back to junior researcher for revisions.
     */
    public function requestRevisions(): void
    {
        $this->query->update([
            'senior_notes' => $this->seniorNotes,
            'status_enum' => QueryStatus::InProgress,
        ]);

        $this->dispatch('notify', message: 'Sent back for revisions with your notes.');
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.senior-review-pane')
            ->layout('components.layouts.app');
    }
}
