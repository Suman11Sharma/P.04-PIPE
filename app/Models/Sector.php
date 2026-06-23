<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sector extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'icon_class',
    ];

    /**
     * Standard validation rules for this model.
     *
     * @return array<string, string>
     */
    public static function validationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:sectors,slug',
            'icon_class' => 'nullable|string|max:255',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────────────────

    /**
     * Users who follow this sector for personalized feed curation.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_sector')
            ->withTimestamps();
    }

    /**
     * Policy briefs categorized under this sector.
     */
    public function policyBriefs(): HasMany
    {
        return $this->hasMany(PolicyBrief::class);
    }
}
