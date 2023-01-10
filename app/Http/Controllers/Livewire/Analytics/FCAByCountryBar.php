<?php

namespace App\Http\Controllers\Livewire\Analytics;

use Livewire\Component;

use App\Traits\ColorPalette;
use App\Traits\AnalyticsFiltering;
use App\StockVehicle;
use Illuminate\Support\Facades\DB;

class FCAByCountryBar extends Component
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

        return view('frontend.livewire.analytics.f-c-a-by-country-bar');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        $stockVehicles = new StockVehicle();

        $query = $stockVehicles->select('country', DB::raw('count(*) as total'))->whereIn('brand', ['Abarth', 'Alfa Romeo', 'Chrysler', 'Dodge', 'Fiat', 'Fiat Professional', 'Jeep', 'Lancia', 'Maserati', 'Ram Truck']);

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
