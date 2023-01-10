<?php

namespace App\Console\Commands;

use App\FilterSearch;
use Illuminate\Console\Command;

class ResetFilterSearches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:filter:searches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncates filter searches table (after publish)';

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
    public function handle()
    {
        FilterSearch::truncate();

        $this->info('Done');
    }
}
