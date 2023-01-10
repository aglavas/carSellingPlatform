<?php

namespace App\Http\Controllers\Livewire\Analytics;

use App\StockMercedes;
use App\Traits\AnalyticsFiltering;
use App\Traits\ColorPalette;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class MercedesByCountry extends Component
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

        return view('frontend.livewire.analytics.mercedes-by-country');
    }

    /**
     * Set valuees
     */
    protected function setValues()
    {
        $stockMercedes = new StockMercedes();

        $query = $stockMercedes->select('country', DB::raw('count(*) as total'));

        $query = $this->filterByPeriod($query);

        $countryTotalCollection = $query->groupBy('country')->get();

        $countryArray = $countryTotalCollection->pluck('country')->toArray();

        $valueArray = $countryTotalCollection->pluck('total')->toArray();

        $this->color = $this->getColorArray(count($countryArray));

        $this->countries = $countryArray;

        $this->values = $valueArray;

        $this->rand = rand(11111, 99999999);
    }
}
