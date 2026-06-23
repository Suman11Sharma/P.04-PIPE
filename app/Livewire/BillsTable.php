<?php

namespace App\Livewire;

use App\Enums\BillStatus;
use App\Models\Bill;
use Livewire\Component;
use Livewire\WithPagination;

class BillsTable extends Component
{
    use WithPagination;

    /**
     * Active status filter (null = all active bills).
     */
    public ?string $filterStatus = null;

    /**
     * House of origin filter.
     */
    public ?string $filterHouse = null;

    /**
     * Search string for bill title/identifier.
     */
    public string $search = '';

    /**
     * Sort column.
     */
    public string $sortField = 'tabled_at';

    /**
     * Sort direction.
     */
    public string $sortDirection = 'desc';

    /**
     * Reset pagination when filters change.
     */
    protected function queryString(): array
    {
        return [
            'filterStatus' => ['except' => null, 'as' => 'status'],
            'filterHouse' => ['except' => null, 'as' => 'house'],
            'search' => ['except' => '', 'as' => 'q'],
            'sortField' => ['except' => 'tabled_at'],
            'sortDirection' => ['except' => 'desc'],
        ];
    }

    /**
     * Available house origin options.
     */
    public function getHouseOptionsProperty(): array
    {
        return Bill::query()
            ->whereNotNull('house_origin')
            ->select('house_origin')
            ->distinct()
            ->orderBy('house_origin')
            ->pluck('house_origin')
            ->toArray();
    }

    /**
     * Available status options (for filter dropdown).
     */
    public function getStatusOptionsProperty(): array
    {
        return collect(BillStatus::cases())->mapWithKeys(fn (BillStatus $s) => [
            $s->value => $s->label(),
        ])->toArray();
    }

    /**
     * The pipeline stepper stages in order.
     */
    public function getStepperStagesProperty(): array
    {
        return [
            'tabled' => ['label' => 'Tabled', 'icon' => 'M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776'],
            'first_reading' => ['label' => '1st Reading', 'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25'],
            'second_reading' => ['label' => '2nd Reading', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
            'committee_stage' => ['label' => 'Committee', 'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z'],
            'passed' => ['label' => 'Passed', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ];
    }

    /**
     * The status order for the stepper bar.
     */
    public function getStepperOrderProperty(): array
    {
        return ['tabled', 'first_reading', 'second_reading', 'committee_stage', 'passed'];
    }

    /**
     * Toggle sort direction or change sort field.
     */
    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * Reset all filters.
     */
    public function resetFilters(): void
    {
        $this->reset(['filterStatus', 'filterHouse', 'search']);
        $this->resetPage();
    }

    /**
     * Clear a specific filter.
     */
    public function clearFilter(string $filter): void
    {
        $this->$filter = null;
        $this->resetPage();
    }

    /**
     * Get the primary bills query.
     */
    public function getBillsQueryProperty()
    {
        $query = Bill::query()
            ->withCount('amendments')
            ->with('sector');

        // Status filter
        if ($this->filterStatus) {
            $query->where('status_enum', $this->filterStatus);
        }

        // House filter
        if ($this->filterHouse) {
            $query->where('house_origin', $this->filterHouse);
        }

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('local_identifier', 'like', '%' . $this->search . '%');
            });
        }

        // Sort
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query;
    }

    /**
     * Paginated bills for the table.
     */
    public function getBillsProperty()
    {
        return $this->billsQuery->paginate(15);
    }

    /**
     * Determine the stepper progress index for a given bill.
     */
    public function stepperIndex(string $statusValue): int
    {
        return array_search($statusValue, $this->stepperOrder) ?? -1;
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.bills-table', [
            'bills' => $this->bills,
            'houseOptions' => $this->houseOptions,
            'statusOptions' => $this->statusOptions,
            'stepperStages' => $this->stepperStages,
            'stepperOrder' => $this->stepperOrder,
        ]);
    }
}
