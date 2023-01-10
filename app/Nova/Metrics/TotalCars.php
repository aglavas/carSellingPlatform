<?php

namespace App\Nova\Metrics;

use App\StockFCA;
use App\StockMercedes;
use App\StockOpel;
use App\StockPeugeotCitroenDs;
use App\StockSwitzerland;
use App\StockUsedCentralEurope;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class TotalCars extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return [
            'value' => [
                StockUsedCentralEurope::count() + StockOpel::count() + StockMercedes::count() + StockPeugeotCitroenDs::count() + StockSwitzerland::count() + StockFCA::count()
            ],
            'format' => "0,0"
        ];
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [

        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'total-cars';
    }
}
