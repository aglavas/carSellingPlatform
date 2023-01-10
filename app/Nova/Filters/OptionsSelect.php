<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Nova\Filters\Filter;

class OptionsSelect extends Filter
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
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        if ($this->meta()['range'] === true) {
            if (in_array($this->column, (new $this->model)->getDates())) {
                return $query->whereBetween($this->column,
                    [Carbon::createFromDate($value['min'], 1, 1)->startOfDay(), Carbon::createFromDate($value['max'], 12, 31)->endOfDay()]);
            } else {
                return $query->whereBetween($this->column, Arr::flatten($value));
            }
        }

        $test = $this->column;

        $test1 = Arr::wrap($value);

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
        if (Arr::get($this->meta(), 'range') === true) {
            return [
                'min' => intval(floor($this->model::min($this->column))),
                'max' => intval(ceil($this->model::max($this->column)))
            ];
        }
        return select_options_for($this->model, $this->column);
    }

    public function key()
    {
        $modelAsSnakeCase = Str::snake(preg_replace('/[^A-Za-z\d ]/', '', $this->model));
        return 'select_options__' . $this->column . '__' . $modelAsSnakeCase;
    }
}
