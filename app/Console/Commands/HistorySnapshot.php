<?php

namespace App\Console\Commands;

use App\Service\AnalyticsHistoryService;
use Illuminate\Console\Command;

class HistorySnapshot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'history:snapshot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take a history snapshot.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(AnalyticsHistoryService $analyticsHistoryService)
    {
        $analyticsHistoryService();

        $this->info('Snapshot taken!');
    }
}
