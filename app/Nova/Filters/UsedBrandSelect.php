<?php

namespace App\Nova\Filters;

use App\StockUsedCentralEurope;
use Efdi\LocalMultiselectFilter\LocalMultiselectFilter;
use Illuminate\Http\Request;

class UsedBrandSelect extends LocalMultiselectFilter
{

    /**
     * Apply the filter to the given query.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->whereIn('brand', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return
            StockUsedCentralEurope::select('brand')
                ->distinct()
                ->orderBy('brand', 'asc')
                ->get()
                ->pluck('brand', 'brand')->toArray();
    }

    public function key()
    {
        return 'used_brands_filter';
    }
}
