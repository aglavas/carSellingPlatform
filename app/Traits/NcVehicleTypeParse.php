<?php

namespace App\Traits;

trait NcVehicleTypeParse {

    /**
     * Parse NC vehicle types
     *
     * @param \Illuminate\Support\Collection $collection
     * @return array
     */
    public function parse(\Illuminate\Support\Collection $collection)
    {
        $lcvArray = [];
        $passengerArray = [];
        $truckArray = [];

        foreach ($collection as $key => $subCollection) {
            if ($key == 0) {
                continue;
            }

            if ($subCollection[2] == 'Passenger') {
                array_push($passengerArray, $subCollection[1]);
            } elseif ($subCollection[2] == 'LCV') {
                array_push($lcvArray, $subCollection[1]);
            } elseif ($subCollection[2] == 'Truck') {
                array_push($truckArray, $subCollection[1]);
            }
        }

        return [$lcvArray, $passengerArray, $truckArray];
    }
}
