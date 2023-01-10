<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait MetricsByAge
{
    /**
     * Get by age metrics
     *
     * @return array
     */
    public function getByAgeMetrics($whereQuery)
    {

//        $resultObject = DB::query()->fromSub(function ($query) use ($subQuery) {
//            $query->selectSub($subQuery, 'a');
//        }, 'a')
//            ->selectRaw('age , COUNT(age) as NoCars , AVG(km) as avgkm , AVG(price_in_euro) as avgprice, PERCENTILE_DISC(0.5) WITHIN GROUP(ORDER BY km) AS medianKm')
//            ->groupBy('age')
//            ->orderBy('age')
//            ->get()->toArray();


//        if ($whereQuery) {
//            $resultObject = DB::query()->fromSub(function ($query) use ($whereQuery) {
//                $query->selectRaw('date_part(\'year\', age(firstregistration)) as age,
//             km ,
//             price_in_euro')->from('stock_retail_central_europe');
//            }, 'a')
//                ->selectRaw('age , COUNT(age) as NoCars , AVG(km) as avgkm , AVG(price_in_euro) as avgprice, PERCENTILE_DISC(0.5) WITHIN GROUP(ORDER BY km) AS medianKm')
//                ->groupBy('age')
//                ->orderBy('age')
//                ->get()->toArray();
//
//        } else {
//            $resultObject = DB::query()->fromSub(function ($query) {
//                $query->selectRaw('date_part(\'year\', age(firstregistration)) as age,
//             km ,
//             price_in_euro')->from('stock_retail_central_europe');
//            }, 'a')
//                ->selectRaw('age , COUNT(age) as NoCars , AVG(km) as avgkm , AVG(price_in_euro) as avgprice, PERCENTILE_DISC(0.5) WITHIN GROUP(ORDER BY km) AS medianKm')
//                ->groupBy('age')
//                ->orderBy('age')
//                ->get()->toArray();
//
//        }

        if ($whereQuery) {
            $resultObject = DB::select("
          SELECT  age , COUNT(age) as NoCars , AVG(km) as avgkm , AVG(price_in_euro) as avgprice, PERCENTILE_DISC(0.5) WITHIN GROUP(ORDER BY km) AS medianKm FROM (
          SELECT  date_part('year', age(firstregistration)) as age,
             km ,
             price_in_euro
          FROM stock_vehicles
          {$whereQuery} AND condition_type = 'used'
          ) temp_table
          GROUP BY age
          ORDER BY age
          ");

        } else {
            $resultObject = DB::select("
          SELECT  age , COUNT(age) as NoCars , AVG(km) as avgkm , AVG(price_in_euro) as avgprice, PERCENTILE_DISC(0.5) WITHIN GROUP(ORDER BY km) AS medianKm FROM (
          SELECT  date_part('year', age(firstregistration)) as age,
             km ,
             price_in_euro
          FROM stock_vehicles WHERE condition_type = 'used'
          ) temp_table
          GROUP BY age
          ORDER BY age
          ");

        }


        $ageRangeArray = [
            "0-1" => null,
            "1-2" => null,
            "2-3" => null,
            "3-4" => null,
            "4-5" => null,
            "5-6" => null,
            "6-7" => null,
            "7-8" => null,
            "8-9" => null,
            "9-10" => null,
            ">=10" => null,
        ];

        $resultArray = array_map(function ($value) {
            return (array)$value;
        }, $resultObject);

        foreach ($resultArray as $item) {
            $age = $item['age'];

            if ($age < 1) {
                $ageRangeArray["0-1"] = [
                    'count' => $item['nocars'],
                    'km' => $item['avgkm'],
                    'median' => $item['mediankm'],
                    'price' => $item['avgprice'],
                ];
            } elseif ((1 >= $age) && ($age < 2)) {
                $ageRangeArray["1-2"] = [
                    'count' => $item['nocars'],
                    'km' => $item['avgkm'],
                    'median' => $item['mediankm'],
                    'price' => $item['avgprice'],
                ];
            } elseif ((2 >= $age) && ($age < 3)) {
                $ageRangeArray["2-3"] = [
                    'count' => $item['nocars'],
                    'km' => $item['avgkm'],
                    'median' => $item['mediankm'],
                    'price' => $item['avgprice'],
                ];
            } elseif ((3 >= $age) && ($age < 4)) {
                $ageRangeArray["3-4"] = [
                    'count' => $item['nocars'],
                    'km' => $item['avgkm'],
                    'median' => $item['mediankm'],
                    'price' => $item['avgprice'],
                ];
            } elseif ((4 >= $age) && ($age < 5)) {
                $ageRangeArray["4-5"] = [
                    'count' => $item['nocars'],
                    'km' => $item['avgkm'],
                    'median' => $item['mediankm'],
                    'price' => $item['avgprice'],
                ];
            } elseif ((5 >= $age) && ($age < 6)) {
                $ageRangeArray["5-6"] = [
                    'count' => $item['nocars'],
                    'km' => $item['avgkm'],
                    'median' => $item['mediankm'],
                    'price' => $item['avgprice'],
                ];
            } elseif ((6 >= $age) && ($age < 7)) {
                $ageRangeArray["6-7"] = [
                    'count' => $item['nocars'],
                    'km' => $item['avgkm'],
                    'median' => $item['mediankm'],
                    'price' => $item['avgprice'],
                ];
            } elseif ((7 >= $age) && ($age < 8)) {
                $ageRangeArray["7-8"] = [
                    'count' => $item['nocars'],
                    'km' => $item['avgkm'],
                    'median' => $item['mediankm'],
                    'price' => $item['avgprice'],
                ];
            } elseif ((8 >= $age) && ($age < 9)) {
                $ageRangeArray["8-9"] = [
                    'count' => $item['nocars'],
                    'km' => $item['avgkm'],
                    'median' => $item['mediankm'],
                    'price' => $item['avgprice'],
                ];
            }  elseif ((9 >= $age) && ($age < 10)) {
                $ageRangeArray["9-10"] = [
                    'count' => $item['nocars'],
                    'km' => $item['avgkm'],
                    'median' => $item['mediankm'],
                    'price' => $item['avgprice'],
                ];
            } else {
                $ageRangeArray[">=10"] = [
                    'count' => $item['nocars'],
                    'km' => $item['avgkm'],
                    'median' => $item['mediankm'],
                    'price' => $item['avgprice'],
                ];
            }
        }

        return collect($ageRangeArray);
    }
}
