<?php

namespace App\Traits;

use App\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait AnalyticsFiltering
{
    /**
     * @var string
     */
    public $period;

    /**
     * Filter records by period
     *
     * @param $query
     * @return mixed
     */
    public function filterByPeriod($query)
    {
        if ($this->period === 'this-year') {
            $year = date('Y');

            $query->whereYear('created_at', $year);
        } elseif ($this->period === 'last-year') {
            $year = date('Y') - 1;

            $query->whereYear('created_at', $year);
        } elseif ($this->period === 'this-month') {
            $month = date('m');
            $year = date('Y');

            $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
        } elseif ($this->period === 'last-month') {
            $month = date('m') - 1;
            $year = date('Y');

            $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
        } elseif ($this->period === 'this-week') {
            $weekStart = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
            $weekEnd = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s');

            $query->whereBetween('created_at', [$weekStart, $weekEnd]);
        } elseif ($this->period === 'last-week') {
            $carbon = Carbon::now()->subWeek();
            $weekStart = $carbon->startOfWeek()->format('Y-m-d H:i:s');
            $weekEnd = $carbon->endOfWeek()->format('Y-m-d H:i:s');

            $query->whereBetween('created_at', [$weekStart, $weekEnd]);
        }

        return $query;
    }

    /**
     * Filter resource by period
     *
     * @param string $resource
     * @return array
     */
    public function filterResourceByPeriod(string $resource)
    {
        $resource = new $resource;

        if ($this->period === 'this-year') {
            $year = date('Y');

            $maxTimestamp = $resource->whereYear('created_at', $year)->max('created_at');
            $minTimestamp = $resource->whereYear('created_at', $year)->min('created_at');
        } elseif ($this->period === 'last-year') {
            $year = date('Y') - 1;

            $maxTimestamp = $resource->whereYear('created_at', $year)->max('created_at');
            $minTimestamp = $resource->whereYear('created_at', $year)->min('created_at');
        } elseif ($this->period === 'this-month') {
            $month = date('m');
            $year = date('Y');

            $maxTimestamp = $resource->whereYear('created_at', $year)->whereMonth('created_at', $month)->max('created_at');
            $minTimestamp = $resource->whereYear('created_at', $year)->whereMonth('created_at', $month)->min('created_at');
        } elseif ($this->period === 'last-month') {
            $month = date('m') - 1;
            $year = date('Y');

            $maxTimestamp = $resource->whereYear('created_at', $year)->whereMonth('created_at', $month)->max('created_at');
            $minTimestamp = $resource->whereYear('created_at', $year)->whereMonth('created_at', $month)->min('created_at');
        } elseif ($this->period === 'this-week') {
            $weekStart = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
            $weekEnd = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s');

            $maxTimestamp = $resource->whereBetween('created_at', [$weekStart, $weekEnd])->max('created_at');
            $minTimestamp = $resource->whereBetween('created_at', [$weekStart, $weekEnd])->min('created_at');
        } elseif ($this->period === 'last-week') {
            $carbon = Carbon::now()->subWeek();
            $weekStart = $carbon->startOfWeek()->format('Y-m-d H:i:s');
            $weekEnd = $carbon->endOfWeek()->format('Y-m-d H:i:s');

            $maxTimestamp = $resource->whereBetween('created_at', [$weekStart, $weekEnd])->max('created_at');
            $minTimestamp = $resource->whereBetween('created_at', [$weekStart, $weekEnd])->min('created_at');
        } else {
            $maxTimestamp = $resource->max('created_at');
            $minTimestamp = $resource->min('created_at');
        }

        if ($minTimestamp) {
            $min = Carbon::parse($minTimestamp)->format('Y-m-d');
        } else {
            $min = null;
        }

        if ($maxTimestamp) {
            $max = Carbon::parse($maxTimestamp)->format('Y-m-d');
        } else {
            $max = null;
        }

        return [$min, $max];
    }

    /**
     * Filter age by period
     *
     * @return string|null
     */
    public function filterAgeByPeriod()
    {
        if ($this->period === 'this-year') {
            $year = date('Y');

            return "where extract(year from created_at) = {$year}";
        } elseif ($this->period === 'last-year') {
            $year = date('Y') - 1;

            return "where extract(year from created_at) = {$year}";
        } elseif ($this->period === 'this-month') {
            $month = date('m');
            $year = date('Y');

            return "where extract(year from created_at) = {$year} and extract(month from created_at) = {$month}";
        } elseif ($this->period === 'last-month') {
            $month = date('m') - 1;
            $year = date('Y');

            return "where extract(year from created_at) = {$year} and extract(month from created_at) = {$month}";
        } elseif ($this->period === 'this-week') {
            $weekStart = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
            $weekEnd = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s');

            return "where 'created_at' between '{$weekStart}' and '{$weekEnd}'";
        } elseif ($this->period === 'last-week') {
            $carbon = Carbon::now()->subWeek();
            $weekStart = $carbon->startOfWeek()->format('Y-m-d H:i:s');
            $weekEnd = $carbon->endOfWeek()->format('Y-m-d H:i:s');

            return "where created_at between '{$weekStart}' and '{$weekEnd}'";
        }

        return null;
    }
}
