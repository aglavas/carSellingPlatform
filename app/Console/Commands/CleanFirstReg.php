<?php

namespace App\Console\Commands;

use App\StockVehicle;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanFirstReg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:first:reg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean first registration date';

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
        $stockVehicleCollection = StockVehicle::get();

        $counter = 0;

        foreach ($stockVehicleCollection as $stockVehicle) {
            /** @var Carbon $firstRegistration */
            $firstRegistration = $stockVehicle->firstregistration;

            if ($firstRegistration) {
                $result = $firstRegistration->isFuture();

                if ($result) {
                    $firstRegistration->year(2021);
                    $stockVehicle->firstregistration = $firstRegistration->format('Y-m-d');
                    $stockVehicle->save();
                    $counter++;
                }
            }
        }

        $this->info("$counter vehicles updated");
    }
}
