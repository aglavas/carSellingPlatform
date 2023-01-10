<?php

namespace App\Console\Commands;

use App\Repositories\VehicleRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TriggerBiddingCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bidding:trigger:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trigger bidding cron for returning data';

    /**
     * @var string
     */
    public $cronTriggerUrl;

    /**
     * @var VehicleRepository
     */
    public $vehicleRepository;

    /**
     * TriggerBiddingCron constructor.
     * @param VehicleRepository $vehicleRepository
     */
    public function __construct(VehicleRepository $vehicleRepository)
    {
        parent::__construct();

        $this->cronTriggerUrl = config('carmarket.bidding.cron_trigger_url');
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle()
    {
        $count = $this->vehicleRepository->vehicleCountWithBiddingDataReady();

        if ($count) {
            $response = Http::get($this->cronTriggerUrl);
        }

        return true;
    }
}
