<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\ExpertQuery;
use App\Models\PolicyBrief;
use Illuminate\Http\Request;

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

        // Critical system notification (simulated via a high-urgency published brief)
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

        return view('dashboard.index', compact(
            'constituencyName',
            'criticalNotification',
            'intelligenceFeed',
            'activeQueries',
            'recentCompleted',
            'upcomingBills'
        ));
    }
}
