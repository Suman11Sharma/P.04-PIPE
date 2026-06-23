<?php

namespace App\Enums;

enum QueryStatus: string
{
    case Pending = 'pending';
    case Assigned = 'assigned';
    case InProgress = 'in_progress';
    case SeniorReview = 'senior_review';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Unassigned',
            self::Assigned => 'Active Processing',
            self::InProgress => 'In Progress',
            self::SeniorReview => 'Senior Editorial Review',
            self::Completed => 'Transmitted to Parliament',
        };
    }

    /**
     * Kanban column order for the researcher dashboard.
     */
    public static function kanbanOrder(): array
    {
        return [self::Pending, self::Assigned, self::InProgress, self::SeniorReview, self::Completed];
    }

    /**
     * Get the next status in the review workflow.
     */
    public function nextInWorkflow(): ?self
    {
        return match ($this) {
            self::Pending => self::Assigned,
            self::Assigned => self::InProgress,
            self::InProgress => self::SeniorReview,
            self::SeniorReview => self::Completed,
            self::Completed => null,
        };
    }
}
