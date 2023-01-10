<?php

namespace App\Http\Controllers\Livewire\Analytics;

use App\StockVehicleNew;
use App\UnifiedView;
use Livewire\Component;
use App\Traits\ColorPalette;
use App\Traits\AnalyticsFiltering;
use Illuminate\Support\Facades\DB;
use App\StockUsedCentralEurope;

class NewCarsByBrandBar extends Component
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

        return view('frontend.livewire.analytics.new-cars-by-brand-bar');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        $stockVehicleNew = new StockVehicleNew();

        $query = $stockVehicleNew->select('brand', DB::raw('count(*) as total'));

        $query = $this->filterByPeriod($query);

        $brandTotalCollection = $query->groupBy('brand')->orderBy('total', 'desc')->get();

        $brandArray = $brandTotalCollection->pluck('brand')->toArray();

        $valueArray = $brandTotalCollection->pluck('total')->toArray();

        $this->color = $this->getColorArray(count($brandArray));

        $this->brand = $brandArray;

        $this->values = $valueArray;

        $this->rand = rand(11111, 99999999);
    }
}
