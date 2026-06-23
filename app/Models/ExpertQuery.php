<?php

namespace App\Models;

use App\Enums\QueryStatus;
use App\Enums\TurnaroundTier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpertQuery extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'explicit_description',
        'audio_note_path',
        'attachments',
        'status_enum',
        'turnaround_tier_enum',
        'assigned_researcher_id',
        'bill_id',
        'reviewed_by',
        'target_deadline',
        'historical_precedents_context',
        'response_text',
        'senior_notes',
        'resolved_at',
        'sla_breached_at',
        'sla_breach_notified',
    ];

    /**
     * Standard validation rules for this model.
     *
     * @return array<string, string>
     */
    public static function validationRules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:255',
            'explicit_description' => 'required|string',
            'audio_note_path' => 'nullable|string|max:255',
            'attachments' => 'nullable|json',
            'status_enum' => 'required|in:pending,assigned,in_progress,senior_review,completed',
            'turnaround_tier_enum' => 'required|in:30min_floor_support,48hr_analysis,standard_request',
            'assigned_researcher_id' => 'nullable|integer|exists:users,id',
            'bill_id' => 'nullable|integer|exists:bills,id',
            'reviewed_by' => 'nullable|integer|exists:users,id',
            'target_deadline' => 'nullable|date',
            'historical_precedents_context' => 'nullable|string',
            'response_text' => 'nullable|string',
            'senior_notes' => 'nullable|string',
            'resolved_at' => 'nullable|date',
            'sla_breached_at' => 'nullable|date',
            'sla_breach_notified' => 'boolean',
        ];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'attachments' => 'array',
            'target_deadline' => 'datetime',
            'resolved_at' => 'datetime',
            'sla_breached_at' => 'datetime',
            'sla_breach_notified' => 'boolean',
            'status_enum' => QueryStatus::class,
            'turnaround_tier_enum' => TurnaroundTier::class,
        ];
    }

    // ─── Relationships ───────────────────────────────────────────────────────

    /**
     * The MP who submitted this query.
     */
    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The researcher assigned to handle this query.
     */
    public function assignedResearcher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_researcher_id');
    }

    /**
     * The senior researcher who performed the editorial review.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * The associated bill (for floor support requests).
     */
    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }

    // ─── Query Scopes ─────────────────────────────────────────────────────────

    /**
     * Scope to filter by query status.
     */
    public function scopeOfStatus(Builder $query, QueryStatus $status): Builder
    {
        return $query->where('status_enum', $status->value);
    }

    /**
     * Scope to include only pending queries.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status_enum', QueryStatus::Pending->value);
    }

    /**
     * Scope to include only assigned queries.
     */
    public function scopeAssigned(Builder $query): Builder
    {
        return $query->where('status_enum', QueryStatus::Assigned->value);
    }

    /**
     * Scope to include only in-progress queries.
     */
    public function scopeInProgress(Builder $query): Builder
    {
        return $query->where('status_enum', QueryStatus::InProgress->value);
    }

    /**
     * Scope to include only queries in senior review.
     */
    public function scopeInSeniorReview(Builder $query): Builder
    {
        return $query->where('status_enum', QueryStatus::SeniorReview->value);
    }

    /**
     * Scope to include only completed queries.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status_enum', QueryStatus::Completed->value);
    }

    /**
     * Scope to filter by turnaround tier.
     */
    public function scopeOfTier(Builder $query, TurnaroundTier $tier): Builder
    {
        return $query->where('turnaround_tier_enum', $tier->value);
    }

    /**
     * Scope to include queries in a specific kanban column.
     */
    public function scopeInKanbanColumn(Builder $query, string $statusValue): Builder
    {
        return $query->where('status_enum', $statusValue);
    }

    /**
     * Scope to include queries that have breached their SLA.
     */
    public function scopeSlaBreached(Builder $query): Builder
    {
        return $query->whereNotNull('sla_breached_at');
    }

    /**
     * Scope to include queries approaching their SLA deadline.
     * Uses a 2-hour threshold for database portability.
     */
    public function scopeAtSlaRisk(Builder $query): Builder
    {
        $threshold = now()->addHours(2);
        return $query->whereNotNull('target_deadline')
            ->whereNull('sla_breached_at')
            ->whereNotIn('status_enum', [QueryStatus::Completed->value])
            ->where('target_deadline', '>', now())
            ->where('target_deadline', '<', $threshold);
    }

    /**
     * Scope to include queries that are overdue past their target deadline.
     */
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->whereNotNull('target_deadline')
            ->where('target_deadline', '<', now())
            ->where('status_enum', '!=', QueryStatus::Completed->value);
    }

    /**
     * Scope to include queries assigned to a specific researcher.
     */
    public function scopeAssignedTo(Builder $query, int $researcherId): Builder
    {
        return $query->where('assigned_researcher_id', $researcherId);
    }

    /**
     * Scope to include queries submitted by a specific user (MP).
     */
    public function scopeSubmittedBy(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to include active (non-completed) queries in priority order:
     * 30-min floor first, then 48hr, then standard — ordered by deadline.
     */
    public function scopePriorityOrder(Builder $query): Builder
    {
        return $query->whereNotIn('status_enum', [QueryStatus::Completed->value])
            ->orderByRaw("FIELD(turnaround_tier_enum, '30min_floor_support', '48hr_analysis', 'standard_request')")
            ->orderBy('target_deadline');
    }

    /**
     * Scope for the researcher kanban: orders by SLA breach first,
     * then turnaround priority, then deadline.
     */
    public function scopeKanbanOrder(Builder $query): Builder
    {
        return $query->orderByRaw('sla_breached_at IS NOT NULL DESC')
            ->orderByRaw("FIELD(turnaround_tier_enum, '30min_floor_support', '48hr_analysis', 'standard_request')")
            ->orderBy('target_deadline');
    }

    // ─── Accessors ─────────────────────────────────────────────────────────

    /**
     * Determine if this query has breached its SLA.
     */
    public function getIsSlaBreachedAttribute(): bool
    {
        return $this->sla_breached_at !== null;
    }

    /**
     * Get the CSS class for the SLA status indicator.
     * Pre-defined strings for Tailwind JIT detection.
     */
    public function getSlaIndicatorClassAttribute(): string
    {
        if ($this->sla_breached_at) {
            return 'bg-red-500 animate-pulse text-white';
        }

        // Check if 30-min floor support (highest priority)
        if ($this->turnaround_tier_enum === TurnaroundTier::ThirtyMinFloor) {
            return 'bg-amber-500 text-white';
        }

        return 'bg-slate-700 text-slate-300';
    }
}
