<?php

namespace App\Http\Controllers\Livewire\Analytics;

use App\StockUsedCentralEurope;
use App\StockVehicle;
use App\UnifiedView;
use Livewire\Component;
use App\Traits\ColorPalette;
use App\Traits\AnalyticsFiltering;
use Illuminate\Support\Facades\DB;

class CarsByCountry extends Component
{
    use ColorPalette, AnalyticsFiltering;

    /**
     * @var array
     */
    public $countries;

    /**
     * @var array
     */
    public $values;

    /**
     * @var integer
     */
    public $rand;

    /**
     * @var array
     */
    public $color = [];

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->setValues();

        return view('frontend.livewire.analytics.cars-by-country');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        $stockVehicle = new StockVehicle();

        $countryArray = array_values($stockVehicle->distinct()->pluck('country', 'country')->toArray());

        asort($countryArray);

        $this->countries = array_values($countryArray);

        $queryUsed = $stockVehicle->select('country', DB::raw('count(*) as total'))->where('condition_type', 'used');
        $queryNew = $stockVehicle->select('country', DB::raw('count(*) as total'))->where('condition_type', 'new');

        $queryUsed = $this->filterByPeriod($queryUsed);
        $queryNew = $this->filterByPeriod($queryNew);

        $usedCarCollection = $queryUsed->groupBy('country')->get();
        $newCarCollection = $queryNew->groupBy('country')->get();

        $colorArray = $this->getColorArray(2, true);

        $usedCarsArray = $usedCarCollection->keyBy('country')->toArray();
        $newCarsArray = $newCarCollection->keyBy('country')->toArray();

        $usedCarsValueArray = [];
        $newCarsValueArray = [];

        foreach ($this->countries as $country) {
            if (isset($usedCarsArray[$country])) {
                array_push($usedCarsValueArray, $usedCarsArray[$country]['total']);
            } else {
                array_push($usedCarsValueArray, 0);
            }

            if (isset($newCarsArray[$country])) {
                array_push($newCarsValueArray, $newCarsArray[$country]['total']);
            } else {
                array_push($newCarsValueArray, 0);
            }
        }

        $valueArray = [
            [
                'label' => 'Used Cars',
                'backgroundColor' => $colorArray[0],
                'data' => $usedCarsValueArray
            ],
            [
                'label' => 'New Cars',
                'backgroundColor' => $colorArray[1],
                'data' => $newCarsValueArray
            ]
        ];

        $this->countries = array_map('strtoupper', $this->countries);

        $this->values = $valueArray;

        $this->rand = rand(11111, 99999999);
    }
}
