<?php

namespace App\Livewire;

use App\Enums\QueryStatus;
use App\Models\ExpertQuery;
use App\Models\User;
use App\Services\SLABreachService;
use Livewire\Component;

class ResearcherKanban extends Component
{
    /**
     * The current user (researcher).
     */
    public User $user;

    /**
     * The kanban column order.
     */
    public array $kanbanColumns = [];

    /**
     * SLA breach count for alert banner.
     */
    public int $breachCount = 0;

    /**
     * Whether to show only the current user's assigned queries.
     */
    public bool $showMineOnly = false;

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->kanbanColumns = [
            'pending' => ['label' => 'Unassigned', 'color' => 'slate'],
            'assigned' => ['label' => 'Active Processing', 'color' => 'blue'],
            'in_progress' => ['label' => 'In Progress', 'color' => 'indigo'],
            'senior_review' => ['label' => 'Senior Editorial Review', 'color' => 'amber'],
            'completed' => ['label' => 'Transmitted to Parliament', 'color' => 'emerald'],
        ];
        $this->breachCount = ExpertQuery::query()
            ->whereNotNull('sla_breached_at')
            ->count();
    }

    /**
     * Available researchers for assignment dropdown.
     */
    public function getResearchersProperty(): array
    {
        return User::query()
            ->researchers()
            ->select('id', 'name', 'role_enum')
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    /**
     * Get queries for a specific kanban column.
     */
    public function getColumnQueries(string $statusValue): mixed
    {
        $query = ExpertQuery::query()
            ->inKanbanColumn($statusValue)
            ->with(['submitter', 'assignedResearcher', 'reviewer', 'bill'])
            ->kanbanOrder();

        // Junior researchers only see their own assigned queries (unless in pending/senior_review)
        if ($this->showMineOnly && $this->user->isJuniorResearcher()) {
            if (in_array($statusValue, ['assigned', 'in_progress'])) {
                $query->assignedTo($this->user->id);
            }
        }

        return $query->get();
    }

    /**
     * Get all column queries as a named array.
     */
    public function getColumnsDataProperty(): array
    {
        $data = [];
        foreach ($this->kanbanColumns as $key => $col) {
            $data[$key] = [
                'label' => $col['label'],
                'color' => $col['color'],
                'queries' => $this->getColumnQueries($key),
            ];
        }
        return $data;
    }

    /**
     * Assign a query to a researcher.
     */
    public function assignQuery(int $queryId, int $researcherId): void
    {
        $query = ExpertQuery::findOrFail($queryId);
        $query->update([
            'assigned_researcher_id' => $researcherId,
            'status_enum' => QueryStatus::Assigned,
        ]);
    }

    /**
     * Change the status of a query (drag-and-drop action).
     */
    public function moveQuery(int $queryId, string $newStatus): void
    {
        $query = ExpertQuery::findOrFail($queryId);
        $newStatusEnum = QueryStatus::tryFrom($newStatus);

        if (! $newStatusEnum) {
            return;
        }

        $data = ['status_enum' => $newStatusEnum];

        // When moving to in_progress, ensure a researcher is assigned
        if ($newStatusEnum === QueryStatus::InProgress && ! $query->assigned_researcher_id) {
            $data['assigned_researcher_id'] = $this->user->id;
        }

        // When moving to senior_review, set the junior who completed it
        if ($newStatusEnum === QueryStatus::SeniorReview && $this->user->isJuniorResearcher()) {
            $data['response_text'] = $data['response_text'] ?? $query->response_text;
        }

        // When completing (approving), set resolved timestamp
        if ($newStatusEnum === QueryStatus::Completed) {
            $data['resolved_at'] = now();
        }

        $query->update($data);
    }

    /**
     * Self-assign a query from the unassigned column.
     */
    public function selfAssign(int $queryId): void
    {
        $this->assignQuery($queryId, $this->user->id);
    }

    /**
     * Toggle the "Show mine only" filter.
     */
    public function toggleShowMine(): void
    {
        $this->showMineOnly = ! $this->showMineOnly;
    }

    /**
     * Run SLA breach check manually.
     */
    public function checkSlaBreaches(): void
    {
        $count = app(SLABreachService::class)->checkAndMarkBreaches();
        $this->breachCount = ExpertQuery::query()
            ->whereNotNull('sla_breached_at')
            ->count();

        if ($count > 0) {
            $this->dispatch('notify', message: "{$count} SLA breach(es) detected and logged.");
        }
    }

    // ─── Computed column accessors ─────────────────────────────────────

    public function getUnassignedQueriesProperty()
    {
        return $this->getColumnQueries('pending');
    }

    public function getActiveQueriesProperty()
    {
        return $this->getColumnQueries('assigned');
    }

    public function getInProgressQueriesProperty()
    {
        return $this->getColumnQueries('in_progress');
    }

    public function getSeniorReviewQueriesProperty()
    {
        return $this->getColumnQueries('senior_review');
    }

    public function getCompletedQueriesProperty()
    {
        return $this->getColumnQueries('completed');
    }

    public function render()
    {
        return view('livewire.researcher-kanban')
            ->layout('components.layouts.app');
    }
}
