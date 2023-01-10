<?php

namespace App;

use App\Scopes\NewScope;

class StockVehicleNew extends StockVehicle
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new NewScope());
    }
}
