<?php

namespace App\Http\Controllers\Livewire\Analytics;

use App\Traits\AnalyticsFiltering;
use Livewire\Component;
use App\Traits\ColorPalette;
use App\Traits\MetricsByAge;

class UsedCarsByPrice extends Component
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

        return view('frontend.livewire.analytics.used-cars-by-price');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        $whereQuery = $this->filterAgeByPeriod();

        $resultCollection = $this->getByAgeMetrics($whereQuery);

        $this->age = $resultCollection->keys()->toArray();

        $this->color = $this->getColorArray(count($this->age));

        $this->values = $resultCollection->pluck('price')->toArray();

        $this->rand = rand(11111, 99999999);
    }
}
