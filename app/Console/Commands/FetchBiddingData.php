<?php

namespace App\Console\Commands;

use App\Repositories\VehicleRepository;
use App\Service\CarBidding\BiddingService;
use Illuminate\Console\Command;

class FetchBiddingData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bidding:sync:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync bidding data';

    /**
     * @var BiddingService
     */
    public $biddingService;

    /**
     * @var VehicleRepository
     */
    public $vehicleRepository;

    /**
     * FetchBiddingData constructor.
     * @param BiddingService $biddingService
     * @param VehicleRepository $vehicleRepository
     */
    public function __construct(BiddingService $biddingService, VehicleRepository $vehicleRepository)
    {
        parent::__construct();

        $this->biddingService = $biddingService;
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
        $vehicleCollection = $this->vehicleRepository->getVehiclesForBiddingSync();

        if (count($vehicleCollection)) {
            $this->biddingService->sendCarData($vehicleCollection);
        }

        $this->info('Sync completed');
    }
}
