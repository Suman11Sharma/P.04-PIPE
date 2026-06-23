<?php

namespace App\Models;

use App\Enums\BillStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'local_identifier',
        'house_origin',
        'status_enum',
        'current_stage_description',
        'constitutional_implications_summary',
        'comparison_matrix',
        'sector_id',
        'tabled_at',
        'voting_records',
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
            'local_identifier' => 'required|string|max:255|unique:bills,local_identifier',
            'house_origin' => 'nullable|string|max:64',
            'status_enum' => 'required|in:tabled,first_reading,second_reading,committee_stage,passed,vetoed',
            'current_stage_description' => 'nullable|string',
            'constitutional_implications_summary' => 'nullable|string',
            'comparison_matrix' => 'nullable|json',
            'tabled_at' => 'nullable|date',
            'voting_records' => 'nullable|json',
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
            'comparison_matrix' => 'array',
            'voting_records' => 'array',
            'tabled_at' => 'datetime',
            'status_enum' => BillStatus::class,
        ];
    }

    // ─── Relationships ───────────────────────────────────────────────────────

    /**
     * The primary sector this bill belongs to.
     */
    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }

    /**
     * All amendments made to this bill across its lifecycle.
     */
    public function amendments(): HasMany
    {
        return $this->hasMany(BillAmendment::class)->latest('version');
    }

    /**
     * The most recent amendment (if any).
     */
    public function latestAmendment(): HasMany
    {
        return $this->hasMany(BillAmendment::class)->latest('version')->take(1);
    }

    // ─── Query Scopes ─────────────────────────────────────────────────────────

    /**
     * Scope to filter bills by current status.
     */
    public function scopeOfStatus(Builder $query, BillStatus $status): Builder
    {
        return $query->where('status_enum', $status->value);
    }

    /**
     * Scope to include only bills currently in committee stage.
     */
    public function scopeInCommittee(Builder $query): Builder
    {
        return $query->where('status_enum', BillStatus::CommitteeStage->value);
    }

    /**
     * Scope to include only bills that are still active (not passed or vetoed).
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotIn('status_enum', [
            BillStatus::Passed->value,
            BillStatus::Vetoed->value,
        ]);
    }

    /**
     * Scope to filter bills by house of origin.
     */
    public function scopeFromHouse(Builder $query, string $house): Builder
    {
        return $query->where('house_origin', $house);
    }

    /**
     * Scope to include the most recently tabled bills first.
     */
    public function scopeRecentlyTabled(Builder $query): Builder
    {
        return $query->latest('tabled_at');
    }
}
