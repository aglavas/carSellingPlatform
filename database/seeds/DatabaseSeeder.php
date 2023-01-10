<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\StockVehicleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StockVehicleSeeder::class);
        //$this->call('StockVehicleSeeder');
    }
}
