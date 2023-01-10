<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class SetVehicleType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:set:vehicle-type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set vehicle type on users that dont have it. Uploader only. (after publish)';

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
        $userCollection = User::role('Logistics')->where('vehicle_type', null)->get();

        $count = 0;

        foreach ($userCollection as $user) {
            $user->vehicle_type = [
                'Passenger',
                'LCV'
            ];

            $user->save();

            $count++;
        }

        $this->info("$count users have their vehicle type set.");

        $userCollection = User::role('Uploader')->where('vehicle_type', null)->get();

        $count = 0;

        foreach ($userCollection as $user) {
            $user->vehicle_type = [
                'Passenger',
                'LCV'
            ];

            $user->save();

            $count++;
        }

        $this->info("$count users have their vehicle type set.");

        return true;
    }
}
