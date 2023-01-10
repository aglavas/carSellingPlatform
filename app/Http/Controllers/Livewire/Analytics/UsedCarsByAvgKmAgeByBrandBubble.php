<?php

namespace App\Http\Controllers\Livewire\Analytics;

use App\StockUsedCentralEurope;
use App\Traits\AnalyticsFiltering;
use App\Traits\ColorPalette;
use Carbon\Carbon;
use Livewire\Component;

class UsedCarsByAvgKmAgeByBrandBubble extends Component
{
    use ColorPalette, AnalyticsFiltering;

    /**
     * @var array
     */
    public $values;

    /**
     * @var integer
     */
    public $rand;

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->setValues();

        return view('frontend.livewire.analytics.used-cars-by-avg-km-age-by-brand-bubble');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        $valueArray = [];

        $query = StockUsedCentralEurope::selectRaw('AVG(km) as km, to_timestamp(avg(extract(epoch from firstregistration)))::date AS age, brand, COUNT(*) as R');

        $query = $this->filterByPeriod($query);

        $collection = $query->groupByRaw('brand')->get();

        //$collection = StockUsedCentralEurope::selectRaw('AVG(km) as km, to_timestamp(avg(extract(epoch from firstregistration)))::date AS age, brand, COUNT(*) as R')->groupByRaw('brand')->get();

        $count = $collection->count();

        $colorArray = $this->getColorArray($count);

        foreach ($collection as $key => $item) {
            if ($count > 14) {
                $colorKey = rand(0, 11);
            } else {
                $colorKey = $key;
            }

            $carbon = Carbon::createFromFormat('Y-m-d', $item['age']);

            array_push($valueArray, [
                'label' => $item['brand'],
                'backgroundColor' => $colorArray[$colorKey],
                'borderColor' => $colorArray[$colorKey],
                'data' => [
                    [
                        'x' => round($carbon->diffInDays()/365, 2),
                        'y' => $item['km'],
                        'r' => $item['r'],
                    ]
                ]
            ]);
        }

        $this->values = $valueArray;

        $this->rand = rand(11111, 99999999);
    }
}
