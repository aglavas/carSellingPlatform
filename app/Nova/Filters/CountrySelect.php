<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Nova\Filters\Filter;

class CountrySelect extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'dependency-filter';

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
     * @param Request $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function apply(Request $request, $query, $value)
    {
        $formattedValue = convert_country_to_iso3166($value);

        return $query->whereIn($this->column, Arr::wrap($formattedValue));
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

    /**
     * Field key
     *
     * @return string
     */
    public function key()
    {
        $modelAsSnakeCase = Str::snake(preg_replace('/[^A-Za-z\d ]/', '', $this->model));
        return 'select_options__' . $this->column . '__' . $modelAsSnakeCase;
    }
}
