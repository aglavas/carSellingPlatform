<?php

namespace App\Repositories;

use App\Imports\Processing\StockVehicleProcessing;
use App\Service\ExchangeService;
use App\StockVehicle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VehicleRepository
{
    /**
     * @var Model
     */
    public $vehicle;

    /**
     * Filter out columns
     *
     * @var array
     */
    private $nonUpdateableColumns = [
        'manufacturer_id',
        'country',
        'company',
        'company_id',
        'seller',
    ];

    /**
     * VehicleRepository constructor.
     * @param StockVehicle $stockVehicle
     */
    public function __construct(StockVehicle $stockVehicle)
    {
        $this->vehicle = $stockVehicle;
    }

    /**
     * Return all vehicles (for now @todo)
     *
     * @return mixed
     */
    public function getVehicles()
    {
        $vehicleCollection = $this->vehicle->get();

        $vehicleCollection = $this->formatMediaPath($vehicleCollection);

        return $vehicleCollection;
    }

    /**
     * Format media path
     *
     * @param Collection $collection
     * @return Collection
     */
    private function formatMediaPath(Collection $collection)
    {
        foreach ($collection as &$item) {
            if (in_array($item->company_id, [86, 87, 88])) {
                $path = null;

                $mappingArray = config('carmarket.imports.used.nl.mappings');

                $mappingKeys = array_keys($mappingArray);

                foreach ($mappingKeys as $key) {
                    $companyId = $mappingArray[$key]['klantnummer'];

                    if ($companyId == $item->company_id) {
                        if ($item->media_path) {
                            $mediaPathArray = explode(';', $item->media_path);

                            $mediaPathArray = array_filter($mediaPathArray);

                            $fullPath = [];

                            foreach ($mediaPathArray as $image) {
                                $path = asset("nl_images/{$key}/images/$image");

                                array_push($fullPath, $path);
                            }

                            $item->media_path = array_filter($fullPath);
                        }

                    }
                }
            } elseif ($item->company_id === 106) {
                if ($item->media_path) {
                    $mediaPathArray = explode(';', $item->media_path);

                    $mediaPathArray = array_filter($mediaPathArray);

                    $fullPath = [];

                    foreach ($mediaPathArray as $image) {
                        $path = asset("de_images/$image");

                        array_push($fullPath, $path);
                    }

                    $item->media_path = $fullPath;
                }
            } else {
                if ($item->media_path) {
                    $mediaPathArray = explode(';', $item->media_path);

                    $mediaPathArray = array_filter($mediaPathArray);

                    $item->media_path = $mediaPathArray;
                }
            }
        }

        return $collection;
    }

    /**
     * Get price with fee from Bidding API
     *
     * @param StockVehicle $stockVehicle
     * @param string $country
     * @return array|null
     */
    public function getPriceWithFee(StockVehicle $stockVehicle, string $country)
    {
        $stockVehicle->load(['biddingPrices' => function($query) use ($country) {
            $query->where('country_to', $country);
        }]);

        $biddingPrice = $stockVehicle->biddingPrices;

        if ($biddingPrice) {
            return [$biddingPrice->price, $biddingPrice->currency];
        }

        return [null, null];
    }

    /**
     * Get vehicles ready for bidding sync
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getVehiclesForBiddingSync()
    {
        $vehicleQuery = $this->vehicle->query();

        $stockVehicleCollection = $vehicleQuery->select(['sv.*', 'vs.bidding_status'])
            ->from('stock_vehicles AS sv')
            ->leftJoin('vehicle_settings AS vs', 'vs.manufacturer_id', '=', 'sv.manufacturer_id')
            ->whereNotIn('bidding_status', [StockVehicle::STATUS_SYNC_SUCCESS, StockVehicle::STATUS_SYNC_COMPLETED, StockVehicle::STATUS_SYNC_DONT_SYNC])
            ->orWhere(['bidding_status' => null])
            ->get();

        return $stockVehicleCollection;
    }

    /**
     * Get vehicle count with bidding data ready
     *
     * @return int
     */
    public function vehicleCountWithBiddingDataReady()
    {
        $vehicleQuery = $this->vehicle->query();

        $stockVehicleCount = $vehicleQuery->select('*')
            ->leftJoin('vehicle_settings', 'vehicle_settings.manufacturer_id', '=', 'stock_vehicles.manufacturer_id')
            ->where(['bidding_status' => StockVehicle::STATUS_SYNC_SUCCESS])
            ->count();

        return $stockVehicleCount;
    }

    /**
     * Delete vehicle
     *
     * @param StockVehicle $stockVehicle
     * @return bool
     * @throws \Exception
     */
    public function deleteVehicle(StockVehicle $stockVehicle)
    {
        $stockVehicle->delete();

        return true;
    }

    /**
     * Update vehicle
     *
     * @param StockVehicle $vehicle
     * @param array $params
     * @return StockVehicle
     * @throws \App\Exceptions\ImportColumnMissingException
     */
    public function updateVehicle(StockVehicle $vehicle, array $params)
    {
        $exchangeService = new ExchangeService();

        $proccessingClass = new StockVehicleProcessing($exchangeService);

        $params = $proccessingClass->process($params);

        $params = array_diff_key($params, array_flip($this->nonUpdateableColumns));

        $vehicle->update($params);

        return $vehicle;
    }
}
