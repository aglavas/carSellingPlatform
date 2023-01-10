<?php

namespace App\Http\Controllers\Livewire\Analytics;

use App\Traits\AnalyticsFiltering;
use App\Traits\ColorPalette;
use Livewire\Component;
use App\StockUsedCentralEurope;
use Illuminate\Support\Facades\DB;

class UsedCarsByBrand extends Component
{
    use ColorPalette, AnalyticsFiltering;

    /**
     * @var array
     */
    public $brand;

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

        return view('frontend.livewire.analytics.used-cars-by-brand');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        $stockUsedCentralEurope = new StockUsedCentralEurope();

        $query = $stockUsedCentralEurope->select('brand', DB::raw('count(*) as total'));

        $query = $this->filterByPeriod($query);

        $brandTotalCollection = $query->groupBy('brand')->get();

        $brandArray = $brandTotalCollection->pluck('brand')->toArray();

        $valueArray = $brandTotalCollection->pluck('total')->toArray();

        $this->color = $this->getColorArray(count($brandArray));

        $this->brand = $brandArray;

        $this->values = $valueArray;

        $this->rand = rand(11111, 99999999);
    }
}
