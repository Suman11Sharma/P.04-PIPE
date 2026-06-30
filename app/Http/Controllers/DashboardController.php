<?php

namespace App\Http\Controllers;

use App\Enums\QueryStatus;
use App\Enums\UserRole;
use App\Models\Bill;
use App\Models\ExpertQuery;
use App\Models\PolicyBrief;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Render the personalised MP dashboard with all components.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $user->loadMissing('constituency', 'sectors');

        // ── Sector IDs the user follows ──────────────────────────────────
        $sectorIds = $user->sectors()->pluck('sectors.id');

        // ─── 1. Hero Banner Data ─────────────────────────────────────────
        $constituencyName = $user->constituency?->name ?? 'your constituency';

        // Critical system notification
        $criticalNotification = PolicyBrief::query()
            ->published()
            ->ofUrgency(\App\Enums\UrgencyLevel::High)
            ->latest('published_at')
            ->first();

        // ─── 2. Personalized Intelligence Feed ──────────────────────────
        $intelligenceFeed = PolicyBrief::query()
            ->published()
            ->when($sectorIds->isNotEmpty(), function ($q) use ($sectorIds) {
                $q->whereIn('sector_id', $sectorIds);
            })
            ->with('sector', 'compiler')
            ->latest('published_at')
            ->take(6)
            ->get();

        // ─── 3. Status Tracker (Active Expert Queries) ──────────────────
        $activeQueries = ExpertQuery::query()
            ->submittedBy($user->id)
            ->where('status_enum', '!=', \App\Enums\QueryStatus::Completed->value)
            ->with('assignedResearcher')
            ->priorityOrder()
            ->get();

        $recentCompleted = ExpertQuery::query()
            ->submittedBy($user->id)
            ->completed()
            ->latest('resolved_at')
            ->take(3)
            ->get();

        // ─── 4. Upcoming Legislation ────────────────────────────────────
        $upcomingBills = Bill::query()
            ->active()
            ->recentlyTabled()
            ->take(5)
            ->get();

        // ─── 5. Admin Stats Cards ──────────────────────────────────────
        $stats = [
            'total_users' => User::count(),
            'total_mps' => User::ofRole(UserRole::MP)->count(),
            'total_queries' => ExpertQuery::count(),
            'queries_completed' => ExpertQuery::completed()->count(),
            'queries_pending' => ExpertQuery::pending()->count(),
        ];

        // ─── 6. Monthly Query Chart — Single Month with Filter ─────────

        // Build month options (last 12 months) for the dropdown
        $monthOptions = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthOptions[$date->format('Y-m')] = $date->format('F Y');
        }

        // Get selected month from query string, default to current month
        $selectedMonth = $request->query('month', now()->format('Y-m'));

        // If the selected month is not in the valid range, fall back to current
        if (!isset($monthOptions[$selectedMonth])) {
            $selectedMonth = now()->format('Y-m');
        }

        // Query data for the selected month only
        $monthStart = \Carbon\Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();

        $monthData = ExpertQuery::query()
            ->select(
                DB::raw("SUM(CASE WHEN status_enum = 'completed' THEN 1 ELSE 0 END) as completed"),
                DB::raw("SUM(CASE WHEN status_enum != 'completed' THEN 1 ELSE 0 END) as pending")
            )
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->first();

        $chartCompleted = (int) ($monthData->completed ?? 0);
        $chartPending = (int) ($monthData->pending ?? 0);
        $chartMax = max($chartCompleted, $chartPending, 1);

        // Selected month label for display
        $selectedMonthLabel = $monthStart->format('F Y');

        return view('dashboard.index', compact(
            'constituencyName',
            'criticalNotification',
            'intelligenceFeed',
            'activeQueries',
            'recentCompleted',
            'upcomingBills',
            'stats',
            'monthOptions',
            'selectedMonth',
            'selectedMonthLabel',
            'chartCompleted',
            'chartPending',
            'chartMax'
        ));
    }
}
