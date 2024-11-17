<?php

namespace App\Console\Commands;

use App\Models\Visit;
use Illuminate\Console\Command;

class CleanupOldVisits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visits:cleanup {--days=30}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup old visit records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $deleted = Visit::where('visited_at', '<', now()->subDays($days))->delete();
        $this->info("Deleted {$deleted} old visit records.");
    }
}
