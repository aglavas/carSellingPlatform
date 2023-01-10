<?php

namespace Database\Seeders;

use App\StockVehicle;
use Database\Factories\StockVehicleFactory;
use Illuminate\Database\Seeder;

class StockVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StockVehicle::factory()->count(50)->create();
    }
}
