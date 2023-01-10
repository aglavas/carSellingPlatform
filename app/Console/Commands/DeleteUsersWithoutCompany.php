<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class DeleteUsersWithoutCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:users:without:company';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users without company';

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
        $userCount = User::whereNull('company_id')->delete();

        $this->info("$userCount users deleted");

        return true;
    }
}
