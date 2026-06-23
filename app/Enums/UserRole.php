<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case SeniorResearcher = 'senior_researcher';
    case JuniorResearcher = 'junior_researcher';
    case CommitteeChair = 'committee_chair';
    case MP = 'mp';
    case Staff = 'staff';

    /**
     * Get the human-readable label for the role.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::SeniorResearcher => 'Senior Researcher',
            self::JuniorResearcher => 'Junior Researcher',
            self::CommitteeChair => 'Committee Chair',
            self::MP => 'Member of Parliament',
            self::Staff => 'Research Assistant',
        };
    }

    /**
     * Get the roles that have administrative access.
     */
    public static function administrative(): array
    {
        return [self::Admin];
    }

    /**
     * Get the roles that are research-based.
     */
    public static function researchers(): array
    {
        return [self::SeniorResearcher, self::JuniorResearcher];
    }

    /**
     * Get the roles that are parliamentary.
     */
    public static function parliamentary(): array
    {
        return [self::MP, self::CommitteeChair, self::Staff];
    }
}
