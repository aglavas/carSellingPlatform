<?php

namespace App\Http\Controllers\Livewire\Analytics;

use Livewire\Component;
use App\Traits\ColorPalette;
use App\Traits\AnalyticsFiltering;
use App\AnalyticsHistory;
use Carbon\Carbon;

class AveragePriceUsedCarsOverTime extends Component
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
     * @var array
     */
    public $agePeriods = [
        "0-1",
        "1-2",
        "2-3",
        "3-4",
        "4-5",
        "5-6",
        "6-7",
        "7-8",
        "8-9",
        "9-10",
        ">=10",
    ];

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->setValues();

        return view('frontend.livewire.analytics.average-price-used-cars-over-time');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        $query = AnalyticsHistory::query();

        $query = $this->filterByPeriod($query);

        $carsOverTimeCollection = $query->orderBy('created_at')->get();
//        $carsOverTimeCollection = AnalyticsHistory::get();

        $dataArray = [];

        foreach ($carsOverTimeCollection as $data) {
            $date = Carbon::parse($data->created_at)->format('Y-m-d');

            $stats = $data->stats;

            $usedCarsAvgPricePerAgeArray = $stats['AvgPriceOfUsedCarsPerAge'];

            foreach ($usedCarsAvgPricePerAgeArray as $item) {
                $age = $item['age'];

                if ($age < 1) {
                    $ageRangeArray["0-1"] = [
                        'price' => $item['avgprice'],
                    ];
                } elseif ((1 >= $age) && ($age < 2)) {
                    $ageRangeArray["1-2"] = [
                        'price' => $item['avgprice'],
                    ];
                } elseif ((2 >= $age) && ($age < 3)) {
                    $ageRangeArray["2-3"] = [
                        'price' => $item['avgprice'],
                    ];
                } elseif ((3 >= $age) && ($age < 4)) {
                    $ageRangeArray["3-4"] = [
                        'price' => $item['avgprice'],
                    ];
                } elseif ((4 >= $age) && ($age < 5)) {
                    $ageRangeArray["4-5"] = [
                        'price' => $item['avgprice'],
                    ];
                } elseif ((5 >= $age) && ($age < 6)) {
                    $ageRangeArray["5-6"] = [
                        'price' => $item['avgprice'],
                    ];
                } elseif ((6 >= $age) && ($age < 7)) {
                    $ageRangeArray["6-7"] = [
                        'price' => $item['avgprice'],
                    ];
                } elseif ((7 >= $age) && ($age < 8)) {
                    $ageRangeArray["7-8"] = [
                        'price' => $item['avgprice'],
                    ];
                } elseif ((8 >= $age) && ($age < 9)) {
                    $ageRangeArray["8-9"] = [
                        'price' => $item['avgprice'],
                    ];
                }  elseif ((9 >= $age) && ($age < 10)) {
                    $ageRangeArray["9-10"] = [
                        'price' => $item['avgprice'],
                    ];
                } else {
                    $ageRangeArray[">=10"] = [
                        'price' => $item['avgprice'],
                    ];
                }
            }

            foreach ($this->agePeriods as $period) {
                if (!isset($ageRangeArray[$period])) {
                    $ageRangeArray[$period]['price'] = 0;
                }

                if (!isset($dataArray[$period])) {
                    $dataArray[$period] = [];
                }
            }

            foreach ($ageRangeArray as $period => $data) {
                array_push($dataArray[$period], $data['price']);
            }

            array_push($this->time, $date);
        }

        $count = count($this->agePeriods);

        $colorArray = $this->getColorArray($count);

        $resultArray = [];

        if (count($dataArray)) {
            foreach ($this->agePeriods as $key => $period) {
                $array = [
                    'data' => $dataArray[$period],
                    'label' => $period,
                    'borderColor' => $colorArray[$key],
//                    'fill' => '-1',
                    'backgroundColor' => $colorArray[$key]
                    //'backgroundColor' => $this->adjustBrightness($colorArray[$key], 0.1)
                ];

                array_push($resultArray, $array);
            }
        }

        $this->values = $resultArray;

        $this->rand = rand(11111, 99999999);
    }
}
