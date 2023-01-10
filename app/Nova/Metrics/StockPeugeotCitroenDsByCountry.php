<?php

namespace App\Nova\Metrics;

use App\StockPeugeotCitroenDs;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class StockPeugeotCitroenDsByCountry extends Partition
{
    public $width = "1/3";
    public $name = "Stock PCD by Country";

    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, StockPeugeotCitroenDs::class, 'country')->label(function ($value) {
            return convert_iso3166_to_country($value);
        });
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
        return 'stock-peugeot-citroen-ds-by-country';
    }
}
