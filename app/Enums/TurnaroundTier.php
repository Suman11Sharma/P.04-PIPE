<?php

namespace App\Enums;

enum TurnaroundTier: string
{
    case ThirtyMinFloor = '30min_floor_support';
    case FortyEightHour = '48hr_analysis';
    case Standard = 'standard_request';

    public function label(): string
    {
        return match ($this) {
            self::ThirtyMinFloor => '30-Minute Floor Support',
            self::FortyEightHour => '48-Hour Analysis',
            self::Standard => 'Standard Request',
        };
    }

    /**
     * Default deadline in hours from creation.
     */
    public function defaultDeadlineHours(): int
    {
        return match ($this) {
            self::ThirtyMinFloor => 1,
            self::FortyEightHour => 48,
            self::Standard => 168, // 7 days
        };
    }
}
