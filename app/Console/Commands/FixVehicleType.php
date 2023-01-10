<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class FixVehicleType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:vehicle:type';

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
        $userCollection = User::all();

        $counter = 0;

        foreach ($userCollection as $user) {
            $vehicleType = $user->vehicle_type;

            if ($vehicleType && in_array('Trucks', $vehicleType)) {
                $index = array_search('Trucks', $vehicleType);

                $vehicleType[$index] = 'Truck';

                $user->vehicle_type = $vehicleType;

                $user->save();

                $counter++;
            }
        }

        $this->info("$counter users processed.");
    }
}
