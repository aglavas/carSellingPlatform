<?php

namespace Efdi\UsedCarsFiltering;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FilteringService
{
    /**
     * @var array
     */
    private $fields = [
        'range' => [],
        'string' => []
    ];

    /**
     * @var Collection
     */
    private $fieldsCollectionHelper;

    /**
     * FilteringService constructor.
     */
    public function __construct()
    {
        $this->fieldsCollectionHelper = collect();
    }

    /**
     * Get filtered options
     *
     * @param Request $request
     * @return array
     */
    public function getFilteredOptions(Request $request)
    {
        $filterCollection = $this->parseFilter($request);

        try {
            $modelName = $request->input('model');

            /** @var Model $model */
            $model = new $modelName();
        } catch (\Exception $exception) {

        }

        $query = $model->newQuery();

        foreach ($filterCollection as &$filter) {
            $column = (string) Str::of($filter->class)->match('/__(.*)__/');

            if ($column === 'country') {
                $filter->value = convert_country_to_iso3166($filter->value);
            }

            if (!is_array($filter->value) && property_exists($filter->value, 'min') && property_exists($filter->value, 'max')) {
                if(in_array($column, $model->getDates())) {
                    $query->whereBetween($column, [
                        \Illuminate\Support\Carbon::createFromDate($filter->value->min, 1, 1)->startOfDay(),
                        \Illuminate\Support\Carbon::createFromDate($filter->value->max, 12, 31)->endOfDay()]);
                } else {
                    $query->whereBetween($column, [$filter->value->min, $filter->value->max]);
                }
            } else {
                $query->whereIn($column, \Illuminate\Support\Arr::wrap($filter->value));
            }
        }


        foreach ($this->fields['string'] as $field) {
            $fieldCast = $field . '::text';
            $query->selectRaw("string_agg(DISTINCT " . $fieldCast . ", '|') AS " . $field);
        }

        foreach ($this->fields['range'] as $field) {
            $query->selectRaw('MIN(' . $field . ') AS ' . $field . '_x_min');
            $query->selectRaw('MAX(' . $field . ') AS ' . $field . '_x_max');
        }

        $result = $query->get()->first()->toArray();

        $collectionMapping = $this->fieldsCollectionHelper->keyBy('column');

        $output = [];

        foreach ($result as $key => $value) {
            if (strpos($key, '_x_min') || strpos($key, '_x_max')) {
                $minExploded = explode('_x_min', $key);

                if (count($minExploded) > 1) {
                    $rangeColumnType = $collectionMapping[$minExploded[0]]['type'];

                    if ($rangeColumnType === 'date-range') {
                        $output[$minExploded[0]]['min'] =  Carbon::createFromDate(intval($value), 12, 31)->endOfDay()->format('Y');
                    } else {
                        $output[$minExploded[0]]['min'] = intval($value);
                    }
                }

                $maxExploded = explode('_x_max', $key);

                if (count($maxExploded) > 1) {
                    $rangeColumnType = $collectionMapping[$maxExploded[0]]['type'];

                    if ($rangeColumnType === 'date-range') {
                        $output[$maxExploded[0]]['max'] = Carbon::createFromDate(intval($value), 12, 31)->endOfDay()->format('Y');
                    } else {
                        $output[$maxExploded[0]]['max'] = intval($value);
                    }
                }
            } elseif ($key === 'country' && $value != null) {
                $countryExploded = explode('|', $value);

                foreach ($countryExploded as &$country) {
                    $country = convert_iso3166_to_country($country);
                }

                $countryFormatted = implode('|', $countryExploded);

                $output[$key] = $countryFormatted;
            } else {
                $output[$key] = $value;
            }
        }

        return $output;
    }

    /**
     * Parse filter from request
     *
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    private function parseFilter(Request $request)
    {
        $filterCollection = collect(json_decode(base64_decode($request->input('filter'))));

        $filterCollection = $filterCollection->filter(function($item) {
            $column = (string) Str::of($item->class)->match('/__(.*)__/');

            if ($column === 'notification_update') {
                return false;
            }

            if ($item->type === 'string') {
                if ($column != 'brand') {
                    array_push($this->fields['string'], $column);
                }
            } else {
                array_push($this->fields['range'], $column);

                $this->fieldsCollectionHelper->push([
                    'column' => $column,
                    'type' => $item->type,
                ]);
            }

            return !empty($item->value);
        });

        return $filterCollection;
    }
}
