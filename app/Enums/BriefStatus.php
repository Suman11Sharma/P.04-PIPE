<?php

namespace App\Enums;

enum BriefStatus: string
{
    case Draft = 'draft';
    case UnderReview = 'under_review';
    case Published = 'published';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::UnderReview => 'Under Review',
            self::Published => 'Published',
        };
    }
}
