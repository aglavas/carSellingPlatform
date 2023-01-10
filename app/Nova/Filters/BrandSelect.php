<?php

namespace App\Nova\Filters;

use App\Brand;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Illuminate\Support\Str;

class BrandSelect extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    public function __construct($column, $model)
    {
        $this->column = $column;
        $this->model = $model;
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
        return $query->where('brand_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return Brand::whereIn('id',
            $this->model::select('brand_id')->distinct()->get()->pluck('brand_id'))->get()->pluck('id', 'name');
    }

    /**
     * Column key
     *
     * @return string
     */
    public function key()
    {
        $modelAsSnakeCase = Str::snake(preg_replace('/[^A-Za-z\d ]/', '', $this->model));
        return 'select_options__' . $this->column . '__' . $modelAsSnakeCase;
    }
}
