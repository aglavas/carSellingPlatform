<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunAllApiImportCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:all:vehicles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs NL, DE, CZ API vehicle import commands (after publish)';

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
        $this->info('NL import.');
        $this->call('import:vehicles:nl');
        $this->info('NL import is completed.');

        $this->info('DE import.');
        $this->call('import:vehicles:de');
        $this->info('DE import is completed.');

        $this->info('CZ import.');
        $this->call('import:vehicles:cz');
        $this->info('CZ import is completed.');
    }
}
