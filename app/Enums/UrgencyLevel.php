<?php

namespace App\Enums;

enum UrgencyLevel: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    public function label(): string
    {
        return match ($this) {
            self::Low => 'Low',
            self::Medium => 'Medium',
            self::High => 'High',
        };
    }

    /**
     * Get the color code for the urgency level (for UI badges).
     */
    public function color(): string
    {
        return match ($this) {
            self::Low => 'green',
            self::Medium => 'amber',
            self::High => 'red',
        };
    }
}
