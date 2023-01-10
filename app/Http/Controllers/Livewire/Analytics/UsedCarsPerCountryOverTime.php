<?php

namespace App\Http\Controllers\Livewire\Analytics;

use Livewire\Component;
use App\Traits\ColorPalette;
use App\Traits\AnalyticsFiltering;
use Carbon\Carbon;
use App\AnalyticsHistory;

class UsedCarsPerCountryOverTime extends Component
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

        return view('frontend.livewire.analytics.used-cars-per-country-over-time');
    }

    /**
     * Set values
     */
    protected function setValues()
    {
        $query = AnalyticsHistory::query();

        $query = $this->filterByPeriod($query);

        $carsOverTimeCollection = $query->orderBy('created_at')->get();

        $dataArray = [];
        $countryArray = [];

        foreach ($carsOverTimeCollection as $item) {
            $date = Carbon::parse($item->created_at)->format('Y-m-d');

            $stats = $item->stats;

            $usedCarsPerCountryArray = $stats['CountOfUsedCarsPerCountry'];

            if (count($usedCarsPerCountryArray) == 0) {
                foreach ($dataArray as $country => $data) {
                    array_push($dataArray[$country], 0);
                }

                array_push($this->time, $date);
                continue;
            }

            $countries = array_keys($usedCarsPerCountryArray);

            foreach ($countries as $country) {
                if (!isset($dataArray[$country])) {
                    $dataArray[$country] = [];
                }
            }

            $countryArray = array_unique(array_merge($countryArray, $countries));

            foreach ($usedCarsPerCountryArray as $country => $data) {
                $iterations = 0;
                if (count($this->time) == count($dataArray[$country])) {
                    array_push($dataArray[$country], $data['total']);
                } else {
                    $count = count($this->time);

                    do {
                        array_push($dataArray[$country], 0);
                        $iterations++;
                    } while ($iterations != $count);
                    array_push($dataArray[$country], $data['total']);
                }
            }

            $dataArray = $this->populateIfMissing($dataArray);

            array_push($this->time, $date);
        }

        $countryArray = array_values($countryArray);

        $colorArray = $this->getCountryColorArray($countryArray);

        $resultArray = [];

        foreach ($countryArray as $key => $country) {
            $array = [
                'data' => $dataArray[$country],
                'label' => strtoupper($country),
                'borderColor' => $colorArray[$country],
                //'fill' => 'origin',
                'backgroundColor' => $colorArray[$country]
                //'backgroundColor' => $this->adjustBrightness($colorArray[$key], 0.3)
            ];

            array_push($resultArray, $array);
        }

        $this->values = $resultArray;

        $this->rand = rand(11111, 99999999);
    }

    /**
     * Populate if missing
     *
     * @param array $dataArray
     * @return array
     */
    private function populateIfMissing(array $dataArray)
    {
        $biggestArrayCount = 0;

        foreach ($dataArray as $country => $data) {
            if (count($data) > $biggestArrayCount) {
                $biggestArrayCount = count($data);
            }
        }

        foreach ($dataArray as $country => $data) {
            if (count($data) < $biggestArrayCount) {
                do {
                    array_push($dataArray[$country], 0);
                } while (count($dataArray[$country]) < $biggestArrayCount);
            }
        }

        return $dataArray;
    }
}
