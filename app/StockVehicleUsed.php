<?php

namespace App;

use App\Scopes\UsedScope;

class StockVehicleUsed extends StockVehicle
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new UsedScope());
    }
}
