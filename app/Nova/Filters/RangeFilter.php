<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Oleksiypetlyuk\NovaRangeFilter\NovaRangeFilter;

class RangeFilter extends NovaRangeFilter
{
    private $column;

    public function __construct($column, $model)
    {
        $this->column = $column;
        $this->name = $column;
        $this->min = floor($model::min($column));
        $this->max = ceil($model::max($column));

        parent::__construct();
    }

    /**
     * Apply the filter to the given query.
     *
     * @param Request $request
     * @param Builder $query
     * @param mixed $value
     * @return Builder
     */
    public function apply(Request $request, $query, $value)
    {
        if (in_array($this->column, $query->getModel()->getDates())) {
            $value[0] = $value[0] . '-01-01';
            $value[1] = $value[1] . '-12-31';
        }
        return $query
            ->where(function ($query) use ($value) {
                $query
                    ->whereBetween($this->column, $value)
                    ->orWhereNull($this->column);
            });

    }

    public function key()
    {
        return 'slider_filter_' . $this->column;
    }
}