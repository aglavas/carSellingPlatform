<?php

namespace App\Http\Controllers\Livewire\Analytics;

use App\AnalyticsHistory;
use Livewire\Component;
use App\Traits\ColorPalette;
use Illuminate\Support\Facades\DB;
use App\Traits\AnalyticsFiltering;

class CarsByTimeLine extends Component
{
    use ColorPalette, AnalyticsFiltering;

    /**
     * @var array
     */
    public $time;

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

        return view('frontend.livewire.analytics.cars-by-time-line');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        list($periodMin, $periodMax) = $this->filterResourceByPeriod(AnalyticsHistory::class);

        if ((!$periodMin) || (!$periodMax)) {
            $resultUsedCarsCollection = collect([]);
            $resultNewCarsCollection = collect([]);
        } else {
            $resultObjectNewCars =
                DB::select("
            SELECT date_trunc('day', dd):: date AS day,
            (SELECT COUNT(*) FROM analytics_history WHERE type = 'new'
            AND date(created_at) <= date_trunc('day', dd)) AS \"count\"
            FROM generate_series 
            ( '$periodMin'::timestamp
            , '$periodMax'::timestamp
            , '1 day'::interval) dd
        ");

            $resultObjectUsedCars =
                DB::select("
            SELECT date_trunc('day', dd):: date AS day,
            (SELECT COUNT(*) FROM analytics_history WHERE type = 'used'
            AND date(created_at) <= date_trunc('day', dd)) AS \"count\"
            FROM generate_series 
            ( '$periodMin'::timestamp
            , '$periodMax'::timestamp
            , '1 day'::interval) dd
        ");

            $resultArrayNewCars = array_map(function ($value) {
                return (array)$value;
            }, $resultObjectNewCars);

            $resultArrayUsedCars = array_map(function ($value) {
                return (array)$value;
            }, $resultObjectUsedCars);

            $resultNewCarsCollection = collect($resultArrayNewCars);
            $resultUsedCarsCollection = collect($resultArrayUsedCars);
        }

        $this->time = $resultUsedCarsCollection->pluck('day')->toArray();

        $colorArray = $this->getColorArray(2);

        $usedCarsDataArray = [
            'data' => [],
            'label' => 'Used Cars',
            'borderColor' => $colorArray[0],
            'fill' => false
        ];

        $newCarsDataArray = [
            'data' => [],
            'label' => 'New Cars',
            'borderColor' => $colorArray[1],
            'fill' => false,
        ];

        foreach ($resultUsedCarsCollection as $usedCar) {
            array_push($usedCarsDataArray['data'], $usedCar['count']);
        }

        foreach ($resultNewCarsCollection as $newCar) {
            array_push($newCarsDataArray['data'], $newCar['count']);
        }


        $this->values = [
            $usedCarsDataArray,
            $newCarsDataArray
        ];

        $this->rand = rand(11111, 99999999);
    }
}
