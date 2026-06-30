<?php

namespace App\Livewire;

use App\Enums\QueryStatus;
use App\Models\ExpertQuery;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminDashboardQueries extends Component
{
    use WithPagination;

    /**
     * Available researchers for assignment dropdown.
     */
    public function getResearchersProperty()
    {
        return User::query()
            ->researchers()
            ->select('id', 'name', 'role_enum')
            ->orderBy('name')
            ->get();
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

        $this->dispatch('notify', message: 'Query assigned successfully.');
    }

    public function render()
    {
        $queries = ExpertQuery::query()
            ->whereIn('status_enum', [QueryStatus::Pending->value, QueryStatus::Assigned->value])
            ->with('submitter', 'assignedResearcher')
            ->latest()
            ->paginate(10);

        return view('livewire.admin-dashboard-queries', [
            'queries' => $queries,
            'researchers' => $this->researchers,
        ]);
    }
}
