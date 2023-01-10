<?php

namespace App\Console\Commands;

use App\Company;
use Illuminate\Console\Command;

class DeleteCompaniesWithoutUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:companies:without:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete companies without users attached';

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
        $companyCount = Company::doesntHave('users')->delete();

        $this->info("$companyCount companies deleted");

        return true;
    }
}
