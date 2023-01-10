<?php

namespace App\Imports\Json;

use App\Imports\Processing\StockVehicleProcessing;
use App\StockVehicle;

class StockVehicleImport extends StockVehicleProcessing
{
    /**
     * Import resource
     *
     * @param array $row
     * @return bool
     * @throws \App\Exceptions\ImportColumnMissingException
     */
    public function import(array $row)
    {
        $params = $this->process($row);

        StockVehicle::create($params);

        return true;
    }
}
