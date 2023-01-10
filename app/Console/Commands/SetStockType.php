<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class SetStockType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:set:stock-type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $userCollection = User::where('stock_type', null)->get();

        $count = 0;

        foreach ($userCollection as $user) {
            $user->stock_type = 'UC';

            $user->save();

            $count++;
        }

        $this->info("$count users have their stock type set.");

        return true;
    }
}
