<?php

namespace App\Livewire;

use App\Models\Constituency;
use App\Models\Sector;
use Livewire\Component;

class MpOnboardingWizard extends Component
{
    /**
     * Current wizard step (1-based).
     */
    public int $step = 1;

    /**
     * Maximum number of steps.
     */
    public int $totalSteps = 3;

    // ── Step 1: Constituency Mapping ────────────────────────────────────
    /** Selected province name */
    public ?string $selectedProvince = null;

    /** Available provinces from the constituencies table */
    public array $provinces = [];

    /** Constituencies filtered by selected province */
    public array $availableConstituencies = [];

    /** Selected constituency ID */
    public ?int $selectedConstituencyId = null;

    // ── Step 2: Governance Focus (Committees) ──────────────────────────
    /** Committees are stored as a JSON preference for extensibility */
    public array $selectedCommittees = [];

    /** Predefined list of parliamentary committees */
    public array $committeeOptions = [
        'finance' => 'Finance & Appropriations',
        'health' => 'Health & Social Services',
        'education' => 'Education & Training',
        'defence' => 'Defence & Security',
        'agriculture' => 'Agriculture & Land',
        'justice' => 'Justice & Legal Affairs',
        'energy' => 'Energy & Natural Resources',
        'transport' => 'Transport & Infrastructure',
        'trade' => 'Trade & Industry',
        'environment' => 'Environment & Climate Change',
    ];

    // ── Step 3: Intelligence Customization (Sectors) ────────────────────
    /** Selected sector IDs from the database */
    public array $selectedSectorIds = [];

    /** Available sectors from the database */
    public array $availableSectors = [];

    // ── Validation Rules (per step) ──────────────────────────────────────

    protected function rules(): array
    {
        return match ($this->step) {
            1 => [
                'selectedProvince' => 'required|string|max:255',
                'selectedConstituencyId' => 'required|integer|exists:constituencies,id',
            ],
            2 => [
                'selectedCommittees' => 'array|min:1',
                'selectedCommittees.*' => 'string|in:' . implode(',', array_keys($this->committeeOptions)),
            ],
            3 => [
                'selectedSectorIds' => 'array|min:1',
                'selectedSectorIds.*' => 'integer|exists:sectors,id',
            ],
            default => [],
        };
    }

    protected $messages = [
        'selectedProvince.required' => 'Please select your province.',
        'selectedConstituencyId.required' => 'Please select your constituency.',
        'selectedConstituencyId.exists' => 'The selected constituency is not valid.',
        'selectedCommittees.min' => 'Please select at least one committee.',
        'selectedSectorIds.min' => 'Please select at least one sector of interest.',
    ];

    // ── Lifecycle ────────────────────────────────────────────────────────

    public function mount(): void
    {
        // Load provinces from the constituencies table
        $this->provinces = Constituency::query()
            ->select('province_name')
            ->distinct()
            ->orderBy('province_name')
            ->pluck('province_name')
            ->toArray();

        // Load sectors from the database
        $this->availableSectors = Sector::query()
            ->select('id', 'name', 'slug', 'icon_class')
            ->orderBy('name')
            ->get()
            ->toArray();

        // Pre-populate from existing user data if available
        $user = auth()->user();

        if ($user->constituency_id) {
            $this->selectedConstituencyId = $user->constituency_id;
            $constituency = $user->constituency;
            if ($constituency) {
                $this->selectedProvince = $constituency->province_name;
                $this->updatedSelectedProvince($this->selectedProvince);
            }
        }

        if ($user->committee_id) {
            // committee_id is a single value; convert array for compatibility
            // In a real app, committees would be a many-to-many relationship
        }

        if ($user->sectors()->exists()) {
            $this->selectedSectorIds = $user->sectors()->pluck('sectors.id')->toArray();
        }
    }

    // ── Computed Properties ─────────────────────────────────────────────

    public function getStepTitleProperty(): string
    {
        return match ($this->step) {
            1 => 'Constituency Mapping',
            2 => 'Governance Focus',
            3 => 'Intelligence Customization',
            default => 'Onboarding',
        };
    }

    public function getStepDescriptionProperty(): string
    {
        return match ($this->step) {
            1 => 'Select your province and constituency to personalise your geographic intelligence feed.',
            2 => 'Select the parliamentary committees you are officially assigned to.',
            3 => 'Choose the policy sectors you want to track for personalised briefings.',
            default => '',
        };
    }

    public function getProgressPercentageProperty(): int
    {
        return (int) round(($this->step / $this->totalSteps) * 100);
    }

    // ── Actions ─────────────────────────────────────────────────────────

    /**
     * When the province changes, reload the constituency dropdown.
     */
    public function updatedSelectedProvince(string $value): void
    {
        $this->selectedConstituencyId = null;

        $this->availableConstituencies = Constituency::query()
            ->where('province_name', $value)
            ->select('id', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    /**
     * Proceed to the next step.
     */
    public function next(): void
    {
        $this->validate();

        if ($this->step < $this->totalSteps) {
            $this->step++;
        }
    }

    /**
     * Go back to the previous step.
     */
    public function previous(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    /**
     * Finalise the onboarding: save all selections to the user record.
     */
    public function complete(): void
    {
        $this->validate();

        $user = auth()->user();

        // Step 1: Save constituency mapping
        $user->constituency_id = $this->selectedConstituencyId;

        // Step 2: Save committee assignment (first selected as primary committee_id)
        // In a production app, committees would be a separate many-to-many table.
        // For now, we store the first committee in the committee_id field and
        // the full list in dynamic_preferences for extensibility.
        $preferences = $user->dynamic_preferences ?? [];
        $preferences['committees'] = $this->selectedCommittees;
        $user->dynamic_preferences = $preferences;

        $user->save();

        // Step 3: Sync sector interests
        $user->sectors()->sync($this->selectedSectorIds);

        session()->flash('onboarding_complete', true);

        $this->redirect(route('dashboard'), navigate: true);
    }

    /**
     * Skip onboarding for now — redirect to dashboard.
     */
    public function skip(): void
    {
        $this->redirect(route('dashboard'), navigate: true);
    }

    // ── Render ──────────────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.mp-onboarding-wizard')
            ->layout('components.layouts.app');
    }
}
