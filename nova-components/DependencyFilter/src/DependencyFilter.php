<?php

namespace Efdi\DependencyFilter;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class DependencyFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'dependency-filter';

    public $multiple = false;

    public $width = "w-1/4";

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
        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return [];
    }
}
