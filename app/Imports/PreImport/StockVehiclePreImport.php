<?php

namespace App\Imports\PreImport;

use App\StockVehicle;
use Maatwebsite\Excel\Concerns\FromCollection;

class StockVehiclePreImport implements FromCollection
{
    /**
     * Return parsed collection
     *
     * @return StockVehicle[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function collection()
    {
        return StockVehicle::all();
    }
}
