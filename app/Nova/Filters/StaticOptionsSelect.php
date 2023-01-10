<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Nova\Filters\Filter;

class StaticOptionsSelect extends Filter
{
    protected $column;

    public function __construct($column, $model)
    {
        $this->column = $column;
        $this->model = $model;
        $this->name = $column;
    }

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
        return $query->whereIn($this->column, Arr::wrap($value));
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return select_options_for($this->model, $this->column);
    }

    public function key()
    {
        $modelAsSnakeCase = Str::snake(preg_replace('/[^A-Za-z\d ]/', '', $this->model));
        return 'select_options__' . $this->column . '__' . $modelAsSnakeCase;
    }
}
