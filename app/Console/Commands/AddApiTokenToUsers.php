<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AddApiTokenToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:token:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API token for all users';

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
        $usersCollection = User::all();

        foreach ($usersCollection as $user) {
            $user->api_token = Str::random(60);
            $user->save();
        }
    }
}
