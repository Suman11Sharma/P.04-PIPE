<?php

namespace App\Models;

use App\Enums\BriefStatus;
use App\Enums\UrgencyLevel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PolicyBrief extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'full_content',
        'attachments',
        'sector_id',
        'urgency_level_enum',
        'status_enum',
        'published_at',
        'compiled_by',
        'verified_by',
        'views_count',
    ];

    /**
     * Standard validation rules for this model.
     *
     * @return array<string, string>
     */
    public static function validationRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:policy_briefs,slug',
            'summary' => 'required|string',
            'full_content' => 'required|string',
            'attachments' => 'nullable|json',
            'sector_id' => 'nullable|integer|exists:sectors,id',
            'urgency_level_enum' => 'required|in:low,medium,high',
            'status_enum' => 'required|in:draft,under_review,published',
            'published_at' => 'nullable|date',
            'compiled_by' => 'nullable|integer|exists:users,id',
            'verified_by' => 'nullable|integer|exists:users,id',
            'views_count' => 'integer|min:0',
        ];
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'attachments' => 'array',
            'published_at' => 'datetime',
            'views_count' => 'integer',
            'urgency_level_enum' => UrgencyLevel::class,
            'status_enum' => BriefStatus::class,
        ];
    }

    // ─── Relationships ───────────────────────────────────────────────────────

    /**
     * The sector this policy brief belongs to.
     */
    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }

    /**
     * The user who compiled/authored this brief.
     */
    public function compiler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'compiled_by');
    }

    /**
     * The user who verified/approved this brief.
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Feedback submitted by MPs on this brief.
     */
    public function feedback(): HasMany
    {
        return $this->hasMany(PolicyBriefFeedback::class);
    }

    // ─── Query Scopes ─────────────────────────────────────────────────────────

    /**
     * Scope to filter by active (published) status.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status_enum', BriefStatus::Published->value);
    }

    /**
     * Scope to filter by draft status.
     */
    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status_enum', BriefStatus::Draft->value);
    }

    /**
     * Scope to filter by under review status.
     */
    public function scopeUnderReview(Builder $query): Builder
    {
        return $query->where('status_enum', BriefStatus::UnderReview->value);
    }

    /**
     * Scope to filter by urgency level.
     */
    public function scopeOfUrgency(Builder $query, UrgencyLevel $level): Builder
    {
        return $query->where('urgency_level_enum', $level->value);
    }

    /**
     * Scope to filter by sector.
     */
    public function scopeInSector(Builder $query, int $sectorId): Builder
    {
        return $query->where('sector_id', $sectorId);
    }

    /**
     * Scope to include the most urgent briefs first.
     */
    public function scopeUrgentFirst(Builder $query): Builder
    {
        return $query->orderByRaw(
            "FIELD(urgency_level_enum, 'high', 'medium', 'low')"
        );
    }

    /**
     * Scope to include recently published briefs.
     */
    public function scopeRecentlyPublished(Builder $query): Builder
    {
        return $query->published()->latest('published_at');
    }
}
