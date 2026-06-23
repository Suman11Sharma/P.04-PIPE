<?php

namespace App\Console\Commands;

use App\Services\SLABreachService;
use Illuminate\Console\Command;

class CheckSlaBreaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pipe:sla-check
                            {--notify : Send notifications for newly detected breaches}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all active expert queries for SLA deadline breaches and mark overdue items';

    /**
     * Execute the console command.
     */
    public function handle(SLABreachService $slaService): int
    {
        $this->info('Checking for SLA breaches...');

        $count = $slaService->checkAndMarkBreaches();

        if ($count > 0) {
            $this->warn("{$count} SLA breach(es) detected and marked.");
        } else {
            $this->info('No SLA breaches detected.');
        }

        return Command::SUCCESS;
    }
}
