<?php

namespace App\Http\Controllers\Livewire\Analytics;

use App\Traits\AnalyticsFiltering;
use App\Traits\ColorPalette;
use App\Traits\MetricsByAge;
use Livewire\Component;

class UsedCarsByMileage extends Component
{
    use ColorPalette, MetricsByAge, AnalyticsFiltering;

    /**
     * @var array
     */
    public $age;

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

        return view('frontend.livewire.analytics.used-cars-by-mileage');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        $whereQuery = $this->filterAgeByPeriod();

        $resultCollection = $this->getByAgeMetrics($whereQuery);

        $this->age = $resultCollection->keys()->toArray();

        $colorArray = $this->getColorArray(1, true);

        $this->color = $colorArray[0];

        $this->values = $resultCollection->pluck('km')->toArray();

        $this->rand = rand(11111, 99999999);
    }
}
