<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Constituency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'province_name',
        'geographic_coordinates',
        'socio_economic_indicators',
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
            'province_name' => 'required|string|max:255',
            'geographic_coordinates' => 'nullable|string',
            'socio_economic_indicators' => 'nullable|json',
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
            'socio_economic_indicators' => 'array',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────────────────

    /**
     * The users (MPs) representing this constituency.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // ─── Query Scopes ─────────────────────────────────────────────────────────

    /**
     * Scope to filter constituencies by province.
     */
    public function scopeInProvince(Builder $query, string $provinceName): Builder
    {
        return $query->where('province_name', $provinceName);
    }

    /**
     * Scope to include only constituencies that have socio-economic data.
     */
    public function scopeWithIndicators(Builder $query): Builder
    {
        return $query->whereNotNull('socio_economic_indicators');
    }
}
