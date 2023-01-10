<?php

namespace App\Http\Controllers\Livewire\Analytics;

use App\StockVehicle;
use App\Traits\AnalyticsFiltering;
use Livewire\Component;
use App\StockUsedCentralEurope;
use Illuminate\Support\Facades\DB;
use App\Traits\ColorPalette;

class UsedCarsByFuel extends Component
{
    use ColorPalette, AnalyticsFiltering;

    /**
     * @var array
     */
    public $fuel;

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

        return view('frontend.livewire.analytics.used-cars-by-fuel');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        $stockVehicle = new StockVehicle();

        $query = $stockVehicle->select('fuel_type', DB::raw('count(*) as total'))->where('condition_type', 'used');

        $query = $this->filterByPeriod($query);

        $fuelTypeTotalCollection = $query->groupBy('fuel_type')->get();

        $fuelArray = $fuelTypeTotalCollection->pluck('fuel_type')->toArray();

        $valueArray = $fuelTypeTotalCollection->pluck('total')->toArray();

        $this->color = $this->getColorArray(count($fuelArray));

        $this->fuel = $fuelArray;

        $this->values = $valueArray;

        $this->rand = rand(11111, 99999999);
    }
}
