<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class AddBuyerRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:buyer:role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set buyer role to all users that dont have it';

    /**
     * @var User
     */
    public $user;

    /**
     * AddBuyerRole constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $usersCollection = $this->user->get();

        $counter = 0;

        foreach ($usersCollection as $user) {
            if (!$user->hasRole(['Buyer'])) {
                $counter++;
                $user->assignRole(['Buyer']);
            }
        }

        $this->info("$counter users have been set the Buyer role.");
    }
}
