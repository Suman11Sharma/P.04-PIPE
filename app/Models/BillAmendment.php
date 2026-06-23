<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillAmendment extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'bill_amendments';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'bill_id',
        'version',
        'original_text',
        'amended_text',
        'diff_summary',
        'amendment_notes',
        'proposed_by',
        'applied_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'diff_summary' => 'array',
            'applied_at' => 'datetime',
            'version' => 'integer',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────────────────

    /**
     * The bill this amendment belongs to.
     */
    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }

    /**
     * The user who proposed this amendment.
     */
    public function proposer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'proposed_by');
    }
}
