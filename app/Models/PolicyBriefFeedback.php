<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PolicyBriefFeedback extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'policy_brief_feedback';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'policy_brief_id',
        'user_id',
        'rating',
        'error_tags',
        'revision_request',
        'status_enum',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'boolean',
            'error_tags' => 'array',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────────────────

    /**
     * The policy brief this feedback belongs to.
     */
    public function policyBrief(): BelongsTo
    {
        return $this->belongsTo(PolicyBrief::class);
    }

    /**
     * The MP who submitted this feedback.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
