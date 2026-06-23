<?php

namespace App\Enums;

enum BillStatus: string
{
    case Tabled = 'tabled';
    case FirstReading = 'first_reading';
    case SecondReading = 'second_reading';
    case CommitteeStage = 'committee_stage';
    case Passed = 'passed';
    case Vetoed = 'vetoed';

    public function label(): string
    {
        return match ($this) {
            self::Tabled => 'Tabled',
            self::FirstReading => 'First Reading',
            self::SecondReading => 'Second Reading',
            self::CommitteeStage => 'Committee Stage',
            self::Passed => 'Passed',
            self::Vetoed => 'Vetoed',
        };
    }

    /**
     * Get the next possible statuses in the workflow.
     */
    public function next(): array
    {
        return match ($this) {
            self::Tabled => [self::FirstReading],
            self::FirstReading => [self::SecondReading, self::Vetoed],
            self::SecondReading => [self::CommitteeStage, self::Vetoed],
            self::CommitteeStage => [self::Passed, self::Vetoed],
            self::Passed => [],
            self::Vetoed => [],
        };
    }
}
