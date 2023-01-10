<?php

namespace App\Traits;

use App\CartItem;
use App\StockFCA;
use App\StockMercedes;
use App\StockOpel;
use App\StockPeugeotCitroenDs;
use App\StockUsedCentralEurope;
use App\StockVehicle;
use App\Transaction;
use App\UnifiedView;
use Carbon\Carbon;

trait WithFilterableOptions
{
    /**
     * Apply filters
     *
     * @param $model
     * @param $filters
     * @param string $excludedColumn
     * @param null $columnAs
     * @return mixed
     */
    public function applyFilters($model, $filters, $excludedColumn = '', $columnAs = null)
    {
        if (is_array($filters)) {
            foreach ($filters as $key => $filter) {
                if ($key === 'transaction_status' && $filter['values']) {
                    if ($filter['values'] === Transaction::TRANSACTION_STATUS_IN_PROGRESS) {
                        $vehicleIdentArray = Transaction::where('vehicle_type', StockVehicle::class)->where(
                            'status',
                            Transaction::TRANSACTION_STATUS_IN_PROGRESS
                        )->pluck('vehicle_ident')->toArray();

                        $model->whereIn('manufacturer_id', $vehicleIdentArray);
                    } else if ($filter['values'] === 'in_cart') {
                        $vehicleIdentArray = CartItem::where('vehicle_type', StockVehicle::class)->pluck('vehicle_ident')->toArray();

                        $model->whereIn('manufacturer_id', $vehicleIdentArray);
                    }

                    continue;
                }

                if ($filter['values'] && $filter['column'] != $excludedColumn) {
                    switch ($filter['type']) {
//                        case 'range':
//                            $model->whereBetween($filter['column'], $filter['values']);
//                            break;
                        case 'max':
                            $model->where($filter['column'], '<=', $filter['values']);
                            break;
                        default:
                            if ($filter['column'] === 'firstregistration') {
                                $values = $filter['values'];
                                $model->where(function ($query) use ($values){
                                    foreach ($values as $regKey => $value) {
                                        $date = Carbon::create($value, 1, 1, 0, 0, 0);
                                        $startOfYear = $date->copy()->startOfYear();
                                        $endOfYear   = $date->copy()->endOfYear();

                                        $query->orWhere(function ($query) use ($startOfYear, $endOfYear) {
                                            $query->whereBetween('firstregistration', [$startOfYear, $endOfYear]);
                                        });
                                    }
                                });
                            } else {
                                $model->whereIn($filter['column'], $filter['values']);
                            }

                            break;
                    }
                }
            }
        }
        return $model;
    }
}
