<?php

namespace App\Nova\Filters;

use App\StockUsedCentralEurope;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Filters\Filter;

class NotificationUpdateFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'dependency-filter';

    /**
     * @var
     */
    protected $column;

    /**
     * NotificationUpdateFilter constructor.
     * @param $column
     * @param $model
     */
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
        if ($this->model === StockUsedCentralEurope::class) {
            $valueCollection = collect($value);

            $vinArray = $valueCollection->pluck('vin')->toArray();
//
//            $company = $value[0]['company'];
//
//            $country = strtolower($value[0]['country']);

            return $query->whereIn('id', function($subQuery) use ($vinArray){
                $subQuery->selectRaw('MAX(id)')->from('stock_retail_central_europe')->whereIn('vin', $vinArray)->groupBy('vin');
            });
        } else {
            return $query->whereIn('vin', $value);
        }
    }

    /**
     * Filter key
     *
     * @return string
     */
    public function key()
    {
        $modelAsSnakeCase = Str::snake(preg_replace('/[^A-Za-z\d ]/', '', $this->model));
        return 'select_options__notification_update__' . $modelAsSnakeCase;
    }

    /**
     * Filter options. Must exists
     *
     * @param Request $request
     * @return array|void
     */
    public function options(Request $request)
    {
        // TODO: Implement options() method.
    }
}
