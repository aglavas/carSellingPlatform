<?php

namespace App\Console\Commands;

use App\FrontendNotification;
use Illuminate\Console\Command;

class ResetFrontendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:frontend:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate frontend notifications table (after publish)';

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
        FrontendNotification::truncate();

        $this->info('Done');
    }
}
