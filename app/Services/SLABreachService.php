<?php

namespace App\Services;

use App\Enums\QueryStatus;
use App\Models\ExpertQuery;
use Illuminate\Support\Facades\Log;

/**
 * SLABreachService monitors and manages SLA compliance for expert queries.
 *
 * Responsibilities:
 * - Detect overdue queries past their target deadline
 * - Dispatch breach notifications
 * - Mark queries as breached
 */
class SLABreachService
{
    /**
     * The grace period in minutes before an SLA breach is recorded
     * (allows small processing delays).
     */
    protected int $gracePeriodMinutes = 5;

    /**
     * Find all active queries that have exceeded their SLA deadline
     * and mark them as breached.
     *
     * @return int Number of queries marked as breached.
     */
    public function checkAndMarkBreaches(): int
    {
        $breachCount = 0;

        // Find queries past deadline that haven't been breached yet
        ExpertQuery::query()
            ->whereNotNull('target_deadline')
            ->where('target_deadline', '<', now()->subMinutes($this->gracePeriodMinutes))
            ->whereNull('sla_breached_at')
            ->whereNotIn('status_enum', [
                QueryStatus::Completed->value,
                QueryStatus::SeniorReview->value,
            ])
            ->chunk(50, function ($queries) use (&$breachCount) {
                foreach ($queries as $query) {
                    $this->markBreached($query);
                    $breachCount++;
                }
            });

        return $breachCount;
    }

    /**
     * Mark a specific query as SLA-breached and dispatch notifications.
     */
    public function markBreached(ExpertQuery $query): void
    {
        $query->update([
            'sla_breached_at' => now(),
            'sla_breach_notified' => true,
        ]);

        $this->dispatchNotification($query);

        Log::warning(sprintf(
            '[PIPE SLA BREACH] Query #%d "%s" (%s) exceeded deadline of %s. Assigned to researcher #%s.',
            $query->id,
            $query->title,
            $query->turnaround_tier_enum->label(),
            $query->target_deadline?->toDateTimeString() ?? 'N/A',
            $query->assigned_researcher_id ?? 'unassigned'
        ));
    }

    /**
     * Calculate the target deadline for a given turnaround tier,
     * relative to the current time or a provided start time.
     */
    public function calculateDeadline(string $turnaroundTier, ?\DateTimeInterface $from = null): \DateTimeInterface
    {
        $from = $from ?? now();

        $hours = match ($turnaroundTier) {
            '30min_floor_support' => 1,
            '48hr_analysis' => 48,
            default => 168, // 7 days
        };

        return $from->modify("+{$hours} hours");
    }

    /**
     * Check if a query's remaining time is within the warning threshold
     * (e.g., 25% of SLA time remaining).
     */
    public function isAtRisk(ExpertQuery $query): bool
    {
        if (! $query->target_deadline || $query->sla_breached_at) {
            return false;
        }

        $totalSeconds = $query->created_at?->diffInSeconds($query->target_deadline) ?? 0;
        $remainingSeconds = now()->diffInSeconds($query->target_deadline, false);

        // At risk if less than 25% of time remains
        return $totalSeconds > 0 && $remainingSeconds > 0
            && ($remainingSeconds / $totalSeconds) < 0.25;
    }

    /**
     * Simulate dispatching a breach notification.
     * In production, replace with actual email/SMS/Teams webhook.
     */
    protected function dispatchNotification(ExpertQuery $query): void
    {
        // Simulated notification — in production, send to assigned researcher
        // and their senior via email/Slack/Teams.
        session()->flash('sla_breach', sprintf(
            'SLA BREACHED: Query "%s" has exceeded its deadline.',
            $query->title
        ));
    }
}
