<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'role_enum',
        'constituency_id',
        'committee_id',
        'phone_number',
        'profile_photo_path',
        'dynamic_preferences',
        'two_factor_secret',
        'two_factor_recovery_codes',
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
            'email' => 'required|email|max:255|unique:users,email',
            'email_verified_at' => 'nullable|date',
            'password' => 'required|string|min:8',
            'role_enum' => 'required|in:admin,senior_researcher,junior_researcher,committee_chair,mp,staff',
            'constituency_id' => 'nullable|integer|exists:constituencies,id',
            'committee_id' => 'nullable|integer',
            'phone_number' => 'nullable|string|max:32',
            'profile_photo_path' => 'nullable|string|max:255',
            'dynamic_preferences' => 'nullable|json',
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = [
        'role_label',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dynamic_preferences' => 'array',
            'two_factor_secret' => 'encrypted',
            'two_factor_recovery_codes' => 'encrypted',
            'role_enum' => UserRole::class,
        ];
    }

    // ─── Relationships ───────────────────────────────────────────────────────

    /**
     * The constituency this user represents or belongs to.
     */
    public function constituency(): BelongsTo
    {
        return $this->belongsTo(Constituency::class);
    }

    /**
     * The sectors this user follows for personalized feed curation.
     */
    public function sectors(): BelongsToMany
    {
        return $this->belongsToMany(Sector::class, 'user_sector')
            ->withTimestamps();
    }

    /**
     * Policy briefs compiled/authored by this user.
     */
    public function compiledBriefs(): HasMany
    {
        return $this->hasMany(PolicyBrief::class, 'compiled_by');
    }

    /**
     * Policy briefs verified/approved by this user.
     */
    public function verifiedBriefs(): HasMany
    {
        return $this->hasMany(PolicyBrief::class, 'verified_by');
    }

    /**
     * Expert queries submitted by this user (as an MP).
     */
    public function submittedQueries(): HasMany
    {
        return $this->hasMany(ExpertQuery::class, 'user_id');
    }

    /**
     * Expert queries assigned to this user (as a researcher).
     */
    public function assignedQueries(): HasMany
    {
        return $this->hasMany(ExpertQuery::class, 'assigned_researcher_id');
    }

    // ─── Accessors ───────────────────────────────────────────────────────────

    /**
     * Get the human-readable role label.
     */
    public function getRoleLabelAttribute(): string
    {
        return $this->role_enum instanceof UserRole
            ? $this->role_enum->label()
            : ucfirst(str_replace('_', ' ', $this->role_enum));
    }

    /**
     * Determine if the user has administrative privileges.
     */
    public function isAdmin(): bool
    {
        return $this->role_enum === UserRole::Admin;
    }

    /**
     * Determine if the user is a researcher (senior or junior).
     */
    public function isResearcher(): bool
    {
        return in_array($this->role_enum, [UserRole::SeniorResearcher, UserRole::JuniorResearcher], true);
    }

    /**
     * Determine if the user is a senior researcher.
     */
    public function isSeniorResearcher(): bool
    {
        return $this->role_enum === UserRole::SeniorResearcher;
    }

    /**
     * Determine if the user is an MP or Committee Chair.
     */
    public function isParliamentary(): bool
    {
        return in_array($this->role_enum, [UserRole::MP, UserRole::CommitteeChair, UserRole::Staff], true);
    }

    /**
     * Determine if the user can peer-review and approve policy briefs.
     */
    public function canApproveBriefs(): bool
    {
        return in_array($this->role_enum, [
            UserRole::Admin,
            UserRole::SeniorResearcher,
            UserRole::CommitteeChair,
        ], true);
    }

    // ─── Query Scopes ─────────────────────────────────────────────────────────

    /**
     * Scope to filter users by a specific role.
     */
    public function scopeOfRole(Builder $query, UserRole $role): Builder
    {
        return $query->where('role_enum', $role->value);
    }

    /**
     * Scope to include only administrative users.
     */
    public function scopeAdmins(Builder $query): Builder
    {
        return $query->whereIn('role_enum', array_map(fn (UserRole $r) => $r->value, UserRole::administrative()));
    }

    /**
     * Scope to include only research users.
     */
    public function scopeResearchers(Builder $query): Builder
    {
        return $query->whereIn('role_enum', array_map(fn (UserRole $r) => $r->value, UserRole::researchers()));
    }

    /**
     * Scope to include only parliamentary users (MPs, Committee Chairs, Staff).
     */
    public function scopeParliamentary(Builder $query): Builder
    {
        return $query->whereIn('role_enum', array_map(fn (UserRole $r) => $r->value, UserRole::parliamentary()));
    }

    /**
     * Scope to filter users by constituency.
     */
    public function scopeFromConstituency(Builder $query, int $constituencyId): Builder
    {
        return $query->where('constituency_id', $constituencyId);
    }

    /**
     * Scope to filter users by committee.
     */
    public function scopeFromCommittee(Builder $query, int $committeeId): Builder
    {
        return $query->where('committee_id', $committeeId);
    }

    /**
     * Scope that includes only users with active email verification.
     */
    public function scopeVerified(Builder $query): Builder
    {
        return $query->whereNotNull('email_verified_at');
    }
}
