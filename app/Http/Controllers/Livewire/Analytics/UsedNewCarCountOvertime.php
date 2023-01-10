<?php

namespace App\Http\Controllers\Livewire\Analytics;

use App\AnalyticsHistory;
use Carbon\Carbon;
use Livewire\Component;
use App\Traits\ColorPalette;
use App\Traits\AnalyticsFiltering;

class UsedNewCarCountOvertime extends Component
{
    use ColorPalette, AnalyticsFiltering;

    /**
     * @var array
     */
    public $time = [];

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

        return view('frontend.livewire.analytics.used-new-car-count-overtime');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        $query = AnalyticsHistory::query();

        $query = $this->filterByPeriod($query);

        $carsOverTimeCollection = $query->orderBy('created_at')->get();

        $colorArray = $this->getColorArray(2, true);

        $usedCarsDataArray = [
            'data' => [],
            'label' => 'Used Cars',
            'backgroundColor' => $colorArray[0],
            'borderColor' => $colorArray[0],
            'fill' => false
        ];

        $newCarsDataArray = [
            'data' => [],
            'label' => 'New Cars',
            'backgroundColor' => $colorArray[1],
            'borderColor' => $colorArray[1],
            'fill' => false,
        ];

        $usedCarsCountArray = [];
        $newCarsCountArray = [];

        foreach ($carsOverTimeCollection as $item) {
            $date = Carbon::parse($item->created_at)->format('Y-m-d');

            $stats = $item->stats;

            array_push($this->time, $date);
            array_push($usedCarsCountArray, $stats['CountOfUsedCars']);
            array_push($newCarsCountArray, $stats['CountOfNewCars']);
        }

        $usedCarsDataArray['data'] = $usedCarsCountArray;
        $newCarsDataArray['data'] = $newCarsCountArray;

        $this->values = [
            $usedCarsDataArray,
            $newCarsDataArray
        ];

        $this->rand = rand(11111, 99999999);
    }
}
