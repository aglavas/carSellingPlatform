<?php

namespace App\Http\Controllers\Livewire\Analytics;

use App\StockVehicle;
use App\Traits\ColorPalette;
use App\Traits\AnalyticsFiltering;
use App\StockOpel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OpelByCountryBar extends Component
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

        return view('frontend.livewire.analytics.opel-by-country-bar');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        $stockVehicle = new StockVehicle();

        $query = $stockVehicle->select('country', DB::raw('count(*) as total'))->whereIn('brand', ['Opel']);

        $query = $this->filterByPeriod($query);

        $countryTotalCollection = $query->groupBy('country')->get();

        $countryArray = $countryTotalCollection->pluck('country')->toArray();

        $valueArray = $countryTotalCollection->pluck('total')->toArray();

        $colorArray = $this->getCountryColorArray($countryArray);

        $this->color = array_values($colorArray);

        $this->countries = $countryArray;

        $this->values = $valueArray;

        $this->rand = rand(11111, 99999999);
    }
}
