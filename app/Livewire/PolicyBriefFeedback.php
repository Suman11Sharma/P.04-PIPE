<?php

namespace App\Livewire;

use App\Models\PolicyBrief;
use App\Models\PolicyBriefFeedback as FeedbackModel;
use Livewire\Component;

class PolicyBriefFeedback extends Component
{
    /**
     * The policy brief being evaluated.
     */
    public PolicyBrief $brief;

    /**
     * The user's existing feedback (if any).
     */
    public ?FeedbackModel $existingFeedback = null;

    // ── Form fields ─────────────────────────────────────────────────────
    public ?bool $rating = null;
    public array $selectedTags = [];
    public string $revisionRequest = '';

    /**
     * Available error classification tags.
     */
    public array $errorTagOptions = [
        'data_outdated' => 'Data Outdated',
        'local_context_missing' => 'Local Context Missing',
        'source_unclear' => 'Source Not Clearly Cited',
        'methodology_flawed' => 'Methodology Questionable',
        'stakeholders_omitted' => 'Key Stakeholders Omitted',
        'comparative_data_lacking' => 'Comparative/Longitudinal Data Lacking',
        'implementation_unclear' => 'Implementation Pathway Unclear',
        'cost_analysis_missing' => 'Cost/Benefit Analysis Missing',
    ];

    // ── Lifecycle ────────────────────────────────────────────────────────

    public function mount(PolicyBrief $brief, ?FeedbackModel $existingFeedback): void
    {
        $this->brief = $brief;
        $this->existingFeedback = $existingFeedback;

        // Pre-populate if the user already submitted feedback
        if ($existingFeedback) {
            $this->rating = $existingFeedback->rating;
            $this->selectedTags = $existingFeedback->error_tags ?? [];
            $this->revisionRequest = $existingFeedback->revision_request ?? '';
        }
    }

    // ── Validation ──────────────────────────────────────────────────────

    protected function rules(): array
    {
        return [
            'rating' => 'nullable|boolean',
            'selectedTags' => 'nullable|array',
            'selectedTags.*' => 'string|in:' . implode(',', array_keys($this->errorTagOptions)),
            'revisionRequest' => 'nullable|string|max:2000',
        ];
    }

    // ── Actions ─────────────────────────────────────────────────────────

    /**
     * Submit or update the feedback for this brief.
     */
    public function submitFeedback(): void
    {
        $this->validate();

        if ($this->existingFeedback) {
            // Update existing record
            $this->existingFeedback->update([
                'rating' => $this->rating,
                'error_tags' => $this->selectedTags,
                'revision_request' => $this->revisionRequest,
                'status_enum' => 'submitted',
            ]);

            $this->dispatch('feedback-saved', type: 'updated');
        } else {
            // Create new feedback record
            FeedbackModel::create([
                'policy_brief_id' => $this->brief->id,
                'user_id' => auth()->id(),
                'rating' => $this->rating,
                'error_tags' => $this->selectedTags,
                'revision_request' => $this->revisionRequest,
                'status_enum' => 'submitted',
            ]);

            $this->existingFeedback = FeedbackModel::where('policy_brief_id', $this->brief->id)
                ->where('user_id', auth()->id())
                ->first();

            $this->dispatch('feedback-saved', type: 'created');
        }

        $this->dispatch('notify', message: 'Your feedback has been submitted to the research division.');
    }

    /**
     * Quick-thumbs action without filling the full form.
     */
    public function quickThumbs(bool $value): void
    {
        $this->rating = $value;
        $this->submitFeedback();
    }

    /**
     * Toggle an error tag.
     */
    public function toggleTag(string $tag): void
    {
        if (in_array($tag, $this->selectedTags)) {
            $this->selectedTags = array_values(array_filter($this->selectedTags, fn ($t) => $t !== $tag));
        } else {
            $this->selectedTags[] = $tag;
        }
    }

    // ── Render ──────────────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.policy-brief-feedback');
    }
}
