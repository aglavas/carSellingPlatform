<?php

namespace App\Service;

use App\AnalyticsHistory;
use App\StockUsedCentralEurope;
use App\StockVehicleNew;
use App\StockVehicleUsed;
use App\UnifiedView;
use Illuminate\Support\Facades\DB;

class AnalyticsHistoryService
{
    /**
     * Collect analytics snapshot
     */
    public function __invoke()
    {
        $usedCars = StockVehicleUsed::query();
        $newCars = StockVehicleNew::query();

        $usedCarsCount = $usedCars->count();
        $newCarsCount = $newCars->count();
        $usedCarsCountPerCountry = $usedCars->select('country', DB::raw('count(*) as total'))->groupBy('country')->get()->keyBy('country')->toArray();
        $newCarsCountPerCountry = $newCars->select('country', DB::raw('count(*) as total'))->groupBy('country')->get()->keyBy('country')->toArray();
        $usedCarsAvgPricePerAge = DB::select("
          SELECT  age , AVG(price_in_euro) as avgprice FROM (
          SELECT  date_part('year', age(firstregistration)) as age,
             price_in_euro
          FROM stock_vehicles WHERE condition_type = 'used' 
          ) temp_table
          GROUP BY age
          ORDER BY age
          ");

        $usedCarsAvgPricePerAgeArray = array_map(function ($value) {
            return (array)$value;
        }, $usedCarsAvgPricePerAge);

        $usedCarsAvgPricePerAgeResult = collect($usedCarsAvgPricePerAgeArray)->keyBy('age')->toArray();

        $statsArray = [
            'CountOfUsedCars' => $usedCarsCount,
            'CountOfNewCars' => $newCarsCount,
            'CountOfUsedCarsPerCountry' => $usedCarsCountPerCountry,
            'CountOfNewCarsPerCountry' => $newCarsCountPerCountry,
            'AvgPriceOfUsedCarsPerAge' => $usedCarsAvgPricePerAgeResult,
        ];

        AnalyticsHistory::create([
            'stats' => $statsArray
        ]);
    }
}
